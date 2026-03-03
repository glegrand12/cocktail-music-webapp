/**
 * Cocktail Music - Admin Devis JavaScript
 *
 * @package CocktailMusic
 */

(function() {
    'use strict';

    function init() {
        // Toggle detail rows
        var viewBtns = document.querySelectorAll('.devis-view-btn');
        viewBtns.forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                var id = this.getAttribute('data-id');
                var detailRow = document.getElementById('devis-detail-' + id);
                if (detailRow) {
                    var isVisible = detailRow.style.display !== 'none';
                    detailRow.style.display = isVisible ? 'none' : 'table-row';
                    this.textContent = isVisible ? 'Voir' : 'Masquer';
                }
            });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
