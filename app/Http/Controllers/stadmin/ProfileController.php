<?php

namespace App\Http\Controllers\stadmin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\Rating;
use App\Models\ServiceCategory;
use App\Models\ServiceProvider;
use App\Models\ServiceProviderRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $user = Auth::user();

        $sprovider = ServiceProvider::with([
            'category',
            'services',
            'staffMembers',
            'workingHours',
            'ratings',
            'feedback',
        ])
            ->where('user_id', $user->id)
            ->first();

        if (!$sprovider) {
            return redirect()
                ->back()
                ->with('error', 'Service provider profile not found.');
        }

        $categories = ServiceCategory::orderBy('name')->get();

        return view('stadmin.account.index', compact(
            'sprovider',
            'categories'
        ));
    }


    public function edit()
    {
        //
        $scategories = ServiceCategory::all();
        $sprovider = ServiceProvider::where('user_id', Auth::user()->id)->first();
        return view('stadmin.account.edit', ['scategories' => $scategories, 'sprovider' => $sprovider]);
    }

    public function updateProfile(Request $request)
    {
        $user = \App\Models\User::findOrFail(Auth::id());

        $sprovider = ServiceProvider::where(
            'user_id',
            $user->id
        )->firstOrFail();


        $validated = $request->validate([

            // User
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . $user->id,
            ],

            'phone' => [
                'nullable',
                'string',
                'max:30',
            ],


            // Provider
            'city' => [
                'nullable',
                'string',
                'max:255',
            ],

            'service_category_id' => [
                'nullable',
                'exists:service_categories,id',
            ],

            'service_locations' => [
                'nullable',
                'string',
                'max:500',
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
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

        ]);


        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? null;

        $user->save();


        /*
    |--------------------------------------------------------------------------
    | Update Service Provider
    |--------------------------------------------------------------------------
    */

        $sprovider->city =
            $validated['city'] ?? null;

        $sprovider->service_category_id =
            $validated['service_category_id'] ?? null;

        $sprovider->service_locations =
            $validated['service_locations'] ?? null;

        $sprovider->about =
            $validated['about'] ?? null;

        $sprovider->skills =
            $validated['skills'] ?? null;

        $sprovider->qualification =
            $validated['qualification'] ?? null;

        $sprovider->experience =
            $validated['experience'] ?? null;


        /*
    |--------------------------------------------------------------------------
    | Profile Image
    |--------------------------------------------------------------------------
    */

        if ($request->hasFile('image')) {

            $image = $request->file('image');

            $imageName =
                time() .
                '_' .
                uniqid() .
                '.' .
                $image->getClientOriginalExtension();


            $imageDirectory =
                public_path('image/profile');


            if (!is_dir($imageDirectory)) {
                mkdir(
                    $imageDirectory,
                    0755,
                    true
                );
            }


            $image->move(
                $imageDirectory,
                $imageName
            );


            /*
        |--------------------------------------------------------------------------
        | Delete Old Image
        |--------------------------------------------------------------------------
        */

            if (
                $sprovider->image &&
                $sprovider->image !== 'avatar.jpg'
            ) {

                $oldImage =
                    $imageDirectory .
                    DIRECTORY_SEPARATOR .
                    $sprovider->image;


                if (file_exists($oldImage)) {
                    @unlink($oldImage);
                }
            }


            $sprovider->image = $imageName;
        }


        $sprovider->save();


        return redirect()
            ->back()
            ->with(
                'success',
                'Your profile has been updated successfully.'
            );
    }

    public function UserFeedback()
    {
        $user = Auth::user();

        $sprovider = ServiceProvider::where('user_id', $user->id)
            ->firstOrFail();

        $feedbackQuery = Feedback::where(
            'Service_Provider_ID',
            $sprovider->id
        )->where('approved', true);

        $stats = [
            'total' => (clone $feedbackQuery)->count(),

            'this_month' => (clone $feedbackQuery)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),

            'latest' => (clone $feedbackQuery)
                ->latest('created_at')
                ->first(),
        ];

        $feedbacks = $feedbackQuery
            ->latest('created_at')
            ->paginate(10)
            ->withQueryString();

        return view(
            'stadmin.feedback.user-feedbacks',
            compact(
                'feedbacks',
                'sprovider',
                'stats'
            )
        );
    }

    public function UserReviews()
    {
        $user = Auth::user();

        $sprovider = ServiceProvider::with([
            'user',
            'category',
        ])
            ->where('user_id', $user->id)
            ->firstOrFail();

        $ratingsQuery = ServiceProviderRating::with('user')
            ->where('service_provider_id', $sprovider->id)
            ->where('status', 1);

        $stats = [
            'total' => (clone $ratingsQuery)->count(),

            'average' => round(
                (clone $ratingsQuery)->avg('rating') ?? 0,
                1
            ),

            'five_star' => (clone $ratingsQuery)
                ->where('rating', 5)
                ->count(),

            'four_star' => (clone $ratingsQuery)
                ->where('rating', 4)
                ->count(),

            'three_star' => (clone $ratingsQuery)
                ->where('rating', 3)
                ->count(),

            'two_star' => (clone $ratingsQuery)
                ->where('rating', 2)
                ->count(),

            'one_star' => (clone $ratingsQuery)
                ->where('rating', 1)
                ->count(),
        ];

        $ratings = $ratingsQuery
            ->latest('created_at')
            ->paginate(10)
            ->withQueryString();

        return view(
            'stadmin.feedback.user-reviews',
            compact(
                'ratings',
                'sprovider',
                'stats'
            )
        );
    }
}
