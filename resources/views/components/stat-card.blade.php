@props(['label', 'value', 'hint' => ''])
<div class="rounded-xl border border-earth/10 bg-white p-5 shadow-sm">
    <p class="text-sm font-medium text-charcoal/60">{{ $label }}</p>
    <p class="mt-2 font-display text-3xl text-pasture">{{ $value }}</p>
    <p class="mt-1 text-xs text-charcoal/60">{{ $hint }}</p>
</div>
