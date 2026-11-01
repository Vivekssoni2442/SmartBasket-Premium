@extends('layouts.app')
@section('title', 'Mobile Required | Smart Basket Delivery')
@section('content')
<main style="min-height:75vh;display:grid;place-items:center;padding:24px;background:#f4f7fb">
    <section style="max-width:460px;padding:32px;border:1px solid #e2e8f0;border-radius:22px;background:#fff;text-align:center;box-shadow:0 20px 50px rgba(15,23,42,.08)">
        <div style="font-size:36px;color:#315bd4"><i class="fa-solid fa-mobile-screen-button" aria-hidden="true"></i></div>
        <h1 style="margin:14px 0 8px;font-size:23px;font-weight:900;color:#17243b">Open this private link on your phone</h1>
        <p style="margin:0;color:#718096;line-height:1.6">The delivery partner app is mobile-only. For customer privacy, assigned orders are shown only on a mobile device.</p>
    </section>
</main>
@endsection
