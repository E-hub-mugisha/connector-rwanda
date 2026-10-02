<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ServiceCategoryController extends Controller
{
    /**
     * Display service categories.
     */
    public function index()
    {
        $scategories = ServiceCategory::query()
            ->with([
                'subcategories:id,name,slug,service_category_id'
            ])
            ->orderBy('name')
            ->get();

        return view(
            'admin.service-category.index',
            compact('scategories')
        );
    }

    /**
     * Show category creation page.
     */
    public function create()
    {
        $categories = ServiceCategory::query()
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return view(
            'admin.service-category.create',
            compact('categories')
        );
    }

    /**
     * Create a category or subcategory from the same form.
     *
     * If service_category_id is supplied, a subcategory is created.
     * Otherwise a main category is created.
     */
    public function createNewCategory(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Determine whether this is a category or subcategory
        |--------------------------------------------------------------------------
        */

        $isSubcategory = $request->filled('service_category_id');

        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $rules = [
            'name' => [
                'required',
                'string',
                'min:2',
                'max:255',
            ],

            'service_category_id' => [
                'nullable',
                'integer',
                'exists:service_categories,id',
            ],
        ];

        /*
        |--------------------------------------------------------------------------
        | Image is required ONLY for main categories
        |--------------------------------------------------------------------------
        */

        if ($isSubcategory) {
            $rules['image'] = [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif,svg',
                'max:2048',
            ];
        } else {
            $rules['image'] = [
                'required',
                'image',
                'mimes:jpeg,png,jpg,gif,svg',
                'max:2048',
            ];
        }

        $validated = $request->validate($rules);

        /*
        |--------------------------------------------------------------------------
        | Create subcategory
        |--------------------------------------------------------------------------
        */

        if ($isSubcategory) {

            $parentCategory = ServiceCategory::findOrFail(
                $validated['service_category_id']
            );

            /*
            |--------------------------------------------------------------------------
            | Generate unique slug within subcategories
            |--------------------------------------------------------------------------
            */

            $slug = $this->generateUniqueSubcategorySlug(
                $validated['name']
            );

            ServiceSubCategory::create([
                'name' => $validated['name'],
                'slug' => $slug,
                'service_category_id' => $parentCategory->id,
            ]);

            return redirect()
                ->route('admin.service_categories')
                ->with(
                    'message',
                    'Subcategory created successfully.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Create main category
        |--------------------------------------------------------------------------
        */

        $slug = $this->generateUniqueCategorySlug(
            $validated['name']
        );

        $category = new ServiceCategory();

        $category->name = $validated['name'];
        $category->slug = $slug;
        $category->featured = $request->boolean('featured');

        /*
        |--------------------------------------------------------------------------
        | Upload category image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {

            $category->image = $this->uploadCategoryImage(
                $request->file('image')
            );
        }

        $category->save();

        return redirect()
            ->route('admin.service_categories')
            ->with(
                'message',
                'Category created successfully.'
            );
    }

    /**
     * Display services belonging to a category.
     */
    public function showServiceByCategory($category_slug)
    {
        $category = ServiceCategory::query()
            ->where('slug', $category_slug)
            ->firstOrFail();

        $services = Service::query()
            ->where('service_category_id', $category->id)
            ->latest()
            ->paginate(10);

        return view(
            'admin.service-category.show-service',
            [
                'category_name' => $category->name,
                'services' => $services,
            ]
        );
    }

    /**
     * Show category edit page.
     */
    public function edit($id)
    {
        $scategory = ServiceCategory::findOrFail($id);

        return view(
            'admin.service-category.edit',
            compact('scategory')
        );
    }

    /**
     * Update category.
     */
    public function updateServiceCategory(Request $request, $id)
    {
        $scategory = ServiceCategory::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'min:2',
                'max:255',
                Rule::unique('service_categories', 'name')
                    ->ignore($scategory->id),
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif,svg',
                'max:2048',
            ],

            'featured' => [
                'nullable',
                'boolean',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Generate unique slug
        |--------------------------------------------------------------------------
        */

        $slug = $this->generateUniqueCategorySlug(
            $validated['name'],
            $scategory->id
        );

        $scategory->name = $validated['name'];
        $scategory->slug = $slug;
        $scategory->featured = $request->boolean('featured');

        /*
        |--------------------------------------------------------------------------
        | Replace image only when a new image was uploaded
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {

            $oldImage = $scategory->image;

            $newImage = $this->uploadCategoryImage(
                $request->file('image')
            );

            $scategory->image = $newImage;

            /*
            |--------------------------------------------------------------------------
            | Delete old image
            |--------------------------------------------------------------------------
            */

            if (!empty($oldImage)) {

                $oldImagePath = public_path(
                    'image/categories/' . $oldImage
                );

                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }
        }

        $scategory->save();

        return redirect()
            ->route('admin.service_categories')
            ->with(
                'message',
                'Category updated successfully.'
            );
    }

    /**
     * Delete category.
     */
    public function destroy($id)
    {
        $scategory = ServiceCategory::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | Prevent deletion when subcategories exist
        |--------------------------------------------------------------------------
        */

        if ($scategory->subcategories()->exists()) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'This category cannot be deleted because it still has subcategories.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Prevent deletion when services exist
        |--------------------------------------------------------------------------
        */

        if (
            Service::where(
                'service_category_id',
                $scategory->id
            )->exists()
        ) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'This category cannot be deleted because services are using it.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Delete category image
        |--------------------------------------------------------------------------
        */

        $image = $scategory->image;

        $scategory->delete();

        if (!empty($image)) {

            $imagePath = public_path(
                'image/categories/' . $image
            );

            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        return redirect()
            ->route('admin.service_categories')
            ->with(
                'message',
                'Category deleted successfully.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | SUBCATEGORY MANAGEMENT
    |--------------------------------------------------------------------------
    */

    /**
     * Display subcategories.
     */
    public function SubCat()
    {
        $scategories = ServiceSubCategory::query()
            ->with([
                'category:id,name'
            ])
            ->orderBy('name')
            ->get();

        $categories = ServiceCategory::query()
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return view(
            'admin.service-category.subcategory',
            compact(
                'scategories',
                'categories'
            )
        );
    }

    /**
     * Create a subcategory.
     */
    public function NewSubCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'min:2',
                'max:255',
            ],

            'service_category_id' => [
                'required',
                'integer',
                'exists:service_categories,id',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Generate unique slug
        |--------------------------------------------------------------------------
        */

        $slug = $this->generateUniqueSubcategorySlug(
            $validated['name']
        );

        ServiceSubCategory::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'service_category_id' => $validated['service_category_id'],
        ]);

        return redirect()
            ->back()
            ->with(
                'message',
                'Subcategory created successfully.'
            );
    }

    /**
     * Show subcategory edit page.
     */
    public function editSub($id)
    {
        $subcategory = ServiceSubCategory::findOrFail($id);

        $categories = ServiceCategory::query()
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return view(
            'admin.service-category.edit-subcategory',
            compact(
                'subcategory',
                'categories'
            )
        );
    }

    /**
     * Update subcategory.
     */
    public function updateSub(Request $request, $id)
    {
        $subcategory = ServiceSubCategory::findOrFail($id);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'min:2',
                'max:255',
            ],

            'service_category_id' => [
                'required',
                'integer',
                'exists:service_categories,id',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Generate unique slug
        |--------------------------------------------------------------------------
        */

        $slug = $this->generateUniqueSubcategorySlug(
            $validated['name'],
            $subcategory->id
        );

        $subcategory->update([
            'name' => $validated['name'],
            'slug' => $slug,
            'service_category_id' =>
                $validated['service_category_id'],
        ]);

        return redirect()
            ->back()
            ->with(
                'message',
                'Subcategory updated successfully.'
            );
    }

    /**
     * Delete subcategory.
     */
    public function destroySub($id)
    {
        $subcategory = ServiceSubCategory::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | Prevent deletion when services use this subcategory
        |--------------------------------------------------------------------------
        */

        if ($subcategory->services()->exists()) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'This subcategory cannot be deleted because services are using it.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Prevent deletion when blogs use this subcategory
        |--------------------------------------------------------------------------
        */

        if ($subcategory->blogs()->exists()) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'This subcategory cannot be deleted because blogs are using it.'
                );
        }

        $subcategory->delete();

        return redirect()
            ->back()
            ->with(
                'message',
                'Subcategory deleted successfully.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | PRIVATE HELPERS
    |--------------------------------------------------------------------------
    */

    /**
     * Generate a unique category slug.
     */
    private function generateUniqueCategorySlug(
        string $name,
        ?int $ignoreId = null
    ): string {

        $baseSlug = Str::slug($name);

        if ($baseSlug === '') {
            $baseSlug = 'category';
        }

        $slug = $baseSlug;
        $counter = 1;

        while (
            ServiceCategory::query()
                ->where('slug', $slug)
                ->when(
                    $ignoreId,
                    fn ($query) =>
                        $query->where('id', '!=', $ignoreId)
                )
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Generate a unique subcategory slug.
     */
    private function generateUniqueSubcategorySlug(
        string $name,
        ?int $ignoreId = null
    ): string {

        $baseSlug = Str::slug($name);

        if ($baseSlug === '') {
            $baseSlug = 'subcategory';
        }

        $slug = $baseSlug;
        $counter = 1;

        while (
            ServiceSubCategory::query()
                ->where('slug', $slug)
                ->when(
                    $ignoreId,
                    fn ($query) =>
                        $query->where('id', '!=', $ignoreId)
                )
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Upload category image.
     */
    private function uploadCategoryImage($image): string
    {
        $destinationPath = public_path(
            'image/categories'
        );

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
}