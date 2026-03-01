<?php
/**
 * Template Name: Contact
 *
 * @package CocktailMusic
 */

get_header();
?>

<!-- HERO SECTION -->
<section class="hero hero--page section--primary">
    <div class="hero__decoration hero__decoration--1"></div>
    <div class="hero__decoration hero__decoration--2"></div>

    <div class="container">
        <div class="hero__content">
            <h1 class="hero__title">
                <span class="accent">Contactez</span>-nous
            </h1>
            <p class="hero__description">
                Une question ? Un projet d'evenement ? N'hesitez pas a nous contacter. Nous vous repondons sous 48h.
            </p>
        </div>
    </div>
</section>

<!-- CONTACT OPTIONS -->
<section class="section section--light">
    <div class="container">
        <div class="contact-options">
            <!-- Phone -->
            <article class="contact-card">
                <h3 class="contact-card__title">Telephone</h3>
                <p class="contact-card__value"><?php echo esc_html(cocktailmusic_get_option('phone')); ?></p>
                <p class="contact-card__description">
                    Du lundi au vendredi, de 9h a 18h. N'hesitez pas a laisser un message.
                </p>
                <a href="tel:+33612345678" class="btn btn--primary">Appeler</a>
            </article>

            <!-- Email -->
            <article class="contact-card">
                <h3 class="contact-card__title">Email</h3>
                <p class="contact-card__value"><?php echo esc_html(cocktailmusic_get_option('email')); ?></p>
                <p class="contact-card__description">
                    Reponse garantie sous 48h ouvrees. Joignez des details sur votre evenement.
                </p>
                <a href="mailto:<?php echo esc_attr(cocktailmusic_get_option('email')); ?>" class="btn btn--primary">Envoyer un email</a>
            </article>

            <!-- Social -->
            <article class="contact-card">
                <h3 class="contact-card__title">Reseaux sociaux</h3>
                <p class="contact-card__value">@cocktailmusic</p>
                <p class="contact-card__description">
                    Suivez nos actualites et decouvrez nos groupes en action sur nos reseaux.
                </p>
                <a href="<?php echo esc_url(cocktailmusic_get_option('facebook')); ?>" target="_blank" rel="noopener noreferrer" class="btn btn--primary">Nous suivre</a>
            </article>
        </div>
    </div>
</section>

<!-- INFO SECTION -->
<section class="section section--primary">
    <div class="container">
        <div class="info-grid">
            <article class="info-box">
                <h3 class="info-box__title">Zone d'intervention</h3>
                <p class="info-box__content">Hauts-de-France</p>
                <p class="info-box__description">
                    Nous intervenons principalement dans les Hauts-de-France : Nord, Pas-de-Calais, Somme, Aisne, Oise. Pour les evenements en dehors de cette zone, contactez-nous pour etudier la faisabilite.
                </p>
            </article>

            <article class="info-box">
                <h3 class="info-box__title">Delais de reservation</h3>
                <p class="info-box__content">2 a 3 mois</p>
                <p class="info-box__description">
                    Pour garantir la disponibilite du groupe souhaite, nous recommandons de reserver 2 a 3 mois a l'avance. Pour les grands evenements (festivals, galas), prevoyez 6 mois minimum.
                </p>
            </article>
        </div>
    </div>
</section>

<!-- DEVIS FORM SECTION -->
<?php get_template_part('template-parts/devis-form'); ?>

<?php get_footer(); ?>
