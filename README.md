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
# Blog sitemap
RewriteRule ^blog/sitemap.xml$ index.php?__route=blog/sitemap [QSA,L]

# Rule 1
RewriteCond %{THE_REQUEST} blog/article?url=([^&\ ]+)
RewriteRule ^ /blog/%1\.html? [L,R=301]

# Rule 2
RewriteRule ^blog/([^/]+)/?\.html$ index.php?__route=blog/article&url=$1 [QSA,L]
```

### Explanation on the rules:

1. Blog sitemap make the sitemap available at /blog/sitemap.xml   
2. Rule 1 is for redirecting old urls to the new ones. Use it in case there are already articles created and indexed 
   with the old url structure. It will redirect urls like /blog/article?url=article-slug to /blog/article-slug.html   
3. Rule 2 is for making the new urls work. It will rewrite urls like /blog/article-slug.html to the system understandable
   format /blog/article?url=article-slug internally so the plugin can handle it.

Change blog in the rules to match the category of the plugin incase the category is renamed with different name .e.g. 
news.