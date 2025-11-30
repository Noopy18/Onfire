<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrackLife - Habit Tracker</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="">TrackLife</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="">Features</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="">About</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<?= $content ?>

<!-- Footer -->
<footer class="bg-dark text-light py-4 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h5>Contact Us</h5>
                <p>Email: info@tracklife.com<br>
                    Phone: (555) 123-4567<br>
                    Address: 123 Habit Street, Wellness City</p>
            </div>
            <div class="col-md-6">
                <h5>Partner Organizations</h5>
                <ul class="list-unstyled">
                    <li>Health & Wellness Association</li>
                    <li>Productivity Masters</li>
                    <li>Mindfulness International</li>
                </ul>
            </div>
        </div>
        <hr>
        <p class="text-center mb-0">&copy; 2023 TrackLife. All rights reserved.</p>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>