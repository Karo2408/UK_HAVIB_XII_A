@php
    $posName = \App\Setting::getValue('pos_name') ?? 'POS Default';
    $diskon = \App\Setting::getValue('diskon_global') ?? 0;
@endphp

<div class="alert alert-light border">
    <strong>{{ $posName }}</strong> — Diskon: {{ $diskon }}% (Jika Member)
</div>