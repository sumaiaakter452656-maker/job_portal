<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employer Dashboard · Jobs Portal</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body class="theme-employer">

<!-- ================= SIDEBAR ================= -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon"><i class="bi bi-briefcase-fill"></i></div>
        <div class="brand-text">Jobs<span>Portal</span><small class="brand-role">Employer</small></div>
        <button class="btn btn-sm text-white ms-auto d-lg-none" id="sidebarClose" aria-label="Close menu"><i class="bi bi-x-lg"></i></button>
    </div>

    <nav class="sidebar-menu">
        <div class="nav-section">Main</div>
        <a href="employer_dashboard.html" class="side-link active"><i class="bi bi-grid-1x2-fill"></i><span>Dashboard</span></a>
        <a href="#analytics" class="side-link"><i class="bi bi-graph-up-arrow"></i><span>Hiring Analytics</span></a>

        <div class="nav-section">Jobs</div>
        <a href="#post-job" class="side-link"><i class="bi bi-plus-square"></i><span>Post a Job</span></a>
        <a href="#my-jobs" class="side-link"><i class="bi bi-briefcase"></i><span>Manage Jobs</span>
            <em class="side-badge">128</em></a>
        <a href="#applicants" class="side-link"><i class="bi bi-people"></i><span>Applicants</span>
            <em class="side-badge">8 new</em></a>
        <a href="#applicants" class="side-link"><i class="bi bi-person-check"></i><span>Shortlisted</span></a>

        <div class="nav-section">Company</div>
        <a href="#company" class="side-link"><i class="bi bi-buildings"></i><span>Company Profile</span></a>

        <div class="nav-section">Billing</div>
        <a href="#subscription" class="side-link"><i class="bi bi-box-seam"></i><span>Packages</span></a>
        <a href="#subscription" class="side-link"><i class="bi bi-arrow-repeat"></i><span>My Subscription</span></a>
        <a href="#payments" class="side-link"><i class="bi bi-receipt"></i><span>Payment History</span></a>

        <div class="nav-section">Account</div>
        <a href="#" class="side-link"><i class="bi bi-bell"></i><span>Notifications</span>
            <em class="side-badge">4</em></a>
        <a href="#" class="side-link"><i class="bi bi-key"></i><span>Change Password</span></a>
        <a href="../index.html" class="side-link"><i class="bi bi-box-arrow-left"></i><span>Logout</span></a>
    </nav>

    <div class="sidebar-footer">
        <div class="upgrade-box">
            
                <h6><i class="bi bi-gem me-1"></i> Premium Plan</h6>
                <p>7 job post(s) left · 24 day(s) remaining</p>
                <a href="#subscription" class="btn btn-light btn-sm w-100">Upgrade Plan</a>
            
                <h6><i class="bi bi-gem me-1"></i> No active plan</h6>
                <p>Choose a package to start posting jobs.</p>
                <a href="#subscription" class="btn btn-light btn-sm w-100">View Packages</a>
            
        </div>
    </div>
</aside>
<div class="sidebar-overlay"></div>

