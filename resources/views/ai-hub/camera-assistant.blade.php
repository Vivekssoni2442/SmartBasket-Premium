<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AI Camera Assistant | Smart Basket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/premium-dark-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ai-hub-dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ai-camera-assistant.css') }}">
</head>
<body>
<div class="ai-hub-layout">
    @include('ai-hub.partials.navigation')
    <main class="ai-hub-main">
        <header class="ai-hub-heading ai-ca-heading">
            <div>
                <span class="ai-hub-eyebrow">Virtual Style & Product Recommendation</span>
                <h1>AI Camera Assistant 📷</h1>
                <p>Show your face & full body to the camera — AI will suggest the best Smart Basket outfits for you.</p>
            </div>
            <a href="{{ route('products.index') }}" class="btn btn-outline-primary"><i class="fa-solid fa-store me-1"></i> Browse products</a>
        </header>

        @if(session('success'))
            <div class="alert alert-success"><i class="fa-solid fa-circle-check me-1"></i> {{ session('success') }}</div>
        @endif

        <!-- Privacy notice -->
        <div class="ai-ca-privacy">
            <i class="fa-solid fa-shield-halved"></i>
            <div>
                <strong>Your privacy matters.</strong>
                <span>Your image is processed in memory only and <em>never saved</em> to our servers or database. It is deleted immediately after analysis.</span>
            </div>
        </div>

        <div class="row g-4">
            <!-- Camera preview card -->
            <div class="col-lg-5">
                <div class="ai-ca-card ai-ca-camera-card">
                    <div class="ai-ca-card-head">
                        <span class="ai-ca-card-icon"><i class="fa-solid fa-camera"></i></span>
                        <div>
                            <h2>Live Camera</h2>
                            <small>Front camera / webcam · full body view</small>
                        </div>
                    </div>

<div class="ai-ca-alerts"></div>

                    <div class="ai-ca-viewport" id="caViewport">
                        <video id="caVideo" autoplay playsinline muted></video>
                        <div class="ai-ca-placeholder" id="caPlaceholder">
                            <i class="fa-solid fa-user-large"></i>
                            <p>Press "Start Camera" to show your face & full body.</p>
                        </div>
                        <canvas id="caCanvas" class="d-none"></canvas>
                        <div class="ai-ca-cam-loading d-none" id="caCamLoading">
                            <div class="ai-ca-loader"><span></span><span></span><span></span><span></span><span></span></div>
                            <p>Starting camera...</p>
                        </div>
                    </div>

                    <input type="file" id="caFile" accept="image/jpeg,image/png,image/webp" class="d-none">
                    <img id="caUploadPreview" class="ai-ca-upload-preview" alt="Uploaded preview">

                    <div class="ai-ca-capture-tools">
                        <button type="button" class="btn btn-primary" id="caStartBtn"><i class="fa-solid fa-video me-1"></i> Start Camera</button>
                        <button type="button" class="btn btn-warning d-none" id="caCaptureBtn"><i class="fa-solid fa-camera me-1"></i> Capture</button>
                        <button type="button" class="btn btn-info d-none" id="caRetakeBtn"><i class="fa-solid fa-rotate-right me-1"></i> Retake</button>
                        <button type="button" class="btn btn-outline-secondary" id="caUploadBtn"><i class="fa-solid fa-upload me-1"></i> Upload</button>
                        <button type="button" class="btn btn-danger d-none" id="caStopBtn"><i class="fa-solid fa-stop me-1"></i> Stop</button>
                    </div>

                    <div class="ai-ca-cam-status" id="caStatus">Camera is off.</div>
                </div>
            </div>

            <!-- AI result card -->
            <div class="col-lg-7">
                <div class="ai-ca-card ai-ca-result-card">
                    <div class="ai-ca-card-head">
                        <span class="ai-ca-card-icon ai-ca-icon-ai"><i class="fa-solid fa-wand-magic-sparkles"></i></span>
                        <div>
                            <h2>AI Style Analysis</h2>
                            <small>Face features · body · color · style · outfits</small>
                        </div>
                    </div>

