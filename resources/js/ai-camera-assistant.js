/*
|--------------------------------------------------------------------------
| SMART BASKET — AI CAMERA ASSISTANT
|--------------------------------------------------------------------------
| Camera + Upload + Capture + AI Analysis + Voice + History
|--------------------------------------------------------------------------
| IMPORTANT:
| - Works with Laravel Blade/API responses
| - Preserves existing element IDs/routes
| - Sends CSRF token correctly
| - Supports camera, upload and captured images
| - Handles JSON and HTML responses
| - Adds AI voice output
| - Keeps Virtual Try-On navigation
|--------------------------------------------------------------------------
*/

document.addEventListener('DOMContentLoaded', () => {

    'use strict';

    /* ---------------------------------------------------------------------
     * ELEMENTS
     * ------------------------------------------------------------------ */

    const video = document.getElementById('caVideo');
    const canvas = document.getElementById('caCanvas');
    const viewport = document.getElementById('caViewport');

    const placeholder = document.getElementById('caPlaceholder');
    const loadingCamera = document.getElementById('caCamLoading');

    const fileInput = document.getElementById('caFile');
    const uploadPreview = document.getElementById('caUploadPreview');

    const startBtn = document.getElementById('caStartBtn');
    const captureBtn = document.getElementById('caCaptureBtn');
    const retakeBtn = document.getElementById('caRetakeBtn');
    const uploadBtn = document.getElementById('caUploadBtn');
    const stopBtn = document.getElementById('caStopBtn');

    const analyzeForm = document.getElementById('caAnalyzeForm');
    const analyzeBtn = document.getElementById('caAnalyzeBtn');
    const queryInput = document.getElementById('caQuery');

    const virtualTryOnBtn =
        document.getElementById('caVirtualTryOnBtn');

    const downloadBtn =
        document.getElementById('caDownloadBtn');

    const shareBtn =
        document.getElementById('caShareBtn');

    const historyBtn =
        document.getElementById('caHistoryBtn');

    const resetBtn =
        document.getElementById('caResetBtn');

    const historyPanel =
        document.getElementById('caHistoryPanel');

    const historyClose =
        document.getElementById('caHistoryClose');

    const historyList =
        document.getElementById('caHistoryList');

    const loading =
        document.getElementById('caLoading');

    const results =
        document.getElementById('caResults');

    const alerts =
        document.querySelector('.ai-ca-alerts');


    /* ---------------------------------------------------------------------
     * STATE
     * ------------------------------------------------------------------ */

    let stream = null;
    let capturedBlob = null;
    let lastAnalysis = null;
    let lastRecommendations = [];

    let previewObjectUrl = null;

    let speechEnabled = true;
    let speechLanguage = 'en-IN';

    let isAnalyzing = false;


    /* ---------------------------------------------------------------------
     * CSRF
     * ------------------------------------------------------------------ */

    function csrfToken() {

        const meta = document.querySelector(
            'meta[name="csrf-token"]'
        );

        if (meta) {
            return meta.getAttribute('content') || '';
        }

        const csrfInput =
            document.querySelector(
                'input[name="_token"]'
            );

        return csrfInput
            ? csrfInput.value
            : '';
    }


    /* ---------------------------------------------------------------------
     * ESCAPE HTML
     * ------------------------------------------------------------------ */

    function escapeHtml(value) {

        if (
            value === null ||
            value === undefined
        ) {
            return '';
        }

        return String(value)
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    }


    /* ---------------------------------------------------------------------
     * ALERT
     * ------------------------------------------------------------------ */

    function showAlert(message, type = 'info') {

        if (!alerts) {
            console[type === 'danger' ? 'error' : 'log'](
                message
            );
            return;
        }

        alerts.innerHTML = `
            <div class="alert alert-${escapeHtml(type)} ai-ca-alert">
                ${escapeHtml(message)}
            </div>
        `;

        window.setTimeout(() => {

            const alertBox =
                alerts.querySelector('.ai-ca-alert');

            if (alertBox) {
                alertBox.remove();
            }

        }, 5000);
    }


    /* ---------------------------------------------------------------------
     * PREVIEW URL CLEANUP
     * ------------------------------------------------------------------ */

    function revokePreviewUrl() {

        if (previewObjectUrl) {

            URL.revokeObjectURL(
                previewObjectUrl
            );

            previewObjectUrl = null;
        }
    }


    /* ---------------------------------------------------------------------
     * CAMERA START
     * ------------------------------------------------------------------ */

    async function startCamera() {

        if (
            !navigator.mediaDevices ||
            !navigator.mediaDevices.getUserMedia
        ) {

            showAlert(
                'Camera is not supported by this browser. Please upload a photo instead.',
                'danger'
            );

            return;
        }

        try {

            stopCamera();

            if (loadingCamera) {
                loadingCamera.classList.remove(
                    'd-none'
                );
            }

            const constraints = {
                video: {
                    facingMode: {
                        ideal: 'user'
                    },
                    width: {
                        ideal: 1280
                    },
                    height: {
                        ideal: 720
                    }
                },
                audio: false
            };

            stream =
                await navigator.mediaDevices
                    .getUserMedia(constraints);

            if (!video) {
                stopCamera();
                throw new Error(
                    'Camera preview element was not found.'
                );
            }

            video.srcObject = stream;

            video.muted = true;
            video.playsInline = true;

            await video.play();

            if (placeholder) {
                placeholder.classList.add(
                    'd-none'
                );
            }

            if (uploadPreview) {

                uploadPreview.classList.remove(
                    'show'
                );

                uploadPreview.removeAttribute(
                    'src'
                );
            }

            if (startBtn) {
                startBtn.classList.add(
                    'd-none'
                );
            }

            if (captureBtn) {
                captureBtn.classList.remove(
                    'd-none'
                );
            }

            if (stopBtn) {
                stopBtn.classList.remove(
                    'd-none'
                );
            }

            if (retakeBtn) {
                retakeBtn.classList.add(
                    'd-none'
                );
            }

            if (loadingCamera) {
                loadingCamera.classList.add(
                    'd-none'
                );
            }

            showAlert(
                'Camera started. Position yourself clearly inside the frame.',
                'success'
            );

        } catch (error) {

            console.error(
                'SMART BASKET camera error:',
                error
            );

            stopCamera();

            if (loadingCamera) {
                loadingCamera.classList.add(
                    'd-none'
                );
            }

            let message =
                'Unable to access camera.';

            if (
                error &&
                error.name === 'NotAllowedError'
            ) {
                message =
                    'Camera permission was denied. Please allow camera access or upload a photo.';
            } else if (
                error &&
                error.name === 'NotFoundError'
            ) {
                message =
                    'No camera was found. Please connect a camera or upload a photo.';
            } else if (
                error &&
                error.name === 'NotReadableError'
            ) {
                message =
                    'Camera is already being used by another application.';
            }

            showAlert(
                message,
                'danger'
            );
        }
    }


    /* ---------------------------------------------------------------------
     * CAMERA STOP
     * ------------------------------------------------------------------ */

    function stopCamera() {

        if (stream) {

            stream.getTracks().forEach(
                track => {

                    try {
                        track.stop();
                    } catch (e) {
                        console.warn(e);
                    }

                }
            );

            stream = null;
        }

        if (video) {
            video.srcObject = null;
        }
    }


    /* ---------------------------------------------------------------------
     * CAPTURE PHOTO
     * ------------------------------------------------------------------ */

    function capturePhoto() {

        if (
            !video ||
            !video.videoWidth ||
            !video.videoHeight
        ) {

            showAlert(
                'Camera is not ready yet. Please wait a moment.',
                'warning'
            );

            return;
        }

        if (!canvas) {

            showAlert(
                'Capture system is not available.',
                'danger'
            );

            return;
        }

        canvas.width =
            video.videoWidth;

        canvas.height =
            video.videoHeight;

        const context =
            canvas.getContext('2d', {
                alpha: false
            });

        if (!context) {

            showAlert(
                'Unable to prepare the photo.',
                'danger'
            );

            return;
        }

        /*
         * Mirror compensation:
         * The preview may be mirrored through CSS,
         * but the AI should receive a normal image.
         */
        context.save();

        context.drawImage(
            video,
            0,
            0,
            canvas.width,
            canvas.height
        );

        context.restore();

        canvas.toBlob(
            blob => {

                if (!blob) {

                    showAlert(
                        'Unable to capture photo.',
                        'danger'
                    );

                    return;
                }

                capturedBlob = blob;

                revokePreviewUrl();

                previewObjectUrl =
                    URL.createObjectURL(
                        blob
                    );

                if (uploadPreview) {

                    uploadPreview.src =
                        previewObjectUrl;

                    uploadPreview.classList.add(
                        'show'
                    );
                }

                if (video) {
                    video.classList.add(
                        'd-none'
                    );
                }

                if (captureBtn) {
                    captureBtn.classList.add(
                        'd-none'
                    );
                }

                if (retakeBtn) {
                    retakeBtn.classList.remove(
                        'd-none'
                    );
                }

                showAlert(
                    'Photo captured successfully. You can now analyze your style.',
                    'success'
                );

            },
            'image/jpeg',
            0.92
        );
    }


    /* ---------------------------------------------------------------------
     * RETAKE
     * ------------------------------------------------------------------ */

    function retakePhoto() {

        capturedBlob = null;

        revokePreviewUrl();

        if (uploadPreview) {

            uploadPreview.removeAttribute(
                'src'
            );

            uploadPreview.classList.remove(
                'show'
            );
        }

        if (video) {
            video.classList.remove(
                'd-none'
            );
        }

        if (retakeBtn) {
            retakeBtn.classList.add(
                'd-none'
            );
        }

        if (captureBtn) {
            captureBtn.classList.remove(
                'd-none'
            );
        }

        showAlert(
            'Ready to capture another photo.',
            'info'
        );
    }


    /* ---------------------------------------------------------------------
     * UPLOAD
     * ------------------------------------------------------------------ */

    function openUpload() {

        if (fileInput) {
            fileInput.click();
        }
    }


    /* ---------------------------------------------------------------------
     * HANDLE UPLOAD
     * ------------------------------------------------------------------ */

    function handleUpload(event) {

        const file =
            event.target.files &&
            event.target.files[0];

        if (!file) {
            return;
        }

        if (!file.type.startsWith('image/')) {

            if (fileInput) {
                fileInput.value = '';
            }

            showAlert(
                'Please select a valid image file.',
                'danger'
            );

            return;
        }

        const maxSize =
            5 * 1024 * 1024;

        if (file.size > maxSize) {

            if (fileInput) {
                fileInput.value = '';
            }

            showAlert(
                'Image must be smaller than 5 MB.',
                'danger'
            );

            return;
        }

        capturedBlob = file;

        stopCamera();

        revokePreviewUrl();

        previewObjectUrl =
            URL.createObjectURL(
                file
            );

        if (video) {
            video.classList.add(
                'd-none'
            );
        }

        if (placeholder) {
            placeholder.classList.add(
                'd-none'
            );
        }

        if (startBtn) {
            startBtn.classList.remove(
                'd-none'
            );
        }

        if (captureBtn) {
            captureBtn.classList.add(
                'd-none'
            );
        }

        if (stopBtn) {
            stopBtn.classList.add(
                'd-none'
            );
        }

        if (retakeBtn) {
            retakeBtn.classList.remove(
                'd-none'
            );
        }

        if (uploadPreview) {

            uploadPreview.src =
                previewObjectUrl;

            uploadPreview.classList.add(
                'show'
            );
        }

        showAlert(
            'Photo uploaded successfully. You can now analyze it.',
            'success'
        );
    }


    /* ---------------------------------------------------------------------
     * IMAGE FILE
     * ------------------------------------------------------------------ */

    function getImageFile() {

        if (!capturedBlob) {
            return null;
        }

        if (
            typeof File !== 'undefined' &&
            capturedBlob instanceof File
        ) {
            return capturedBlob;
        }

        return new File(
            [capturedBlob],
            'ai-camera-photo.jpg',
            {
                type:
                    capturedBlob.type ||
                    'image/jpeg',
                lastModified:
                    Date.now()
            }
        );
    }


    /* ---------------------------------------------------------------------
     * ANALYZE
     * ------------------------------------------------------------------ */

    async function analyzeStyle(event) {

        if (event) {
            event.preventDefault();
        }

        if (isAnalyzing) {
            return;
        }

        const imageFile =
            getImageFile();

        if (!imageFile) {

            showAlert(
                'Please capture or upload a photo first.',
                'warning'
            );

            return;
        }

        const token =
            csrfToken();

        if (!token) {

            showAlert(
                'Security token is missing. Please refresh the page and try again.',
                'danger'
            );

            return;
        }

        const formData =
            new FormData();

        formData.append(
            'image',
            imageFile,
            imageFile.name ||
            'ai-camera-photo.jpg'
        );

        formData.append(
            'query',
            queryInput?.value?.trim() || ''
        );

        /*
         * Let Laravel know this is an AI request.
         */
        formData.append(
            'source',
            'ai_camera_assistant'
        );

        setLoading(true);

        isAnalyzing = true;

        try {

            const response =
                await fetch(
                    '/ai-camera-assistant',
                    {
                        method: 'POST',

                        headers: {
                            'X-CSRF-TOKEN':
                                token,

                            'X-Requested-With':
                                'XMLHttpRequest',

                            'Accept':
                                'application/json, text/html'
                        },

                        body: formData,

                        credentials: 'same-origin'
                    }
                );

            const contentType =
                (
                    response.headers.get(
                        'content-type'
                    ) || ''
                ).toLowerCase();

            /*
             * --------------------------------------------------------------
             * NON-OK RESPONSE
             * --------------------------------------------------------------
             */

            if (!response.ok) {

                let message =
                    `Server error (${response.status})`;

                if (
                    contentType.includes(
                        'application/json'
                    )
                ) {

                    try {

                        const errorData =
                            await response.json();

                        message =
                            errorData.message ||
                            message;

                        if (
                            errorData.errors &&
                            errorData.errors.image &&
                            errorData.errors.image[0]
                        ) {

                            message =
                                errorData.errors.image[0];
                        }

                    } catch (jsonError) {
                        console.warn(jsonError);
                    }

                } else {

                    const text =
                        await response.text();

                    if (
                        response.status === 419
                    ) {

                        message =
                            'Your session or CSRF token expired. Please refresh the page and try again.';

                    } else if (
                        response.status === 422
                    ) {

                        message =
                            'The uploaded image could not be validated. Please try another image.';

                    } else if (
                        response.status >= 500
                    ) {

                        message =
                            'Laravel server error occurred. Please check the Laravel logs.';
                    } else if (
                        text &&
                        text.length < 300
                    ) {

                        message =
                            text.replace(
                                /<[^>]*>/g,
                                ''
                            ).trim() ||
                            message;
                    }
                }

                throw new Error(
                    message
                );
            }


            /* ----------------------------------------------------------------
             * JSON RESPONSE
             * ---------------------------------------------------------------- */

            if (
                contentType.includes(
                    'application/json'
                )
            ) {

                const data =
                    await response.json();

                handleAnalysisResponse(
                    data
                );

                return;
            }


            /* ----------------------------------------------------------------
             * HTML RESPONSE
             * ---------------------------------------------------------------- */

            const html =
                await response.text();

            const parser =
                new DOMParser();

            const parsed =
                parser.parseFromString(
                    html,
                    'text/html'
                );

            /*
             * If Laravel returns a complete Blade page,
             * extract only the result area.
             */
            const newResults =
                parsed.querySelector(
                    '#caResults'
                );

            if (
                newResults &&
                results
            ) {

                results.innerHTML =
                    newResults.innerHTML;

                lastAnalysis = {
                    summary:
                        'AI style analysis completed.'
                };

                lastRecommendations = [];

                enableActionButtons();

                showAlert(
                    'AI style analysis completed successfully.',
                    'success'
                );

                speakAnalysis(
                    lastAnalysis
                );

                return;
            }

            /*
             * Fallback:
             * If there is no caResults in the returned page,
             * don't destroy the current page.
             */
            if (
                results &&
                html.trim()
            ) {

                showAlert(
                    'AI returned a page response, but the results section could not be identified.',
                    'warning'
                );

                console.warn(
                    'AI Camera HTML response did not contain #caResults.'
                );
            }

        } catch (error) {

            console.error(
                'SMART BASKET AI analysis error:',
                error
            );

            showAlert(
                error.message ||
                'AI analysis failed. Please try again.',
                'danger'
            );

        } finally {

            isAnalyzing = false;

            setLoading(false);
        }
    }


    /* ---------------------------------------------------------------------
     * HANDLE AI RESPONSE
     * ------------------------------------------------------------------ */

    function handleAnalysisResponse(data) {

        if (!data) {

            throw new Error(
                'Empty AI response received.'
            );
        }

        /*
         * Common Laravel response shapes:
         *
         * {
         *   analysis: {...},
         *   recommendations: [...]
         * }
         *
         * OR
         *
         * {
         *   data: {
         *      analysis: {...}
         *   }
         * }
         */

        let analysis =
            data.analysis ||
            data.data?.analysis ||
            data.result?.analysis ||
            data.data ||
            null;

        let recommendations =
            data.recommendations ||
            data.data?.recommendations ||
            data.result?.recommendations ||
            [];

        /*
         * If Laravel directly returns an analysis object.
         */
        if (
            !analysis &&
            (
                data.summary ||
                data.detection ||
                data.style_preference ||
                data.color_matching
            )
        ) {
            analysis = data;
        }

        if (!analysis) {

            const message =
                data.message ||
                'AI analysis result was not found in the server response.';

            throw new Error(
                message
            );
        }

        if (!Array.isArray(recommendations)) {
            recommendations = [];
        }

        lastAnalysis =
            analysis;

        lastRecommendations =
            recommendations;

        renderAnalysis(
            analysis,
            recommendations
        );

        enableActionButtons();

        showAlert(
            data.message ||
            'AI style analysis completed successfully.',
            'success'
        );

        speakAnalysis(
            analysis
        );
    }


    /* ---------------------------------------------------------------------
     * LOADING
     * ------------------------------------------------------------------ */

    function setLoading(active) {

        if (loading) {

            loading.classList.toggle(
                'd-none',
                !active
            );
        }

        if (!analyzeBtn) {
            return;
        }

        analyzeBtn.disabled =
            active;

        if (active) {

            analyzeBtn.innerHTML = `
                <i class="fa-solid fa-spinner fa-spin me-1"></i>
                AI is analyzing...
            `;

        } else {

            analyzeBtn.innerHTML = `
                <i class="fa-solid fa-wand-magic-sparkles me-1"></i>
                Analyze My Style
            `;
        }
    }


    /* ---------------------------------------------------------------------
     * ENABLE ACTION BUTTONS
     * ------------------------------------------------------------------ */

    function enableActionButtons() {

        if (virtualTryOnBtn) {
            virtualTryOnBtn.disabled =
                false;
        }

        if (downloadBtn) {
            downloadBtn.disabled =
                false;
        }

        if (shareBtn) {
            shareBtn.disabled =
                false;
        }
    }


    /* ---------------------------------------------------------------------
     * NORMALIZE VALUE
     * ------------------------------------------------------------------ */

    function safeText(value, fallback = '—') {

        if (
            value === null ||
            value === undefined ||
            value === ''
        ) {
            return fallback;
        }

        if (
            typeof value === 'object'
        ) {

            if (value.label) {
                return value.label;
            }

            if (value.name) {
                return value.name;
            }

            return fallback;
        }

        return String(value);
    }


    /* ---------------------------------------------------------------------
     * RENDER ANALYSIS
     * ------------------------------------------------------------------ */

    function renderAnalysis(
        analysis,
        recommendations = []
    ) {

        if (!results) {
            return;
        }

        analysis =
            analysis || {};

        const detection =
            analysis.detection || {};

        const skin =
            detection.skin_tone || {};

        const face =
            detection.face_shape || {};

        const gender =
            detection.gender || {};

        const age =
            detection.age_group || {};

        const style =
            analysis.style_preference || {};

        const colors =
            analysis.color_matching || {};

        const suitableColors =
            Array.isArray(
                colors.suitable_colors
            )
                ? colors.suitable_colors
                : [];

        const skinTone =
            safeText(
                skin.label ||
                analysis.face_features?.skin_tone
            );

        const faceShape =
            safeText(
                face.label
            );

        const genderLabel =
            safeText(
                gender.label
            );

        const ageLabel =
            safeText(
                age.label
            );

        const suggestedStyle =
            safeText(
                style.suggested_style,
                'casual'
            );

        const colorCategory =
            safeText(
                colors.color_category,
                'neutral'
            );

        const summary =
            safeText(
                analysis.summary,
                'AI style analysis completed.'
            );

        results.innerHTML = `
            <div class="ai-ca-analysis-result">

                <div class="ai-ca-detection-grid ai-ca-detection-grid-sm">

                    <div class="ai-ca-detection-item">
                        <i class="fa-solid fa-hand"></i>

                        <strong>
                            Skin Tone
                        </strong>

                        <span class="ai-ca-detect-label">
                            ${escapeHtml(skinTone)}
                        </span>

                        <small class="ai-ca-confidence">
                            Conf:
                            ${escapeHtml(
                                safeText(
                                    skin.confidence
                                )
                            )}%
                        </small>
                    </div>


                    <div class="ai-ca-detection-item">
                        <i class="fa-solid fa-face-smile"></i>

                        <strong>
                            Face Shape
                        </strong>

                        <span class="ai-ca-detect-label">
                            ${escapeHtml(faceShape)}
                        </span>

                        <small class="ai-ca-confidence">
                            Conf:
                            ${escapeHtml(
                                safeText(
                                    face.confidence
                                )
                            )}%
                        </small>
                    </div>


                    <div class="ai-ca-detection-item">
                        <i class="fa-solid fa-venus-mars"></i>

                        <strong>
                            Gender
                        </strong>

                        <span class="ai-ca-detect-label">
                            ${escapeHtml(genderLabel)}
                        </span>

                        <small class="ai-ca-confidence">
                            Conf:
                            ${escapeHtml(
                                safeText(
                                    gender.confidence
                                )
                            )}%
                        </small>
                    </div>


                    <div class="ai-ca-detection-item">
                        <i class="fa-solid fa-cake-candles"></i>

                        <strong>
                            Age
                        </strong>

                        <span class="ai-ca-detect-label">
                            ${escapeHtml(ageLabel)}
                        </span>

                        <small class="ai-ca-confidence">
                            Conf:
                            ${escapeHtml(
                                safeText(
                                    age.confidence
                                )
                            )}%
                        </small>
                    </div>

                </div>


                <div class="ai-ca-analysis-grid">

                    <div class="ai-ca-analysis-item">
                        <i class="fa-solid fa-face-smile"></i>

                        <strong>
                            Face
                        </strong>

                        <span>
                            ${escapeHtml(
                                skinTone
                            )}
                        </span>
                    </div>


                    <div class="ai-ca-analysis-item">
                        <i class="fa-solid fa-shirt"></i>

                        <strong>
                            Style
                        </strong>

                        <span>
                            ${escapeHtml(
                                suggestedStyle
                            )}
                        </span>
                    </div>


                    <div class="ai-ca-analysis-item">
                        <i class="fa-solid fa-palette"></i>

                        <strong>
                            Color
                        </strong>

                        <span>
                            ${escapeHtml(
                                colorCategory
                            )}
                            tones
                        </span>
                    </div>

                </div>


                ${
                    suitableColors.length
                        ? `
                            <div class="ai-ca-color-section mt-2">

                                <h4>
                                    <i class="fa-solid fa-palette me-1"></i>
                                    Suitable Colors
                                </h4>

                                <div class="ai-ca-color-chips">

                                    ${suitableColors
                                        .map(
                                            color => `
                                                <span class="ai-ca-color-chip">
                                                    ${escapeHtml(
                                                        safeText(
                                                            color,
                                                            ''
                                                        )
                                                    )}
                                                </span>
                                            `
                                        )
                                        .join('')
                                    }

                                </div>

                            </div>
                        `
                        : ''
                }


                <div class="ai-ca-summary">
                    <strong>
                        <i class="fa-solid fa-sparkles me-1"></i>
                        AI Recommendation
                    </strong>

                    <p>
                        ${escapeHtml(summary)}
                    </p>
                </div>


                ${
                    renderRecommendations(
                        recommendations
                    )
                }

            </div>
        `;
    }


    /* ---------------------------------------------------------------------
     * RECOMMENDATIONS
     * ------------------------------------------------------------------ */

    function renderRecommendations(
        recommendations
    ) {

        if (
            !Array.isArray(
                recommendations
            ) ||
            !recommendations.length
        ) {
            return '';
        }

        const validProducts =
            recommendations
                .map(item => {

                    if (
                        item &&
                        item.product
                    ) {
                        return item.product;
                    }

                    return item;
                })
                .filter(Boolean);

        if (!validProducts.length) {
            return '';
        }

        return `
            <div class="ai-ca-recommendations">

                <h3 class="ai-ca-section-title">
                    <i class="fa-solid fa-bag-shopping me-1"></i>
                    Recommended Products
                </h3>

                <div class="ai-drawer-products">

                    ${validProducts
                        .map(
                            product =>
                                renderProductCard(
                                    product
                                )
                        )
                        .join('')
                    }

                </div>

            </div>
        `;
    }


    /* ---------------------------------------------------------------------
     * PRODUCT CARD
     * ------------------------------------------------------------------ */

    function renderProductCard(
        product
    ) {

        const id =
            product.id;

        if (!id) {
            return '';
        }

        const name =
            safeText(
                product.name,
                'Product'
            );

        const priceNumber =
            Number(
                product.price || 0
            );

        const price =
            Number.isFinite(
                priceNumber
            )
                ? priceNumber.toFixed(2)
                : '0.00';

        let image =
            product.image ||
            product.product_image ||
            '';

        /*
         * Keep compatibility with existing
         * Smart Basket product storage.
         */
        if (image) {

            image =
                String(image)
                    .replace(
                        /^\/+/,
                        ''
                    );

            if (
                !image.startsWith(
                    'http://'
                ) &&
                !image.startsWith(
                    'https://'
                ) &&
                !image.startsWith(
                    '/'
                )
            ) {

                image =
                    `/products/${encodeURIComponent(
                        image
                    )}`;
            }
        }

        const viewUrl =
            `/products/${encodeURIComponent(
                id
            )}`;

        const cartUrl =
            `/cart/add/${encodeURIComponent(
                id
            )}`;

        return `
            <div
                class="ai-ca-product ai-ca-product-sm"
                data-product-id="${escapeHtml(id)}"
            >

                ${
                    image
                        ? `
                            <img
                                src="${escapeHtml(image)}"
                                alt="${escapeHtml(name)}"
                                loading="lazy"
                                onerror="this.style.display='none';"
                            >
                        `
                        : `
                            <div class="ai-ca-product-image-placeholder">
                                <i class="fa-solid fa-shirt"></i>
                            </div>
                        `
                }


                <div class="ai-ca-product-body">

                    <h4>
                        ${escapeHtml(name)}
                    </h4>

                    <b>
                        ₹${escapeHtml(price)}
                    </b>


                    <div class="ai-ca-product-btn-group">

                        <form
                            action="${escapeHtml(cartUrl)}"
                            method="POST"
                            class="d-inline ai-ca-cart-form"
                        >

                            <input
                                type="hidden"
                                name="_token"
                                value="${escapeHtml(
                                    csrfToken()
                                )}"
                            >

                            <button
                                type="submit"
                                class="btn btn-sm btn-outline-primary"
                            >
                                <i class="fa-solid fa-cart-plus me-1"></i>
                                Cart
                            </button>

                        </form>


                        <a
                            href="${escapeHtml(viewUrl)}"
                            class="btn btn-sm btn-primary"
                        >
                            <i class="fa-solid fa-eye me-1"></i>
                            View
                        </a>

                    </div>

                </div>

            </div>
        `;
    }


    /* ---------------------------------------------------------------------
     * CART AJAX ENHANCEMENT
     * ------------------------------------------------------------------ */

    document.addEventListener(
        'submit',
        async event => {

            const form =
                event.target.closest(
                    '.ai-ca-cart-form'
                );

            if (!form) {
                return;
            }

            /*
             * Preserve normal Laravel behavior.
             * We intentionally don't hijack the form because
             * existing cart/session handling should remain compatible.
             */
        }
    );


    /* ---------------------------------------------------------------------
     * HISTORY
     * ------------------------------------------------------------------ */

    async function loadHistory() {

        if (!historyList) {
            return;
        }

        historyList.innerHTML =
            `
                <span class="ai-ca-empty">
                    Loading history...
                </span>
            `;

        try {

            const response =
                await fetch(
                    '/ai-camera-assistant/history?sidebar=1',
                    {
                        method: 'GET',

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

            const parser =
                new DOMParser();

            const doc =
                parser.parseFromString(
                    html,
                    'text/html'
                );

            const historyContent =
                doc.querySelector(
                    '#caHistoryList'
                );

            if (historyContent) {

                historyList.innerHTML =
                    historyContent.innerHTML;

            } else {

                historyList.innerHTML =
                    html ||
                    `
                        <span class="ai-ca-empty">
                            No history found.
                        </span>
                    `;
            }

        } catch (error) {

            console.error(
                'History error:',
                error
            );

            historyList.innerHTML =
                `
                    <span class="ai-ca-empty">
                        Unable to load history.
                    </span>
                `;
        }
    }


    /* ---------------------------------------------------------------------
     * HISTORY TOGGLE
     * ------------------------------------------------------------------ */

    function toggleHistory() {

        if (!historyPanel) {
            return;
        }

        const isHidden =
            historyPanel.classList.contains(
                'd-none'
            );

        historyPanel.classList.toggle(
            'd-none'
        );

        if (isHidden) {
            loadHistory();
        }
    }


    /* ---------------------------------------------------------------------
     * RESET
     * ------------------------------------------------------------------ */

    function resetAssistant() {

        stopCamera();

        capturedBlob = null;
        lastAnalysis = null;
        lastRecommendations = [];

        revokePreviewUrl();

        if (fileInput) {
            fileInput.value = '';
        }

        if (video) {

            video.srcObject = null;

            video.classList.remove(
                'd-none'
            );
        }

        if (placeholder) {
            placeholder.classList.remove(
                'd-none'
            );
        }

        if (uploadPreview) {

            uploadPreview.removeAttribute(
                'src'
            );

            uploadPreview.classList.remove(
                'show'
            );
        }

        if (startBtn) {
            startBtn.classList.remove(
                'd-none'
            );
        }

        if (captureBtn) {
            captureBtn.classList.add(
                'd-none'
            );
        }

        if (retakeBtn) {
            retakeBtn.classList.add(
                'd-none'
            );
        }

        if (stopBtn) {
            stopBtn.classList.add(
                'd-none'
            );
        }

        if (virtualTryOnBtn) {
            virtualTryOnBtn.disabled =
                true;
        }

        if (downloadBtn) {
            downloadBtn.disabled =
                true;
        }

        if (shareBtn) {
            shareBtn.disabled =
                true;
        }

        if (results) {

            results.innerHTML = `
                <div class="ai-ca-empty">

                    <i class="fa-solid fa-sparkles"></i>

                    <p>
                        Capture or upload a photo to see personalized AI recommendations.
                    </p>

                </div>
            `;
        }

        stopSpeaking();

        showAlert(
            'AI Camera Assistant has been reset.',
            'info'
        );
    }


    /* ---------------------------------------------------------------------
     * DOWNLOAD RESULT
     * ------------------------------------------------------------------ */

    function downloadResult() {

        if (!lastAnalysis) {

            showAlert(
                'Please analyze your style first.',
                'warning'
            );

            return;
        }

        const content =
            results?.innerText ||
            buildAnalysisText(
                lastAnalysis
            );

        const finalText =
            [
                'SMART BASKET',
                'AI STYLE ANALYSIS',
                '',
                content
            ].join('\n');

        const blob =
            new Blob(
                [finalText],
                {
                    type:
                        'text/plain;charset=utf-8'
                }
            );

        const url =
            URL.createObjectURL(
                blob
            );

        const link =
            document.createElement(
                'a'
            );

        link.href = url;

        link.download =
            'smart-basket-ai-style-analysis.txt';

        document.body.appendChild(
            link
        );

        link.click();

        link.remove();

        URL.revokeObjectURL(
            url
        );

        showAlert(
            'AI style analysis downloaded successfully.',
            'success'
        );
    }


    /* ---------------------------------------------------------------------
     * BUILD ANALYSIS TEXT
     * ------------------------------------------------------------------ */

    function buildAnalysisText(
        analysis
    ) {

        if (!analysis) {
            return '';
        }

        const detection =
            analysis.detection || {};

        const skin =
            detection.skin_tone || {};

        const face =
            detection.face_shape || {};

        const style =
            analysis.style_preference || {};

        const colors =
            analysis.color_matching || {};

        const suitableColors =
            Array.isArray(
                colors.suitable_colors
            )
                ? colors.suitable_colors
                : [];

        return [
            `Skin Tone: ${safeText(skin.label)}`,
            `Face Shape: ${safeText(face.label)}`,
            `Style: ${safeText(style.suggested_style)}`,
            `Color Category: ${safeText(colors.color_category)}`,
            suitableColors.length
                ? `Suitable Colors: ${suitableColors.join(', ')}`
                : '',
            '',
            `Summary: ${safeText(analysis.summary)}`
        ]
            .filter(Boolean)
            .join('\n');
    }


    /* ---------------------------------------------------------------------
     * SHARE
     * ------------------------------------------------------------------ */

    async function shareResult() {

        if (!lastAnalysis) {

            showAlert(
                'Please analyze your style first.',
                'warning'
            );

            return;
        }

        const text =
            buildAnalysisText(
                lastAnalysis
            ) ||
            results?.innerText ||
            'My Smart Basket AI Style Analysis';

        try {

            if (
                navigator.share
            ) {

                await navigator.share({
                    title:
                        'Smart Basket AI Style Analysis',

                    text
                });

                return;
            }

            if (
                navigator.clipboard &&
                navigator.clipboard.writeText
            ) {

                await navigator.clipboard.writeText(
                    text
                );

                showAlert(
                    'AI style analysis copied to clipboard.',
                    'success'
                );

                return;
            }

            showAlert(
                'Sharing is not supported by this browser.',
                'warning'
            );

        } catch (error) {

            /*
             * User cancelling native share is not an error
             * that needs to be displayed.
             */
            if (
                error &&
                error.name === 'AbortError'
            ) {
                return;
            }

            console.error(
                'Share error:',
                error
            );

            showAlert(
                'Unable to share the AI analysis.',
                'danger'
            );
        }
    }


    /* ---------------------------------------------------------------------
     * VIRTUAL TRY-ON
     * ------------------------------------------------------------------ */

    function openVirtualTryOn() {

        if (!capturedBlob) {

            showAlert(
                'Please capture or upload a photo first.',
                'warning'
            );

            return;
        }

        /*
         * Keep the captured image available during
         * same-origin navigation.
         *
         * We don't put the image in the URL.
         */
        try {

            const reader =
                new FileReader();

            reader.onload = () => {

                try {

                    sessionStorage.setItem(
                        'smartBasketVirtualTryOnImage',
                        reader.result
                    );

                } catch (storageError) {

                    console.warn(
                        'Unable to cache image for Virtual Try-On:',
                        storageError
                    );
                }

                window.location.href =
                    '/ai-camera-assistant/virtual-try-on';
            };

            reader.onerror = () => {

                window.location.href =
                    '/ai-camera-assistant/virtual-try-on';
            };

            reader.readAsDataURL(
                capturedBlob
            );

        } catch (error) {

            console.warn(
                error
            );

            window.location.href =
                '/ai-camera-assistant/virtual-try-on';
        }
    }


    /* ---------------------------------------------------------------------
     * VOICE / TEXT-TO-SPEECH
     * ------------------------------------------------------------------ */

    function detectSpeechLanguage() {

        /*
         * Use a language saved by the page if available.
         */
        const htmlLanguage =
            document.documentElement
                ?.getAttribute('lang');

        const storedLanguage =
            localStorage.getItem(
                'smartBasketLanguage'
            );

        const candidate =
            storedLanguage ||
            htmlLanguage ||
            'en-IN';

        const normalized =
            String(candidate)
                .toLowerCase();

        if (
            normalized.startsWith(
                'hi'
            )
        ) {
            return 'hi-IN';
        }

        if (
            normalized.startsWith(
                'gu'
            )
        ) {
            return 'gu-IN';
        }

        if (
            normalized.startsWith(
                'mr'
            )
        ) {
            return 'mr-IN';
        }

        if (
            normalized.startsWith(
                'bn'
            )
        ) {
            return 'bn-IN';
        }

        return 'en-IN';
    }


    function stopSpeaking() {

        if (
            'speechSynthesis' in
            window
        ) {

            window.speechSynthesis.cancel();
        }
    }


    function speakText(
        text,
        language = null
    ) {

        if (!speechEnabled) {
            return;
        }

        if (
            !('speechSynthesis' in window)
        ) {
            return;
        }

        if (!text) {
            return;
        }

        stopSpeaking();

        const utterance =
            new SpeechSynthesisUtterance(
                text
            );

        speechLanguage =
            language ||
            detectSpeechLanguage();

        utterance.lang =
            speechLanguage;

        utterance.rate =
            0.95;

        utterance.pitch =
            1;

        utterance.volume =
            1;

        /*
         * Try to find a voice matching the language.
         */
        const voices =
            window.speechSynthesis
                .getVoices();

        if (voices.length) {

            const preferred =
                voices.find(
                    voice =>
                        voice.lang
                            .toLowerCase()
                            .startsWith(
                                speechLanguage
                                    .split('-')[0]
                            )
                );

            if (preferred) {
                utterance.voice =
                    preferred;
            }
        }

        window.speechSynthesis.speak(
            utterance
        );
    }


    function speakAnalysis(
        analysis
    ) {

        if (!analysis) {
            return;
        }

        const detection =
            analysis.detection || {};

        const skin =
            detection.skin_tone || {};

        const face =
            detection.face_shape || {};

        const style =
            analysis.style_preference || {};

        const colors =
            analysis.color_matching || {};

        const suitableColors =
            Array.isArray(
                colors.suitable_colors
            )
                ? colors.suitable_colors
                : [];

        const language =
            detectSpeechLanguage();

        let speech = '';

        if (
            language === 'hi-IN'
        ) {

            speech =
                `आपके AI स्टाइल विश्लेषण के अनुसार, ` +
                `आपकी स्किन टोन ${safeText(skin.label, 'नहीं मिली')} है। ` +
                `फेस शेप ${safeText(face.label, 'नहीं मिला')} है। ` +
                `आपके लिए ${safeText(style.suggested_style, 'कैजुअल')} स्टाइल अच्छा रहेगा। ` +
                `उपयुक्त कलर ${suitableColors.length
                    ? suitableColors.join(', ')
                    : safeText(colors.color_category, 'न्यूट्रल')} हैं। ` +
                `${safeText(analysis.summary, '')}`;

        } else if (
            language === 'gu-IN'
        ) {

            speech =
                `તમારા AI સ્ટાઇલ વિશ્લેષણ અનુસાર, ` +
                `તમારો સ્કિન ટોન ${safeText(skin.label, 'મળ્યો નથી')} છે. ` +
                `તમારો ફેસ શેપ ${safeText(face.label, 'મળ્યો નથી')} છે. ` +
                `તમારા માટે ${safeText(style.suggested_style, 'કેઝ્યુઅલ')} સ્ટાઇલ યોગ્ય રહેશે. ` +
                `તમારા માટે યોગ્ય રંગો ${suitableColors.length
                    ? suitableColors.join(', ')
                    : safeText(colors.color_category, 'ન્યુટ્રલ')} છે. ` +
                `${safeText(analysis.summary, '')}`;

        } else {

            speech =
                `Your AI style analysis is complete. ` +
                `Your skin tone is ${safeText(skin.label, 'not detected')}. ` +
                `Your face shape is ${safeText(face.label, 'not detected')}. ` +
                `A ${safeText(style.suggested_style, 'casual')} style may suit you. ` +
                `Recommended colors are ${
                    suitableColors.length
                        ? suitableColors.join(', ')
                        : safeText(
                            colors.color_category,
                            'neutral'
                        )
                }. ` +
                `${safeText(analysis.summary, '')}`;
        }

        /*
         * Prevent excessively long browser speech.
         */
        speech =
            speech
                .replace(/\s+/g, ' ')
                .trim();

        if (speech.length > 900) {
            speech =
                speech.substring(
                    0,
                    900
                ) + '...';
        }

        speakText(
            speech,
            language
        );
    }


    /* ---------------------------------------------------------------------
     * VOICE CONTROL
     * ------------------------------------------------------------------ */

    function initializeSpeech() {

        if (
            !('speechSynthesis' in window)
        ) {
            return;
        }

        /*
         * Chrome may populate voices asynchronously.
         */
        window.speechSynthesis.onvoiceschanged =
            () => {
                window.speechSynthesis
                    .getVoices();
            };
    }


    /* ---------------------------------------------------------------------
     * EVENTS
     * ------------------------------------------------------------------ */

    startBtn?.addEventListener(
        'click',
        startCamera
    );

    captureBtn?.addEventListener(
        'click',
        capturePhoto
    );

    retakeBtn?.addEventListener(
        'click',
        retakePhoto
    );

    uploadBtn?.addEventListener(
        'click',
        openUpload
    );

    stopBtn?.addEventListener(
        'click',
        () => {

            stopCamera();

            if (startBtn) {
                startBtn.classList.remove(
                    'd-none'
                );
            }

            if (captureBtn) {
                captureBtn.classList.add(
                    'd-none'
                );
            }

            if (stopBtn) {
                stopBtn.classList.add(
                    'd-none'
                );
            }

            showAlert(
                'Camera stopped.',
                'info'
            );
        }
    );

    fileInput?.addEventListener(
        'change',
        handleUpload
    );

    analyzeForm?.addEventListener(
        'submit',
        analyzeStyle
    );

    historyBtn?.addEventListener(
        'click',
        toggleHistory
    );

    historyClose?.addEventListener(
        'click',
        () => {

            historyPanel?.classList.add(
                'd-none'
            );
        }
    );

    resetBtn?.addEventListener(
        'click',
        resetAssistant
    );

    downloadBtn?.addEventListener(
        'click',
        downloadResult
    );

    shareBtn?.addEventListener(
        'click',
        shareResult
    );

    virtualTryOnBtn?.addEventListener(
        'click',
        openVirtualTryOn
    );


    /* ---------------------------------------------------------------------
     * OPTIONAL GLOBAL VOICE CONTROLS
     * ------------------------------------------------------------------ */

    document.addEventListener(
        'click',
        event => {

            const speakButton =
                event.target.closest(
                    '[data-ai-speak]'
                );

            if (
                speakButton &&
                lastAnalysis
            ) {

                speakAnalysis(
                    lastAnalysis
                );
            }

            const stopVoiceButton =
                event.target.closest(
                    '[data-ai-stop-voice]'
                );

            if (stopVoiceButton) {
                stopSpeaking();
            }

            const voiceToggle =
                event.target.closest(
                    '[data-ai-voice-toggle]'
                );

            if (voiceToggle) {

                speechEnabled =
                    !speechEnabled;

                voiceToggle.setAttribute(
                    'aria-pressed',
                    speechEnabled
                        ? 'true'
                        : 'false'
                );

                if (!speechEnabled) {
                    stopSpeaking();
                }
            }
        }
    );


    /* ---------------------------------------------------------------------
     * INITIAL STATE
     * ------------------------------------------------------------------ */

    function initialize() {

        initializeSpeech();

        if (virtualTryOnBtn) {
            virtualTryOnBtn.disabled =
                !capturedBlob;
        }

        if (downloadBtn) {
            downloadBtn.disabled =
                !lastAnalysis;
        }

        if (shareBtn) {
            shareBtn.disabled =
                !lastAnalysis;
        }

        /*
         * Prevent accidental browser submission
         * if the analyze form is missing a button type.
         */
        if (analyzeForm) {

            analyzeForm.setAttribute(
                'enctype',
                'multipart/form-data'
            );
        }

        /*
         * Keep the camera off until the user explicitly
         * presses Start Camera.
         */
        stopCamera();
    }

    initialize();


    /* ---------------------------------------------------------------------
     * CLEANUP
     * ------------------------------------------------------------------ */

    window.addEventListener(
        'beforeunload',
        () => {

            stopCamera();

            stopSpeaking();

            revokePreviewUrl();
        }
    );

    window.addEventListener(
        'pagehide',
        () => {

            stopCamera();

            stopSpeaking();

            revokePreviewUrl();
        }
    );

});