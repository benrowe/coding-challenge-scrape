<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

if ($_SERVER['REQUEST_URI'] === '/article') {
    echo file_get_contents(__DIR__.'/../storage/news.html');
}
