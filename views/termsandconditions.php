<?php 
require_once("navigation.php"); 
require_once $_SERVER['DOCUMENT_ROOT'] . "/cmsadmin/model/termsandconditionsModel.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/cmsadmin/dblayer/termsandconditionsOps.php";
?>

<style>
    /* Same Luxury Styling as Privacy Page */
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

    h1, h2, h3, h4, h5, h6 {
        font-family: 'Playfair Display', Georgia, serif;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .content-section {
        padding: 100px 0;
        position: relative;
    }

    .section-header {
        text-align: center;
        margin-bottom: 70px;
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

    .terms-content {
        background: var(--primary-light);
        padding: 50px;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
        position: relative;
        font-size: 1.1rem;
        line-height: 1.9;
        color: var(--gray-light);
    }

    .terms-content::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 5px;
        height: 100%;
        background: var(--gold);
    }
</style>

<div class="container content-section">
    <div class="section-header animate-fade-in-up">
        <h2>Terms & Conditions</h2>
        <p>Please read our terms carefully before using our services</p>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="terms-content animate-fade-in-up">
                <?php
                    $terms = DBterms::gettermsandconditions();
                    echo $terms->getdescription();
                ?>
            </div>
        </div>
    </div>
</div>

<?php require_once("footer.php"); ?>
