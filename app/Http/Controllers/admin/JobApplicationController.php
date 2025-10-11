<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function index($jobId)
    {
        $applications = JobApplication::where('job_id', $jobId)->with('user')->get();
        $job = $applications->first()->job ?? null;
        if (!$job) {
            return back()->with('error', 'Job not found.');
        }
        return view('admin.applications.index', compact('job'));
    }

    public function accept($id)
    {
        $app = JobApplication::findOrFail($id);
        $app->status = 'accepted';
        $app->save();
        return back()->with('success', 'Application accepted.');
    }

    public function reject($id)
    {
        $app = JobApplication::findOrFail($id);
        $app->status = 'rejected';
        $app->save();
        return back()->with('success', 'Application rejected.');
    }
}
