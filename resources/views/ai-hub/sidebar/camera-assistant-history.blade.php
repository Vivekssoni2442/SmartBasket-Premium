<link rel="stylesheet" href="{{ asset('css/ai-camera-assistant.css') }}">
<div class="ai-panel-fragment">
    <h2>📜 AI Analysis History</h2>
    <p>Your previous AI Camera Assistant analyses.</p>

    @if($histories->isEmpty())
        <div class="ai-ca-empty">
            <i class="fa-solid fa-clock-rotate-left"></i>
            <p>No saved analyses yet.</p>
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
                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash me-1"></i></button>
                        </form>
                    </div>
                    @if($history->image_path)
                        <img src="{{ Storage::disk('public')->url($history->image_path) }}" class="ai-ca-history-thumb" alt="Source photo">
                    @endif
                    @if($history->result_image)
                        <img src="{{ Storage::disk('public')->url($history->result_image) }}" class="ai-ca-history-thumb" alt="Try-on result">
                    @endif
                    @if(!empty($a['summary']))
                        <p class="ai-ca-summary">{{ $a['summary'] }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>
