<?php require_once("navigation.php"); ?>
<?php require_once("slider.php"); ?>
<?php
require_once $_SERVER['DOCUMENT_ROOT']."/acedecor/cmsadmin/dblayer/dbconnection.php";
require_once $_SERVER['DOCUMENT_ROOT']."/acedecor/cmsadmin/dblayer/contentOps.php";

$maincontent = DBcontent::getLatestContent(type: "main");
$postcontent = DBcontent::getLatestContent(type: "post");
$allContents = DBcontent::getAll();
?>
<style>
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
    h1, h2, h3, h4, h5, h6 {
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
    background: transparent; /* makes card see-through */
    padding: 40px;
    box-shadow: 0 15px 30px rgba(0,0,0,0.3);
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
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
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
            <a href="/acedecor/views/content" class="btn-discover">Discover Our Story</a>
        </div>
    </div>
</div> -->
<br><br><br>
<div class="row justify-content-center"> 
    <div class="col-lg-12">
        <div class="content-card animate-fade-in-up">
            <?php if ($maincontent): ?>
                <h3 class="content-title"><?= htmlspecialchars((string) $maincontent->getTitle(), ENT_QUOTES, 'UTF-8'); ?></h3>

                <div class="content-text">
                    <?= nl2br(htmlspecialchars((string) $maincontent->getBrief(), ENT_QUOTES, 'UTF-8')); ?>
                </div>

                <a href="/acedecor/views/content" class="btn-discover">Discover</a>
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
                <h3 class="content-title"><?= htmlspecialchars((string) $postcontent->getTitle(), ENT_QUOTES, 'UTF-8'); ?></h3>

                <div class="content-text">
                    <?= nl2br(htmlspecialchars((string) $postcontent->getParagraph(), ENT_QUOTES, 'UTF-8')); ?>
                </div>

                <!-- <a href="/acedecor/views/content" class="btn-discover">Discover</a> -->
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

<script>
    // Add scroll animation to elements
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