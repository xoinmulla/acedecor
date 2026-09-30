<?php
require_once __DIR__ . "/../cmsadmin/dblayer/sliderImageOps.php";
require_once __DIR__ . "/../cmsadmin/model/sliderImageModel.php";

$designList = DBsliderImageFile::readByPostId($postId ?? 0);
?>

<style>
    /* =========================================================
       ACE DECORS - FULL SCREEN LUXURY HERO SLIDER
       ========================================================= */

    .ace-hero-slider {
        --ace-gold: #c6a972;
        --ace-gold-light: #e1cc9e;
        --ace-white: #ffffff;
        --ace-black: #080808;

        position: relative;
        width: 100%;
        height: calc(100vh - 80px);
        min-height: 620px;
        max-height: 1000px;
        overflow: hidden;
        background: var(--ace-black);
        isolation: isolate;
    }

    /* ---------------------------------------------------------
       SLIDES
       --------------------------------------------------------- */

    .ace-hero-slide {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transform: scale(1.04);
        transition:
            opacity 1s ease,
            visibility 1s ease,
            transform 7s ease;
        z-index: 1;
    }

    .ace-hero-slide.active {
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
        transform: scale(1);
        z-index: 2;
    }

    /* ---------------------------------------------------------
       MEDIA
       --------------------------------------------------------- */

    .ace-hero-media,
    .ace-hero-media img,
    .ace-hero-media video,
    .ace-hero-media iframe {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        border: 0;
    }

    .ace-hero-media img,
    .ace-hero-media video {
        object-fit: cover;
        object-position: center;
    }

    .ace-hero-media iframe {
        object-fit: cover;
        pointer-events: none;
        transform: scale(1.01);
    }

    /* ---------------------------------------------------------
       IMAGE / VIDEO OVERLAYS
       --------------------------------------------------------- */

    .ace-hero-overlay {
        position: absolute;
        inset: 0;
        z-index: 3;
        background:
            linear-gradient(90deg,
                rgba(0, 0, 0, 0.82) 0%,
                rgba(0, 0, 0, 0.58) 30%,
                rgba(0, 0, 0, 0.18) 65%,
                rgba(0, 0, 0, 0.48) 100%),
            linear-gradient(0deg,
                rgba(0, 0, 0, 0.72) 0%,
                transparent 35%,
                rgba(0, 0, 0, 0.15) 100%);
        pointer-events: none;
    }

    /* Subtle luxury grain */
    .ace-hero-grain {
        position: absolute;
        inset: 0;
        z-index: 4;
        pointer-events: none;
        opacity: 0.06;
        background-image:
            url("data:image/svg+xml,%3Csvg viewBox='0 0 180 180' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.9' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='.55'/%3E%3C/svg%3E");
    }

    /* ---------------------------------------------------------
       DECORATIVE GOLD FRAME
       --------------------------------------------------------- */

    .ace-hero-frame {
        position: absolute;
        inset: 28px;
        border: 1px solid rgba(198, 169, 114, 0.28);
        z-index: 5;
        pointer-events: none;
    }

    .ace-hero-frame::before,
    .ace-hero-frame::after {
        content: "";
        position: absolute;
        width: 90px;
        height: 90px;
        border-color: rgba(198, 169, 114, 0.8);
        border-style: solid;
    }

    .ace-hero-frame::before {
        top: -1px;
        left: -1px;
        border-width: 2px 0 0 2px;
    }

    .ace-hero-frame::after {
        right: -1px;
        bottom: -1px;
        border-width: 0 2px 2px 0;
    }

    /* ---------------------------------------------------------
       CONTENT
       --------------------------------------------------------- */

    .ace-hero-content {
        position: relative;
        z-index: 6;
        width: 100%;
        height: 100%;
        max-width: 1500px;
        margin: 0 auto;
        padding: 0 8%;
        display: flex;
        align-items: center;
    }

    .ace-hero-content-inner {
        max-width: 720px;
        padding-top: 20px;
    }

    .ace-hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 24px;
        color: var(--ace-gold-light);
        font-family: "Montserrat", Arial, sans-serif;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 4px;
        text-transform: uppercase;
        opacity: 0;
        transform: translateY(25px);
        transition:
            opacity 0.8s ease 0.25s,
            transform 0.8s ease 0.25s;
    }

    .ace-hero-eyebrow::before {
        content: "";
        width: 42px;
        height: 1px;
        background: var(--ace-gold);
    }

    .ace-hero-slide.active .ace-hero-eyebrow {
        opacity: 1;
        transform: translateY(0);
    }

    .ace-hero-title {
        margin: 0 0 22px;
        color: var(--ace-white);
        font-family: "Playfair Display", Georgia, serif;
        font-size: clamp(42px, 5.2vw, 82px);
        font-weight: 500;
        line-height: 1.05;
        letter-spacing: -1px;
        text-shadow: 0 5px 30px rgba(0, 0, 0, 0.35);
        opacity: 0;
        transform: translateY(35px);
        transition:
            opacity 0.9s ease 0.4s,
            transform 0.9s ease 0.4s;
    }

    .ace-hero-slide.active .ace-hero-title {
        opacity: 1;
        transform: translateY(0);
    }

    .ace-hero-title-line {
        display: block;
        width: 70px;
        height: 2px;
        margin: 28px 0;
        background: var(--ace-gold);
        transform-origin: left;
        transform: scaleX(0);
        transition: transform 0.8s ease 0.7s;
    }

    .ace-hero-slide.active .ace-hero-title-line {
        transform: scaleX(1);
    }

    .ace-hero-description {
        max-width: 580px;
        margin: 0 0 34px;
        color: rgba(255, 255, 255, 0.86);
        font-family: "Montserrat", Arial, sans-serif;
        font-size: 15px;
        font-weight: 300;
        line-height: 1.9;
        letter-spacing: 0.2px;
        opacity: 0;
        transform: translateY(25px);
        transition:
            opacity 0.9s ease 0.6s,
            transform 0.9s ease 0.6s;
    }

    .ace-hero-slide.active .ace-hero-description {
        opacity: 1;
        transform: translateY(0);
    }

    /* ---------------------------------------------------------
       DISCOVER BUTTON
       --------------------------------------------------------- */

    .ace-hero-button {
        display: inline-flex;
        align-items: center;
        gap: 18px;
        padding: 14px 24px;
        border: 1px solid rgba(198, 169, 114, 0.85);
        color: var(--ace-white);
        background: rgba(0, 0, 0, 0.15);
        text-decoration: none;
        font-family: "Montserrat", Arial, sans-serif;
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 2.5px;
        text-transform: uppercase;
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        transition: all 0.35s ease;
        opacity: 0;
        transform: translateY(25px);
    }

    .ace-hero-slide.active .ace-hero-button {
        opacity: 1;
        transform: translateY(0);
        transition:
            opacity 0.8s ease 0.8s,
            transform 0.8s ease 0.8s,
            background 0.35s ease,
            color 0.35s ease,
            box-shadow 0.35s ease;
    }

    .ace-hero-button span {
        display: inline-block;
        width: 28px;
        height: 1px;
        background: var(--ace-gold);
        transition: width 0.35s ease;
    }

    .ace-hero-button:hover {
        color: #111;
        background: var(--ace-gold);
        box-shadow: 0 10px 30px rgba(198, 169, 114, 0.22);
    }

    .ace-hero-button:hover span {
        width: 42px;
        background: #111;
    }

    /* ---------------------------------------------------------
       RIGHT SIDE DECORATIVE NUMBER
       --------------------------------------------------------- */

    .ace-hero-number {
        position: absolute;
        right: 8%;
        top: 50%;
        z-index: 6;
        transform: translateY(-50%);
        color: rgba(255, 255, 255, 0.08);
        font-family: "Playfair Display", Georgia, serif;
        font-size: clamp(130px, 18vw, 280px);
        font-weight: 500;
        line-height: 1;
        pointer-events: none;
        user-select: none;
    }

    /* ---------------------------------------------------------
       NAVIGATION
       --------------------------------------------------------- */

    .ace-hero-navigation {
        position: absolute;
        right: 8%;
        bottom: 55px;
        z-index: 10;
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .ace-hero-nav-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 46px;
        height: 46px;
        border: 1px solid rgba(255, 255, 255, 0.35);
        border-radius: 50%;
        color: #fff;
        background: rgba(0, 0, 0, 0.18);
        font-size: 17px;
        line-height: 1;
        cursor: pointer;
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        transition: all 0.3s ease;
    }

    .ace-hero-nav-btn:hover {
        border-color: var(--ace-gold);
        color: var(--ace-gold);
        transform: scale(1.08);
    }

    /* ---------------------------------------------------------
       SLIDE COUNTER
       --------------------------------------------------------- */

    .ace-hero-counter {
        position: absolute;
        left: 8%;
        bottom: 55px;
        z-index: 10;
        display: flex;
        align-items: center;
        gap: 14px;
        color: rgba(255, 255, 255, 0.7);
        font-family: "Montserrat", Arial, sans-serif;
        font-size: 11px;
        letter-spacing: 2px;
    }

    .ace-hero-counter-current {
        color: var(--ace-gold);
        font-size: 18px;
        font-weight: 600;
    }

    .ace-hero-counter-line {
        width: 70px;
        height: 1px;
        background: rgba(255, 255, 255, 0.25);
        overflow: hidden;
    }

    .ace-hero-progress {
        display: block;
        width: 0%;
        height: 100%;
        background: var(--ace-gold);
    }

    /* ---------------------------------------------------------
       DOTS
       --------------------------------------------------------- */

    .ace-hero-dots {
        position: absolute;
        left: 50%;
        bottom: 58px;
        z-index: 10;
        display: flex;
        align-items: center;
        gap: 9px;
        transform: translateX(-50%);
    }

    .ace-hero-dot {
        width: 7px;
        height: 7px;
        padding: 0;
        border: 1px solid rgba(255, 255, 255, 0.65);
        border-radius: 50%;
        background: transparent;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .ace-hero-dot.active {
        width: 28px;
        border-color: var(--ace-gold);
        border-radius: 10px;
        background: var(--ace-gold);
    }

    /* ---------------------------------------------------------
       SCROLL INDICATOR
       --------------------------------------------------------- */

    .ace-hero-scroll {
        position: absolute;
        right: 2.8%;
        top: 50%;
        z-index: 10;
        display: flex;
        align-items: center;
        gap: 12px;
        color: rgba(255, 255, 255, 0.5);
        font-family: "Montserrat", Arial, sans-serif;
        font-size: 9px;
        letter-spacing: 3px;
        text-transform: uppercase;
        writing-mode: vertical-rl;
        transform: translateY(-50%);
    }

    .ace-hero-scroll-line {
        width: 1px;
        height: 55px;
        background: linear-gradient(to bottom,
                transparent,
                var(--ace-gold),
                transparent);
    }

    /* ---------------------------------------------------------
       EMPTY STATE
       --------------------------------------------------------- */

    .ace-hero-empty {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-family: "Montserrat", Arial, sans-serif;
    }

    /* ---------------------------------------------------------
       RESPONSIVE
       --------------------------------------------------------- */

    @media (max-width: 1200px) {
        .ace-hero-content {
            padding-left: 7%;
            padding-right: 7%;
        }

        .ace-hero-number {
            right: 7%;
        }

        .ace-hero-navigation {
            right: 7%;
        }

        .ace-hero-counter {
            left: 7%;
        }
    }

    @media (max-width: 768px) {

        .ace-hero-slider {
            height: calc(100svh - 65px);
            min-height: 560px;
            max-height: none;
        }

        .ace-hero-frame {
            inset: 14px;
        }

        .ace-hero-frame::before,
        .ace-hero-frame::after {
            width: 45px;
            height: 45px;
        }

        .ace-hero-overlay {
            background:
                linear-gradient(90deg,
                    rgba(0, 0, 0, 0.78),
                    rgba(0, 0, 0, 0.38)),
                linear-gradient(0deg,
                    rgba(0, 0, 0, 0.82),
                    transparent 55%);
        }

        .ace-hero-content {
            padding: 0 9%;
            align-items: flex-end;
            padding-bottom: 150px;
        }

        .ace-hero-content-inner {
            width: 100%;
            max-width: 100%;
        }

        .ace-hero-eyebrow {
            margin-bottom: 17px;
            font-size: 9px;
            letter-spacing: 3px;
        }

        .ace-hero-eyebrow::before {
            width: 25px;
        }

        .ace-hero-title {
            margin-bottom: 15px;
            font-size: clamp(37px, 11vw, 58px);
            line-height: 1.08;
        }

        .ace-hero-title-line {
            width: 48px;
            margin: 18px 0;
        }

        .ace-hero-description {
            max-width: 100%;
            margin-bottom: 23px;
            font-size: 12px;
            line-height: 1.7;
        }

        .ace-hero-button {
            padding: 12px 18px;
            font-size: 8px;
            letter-spacing: 2px;
        }

        .ace-hero-number {
            top: 22%;
            right: 7%;
            font-size: 110px;
        }

        .ace-hero-navigation {
            right: 9%;
            bottom: 32px;
            gap: 8px;
        }

        .ace-hero-nav-btn {
            width: 38px;
            height: 38px;
            font-size: 14px;
        }

        .ace-hero-counter {
            left: 9%;
            bottom: 38px;
            gap: 9px;
        }

        .ace-hero-counter-current {
            font-size: 15px;
        }

        .ace-hero-counter-line {
            width: 42px;
        }

        .ace-hero-dots {
            display: none;
        }

        .ace-hero-scroll {
            display: none;
        }
    }

    @media (max-width: 480px) {

        .ace-hero-slider {
            min-height: 520px;
        }

        .ace-hero-content {
            padding-left: 8%;
            padding-right: 8%;
            padding-bottom: 125px;
        }

        .ace-hero-title {
            font-size: 36px;
        }

        .ace-hero-description {
            font-size: 11px;
        }

        .ace-hero-navigation {
            bottom: 27px;
        }

        .ace-hero-counter {
            bottom: 33px;
        }
    }

    /* ---------------------------------------------------------
       REDUCED MOTION
       --------------------------------------------------------- */

    @media (prefers-reduced-motion: reduce) {

        .ace-hero-slide,
        .ace-hero-eyebrow,
        .ace-hero-title,
        .ace-hero-description,
        .ace-hero-button,
        .ace-hero-title-line {
            transition: none !important;
        }
    }
</style>


<div class="ace-hero-slider" id="aceHeroSlider">

    <?php if (count($designList) > 0): ?>

        <?php foreach ($designList as $index => $design): ?>

            <?php
            $title = htmlspecialchars(
                (string) ($design->getImageAlternateText() ?: 'ACE DECORS'),
                ENT_QUOTES,
                'UTF-8'
            );

            $description = htmlspecialchars(
                (string) ($design->getImageFileCaption() ?: ''),
                ENT_QUOTES,
                'UTF-8'
            );

            $fileType = $design->getFileType();

            

            $totalSlides = str_pad(
                count($designList),
                2,
                '0',
                STR_PAD_LEFT
            );
            ?>

            <div class="ace-hero-slide <?= $index === 0 ? 'active' : ''; ?>" data-slide="<?= $index; ?>">

                <!-- MEDIA -->
                <div class="ace-hero-media">

                    <?php if ($fileType === 'video'): ?>

                        <?php if (!empty($design->getVideoUrl())): ?>

                            <iframe src="<?= htmlspecialchars(
                                (string) $design->getVideoUrl(),
                                ENT_QUOTES,
                                'UTF-8'
                            ); ?>" title="<?= $title; ?>" allow="autoplay; fullscreen" allowfullscreen>
                            </iframe>

                        <?php elseif (!empty($design->getVideoFile())): ?>

                            <video autoplay muted loop playsinline preload="auto">
                                <source src="/cmsadmin/img/Slider/<?= htmlspecialchars(
                                    (string) $design->getVideoFile(),
                                    ENT_QUOTES,
                                    'UTF-8'
                                ); ?>" type="video/mp4">
                            </video>

                        <?php endif; ?>

                    <?php else: ?>

                        <img src="/cmsadmin/img/Slider/<?= htmlspecialchars(
                            (string) $design->getImage(),
                            ENT_QUOTES,
                            'UTF-8'
                        ); ?>" alt="<?= $title; ?>" loading="<?= $index === 0 ? 'eager' : 'lazy'; ?>">

                    <?php endif; ?>

                </div>


                <!-- OVERLAYS -->
                <div class="ace-hero-overlay"></div>
                <div class="ace-hero-grain"></div>


                <!-- DECORATIVE FRAME -->
                <div class="ace-hero-frame"></div>


                <!-- LARGE BACKGROUND NUMBER -->
                <div class="ace-hero-number">
                    <?= $slideNumber; ?>
                </div>


                <!-- CONTENT -->
                <div class="ace-hero-content">

                    <div class="ace-hero-content-inner">

                        <div class="ace-hero-eyebrow">
                            ACE DECORS
                        </div>

                        <h1 class="ace-hero-title">
                            <?= $title; ?>
                        </h1>

                        <span class="ace-hero-title-line"></span>

                        <?php if (!empty($description)): ?>

                            <p class="ace-hero-description">
                                <?= $description; ?>
                            </p>

                        <?php endif; ?>

                        <a href="/about/" class="ace-hero-button">
                            Discover
                            <span></span>
                        </a>

                    </div>

                </div>

            </div>

        <?php endforeach; ?>


        <!-- =====================================================
             SLIDER COUNTER
             ===================================================== -->

        <div class="ace-hero-counter">

            

            <span class="ace-hero-counter-line">
                <span class="ace-hero-progress" id="aceHeroProgress"></span>
            </span>

            

        </div>


        <!-- =====================================================
             DOT NAVIGATION
             ===================================================== -->

        <?php if (count($designList) > 1): ?>

            <div class="ace-hero-dots" id="aceHeroDots">

                <?php foreach ($designList as $index => $design): ?>

                    <button type="button" class="ace-hero-dot <?= $index === 0 ? 'active' : ''; ?>" data-slide="<?= $index; ?>"
                        aria-label="Go to slide <?= $index + 1; ?>"></button>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>


        <!-- =====================================================
             PREVIOUS / NEXT
             ===================================================== -->

        <?php if (count($designList) > 1): ?>

            <div class="ace-hero-navigation">

                <button type="button" class="ace-hero-nav-btn" id="aceHeroPrev" aria-label="Previous slide">
                    &#10094;
                </button>

                <button type="button" class="ace-hero-nav-btn" id="aceHeroNext" aria-label="Next slide">
                    &#10095;
                </button>

            </div>

        <?php endif; ?>


        <!-- SCROLL INDICATOR -->

        <div class="ace-hero-scroll">

            <span>Scroll</span>

            <span class="ace-hero-scroll-line"></span>

        </div>


    <?php else: ?>

        <div class="ace-hero-empty">
            No slides to display
        </div>

    <?php endif; ?>

