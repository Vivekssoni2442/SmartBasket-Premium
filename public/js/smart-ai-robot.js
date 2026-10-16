(() => {
'use strict';

/*
|--------------------------------------------------------------------------
| SMART BASKET - SMART AI ROBOT
|--------------------------------------------------------------------------
| Features:
| - Text chat
| - Voice input
| - Voice output
| - Language detection
| - Multiple languages
| - Robot expressions
| - Dance / cry / laugh / wave / sleep / wake / sing / celebrate
| - Product context
| - Cart actions
| - Navigation
| - Search
| - Theme control
| - Backend AI actions
| - Conversation history
|--------------------------------------------------------------------------
*/

if (window.__smartBasketRobotLoaded) {
    return;
}

window.__smartBasketRobotLoaded = true;

const root = document.querySelector('[data-smart-ai]');

if (!root) {
    console.warn('Smart AI root not found.');
    return;
}

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
const maximizeButton = $('[data-smart-ai-maximize]');
const settingsButton = $('[data-smart-ai-settings]');
const settingsPanel = $('[data-smart-ai-voice-settings]');
const closeSettingsButton = $('[data-smart-ai-close-settings]');
const languageSelect = $('[data-smart-ai-language]');
const voiceSelect = $('[data-smart-ai-voice]');
const autoSpeakToggle = $('[data-smart-ai-auto-speak]');
const rateControl = $('[data-smart-ai-rate]');
const volumeControl = $('[data-smart-ai-volume]');
const clearConversationButton = $('[data-smart-ai-clear]');
const voiceEnabledToggle = $('[data-smart-ai-voice-enabled]');
const voiceInputToggle = $('[data-smart-ai-voice-input]');
const testVoiceButton = $('[data-smart-ai-test-voice]');
const themeSelect = $('[data-smart-ai-theme]');
const popupSizeSelect = $('[data-smart-ai-popup-size]');
const animationsToggle = $('[data-smart-ai-animations]');
const statusIndicatorsToggle = $('[data-smart-ai-status-indicators]');
const speakingStatus = $('[data-smart-ai-speaking-status]');
const liveSettingsStatus = $('[data-smart-ai-live-settings-status]');
const micPermissionStatus = $('[data-smart-ai-mic-permission]');
const searchSettingsStatus = $('[data-smart-ai-search-status]');
const voiceInputButtons = root.querySelectorAll('[data-smart-ai-mic]');
const clearHistoryEndpoint = root.dataset.clearUrl || '';
const liveOpenButton = $('[data-smart-ai-live-open]');
const liveOverlay = $('[data-smart-ai-live-overlay]');
const liveWelcome = $('[data-smart-ai-live-welcome]');
const liveStartButton = $('[data-smart-ai-live-start]');
const liveTextButton = $('[data-smart-ai-live-text]');
const liveDismissButton = $('[data-smart-ai-live-dismiss]');
const livePermissionNote = $('[data-smart-ai-permission-note]');
const liveStatus = $('[data-smart-ai-live-status]');
const liveStateLabel = $('[data-smart-ai-live-state-label]');
const liveOrb = $('[data-smart-ai-live-orb]');
const liveMicButton = $('[data-smart-ai-live-mic]');
const liveTranscript = $('[data-smart-ai-live-transcript]');
const liveMuteButton = $('[data-smart-ai-live-mute]');
const liveStopButton = $('[data-smart-ai-live-stop]');
const liveStorageKey = `smart-ai-live-active:${root.dataset.liveStorageKey || 'guest'}`;
const historyEndpoint = root.dataset.historyUrl || '';

const endpoint = root.dataset.endpoint || '';
const csrf = root.dataset.csrf || '';

let selectedProductId = null;
let recognition = null;
let recognitionRunning = false;
let liveListeningRequested = false;
let liveSessionActive = false;
let liveProcessing = false;
let liveMuted = false;
let recognitionStarting = false;
let liveCloseAfterStop = false;
let lastVoiceTranscript = '';
let lastVoiceTranscriptAt = 0;
let liveModeActive = localStorage.getItem(liveStorageKey) === 'true';
let voiceInputEnabled = localStorage.getItem('smart-ai-voice-input-enabled') !== 'false';
const spokenResponseIds = new Set();

/*
|--------------------------------------------------------------------------
| Conversation
|--------------------------------------------------------------------------
*/

const conversation = [];

const MAX_HISTORY = 30;

/*
|--------------------------------------------------------------------------
| URLs
|--------------------------------------------------------------------------
*/

const urls = {
    home: root.dataset.homeUrl || '/',
    products: root.dataset.productsUrl || '/',
    cart: root.dataset.cartUrl || '/',
    checkout: root.dataset.checkoutUrl || '/',
    orders: root.dataset.ordersUrl || '/',
    wishlist: root.dataset.wishlistUrl || '/',
    profile: root.dataset.profileUrl || '/',
    addresses: root.dataset.addressesUrl || '/',
    settings: root.dataset.settingsUrl || '/',
    login: root.dataset.loginUrl || '/',
};

/*
|--------------------------------------------------------------------------
| Voice
|--------------------------------------------------------------------------
*/

const speech = {
    voices: [],
    currentUtterance: null,
    speaking: false,
    preferredLanguage:
        localStorage.getItem('smart-ai-language') || null,
    enabled:
        localStorage.getItem('smart-ai-voice-enabled') !== 'false',
    autoSpeak:
        localStorage.getItem('smart-ai-auto-speak') !== 'false',
    voiceName:
        localStorage.getItem('smart-ai-voice-name') || 'default',
    rate:
        Number(localStorage.getItem('smart-ai-voice-rate')) || 0.98,
    pitch:
        Number(localStorage.getItem('smart-ai-voice-pitch')) || 1.02,
    volume:
        localStorage.getItem('smart-ai-voice-volume') === null ? 1 : Math.min(1, Math.max(0, Number(localStorage.getItem('smart-ai-voice-volume')) || 0)),
};

/*
|--------------------------------------------------------------------------
| Language Map
|--------------------------------------------------------------------------
*/

const LANGUAGE_MAP = {
    hindi: 'hi-IN',
    hinglish: 'hi-IN',
    hi: 'hi-IN',
    'hi-in': 'hi-IN',

    gujarati: 'gu-IN',
    gu: 'gu-IN',
    'gu-in': 'gu-IN',

    english: 'en-IN',
    en: 'en-IN',
    'en-in': 'en-IN',

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

/*
|--------------------------------------------------------------------------
| Voice Loading
|--------------------------------------------------------------------------
*/

const refreshVoices = () => {
    if (!('speechSynthesis' in window) || typeof window.SpeechSynthesisUtterance !== 'function') {
        return;
    }

    const voices = window.speechSynthesis.getVoices();

    if (Array.isArray(voices)) {
        speech.voices = voices;
    }

    if (voiceSelect) {
        const selected = speech.voiceName;
        voiceSelect.replaceChildren(new Option('Best available', 'default'));
        speech.voices.forEach(voice => {
            voiceSelect.add(new Option(`${voice.name} (${voice.lang})`, voice.name));
        });
        voiceSelect.value = speech.voices.some(voice => voice.name === selected)
            ? selected
            : 'default';
    }
};

if ('speechSynthesis' in window) {
    refreshVoices();

    window.speechSynthesis.onvoiceschanged = refreshVoices;

    setTimeout(refreshVoices, 100);
    setTimeout(refreshVoices, 500);
    setTimeout(refreshVoices, 1500);
    setTimeout(refreshVoices, 3000);
}

/*
|--------------------------------------------------------------------------
| Normalize Language
|--------------------------------------------------------------------------
*/

const normalizeLanguage = language => {
    if (!language) {
        return 'en-IN';
    }

    const key = String(language)
        .trim()
        .toLowerCase();

    return LANGUAGE_MAP[key] || language;
};

/*
|--------------------------------------------------------------------------
| Detect Language
|--------------------------------------------------------------------------
*/

const detectLanguage = text => {
    const value = String(text || '').trim();

    if (!value) {
        return 'en-IN';
    }

    if (/[\u0A80-\u0AFF]/.test(value)) {
        return 'gu-IN';
    }

    if (/[\u0900-\u097F]/.test(value)) {
        return 'hi-IN';
    }

    if (/[\u0980-\u09FF]/.test(value)) {
        return 'bn-IN';
    }

    if (/[\u0A00-\u0A7F]/.test(value)) {
        return 'pa-IN';
    }

    if (/[\u0B80-\u0BFF]/.test(value)) {
        return 'ta-IN';
    }

    if (/[\u0C00-\u0C7F]/.test(value)) {
        return 'te-IN';
    }

    if (/[\u0C80-\u0CFF]/.test(value)) {
        return 'kn-IN';
    }

    if (/[\u0D00-\u0D7F]/.test(value)) {
        return 'ml-IN';
    }

    if (/[\u0600-\u06FF]/.test(value)) {
        return 'ur-IN';
    }

    if (/[\u3040-\u30FF]/.test(value)) {
        return 'ja-JP';
    }

    if (/[\uAC00-\uD7AF]/.test(value)) {
        return 'ko-KR';
    }

    if (/[\u4E00-\u9FFF]/.test(value)) {
        return 'zh-CN';
    }

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
        'aapko',
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
        'ro',
        'rona',
        'hanso',
        'hasi',
        'haso',
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

    if (
        hindiWords.some(word =>
            new RegExp(`\\b${word}\\b`, 'i').test(lower)
        )
    ) {
        return 'hi-IN';
    }

    return 'en-IN';
};

/*
|--------------------------------------------------------------------------
| Find Voice
|--------------------------------------------------------------------------
*/

const findBestVoice = language => {
    refreshVoices();

    if (!speech.voices.length) {
        return null;
    }

    if (speech.voiceName !== 'default') {
        const preferred = speech.voices.find(voice => voice.name === speech.voiceName);
        if (preferred) return preferred;
    }

    const target = normalizeLanguage(language).toLowerCase();

    const ranked = speech.voices
        .map(voice => {
            const voiceLang =
                String(voice.lang || '').toLowerCase();

            let score = 0;

            if (voiceLang === target) {
                score = 100;
            } else if (
                voiceLang.split('-')[0] ===
                target.split('-')[0]
            ) {
                score = 80;
            } else if (
                target === 'en-in' &&
                ['en-us', 'en-gb', 'en-au', 'en-ca'].includes(
                    voiceLang
                )
            ) {
                score = 50;
            }

            return {
                voice,
                score,
            };
        })
        .filter(item => item.score > 0)
        .sort((a, b) => b.score - a.score);

    return ranked[0]?.voice || speech.voices[0];
};

/*
|--------------------------------------------------------------------------
| Clean Text
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
| Stop Speaking
|--------------------------------------------------------------------------
*/

const stopSpeaking = () => {
    if (!('speechSynthesis' in window) || typeof window.SpeechSynthesisUtterance !== 'function') {
        return;
    }

    const wasSpeaking = speech.speaking;
    try {
        window.speechSynthesis.cancel();
    } catch (_) {}

    speech.currentUtterance = null;
    speech.speaking = false;
    if (speakingStatus) speakingStatus.hidden = true;
    if (wasSpeaking) root.dispatchEvent(new CustomEvent('smart-ai:speech-state', { detail: { state: 'stopped' } }));
};

/*
|--------------------------------------------------------------------------
| Speak
|--------------------------------------------------------------------------
*/

const speak = (text, options = {}) => {
    const cleanText = cleanSpeechText(text);

    if (!cleanText) {
        return false;
    }

    if (!speech.enabled && !options.force) {
        return false;
    }

    if (!('speechSynthesis' in window)) {
        if (speakingStatus) {
            speakingStatus.hidden = false;
            speakingStatus.querySelector('span').textContent = 'Speech playback is not supported by this browser.';
        }
        return false;
    }

    if (options.responseId && spokenResponseIds.has(String(options.responseId))) return false;
    if (options.responseId) {
        spokenResponseIds.add(String(options.responseId));
        if (spokenResponseIds.size > 100) spokenResponseIds.delete(spokenResponseIds.values().next().value);
    }

    stopSpeaking();
    refreshVoices();

    const language = detectLanguage(cleanText);

    speech.preferredLanguage = language;

    localStorage.setItem(
        'smart-ai-language',
        language
    );

    const utterance =
        new SpeechSynthesisUtterance(cleanText);
    const playbackId = options.responseId ? String(options.responseId) : `speech-${Date.now()}-${Math.random()}`;

    utterance.lang = language;

    const voice = findBestVoice(language);

    if (voice) {
        utterance.voice = voice;
    }

    utterance.rate = speech.rate;
    utterance.pitch = speech.pitch;
    utterance.volume = speech.volume;

    speech.currentUtterance = utterance;

    utterance.onstart = () => {
        if (speech.currentUtterance !== utterance) return;
        speech.speaking = true;
        if (speakingStatus) speakingStatus.hidden = false;

        setExpression(
            'speaking',
            'Speaking…'
        );
        root.dispatchEvent(new CustomEvent('smart-ai:speech-state', { detail: { state: 'speaking' } }));
    };

    utterance.onend = () => {
        if (speech.currentUtterance !== utterance) return;
        speech.speaking = false;
        speech.currentUtterance = null;
        if (speakingStatus) speakingStatus.hidden = true;

        if (
            stage &&
            stage.dataset.expression === 'speaking'
        ) {
            setExpression(
                'happy',
                'Ready to help'
            );
        }
        root.dispatchEvent(new CustomEvent('smart-ai:speech-state', { detail: { state: 'ended' } }));
    };

    utterance.onerror = () => {
        if (speech.currentUtterance !== utterance) return;
        speech.speaking = false;
        speech.currentUtterance = null;
        if (speakingStatus) {
            speakingStatus.hidden = false;
            const label = speakingStatus.querySelector('span');
            if (label) label.textContent = 'Speech did not start. Check browser audio permissions or use the Test voice control.';
        }

        if (
            stage &&
            stage.dataset.expression === 'speaking'
        ) {
            setExpression(
                'happy',
                'Ready to help'
            );
        }
        root.dispatchEvent(new CustomEvent('smart-ai:speech-state', { detail: { state: 'ended' } }));
    };

    utterance.onstart = ((onstart) => function (...args) {
        onstart.apply(this, args);
        root.dataset.speechPlaybackId = playbackId;
    })(utterance.onstart);

    try {
        window.speechSynthesis.speak(utterance);
        return true;
    } catch (error) {
        console.warn(
            'Smart AI voice error:',
            error
        );
        root.dispatchEvent(new CustomEvent('smart-ai:speech-state', { detail: { state: 'ended' } }));
        return false;
    }
};

const refreshSettingsControls = () => {
    if (autoSpeakToggle) autoSpeakToggle.checked = speech.autoSpeak;
    if (voiceEnabledToggle) voiceEnabledToggle.checked = speech.enabled;
    if (voiceInputToggle) voiceInputToggle.checked = voiceInputEnabled;
    if (rateControl) rateControl.value = String(speech.rate);
    if (volumeControl) volumeControl.value = String(speech.volume);
    if (languageSelect) languageSelect.value = speech.preferredLanguage || 'auto';
    if (animationsToggle) animationsToggle.checked = localStorage.getItem('smart-ai-animations') !== 'false';
    if (statusIndicatorsToggle) statusIndicatorsToggle.checked = localStorage.getItem('smart-ai-status-indicators') !== 'false';
    root.dataset.animations = localStorage.getItem('smart-ai-animations') === 'false' ? 'false' : 'true';
    root.dataset.statusIndicators = localStorage.getItem('smart-ai-status-indicators') === 'false' ? 'false' : 'true';
    voiceInputButtons.forEach(button => { button.disabled = !voiceInputEnabled || !(window.SpeechRecognition || window.webkitSpeechRecognition); });
    if (themeSelect) themeSelect.value = localStorage.getItem('sb-theme') || 'system';
    if (popupSizeSelect) popupSizeSelect.value = panel?.dataset.expanded === 'true' ? 'expanded' : 'normal';
    if (searchSettingsStatus) {
        const configured = root.dataset.searchStatus === 'configured';
        const provider = root.dataset.searchProvider || 'configured provider';
        searchSettingsStatus.textContent = configured
            ? `Web search is configured (${provider}). Availability still depends on the server provider and network.`
            : 'Web search is not configured. Ask the site administrator to configure the server-side provider.';
    }
};

refreshSettingsControls();

settingsButton?.addEventListener('click', () => {
    if (!settingsPanel) return;
    settingsPanel.hidden = !settingsPanel.hidden;
    settingsButton.setAttribute('aria-expanded', settingsPanel.hidden ? 'false' : 'true');
    if (!settingsPanel.hidden) refreshSettingsControls();
});

closeSettingsButton?.addEventListener('click', () => {
    if (settingsPanel) settingsPanel.hidden = true;
    settingsButton?.setAttribute('aria-expanded', 'false');
    settingsButton?.focus();
});

autoSpeakToggle?.addEventListener('change', () => {
    speech.autoSpeak = autoSpeakToggle.checked;
    localStorage.setItem('smart-ai-auto-speak', speech.autoSpeak ? 'true' : 'false');
});

voiceEnabledToggle?.addEventListener('change', () => {
    speech.enabled = voiceEnabledToggle.checked;
    localStorage.setItem('smart-ai-voice-enabled', speech.enabled ? 'true' : 'false');
    if (!speech.enabled) stopSpeaking();
});

voiceInputToggle?.addEventListener('change', () => {
    voiceInputEnabled = voiceInputToggle.checked;
    localStorage.setItem('smart-ai-voice-input-enabled', voiceInputEnabled ? 'true' : 'false');
    voiceInputButtons.forEach(button => { button.disabled = !voiceInputEnabled || !(window.SpeechRecognition || window.webkitSpeechRecognition); });
    if (!voiceInputEnabled && recognitionRunning) {
        liveListeningRequested = false;
        try { recognition?.abort(); } catch (_) { try { recognition?.stop(); } catch (_) {} }
    }
    if (!voiceInputEnabled && liveSessionActive) setLiveState('stopped', 'Voice input is off in Settings. Spoken responses remain available.');
});

rateControl?.addEventListener('input', () => {
    speech.rate = Math.min(1.3, Math.max(0.7, Number(rateControl.value) || 0.98));
    localStorage.setItem('smart-ai-voice-rate', String(speech.rate));
});

volumeControl?.addEventListener('input', () => {
    speech.volume = Math.min(1, Math.max(0, Number(volumeControl.value)));
    localStorage.setItem('smart-ai-voice-volume', String(speech.volume));
});

languageSelect?.addEventListener('change', () => {
    const language = languageSelect.value === 'auto' ? null : normalizeLanguage(languageSelect.value);
    speech.preferredLanguage = language;
    if (language) {
        localStorage.setItem('smart-ai-language', language);
        localStorage.setItem('smart-ai-recognition-language', language);
        if (recognition) recognition.lang = language;
    } else {
        localStorage.removeItem('smart-ai-language');
    }
});

voiceSelect?.addEventListener('change', () => {
    speech.voiceName = voiceSelect.value || 'default';
    localStorage.setItem('smart-ai-voice-name', speech.voiceName);
});

testVoiceButton?.addEventListener('click', () => {
    if (!speech.enabled) {
        if (micPermissionStatus) micPermissionStatus.textContent = 'Turn on Voice output to test speech.';
        return;
    }
    speak('Hello, this is a test of Smart AI voice responses.', { force: true, responseId: `voice-test-${Date.now()}` });
});

root.querySelectorAll('[data-smart-ai-stop-speaking]').forEach(button => button.addEventListener('click', stopSpeaking));

animationsToggle?.addEventListener('change', () => {
    localStorage.setItem('smart-ai-animations', animationsToggle.checked ? 'true' : 'false');
    root.dataset.animations = animationsToggle.checked ? 'true' : 'false';
});

statusIndicatorsToggle?.addEventListener('change', () => {
    localStorage.setItem('smart-ai-status-indicators', statusIndicatorsToggle.checked ? 'true' : 'false');
    root.dataset.statusIndicators = statusIndicatorsToggle.checked ? 'true' : 'false';
});

const setExpanded = expanded => {
    if (!panel) return;
    panel.dataset.expanded = expanded ? 'true' : 'false';
    localStorage.setItem('smart-ai-popup-size', expanded ? 'expanded' : 'normal');
    if (maximizeButton) {
        maximizeButton.setAttribute('aria-pressed', expanded ? 'true' : 'false');
        maximizeButton.setAttribute('aria-label', expanded ? 'Restore assistant size' : 'Expand assistant');
        maximizeButton.title = expanded ? 'Restore size' : 'Expand assistant';
        maximizeButton.innerHTML = expanded
            ? '<i class="fa-solid fa-down-left-and-up-right-to-center" aria-hidden="true"></i>'
            : '<i class="fa-solid fa-up-right-and-down-left-from-center" aria-hidden="true"></i>';
    }
    if (popupSizeSelect) popupSizeSelect.value = expanded ? 'expanded' : 'normal';
};

popupSizeSelect?.addEventListener('change', () => setExpanded(popupSizeSelect.value === 'expanded'));

themeSelect?.addEventListener('change', () => {
    const selected = themeSelect.value;
    const theme = selected === 'system'
        ? (window.matchMedia?.('(prefers-color-scheme: dark)').matches ? 'dark' : 'light')
        : selected;
    try { window.SmartBasketTheme?.set?.(selected); } catch (_) {}
    document.documentElement.setAttribute('data-theme', theme);
    document.documentElement.setAttribute('data-sb-theme', theme);
    if (selected === 'system') localStorage.removeItem('sb-theme');
    else localStorage.setItem('sb-theme', selected);
    window.dispatchEvent(new CustomEvent('sb-theme-changed', { detail: { theme: selected } }));
});

const updateMicPermissionStatus = async () => {
    if (!micPermissionStatus) return;
    if (!navigator.permissions?.query) {
        micPermissionStatus.textContent = 'Microphone permission is managed by your browser and requested only when voice input starts.';
        return;
    }
    try {
        const permission = await navigator.permissions.query({ name: 'microphone' });
        const describe = () => {
            micPermissionStatus.textContent = permission.state === 'granted'
                ? 'Microphone permission is granted. Voice input starts only when you choose it.'
                : permission.state === 'denied'
                    ? 'Microphone permission is blocked. You can still chat by text and hear spoken replies.'
                    : 'Microphone permission has not been granted. Your browser asks only when you start voice input.';
        };
        describe();
        permission.addEventListener?.('change', describe);
    } catch (_) {
        micPermissionStatus.textContent = 'Microphone permission is managed by your browser and requested only when voice input starts.';
    }
};
updateMicPermissionStatus();

if (panel && localStorage.getItem('smart-ai-popup-size') === 'expanded') {
    panel.dataset.expanded = 'true';
    if (maximizeButton) {
        maximizeButton.setAttribute('aria-pressed', 'true');
        maximizeButton.setAttribute('aria-label', 'Restore assistant size');
        maximizeButton.title = 'Restore size';
        maximizeButton.innerHTML = '<i class="fa-solid fa-down-left-and-up-right-to-center" aria-hidden="true"></i>';
    }
}

/*
|--------------------------------------------------------------------------
| Robot Expression
|--------------------------------------------------------------------------
*/

const expressionMessages = {
    normal: 'How can I help you?',
    happy: 'Happy to help!',
    thinking: 'Let me think about that…',
    listening: 'I am listening…',
    speaking: 'Smart AI is speaking…',

    dance: 'Beep boop! Dance mode activated! 💃',
    cry: 'Oh no… 😢',
    sad: 'I am still here to help.',
    laugh: 'Ha ha ha! 😂',
    laughing: 'Ha ha ha! 😂',

    wave: 'Hello there! 👋',
    smile: '😊',
    jump: 'Wheee! 🚀',

    celebrate: 'Fantastic! 🎉',
    sleep: 'Zzz… 😴',
    wake: 'I am awake!',

    sing: '♪ La la la… ♪',
    singing: '♪ Singing for you ♪',

    excited: 'That sounds fun!',

    love: '❤️',
    angry: 'Grrr…',
    surprised: 'Wow! 😮',
};

const setExpression = (
    expression = 'normal',
    label = null
) => {
    if (!stage) {
        return;
    }

    stage.dataset.expression = expression;

    if (status) {
        status.textContent =
            label ||
            expressionMessages[expression] ||
            'Ready to help';
    }

    if (thought) {
        thought.textContent =
            expressionMessages[expression] ||
            'How can I help you shop?';
    }

    /*
    |--------------------------------------------------------------------------
    | Restart CSS animation
    |--------------------------------------------------------------------------
    */

    stage.classList.remove(
        'smart-ai__expression-trigger'
    );

    void stage.offsetWidth;

    stage.classList.add(
        'smart-ai__expression-trigger'
    );

    setTimeout(() => {
        stage.classList.remove(
            'smart-ai__expression-trigger'
        );
    }, 3000);
};

/*
|--------------------------------------------------------------------------
| Gesture
|--------------------------------------------------------------------------
*/

const handleGesture = gesture => {
    if (!gesture) {
        return;
    }

    const normalized = String(gesture)
        .toLowerCase()
        .trim();

    const allowed = [
        'dance',
        'cry',
        'sad',
        'laugh',
        'laughing',
        'wave',
        'smile',
        'jump',
        'celebrate',
        'sleep',
        'wake',
        'sing',
        'singing',
        'excited',
        'love',
        'angry',
        'surprised',
    ];

    const expression =
        allowed.includes(normalized)
            ? normalized
            : 'happy';

    stopSpeaking();

    setExpression(
        expression,
        expressionMessages[expression]
    );

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
        }, 3000);
    }

    /*
    |--------------------------------------------------------------------------
    | Automatically return to normal after temporary gesture.
    |--------------------------------------------------------------------------
    */

    if (
        !['sleep', 'sad'].includes(expression)
    ) {
        setTimeout(() => {
            if (
                stage &&
                stage.dataset.expression === expression
            ) {
                setExpression(
                    'happy',
                    'Ready to help'
                );
            }
        }, 3500);
    }
};

