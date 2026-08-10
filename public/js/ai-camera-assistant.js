/* Smart Basket Premium — AI Camera Assistant
   Handles camera permission, live preview, capture, upload, retake, AJAX analysis,
   Virtual Try-On, Download, Share, Reset, and History.
   Works on the full page and inside the AI HUB sidebar drawer. */
(function () {
    'use strict';

    function initCameraAssistant(root) {
        const vp       = root.querySelector('.ai-ca-viewport');
        const video    = root.querySelector('#caVideo');
        const canvas   = root.querySelector('#caCanvas');
        const startBtn = root.querySelector('#caStartBtn');
        const stopBtn  = root.querySelector('#caStopBtn');
        const capBtn   = root.querySelector('#caCaptureBtn');
        const upBtn    = root.querySelector('#caUploadBtn');
        const file     = root.querySelector('#caFile');
        const preview  = root.querySelector('#caUploadPreview');
        const status   = root.querySelector('#caStatus');
        const form     = root.querySelector('#caAnalyzeForm');
        const query    = root.querySelector('#caQuery');
        const analyzeBtn = root.querySelector('#caAnalyzeBtn');
        const loading  = root.querySelector('#caLoading');
        const results  = root.querySelector('#caResults');
        const retakeBtn = root.querySelector('#caRetakeBtn');
        const camLoading = root.querySelector('#caCamLoading');

        // Action buttons
        const vtoBtn     = root.querySelector('#caVirtualTryOnBtn');
        const downloadBtn = root.querySelector('#caDownloadBtn');
        const shareBtn   = root.querySelector('#caShareBtn');
        const historyBtn = root.querySelector('#caHistoryBtn');
        const resetBtn   = root.querySelector('#caResetBtn');
        const historyPanel = root.querySelector('#caHistoryPanel');
        const historyList  = root.querySelector('#caHistoryList');
        const historyClose = root.querySelector('#caHistoryClose');

        if (!vp || !video || !form || !results) return;

        let stream = null;
        let currentImageDataUrl = null; // holds the active (captured/uploaded) image
        let activeFile = null;          // holds the selected/uploaded File object
        let currentResultImageUrl = null; // holds the latest generated try-on result URL

        // Read the CSRF token from the meta tag.
        const csrfToken = (() => {
            const meta = document.querySelector('meta[name="csrf-token"]');
            return meta ? meta.getAttribute('content') : '';
        })();

        const csrfHeaders = Object.assign(
            { 'X-Requested-With': 'XMLHttpRequest' },
            csrfToken ? { 'X-CSRF-TOKEN': csrfToken } : {}
        );

        const setStatus = (msg, live) => {
            if (!status) return;
            status.textContent = msg;
            status.classList.toggle('is-live', !!live);
        };

        const showAlert = (message, type) => {
            type = type || 'danger';
            const container = root.querySelector('.ai-ca-alerts');
            if (!container) return;
            const wrapper = document.createElement('div');
            wrapper.className = 'alert alert-' + type + ' alert-dismissible fade show ai-ca-alert';
            wrapper.setAttribute('role', 'alert');
            wrapper.innerHTML = message +
                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
            container.appendChild(wrapper);
            setTimeout(() => {
                if (wrapper.parentNode) wrapper.remove();
            }, 6000);
        };

        const enableActionResultButtons = (enabled) => {
            if (vtoBtn) vtoBtn.disabled = !enabled;
            if (downloadBtn) downloadBtn.disabled = !enabled;
            if (shareBtn) shareBtn.disabled = !enabled;
        };

        const setAnalyzeEnabled = (enabled) => {
            if (analyzeBtn) analyzeBtn.disabled = !enabled;
        };

        const dataURLToBlob = (dataUrl) => {
            const parts = dataUrl.split(',');
            const mime = parts[0].match(/:(.*?);/)[1];
            const bstr = atob(parts[1]);
            const n = bstr.length;
            const u8arr = new Uint8Array(n);
            for (let i = 0; i < n; i++) u8arr[i] = bstr.charCodeAt(i);
            return new Blob([u8arr], { type: mime });
        };

        const stopCamera = () => {
            if (stream) {
                stream.getTracks().forEach((t) => t.stop());
                stream = null;
            }
            video.pause();
            video.classList.remove('is-on');
            if (startBtn) startBtn.classList.remove('d-none');
            if (stopBtn) stopBtn.classList.add('d-none');
            if (capBtn) capBtn.classList.add('d-none');
            setStatus('Camera is off.', false);
        };

        const startCamera = async () => {
            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                setStatus('Camera not supported on this device or browser.', false);
                showAlert('Camera is not supported on this device or browser. You can still upload a photo.', 'warning');
                return;
            }
            if (camLoading) camLoading.classList.remove('d-none');
            setStatus('Loading camera...', false);
            try {
                stream = await navigator.mediaDevices.getUserMedia({
                    video: { facingMode: { ideal: 'user' }, width: { ideal: 1280 }, height: { ideal: 1024 } },
                    audio: false
                });
                video.srcObject = stream;
                await video.play();
                video.classList.add('is-on');
                if (startBtn) startBtn.classList.add('d-none');
                if (stopBtn) stopBtn.classList.remove('d-none');
                if (capBtn) capBtn.classList.remove('d-none');
                if (retakeBtn) retakeBtn.classList.add('d-none');
                setStatus('Camera is live — show your face & full body.', true);
            } catch (err) {
                const denied =
                    err.name === 'NotAllowedError' || err.name === 'PermissionDeniedError' ||
                    err.name === 'SecurityError';
                const notFound =
                    err.name === 'NotFoundError' || err.name === 'OverconstrainedError' ||
                    err.name === 'NotReadableError';
                if (denied) {
                    setStatus('Camera permission denied. You can still upload a photo below.', false);
                    showAlert('Camera permission was denied. Please allow camera access, or upload a photo instead.', 'danger');
                } else if (notFound) {
                    setStatus('No camera found. You can still upload a photo below.', false);
                    showAlert('No camera was found on this device. Please connect a camera or upload a photo instead.', 'warning');
                } else {
                    setStatus('Unable to access camera. You can still upload a photo below.', false);
                    showAlert('Unable to access the camera. Please try again or upload a photo instead.', 'warning');
                }
            } finally {
                if (camLoading) camLoading.classList.add('d-none');
            }
        };

        const capture = () => {
            if (!stream || !video.videoWidth) return;
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext('2d').drawImage(video, 0, 0);
            currentImageDataUrl = canvas.toDataURL('image/jpeg', 0.9);
            activeFile = null;
            if (preview) {
                preview.src = currentImageDataUrl;
                preview.classList.add('is-on');
            }
            stopCamera();
            if (retakeBtn) retakeBtn.classList.remove('d-none');
            setAnalyzeEnabled(true);
            enableActionResultButtons(true);
            setStatus('Photo captured — ready to analyze. Use Retake to try again.', false);
        };

        const retake = () => {
            currentImageDataUrl = null;
            activeFile = null;
            if (preview) {
                preview.src = '';
                preview.classList.remove('is-on');
            }
            if (file) file.value = '';
            if (results) {
                results.innerHTML =
                    '<div class="ai-ca-empty"><i class="fa-solid fa-sparkles"></i>' +
                    '<p>Capture or upload a photo to see your AI style analysis and product recommendations.</p></div>';
            }
            setAnalyzeEnabled(false);
            enableActionResultButtons(false);
            startCamera();
        };

        const onFile = (e) => {
            const f = e.target.files && e.target.files[0];
            if (!f) return;
            const validTypes = ['image/jpeg', 'image/png', 'image/webp'];
            if (!validTypes.includes(f.type)) {
                setStatus('Invalid image type. Please upload JPG, PNG or WEBP.', false);
                showAlert('Invalid image type. Please upload a JPG, PNG or WEBP image.', 'danger');
                setAnalyzeEnabled(false);
                return;
            }
            if (f.size > 5 * 1024 * 1024) {
                setStatus('Image too large. Maximum size is 5 MB.', false);
                showAlert('Image is too large. Maximum allowed size is 5 MB.', 'danger');
                setAnalyzeEnabled(false);
                return;
            }
            const reader = new FileReader();
            reader.onload = () => {
                currentImageDataUrl = reader.result;
                activeFile = f;
                if (preview) {
                    preview.src = currentImageDataUrl;
                    preview.classList.add('is-on');
                }
                stopCamera();
                if (retakeBtn) retakeBtn.classList.remove('d-none');
                setAnalyzeEnabled(true);
                enableActionResultButtons(true);
                setStatus('Photo selected — ready to analyze.', false);
            };
            reader.onerror = () => {
                setStatus('Failed to read the selected image.', false);
                showAlert('Failed to read the selected image. Please try again.', 'danger');
                setAnalyzeEnabled(false);
            };
            reader.readAsDataURL(f);
        };

        const submitAnalysis = async (formData) => {
            if (loading) loading.classList.remove('d-none');
            if (analyzeBtn) analyzeBtn.disabled = true;
            try {
                const res = await fetch('/ai-camera-assistant', {
                    method: 'POST',
                    body: formData,
                    headers: csrfHeaders,
                    credentials: 'same-origin'
                });
                if (res.redirected) {
                    window.location.href = res.url;
                    return;
                }
                if (!res.ok) throw new Error('Request failed');
                const html = await res.text();
                results.innerHTML = html;
                enableActionResultButtons(true);
                setAnalyzeEnabled(true);
            } catch (err) {
                results.innerHTML =
                    '<div class="ai-ca-empty"><i class="fa-solid fa-triangle-exclamation"></i>' +
                    '<p>Something went wrong while analyzing. Please try again.</p></div>';
                enableActionResultButtons(false);
                setAnalyzeEnabled(true);
            } finally {
                if (loading) loading.classList.add('d-none');
                if (analyzeBtn) analyzeBtn.disabled = false;
            }
        };

        const buildFormData = () => {
            const fd = new FormData();
            fd.append('query', (query && query.value) || '');
            if (activeFile) {
                fd.append('image', activeFile, activeFile.name);
            } else if (currentImageDataUrl) {
                const blob = dataURLToBlob(currentImageDataUrl);
                fd.append('image', blob, 'camera-capture.jpg');
            }
            return fd;
        };

        const resetAll = () => {
            stopCamera();
            if (file) file.value = '';
            if (preview) {
                preview.src = '';
                preview.classList.remove('is-on');
            }
            if (results) {
                results.innerHTML =
                    '<div class="ai-ca-empty"><i class="fa-solid fa-sparkles"></i>' +
                    '<p>Capture or upload a photo to see your AI style analysis and product recommendations.</p></div>';
            }
            if (query) query.value = '';
            if (historyPanel) historyPanel.classList.add('d-none');
            if (retakeBtn) retakeBtn.classList.add('d-none');
            currentImageDataUrl = null;
            activeFile = null;
            currentResultImageUrl = null;
            setAnalyzeEnabled(false);
            enableActionResultButtons(false);
            setStatus('Camera is off.', false);
        };

        // Virtual Try-On: send the current image to the backend, show a loading
        // animation, and render the AI-generated result in the result area.
        const openVirtualTryOn = async () => {
            if (!currentImageDataUrl && !activeFile) {
                setStatus('Please capture or upload a photo first.', false);
                showAlert('Please capture or upload a photo first.', 'warning');
                return;
            }
            if (loading) loading.classList.remove('d-none');
            if (vtoBtn) vtoBtn.disabled = true;
            setStatus('Processing virtual try-on...', false);
            try {
                const fd = new FormData();
                if (activeFile) {
                    fd.append('image', activeFile, activeFile.name);
                } else if (currentImageDataUrl) {
                    const blob = dataURLToBlob(currentImageDataUrl);
                    fd.append('image', blob, 'camera-capture.jpg');
                }
                const res = await fetch('/ai-camera-assistant/virtual-try-on', {
                    method: 'POST',
                    body: fd,
                    headers: csrfHeaders,
                    credentials: 'same-origin'
                });
                if (!res.ok) throw new Error('Try-on failed');
                const data = await res.json();
                if (!data.success) throw new Error(data.message || 'Try-on failed');

                currentResultImageUrl = data.result_image;
                renderVirtualTryOnResult(data);
                enableActionResultButtons(true);
                setStatus(data.message || 'Virtual try-on complete.', false);
            } catch (err) {
                setStatus('Virtual try-on failed. Please try again.', false);
                showAlert('Virtual try-on could not be processed. Please try again.', 'danger');
            } finally {
                if (loading) loading.classList.add('d-none');
                if (vtoBtn) vtoBtn.disabled = false;
            }
        };

        const renderVirtualTryOnResult = (data) => {
            if (!results) return;
            const img = data.result_image || '';
            const meta = data.meta || {};
            const processor = data.processor || 'offline-composite';
            const garment = meta.garment || 'Selected outfit';
            results.innerHTML =
                '<div class="ai-ca-vto-result">' +
                    '<div class="ai-ca-card-head">' +
                        '<span class="ai-ca-card-icon ai-ca-icon-ai"><i class="fa-solid fa-wand-magic-sparkles"></i></span>' +
                        '<div><h2>Virtual Try-On Result</h2><small>AI-generated preview · ' + processor + '</small></div>' +
                    '</div>' +
                    (img ? '<img src="' + img + '" class="ai-ca-vto-result-img" alt="Virtual Try-On result">' : '') +
                    '<div class="ai-ca-vto-meta">' +
                        '<span><i class="fa-solid fa-shirt me-1"></i>' + (garment ? garment : 'Selected outfit') + '</span>' +
                        '<span><i class="fa-solid fa-layer-group me-1"></i>' + (meta.mode || 'offline-composite') + '</span>' +
                    '</div>' +
                    '<p class="ai-ca-summary">' + (data.message || 'Your virtual try-on preview is ready.') + '</p>' +
                '</div>';
        };

        // Download the generated result image (or source photo) as PNG/JPG.
        const downloadResult = async () => {
            if (currentResultImageUrl) {
                try {
                    const res = await fetch(currentResultImageUrl, { credentials: 'same-origin' });
                    if (!res.ok) throw new Error('Fetch failed');
                    const blob = await res.blob();
                    const ext = blob.type === 'image/png' ? 'png' : 'jpg';
                    const a = document.createElement('a');
                    a.href = URL.createObjectURL(blob);
                    a.download = 'smart-basket-virtual-tryon.' + ext;
                    document.body.appendChild(a);
                    a.click();
                    setTimeout(() => { URL.revokeObjectURL(a.href); a.remove(); }, 400);
                    setStatus('Result image downloaded.', false);
                    return;
                } catch (err) {
                    setStatus('Download failed. Try again.', false);
                    showAlert('Download failed for the generated image. Please try again.', 'warning');
                    return;
                }
            }

            if (!currentImageDataUrl) {
                setStatus('Please capture or upload a photo first.', false);
                showAlert('Please capture or upload a photo first to download.', 'warning');
                return;
            }
            const downloadSrc = await new Promise((resolve) => {
                const img = new Image();
                img.onload = () => {
                    const c = document.createElement('canvas');
                    c.width = img.naturalWidth;
                    c.height = img.naturalHeight;
                    c.getContext('2d').drawImage(img, 0, 0);
                    resolve(c.toDataURL('image/png'));
                };
                img.onerror = () => resolve(currentImageDataUrl);
                img.src = currentImageDataUrl;
            });
            const a = document.createElement('a');
            a.href = downloadSrc;
            a.download = 'smart-basket-camera-photo.png';
            document.body.appendChild(a);
            a.click();
            a.remove();
            setStatus('Photo downloaded as PNG.', false);
        };

        // Share the generated image URL / file via the Web Share API (with fallback).
        const shareResult = async () => {
            const title = 'My Smart Basket AI Style Analysis';
            const shareText = (results ? results.innerText.slice(0, 900) : 'Smart Basket AI Style Analysis');

            if (currentResultImageUrl && navigator.share) {
                try {
                    await navigator.share({ title: title, text: shareText, url: currentResultImageUrl });
                    setStatus('Shared successfully!', false);
                    return;
                } catch (e) { /* user cancelled or share failed */ }
            }

            const source = currentResultImageUrl || currentImageDataUrl;
            if (!source) {
                setStatus('Please capture or upload a photo first.', false);
                showAlert('Please capture or upload a photo before sharing.', 'warning');
                return;
            }
            try {
                const blob = source.indexOf('data:') === 0
                    ? dataURLToBlob(source)
                    : await (await fetch(source, { credentials: 'same-origin' })).blob();
                const file = new File([blob], 'smart-basket-ai-result.png', { type: blob.type });
                if (navigator.canShare && navigator.canShare({ files: [file] })) {
                    await navigator.share({ title: title, text: shareText, files: [file] });
                    setStatus('Shared successfully!', false);
                    return;
                }
            } catch (e) { /* fall through to clipboard */ }

            try {
                const link = currentResultImageUrl || ('Smart Basket AI Style Analysis\n\n' + shareText);
                await navigator.clipboard.writeText(link);
                setStatus('Copied to clipboard! Paste to share.', false);
            } catch (e) {
                setStatus('Sharing not supported. Try downloading the result.', false);
            }
        };

        // History: toggle the history panel and load history entries.
        const toggleHistory = async () => {
            if (!historyPanel || !historyList) return;
            const isHidden = historyPanel.classList.contains('d-none');
            historyPanel.classList.toggle('d-none', !isHidden);
            if (!isHidden) return;
            historyList.innerHTML = '<span class="ai-ca-empty">Loading history...</span>';
            try {
                const res = await fetch('/ai-camera-assistant/history?sidebar=' + (root.closest('[data-ai-hub-content]') ? '1' : '0'), {
                    headers: csrfHeaders,
                    credentials: 'same-origin'
                });
                if (!res.ok) throw new Error('Failed to load history');
                const html = await res.text();
                const temp = document.createElement('div');
                temp.innerHTML = html;
                const listEl = temp.querySelector('.ai-ca-history-list');
                historyList.innerHTML = listEl ? listEl.innerHTML :
                    '<div class="ai-ca-empty"><i class="fa-solid fa-clock-rotate-left"></i><p>No saved analyses yet.</p></div>';
            } catch (err) {
                historyList.innerHTML = '<div class="ai-ca-empty"><i class="fa-solid fa-triangle-exclamation"></i><p>Failed to load history.</p></div>';
            }
        };

        if (startBtn) startBtn.addEventListener('click', startCamera);
        if (stopBtn) stopBtn.addEventListener('click', stopCamera);
        if (capBtn) capBtn.addEventListener('click', capture);
        if (upBtn) upBtn.addEventListener('click', () => file && file.click());
        if (file) file.addEventListener('change', onFile);
        if (retakeBtn) retakeBtn.addEventListener('click', retake);
        if (resetBtn) resetBtn.addEventListener('click', resetAll);
        if (vtoBtn) vtoBtn.addEventListener('click', openVirtualTryOn);
        if (downloadBtn) downloadBtn.addEventListener('click', downloadResult);
        if (shareBtn) shareBtn.addEventListener('click', shareResult);
        if (historyBtn) historyBtn.addEventListener('click', toggleHistory);
        if (historyClose) historyClose.addEventListener('click', () => historyPanel.classList.add('d-none'));

        // Delegate delete buttons inside history panel.
        if (historyList) {
            historyList.addEventListener('click', async (e) => {
                const del = e.target.closest('.ca-history-delete');
                if (!del) return;
                e.preventDefault();
                try {
                    await fetch(del.href, {
                        method: 'DELETE',
                        headers: csrfHeaders,
                        credentials: 'same-origin'
                    });
                    toggleHistory();
                } catch (err) {
                    setStatus('Failed to delete history entry.', false);
                }
            });
        }

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            if (stream && video.videoWidth) {
                capture();
                return;
            }
            if (!currentImageDataUrl && !activeFile) {
                results.innerHTML =
                    '<div class="ai-ca-empty"><i class="fa-solid fa-camera"></i>' +
                    '<p>Please start the camera and capture, or upload a photo first.</p></div>';
                showAlert('Please capture or upload a photo before analyzing.', 'warning');
                return;
            }
            const fd = buildFormData();
            submitAnalysis(fd);
        });

        setAnalyzeEnabled(false);
        window.addEventListener('beforeunload', stopCamera);
    }

    function initAll() {
        document.querySelectorAll('.ai-ca-viewport').forEach((vp) => {
            const root = vp.closest('.ai-ca-card, .ai-panel-fragment');
            if (root && !root.dataset.caInitialized) {
                root.dataset.caInitialized = '1';
                initCameraAssistant(root);
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAll);
    } else {
        initAll();
    }

    document.addEventListener('DOMContentLoaded', () => {
        const content = document.querySelector('[data-ai-hub-content]');
        if (content) {
            const mo = new MutationObserver(() => initAll());
            mo.observe(content, { childList: true, subtree: true });
        }
    });
})();
