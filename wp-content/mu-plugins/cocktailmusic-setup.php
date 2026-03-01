<?php
/**
 * Cocktail Music - Auto Setup Pages
 *
 * Ce plugin MU cree automatiquement les pages necessaires au theme.
 * Il s'execute une seule fois puis se desactive.
 *
 * @package CocktailMusic
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Create theme pages on activation
 */
function cocktailmusic_create_pages() {
    // Check if already installed
    if (get_option('cocktailmusic_pages_created')) {
        return;
    }

    // Pages to create
    $pages = array(
        array(
            'title'    => 'Accueil',
            'slug'     => 'accueil',
            'template' => '',
            'content'  => '',
        ),
        array(
            'title'    => 'Secteurs d\'activite',
            'slug'     => 'secteurs-activite',
            'template' => 'page-secteurs-activite.php',
            'content'  => '',
        ),
        array(
            'title'    => 'Histoire & Valeurs',
            'slug'     => 'histoire-valeurs',
            'template' => 'page-histoire-valeurs.php',
            'content'  => '',
        ),
        array(
            'title'    => 'Contact',
            'slug'     => 'contact',
            'template' => 'page-contact.php',
            'content'  => '',
        ),
        array(
            'title'    => 'Mentions legales',
            'slug'     => 'mentions-legales',
            'template' => '',
            'content'  => '<h2>Editeur du site</h2>
<p>Cocktail Music<br>
Hauts-de-France<br>
Telephone : 06 12 34 56 78<br>
Email : contact@cocktailmusic.fr</p>

<h2>Hebergement</h2>
<p>[A completer avec les informations de votre hebergeur]</p>

<h2>Propriete intellectuelle</h2>
<p>L\'ensemble du contenu de ce site (textes, images, videos) est protege par le droit d\'auteur. Toute reproduction est interdite sans autorisation prealable.</p>

<h2>Donnees personnelles</h2>
<p>Les informations recueillies via le formulaire de contact sont destinees uniquement a Cocktail Music pour le traitement de votre demande. Conformement au RGPD, vous disposez d\'un droit d\'acces, de rectification et de suppression de vos donnees.</p>

<h2>Cookies</h2>
<p>Ce site utilise des cookies techniques necessaires a son fonctionnement. Aucun cookie publicitaire n\'est utilise.</p>',
        ),
    );

    $home_page_id = 0;

    foreach ($pages as $page_data) {
        // Check if page already exists
        $existing_page = get_page_by_path($page_data['slug']);

        if ($existing_page) {
            $page_id = $existing_page->ID;

            // Update template if needed
            if (!empty($page_data['template'])) {
                update_post_meta($page_id, '_wp_page_template', $page_data['template']);
            }
        } else {
            // Create the page
            $page_id = wp_insert_post(array(
                'post_title'   => $page_data['title'],
                'post_name'    => $page_data['slug'],
                'post_content' => $page_data['content'],
                'post_status'  => 'publish',
                'post_type'    => 'page',
                'post_author'  => 1,
            ));

            // Set page template
            if ($page_id && !empty($page_data['template'])) {
                update_post_meta($page_id, '_wp_page_template', $page_data['template']);
            }
        }

        // Track home page
        if ($page_data['slug'] === 'accueil') {
            $home_page_id = $page_id;
        }
    }

    // Set homepage settings
    if ($home_page_id) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', $home_page_id);
    }

    // Set permalink structure
    global $wp_rewrite;
    $wp_rewrite->set_permalink_structure('/%postname%/');
    $wp_rewrite->flush_rules();

    // Update site title and tagline
    update_option('blogname', 'Cocktail Music');
    update_option('blogdescription', 'Groupes de musique live pour vos evenements');

    // Set timezone
    update_option('timezone_string', 'Europe/Paris');
    update_option('date_format', 'j F Y');
    update_option('time_format', 'H:i');

    // Disable comments by default
    update_option('default_comment_status', 'closed');
    update_option('default_ping_status', 'closed');

    // Mark as installed
    update_option('cocktailmusic_pages_created', true);

    // Admin notice
    add_action('admin_notices', function() {
        echo '<div class="notice notice-success is-dismissible">';
        echo '<p><strong>Cocktail Music :</strong> Les pages ont ete creees avec succes !</p>';
        echo '<ul style="margin-left: 20px; list-style: disc;">';
        echo '<li>Accueil (page d\'accueil)</li>';
        echo '<li>Secteurs d\'activite</li>';
        echo '<li>Histoire & Valeurs</li>';
        echo '<li>Contact</li>';
        echo '<li>Mentions legales</li>';
        echo '</ul>';
        echo '</div>';
    });
}
add_action('init', 'cocktailmusic_create_pages', 0);

