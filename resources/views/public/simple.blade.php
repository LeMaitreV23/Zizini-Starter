@php
$content = [
 'how-it-works' => ['How It Works', ['Buyer flow' => ['Browse livestock','Filter by category/county','View animal details','Contact owner by call or WhatsApp','Inspect animal physically','Agree directly with seller offline'], 'Seller flow' => ['Register seller account','Wait for admin approval','Admin assigns posting access','Post livestock details and photos','Listing goes for approval','Listing goes live','Buyers contact seller directly'], 'Admin flow' => ['Review seller requests','Assign role and posting allowance','Review listings','Approve/reject listings','Monitor reports and expired listings']]],
 'about' => ['About Zizini', ['What Zizini is' => ['A livestock listing and contact marketplace for Kenya and East Africa.'], 'Who it helps' => ['Farmers','Buyers','Brokers','Livestock businesses','Farms/dealers'], 'Mission' => ['Make livestock discovery and seller contact easier across Kenya and East Africa.'], 'Vision' => ['A trusted digital livestock marketplace for Africa.']]],
 'faq' => ['FAQ', ['Common questions' => ['How do I post livestock? Register as a seller and wait for admin approval.','How do I contact an owner? Use Contact Owner, Call Owner, or WhatsApp Owner.','Does Zizini sell animals directly? No. Zizini only connects buyers and sellers.','Can I buy directly through the website? No.','Is payment done through Zizini? For this version, payments are handled directly between buyer and seller outside the platform.','How are sellers approved? Admin reviews and assigns access manually.','How long does a listing stay active? Admin controls listing duration, commonly 30 days.','Can a seller edit a listing? Yes, in the seller listing area.','How do I mark an animal as sold? Use Mark as sold in seller/admin listing actions.','Can I report a suspicious listing? Yes, from the listing detail page.','Will online payments be added later? They can be added as a future module.']]],
 'contact' => ['Contact Support', ['Support options' => ['Buyer support','Seller support','Report issue','Partnership inquiries']]],
 'safety' => ['Safety', ['Buyer checklist' => ['Inspect the animal physically','Verify ownership','Ask for health and vaccination history','Follow veterinary and movement rules','Do not send deposits to unknown parties'], 'Seller checklist' => ['Meet buyers safely','Keep records of inquiries','Mark sold animals promptly','Report suspicious buyers'], 'Platform boundary' => ['Zizini is a listing/contact platform, not a payment or escrow platform.']]],
];
[$heading,$sections] = $content[$page];
@endphp
<x-layouts.main title="{{ $heading }}">
    @if($page === 'about')
        <section class="mx-auto max-w-7xl px-4 py-12 lg:px-8">
            <div class="grid gap-10 lg:grid-cols-[1fr_.85fr] lg:items-center">
                <div>
                    <h1 class="font-display text-5xl leading-tight text-pasture">A practical livestock market for Kenyan farmers, buyers and dealers.</h1>
                    <p class="mt-5 text-lg leading-8 text-charcoal/75">Zizini.co.ke helps people discover cattle, goats, sheep, poultry and farm services without turning the website into a checkout platform. Buyers browse, compare and contact owners directly. Sellers get a cleaner way to present animals, build trust and manage inquiries.</p>
                    <div class="mt-7 flex flex-wrap gap-3"><a href="/marketplace" class="rounded-lg bg-pasture px-5 py-3 font-bold text-white">Browse Livestock</a><a href="/seller/register" class="rounded-lg border border-pasture px-5 py-3 font-bold text-pasture">Join as Seller</a></div>
                </div>
                <div class="overflow-hidden rounded-3xl bg-white shadow-xl">
                    <img src="/assets/livestock/cow-ayrshire.jpg" class="aspect-[4/3] w-full object-cover" alt="Cattle in a farm">
                    <div class="grid gap-3 p-5 sm:grid-cols-3">
                        <div class="rounded-xl bg-cream p-4"><p class="font-display text-2xl text-pasture">Direct</p><p class="text-sm text-charcoal/65">Call and WhatsApp owner contact.</p></div>
                        <div class="rounded-xl bg-cream p-4"><p class="font-display text-2xl text-pasture">Local</p><p class="text-sm text-charcoal/65">County-based livestock search.</p></div>
                        <div class="rounded-xl bg-cream p-4"><p class="font-display text-2xl text-pasture">Moderated</p><p class="text-sm text-charcoal/65">Admin approval before listings go live.</p></div>
                    </div>
                </div>
            </div>
            <div class="mt-12 grid gap-5 md:grid-cols-2 lg:grid-cols-4">
                @foreach(['Farmers' => 'Show animals clearly and receive serious calls.', 'Buyers' => 'Find livestock by county, category, breed and status.', 'Brokers' => 'Organize listings without pretending payment happens online.', 'Farms and dealers' => 'Use verified badges, featured visibility and controlled access.'] as $title => $copy)
                    <div class="rounded-2xl bg-white p-6 shadow-sm"><h2 class="font-display text-2xl text-pasture">{{ $title }}</h2><p class="mt-3 text-sm leading-6 text-charcoal/70">{{ $copy }}</p></div>
                @endforeach
            </div>
            <div class="mt-10 grid gap-6 lg:grid-cols-2">
                <div class="rounded-2xl bg-white p-7 shadow-sm"><h2 class="font-display text-3xl text-pasture">Mission</h2><p class="mt-3 text-charcoal/70">Make livestock discovery and seller contact easier across Kenya and East Africa.</p></div>
                <div class="rounded-2xl bg-pasture p-7 text-white shadow-sm"><h2 class="font-display text-3xl">Vision</h2><p class="mt-3 text-white/80">A trusted digital livestock marketplace for Africa, starting with a simple launch-ready contact marketplace.</p></div>
            </div>
        </section>
    @else
    <section class="mx-auto max-w-5xl px-4 py-10 lg:px-8">
        <h1 class="font-display text-4xl text-pasture">{{ $heading }}</h1>
        <div class="mt-8 grid gap-6">@foreach($sections as $title => $items)<div class="rounded-2xl bg-white p-6 shadow-sm"><h2 class="font-display text-2xl text-pasture">{{ $title }}</h2><ul class="mt-4 grid gap-3">@foreach($items as $item)<li class="rounded-lg bg-cream p-3 text-charcoal/75">{{ $item }}</li>@endforeach</ul></div>@endforeach</div>
        @if($page === 'contact')
            @if(session('status'))<div class="mt-6 rounded-xl bg-fresh/15 px-4 py-3 font-semibold text-pasture">{{ session('status') }}</div>@endif
            <form method="post" action="{{ route('prototype.status') }}" class="mt-8 rounded-2xl bg-white p-6 shadow-sm">@csrf<input type="hidden" name="message" value="Thanks. Zizini support has received your message for this demo build."><div class="grid gap-4 md:grid-cols-2"><input name="name" class="rounded-lg border border-earth/20 p-3" placeholder="Name"><input name="contact" class="rounded-lg border border-earth/20 p-3" placeholder="Phone or email"><textarea name="support_message" class="rounded-lg border border-earth/20 p-3 md:col-span-2" rows="5" placeholder="How can we help?"></textarea></div><button class="mt-4 rounded-lg bg-pasture px-5 py-3 font-bold text-white">Send Message</button></form>
        @endif
    </section>
    @endif
</x-layouts.main>
