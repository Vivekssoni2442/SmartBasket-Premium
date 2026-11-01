import { Passkeys } from '@laravel/passkeys';

const csrf = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
const message = document.getElementById('sellerFaceUnlockMessage');
const setMessage = (text, isError = false) => {
    if (!message) return;
    message.textContent = text;
    message.style.color = isError ? '#a43131' : '#21734b';
};

const isUnsupportedLoopback = ['127.0.0.1', '::1'].includes(window.location.hostname);
if (isUnsupportedLoopback) {
    setMessage('Passkeys are blocked on this IP address. Sign in at http://localhost:8000 for local development, or use the secure HTTPS seller link.', true);
}

const post = async (url) => {
    const response = await fetch(url, {
        method: 'POST',
        headers: {
            Accept: 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrf,
        },
        credentials: 'same-origin',
        body: JSON.stringify({}),
    });
    const payload = await response.json().catch(() => ({}));
    if (!response.ok) throw new Error(payload.message || 'Request failed. Please try again.');
    return payload;
};

const registerButton = document.getElementById('sellerRegisterPasskey');
registerButton?.addEventListener('click', async () => {
    registerButton.disabled = true;
    setMessage('Follow the device prompt to register its secure unlock.');
    try {
        if (isUnsupportedLoopback) throw new Error('Open the seller site at http://localhost:8000, sign in again, and register this device there. On a phone, use the secure HTTPS seller link.');
        if (!Passkeys.isSupported()) throw new Error('This browser does not support device passkeys. Open the seller site in a current browser over HTTPS.');
        const platform = [navigator.userAgentData?.platform, navigator.platform].filter(Boolean).join(' ');
        await Passkeys.register({ name: platform ? `Seller device · ${platform}` : 'Seller device' });
        await post('/seller/face-unlock/enable');
        setMessage('This device is registered and face unlock is enabled for seller login.');
        window.setTimeout(() => window.location.reload(), 900);
    } catch (error) {
        setMessage(error?.message || 'Could not register this device.', true);
    } finally {
        registerButton.disabled = false;
    }
});

const disableButton = document.getElementById('sellerDisableFaceUnlock');
disableButton?.addEventListener('click', async () => {
    if (!window.confirm('Turn off the extra device-unlock step for seller login?')) return;
    disableButton.disabled = true;
    try {
        await post('/seller/face-unlock/disable');
        setMessage('Face unlock has been turned off.');
        window.setTimeout(() => window.location.reload(), 700);
    } catch (error) {
        setMessage(error?.message || 'Could not update face-unlock settings.', true);
        disableButton.disabled = false;
    }
});

const verifyButton = document.getElementById('sellerFaceUnlockVerify');
verifyButton?.addEventListener('click', async () => {
    verifyButton.disabled = true;
    setMessage('Waiting for device verification…');
    try {
        if (isUnsupportedLoopback) throw new Error('This IP address cannot use passkeys. Open the seller site at http://localhost:8000 or use the secure HTTPS seller link.');
        if (!Passkeys.isSupported()) throw new Error('This browser does not support passkeys. Try the browser on your registered device.');
        const result = await Passkeys.verify();
        if (!result?.redirect) throw new Error('Verification did not complete. Please try again.');
        window.location.replace(result.redirect);
    } catch (error) {
        setMessage(error?.message || 'Device verification failed. Try again.', true);
        verifyButton.disabled = false;
    }
});
