</main><!-- .site-main -->

<footer class="site-footer">
    <div class="container">
        <div class="footer__grid">
            <!-- Brand Column -->
            <div class="footer__brand">
                <div class="footer__logo">
                    Cocktail<span>Music</span>
                </div>
                <p class="footer__description">
                    Depuis 2010, Cocktail Music anime vos evenements avec des groupes de musique live dans les Hauts-de-France. Festivals, fetes locales, bars, entreprises, evenements prives.
                </p>
            </div>

            <!-- Navigation Column -->
            <div class="footer__column">
                <h4 class="footer__title">Navigation</h4>
                <ul class="footer__links">
                    <li><a href="<?php echo esc_url(home_url('/')); ?>">Accueil</a></li>
                    <li><a href="<?php echo esc_url(home_url('/secteurs-activite/')); ?>">Secteurs d'activite</a></li>
                    <li><a href="<?php echo esc_url(home_url('/histoire-valeurs/')); ?>">Histoire & Valeurs</a></li>
                    <li><a href="<?php echo esc_url(home_url('/contact/')); ?>">Contact</a></li>
                    <li><a href="#devis-section">Demander un devis</a></li>
                </ul>
            </div>

            <!-- Contact Column -->
            <div class="footer__column">
                <h4 class="footer__title">Contact</h4>
                <div class="footer__contact">
                    <div class="footer__contact-item">
                        <?php echo cocktailmusic_get_icon('phone'); ?>
                        <a href="tel:+33612345678"><?php echo esc_html(cocktailmusic_get_option('phone')); ?></a>
                    </div>
                    <div class="footer__contact-item">
                        <?php echo cocktailmusic_get_icon('mail'); ?>
                        <a href="mailto:<?php echo esc_attr(cocktailmusic_get_option('email')); ?>"><?php echo esc_html(cocktailmusic_get_option('email')); ?></a>
                    </div>
                    <div class="footer__contact-item">
                        <?php echo cocktailmusic_get_icon('map-pin'); ?>
                        <span><?php echo esc_html(cocktailmusic_get_option('address')); ?></span>
                    </div>
                </div>
            </div>

            <!-- Social Column -->
            <div class="footer__column">
                <h4 class="footer__title">Suivez-nous</h4>
                <div class="footer__social">
                    <a href="<?php echo esc_url(cocktailmusic_get_option('facebook')); ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
                        <?php echo cocktailmusic_get_icon('facebook'); ?>
                    </a>
                    <a href="<?php echo esc_url(cocktailmusic_get_option('instagram')); ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
                        <?php echo cocktailmusic_get_icon('instagram'); ?>
                    </a>
                    <a href="<?php echo esc_url(cocktailmusic_get_option('youtube')); ?>" target="_blank" rel="noopener noreferrer" aria-label="YouTube">
                        <?php echo cocktailmusic_get_icon('youtube'); ?>
                    </a>
                </div>
            </div>
        </div>

        <div class="footer__bottom">
            <p class="footer__copyright">
                &copy; <?php echo date('Y'); ?> Cocktail Music. Tous droits reserves. |
                <a href="<?php echo esc_url(home_url('/mentions-legales/')); ?>">Mentions legales</a>
            </p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
