{{-- Since the guest layout already provides the card structure,
    this component now just handles the logo and content passing --}}
<div>
    @if (isset($logo))
    <div class="mb-4">
        {{ $logo }}
    </div>
    @endif

    <div>
        {{ $slot }}
    </div>
</div> 