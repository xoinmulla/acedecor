<?php
require_once __DIR__ . "/../cmsadmin/dblayer/sliderImageOps.php";
require_once __DIR__ . "/../cmsadmin/model/sliderImageModel.php";
?>

<style>
    /* Luxury Slider Styling */
    .carousel {
        position: relative;
        overflow: hidden;
    }

    .carousel-item img {
        height: 90vh;
        object-fit: cover;
        filter: brightness(70%);
    }

    .carousel-caption {
        bottom: 20%;
        text-align: center;
        color: var(--white);
        text-shadow: 0 4px 20px rgba(0, 0, 0, 0.6);
        animation: fadeInUp 1.2s ease;
    }

    .carousel-caption p {
        font-size: 0.6rem;
        font-weight: 500;
        letter-spacing: 1px;
        color: var(--gold);
        font-family: 'Playfair Display', serif;
        background: rgba(26, 26, 26, 0.6);
        display: inline-block;
        padding: 12px 20px;
        border-left: 3px solid var(--gold);
        border-right: 3px solid var(--gold);
    }

    /* Controls */
    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        background-size: 60% 60%;
        background-color: rgba(0, 0, 0, 0.4);
        border-radius: 50%;
        padding: 25px;
        transition: var(--transition);
    }

    .carousel-control-prev-icon:hover,
    .carousel-control-next-icon:hover {
        background-color: var(--gold);
    }

    /* Indicators */
    .carousel-indicators [data-bs-target] {
        background-color: var(--white);
        border: 2px solid var(--gold);
        width: 14px;
        height: 14px;
        border-radius: 50%;
        transition: var(--transition);
        opacity: 0.7;
    }

    .carousel-indicators .active {
        background-color: var(--gold);
        transform: scale(1.2);
        opacity: 1;
    }

    /* Animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(40px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Mobile adjustments */
    @media (max-width: 768px) {
        .carousel-item img {
            height: 60vh;
        }
        .carousel-caption p {
            font-size: 1.2rem;
            padding: 8px 16px;
        }
    }
</style>

<div id="carouselExampleDark" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <?php
        $count = 0;
        $isActive = "active";
        $initialValue = 'aria-current="true"';
        $designList = DBsliderImageFile::readByPostId(0??0);
        foreach ($designList as $design) {
            echo '<button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="' . $count . '" class="' . $isActive . '" ' . $initialValue . ' aria-label="Slide ' . ($count + 1) . '"></button>';
            $isActive = "";
            $initialValue = "";
            $count++;
        }
        ?>
    </div>
    <div class="carousel-inner">
        <?php
        $isActive = "active";
        $designList = DBsliderImageFile::readByPostId(0??0);
        if (count($designList) > 0) {
            foreach ($designList as $design) {
    echo '<div class="carousel-item ' . $isActive . '" data-bs-interval="5000">';
    
    if ($design->getFileType() === "video") {
        // Check if it’s YouTube or local MP4
        if (!empty($design->getVideoUrl())) {
            // YouTube / Vimeo embed
            echo '<div class="ratio ratio-16x9">
                    <iframe src="' . $design->getVideoUrl() . '" 
                            frameborder="0" 
                            allow="autoplay; fullscreen" 
                            allowfullscreen>
                    </iframe>
                  </div>';
        } elseif (!empty($design->getVideoFile())) {
            // Local MP4
            echo '<video class="d-block w-100" autoplay muted loop controls>
                    <source src="cmsadmin/img/Slider/' . $design->getVideoFile() . '" type="video/mp4">
                    Your browser does not support the video tag.
                  </video>';
        }
    } else {
        // Default image
        echo '<img src="cmsadmin/img/Slider/' . $design->getImage() . '" 
                   class="d-block w-100 img-fluid" 
                   alt="' . htmlspecialchars($design->getImageAlternateText(), ENT_QUOTES, 'UTF-8') . '">';
    }

    // Caption (for all types)
    echo '<div class="carousel-caption d-none d-md-block">
            <p>' . $design->getImageFileCaption() . '</p>
          </div>
        </div>';

    $isActive = "";
}

            echo '</div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>';
        } else {
            echo "No images to display";
        }
        ?>
</div>
