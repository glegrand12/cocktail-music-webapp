<?php
/**
 * Template Name: Secteurs d'activite
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
                Nos secteurs d'<span class="accent">activite</span>
            </h1>
            <p class="hero__description">
                De la scene de festival au bar de quartier, nous adaptons nos prestations a chaque contexte pour creer l'ambiance parfaite.
            </p>
        </div>
    </div>
</section>

<!-- SECTORS LIST -->
<section class="section section--light">
    <div class="container">

        <!-- Sector 1: Festivals -->
        <article class="sector">
            <div class="sector__content">
                <h2 class="sector__title">Festivals & Concerts</h2>
                <p class="sector__description">
                    Nos groupes sont rompus a l'exercice de la scene et savent capter l'attention d'un large public. Rock, pop, varietes francaises ou internationales : nous proposons des formations adaptees a l'ambiance de votre festival, capables de faire lever les foules et de creer des moments memorables.
                </p>
                <div class="sector__tags">
                    <span class="badge">Grandes scenes</span>
                    <span class="badge">Repertoire adapte</span>
                    <span class="badge">Experience live</span>
                </div>
            </div>
            <div class="sector__image">
                <span>Image Festival</span>
            </div>
        </article>

        <!-- Sector 2: Fetes locales -->
        <article class="sector">
            <div class="sector__content">
                <h2 class="sector__title">Fetes locales & Kermesses</h2>
                <p class="sector__description">
                    Les fetes de village et les kermesses sont notre terrain de jeu prefere. Nous savons rassembler toutes les generations autour de repertoires federateurs : varietes francaises, tubes intemporels, musettes modernes. L'objectif : que tout le monde chante et danse ensemble.
                </p>
                <div class="sector__tags">
                    <span class="badge">Ambiance conviviale</span>
                    <span class="badge">Toutes generations</span>
                    <span class="badge">Repertoire populaire</span>
                </div>
            </div>
            <div class="sector__image">
                <span>Image Fete locale</span>
            </div>
        </article>

        <!-- Sector 3: Bars & Restaurants -->
        <article class="sector">
            <div class="sector__content">
                <h2 class="sector__title">Bars & Restaurants</h2>
                <p class="sector__description">
                    Pour vos soirees a theme ou vos animations regulieres, nous proposons des formules adaptees aux contraintes des etablissements : duos acoustiques, trios jazz, groupes de covers... Nous nous adaptons a l'espace disponible et a l'ambiance souhaitee.
                </p>
                <div class="sector__tags">
                    <span class="badge">Formats flexibles</span>
                    <span class="badge">Ambiance sur mesure</span>
                    <span class="badge">Soirees a theme</span>
                </div>
            </div>
            <div class="sector__image">
                <span>Image Bar</span>
            </div>
        </article>

        <!-- Sector 4: Entreprises -->
        <article class="sector">
            <div class="sector__content">
                <h2 class="sector__title">Evenements d'entreprise</h2>
                <p class="sector__description">
                    Seminaires, soirees de gala, team buildings, inaugurations... La musique live apporte une touche d'exception a vos evenements corporate. Nous proposons des prestations professionnelles et elegantes, adaptees a l'image de votre entreprise.
                </p>
                <div class="sector__tags">
                    <span class="badge">Image corporate</span>
                    <span class="badge">Prestation premium</span>
                    <span class="badge">Sur mesure</span>
                </div>
            </div>
            <div class="sector__image">
                <span>Image Corporate</span>
            </div>
        </article>

        <!-- Sector 5: Prives -->
        <article class="sector">
            <div class="sector__content">
                <h2 class="sector__title">Evenements prives</h2>
                <p class="sector__description">
                    Mariages, anniversaires, fetes de famille... Nous rendons vos moments prives inoubliables avec une musique live qui vous ressemble. Personnalisation du repertoire, interaction avec vos invites : chaque evenement est unique.
                </p>
                <div class="sector__tags">
                    <span class="badge">Moments uniques</span>
                    <span class="badge">Repertoire personnalise</span>
                    <span class="badge">Proximite</span>
                </div>
            </div>
            <div class="sector__image">
                <span>Image Evenement prive</span>
            </div>
        </article>

    </div>
</section>

<!-- CTA SECTION -->
<section class="cta section--accent">
    <div class="container">
        <h2>Votre evenement ne rentre pas dans ces cases ?</h2>
        <p>Pas de probleme ! Contactez-nous pour discuter de votre projet specifique. Nous trouverons ensemble la formule ideale.</p>
        <a href="#devis-section" class="btn btn--dark">Discutons de votre projet</a>
    </div>
</section>

<!-- DEVIS FORM SECTION -->
<?php get_template_part('template-parts/devis-form'); ?>

<?php get_footer(); ?>
