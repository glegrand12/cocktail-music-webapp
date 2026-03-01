<?php
/**
 * The template for displaying all pages
 *
 * @package CocktailMusic
 */

get_header();
?>

<section class="hero hero--page section--primary">
    <div class="hero__decoration hero__decoration--1"></div>
    <div class="hero__decoration hero__decoration--2"></div>

    <div class="container">
        <div class="hero__content">
            <h1 class="hero__title"><?php the_title(); ?></h1>
        </div>
    </div>
</section>

<section class="section section--light">
    <div class="container">
        <div style="max-width: 800px; margin: 0 auto;">
            <?php
            while (have_posts()) :
                the_post();
                the_content();
            endwhile;
            ?>
        </div>
    </div>
</section>

<?php get_template_part('template-parts/devis-form'); ?>

<?php get_footer(); ?>
