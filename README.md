# Curated Archives

Block Editor editable pages for your term archives.

## Installation

Install and activate the plugin. Using Composer is recommended.

```
composer require humanmade/curated-archives
```

## Template File

By default the appropriate archive content template will be used, for example `category.php` or `archive.php`.

You can provide an alternative template for curated archive pages by adding a template file with one of the following names:

- `curated-archive-{$term->slug}.php`
- `curated-archive-{$term->term_id}.php`
- `curated-archive-{$term->taxonomy}.php`
- `curated-archive.php`

To output the curated archive page content use the following function:

- `the_curated_archive( $term_id = null )`: You can optionally pass the term ID to show the content for.

## Filters

- `curated_archives_taxonomies`: The taxonomies curated archives supports.
- `curated_archives_post_data`: The array of default post data used to create new curated archive posts.
- `curated_archives_template`: The default block template for all content, this is passed to the `register_post_type()` call.
