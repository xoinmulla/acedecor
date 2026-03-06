<?php
include('header.php');  // Admin header
?>

<div class="container-fluid d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="access-denied-container text-center">
        <!-- Visual "Locked" Illustration -->
        

        <!-- Text Content -->
        <div class="glass-card p-5 shadow-lg">
            <h1 class="display-4 font-weight-bold text-dark-900 mb-2 text-danger">Access Denied</h1>
            <p class="lead text-gray-600 mb-4">
                Oops! It looks like you've reached a restricted area of the system.
            </p>

            <div class="alert alert-soft-danger d-inline-block px-4 py-2 rounded-pill mb-4">
                <i class="fas fa-exclamation-shield mr-2"></i>
                Permissions Required: <strong>Admin Level</strong>
            </div>

            <p class="text-gray-500 small mb-4">
                If you believe this is a mistake, please contact your system administrator <br>
                or try logging in with a different account.
            </p>

            <!-- Navigation Actions -->
            <div class="d-flex justify-content-center align-items-center">
                <a href="maindashboard.php" class="btn btn-primary btn-lg rounded-pill px-5 shadow hover-lift">
                    <i class="fas fa-arrow-left mr-2"></i> Return Home
                </a>
            </div>

            <div class="mt-4">
                <a href="mailto:support@yourcompany.com"
                    class="text-decoration-none small text-primary font-weight-bold">
                    <i class="fas fa-headset mr-1"></i> Contact Support
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    /* High-End Error Page Styling */
    .access-denied-container {
        max-width: 600px;
        width: 100%;
    }

    /* Error Code & Icon Animation */
    .error-code {
        font-size: 5rem;
        font-weight: 800;
        color: #e74a3b;
        letter-spacing: -2px;
        margin-top: -20px;
        position: relative;
    }

    .lock-wrapper {
        font-size: 4rem;
        position: relative;
        display: inline-block;
        z-index: 2;
    }

    .pulse-ring {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 100px;
        height: 100px;
        background-color: rgba(231, 74, 59, 0.1);
        border-radius: 50%;
        animation: pulse-animation 2s infinite;
        z-index: -1;
    }

    @keyframes pulse-animation {
        0% {
            transform: translate(-50%, -50%) scale(0.8);
            opacity: 0.8;
        }

        100% {
            transform: translate(-50%, -50%) scale(1.5);
            opacity: 0;
        }
    }

    /* Glassmorphism Card */
    .glass-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    /* Soft Danger Alert */
    .alert-soft-danger {
        background-color: #fff5f5;
        color: #e74a3b;
        border: 1px solid #fed7d7;
        font-size: 0.9rem;
    }

    /* Button Animations */
    .hover-lift {
        transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.2s;
    }

    .hover-lift:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(78, 115, 223, 0.2) !important;
    }

    /* Responsive adjustments */
    @media (max-width: 576px) {
        .error-code {
            font-size: 3.5rem;
        }

        .display-4 {
            font-size: 2.2rem;
        }
    }
</style>

<?php include('footer.php'); ?>