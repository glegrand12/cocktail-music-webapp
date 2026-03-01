<?php
/**
 * Template Name: Histoire & Valeurs
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
                Notre <span class="accent">histoire</span> & nos valeurs
            </h1>
            <p class="hero__description">
                Depuis 2010, nous rassemblons les gens autour de la musique live. Decouvrez ce qui nous anime.
            </p>
        </div>
    </div>
</section>

<!-- HISTOIRE SECTION -->
<section class="section section--light">
    <div class="container">
        <div style="max-width: 800px; margin: 0 auto;">
            <h2 class="mb-4">Comment tout a <span class="accent">commence</span></h2>

            <p>
                Cocktail Music est ne d'une passion partagee pour la musique live et d'un constat simple : trop d'evenements manquent de cette energie unique que seule la musique jouee en direct peut apporter. En 2010, une poignee de musiciens professionnels des Hauts-de-France decident de s'associer pour proposer des prestations musicales de qualite, accessibles a tous.
            </p>

            <p>
                Au fil des annees, ce qui n'etait au depart qu'un reseau d'amis musiciens s'est structure pour devenir une veritable entreprise evenementielle. Notre catalogue s'est etoffe, nos groupes se sont professionnalises, et notre reputation s'est construite evenement apres evenement, grace au bouche-a-oreille de clients satisfaits.
            </p>

            <p>
                Aujourd'hui, Cocktail Music c'est plus de 50 artistes partenaires, des centaines d'evenements animes chaque annee, et toujours la meme envie de creer des moments de partage et de joie autour de la musique. Notre force ? Rester a taille humaine tout en offrant un service professionnel et fiable.
            </p>
        </div>
    </div>
</section>

<!-- TIMELINE SECTION -->
<section class="section section--surface">
    <div class="container">
        <h2 class="text-center mb-5">Les grandes <span class="accent">etapes</span></h2>

        <div class="timeline">
            <div class="timeline__item">
                <div class="timeline__dot"></div>
                <div class="timeline__content">
                    <span class="timeline__year">2010</span>
                    <h3 class="timeline__title">Creation</h3>
                    <p class="timeline__description">
                        Lancement de Cocktail Music par un groupe de musiciens passionnes des Hauts-de-France.
                    </p>
                </div>
            </div>

            <div class="timeline__item">
                <div class="timeline__dot"></div>
                <div class="timeline__content">
                    <span class="timeline__year">2014</span>
                    <h3 class="timeline__title">Expansion regionale</h3>
                    <p class="timeline__description">
                        Developpement du reseau d'artistes et extension de notre zone d'intervention a toute la region.
                    </p>
                </div>
            </div>

            <div class="timeline__item">
                <div class="timeline__dot"></div>
                <div class="timeline__content">
                    <span class="timeline__year">2018</span>
                    <h3 class="timeline__title">10 000 heures de musique</h3>
                    <p class="timeline__description">
                        Cap symbolique des 10 000 heures de musique live jouee lors de nos evenements.
                    </p>
                </div>
            </div>

            <div class="timeline__item">
                <div class="timeline__dot"></div>
                <div class="timeline__content">
                    <span class="timeline__year">2023</span>
                    <h3 class="timeline__title">50 artistes partenaires</h3>
                    <p class="timeline__description">
                        Notre reseau compte desormais plus de 50 musiciens professionnels.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- VALUES SECTION -->
<section class="section section--light">
    <div class="container">
        <h2 class="text-center mb-5">Nos <span class="accent">valeurs</span></h2>

        <div class="values__grid">
            <article class="value-card">
                <div class="value-card__icon">
                    <?php echo cocktailmusic_get_icon('users'); ?>
                </div>
                <h3 class="value-card__title">Convivialite</h3>
                <p class="value-card__description">
                    La musique rassemble. Nous creons des ambiances chaleureuses ou chacun se sent bienvenu et peut profiter du moment.
                </p>
            </article>

            <article class="value-card">
                <div class="value-card__icon">
                    <?php echo cocktailmusic_get_icon('sparkles'); ?>
                </div>
                <h3 class="value-card__title">Authenticite</h3>
                <p class="value-card__description">
                    Rien ne remplace l'emotion d'un concert live. Nous defendons une musique vraie, jouee avec passion et sincerite.
                </p>
            </article>

            <article class="value-card">
                <div class="value-card__icon">
                    <?php echo cocktailmusic_get_icon('heart'); ?>
                </div>
                <h3 class="value-card__title">Accessibilite</h3>
                <p class="value-card__description">
                    La musique live n'est pas reservee aux grands evenements. Nous proposons des formules adaptees a tous les budgets.
                </p>
            </article>

            <article class="value-card">
                <div class="value-card__icon">
                    <?php echo cocktailmusic_get_icon('award'); ?>
                </div>
                <h3 class="value-card__title">Professionnalisme</h3>
                <p class="value-card__description">
                    Ponctualite, fiabilite, qualite sonore... Nous prenons notre metier au serieux pour que vous puissiez compter sur nous.
                </p>
            </article>

            <article class="value-card">
                <div class="value-card__icon">
                    <?php echo cocktailmusic_get_icon('map-pin'); ?>
                </div>
                <h3 class="value-card__title">Proximite</h3>
                <p class="value-card__description">
                    Ancres dans les Hauts-de-France, nous connaissons notre territoire et ses acteurs. Nous sommes vos voisins.
                </p>
            </article>

            <article class="value-card">
                <div class="value-card__icon">
                    <?php echo cocktailmusic_get_icon('zap'); ?>
                </div>
                <h3 class="value-card__title">Passion</h3>
                <p class="value-card__description">
                    Nos musiciens vivent pour la scene. Cette passion se ressent dans chaque note et se transmet a votre public.
                </p>
            </article>
        </div>
    </div>
</section>

<!-- DEVIS FORM SECTION -->
<?php get_template_part('template-parts/devis-form'); ?>

<?php get_footer(); ?>
