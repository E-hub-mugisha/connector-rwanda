<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Blogs;
use App\Models\ServiceCategory;
use App\Models\ServiceSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Blog listing
     */
    public function index(Request $request)
    {
        $query = Blogs::query()
            ->with(['category', 'subcategory', 'user'])
            ->latest();

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('content', 'like', '%' . $search . '%')
                    ->orWhere('slug', 'like', '%' . $search . '%');

            });
        }


        /*
        |--------------------------------------------------------------------------
        | Status
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Category
        |--------------------------------------------------------------------------
        */

        if ($request->filled('category')) {

            $query->where(
                'service_category_id',
                $request->category
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Featured
        |--------------------------------------------------------------------------
        */

        if ($request->filled('featured')) {

            $query->where(
                'featured',
                $request->featured
            );
        }


        $blogs = $query->paginate(15)->withQueryString();

        $categories = ServiceCategory::orderBy('name')->get();


        return view(
            'admin.blogs.index',
            compact(
                'blogs',
                'categories'
            )
        );
    }


    /**
     * Create
     */
    public function create()
    {
        $categories = ServiceCategory::all();

        $subcategory = ServiceSubCategory::all();

        return view(
            'admin.blogs.create',
            compact(
                'categories',
                'subcategory'
            )
        );
    }


    /**
     * Store
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'service_category_id' => [
                'required',
                'exists:service_categories,id',
            ],

            'service_sub_category_id' => [
                'nullable',
                'exists:service_sub_categories,id',
            ],

            'content' => [
                'required',
                'string',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],

            'thumbnail' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],

            'status' => [
                'nullable',
                'in:pending,approved,rejected',
            ],
        ]);


        $blog = new Blogs();

        $blog->title = $validated['title'];

        $blog->slug = $this->generateUniqueSlug(
            $validated['title']
        );

        $blog->content = $validated['content'];

        $blog->user_id = Auth::id();

        $blog->service_category_id =
            $validated['service_category_id'];

        $blog->service_sub_category_id =
            $validated['service_sub_category_id'] ?? null;

        $blog->status =
            $validated['status'] ?? 'pending';

        $blog->featured =
            $request->boolean('featured');

        $blog->views = 0;


        /*
        |--------------------------------------------------------------------------
        | Main image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {

            $destinationPath = public_path('image/blog');

            if (!File::exists($destinationPath)) {
                File::makeDirectory(
                    $destinationPath,
                    0755,
                    true
                );
            }

            $image = $request->file('image');

            $imageName =
                time() .
                '_' .
                Str::random(8) .
                '.' .
                $image->getClientOriginalExtension();

            $image->move(
                $destinationPath,
                $imageName
            );

            $blog->image = $imageName;
        }


        /*
        |--------------------------------------------------------------------------
        | Thumbnail
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('thumbnail')) {

            $destinationPath =
                public_path('thumbnail/blog');

            if (!File::exists($destinationPath)) {
                File::makeDirectory(
                    $destinationPath,
                    0755,
                    true
                );
            }

            $thumbnail =
                $request->file('thumbnail');

            $thumbnailName =
                time() .
                '_' .
                Str::random(8) .
                '.' .
                $thumbnail->getClientOriginalExtension();

            $thumbnail->move(
                $destinationPath,
                $thumbnailName
            );

            $blog->thumbnail = $thumbnailName;
        }


        $blog->save();


        return redirect()
            ->route('admin.blogs')
            ->with(
                'message',
                'Article created successfully.'
            );
    }


    /**
     * Show
     */
    public function show($slug)
    {
        $blog = Blogs::with([
            'category',
            'subcategory',
            'user',
            'comments'
        ])
        ->where('slug', $slug)
        ->firstOrFail();


        return view(
            'admin.blogs.show',
            compact('blog')
        );
    }


    /**
     * Edit
     */
    public function edit($id)
    {
        $blog = Blogs::findOrFail($id);

        $categories =
            ServiceCategory::all();

        $subcategory =
            ServiceSubCategory::all();


        return view(
            'admin.blogs.edit',
            compact(
                'categories',
                'blog',
                'subcategory'
            )
        );
    }


    /**
     * Update
     */
    public function update(
        Request $request,
        $id
    ) {

        $blog = Blogs::findOrFail($id);


        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'service_category_id' => [
                'required',
                'exists:service_categories,id',
            ],

            'service_sub_category_id' => [
                'nullable',
                'exists:service_sub_categories,id',
            ],

            'content' => [
                'required',
                'string',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],

            'thumbnail' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],

            'status' => [
                'nullable',
                'in:pending,approved,rejected',
            ],
        ]);


        $blog->title =
            $validated['title'];

        $blog->slug =
            $this->generateUniqueSlug(
                $validated['title'],
                $blog->id
            );

        $blog->content =
            $validated['content'];

        $blog->service_category_id =
            $validated['service_category_id'];

        $blog->service_sub_category_id =
            $validated['service_sub_category_id'] ?? null;

        $blog->status =
            $validated['status'] ?? $blog->status;

        $blog->featured =
            $request->boolean('featured');


        /*
        |--------------------------------------------------------------------------
        | Replace main image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {

            $destinationPath =
                public_path('image/blog');

            if (!File::exists($destinationPath)) {
                File::makeDirectory(
                    $destinationPath,
                    0755,
                    true
                );
            }

            $image =
                $request->file('image');

            $imageName =
                time() .
                '_' .
                Str::random(8) .
                '.' .
                $image->getClientOriginalExtension();

            $image->move(
                $destinationPath,
                $imageName
            );

            if (
                $blog->image &&
                File::exists(
                    $destinationPath . '/' . $blog->image
                )
            ) {
                File::delete(
                    $destinationPath . '/' . $blog->image
                );
            }

            $blog->image = $imageName;
        }


        /*
        |--------------------------------------------------------------------------
        | Replace thumbnail
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('thumbnail')) {

            $destinationPath =
                public_path('thumbnail/blog');

            if (!File::exists($destinationPath)) {
                File::makeDirectory(
                    $destinationPath,
                    0755,
                    true
                );
            }

            $thumbnail =
                $request->file('thumbnail');

            $thumbnailName =
                time() .
                '_' .
                Str::random(8) .
                '.' .
                $thumbnail->getClientOriginalExtension();

            $thumbnail->move(
                $destinationPath,
                $thumbnailName
            );

            if (
                $blog->thumbnail &&
                File::exists(
                    $destinationPath . '/' . $blog->thumbnail
                )
            ) {
                File::delete(
                    $destinationPath . '/' . $blog->thumbnail
                );
            }

            $blog->thumbnail =
                $thumbnailName;
        }


        $blog->save();


        return redirect()
            ->route('admin.blogs')
            ->with(
                'message',
                'Article updated successfully.'
            );
    }


    /**
     * Approve
     */
    public function approveBlog($id)
    {
        $blog = Blogs::findOrFail($id);

        $blog->status = 'approved';

        $blog->save();


        return redirect()
            ->route('admin.blogs')
            ->with(
                'message',
                'Article approved successfully.'
            );
    }


    /**
     * Delete
     */
    public function destroy($id)
    {
        $blog = Blogs::findOrFail($id);


        if ($blog->image) {

            $imagePath =
                public_path(
                    'image/blog/' . $blog->image
                );

            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }


        if ($blog->thumbnail) {

            $thumbnailPath =
                public_path(
                    'thumbnail/blog/' . $blog->thumbnail
                );

            if (File::exists($thumbnailPath)) {
                File::delete($thumbnailPath);
            }
        }


        $blog->delete();


        return redirect()
            ->route('admin.blogs')
            ->with(
                'message',
                'Article deleted successfully.'
            );
    }


    /**
     * Generate unique slug
     */
    private function generateUniqueSlug(
        string $title,
        $ignoreId = null
    ) {

        $slug = Str::slug($title);

        $originalSlug = $slug;

        $counter = 1;


        while (
            Blogs::where('slug', $slug)
                ->when(
                    $ignoreId,
                    function ($query) use ($ignoreId) {
                        $query->where('id', '!=', $ignoreId);
                    }
                )
                ->exists()
        ) {

            $slug =
                $originalSlug .
                '-' .
                $counter++;

        }


        return $slug;
    }
}