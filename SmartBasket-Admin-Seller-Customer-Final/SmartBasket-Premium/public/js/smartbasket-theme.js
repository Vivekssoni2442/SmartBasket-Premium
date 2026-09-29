(function () {
    'use strict';

    const STORAGE_KEY = 'smartbasket-theme';

    function getSystemTheme() {
        return window.matchMedia &&
            window.matchMedia('(prefers-color-scheme: dark)').matches
            ? 'dark'
            : 'light';
    }

    function getServerTheme() {
        const meta = document.querySelector(
            'meta[name="smartbasket-user-theme"]'
        );

        if (!meta) {
            return null;
        }

        const theme = meta.getAttribute('content');

        return ['light', 'dark', 'system'].includes(theme)
            ? theme
            : null;
    }

    function getBrowserTheme() {
        try {
            const saved = localStorage.getItem(STORAGE_KEY);

            if (['light', 'dark', 'system'].includes(saved)) {
                return saved;
            }
        } catch (error) {
            // Ignore storage errors.
        }

        return 'system';
    }

    function getSavedTheme() {
        const serverTheme = getServerTheme();

        if (serverTheme) {
            return serverTheme;
        }

        return getBrowserTheme();
    }

    function applyTheme(theme) {
        if (!['light', 'dark', 'system'].includes(theme)) {
            theme = 'system';
        }

        const finalTheme =
            theme === 'system'
                ? getSystemTheme()
                : theme;

        document.documentElement.setAttribute(
            'data-theme',
            finalTheme
        );

        document.documentElement.setAttribute(
            'data-sb-theme',
            finalTheme
        );

        if (document.body) {
            document.body.setAttribute(
                'data-theme',
                finalTheme
            );
        }

        try {
            localStorage.setItem(
                STORAGE_KEY,
                theme
            );
        } catch (error) {
            // Ignore storage errors.
        }
    }

    function setTheme(theme) {
        if (!['light', 'dark', 'system'].includes(theme)) {
            theme = 'system';
        }

        applyTheme(theme);

        window.dispatchEvent(
            new CustomEvent(
                'smartbasket:theme-changed',
                {
                    detail: {
                        theme: theme
                    }
                }
            )
        );
    }

    window.SmartBasketTheme = {
        set: setTheme,
        get: getSavedTheme,
        apply: applyTheme
    };

    /*
    | Apply theme as soon as DOM is ready.
    */

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () {
            applyTheme(getSavedTheme());
        });
    } else {
        applyTheme(getSavedTheme());
    }

    /*
    | System theme changes.
    */

    if (window.matchMedia) {
        const media = window.matchMedia(
            '(prefers-color-scheme: dark)'
        );

        const systemThemeChanged = function () {
            const currentPreference =
                getServerTheme() ||
                getBrowserTheme();

            if (currentPreference === 'system') {
                applyTheme('system');
            }
        };

        if (media.addEventListener) {
            media.addEventListener(
                'change',
                systemThemeChanged
            );
        } else {
            media.addListener(
                systemThemeChanged
            );
        }
    }
})();