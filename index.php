<?php

$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '/acedecor/':
        require __DIR__ . '/views/index.php';
        break;
    case '':
        require __DIR__ . '/views/index.php';
        break;
    case '/acedecor/contact/':
        require __DIR__ . '/views/contact.php';
        break;
    case  '/acedecor/termsandconditions/':
        require __DIR__ . '/views/termsandconditions.php';
        break;
    case  '/acedecor/PrivacyPolicy/':
        require __DIR__ . '/views/PrivacyPolicy.php';
        break;
    case '/acedecor/about/':
        require __DIR__ . '/views/about.php';
        break;
    case '/acedecor/cmsadmin/login.php':
        require __DIR__ . '/admin/views/login.php';
        break;

    default:
        require __DIR__ . '/views/route.php';
        
        route::get($request);
        
        break;
}
