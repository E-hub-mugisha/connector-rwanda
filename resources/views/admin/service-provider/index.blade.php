@extends('layouts.app')

@section('title', 'Service Provider')

@section('content')

<div class="container">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Service Provider</h1>
        <a href="{{ route('admin.AddServiceProviders') }}" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Add Service Provider
        </a>
    </div>

    <!-- DataTable Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Our Service Providers</h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">

                @if(Session::has('message'))
                    <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
                @endif

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Phone</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($sproviders as $sprovider)
                            <tr>
                                <td>{{ $sprovider->id }}</td>
                                <td>
                                    <img src="{{ $sprovider->image 
                                                ? asset('image/profile/' . $sprovider->image) 
                                                : asset('assets/images/sproviders/avatar.jpg') }}" 
                                        alt="{{ $sprovider->user->name ?? 'Service Provider' }}" 
                                        width="60" height="50" 
                                        class="rounded" style="object-fit: cover;">
                                </td>
                                <td>{{ $sprovider->user->name ?? 'Unknown' }}</td>
                                <td>{{ $sprovider->category->name ?? 'No Category' }}</td>
                                <td>{{ $sprovider->user->phone ?? 'N/A' }}</td>
                                <td>{{ $sprovider->service_locations ?? 'N/A' }}</td>
                                <td>
                                    @if($sprovider->status === 'active')
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-secondary">{{ ucfirst($sprovider->status) }}</span>
                                    @endif
                                </td>
                                <td>{{ $sprovider->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <a class="btn btn-sm badge-info" 
                                       href="{{ route('admin.ShowServiceProviders', $sprovider->id) }}">
                                        Show
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    
                </table>

            </div>
        </div>
    </div>

</div>

@endsection
