<?php

use Timber\Timber;

require_once(__DIR__ . '/vendor/autoload.php');

$timber = new Timber();

Timber::$dirname = ['templates'];

/**
 * By default, Timber does NOT autoescape values. Want to enable Twig's autoescape?
 * No prob! Just set this value to true
 */
Timber::$autoescape = false;

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('tw/main.css', get_template_directory_uri() . '/dist/main.css', false, null);
    wp_enqueue_script('tw/app.js', get_template_directory_uri() . '/dist/app.js', ['jquery'], null, true);

    wp_localize_script('tw/app.js', 'wp', [
        'ajaxurl' => admin_url('admin-ajax.php'),
    ]);
}, 100);

add_action('after_setup_theme', function () {
    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);
    add_theme_support('menus');

    /**
     * Enable features from Soil when plugin is activated
     * @link https://roots.io/plugins/soil/
     */
    add_theme_support('soil-clean-up');
    add_theme_support('soil-nav-walker');
    add_theme_support('soil-nice-search');

    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'tw'),
        'pages_sidebar' => __('Pages sidebar', 'tw'),
    ]);
}, 20);

/**
 * Register sidebars
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>'
    ];
    register_sidebar([
         'name' => __('Primary', 'tw'),
         'id' => 'sidebar-primary'
     ] + $config);
});

/**
 * Adding globals to theme context
 */
add_filter('timber/context', function ($context) {

    // access it in template with {{ main_menu }}
    $context['main_menu'] = new \Timber\Menu('primary_navigation');

    return $context;
});