</div>


<?php if (count($designList) > 1): ?>

    <script>
        document.addEventListener("DOMContentLoaded", function () {

            const slider = document.getElementById("aceHeroSlider");

            if (!slider) {
                return;
            }

            const slides = slider.querySelectorAll(".ace-hero-slide");
            const dots = slider.querySelectorAll(".ace-hero-dot");

            const prevButton = document.getElementById("aceHeroPrev");
            const nextButton = document.getElementById("aceHeroNext");

            const currentCounter = document.getElementById("aceHeroCurrent");
            const progressBar = document.getElementById("aceHeroProgress");

            const slideCount = slides.length;

            if (slideCount <= 1) {
                return;
            }

            let currentIndex = 0;
            let autoSlideTimer = null;

            const AUTO_SLIDE_TIME = 6000;


            /* =========================================================
               UPDATE SLIDE
               ========================================================= */

            function updateSlider(index) {

                if (index < 0) {
                    index = slideCount - 1;
                }

                if (index >= slideCount) {
                    index = 0;
                }

                currentIndex = index;


                slides.forEach(function (slide, i) {

                    slide.classList.remove("active");

                    if (i === currentIndex) {
                        slide.classList.add("active");
                    }

                });


                dots.forEach(function (dot, i) {

                    dot.classList.remove("active");

                    if (i === currentIndex) {
                        dot.classList.add("active");
                    }

                });


                if (currentCounter) {

                    currentCounter.textContent = String(
                        currentIndex + 1
                    ).padStart(2, "0");

                }


                resetProgress();

            }


            /* =========================================================
               NEXT
               ========================================================= */

            function nextSlide() {

                updateSlider(currentIndex + 1);

            }


            /* =========================================================
               PREVIOUS
               ========================================================= */

            function previousSlide() {

                updateSlider(currentIndex - 1);

            }


            /* =========================================================
               PROGRESS BAR
               ========================================================= */

            function resetProgress() {

                if (!progressBar) {
                    return;
                }

                progressBar.style.transition = "none";
                progressBar.style.width = "0%";

                requestAnimationFrame(function () {

                    requestAnimationFrame(function () {

                        progressBar.style.transition =
                            "width " + AUTO_SLIDE_TIME + "ms linear";

                        progressBar.style.width = "100%";

                    });

                });

            }


            /* =========================================================
               AUTOPLAY
               ========================================================= */

            function startAutoSlide() {

                stopAutoSlide();

                autoSlideTimer = setInterval(function () {

                    nextSlide();

                }, AUTO_SLIDE_TIME);

                resetProgress();

            }


            function stopAutoSlide() {

                if (autoSlideTimer) {

                    clearInterval(autoSlideTimer);

                    autoSlideTimer = null;

                }

            }


            /* =========================================================
               BUTTON EVENTS
               ========================================================= */

            if (nextButton) {

                nextButton.addEventListener(
                    "click",
                    function () {

                        nextSlide();
                        startAutoSlide();

                    }
                );

            }


            if (prevButton) {

                prevButton.addEventListener(
                    "click",
                    function () {

                        previousSlide();
                        startAutoSlide();

                    }
                );

            }


            /* =========================================================
               DOT EVENTS
               ========================================================= */

            dots.forEach(function (dot) {

                dot.addEventListener(
                    "click",
                    function () {

                        const index = parseInt(
                            this.getAttribute("data-slide"),
                            10
                        );

                        updateSlider(index);
                        startAutoSlide();

                    }
                );

            });


            /* =========================================================
               PAUSE ON HOVER
               ========================================================= */

            slider.addEventListener(
                "mouseenter",
                function () {

                    stopAutoSlide();

                }
            );


            slider.addEventListener(
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

            slider.addEventListener(
                "touchstart",
                function (event) {

                    touchStartX =
                        event.changedTouches[0].screenX;

                },
                {
                    passive: true
                }
            );


            slider.addEventListener(
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

                        nextSlide();

                    } else {

                        previousSlide();

                    }

                    startAutoSlide();

                },
                {
                    passive: true
                }
            );


            /* =========================================================
               KEYBOARD NAVIGATION
               ========================================================= */

            document.addEventListener(
                "keydown",
                function (event) {

                    if (event.key === "ArrowRight") {

                        nextSlide();
                        startAutoSlide();

                    }

                    if (event.key === "ArrowLeft") {

                        previousSlide();
                        startAutoSlide();

                    }

                }
            );


            /* =========================================================
               INITIALIZE
               ========================================================= */

            updateSlider(0);
            startAutoSlide();

        });
    </script>

<?php endif; ?>