<?php require_once("navigation.php"); ?>
<?php require_once("slider.php"); ?>
<?php
require_once __DIR__ . "/../cmsadmin/dblayer/dbconnection.php";
require_once __DIR__ . "/../cmsadmin/dblayer/contentOps.php";
require_once __DIR__ . "/../cmsadmin/dblayer/brandOps.php";
require_once __DIR__ . "/../cmsadmin/dblayer/brandSectionOps.php";

$brands = DBbrand::getAll();
$section = DBbrandSection::get();

$maincontent = DBcontent::getLatestContent(type: "main");
$postcontent = DBcontent::getLatestContent(type: "post");
$allContents = DBcontent::getAll();
?>
<style>
    /* =========================================================
   ACE DECORS - LUXURY BRANDS CAROUSEL
   ========================================================= */

    .ace-brands-section {
        position: relative;
        width: 100%;
        padding: 110px 0 120px;
        overflow: hidden;
        text-align: center;
        background:
            radial-gradient(circle at center,
                rgba(198, 169, 114, 0.07) 0%,
                transparent 42%),
            #1a1a1a;
    }

    /* Decorative top line */
    .ace-brands-section::before {
        content: "";
        position: absolute;
        top: 0;
        left: 50%;
        width: 180px;
        height: 1px;
        transform: translateX(-50%);
        background: linear-gradient(90deg,
                transparent,
                var(--gold),
                transparent);
    }

    /* Background decorative circle */
    .ace-brands-section::after {
        content: "";
        position: absolute;
        width: 520px;
        height: 520px;
        border: 1px solid rgba(198, 169, 114, 0.06);
        border-radius: 50%;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        pointer-events: none;
    }


    /* =========================================================
   HEADING
   ========================================================= */

    .ace-brands-heading {
        position: relative;
        z-index: 3;
        margin: 0 0 12px;
        color: #ffffff;
        font-family: "Playfair Display", Georgia, serif;
        font-size: clamp(30px, 4vw, 52px);
        font-weight: 500;
        letter-spacing: 0.5px;
    }

    .ace-brands-heading::after {
        content: "";
        display: block;
        width: 55px;
        height: 2px;
        margin: 18px auto 0;
        background: var(--gold);
    }

    .ace-brands-description {
        position: relative;
        z-index: 3;
        max-width: 650px;
        margin: 25px auto 55px;
        padding: 0 20px;
        color: rgba(255, 255, 255, 0.68);
        font-family: "Montserrat", Arial, sans-serif;
        font-size: 14px;
        font-weight: 300;
        line-height: 1.8;
    }


    /* =========================================================
   CAROUSEL
   ========================================================= */

    .ace-brands-carousel-wrapper {
        position: relative;
        z-index: 3;
        width: 100%;
        max-width: 1250px;
        height: 390px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .ace-brands-carousel {
        position: relative;
        width: 100%;
        height: 100%;
        perspective: 1500px;
        transform-style: preserve-3d;
    }


    /* =========================================================
   BRAND SLIDE
   ========================================================= */

    .ace-brand-slide {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;

        display: flex;
        align-items: center;
        justify-content: center;

        opacity: 0;
        pointer-events: none;

        transform:
            translateX(0) scale(0.55);

        transition:
            transform 0.75s cubic-bezier(0.77, 0, 0.175, 1),
            opacity 0.75s ease;

        transform-style: preserve-3d;
    }


    /* =========================================================
   ACTIVE / PREVIOUS / NEXT
   ========================================================= */

    .ace-brand-slide.active {
        opacity: 1;
        z-index: 5;
        pointer-events: auto;

        transform:
            translateX(0) scale(1);
    }

    .ace-brand-slide.prev {
        opacity: 0.55;
        z-index: 3;

        transform:
            translateX(-330px) scale(0.68) rotateY(38deg);
    }

    .ace-brand-slide.next {
        opacity: 0.55;
        z-index: 3;

        transform:
            translateX(330px) scale(0.68) rotateY(-38deg);
    }

    .ace-brand-slide.hidden {
        opacity: 0;
        z-index: 1;
        pointer-events: none;

        transform:
            translateX(0) scale(0.45);
    }


    /* =========================================================
   BRAND CARD
   ========================================================= */


    .ace-brand-card img {
        border-radius: 10px;
    }

    .ace-brand-slide.active .ace-brand-card {
        border-color: rgba(198, 169, 114, 0.65);

    }


    /* =========================================================
   CARD CORNERS
   ========================================================= */



    .ace-brand-card::before {
        top: 12px;
        left: 12px;
        border-width: 1px 0 0 1px;
    }




    /* =========================================================
   LOGO
   ========================================================= */



    .ace-brand-logo {
        max-width: 175px;
        max-height: 105px;

        width: auto;
        height: auto;

        object-fit: contain;

        filter:
            drop-shadow(0 10px 20px rgba(0, 0, 0, 0.35));

        transition:
            transform 0.45s ease;
    }

    .ace-brand-slide.active .ace-brand-card:hover .ace-brand-logo {
        transform: scale(1.06);
    }


    /* =========================================================
   BRAND NAME
   ========================================================= */

    .ace-brand-name {
        margin: 0;

        color: var(--gold-light);

        font-family:
            "Playfair Display",
            Georgia,
            serif;

        font-size: 19px;
        font-weight: 500;

        letter-spacing: 1px;
    }


    /* =========================================================
   BRAND NUMBER
   ========================================================= */

    .ace-brand-number {
        position: absolute;

        right: 22px;
        top: 18px;

        color: rgba(198, 169, 114, 0.22);

        font-family:
            "Playfair Display",
            Georgia,
            serif;

        font-size: 13px;
        letter-spacing: 1px;
    }


    /* =========================================================
   NAVIGATION BUTTONS
   ========================================================= */

    .ace-brands-nav {
        position: absolute;
        top: 50%;

        z-index: 20;

        width: 52px;
        height: 52px;

        display: flex;
        align-items: center;
        justify-content: center;

        transform: translateY(-50%);

        border: 1px solid rgba(198, 169, 114, 0.4);
        border-radius: 50%;

        background: rgba(0, 0, 0, 0.35);

        color: #ffffff;

        font-size: 18px;

        cursor: pointer;

        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);

        transition:
            background 0.3s ease,
            border-color 0.3s ease,
            color 0.3s ease,
            transform 0.3s ease;
    }

    .ace-brands-nav:hover {
        background: var(--gold);
        border-color: var(--gold);
        color: #111111;

        transform:
            translateY(-50%) scale(1.08);
    }

    .ace-brands-nav.prev {
        left: 25px;
    }

    .ace-brands-nav.next {
        right: 25px;
    }


    /* =========================================================
   DOTS
   ========================================================= */

    .ace-brands-dots {
        position: absolute;

        left: 50%;
        bottom: 0;

        z-index: 20;

        display: flex;
        align-items: center;
        gap: 9px;

        transform: translateX(-50%);
    }

    .ace-brands-dot {
        width: 7px;
        height: 7px;

        padding: 0;

        border: 1px solid rgba(255, 255, 255, 0.45);
        border-radius: 50%;

        background: transparent;

        cursor: pointer;

        transition:
            width 0.3s ease,
            background 0.3s ease,
            border-color 0.3s ease;
    }

    .ace-brands-dot.active {
        width: 28px;

        border-color: var(--gold);
        border-radius: 10px;

        background: var(--gold);
    }

    .ace-brand-logo-box {
        width: 175px;
        height: 115px;
    }

    /* =========================================================
   MOBILE
   ========================================================= */

    @media (max-width: 992px) {

        .ace-brands-carousel-wrapper {
            height: 350px;
        }

        .ace-brand-card {
            width: 290px;
            height: 260px;
        }

        .ace-brand-slide.prev {
            transform:
                translateX(-250px) scale(0.65) rotateY(35deg);
        }

        .ace-brand-slide.next {
            transform:
                translateX(250px) scale(0.65) rotateY(-35deg);
        }

        .ace-brands-nav.prev {
            left: 15px;
        }

        .ace-brands-nav.next {
            right: 15px;
        }
    }


    @media (max-width: 768px) {

        .ace-brands-section {
            padding: 80px 0 95px;
        }

        .ace-brands-description {
            margin-bottom: 35px;
            font-size: 12px;
        }

        .ace-brands-carousel-wrapper {
            height: 330px;
        }

        .ace-brand-card {
            width: 250px;
            height: 235px;
        }

        .ace-brand-logo-box {
            width: 175px;
            height: 115px;
        }

        .ace-brand-logo {
            max-width: 140px;
            max-height: 80px;
        }

        .ace-brand-name {
            font-size: 16px;
        }

        .ace-brand-slide.prev {
            transform:
                translateX(-165px) scale(0.58) rotateY(30deg);
            opacity: 0.3;
        }

        .ace-brand-slide.next {
            transform:
                translateX(165px) scale(0.58) rotateY(-30deg);
            opacity: 0.3;
        }

        .ace-brands-nav {
            width: 42px;
            height: 42px;
            font-size: 14px;
        }

        .ace-brands-nav.prev {
            left: 8px;
        }

        .ace-brands-nav.next {
            right: 8px;
        }
    }


    @media (max-width: 480px) {

        .ace-brands-carousel-wrapper {
            height: 310px;
        }

        .ace-brand-card {
            width: 220px;
            height: 220px;
        }

        .ace-brand-logo-box {
            width: 150px;
            height: 100px;
            margin-bottom: 16px;
        }


        .ace-brand-logo {
            max-width: 120px;
            max-height: 70px;
        }

        .ace-brand-name {
            font-size: 14px;
        }

        .ace-brand-slide.prev,
        .ace-brand-slide.next {
            opacity: 0;
            transform: scale(0.5);
        }

        .ace-brands-nav {
            width: 38px;
            height: 38px;
        }

        .ace-brands-nav.prev {
            left: 5px;
        }

        .ace-brands-nav.next {
            right: 5px;
        }
    }

    /* Enhanced Luxury Design */
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
        line-height: 1.6;
        overflow-x: hidden;
    }

    /* Improved Typography */
    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        font-family: 'Playfair Display', Georgia, serif;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    /* Section Spacing & Headers */
    .content-section {
        padding: 100px 0;
        position: relative;
    }

    .content-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, var(--gold), transparent);
    }

    .section-header {
        text-align: center;
        margin-bottom: 70px;
        position: relative;
    }

    .section-header h2 {
        font-size: 2.8rem;
        font-weight: 500;
        margin-bottom: 20px;
        color: var(--white);
        position: relative;
        display: inline-block;
    }

    .section-header h2::after {
        content: '';
        position: absolute;
        bottom: -15px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 3px;
        background-color: var(--gold);
    }

    .section-header p {
        font-size: 1.1rem;
        color: var(--gray-light);
        max-width: 700px;
        margin: 30px auto 0;
        line-height: 1.8;
    }

    /* About Section */
    .about-text {
        font-size: 1.15rem;
        line-height: 1.9;
        text-align: center;
        max-width: 800px;
        margin: 0 auto 40px auto;
        color: var(--gray-light);
    }

    /* Enhanced Button Styling */
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

    /* Enhanced Card Design */
    .card {
        border: none;
        border-radius: 10;
        overflow: hidden;
        margin-bottom: 30px;
        background: var(--primary-light);
        transition: var(--transition);
        position: relative;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        height: 100%;
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
    }

    .card-img-container {
        overflow: hidden;
        position: relative;
    }

    .card-img-top {
        height: 280px;
        object-fit: cover;
        width: 100%;
        transition: var(--transition);
    }

    .card:hover .card-img-top {
        transform: scale(1.05);
    }

    .card-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.7) 0%, transparent 100%);
        opacity: 0;
        transition: var(--transition);
    }

    .card:hover .card-overlay {
        opacity: 1;
    }

    .card-body {
        padding: 25px;
        position: relative;
    }

    .card-keywords {
        font-size: 1.3rem;
        font-weight: 600;
        color: var(--gold);
        margin-bottom: 15px;
        font-family: 'Playfair Display', Georgia, serif;
    }

    .card-text {
        font-size: 0.95rem;
        line-height: 1.7;
        color: var(--gray-light);
        margin-bottom: 25px;
    }

    /* Decorative Elements */
    .decorative-line {
        height: 2px;
        width: 40px;
        background-color: var(--gold);
        margin: 20px 0;
        display: inline-block;
    }

    /* Animation Keyframes */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in-up {
        animation: fadeInUp 0.8s ease forwards;
    }

    /* Responsive Adjustments */
    @media (max-width: 992px) {
        .section-header h2 {
            font-size: 2.3rem;
        }

        .content-section {
            padding: 80px 0;
        }
    }

    @media (max-width: 768px) {
        .section-header h2 {
            font-size: 2rem;
        }

        .about-text {
            font-size: 1rem;
        }
    }

    .content-card {
        background: transparent;
        /* makes card see-through */
        padding: 40px;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
        margin: 0 auto 50px auto;
        position: relative;
        max-width: 1000px;
        text-align: center;
        /* border: 1px solid rgba(198, 169, 114, 0.3); optional: subtle gold outline */
    }

    .content-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 5px;
        height: 100%;
        background: var(--gold);
    }

    .content-title {
        font-size: 2.2rem;
        color: var(--gold);
        margin-bottom: 25px;
        position: relative;
        padding-bottom: 15px;
        display: inline-block;
    }

    .content-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 2px;
        background-color: var(--gold);
    }

    .content-text {
        font-size: 1.1rem;
        line-height: 1.9;
        color: var(--gray-light);
        margin-bottom: 30px;
        text-align: center;
    }


    .btn-discover {
        display: inline-block;
        padding: 12px 30px;
        background: var(--gold);
        color: var(--white);
        font-weight: bold;
        text-decoration: none;
        border-radius: 50px;
        transition: 0.3s ease;
    }

    .btn-discover:hover {
        background: var(--white);
        color: var(--gold);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }
