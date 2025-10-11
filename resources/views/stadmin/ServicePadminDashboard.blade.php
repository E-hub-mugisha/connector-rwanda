@extends('layouts.staradmin')

@section('title', 'Dashboard')

@section('content')

@php
    $labels = $revenueByServiceType->pluck('service_name')->toArray();
    $data = $revenueByServiceType->pluck('total_revenue')->toArray();
@endphp

<div class="content-wrapper">
    <div class="row">
        <div class="col-sm-12">
            <div class="home-tab">

                <!-- Top Navigation with Share Buttons -->
                <div class="d-sm-flex align-items-center justify-content-between border-bottom mb-3">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active ps-0" data-bs-toggle="tab" href="#overview" role="tab">Overview</a>
                        </li>
                    </ul>
                    @if(isset($sprovider))
                        <div class="btn-group">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('home.service-provider_profile', ['sprovider_id' => $sprovider->id])) }}" target="_blank" class="btn btn-outline-dark btn-sm">
                                <i class="icon-facebook"></i> Facebook
                            </a>
                            <a href="https://www.instagram.com/?url={{ urlencode(route('home.service-provider_profile', ['sprovider_id' => $sprovider->id])) }}" target="_blank" class="btn btn-outline-dark btn-sm">
                                <i class="icon-instagram"></i> Instagram
                            </a>
                            <a href="https://api.whatsapp.com/send?text={{ urlencode('Check out my profile: ' . route('home.service-provider_profile', ['sprovider_id' => $sprovider->id])) }}" target="_blank" class="btn btn-success btn-sm text-white">
                                <i class="icon-whatsapp"></i> WhatsApp
                            </a>
                        </div>
                    @endif
                </div>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="overview">

                        <!-- Statistics Section -->
                        <div class="row mb-4">
                            <div class="col-sm-12">
                                <div class="statistics-details d-flex align-items-center justify-content-between flex-wrap">
                                    <div>
                                        <p class="statistics-title">Appointments</p>
                                        <h3 class="rate-percentage">{{ number_format($percentage, 2) }}%</h3>
                                    </div>
                                    <div>
                                        <p class="statistics-title">Total Services</p>
                                        <h3 class="rate-percentage">{{ $totalService }}</h3>
                                    </div>
                                    <div>
                                        <p class="statistics-title">Total Sales</p>
                                        <h3 class="rate-percentage">{{ number_format($totalAmount, 0, '.', ',') }} RWF</h3>
                                    </div>
                                    <div>
                                        <p class="statistics-title">Customer Satisfaction</p>
                                        <h3 class="rate-percentage">{{ number_format($percentageRating, 2) }}%</h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Charts Section -->
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="card card-rounded shadow-sm mb-4">
                                    <div class="card-body">
                                        <h4 class="card-title mb-3">Performance (Monthly Revenue)</h4>
                                        <canvas id="performanceLine"></canvas>
                                    </div>
                                </div>

                                <div class="card card-rounded shadow-sm">
                                    <div class="card-body">
                                        <h4 class="card-title mb-3">Revenue by Service Type</h4>
                                        <canvas id="revenuePieChart"></canvas>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="card text-white card-rounded shadow-sm mb-4">
                                    <div class="card-body">
                                        <h4 class="card-title">Service Bookings by Status</h4>
                                        <canvas id="bookingsChart"></canvas>
                                    </div>
                                </div>

                                <div class="card card-rounded shadow-sm">
                                    <div class="card-body">
                                        <h4 class="card-title">Service Bookings by Location</h4>
                                        <canvas id="locationChart"></canvas>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="card card-rounded shadow-sm mb-4">
                                    <div class="card-body">
                                        <h4 class="card-title mb-3">Monthly Revenue by Service</h4>
                                        <canvas id="serviceRevenueChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Table -->
                        <div class="card card-rounded shadow-sm mt-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h4 class="card-title mb-0">Pending Requests</h4>
                                    </div>
                                    <a href="{{ route('serviceProviderBooking.index') }}" class="btn btn-primary btn-lg">View All</a>
                                </div>

                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Service</th>
                                                <th>Names</th>
                                                <th>Contact</th>
                                                <th>When</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($orders as $order)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('serviceProviderBooking.show', $order->id) }}" class="text-decoration-none">
                                                            {{ $order->service->name ?? 'N/A' }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $order->names }}<br><small>{{ $order->email }}</small></td>
                                                    <td>{{ $order->phone }}<br><small>{{ $order->location }}</small></td>
                                                    <td>{{ \Carbon\Carbon::parse($order->date)->format('d M, Y') }}<br><small>{{ $order->time }}</small></td>
                                                    <td>
                                                        <span class="badge badge-opacity-{{ $order->status == 'completed' ? 'success' : ($order->status == 'pending' ? 'warning' : ($order->status == 'approved' ? 'primary' : 'danger')) }}">
                                                            {{ ucfirst($order->status) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('serviceProviderBooking.show', $order->id) }}" class="btn btn-sm btn-success">
                                                            <i class="mdi mdi-eye"></i> View
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Profile Incomplete Modal -->
                        @if($showModal)
                            <div class="modal fade show" id="profileIncompleteModal" tabindex="-1" role="dialog" aria-modal="true" style="display:block;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Profile Incomplete</h5>
                                        </div>
                                        <div class="modal-body">
                                            Your profile is incomplete. Please update your name and email to proceed.
                                        </div>
                                        <div class="modal-footer">
                                            <a href="{{ route('sprovider.edit_profile') }}" class="btn btn-primary">Edit Profile</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-backdrop fade show"></div>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Chart.js Integration -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Performance Line Chart - Monthly Revenue (Total)
    const performanceCtx = document.getElementById('performanceLine').getContext('2d');
    new Chart(performanceCtx, {
        type: 'line',
        data: {
            labels: @json($monthsPerformance),
            datasets: [{
                label: 'Monthly Revenue (RWF)',
                data: @json($monthlyRevenueData),
                borderColor: '#4BC0C0',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let value = context.parsed.y || 0;
                            return value.toLocaleString() + ' RWF';
                        }
                    }
                }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Revenue Pie Chart
    const revenueCtx = document.getElementById('revenuePieChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'pie',
        data: {
            labels: @json($labels),
            datasets: [{
                data: @json($data),
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40', '#2ecc71', '#f39c12', '#8e44ad', '#e74c3c']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            let label = context.label || '';
                            let value = context.parsed || 0;
                            return label + ': ' + value.toLocaleString() + ' RWF';
                        }
                    }
                }
            }
        }
    });

    // Bookings by Status Pie Chart
    const ordersGraph = @json($ordersGraph);
    const bookingsCtx = document.getElementById('bookingsChart').getContext('2d');
    new Chart(bookingsCtx, {
        type: 'pie',
        data: {
            labels: ordersGraph.map(o => o.status),
            datasets: [{
                data: ordersGraph.map(o => o.count),
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0']
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } }
        }
    });

    // Bookings by Location Bar Chart
    const locationData = @json($locationData);
    const locationCtx = document.getElementById('locationChart').getContext('2d');
    new Chart(locationCtx, {
        type: 'bar',
        data: {
            labels: locationData.map(l => l.location),
            datasets: [{
                label: 'Bookings',
                data: locationData.map(l => l.count),
                backgroundColor: '#36A2EB'
            }]
        },
        options: {
            responsive: true,
            scales: { y: { beginAtZero: true, precision: 0 } },
            plugins: { legend: { display: false } }
        }
    });

    // Monthly Revenue by Service (Stacked Bar Chart)
    const revenueServiceCtx = document.getElementById('serviceRevenueChart').getContext('2d');
    new Chart(revenueServiceCtx, {
        type: 'bar',
        data: {
            labels: @json($monthsRevenue),
            datasets: @json($datasets)
        },
        options: {
            responsive: true,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            let value = context.parsed.y || 0;
                            return context.dataset.label + ': ' + value.toLocaleString() + ' RWF';
                        }
                    }
                },
                legend: { position: 'top' }
            },
            scales: {
                x: { stacked: true },
                y: { stacked: true, beginAtZero: true }
            }
        }
    });

});
</script>

@endsection
