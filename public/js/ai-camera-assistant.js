/*
|--------------------------------------------------------------------------
| SMART BASKET — AI CAMERA ASSISTANT
|--------------------------------------------------------------------------
| Handles:
| - Camera start / stop
| - Capture
| - Upload
| - Preview
| - AI analysis
| - CSRF
| - Recommendations
| - History
| - Share
| - Download
| - Reset
|--------------------------------------------------------------------------
*/

document.addEventListener('DOMContentLoaded', function () {

    'use strict';

    /* =========================================================
       ELEMENTS
    ========================================================== */

    const video = document.getElementById('caVideo');
    const canvas = document.getElementById('caCanvas');

    const placeholder = document.getElementById('caPlaceholder');
    const uploadPreview = document.getElementById('caUploadPreview');

    const fileInput = document.getElementById('caFile');

    const startBtn = document.getElementById('caStartBtn');
    const captureBtn = document.getElementById('caCaptureBtn');
    const retakeBtn = document.getElementById('caRetakeBtn');
    const uploadBtn = document.getElementById('caUploadBtn');
    const stopBtn = document.getElementById('caStopBtn');

    const statusBox = document.getElementById('caStatus');
    const alerts = document.getElementById('caAlerts');

    const analyzeForm = document.getElementById('caAnalyzeForm');
    const analyzeBtn = document.getElementById('caAnalyzeBtn');
    const queryInput = document.getElementById('caQuery');

    const loading = document.getElementById('caLoading');
    const results = document.getElementById('caResults');

    const resetBtn = document.getElementById('caResetBtn');
    const shareBtn = document.getElementById('caShareBtn');
    const downloadBtn = document.getElementById('caDownloadBtn');

    const historyBtn = document.getElementById('caHistoryBtn');
    const historyPanel = document.getElementById('caHistoryPanel');
    const historyClose = document.getElementById('caHistoryClose');
    const historyList = document.getElementById('caHistoryList');

    const virtualTryOnBtn =
        document.getElementById('caVirtualTryOnBtn');
    const tryOnPanel = document.getElementById('caTryOn');
    const productSearchInput = document.getElementById('caProductSearch');
    const productSearchStatus = document.getElementById('caProductSearchStatus');
    const tryOnProducts = document.getElementById('caTryOnProducts');
    const tryOnConsent = document.getElementById('caTryOnConsent');
    const tryOnProgress = document.getElementById('caTryOnProgress');
    const tryOnProgressText = document.getElementById('caTryOnProgressText');
    const tryOnResult = document.getElementById('caTryOnResult');
    const tryOnResultImage = document.getElementById('caTryOnResultImage');
    const tryOnResultTitle = document.getElementById('caTryOnResultTitle');
    const tryOnDownload = document.getElementById('caTryOnDownload');


    /* =========================================================
       STATE
    ========================================================== */

    let stream = null;
    let selectedImageBlob = null;
    let selectedImageUrl = null;
    let lastAnalysisHtml = null;
    let selectedTryOnProduct = null;
    let productSearchTimer = null;
    let productSearchSequence = 0;
    let tryOnInProgress = false;


    /* =========================================================
       CSRF
    ========================================================== */

    function getCsrfToken() {

        const meta = document.querySelector(
            'meta[name="csrf-token"]'
        );

        return meta ? meta.getAttribute('content') : '';
    }


    /* =========================================================
       HELPERS
    ========================================================== */

    function showAlert(message, type = 'danger') {

        if (!alerts) {
            return;
        }

        alerts.innerHTML = `
            <div class="alert alert-${type} d-flex align-items-center">
                <i class="fa-solid ${
                    type === 'success'
                        ? 'fa-circle-check'
                        : 'fa-circle-exclamation'
                } me-2"></i>

                <span>${escapeHtml(message)}</span>
            </div>
        `;

        setTimeout(() => {

            if (alerts) {
                alerts.innerHTML = '';
            }

        }, 6000);
    }


    function escapeHtml(value) {

        const div = document.createElement('div');

        div.textContent = value ?? '';

        return div.innerHTML;
    }


    function setStatus(message, type = '') {

        if (!statusBox) {
            return;
        }

        statusBox.textContent = message;

        statusBox.classList.remove(
            'success',
            'error',
            'active'
        );

        if (type) {
            statusBox.classList.add(type);
        }
    }


    function setLoading(show) {

        if (!loading) {
            return;
        }

        loading.classList.toggle(
            'd-none',
            !show
        );

        if (analyzeBtn) {
            analyzeBtn.disabled = show;
        }
    }


    function enableActionButtons(enabled) {

        if (shareBtn) {
            shareBtn.disabled = !enabled;
        }

        if (downloadBtn) {
            downloadBtn.disabled = !enabled;
        }

    }


    /* =========================================================
       CAMERA
    ========================================================== */

    async function startCamera() {

        if (!navigator.mediaDevices ||
            !navigator.mediaDevices.getUserMedia) {

            showAlert(
                'Your browser does not support camera access.',
                'danger'
            );

            return;
        }

        try {

            setStatus('Requesting camera permission...');

            if (stream) {
                stopCamera(false);
            }

            stream = await navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: 'user',
                    width: {
                        ideal: 1280
                    },
                    height: {
                        ideal: 720
                    }
                },
                audio: false
            });

            video.srcObject = stream;

            await video.play();

            video.classList.add('active');

            if (placeholder) {
                placeholder.classList.add('d-none');
            }

            if (uploadPreview) {
                uploadPreview.classList.remove('active');
                uploadPreview.removeAttribute('src');
            }

            if (startBtn) {
                startBtn.classList.add('d-none');
            }

            if (captureBtn) {
                captureBtn.classList.remove('d-none');
            }

            if (stopBtn) {
                stopBtn.classList.remove('d-none');
            }

            if (retakeBtn) {
                retakeBtn.classList.add('d-none');
            }

            setStatus(
                'Camera is active. Stand in front of the camera.',
                'active'
            );

        } catch (error) {

            console.error(
                'Camera error:',
                error
            );

            let message =
                'Unable to access camera.';

            if (error.name === 'NotAllowedError') {

                message =
                    'Camera permission was denied. Please allow camera access in your browser.';

            } else if (error.name === 'NotFoundError') {

                message =
                    'No camera was found on this device.';

            } else if (error.name === 'NotReadableError') {

                message =
                    'Camera is already being used by another application.';

            } else if (error.name === 'SecurityError') {

                message =
                    'Camera access is blocked by browser security settings.';

            }

            showAlert(
                message,
                'danger'
            );

            setStatus(
                'Camera could not be started.',
                'error'
            );
        }
    }


    /* =========================================================
       STOP CAMERA
    ========================================================== */

    function stopCamera(showMessage = true) {

        if (stream) {

            stream.getTracks().forEach(
                track => track.stop()
            );

            stream = null;
        }

        if (video) {

            video.pause();

            video.srcObject = null;

            video.classList.remove('active');
        }

        if (captureBtn) {
            captureBtn.classList.add('d-none');
        }

        if (stopBtn) {
            stopBtn.classList.add('d-none');
        }

        if (startBtn) {
            startBtn.classList.remove('d-none');
        }

        if (showMessage) {

            setStatus(
                'Camera is off.',
                ''
            );
        }
    }


    /* =========================================================
       CAPTURE PHOTO
    ========================================================== */

    function capturePhoto() {

        if (!video ||
            !video.videoWidth ||
            !video.videoHeight) {

            showAlert(
                'Camera is not ready yet.',
                'danger'
            );

            return;
        }

        const width = video.videoWidth;
        const height = video.videoHeight;

        canvas.width = width;
        canvas.height = height;

        const context =
            canvas.getContext('2d');

        /*
         * Mirror the front-camera image so the
         * captured photo looks natural.
         */

        context.save();

        context.translate(
            width,
            0
        );

        context.scale(
            -1,
            1
        );

        context.drawImage(
            video,
            0,
            0,
            width,
            height
        );

        context.restore();

        canvas.toBlob(
            function (blob) {

                if (!blob) {

                    showAlert(
                        'Unable to capture image.',
                        'danger'
                    );

                    return;
                }

                selectedImageBlob = blob;

                showImagePreview(
                    blob
                );

                stopCamera(false);

                if (retakeBtn) {
                    retakeBtn.classList.remove('d-none');
                }

                setStatus(
                    'Photo captured successfully. You can now analyze it.',
                    'success'
                );

                enableActionButtons(false);
                if (virtualTryOnBtn) virtualTryOnBtn.disabled = false;
                maybeGenerateTryOn();

            },
            'image/jpeg',
            0.92
        );
    }


    /* =========================================================
       IMAGE PREVIEW
    ========================================================== */

    function showImagePreview(blob) {

        if (!uploadPreview) {
            return;
        }

        if (selectedImageUrl) {

            URL.revokeObjectURL(
                selectedImageUrl
            );
        }

        selectedImageUrl =
            URL.createObjectURL(blob);

        uploadPreview.src =
            selectedImageUrl;

        if (virtualTryOnBtn) virtualTryOnBtn.disabled = false;

        uploadPreview.classList.add(
            'active'
        );

        if (video) {
            video.classList.remove(
                'active'
            );
        }

        if (placeholder) {
            placeholder.classList.add(
                'd-none'
            );
        }
    }


    /* =========================================================
       UPLOAD
    ========================================================== */

    function openUpload() {

        if (!fileInput) {
            return;
        }

        fileInput.click();
    }


    function handleUpload(event) {

        const file =
            event.target.files?.[0];

        if (!file) {
            return;
        }

        const allowedTypes = [
            'image/jpeg',
            'image/png',
            'image/webp'
        ];

        if (!allowedTypes.includes(file.type)) {

            showAlert(
                'Please select a JPG, PNG or WEBP image.',
                'danger'
            );

            fileInput.value = '';

            return;
        }

        if (file.size > 5 * 1024 * 1024) {

            showAlert(
                'Image must be smaller than 5 MB.',
                'danger'
            );

            fileInput.value = '';

            return;
        }

        selectedImageBlob = file;

        showImagePreview(
            file
        );

        stopCamera(false);

        if (retakeBtn) {
            retakeBtn.classList.remove(
                'd-none'
            );
        }

        setStatus(
            'Image uploaded successfully. Click Analyze My Style.',
            'success'
        );

        enableActionButtons(false);
        if (virtualTryOnBtn) virtualTryOnBtn.disabled = false;
        maybeGenerateTryOn();
    }


    /* =========================================================
       ANALYZE
    ========================================================== */

    async function analyzeImage(event) {

        event.preventDefault();

        if (!selectedImageBlob) {

            showAlert(
                'First capture or upload a photo.',
                'danger'
            );

            return;
        }

        setLoading(true);

        setStatus(
            'AI is analyzing your image...'
        );

        try {

            const formData =
                new FormData();

            /*
             * Always send the image using the exact
             * field expected by AICameraAssistantController.
             */

            formData.append(
                'image',
                selectedImageBlob,
                'ai-camera.jpg'
            );

            formData.append(
                'query',
                queryInput
                    ? queryInput.value
                    : ''
            );

            const response =
                await fetch(
                    '/ai-camera-assistant',
                    {
                        method: 'POST',

                        headers: {
                            'X-CSRF-TOKEN':
                                getCsrfToken(),

                            'X-Requested-With':
                                'XMLHttpRequest',

                            'Accept':
                                'text/html'
                        },

                        body: formData,

                        credentials:
                            'same-origin'
                    }
                );

            if (!response.ok) {

                let message =
                    `Server error (${response.status})`;

                try {

                    const text =
                        await response.text();

                    console.error(
                        'AI Camera server response:',
                        text
                    );

                    if (
                        response.status === 419
                    ) {

                        message =
                            'Session expired. Please refresh the page and try again.';

                    } else if (
                        response.status === 422
                    ) {

                        message =
                            'Image validation failed. Please use a JPG, PNG or WEBP image under 5 MB.';

                    } else if (
                        response.status === 500
                    ) {

                        message =
                            'AI server error. Please check Laravel logs.';
                    }

                } catch (e) {
                    console.error(e);
                }

                throw new Error(
                    message
                );
            }

            /*
             * Controller currently returns the full Blade page.
             * We extract only #caResults from that HTML.
             */

            const html =
                await response.text();

            const parser =
                new DOMParser();

            const documentHtml =
                parser.parseFromString(
                    html,
                    'text/html'
                );

            const newResults =
                documentHtml.querySelector(
                    '#caResults'
                );

            if (!newResults) {

                console.error(
                    'AI response did not contain #caResults',
                    html
                );

                throw new Error(
                    'AI returned an unexpected response.'
                );
            }

            if (results) {

                results.innerHTML =
                    newResults.innerHTML;
            }

            lastAnalysisHtml =
                newResults.innerHTML;

            enableActionButtons(
                true
            );

            setStatus(
                'AI analysis completed successfully.',
                'success'
            );

            showAlert(
                'AI analysis complete! Recommendations are ready.',
                'success'
            );

            /*
             * Scroll result into view.
             */

            if (results) {

                setTimeout(() => {

                    results.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });

                }, 150);
            }

        } catch (error) {

            console.error(
                'AI analysis error:',
                error
            );

            showAlert(
                error.message ||
                'Something went wrong while analyzing your image.',
                'danger'
            );

            setStatus(
                'AI analysis failed.',
                'error'
            );

        } finally {

            setLoading(false);
        }
    }


    /* =========================================================
       HISTORY
    ========================================================== */

    async function openHistory(event) {

        if (event) {
            event.preventDefault();
        }

        if (!historyPanel) {
            return;
        }

        historyPanel.classList.remove(
            'd-none'
        );

        if (historyList) {

            historyList.innerHTML = `
                <span class="ai-ca-empty">
                    Loading history...
                </span>
            `;
        }

        try {

            const response =
                await fetch(
                    '/ai-camera-assistant/history?sidebar=0',
                    {
                        headers: {
                            'X-Requested-With':
                                'XMLHttpRequest',

                            'Accept':
                                'text/html'
                        },

                        credentials:
                            'same-origin'
                    }
                );

            if (!response.ok) {

                throw new Error(
                    'Unable to load history.'
                );
            }

            const html =
                await response.text();

            const doc =
                new DOMParser()
                    .parseFromString(
                        html,
                        'text/html'
                    );

            /*
             * Try common history containers.
             */

            const historySource =
                doc.querySelector(
                    '#caHistoryList'
                ) ||
                doc.querySelector(
                    '.ai-ca-history-list'
                ) ||
                doc.querySelector(
                    '.history-list'
                ) ||
                doc.querySelector(
                    'main'
                );

            if (historyList) {

                historyList.innerHTML =
                    historySource
                        ? historySource.innerHTML
                        : `
                            <span class="ai-ca-empty">
                                No analysis history found.
                            </span>
                        `;
            }

        } catch (error) {

            console.error(
                error
            );

            if (historyList) {

                historyList.innerHTML = `
                    <span class="ai-ca-empty">
                        Unable to load history.
                    </span>
                `;
            }
        }
    }


    function closeHistory() {

        if (historyPanel) {

            historyPanel.classList.add(
                'd-none'
            );
        }
    }


    /* =========================================================
       DOWNLOAD
    ========================================================== */

    function downloadAnalysis() {

        if (!lastAnalysisHtml) {

            showAlert(
                'Please analyze an image first.',
                'danger'
            );

            return;
        }

        const printWindow =
            window.open(
                '',
                '_blank'
            );

        if (!printWindow) {

            showAlert(
                'Please allow popups to download your analysis.',
                'danger'
            );

            return;
        }

        printWindow.document.write(`
            <!DOCTYPE html>

            <html>

            <head>

                <title>
                    Smart Basket AI Style Analysis
                </title>

                <meta charset="UTF-8">

                <style>

                    body {
                        font-family:
                            Arial,
                            sans-serif;

                        padding: 40px;

                        color: #111827;
                    }

                    h1 {
                        margin-bottom: 30px;
                    }

                    .ai-ca-detection-grid,
                    .ai-ca-analysis-grid {
                        display: grid;
                        gap: 15px;
                        margin-bottom: 25px;
                    }

                    .ai-ca-detection-grid {
                        grid-template-columns:
                            repeat(2, 1fr);
                    }

                    .ai-ca-analysis-grid {
                        grid-template-columns:
                            repeat(2, 1fr);
                    }

                    .ai-ca-detection-item,
                    .ai-ca-analysis-item {
                        padding: 18px;
                        border: 1px solid #ddd;
                        border-radius: 12px;
                    }

                    .ai-ca-detection-item > *,
                    .ai-ca-analysis-item > * {
                        display: block;
                        margin-bottom: 6px;
                    }

                    .ai-ca-color-chips {
                        display: flex;
                        gap: 8px;
                        flex-wrap: wrap;
                    }

                    .ai-ca-color-chip {
                        border: 1px solid #ddd;
                        padding: 7px 12px;
                        border-radius: 30px;
                    }

                </style>

            </head>

            <body>

                <h1>
                    Smart Basket — AI Style Analysis
                </h1>

                ${lastAnalysisHtml}

                <script>
                    window.onload = function () {
                        window.print();
                    };
                <\/script>

            </body>

            </html>
        `);

        printWindow.document.close();
    }


    /* =========================================================
       SHARE
    ========================================================== */

    async function shareAnalysis() {

        const text =
            'My Smart Basket AI Style Analysis is ready!';

        try {

            if (
                navigator.share
            ) {

                await navigator.share({
                    title:
                        'Smart Basket AI Style Analysis',

                    text:
                        text,

                    url:
                        window.location.href
                });

            } else {

                await navigator.clipboard.writeText(
                    window.location.href
                );

                showAlert(
                    'Analysis link copied to clipboard.',
                    'success'
                );
            }

        } catch (error) {

            /*
             * User cancelled share.
             * Do not show an error.
             */

            if (
                error.name !==
                'AbortError'
            ) {

                console.error(
                    error
                );
            }
        }
    }


    /* =========================================================
       RESET
    ========================================================== */

    function resetAssistant() {

        stopCamera(false);

        selectedImageBlob = null;
        selectedTryOnProduct = null;
        if (virtualTryOnBtn) virtualTryOnBtn.disabled = true;
        if (tryOnProducts) tryOnProducts.innerHTML = '';
        if (tryOnResult) tryOnResult.classList.add('d-none');
        if (tryOnResultImage) tryOnResultImage.removeAttribute('src');
        if (tryOnDownload) tryOnDownload.removeAttribute('href');
        if (tryOnConsent) tryOnConsent.checked = false;
        if (productSearchInput) productSearchInput.value = '';
        setProductSearchStatus('Upload a photo, then search for a product.');

        if (selectedImageUrl) {

            URL.revokeObjectURL(
                selectedImageUrl
            );

            selectedImageUrl = null;
        }

        if (fileInput) {
            fileInput.value = '';
        }

        if (uploadPreview) {

            uploadPreview.removeAttribute(
                'src'
            );

            uploadPreview.classList.remove(
                'active'
            );
        }

        if (placeholder) {

            placeholder.classList.remove(
                'd-none'
            );
        }

        if (queryInput) {
            queryInput.value = '';
        }

        if (results) {

            results.innerHTML = `
                <div class="ai-ca-empty">

                    <i class="fa-solid fa-sparkles"></i>

                    <p>
                        Capture or upload a photo to see
                        your AI style analysis and product
                        recommendations.
                    </p>

                </div>
            `;
        }

        if (loading) {

            loading.classList.add(
                'd-none'
            );
        }

        if (retakeBtn) {

            retakeBtn.classList.add(
                'd-none'
            );
        }

        if (startBtn) {

            startBtn.classList.remove(
                'd-none'
            );
        }

        lastAnalysisHtml = null;

        enableActionButtons(
            false
        );

        setStatus(
            'Camera is off.'
        );

        if (alerts) {
            alerts.innerHTML = '';
        }
    }


    /* =========================================================
       RETAKE
    ========================================================== */

    function retakePhoto() {

        selectedImageBlob = null;
        if (virtualTryOnBtn) virtualTryOnBtn.disabled = true;

        if (uploadPreview) {

            uploadPreview.removeAttribute(
                'src'
            );

            uploadPreview.classList.remove(
                'active'
            );
        }

        if (retakeBtn) {

            retakeBtn.classList.add(
                'd-none'
            );
        }

        enableActionButtons(
            false
        );

        startCamera();
    }


    /* =========================================================
       PRODUCT SEARCH + AI TRY-ON
    ========================================================== */

    function setProductSearchStatus(message, type = '') {
        if (!productSearchStatus) return;
        productSearchStatus.textContent = message;
        productSearchStatus.classList.toggle('is-error', type === 'error');
    }

    function renderTryOnProducts(products) {
        if (!tryOnProducts) return;
        if (!products.length) {
            tryOnProducts.innerHTML = '<div class="ai-ca-empty">No matching products found.</div>';
            return;
        }

        tryOnProducts.innerHTML = products.map((product, index) => `
            <button type="button" class="ai-ca-tryon-product ${selectedTryOnProduct?.id === product.id ? 'is-selected' : ''}" data-product-index="${index}" aria-pressed="${selectedTryOnProduct?.id === product.id ? 'true' : 'false'}">
                <img src="${escapeHtml(product.image).replace(/"/g, '&quot;')}" alt="" loading="lazy">
                <span><strong>${escapeHtml(product.name)}</strong><small>${escapeHtml(product.category || product.brand || 'Smart Basket product')} · ₹${Number(product.price || 0).toLocaleString('en-IN')}</small></span>
            </button>
        `).join('');

        tryOnProducts.querySelectorAll('[data-product-index]').forEach(button => {
            button.addEventListener('click', () => {
                selectedTryOnProduct = products[Number(button.dataset.productIndex)] || null;
                tryOnProducts.querySelectorAll('.ai-ca-tryon-product').forEach(item => {
                    const selected = item === button;
                    item.classList.toggle('is-selected', selected);
                    item.setAttribute('aria-pressed', selected ? 'true' : 'false');
                });
                if (tryOnResult) tryOnResult.classList.add('d-none');
                setProductSearchStatus(`Selected ${selectedTryOnProduct?.name || 'product'}.`);
                maybeGenerateTryOn();
            });
        });
    }

    async function searchTryOnProducts() {
        const term = productSearchInput?.value.trim() || '';
        const sequence = ++productSearchSequence;
        if (term.length < 2) {
            if (tryOnProducts) tryOnProducts.innerHTML = '';
            setProductSearchStatus('Type at least 2 letters to search the catalog.');
            return;
        }

        setProductSearchStatus('Searching Smart Basket products…');
        try {
            const url = new URL(tryOnPanel.dataset.searchUrl, window.location.origin);
            url.searchParams.set('q', term);
            const response = await fetch(url, {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                credentials: 'same-origin'
            });
            const data = await response.json();
            if (sequence !== productSearchSequence) return;
            if (!response.ok) throw new Error(data.message || 'Product search failed. Please try again.');
            renderTryOnProducts(Array.isArray(data.products) ? data.products : []);
            setProductSearchStatus(data.products?.length ? `${data.products.length} matching products. Select one to create its preview.` : 'No matching products found.');
        } catch (error) {
            if (sequence !== productSearchSequence) return;
            setProductSearchStatus(error.message || 'Unable to search products right now.', 'error');
        }
    }

    function maybeGenerateTryOn() {
        if (!selectedTryOnProduct) return;
        if (!selectedImageBlob) {
            setProductSearchStatus('Upload or capture your photo to continue.');
            return;
        }
        if (!tryOnConsent?.checked) {
            setProductSearchStatus('Please agree to the private AI image processing notice to generate your preview.');
            return;
        }
        virtualTryOn();
    }

    async function virtualTryOn() {
        if (!selectedImageBlob || !selectedTryOnProduct || !tryOnConsent?.checked || tryOnInProgress) return;

        tryOnInProgress = true;
        if (tryOnProgress) tryOnProgress.classList.remove('d-none');
        if (tryOnProgressText) tryOnProgressText.textContent = `Creating a preview with ${selectedTryOnProduct.name}…`;
        if (tryOnResult) tryOnResult.classList.add('d-none');
        setProductSearchStatus('The image model is creating your preview. This can take a little while.');
        try {
            const formData = new FormData();
            formData.append('photo', selectedImageBlob, selectedImageBlob.name || 'customer-photo.jpg');
            formData.append('privacy_consent', '1');

            const generationUrl = tryOnPanel.dataset.generateUrlTemplate.replace('__PRODUCT__', encodeURIComponent(selectedTryOnProduct.id));
            const response = await fetch(generationUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData,
                credentials: 'same-origin'
            });
            const data = await response.json().catch(() => ({}));
            if (!response.ok || !data.success) {
                if (response.status === 401) throw new Error('Please log in to generate a private AI preview.');
                throw new Error(data.message || 'AI preview could not be generated. Please try again.');
            }

            if (tryOnResultImage) tryOnResultImage.src = `${data.result_url}${data.result_url.includes('?') ? '&' : '?'}t=${Date.now()}`;
            if (tryOnResultTitle) tryOnResultTitle.textContent = `AI preview · ${selectedTryOnProduct.name}`;
            if (tryOnDownload) tryOnDownload.href = data.download_url;
            if (tryOnResult) tryOnResult.classList.remove('d-none');
            setProductSearchStatus('Your AI product preview is ready.');
            tryOnResult?.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        } catch (error) {
            setProductSearchStatus(error.message || 'AI preview failed. Please try again.', 'error');
            showAlert(error.message || 'AI preview failed. Please try again.', 'danger');
        } finally {
            tryOnInProgress = false;
            if (tryOnProgress) tryOnProgress.classList.add('d-none');
        }
    }


    /* =========================================================
       EVENT LISTENERS
    ========================================================== */

    if (startBtn) {

        startBtn.addEventListener(
            'click',
            startCamera
        );
    }


    if (captureBtn) {

        captureBtn.addEventListener(
            'click',
            capturePhoto
        );
    }


    if (stopBtn) {

        stopBtn.addEventListener(
            'click',
            () => stopCamera(true)
        );
    }


    if (uploadBtn) {

        uploadBtn.addEventListener(
            'click',
            openUpload
        );
    }


    if (fileInput) {

        fileInput.addEventListener(
            'change',
            handleUpload
        );
    }


    if (retakeBtn) {

        retakeBtn.addEventListener(
            'click',
            retakePhoto
        );
    }


    if (analyzeForm) {

        analyzeForm.addEventListener(
            'submit',
            analyzeImage
        );
    }


    if (resetBtn) {

        resetBtn.addEventListener(
            'click',
            resetAssistant
        );
    }


    if (shareBtn) {

        shareBtn.addEventListener(
            'click',
            shareAnalysis
        );
    }


    if (downloadBtn) {

        downloadBtn.addEventListener(
            'click',
            downloadAnalysis
        );
    }


    if (historyBtn) {

        historyBtn.addEventListener(
            'click',
            openHistory
        );
    }


    if (historyClose) {

        historyClose.addEventListener(
            'click',
            closeHistory
        );
    }


    if (virtualTryOnBtn) {

        virtualTryOnBtn.addEventListener(
            'click',
            function () {
                tryOnPanel?.scrollIntoView({ behavior: 'smooth', block: 'center' });
                if (!selectedTryOnProduct) {
                    productSearchInput?.focus({ preventScroll: true });
                    setProductSearchStatus('Search and select a product to create its preview.');
                    return;
                }
                maybeGenerateTryOn();
            }
        );
    }

    if (productSearchInput && tryOnPanel) {
        productSearchInput.addEventListener('input', function () {
            window.clearTimeout(productSearchTimer);
            productSearchTimer = window.setTimeout(searchTryOnProducts, 280);
        });
    }

    if (tryOnConsent) {
        tryOnConsent.addEventListener('change', maybeGenerateTryOn);
    }


    /* =========================================================
       CLEANUP
    ========================================================== */

    window.addEventListener(
        'beforeunload',
        function () {

            if (stream) {

                stream.getTracks().forEach(
                    track => track.stop()
                );
            }

            if (selectedImageUrl) {

                URL.revokeObjectURL(
                    selectedImageUrl
                );
            }
        }
    );


    /* =========================================================
       INITIAL STATE
    ========================================================== */

    enableActionButtons(false);

    setStatus(
        'Camera is off.'
    );

});
