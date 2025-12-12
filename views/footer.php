<footer class="footer-section">
    <div class="container">
        <div class="row">
            <!-- About Us -->
            <!--<div class="col-lg-4 col-md-6 mb-5">
    <h5 class="footer-title">About Us</h5>
     <div class="footer-line"></div>
    <p class="footer-text">
        <?php 
            $string = strip_tags($business->getBusinessAboutBusiness());
            if (strlen($string) > 350) {
                $stringCut = substr($string, 0, 340);
                $endPoint = strrpos($stringCut, ' ');
                $string = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                $string .= '... <a href="about.php" class="footer-link">More</a>';
            }
            echo $string;
        ?>
    </p>
</div> -->


            <!-- Quick Links -->
            <div class="col-lg-2 col-md-6 mb-5">
                <h5 class="footer-title">Quick Links</h5>
                <div class="footer-line"></div>
                <ul class="footer-links">
                    <li><a href="/acedecor/">Home</a></li>
                    <li><a href="views/about">About</a></li>
                    <li><a href="views/contact">Contact</a></li>
                    <li><a href="views/termsandconditions">Terms & Conditions</a></li>
                    <li><a href="views/PrivacyPolicy">Privacy Policy</a></li>

                </ul>
            </div>

            <!-- Services -->
            <div class="col-lg-3 col-md-6 mb-5">
                <h5 class="footer-title">Follow Us</h5>
                <div class="footer-line"></div>
                <div class="footer-social">
                    <?php
                    foreach ($socialMediaHandles as $handle) {
                        echo '<a class="social-icon" href="' . $handle->getHandle() . '" target="_blank" title="' . $handle->getName() . '">' . $handle->getIcon() . '</a>';
                    }
                    ?>
                </div>
            </div>

            <!-- Contact & Social -->
            <div class="col-lg-3 col-md-6 mb-5">
                <h5 class="footer-title">Contact Us</h5>
                <div class="footer-line"></div>
                <p class="footer-text"><i class="far fa-envelope"></i> <?php echo $business->getBusinessEmail(); ?></p>
                <p class="footer-text"><i class="fas fa-phone-alt"></i> <?php echo $business->getBusinessContact(); ?>, <?php echo $business->getBusinessContact2(); ?></p>
                <p class="footer-text"><i class="fas fa-map-marker-alt"></i> <?php echo $business->getBusinessAddress(); ?></p>
                <a href="/acedecor/views/contact" class="btn-discover">Enquiry</a>
            </div>
        </div>

        <!-- Bottom Footer -->
        <div class="footer-bottom text-center">
            <p class="mt-3">&copy; <?php echo date("Y"); ?> <?php echo $business->getBusinessName(); ?>. All Rights Reserved | Website Designed By - 
                <span><a href="https://www.dharwadhubballitutor.com" style="text-decoration:none;">DharwadHubballiTutor</a></span>
            </p>
        </div>

    </div>
</footer>

<style>
    .btn-discover {
        display: inline-block;
        font-weight: 500;
        color: var(--primary-dark);
        background-color: var(--gold);
        text-align: center;
        vertical-align: middle;
        padding: 14px 32px;
        font-size: 1rem;
        border-radius: 0;
        text-decoration: none;
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        z-index: 1;
        border: none;
        letter-spacing: 1px;
        text-transform: uppercase;
        font-size: 0.9rem;
    }
    
    .btn-discover::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: var(--gold-light);
        transition: var(--transition);
        z-index: -1;
    }
    
    .btn-discover:hover {
        color: var(--primary-dark);
    }
    
    .btn-discover:hover::before {
        left: 0;
    }
    .footer-section {
        background-color: var(--primary-dark);
        color: var(--gray-light);
        padding: 80px 0 40px;
        font-family: 'Montserrat', sans-serif;
    }

    .footer-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 15px;
        color: var(--white);
    }

    .footer-line {
        width: 50px;
        height: 2px;
        background: var(--gold);
        margin-bottom: 20px;
    }

    .footer-text {
        font-size: 0.95rem;
        line-height: 1.7;
        color: var(--gray-light);
    }

    .footer-links {
        list-style: none;
        padding: 0;
    }

    .footer-links li {
        margin-bottom: 12px;
    }

    .footer-links a {
        color: var(--gray-light);
        text-decoration: none;
        transition: var(--transition);
    }

    .footer-links a:hover {
        color: var(--gold);
        padding-left: 5px;
    }

    .footer-social {
        margin-top: 15px;
    }

    .social-icon {
        display: inline-block;
        margin-right: 12px;
        font-size: 1.2rem;
        color: var(--white);
        transition: var(--transition);
    }

    .social-icon:hover {
        color: var(--gold);
        transform: scale(1.2);
    }

    .footer-bottom {
        margin-top: 40px;
        border-top: 1px solid rgba(255,255,255,0.1);
        padding-top: 20px;
    }

    .footer-logo {
        max-width: 160px;
        height: auto;
    }

    @media (max-width: 768px) {
        .footer-section {
            text-align: center;
        }
        .footer-social {
            margin-top: 20px;
        }
    }
</style>
