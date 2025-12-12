<?php require_once("navigation.php"); ?>

<style>
    :root {
        --primary-dark: #1a1a1a;
        --primary-light: #2d2d2d;
        --gold: #c6a972;
        --gold-light: #d8c092;
        --white: #ffffff;
        --gray-light: #f5f5f5;
        --transition: all 0.3s ease;
    }

    body {
        background-color: var(--primary-dark);
        color: var(--white);
        font-family: 'Montserrat', 'Helvetica Neue', Arial, sans-serif;
        overflow-x: hidden;
    }

    h2 {
        font-family: 'Playfair Display', Georgia, serif;
        font-weight: 600;
        color: var(--white);
    }

    .content-section {
        padding: 100px 0;
        position: relative;
    }

    .section-header {
        text-align: center;
        margin-bottom: 40px;
        position: relative;
    }

    .section-header h2 {
        font-size: 2.5rem;
        margin-bottom: 15px;
        display: inline-block;
        position: relative;
    }

    .section-header h2::after {
        content: '';
        position: absolute;
        bottom: -12px;
        left: 50%;
        transform: translateX(-50%);
        width: 70px;
        height: 3px;
        background: var(--gold);
    }

    .form-card {
        background: var(--primary-light);
        border: none;
        padding: 40px;
        border-radius: 0;
        box-shadow: 0 8px 25px rgba(0,0,0,0.35);
        transition: var(--transition);
    }

    .form-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.45);
    }

    label {
        font-weight: 500;
        font-size: 0.95rem;
        color: var(--gold-light);
        margin-bottom: 6px;
    }

    .form-control, .form-select {
        background: #2a2a2a;
        border: 1px solid #3a3a3a;
        color: var(--white);
        border-radius: 0;
        padding: 12px;
    }

    .form-control:focus, .form-select:focus {
        background: #333;
        border-color: var(--gold);
        outline: none;
        box-shadow: none;
        color: var(--white);
    }

    .btn-discover {
        display: inline-block;
        font-weight: 500;
        color: var(--primary-dark);
        background-color: var(--gold);
        padding: 14px 35px;
        text-transform: uppercase;
        letter-spacing: 1px;
        border: none;
        transition: var(--transition);
        position: relative;
        z-index: 1;
    }

    .btn-discover:hover {
        color: var(--primary-dark);
        background-color: var(--gold-light);
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-fade-in-up { animation: fadeInUp 0.8s ease forwards; }

    /* ✅ Success message styling */
    .enquiry-success {
        background: rgba(198, 169, 114, 0.15);
        border: 1px solid var(--gold);
        color: var(--gold-light);
        font-weight: 500;
        text-align: center;
        padding: 16px 25px;
        border-radius: 6px;
        margin: 20px auto 40px;
        max-width: 700px;
        letter-spacing: 0.4px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.25);
        animation: fadeInSmooth 0.8s ease forwards;
    }

    .success-icon {
        color: var(--gold);
        font-size: 1.3rem;
        margin-right: 8px;
    }

    @keyframes fadeInSmooth {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Auto-hide fade out */
    @keyframes fadeOutSmooth {
        from { opacity: 1; transform: translateY(0); }
        to { opacity: 0; transform: translateY(-10px); }
    }
</style>

<div class="container content-section">
    <div class="section-header animate-fade-in-up">
        <h2>Contact Us</h2>
        <p style="color: var(--gray-light); max-width:700px; margin:auto;">
            We’d love to hear from you. Fill in the details below and our team will get in touch shortly.
        </p>
    </div>

    <!-- ✅ Success message block -->
    <?php if (isset($_GET['success'])): ?>
        <div class="enquiry-success animate-fade-in-up" id="successMessage">
            <span class="success-icon">✔</span>
            Your enquiry has been submitted successfully! Our team will contact you soon.
        </div>
    <?php endif; ?>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="form-card animate-fade-in-up">
                <form method="POST" id="customer_form" enctype="multipart/form-data"
                      action="/acedecor/Admin/Controller/newenquiry.php">
                    
                    <div class="mb-4">
                        <label for="name">Full Name *</label>
                        <input type="text" name="name" id="name" class="form-control" required maxlength="150"
                               style="text-transform: capitalize;">
                        <input type="hidden" name="front" value="front">
                    </div>

                    <div class="mb-4">
                        <label for="phone">Phone *</label>
                        <input type="tel" name="phone" id="phone" class="form-control" required maxlength="10">
                    </div>

                    <div class="mb-4">
                        <label for="email">Email *</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>

                    <div class="mb-4">
                        <label for="address">Address *</label>
                        <input type="text" name="address" id="address" class="form-control" required maxlength="500">
                    </div>

                    <div class="mb-4">
                        <label for="selectedCountry">Country *</label>
                        <select id="selectedCountry" name="SelectCountry" class="form-select">
                            <option value="India">India</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label>Looking For</label>
                        <div id="checkboxes"></div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn-discover">Submit Enquiry</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const animatedElements = document.querySelectorAll('.animate-fade-in-up');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.visibility = 'visible';
                entry.target.classList.add('animate-fade-in-up');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });
    animatedElements.forEach(el => {
        el.style.visibility = 'hidden';
        observer.observe(el);
    });

    // Load enquiry categories dynamically
    fetch('../Admin/Controller/enqcategoryController.php')
        .then(response => response.json())
        .then(data => {
            const checkboxesDiv = document.getElementById('checkboxes');
            data.forEach(cat => {
                const wrapper = document.createElement('div');
                wrapper.className = 'form-check mb-2';
                const input = document.createElement('input');
                input.type = 'checkbox';
                input.className = 'form-check-input';
                input.name = 'interest_list[]';
                input.value = cat.CatId;
                input.id = 'cat_' + cat.CatId;
                const label = document.createElement('label');
                label.className = 'form-check-label';
                label.htmlFor = input.id;
                label.textContent = cat.catname;
                wrapper.appendChild(input);
                wrapper.appendChild(label);
                checkboxesDiv.appendChild(wrapper);
            });
        })
        .catch(() => {
            document.getElementById('checkboxes').innerHTML = '<em>Could not load categories.</em>';
        });

    // ✅ Auto-hide success message after 5 seconds
    const successMsg = document.getElementById('successMessage');
    if (successMsg) {
        setTimeout(() => {
            successMsg.style.animation = "fadeOutSmooth 0.8s ease forwards";
            setTimeout(() => successMsg.remove(), 800);
        }, 5000);
    }
});
</script>

<?php require_once("footer.php"); ?>
