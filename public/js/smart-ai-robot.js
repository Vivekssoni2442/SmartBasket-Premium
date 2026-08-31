(() => {
    'use strict';

    if (window.__smartBasketRobotLoaded) return;
    window.__smartBasketRobotLoaded = true;

    const root = document.querySelector('[data-smart-ai]');
    if (!root) return;

    const $ = selector => root.querySelector(selector);

    const panel = $('[data-smart-ai-panel]');
    const chat = $('[data-smart-ai-chat]');
    const form = $('[data-smart-ai-form]');
    const input = $('[data-smart-ai-input]');
    const stage = $('[data-smart-ai-stage]');
    const thought = $('[data-smart-ai-thought]');
    const status = $('[data-smart-ai-status]');
    const mic = $('[data-smart-ai-mic]');
    const openButton = $('[data-smart-ai-open]');
    const closeButton = $('[data-smart-ai-close]');
    const minimizeButton = $('[data-smart-ai-minimize]');

    const endpoint = root.dataset.endpoint;
    const csrf = root.dataset.csrf;

    let selectedProductId = null;
    let recognition = null;

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    */

    const urls = {
        products: root.dataset.productsUrl,
        cart: root.dataset.cartUrl,
        checkout: root.dataset.checkoutUrl,
        orders: root.dataset.ordersUrl,
        settings: root.dataset.settingsUrl,
        login: root.dataset.loginUrl,
    };

    /*
    |--------------------------------------------------------------------------
    | Voice System
    |--------------------------------------------------------------------------
    */

    const speech = {
        voices: [],
        currentUtterance: null,
        speaking: false,
        preferredLanguage: localStorage.getItem('smart-ai-language') || null,
    };

    const LANGUAGE_MAP = {
        hindi: 'hi-IN',
        hi: 'hi-IN',
        hinglish: 'hi-IN',

        gujarati: 'gu-IN',
        gu: 'gu-IN',

        english: 'en-IN',
        en: 'en-IN',

        marathi: 'mr-IN',
        mr: 'mr-IN',

        bengali: 'bn-IN',
        bn: 'bn-IN',

        tamil: 'ta-IN',
        ta: 'ta-IN',

        telugu: 'te-IN',
        te: 'te-IN',

        kannada: 'kn-IN',
        kn: 'kn-IN',

        malayalam: 'ml-IN',
        ml: 'ml-IN',

        punjabi: 'pa-IN',
        pa: 'pa-IN',

        urdu: 'ur-IN',
        ur: 'ur-IN',

        arabic: 'ar-SA',
        ar: 'ar-SA',

        french: 'fr-FR',
        fr: 'fr-FR',

        german: 'de-DE',
        de: 'de-DE',

        spanish: 'es-ES',
        es: 'es-ES',

        italian: 'it-IT',
        it: 'it-IT',

        portuguese: 'pt-BR',
        pt: 'pt-BR',

        japanese: 'ja-JP',
        ja: 'ja-JP',

        korean: 'ko-KR',
        ko: 'ko-KR',

        chinese: 'zh-CN',
        zh: 'zh-CN',

        russian: 'ru-RU',
        ru: 'ru-RU',
    };

    const refreshVoices = () => {
        if (!('speechSynthesis' in window)) return;

        const voices = window.speechSynthesis.getVoices();

        if (Array.isArray(voices) && voices.length) {
            speech.voices = voices;
        }
    };

    if ('speechSynthesis' in window) {
        refreshVoices();

        window.speechSynthesis.onvoiceschanged = refreshVoices;

        setTimeout(refreshVoices, 100);
        setTimeout(refreshVoices, 500);
        setTimeout(refreshVoices, 1500);
    }

    /*
    |--------------------------------------------------------------------------
    | Detect Language
    |--------------------------------------------------------------------------
    */

    const detectLanguage = text => {
        const value = String(text || '').trim();

        if (!value) return 'en-IN';

        /*
         * Gujarati Unicode
         */
        if (/[\u0A80-\u0AFF]/.test(value)) {
            return 'gu-IN';
        }

        /*
         * Hindi / Devanagari
         */
        if (/[\u0900-\u097F]/.test(value)) {
            return 'hi-IN';
        }

        /*
         * Bengali
         */
        if (/[\u0980-\u09FF]/.test(value)) {
            return 'bn-IN';
        }

        /*
         * Punjabi
         */
        if (/[\u0A00-\u0A7F]/.test(value)) {
            return 'pa-IN';
        }

        /*
         * Tamil
         */
        if (/[\u0B80-\u0BFF]/.test(value)) {
            return 'ta-IN';
        }

        /*
         * Telugu
         */
        if (/[\u0C00-\u0C7F]/.test(value)) {
            return 'te-IN';
        }

        /*
         * Kannada
         */
        if (/[\u0C80-\u0CFF]/.test(value)) {
            return 'kn-IN';
        }

        /*
         * Malayalam
         */
        if (/[\u0D00-\u0D7F]/.test(value)) {
            return 'ml-IN';
        }

        /*
         * Urdu / Arabic
         */
        if (/[\u0600-\u06FF]/.test(value)) {
            return 'ur-IN';
        }

        /*
         * Japanese
         */
        if (/[\u3040-\u30FF]/.test(value)) {
            return 'ja-JP';
        }

        /*
         * Korean
         */
        if (/[\uAC00-\uD7AF]/.test(value)) {
            return 'ko-KR';
        }

        /*
         * Chinese
         */
        if (/[\u4E00-\u9FFF]/.test(value)) {
            return 'zh-CN';
        }

        /*
         * Latin text.
         *
         * Detect common Hindi/Hinglish words.
         */
        const lower = value.toLowerCase();

        const hindiWords = [
            'hai',
            'ho',
            'karo',
            'kar',
            'mujhe',
            'mera',
            'meri',
            'mere',
            'aap',
            'apko',
            'tum',
            'tumhe',
            'chahiye',
            'dikhao',
            'batao',
            'bata',
            'khareed',
            'kharid',
            'jodo',
            'hatao',
            'nacho',
            'nach',
            'hanso',
            'hasi',
            'so',
            'utho',
            'chalo',
            'kya',
            'kaise',
            'kitna',
            'kitne',
            'sasta',
            'mehenga',
            'accha',
            'achha',
            'product',
            'shopping',
        ];

        const containsHindiWords = hindiWords.some(word => {
            return new RegExp(`\\b${word}\\b`, 'i').test(lower);
        });

        if (containsHindiWords) {
            return 'hi-IN';
        }

        return 'en-IN';
    };

    /*
    |--------------------------------------------------------------------------
    | Voice Selection
    |--------------------------------------------------------------------------
    */

    const normalizeLanguage = language => {
        if (!language) return 'en-IN';

        const key = String(language)
            .trim()
            .toLowerCase();

        return LANGUAGE_MAP[key] || language;
    };

    const languageScore = (voice, target) => {
        const voiceLang = String(voice.lang || '').toLowerCase();
        const wanted = String(target || '').toLowerCase();

        if (!voiceLang || !wanted) return 0;

        if (voiceLang === wanted) return 100;

        const voiceBase = voiceLang.split('-')[0];
        const wantedBase = wanted.split('-')[0];

        if (voiceBase === wantedBase) return 80;

        /*
         * Indian English fallback
         */
        if (
            wanted === 'en-in' &&
            ['en-us', 'en-gb', 'en-au', 'en-ca'].includes(voiceLang)
        ) {
            return 50;
        }

        /*
         * Hindi fallback
         */
        if (
            wanted === 'hi-in' &&
            voiceBase === 'hi'
        ) {
            return 90;
        }

        /*
         * Gujarati fallback
         */
        if (
            wanted === 'gu-in' &&
            voiceBase === 'gu'
        ) {
            return 90;
        }

        return 0;
    };

    const findBestVoice = language => {
        refreshVoices();

        if (!speech.voices.length) {
            return null;
        }

        const target = normalizeLanguage(language);

        const ranked = speech.voices
            .map(voice => ({
                voice,
                score: languageScore(voice, target),
            }))
            .filter(item => item.score > 0)
            .sort((a, b) => b.score - a.score);

        return ranked[0]?.voice || speech.voices[0];
    };

    /*
    |--------------------------------------------------------------------------
    | Speech Cleanup
    |--------------------------------------------------------------------------
    */

    const cleanSpeechText = text => {
        return String(text || '')
            .replace(/https?:\/\/\S+/gi, '')
            .replace(/www\.\S+/gi, '')
            .replace(/[*_#`]/g, '')
            .replace(/<\/?[^>]+>/g, '')
            .replace(/\s+/g, ' ')
            .trim();
    };

    /*
    |--------------------------------------------------------------------------
    | Speak
    |--------------------------------------------------------------------------
    */

    const stopSpeaking = () => {
        if (!('speechSynthesis' in window)) return;

        try {
            window.speechSynthesis.cancel();
        } catch (_) {}

        speech.currentUtterance = null;
        speech.speaking = false;
    };

    const speak = text => {
        const cleanText = cleanSpeechText(text);

        if (!cleanText) return;

        if (!('speechSynthesis' in window)) {
            return;
        }

        stopSpeaking();

        refreshVoices();

        const language = detectLanguage(cleanText);

        localStorage.setItem(
            'smart-ai-language',
            language
        );

        const voice = findBestVoice(language);

        const utterance =
            new SpeechSynthesisUtterance(cleanText);

        utterance.lang = language;

        if (voice) {
            utterance.voice = voice;
        }

        /*
        |--------------------------------------------------------------------------
        | Natural voice settings
        |--------------------------------------------------------------------------
        */

        utterance.rate = 0.98;
        utterance.pitch = 1.02;
        utterance.volume = 1;

        speech.currentUtterance = utterance;

        utterance.onstart = () => {
            speech.speaking = true;

            setExpression(
                'speaking',
                'Speaking…'
            );
        };

        utterance.onend = () => {
            speech.speaking = false;

            if (
                stage.dataset.expression === 'speaking'
            ) {
                setExpression(
                    'happy',
                    'Ready to help'
                );
            }
        };

        utterance.onerror = () => {
            speech.speaking = false;

            if (
                stage.dataset.expression === 'speaking'
            ) {
                setExpression(
                    'happy',
                    'Ready to help'
                );
            }
        };

        try {
            window.speechSynthesis.speak(
                utterance
            );
        } catch (_) {
            speech.speaking = false;
        }
    };

    /*
    |--------------------------------------------------------------------------
    | Robot Expression
    |--------------------------------------------------------------------------
    */

    const setExpression = (
        expression = 'normal',
        label = 'Ready to help'
    ) => {
        if (!stage) return;

        stage.dataset.expression = expression;

        if (status) {
            status.textContent = label;
        }

        if (thought) {
            thought.textContent = ({
                thinking:
                    'Let me think about that…',

                listening:
                    'I am listening…',

                speaking:
                    'Smart AI is speaking…',

                happy:
                    'Happy to help!',

                excited:
                    'That sounds fun!',

                dance:
                    'Beep boop, dance mode! 💃',

                wave:
                    'Hello there! 👋',

                smile:
                    '😊',

                laughing:
                    'Ha ha! 😂',

                jump:
                    'Wheee! 🚀',

                celebrate:
                    'Fantastic! 🎉',

                sleep:
                    'Zzz… 😴',

                wake:
                    'I am awake!',

                singing:
                    '♪ A little AI tune ♪',

                sad:
                    'I am still here to help.',
            })[expression]
                || 'How can I help you shop?';
        }
    };

    /*
    |--------------------------------------------------------------------------
    | Chat UI
    |--------------------------------------------------------------------------
    */

    const scrollChat = () => {
        if (!chat) return;

        chat.scrollTop =
            chat.scrollHeight;
    };

    const addMessage = (
        text,
        role = 'ai',
        extra = null
    ) => {
        const message =
            document.createElement('article');

        message.className =
            `smart-ai__message smart-ai__message--${role}`;

        message.textContent = text;

        if (extra) {
            message.append(extra);
        }

        chat.append(message);

        scrollChat();

        return message;
    };

    const typing = () => {
        const indicator =
            document.createElement('article');

        indicator.className =
            'smart-ai__message smart-ai__message--ai smart-ai__typing';

        indicator.innerHTML =
            '<i></i><i></i><i></i>';

        chat.append(indicator);

        scrollChat();

        return indicator;
    };

    /*
    |--------------------------------------------------------------------------
    | Visible Products
    |--------------------------------------------------------------------------
    */

    const visibleProductIds = () => {
        return [
            ...document.querySelectorAll(
                '[data-smart-ai-product-id]'
            ),
        ]
            .map(card =>
                Number(
                    card.dataset.smartAiProductId
                )
            )
            .filter(Boolean);
    };

    /*
    |--------------------------------------------------------------------------
    | Recommendations
    |--------------------------------------------------------------------------
    */

    const recommendationButtons = products => {
        const wrap =
            document.createElement('div');

        wrap.className =
            'smart-ai__recommendations';

        products.forEach(product => {
            const button =
                document.createElement('button');

            button.type = 'button';

            button.textContent =
                `${product.name} — ₹${Number(
                    product.price
                ).toLocaleString('en-IN')}`;

            button.addEventListener(
                'click',
                () => {
                    window.location.assign(
                        `${root.dataset.productUrl}/${product.id}`
                    );
                }
            );

            wrap.append(button);
        });

        return wrap;
    };

    /*
    |--------------------------------------------------------------------------
    | Cart Actions
    |--------------------------------------------------------------------------
    */

    const mutateCart = async (
        url,
        method
    ) => {
        const response =
            await fetch(
                url,
                {
                    method,

                    headers: {
                        'X-CSRF-TOKEN': csrf,
                        'X-Requested-With':
                            'XMLHttpRequest',
                        Accept:
                            'application/json',
                    },

                    credentials:
                        'same-origin',
                }
            );

        if (!response.ok) {
            throw new Error(
                'Cart request failed'
            );
        }

        return response;
    };

    /*
    |--------------------------------------------------------------------------
    | Robot Gestures
    |--------------------------------------------------------------------------
    */

    const gestureLabels = {
        dance: 'Dance mode!',
        wave: 'Hello there!',
        smile: 'Smiling!',
        laughing: 'Ha ha ha!',
        jump: 'Jumping!',
        celebrate: 'Celebrating!',
        sleep: 'Going to sleep…',
        wake: 'I am awake!',
        singing: '♪ Singing ♪',
    };

    const handleGesture = gesture => {
        if (!gesture) return;

        stopSpeaking();

        setExpression(
            gesture,
            gestureLabels[gesture]
                || 'Having fun!'
        );

        /*
         * Restart animation so repeated commands
         * also visibly trigger the gesture.
         */

        if (stage) {
            stage.classList.remove(
                'smart-ai__gesture-trigger'
            );

            void stage.offsetWidth;

            stage.classList.add(
                'smart-ai__gesture-trigger'
            );

            setTimeout(() => {
                stage.classList.remove(
                    'smart-ai__gesture-trigger'
                );
            }, 2500);
        }
    };

    /*
    |--------------------------------------------------------------------------
    | AI Actions
    |--------------------------------------------------------------------------
    */

    const handleAction = async action => {
        if (!action?.type) {
            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | Navigation
        |--------------------------------------------------------------------------
        */

        if (action.type === 'navigate') {
            const destination =
                action.destination;

            window.location.assign(
                urls[destination]
                    || urls.products
            );

            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if (action.type === 'search') {
            const url =
                new URL(
                    urls.products,
                    window.location.origin
                );

            url.searchParams.set(
                'search',
                action.query || ''
            );

            window.location.assign(url);

            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | Theme
        |--------------------------------------------------------------------------
        */

        if (action.type === 'theme') {
            const theme = action.theme;

            try {
                window.SmartBasketTheme
                    ?.set?.(theme);
            } catch (_) {}

            document.documentElement
                .setAttribute(
                    'data-theme',
                    theme
                );

            localStorage.setItem(
                'sb-theme',
                theme
            );

            window.dispatchEvent(
                new CustomEvent(
                    'sb-theme-changed',
                    {
                        detail: {
                            theme,
                        },
                    }
                )
            );

            return 'Theme updated.';
        }

        /*
        |--------------------------------------------------------------------------
        | Product
        |--------------------------------------------------------------------------
        */

        if (action.type === 'open_product') {
            window.location.assign(
                `${root.dataset.productUrl}/${action.product_id}`
            );

            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | Recommendations
        |--------------------------------------------------------------------------
        */

        if (
            action.type ===
            'recommendations'
        ) {
            return recommendationButtons(
                action.products || []
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Robot Gesture
        |--------------------------------------------------------------------------
        */

        if (action.type === 'gesture') {
            handleGesture(
                action.gesture
            );

            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | Add / Remove Cart
        |--------------------------------------------------------------------------
        */

        try {
            if (
                action.type ===
                'add_to_cart'
            ) {
                await mutateCart(
                    `${root.dataset.cartAddUrl}/${action.product_id}`,
                    'POST'
                );

                return 'Added to your cart.';
            }

            if (
                action.type ===
                'remove_cart_item'
            ) {
                await mutateCart(
                    `${root.dataset.cartRemoveUrl}/${action.cart_item_id}`,
                    'DELETE'
                );

                return 'Removed from your cart.';
            }

            if (
                action.type ===
                'update_cart_quantity'
            ) {
                return 'Cart quantity updated.';
            }

        } catch (_) {
            return 'I could not update your cart just now. Please try again from the cart page.';
        }

        return null;
    };

    /*
    |--------------------------------------------------------------------------
    | Send Message
    |--------------------------------------------------------------------------
    */

    const send = async rawMessage => {
        const message =
            String(rawMessage || '').trim();

        if (!message) return;

        stopSpeaking();

        addMessage(
            message,
            'user'
        );

        input.value = '';

        setExpression(
            'thinking',
            'Thinking…'
        );

        const loading = typing();

        try {
            const response =
                await fetch(
                    endpoint,
                    {
                        method: 'POST',

                        credentials:
                            'same-origin',

                        headers: {
                            'Content-Type':
                                'application/json',

                            Accept:
                                'application/json',

                            'X-CSRF-TOKEN':
                                csrf,

                            'X-Requested-With':
                                'XMLHttpRequest',
                        },

                        body:
                            JSON.stringify({
                                message,

                                context: {
                                    selected_product_id:
                                        selectedProductId,

                                    visible_product_ids:
                                        visibleProductIds(),
                                },
                            }),
                    }
                );

            if (!response.ok) {
                throw new Error(
                    `Assistant HTTP ${response.status}`
                );
            }

            const data =
                await response.json();

            loading.remove();

            /*
            |--------------------------------------------------------------------------
            | Handle backend error
            |--------------------------------------------------------------------------
            */

            if (data.error) {
                setExpression(
                    'sad',
                    'Temporarily unavailable'
                );

                addMessage(
                    data.reply
                        || 'Smart AI is temporarily unavailable.',
                    'ai'
                );

                return;
            }

            /*
            |--------------------------------------------------------------------------
            | Expression
            |--------------------------------------------------------------------------
            */

            setExpression(
                data.expression
                    || 'normal'
            );

            /*
            |--------------------------------------------------------------------------
            | Actions
            |--------------------------------------------------------------------------
            */

            const actions =
                Array.isArray(data.actions)
                    ? data.actions
                    : (
                        data.action
                            ? [data.action]
                            : []
                    );

            let extra = null;

            for (
                const action of actions
            ) {
                const actionResult =
                    await handleAction(
                        action
                    );

                if (
                    action?.type ===
                    'recommendations'
                ) {
                    extra =
                        actionResult;
                }
            }

            /*
            |--------------------------------------------------------------------------
            | AI Reply
            |--------------------------------------------------------------------------
            */

            const reply =
                String(
                    data.reply
                        || 'Smart AI did not return a reply. Please try again.'
                );

            addMessage(
                reply,
                'ai',
                extra
            );

            /*
            |--------------------------------------------------------------------------
            | Voice
            |--------------------------------------------------------------------------
            |
            | Always speak the complete AI response
            | unless robot is intentionally sleeping.
            |
            */

            const hasSleep =
                actions.some(
                    action =>
                        action?.type ===
                        'gesture' &&
                        action?.gesture ===
                        'sleep'
                );

            if (!hasSleep) {
                speak(reply);
            }

        } catch (error) {
            console.error(
                'Smart AI error:',
                error
            );

            loading.remove();

            setExpression(
                'sad',
                'Temporarily unavailable'
            );

            addMessage(
                'Smart AI is temporarily unavailable. You can still browse Smart Basket normally.',
                'ai'
            );
        }
    };

    /*
    |--------------------------------------------------------------------------
    | Open / Close
    |--------------------------------------------------------------------------
    */

    if (openButton) {
        openButton.addEventListener(
            'click',
            () => {
                panel.hidden = false;

                setExpression(
                    'happy',
                    'Ready to help'
                );

                setTimeout(
                    () => input?.focus(),
                    80
                );
            }
        );
    }

    if (closeButton) {
        closeButton.addEventListener(
            'click',
            () => {
                panel.hidden = true;

                stopSpeaking();
            }
        );
    }

    if (minimizeButton) {
        minimizeButton.addEventListener(
            'click',
            () => {
                panel.hidden = true;

                stopSpeaking();
            }
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Form
    |--------------------------------------------------------------------------
    */

    if (form) {
        form.addEventListener(
            'submit',
            event => {
                event.preventDefault();

                send(input.value);
            }
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Product Context
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll(
            '[data-smart-ai-product-id]'
        )
        .forEach(card => {

            card.addEventListener(
                'mouseenter',
                () => {
                    selectedProductId =
                        Number(
                            card.dataset
                                .smartAiProductId
                        );
                }
            );

            card.addEventListener(
                'focusin',
                () => {
                    selectedProductId =
                        Number(
                            card.dataset
                                .smartAiProductId
                        );
                }
            );
        });

    /*
    |--------------------------------------------------------------------------
    | Voice Recognition
    |--------------------------------------------------------------------------
    */

    const SpeechRecognition =
        window.SpeechRecognition
        || window.webkitSpeechRecognition;

    if (
        !SpeechRecognition
        || !mic
    ) {
        if (mic) {
            mic.disabled = true;

            mic.title =
                'Voice input is not supported by this browser';
        }
    } else {

        recognition =
            new SpeechRecognition();

        /*
        |--------------------------------------------------------------------------
        | Use multiple languages intelligently
        |--------------------------------------------------------------------------
        |
        | Browser recognition can automatically understand
        | many languages, but one recognition language must
        | be selected at a time.
        |
        | Default: Indian English.
        |
        */

        recognition.lang =
            localStorage.getItem(
                'smart-ai-recognition-language'
            )
            || 'en-IN';

        recognition.interimResults =
            false;

        recognition.continuous =
            false;

        recognition.maxAlternatives =
            3;

        recognition.onstart = () => {
            mic.classList.add(
                'is-listening'
            );

            setExpression(
                'listening',
                'Listening…'
            );
        };

        recognition.onend = () => {
            mic.classList.remove(
                'is-listening'
            );

            if (
                stage.dataset.expression ===
                'listening'
            ) {
                setExpression(
                    'normal',
                    'Ready to help'
                );
            }
        };

        recognition.onerror = event => {
            console.warn(
                'Speech recognition error:',
                event.error
            );

            mic.classList.remove(
                'is-listening'
            );

            setExpression(
                'sad',
                'Voice input unavailable'
            );

            if (
                event.error ===
                'not-allowed'
            ) {
                addMessage(
                    'Microphone permission is blocked. Please allow microphone access in your browser.',
                    'ai'
                );
            }
        };

        recognition.onresult = event => {
            const result =
                event.results?.[0]?.[0];

            if (!result) return;

            const words =
                result.transcript
                    ?.trim();

            if (!words) return;

            /*
            |--------------------------------------------------------------------------
            | Detect language from spoken transcript
            |--------------------------------------------------------------------------
            */

            const detected =
                detectLanguage(words);

            localStorage.setItem(
                'smart-ai-recognition-language',
                detected
            );

            input.value = words;

            send(words);
        };

        mic.addEventListener(
            'click',
            () => {
                stopSpeaking();

                try {
                    recognition.start();
                } catch (_) {
                    /*
                     * Recognition may already be running.
                     */
                }
            }
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Keyboard Escape
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'keydown',
        event => {
            if (
                event.key ===
                'Escape'
            ) {
                stopSpeaking();

                if (panel) {
                    panel.hidden = true;
                }
            }
        }
    );

    /*
    |--------------------------------------------------------------------------
    | Public API
    |--------------------------------------------------------------------------
    |
    | Other Smart Basket scripts can directly control
    | the robot.
    |
    */

    window.SmartBasketAI = {
        speak,
        stopSpeaking,
        setExpression,
        gesture: handleGesture,
        send,
        detectLanguage,
    };

    /*
    |--------------------------------------------------------------------------
    | Initial State
    |--------------------------------------------------------------------------
    */

    setExpression(
        'normal',
        'Ready to help'
    );

})();