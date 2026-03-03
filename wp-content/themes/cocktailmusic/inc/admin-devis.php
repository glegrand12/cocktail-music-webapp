<?php
/**
 * Admin Devis Management
 *
 * @package CocktailMusic
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add admin menu for devis management
 */
function cocktailmusic_admin_menu() {
    add_menu_page(
        'Demandes de devis',
        'Devis',
        'manage_options',
        'cocktailmusic-devis',
        'cocktailmusic_devis_list_page',
        'dashicons-clipboard',
        25
    );

    add_submenu_page(
        'cocktailmusic-devis',
        'Toutes les demandes',
        'Toutes les demandes',
        'manage_options',
        'cocktailmusic-devis',
        'cocktailmusic_devis_list_page'
    );

    add_submenu_page(
        'cocktailmusic-devis',
        'Calendrier / Agenda',
        'Calendrier',
        'manage_options',
        'cocktailmusic-devis-calendar',
        'cocktailmusic_devis_calendar_page'
    );
}
add_action('admin_menu', 'cocktailmusic_admin_menu');

/**
 * Enqueue admin styles and scripts
 */
function cocktailmusic_admin_scripts($hook) {
    if (strpos($hook, 'cocktailmusic-devis') === false) {
        return;
    }

    wp_enqueue_style(
        'cocktailmusic-admin',
        get_template_directory_uri() . '/assets/css/admin-devis.css',
        array(),
        wp_get_theme()->get('Version')
    );

    wp_enqueue_script(
        'cocktailmusic-admin',
        get_template_directory_uri() . '/assets/js/admin-devis.js',
        array(),
        wp_get_theme()->get('Version'),
        true
    );

    wp_localize_script('cocktailmusic-admin', 'cocktailmusic_admin', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('cocktailmusic_admin_nonce'),
    ));
}
add_action('admin_enqueue_scripts', 'cocktailmusic_admin_scripts');

/**
 * Devis list page
 */
