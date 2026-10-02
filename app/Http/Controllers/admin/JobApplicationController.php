<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function index($jobId)
    {
        $job = Job::with('serviceProvider')
            ->findOrFail($jobId);

        $applications = JobApplication::with('user')
            ->where('job_id', $job->id)
            ->latest()
            ->paginate(15);

        return view(
            'admin.jobs.applications',
            compact('job', 'applications')
        );
    }

    public function show($id)
    {
        $application = JobApplication::with([
            'job.serviceProvider',
            'user',
        ])->findOrFail($id);

        return view(
            'admin.jobs.application-show',
            compact('application')
        );
    }

    public function updateStatus(Request $request, $id)
    {
        $application = JobApplication::findOrFail($id);

        $request->validate([
            'status' => [
                'required',
                'in:pending,reviewed,shortlisted,accepted,rejected',
            ],
        ]);

        $application->update([
            'status' => $request->status,
        ]);

        return redirect()
            ->back()
            ->with(
                'message',
                'Application status updated successfully.'
            );
    }
}