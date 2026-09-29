<div class="ai-panel-fragment">

    {{-- =====================================================
         AI GIFT FINDER
    ====================================================== --}}

    <h2>
        🎁 Gift Finder
    </h2>

    <p>
        Select an occasion for curated gift ideas.
    </p>


    {{-- =====================================================
         OCCASIONS
    ====================================================== --}}

    <div class="d-grid gap-2">

        @foreach([
            'Birthday',
            'Anniversary',
            'Festival'
        ] as $item)

            <a
                href="{{ route('gift-finder', [
                    'occasion' => $item,
                    'sidebar' => 1
                ]) }}"
                class="btn btn-sm
                    {{ $occasion === $item
                        ? 'btn-primary'
                        : 'btn-outline-primary'
                    }}"
                data-ai-hub-panel-link
            >

                @if($item === 'Birthday')
                    🎂
                @elseif($item === 'Anniversary')
                    💍
                @else
                    🎉
                @endif

                {{ $item }}

            </a>

        @endforeach

    </div>


    {{-- =====================================================
         RECOMMENDED PRODUCTS
    ====================================================== --}}

    @if($occasion)

        <div class="ai-drawer-products">

            <div
                class="mb-2"
                style="font-size:.78rem;color:#94A3B8;"
            >

                🎯 Recommended for
                <strong style="color:#fff;">
                    {{ $occasion }}
                </strong>

            </div>


            @forelse($products as $product)

                <a
                    href="{{ route('products.show', $product->id) }}"
                    class="ai-gift-product"
                >

                    <span>

                        <strong>
                            {{ $product->name }}
                        </strong>

                        <small>
                            {{ $product->category ?: 'Smart Basket product' }}
                        </small>

                    </span>


                    <b>
                        ₹{{ number_format(
                            (float) $product->price,
                            2
                        ) }}
                    </b>

                </a>

            @empty

                <div
                    class="text-center py-3"
                    style="color:#94A3B8;font-size:.8rem;"
                >

                    🎁

                    <div class="mt-2">
                        No recommendations yet.
                    </div>

                </div>

            @endforelse

        </div>

    @endif

</div>