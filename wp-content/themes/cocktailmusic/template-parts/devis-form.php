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

        <form class="devis-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST" novalidate>
            <input type="hidden" name="action" value="cocktailmusic_devis_form">
            <?php wp_nonce_field('cocktailmusic_devis_nonce', 'devis_nonce'); ?>

            <div class="devis-form__grid">

                <!-- Ligne 1 : Nom + Prenom -->
                <div class="devis-form__field">
                    <label for="devis-nom" class="devis-form__label">Nom</label>
                    <input
                        type="text"
                        name="nom"
                        id="devis-nom"
                        placeholder="Dupont"
                        required
                    >
                    <span class="devis-form__error" data-error="nom"></span>
                </div>

                <div class="devis-form__field">
                    <label for="devis-prenom" class="devis-form__label">Prenom</label>
                    <input
                        type="text"
                        name="prenom"
                        id="devis-prenom"
                        placeholder="Jean"
                        required
                    >
                    <span class="devis-form__error" data-error="prenom"></span>
                </div>

                <!-- Ligne 2 : Email + Telephone -->
                <div class="devis-form__field">
                    <label for="devis-email" class="devis-form__label">Adresse email</label>
                    <input
                        type="email"
                        name="email"
                        id="devis-email"
                        placeholder="jean@exemple.fr"
                        required
                    >
                    <span class="devis-form__error" data-error="email"></span>
                </div>

                <div class="devis-form__field">
                    <label for="devis-telephone" class="devis-form__label">Telephone</label>
                    <input
                        type="tel"
                        name="telephone"
                        id="devis-telephone"
                        placeholder="06 12 34 56 78"
                        required
                    >
                    <span class="devis-form__error" data-error="telephone"></span>
                </div>

                <!-- Ligne 3 : Type + Date -->
                <div class="devis-form__field">
                    <label for="devis-type" class="devis-form__label">Type d'evenement</label>
                    <select name="type_event" id="devis-type" required>
                        <option value="">Selectionnez un type</option>
                        <option value="festival">Festival</option>
                        <option value="bar">Bar / Restaurant</option>
                        <option value="fete-locale">Fete locale</option>
                        <option value="entreprise">Evenement d'entreprise</option>
                        <option value="prive">Evenement prive</option>
                        <option value="autre">Autre</option>
                    </select>
                    <span class="devis-form__error" data-error="type_event"></span>
                </div>

                <div class="devis-form__field">
                    <label for="devis-date" class="devis-form__label">Date souhaitee</label>
                    <input
                        type="date"
                        name="date"
                        id="devis-date"
                        min="<?php echo date('Y-m-d'); ?>"
                    >
                    <span class="devis-form__error" data-error="date"></span>
                </div>

                <!-- Ligne 4 : Code postal + Ville -->
                <div class="devis-form__field">
                    <label for="devis-code-postal" class="devis-form__label">Code postal</label>
                    <input
                        type="text"
                        name="code_postal"
                        id="devis-code-postal"
                        placeholder="59000"
                        maxlength="5"
                    >
                    <span class="devis-form__error" data-error="code_postal"></span>
                </div>

                <div class="devis-form__field">
                    <label for="devis-lieu" class="devis-form__label">Ville</label>
                    <input
                        type="text"
                        name="lieu"
                        id="devis-lieu"
                        placeholder="Lille"
                    >
                    <span class="devis-form__error" data-error="lieu"></span>
                </div>

                <!-- Ligne 5 : Message (pleine largeur) -->
                <div class="devis-form__field devis-form__field--full">
                    <label for="devis-message" class="devis-form__label">Votre message</label>
                    <textarea
                        name="message"
                        id="devis-message"
                        placeholder="Decrivez votre projet, vos attentes, le type de musique souhaite..."
                        rows="5"
                    ></textarea>
                    <span class="devis-form__error" data-error="message"></span>
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
