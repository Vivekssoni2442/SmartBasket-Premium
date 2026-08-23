document.addEventListener('DOMContentLoaded', () => {

    const fileInput = document.getElementById('tryOnImage');
    const uploadBtn = document.getElementById('uploadTryOnBtn');
    const cameraBtn = document.getElementById('cameraTryOnBtn');
    const generateBtn = document.getElementById('generateTryOnBtn');

    const previewBox = document.getElementById('tryOnPreviewBox');
    const preview = document.getElementById('tryOnPreview');

    const camera = document.getElementById('tryOnCamera');
    const canvas = document.getElementById('tryOnCanvas');

    const loading = document.getElementById('tryOnLoading');
    const errorBox = document.getElementById('tryOnError');

    const resultBox = document.getElementById('tryOnResult');
    const resultImage = document.getElementById('tryOnResultImage');

    const productId = document.getElementById('tryOnProductId');

    let selectedFile = null;
    let stream = null;

    function showError(message) {
        errorBox.textContent = message;
        errorBox.classList.remove('hidden');
    }

    function clearError() {
        errorBox.textContent = '';
        errorBox.classList.add('hidden');
    }

    function setLoading(status) {
        if (status) {
            loading.classList.remove('hidden');
            generateBtn.disabled = true;
        } else {
            loading.classList.add('hidden');
            generateBtn.disabled = false;
        }
    }

    uploadBtn?.addEventListener('click', () => {
        fileInput?.click();
    });

    fileInput?.addEventListener('change', () => {

        clearError();

        const file = fileInput.files?.[0];

        if (!file) {
            return;
        }

        const allowedTypes = [
            'image/jpeg',
            'image/png',
            'image/webp'
        ];

        if (!allowedTypes.includes(file.type)) {
            showError(
                'Please select a JPG, PNG, or WebP image.'
            );
            fileInput.value = '';
            return;
        }

        if (file.size > 10 * 1024 * 1024) {
            showError(
                'Image must be smaller than 10 MB.'
            );
            fileInput.value = '';
            return;
        }

        selectedFile = file;

        const objectUrl = URL.createObjectURL(file);

        preview.src = objectUrl;
        previewBox.classList.remove('hidden');

        generateBtn.classList.remove('hidden');

        resultBox.classList.add('hidden');
    });

    cameraBtn?.addEventListener('click', async () => {

        clearError();

        try {

            stream = await navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: 'user'
                },
                audio: false
            });

            camera.srcObject = stream;

            camera.classList.remove('hidden');

            generateBtn.classList.remove('hidden');

            cameraBtn.textContent = '📸 Capture Photo';

            cameraBtn.dataset.cameraActive = 'true';

        } catch (error) {

            console.error(error);

            showError(
                'Camera permission was denied or camera is unavailable.'
            );
        }
    });

    cameraBtn?.addEventListener('click', () => {

        if (cameraBtn.dataset.cameraActive !== 'true') {
            return;
        }

        if (!stream) {
            return;
        }

        canvas.width = camera.videoWidth;
        canvas.height = camera.videoHeight;

        const context = canvas.getContext('2d');

        context.drawImage(
            camera,
            0,
            0,
            canvas.width,
            canvas.height
        );

        canvas.toBlob((blob) => {

            if (!blob) {
                showError('Unable to capture camera image.');
                return;
            }

            selectedFile = new File(
                [blob],
                'camera-photo.jpg',
                {
                    type: 'image/jpeg'
                }
            );

            preview.src = URL.createObjectURL(selectedFile);

            previewBox.classList.remove('hidden');

            generateBtn.classList.remove('hidden');

            if (stream) {
                stream.getTracks().forEach(track => track.stop());
                stream = null;
            }

            camera.classList.add('hidden');

            cameraBtn.textContent = '🎥 Use Camera';
            cameraBtn.dataset.cameraActive = 'false';

        }, 'image/jpeg', 0.92);
    });

    generateBtn?.addEventListener('click', async () => {

        clearError();

        if (!selectedFile) {
            showError(
                'Please upload or capture a photo first.'
            );
            return;
        }

        const id = productId?.value;

        if (!id) {
            showError(
                'Product information is missing.'
            );
            return;
        }

       const form = document.getElementById('tryOnForm');

if (!form) {
    showError('Virtual Try-On form is missing.');
    return;
}

const formData = new FormData(form);

// Make sure the selected/captured photo is submitted
formData.set('photo', selectedFile);

setLoading(true);

try {

    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute('content');

    const response = await fetch(
        form.action,
        {
            method: 'POST',

            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },

            body: formData
        }
    );B

            /*
             * IMPORTANT:
             *
             * Do NOT blindly do:
             *
             * await response.json()
             *
             * because Laravel can sometimes return HTML.
             */

            const contentType =
                response.headers.get('content-type') || '';

            const rawResponse = await response.text();

            let data = null;

            if (contentType.includes('application/json')) {

                try {
                    data = JSON.parse(rawResponse);

                } catch (jsonError) {

                    console.error(
                        'Invalid JSON response:',
                        rawResponse
                    );

                    throw new Error(
                        'Server returned invalid JSON.'
                    );
                }

            } else {

                console.error(
                    'Non-JSON server response:',
                    rawResponse
                );

                if (response.status === 419) {
                    throw new Error(
                        'Session expired. Please refresh the page and try again.'
                    );
                }

                if (response.status === 404) {
                    throw new Error(
                        'Virtual Try-On endpoint was not found.'
                    );
                }

                if (response.status === 405) {
                    throw new Error(
                        'Invalid request method for Virtual Try-On.'
                    );
                }

                throw new Error(
                    'Server returned an unexpected response.'
                );
            }

            if (!response.ok || !data?.success) {

                throw new Error(
                    data?.message ||
                    'Virtual Try-On failed.'
                );
            }

            /*
             * SUCCESS
             */

            if (data.result_image) {

                resultImage.src = data.result_image;

                resultBox.classList.remove('hidden');

                resultBox.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }

        } catch (error) {

            console.error(
                'Virtual Try-On:',
                error
            );

            showError(
                error.message ||
                'Something went wrong while creating the virtual preview.'
            );

        } finally {

            setLoading(false);
        }
    });

});