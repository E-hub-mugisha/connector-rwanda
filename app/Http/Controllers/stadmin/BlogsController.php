<?php

namespace App\Http\Controllers\stadmin;

use App\Http\Controllers\Controller;
use App\Models\Blogs;
use App\Models\ServiceCategory;
use App\Models\ServiceProvider;
use App\Models\ServiceSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BlogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $sprovider = ServiceProvider::where('user_id', $user->id)
            ->firstOrFail();

        $query = Blogs::query()
            ->where('user_id', $user->id)
            ->with([
                'category:id,name',
                'subcategory:id,name',
            ]);

        /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    */
        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%")
                    ->orWhere('blog_category', 'like', "%{$search}%");
            });
        }

        /*
    |--------------------------------------------------------------------------
    | Status filter
    |--------------------------------------------------------------------------
    */
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        /*
    |--------------------------------------------------------------------------
    | Statistics
    |--------------------------------------------------------------------------
    */
        $baseQuery = Blogs::where('user_id', $user->id);

        $stats = [
            'total' => (clone $baseQuery)->count(),

            'published' => (clone $baseQuery)
                ->where('status', 'published')
                ->count(),

            'pending' => (clone $baseQuery)
                ->where('status', 'pending')
                ->count(),

            'draft' => (clone $baseQuery)
                ->where('status', 'draft')
                ->count(),

            'views' => (clone $baseQuery)->sum('views'),
        ];

        /*
    |--------------------------------------------------------------------------
    | Blogs
    |--------------------------------------------------------------------------
    */
        $blogs = $query
            ->latest('created_at')
            ->paginate(10)
            ->withQueryString();

        return view(
            'stadmin.blog.index',
            compact(
                'blogs',
                'stats',
                'sprovider'
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
        $categories = ServiceCategory::orderBy('name')
            ->get();

        $subcategory = ServiceSubCategory::orderBy('name')
            ->get();

        return view(
            'stadmin.blog.create',
            compact(
                'categories',
                'subcategory'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
                'required',
                'exists:service_sub_categories,id',
            ],

            'content' => [
                'required',
                'string',
            ],

            'image' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'thumbnail' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);


        /*
    |--------------------------------------------------------------------------
    | Verify that the selected subcategory belongs to selected category
    |--------------------------------------------------------------------------
    */

        $subcategory = ServiceSubCategory::where(
            'id',
            $validated['service_sub_category_id']
        )
            ->where(
                'service_category_id',
                $validated['service_category_id']
            )
            ->firstOrFail();


        /*
    |--------------------------------------------------------------------------
    | Generate unique slug
    |--------------------------------------------------------------------------
    */

        $slug = Str::slug($validated['title']);

        $originalSlug = $slug;

        $counter = 1;

        while (
            Blogs::where('slug', $slug)->exists()
        ) {
            $slug = $originalSlug . '-' . $counter++;
        }


        /*
    |--------------------------------------------------------------------------
    | Image directories
    |--------------------------------------------------------------------------
    */

        $imageDirectory =
            public_path('image/blogs');

        $thumbnailDirectory =
            public_path('image/blogs/thumbnails');


        if (!is_dir($imageDirectory)) {
            mkdir(
                $imageDirectory,
                0755,
                true
            );
        }

        if (!is_dir($thumbnailDirectory)) {
            mkdir(
                $thumbnailDirectory,
                0755,
                true
            );
        }


        /*
    |--------------------------------------------------------------------------
    | Upload main image
    |--------------------------------------------------------------------------
    */

        $imageName =
            time() . '_' .
            Str::random(10) . '.' .
            $request->file('image')
            ->getClientOriginalExtension();

        $request->file('image')
            ->move(
                $imageDirectory,
                $imageName
            );


        /*
    |--------------------------------------------------------------------------
    | Upload thumbnail
    |--------------------------------------------------------------------------
    */

        $thumbnailName =
            time() . '_thumb_' .
            Str::random(10) . '.' .
            $request->file('thumbnail')
            ->getClientOriginalExtension();

        $request->file('thumbnail')
            ->move(
                $thumbnailDirectory,
                $thumbnailName
            );


        /*
    |--------------------------------------------------------------------------
    | Create blog
    |--------------------------------------------------------------------------
    */

        Blogs::create([

            'user_id' => Auth::id(),

            'title' => $validated['title'],

            'slug' => $slug,

            'content' => $validated['content'],

            'image' => $imageName,

            'thumbnail' => $thumbnailName,

            'service_category_id' =>
            $validated['service_category_id'],

            'service_sub_category_id' =>
            $validated['service_sub_category_id'],

            /*
        | Change these according to your approval workflow.
        */
            'status' => 'pending',

            'views' => 0,
        ]);


        return redirect()
            ->route('serviceProviderBlog.index')
            ->with(
                'message',
                'Blog created successfully and submitted for review.'
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
        //
        $blog = Blogs::where('slug', $slug)->first();
        return view('stadmin.blog.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $categories = ServiceCategory::orderBy('name')->get();
        $subcategory = ServiceSubCategory::orderBy('name')->get();
        $blog = Blogs::findOrFail($id);
        return view('stadmin.blog.edit', compact('categories', 'blog', 'subcategory'));
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
        //
        $blog = Blogs::find($id);

        $request->validate([
            'title' => 'required',
            'blog_category' => 'required',
            'content' => 'required',
            'status' => 'required|in:pending,approved,declined',
            'featured' => 'required',
        ]);

        $slugTitle = Str::slug($request->input("title"));
        $blog->slug = $slugTitle;
        $blog->user_id = Auth::user()->id;
        $blog->title = $request->input('title');
        $blog->blog_category = $request->input('blog_category');
        $blog->sub_category = $request->input('sub_category');
        $blog->content = $request->input('content');
        $blog->featured = $request->input('featured');

        if ($image = $request->file('image')) {
            $destinationPath = 'image/blog/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $blog['image'] = "$profileImage";
        }
        if ($thumbnail = $request->file('thumbnail')) {
            $destinationPath = 'thumbnail/blog/';
            $profileThumbnail = date('YmdHis') . "." . $thumbnail->getClientOriginalExtension();
            $thumbnail->move($destinationPath, $profileThumbnail);
            $blog['thumbnail'] = "$profileThumbnail";
        }

        $blog->update();
        session()->flash('message', 'blog updated');
        return redirect()->route('serviceProviderBlog.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $data = Blogs::findOrFail($id);
        $data->delete();
        Session()->flash('message', 'blogs has been deleted Successfully!');
        return redirect()->route('serviceProviderBlog.index');
    }
}
