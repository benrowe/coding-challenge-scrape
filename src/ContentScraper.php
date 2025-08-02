<?php

declare(strict_types=1);

namespace App;

use Goutte\Client as GoutteClient;
use Symfony\Component\DomCrawler\Crawler;

class ContentScraper
{
    /**
     * Scraping from localhost, as news.com.au blocked me for scraping
     */
    private const string URL = 'http://localhost:8000/article';

    private const string ARTICLE_CSS_SELECTOR = 'article';

    /**
     * Static entry point to run the scraper
     */
    public static function run(): void
    {
        $url = static::URL;
        $scraper = new static();
        $articles = $scraper->scrapeArticles($url);
        $data = [
            'articles' => $articles,
            'categories' => $scraper->extractCategoriesFromArticles($articles),
        ];
        $scraper->persistArticles($data, 'storage/articles.json');
    }

    /**
     * Extract a high-level summary of articles from the given URL.
     *
     * @return array{string: title, string: link, string: date, string: image}[]
     */
    public function scrapeArticles(string $url): array
    {
        $client = new GoutteClient();
        $crawler = $client->request('GET', $url);

        return $crawler
            ->filter(self::ARTICLE_CSS_SELECTOR)
            ->each(function (Crawler $node) {
                return [
                    'title' => $this->extractNodeText($node, '.storyblock_title'),
                    'link' => $this->extractNodeAttribute($node, 'a.storyblock_title_link', 'href'),
                    'date' => $this->extractNodeAttribute($node, '.storyblock_datetime', 'datetime'),
                    'image' => $this->extractNodeAttribute($node, 'img.storyblck_image', 'src'),
                ];
            });
    }

    /**
     * Persist the scraped articles to a JSON file.
     *
     * @param array{string: title, string: link, string: date, string: image}[] $articles
     */
    public function persistArticles(array $articles, string $path): void
    {
        file_put_contents($path, json_encode($articles, JSON_PRETTY_PRINT));
    }

    /**
     * Extract unique categories from the articles.
     *
     * @param array{string: title, string: link, string: date, string: image}[] $articles $articles
     * @return array<string, int>
     */
    private function extractCategoriesFromArticles(array $articles): array
    {
        $categories = [];

        foreach ($articles as $article) {
            // parse the category from the url
            $url = $article['link'];
            $parts = explode('/', trim(parse_url($url, PHP_URL_PATH), '/'));
            $firstPart = $parts[0] ?? 'uncategorised';

            if (isset($categories[$firstPart])) {
                $categories[$firstPart]++;
            } else {
                $categories[$firstPart] = 1;
            }
        }

        return $categories;
    }

    private function extractNodeText(Crawler $node, string $selector): string
    {
        if (!$node->filter($selector)->count()) {
            return '';
        }

        return trim($node->filter($selector)->text());
    }

    private function extractNodeAttribute(Crawler $node, string $selector, string $attribute): string
    {
        if (!$node->filter($selector)->count()) {
            return '';
        }

        return trim($node->filter($selector)->attr($attribute));
    }
}
