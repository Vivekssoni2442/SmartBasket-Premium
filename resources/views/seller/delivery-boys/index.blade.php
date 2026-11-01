@extends('seller.partials.premium-layout')

@section('title', 'Delivery Boy Profiles | Smart Basket')

@section('content')
@push('styles')
<style>
    .delivery-page{--dp-bg:#f2f6fc;--dp-card:#fff;--dp-text:#17243a;--dp-muted:#718096;--dp-line:#e1e8f1;--dp-soft:#f7f9fd;--dp-shadow:0 18px 46px rgba(26,54,93,.09);width:100%;max-width:none;min-height:calc(100vh - 76px);margin:0;padding:26px clamp(14px,2.4vw,36px) 54px;color:var(--dp-text);background:radial-gradient(circle at 3% 4%,rgba(41,111,232,.08),transparent 25%),var(--dp-bg)}
    html[data-sb-theme="dark"] .delivery-page,body[data-sb-theme="dark"] .delivery-page{--dp-bg:#07111f;--dp-card:#101c2d;--dp-text:#f1f5fb;--dp-muted:#a1aec1;--dp-line:rgba(196,213,237,.13);--dp-soft:#0b1727;--dp-shadow:0 20px 55px rgba(0,0,0,.24)}
    .delivery-shell{width:100%;max-width:none;margin:0 auto}.delivery-hero{position:relative;isolation:isolate;overflow:hidden;display:flex;align-items:center;justify-content:space-between;gap:22px;padding:clamp(22px,3.3vw,38px);border:1px solid rgba(155,204,255,.24);border-radius:26px;background:radial-gradient(circle at 85% 10%,rgba(63,211,192,.27),transparent 32%),radial-gradient(circle at 12% 130%,rgba(96,103,255,.34),transparent 46%),linear-gradient(120deg,#10264d,#1c4d92 54%,#443b91);box-shadow:0 22px 55px rgba(20,51,103,.22);color:#fff}.delivery-hero:after{position:absolute;z-index:-1;right:11%;top:-110px;width:270px;height:270px;border:1px solid rgba(255,255,255,.13);border-radius:50%;content:"";box-shadow:0 0 0 28px rgba(255,255,255,.035),0 0 0 58px rgba(255,255,255,.025)}
    .delivery-kicker{display:inline-flex;align-items:center;gap:8px;color:#a8f5e3;font-size:10px;font-weight:950;letter-spacing:.16em;text-transform:uppercase}.delivery-hero h1{margin:10px 0 7px;color:#fff;font-size:clamp(27px,3.8vw,42px);font-weight:950;letter-spacing:-1.2px}.delivery-hero p{max-width:680px;margin:0;color:#dbe8ff;font-size:13px;line-height:1.7}.delivery-count{flex:none;min-width:128px;padding:16px 18px;border:1px solid rgba(255,255,255,.19);border-radius:18px;background:rgba(255,255,255,.1);text-align:center;backdrop-filter:blur(12px)}.delivery-count strong{display:block;font-size:28px;line-height:1.1}.delivery-count span{display:block;margin-top:5px;color:#d6e7ff;font-size:10px;font-weight:800;letter-spacing:.06em;text-transform:uppercase}
    .delivery-alert{display:flex;align-items:flex-start;gap:10px;margin-top:16px;padding:13px 16px;border:1px solid var(--dp-line);border-radius:14px;background:var(--dp-card);font-size:12px;box-shadow:var(--dp-shadow)}.delivery-alert.success{border-color:rgba(22,163,74,.25);color:#15803d}.delivery-alert.error{border-color:rgba(220,38,38,.25);color:#b91c1c}
    .delivery-grid{display:grid;grid-template-columns:minmax(340px,.88fr) minmax(0,1.42fr);gap:18px;margin-top:19px;align-items:start}.delivery-card{min-width:0;overflow:hidden;border:1px solid var(--dp-line);border-radius:22px;background:var(--dp-card);box-shadow:var(--dp-shadow)}.delivery-card-head{display:flex;align-items:center;gap:12px;padding:20px 22px;border-bottom:1px solid var(--dp-line);background:linear-gradient(120deg,rgba(39,105,220,.07),transparent)}.delivery-card-icon{width:42px;height:42px;display:grid;place-items:center;flex:none;border:1px solid rgba(37,99,235,.16);border-radius:14px;background:rgba(37,99,235,.09);color:#3b70d4;font-size:17px}.delivery-card-head h2{margin:0;color:var(--dp-text);font-size:17px;font-weight:950}.delivery-card-head p{margin:4px 0 0;color:var(--dp-muted);font-size:10px;line-height:1.5}.delivery-card-body{padding:20px 22px 23px}
    .delivery-fields{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px}.delivery-field{display:block;min-width:0;color:var(--dp-text);font-size:11px;font-weight:850}.delivery-field.full{grid-column:1/-1}.delivery-field input,.delivery-field select,.delivery-field textarea{display:block;width:100%;min-height:44px;margin-top:6px;padding:10px 12px;border:1px solid var(--dp-line);border-radius:11px;outline:none;background:var(--dp-soft);color:var(--dp-text);font-size:12px;transition:border-color .18s,box-shadow .18s}.delivery-field textarea{min-height:78px;resize:vertical}.delivery-field input:focus,.delivery-field select:focus,.delivery-field textarea:focus{border-color:#5387eb;box-shadow:0 0 0 3px rgba(59,112,212,.12)}.delivery-field input::placeholder,.delivery-field textarea::placeholder{color:#94a3b8}.delivery-required{color:#ef5364}.delivery-field-error{display:block;margin-top:5px;color:#dc3545;font-size:10px;font-weight:700}.delivery-submit{display:inline-flex;align-items:center;justify-content:center;gap:9px;min-height:47px;margin-top:17px;padding:0 19px;border:0;border-radius:13px;background:linear-gradient(115deg,#2468d9,#634bd0);box-shadow:0 11px 24px rgba(49,94,190,.24);color:#fff;font-size:12px;font-weight:900;cursor:pointer;transition:transform .2s,box-shadow .2s}.delivery-submit:hover{transform:translateY(-2px);box-shadow:0 15px 29px rgba(49,94,190,.31)}
    .delivery-search-wrap{position:relative;padding:15px 20px 0}.delivery-search-wrap i{position:absolute;top:29px;left:34px;color:var(--dp-muted);font-size:12px}.delivery-search{width:100%;min-height:43px;padding:10px 13px 10px 35px;border:1px solid var(--dp-line);border-radius:12px;background:var(--dp-soft);color:var(--dp-text);font-size:11px}.delivery-team{display:grid;gap:11px;padding:14px 20px 20px}.delivery-partner{padding:14px;border:1px solid var(--dp-line);border-radius:17px;background:var(--dp-soft);transition:border-color .18s,transform .18s}.delivery-partner:hover{transform:translateY(-2px);border-color:rgba(59,112,212,.38)}.delivery-partner-main{display:flex;align-items:center;gap:12px;min-width:0}.delivery-avatar{width:52px;height:52px;display:grid;place-items:center;overflow:hidden;flex:none;border:1px solid rgba(59,112,212,.17);border-radius:16px;background:linear-gradient(135deg,#e1edff,#e7e3ff);color:#456dbe;font-size:18px}.delivery-avatar img{width:100%;height:100%;object-fit:cover}.delivery-person{min-width:0;flex:1}.delivery-person strong{display:block;overflow:hidden;color:var(--dp-text);font-size:13px;font-weight:900;text-overflow:ellipsis;white-space:nowrap}.delivery-person span,.delivery-person small{display:block;overflow:hidden;margin-top:3px;color:var(--dp-muted);font-size:10px;text-overflow:ellipsis;white-space:nowrap}.delivery-person small{color:#5680c7}.delivery-active{flex:none;padding:7px 9px;border:1px solid rgba(22,163,74,.16);border-radius:999px;background:rgba(22,163,74,.08);color:#168449;font-size:9px;font-weight:900}.delivery-actions{display:flex;align-items:center;gap:8px;flex-wrap:wrap;margin-top:12px;padding-left:64px}.delivery-action{display:inline-flex;align-items:center;gap:6px;min-height:34px;padding:0 10px;border:1px solid var(--dp-line);border-radius:10px;background:var(--dp-card);color:var(--dp-text);font-size:10px;font-weight:800;text-decoration:none;cursor:pointer}.delivery-action.primary{border-color:rgba(59,112,212,.28);color:#3d6fc4}.delivery-action:hover{border-color:#5a85d5;color:#315fb1}.delivery-edit{flex:1 1 100%;margin-top:5px}.delivery-edit summary{display:inline-flex;align-items:center;gap:6px;min-height:34px;padding:0 10px;border:1px solid var(--dp-line);border-radius:10px;background:var(--dp-card);color:var(--dp-text);font-size:10px;font-weight:800;cursor:pointer;list-style:none}.delivery-edit summary::-webkit-details-marker{display:none}.delivery-edit-form{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:9px;margin-top:11px}.delivery-edit-form .delivery-field input,.delivery-edit-form .delivery-field select,.delivery-edit-form .delivery-field textarea{min-height:38px;padding:8px 10px;font-size:11px}.delivery-empty{padding:36px 18px;border:1px dashed var(--dp-line);border-radius:15px;color:var(--dp-muted);font-size:12px;text-align:center}.delivery-empty i{display:block;margin-bottom:10px;color:#7895c8;font-size:25px}
    @media(max-width:1000px){.delivery-grid{grid-template-columns:minmax(0,1fr) minmax(0,1.2fr)}}
    @media(max-width:760px){.delivery-page{padding:17px 12px 38px}.delivery-hero{align-items:flex-start;padding:22px 19px;border-radius:21px}.delivery-count{min-width:83px;padding:12px 10px}.delivery-count strong{font-size:23px}.delivery-count span{font-size:8px}.delivery-grid{grid-template-columns:1fr}.delivery-card-head{padding:17px}.delivery-card-body{padding:17px}.delivery-search-wrap{padding-inline:16px}.delivery-search-wrap i{left:30px}.delivery-team{padding:13px 16px 16px}}
    @media(max-width:480px){.delivery-hero{display:block}.delivery-count{display:inline-block;margin-top:15px;min-width:105px}.delivery-fields{grid-template-columns:1fr;gap:12px}.delivery-field.full{grid-column:auto}.delivery-card-head h2{font-size:15px}.delivery-actions{padding-left:0}.delivery-edit-form{grid-template-columns:1fr}.delivery-active{font-size:8px;padding:6px 7px}}
</style>
@endpush

<main class="delivery-page">
    <div class="delivery-shell">
        <header class="delivery-hero">
            <div>
                <div class="delivery-kicker"><i class="fa-solid fa-truck-fast" aria-hidden="true"></i> Seller fleet management</div>
                <h1>Delivery partners</h1>
                <p>Apni delivery team ko ek jagah manage karein. Saved partner ko order assign karke uska private driver-app link share karein.</p>
            </div>
            <div class="delivery-count"><strong>{{ $partners->count() }}</strong><span>Saved partners</span></div>
        </header>

        <div class="delivery-alert" role="note"><i class="fa-solid fa-shield-halved" aria-hidden="true"></i><span>Private network setup: server aur har phone ko ek hi Tailscale account/network me sign in karein. Server PC aur internet chalu rehna chahiye. Tailscale VPN ke bina driver link nahi khulega.</span></div>

        @if(session('success'))<div class="delivery-alert success" role="status"><i class="fa-solid fa-circle-check" aria-hidden="true"></i><span>{{ session('success') }}</span></div>@endif
        @if($errors->any())<div class="delivery-alert error" role="alert"><i class="fa-solid fa-triangle-exclamation" aria-hidden="true"></i><span>{{ $errors->first() }}</span></div>@endif

        <div class="delivery-grid">
            <section class="delivery-card" aria-labelledby="addPartnerTitle">
                <header class="delivery-card-head">
                    <span class="delivery-card-icon"><i class="fa-solid fa-user-plus" aria-hidden="true"></i></span>
                    <div><h2 id="addPartnerTitle">Add a delivery boy</h2><p>Profile ek baar save karein, baad mein orders par assign karein.</p></div>
                </header>
                <div class="delivery-card-body">
                    <form method="POST" action="{{ route('seller.delivery-boys.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="delivery-fields">
                            <label class="delivery-field full">Profile photo<input name="image" type="file" accept="image/jpeg,image/png,image/webp"><span class="delivery-field-error">@error('image'){{ $message }}@enderror</span></label>
                            <label class="delivery-field">Full name <span class="delivery-required">*</span><input name="name" required value="{{ old('name') }}" placeholder="Delivery partner name"><span class="delivery-field-error">@error('name'){{ $message }}@enderror</span></label>
                            <label class="delivery-field">Mobile number <span class="delivery-required">*</span><input name="phone" required value="{{ old('phone') }}" placeholder="Phone number"><span class="delivery-field-error">@error('phone'){{ $message }}@enderror</span></label>
                            <label class="delivery-field">Email<input name="email" type="email" value="{{ old('email') }}" placeholder="Optional"><span class="delivery-field-error">@error('email'){{ $message }}@enderror</span></label>
                            <label class="delivery-field">Vehicle type<select name="vehicle_type"><option value="">Select vehicle</option>@foreach(['Bike','Activa','Jeep'] as $vehicle)<option value="{{ $vehicle }}" @selected(old('vehicle_type') === $vehicle)>{{ $vehicle }}</option>@endforeach</select><span class="delivery-field-error">@error('vehicle_type'){{ $message }}@enderror</span></label>
                            <label class="delivery-field">Vehicle number<input name="vehicle_number" value="{{ old('vehicle_number') }}" placeholder="Optional"><span class="delivery-field-error">@error('vehicle_number'){{ $message }}@enderror</span></label>
                            <label class="delivery-field">Availability date<input name="delivery_date" type="date" value="{{ old('delivery_date') }}"><span class="delivery-field-error">@error('delivery_date'){{ $message }}@enderror</span></label>
                            <label class="delivery-field full">Usual shift / time<input name="expected_time" value="{{ old('expected_time') }}" placeholder="For example, 9 AM to 6 PM"><span class="delivery-field-error">@error('expected_time'){{ $message }}@enderror</span></label>
                            <label class="delivery-field full">Notes<textarea name="notes" rows="3" placeholder="Optional delivery notes">{{ old('notes') }}</textarea><span class="delivery-field-error">@error('notes'){{ $message }}@enderror</span></label>
                        </div>
                        <button type="submit" class="delivery-submit"><i class="fa-solid fa-floppy-disk" aria-hidden="true"></i> Save delivery boy</button>
                    </form>
                </div>
            </section>

            <section class="delivery-card" aria-labelledby="teamTitle">
                <header class="delivery-card-head">
                    <span class="delivery-card-icon"><i class="fa-solid fa-people-group" aria-hidden="true"></i></span>
                    <div><h2 id="teamTitle">Your delivery team</h2><p>Driver app kholein, private link copy karein, ya profile update karein.</p></div>
                </header>
                <div class="delivery-search-wrap"><i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i><input id="partnerSearch" type="search" class="delivery-search" placeholder="Search name, mobile or vehicle" aria-label="Search delivery partners"></div>
                <div class="delivery-team">
                    @forelse($partners as $partner)
                        @php($driverPortalLink = \App\Support\DriverPortalLink::for($partner))
                        <article class="delivery-partner" data-partner-card data-search="{{ strtolower($partner->name.' '.$partner->phone.' '.$partner->vehicle_type.' '.$partner->vehicle_number) }}">
                            <div class="delivery-partner-main">
                                <div class="delivery-avatar">@if($partner->image)<img src="{{ asset('delivery-partners/'.$partner->image) }}" alt="{{ $partner->name }}">@else<i class="fa-solid fa-user" aria-hidden="true"></i>@endif</div>
                                <div class="delivery-person"><strong>{{ $partner->name }}</strong><span>{{ $partner->phone }}{{ $partner->email ? ' · '.$partner->email : '' }}</span><small>{{ $partner->vehicle_type ?: 'Vehicle not set' }}{{ $partner->vehicle_number ? ' · '.$partner->vehicle_number : '' }}</small></div>
                                <span class="delivery-active">{{ $partner->active_deliveries_count }} active</span>
                            </div>
                            <div class="delivery-actions">
                                @if($driverPortalLink)
                                    <a class="delivery-action primary" href="{{ $driverPortalLink }}" target="_blank" rel="noopener"><i class="fa-solid fa-mobile-screen-button" aria-hidden="true"></i> Driver app</a>
                                    <button class="delivery-action" type="button" data-copy-partner-link="{{ $driverPortalLink }}"><i class="fa-regular fa-copy" aria-hidden="true"></i> Copy private link</button>
                                @else
                                    <span class="delivery-action" aria-disabled="true" title="Configure APP_URL with the server's private HTTPS Tailscale URL first"><i class="fa-solid fa-link-slash" aria-hidden="true"></i> Private link not configured</span>
                                @endif
                                <details class="delivery-edit"><summary><i class="fa-solid fa-pen" aria-hidden="true"></i> Edit profile</summary>
                                    <form method="POST" action="{{ route('seller.delivery-boys.update', $partner) }}" enctype="multipart/form-data" class="delivery-edit-form">
                                        @csrf @method('PUT')
                                        <label class="delivery-field">Name<input name="name" required value="{{ $partner->name }}"></label>
                                        <label class="delivery-field">Mobile<input name="phone" required value="{{ $partner->phone }}"></label>
                                        <label class="delivery-field">Email<input name="email" type="email" value="{{ $partner->email }}" placeholder="Optional"></label>
                                        <label class="delivery-field">Vehicle type<select name="vehicle_type"><option value="">Select vehicle</option>@foreach(['Bike','Activa','Jeep'] as $vehicle)<option value="{{ $vehicle }}" @selected($partner->vehicle_type === $vehicle)>{{ $vehicle }}</option>@endforeach</select></label>
                                        <label class="delivery-field">Vehicle number<input name="vehicle_number" value="{{ $partner->vehicle_number }}"></label>
                                        <label class="delivery-field">Availability date<input name="delivery_date" type="date" value="{{ $partner->delivery_date?->format('Y-m-d') }}"></label>
                                        <label class="delivery-field">Usual shift<input name="expected_time" value="{{ $partner->expected_time }}"></label>
                                        <label class="delivery-field">Replace photo<input name="image" type="file" accept="image/jpeg,image/png,image/webp"></label>
                                        <label class="delivery-field">Notes<textarea name="notes" rows="2">{{ $partner->notes }}</textarea></label>
                                        <button class="delivery-submit" type="submit"><i class="fa-solid fa-check" aria-hidden="true"></i> Save changes</button>
                                    </form>
                                </details>
                            </div>
                        </article>
                    @empty
                        <div class="delivery-empty"><i class="fa-solid fa-truck-fast" aria-hidden="true"></i>Add your first delivery partner profile to assign them to orders.</div>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</main>

<script>
(() => {
    const search = document.getElementById('partnerSearch');
    search?.addEventListener('input', () => {
        const query = search.value.trim().toLowerCase();
        document.querySelectorAll('[data-partner-card]').forEach((card) => { card.hidden = !card.dataset.search.includes(query); });
    });
    document.querySelectorAll('[data-copy-partner-link]').forEach((button) => button.addEventListener('click', async () => {
        const link = new URL(button.dataset.copyPartnerLink, location.href).href;
        try { await navigator.clipboard.writeText(link); button.innerHTML = '<i class="fa-solid fa-check" aria-hidden="true"></i> Copied'; }
        catch (_) { window.prompt('Copy private driver link:', link); }
    }));
})();
</script>
@endsection