<form id="caAnalyzeForm" class="ai-ca-query-form">
                        <input type="text" id="caQuery" name="query" class="form-control" placeholder="Ask AI, e.g. 'Iske liye best outfit suggest karo'">
                        <button type="submit" class="btn btn-primary" id="caAnalyzeBtn"><i class="fa-solid fa-wand-magic-sparkles me-1"></i> Analyze My Style</button>
                    </form>

                    <!-- Action buttons -->
                    <div class="ai-ca-actions">
                        <button type="button" class="btn btn-info" id="caVirtualTryOnBtn" disabled><i class="fa-solid fa-wand-magic-sparkles me-1"></i> Virtual Try-On</button>
                        <button type="button" class="btn btn-success" id="caDownloadBtn" disabled><i class="fa-solid fa-file-pdf me-1"></i> Download</button>
                        <button type="button" class="btn btn-warning" id="caShareBtn" disabled><i class="fa-solid fa-share-nodes me-1"></i> Share</button>
                        <button type="button" class="btn btn-outline-secondary" id="caHistoryBtn"><i class="fa-solid fa-clock-rotate-left me-1"></i> History</button>
                        <button type="button" class="btn btn-danger" id="caResetBtn"><i class="fa-solid fa-rotate-left me-1"></i> Reset</button>
                    </div>

                    <!-- History panel -->
                    <div class="ai-ca-history d-none" id="caHistoryPanel">
                        <div class="ai-ca-history-head">
                            <h4><i class="fa-solid fa-clock-rotate-left me-1"></i> Your Analysis History</h4>
                            <button type="button" class="btn-close btn-close-white" id="caHistoryClose" aria-label="Close"></button>
                        </div>
                        <div id="caHistoryList"><span class="ai-ca-empty">Loading history...</span></div>
                    </div>

                    <!-- Loading animation -->
                    <div class="ai-ca-loading d-none" id="caLoading">
                        <div class="ai-ca-loader">
                            <span></span><span></span><span></span><span></span><span></span>
                        </div>
                        <p>AI is analyzing your style...</p>
                        <small>Detecting face features, body appearance & color matching</small>
                    </div>

