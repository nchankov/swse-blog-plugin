<?php 
class Sitemap 
{
    public function get()
    {
        header("Content-Type: application/xml; charset=utf-8");

        $content_directory = ROOT_DIR . $_ENV['BLOG_MARKDOWN_DIR'];
        $files = scandir($content_directory);
        $urls = [];
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }
            $path = $content_directory . "/" . $file;
            $filename = pathinfo($file, PATHINFO_FILENAME);
            $d = date(DATE_ATOM, filemtime($path));
            $urls[] = [
                'url' => $_ENV['SITE_URL'] . sprintf($_ENV['BLOG_URL_STRUCTURE'], $_ENV['PLUGIN'], urlencode($filename)),
                'lastmod' => $d
            ];
        }

        return [
            'urls' => $urls,
            'article_list' => $_ENV['SITE_URL'] . '/' . $_ENV['PLUGIN'],
            'date_list' => date(DATE_ATOM)
        ];
    }
}