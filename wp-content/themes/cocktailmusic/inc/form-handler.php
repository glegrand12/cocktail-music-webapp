<?php
/**
 * Devis Form Handler
 *
 * @package CocktailMusic
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Handle devis form submission
 */
function cocktailmusic_handle_devis_form() {
    // Verify nonce
    if (!isset($_POST['devis_nonce']) || !wp_verify_nonce($_POST['devis_nonce'], 'cocktailmusic_devis_nonce')) {
        wp_die('Erreur de securite. Veuillez reessayer.');
    }

    // Sanitize form data
    $nom = isset($_POST['nom']) ? sanitize_text_field($_POST['nom']) : '';
    $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
    $telephone = isset($_POST['telephone']) ? sanitize_text_field($_POST['telephone']) : '';
    $type_event = isset($_POST['type_event']) ? sanitize_text_field($_POST['type_event']) : '';
    $date = isset($_POST['date']) ? sanitize_text_field($_POST['date']) : '';
    $lieu = isset($_POST['lieu']) ? sanitize_text_field($_POST['lieu']) : '';
    $message = isset($_POST['message']) ? sanitize_textarea_field($_POST['message']) : '';

    // Validate required fields
    if (empty($nom) || empty($email)) {
        wp_redirect(add_query_arg('devis_error', 'required', wp_get_referer()));
        exit;
    }

    // Validate email
    if (!is_email($email)) {
        wp_redirect(add_query_arg('devis_error', 'email', wp_get_referer()));
        exit;
    }

    // Map event type to readable label
    $event_types = array(
        'festival' => 'Festival',
        'bar' => 'Bar / Restaurant',
        'fete-locale' => 'Fete locale',
        'entreprise' => 'Evenement d\'entreprise',
        'prive' => 'Evenement prive',
        'autre' => 'Autre',
    );
    $type_label = isset($event_types[$type_event]) ? $event_types[$type_event] : $type_event;

    // Format date
    $date_formatted = !empty($date) ? date_i18n('j F Y', strtotime($date)) : 'Non precisee';

    // Build email content
    $to = cocktailmusic_get_option('email', 'contact@cocktailmusic.fr');
    $subject = sprintf('[Cocktail Music] Nouvelle demande de devis - %s', $nom);

    $email_content = "Nouvelle demande de devis recue via le site web.\n\n";
    $email_content .= "===========================================\n";
    $email_content .= "INFORMATIONS DU CONTACT\n";
    $email_content .= "===========================================\n\n";
    $email_content .= sprintf("Nom : %s\n", $nom);
    $email_content .= sprintf("Email : %s\n", $email);
    $email_content .= sprintf("Telephone : %s\n", !empty($telephone) ? $telephone : 'Non renseigne');
    $email_content .= "\n";
    $email_content .= "===========================================\n";
    $email_content .= "DETAILS DE L'EVENEMENT\n";
    $email_content .= "===========================================\n\n";
    $email_content .= sprintf("Type d'evenement : %s\n", !empty($type_label) ? $type_label : 'Non precise');
    $email_content .= sprintf("Date souhaitee : %s\n", $date_formatted);
    $email_content .= sprintf("Lieu : %s\n", !empty($lieu) ? $lieu : 'Non precise');
    $email_content .= "\n";
    $email_content .= "===========================================\n";
    $email_content .= "MESSAGE\n";
    $email_content .= "===========================================\n\n";
    $email_content .= !empty($message) ? $message : 'Aucun message';
    $email_content .= "\n\n";
    $email_content .= "---\n";
    $email_content .= "Ce message a ete envoye depuis le formulaire de demande de devis du site Cocktail Music.\n";
    $email_content .= sprintf("Date et heure : %s\n", date_i18n('j F Y a H:i'));
    $email_content .= sprintf("IP : %s\n", cocktailmusic_get_client_ip());

    // Email headers
    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        sprintf('From: Cocktail Music <wordpress@%s>', $_SERVER['SERVER_NAME']),
        sprintf('Reply-To: %s <%s>', $nom, $email),
    );

    // Send email
    $sent = wp_mail($to, $subject, $email_content, $headers);

    // Send confirmation email to user
    if ($sent) {
        $user_subject = 'Cocktail Music - Confirmation de votre demande de devis';
        $user_content = sprintf("Bonjour %s,\n\n", $nom);
        $user_content .= "Nous avons bien recu votre demande de devis et nous vous remercions de votre confiance.\n\n";
        $user_content .= "Notre equipe etudiera votre projet et vous recontactera sous 48 heures ouvrees.\n\n";
        $user_content .= "Recapitulatif de votre demande :\n";
        $user_content .= "--------------------------------\n";
        $user_content .= sprintf("Type d'evenement : %s\n", !empty($type_label) ? $type_label : 'Non precise');
        $user_content .= sprintf("Date souhaitee : %s\n", $date_formatted);
        $user_content .= sprintf("Lieu : %s\n", !empty($lieu) ? $lieu : 'Non precise');
        $user_content .= "--------------------------------\n\n";
        $user_content .= "A tres bientot,\n";
        $user_content .= "L'equipe Cocktail Music\n\n";
        $user_content .= "---\n";
        $user_content .= "Cocktail Music - Groupes de musique live pour vos evenements\n";
        $user_content .= "Tel : " . cocktailmusic_get_option('phone') . "\n";
        $user_content .= "Email : " . cocktailmusic_get_option('email') . "\n";

        $user_headers = array(
            'Content-Type: text/plain; charset=UTF-8',
            sprintf('From: Cocktail Music <%s>', cocktailmusic_get_option('email')),
        );

        wp_mail($email, $user_subject, $user_content, $user_headers);
    }

    // Redirect with success or error
    if ($sent) {
        wp_redirect(add_query_arg('devis_success', '1', wp_get_referer() . '#devis-section'));
    } else {
        wp_redirect(add_query_arg('devis_error', 'send', wp_get_referer() . '#devis-section'));
    }
    exit;
}
add_action('admin_post_cocktailmusic_devis_form', 'cocktailmusic_handle_devis_form');
add_action('admin_post_nopriv_cocktailmusic_devis_form', 'cocktailmusic_handle_devis_form');

/**
 * Get client IP address
 */
function cocktailmusic_get_client_ip() {
    $ip = '';

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    return sanitize_text_field($ip);
}

/**
 * Display form messages
 */
function cocktailmusic_form_messages() {
    if (isset($_GET['devis_success'])) {
        echo '<div class="form-message form-message--success" style="background-color: #d4edda; color: #155724; padding: 16px 24px; border-radius: 4px; margin-bottom: 24px; text-align: center;">';
        echo '<strong>Merci !</strong> Votre demande de devis a bien ete envoyee. Nous vous recontacterons sous 48h.';
        echo '</div>';
    }

    if (isset($_GET['devis_error'])) {
        $error = sanitize_text_field($_GET['devis_error']);
        $messages = array(
            'required' => 'Veuillez remplir tous les champs obligatoires.',
            'email' => 'L\'adresse email saisie n\'est pas valide.',
            'send' => 'Une erreur est survenue lors de l\'envoi. Veuillez reessayer ou nous contacter par telephone.',
        );

        $message = isset($messages[$error]) ? $messages[$error] : 'Une erreur est survenue.';

        echo '<div class="form-message form-message--error" style="background-color: #f8d7da; color: #721c24; padding: 16px 24px; border-radius: 4px; margin-bottom: 24px; text-align: center;">';
        echo '<strong>Erreur :</strong> ' . esc_html($message);
        echo '</div>';
    }
}
