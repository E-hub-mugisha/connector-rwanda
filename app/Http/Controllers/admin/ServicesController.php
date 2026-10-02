<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceProvider;
use App\Models\ServiceSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ServicesController extends Controller
{
    /**
     * Display all services.
     */
    public function index(Request $request)
    {
        $services = Service::query()
            ->with([
                'category:id,name',
                'subcategory:id,name',
                'provider:id,user_id',
                'provider.user:id,name,email',
            ])
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view(
            'admin.services.index',
            compact('services')
        );
    }

    /**
     * Show create service form.
     */
    public function createService()
    {
        $categories = ServiceCategory::query()
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        $subcategories = ServiceSubCategory::query()
            ->select(
                'id',
                'name',
                'service_category_id'
            )
            ->orderBy('name')
            ->get();

        $providers = ServiceProvider::query()
            ->with('user:id,name,email')
            ->where('status', 'approved')
            ->orderBy('id', 'desc')
            ->get();

        return view(
            'admin.services.create',
            [
                'categories' => $categories,
                'subcategories' => $subcategories,
                'sprovider' => $providers,
            ]
        );
    }

    /**
     * Store a service.
     */
    public function postService(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'min:2',
                'max:255',
            ],

            'service_provider_id' => [
                'required',
                'integer',
                'exists:service_providers,id',
            ],

            'service_category_id' => [
                'required',
                'integer',
                'exists:service_categories,id',
            ],

            'sub_category_id' => [
                'nullable',
                'integer',
                'exists:service_sub_categories,id',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'discount' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'discount_type' => [
                'nullable',
                'string',
                'max:50',
            ],

            'duration' => [
                'required',
                'string',
                'max:100',
            ],

            'location' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'required',
                'string',
            ],

            'inclusion' => [
                'required',
                'string',
            ],

            'exclusion' => [
                'required',
                'string',
            ],

            'image' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:2048',
            ],

            'featured' => [
                'nullable',
                'boolean',
            ],

            'status' => [
                'nullable',
                'boolean',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Validate that subcategory belongs to selected category
        |--------------------------------------------------------------------------
        */

        if (!empty($validated['sub_category_id'])) {

            $validSubcategory = ServiceSubCategory::query()
                ->where('id', $validated['sub_category_id'])
                ->where(
                    'service_category_id',
                    $validated['service_category_id']
                )
                ->exists();

            if (!$validSubcategory) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'sub_category_id' =>
                            'The selected subcategory does not belong to the selected category.',
                    ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Create service
        |--------------------------------------------------------------------------
        */

        $service = new Service();

        $service->service_provider_id =
            $validated['service_provider_id'];

        $service->name =
            $validated['name'];

        $service->slug =
            $this->generateUniqueSlug(
                $validated['name']
            );

        $service->service_category_id =
            $validated['service_category_id'];

        $service->sub_category_id =
            $validated['sub_category_id'] ?? null;

        $service->price =
            $validated['price'];

        $service->discount =
            $validated['discount'] ?? 0;

        $service->discount_type =
            $validated['discount_type'] ?? null;

        $service->duration =
            $validated['duration'];

        $service->description =
            $validated['description'];

        $service->location =
            $validated['location'];

        $service->inclusion =
            $this->formatList(
                $validated['inclusion']
            );

        $service->exclusion =
            $this->formatList(
                $validated['exclusion']
            );

        $service->featured =
            $request->boolean('featured');

        $service->status =
            $request->boolean('status', true);

        /*
        |--------------------------------------------------------------------------
        | Upload image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {
            $service->image =
                $this->uploadServiceImage(
                    $request->file('image')
                );
        }

        $service->save();

        return redirect()
            ->route('admin.all_services')
            ->with(
                'message',
                'Service created successfully.'
            );
    }

    /**
     * Display a service.
     */
    public function showService($slug)
    {
        $service = Service::query()
            ->with([
                'category:id,name',
                'subcategory:id,name',
                'provider:id,user_id',
                'provider.user:id,name,email',
                'ratings',
                'media',
                'portfolios',
                'promotions',
            ])
            ->where('slug', $slug)
            ->firstOrFail();

        return view(
            'admin.services.show',
            compact('service')
        );
    }

    /**
     * Show edit service form.
     */
    public function editService($id)
    {
        $service = Service::query()
            ->with([
                'category:id,name',
                'subcategory:id,name,service_category_id',
                'provider:id,user_id',
            ])
            ->findOrFail($id);

        $categories = ServiceCategory::query()
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        $subcategories = ServiceSubCategory::query()
            ->select(
                'id',
                'name',
                'service_category_id'
            )
            ->orderBy('name')
            ->get();

        $providers = ServiceProvider::query()
            ->with('user:id,name,email')
            ->where('status', 'approved')
            ->orderBy('id', 'desc')
            ->get();

        return view(
            'admin.services.edit',
            [
                'service' => $service,
                'categories' => $categories,
                'subcategories' => $subcategories,
                'sprovider' => $providers,
            ]
        );
    }

    /**
     * Update service.
     */
    public function updateService(
        Request $request,
        $id
    ) {
        $service = Service::findOrFail($id);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'min:2',
                'max:255',
            ],

            'service_provider_id' => [
                'required',
                'integer',
                'exists:service_providers,id',
            ],

            'service_category_id' => [
                'required',
                'integer',
                'exists:service_categories,id',
            ],

            'sub_category_id' => [
                'nullable',
                'integer',
                'exists:service_sub_categories,id',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'discount' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'discount_type' => [
                'nullable',
                'string',
                'max:50',
            ],

            'duration' => [
                'required',
                'string',
                'max:100',
            ],

            'location' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'required',
                'string',
            ],

            'inclusion' => [
                'required',
                'string',
            ],

            'exclusion' => [
                'required',
                'string',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:2048',
            ],

            'featured' => [
                'nullable',
                'boolean',
            ],

            'status' => [
                'nullable',
                'boolean',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Validate subcategory/category relationship
        |--------------------------------------------------------------------------
        */

        if (!empty($validated['sub_category_id'])) {

            $validSubcategory = ServiceSubCategory::query()
                ->where(
                    'id',
                    $validated['sub_category_id']
                )
                ->where(
                    'service_category_id',
                    $validated['service_category_id']
                )
                ->exists();

            if (!$validSubcategory) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'sub_category_id' =>
                            'The selected subcategory does not belong to the selected category.',
                    ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Update service
        |--------------------------------------------------------------------------
        */

        $service->name =
            $validated['name'];

        $service->slug =
            $this->generateUniqueSlug(
                $validated['name'],
                $service->id
            );

        $service->service_provider_id =
            $validated['service_provider_id'];

        $service->service_category_id =
            $validated['service_category_id'];

        $service->sub_category_id =
            $validated['sub_category_id'] ?? null;

        $service->price =
            $validated['price'];

        $service->discount =
            $validated['discount'] ?? 0;

        $service->discount_type =
            $validated['discount_type'] ?? null;

        $service->featured =
            $request->boolean('featured');

        $service->status =
            $request->boolean('status', true);

        $service->description =
            $validated['description'];

        $service->duration =
            $validated['duration'];

        $service->location =
            $validated['location'];

        $service->inclusion =
            $this->formatList(
                $validated['inclusion']
            );

        $service->exclusion =
            $this->formatList(
                $validated['exclusion']
            );

        /*
        |--------------------------------------------------------------------------
        | Replace image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {

            $oldImage =
                $service->image;

            $newImage =
                $this->uploadServiceImage(
                    $request->file('image')
                );

            $service->image =
                $newImage;

            if (!empty($oldImage)) {
                $this->deleteServiceImage(
                    $oldImage
                );
            }
        }

        $service->save();

        return redirect()
            ->route('admin.all_services')
            ->with(
                'message',
                'Service updated successfully.'
            );
    }

    /**
     * Delete service.
     */
    public function destroy($id)
    {
        $service = Service::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | Store image before deleting model
        |--------------------------------------------------------------------------
        */

        $image =
            $service->image;

        $service->delete();

        if (!empty($image)) {
            $this->deleteServiceImage(
                $image
            );
        }

        return redirect()
            ->route('admin.all_services')
            ->with(
                'message',
                'Service deleted successfully.'
            );
    }

    /**
     * Generate a unique service slug.
     */
    private function generateUniqueSlug(
        string $name,
        ?int $ignoreId = null
    ): string {

        $baseSlug =
            Str::slug($name);

        if ($baseSlug === '') {
            $baseSlug = 'service';
        }

        $slug =
            $baseSlug;

        $counter = 1;

        while (
            Service::query()
                ->where('slug', $slug)
                ->when(
                    $ignoreId,
                    function ($query) use ($ignoreId) {
                        $query->where(
                            'id',
                            '!=',
                            $ignoreId
                        );
                    }
                )
                ->exists()
        ) {

            $slug =
                $baseSlug . '-' . $counter;

            $counter++;
        }

        return $slug;
    }

    /**
     * Convert textarea lines to the existing "|" storage format.
     */
    private function formatList(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $items = preg_split(
            '/\r\n|\r|\n/',
            $value
        );

        $items = collect($items)
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values()
            ->all();

        return implode('|', $items);
    }

    /**
     * Upload service image.
     */
    private function uploadServiceImage($image): string
    {
        $destinationPath =
            public_path('image/services');

        if (!File::exists($destinationPath)) {
            File::makeDirectory(
                $destinationPath,
                0755,
                true
            );
        }

        $fileName =
            date('YmdHis') .
            '_' .
            Str::random(8) .
            '.' .
            $image->getClientOriginalExtension();

        $image->move(
            $destinationPath,
            $fileName
        );

        return $fileName;
    }

    /**
     * Delete service image.
     */
    private function deleteServiceImage(
        string $image
    ): void {

        $imagePath =
            public_path(
                'image/services/' . $image
            );

        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }
    }
}