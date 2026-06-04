<x-layouts.main title="Admin Login">
    <section class="mx-auto max-w-md px-4 py-16">
        <div class="rounded-3xl bg-white p-8 shadow-sm">
            <p class="text-sm font-bold text-earth">Admin portal</p>
            <h1 class="mt-2 font-display text-3xl text-pasture">Admin Login</h1>
            <p class="mt-2 text-sm text-charcoal/65">Use this page for Zizini admin and moderation accounts only.</p>
            <form action="{{ route('admin.login.store') }}" method="post" class="mt-6 grid gap-4">
                @csrf
                <input name="login" class="rounded-lg border border-earth/20 p-3" placeholder="Admin email" required>
                <input name="password" class="rounded-lg border border-earth/20 p-3" placeholder="Password" type="password" required>
                <button class="rounded-lg bg-pasture px-5 py-3 font-bold text-white">Login as Admin</button>
            </form>
            <div class="mt-5 flex justify-between text-sm font-semibold">
                <a href="/login" class="text-pasture">Seller login</a>
                <a href="/contact" class="text-earth">Need help?</a>
            </div>
        </div>
    </section>
</x-layouts.main>
