<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

if ($_SERVER['REQUEST_URI'] === '/article') {
    // Serve the HTML content for the article
    // this is because news.com.au blocked scraping
    // and we are scraping from localhost
    header('Content-Type: text/html; charset=UTF-8');
    echo file_get_contents(__DIR__.'/../storage/news.html');
} else if ($_SERVER['REQUEST_URI'] === '/api') {

    // Serve the JSON content for the articles

    header('content-type: application/json');
    if (!file_exists(__DIR__.'/../storage/articles.json')) {

        echo json_encode(['error' => 'No articles found. Run the scraper first.']);
        exit;
    }
    echo file_get_contents(__DIR__.'/../storage/articles.json');
} else {
    // dashboard page
    header('Content-Type: text/html; charset=UTF-8');
    echo file_get_contents(__DIR__.'/../resources/views/dashboard.html');
}
