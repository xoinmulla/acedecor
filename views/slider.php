<?php
require_once __DIR__ . "/../cmsadmin/dblayer/sliderImageOps.php";
require_once __DIR__ . "/../cmsadmin/model/sliderImageModel.php";
?>

<style>
    /* ----- Cover Flow Carousel Styles ----- */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap');

    .carousel-wrapper {
        position: relative;
        width: 100%;
        max-width: 1200px;
        height: 500px;
        margin: 0 auto;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .carousel {
        position: relative;
        width: 100%;
        height: 100%;
        perspective: 1500px;
        transform-style: preserve-3d;
    }

    .slide {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        transition: transform 0.7s cubic-bezier(0.77, 0, 0.175, 1), opacity 0.7s ease;
        opacity: 0.8;
    }

    .slide-content {
        position: relative;
        width: 45%;
        height: 65%;
        transform-style: preserve-3d;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        background: #000;
        /* fallback for videos */
    }

    /* Images */
    .slide-img-wrapper {
        position: relative;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
    }

    .slide-img-wrapper::after {
        content: '';
        position: absolute;
        bottom: -100%;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: inherit;
        background-size: cover;
        background-position: center;
        transform: scaleY(-1);
        filter: blur(5px);
        mask-image: linear-gradient(to top, rgba(0, 0, 0, 0.4) 0%, transparent 60%);
        opacity: 0.5;
        pointer-events: none;
    }

    .slide-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    /* Videos */
    .slide-video {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Caption */
    .slide-text {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 25px;
        background: rgba(0, 0, 0, 0.25);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        color: #fff;
        transform: translateY(100%);
        transition: transform 0.5s 0.2s cubic-bezier(0.23, 1, 0.32, 1);
    }

    .slide-title {
        font-size: 1.75rem;
        font-weight: 700;
        margin: 0 0 5px;
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.5s 0.4s ease, transform 0.5s 0.4s ease;
    }

    .slide-desc {
        font-size: 0.9rem;
        font-weight: 300;
        margin: 0;
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.5s 0.5s ease, transform 0.5s 0.5s ease;
    }

    /* Active and neighbour states */
    .slide.active {
        opacity: 1;
        z-index: 2;
        transform: translateZ(0) rotateY(0deg) scale(1);
    }

    .slide.active .slide-text {
        transform: translateY(0);
    }

    .slide.active .slide-title,
    .slide.active .slide-desc {
        opacity: 1;
        transform: translateY(0);
    }

    .slide.prev {
        z-index: 1;
        transform: translateX(-35%) scale(0.75) rotateY(45deg);
    }

    .slide.next {
        z-index: 1;
        transform: translateX(35%) scale(0.75) rotateY(-45deg);
    }

    .slide.hidden {
        opacity: 0;
        pointer-events: none;
        transform: translateX(0) scale(0.5);
    }

    /* Navigation buttons */
    .carousel-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        width: 50px;
        height: 50px;
        font-size: 1.5rem;
        color: #fff;
        cursor: pointer;
        z-index: 10;
        transition: all 0.3s ease;
    }

    .carousel-btn:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateY(-50%) scale(1.1);
    }

    .carousel-btn.prev {
        left: 5%;
    }

    .carousel-btn.next {
        right: 5%;
    }

    /* Mobile adjustments */
    @media (max-width: 768px) {
        .carousel-wrapper {
            height: 350px;
        }

        .slide-content {
            width: 60%;
            height: 60%;
        }

        .slide-title {
            font-size: 1.2rem;
        }

        .slide-desc {
            font-size: 0.8rem;
        }

        .carousel-btn {
            width: 40px;
            height: 40px;
            font-size: 1.2rem;
        }
    }
</style>

