<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    @include('ai-hub.partials.head', [
        'title' => 'Smart Basket AI'
    ])

</head>


<body>

<div class="ai-hub-layout">


    {{-- =========================================================
         GLOBAL AI HUB
         ONE INSTANCE ONLY

         Same AI HUB popup/sidebar as every other AI page.
    ========================================================== --}}

    @include('ai-hub.partials.navigation')


    {{-- =========================================================
         MAIN CONTENT
    ========================================================== --}}

    <main class="ai-hub-main">


        {{-- =====================================================
             PAGE HEADER
        ====================================================== --}}

        <header class="ai-hub-heading">

            <div>

                <span class="ai-hub-eyebrow">
                    SMART BASKET AI
                </span>

                <h1>
                    AI Shopping Assistant 🤖
                </h1>

                <p>
                    Ask Smart Basket AI anything about products,
                    shopping, budgets, gifts and recommendations.
                </p>

            </div>

        </header>


        {{-- =====================================================
             AI CHAT PANEL
        ====================================================== --}}

        <section class="ai-panel">

            <div class="d-flex align-items-center gap-3 mb-4">

                <div
                    style="
                        width:52px;
                        height:52px;
                        border-radius:15px;
                        display:grid;
                        place-items:center;
                        font-size:1.5rem;
                        background:rgba(59,130,246,.15);
                        border:1px solid rgba(59,130,246,.35);
                    "
                >
                    🤖
                </div>

                <div>

                    <h2 class="h4 mb-1">
                        Smart Basket AI
                    </h2>

                    <p class="text-muted mb-0">
                        Your intelligent shopping assistant
                    </p>

                </div>

            </div>


            {{-- =================================================
                 PREVIOUS RESPONSE
            ================================================== --}}

            @if(session('ai_response'))

                <div class="alert alert-info mb-4">

                    <div class="fw-bold mb-2">
                        🤖 AI Response
                    </div>

                    <div>
                        {!! nl2br(e(session('ai_response'))) !!}
                    </div>

                </div>

            @endif


            {{-- =================================================
                 ERROR
            ================================================== --}}

            @if(session('error'))

                <div class="alert alert-danger mb-4">

                    <i class="fa-solid fa-circle-exclamation me-1"></i>

                    {{ session('error') }}

                </div>

            @endif


            {{-- =================================================
                 VALIDATION ERRORS
            ================================================== --}}

            @if($errors->any())

                <div class="alert alert-danger mb-4">

                    <strong>
                        Please fix the following:
                    </strong>

                    <ul class="mb-0 mt-2">

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- =================================================
                 CHAT FORM
            ================================================== --}}

            <form
                method="POST"
                action="{{ url('/ai-chat') }}"
                id="aiChatForm"
            >

                @csrf


                <label
                    for="aiMessage"
                    class="form-label"
                >
                    What would you like to ask?
                </label>


                <textarea
                    id="aiMessage"
                    name="message"
                    class="form-control"
                    rows="5"
                    maxlength="5000"
                    placeholder="Example: ₹1000 ke andar best headphones suggest karo..."
                    required
                >{{ old('message') }}</textarea>


                <div
                    class="d-flex flex-wrap justify-content-between align-items-center gap-3 mt-3"
                >

                    <small class="text-muted">

                        <i class="fa-solid fa-circle-info me-1"></i>

                        Ask about products, budget,
                        gifts, comparisons or shopping.

                    </small>


                    <button
                        type="submit"
                        class="btn btn-primary"
                        id="aiChatSubmit"
                    >

                        <i class="fa-solid fa-paper-plane me-1"></i>

                        Ask AI

                    </button>

                </div>

            </form>

        </section>


        {{-- =====================================================
             QUICK AI QUESTIONS
        ====================================================== --}}

        <section class="ai-panel mt-4">

            <div class="mb-3">

                <span class="ai-hub-eyebrow">
                    QUICK QUESTIONS
                </span>

                <h2 class="h5 mt-1 mb-0">
                    Try asking Smart Basket AI
                </h2>

            </div>


            <div class="d-flex flex-wrap gap-2">

                <button
                    type="button"
                    class="btn btn-outline-primary ai-quick-question"
                    data-question="₹500 ke andar best products suggest karo"
                >
                    💰 Budget Products
                </button>


                <button
                    type="button"
                    class="btn btn-outline-primary ai-quick-question"
                    data-question="Mujhe birthday ke liye ek accha gift suggest karo"
                >
                    🎁 Gift Ideas
                </button>


                <button
                    type="button"
                    class="btn btn-outline-primary ai-quick-question"
                    data-question="Smart Basket par trending products kaunse hain?"
                >
                    🌟 Trending Products
                </button>


                <button
                    type="button"
                    class="btn btn-outline-primary ai-quick-question"
                    data-question="Mere liye best shopping products recommend karo"
                >
                    🛍️ Recommendations
                </button>

            </div>

        </section>

    </main>

</div>


{{-- =========================================================
     QUICK QUESTION SCRIPT
========================================================== --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const message =
        document.getElementById('aiMessage');

    const quickQuestions =
        document.querySelectorAll('.ai-quick-question');


    quickQuestions.forEach(function (button) {

        button.addEventListener(
            'click',
            function () {

                if (!message) {
                    return;
                }


                message.value =
                    this.dataset.question || '';


                message.focus();


                message.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });

            }
        );

    });


    /*
     * Prevent accidental double submission.
     */

    const form =
        document.getElementById('aiChatForm');

    const submitButton =
        document.getElementById('aiChatSubmit');


    if (form && submitButton) {

        form.addEventListener(
            'submit',
            function () {

                submitButton.disabled =
                    true;

                submitButton.innerHTML =
                    '<i class="fa-solid fa-spinner fa-spin me-1"></i> AI is thinking...';

            }
        );

    }

});

</script>


</body>
</html>