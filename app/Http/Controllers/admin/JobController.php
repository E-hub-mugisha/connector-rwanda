<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::with('company', 'applications')->get();
        return view('admin.jobs.index', compact('jobs'));
    }

    public function updateStatus($id)
    {
        $job = Job::findOrFail($id);
        $job->status = request('status');
        $job->save();
        return back()->with('success', 'Job status updated successfully!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'type' => 'required|string|max:50',
            'requirements' => 'nullable|string',
            'responsibilities' => 'nullable|string',
            'company_id' => 'required|exists:service_providers,id',
            'deadline' => 'nullable|date|after:today',
        ]);

        Job::create($request->all());
        return back()->with('success', 'Job added successfully!');
    }

    public function update(Request $request, $id)
    {
        $job = Job::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'type' => 'required|string|max:50',
            'requirements' => 'nullable|string',
            'responsibilities' => 'nullable|string',
            'company_id' => 'required|exists:service_providers,id',
            'deadline' => 'nullable|date |after:today',
        ]);

        $job->update($request->all());
        return back()->with('success', 'Job updated successfully!');
    }

    public function destroy($id)
    {
        Job::destroy($id);
        return back()->with('success', 'Job deleted successfully!');
    }
}