function cocktailmusic_devis_list_page() {
    // Handle status update
    if (isset($_GET['update_status']) && isset($_GET['devis_id']) && isset($_GET['_wpnonce'])) {
        if (wp_verify_nonce($_GET['_wpnonce'], 'update_devis_status')) {
            $devis_id = intval($_GET['devis_id']);
            $new_status = sanitize_text_field($_GET['update_status']);
            $allowed_statuses = array('nouveau', 'en_cours', 'accepte', 'refuse', 'termine');
            if (in_array($new_status, $allowed_statuses)) {
                update_post_meta($devis_id, '_devis_statut', $new_status);
            }
        }
    }

    // Handle delete
    if (isset($_GET['delete_devis']) && isset($_GET['_wpnonce'])) {
        if (wp_verify_nonce($_GET['_wpnonce'], 'delete_devis')) {
            $devis_id = intval($_GET['delete_devis']);
            wp_trash_post($devis_id);
        }
    }

    // Get filter
    $filter_status = isset($_GET['status']) ? sanitize_text_field($_GET['status']) : '';

    // Query devis
    $args = array(
        'post_type'      => 'devis',
        'posts_per_page' => 20,
        'paged'          => isset($_GET['paged']) ? intval($_GET['paged']) : 1,
        'orderby'        => 'date',
        'order'          => 'DESC',
    );

    if ($filter_status) {
        $args['meta_query'] = array(
            array(
                'key'   => '_devis_statut',
                'value' => $filter_status,
            ),
        );
    }

    $devis_query = new WP_Query($args);

    $status_labels = array(
        'nouveau'  => 'Nouveau',
        'en_cours' => 'En cours',
        'accepte'  => 'Accepte',
        'refuse'   => 'Refuse',
        'termine'  => 'Termine',
    );

    $status_colors = array(
        'nouveau'  => '#2196F3',
        'en_cours' => '#FF9800',
        'accepte'  => '#4CAF50',
        'refuse'   => '#f44336',
        'termine'  => '#9E9E9E',
    );

    ?>
    <div class="wrap cocktailmusic-admin">
        <h1>Demandes de devis</h1>

        <div class="devis-stats">
            <?php
            $counts = array();
            foreach (array_keys($status_labels) as $s) {
                $count_query = new WP_Query(array(
                    'post_type'      => 'devis',
                    'posts_per_page' => -1,
                    'meta_query'     => array(array('key' => '_devis_statut', 'value' => $s)),
                    'fields'         => 'ids',
                ));
                $counts[$s] = $count_query->found_posts;
            }
            ?>
            <a href="<?php echo admin_url('admin.php?page=cocktailmusic-devis'); ?>" class="devis-stat-card <?php echo !$filter_status ? 'active' : ''; ?>">
                <span class="devis-stat-number"><?php echo array_sum($counts); ?></span>
                <span class="devis-stat-label">Total</span>
            </a>
            <?php foreach ($status_labels as $key => $label) : ?>
            <a href="<?php echo admin_url('admin.php?page=cocktailmusic-devis&status=' . $key); ?>" class="devis-stat-card <?php echo $filter_status === $key ? 'active' : ''; ?>" style="--stat-color: <?php echo $status_colors[$key]; ?>">
                <span class="devis-stat-number"><?php echo $counts[$key]; ?></span>
                <span class="devis-stat-label"><?php echo esc_html($label); ?></span>
            </a>
            <?php endforeach; ?>
        </div>

        <div class="devis-actions-bar">
            <a href="<?php echo wp_nonce_url(admin_url('admin.php?page=cocktailmusic-devis&export=csv'), 'export_devis'); ?>" class="button">Exporter en CSV</a>
        </div>

        <?php if ($devis_query->have_posts()) : ?>
        <table class="wp-list-table widefat fixed striped devis-table">
            <thead>
                <tr>
                    <th width="5%">ID</th>
                    <th width="13%">Date</th>
                    <th width="14%">Nom</th>
                    <th width="14%">Contact</th>
                    <th width="12%">Evenement</th>
                    <th width="10%">Date evt.</th>
                    <th width="12%">Lieu</th>
                    <th width="10%">Statut</th>
                    <th width="10%">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($devis_query->have_posts()) : $devis_query->the_post();
                    $id = get_the_ID();
                    $statut = get_post_meta($id, '_devis_statut', true) ?: 'nouveau';
                ?>
                <tr>
                    <td>#<?php echo $id; ?></td>
                    <td><?php echo get_the_date('d/m/Y H:i'); ?></td>
                    <td><strong><?php echo esc_html(get_post_meta($id, '_devis_nom_complet', true) ?: get_post_meta($id, '_devis_nom', true)); ?></strong></td>
                    <td>
                        <a href="mailto:<?php echo esc_attr(get_post_meta($id, '_devis_email', true)); ?>"><?php echo esc_html(get_post_meta($id, '_devis_email', true)); ?></a><br>
                        <a href="tel:<?php echo esc_attr(get_post_meta($id, '_devis_telephone', true)); ?>"><?php echo esc_html(get_post_meta($id, '_devis_telephone', true)); ?></a>
                    </td>
                    <td><?php echo esc_html(get_post_meta($id, '_devis_type_label', true)); ?></td>
                    <td>
                        <?php
                        $date_evt = get_post_meta($id, '_devis_date', true);
                        echo $date_evt ? date_i18n('d/m/Y', strtotime($date_evt)) : '-';
                        ?>
                    </td>
                    <td><?php echo esc_html(get_post_meta($id, '_devis_lieu_complet', true) ?: '-'); ?></td>
                    <td>
                        <span class="devis-status-badge" style="background-color: <?php echo $status_colors[$statut]; ?>">
                            <?php echo esc_html($status_labels[$statut] ?? $statut); ?>
                        </span>
                    </td>
                    <td>
                        <a href="#" class="devis-view-btn" data-id="<?php echo $id; ?>">Voir</a>
                        |
                        <a href="<?php echo wp_nonce_url(admin_url('admin.php?page=cocktailmusic-devis&delete_devis=' . $id), 'delete_devis'); ?>" onclick="return confirm('Supprimer cette demande ?');" class="devis-delete-btn">Suppr.</a>
                    </td>
                </tr>
                <!-- Detail row -->
                <tr class="devis-detail-row" id="devis-detail-<?php echo $id; ?>" style="display: none;">
                    <td colspan="9">
                        <div class="devis-detail">
                            <div class="devis-detail__grid">
                                <div class="devis-detail__section">
                                    <h4>Contact</h4>
                                    <p><strong>Nom :</strong> <?php echo esc_html(get_post_meta($id, '_devis_nom', true)); ?></p>
                                    <p><strong>Prenom :</strong> <?php echo esc_html(get_post_meta($id, '_devis_prenom', true)); ?></p>
                                    <p><strong>Email :</strong> <?php echo esc_html(get_post_meta($id, '_devis_email', true)); ?></p>
                                    <p><strong>Telephone :</strong> <?php echo esc_html(get_post_meta($id, '_devis_telephone', true)); ?></p>
                                </div>
                                <div class="devis-detail__section">
                                    <h4>Evenement</h4>
                                    <p><strong>Type :</strong> <?php echo esc_html(get_post_meta($id, '_devis_type_label', true)); ?></p>
                                    <p><strong>Date :</strong> <?php echo $date_evt ? date_i18n('j F Y', strtotime($date_evt)) : 'Non precisee'; ?></p>
                                    <p><strong>Code postal :</strong> <?php echo esc_html(get_post_meta($id, '_devis_code_postal', true) ?: '-'); ?></p>
                                    <p><strong>Lieu :</strong> <?php echo esc_html(get_post_meta($id, '_devis_lieu', true) ?: '-'); ?></p>
                                </div>
                                <div class="devis-detail__section devis-detail__section--full">
                                    <h4>Message</h4>
                                    <p><?php echo nl2br(esc_html(get_post_meta($id, '_devis_message', true) ?: 'Aucun message')); ?></p>
                                </div>
                            </div>
                            <div class="devis-detail__actions">
                                <strong>Changer le statut :</strong>
                                <?php foreach ($status_labels as $key => $label) : ?>
                                    <a href="<?php echo wp_nonce_url(admin_url('admin.php?page=cocktailmusic-devis&devis_id=' . $id . '&update_status=' . $key), 'update_devis_status'); ?>"
                                       class="button <?php echo $statut === $key ? 'button-primary' : ''; ?>"
                                       style="<?php echo $statut === $key ? 'background-color: ' . $status_colors[$key] . '; border-color: ' . $status_colors[$key] . ';' : ''; ?>">
                                        <?php echo esc_html($label); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <?php
        // Pagination
        $total_pages = $devis_query->max_num_pages;
        if ($total_pages > 1) {
            $current_page = max(1, isset($_GET['paged']) ? intval($_GET['paged']) : 1);
            echo '<div class="tablenav bottom"><div class="tablenav-pages">';
            echo paginate_links(array(
                'base'    => add_query_arg('paged', '%#%'),
                'format'  => '',
                'current' => $current_page,
                'total'   => $total_pages,
            ));
            echo '</div></div>';
        }
        ?>

        <?php wp_reset_postdata(); ?>
        <?php else : ?>
            <div class="devis-empty">
                <p>Aucune demande de devis pour le moment.</p>
            </div>
        <?php endif; ?>
    </div>
    <?php
}