/*
|--------------------------------------------------------------------------
| Chat Scroll
|--------------------------------------------------------------------------
*/

const scrollChat = () => {
    if (!chat) {
        return;
    }

    chat.scrollTop = chat.scrollHeight;
};

/*
|--------------------------------------------------------------------------
| Add Message
|--------------------------------------------------------------------------
*/

const addMessage = (
    text,
    role = 'ai',
    extra = null
) => {
    if (!chat) {
        return null;
    }

    const message =
        document.createElement('article');

    message.className =
        `smart-ai__message smart-ai__message--${role}`;

    message.textContent = String(text || '');

    if (extra instanceof Node) {
        message.appendChild(extra);
    }

    chat.appendChild(message);

    scrollChat();

    conversation.push({
        role:
            role === 'user'
                ? 'user'
                : 'assistant',
        content: String(text || ''),
    });

    while (
        conversation.length > MAX_HISTORY
    ) {
        conversation.shift();
    }

    return message;
};

const conversationRestorePromise = (async () => {
    if (!historyEndpoint || !chat) return;
    try {
        const response = await fetch(historyEndpoint, {
            method: 'GET',
            credentials: 'same-origin',
            headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            cache: 'no-store',
        });
        if (!response.ok) return;
        const data = await response.json();
        const messages = Array.isArray(data.messages) ? data.messages.slice(-MAX_HISTORY) : [];
        if (!messages.length) return;
        $('[data-smart-ai-welcome]')?.remove();
        messages.forEach(item => {
            if (!item || !['user', 'assistant'].includes(item.role) || typeof item.content !== 'string') return;
            addMessage(item.content.slice(0, 2000), item.role === 'user' ? 'user' : 'ai');
        });
    } catch (_) {
        // Text chat remains usable when transcript restoration is unavailable.
    }
})();

