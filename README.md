#SWSE Blog Plugin

The plugin provide basic functionality of listing markdown articles and allowing viewing each of the articles.

The plugin requires 2 libraries in order to work:

```
composer require erusev/parsedown
composer require spatie/yaml-front-matter
```

Functionalities provided:

1. listing all articles in paginated list ordered by file modification date descending. So new articles would appear first
2. access to the article details with ability to go back to the list link
3. sitemap.xml generator which would construct sitemap of the blog


## URL Rewrites

The url structure is:
https://server.com/{plugin}

https://server.com/{plugin}/{article_filename}.html
https://server.com/sitemap.xml

e.g
https://server.com/blog
https://server.com/blog/your-first-post.html
https://server.com/sitemap.xml

To make the url rewrites use the following rows in the .htaccess

```
# Blog sitemap
RewriteRule ^blog/sitemap.xml$ index.php?__route=blog/sitemap [QSA,L]

# Step 1: redirect /{plugin}/article?url={article_filename} to /{plugin}/{article_filename}.html
RewriteCond %{THE_REQUEST} blog/article?url=([^&\ ]+)
RewriteRule ^ /blog/%1\.html? [L,R=301]

# Step 2: Rewrite /{plugin}/{article_filename} to index.php?__route={plugin}/article?url={article_filename}
RewriteRule ^blog/([^/]+)/?\.html$ index.php?__route=blog/article&url=$1 [QSA,L]
```

More information -> [SWSE Documentation](https://swse.chankov.net)
