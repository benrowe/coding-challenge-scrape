<?php

declare(strict_types=1);

namespace App;

class ContentScraper
{
    private const string URL = 'https://news.com.au';

    public static function run(): void
    {
        $url = static::URL;
        $scraper = new static();
        $articles = $scraper->scrapeArticles($url);
        $scraper->persistArticles($articles);

    }

    public function scrapeArticles(string $url): array
    {
        // Simulate scraping content from the URL
        $content = file_get_contents($url);
        if ($content === false) {
            throw new \RuntimeException("Failed to fetch content from $url");
        }

        // @todo parse the dom for the content

        return [];
    }

    private function persistArticles(array $articles): void
    {
        // @todo abstract
        file_put_contents('storage/articles.json', json_encode($articles, JSON_PRETTY_PRINT));
    }
}
