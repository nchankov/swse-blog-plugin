<?php 
include_once __DIR__ . '/../traits/replace.php';
class Article 
{
    use Replace;
    
    public function get()
    {
        
        $content_directory = ROOT_DIR . $_ENV['BLOG_MARKDOWN_DIR'];
        // Get the markdown file name from the url query parameter
        $url = getQuery('url'); // get article name (md file name without extension)
        
        // Sanitize the $url to prevent directory traversal attacks
        $url = preg_replace('/\../', '', $url);
        $url = preg_replace('/\./', '', $url);

        // $url is missing or empty
        if (!$url) {
            redirect('/404', 301); // Redirect to 404 page
        }

        // Construct the file path where the markdown file is located
        $filepath = $content_directory . $url . ".md";

        // The file is missing
        if (!file_exists($filepath)) {
            redirect('/404', 301); // Redirect to 404 page
        }
        $object = Spatie\YamlFrontMatter\YamlFrontMatter::parse(file_get_contents($filepath));    
        return [
            'title' => $this->replacePlaceholders($object->title),
            'meta_title' => $this->replacePlaceholders($object->title),
            'image' => $object->image,
            'meta_description' => $this->replacePlaceholders($object->excerpt),
            'content' => $this->replacePlaceholders((new Parsedown())->text($object->body())),
            'back_url' => '/' . $_ENV['PLUGIN'],
        ];
    }
}