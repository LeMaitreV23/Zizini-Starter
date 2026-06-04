<x-layouts.main title="Register as Seller">
    <section class="mx-auto max-w-4xl px-4 py-10 lg:px-8">
        <div class="rounded-3xl bg-white p-8 shadow-sm">
            <h1 class="font-display text-4xl text-pasture">Register as a seller</h1><p class="mt-2 text-charcoal/65">After registration, admin reviews your account before you can post livestock.</p>
            <form action="{{ route('seller.register.store') }}" method="post" class="mt-8 grid gap-4 md:grid-cols-2">
                @csrf
                <input name="name" class="rounded-lg border border-earth/20 p-3" placeholder="Full name" required>
                <input name="phone" class="rounded-lg border border-earth/20 p-3" placeholder="Phone number" required>
                <input name="whatsapp" class="rounded-lg border border-earth/20 p-3" placeholder="WhatsApp number">
                <input name="email" type="email" class="rounded-lg border border-earth/20 p-3" placeholder="Email" required>
                <input name="county" class="rounded-lg border border-earth/20 p-3" placeholder="County" required>
                <input name="business_name" class="rounded-lg border border-earth/20 p-3" placeholder="Farm/business name optional">
                <input name="password" class="rounded-lg border border-earth/20 p-3" placeholder="Password" type="password" required>
                <input name="password_confirmation" class="rounded-lg border border-earth/20 p-3" placeholder="Confirm password" type="password" required>
                <select name="seller_type" class="rounded-lg border border-earth/20 p-3"><option>Individual farmer</option><option>Broker</option><option>Farm/dealer</option><option>Cooperative</option><option>Vet/partner</option></select>
                <label class="flex items-center gap-2 text-sm"><input name="terms" value="1" type="checkbox" required> I accept the seller terms</label>
                <button class="rounded-lg bg-pasture px-5 py-3 font-bold text-white md:col-span-2">Submit Seller Application</button>
            </form>
        </div>
    </section>
</x-layouts.main>
