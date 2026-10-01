<?php

namespace App\Http\Controllers\stadmin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceProvider;
use App\Models\ServiceSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $sprovider = ServiceProvider::where('user_id', $user->id)->first();

        if (!$sprovider) {
            return redirect()
                ->back()
                ->with('error', 'Service provider profile not found.');
        }

        $baseQuery = Service::where('service_provider_id', $sprovider->id);

        $stats = [
            'total' => (clone $baseQuery)->count(),
            'active' => (clone $baseQuery)->where('status', true)->count(),
            'inactive' => (clone $baseQuery)->where('status', false)->count(),
            'categories' => (clone $baseQuery)
                ->whereNotNull('service_category_id')
                ->distinct('service_category_id')
                ->count('service_category_id'),
        ];

        $services = $baseQuery
            ->with('category')
            ->latest()
            ->get();

        return view('stadmin.services.index', compact(
            'services',
            'sprovider',
            'stats'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();

        $sprovider = ServiceProvider::where('user_id', $user->id)
            ->firstOrFail();

        $categories = ServiceCategory::orderBy('name')->get();

        $subcategories = ServiceSubCategory::orderBy('name')->get();

        return view('stadmin.services.create', compact(
            'sprovider',
            'categories',
            'subcategories'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $sprovider = ServiceProvider::where('user_id', $user->id)
            ->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:255',

            'service_category_id' => [
                'required',
                'exists:service_categories,id',
            ],

            'sub_category_id' => [
                'nullable',
                'exists:service_sub_categories,id',
            ],

            'description' => 'required|string',

            'inclusion' => 'nullable|string',

            'exclusion' => 'nullable|string',

            'price' => 'required|numeric|min:0',

            'discount' => 'nullable|numeric|min:0',

            'discount_type' => [
                'nullable',
                'in:percentage,fixed',
            ],

            'location' => 'nullable|string|max:255',

            'duration' => 'nullable|string|max:100',

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'status' => 'nullable|boolean',
        ]);


        /*
    |--------------------------------------------------------------------------
    | Generate Slug
    |--------------------------------------------------------------------------
    */

        $slug = Str::slug($request->name);

        $originalSlug = $slug;
        $counter = 1;

        while (
            Service::where('slug', $slug)->exists()
        ) {
            $slug = $originalSlug . '-' . $counter++;
        }

        $validated['slug'] = $slug;


        /*
    |--------------------------------------------------------------------------
    | Provider
    |--------------------------------------------------------------------------
    */

        $validated['service_provider_id'] = $sprovider->id;


        /*
    |--------------------------------------------------------------------------
    | Status
    |--------------------------------------------------------------------------
    */

        $validated['status'] =
            $request->boolean('status');


        /*
    |--------------------------------------------------------------------------
    | Image
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

            $image->move(
                public_path('image/services'),
                $imageName
            );

            $validated['image'] = $imageName;
        } else {

            $validated['image'] = 'default.png';
        }


        /*
    |--------------------------------------------------------------------------
    | Create Service
    |--------------------------------------------------------------------------
    */

        $service = Service::create($validated);


        return redirect()
            ->route(
                'serviceProvider.show',
                $service->slug
            )
            ->with(
                'success',
                'Service created successfully.'
            );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $user = Auth::user();

        $sprovider = ServiceProvider::where('user_id', $user->id)->firstOrFail();

        $details = Service::with([
            'category',
            'subcategory',
            'provider',
            'ratings',
            'media',
            'portfolios',
            'staffMembers',
            'promotions',
        ])
            ->where('service_provider_id', $sprovider->id)
            ->where('slug', $slug)
            ->firstOrFail();

        return view('stadmin.services.show', compact('details'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();

        $sprovider = ServiceProvider::where('user_id', $user->id)
            ->firstOrFail();

        $service = Service::with([
            'category',
            'subcategory',
            'provider',
        ])
            ->where('service_provider_id', $sprovider->id)
            ->findOrFail($id);

        $categories = ServiceCategory::orderBy('name')->get();

        $subcategories = ServiceSubCategory::orderBy('name')->get();

        return view('stadmin.services.edit', compact(
            'service',
            'categories',
            'subcategories'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();

        $sprovider = ServiceProvider::where('user_id', $user->id)
            ->firstOrFail();

        $service = Service::where('service_provider_id', $sprovider->id)
            ->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',

            'service_category_id' => [
                'required',
                'exists:service_categories,id',
            ],

            'sub_category_id' => [
                'nullable',
                'exists:service_sub_categories,id',
            ],

            'description' => 'required|string',

            'inclusion' => 'nullable|string',

            'exclusion' => 'nullable|string',

            'price' => 'required|numeric|min:0',

            'discount' => 'nullable|numeric|min:0',

            'discount_type' => 'nullable|in:percentage,fixed',

            'location' => 'nullable|string|max:255',

            'duration' => 'nullable|string|max:100',

            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',

            'status' => 'nullable|boolean',
        ]);

        /*
    |--------------------------------------------------------------------------
    | Status
    |--------------------------------------------------------------------------
    */

        $validated['status'] = $request->boolean('status');

        /*
    |--------------------------------------------------------------------------
    | Image
    |--------------------------------------------------------------------------
    */

        if ($request->hasFile('image')) {

            $image = $request->file('image');

            $imageName = time() . '_' . uniqid() . '.' .
                $image->getClientOriginalExtension();

            $image->move(
                public_path('image/services'),
                $imageName
            );

            /*
         * Delete old image
         */

            if (
                $service->image &&
                $service->image !== 'default.png'
            ) {

                $oldImage = public_path(
                    'image/services/' . $service->image
                );

                if (file_exists($oldImage)) {
                    @unlink($oldImage);
                }
            }

            $validated['image'] = $imageName;
        }

        /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

        $service->update($validated);

        return redirect()
            ->route('serviceProvider.show', $service->slug)
            ->with(
                'success',
                'Service updated successfully.'
            );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return redirect()->route('serviceProvider.index')
            ->with('success', 'deleted successfully');
    }
}
