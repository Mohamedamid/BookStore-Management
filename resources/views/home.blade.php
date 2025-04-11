@extends('layouts.apps')

@section('content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <h2>Dashboard Overview</h2>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4">
        <!-- Total Users -->
        <div class="col-12 col-md-4">
            <div class="card stat-card">
                <div class="card-body">
                    <div>
                        <h5 class="card-title">Total Users</h5>
                        <p class="card-text" style="color: var(--primary-color)">1,250</p>
                    </div>
                    <div class="icon-container" style="background-color: rgba(98, 0, 234, 0.1)">
                        <i class="fas fa-users fa-2x" style="color: var(--primary-color)"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Events -->
        <div class="col-12 col-md-4">
            <div class="card stat-card">
                <div class="card-body">
                    <div>
                        <h5 class="card-title">Active Events</h5>
                        <p class="card-text text-success">24</p>
                    </div>
                    <div class="icon-container bg-success bg-opacity-10">
                        <i class="fas fa-calendar-alt fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Clubs Created -->
        <div class="col-12 col-md-4">
            <div class="card stat-card">
                <div class="card-body">
                    <div>
                        <h5 class="card-title">Clubs Created</h5>
                        <p class="card-text text-warning">78</p>
                    </div>
                    <div class="icon-container bg-warning bg-opacity-10">
                        <i class="fas fa-users fa-2x text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Recent Activities</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center border-0">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                                    <i class="fas fa-user-plus text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">New User Registration</h6>
                                    <small class="text-muted">John Smith joined the platform</small>
                                </div>
                            </div>
                            <small class="text-muted">Just now</small>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center border-0">
                            <div class="d-flex align-items-center">
                                <div class="bg-success bg-opacity-10 p-3 rounded-circle me-3">
                                    <i class="fas fa-calendar-plus text-success"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">New Event Created</h6>
                                    <small class="text-muted">Book Club Meeting scheduled for next week</small>
                                </div>
                            </div>
                            <small class="text-muted">2 hours ago</small>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center border-0">
                            <div class="d-flex align-items-center">
                                <div class="bg-warning bg-opacity-10 p-3 rounded-circle me-3">
                                    <i class="fas fa-users text-warning"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">New Club Created</h6>
                                    <small class="text-muted">Science Fiction Club was created</small>
                                </div>
                            </div>
                            <small class="text-muted">1 day ago</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