</style>

<!-- <div class="container content-section">


    <div class="section-header animate-fade-in-up">
        <h2>Luxury German Kitchens in UAE</h2>
        <div class="about-text">
            <?php
            $string = strip_tags($business->getBusinessAboutBusiness());
            if (strlen($string) > 500) {
                // truncate string
                $stringCut = substr($string, 0, 500);
                $endPoint = strrpos($stringCut, ' ');

                //if the string doesn't contain any space then it will cut without word basis.
                $string = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                $string .= '...';
            }
            echo '<p>' . $string . '</p>';
            ?>
            <div class="decorative-line"></div>
            <br>
            <a href="/views/content" class="btn-discover">Discover Our Story</a>
        </div>
    </div>
</div> -->
<br><br><br>
<div class="row justify-content-center">
    <div class="col-lg-12">
        <div class="content-card animate-fade-in-up">
            <?php if ($maincontent): ?>
                <h3 class="content-title"><?= htmlspecialchars((string) $maincontent->getTitle(), ENT_QUOTES, 'UTF-8'); ?>
                </h3>

                <div class="content-text">
                    <?= nl2br(htmlspecialchars((string) $maincontent->getBrief(), ENT_QUOTES, 'UTF-8')); ?>
                </div>

                <a href="/content/" class="btn-discover">Discover</a>
            <?php else: ?>
                <p>No content available at the moment.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="container content-section">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="content-card animate-fade-in-up">
                <?php if ($postcontent): ?>
                    <h3 class="content-title">
                        <?= htmlspecialchars((string) $postcontent->getTitle(), ENT_QUOTES, 'UTF-8'); ?>
                    </h3>

                    <div class="content-text">
                        <?= nl2br(htmlspecialchars((string) $postcontent->getParagraph(), ENT_QUOTES, 'UTF-8')); ?>
                    </div>

                    <!-- <a href="/views/content" class="btn-discover">Discover</a> -->
                <?php endif; ?>
            </div>
        </div>
    </div>


    <div class="row">
        <?php
        $postOnHomeList = DBpost::getPostOnHome();
        foreach ($postOnHomeList as $postOnHome) {
            echo '<div class="col-lg-4 col-md-6">
                <div class="card">
                    <img src="/cmsadmin/img/Post/' . htmlspecialchars((string) $postOnHome->getImage(), ENT_QUOTES, 'UTF-8') . '" class="card-img-top" alt="' . htmlspecialchars((string) $postOnHome->getAltTextImage(), ENT_QUOTES, 'UTF-8') . '">
                    <div class="text-center">
                        <div class="card-keywords">' . htmlspecialchars((string) $postOnHome->getKeywords(), ENT_QUOTES, 'UTF-8') . '</div>
                        <p class="card-text">';
            $string = strip_tags((string) $postOnHome->getPostDescription());
            if (strlen($string) > 200) { // Reduced length for better card balance
                // truncate string
                $stringCut = substr($string, 0, 150);
                $endPoint = strrpos($stringCut, ' ');
                //if the string doesn't contain any space then it will cut without word basis.
                $string = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                $string .= '...';
            }
            echo htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
            echo '</p>
                        <a href="';
            echo htmlspecialchars((string) $postOnHome->getPostUrl(), ENT_QUOTES, 'UTF-8');
            echo '" class="btn-discover">Discover</a>
                    </div>
                </div>
            </div>';
        }
        ?>
    </div>
