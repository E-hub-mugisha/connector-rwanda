@extends('layouts.staradmin')
@section('title', 'Job Applications')
@section('content')


<div class="content-wrapper">
    <div class="row">

        <h2>{{ $job->title ?? 'Unknown' }} Applications</h2>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="close" data-bs-dismiss="alert">&times;</button>
        </div>
        @endif

        <table class="table table-hover table-bordered mt-3">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Job</th>
                    <th>Applicant</th>
                    <th>Status</th>
                    <th>Applied On</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($job->applications as $app)
                <tr>
                    <td>{{ $app->id }}</td>
                    <td>{{ $app->job->title ?? 'N/A' }}</td>
                    <td>
                        @php
                        $provider = $app->user ? \App\Models\ServiceProvider::where('user_id', $app->user->id)->first() : null;
                        @endphp

                        @if($provider)
                        <a href="{{ route('home.service-provider_profile', $app->user->id) }}"
                            class="text-primary font-weight-bold"
                            title="View {{ $app->user->name }}'s provider profile">
                            <i class="fa fa-briefcase text-info mr-1"></i> {{ $app->user->name }}
                        </a>
                        @elseif($app->user)
                        <span class="text-dark">
                            <i class="fa fa-user mr-1 text-muted"></i> {{ $app->user->name }}
                        </span>
                        @else
                        <span class="text-muted">N/A</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge badge-{{ $app->status == 'pending' ? 'secondary' : ($app->status=='accepted' ? 'success' : 'danger') }}">
                            {{ ucfirst($app->status) }}
                        </span>
                    </td>
                    <td>{{ $app->created_at->format('d M Y') }}</td>
                    <td class="d-flex gap-1">
                        <!-- View Applicant Modal Trigger -->
                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewApplicantModal{{ $app->id }}">
                            <i class="fa fa-eye"></i>View
                        </button>

                        <!-- Accept/Reject -->
                        @if($app->status == 'pending')
                        <form action="{{ route('provider.applications.accept', $app->id) }}" method="POST" class="mr-1">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">
                                <i class="fa fa-check"></i>Accept
                            </button>
                        </form>

                        <form action="{{ route('provider.applications.reject', $app->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fa fa-times"></i> Reject
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>

                <!-- View Applicant Modal -->
                <div class="modal fade" id="viewApplicantModal{{ $app->id }}" tabindex="-1">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content shadow-lg border-0 rounded-lg">

                            <div class="modal-header" style="background: linear-gradient(135deg, #6c757d, #343a40); color: #fff;">
                                <h5 class="modal-title">
                                    <i class="fa fa-user mr-2"></i> Applicant - {{ $app->user->name ?? 'N/A' }}
                                </h5>
                                <button type="button" class="close text-white" data-bs-dismiss="modal">&times;</button>
                            </div>

                            <div class="modal-body">
                                <div class="mb-3">
                                    <h6><i class="fa fa-envelope mr-2"></i>Email</h6>
                                    <p class="border rounded p-2 bg-light">{{ $app->user->email ?? 'N/A' }}</p>
                                </div>
                                <div class="mb-3">
                                    <h6><i class="fa fa-file-alt mr-2"></i>Cover Letter</h6>
                                    <p class="border rounded p-2 bg-light">{{ $app->cover_letter }}</p>
                                </div>
                                <div class="mb-3">
                                    <h6><i class="fa fa-file-pdf mr-2"></i>Resume</h6>
                                    @if($app->resume)
                                    <a href="{{ asset($app->resume) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fa fa-download"></i> Download
                                    </a>
                                    @else
                                    <p>N/A</p>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <h6><i class="fa fa-briefcase mr-2"></i>Job Applied</h6>
                                    <p class="border rounded p-2 bg-light">{{ $app->job->title ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <div class="modal-footer border-top-0">
                                <button type="button" class="btn btn-secondary btn-sm rounded-pill" data-bs-dismiss="modal">
                                    <i class="fa fa-times mr-1"></i> Close
                                </button>
                            </div>

                        </div>
                    </div>
                </div>

                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">No applicants yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @endsection