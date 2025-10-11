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
        $company = ServiceProvider::where('user_id', Auth::id())->first();

        if (!$company) {
            // Optional: redirect with message if no company found
            return redirect()->back()->with('error', 'You have not set up your company profile yet.');
        }

        // Fetch jobs for this company
        $jobs = Job::with('applications.user')->where('company_id', $company->id)->get();

        return view('stadmin.jobs.index', compact('jobs'));
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