/*
|--------------------------------------------------------------------------
| Typing Indicator
|--------------------------------------------------------------------------
*/

const typing = () => {
    if (!chat) {
        return {
            remove() {},
        };
    }

    const indicator =
        document.createElement('article');

    indicator.className =
        'smart-ai__message smart-ai__message--ai smart-ai__typing';

    indicator.innerHTML =
        '<i></i><i></i><i></i>';

    chat.appendChild(indicator);

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

const currentPageContext = () => {
    const segments = window.location.pathname.toLowerCase().split('/').filter(Boolean);
    const first = segments[0] || '';
    if (first === 'products') return segments.length > 1 && /^\d+$/.test(segments[1]) ? 'product' : 'products';
    if (first === 'product') return segments.length > 1 ? 'product' : 'products';
    if (first === 'cart' || first === 'checkout') return 'cart';
    if (first === 'orders') return 'orders';
    if (first === 'wishlist') return 'wishlist';
    if (first === 'profile') return 'profile';
    if (first === 'settings') return 'settings';
    if (first === 'ai-hub' || first === 'ai-camera-assistant' || first === 'budget-shopping' || first === 'virtual-try-on') return 'ai_hub';
    return 'other';
};

/*
|--------------------------------------------------------------------------
| Product Recommendations
|--------------------------------------------------------------------------
*/

const recommendationButtons = products => {
    const wrap =
        document.createElement('div');

    wrap.className =
        'smart-ai__recommendations';

    if (!Array.isArray(products)) {
        return wrap;
    }

    products.forEach(product => {
        if (!product || !product.id) {
            return;
        }

        const button =
            document.createElement('button');

        button.type = 'button';

        const price =
            Number(product.price || 0)
                .toLocaleString('en-IN');

        button.textContent =
            `${product.name || 'Product'} — ₹${price}`;

        button.addEventListener(
            'click',
            () => {
                const productUrl =
                    root.dataset.productUrl;

                if (!productUrl) {
                    return;
                }

                window.location.assign(
                    `${productUrl}/${product.id}`
                );
            }
        );

        wrap.appendChild(button);
    });

    return wrap;
};

const sourceLinks = (sources, checkedAt) => {
    const wrap = document.createElement('div');
    wrap.className = 'smart-ai__sources';

    if (!Array.isArray(sources) || sources.length === 0) {
        return wrap;
    }

    const heading = document.createElement('strong');
    heading.textContent = 'Live web sources';
    wrap.appendChild(heading);

    if (checkedAt) {
        const checked = document.createElement('small');
        const time = new Date(checkedAt);
        checked.textContent = Number.isNaN(time.valueOf())
            ? ''
            : `Checked ${time.toLocaleString()}`;
        wrap.appendChild(checked);
    }

    sources.slice(0, 5).forEach(source => {
        try {
            const url = new URL(source.url);
            if (!['http:', 'https:'].includes(url.protocol)) return;

            const link = document.createElement('a');
            link.href = url.href;
            link.target = '_blank';
            link.rel = 'noopener noreferrer';
            link.textContent = String(source.title || url.hostname).slice(0, 200);
            wrap.appendChild(link);

            const metadata = document.createElement('small');
            const details = [
                String(source.domain || url.hostname),
                source.published_date
                    ? 'Date estimate: ' + String(source.published_date).slice(0, 100)
                    : '',
            ].filter(Boolean);
            metadata.textContent = details.join(' · ');
            wrap.appendChild(metadata);
        } catch (_) {}
    });

    return wrap;
};

/*
|--------------------------------------------------------------------------
| Cart Request
|--------------------------------------------------------------------------
*/

const mutateCart = async (
    url,
    method = 'POST',
    body = null
) => {
    const options = {
        method,

        credentials:
            'same-origin',

        headers: {
            Accept:
                'application/json',

            'X-CSRF-TOKEN':
                csrf,

            'X-Requested-With':
                'XMLHttpRequest',
        },
    };

    if (body !== null) {
        options.headers['Content-Type'] =
            'application/json';

        options.body =
            JSON.stringify(body);
    }

    const response =
        await fetch(
            url,
            options
        );

    if (!response.ok) {
        throw new Error(
            `Cart request failed: ${response.status}`
        );
    }

    return response;
};

/*
|--------------------------------------------------------------------------
| Navigate
|--------------------------------------------------------------------------
*/

const navigateTo = destination => {
    if (destination === 'back' || destination === 'forward') {
        if (destination === 'back' && window.history.length > 1) {
            window.history.back();
            return true;
        }

        if (destination === 'forward') {
            window.history.forward();
            return true;
        }

        return false;
    }

    const url = urls[destination];

    if (!url) {
        return false;
    }

    window.location.assign(url);
    return true;
};

/*
|--------------------------------------------------------------------------
| Search
|--------------------------------------------------------------------------
*/

const performSearch = query => {
    if (!query) {
        return;
    }

    try {
        const url =
            new URL(
                urls.products,
                window.location.origin
            );

        url.searchParams.set(
            'search',
            query
        );

        window.location.assign(url.toString());
    } catch (_) {
        window.location.assign(
            urls.products
        );
    }
};

/*
|--------------------------------------------------------------------------
| Action Handler
|--------------------------------------------------------------------------
*/

const handleAction = async action => {
    if (!action || !action.type) {
        return null;
    }

    const type =
        String(action.type).toLowerCase();

    /*
    |--------------------------------------------------------------------------
    | Gesture
    |--------------------------------------------------------------------------
    */

    if (
        type === 'gesture' ||
        type === 'robot_gesture' ||
        type === 'expression'
    ) {
        handleGesture(
            action.gesture ||
            action.expression ||
            'happy'
        );

        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | Navigate
    |--------------------------------------------------------------------------
    */

    if (
        type === 'navigate' ||
        type === 'navigation'
    ) {
        navigateTo(
            action.destination || 'products'
        );

        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    */

    if (
        type === 'search' ||
        type === 'product_search'
    ) {
        performSearch(
            action.query ||
            action.search ||
            ''
        );

        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | Open Product
    |--------------------------------------------------------------------------
    */

    if (
        type === 'open_product' ||
        type === 'product'
    ) {
        const productUrl =
            root.dataset.productUrl;

        if (
            productUrl &&
            action.product_id
        ) {
            window.location.assign(
                `${productUrl}/${action.product_id}`
            );
        }

        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | Recommendations
    |--------------------------------------------------------------------------
    */

    if (
        type === 'recommendations' ||
        type === 'show_products'
    ) {
        return recommendationButtons(
            action.products || []
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Theme
    |--------------------------------------------------------------------------
    */

    if (type === 'theme') {
        const theme =
            action.theme || 'light';

        try {
            window.SmartBasketTheme?.set?.(
                theme
            );
        } catch (_) {}

        document.documentElement.setAttribute(
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
    | Voice On / Off
    |--------------------------------------------------------------------------
    */

    if (
        type === 'voice_on' ||
        type === 'enable_voice'
    ) {
        speech.enabled = true;

        localStorage.setItem(
            'smart-ai-voice-enabled',
            'true'
        );

        return 'Voice is now enabled.';
    }

    if (
        type === 'voice_off' ||
        type === 'disable_voice'
    ) {
        speech.enabled = false;

        stopSpeaking();

        localStorage.setItem(
            'smart-ai-voice-enabled',
            'false'
        );

        return 'Voice is now disabled.';
    }

    /*
    |--------------------------------------------------------------------------
    | Language
    |--------------------------------------------------------------------------
    */

    if (
        type === 'language' ||
        type === 'change_language'
    ) {
        const language =
            normalizeLanguage(
                action.language ||
                action.lang ||
                'en-IN'
            );

        speech.preferredLanguage =
            language;

        localStorage.setItem(
            'smart-ai-language',
            language
        );

        if (recognition) {
            recognition.lang =
                language;

            localStorage.setItem(
                'smart-ai-recognition-language',
                language
            );
        }

        return `Language changed to ${language}.`;
    }

    /*
    |--------------------------------------------------------------------------
    | Add To Cart
    |--------------------------------------------------------------------------
    */

    if (type === 'add_to_cart' || type === 'cart_add') {
        window.dispatchEvent(new CustomEvent('smart-ai-cart-updated', {
            detail: { action: 'add', productId: action.product_id || selectedProductId },
        }));
        return null;
    }

    if (type === 'remove_cart_item' || type === 'cart_remove') {
        window.dispatchEvent(new CustomEvent('smart-ai-cart-updated', {
            detail: { action: 'remove', itemId: action.cart_item_id || action.item_id },
        }));
        return null;
    }

    if (type === 'update_cart_quantity' || type === 'cart_quantity') {
        window.dispatchEvent(new CustomEvent('smart-ai-cart-updated', {
            detail: {
                action: 'quantity',
                itemId: action.cart_item_id || action.item_id,
                quantity: Number(action.quantity),
            },
        }));
        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | Open Cart
    |--------------------------------------------------------------------------
    */

    if (
        type === 'open_cart' ||
        type === 'cart'
    ) {
        navigateTo('cart');

        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | Checkout
    |--------------------------------------------------------------------------
    */

    if (
        type === 'checkout' ||
        type === 'open_checkout'
    ) {
        navigateTo('checkout');

        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | Orders
    |--------------------------------------------------------------------------
    */

    if (
        type === 'orders' ||
        type === 'open_orders'
    ) {
        navigateTo('orders');

        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | Settings
    |--------------------------------------------------------------------------
    */

    if (
        type === 'settings' ||
        type === 'open_settings'
    ) {
        navigateTo('settings');

        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | Login
    |--------------------------------------------------------------------------
    */

    if (
        type === 'login' ||
        type === 'open_login'
    ) {
        navigateTo('login');

        return null;
    }

    return null;
};

/*
|--------------------------------------------------------------------------
| Send Message
|--------------------------------------------------------------------------
*/

const send = async (rawMessage, options = {}) => {
    const message =
        String(rawMessage || '').trim();

    if (!message) {
        return;
    }

    const stopSpeechCommand = message
        .toLocaleLowerCase()
        .replace(/[^\p{L}\p{N}]+/gu, ' ')
        .trim();

    if (/^(please )?(stop speaking|stop talking|be quiet|mute)( please)?( and continue in text)?$/.test(stopSpeechCommand)) {
        await conversationRestorePromise;
        stopSpeaking();
        speech.autoSpeak = false;
        if (autoSpeakToggle) autoSpeakToggle.checked = false;
        localStorage.setItem('smart-ai-auto-speak', 'false');
        addMessage(message, 'user');
        const reply = 'Okay. I stopped speaking and will continue in text.';
        addMessage(reply, 'ai');
        setExpression('normal', 'Text mode');
        return { ok: true, reply, localCommand: true };
    }

    const requestId = window.crypto?.randomUUID?.() || `smart-ai-${Date.now()}-${Math.random().toString(36).slice(2)}`;

    await conversationRestorePromise;

    stopSpeaking();

    addMessage(
        message,
        'user'
    );

    if (input) {
        input.value = '';
    }

    setExpression(
        'thinking',
        'Thinking…'
    );

    const loading = typing();
    let requestController = null;
    let requestTimeout = null;

    try {
        if (!endpoint) {
            throw new Error(
                'Smart AI endpoint is missing.'
            );
        }

        requestController = new AbortController();
        requestTimeout = window.setTimeout(() => requestController.abort(), 30000);

        const response =
            await fetch(
                endpoint,
                {
                    method: 'POST',
                    signal: requestController.signal,

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
                                current_page: currentPageContext(),

                                selected_product_id:
                                    selectedProductId,

                                visible_product_ids:
                                    visibleProductIds(),

                                language:
                                    detectLanguage(
                                        message
                                    ),

                                conversation:
                                    conversation.slice(
                                        -MAX_HISTORY
                                    ),
                            },
                        }),
                }
            );

        if (response.redirected && new URL(response.url, window.location.href).pathname.replace(/\/$/, '') === new URL(urls.login, window.location.href).pathname.replace(/\/$/, '')) {
            const authError = new Error('Sign in is required to use Smart AI.');
            authError.code = 'authentication_required';
            throw authError;
        }

        if (response.status === 401) {
            const authError = new Error('Sign in is required to use Smart AI.');
            authError.code = 'authentication_required';
            throw authError;
        }

        if (!response.ok) {
            throw new Error(
                `Assistant HTTP ${response.status}`
            );
        }

        const data =
            await response.json();
        const responseId = String(data.response_id || data.id || requestId);
        window.clearTimeout(requestTimeout);
        requestTimeout = null;

        loading.remove();

        /*
        |--------------------------------------------------------------------------
        | Backend Error
        |--------------------------------------------------------------------------
        */

        if (data.error) {
            const errorReply =
                data.reply ||
                data.message ||
                'Smart AI is temporarily unavailable.';

            setExpression(
                'sad',
                'Something went wrong'
            );

            addMessage(
                errorReply,
                'ai'
            );

            if (!options.suppressSpeech && (speech.autoSpeak || options.speakResponse)) speak(errorReply, { responseId });

            return { ok: false, reply: errorReply, data };
        }

        /*
        |--------------------------------------------------------------------------
        | Expression
        |--------------------------------------------------------------------------
        */

        if (data.expression) {
            setExpression(
                data.expression,
                data.status || null
            );
        } else {
            setExpression(
                'happy',
                'Ready to help'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Actions
        |--------------------------------------------------------------------------
        */

        let actions = [];

        if (Array.isArray(data.actions)) {
            actions = data.actions;
        } else if (data.action) {
            actions = [data.action];
        }

        let extra = null;

        for (
            const action of actions
        ) {
            try {
                const result =
                    await handleAction(
                        action
                    );

                if (
                    action?.type ===
                        'recommendations' ||
                    action?.type ===
                        'show_products'
                ) {
                    extra = result;
                }
            } catch (actionError) {
                console.warn(
                    'Smart AI action error:',
                    actionError
                );
            }
        }

        const messageExtras = document.createElement('div');
        if (extra) messageExtras.appendChild(extra);
        if (Array.isArray(data.sources) && data.sources.length) {
            messageExtras.appendChild(sourceLinks(data.sources, data.source_checked_at));
        }
        extra = messageExtras.childElementCount ? messageExtras : null;

        /*
        |--------------------------------------------------------------------------
        | Reply
        |--------------------------------------------------------------------------
        */

        let reply =
            data.reply ||
            data.answer ||
            data.message ||
            '';

        reply = String(reply).trim();

        /*
        |--------------------------------------------------------------------------
        | Empty response fallback
        |--------------------------------------------------------------------------
        */

        if (!reply) {
            const emptyReply = 'Smart AI returned an empty reply. Please try again.';
            setExpression('sad', 'Empty AI response');
            addMessage(emptyReply, 'ai');
            return { ok: false, reply: emptyReply, data };
        }

        addMessage(
            reply,
            'ai',
            extra
        );

        /*
        |--------------------------------------------------------------------------
        | Speak
        |--------------------------------------------------------------------------
        */

        const sleeping =
            actions.some(action =>
                action?.type === 'gesture' &&
                String(
                    action?.gesture || ''
                ).toLowerCase() === 'sleep'
            );

        if (!options.suppressSpeech && !sleeping && (speech.autoSpeak || options.speakResponse)) {
            speak(reply, { responseId });
        }

        return { ok: true, reply, data };

    } catch (error) {
        window.clearTimeout(requestTimeout);
        console.error(
            'Smart AI error:',
            error
        );

        loading.remove();

        setExpression(
            'sad',
            'Connection problem'
        );

        const authRequired = error?.code === 'authentication_required';
        const fallback = authRequired
            ? 'Please sign in to use Smart AI shopping assistance.'
            : error?.name === 'AbortError'
                ? 'Smart AI took too long to respond. Please try again.'
                : 'Smart AI could not connect right now. Please try again in a moment.';

        addMessage(
            fallback,
            'ai'
        );

        if (!options.suppressSpeech && (speech.autoSpeak || options.speakResponse)) speak(fallback, { responseId: requestId });
        return { ok: false, reply: fallback, error, authRequired };
    }
};

/*
|--------------------------------------------------------------------------
| Open Robot
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Close
|--------------------------------------------------------------------------
*/

if (closeButton) {
    closeButton.addEventListener(
        'click',
        () => {
            if (panel) {
                panel.hidden = true;
            }

        }
    );
}

/*
|--------------------------------------------------------------------------
| Minimize
|--------------------------------------------------------------------------
*/

if (minimizeButton) {
    minimizeButton.addEventListener(
        'click',
        () => {
            if (panel) {
                panel.hidden = true;
            }

        }
    );
}

maximizeButton?.addEventListener('click', () => setExpanded(panel?.dataset.expanded !== 'true'));

clearConversationButton?.addEventListener('click', async () => {
    await conversationRestorePromise;
    clearConversationButton.disabled = true;
    try {
        const response = await fetch(clearHistoryEndpoint, {
            method: 'DELETE',
            credentials: 'same-origin',
            headers: { Accept: 'application/json', 'X-CSRF-TOKEN': csrf, 'X-Requested-With': 'XMLHttpRequest' },
            cache: 'no-store',
        });
        if (!response.ok || response.redirected) throw new Error(`History clear failed (${response.status}).`);
        conversation.splice(0, conversation.length);
        chat?.replaceChildren();
        liveTranscript?.replaceChildren();
        if (chat) {
            const welcome = document.createElement('div');
            welcome.className = 'smart-ai__welcome-message';
            const content = document.createElement('div');
            content.className = 'smart-ai__message-content';
            const title = document.createElement('strong');
            title.textContent = 'Smart AI';
            const message = document.createElement('p');
            message.textContent = 'Your conversation was cleared. How can I help?';
            content.append(title, message);
            welcome.appendChild(content);
            chat.appendChild(welcome);
        }
        setExpression('normal', 'Conversation cleared');
    } catch (_) {
        if (status) status.textContent = 'Could not clear conversation. Please try again.';
    } finally {
        clearConversationButton.disabled = false;
    }
});

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

            if (!input) {
                return;
            }

            send(input.value);
        }
    );
}

/*
|--------------------------------------------------------------------------
| Enter / Shift + Enter
|--------------------------------------------------------------------------
*/

if (input) {
    input.addEventListener(
        'keydown',
        event => {
            if (
                event.key === 'Enter' &&
                !event.shiftKey
            ) {
                event.preventDefault();

                form?.requestSubmit();
            }
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

        const selectProduct = () => {
            selectedProductId =
                Number(
                    card.dataset.smartAiProductId
                );
        };

        card.addEventListener(
            'mouseenter',
            selectProduct
        );

        card.addEventListener(
            'focusin',
            selectProduct
        );

        card.addEventListener(
            'click',
            selectProduct
        );
    });

/*
|--------------------------------------------------------------------------
| LIVE Voice Interface — reuses the same recognition instance and AI sender
|--------------------------------------------------------------------------
*/
const setLiveState = (state, message) => {
    if (root) root.dataset.liveActive = liveModeActive ? 'true' : 'false';
    if (liveOrb) liveOrb.dataset.state = state;
    if (liveOverlay) liveOverlay.dataset.state = state;
    if (liveStateLabel) {
        const labels = {
            idle: liveModeActive ? 'LIVE' : 'OFF',
            requesting_permission: 'CONNECTING',
            listening: 'LISTENING',
            processing: 'THINKING',
            speaking: 'SPEAKING',
            stopping: 'STOPPING',
            stopped: liveModeActive ? 'PAUSED' : 'OFF',
            error: 'ERROR',
        };
        liveStateLabel.textContent = labels[state] || (liveModeActive ? 'LIVE' : 'OFF');
    }
    if (liveStatus && message) liveStatus.textContent = message;
    if (liveSettingsStatus) {
        const labels = {
            idle: 'LIVE is ready. Microphone is not active.',
            requesting_permission: 'LIVE is connecting and requesting microphone access.',
            listening: 'LIVE is listening through the microphone.',
            processing: 'LIVE is processing the current request.',
            speaking: 'LIVE is speaking a response.',
            stopping: 'LIVE is stopping the microphone and playback.',
            stopped: 'LIVE is paused. Spoken responses can still work when LIVE is off.',
            error: `LIVE needs attention: ${message || 'voice input is unavailable.'}`,
        };
        liveSettingsStatus.textContent = labels[state] || 'LIVE status is unavailable.';
    }
    root.querySelectorAll('[data-smart-ai-live-open]').forEach(button => {
        button.setAttribute('aria-pressed', liveSessionActive ? 'true' : 'false');
        button.setAttribute('aria-label', liveSessionActive ? 'LIVE voice session is active. Click to end it.' : 'Start or resume a LIVE voice session');
        const label = button.querySelector('span:last-child');
        if (label) label.textContent = liveSessionActive ? 'LIVE ON' : 'LIVE';
    });
    if (liveMicButton) {
        liveMicButton.setAttribute('aria-label', state === 'listening' ? 'Pause voice listening' : state === 'requesting_permission' ? 'Cancel microphone request' : 'Start listening');
    }
};

const appendLiveMessage = (role, text) => {
    if (!liveTranscript || !text) return;
    const item = document.createElement('div');
    item.className = 'smart-ai__live-message smart-ai__live-message--' + role;
    item.textContent = String(text);
    liveTranscript.appendChild(item);
    liveTranscript.scrollTop = liveTranscript.scrollHeight;
};

const startLiveListening = () => {
    if (!liveSessionActive || liveProcessing) return;
    if (!voiceInputEnabled) {
        liveListeningRequested = false;
        setLiveState('error', 'Voice input is disabled in Smart AI Settings.');
        return;
    }
    if (!recognition) {
        liveListeningRequested = false;
        setLiveState('error', 'Speech recognition is not supported here. Turn off LIVE to use text chat.');
        return;
    }
    if (recognitionRunning || recognitionStarting) return;
    liveListeningRequested = true;
    recognitionStarting = true;
    setLiveState('requesting_permission', 'Requesting microphone access…');
    recognition.lang = normalizeLanguage(speech.preferredLanguage || localStorage.getItem('smart-ai-recognition-language') || 'en-IN');
    try {
        recognition.start();
    } catch (error) {
        recognitionStarting = false;
        liveListeningRequested = false;
        setLiveState('error', 'Could not start the microphone. Please try again.');
        console.warn('Smart AI live voice start error:', error);
    }
};

const endVoiceSession = (closeOverlay = false) => {
    if (closeOverlay) {
        liveModeActive = false;
        localStorage.removeItem(liveStorageKey);
    }
    liveSessionActive = false;
    liveListeningRequested = false;
    liveProcessing = false;
    liveCloseAfterStop = closeOverlay;
    stopSpeaking();
    if (recognition && (recognitionRunning || recognitionStarting)) {
        setLiveState('stopping', 'Stopping microphone…');
        try { recognition.abort(); } catch (_) { try { recognition.stop(); } catch (_) {} }
        return;
    }
    recognitionStarting = false;
    setLiveState('stopped', 'Voice assistant paused.');
    if (liveCloseAfterStop && liveOverlay) { liveOverlay.hidden = true; liveOpenButton?.focus(); }
    liveCloseAfterStop = false;
};

const closeLiveInterface = () => endVoiceSession(true);

const pauseOrResumeLiveMic = () => {
    if (!liveSessionActive) {
        liveSessionActive = true;
        startLiveListening();
        return;
    }
    if (recognitionRunning || recognitionStarting) {
        liveListeningRequested = false;
        setLiveState('stopped', 'Voice assistant paused. Tap the orb to resume.');
        try { recognition?.abort(); } catch (_) { try { recognition?.stop(); } catch (_) {} }
        return;
    }
    startLiveListening();
};

const submitLiveMessage = async text => {
    const message = String(text || '').trim();
    if (!message || liveProcessing) return;
    appendLiveMessage('user', message);
    liveProcessing = true;
    liveListeningRequested = false;
    if (recognitionRunning || recognitionStarting) {
        try { recognition?.abort(); } catch (_) {}
    }
    setLiveState('processing', 'Thinking…');
    const result = await window.SmartBasketAI.send(message, { suppressSpeech: true });
    if (!result || !result.ok) {
        liveProcessing = false;
        const failureMessage = result?.authRequired
            ? 'Please sign in to use Smart AI.'
            : result?.error?.name === 'AbortError'
                ? 'That took too long. Please try again.'
                : result?.reply || 'I could not get a reply. Check your connection and try again.';
        setLiveState('error', failureMessage);
        if (liveSessionActive) window.setTimeout(startLiveListening, 500);
        return;
    }
    appendLiveMessage('ai', result.reply);
    if (result.localCommand) {
        liveProcessing = false;
        liveSessionActive = false;
        liveListeningRequested = false;
        liveModeActive = false;
        localStorage.removeItem(liveStorageKey);
        if (liveOverlay) liveOverlay.hidden = true;
        if (panel) panel.hidden = false;
        setLiveState('stopped', result.reply);
        input?.focus();
        return;
    }
    if (!liveMuted && ('speechSynthesis' in window) && typeof window.SpeechSynthesisUtterance === 'function' && typeof window.SmartBasketAI.speak === 'function') {
        setLiveState('processing', 'Preparing spoken reply…');
        window.SmartBasketAI.speak(result.reply, { force: true });
    } else {
        liveProcessing = false;
        setLiveState('idle', liveMuted ? 'Reply received. Voice output is muted.' : 'Speech output is unavailable. Turn off LIVE to use text chat.');
        if (liveSessionActive) window.setTimeout(startLiveListening, 700);
    }
};

if (liveOverlay) {
    root.querySelectorAll('[data-smart-ai-live-open]').forEach(button => {
    button.addEventListener('click', () => {
        if (liveSessionActive) {
            endVoiceSession(true);
            return;
        }
        if (liveOverlay.parentElement !== document.body) document.body.appendChild(liveOverlay);
        if (liveModeActive) {
            liveOverlay.hidden = false;
            liveOverlay.dataset.mode = 'live';
            if (panel) panel.hidden = true;
            liveSessionActive = true;
            setLiveState('requesting_permission', 'Resuming LIVE. Starting microphone…');
            startLiveListening();
            return;
        }
        liveOverlay.hidden = false;
        liveOverlay.dataset.mode = 'welcome';
        if (panel) panel.hidden = true;
        liveWelcome?.querySelector('[data-smart-ai-live-start]')?.focus();
    });
    });
}
liveStartButton?.addEventListener('click', () => {
    if (!voiceInputEnabled) {
        if (livePermissionNote) livePermissionNote.textContent = 'Enable Voice input in Smart AI Settings before starting LIVE. Spoken text responses do not need microphone access.';
        livePermissionNote?.classList.add('is-error');
        return;
    }
    if (!recognition) {
        if (livePermissionNote) livePermissionNote.textContent = 'Voice input is not supported in this browser. Continue with text chat instead.';
        livePermissionNote?.classList.add('is-error');
        liveStartButton.disabled = true;
        liveTextButton?.focus();
        return;
    }
    liveOverlay.dataset.mode = 'live';
    liveModeActive = true;
    localStorage.setItem(liveStorageKey, 'true');
    liveSessionActive = true;
    liveMuted = false;
    liveCloseAfterStop = false;
    if (liveMuteButton) { liveMuteButton.setAttribute('aria-pressed', 'false'); liveMuteButton.innerHTML = '<i class="fa-solid fa-volume-high" aria-hidden="true"></i><span>Mute voice</span>'; }
    setLiveState('requesting_permission', 'LIVE is on. Starting microphone…');
    if (liveTranscript && !liveTranscript.childElementCount) appendLiveMessage('ai', 'Smart AI is ready. Recognized speech is sent to Smart Basket AI.');
    startLiveListening();
    liveMicButton?.focus();
});

liveTextButton?.addEventListener('click', () => {
    liveOverlay.hidden = true;
    liveOverlay.dataset.mode = 'welcome';
    if (panel) {
        panel.hidden = false;
        input?.focus();
    }
    liveOpenButton?.focus();
});

liveDismissButton?.addEventListener('click', () => {
    liveOverlay.hidden = true;
    liveOpenButton?.focus();
});

if (liveOpenButton && liveOverlay) {
    /*
     * LIVE activation is deliberately separated from microphone capture so
     * permission is requested only after the customer's explicit Go Live click.
     */
    liveOverlay.addEventListener('click', event => {
        if (event.target === liveOverlay && liveOverlay.dataset.mode === 'welcome') {
            liveOverlay.hidden = true;
            liveOpenButton.focus();
        }
    });
}
liveMicButton?.addEventListener('click', pauseOrResumeLiveMic);
liveOverlay?.querySelector('[data-smart-ai-live-end]')?.addEventListener('click', closeLiveInterface);
root.querySelector('[data-smart-ai-end-live]')?.addEventListener('click', () => {
    if (liveModeActive || liveSessionActive) closeLiveInterface();
    else setLiveState('stopped', 'LIVE is already off. Spoken responses remain available independently.');
});
liveOverlay?.addEventListener('click', event => { if (event.target === liveOverlay) closeLiveInterface(); });
liveMuteButton?.addEventListener('click', () => {
    liveMuted = !liveMuted;
    liveMuteButton.setAttribute('aria-pressed', liveMuted ? 'true' : 'false');
    liveMuteButton.innerHTML = liveMuted ? '<i class="fa-solid fa-volume-xmark" aria-hidden="true"></i><span>Unmute voice</span>' : '<i class="fa-solid fa-volume-high" aria-hidden="true"></i><span>Mute voice</span>';
    if (liveMuted) { stopSpeaking(); liveProcessing = false; setLiveState('idle', 'Voice output muted.'); }
});
liveStopButton?.addEventListener('click', () => {
    liveSessionActive = false;
    liveListeningRequested = false;
    liveProcessing = false;
    liveCloseAfterStop = false;
    stopSpeaking();
    if (recognition && (recognitionRunning || recognitionStarting)) {
        try { recognition.abort(); } catch (_) { try { recognition.stop(); } catch (_) {} }
    }
    setLiveState('stopped', 'Speech stopped. LIVE stays on; tap the microphone to resume.');
});
root.addEventListener('smart-ai:speech-state', event => {
    if (!liveSessionActive || !liveProcessing) return;
    if (event.detail?.state === 'speaking') setLiveState('speaking', 'Smart AI is speaking…');
    if (event.detail?.state === 'ended') {
        liveProcessing = false;
        if (liveSessionActive && !liveMuted) {
            liveListeningRequested = true;
            setLiveState('idle', 'Reply complete. Preparing for your next question.');
            window.setTimeout(startLiveListening, 350);
        }
        else setLiveState('idle', 'Reply complete. Tap the microphone when you are ready.');
    }
});

// Restore the LIVE dock after normal full-page navigation, but never resume
// microphone capture without a fresh user gesture on the new document.
if (liveModeActive && liveOverlay) {
    liveOverlay.hidden = false;
    liveOverlay.dataset.mode = 'live';
    if (panel) panel.hidden = true;
    liveSessionActive = false;
    liveListeningRequested = false;
    setLiveState('stopped', 'Page changed. Tap the microphone to continue LIVE; speech does not carry through a full page load.');
}

document.querySelectorAll('form.sb-logout-form').forEach(logoutForm => {
    logoutForm.addEventListener('submit', () => {
        localStorage.removeItem(liveStorageKey);
    }, { once: true });
});

/*
|--------------------------------------------------------------------------
| Voice Recognition
|--------------------------------------------------------------------------
*/

const SpeechRecognition =
    window.SpeechRecognition ||
    window.webkitSpeechRecognition;

if (!SpeechRecognition) {
    if (mic) {
        mic.disabled = true;
        mic.title = 'Voice input is not supported by this browser';
    }
} else {

    recognition =
        new SpeechRecognition();

    recognition.lang =
        localStorage.getItem(
            'smart-ai-recognition-language'
        ) ||
        speech.preferredLanguage ||
        'en-IN';

    recognition.interimResults = false;
    recognition.continuous = false;
    recognition.maxAlternatives = 3;

    recognition.onstart = () => {
        recognitionStarting = false;
        recognitionRunning = true;
        if (liveSessionActive && liveListeningRequested) setLiveState('listening', "I'm listening… Speak now.");

        mic.classList.add(
            'is-listening'
        );

        setExpression(
            'listening',
            'Listening…'
        );
    };

    recognition.onend = () => {
        recognitionStarting = false;
        recognitionRunning = false;
        mic?.classList.remove('is-listening');

        if (liveCloseAfterStop) {
            setLiveState('stopped', 'Microphone stopped.');
            if (liveOverlay) liveOverlay.hidden = true;
            liveOpenButton?.focus();
            liveCloseAfterStop = false;
            return;
        }
        if (!liveSessionActive) {
            setLiveState('stopped', 'Voice assistant paused.');
            return;
        }
        if (liveSessionActive && liveListeningRequested && !liveProcessing) {
            window.setTimeout(startLiveListening, 250);
            return;
        }
        if (liveSessionActive && !liveProcessing && !liveListeningRequested) {
            if (liveOrb?.dataset.state !== 'error') setLiveState('stopped', 'Voice assistant paused. Tap the orb to resume.');
            return;
        }
        if (!liveSessionActive && stage && stage.dataset.expression === 'listening') {
            setExpression('normal', 'Ready to help');
        }
        if (!liveSessionActive && !liveListeningRequested && liveOrb) liveOrb.dataset.state = 'stopped';
    };

    recognition.onerror = event => {
        recognitionRunning = false;

        mic.classList.remove(
            'is-listening'
        );

        console.warn(
            'Speech recognition error:',
            event.error
        );

        if (liveSessionActive) {
            liveListeningRequested = false;
            const liveError = event.error === 'not-allowed' || event.error === 'service-not-allowed'
                ? 'Microphone permission was denied. Allow access in your browser to use voice input.'
                : event.error === 'no-speech'
                    ? 'I did not hear anything. Tap the orb and try again.'
                    : 'Voice input is unavailable right now. Turn off LIVE to use text chat.';
            setLiveState(event.error === 'no-speech' ? 'idle' : 'error', liveError);
            return;
        }

        if (
            event.error === 'not-allowed'
        ) {
            const message =
                'Microphone permission blocked hai. Browser mein microphone permission allow karein.';

            setExpression(
                'sad',
                'Microphone permission required'
            );

            addMessage(
                message,
                'ai'
            );

            return;
        }

        if (
            event.error === 'no-speech'
        ) {
            setExpression(
                'normal',
                'I did not hear anything'
            );

            return;
        }

        setExpression(
            'sad',
            'Voice input unavailable'
        );
    };

    recognition.onresult = event => {
        const result =
            event.results?.[0]?.[0];

        if (!result) {
            return;
        }

        const transcript =
            String(
                result.transcript || ''
            ).trim();

        if (!transcript) {
            return;
        }

        const transcriptKey = transcript.toLocaleLowerCase().replace(/\s+/g, ' ').trim();
        const now = Date.now();
        if (transcriptKey === lastVoiceTranscript && now - lastVoiceTranscriptAt < 4000) {
            return;
        }
        lastVoiceTranscript = transcriptKey;
        lastVoiceTranscriptAt = now;

        const detected =
            detectLanguage(
                transcript
            );

        localStorage.setItem(
            'smart-ai-recognition-language',
            detected
        );

        recognition.lang =
            detected;

        if (liveSessionActive) {
            submitLiveMessage(transcript);
            return;
        }

        if (input) {
            input.value =
                transcript;
        }

        send(transcript);
    };

    mic.addEventListener(
        'click',
        () => {
            if (!voiceInputEnabled) {
                if (micPermissionStatus) micPermissionStatus.textContent = 'Enable Voice input in Smart AI Settings to use the microphone.';
                if (settingsPanel) settingsPanel.hidden = false;
                return;
            }
            if (recognitionRunning) {
                try {
                    recognition.stop();
                } catch (_) {}

                return;
            }

            stopSpeaking();

            const currentLanguage =
                speech.preferredLanguage ||
                localStorage.getItem(
                    'smart-ai-recognition-language'
                ) ||
                'en-IN';

            recognition.lang =
                normalizeLanguage(
                    currentLanguage
                );

            try {
                recognition.start();
            } catch (error) {
                console.warn(
                    'Recognition start error:',
                    error
                );
            }
        }
    );
}

/*
|--------------------------------------------------------------------------
| Escape
|--------------------------------------------------------------------------
*/

document.addEventListener(
    'keydown',
    event => {
        if (
            event.key === 'Escape'
        ) {
            if (panel) {
                panel.hidden = true;
            }
        }
    }
);

/*
|--------------------------------------------------------------------------
| Stop Voice When Page Is Hidden
|--------------------------------------------------------------------------
*/

window.addEventListener('pagehide', () => {
    if (liveSessionActive) endVoiceSession(false);
    stopSpeaking();
});

/*
|--------------------------------------------------------------------------
| Public API
|--------------------------------------------------------------------------
*/

window.SmartBasketAI = {

    speak,

    stopSpeaking,

    send,

    gesture:
        handleGesture,

    setExpression,

    detectLanguage,

    setLanguage(language) {
        const normalized =
            normalizeLanguage(
                language
            );

        speech.preferredLanguage =
            normalized;

        localStorage.setItem(
            'smart-ai-language',
            normalized
        );

        localStorage.setItem(
            'smart-ai-recognition-language',
            normalized
        );

        if (recognition) {
            recognition.lang =
                normalized;
        }
    },

    setVoiceEnabled(enabled) {
        speech.enabled =
            Boolean(enabled);

        localStorage.setItem(
            'smart-ai-voice-enabled',
            speech.enabled
                ? 'true'
                : 'false'
        );

        if (!speech.enabled) {
            stopSpeaking();
        }
        if (voiceEnabledToggle) voiceEnabledToggle.checked = speech.enabled;
    },

    setVoiceRate(rate) {
        const value =
            Math.min(
                2,
                Math.max(
                    0.5,
                    Number(rate) || 0.98
                )
            );

        speech.rate = value;

        localStorage.setItem(
            'smart-ai-voice-rate',
            String(value)
        );
    },

    setVoicePitch(pitch) {
        const value =
            Math.min(
                2,
                Math.max(
                    0,
                    Number(pitch) || 1.02
                )
            );

        speech.pitch = value;

        localStorage.setItem(
            'smart-ai-voice-pitch',
            String(value)
        );
    },

    setVoiceVolume(volume) {
        const value =
            Math.min(
                1,
                Math.max(
                    0,
                    Number(volume) || 1
                )
            );

        speech.volume = value;

        localStorage.setItem(
            'smart-ai-voice-volume',
            String(value)
        );
        if (volumeControl) volumeControl.value = String(value);
    },

    open() {
        if (panel) {
            panel.hidden = false;
        }

        setExpression(
            'happy',
            'Ready to help'
        );
        handleGesture('wave');

        setTimeout(() => {
            if (!liveModeActive) input?.focus();
            else closeButton?.focus();
        }, 100);
    },

    close() {
        if (panel) {
            panel.hidden = true;
        }
    },

    stopListening() {
        if (
            recognition &&
            recognitionRunning
        ) {
            try {
                recognition.stop();
            } catch (_) {}
        }
    },

    getConversation() {
        return [
            ...conversation,
        ];
    },
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