<!-- ================= MAIN ================= -->
<div class="main">

    <header class="topbar">
        <button class="icon-btn" id="sidebarToggle" aria-label="Toggle menu"><i class="bi bi-list"></i></button>

        <div class="top-search">
            <i class="bi bi-search"></i>
            <input type="search" id="globalSearch" placeholder="Search jobs or applicants… (press Enter)">
        </div>

        <div class="topbar-right">
            <a href="#post-job" class="btn btn-accent btn-sm d-none d-md-inline-flex align-items-center gap-1"><i class="bi bi-plus-lg"></i> Post a Job</a>

            <div class="dropdown">
                <button class="icon-btn" data-bs-toggle="dropdown" aria-label="Notifications">
                    <i class="bi bi-bell"></i>
                    <span class="dot">4</span>
                </button>
                <div class="dropdown-menu dropdown-menu-end notif-menu">
                    <div class="notif-head"><strong>Notifications</strong><span class="tag tag-accent">4 new</span></div>
                    
                        <a href="#" class="notif-item Demo">
                            <span class="ico"><i class="bi bi-person-plus"></i></span>
                            <div><p>Your account has a new update.</p><small class="text-muted">2 hours ago</small></div>
                        </a>
                    
                        <div class="empty-state py-4"><i class="bi bi-bell-slash"></i>No notifications yet</div>
                    
                    <a href="#" class="d-block text-center py-2 small fw-semibold">View all</a>
                </div>
            </div>

            <div class="dropdown">
                <button class="user-chip" data-bs-toggle="dropdown">
                    <span class="avatar round avatar-accent">CO</span>
                    <span class="meta text-start d-none d-sm-block">
                        <span class="name d-block">Demo</span>
                        <span class="role">Admin User</span>
                    </span>
                    <i class="bi bi-chevron-down small text-muted d-none d-sm-block"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li class="px-3 py-2"><strong class="d-block">Admin User</strong><small class="text-muted">admin@example.com</small></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#company"><i class="bi bi-buildings"></i> Company Profile</a></li>
                    <li><a class="dropdown-item" href="#subscription"><i class="bi bi-gem"></i> My Subscription</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-key"></i> Change Password</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="../index.html"><i class="bi bi-box-arrow-right text-danger"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </header>

    <main class="content">

        
            <div class="alert alert-warning d-flex align-items-center gap-2 rounded-4 border-0 mb-4">
                <i class="bi bi-hourglass-split fs-5"></i>
                <div>Your employer account is <strong>pending approval</strong>. Jobs you post will go live once an admin approves your account.</div>
            </div>
        

        <!-- Hero -->
        <div class="hero-card mb-4 reveal" id="company">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        
                            <img src="Demo" alt="" class="avatar lg avatar-img">
                        
                            <span class="avatar lg" style="background:rgba(255,255,255,.2)">AD</span>
                        
                        <div>
                            <small style="opacity:.85"><span data-greeting>Hello</span>, Alex 👋</small>
                            <h2 class="mb-0">Demo</h2>
                        </div>
                    </div>
                    <p>
                        <i class="bi bi-geo-alt"></i> Dhaka
                         &nbsp;·&nbsp; <i class="bi bi-globe"></i> Demo
                        <br>You have <strong>8 new applicant(s)</strong> waiting for review and <strong>Demo</strong> live job(s).
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="#post-job" class="btn btn-hero"><i class="bi bi-plus-lg me-1"></i> Post a New Job</a>
                        <a href="#applicants" class="btn btn-hero-outline"><i class="bi bi-people me-1"></i> Review Applicants</a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="row g-2 text-center">
                        <div class="col-6"><div class="p-3 rounded-4" style="background:rgba(255,255,255,.14)"><div class="fs-4 fw-bold">Demo</div><small style="opacity:.85">Hired</small></div></div>
                        <div class="col-6"><div class="p-3 rounded-4" style="background:rgba(255,255,255,.14)"><div class="fs-4 fw-bold">12</div><small style="opacity:.85">Pending Jobs</small></div></div>
                        <div class="col-12"><div class="p-3 rounded-4" style="background:rgba(255,255,255,.14)"><div class="fs-5 fw-bold">৳2,500</div><small style="opacity:.85">Total spent on packages</small></div></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="row g-3 g-xl-4 mb-4">
            <div class="col-6 col-xl-3 reveal">
                <div class="stat-card tone-blue">
                    <div class="stat-top">
                        <div><div class="stat-label">Posted Jobs</div><div class="stat-value" data-count="128">0</div></div>
                        <div class="stat-icon"><i class="bi bi-briefcase-fill"></i></div>
                    </div>
                    <div class="stat-foot"><span class="trend-warn">12</span> awaiting approval</div>
                </div>
            </div>
            <div class="col-6 col-xl-3 reveal">
                <div class="stat-card tone-green">
                    <div class="stat-top">
                        <div><div class="stat-label">Active Jobs</div><div class="stat-value" data-count="Demo">0</div></div>
                        <div class="stat-icon"><i class="bi bi-broadcast"></i></div>
                    </div>
                    <div class="stat-foot">Approved &amp; before deadline</div>
                </div>
            </div>
            <div class="col-6 col-xl-3 reveal">
                <div class="stat-card tone-purple">
                    <div class="stat-top">
                        <div><div class="stat-label">Total Applicants</div><div class="stat-value" data-count="3580">0</div></div>
                        <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
                    </div>
                    <div class="stat-foot"><span class="trend-up"><i class="bi bi-arrow-up-right"></i> 8</span> new, not reviewed</div>
                </div>
            </div>
            <div class="col-6 col-xl-3 reveal">
                <div class="stat-card tone-orange">
                    <div class="stat-top">
                        <div><div class="stat-label">Shortlisted</div><div class="stat-value" data-count="Demo">0</div></div>
                        <div class="stat-icon"><i class="bi bi-person-check-fill"></i></div>
                    </div>
                    <div class="stat-foot">Shortlisted &amp; interview stage</div>
                </div>
            </div>
        </div>

        <!-- Analytics -->
        <div class="row g-3 g-xl-4 mb-4" id="analytics">
            <div class="col-xl-5 reveal">
                <div class="card-x">
                    <div class="card-x-head">
                        <div><h5>Applications Received</h5><p>Last 6 months</p></div>
                        <div class="chart-legend"><span><i style="background:#10b981"></i>Applications</span></div>
                    </div>
                    <div class="card-x-body">
                        <div class="bar-chart" data-labels='["Jun","Jul","Aug","Sep","Oct","Nov"]' data-series='[{"name":"Applications","color":"#6366f1","values":[12,18,15,25,22,31]},{"name":"New Registrations","color":"#22d3ee","values":[6,9,8,13,11,17]}]'></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3 reveal">
                <div class="card-x">
                    <div class="card-x-head"><div><h5>Hiring Funnel</h5><p>Applicant status</p></div></div>
                    <div class="card-x-body">
                        <div class="donut-wrap">
                            <div class="donut" style="width:160px;height:160px" data-segments='[{"label":"Applied","value":38,"color":"#f59e0b"},{"label":"Viewed","value":20,"color":"#06b6d4"},{"label":"Shortlisted","value":15,"color":"#3b82f6"},{"label":"Interview","value":10,"color":"#8b5cf6"},{"label":"Hired","value":7,"color":"#10b981"},{"label":"Rejected","value":10,"color":"#ef4444"}]' data-legend="#empLegend">
                                <div class="donut-center"><div><strong>3580</strong><small>Applicants</small></div></div>
                            </div>
                            <div class="donut-legend" id="empLegend"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-4 reveal" id="subscription">
                <div class="sub-card">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <div class="muted">Current Plan</div>
                            <h4 class="fw-bold mb-0 text-white">Premium</h4>
                        </div>
                        <span class="badge-soft Demo">Demo</span>
                    </div>
                    
                        <div class="d-flex justify-content-between small mb-2">
                            <span class="muted">Job posts used</span><strong>3 / 5</strong>
                        </div>
                        <div class="progress mb-3"><div class="progress-bar" data-width="45"></div></div>
                        <div class="row g-2 text-center mb-3">
                            <div class="col-4"><div class="fw-bold fs-5">7</div><div class="muted">Posts left</div></div>
                            <div class="col-4"><div class="fw-bold fs-5">24</div><div class="muted">Days left</div></div>
                            <div class="col-4"><div class="fw-bold fs-5">৳2,500</div><div class="muted">Price</div></div>
                        </div>
                        <div class="muted mb-3"><i class="bi bi-calendar-event"></i> 20 Nov 2026 – 20 Nov 2026</div>
                    
                        <p class="muted mb-3">Subscribe to a package to start posting jobs and reach thousands of job seekers.</p>
                    
                    <div class="d-flex flex-wrap gap-2">
                        
                            <span class="tag" style="background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.12);color:#e2e8f0">
                                Sample User · ৳2,500
                            </span>
                        
                    </div>
                    <a href="#" class="btn btn-accent w-100 mt-3"><i class="bi bi-gem me-1"></i> Demo</a>
                </div>
            </div>
        </div>

        <!-- My jobs -->
        <div class="card-x mb-4 reveal" id="my-jobs" style="height:auto">
            <div class="card-x-head">
                <div><h5>My Job Posts</h5><p>Manage your listings and see how they perform</p></div>
                <div class="table-tools">
                    <select class="form-select form-select-sm" style="width:auto" data-status-filter="#myJobsTable">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                        <option value="closed">Closed</option>
                    </select>
                    <div class="table-search d-none d-sm-block"><i class="bi bi-search"></i><input type="search" placeholder="Search jobs…" data-table-filter="#myJobsTable"></div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-modern" id="myJobsTable">
                    <thead><tr><th>Job Title</th><th>Type</th><th>Salary</th><th>Applicants</th><th>Deadline</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
                    <tbody>
                    
                        <tr data-status="approved">
                            <td>
                                <div class="t fw-bold">Frontend Developer
                                    <span class="tag tag-featured ms-1"><i class="bi bi-star-fill"></i> Featured</span>
                                </div>
                                <small class="text-muted">Technology · <i class="bi bi-geo-alt"></i> Dhaka</small>
                            </td>
                            <td><span class="tag tag-accent">Full Time</span></td>
                            <td class="text-nowrap small fw-semibold">৳30,000 – ৳50,000</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <strong>24</strong>
                                    <small class="text-muted text-nowrap">(Demo shortlisted)</small>
                                </div>
                            </td>
                            <td class="text-nowrap">
                                20 Nov 2026
                                <br><small class="text-danger">Expired</small>
                            </td>
                            <td><span class="tag tag-success">Approved</span></td>
                            <td class="text-end text-nowrap">
                                <a href="#" class="action-btn" data-bs-toggle="tooltip" title="View applicants"><i class="bi bi-people"></i></a>
                                <a href="#" class="action-btn" data-bs-toggle="tooltip" title="Edit"><i class="bi bi-pencil"></i></a>
                            </td>
                        </tr>
                    
                        <tr class="no-filter"><td colspan="7"><div class="empty-state"><i class="bi bi-briefcase"></i>You haven't posted any job yet.<br><a href="#post-job" class="fw-semibold">Post your first job</a></div></td></tr>
                    
                    </tbody>
                </table>
            </div>
            <div class="card-x-foot"><a href="#">Manage all jobs <i class="bi bi-arrow-right"></i></a></div>
        </div>

        <!-- Applicants + payments -->
        <div class="row g-3 g-xl-4 mb-4">
            <div class="col-xl-7 reveal" id="applicants">
                <div class="card-x">
                    <div class="card-x-head">
                        <div><h5>Recent Applicants</h5><p>Candidates who applied to your jobs</p></div>
                        <div class="table-search"><i class="bi bi-search"></i><input type="search" placeholder="Search candidate…" data-table-filter="#applicantsTable"></div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-modern" id="applicantsTable">
                            <thead><tr><th>Candidate</th><th>Applied For</th><th>Status</th><th class="text-end">CV</th></tr></thead>
                            <tbody>
                            
                                <tr>
                                    <td>
                                        <div class="cell-main">
                                            <span class="avatar round avatar-blue">AD</span>
                                            <div>
                                                <div class="t">Mahmudul Alam</div>
                                                <div class="s">Web Developer · 3 yrsDemo</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><div class="fw-semibold small">Frontend Developer</div><small class="text-muted">2 hours ago</small></td>
                                    <td><span class="tag tag-success">Approved</span></td>
                                    <td class="text-end text-nowrap">
                                        <a href="#" target="_blank" class="action-btn" data-bs-toggle="tooltip" title="Download CV"><i class="bi bi-file-earmark-arrow-down"></i></a>
                                        <a href="mailto:candidate@example.com" class="action-btn" data-bs-toggle="tooltip" title="Email"><i class="bi bi-envelope"></i></a>
                                    </td>
                                </tr>
                            
                                <tr class="no-filter"><td colspan="4"><div class="empty-state"><i class="bi bi-people"></i>No applicants yet</div></td></tr>
                            
                            </tbody>
                        </table>
                    </div>
                    <div class="card-x-foot"><a href="#">View all applicants <i class="bi bi-arrow-right"></i></a></div>
                </div>
            </div>

            <div class="col-xl-5 reveal" id="payments">
                <div class="card-x">
                    <div class="card-x-head"><div><h5>Payment History</h5><p>Your package purchases</p></div><span class="tag tag-accent">Spent ৳2,500</span></div>
                    <ul class="list-x">
                        
                            <li>
                                <span class="avatar sm avatar-accent"><i class="bi bi-receipt"></i></span>
                                <div class="info">
                                    <div class="t">#INV-1024 · Premium</div>
                                    <div class="s">bKashDemo</div>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold small">৳2,500</div>
                                    <span class="tag tag-success">Approved</span>
                                </div>
                            </li>
                        
                            <li class="d-block"><div class="empty-state"><i class="bi bi-receipt"></i>No payments yet</div></li>
                        
                    </ul>
                    <div class="card-x-foot"><a href="#">Full payment history <i class="bi bi-arrow-right"></i></a></div>
                </div>
            </div>
        </div>

        <!-- Post a job (design only) -->
        <div class="card-x mb-2 reveal" id="post-job" style="height:auto">
            <div class="card-x-head">
                <div><h5>Post a New Job</h5><p>7</p></div>
                <span class="tag tag-accent"><i class="bi bi-info-circle"></i> Jobs are reviewed by admin before going live</span>
            </div>
            <div class="card-x-body">
                <form data-demo="Job post form ready (design preview)" novalidate>
                    <div class="row g-3">
                        <div class="col-lg-8">
                            <label class="form-label">Job Title <span class="text-danger">*</span></label>
                            <div class="input-icon"><i class="bi bi-briefcase"></i><input type="text" class="form-control" placeholder="e.g. Senior Laravel Developer" required></div>
                            <div class="invalid-feedback">Job title is required.</div>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label">Job Type <span class="text-danger">*</span></label>
                            <div class="input-icon"><i class="bi bi-clock"></i>
                                <select class="form-select" required>
                                    <option value="Demo">Full Time</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <label class="form-label">Category</label>
                            <div class="input-icon"><i class="bi bi-tag"></i>
                                <select class="form-select" required>
                                    <option value="">Select</option>
                                    <option value="Demo">Sample User</option>
                                </select>
                            </div>
                            <div class="invalid-feedback">Choose a category.</div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <label class="form-label">City</label>
                            <div class="input-icon"><i class="bi bi-geo-alt"></i>
                                <select class="form-select" required>
                                    <option value="">Select</option>
                                    <option value="Demo">Sample User</option>
                                </select>
                            </div>
                            <div class="invalid-feedback">Choose a city.</div>
                        </div>
                        <div class="col-md-4 col-lg-2">
                            <label class="form-label">Min Salary (৳)</label>
                            <input type="number" min="0" class="form-control" placeholder="30000">
                        </div>
                        <div class="col-md-4 col-lg-2">
                            <label class="form-label">Max Salary (৳)</label>
                            <input type="number" min="0" class="form-control" placeholder="50000">
                        </div>
                        <div class="col-md-4 col-lg-2">
                            <label class="form-label">Deadline <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" min="Demo" required>
                            <div class="invalid-feedback">Set a deadline.</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Job Description</label>
                            <textarea class="form-control" rows="4" placeholder="Responsibilities, requirements, benefits…"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Required Skills</label>
                            <div class="d-flex flex-wrap gap-2">
                                
                                    <input type="checkbox" class="btn-check" id="skDemo" autocomplete="off">
                                    <label class="btn btn-white btn-sm" for="skDemo">Sample User</label>
                                
                                <span class="text-muted small">No skills found</span>
                            </div>
                        </div>
                        <div class="col-12 d-flex flex-wrap justify-content-between align-items-center gap-3 pt-2">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="featuredSwitch" Premium>
                                <label class="form-check-label small" for="featuredSwitch">Mark as <strong>Featured</strong> <span class="text-muted">(Premium plan)</span></label>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="reset" class="btn btn-white">Clear</button>
                                <button type="submit" class="btn btn-accent"><i class="bi bi-send me-1"></i> Submit for Review</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <footer class="footer">
        <span>© <span id="year">2026</span> Jobs Portal. All rights reserved.</span>
        <span>Employer Panel · v1.0</span>
    </footer>
</div>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="appToast" class="toast toast-x" role="status" aria-live="polite">
        <div class="toast-body"><i class="bi bi-check-circle-fill"></i><span class="toast-msg">Saved</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="toast" aria-label="Close"></button></div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/script.js"></script>
</body>
</html>
