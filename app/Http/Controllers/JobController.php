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
    public function index(Request $request)
    {
        $query = Job::with([
            'serviceProvider',
        ]);

        /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    */
        if ($request->filled('query')) {

            $search = trim($request->query('query'));

            $query->where(function ($q) use ($search) {

                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('location', 'like', '%' . $search . '%')
                    ->orWhere('type', 'like', '%' . $search . '%')

                    ->orWhereHas('serviceProvider', function ($providerQuery) use ($search) {
                        $providerQuery->where(
                            'name',
                            'like',
                            '%' . $search . '%'
                        );
                    });
            });
        }

        /*
    |--------------------------------------------------------------------------
    | Sorting
    |--------------------------------------------------------------------------
    */
        switch ($request->query('sort')) {

            case 'deadline':

                $query->orderByRaw(
                    'CASE WHEN deadline IS NULL THEN 1 ELSE 0 END'
                )
                    ->orderBy('deadline', 'asc');

                break;

            case 'title':

                $query->orderBy('title', 'asc');

                break;

            case 'latest':
            default:

                $query->latest();

                break;
        }

        /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    */
        $jobs = $query
            ->paginate(12)
            ->withQueryString();

        return view(
            'pages.jobs.index',
            compact('jobs')
        );
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
        $job = Job::with('serviceProvider')->findOrFail($id);

        $relatedJobs = Job::with('serviceProvider')
            ->where('service_provider_id', $job->service_provider_id)
            ->where('id', '!=', $job->id)
            ->latest()
            ->take(5)
            ->get();

        return view('pages.jobs.show', compact('job', 'relatedJobs'));
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
