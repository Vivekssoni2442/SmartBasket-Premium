(function () {

    'use strict';

    function initAIHub() {

        const fab = document.querySelector('[data-ai-hub-open]');
        const drawer = document.querySelector('[data-ai-hub-drawer]');
        const overlay = document.querySelector('.ai-hub-overlay');

        if (!fab || !drawer) {
            console.warn('AI HUB: Navigation elements not found.');
            return;
        }


        /* =====================================================
           OPEN
        ====================================================== */

        function openHub() {

            drawer.classList.add('is-open');

            if (overlay) {
                overlay.classList.add('is-open');
            }

            drawer.setAttribute('aria-hidden', 'false');
            fab.setAttribute('aria-expanded', 'true');

            document.body.classList.add('ai-hub-open');

        }


        /* =====================================================
           CLOSE
        ====================================================== */

        function closeHub() {

            drawer.classList.remove('is-open');

            if (overlay) {
                overlay.classList.remove('is-open');
            }

            drawer.setAttribute('aria-hidden', 'true');
            fab.setAttribute('aria-expanded', 'false');

            document.body.classList.remove('ai-hub-open');

        }


        /* =====================================================
           FAB CLICK
        ====================================================== */

        fab.addEventListener('click', function (event) {

            event.preventDefault();
            event.stopPropagation();

            if (drawer.classList.contains('is-open')) {
                closeHub();
            } else {
                openHub();
            }

        });


        /* =====================================================
           CLOSE BUTTONS
        ====================================================== */

        document
            .querySelectorAll('[data-ai-hub-close]')
            .forEach(function (button) {

                button.addEventListener('click', function (event) {

                    event.preventDefault();
                    event.stopPropagation();

                    closeHub();

                });

            });


        /* =====================================================
           OVERLAY
        ====================================================== */

        if (overlay) {

            overlay.addEventListener('click', function () {

                closeHub();

            });

        }


        /* =====================================================
           ESC
        ====================================================== */

        document.addEventListener('keydown', function (event) {

            if (event.key === 'Escape') {
                closeHub();
            }

        });


        /* =====================================================
           TOOL LINKS
        ====================================================== */

        document
            .querySelectorAll('[data-ai-hub-link]')
            .forEach(function (link) {

                link.addEventListener('click', function () {

                    closeHub();

                });

            });


        console.log('SMART BASKET AI HUB loaded successfully.');

    }


    /* =========================================================
       DOM READY
    ========================================================== */

    if (document.readyState === 'loading') {

        document.addEventListener(
            'DOMContentLoaded',
            initAIHub
        );

    } else {

        initAIHub();

    }

})();