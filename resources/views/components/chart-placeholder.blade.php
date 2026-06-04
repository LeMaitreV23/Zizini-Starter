@props(['title'])
<div class="rounded-xl border border-earth/10 bg-white p-5 shadow-sm">
    <div class="flex items-center justify-between"><h3 class="font-display text-lg text-pasture">{{ $title }}</h3><span class="text-xs font-semibold text-earth">Demo analytics</span></div>
    <div class="mt-5 flex h-40 items-end gap-3">
        @foreach([45,70,38,82,54,92,64] as $bar)
            <div class="flex-1 rounded-t bg-pasture/80" style="height: {{ $bar }}%"></div>
        @endforeach
    </div>
</div>