/**
 * Calendar page
 */
function cocktailmusic_devis_calendar_page() {
    ?>
    <div class="wrap cocktailmusic-admin">
        <h1>Calendrier des evenements</h1>

        <div class="devis-calendar-actions">
            <a href="<?php echo wp_nonce_url(admin_url('admin.php?page=cocktailmusic-devis-calendar&export=ics'), 'export_calendar'); ?>" class="button button-primary">Exporter l'agenda (ICS)</a>
            <a href="<?php echo wp_nonce_url(admin_url('admin.php?page=cocktailmusic-devis-calendar&export=csv'), 'export_calendar'); ?>" class="button">Exporter en CSV</a>
        </div>

        <div class="devis-calendar-navigation">
            <?php
            $month = isset($_GET['month']) ? intval($_GET['month']) : intval(date('n'));
            $year = isset($_GET['year']) ? intval($_GET['year']) : intval(date('Y'));

            $prev_month = $month - 1;
            $prev_year = $year;
            if ($prev_month < 1) { $prev_month = 12; $prev_year--; }

            $next_month = $month + 1;
            $next_year = $year;
            if ($next_month > 12) { $next_month = 1; $next_year++; }

            $months_fr = array(1 => 'Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre');
            ?>
            <a href="<?php echo admin_url('admin.php?page=cocktailmusic-devis-calendar&month=' . $prev_month . '&year=' . $prev_year); ?>" class="button">&larr; Precedent</a>
            <h2><?php echo $months_fr[$month] . ' ' . $year; ?></h2>
            <a href="<?php echo admin_url('admin.php?page=cocktailmusic-devis-calendar&month=' . $next_month . '&year=' . $next_year); ?>" class="button">Suivant &rarr;</a>
        </div>

        <?php
        // Get events for this month
        $first_day = sprintf('%04d-%02d-01', $year, $month);
        $last_day = date('Y-m-t', strtotime($first_day));

        $events = new WP_Query(array(
            'post_type'      => 'devis',
            'posts_per_page' => -1,
            'meta_query'     => array(
                array(
                    'key'     => '_devis_date',
                    'value'   => array($first_day, $last_day),
                    'compare' => 'BETWEEN',
                    'type'    => 'DATE',
                ),
            ),
        ));

        // Organize events by date
        $events_by_date = array();
        while ($events->have_posts()) {
            $events->the_post();
            $id = get_the_ID();
            $date = get_post_meta($id, '_devis_date', true);
            if (!isset($events_by_date[$date])) {
                $events_by_date[$date] = array();
            }
            $events_by_date[$date][] = array(
                'id'     => $id,
                'nom'    => get_post_meta($id, '_devis_nom', true),
                'type'   => get_post_meta($id, '_devis_type_label', true),
                'lieu'   => get_post_meta($id, '_devis_lieu_complet', true),
                'statut' => get_post_meta($id, '_devis_statut', true) ?: 'nouveau',
            );
        }
        wp_reset_postdata();

        $status_colors = array(
            'nouveau'  => '#2196F3',
            'en_cours' => '#FF9800',
            'accepte'  => '#4CAF50',
            'refuse'   => '#f44336',
            'termine'  => '#9E9E9E',
        );

        // Build calendar
        $days_in_month = intval(date('t', strtotime($first_day)));
        $first_weekday = intval(date('N', strtotime($first_day))); // 1=Monday
        $today = date('Y-m-d');
        ?>

        <table class="devis-calendar">
            <thead>
                <tr>
                    <th>Lun</th>
                    <th>Mar</th>
                    <th>Mer</th>
                    <th>Jeu</th>
                    <th>Ven</th>
                    <th>Sam</th>
                    <th>Dim</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $day = 1;
                $cell = 1;
                $rows = ceil(($days_in_month + $first_weekday - 1) / 7);

                for ($row = 0; $row < $rows; $row++) :
                ?>
                <tr>
                    <?php for ($col = 1; $col <= 7; $col++) :
                        $current_cell = $row * 7 + $col;
                        if ($current_cell < $first_weekday || $day > $days_in_month) :
                    ?>
                        <td class="devis-calendar__empty"></td>
                    <?php else :
                        $date_str = sprintf('%04d-%02d-%02d', $year, $month, $day);
                        $is_today = ($date_str === $today);
                        $has_events = isset($events_by_date[$date_str]);
                    ?>
                        <td class="devis-calendar__day <?php echo $is_today ? 'is-today' : ''; ?> <?php echo $has_events ? 'has-events' : ''; ?>">
                            <span class="devis-calendar__date"><?php echo $day; ?></span>
                            <?php if ($has_events) : ?>
                                <div class="devis-calendar__events">
                                    <?php foreach ($events_by_date[$date_str] as $event) : ?>
                                        <a href="<?php echo admin_url('admin.php?page=cocktailmusic-devis'); ?>" class="devis-calendar__event" style="border-left-color: <?php echo $status_colors[$event['statut']]; ?>">
                                            <strong><?php echo esc_html($event['nom']); ?></strong>
                                            <span><?php echo esc_html($event['type']); ?></span>
                                            <?php if ($event['lieu']) : ?>
                                                <span><?php echo esc_html($event['lieu']); ?></span>
                                            <?php endif; ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </td>
                    <?php
                        $day++;
                        endif;
                    endfor; ?>
                </tr>
                <?php endfor; ?>
            </tbody>
        </table>

        <div class="devis-calendar-legend">
            <strong>Legende :</strong>
            <?php
            $status_labels = array(
                'nouveau'  => 'Nouveau',
                'en_cours' => 'En cours',
                'accepte'  => 'Accepte',
                'refuse'   => 'Refuse',
                'termine'  => 'Termine',
            );
            foreach ($status_labels as $key => $label) : ?>
                <span class="devis-calendar-legend__item">
                    <span class="devis-calendar-legend__dot" style="background-color: <?php echo $status_colors[$key]; ?>"></span>
                    <?php echo esc_html($label); ?>
                </span>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
}

