<?php
/**
 * Template: Front Page (Accueil)
 *
 * @package CocktailMusic
 */

get_header();
?>

<!-- HERO SECTION -->
<section class="hero section--primary">
    <div class="hero__decoration hero__decoration--1"></div>
    <div class="hero__decoration hero__decoration--2"></div>

    <div class="container">
        <div class="hero__content">
            <span class="hero__label">Groupes de musique live</span>
            <h1 class="hero__title">
                La musique qui fait <span class="accent">vibrer</span> vos evenements
            </h1>
            <p class="hero__description">
                Depuis plus de 15 ans, Cocktail Music anime vos festivals, fetes locales, bars et evenements prives avec des groupes de musique live professionnels dans les Hauts-de-France.
            </p>
            <div class="hero__buttons">
                <a href="#devis-section" class="btn btn--primary">Demander un devis gratuit</a>
                <a href="<?php echo esc_url(home_url('/secteurs-activite/')); ?>" class="btn btn--outline">Decouvrir nos groupes</a>
            </div>
        </div>
    </div>
</section>

<!-- STATISTICS SECTION -->
<section class="stats section--light">
    <div class="container">
        <div class="stats__grid">
            <div class="stat">
                <span class="stat__number">15+</span>
                <span class="stat__label">Annees d'experience</span>
            </div>
            <div class="stat">
                <span class="stat__number">500+</span>
                <span class="stat__label">Evenements animes</span>
            </div>
            <div class="stat">
                <span class="stat__number">50+</span>
                <span class="stat__label">Artistes partenaires</span>
            </div>
            <div class="stat">
                <span class="stat__number">100%</span>
                <span class="stat__label">Clients satisfaits</span>
            </div>
        </div>
    </div>
</section>

<!-- SERVICES SECTION -->
<section class="services section--surface">
    <div class="container">
        <div class="services__header">
            <h2>Une musique pour chaque <span class="accent">occasion</span></h2>
            <p class="text-muted">Decouvrez nos prestations adaptees a tous types d'evenements</p>
        </div>

        <div class="services__grid">
            <article class="service-card">
                <div class="service-card__icon">
                    <?php echo cocktailmusic_get_icon('festival'); ?>
                </div>
                <h3 class="service-card__title">Festivals</h3>
                <p class="service-card__description">
                    Des groupes energiques pour faire vibrer votre public. Rock, pop, variete... Nous adaptons notre repertoire a l'ambiance de votre festival.
                </p>
            </article>

            <article class="service-card">
                <div class="service-card__icon">
                    <?php echo cocktailmusic_get_icon('celebration'); ?>
                </div>
                <h3 class="service-card__title">Fetes locales</h3>
                <p class="service-card__description">
                    Kermesses, fetes de village, bals populaires... Nous creons une ambiance conviviale et federatrice pour rassembler toutes les generations.
                </p>
            </article>

            <article class="service-card">
                <div class="service-card__icon">
                    <?php echo cocktailmusic_get_icon('bar'); ?>
                </div>
                <h3 class="service-card__title">Bars & Restaurants</h3>
                <p class="service-card__description">
                    Soirees a theme, concerts intimistes, ambiances jazz ou acoustique... Nous accompagnons vos etablissements pour des moments inoubliables.
                </p>
            </article>
        </div>
    </div>
</section>

<!-- CTA SECTION -->
<section class="cta section--primary">
    <div class="container">
        <h2>Pret a faire <span class="accent">vibrer</span> votre evenement ?</h2>
        <p>Contactez-nous pour discuter de votre projet et recevoir un devis personnalise gratuit.</p>
        <a href="#devis-section" class="btn btn--primary">Demander un devis gratuit</a>
    </div>
</section>

<!-- DEVIS FORM SECTION -->
<?php get_template_part('template-parts/devis-form'); ?>

<?php get_footer(); ?>
