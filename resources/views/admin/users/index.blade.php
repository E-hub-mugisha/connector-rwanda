@extends('layouts.app')
@section('title','Users')
@section('content')

<div class="container">
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center py-3">
            <h6 class="m-0 font-weight-bold text-primary">Meet Our Users</h6>
        </div>
        <div class="card-body">
            @if(Session::has('message'))
            <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>UTYPE</th>
                            <th>Verified</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>
                                <img src="{{ $user->image ? asset('assets/images/sproviders/'.$user->image) : asset('assets/images/sproviders/avatar.jpg') }}" alt="{{ $user->name }}" width="50" class="rounded-circle">
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ ucfirst($user->utype) }}</td>
                            <td>
                                @if($user->email_verified_at || $user->is_verified)
                                    <span class="badge badge-success">Verified</span>
                                @else
                                    <span class="badge badge-secondary">Unverified</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" data-toggle="dropdown">
                                        Options
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('admin.activate', $user->id) }}" onclick="return confirm('Activate as Admin?');">
                                            <span class="badge badge-primary">Activate Admin</span>
                                        </a>
                                        <a class="dropdown-item" href="{{ route('customer.activate', $user->id) }}" onclick="return confirm('Activate as Customer?');">
                                            <span class="badge badge-success">Activate Customer</span>
                                        </a>
                                        <a class="dropdown-item" href="{{ route('provider.activate', $user->id) }}" onclick="return confirm('Activate as Provider?');">
                                            <span class="badge badge-warning">Activate Provider</span>
                                        </a>
                                        @if(!$user->email_verified_at && !$user->is_verified)
                                        <a href="#verifyModal{{ $user->id }}" class="dropdown-item text-info" data-toggle="modal">
                                            <span class="badge badge-info">Verify User</span>
                                        </a>
                                        @endif
                                        <form action="{{ route('users.delete', $user->id) }}" method="POST" onsubmit="return confirm('Delete this user?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <span class="badge badge-danger">Delete User</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal for each user -->
                        <div class="modal fade" id="verifyModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="verifyModalLabel{{ $user->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <form method="POST" action="{{ route('users.verify', $user->id) }}">
                                    @csrf
                                    <div class="modal-content">
                                        <div class="modal-header bg-info text-white">
                                            <h5 class="modal-title" id="verifyModalLabel{{ $user->id }}">Verify User</h5>
                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to verify <strong>{{ $user->name }}</strong>?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-info">Yes, Verify</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
