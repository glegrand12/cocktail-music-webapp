<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package CocktailMusic
 */

get_header();
?>

<section class="hero section--primary" style="min-height: 80vh;">
    <div class="hero__decoration hero__decoration--1"></div>
    <div class="hero__decoration hero__decoration--2"></div>

    <div class="container">
        <div class="hero__content text-center" style="max-width: 600px; margin: 0 auto;">
            <span class="hero__label">Erreur 404</span>
            <h1 class="hero__title">Page non <span class="accent">trouvee</span></h1>
            <p class="hero__description">
                Oups ! La page que vous recherchez n'existe pas ou a ete deplacee. Pas de panique, la musique continue !
            </p>
            <div class="hero__buttons" style="justify-content: center;">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn--primary">Retour a l'accueil</a>
                <a href="#devis-section" class="btn btn--outline">Demander un devis</a>
            </div>
        </div>
    </div>
</section>

<?php get_template_part('template-parts/devis-form'); ?>

<?php get_footer(); ?>
