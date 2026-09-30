<?php
require_once(__DIR__ . "/../cmsadmin/dblayer/businessOps.php");
require_once(__DIR__ . "/../cmsadmin/dblayer/categoryOps.php");
require_once(__DIR__ . "/../cmsadmin/dblayer/postOps.php");
require_once __DIR__ . "/../cmsadmin/dblayer/socialMediaHandleOps.php";
$business = DBbusiness::getBusinessDetails();
$socialMediaHandles = DBsocialMediaHandle::read();
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="author" content="Square Edge Technologies" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo isset($post) ? $post->getPostTitle() : "ACE DECORS"; ?></title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600&family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">

  <style>
    :root {
      --primary-dark: #1a1a1a;
      --primary-light: #2d2d2d;
      --gold: #c6a972;
      --gold-light: #d8c092;
      --white: #ffffff;
      --transition: all 0.3s ease;
      --transition-slow: all 0.5s ease;
    }

    body {
      font-family: 'Montserrat', sans-serif;
      background: var(--primary-dark);
      color: var(--white);
      overflow-x: hidden;
    }

    h1, h2, h3, h4, h5, h6 {
      font-family: 'Playfair Display', serif;
    }

    /* Top Strip */
    .top-strip {
      background: var(--primary-light);
      padding: 8px 0;
      font-size: 0.9rem;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .top-info {
      display: flex;
      align-items: center;
      margin-bottom: 5px;
      justify-content: flex-end;
    }

    .top-info i {
      color: var(--gold);
      margin-right: 8px;
      transition: var(--transition);
    }

    .top-info a {
      color: var(--white);
      text-decoration: none;
      transition: var(--transition);
      position: relative;
    }

    .top-info a:hover {
      color: var(--gold);
      transform: translateY(-2px);
    }

    .top-info a:hover i {
      transform: scale(1.2);
    }

    .social-icon {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 34px;
      height: 34px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.05);
      margin-left: 8px;
      color: var(--white);
      transition: var(--transition);
      position: relative;
      overflow: hidden;
    }

    .social-icon::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
      transition: var(--transition-slow);
    }

    .social-icon:hover {
      background: var(--gold);
      color: var(--primary-dark) !important;
      transform: translateY(-3px) scale(1.1);
      box-shadow: 0 5px 15px rgba(198, 169, 114, 0.3);
    }

    .social-icon:hover::before {
      left: 100%;
    }

    /* Navbar */
    .navbar {
      background: var(--primary-dark) !important;
      padding: 12px 0;
      border-bottom: 1px solid rgba(255, 255, 255, 0.05);
      transition: var(--transition);
    }

    .navbar.scrolled {
      padding: 8px 0;
      background: rgba(26, 26, 26, 0.95) !important;
      backdrop-filter: blur(10px);
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
    }

    .navbar-brand {
      position: relative;
      overflow: hidden;
    }

    .navbar-brand::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: -100%;
      width: 100%;
      height: 2px;
      background: var(--gold);
      transition: var(--transition);
    }

    .navbar-brand:hover::after {
      left: 0;
    }

    .nav-link {
      font-weight: 500;
      color: var(--white) !important;
      padding: 15px 18px !important;
      transition: var(--transition);
      text-transform: uppercase;
      font-size: 0.9rem;
      letter-spacing: 0.5px;
      position: relative;
    }

    .nav-link::before {
      content: '';
      position: absolute;
      bottom: 0;
      left: 50%;
      width: 0;
      height: 2px;
      background: var(--gold);
      transition: var(--transition);
      transform: translateX(-50%);
    }

    .nav-link:hover::before,
    .nav-link.active::before {
      width: 80%;
    }

    .nav-link:hover, .nav-link.active {
      color: var(--gold) !important;
      transform: translateY(-2px);
    }

    .dropdown-menu {
      background: var(--primary-light);
      border: none;
      border-radius: 0;
      padding: 10px;
      min-width: 220px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
      transform: translateY(10px);
      opacity: 0;
      visibility: hidden;
      transition: all 0.3s ease;
      display: block;
    }

    .dropdown:hover .dropdown-menu,
    .dropdown.show .dropdown-menu {
      transform: translateY(0);
      opacity: 1;
      visibility: visible;
    }

    .dropdown-item {
      color: var(--white);
      padding: 10px 15px;
      transition: var(--transition);
      font-size: 0.9rem;
      position: relative;
      overflow: hidden;
    }

    .dropdown-item::before {
      content: '';
      position: absolute;
      left: -100%;
      top: 0;
      width: 100%;
      height: 100%;
      background: var(--gold);
      transition: var(--transition);
      z-index: -1;
    }

    .dropdown-item:hover {
      background: transparent;
      color: var(--primary-dark) !important;
      padding-left: 20px;
      transform: translateX(5px);
    }

    .dropdown-item:hover::before {
      left: 0;
    }

    /* Mobile-specific styles */
    @media (max-width: 767.98px) {
      .top-strip {
        padding: 6px 0;
        font-size: 0.8rem;
      }
      
      .top-info {
        margin-bottom: 8px;
        justify-content: flex-start;
      }
      
      .social-icons-container {
        display: flex;
        justify-content: center;
        margin-top: 10px;
      }
      
      .navbar-brand {
        font-size: 1.5rem;
      }
      
      .nav-link {
        padding: 12px 15px !important;
        font-size: 1rem;
      }
      
      .dropdown-menu {
        margin-left: 15px;
        width: calc(100% - 30px);
        min-width: auto;
        transform: none !important;
        opacity: 1 !important;
        visibility: visible !important;
        display: none;
      }
      
      .dropdown-menu.show {
        display: block;
      }
      
      .dropdown-toggle::after {
        float: right;
        margin-top: 8px;
      }
    }

    /* Tablet-specific styles */
    @media (min-width: 768px) and (max-width: 991.98px) {
      .top-info {
        margin-bottom: 8px;
        justify-content: center;
      }
      
      .top-strip .row {
        text-align: center;
      }
      
      .social-icons-container {
        display: flex;
        justify-content: center;
        margin-top: 10px;
      }
      
      .nav-link {
        padding: 12px 15px !important;
        font-size: 0.85rem;
      }
    }

    /* Desktop-specific styles */
    @media (min-width: 992px) {
      .top-info {
        margin-bottom: 0;
        justify-content: flex-end;
      }
      
      .top-strip .row {
        align-items: center;
      }
      
      /* --- NEW STYLES FOR DOWNWARD-FACING DROPDOWNS --- */

      /* Style the sub-category dropdown container */
      .dropdown-menu .dropdown {
        position: relative;
      }

      /* Make the sub-menu static to appear within the parent dropdown */
      .dropdown-menu .dropdown .dropdown-menu {
        position: static;
        display: none; /* Hidden by default */
        width: 100%;
        background-color: transparent;
        border: none;
        box-shadow: none;
        padding-left: 15px; /* Indent the sub-menu */
        margin: 0;
        transform: none;
        opacity: 1;
        visibility: visible;
      }
      
      /* Show the nested menu when its parent li is hovered */
      .dropdown-menu .dropdown:hover > .dropdown-menu {
        display: block;
      }

      /* Style for the post-level links for clarity */
      .dropdown-menu .dropdown .dropdown-menu .dropdown-item {
        font-size: 0.85rem;
        color: var(--gold-light);
      }

      /* Hover effect for post-level links */
      .dropdown-menu .dropdown .dropdown-menu .dropdown-item:hover {
        color: var(--primary-dark) !important;
        background-color: transparent;
        padding-left: 25px; /* Enhance indent on hover */
      }

      .dropdown-menu .dropdown .dropdown-menu .dropdown-item::before {
        background: var(--gold-light);
      }
    }

    /* Animation classes */
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

    @keyframes pulse {
      0% {
        transform: scale(1);
      }
      50% {
        transform: scale(1.05);
      }
      100% {
        transform: scale(1);
      }
    }

    .animate-fadeInUp {
      animation: fadeInUp 0.6s ease-out;
    }

    .animate-pulse {
      animation: pulse 2s infinite;
    }

    /* Loading animation */
    .loading-bar {
      position: fixed;
      top: 0;
      left: 0;
      height: 3px;
      background: var(--gold);
      width: 0%;
      z-index: 9999;
      transition: width 0.3s ease;
    }

    /* Enhanced navbar toggler */
    .navbar-toggler {
      border: 1px solid rgba(255,255,255,0.1);
      padding: 4px 8px;
      transition: var(--transition);
    }

    .navbar-toggler:hover {
      border-color: var(--gold);
      transform: scale(1.1);
    }

    .navbar-toggler:focus {
      box-shadow: 0 0 0 2px rgba(198, 169, 114, 0.25);
    }

    /* Contact info section styling */
    .contact-info {
      display: flex;
      align-items: center;
      justify-content: flex-end;
      gap: 20px;
    }

    .contact-item {
      display: flex;
      align-items: center;
      gap: 5px;
    }
    .contact-item a {
      color: var(--white);
      text-decoration: none;
      transition: var(--transition);
      position: relative;
    }
    .contact-item a:hover {
      color: var(--gold);
      transform: translateY(-2px);
    }
    
    @media (max-width: 991.98px) {
      .contact-info {
        justify-content: center;
        margin-top: 10px;
      }
    }
  </style>
