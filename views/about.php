<?php 
require_once("navigation.php"); 
require_once $_SERVER['DOCUMENT_ROOT']."/acedecor/cmsadmin/dblayer/businessOps.php";

$business = DBbusiness::getBusinessDetails();
?>

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
        font-family: 'Montserrat', sans-serif;
    }
    .content-section {
        padding: 100px 0;
    }
    .section-header {
        text-align: center;
        margin-bottom: 60px;
    }
    .section-header h2 {
        font-size: 2.8rem;
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
        color: var(--gray-light);
        margin-top: 25px;
    }
    .about-content {
        background: var(--primary-light);
        padding: 40px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    }
    .about-image, .carousel-item video, .carousel-item iframe {
        width: 100%;
        height: 600px;
        object-fit: cover;
    }
    .about-title {
        color: var(--gold);
        font-size: 2rem;
        margin-top: 20px;
        border-left: 4px solid var(--gold);
        padding-left: 10px;
    }
    .about-text {
        color: var(--gray-light);
        font-size: 1.1rem;
        line-height: 1.8;
        margin-top: 20px;
    }
    .btn-discover {
        background: var(--gold);
        color: var(--primary-dark);
        border: none;
        padding: 12px 28px;
        margin-top: 20px;
        text-transform: uppercase;
        font-weight: 600;
        transition: var(--transition);
    }
    .btn-discover:hover {
        background: var(--gold-light);
        color: var(--primary-dark);
    }
    @media (max-width: 768px) {
        .about-image, .carousel-item video, .carousel-item iframe {
            height: 350px;
        }
    }
</style>

<div class="container content-section">
    <div class="section-header">
        <?php if (!empty($business->getAboutHeader())): ?>
            <h2><?= htmlspecialchars($business->getAboutHeader()); ?></h2>
        <?php endif; ?>
        <?php if (!empty($business->getAboutSubheading())): ?>
            <p><?= htmlspecialchars($business->getAboutSubheading()); ?></p>
        <?php endif; ?>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="about-content">
                <?php
                $mediaItems = DBbusiness::getBusinessMedia($business->getBusinessId());
                if (count($mediaItems) > 0):
                ?>
                <div id="aboutCarousel" class="carousel slide mb-4" data-bs-ride="false">
                    <div class="carousel-inner">
                        <?php foreach ($mediaItems as $i => $m): ?>
                        <?php
                            $fileName = htmlspecialchars($m['fileName'] ?? '');
                            $caption = htmlspecialchars($m['caption'] ?? '');
                            $url = htmlspecialchars($m['videoUrl'] ?? '');
                            $mediaType = $m['mediaType'];

                            // ✅ Convert YouTube/Vimeo links to proper embed URLs
                            if (!empty($url)) {
                                if (strpos($url, 'youtube.com/watch?v=') !== false) {
                                    parse_str(parse_url($url, PHP_URL_QUERY), $ytParams);
                                    $videoId = $ytParams['v'] ?? '';
                                    $url = "https://www.youtube.com/embed/$videoId?enablejsapi=1";
                                } elseif (strpos($url, 'youtu.be/') !== false) {
                                    $videoId = basename($url);
                                    $url = "https://www.youtube.com/embed/$videoId?enablejsapi=1";
                                } elseif (strpos($url, 'vimeo.com/') !== false) {
                                    $videoId = basename($url);
                                    $url = "https://player.vimeo.com/video/$videoId";
                                }
                            }
                        ?>
                        <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
                            <?php if ($mediaType === 'image'): ?>
                                <img src="/acedecor/cmsadmin/img/Slider/<?= $fileName ?>" class="about-image" alt="">
                            <?php elseif ($mediaType === 'video' && !empty($url)): ?>
                                <iframe class="yt-video" src="<?= $url ?>" allow="autoplay; fullscreen"></iframe>
                            <?php else: ?>
                                <video class="about-image local-video" muted controls preload="metadata">
                                    <source src="/acedecor/cmsadmin/img/Slider/<?= $fileName ?>" type="video/mp4">
                                </video>
                            <?php endif; ?>
                            <?php if (!empty($caption)): ?>
                                <div class="carousel-caption d-none d-md-block">
                                    <p><?= $caption ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <!-- Manual navigation buttons only -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#aboutCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#aboutCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
                <?php endif; ?>

                <?php if (!empty($business->getAboutTitle())): ?>
                    <h3 class="about-title"><?= htmlspecialchars($business->getAboutTitle()); ?></h3>
                <?php endif; ?>

                <?php if (!empty($business->getBusinessAboutBusiness())): ?>
                    <div class="about-text"><?= $business->getBusinessAboutBusiness(); ?></div>
                <?php endif; ?>

                <a href="/acedecor/views/contact/" class="btn btn-discover">Get In Touch</a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const carouselEl = document.querySelector('#aboutCarousel');
    if (!carouselEl) return;
    const carousel = bootstrap.Carousel.getOrCreateInstance(carouselEl);

    // Prevent auto-cycling completely
    carousel.pause();

    // Handle local <video> elements
    carouselEl.querySelectorAll('.local-video').forEach(video => {
        video.addEventListener('play', () => carousel.pause());
        video.addEventListener('pause', () => carousel.pause());
        video.addEventListener('ended', () => carousel.pause());
    });

    // Handle YouTube events via postMessage API
    window.addEventListener('message', function(e) {
        const data = e.data;
        if (typeof data === 'string' && data.indexOf('{"event":"') === 0) {
            const json = JSON.parse(data);
            if (json.event === 'onStateChange') {
                // 1 = playing, 2 = paused, 0 = ended
                carousel.pause();
            }
        }
    });

    // Add IDs to YouTube iframes
    document.querySelectorAll('.yt-video').forEach((iframe, i) => {
        iframe.id = 'ytplayer-' + i;
    });
});
</script>

<?php require_once("footer.php"); ?>
