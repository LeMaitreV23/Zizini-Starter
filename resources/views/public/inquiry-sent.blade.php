<x-layouts.main title="Inquiry Prepared">
    @php($whatsapp = preg_replace('/\D+/', '', $listing['seller_whatsapp'] ?? $listing['seller_phone'] ?? ''))
    <section class="mx-auto max-w-2xl px-4 py-16">
        <div class="rounded-3xl bg-white p-8 text-center shadow-sm">
            <div class="mx-auto grid h-16 w-16 place-items-center rounded-full bg-fresh/20 text-3xl text-pasture">✓</div>
            <h1 class="mt-4 font-display text-3xl text-pasture">Inquiry prepared</h1>
            <p class="mt-2 text-charcoal/70">Hello, I saw your {{ $listing['title'] }} on Zizini.co.ke. Is it still available?</p>
            <p class="mt-4 font-bold">{{ $listing['seller_phone'] }}</p>
            <div class="mt-6 flex flex-wrap justify-center gap-3">
                <a href="https://wa.me/{{ $whatsapp }}?text={{ urlencode('Hello, I saw your '.$listing['title'].' on Zizini.co.ke. Is it still available?') }}" class="rounded-lg bg-pasture px-5 py-3 font-bold text-white">Open WhatsApp</a>
                <a href="/livestock/{{ $listing['slug'] }}" class="rounded-lg bg-cream px-5 py-3 font-bold">Back to Listing</a>
            </div>
        </div>
    </section>
</x-layouts.main>
