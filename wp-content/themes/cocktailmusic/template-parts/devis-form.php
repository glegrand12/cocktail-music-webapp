<?php
/**
 * Template Part: Devis Form
 *
 * @package CocktailMusic
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<section id="devis-section" class="devis-section section section--light">
    <div class="container">
        <div class="devis-section__header">
            <h2>Demandez votre <span class="accent">devis gratuit</span></h2>
            <p>Decrivez votre projet et recevez une proposition personnalisee sous 48h.</p>
        </div>

        <?php cocktailmusic_form_messages(); ?>

        <form class="devis-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST">
            <input type="hidden" name="action" value="cocktailmusic_devis_form">
            <?php wp_nonce_field('cocktailmusic_devis_nonce', 'devis_nonce'); ?>

            <div class="devis-form__grid">
                <div class="devis-form__field">
                    <input
                        type="text"
                        name="nom"
                        id="devis-nom"
                        placeholder="Jean Dupont"
                        required
                        aria-label="Nom complet"
                    >
                </div>

                <div class="devis-form__field">
                    <input
                        type="email"
                        name="email"
                        id="devis-email"
                        placeholder="jean@exemple.fr"
                        required
                        aria-label="Adresse email"
                    >
                </div>

                <div class="devis-form__field">
                    <input
                        type="tel"
                        name="telephone"
                        id="devis-telephone"
                        placeholder="06 12 34 56 78"
                        aria-label="Numero de telephone"
                    >
                </div>

                <div class="devis-form__field">
                    <select name="type_event" id="devis-type" aria-label="Type d'evenement">
                        <option value="">Type d'evenement</option>
                        <option value="festival">Festival</option>
                        <option value="bar">Bar / Restaurant</option>
                        <option value="fete-locale">Fete locale</option>
                        <option value="entreprise">Evenement d'entreprise</option>
                        <option value="prive">Evenement prive</option>
                        <option value="autre">Autre</option>
                    </select>
                </div>

                <div class="devis-form__field">
                    <input
                        type="date"
                        name="date"
                        id="devis-date"
                        aria-label="Date souhaitee"
                    >
                </div>

                <div class="devis-form__field">
                    <input
                        type="text"
                        name="lieu"
                        id="devis-lieu"
                        placeholder="Ville ou adresse"
                        aria-label="Lieu de l'evenement"
                    >
                </div>

                <div class="devis-form__field devis-form__field--full">
                    <textarea
                        name="message"
                        id="devis-message"
                        placeholder="Decrivez votre projet, vos attentes, le type de musique souhaite..."
                        rows="5"
                        aria-label="Votre message"
                    ></textarea>
                </div>
            </div>

            <div class="devis-form__submit">
                <button type="submit" class="btn btn--primary">
                    Envoyer ma demande
                </button>
            </div>
        </form>
    </div>
</section>
