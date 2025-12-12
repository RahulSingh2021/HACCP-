@extends('layouts.app1', ['pagetitle' => 'Dashboard'])
@section('content')

<style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2ecc71;
            --accent-color: #e74c3c;
            --light-color: #ecf0f1;
            --dark-color: #2c3e50;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            color: var(--dark-color);
        }
        
        .dashboard-header {
            background: linear-gradient(135deg, var(--primary-color), var(--dark-color));
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
            margin-bottom: 20px;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }
        
        .card-header {
            background-color: white;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            font-weight: 600;
            border-radius: 10px 10px 0 0 !important;
        }
        
        .stat-card {
            text-align: center;
            padding: 20px;
        }
        
        .stat-value {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
        }
        
        .stat-label {
            font-size: 1rem;
            color: #7f8c8d;
        }
        
        .progress {
            height: 10px;
            border-radius: 5px;
        }
        
        .trainer-card {
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .trainer-card.active {
            border-left: 5px solid var(--secondary-color);
            background-color: rgba(46, 204, 113, 0.05);
        }
        
        .filter-controls {
            background-color: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }
        
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }
        
        .badge-training {
            background-color: rgba(52, 152, 219, 0.2);
            color: var(--primary-color);
        }
        
        .trainer-stats {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }
        
        .trainer-stat {
            text-align: center;
            flex: 1;
        }
        
        .trainer-stat-value {
            font-weight: 600;
            color: var(--dark-color);
        }
        
        .trainer-stat-label {
            font-size: 0.75rem;
            color: #7f8c8d;
        }
        
        .trainer-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
        }
        
        .trainer-header {
            display: flex;
            align-items: center;
        }
        
        .trainer-name {
            flex: 1;
        }
        
        .rating {
            color: #f39c12;
        }
        
        .badge-certified {
            background-color: rgba(46, 204, 113, 0.1);
            color: var(--secondary-color);
            font-size: 0.7rem;
        }
        
        .badge-senior {
            background-color: rgba(155, 89, 182, 0.1);
            color: #9b59b6;
            font-size: 0.7rem;
        }
        
        .badge-junior {
            background-color: rgba(52, 152, 219, 0.1);
            color: var(--primary-color);
            font-size: 0.7rem;
        }
        
        .training-table tr {
            transition: background-color 0.2s;
        }
        
        .training-table tr:hover {
            background-color: rgba(52, 152, 219, 0.05);
        }
        
        .status-badge {
            font-size: 0.75rem;
            padding: 4px 8px;
            border-radius: 12px;
        }
        
        .export-btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 0.875rem;
            transition: all 0.3s;
        }
        
        .export-btn:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }
        
        .search-box {
            position: relative;
        }
        
        .search-box i {
            position: absolute;
            left: 12px;
            top: 10px;
            color: #7f8c8d;
        }
        
        .search-input {
            padding-left: 35px;
            border-radius: 20px;
            border: 1px solid #ddd;
        }
        
        .pagination .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .pagination .page-link {
            color: var(--primary-color);
        }
        
        .topic-card {
            border-left: 4px solid var(--primary-color);
        }
        
        .topic-progress {
            height: 8px;
            border-radius: 4px;
        }
        
        .topic-stats {
            display: flex;
            justify-content: space-between;
            margin-top: 8px;
        }
        
        .topic-stat {
            text-align: center;
            flex: 1;
        }
        
        .topic-stat-value {
            font-weight: 600;
            font-size: 1.1rem;
        }
        
        .topic-stat-label {
            font-size: 0.7rem;
            color: #7f8c8d;
        }
        
        .topic-badge {
            font-size: 0.7rem;
            padding: 3px 6px;
            border-radius: 10px;
        }
    </style>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    @include('admin.training.training_navbar')
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="training-types" role="tabpanel">
                                <div class="container-fluid py-4">
        <!-- Dashboard Header -->
        <div class="dashboard-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1><i class="fas fa-chalkboard-teacher me-2"></i> Training Tracker Dashboard</h1>
                    <p class="mb-0">Track and analyze training activities across your organization</p>
                </div>
                <div class="col-md-4 text-end">
                    <div class="dropdown d-inline-block me-2">
                        <button class="btn btn-light dropdown-toggle" type="button" id="timeRangeDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Last 30 Days
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="timeRangeDropdown">
                            <li><a class="dropdown-item" href="#">Last 7 Days</a></li>
                            <li><a class="dropdown-item" href="#">Last 30 Days</a></li>
                            <li><a class="dropdown-item" href="#">Last Quarter</a></li>
                            <li><a class="dropdown-item" href="#">Last Year</a></li>
                            <li><a class="dropdown-item" href="#">Custom Range</a></li>
                        </ul>
                    </div>
                    <button class="export-btn">
                        <i class="fas fa-download me-1"></i> Export
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Summary Stats -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card stat-card">
                    <div class="stat-value" id="totalEmployeesTrained">1,248</div>
                    <div class="stat-label">Total Employees Trained</div>
                    <div class="mt-3">
                        <span class="badge bg-success">+12%</span> from last period
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card">
                    <div class="stat-value" id="totalTrainingHours">586</div>
                    <div class="stat-label">Total Training Hours</div>
                    <div class="mt-3">
                        <span class="badge bg-warning text-dark">+5%</span> from last period
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card">
                    <div class="stat-value" id="totalTrainingsConducted">84</div>
                    <div class="stat-label">Trainings Conducted</div>
                    <div class="mt-3">
                        <span class="badge bg-success">+18%</span> from last period
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card">
                    <div class="stat-value" id="avgTrainingRating">4.6</div>
                    <div class="stat-label">Average Rating</div>
                    <div class="mt-3">
                        <div class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Filters and Main Content -->
        <div class="row">
            <!-- Trainer List -->
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Trainers</span>
                        <div>
                            <span class="badge bg-primary rounded-pill me-2">5 Active</span>
                            <span class="badge bg-secondary rounded-pill">2 Inactive</span>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="search-box p-3 border-bottom">
                            <i class="fas fa-search"></i>
                            <input type="text" class="form-control search-input" placeholder="Search trainers...">
                        </div>
                        <div class="list-group list-group-flush" id="trainerList">
                            <a href="#" class="list-group-item list-group-item-action trainer-card active" data-trainer-id="1">
                                <div class="trainer-header">
                                    <img src="https://randomuser.me/api/portraits/women/44.jpg" class="trainer-avatar" alt="Sarah Johnson">
                                    <div class="trainer-name">
                                        <h6 class="mb-1">Sarah Johnson</h6>
                                        <small class="text-muted">Lead Trainer</small>
                                    </div>
                                    <span class="badge badge-training">24</span>
                                </div>
                                <div class="d-flex mt-2">
                                    <span class="badge badge-certified me-1"><i class="fas fa-certificate me-1"></i>Certified</span>
                                    <span class="badge badge-senior"><i class="fas fa-star me-1"></i>Senior</span>
                                </div>
                                <div class="trainer-stats mt-2">
                                    <div class="trainer-stat">
                                        <div class="trainer-stat-value">428</div>
                                        <div class="trainer-stat-label">Trained</div>
                                    </div>
                                    <div class="trainer-stat">
                                        <div class="trainer-stat-value">192</div>
                                        <div class="trainer-stat-label">Hours</div>
                                    </div>
                                    <div class="trainer-stat">
                                        <div class="trainer-stat-value">4.7</div>
                                        <div class="trainer-stat-label">Rating</div>
                                    </div>
                                </div>
                                <div class="progress mt-2">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action trainer-card" data-trainer-id="2">
                                <div class="trainer-header">
                                    <img src="https://randomuser.me/api/portraits/men/32.jpg" class="trainer-avatar" alt="Michael Chen">
                                    <div class="trainer-name">
                                        <h6 class="mb-1">Michael Chen</h6>
                                        <small class="text-muted">Technical Trainer</small>
                                    </div>
                                    <span class="badge badge-training">18</span>
                                </div>
                                <div class="d-flex mt-2">
                                    <span class="badge badge-certified me-1"><i class="fas fa-certificate me-1"></i>Certified</span>
                                    <span class="badge badge-senior"><i class="fas fa-star me-1"></i>Senior</span>
                                </div>
                                <div class="trainer-stats mt-2">
                                    <div class="trainer-stat">
                                        <div class="trainer-stat-value">312</div>
                                        <div class="trainer-stat-label">Trained</div>
                                    </div>
                                    <div class="trainer-stat">
                                        <div class="trainer-stat-value">144</div>
                                        <div class="trainer-stat-label">Hours</div>
                                    </div>
                                    <div class="trainer-stat">
                                        <div class="trainer-stat-value">4.5</div>
                                        <div class="trainer-stat-label">Rating</div>
                                    </div>
                                </div>
                                <div class="progress mt-2">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 72%" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action trainer-card" data-trainer-id="3">
                                <div class="trainer-header">
                                    <img src="https://randomuser.me/api/portraits/men/75.jpg" class="trainer-avatar" alt="David Wilson">
                                    <div class="trainer-name">
                                        <h6 class="mb-1">David Wilson</h6>
                                        <small class="text-muted">Soft Skills Trainer</small>
                                    </div>
                                    <span class="badge badge-training">15</span>
                                </div>
                                <div class="d-flex mt-2">
                                    <span class="badge badge-certified me-1"><i class="fas fa-certificate me-1"></i>Certified</span>
                                </div>
                                <div class="trainer-stats mt-2">
                                    <div class="trainer-stat">
                                        <div class="trainer-stat-value">260</div>
                                        <div class="trainer-stat-label">Trained</div>
                                    </div>
                                    <div class="trainer-stat">
                                        <div class="trainer-stat-value">90</div>
                                        <div class="trainer-stat-label">Hours</div>
                                    </div>
                                    <div class="trainer-stat">
                                        <div class="trainer-stat-value">4.3</div>
                                        <div class="trainer-stat-label">Rating</div>
                                    </div>
                                </div>
                                <div class="progress mt-2">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action trainer-card" data-trainer-id="4">
                                <div class="trainer-header">
                                    <img src="https://randomuser.me/api/portraits/women/65.jpg" class="trainer-avatar" alt="Emily Rodriguez">
                                    <div class="trainer-name">
                                        <h6 class="mb-1">Emily Rodriguez</h6>
                                        <small class="text-muted">Compliance Trainer</small>
                                    </div>
                                    <span class="badge badge-training">12</span>
                                </div>
                                <div class="d-flex mt-2">
                                    <span class="badge badge-certified me-1"><i class="fas fa-certificate me-1"></i>Certified</span>
                                </div>
                                <div class="trainer-stats mt-2">
                                    <div class="trainer-stat">
                                        <div class="trainer-stat-value">180</div>
                                        <div class="trainer-stat-label">Trained</div>
                                    </div>
                                    <div class="trainer-stat">
                                        <div class="trainer-stat-value">48</div>
                                        <div class="trainer-stat-label">Hours</div>
                                    </div>
                                    <div class="trainer-stat">
                                        <div class="trainer-stat-value">4.8</div>
                                        <div class="trainer-stat-label">Rating</div>
                                    </div>
                                </div>
                                <div class="progress mt-2">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 58%" aria-valuenow="58" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action trainer-card" data-trainer-id="5">
                                <div class="trainer-header">
                                    <img src="https://randomuser.me/api/portraits/men/22.jpg" class="trainer-avatar" alt="James Peterson">
                                    <div class="trainer-name">
                                        <h6 class="mb-1">James Peterson</h6>
                                        <small class="text-muted">New Hire Trainer</small>
                                    </div>
                                    <span class="badge badge-training">9</span>
                                </div>
                                <div class="d-flex mt-2">
                                    <span class="badge badge-junior"><i class="fas fa-seedling me-1"></i>Junior</span>
                                </div>
                                <div class="trainer-stats mt-2">
                                    <div class="trainer-stat">
                                        <div class="trainer-stat-value">108</div>
                                        <div class="trainer-stat-label">Trained</div>
                                    </div>
                                    <div class="trainer-stat">
                                        <div class="trainer-stat-value">72</div>
                                        <div class="trainer-stat-label">Hours</div>
                                    </div>
                                    <div class="trainer-stat">
                                        <div class="trainer-stat-value">4.2</div>
                                        <div class="trainer-stat-label">Rating</div>
                                    </div>
                                </div>
                                <div class="progress mt-2">
                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 45%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        <button class="btn btn-sm btn-outline-primary w-100">
                            <i class="fas fa-plus me-1"></i> Add New Trainer
                        </button>
                    </div>
                </div>
                
                <div class="card mt-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Training Distribution</span>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="chartTypeDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-chart-pie"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="chartTypeDropdown">
                                <li><a class="dropdown-item" href="#" data-chart-type="doughnut"><i class="fas fa-chart-pie me-2"></i>Doughnut</a></li>
                                <li><a class="dropdown-item" href="#" data-chart-type="pie"><i class="fas fa-chart-pie me-2"></i>Pie</a></li>
                                <li><a class="dropdown-item" href="#" data-chart-type="bar"><i class="fas fa-chart-bar me-2"></i>Bar</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="trainingTypeChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-lg-9">
                <div class="filter-controls">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="departmentFilter" class="form-label">Department</label>
                            <select class="form-select" id="departmentFilter">
                                <option selected>All Departments</option>
                                <option>Sales</option>
                                <option>Marketing</option>
                                <option>Engineering</option>
                                <option>HR</option>
                                <option>Operations</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="trainingTypeFilter" class="form-label">Training Type</label>
                            <select class="form-select" id="trainingTypeFilter">
                                <option selected>All Types</option>
                                <option>Technical</option>
                                <option>Soft Skills</option>
                                <option>Compliance</option>
                                <option>Leadership</option>
                                <option>Onboarding</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="locationFilter" class="form-label">Location</label>
                            <select class="form-select" id="locationFilter">
                                <option selected>All Locations</option>
                                <option>Headquarters</option>
                                <option>North Office</option>
                                <option>East Office</option>
                                <option>Remote</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="statusFilter" class="form-label">Status</label>
                            <select class="form-select" id="statusFilter">
                                <option selected>All Statuses</option>
                                <option>Completed</option>
                                <option>Upcoming</option>
                                <option>In Progress</option>
                                <option>Cancelled</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <!-- Training Topic Tracker Section -->
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Training Topic Tracker</span>
                        <button class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-filter me-1"></i> Filter Topics
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="card topic-card h-100">
                                    <div class="card-body">
                                        <h6 class="card-title d-flex justify-content-between align-items-center">
                                            <span>Advanced Sales Techniques</span>
                                            <span class="badge bg-primary topic-badge">Sales</span>
                                        </h6>
                                        <div class="topic-stats">
                                            <div class="topic-stat">
                                                <div class="topic-stat-value">428</div>
                                                <div class="topic-stat-label">Trained</div>
                                            </div>
                                            <div class="topic-stat">
                                                <div class="topic-stat-value">96</div>
                                                <div class="topic-stat-label">Hours</div>
                                            </div>
                                            <div class="topic-stat">
                                                <div class="topic-stat-value">24</div>
                                                <div class="topic-stat-label">Sessions</div>
                                            </div>
                                        </div>
                                        <div class="progress topic-progress mt-2">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-2">
                                            <small class="text-muted">Last session: May 15, 2023</small>
                                            <div class="rating">
                                                <i class="fas fa-star"></i>
                                                <span>4.5</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="card topic-card h-100">
                                    <div class="card-body">
                                        <h6 class="card-title d-flex justify-content-between align-items-center">
                                            <span>Python for Data Analysis</span>
                                            <span class="badge bg-info topic-badge">Technical</span>
                                        </h6>
                                        <div class="topic-stats">
                                            <div class="topic-stat">
                                                <div class="topic-stat-value">312</div>
                                                <div class="topic-stat-label">Trained</div>
                                            </div>
                                            <div class="topic-stat">
                                                <div class="topic-stat-value">108</div>
                                                <div class="topic-stat-label">Hours</div>
                                            </div>
                                            <div class="topic-stat">
                                                <div class="topic-stat-value">18</div>
                                                <div class="topic-stat-label">Sessions</div>
                                            </div>
                                        </div>
                                        <div class="progress topic-progress mt-2">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 72%" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-2">
                                            <small class="text-muted">Last session: May 14, 2023</small>
                                            <div class="rating">
                                                <i class="fas fa-star"></i>
                                                <span>5.0</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="card topic-card h-100">
                                    <div class="card-body">
                                        <h6 class="card-title d-flex justify-content-between align-items-center">
                                            <span>Effective Communication</span>
                                            <span class="badge bg-warning text-dark topic-badge">Soft Skills</span>
                                        </h6>
                                        <div class="topic-stats">
                                            <div class="topic-stat">
                                                <div class="topic-stat-value">260</div>
                                                <div class="topic-stat-label">Trained</div>
                                            </div>
                                            <div class="topic-stat">
                                                <div class="topic-stat-value">45</div>
                                                <div class="topic-stat-label">Hours</div>
                                            </div>
                                            <div class="topic-stat">
                                                <div class="topic-stat-value">15</div>
                                                <div class="topic-stat-label">Sessions</div>
                                            </div>
                                        </div>
                                        <div class="progress topic-progress mt-2">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-2">
                                            <small class="text-muted">Last session: May 12, 2023</small>
                                            <div class="rating">
                                                <i class="fas fa-star"></i>
                                                <span>4.3</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="card topic-card h-100">
                                    <div class="card-body">
                                        <h6 class="card-title d-flex justify-content-between align-items-center">
                                            <span>Workplace Safety</span>
                                            <span class="badge bg-danger topic-badge">Compliance</span>
                                        </h6>
                                        <div class="topic-stats">
                                            <div class="topic-stat">
                                                <div class="topic-stat-value">180</div>
                                                <div class="topic-stat-label">Trained</div>
                                            </div>
                                            <div class="topic-stat">
                                                <div class="topic-stat-value">24</div>
                                                <div class="topic-stat-label">Hours</div>
                                            </div>
                                            <div class="topic-stat">
                                                <div class="topic-stat-value">12</div>
                                                <div class="topic-stat-label">Sessions</div>
                                            </div>
                                        </div>
                                        <div class="progress topic-progress mt-2">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 58%" aria-valuenow="58" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-2">
                                            <small class="text-muted">Last session: May 10, 2023</small>
                                            <div class="rating">
                                                <i class="fas fa-star"></i>
                                                <span>4.8</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="card topic-card h-100">
                                    <div class="card-body">
                                        <h6 class="card-title d-flex justify-content-between align-items-center">
                                            <span>New Hire Orientation</span>
                                            <span class="badge bg-secondary topic-badge">Onboarding</span>
                                        </h6>
                                        <div class="topic-stats">
                                            <div class="topic-stat">
                                                <div class="topic-stat-value">108</div>
                                                <div class="topic-stat-label">Trained</div>
                                            </div>
                                            <div class="topic-stat">
                                                <div class="topic-stat-value">72</div>
                                                <div class="topic-stat-label">Hours</div>
                                            </div>
                                            <div class="topic-stat">
                                                <div class="topic-stat-value">9</div>
                                                <div class="topic-stat-label">Sessions</div>
                                            </div>
                                        </div>
                                        <div class="progress topic-progress mt-2">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 45%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-2">
                                            <small class="text-muted">Last session: May 8, 2023</small>
                                            <div class="rating">
                                                <i class="fas fa-star"></i>
                                                <span>4.2</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="card topic-card h-100">
                                    <div class="card-body">
                                        <h6 class="card-title d-flex justify-content-between align-items-center">
                                            <span>Leadership Development</span>
                                            <span class="badge bg-success topic-badge">Leadership</span>
                                        </h6>
                                        <div class="topic-stats">
                                            <div class="topic-stat">
                                                <div class="topic-stat-value">84</div>
                                                <div class="topic-stat-label">Trained</div>
                                            </div>
                                            <div class="topic-stat">
                                                <div class="topic-stat-value">42</div>
                                                <div class="topic-stat-label">Hours</div>
                                            </div>
                                            <div class="topic-stat">
                                                <div class="topic-stat-value">6</div>
                                                <div class="topic-stat-label">Sessions</div>
                                            </div>
                                        </div>
                                        <div class="progress topic-progress mt-2">
                                            <div class="progress-bar bg-secondary" role="progressbar" style="width: 38%" aria-valuenow="38" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-2">
                                            <small class="text-muted">Last session: Apr 28, 2023</small>
                                            <div class="rating">
                                                <i class="fas fa-star"></i>
                                                <span>4.6</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-3">
                            <button class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-plus me-1"></i> View All Topics
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="card mt-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Recent Training Sessions</span>
                        <div>
                            <button class="btn btn-sm btn-outline-secondary me-2">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                            <button class="btn btn-sm btn-primary">
                                <i class="fas fa-plus me-1"></i> Add Session
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 training-table">
                                <thead class="table-light">
                                    <tr>
                                        <th>Date</th>
                                        <th>Trainer</th>
                                        <th>Training</th>
                                        <th>Duration</th>
                                        <th>Attendees</th>
                                        <th>Rating</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>May 15, 2023</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="https://randomuser.me/api/portraits/women/44.jpg" class="trainer-avatar me-2" alt="Sarah Johnson">
                                                Sarah Johnson
                                            </div>
                                        </td>
                                        <td>Advanced Sales Techniques</td>
                                        <td>4 hours</td>
                                        <td>24</td>
                                        <td>
                                            <div class="rating">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star-half-alt"></i>
                                                <span class="ms-1">4.5</span>
                                            </div>
                                        </td>
                                        <td><span class="status-badge bg-success">Completed</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-secondary">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>May 14, 2023</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="https://randomuser.me/api/portraits/men/32.jpg" class="trainer-avatar me-2" alt="Michael Chen">
                                                Michael Chen
                                            </div>
                                        </td>
                                        <td>Python for Data Analysis</td>
                                        <td>6 hours</td>
                                        <td>18</td>
                                        <td>
                                            <div class="rating">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <span class="ms-1">5.0</span>
                                            </div>
                                        </td>
                                        <td><span class="status-badge bg-success">Completed</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-secondary">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>May 12, 2023</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="https://randomuser.me/api/portraits/men/75.jpg" class="trainer-avatar me-2" alt="David Wilson">
                                                David Wilson
                                            </div>
                                        </td>
                                        <td>Effective Communication</td>
                                        <td>3 hours</td>
                                        <td>32</td>
                                        <td>
                                            <div class="rating">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <span class="ms-1">4.0</span>
                                            </div>
                                        </td>
                                        <td><span class="status-badge bg-success">Completed</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-secondary">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>May 10, 2023</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="https://randomuser.me/api/portraits/women/65.jpg" class="trainer-avatar me-2" alt="Emily Rodriguez">
                                                Emily Rodriguez
                                            </div>
                                        </td>
                                        <td>Workplace Safety</td>
                                        <td>2 hours</td>
                                        <td>45</td>
                                        <td>
                                            <div class="rating">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <span class="ms-1">5.0</span>
                                            </div>
                                        </td>
                                        <td><span class="status-badge bg-success">Completed</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-secondary">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>May 8, 2023</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="https://randomuser.me/api/portraits/men/22.jpg" class="trainer-avatar me-2" alt="James Peterson">
                                                James Peterson
                                            </div>
                                        </td>
                                        <td>New Hire Orientation</td>
                                        <td>8 hours</td>
                                        <td>12</td>
                                        <td>
                                            <div class="rating">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <span class="ms-1">4.0</span>
                                            </div>
                                        </td>
                                        <td><span class="status-badge bg-success">Completed</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-secondary">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center mb-0">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->
    </div>
    

<!-- Modal -->
@endsection
@section('footerscript')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn3.devexpress.com/jslib/19.1.8/js/dx.all.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/1.7.0/exceljs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.8/FileSaver.min.js"></script>

    <script>
        $( ".reserve-button" ).each(function(index) {
            $(this).on("click", function(){
                if($(this).val()=='1'){
                    $(this).val('0');
                } else {
                    $(this).val('1');
                }
                var training_status_id = $(this).data('id');
                var training_status_update = $(this).val();
                $.ajax
                ({ 
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url : "{{ route('training_status_update') }}",
                    data : {'id' : training_status_id, 'status' : training_status_update},
                    type : 'POST',
                    dataType : 'json',
                    success: function(result)
                    {
                        console.log(result); return false;
                    }
                });
            });
        });
    </script>
@endsection
