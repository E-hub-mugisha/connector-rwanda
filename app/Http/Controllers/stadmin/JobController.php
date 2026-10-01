<?php

namespace App\Http\Controllers\stadmin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    // List all jobs posted by the company
    public function index()
    {
        $user = Auth::user();

        $sprovider = ServiceProvider::where('user_id', $user->id)
            ->firstOrFail();

        $baseQuery = Job::where(
            'service_provider_id',
            $sprovider->id
        );

        $stats = [
            'total' => (clone $baseQuery)->count(),

            'open' => (clone $baseQuery)
                ->where('status', 'open')
                ->count(),

            'closed' => (clone $baseQuery)
                ->where('status', 'closed')
                ->count(),

            'applications' => JobApplication::whereHas('job', function ($query) use ($sprovider) {
                $query->where(
                    'service_provider_id',
                    $sprovider->id
                );
            })->count(),
        ];

        $jobs = $baseQuery
            ->withCount('applications')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'stadmin.jobs.index',
            compact(
                'jobs',
                'sprovider',
                'stats'
            )
        );
    }

    public function show($id)
    {
        $user = Auth::user();

        $sprovider = ServiceProvider::where(
            'user_id',
            $user->id
        )->firstOrFail();

        $job = Job::where(
            'service_provider_id',
            $sprovider->id
        )
            ->with([
                'serviceProvider.user',
                'applications' => function ($query) {
                    $query->with('user')
                        ->latest('created_at');
                },
            ])
            ->withCount('applications')
            ->findOrFail($id);

        $applicationStats = [
            'total' => $job->applications_count,

            'pending' => $job->applications
                ->where('status', 'pending')
                ->count(),

            'shortlisted' => $job->applications
                ->where('status', 'shortlisted')
                ->count(),

            'accepted' => $job->applications
                ->where('status', 'accepted')
                ->count(),

            'rejected' => $job->applications
                ->where('status', 'rejected')
                ->count(),
        ];

        return view(
            'stadmin.jobs.show',
            compact(
                'job',
                'sprovider',
                'applicationStats'
            )
        );
    }

    // store a new job
    public function store(Request $request)
    {
        $company = ServiceProvider::where('user_id', Auth::id())->first();
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'type' => 'required|string|max:50',
            'requirements' => 'nullable|string',
            'responsibilities' => 'nullable|string',
            'deadline' => 'nullable|date|after:today',
        ]);

        Job::create(array_merge($request->all(), ['company_id' => $company->id]));

        return redirect()->route('provider.jobs.index')->with('success', 'Job posted successfully.');
    }
    // update an existing job
    public function update(Request $request, $id)
    {
        $company = ServiceProvider::where('user_id', Auth::id())->first();
        $job = Job::where('id', $id)->where('company_id', $company->id)->firstOrFail();
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'type' => 'required|string|max:50',
            'requirements' => 'nullable|string',
            'responsibilities' => 'nullable|string',
            'deadline' => 'nullable|date|after:today',
        ]);
        $job->update($request->all());
        return redirect()->route('provider.jobs.index')->with('success', 'Job updated successfully.');
    }

    // delete a job
    public function destroy($id)
    {
        $company = ServiceProvider::where('user_id', Auth::id())->first();
        $job = Job::where('id', $id)->where('company_id', $company->id)->firstOrFail();
        $job->delete();
        return redirect()->route('provider.jobs.index')->with('success', 'Job deleted successfully.');
    }

    // Show applicants for a specific job
    public function showApplicants(Job $job)
    {
        $job->load('applications.user');
        return view('stadmin.jobs.applications', compact('job'));
    }

    // Accept applicant
    public function acceptApplicant($id)
    {
        $application = JobApplication::findOrFail($id);
        $application->status = 'accepted';
        $application->save();

        return back()->with('success', 'Applicant accepted.');
    }

    // Reject applicant
    public function rejectApplicant($id)
    {
        $application = JobApplication::findOrFail($id);
        $application->status = 'rejected';
        $application->save();

        return back()->with('success', 'Applicant rejected.');
    }

    // Update job status (open/closed)
    public function updateStatus(Request $request, $id)
    {
        $company = ServiceProvider::where('user_id', Auth::id())->first();
        $job = Job::where('id', $id)->where('company_id', $company->id)->firstOrFail();
        $request->validate([
            'status' => 'required|in:open,closed',
        ]);
        $job->status = $request->status;
        $job->save();
        return redirect()->route('provider.jobs.index')->with('success', 'Job status updated successfully.');
    }
}