</head>

<body>
  <div class="loading-bar"></div>

  <div class="container-fluid top-strip d-none d-md-block">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-4">
          <div class="top-info" style="justify-content: flex-start;">
            <i class="fas fa-phone-alt"></i>
            <a href="tel:<?php echo $business->getBusinessContact(); ?>">
              <?php echo $business->getBusinessContact(); ?>
            </a>
            <span class="mx-2">|</span>
            <a href="tel:<?php echo $business->getBusinessContact2(); ?>">
              <?php echo $business->getBusinessContact2(); ?>
            </a>
          </div>
        </div>
        <div class="col-md-8">
          <div class="contact-info">
            <div class="contact-item">
              <i class="fas fa-envelope"></i>
              <a href="mailto:<?php echo $business->getBusinessEmail(); ?>">
                <?php echo $business->getBusinessEmail(); ?>
              </a>
            </div>
            <div class="social-icons-container">
              <?php
              foreach ($socialMediaHandles as $handle) {
                echo '<a class="social-icon" href="' . $handle->getHandle() . '" target="_blank" title="' . $handle->getName() . '">' . $handle->getIcon() . '</a>';
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container">
      <a class="navbar-brand" href="/about/">
        <span style="font-family: 'Montserrat', serif; color: var(--gold); font-size: 28px;">ACE</span>
        <span style="font-family: 'Montserrat', sans-serif; color: var(--white); font-size: 28px;">DECORS</span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link active" href="/">Home</a></li>

          <?php
          // ---------- CATEGORIES THAT HAVE SUBCATEGORIES ----------
          $categoryList = DBcategory::getCategoryHasSubCategory();
          foreach ($categoryList as $category) {
            if (empty($category->getMappedSubCategory())) {
              echo '<li class="nav-item"><a class="nav-link" href="#">' . ucfirst(strtolower($category->getCategoryName())) . '</a></li>';
            } else {
              $dropdown = '<li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="cat' . $category->getCategoryId() . '" role="button" data-bs-toggle="dropdown" aria-expanded="false">'
                  . ucfirst(strtolower($category->getCategoryName())) .
                '</a>
                <ul class="dropdown-menu" aria-labelledby="cat' . $category->getCategoryId() . '">';

              // Loop subcategories
              foreach ($category->getMappedSubCategory($category->getCategoryId()) as $subcategory) {
                $dropdown .= '<li class="dropdown"> 
                  <a class="dropdown-item dropdown-toggle" href="#" id="sub' . $subcategory->getSubCategoryId() . '" data-bs-toggle="dropdown" aria-expanded="false">'
                    . ucfirst(strtolower($subcategory->getSubCategoryName())) .
                  '</a>
                  <ul class="dropdown-menu" aria-labelledby="sub' . $subcategory->getSubCategoryId() . '">';

                // Loop posts under subcategory
                $postList = DBpost::getPostBySubCategoryFornt($subcategory->getSubCategoryId());
                foreach ($postList as $navpost) {
                  $dropdown .= '<li><a class="dropdown-item" href="' . $navpost->getPostUrl() . '">' . ucfirst(strtolower($navpost->getPostTitle())) . '</a></li>';
                }

                $dropdown .= '</ul></li>';
              }

              $dropdown .= '</ul></li>';
              echo $dropdown;
            }
          }

          // ---------- CATEGORIES WITHOUT SUBCATEGORIES ----------
          $categoryList = DBcategory::getCategorydoesnthavesubcategory();
          foreach ($categoryList as $category) {
            $postList = DBpost::getPostByCategoryFornt($category->getCategoryId());
            $dropdown = '<li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="cat' . $category->getCategoryId() . '" role="button" data-bs-toggle="dropdown" aria-expanded="false">'
                . ucfirst(strtolower($category->getCategoryName())) .
              '</a>
              <ul class="dropdown-menu" aria-labelledby="cat' . $category->getCategoryId() . '">';

            foreach ($postList as $navpost) {
              $dropdown .= '<li><a class="dropdown-item" href="' . $navpost->getPostUrl() . '">' . ucfirst(strtolower($navpost->getPostTitle())) . '</a></li>';
            }

            $dropdown .= '</ul></li>';
            echo $dropdown;
          }
          ?>
        </ul>
      </div>
    </div>
  </nav>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Loading bar animation
    window.addEventListener('load', function() {
      const loadingBar = document.querySelector('.loading-bar');
      loadingBar.style.width = '100%';
      setTimeout(() => {
        loadingBar.style.opacity = '0';
        setTimeout(() => {
          loadingBar.remove();
        }, 300);
      }, 500);
    });

    // Update loading bar during page load
    window.addEventListener('beforeunload', function() {
      document.querySelector('.loading-bar').style.width = '100%';
    });

    // Navbar scroll effect
    window.addEventListener('scroll', function() {
      const navbar = document.querySelector('.navbar');
      if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
    });

    // Enhanced dropdown functionality
    document.addEventListener('DOMContentLoaded', function() {
      // Close dropdowns when clicking outside
      document.addEventListener('click', function(e) {
        if (!e.target.matches('.dropdown-toggle') && !e.target.closest('.dropdown-menu')) {
          closeAllDropdowns();
        }
      });

      // Handle dropdown toggle clicks
      document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
        toggle.addEventListener('click', function(e) {
          e.preventDefault();
          e.stopPropagation();
          
          const dropdown = this.closest('.dropdown');
          const isOpen = dropdown.classList.contains('show');
          
          // Close all dropdowns first
          closeAllDropdowns();
          
          // If this dropdown wasn't open, open it
          if (!isOpen) {
            dropdown.classList.add('show');
            const dropdownMenu = dropdown.querySelector('.dropdown-menu');
            if (dropdownMenu) {
              dropdownMenu.classList.add('show');
            }
          }
        });
      });

      // Close all dropdowns function
      function closeAllDropdowns() {
        document.querySelectorAll('.dropdown').forEach(dropdown => {
          dropdown.classList.remove('show');
          const dropdownMenu = dropdown.querySelector('.dropdown-menu');
          if (dropdownMenu) {
            dropdownMenu.classList.remove('show');
          }
        });
      }

      // Mobile dropdown enhancements
      if (window.innerWidth < 992) {
        document.querySelectorAll('.dropdown-menu .dropdown-toggle').forEach(toggle => {
          toggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const parentDropdown = this.closest('.dropdown');
            const submenu = parentDropdown.querySelector('.dropdown-menu');
            
            if (submenu) {
              const isVisible = submenu.style.display === 'block';
              submenu.style.display = isVisible ? 'none' : 'block';
            }
          });
        });
      }
    });

    // Enhanced hover dropdown for desktop (only if not mobile)
    if (window.innerWidth > 992) {
      document.querySelectorAll('.nav-item.dropdown').forEach(item => {
        item.addEventListener('mouseenter', () => {
          let dropdownMenu = item.querySelector('.dropdown-menu');
          if (dropdownMenu) {
            item.classList.add('show');
            dropdownMenu.classList.add('show');
          }
        });
        item.addEventListener('mouseleave', () => {
          let dropdownMenu = item.querySelector('.dropdown-menu');
          if (dropdownMenu) {
            item.classList.remove('show');
            dropdownMenu.classList.remove('show');
          }
        });
      });

      // Add animation to dropdown items on hover
      document.querySelectorAll('.dropdown-item').forEach(item => {
        item.addEventListener('mouseenter', function() {
          this.style.transform = 'translateX(5px)';
        });
        item.addEventListener('mouseleave', function() {
          this.style.transform = 'translateX(0)';
        });
      });
    }

    // Add subtle animation to navbar brand on hover
    document.querySelector('.navbar-brand').addEventListener('mouseenter', function() {
      this.style.transform = 'scale(1.05)';
    });
    
    document.querySelector('.navbar-brand').addEventListener('mouseleave', function() {
      this.style.transform = 'scale(1)';
    });

    // Add click animation to social icons
    document.querySelectorAll('.social-icon').forEach(icon => {
      icon.addEventListener('click', function() {
        this.style.transform = 'scale(0.9)';
        setTimeout(() => {
          this.style.transform = '';
        }, 300);
      });
    });
  </script>
</body>
</html>