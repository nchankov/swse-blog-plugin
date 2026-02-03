<?php 
include_once __DIR__ . '/../traits/replace.php';
class Index 
{
    use Replace;
    
    public function get()
    {
        $currentPage = getQuery('page', 1);
        $content_directory = ROOT_DIR . $_ENV['BLOG_MARKDOWN_DIR'];
        $files = scandir($content_directory);
        $fileCount = count($files) - 2;

        // Sort the files by modified time so new files would be first
        $filesList = [];
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }
            $path = $content_directory . "/" . $file;
            if (is_file($path)) {
                $filesList[$file] = filemtime($path);
            }
        }

        // Sort by modified time (arsort for newest first, asort for oldest first) and get a sli
        arsort($filesList);
        $sortedFilenames = array_keys($filesList);
        $articles = array_slice($sortedFilenames, ($currentPage - 1) * $_ENV['PAGINATION'], $_ENV['PAGINATION']);

        foreach ($articles as $key => $article) {
            // Parse the markdown file for YAML front matter and content
            $object = Spatie\YamlFrontMatter\YamlFrontMatter::parse(
                file_get_contents($content_directory . "/" . $article)
            );    

            // Create the limited description displayed in the articles list the max length is 400 characters.
            $description = substr(strip_tags(
                (new Parsedown())->text($object->body())
            ), 0, 400);
            $description = substr($description, 0, strrpos($description, ' ')) . '...';

            $articles[$key] = [
                'url' => sprintf($_ENV['BLOG_URL_STRUCTURE'], $_ENV['PLUGIN'], pathinfo($article, PATHINFO_FILENAME)),
                'title' => $this->replacePlaceholders($object->title),
                'image' => $object->image,
                'excerpt' => $this->replacePlaceholders($object->excerpt),
                'description' => $this->replacePlaceholders($description)
            ];
        }
        return [
            'totalRecords' => $fileCount,
            'currentPage' => $currentPage,
            'articles' => $articles,
            'meta_title' => sprintf('Expensinator Blog - Page: %s', $currentPage),
            'meta_description' => $articles[0]['excerpt'] ?? 'Read the latest articles on expense tracking, budgeting, and personal finance management with Expensinator.',
        ];
    }
}