</div>
<!-- =========================================================
     ACE DECORS - BRANDS SECTION
     ========================================================= -->

<section class="ace-brands-section">

    <!-- SECTION HEADING -->

    <h2 class="ace-brands-heading">
        <?= $section
            ? htmlspecialchars(
                (string) $section->getHeading(),
                ENT_QUOTES,
                'UTF-8'
            )
            : 'Our Signature Brand Collective';
        ?>
    </h2>


    <?php if ($section && $section->getParagraph()): ?>

        <p class="ace-brands-description">
            <?= htmlspecialchars(
                (string) $section->getParagraph(),
                ENT_QUOTES,
                'UTF-8'
            ); ?>
        </p>

    <?php endif; ?>


    <!-- =====================================================
         BRAND CAROUSEL
         ===================================================== -->

    <?php if (count($brands) > 0): ?>

        <div class="ace-brands-carousel-wrapper">

            <div class="ace-brands-carousel" id="aceBrandsCarousel">

                <?php foreach ($brands as $index => $brand): ?>

                    <?php
                    $brandNumber = str_pad(
                        $index + 1,
                        2,
                        '0',
                        STR_PAD_LEFT
                    );
                    ?>

                    <div class="ace-brand-slide <?= $index === 0 ? 'active' : ''; ?>" data-brand-index="<?= $index; ?>">

                        <div class="ace-brand-card">

                            <!-- Brand Number -->

                            


                            <!-- Brand Logo -->

                            <div class="ace-brand-logo-box">

                                <img src="/cmsadmin/img/brands/<?= htmlspecialchars(
                                    (string) $brand->getImage(),
                                    ENT_QUOTES,
                                    'UTF-8'
                                ); ?>" alt="<?= htmlspecialchars(
                                     (string) $brand->getName(),
                                     ENT_QUOTES,
                                     'UTF-8'
                                 ); ?>" class="ace-brand-logo" loading="lazy">

                            </div>

                            <br>
                            <!-- Brand Name -->

                            <!-- <h3 class="ace-brand-name">
                                <?= htmlspecialchars(
                                    (string) $brand->getName(),
                                    ENT_QUOTES,
                                    'UTF-8'
                                ); ?>
                            </h3> -->

                        </div>

                    </div>

                <?php endforeach; ?>

            </div>


            <!-- =================================================
                 PREVIOUS / NEXT
                 ================================================= -->

            <?php if (count($brands) > 1): ?>

                <button type="button" class="ace-brands-nav prev" id="aceBrandsPrev" aria-label="Previous brand">
                    &#10094;
                </button>

                <button type="button" class="ace-brands-nav next" id="aceBrandsNext" aria-label="Next brand">
                    &#10095;
                </button>

            <?php endif; ?>


            <!-- =================================================
                 DOTS
                 ================================================= -->

            <?php if (count($brands) > 1): ?>

                <div class="ace-brands-dots" id="aceBrandsDots">

                    <?php foreach ($brands as $index => $brand): ?>

                        <button type="button" class="ace-brands-dot <?= $index === 0 ? 'active' : ''; ?>"
                            data-brand-index="<?= $index; ?>" aria-label="Go to brand <?= $index + 1; ?>"></button>

                    <?php endforeach; ?>

                </div>

            <?php endif; ?>

        </div>

    <?php else: ?>

        <p class="text-center text-muted">
            No brands available.
        </p>

    <?php endif; ?>

