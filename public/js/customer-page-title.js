(() => {
    'use strict';

    const pageIcons = [
        [/dashboard|good to see you|welcome back|home/i, '🏠'],
        [/address|location|delivery/i, '📍'],
        [/order|buy again/i, '📦'],
        [/cart|basket/i, '🛒'],
        [/payment|receipt|transaction/i, '💳'],
        [/return|refund/i, '↩️'],
        [/profile|account/i, '👤'],
        [/setting|preference/i, '⚙️'],
        [/wishlist|saved/i, '💜'],
        [/price watch|tracked/i, '🏷️'],
        [/compare/i, '⚖️'],
        [/budget/i, '💰'],
        [/gift/i, '🎁'],
        [/camera|try.on|visual/i, '📸'],
        [/ai hub|assistant|smart ai|chat/i, '✨'],
        [/trend/i, '📈'],
        [/product|shop|catalog/i, '🛍️'],
        [/success|placed/i, '🎉'],
        [/security|password/i, '🔐'],
    ];

    function iconFor(title) {
        const label = title.textContent.replace(/\s+/g, ' ').trim();
        const match = pageIcons.find(([pattern]) => pattern.test(label));
        return match?.[1] || '📄';
    }

    const pageDescriptions = [
        [/dashboard|good to see you|welcome back|home/i, 'Your shopping, orders and saved items at a glance.'],
        [/address|location|delivery/i, 'Manage delivery details for a smoother checkout.'],
        [/order|buy again/i, 'Track your purchases and follow each delivery.'],
        [/cart|basket/i, 'Review your selected items before checkout.'],
        [/payment|receipt|transaction/i, 'Review secure payment details for your orders.'],
        [/return|refund/i, 'Follow the status of your return and refund requests.'],
        [/profile|account/i, 'Keep your account details current and secure.'],
        [/setting|preference/i, 'Manage preferences for your Smart Basket experience.'],
        [/wishlist|saved/i, 'Products you save for later are collected here.'],
        [/price watch|tracked/i, 'Keep an eye on products and their prices.'],
        [/compare/i, 'Compare product details to choose with confidence.'],
        [/budget/i, 'Find available products that fit your spending limit.'],
        [/gift/i, 'Discover thoughtful products for the people you care about.'],
        [/camera|try.on|visual/i, 'Explore products with AI-powered visual tools.'],
        [/ai hub|assistant|smart ai|chat/i, 'Smart tools to help you find the right products.'],
        [/trend/i, 'Explore popular products customers are viewing.'],
        [/product|shop|catalog/i, 'Browse products selected for your shopping needs.'],
        [/success|placed/i, 'Your order is confirmed. We’ll keep you updated.'],
        [/security|password/i, 'Manage the security settings for your account.'],
    ];

    function descriptionFor(title) {
        const label = title.textContent.replace(/\s+/g, ' ').trim();
        return pageDescriptions.find(([pattern]) => pattern.test(label))?.[1]
            || 'Explore this section of your Smart Basket account.';
    }

    function removeInlineEmoji(title) {
        const walker = document.createTreeWalker(title, NodeFilter.SHOW_TEXT);
        const textNodes = [];
        while (walker.nextNode()) {
            if (!walker.currentNode.parentElement?.classList.contains('sb-customer-page-icon')) {
                textNodes.push(walker.currentNode);
            }
        }
        textNodes.forEach((node) => {
            node.textContent = node.textContent
                .replace(/[\p{Extended_Pictographic}\uFE0F\u200D]/gu, '')
                .replace(/\s+/g, ' ');
        });
    }

    function enhancePageTitle(root) {
        const title = Array.from(root.querySelectorAll('h1')).find((heading) =>
            !heading.closest('nav, aside, .modal, .dropdown-menu, [aria-hidden="true"]')
            && heading.getClientRects().length > 0
        );

        if (!title) return;

        let hero = title.closest('.sb-customer-page-hero');
        if (!hero) {
            hero = document.createElement('section');
            hero.className = 'sb-customer-page-hero sb-customer-page-hero--generated';
            const copy = document.createElement('div');
            copy.className = 'sb-customer-page-hero__copy';
            title.parentNode.insertBefore(hero, title);
            hero.appendChild(copy);
            copy.appendChild(title);

            const subtitle = hero.nextElementSibling;
            if (subtitle?.tagName === 'P' && !subtitle.closest('form')) {
                subtitle.classList.add('sb-customer-page-hero__subtitle');
                copy.appendChild(subtitle);
            }
        }

        title.classList.remove('sb-page-brand-title');
        title.classList.add('sb-customer-page-title');

        removeInlineEmoji(title);
        const emoji = iconFor(title);
        let icon = title.querySelector(':scope > .sb-customer-page-icon');
        if (!icon) {
            icon = document.createElement('span');
            icon.className = 'sb-customer-page-icon';
            icon.setAttribute('aria-hidden', 'true');
            title.insertBefore(icon, title.firstChild);
        }
        icon.textContent = emoji;
        title.querySelectorAll(':scope > i.fa-solid, :scope > i.fa-regular, :scope > i.fa-brands, :scope > i.fas, :scope > i.far, :scope > i.fab')
            .forEach((glyph) => glyph.remove());

        const copy = hero.querySelector('.sb-customer-page-hero__copy') || hero;
        if (!copy.querySelector('.sb-customer-page-hero__subtitle')) {
            const subtitle = document.createElement('p');
            subtitle.className = 'sb-customer-page-hero__subtitle';
            subtitle.textContent = descriptionFor(title);
            title.insertAdjacentElement('afterend', subtitle);
        }
    }

    const roots = Array.from(document.querySelectorAll('.sb-main, .sb-page, .customer-page, main'));
    const outermostRoots = roots.filter((root) =>
        !roots.some((other) => other !== root && other.contains(root))
    );
    (outermostRoots.length ? outermostRoots : [document.body]).forEach(enhancePageTitle);
})();
