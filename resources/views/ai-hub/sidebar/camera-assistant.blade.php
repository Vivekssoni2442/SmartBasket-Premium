<link rel="stylesheet" href="{{ asset('css/ai-camera-assistant.css') }}">
<div class="ai-panel-fragment">
    <h2>📷 AI Camera Assistant</h2>
    <p>Show your face & full body to the camera — get AI outfit recommendations.</p>

    <div class="ai-ca-privacy ai-ca-privacy-sm">
        <i class="fa-solid fa-shield-halved"></i>
        <span>Your image is processed in memory only and never saved.</span>
    </div>

<div class="ai-ca-alerts"></div>

    <div class="ai-ca-viewport ai-ca-viewport-sm" id="caViewport">
        <video id="caVideo" autoplay playsinline muted></video>
        <div class="ai-ca-placeholder" id="caPlaceholder">
            <i class="fa-solid fa-user-large"></i>
            <p>Start camera or upload a photo.</p>
        </div>
        <canvas id="caCanvas" class="d-none"></canvas>
        <div class="ai-ca-cam-loading d-none" id="caCamLoading">
            <div class="ai-ca-loader"><span></span><span></span><span></span><span></span><span></span></div>
            <p>Starting camera...</p>
        </div>
    </div>

    <input type="file" id="caFile" accept="image/jpeg,image/png,image/webp" class="d-none">
    <img id="caUploadPreview" class="ai-ca-upload-preview" alt="Uploaded preview">

    <div class="ai-ca-capture-tools ai-ca-capture-tools-sm">
        <button type="button" class="btn btn-primary btn-sm" id="caStartBtn"><i class="fa-solid fa-video me-1"></i> Start</button>
        <button type="button" class="btn btn-warning btn-sm d-none" id="caCaptureBtn"><i class="fa-solid fa-camera me-1"></i> Capture</button>
        <button type="button" class="btn btn-info btn-sm d-none" id="caRetakeBtn"><i class="fa-solid fa-rotate-right me-1"></i> Retake</button>
        <button type="button" class="btn btn-outline-secondary btn-sm" id="caUploadBtn"><i class="fa-solid fa-upload"></i></button>
        <button type="button" class="btn btn-danger btn-sm d-none" id="caStopBtn"><i class="fa-solid fa-stop"></i></button>
    </div>

