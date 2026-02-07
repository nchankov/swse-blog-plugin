# SWSE Blog Plugin

The plugin provide basic functionality of listing markdown articles and allowing viewing each of the articles.

## Functionalities provided:

1. listing all articles in paginated list ordered by file modification date descending. So new articles would appear first
2. access to the article details with ability to go back to the list link
3. sitemap.xml generator which would construct sitemap of the blog

## Installation

### Clone the repository into the project root folder (rename it as blog or articles if required)
```
git clone https://github.com/nchankov/swse-blog-plugin.git blog
```

### Run the composer require commands above
The plugin requires 2 libraries in order to work:

```
composer require erusev/parsedown
composer require spatie/yaml-front-matter
```

### Add the .env file

Use the .env.example file in the plugin directory as a template and modify the variables if needed. They should work out 
of the box without modification.

### Add url rewrites (optional)

Use the following url rewrites for nice article urls.
```
# Blog sitemap - allow nice sitemap url which would be used by search engines to index the articles.
# Add https://server.com/blog/sitemap.xml to the Google Search conole or reference it from the robots.txt file to make 
# sure that search engines can find it.
RewriteRule ^blog/sitemap.xml$ index.php?__route=blog/sitemap [QSA,L]

# Redirect /{plugin}/article?url={article_filename} to /{plugin}/{article_filename}.html
# This is done for comliancy with the old urls and to make sure that the old urls are not indexed by search engines. 
# If you don't have old urls or you don't care about them, you can skip adding this rule.
RewriteCond %{THE_REQUEST} blog/article?url=([^&\ ]+)
RewriteRule ^ /blog/%1\.html? [L,R=301]

# Rewrite /{plugin}/{article_filename} to index.php?__route={plugin}/article?url={article_filename}
# This is the main rewrite rule which would allow using the nice urls for the articles. 
# It should be added after the redirect rule above to avoid infinite redirects.
RewriteRule ^blog/([^/]+)/?\.html$ index.php?__route=blog/article&url=$1 [QSA,L]
```
