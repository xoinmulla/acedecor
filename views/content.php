<?php
require_once "navigation.php";
require_once $_SERVER['DOCUMENT_ROOT']."/cmsadmin/dblayer/dbconnection.php";
require_once $_SERVER['DOCUMENT_ROOT']."/cmsadmin/dblayer/contentOps.php";

$maincontent = DBcontent::getLatestContent(type: "main");
$allContents = DBcontent::getAll();
?>

<style>
:root {
    --primary-dark: #1a1a1a;
    --primary-light: #2d2d2d;
    --gold: #c6a972;
    --white: #ffffff;
    --transition: all 0.3s ease;
}
body {
    background-color: var(--primary-dark);
    color: var(--white);
    font-family: 'Montserrat', sans-serif;
    overflow-x: hidden;
}
.content-wrapper {
    background-color: var(--primary-dark);
    padding-bottom: 60px;
    border-top: 1px solid rgba(198,169,114,0.3);
    border-bottom: 1px solid rgba(198,169,114,0.3);
    box-shadow: 0 0 20px rgba(0,0,0,0.4);
    border-radius: 0 0 20px 20px;
}
.carousel {
    border-radius: 5px;
    overflow: hidden;
    box-shadow: 0 10px 25px rgba(0,0,0,0.4);
}
.carousel-item img, .carousel-item video {
    height: 90vh;
    object-fit: cover;
    width: 100%;
    filter: brightness(70%);
    transition: var(--transition);
}
.carousel-item img:hover, .carousel-item video:hover {
    transform: scale(1.02);
}
.carousel-caption {
    bottom: 20%;
    text-align: center;
    color: var(--white);
    text-shadow: 0 4px 20px rgba(0,0,0,.6);
}
.carousel-caption p {
    font-size: 1rem;
    color: var(--gold);
    background: rgba(26,26,26,.6);
    display: inline-block;
    padding: 12px 20px;
    border-left: 3px solid var(--gold);
    border-right: 3px solid var(--gold);
}
.carousel-indicators [data-bs-target] {
    background-color: var(--white);
    border: 2px solid var(--gold);
    width: 14px; height: 14px; border-radius: 50%;
    opacity: .7;
}
.carousel-indicators .active {
    background-color: var(--gold);
    transform: scale(1.2);
}
.section-text {
    padding: 60px 30px;
    text-align: center;
}
.section-text h2 {
    color: var(--gold);
    font-size: 2.2rem;
    font-family: 'Playfair Display', serif;
    margin-bottom: 25px;
    position: relative;
}
.section-text h2::after {
    content: '';
    position: absolute;
    bottom: -15px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 3px;
    background-color: var(--gold);
}
.section-text p {
    color: var(--white);
    max-width: 1100px;
    margin: 40px auto 0;
    font-size: 1.1rem;
    line-height: 1.8;
    text-align: justify;
}
@media (max-width: 768px) {
    .carousel-item img, .carousel-item video { height: 60vh; }
    .section-text h2 { font-size: 1.8rem; }
}
</style>

<div class="container content-wrapper mt-5 mb-5 p-0">
    <?php 
    $mediaList = DBcontent::getMediaByContent($maincontent->getId());
    if (!empty($mediaList)): ?>
        <div id="contentCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <?php foreach ($mediaList as $i => $m): ?>
                    <button type="button" data-bs-target="#contentCarousel" data-bs-slide-to="<?= $i ?>" class="<?= $i===0?'active':'' ?>" <?= $i===0?'aria-current="true"':'' ?>></button>
                <?php endforeach; ?>
            </div>
            <div class="carousel-inner">
                <?php foreach ($mediaList as $i => $m): ?>
                <div class="carousel-item <?= $i===0 ? 'active' : '' ?>">
                    <?php if ($m['file_type'] === 'image'): ?>
                        <img src="/cmsadmin/img/Slider/<?= htmlspecialchars($m['image_file']) ?>" alt="<?= htmlspecialchars($m['alt_text'] ?? $maincontent->getTitle()) ?>">
                    <?php elseif ($m['file_type'] === 'video'): ?>
                        <?php if (!empty($m['video_url'])): ?>
                            <div class="ratio ratio-16x9">
                                <iframe src="<?= htmlspecialchars($m['video_url']) ?>" frameborder="0" allowfullscreen></iframe>
                            </div>
                        <?php elseif (!empty($m['video_file'])): ?>
                            <video class="d-block w-100" autoplay muted loop controls>
                                <source src="/acedecor/cmsadmin/img/Slider/<?= htmlspecialchars($m['video_file']) ?>" type="video/mp4">
                            </video>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if (!empty($m['caption'])): ?>
                    <div class="carousel-caption d-none d-md-block">
                        <p><?= htmlspecialchars($m['caption']) ?></p>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#contentCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#contentCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    <?php elseif ($maincontent && $maincontent->getImage()): ?>
        <img src="/cmsadmin/img/<?= htmlspecialchars($maincontent->getImage()) ?>" class="w-100" alt="<?= htmlspecialchars($maincontent->getTitle()) ?>">
    <?php endif; ?>

    <div class="section-text">
        <h2><?= htmlspecialchars($maincontent->getTitle()); ?></h2>
        <p><?= nl2br(htmlspecialchars($maincontent->getParagraph())); ?></p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php require_once("footer.php"); ?>
