<?php

$request = $_SERVER['REQUEST_URI'];
error_log($request);

switch ($request) {

    case '/':
        require __DIR__ . '/views/index.php';
        break;

    case '/contact/':
        require __DIR__ . '/views/contact.php';
        break;
        
    case '/content/':
        require __DIR__ . '/views/content.php';
        break;
        
    case '/post/':
        require __DIR__ . '/views/post.php';
        break;
        
    case '/popularpost/':
        require __DIR__ . '/views/popularpost.php';
        break;
        
    case '/popularpostslider/':
        require __DIR__ . '/views/popularpostslider.php';
        break;

    case '/about/':
        require __DIR__ . '/views/about.php';
        break;

    case '/termsandconditions/':
        require __DIR__ . '/views/termsandconditions.php';
        break;
        
    default :
        require __DIR__ . '/views/route.php';
        route::get($request);
        break;

    case '/PrivacyPolicy/':
        require __DIR__ . '/views/PrivacyPolicy.php';
        break;

    case '/cmsadmin/login.php':
        require __DIR__ . '/cmsadmin/views/login.php';
        break;

}