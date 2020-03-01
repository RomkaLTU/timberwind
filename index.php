<?php

use Timber\Timber;

$context = Timber::context();
$context['posts'] = Timber::get_posts();
$templates = ['index.twig'];

if (is_home() || is_front_page()) {
    array_unshift($templates, 'front-page.twig', 'home.twig');
}

Timber::render($templates, $context);
