<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\ServiceProvider;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $query = Job::with([
            'serviceProvider.user',
            'serviceProvider.category',
        ])->withCount('applications');

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */
        if ($request->filled('query')) {
            $search = trim($request->query('query'));

            $query->where(function ($q) use ($search) {

                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%")

                    ->orWhereHas('serviceProvider.user', function ($user) use ($search) {
                        $user->where('name', 'like', "%{$search}%");
                    });
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Status filter
        |--------------------------------------------------------------------------
        */
        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->query('status')
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Type filter
        |--------------------------------------------------------------------------
        */
        if ($request->filled('type')) {
            $query->where(
                'type',
                $request->query('type')
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Sorting
        |--------------------------------------------------------------------------
        */
        switch ($request->query('sort', 'latest')) {

            case 'oldest':
                $query->oldest();
                break;

            case 'deadline':
                $query->orderByRaw(
                    'CASE WHEN deadline IS NULL THEN 1 ELSE 0 END'
                );

                $query->orderBy('deadline', 'asc');
                break;

            case 'title':
                $query->orderBy('title', 'asc');
                break;

            default:
                $query->latest();
                break;
        }

        /*
        |--------------------------------------------------------------------------
        | Jobs
        |--------------------------------------------------------------------------
        */
        $jobs = $query
            ->paginate(15)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */
        $totalJobs = Job::count();

        $activeJobs = Job::where(
            'status',
            'active'
        )->count();

        $pendingJobs = Job::where(
            'status',
            'pending'
        )->count();

        $applications = JobApplication::count();

        /*
        |--------------------------------------------------------------------------
        | Service providers
        |
        | IMPORTANT:
        | ServiceProvider does NOT have a name column.
        | The name belongs to users.name.
        |--------------------------------------------------------------------------
        */
        $providers = ServiceProvider::with('user')
            ->whereHas('user')
            ->get()
            ->sortBy(function ($provider) {
                return strtolower(
                    $provider->user?->name ?? ''
                );
            })
            ->values();

        /*
        |--------------------------------------------------------------------------
        | Job types
        |--------------------------------------------------------------------------
        */
        $types = Job::whereNotNull('type')
            ->where('type', '!=', '')
            ->distinct()
            ->orderBy('type')
            ->pluck('type');

        return view(
            'admin.jobs.index',
            compact(
                'jobs',
                'providers',
                'types',
                'totalJobs',
                'activeJobs',
                'pendingJobs',
                'applications'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        $providers = ServiceProvider::with('user')
            ->whereHas('user')
            ->get()
            ->sortBy(function ($provider) {
                return strtolower(
                    $provider->user?->name ?? ''
                );
            })
            ->values();

        return view(
            'admin.jobs.create',
            compact('providers')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'required',
                'string',
            ],

            'location' => [
                'required',
                'string',
                'max:255',
            ],

            'type' => [
                'required',
                'string',
                'max:100',
            ],

            'requirements' => [
                'nullable',
                'string',
            ],

            'responsibilities' => [
                'nullable',
                'string',
            ],

            'service_provider_id' => [
                'required',
                'exists:service_providers,id',
            ],

            'deadline' => [
                'required',
                'date',
            ],

            'status' => [
                'required',
                'in:pending,active,closed,draft',
            ],
        ]);

        $job = Job::create($validated);

        return redirect()
            ->route(
                'admin.jobs.show',
                $job->id
            )
            ->with(
                'message',
                'Job created successfully.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Show
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $job = Job::with([
            'serviceProvider.user',
            'serviceProvider.category',
            'applications.user',
        ])
            ->withCount('applications')
            ->findOrFail($id);

        return view(
            'admin.jobs.show',
            compact('job')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $job = Job::with([
            'serviceProvider.user',
        ])->findOrFail($id);

        $providers = ServiceProvider::with('user')
            ->whereHas('user')
            ->get()
            ->sortBy(function ($provider) {
                return strtolower(
                    $provider->user?->name ?? ''
                );
            })
            ->values();

        return view(
            'admin.jobs.edit',
            compact(
                'job',
                'providers'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */
    public function update(
        Request $request,
        $id
    ) {
        $job = Job::findOrFail($id);

        $validated = $request->validate([

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'required',
                'string',
            ],

            'location' => [
                'required',
                'string',
                'max:255',
            ],

            'type' => [
                'required',
                'string',
                'max:100',
            ],

            'requirements' => [
                'nullable',
                'string',
            ],

            'responsibilities' => [
                'nullable',
                'string',
            ],

            'service_provider_id' => [
                'required',
                'exists:service_providers,id',
            ],

            'deadline' => [
                'required',
                'date',
            ],

            'status' => [
                'required',
                'in:pending,active,closed,draft',
            ],
        ]);

        $job->update($validated);

        return redirect()
            ->route(
                'admin.jobs.show',
                $job->id
            )
            ->with(
                'message',
                'Job updated successfully.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Update Status
    |--------------------------------------------------------------------------
    */
    public function updateStatus(
        Request $request,
        $id
    ) {
        $job = Job::findOrFail($id);

        $request->validate([
            'status' => [
                'required',
                'in:pending,active,closed,draft',
            ],
        ]);

        $job->update([
            'status' => $request->status,
        ]);

        return redirect()
            ->back()
            ->with(
                'message',
                'Job status updated successfully.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Delete
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $job = Job::findOrFail($id);

        /*
        | Delete applications first because applications
        | belong to the job.
        */
        $job->applications()->delete();

        $job->delete();

        return redirect()
            ->route('admin.jobs')
            ->with(
                'message',
                'Job deleted successfully.'
            );
    }
}