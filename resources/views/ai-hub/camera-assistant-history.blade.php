<!DOCTYPE html>
<html lang="en">
<head>
    @include('ai-hub.partials.head', ['title' => 'AI Analysis History'])
    <link rel="stylesheet" href="{{ asset('css/ai-camera-assistant.css') }}">
</head>
<body>
<div class="ai-hub-layout">
    @include('ai-hub.partials.navigation')
    <main class="ai-hub-main">
        <header class="ai-hub-heading ai-ca-heading">
            <div>
                <span class="ai-hub-eyebrow">Your saved analyses</span>
                <h1>AI Analysis History 📜</h1>
                <p>Review your previous AI Camera Assistant analyses.</p>
            </div>
            <a href="{{ route('ai-camera-assistant') }}" class="btn btn-outline-primary"><i class="fa-solid fa-camera me-1"></i> Back to Camera Assistant</a>
        </header>

        @if(session('success'))
            <div class="alert alert-success"><i class="fa-solid fa-circle-check me-1"></i> {{ session('success') }}</div>
        @endif

        <div class="ai-ca-card">
            @if($histories->isEmpty())
                <div class="ai-ca-empty">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    <p>No saved analyses yet. Analyze a photo to see it here.</p>
                </div>
            @else
                <div class="ai-ca-history-list">
                    @foreach($histories as $history)
                        @php $a = $history->analysis ?? []; @endphp
                        <div class="ai-ca-history-item">
                            <div class="ai-ca-history-item-head">
                                <div>
                                    <strong>{{ $history->query ?: 'AI Style Analysis' }}</strong>
                                    <small>{{ $history->created_at->format('d M Y, h:i A') }}</small>
                                </div>
                                <form action="{{ route('ai-camera-assistant.history.delete', $history->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash me-1"></i> Delete</button>
                                </form>
                            </div>
                            <div class="ai-ca-history-item-body">
                                @if($history->image_path || $history->result_image)
                                    <div class="ai-ca-history-thumbs">
                                        @if($history->image_path)
                                            <a href="{{ Storage::disk('public')->url($history->image_path) }}" target="_blank" title="Source photo">
                                                <img src="{{ Storage::disk('public')->url($history->image_path) }}" class="ai-ca-history-thumb" alt="Source photo">
                                            </a>
                                        @endif
                                        @if($history->result_image)
                                            <a href="{{ Storage::disk('public')->url($history->result_image) }}" target="_blank" title="Generated result">
                                                <img src="{{ Storage::disk('public')->url($history->result_image) }}" class="ai-ca-history-thumb" alt="Try-on result">
                                            </a>
                                        @endif
                                    </div>
                                @endif
                                @if(isset($a['detection']))
                                    <span><i class="fa-solid fa-hand me-1"></i>{{ ucfirst($a['detection']['skin_tone']['label'] ?? '—') }}</span>
                                    <span><i class="fa-solid fa-face-smile me-1"></i>{{ ucfirst($a['detection']['face_shape']['label'] ?? '—') }}</span>
                                    <span><i class="fa-solid fa-venus-mars me-1"></i>{{ $a['detection']['gender']['label'] ?? '—' }}</span>
                                    <span><i class="fa-solid fa-cake-candles me-1"></i>{{ $a['detection']['age_group']['label'] ?? '—' }}</span>
                                @endif
                                @if(!empty($a['summary']))
                                    <p class="ai-ca-summary">{{ $a['summary'] }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </main>
</div>

<x-ai-hub-sidebar />
</body>
</html>