/**
 * Handle CSV and ICS export
 */
function cocktailmusic_handle_export() {
    if (!isset($_GET['export']) || !current_user_can('manage_options')) {
        return;
    }

    // CSV export from devis list
    if (isset($_GET['page']) && $_GET['page'] === 'cocktailmusic-devis' && $_GET['export'] === 'csv') {
        if (!wp_verify_nonce($_GET['_wpnonce'], 'export_devis')) {
            return;
        }

        $args = array(
            'post_type'      => 'devis',
            'posts_per_page' => -1,
            'orderby'        => 'date',
            'order'          => 'DESC',
        );

        if (isset($_GET['status']) && $_GET['status']) {
            $args['meta_query'] = array(
                array('key' => '_devis_statut', 'value' => sanitize_text_field($_GET['status'])),
            );
        }

        $devis = new WP_Query($args);

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=devis-cocktailmusic-' . date('Y-m-d') . '.csv');

        $output = fopen('php://output', 'w');
        // BOM for Excel UTF-8
        fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

        fputcsv($output, array('ID', 'Date demande', 'Nom', 'Prenom', 'Email', 'Telephone', 'Type evenement', 'Date evenement', 'Code postal', 'Ville', 'Message', 'Statut'), ';');

        while ($devis->have_posts()) {
            $devis->the_post();
            $id = get_the_ID();
            fputcsv($output, array(
                $id,
                get_the_date('d/m/Y H:i'),
                get_post_meta($id, '_devis_nom', true),
                get_post_meta($id, '_devis_prenom', true),
                get_post_meta($id, '_devis_email', true),
                get_post_meta($id, '_devis_telephone', true),
                get_post_meta($id, '_devis_type_label', true),
                get_post_meta($id, '_devis_date', true),
                get_post_meta($id, '_devis_code_postal', true),
                get_post_meta($id, '_devis_lieu', true),
                get_post_meta($id, '_devis_message', true),
                get_post_meta($id, '_devis_statut', true),
            ), ';');
        }
        wp_reset_postdata();
        fclose($output);
        exit;
    }

    // Calendar exports (CSV or ICS)
    if (isset($_GET['page']) && $_GET['page'] === 'cocktailmusic-devis-calendar') {
        if (!wp_verify_nonce($_GET['_wpnonce'], 'export_calendar')) {
            return;
        }

        $devis = new WP_Query(array(
            'post_type'      => 'devis',
            'posts_per_page' => -1,
            'meta_query'     => array(
                array(
                    'key'     => '_devis_date',
                    'value'   => '',
                    'compare' => '!=',
                ),
                array(
                    'key'     => '_devis_statut',
                    'value'   => 'refuse',
                    'compare' => '!=',
                ),
            ),
            'orderby'        => 'meta_value',
            'meta_key'       => '_devis_date',
            'order'          => 'ASC',
        ));

        if ($_GET['export'] === 'ics') {
            header('Content-Type: text/calendar; charset=utf-8');
            header('Content-Disposition: attachment; filename=agenda-cocktailmusic.ics');

            echo "BEGIN:VCALENDAR\r\n";
            echo "VERSION:2.0\r\n";
            echo "PRODID:-//Cocktail Music//Agenda//FR\r\n";
            echo "CALSCALE:GREGORIAN\r\n";
            echo "METHOD:PUBLISH\r\n";
            echo "X-WR-CALNAME:Cocktail Music - Agenda\r\n";
            echo "X-WR-TIMEZONE:Europe/Paris\r\n";

            while ($devis->have_posts()) {
                $devis->the_post();
                $id = get_the_ID();
                $date = get_post_meta($id, '_devis_date', true);
                $nom = get_post_meta($id, '_devis_nom', true);
                $type = get_post_meta($id, '_devis_type_label', true);
                $lieu = get_post_meta($id, '_devis_lieu_complet', true);
                $tel = get_post_meta($id, '_devis_telephone', true);
                $email_contact = get_post_meta($id, '_devis_email', true);
                $msg = get_post_meta($id, '_devis_message', true);
                $statut = get_post_meta($id, '_devis_statut', true);

                $status_labels = array(
                    'nouveau'  => 'Nouveau',
                    'en_cours' => 'En cours',
                    'accepte'  => 'Accepte',
                    'termine'  => 'Termine',
                );

                $date_formatted = str_replace('-', '', $date);
                $uid = 'devis-' . $id . '@cocktailmusic.fr';
                $created = get_the_date('Ymd\THis');

                $description = "Client: $nom\\nTel: $tel\\nEmail: $email_contact\\nType: $type\\nStatut: " . ($status_labels[$statut] ?? $statut);
                if ($msg) {
                    $description .= "\\nMessage: $msg";
                }

                echo "BEGIN:VEVENT\r\n";
                echo "UID:$uid\r\n";
                echo "DTSTART;VALUE=DATE:$date_formatted\r\n";
                echo "DTEND;VALUE=DATE:$date_formatted\r\n";
                echo "DTSTAMP:{$created}\r\n";
                echo "SUMMARY:" . cocktailmusic_ical_escape("[$type] $nom") . "\r\n";
                echo "DESCRIPTION:" . cocktailmusic_ical_escape($description) . "\r\n";
                if ($lieu) {
                    echo "LOCATION:" . cocktailmusic_ical_escape($lieu) . "\r\n";
                }
                echo "STATUS:CONFIRMED\r\n";
                echo "END:VEVENT\r\n";
            }
            wp_reset_postdata();

            echo "END:VCALENDAR\r\n";
            exit;
        }

        if ($_GET['export'] === 'csv') {
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=agenda-cocktailmusic-' . date('Y-m-d') . '.csv');

            $output = fopen('php://output', 'w');
            fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($output, array('Date evenement', 'Nom', 'Type', 'Lieu', 'Telephone', 'Email', 'Statut'), ';');

            while ($devis->have_posts()) {
                $devis->the_post();
                $id = get_the_ID();
                fputcsv($output, array(
                    get_post_meta($id, '_devis_date', true),
                    get_post_meta($id, '_devis_nom', true),
                    get_post_meta($id, '_devis_type_label', true),
                    get_post_meta($id, '_devis_lieu_complet', true),
                    get_post_meta($id, '_devis_telephone', true),
                    get_post_meta($id, '_devis_email', true),
                    get_post_meta($id, '_devis_statut', true),
                ), ';');
            }
            wp_reset_postdata();
            fclose($output);
            exit;
        }
    }
}
add_action('admin_init', 'cocktailmusic_handle_export');

