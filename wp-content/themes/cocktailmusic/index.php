<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 *
 * @package CocktailMusic
 */

get_header();
?>

<section class="hero hero--page section--primary">
    <div class="container">
        <div class="hero__content">
            <h1 class="hero__title">
                <?php
                if (is_home() && !is_front_page()) {
                    single_post_title();
                } elseif (is_archive()) {
                    the_archive_title();
                } elseif (is_search()) {
                    printf('Recherche : %s', get_search_query());
                } else {
                    the_title();
                }
                ?>
            </h1>
        </div>
    </div>
</section>

<section class="section section--light">
    <div class="container">
        <?php if (have_posts()) : ?>
            <div class="posts-grid">
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>
                        <h2 class="post-card__title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        <div class="post-card__excerpt">
                            <?php the_excerpt(); ?>
                        </div>
                        <a href="<?php the_permalink(); ?>" class="btn btn--outline-dark">Lire la suite</a>
                    </article>
                <?php endwhile; ?>
            </div>

            <?php the_posts_pagination(array(
                'prev_text' => 'Precedent',
                'next_text' => 'Suivant',
            )); ?>

        <?php else : ?>
            <p>Aucun contenu trouve.</p>
        <?php endif; ?>
    </div>
</section>

<?php get_template_part('template-parts/devis-form'); ?>

<?php get_footer(); ?>
