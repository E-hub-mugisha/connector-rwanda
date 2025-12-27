<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobs = Job::where('status', 'open')->orderBy('created_at', 'desc')->get();
        return view('pages.jobs.index', compact('jobs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Find the job by ID
        $job = Job::findOrFail($id);
        // related jobs
        $relatedJobs = Job::where('company_id', '==', $job->company_id)->take(5)->get();

        return view('pages.jobs.show', compact('job', 'relatedJobs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function edit(Job $job)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Job $job)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job)
    {
        //
    }

    public function storeApplication(Request $request)
    {
        $request->validate([
            'cover_letter' => 'required|string|min:10',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'job_id' => 'required|exists:jobs,id',
        ]);

        $job = Job::findOrFail($request->job_id);

        // Check if user already applied
        $existing = JobApplication::where('job_id', $job->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existing) {
            Alert::error('error', 'You already applied for this job.');
            return redirect()->back();
        }

        $resumeFile = null;

        if ($request->hasFile('resume')) {
            $resumePath = $request->file('resume');
            $destinationPath = 'files/applications/';
            $fileName = date('YmdHis') . "." . $resumePath->getClientOriginalExtension();
            $resumePath->move(public_path($destinationPath), $fileName);

            $resumeFile = $destinationPath . $fileName;
        }

        JobApplication::create([
            'job_id'       => $job->id,
            'user_id'      => Auth::id(),
            'cover_letter' => $request->cover_letter,
            'resume'       => $resumeFile,   // null if no file
            'status'       => 'pending',
        ]);


        Alert::success('success', 'Application submitted successfully!');
        return back();
    }
}
