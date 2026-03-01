<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header" id="site-header">
    <div class="container">
        <div class="header-inner">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo">
                Cocktail<span>Music</span>
            </a>

            <nav class="main-nav" id="main-nav">
                <ul class="nav-links">
                    <li>
                        <a href="<?php echo esc_url(home_url('/')); ?>" <?php echo is_front_page() ? 'class="active"' : ''; ?>>
                            Accueil
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo esc_url(home_url('/secteurs-activite/')); ?>" <?php echo is_page('secteurs-activite') ? 'class="active"' : ''; ?>>
                            Secteurs d'activite
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo esc_url(home_url('/histoire-valeurs/')); ?>" <?php echo is_page('histoire-valeurs') ? 'class="active"' : ''; ?>>
                            Histoire & Valeurs
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo esc_url(home_url('/contact/')); ?>" <?php echo is_page('contact') ? 'class="active"' : ''; ?>>
                            Contact
                        </a>
                    </li>
                </ul>
                <div class="nav-cta">
                    <a href="#devis-section" class="btn btn--primary">Demander un devis</a>
                </div>
            </nav>

            <button class="menu-toggle" id="menu-toggle" aria-label="Menu" aria-expanded="false">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </div>
</header>

<main class="site-main">