<div class="carousel-wrapper">
    <div class="carousel">
        <?php
        $designList = DBsliderImageFile::readByPostId($postId ?? 0);
        if (count($designList) > 0):
            foreach ($designList as $design):
                // Map database fields to title/description (customise as needed)
                $title = htmlspecialchars($design->getImageAlternateText() ?: 'Slide', ENT_QUOTES, 'UTF-8');
                $desc = htmlspecialchars($design->getImageFileCaption() ?: '', ENT_QUOTES, 'UTF-8');
                $fileType = $design->getFileType();
                ?>
                <div class="slide">
                    <div class="slide-content">
                        <?php if ($fileType === 'video'): ?>
                            <?php if (!empty($design->getVideoUrl())): ?>
                                <!-- YouTube/Vimeo embed -->
                                <iframe class="slide-video" src="<?= $design->getVideoUrl() ?>" frameborder="0"
                                    allow="autoplay; fullscreen" allowfullscreen style="width:100%; height:100%;"></iframe>
                            <?php elseif (!empty($design->getVideoFile())): ?>
                                <!-- Local MP4 -->
                                <video class="slide-video" autoplay muted loop controls>
                                    <source src="cmsadmin/img/Slider/<?= $design->getVideoFile() ?>" type="video/mp4">
                                </video>
                            <?php endif; ?>
                        <?php else: ?>
                            <!-- Image with reflection wrapper -->
                            <div class="slide-img-wrapper"
                                style="background-image: url('cmsadmin/img/Slider/<?= $design->getImage() ?>');">
                                <img src="cmsadmin/img/Slider/<?= $design->getImage() ?>" alt="<?= $title ?>" class="slide-img">
                            </div>
                        <?php endif; ?>

                        <!-- Caption (shown for all types) -->
                        <div class="slide-text">
                            <h2 class="slide-title"><?= $title ?></h2>
                            <p class="slide-desc"><?= $desc ?></p>
                        </div>
                    </div>
                </div>
                <?php
            endforeach;
        else:
            echo '<p style="color:#fff; text-align:center;">No slides to display</p>';
        endif;
        ?>
    </div>

    <?php if (count($designList) > 0): ?>
        <button class="carousel-btn prev">&#10094;</button>
        <button class="carousel-btn next">&#10095;</button>
    <?php endif; ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const carousel = document.querySelector('.carousel');
        const prevBtn = document.querySelector('.carousel-btn.prev');
        const nextBtn = document.querySelector('.carousel-btn.next');
        const wrapper = document.querySelector('.carousel-wrapper');

        // Get all slides (already generated by PHP)
        const slides = document.querySelectorAll('.slide');
        const slideCount = slides.length;

        if (slideCount === 0) return; // nothing to do

        let currentIndex = 0;
        let autoSlideInterval;

        function updateSlides() {
            slides.forEach((slide, index) => {
                slide.classList.remove('active', 'prev', 'next', 'hidden');

                // Calculate circular position relative to currentIndex
                let diff = (index - currentIndex + slideCount) % slideCount;

                if (diff === 0) {
                    slide.classList.add('active');
                } else if (diff === 1) {
                    slide.classList.add('next');
                } else if (diff === slideCount - 1) {
                    slide.classList.add('prev');
                } else {
                    slide.classList.add('hidden');
                }
            });
        }

        function moveNext() {
            currentIndex = (currentIndex + 1) % slideCount;
            updateSlides();
        }

        function movePrev() {
            currentIndex = (currentIndex - 1 + slideCount) % slideCount;
            updateSlides();
        }

        function startAutoSlide() {
            stopAutoSlide();
            autoSlideInterval = setInterval(moveNext, 5000);
        }

        function stopAutoSlide() {
            clearInterval(autoSlideInterval);
        }

        // Event listeners
        if (nextBtn) nextBtn.addEventListener('click', moveNext);
        if (prevBtn) prevBtn.addEventListener('click', movePrev);
        if (wrapper) {
            wrapper.addEventListener('mouseenter', stopAutoSlide);
            wrapper.addEventListener('mouseleave', startAutoSlide);
        }

        // Initialise
        updateSlides();
        startAutoSlide();
    });
</script>