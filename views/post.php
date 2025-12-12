<?php
// For post.php - replace the entire content of the file with this code
include('navigation.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acedecor | Post<?php echo $post->getPostTitle(); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
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
            font-family: "Montserrat", "Helvetica Neue", Arial, sans-serif;
            line-height: 1.6;
            overflow-x: hidden;
            margin: 0;
            padding: 0;
        }
        
        /* Improved Typography */
        h1, h2, h3, h4, h5, h6 {
            font-family: "Playfair Display", Georgia, serif;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        
        /* Section Spacing & Headers */
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
            position: relative;
            display: inline-block;
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
        
        .section-header p {
            font-size: 1.1rem;
            color: var(--gray-light);
            max-width: 700px;
            margin: 30px auto 0;
            line-height: 1.8;
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
            content: "";
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
            border-radius: 0;
            overflow: hidden;
            margin-bottom: 30px;
            background: var(--primary-light);
            transition: var(--transition);
            position: relative;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            height: 100%;
        }
        
        .card:hover {
            transform: translateY(-5px);
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
            font-family: "Playfair Display", Georgia, serif;
        }
        
        .card-text {
            font-size: 0.95rem;
            line-height: 1.7;
            color: var(--gray-light);
            margin-bottom: 25px;
        }
        
        /* Post Content Styling */
        .single-post-content {
            background: var(--primary-light);
            padding: 40px;
            margin-bottom: 30px;
        }
        
        .single-post-content h3 {
            font-size: 2.2rem;
            margin-bottom: 25px;
            color: var(--white);
            position: relative;
            padding-bottom: 15px;
        }
        
        .single-post-content h3::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background-color: var(--gold);
        }
        
        .single-post-content p, 
        .single-post-content li {
            font-size: 1.1rem;
            line-height: 1.8;
            color: var(--gray-light);
            margin-bottom: 20px;
        }
        
        .single-post-img {
            position: relative;
            overflow: hidden;
            margin-bottom: 30px;
        }
        
        .single-post-img img {
            width: 100%;
            height: auto;
            transition: var(--transition);
        }
        
        .single-post-img:hover img {
            transform: scale(1.03);
        }
        
        /* Sidebar Styling */
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
        
        .categories-list li:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }
        
        .categories-list a {
            color: var(--gray-light);
            text-decoration: none;
            transition: var(--transition);
            display: block;
            position: relative;
            padding-left: 20px;
        }
        
        .categories-list a::before {
            content: "→";
            position: absolute;
            left: 0;
            color: var(--gold);
            transition: var(--transition);
        }
        
        .categories-list a:hover {
            color: var(--gold);
            padding-left: 25px;
        }
        
        .popular-post-item {
            display: flex;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .popular-post-item:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }
        
        .popular-post-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            margin-right: 15px;
            transition: var(--transition);
        }
        
        .popular-post-item:hover .popular-post-img {
            transform: scale(1.05);
        }
        
        .popular-post-content h5 {
            margin: 0 0 8px 0;
            font-size: 1rem;
        }
        
        .popular-post-content h5 a {
            color: var(--white);
            text-decoration: none;
            transition: var(--transition);
        }
        
        .popular-post-content h5 a:hover {
            color: var(--gold);
        }
        
        .popular-post-content span {
            font-size: 0.85rem;
            color: var(--gray-light);
        }
        
        .newsletter-form {
            position: relative;
        }
        
        .newsletter-form .form-control {
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--white);
            border-radius: 0;
            padding: 12px 15px;
            height: auto;
        }
        
        .newsletter-form .form-control:focus {
            box-shadow: none;
            border-color: var(--gold);
            background-color: rgba(255, 255, 255, 0.08);
        }
        
        .newsletter-form .btn-primary {
            background-color: var(--gold);
            border-color: var(--gold);
            color: var(--primary-dark);
            border-radius: 0;
            padding: 12px 20px;
            font-weight: 500;
            transition: var(--transition);
        }
        
        .newsletter-form .btn-primary:hover {
            background-color: var(--gold-light);
            border-color: var(--gold-light);
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
                padding: 60px 0;
            }
            
            .single-post-content {
                padding: 30px;
            }
        }
        
        @media (max-width: 768px) {
            .section-header h2 {
                font-size: 2rem;
            }
            
            .single-post-content {
                padding: 20px;
            }
            
            .sidebar-widget {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container content-section">
        <div class="row">
            <div class="col-lg-8 col-md-12">
                <div class="single-post-content animate-fade-in-up">
                    <div class="single-post-img">
                        <img src="cmsadmin/img/Post/<?php echo $post->getImage(); ?>" alt="<?php echo $post->getAltTextImage(); ?>">
                    </div>
                    <h3><?php echo $post->getPostTitle(); ?></h3>
                    <?php echo $post->getPostDescription(); ?>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="sidebar-widget">
                    <h4>Categories</h4>
                    <ul class="categories-list">
                        <?php foreach ($post->getMappedSubCategory() as $subcategory){
                            echo '<li><a href="javascript:void(0);">'.$subcategory->getSubCategoryName().'</a></li>';
                        }?>
                    </ul>
                </div>
                
                <div class="header">
                            <h2>Popular Posts</h2>                        
                        </div>
                        <div class="body widget popular-post">
                            <div class="row">
                                <div class="col-lg-12">
                                    <?php $postList=DBpost::getPostBySubCategoryId($postId);
                                    foreach ($postList as $post){
                                    echo '<div class="single_post">
                                        <p class="m-b-0"><a href="postDetails.php?id='.$post->getPostId().'">'.$post->getPostTitle().'</a></p>
                                        <span>'.$post->getPostCreatedBy().'</span>
                                        <div class="img-post">
                                            <img src="../img/post/'.$post->getImage().'" alt="'. $post->getAltTextImage().'">                                        
                                        </div>                                            
                                    </div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
            
                <div class="sidebar-widget">
                    <h4>Newsletter</h4>
                    <p style="color: var(--gray-light); margin-bottom: 20px;">Get our products/news earlier than others, let's get in touch.</p>
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
        // Add scroll animation to elements
        document.addEventListener("DOMContentLoaded", function() {
            const animatedElements = document.querySelectorAll(".animate-fade-in-up");
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.visibility = "visible";
                        entry.target.classList.add("animate-fade-in-up");
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1
            });
            
            animatedElements.forEach(element => {
                element.style.visibility = "hidden";
                observer.observe(element);
            });
        });
    </script>
    
    <?php include('footer.php'); ?>
</body>
</html>