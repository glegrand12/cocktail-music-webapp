<?php
/**
 * The template for displaying all single posts
 *
 * @package CocktailMusic
 */

get_header();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <section class="hero hero--page section--primary">
        <div class="hero__decoration hero__decoration--1"></div>
        <div class="hero__decoration hero__decoration--2"></div>

        <div class="container">
            <div class="hero__content">
                <span class="hero__label">
                    <?php
                    $categories = get_the_category();
                    if (!empty($categories)) {
                        echo esc_html($categories[0]->name);
                    }
                    ?>
                </span>
                <h1 class="hero__title"><?php the_title(); ?></h1>
                <p class="hero__description text-muted">
                    Publie le <?php echo get_the_date('j F Y'); ?>
                </p>
            </div>
        </div>
    </section>

    <section class="section section--light">
        <div class="container">
            <div style="max-width: 800px; margin: 0 auto;">
                <?php
                if (has_post_thumbnail()) :
                    the_post_thumbnail('large', array(
                        'style' => 'width: 100%; height: auto; border-radius: 8px; margin-bottom: 32px;'
                    ));
                endif;
                ?>

                <div class="post-content">
                    <?php
                    the_content();

                    wp_link_pages(array(
                        'before' => '<div class="page-links">Pages :',
                        'after'  => '</div>',
                    ));
                    ?>
                </div>

                <div class="post-navigation" style="margin-top: 48px; padding-top: 32px; border-top: 1px solid rgba(43, 45, 66, 0.1);">
                    <?php
                    the_post_navigation(array(
                        'prev_text' => '<span class="text-muted">Article precedent</span><br>%title',
                        'next_text' => '<span class="text-muted">Article suivant</span><br>%title',
                    ));
                    ?>
                </div>
            </div>
        </div>
    </section>

</article>

<?php get_template_part('template-parts/devis-form'); ?>

<?php get_footer(); ?>
