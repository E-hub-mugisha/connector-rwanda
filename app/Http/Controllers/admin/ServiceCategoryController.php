<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ServiceCategoryController extends Controller
{
    /**
     * Display all service categories.
     */
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));

        $scategories = ServiceCategory::query()
            ->with(['subcategories', 'parent'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // All categories are needed for the parent selector.
        $categories = ServiceCategory::query()
            ->orderBy('name')
            ->get();

        $totalCategories = ServiceCategory::count();

        $featuredCategories = ServiceCategory::where(
            'featured',
            true
        )->count();

        $parentCategories = ServiceCategory::whereNull(
            'service_category_id'
        )->count();

        $totalSubcategories = ServiceSubCategory::count();

        return view('admin.service-category.index', [
            'scategories' => $scategories,
            'categories' => $categories,

            'search' => $search,

            'totalCategories' => $totalCategories,
            'featuredCategories' => $featuredCategories,
            'parentCategories' => $parentCategories,
            'totalSubcategories' => $totalSubcategories,
        ]);
    }

    /**
     * Show create category form.
     */
    public function create()
    {
        $categories = ServiceCategory::latest()->get();

        return view('admin.service-category.create', [
            'categories' => $categories,
        ]);
    }

    /**
     * Create a new category or subcategory.
     */
    public function createNewCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg,gif,svg',
                'max:2048',
            ],
            'service_category_id' => 'nullable|exists:service_categories,id',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Create Subcategory
        |--------------------------------------------------------------------------
        */

        if ($request->filled('service_category_id')) {
            $scategory = new ServiceSubCategory();

            $scategory->name = $request->input('name');
            $scategory->slug = $this->generateUniqueSlug(
                ServiceSubCategory::class,
                $request->input('name')
            );
            $scategory->service_category_id = $request->input('service_category_id');

            $scategory->save();

            session()->flash('message', 'Subcategory created successfully.');

            return redirect()->route('admin.service_categories');
        }

        /*
        |--------------------------------------------------------------------------
        | Create Main Category
        |--------------------------------------------------------------------------
        */

        $scategory = new ServiceCategory();

        $scategory->name = $request->input('name');

        $scategory->slug = $this->generateUniqueSlug(
            ServiceCategory::class,
            $request->input('name')
        );

        /*
        |--------------------------------------------------------------------------
        | Upload Category Image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $destinationPath = public_path('image/categories');

            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $fileName = time() . '_' . Str::random(8) . '.' .
                $image->getClientOriginalExtension();

            $image->move($destinationPath, $fileName);

            $scategory->image = $fileName;
        }

        $scategory->save();

        session()->flash('message', 'Category created successfully.');

        return redirect()->route('admin.service_categories');
    }

    /**
     * Display services belonging to a category.
     */
    public function showServiceByCategory($category_slug)
    {
        $category = ServiceCategory::where('slug', $category_slug)->firstOrFail();

        $services = Service::where(
            'service_category_id',
            $category->id
        )
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.service-category.show-service', [
            'category_name' => $category->name,
            'services' => $services,
        ]);
    }

    /**
     * Show category edit form.
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
     * Update service category.
     */
    public function updateServiceCategory(Request $request, $id)
    {
        $scategory = ServiceCategory::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'name' => 'required|string|max:255',
            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif,svg',
                'max:2048',
            ],
            'featured' => 'nullable',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Update Basic Information
        |--------------------------------------------------------------------------
        */

        $scategory->name = $request->input('name');

        $scategory->slug = $this->generateUniqueSlug(
            ServiceCategory::class,
            $request->input('name'),
            $scategory->id
        );

        $scategory->featured = $request->boolean('featured');

        /*
        |--------------------------------------------------------------------------
        | Update Image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $destinationPath = public_path('image/categories');

            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            /*
            |--------------------------------------------------------------------------
            | Delete old image
            |--------------------------------------------------------------------------
            */

            if (
                !empty($scategory->image) &&
                File::exists($destinationPath . '/' . $scategory->image)
            ) {
                File::delete(
                    $destinationPath . '/' . $scategory->image
                );
            }

            $fileName = time() . '_' . Str::random(8) . '.' .
                $image->getClientOriginalExtension();

            $image->move($destinationPath, $fileName);

            $scategory->image = $fileName;
        }

        $scategory->save();

        session()->flash('message', 'Category updated successfully.');

        return redirect()->route('admin.service_categories');
    }

    /**
     * Delete service category.
     */
    public function destroy($id)
    {
        $scategory = ServiceCategory::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | Delete Category Image
        |--------------------------------------------------------------------------
        */

        if (!empty($scategory->image)) {
            $imagePath = public_path(
                'image/categories/' . $scategory->image
            );

            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Delete Category
        |--------------------------------------------------------------------------
        */

        $scategory->delete();

        session()->flash('message', 'Category deleted successfully.');

        return redirect()->route('admin.service_categories');
    }

    /**
     * Display subcategories.
     */
    public function SubCat(Request $request)
    {
        $search = trim($request->input('search', ''));

        $scategories = ServiceSubCategory::query()
            ->with('category')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $categories = ServiceCategory::latest()->get();

        return view('admin.service-category.subcategory', [
            'scategories' => $scategories,
            'categories' => $categories,
            'search' => $search,
        ]);
    }

    /**
     * Create a new subcategory.
     */
    public function NewSubCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'service_category_id' => [
                'required',
                'exists:service_categories,id',
            ],
        ]);

        $scategory = new ServiceSubCategory();

        $scategory->slug = $this->generateUniqueSlug(
            ServiceSubCategory::class,
            $request->input('name')
        );

        $scategory->name = $request->input('name');

        $scategory->service_category_id =
            $request->input('service_category_id');

        $scategory->save();

        session()->flash(
            'message',
            'Subcategory created successfully.'
        );

        return redirect()->back();
    }

    /**
     * Delete subcategory.
     */
    public function destroySub($id)
    {
        $subcategory = ServiceSubCategory::findOrFail($id);

        $subcategory->delete();

        session()->flash(
            'message',
            'Subcategory deleted successfully.'
        );

        return redirect()->back();
    }

    /**
     * Generate a unique slug.
     */
    private function generateUniqueSlug(
        string $model,
        string $name,
        ?int $ignoreId = null
    ): string {
        $slug = Str::slug($name);

        $originalSlug = $slug;
        $counter = 1;

        while (
            $model::where('slug', $slug)
            ->when($ignoreId, function ($query) use ($ignoreId) {
                $query->where('id', '!=', $ignoreId);
            })
            ->exists()
        ) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
