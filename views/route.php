<?php
require_once("cmsadmin/dblayer/postOps.php");

class route
{
    public static function get($routePath)
    {
        $post = DBpost::getPostByUrl($routePath);
        error_log("Fetched post for route '" . $routePath . "': " . ($post ? $post->getPostTitle() : "No post found"));

        $postId = $post->getPostId();

        ob_start();
        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Acedecor Posts | <?= htmlspecialchars($post->getPostTitle() ?? '') ?></title>
            <link
                href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600&display=swap"
                rel="stylesheet">
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
                    font-family: "Montserrat", "Helvetica Neue", Arial, sans-serif;
                    line-height: 1.6;
                    overflow-x: hidden;
                    margin: 0;
                    padding: 0;
                }

                h1,
                h2,
                h3,
                h4,
                h5,
                h6 {
                    font-family: "Playfair Display", Georgia, serif;
                    font-weight: 600;
                    letter-spacing: 0.5px;
                }

                .content-section {
                    padding: 80px 0;
                    position: relative;
                }

                .content-section::before {
                    content: "";
                    position: absolute;
                    top: 0;
                    left: 0;
                    right: 0;
                    height: 1px;
                    background: linear-gradient(90deg, transparent, var(--gold), transparent);
                }

                .section-header {
                    text-align: center;
                    margin-bottom: 50px;
                    position: relative;
                }

                .section-header h2 {
                    font-size: 2.5rem;
                    font-weight: 500;
                    margin-bottom: 20px;
                    color: var(--white);
                    display: inline-block;
                    position: relative;
                }

                .section-header h2::after {
                    content: "";
                    position: absolute;
                    bottom: -15px;
                    left: 50%;
                    transform: translateX(-50%);
                    width: 80px;
                    height: 3px;
                    background-color: var(--gold);
                }

                .btn-discover {
                    display: inline-block;
                    font-weight: 500;
                    color: var(--primary-dark);
                    background-color: var(--gold);
                    padding: 14px 32px;
                    text-decoration: none;
                    text-transform: uppercase;
                    font-size: 0.9rem;
                    transition: var(--transition);
                }

                .btn-discover:hover {
                    background-color: var(--gold-light);
                }

                .single-post-content {
                    background: var(--primary-light);
                    padding: 40px;
                    margin-bottom: 30px;
                }

                .single-post-img {
                    margin-bottom: 30px;
                }

                .single-post-img img {
                    width: 100%;
                    height: auto;
                }

                .sidebar-widget {
                    background: var(--primary-light);
                    padding: 30px;
                    margin-bottom: 30px;
                }

                .sidebar-widget h4 {
                    font-size: 1.5rem;
                    color: var(--white);
                    margin-bottom: 25px;
                    position: relative;
                    padding-bottom: 15px;
                }

                .sidebar-widget h4::after {
                    content: "";
                    position: absolute;
                    bottom: 0;
                    left: 0;
                    width: 40px;
                    height: 2px;
                    background-color: var(--gold);
                }

                .categories-list {
                    list-style: none;
                    padding: 0;
                    margin: 0;
                }

                .categories-list li {
                    margin-bottom: 12px;
                    padding-bottom: 12px;
                    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
                }

                .categories-list a {
                    color: var(--gray-light);
                    text-decoration: none;
                    transition: var(--transition);
                }

                .categories-list a:hover {
                    color: var(--gold);
                }

                .popular-item {
                    display: flex;
                    align-items: center;
                    margin-bottom: 20px;
                    gap: 15px;
                }

                .popular-img img {
                    width: 150px;
                    height: 100px;
                    object-fit: cover;
                    border-radius: 5px;
                }

                .popular-content a {
                    color: #fff;
                    text-decoration: none;
                    font-size: 0.95rem;
                    font-weight: 500;
                    transition: 0.3s;
                }

                .popular-content a:hover {
                    color: #c6a972;
                }
            </style>
        </head>

        <body>

            <?php require_once("navigation.php"); ?>

            <div class="container content-section">
                <div class="row">
                    <!-- Main Post Content -->
                    <div class="col-lg-8 col-md-12">
                        <div class="single-post-content animate-fade-in-up">
                            <div class="single-post-img">
                                <?php
                                $postId = $post->getPostId();
                                require("slider.php");
                                ?>
                            </div>
                            <h3><?= htmlspecialchars($post->getPostTitle() ?? '') ?></h3>
                            <?= $post->getPostDescription() ?>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="col-lg-4 col-md-12">
                        <!-- Popular Posts (use main/global slider, not post slider) -->
                        <div class="sidebar-widget">
                            <h4>Popular Posts</h4>

                            <?php
                            $postList = DBpost::getPopularPosts((int) $post->getPostId());

                            if (!empty($postList)) {
                                foreach ($postList as $popularPost) {
                                    ?>

                                    <div class="popular-item">
                                        <div class="popular-img">
                                            <img src="/cmsadmin/img/Slider/<?= $popularPost->getImage() ?>">
                                        </div>

                                        <div class="popular-content">
                                            <a href="<?= $popularPost->getPostUrl() ?>">
                                                <?= ucfirst(strtolower($popularPost->getPostTitle())) ?>
                                            </a>
                                        </div>
                                    </div>

                                    <?php
                                }
                            } else {
                                echo "<p>No popular posts found</p>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            


            <!-- Newsletter -->
            <div class="sidebar-widget" style="max-width: 85%; margin: 20px auto;">
                <h4>Newsletter</h4>
                <p style="color: var(--gray-light); margin-bottom: 20px;">
                    Get our products/news earlier than others, let’s get in touch.
                </p>
                <div class="newsletter-form">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Enter Email">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">Subscribe</button>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            </div>
            </div>

            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    const animatedElements = document.querySelectorAll(".animate-fade-in-up");
                    const observer = new IntersectionObserver(entries => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                entry.target.style.visibility = "visible";
                                entry.target.classList.add("animate-fade-in-up");
                                observer.unobserve(entry.target);
                            }
                        });
                    }, { threshold: 0.1 });
                    animatedElements.forEach(el => {
                        el.style.visibility = "hidden";
                        observer.observe(el);
                    });
                });
            </script>

            <?php require("footer.php"); ?>

        </body>

        </html>
        <?php
        echo ob_get_clean();
    }
}
