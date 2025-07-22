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
    <title>Contact | Trimatric Architects</title>
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

<div class="container main-content py-4">
    <div class="row mb-4">
        <div class="col-lg-7">
            <h1 class="main-title mb-3">Contact Us</h1>
            <p class="section-lead mb-4">
                Ready to discuss your project? Get in touch with Trimatric’s expert team today!
            </p>
            <form action="#" method="post" class="row g-3 bg-light p-3 rounded shadow-sm">
                <div class="col-md-6">
                    <label for="name" class="form-label">Name*</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email*</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="col-12">
                    <label for="message" class="form-label">Message*</label>
                    <textarea id="message" name="message" class="form-control" rows="4" required></textarea>
                </div>
                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary px-5">Send</button>
                </div>
            </form>
        </div>
        <div class="col-lg-5 mt-5 mt-lg-0">
            <div class="bg-white rounded p-4 shadow-sm h-100 contact-info-box">
                <h5 class="mb-3">Trimatric Architects & Engineers</h5>
                <p class="mb-2">
                    House 22, Road 3, Sector 13, Uttara, Dhaka, Bangladesh<br>
                    <i class="fa fa-envelope me-2"></i> info@trimatric.com<br>
                    <i class="fa fa-phone me-2"></i> +880 1611-229944
                </p>
                <div class="ratio ratio-16x9">
                    <!-- Placeholder for Google Map iframe -->
                    <iframe src="https://maps.google.com/maps?q=Trimatric%20Architects%20Uttara&t=&z=15&ie=UTF8&iwloc=&output=embed" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
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