/**
 * Escape string for iCalendar format
 */
function cocktailmusic_ical_escape($string) {
    $string = str_replace(array("\r\n", "\n", "\r"), '\\n', $string);
    $string = str_replace(array(',', ';'), array('\\,', '\\;'), $string);
    return $string;
}

/**
 * Add devis count bubble to admin menu
 */
function cocktailmusic_admin_menu_count() {
    global $menu;

    $count = get_transient('cocktailmusic_new_devis_count');
    if ($count === false) {
        $count_query = new WP_Query(array(
            'post_type'      => 'devis',
            'posts_per_page' => -1,
            'meta_query'     => array(array('key' => '_devis_statut', 'value' => 'nouveau')),
            'fields'         => 'ids',
        ));
        $count = $count_query->found_posts;
        set_transient('cocktailmusic_new_devis_count', $count, 300);
    }

    if ($count > 0 && is_array($menu)) {
        foreach ($menu as $key => $item) {
            if (isset($item[2]) && $item[2] === 'cocktailmusic-devis') {
                $menu[$key][0] .= sprintf(' <span class="awaiting-mod">%d</span>', $count);
                break;
            }
        }
    }
}
add_action('admin_menu', 'cocktailmusic_admin_menu_count', 999);

/**
 * Clear devis count cache when status changes
 */
function cocktailmusic_clear_devis_cache() {
    delete_transient('cocktailmusic_new_devis_count');
}
add_action('save_post_devis', 'cocktailmusic_clear_devis_cache');
add_action('updated_post_meta', 'cocktailmusic_clear_devis_cache');
