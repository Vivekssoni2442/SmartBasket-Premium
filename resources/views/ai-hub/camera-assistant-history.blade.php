<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    {{-- =========================================================
         SMART BASKET — AI HUB HEAD
    ========================================================== --}}

    @include('ai-hub.partials.head', [
        'title' => 'AI Analysis History'
    ])


    {{-- =========================================================
         AI CAMERA ASSISTANT CSS
    ========================================================== --}}

    <link
        rel="stylesheet"
        href="{{ asset('css/ai-camera-assistant.css') }}"
    >


    {{-- =========================================================
         AI HUB SIDEBAR CSS
         SAME CSS USED ON EVERY AI PAGE
    ========================================================== --}}

    <link
        rel="stylesheet"
        href="{{ asset('css/ai-hub-sidebar.css') }}"
    >

</head>


<body>


<div class="ai-hub-layout">


    {{-- =========================================================
         GLOBAL AI HUB
         
         IMPORTANT:
         AI HUB ka SINGLE source yahi hai.
         Is page par alag FAB / sidebar mat banana.
    ========================================================== --}}

    @include('ai-hub.partials.navigation')


    {{-- =========================================================
         MAIN CONTENT
    ========================================================== --}}

    <main class="ai-hub-main">


        {{-- =====================================================
             PAGE HEADER
        ====================================================== --}}

        <header class="ai-hub-heading ai-ca-heading">

            <div>

                <span class="ai-hub-eyebrow">
                    YOUR SAVED ANALYSES
                </span>

                <h1>
                    AI Analysis History 📜
                </h1>

                <p>
                    Review your previous AI Camera Assistant
                    analyses and saved results.
                </p>

            </div>


            {{-- =================================================
                 BACK TO CAMERA
            ================================================== --}}

            @if(Route::has('ai-camera-assistant'))

                <a
                    href="{{ route('ai-camera-assistant') }}"
                    class="btn btn-outline-primary"
                >

                    <i class="fa-solid fa-camera me-1"></i>

                    Back to Camera Assistant

                </a>

            @endif

        </header>


        {{-- =====================================================
             SUCCESS MESSAGE
        ====================================================== --}}

        @if(session('success'))

            <div
                class="alert alert-success d-flex align-items-center"
                role="alert"
            >

                <i class="fa-solid fa-circle-check me-2"></i>

                <span>
                    {{ session('success') }}
                </span>

            </div>

        @endif


        {{-- =====================================================
             ERROR MESSAGE
        ====================================================== --}}

        @if(session('error'))

            <div
                class="alert alert-danger d-flex align-items-center"
                role="alert"
            >

                <i class="fa-solid fa-circle-exclamation me-2"></i>

                <span>
                    {{ session('error') }}
                </span>

            </div>

        @endif


        {{-- =====================================================
             VALIDATION ERRORS
        ====================================================== --}}

        @if($errors->any())

            <div class="alert alert-danger">

                <div class="fw-bold mb-2">
                    Please check the following:
                </div>

                <ul class="mb-0">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- =====================================================
             HISTORY CARD
        ====================================================== --}}

        <section class="ai-ca-card">


            {{-- =================================================
                 EMPTY HISTORY
            ================================================== --}}

            @if($histories->isEmpty())

                <div class="ai-ca-empty">

                    <i class="fa-solid fa-clock-rotate-left"></i>

                    <h3 class="mt-3">
                        No Saved Analyses
                    </h3>

                    <p>
                        No saved AI Camera Assistant analyses
                        are available yet.
                    </p>


                    @if(Route::has('ai-camera-assistant'))

                        <a
                            href="{{ route('ai-camera-assistant') }}"
                            class="btn btn-primary mt-2"
                        >

                            <i class="fa-solid fa-camera me-1"></i>

                            Analyze a Photo

                        </a>

                    @endif

                </div>


            @else


                {{-- =================================================
                     HISTORY HEADER
                ================================================== --}}

                <div
                    class="d-flex flex-wrap align-items-center
                           justify-content-between gap-3 mb-4"
                >

                    <div>

                        <span class="ai-hub-eyebrow">
                            SAVED RESULTS
                        </span>

                        <h2 class="mb-1 mt-1">
                            Your AI Analyses
                        </h2>

                        <p class="text-muted mb-0">
                            {{ $histories->count() }}
                            saved
                            {{ $histories->count() === 1 ? 'analysis' : 'analyses' }}
                        </p>

                    </div>


                    @if(Route::has('ai-camera-assistant'))

                        <a
                            href="{{ route('ai-camera-assistant') }}"
                            class="btn btn-primary"
                        >

                            <i class="fa-solid fa-camera me-1"></i>

                            New Analysis

                        </a>

                    @endif

                </div>


                {{-- =================================================
                     HISTORY LIST
                ================================================== --}}

                <div class="ai-ca-history-list">


                    @foreach($histories as $history)

                        @php

                            $analysis = $history->analysis ?? [];

                            if (is_string($analysis)) {
                                $analysis = json_decode(
                                    $analysis,
                                    true
                                ) ?: [];
                            }

                        @endphp


                        <article class="ai-ca-history-item">


                            {{-- =====================================
                                 ITEM HEADER
                            ====================================== --}}

                            <div class="ai-ca-history-item-head">

                                <div>

                                    <strong>

                                        {{ $history->query ?: 'AI Style Analysis' }}

                                    </strong>


                                    <small>

                                        <i class="fa-regular fa-clock me-1"></i>

                                        {{ optional($history->created_at)->format('d M Y, h:i A') }}

                                    </small>

                                </div>


                                {{-- =================================
                                     DELETE
                                ================================== --}}

                                @if(Route::has('ai-camera-assistant.history.delete'))

                                    <form
                                        action="{{ route(
                                            'ai-camera-assistant.history.delete',
                                            $history->id
                                        ) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm(
                                            'Are you sure you want to delete this AI analysis?'
                                        );"
                                    >

                                        @csrf

                                        @method('DELETE')


                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-outline-danger"
                                        >

                                            <i class="fa-solid fa-trash me-1"></i>

                                            Delete

                                        </button>

                                    </form>

                                @endif

                            </div>


                            {{-- =====================================
                                 ITEM BODY
                            ====================================== --}}

                            <div class="ai-ca-history-item-body">


                                {{-- =================================
                                     SAVED IMAGES
                                ================================== --}}

                                @if(
                                    !empty($history->image_path) ||
                                    !empty($history->result_image)
                                )

                                    <div class="ai-ca-history-thumbs">


                                        {{-- SOURCE PHOTO --}}

                                        @if(!empty($history->image_path))

                                            @php

                                                $sourceImage =
                                                    \Illuminate\Support\Facades\Storage::disk('public')
                                                        ->url($history->image_path);

                                            @endphp


                                            <a
                                                href="{{ $sourceImage }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                title="Open source photo"
                                            >

                                                <img
                                                    src="{{ $sourceImage }}"
                                                    class="ai-ca-history-thumb"
                                                    alt="AI Camera source photo"
                                                    loading="lazy"
                                                    onerror="this.style.display='none';"
                                                >

                                            </a>

                                        @endif


                                        {{-- GENERATED RESULT --}}

                                        @if(!empty($history->result_image))

                                            @php

                                                $resultImage =
                                                    \Illuminate\Support\Facades\Storage::disk('public')
                                                        ->url($history->result_image);

                                            @endphp


                                            <a
                                                href="{{ $resultImage }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                title="Open generated result"
                                            >

                                                <img
                                                    src="{{ $resultImage }}"
                                                    class="ai-ca-history-thumb"
                                                    alt="AI Camera generated result"
                                                    loading="lazy"
                                                    onerror="this.style.display='none';"
                                                >

                                            </a>

                                        @endif


                                    </div>

                                @endif


                                {{-- =================================
                                     AI DETECTION INFORMATION
                                ================================== --}}

                                @if(isset($analysis['detection']))


                                    <div class="d-flex flex-wrap gap-2 mb-3">


                                        {{-- SKIN TONE --}}

                                        @if(isset($analysis['detection']['skin_tone']))

                                            <span class="badge bg-secondary">

                                                <i class="fa-solid fa-hand me-1"></i>

                                                {{ ucfirst(
                                                    $analysis['detection']['skin_tone']['label']
                                                    ?? '—'
                                                ) }}

                                            </span>

                                        @endif


                                        {{-- FACE SHAPE --}}

                                        @if(isset($analysis['detection']['face_shape']))

                                            <span class="badge bg-secondary">

                                                <i class="fa-solid fa-face-smile me-1"></i>

                                                {{ ucfirst(
                                                    $analysis['detection']['face_shape']['label']
                                                    ?? '—'
                                                ) }}

                                            </span>

                                        @endif


                                        {{-- GENDER --}}

                                        @if(isset($analysis['detection']['gender']))

                                            <span class="badge bg-secondary">

                                                <i class="fa-solid fa-venus-mars me-1"></i>

                                                {{ $analysis['detection']['gender']['label'] ?? '—' }}

                                            </span>

                                        @endif


                                        {{-- AGE GROUP --}}

                                        @if(isset($analysis['detection']['age_group']))

                                            <span class="badge bg-secondary">

                                                <i class="fa-solid fa-cake-candles me-1"></i>

                                                {{ $analysis['detection']['age_group']['label'] ?? '—' }}

                                            </span>

                                        @endif


                                    </div>

                                @endif


                                {{-- =================================
                                     AI SUMMARY
                                ================================== --}}

                                @if(!empty($analysis['summary']))

                                    <div class="ai-ca-summary">

                                        <strong class="d-block mb-1">

                                            <i class="fa-solid fa-wand-magic-sparkles me-1"></i>

                                            AI Summary

                                        </strong>

                                        <p class="mb-0">

                                            {{ $analysis['summary'] }}

                                        </p>

                                    </div>

                                @endif


                            </div>


                        </article>

                    @endforeach


                </div>


            @endif


        </section>


    </main>

</div>


{{-- =========================================================
     GLOBAL AI HUB JAVASCRIPT
     
     navigation.blade.php already loads:
     ai-hub-sidebar.js

     Therefore DO NOT load it again here.
========================================================= --}}


{{-- =========================================================
     PAGE-SPECIFIC SCRIPTS
========================================================= --}}

@stack('scripts')


</body>

</html>