/**
 * Auto-activate theme if not active
 */
function cocktailmusic_activate_theme() {
    $current_theme = wp_get_theme();

    if ($current_theme->get_stylesheet() !== 'cocktailmusic') {
        // Check if theme exists
        $theme = wp_get_theme('cocktailmusic');

        if ($theme->exists()) {
            switch_theme('cocktailmusic');

            add_action('admin_notices', function() {
                echo '<div class="notice notice-success is-dismissible">';
                echo '<p><strong>Cocktail Music :</strong> Le theme a ete active automatiquement.</p>';
                echo '</div>';
            });
        }
    }
}
add_action('init', 'cocktailmusic_activate_theme', 1);

/**
 * Add admin menu for reset
 */
function cocktailmusic_admin_menu() {
    add_management_page(
        'Cocktail Music Setup',
        'Cocktail Music',
        'manage_options',
        'cocktailmusic-setup',
        'cocktailmusic_setup_page'
    );
}
add_action('admin_menu', 'cocktailmusic_admin_menu');

/**
 * Setup page content
 */
function cocktailmusic_setup_page() {
    // Handle reset
    if (isset($_POST['cocktailmusic_reset']) && check_admin_referer('cocktailmusic_reset_nonce')) {
        delete_option('cocktailmusic_pages_created');
        echo '<div class="notice notice-warning"><p>Configuration reinitalisee. Rechargez la page pour recreer les pages.</p></div>';
    }

    $pages_created = get_option('cocktailmusic_pages_created');
    ?>
    <div class="wrap">
        <h1>Cocktail Music - Configuration</h1>

        <div class="card" style="max-width: 600px; padding: 20px;">
            <h2>Statut de l'installation</h2>

            <?php if ($pages_created) : ?>
                <p style="color: green; font-weight: bold;">Les pages sont installees.</p>

                <h3>Pages creees :</h3>
                <ul>
                    <?php
                    $pages = array('accueil', 'secteurs-activite', 'histoire-valeurs', 'contact', 'mentions-legales');
                    foreach ($pages as $slug) {
                        $page = get_page_by_path($slug);
                        if ($page) {
                            printf(
                                '<li><a href="%s" target="_blank">%s</a> - <a href="%s">Modifier</a></li>',
                                get_permalink($page->ID),
                                esc_html($page->post_title),
                                get_edit_post_link($page->ID)
                            );
                        }
                    }
                    ?>
                </ul>

                <hr>

                <h3>Reinitialiser</h3>
                <p>Si vous souhaitez recreer les pages (par exemple apres une suppression accidentelle) :</p>
                <form method="post">
                    <?php wp_nonce_field('cocktailmusic_reset_nonce'); ?>
                    <button type="submit" name="cocktailmusic_reset" class="button" onclick="return confirm('Reinitialiser la configuration ?');">
                        Reinitialiser la configuration
                    </button>
                </form>

            <?php else : ?>
                <p style="color: orange;">Les pages n'ont pas encore ete creees.</p>
                <p>Rechargez cette page pour lancer l'installation automatique.</p>
            <?php endif; ?>
        </div>

        <div class="card" style="max-width: 600px; padding: 20px; margin-top: 20px;">
            <h2>Prochaines etapes</h2>
            <ol>
                <li>Verifiez que le theme "Cocktail Music" est actif dans <a href="<?php echo admin_url('themes.php'); ?>">Apparence > Themes</a></li>
                <li>Testez le formulaire de devis sur chaque page</li>
                <li>Configurez l'envoi d'emails (plugin SMTP recommande)</li>
                <li>Ajoutez vos images dans les sections</li>
                <li>Personnalisez les textes si necessaire</li>
            </ol>
        </div>
    </div>
    <?php
}
