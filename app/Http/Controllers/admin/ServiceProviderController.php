<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceProvider;
use App\Models\ServiceProviderRating;
use App\Models\User;
use App\Models\Feedback;
use App\Models\Rating;
use App\Models\ServiceCategory;
use App\Models\ServiceRating;
use App\Notifications\WelcomeEmailNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ServiceProviderController extends Controller
{
    /**
     * Display all service providers.
     */
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Provider Query
        |--------------------------------------------------------------------------
        */
        $query = ServiceProvider::query()
            ->with([
                'user:id,name,email,profile_photo_path,utype',
                'category:id,name',
            ])
            ->withCount([
                'services',
                'staffMembers',
                'ratings',
            ]);

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */
        if ($request->filled('search')) {

            $search = trim($request->input('search'));

            $query->where(function ($q) use ($search) {

                // Search provider location
                $q->where(
                    'service_locations',
                    'like',
                    "%{$search}%"
                )

                    // Search provider name/email
                    ->orWhereHas('user', function ($userQuery) use ($search) {

                        $userQuery
                            ->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })

                    // Search category
                    ->orWhereHas('category', function ($categoryQuery) use ($search) {

                        $categoryQuery->where(
                            'name',
                            'like',
                            "%{$search}%"
                        );
                    });
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */
        if ($request->filled('status')) {

            $status = $request->input('status');

            if (in_array($status, ['pending', 'approved', 'rejected'])) {
                $query->where('status', $status);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Category Filter
        |--------------------------------------------------------------------------
        */
        if ($request->filled('category')) {

            $query->where(
                'service_category_id',
                $request->input('category')
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Sorting
        |--------------------------------------------------------------------------
        */
        switch ($request->input('sort', 'latest')) {

            case 'oldest':
                $query->oldest();
                break;

            case 'name':

                $query
                    ->join(
                        'users',
                        'service_providers.user_id',
                        '=',
                        'users.id'
                    )
                    ->select('service_providers.*')
                    ->orderBy('users.name', 'asc');

                break;

            case 'services':
                $query->orderByDesc('services_count');
                break;

            case 'ratings':
                $query->orderByDesc('ratings_count');
                break;

            default:
                $query->latest();
                break;
        }

        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */
        $totalProviders = ServiceProvider::count();

        $approvedProviders = ServiceProvider::where(
            'status',
            'approved'
        )->count();

        $pendingProviders = ServiceProvider::where(
            'status',
            'pending'
        )->count();

        $rejectedProviders = ServiceProvider::where(
            'status',
            'rejected'
        )->count();

        $totalServices = Service::count();

        /*
        |--------------------------------------------------------------------------
        | Providers
        |--------------------------------------------------------------------------
        */
        $sproviders = $query
            ->paginate(12)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Categories
        |--------------------------------------------------------------------------
        */
        $categories = ServiceCategory::query()
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | View
        |--------------------------------------------------------------------------
        */
        return view(
            'admin.service-provider.index',
            compact(
                'sproviders',
                'categories',
                'totalProviders',
                'approvedProviders',
                'pendingProviders',
                'rejectedProviders',
                'totalServices'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ServiceCategory::query()
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return view(
            'admin.service-provider.create',
            compact('categories')
        );
    }


    /**
     * Store a new service provider.
     */
    public function storeServiceProvide(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],

            'service_category_id' => [
                'nullable',
                'exists:service_categories,id',
            ],

            'service_locations' => [
                'nullable',
                'string',
                'max:255',
            ],

            'about' => [
                'nullable',
                'string',
            ],

            'skills' => [
                'nullable',
                'string',
            ],

            'qualification' => [
                'nullable',
                'string',
            ],

            'experience' => [
                'nullable',
                'string',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ],
        ], [
            'name.required' => 'Please enter the provider name.',
            'email.required' => 'Please enter the provider email.',
            'email.unique' => 'This email address is already registered.',
            'password.min' => 'Password must contain at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
            'service_category_id.exists' => 'The selected category is invalid.',
            'image.image' => 'The uploaded file must be an image.',
            'image.mimes' => 'The image must be JPG, JPEG, or PNG.',
            'image.max' => 'The provider image may not exceed 2MB.',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Create User + Provider
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use ($request, $validated) {

            /*
            |--------------------------------------------------------------------------
            | Upload Provider Image
            |--------------------------------------------------------------------------
            */

            $imageName = null;

            if ($request->hasFile('image')) {

                $image = $request->file('image');

                $imageName =
                    time() . '_' .
                    uniqid() . '.' .
                    $image->getClientOriginalExtension();

                $destination = public_path('image/profile');

                if (!is_dir($destination)) {
                    mkdir($destination, 0755, true);
                }

                $image->move(
                    $destination,
                    $imageName
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Create User
            |--------------------------------------------------------------------------
            */

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make(
                    $validated['password']
                ),
                'utype' => 'SVP',
            ]);


            /*
            |--------------------------------------------------------------------------
            | Create Service Provider
            |--------------------------------------------------------------------------
            */

            ServiceProvider::create([

                'user_id' => $user->id,

                'image' => $imageName,

                'service_category_id' =>
                $validated['service_category_id'] ?? null,

                'service_locations' =>
                $validated['service_locations'] ?? null,

                'about' =>
                $validated['about'] ?? null,

                'skills' =>
                $validated['skills'] ?? null,

                'qualification' =>
                $validated['qualification'] ?? null,

                'experience' =>
                $validated['experience'] ?? null,

                'status' => 'pending',
            ]);
        });


        return redirect()
            ->route('admin.service_providers')
            ->with(
                'message',
                'Service provider created successfully.'
            );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $provider = ServiceProvider::query()
            ->with([
                'user:id,name,email,profile_photo_path,utype,created_at',
                'category:id,name',
                'services',
                'ratings',
                'staffMembers',
                'workingHours',
            ])
            ->withCount([
                'services',
                'ratings',
                'staffMembers',
                'workingHours',
            ])
            ->withAvg('ratings', 'rating')
            ->findOrFail($id);

        return view('admin.service-provider.show', [
            'UserProvide' => $provider,
            'services'   => $provider->services,
            'reviews'    => $provider->ratings,
        ]);
    }

    public function edit($id)
    {
        $provider = ServiceProvider::query()
            ->with([
                'user:id,name,email,profile_photo_path,utype',
                'category:id,name',
            ])
            ->findOrFail($id);

        $categories = ServiceCategory::query()
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return view(
            'admin.service-provider.edit',
            compact(
                'provider',
                'categories'
            )
        );
    }

    /**
     * Update service provider.
     */
    public function update(Request $request, $id)
    {
        $provider = ServiceProvider::query()
            ->with('user')
            ->findOrFail($id);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . $provider->user_id,
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],

            'service_category_id' => [
                'nullable',
                'exists:service_categories,id',
            ],

            'service_locations' => [
                'nullable',
                'string',
                'max:255',
            ],

            'about' => [
                'nullable',
                'string',
            ],

            'skills' => [
                'nullable',
                'string',
            ],

            'qualification' => [
                'nullable',
                'string',
            ],

            'experience' => [
                'nullable',
                'string',
            ],

            'status' => [
                'required',
                'in:pending,approved,rejected',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ],
        ], [
            'name.required' => 'Please enter the provider name.',

            'email.required' => 'Please enter the provider email.',

            'email.unique' =>
            'This email address is already registered.',

            'password.min' =>
            'Password must contain at least 8 characters.',

            'password.confirmed' =>
            'Password confirmation does not match.',

            'service_category_id.exists' =>
            'The selected category is invalid.',

            'status.in' =>
            'The selected provider status is invalid.',

            'image.image' =>
            'The uploaded file must be an image.',

            'image.mimes' =>
            'The image must be JPG, JPEG, or PNG.',

            'image.max' =>
            'The provider image may not exceed 2MB.',
        ]);

        DB::transaction(function () use (
            $request,
            $validated,
            $provider
        ) {

            /*
             * Update user account
             */
            $provider->user->name =
                $validated['name'];

            $provider->user->email =
                $validated['email'];

            /*
             * Only change password if a new password
             * was entered.
             */
            if (!empty($validated['password'])) {

                $provider->user->password =
                    Hash::make(
                        $validated['password']
                    );
            }

            /*
             * Keep provider account type.
             */
            $provider->user->utype = 'SVP';

            $provider->user->save();

            /*
             * Update provider image.
             */
            if ($request->hasFile('image')) {

                $image = $request->file('image');

                $imageName =
                    time() . '_' .
                    uniqid() . '.' .
                    $image->getClientOriginalExtension();

                $destination =
                    public_path('image/profile');

                if (!is_dir($destination)) {
                    mkdir($destination, 0755, true);
                }

                /*
                 * Remove old image if it exists.
                 */
                if (
                    !empty($provider->image) &&
                    file_exists(
                        $destination . '/' . $provider->image
                    )
                ) {
                    @unlink(
                        $destination . '/' . $provider->image
                    );
                }

                $image->move(
                    $destination,
                    $imageName
                );

                $provider->image = $imageName;
            }

            /*
             * Update provider information.
             */
            $provider->service_category_id =
                $validated['service_category_id'] ?? null;

            $provider->service_locations =
                $validated['service_locations'] ?? null;

            $provider->about =
                $validated['about'] ?? null;

            $provider->skills =
                $validated['skills'] ?? null;

            $provider->qualification =
                $validated['qualification'] ?? null;

            $provider->experience =
                $validated['experience'] ?? null;

            $provider->status =
                $validated['status'];

            $provider->save();
        });

        return redirect()
            ->route(
                'admin.ShowServiceProviders',
                $provider->id
            )
            ->with(
                'message',
                'Service provider updated successfully.'
            );
    }

    public function ProviderRating()
    {
        //
        $ratings = ServiceRating::all();
        return view('admin.provider-rating.index', compact('ratings'));
    }
    public function ProviderFeedback()
    {
        $feedbacks = Feedback::with([
            'serviceProvider.user',
            'serviceProvider.category',
        ])
            ->latest()
            ->get();

        $totalFeedbacks = $feedbacks->count();

        $approvedFeedbacks = $feedbacks
            ->where('approved', true)
            ->count();

        $pendingFeedbacks = $feedbacks
            ->where('approved', false)
            ->count();

        $providersWithFeedback = $feedbacks
            ->pluck('Service_Provider_ID')
            ->filter()
            ->unique()
            ->count();

        return view('admin.provider-feedback.index', compact(
            'feedbacks',
            'totalFeedbacks',
            'approvedFeedbacks',
            'pendingFeedbacks',
            'providersWithFeedback'
        ));
    }
    public function approveFeedback($id)
    {
        //
        $data = Feedback::findOrFail($id);
        $data->approved = "1";
        $data->save();
        Session()->flash('message', 'approved Successfully!');
        return redirect()->back();
    }
    public function approveRating($id)
    {
        //
        $data = ServiceRating::findOrFail($id);
        $data->approved = "1";
        $data->save();
        Session()->flash('message', 'approved Successfully!');
        return redirect()->back();
    }
}
