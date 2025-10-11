

<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>

<?php
    $labels = $revenueByServiceType->pluck('service_name')->toArray();
    $data = $revenueByServiceType->pluck('total_revenue')->toArray();
?>

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
                    <?php if(isset($sprovider)): ?>
                        <div class="btn-group">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo e(urlencode(route('home.service-provider_profile', ['sprovider_id' => $sprovider->id]))); ?>" target="_blank" class="btn btn-outline-dark btn-sm">
                                <i class="icon-facebook"></i> Facebook
                            </a>
                            <a href="https://www.instagram.com/?url=<?php echo e(urlencode(route('home.service-provider_profile', ['sprovider_id' => $sprovider->id]))); ?>" target="_blank" class="btn btn-outline-dark btn-sm">
                                <i class="icon-instagram"></i> Instagram
                            </a>
                            <a href="https://api.whatsapp.com/send?text=<?php echo e(urlencode('Check out my profile: ' . route('home.service-provider_profile', ['sprovider_id' => $sprovider->id]))); ?>" target="_blank" class="btn btn-success btn-sm text-white">
                                <i class="icon-whatsapp"></i> WhatsApp
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="overview">

                        <!-- Statistics Section -->
                        <div class="row mb-4">
                            <div class="col-sm-12">
                                <div class="statistics-details d-flex align-items-center justify-content-between flex-wrap">
                                    <div>
                                        <p class="statistics-title">Appointments</p>
                                        <h3 class="rate-percentage"><?php echo e(number_format($percentage, 2)); ?>%</h3>
                                    </div>
                                    <div>
                                        <p class="statistics-title">Total Services</p>
                                        <h3 class="rate-percentage"><?php echo e($totalService); ?></h3>
                                    </div>
                                    <div>
                                        <p class="statistics-title">Total Sales</p>
                                        <h3 class="rate-percentage"><?php echo e(number_format($totalAmount, 0, '.', ',')); ?> RWF</h3>
                                    </div>
                                    <div>
                                        <p class="statistics-title">Customer Satisfaction</p>
                                        <h3 class="rate-percentage"><?php echo e(number_format($percentageRating, 2)); ?>%</h3>
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
                                    <a href="<?php echo e(route('serviceProviderBooking.index')); ?>" class="btn btn-primary btn-lg">View All</a>
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
                                            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td>
                                                        <a href="<?php echo e(route('serviceProviderBooking.show', $order->id)); ?>" class="text-decoration-none">
                                                            <?php echo e($order->service->name ?? 'N/A'); ?>

                                                        </a>
                                                    </td>
                                                    <td><?php echo e($order->names); ?><br><small><?php echo e($order->email); ?></small></td>
                                                    <td><?php echo e($order->phone); ?><br><small><?php echo e($order->location); ?></small></td>
                                                    <td><?php echo e(\Carbon\Carbon::parse($order->date)->format('d M, Y')); ?><br><small><?php echo e($order->time); ?></small></td>
                                                    <td>
                                                        <span class="badge badge-opacity-<?php echo e($order->status == 'completed' ? 'success' : ($order->status == 'pending' ? 'warning' : ($order->status == 'approved' ? 'primary' : 'danger'))); ?>">
                                                            <?php echo e(ucfirst($order->status)); ?>

                                                        </span>
                                                    </td>
                                                    <td>
                                                        <a href="<?php echo e(route('serviceProviderBooking.show', $order->id)); ?>" class="btn btn-sm btn-success">
                                                            <i class="mdi mdi-eye"></i> View
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Profile Incomplete Modal -->
                        <?php if($showModal): ?>
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
                                            <a href="<?php echo e(route('sprovider.edit_profile')); ?>" class="btn btn-primary">Edit Profile</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-backdrop fade show"></div>
                        <?php endif; ?>

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
            labels: <?php echo json_encode($monthsPerformance, 15, 512) ?>,
            datasets: [{
                label: 'Monthly Revenue (RWF)',
                data: <?php echo json_encode($monthlyRevenueData, 15, 512) ?>,
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
            labels: <?php echo json_encode($labels, 15, 512) ?>,
            datasets: [{
                data: <?php echo json_encode($data, 15, 512) ?>,
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
    const ordersGraph = <?php echo json_encode($ordersGraph, 15, 512) ?>;
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
    const locationData = <?php echo json_encode($locationData, 15, 512) ?>;
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
            labels: <?php echo json_encode($monthsRevenue, 15, 512) ?>,
            datasets: <?php echo json_encode($datasets, 15, 512) ?>
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

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.staradmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\connector\git\hiletask\resources\views/stadmin/ServicePadminDashboard.blade.php ENDPATH**/ ?>