<form id="caAnalyzeForm" class="ai-ca-query-form mt-2">
        <input type="text" id="caQuery" name="query" class="form-control form-control-sm mb-2" placeholder="Ask AI (e.g. best outfit)">
        <button type="submit" class="btn btn-primary btn-sm w-100" id="caAnalyzeBtn"><i class="fa-solid fa-wand-magic-sparkles me-1"></i> Analyze My Style</button>
    </form>

    <div class="ai-ca-actions ai-ca-actions-sm">
        <button type="button" class="btn btn-info btn-sm" id="caVirtualTryOnBtn" disabled><i class="fa-solid fa-wand-magic-sparkles me-1"></i> Try-On</button>
        <button type="button" class="btn btn-success btn-sm" id="caDownloadBtn" disabled><i class="fa-solid fa-file-pdf me-1"></i> PDF</button>
        <button type="button" class="btn btn-warning btn-sm" id="caShareBtn" disabled><i class="fa-solid fa-share-nodes me-1"></i> Share</button>
        <button type="button" class="btn btn-outline-secondary btn-sm" id="caHistoryBtn"><i class="fa-solid fa-clock-rotate-left me-1"></i> History</button>
        <button type="button" class="btn btn-danger btn-sm" id="caResetBtn"><i class="fa-solid fa-rotate-left me-1"></i> Reset</button>
    </div>

    <div class="ai-ca-history mt-2 d-none" id="caHistoryPanel">
        <div class="ai-ca-history-head">
            <h4><i class="fa-solid fa-clock-rotate-left me-1"></i> History</h4>
            <button type="button" class="btn-close btn-close-white" id="caHistoryClose" aria-label="Close"></button>
        </div>
        <div id="caHistoryList"><span class="ai-ca-empty">Loading history...</span></div>
    </div>

    <div class="ai-ca-loading d-none" id="caLoading">
        <div class="ai-ca-loader"><span></span><span></span><span></span><span></span><span></span></div>
        <p>AI is analyzing your style...</p>
    </div>

    <div id="caResults" class="ai-ca-results ai-ca-results-sm">
        @if($analysis)
            <div class="ai-ca-detection-grid ai-ca-detection-grid-sm">
                <div class="ai-ca-detection-item">
                    <i class="fa-solid fa-hand"></i><strong>Skin Tone</strong>
                    <span class="ai-ca-detect-label">{{ ucfirst($analysis['detection']['skin_tone']['label'] ?? '—') }}</span>
                    <small class="ai-ca-confidence">Conf: {{ $analysis['detection']['skin_tone']['confidence'] ?? '—' }}%</small>
                </div>
                <div class="ai-ca-detection-item">
                    <i class="fa-solid fa-face-smile"></i><strong>Face Shape</strong>
                    <span class="ai-ca-detect-label">{{ ucfirst($analysis['detection']['face_shape']['label'] ?? '—') }}</span>
                    <small class="ai-ca-confidence">Conf: {{ $analysis['detection']['face_shape']['confidence'] ?? '—' }}%</small>
                </div>
                <div class="ai-ca-detection-item">
                    <i class="fa-solid fa-venus-mars"></i><strong>Gender</strong>
                    <span class="ai-ca-detect-label">{{ $analysis['detection']['gender']['label'] ?? '—' }}</span>
                    <small class="ai-ca-confidence">Conf: {{ $analysis['detection']['gender']['confidence'] ?? '—' }}%</small>
                </div>
                <div class="ai-ca-detection-item">
                    <i class="fa-solid fa-cake-candles"></i><strong>Age</strong>
                    <span class="ai-ca-detect-label">{{ $analysis['detection']['age_group']['label'] ?? '—' }}</span>
                    <small class="ai-ca-confidence">Conf: {{ $analysis['detection']['age_group']['confidence'] ?? '—' }}%</small>
                </div>
            </div>
            <div class="ai-ca-analysis-grid">
                <div class="ai-ca-analysis-item">
                    <i class="fa-solid fa-face-smile"></i><strong>Face</strong>
                    <span>{{ $analysis['face_features']['skin_tone'] ?? '—' }} tone</span>
                </div>
                <div class="ai-ca-analysis-item">
                    <i class="fa-solid fa-shirt"></i><strong>Style</strong>
                    <span>{{ ucfirst($analysis['style_preference']['suggested_style'] ?? 'casual') }}</span>
                </div>
                <div class="ai-ca-analysis-item">
                    <i class="fa-solid fa-palette"></i><strong>Color</strong>
                    <span>{{ ucfirst($analysis['color_matching']['color_category'] ?? 'neutral') }} tones</span>
                </div>
            </div>
            @if(collect($analysis['color_matching']['suitable_colors'] ?? [])->isNotEmpty())
                <div class="ai-ca-color-section mt-2">
                    <h4><i class="fa-solid fa-palette me-1"></i> Suitable Colors</h4>
                    <div class="ai-ca-color-chips">
                        @foreach($analysis['color_matching']['suitable_colors'] as $color)
                            <span class="ai-ca-color-chip">{{ $color }}</span>
                        @endforeach
                    </div>
                </div>
            @endif
            <p class="ai-ca-summary">{{ $analysis['summary'] ?? '' }}</p>
        @else
            <div class="ai-ca-empty">
                <i class="fa-solid fa-sparkles"></i>
                <p>Capture or upload a photo to see recommendations.</p>
            </div>
        @endif

        @if($recommendations->isNotEmpty())
            <h3 class="ai-ca-section-title"><i class="fa-solid fa-bag-shopping me-1"></i> Recommended</h3>
            <div class="ai-drawer-products">
                @foreach($recommendations as $item)
                    @php $product = $item['product']; @endphp
                    <div class="ai-ca-product ai-ca-product-sm">
                        <img src="{{ asset('products/' . $product->image) }}" alt="{{ $product->name }}">
                        <div class="ai-ca-product-body">
                            <h4>{{ $product->name }}</h4>
                            <b>₹{{ number_format((float) $product->price, 2) }}</b>
                            <div class="ai-ca-product-btn-group">
                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-cart-plus me-1"></i> Cart</button>
                                </form>
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-primary"><i class="fa-solid fa-eye me-1"></i> View</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<script src="{{ asset('js/ai-camera-assistant.js') }}" defer></script>
