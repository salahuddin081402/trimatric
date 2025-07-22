<?php
// ho_dashboard.php

if (session_status() === PHP_SESSION_NONE) session_start();


// First check, logged in user_id is not available or role_type is not 'HO' . If so, 
// then sends back to login.php. Only Logged in Head office(HO) user can access this page.
if (!isset($_SESSION['user_id']) || ($_SESSION['role_type_name'] ?? '') !== 'HO') {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HO Dashboard | Trimatric Architects</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <!-- HO Menu CSS -->
    <link rel="stylesheet" href="css/menu_ho.css">
    <style>
        html, body {height: 100%;    
                    overflow-x: hidden; 
                    max-width: 100vw;
            }
        body {
            background: #f6fafd;
            min-height: 100vh;
        }
        .dashboard-cards .card {
            border-radius: 1rem;
        }
        .dashboard-cards .card-body {
            padding: 1.2rem 1.4rem;
        }
        .dashboard-cards .badge {
            font-size: 1.2rem;
        }
    </style>
</head>
<body>
<?php include 'include/header.php'; ?>
<?php include 'include/menu_ho.php'; ?>

<div class="container-fluid pt-4 px-3">
    <!-- Welcome Section -->
    <div class="row mb-4 align-items-center">
        <div class="col-md-8">
            <h2 class="fw-bold mb-2">
                <i class="fa fa-building-columns text-primary"></i>
                Head Office Dashboard
            </h2>
            <p class="text-muted">
                Welcome, <span class="fw-bold"><?= htmlspecialchars($_SESSION['user_name']) ?></span> (<?= htmlspecialchars($_SESSION['role_name']) ?>)
                <br>
                <span class="badge bg-gradient text-light">Role: <?= htmlspecialchars($_SESSION['role_type_name']) ?></span>
            </p>
        </div>
        <div class="col-md-4 text-md-end text-center">
            <img src="image/trimatric_logo.png" style="max-height:60px;" alt="Trimatric Logo" class="img-fluid rounded shadow-sm bg-white">
        </div>
    </div>

    <!-- Analytics / Cards Section -->
    <div class="row g-4 dashboard-cards">
        <!-- Projects Card -->
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <span class="badge rounded-circle bg-primary p-3 me-2">
                            <i class="fa fa-diagram-project fa-lg"></i>
                        </span>
                        <h5 class="mb-0">Projects</h5>
                    </div>
                    <h2 class="fw-bold">23</h2>
                    <span class="text-success"><i class="fa fa-arrow-up"></i> 4% this month</span>
                </div>
            </div>
        </div>
        <!-- Cluster Card -->
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <span class="badge rounded-circle bg-success p-3 me-2">
                            <i class="fa fa-cubes fa-lg"></i>
                        </span>
                        <h5 class="mb-0">Clusters</h5>
                    </div>
                    <h2 class="fw-bold">7</h2>
                    <span class="text-info"><i class="fa fa-arrow-right"></i> Stable</span>
                </div>
            </div>
        </div>
        <!-- Employees Card -->
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <span class="badge rounded-circle bg-warning p-3 me-2">
                            <i class="fa fa-users fa-lg"></i>
                        </span>
                        <h5 class="mb-0">Employees</h5>
                    </div>
                    <h2 class="fw-bold">35</h2>
                    <span class="text-secondary">+1 new today</span>
                </div>
            </div>
        </div>
        <!-- Clients Card -->
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <span class="badge rounded-circle bg-danger p-3 me-2">
                            <i class="fa fa-user-tie fa-lg"></i>
                        </span>
                        <h5 class="mb-0">Clients</h5>
                    </div>
                    <h2 class="fw-bold">16</h2>
                    <span class="text-success">Active</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity/Notifications -->
    <div class="row mt-5">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <i class="fa fa-bell"></i> Recent Activity
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Project <b>ABC</b> approved <span class="badge bg-success">1 hour ago</span></li>
                    <li class="list-group-item">New cluster <b>North Zone</b> added <span class="badge bg-info">2 days ago</span></li>
                    <li class="list-group-item">Employee <b>Rahim</b> joined <span class="badge bg-warning">Today</span></li>
                    <li class="list-group-item">Client feedback received <span class="badge bg-secondary">Yesterday</span></li>
                </ul>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-success text-white">
                    <i class="fa fa-chart-bar"></i> Quick Stats
                </div>
                <div class="card-body">
                    <p><b>Pending Requests:</b> 5</p>
                    <p><b>Open Projects:</b> 8</p>
                    <p><b>Unassigned Clusters:</b> 2</p>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include 'include/footer.php'; ?>

<!-- JS Scripts at bottom for fast loading -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
</body>
</html>