<!-- Analysis results -->
                    <div id="caResults" class="ai-ca-results">
                        @if($analysis)
                            <div class="ai-ca-detection-grid">
                                <div class="ai-ca-detection-item">
                                    <i class="fa-solid fa-hand"></i>
                                    <strong>Skin Tone</strong>
                                    <span class="ai-ca-detect-label">{{ ucfirst($analysis['detection']['skin_tone']['label'] ?? '—') }}</span>
                                    <small class="ai-ca-confidence">Confidence: {{ $analysis['detection']['skin_tone']['confidence'] ?? '—' }}%</small>
                                </div>
                                <div class="ai-ca-detection-item">
                                    <i class="fa-solid fa-face-smile"></i>
                                    <strong>Face Shape</strong>
                                    <span class="ai-ca-detect-label">{{ ucfirst($analysis['detection']['face_shape']['label'] ?? '—') }}</span>
                                    <small class="ai-ca-confidence">Confidence: {{ $analysis['detection']['face_shape']['confidence'] ?? '—' }}%</small>
                                </div>
                                <div class="ai-ca-detection-item">
                                    <i class="fa-solid fa-venus-mars"></i>
                                    <strong>Gender</strong>
                                    <span class="ai-ca-detect-label">{{ $analysis['detection']['gender']['label'] ?? '—' }}</span>
                                    <small class="ai-ca-confidence">Confidence: {{ $analysis['detection']['gender']['confidence'] ?? '—' }}%</small>
                                </div>
                                <div class="ai-ca-detection-item">
                                    <i class="fa-solid fa-cake-candles"></i>
                                    <strong>Age Group</strong>
                                    <span class="ai-ca-detect-label">{{ $analysis['detection']['age_group']['label'] ?? '—' }}</span>
                                    <small class="ai-ca-confidence">Confidence: {{ $analysis['detection']['age_group']['confidence'] ?? '—' }}%</small>
                                </div>
                            </div>

                            <div class="ai-ca-analysis-grid">
                                <div class="ai-ca-analysis-item">
                                    <i class="fa-solid fa-face-smile"></i>
                                    <strong>Face Features</strong>
                                    <span>{{ $analysis['face_features']['skin_tone'] ?? '—' }} · {{ $analysis['face_features']['tone'] ?? '—' }} tone</span>
                                </div>
                                <div class="ai-ca-analysis-item">
                                    <i class="fa-solid fa-person"></i>
                                    <strong>Body Appearance</strong>
                                    <span>{{ ucfirst($analysis['body_appearance']['frame'] ?? 'balanced') }} frame</span>
                                </div>
                                <div class="ai-ca-analysis-item">
                                    <i class="fa-solid fa-shirt"></i>
                                    <strong>Style Preference</strong>
                                    <span>{{ ucfirst($analysis['style_preference']['suggested_style'] ?? 'casual') }} · {{ $analysis['style_preference']['fit'] ?? 'regular' }} fit</span>
                                </div>
                                <div class="ai-ca-analysis-item">
                                    <i class="fa-solid fa-palette"></i>
                                    <strong>Color Matching</strong>
                                    <span>{{ ucfirst($analysis['color_matching']['color_category'] ?? 'neutral') }} tones</span>
                                </div>
                            </div>

                            @if(collect($analysis['color_matching']['suitable_colors'] ?? [])->isNotEmpty())
                                <div class="ai-ca-color-section">
                                    <h4><i class="fa-solid fa-palette me-1"></i> Suitable Colors For You</h4>
                                    <div class="ai-ca-color-chips">
                                        @foreach($analysis['color_matching']['suitable_colors'] as $color)
                                            <span class="ai-ca-color-chip">{{ $color }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if(collect($analysis['fashion_recommendations']['outfit_ideas'] ?? [])->isNotEmpty())
                                <div class="ai-ca-fashion-section">
                                    <h4><i class="fa-solid fa-shirt me-1"></i> Fashion Recommendations</h4>
                                    <ul class="ai-ca-fashion-list">
                                        @foreach($analysis['fashion_recommendations']['outfit_ideas'] as $idea)
                                            <li>{{ $idea }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <p class="ai-ca-summary">{{ $analysis['summary'] ?? '' }}</p>
                        @else
                            <div class="ai-ca-empty">
                                <i class="fa-solid fa-sparkles"></i>
                                <p>Capture or upload a photo to see your AI style analysis and product recommendations.</p>
                            </div>
                        @endif

                        @if($recommendations->isNotEmpty())
                            <h3 class="ai-ca-section-title"><i class="fa-solid fa-bag-shopping me-1"></i> Recommended for You</h3>
                            <div class="ai-ca-products">
                                @foreach($recommendations as $item)
                                    @php $product = $item['product']; @endphp
                                    <div class="ai-ca-product">
                                        <img src="{{ asset('products/' . $product->image) }}" alt="{{ $product->name }}">
                                        <div class="ai-ca-product-body">
                                            <h4>{{ $product->name }}</h4>
                                            <p>{{ $product->category ?: 'Smart Basket product' }} · <span class="text-warning">★</span> {{ number_format((float) ($product->rating ?? 0), 1) }}</p>
                                            <small class="ai-ca-reason">{{ collect($item['reasons'])->implode(' · ') }}</small>
                                        </div>
                                        <div class="ai-ca-product-actions">
                                            <span class="ai-ca-price">₹{{ number_format((float) $product->price, 2) }}</span>
                                            <div class="ai-ca-product-btn-group">
                                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-cart-plus me-1"></i> Add to Cart</button>
                                                </form>
                                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-primary"><i class="fa-solid fa-eye me-1"></i> View Product</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<x-ai-hub-sidebar />
<script src="{{ asset('js/ai-camera-assistant.js') }}" defer></script>
</body>
</html>