</section>
<script>
    document.addEventListener("DOMContentLoaded", function () {

        const carousel = document.getElementById("aceBrandsCarousel");

        if (!carousel) {
            return;
        }

        const slides = carousel.querySelectorAll(".ace-brand-slide");

        const prevButton = document.getElementById("aceBrandsPrev");
        const nextButton = document.getElementById("aceBrandsNext");

        const dots = document.querySelectorAll(".ace-brands-dot");

        const slideCount = slides.length;

        if (slideCount === 0) {
            return;
        }


        let currentIndex = 0;

        let autoSlideTimer = null;

        const AUTO_SLIDE_TIME = 4000;


        /* =========================================================
           UPDATE BRANDS
           ========================================================= */

        function updateBrands(index) {

            if (index < 0) {
                index = slideCount - 1;
            }

            if (index >= slideCount) {
                index = 0;
            }

            currentIndex = index;


            slides.forEach(function (slide, i) {

                slide.classList.remove(
                    "active",
                    "prev",
                    "next",
                    "hidden"
                );


                if (slideCount === 1) {

                    slide.classList.add("active");

                    return;

                }


                const difference =
                    (i - currentIndex + slideCount)
                    % slideCount;


                if (difference === 0) {

                    slide.classList.add("active");

                } else if (difference === 1) {

                    slide.classList.add("next");

                } else if (
                    difference === slideCount - 1
                ) {

                    slide.classList.add("prev");

                } else {

                    slide.classList.add("hidden");

                }

            });


            /* Update dots */

            dots.forEach(function (dot, i) {

                dot.classList.toggle(
                    "active",
                    i === currentIndex
                );

            });

        }


        /* =========================================================
           NEXT
           ========================================================= */

        function nextBrand() {

            updateBrands(currentIndex + 1);

        }


        /* =========================================================
           PREVIOUS
           ========================================================= */

        function previousBrand() {

            updateBrands(currentIndex - 1);

        }


        /* =========================================================
           AUTOPLAY
           ========================================================= */

        function startAutoSlide() {

            stopAutoSlide();

            if (slideCount <= 1) {
                return;
            }

            autoSlideTimer = setInterval(
                nextBrand,
                AUTO_SLIDE_TIME
            );

        }


        function stopAutoSlide() {

            if (autoSlideTimer) {

                clearInterval(autoSlideTimer);

                autoSlideTimer = null;

            }

        }


        /* =========================================================
           BUTTONS
           ========================================================= */

        if (nextButton) {

            nextButton.addEventListener(
                "click",
                function () {

                    nextBrand();

                    startAutoSlide();

                }
            );

        }


        if (prevButton) {

            prevButton.addEventListener(
                "click",
                function () {

                    previousBrand();

                    startAutoSlide();

                }
            );

        }


        /* =========================================================
           DOTS
           ========================================================= */

        dots.forEach(function (dot) {

            dot.addEventListener(
                "click",
                function () {

                    const index = parseInt(
                        this.getAttribute(
                            "data-brand-index"
                        ),
                        10
                    );

                    updateBrands(index);

                    startAutoSlide();

                }
            );

        });


        /* =========================================================
           PAUSE WHEN HOVERING
           ========================================================= */

        carousel.addEventListener(
            "mouseenter",
            function () {

                stopAutoSlide();

            }
        );


        carousel.addEventListener(
            "mouseleave",
            function () {

                startAutoSlide();

            }
        );


        /* =========================================================
           TOUCH / SWIPE
           ========================================================= */

        let touchStartX = 0;
        let touchEndX = 0;


        carousel.addEventListener(
            "touchstart",
            function (event) {

                touchStartX =
                    event.changedTouches[0].screenX;

            },
            {
                passive: true
            }
        );


        carousel.addEventListener(
            "touchend",
            function (event) {

                touchEndX =
                    event.changedTouches[0].screenX;


                const difference =
                    touchStartX - touchEndX;


                if (Math.abs(difference) < 50) {
                    return;
                }


                if (difference > 0) {

                    nextBrand();

                } else {

                    previousBrand();

                }


                startAutoSlide();

            },
            {
                passive: true
            }
        );


        /* =========================================================
           INITIALIZE
           ========================================================= */

        updateBrands(0);

        startAutoSlide();

    });
</script>
<script>
    // Add scroll animation to elements
    document.addEventListener('DOMContentLoaded', function () {
        const animatedElements = document.querySelectorAll('.animate-fade-in-up');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.visibility = 'visible';
                    entry.target.classList.add('animate-fade-in-up');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1
        });

        animatedElements.forEach(element => {
            element.style.visibility = 'hidden';
            observer.observe(element);
        });
    });
</script>

<?php require_once("footer.php"); ?>