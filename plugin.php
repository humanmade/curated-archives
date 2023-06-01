<?php
/**
 * Plugin Name: Curated Archives
 * Plugin URI: https://github.com/humanmade/curated-archives
 * Description: Block Editor pages for your term archives
 * Version: 1.1.0
 * Author: Human Made
 */

namespace HM\Curated_Archives;

const FILE = __FILE__;
const DIR = __DIR__;

// Namespaces.
require_once __DIR__ . '/inc/admin-buttons.php';
require_once __DIR__ . '/inc/assets.php';
require_once __DIR__ . '/inc/content-types.php';
require_once __DIR__ . '/inc/create-post.php';
require_once __DIR__ . '/inc/manage-posts.php';
require_once __DIR__ . '/inc/redirects.php';
require_once __DIR__ . '/inc/term-column.php';
require_once __DIR__ . '/inc/template.php';
require_once __DIR__ . '/inc/template-tags.php';

Admin_Buttons\bootstrap();
Assets\bootstrap();
Content_Types\bootstrap();
Create_Post\bootstrap();
Manage_Posts\bootstrap();
Redirects\bootstrap();
Term_Column\bootstrap();
Template\bootstrap();
