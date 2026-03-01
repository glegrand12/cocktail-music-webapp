<?php
/**
 * Fix Permalinks - Script temporaire
 *
 * Visitez /wp-admin/ pour executer ce fix
 * Supprimez ce fichier apres utilisation
 */

if (!defined('ABSPATH')) {
    exit;
}

function cocktailmusic_fix_permalinks() {
    // Only run once
    if (get_option('cocktailmusic_permalinks_fixed')) {
        return;
    }

    // Flush rewrite rules
    global $wp_rewrite;
    $wp_rewrite->set_permalink_structure('/%postname%/');
    $wp_rewrite->flush_rules(true);

    // Mark as done
    update_option('cocktailmusic_permalinks_fixed', true);

    // Show notice
    add_action('admin_notices', function() {
        echo '<div class="notice notice-success is-dismissible">';
        echo '<p><strong>Cocktail Music :</strong> Les permaliens ont ete corriges. Testez les pages maintenant.</p>';
        echo '</div>';
    });
}
add_action('admin_init', 'cocktailmusic_fix_permalinks');

/**
 * Also check if pages exist
 */
function cocktailmusic_check_pages() {
    if (!is_admin()) {
        return;
    }

    $pages_to_check = array(
        'secteurs-activite' => 'Secteurs d\'activite',
        'histoire-valeurs' => 'Histoire & Valeurs',
        'contact' => 'Contact',
    );

    $missing = array();

    foreach ($pages_to_check as $slug => $title) {
        $page = get_page_by_path($slug);
        if (!$page) {
            $missing[] = $title;

            // Create the page
            $template = 'page-' . $slug . '.php';
            $page_id = wp_insert_post(array(
                'post_title'   => $title,
                'post_name'    => $slug,
                'post_content' => '',
                'post_status'  => 'publish',
                'post_type'    => 'page',
                'post_author'  => 1,
            ));

            if ($page_id) {
                update_post_meta($page_id, '_wp_page_template', $template);
            }
        }
    }

    if (!empty($missing)) {
        add_action('admin_notices', function() use ($missing) {
            echo '<div class="notice notice-warning is-dismissible">';
            echo '<p><strong>Cocktail Music :</strong> Pages creees : ' . implode(', ', $missing) . '</p>';
            echo '</div>';
        });

        // Flush rules again after creating pages
        flush_rewrite_rules(true);
    }
}
add_action('admin_init', 'cocktailmusic_check_pages', 5);
