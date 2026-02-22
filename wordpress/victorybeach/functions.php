<?php
function victorybeach_setup() {
    // Schakel editor-stijlen in
    add_theme_support('editor-styles');

    // Vertel WordPress welk bestand hij moet inladen in de editor
    add_editor_style('style.css');
}
add_action('after_setup_theme', 'victorybeach_setup');

// Vergeet niet je normale stylesheet ook in te laden voor de voorkant
function victorybeach_scripts() {
    wp_enqueue_style('victorybeach-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'victorybeach_scripts');