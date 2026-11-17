<footer class="w-full bg-blue border-t border-tedja-border mt-[80px]">
    <div class="w-full max-w-[1280px] px-[75px] py-[60px] mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-10 pb-[50px] border-b border-tedja-border">
            {{-- Kolom 1: Brand & Deskripsi Singkat --}}
            <div class="md:col-span-5 flex flex-col gap-5">
                <a href="{{ route('front.index') }}" class="flex items-center gap-2 w-fit">
                    <span class="font-bold text-2xl text-tedja-black">MyHome</span>
                </a>
                <p class="text-sm text-tedja-secondary leading-7 max-w-[360px]">
                    Platform pencarian properti dan simulasi KPR terpercaya dengan developer bersertifikat untuk membantu Anda menemukan hunian impian.
                </p>
                <div class="flex items-center gap-3 mt-1">
                    <a href="#" aria-label="Instagram"
                        class="flex items-center justify-center size-10 rounded-full border border-tedja-border hover:border-tedja-black transition-all duration-300">
                        <span class="font-semibold text-xs">IG</span>
                    </a>
                    <a href="#" aria-label="YouTube"
                        class="flex items-center justify-center size-10 rounded-full border border-tedja-border hover:border-tedja-black transition-all duration-300">
                        <span class="font-semibold text-xs">YT</span>
                    </a>
                    <a href="#" aria-label="TikTok"
                        class="flex items-center justify-center size-10 rounded-full border border-tedja-border hover:border-tedja-black transition-all duration-300">
                        <span class="font-semibold text-xs">TT</span>
                    </a>
                </div>
            </div>

            {{-- Kolom 2: Navigasi Utama (Selaras dengan Navbar) --}}
            <div class="md:col-span-2 flex flex-col gap-4">
                <h3 class="font-bold text-base text-tedja-black">Explore</h3>
                <ul class="flex flex-col gap-3 text-sm text-tedja-secondary">
                    <li>
                        <a href="{{ route('front.index') }}" class="hover:text-tedja-blue transition-all duration-300">Home</a>
                    </li>
                    <li>
                        <a href="#" class="hover:text-tedja-blue transition-all duration-300">Browse Houses</a>
                    </li>
                    <li>
                        <a href="#" class="hover:text-tedja-blue transition-all duration-300">Rewards</a>
                    </li>
                    <li>
                        <a href="#" class="hover:text-tedja-blue transition-all duration-300">Stories</a>
                    </li>
                </ul>
            </div>

            {{-- Kolom 3: Layanan & KPR --}}
            <div class="md:col-span-2 flex flex-col gap-4">
                <h3 class="font-bold text-base text-tedja-black">Services</h3>
                <ul class="flex flex-col gap-3 text-sm text-tedja-secondary">
                    <li>
                        <a href="#" class="hover:text-tedja-blue transition-all duration-300">Simulasi KPR</a>
                    </li>
                    <li>
                        <a href="#" class="hover:text-tedja-blue transition-all duration-300">Certified Developers</a>
                    </li>
                    <li>
                        <a href="#" class="hover:text-tedja-blue transition-all duration-300">Learn Property</a>
                    </li>
                    <li>
                        <a href="#" class="hover:text-tedja-blue transition-all duration-300">List Your Property</a>
                    </li>
                </ul>
            </div>

            {{-- Kolom 4: Bantuan & Kontak --}}
            <div class="md:col-span-3 flex flex-col gap-4">
                <h3 class="font-bold text-base text-tedja-black">Support & Contact</h3>
                <ul class="flex flex-col gap-3 text-sm text-tedja-secondary">
                    <li>
                        <a href="#" class="hover:text-tedja-blue transition-all duration-300">Help Center</a>
                    </li>
                    <li>
                        <a href="#" class="hover:text-tedja-blue transition-all duration-300">Privacy Policy</a>
                    </li>
                    <li>
                        <a href="#" class="hover:text-tedja-blue transition-all duration-300">Terms & Conditions</a>
                    </li>
                    <li class="font-medium text-tedja-black pt-1">
                        halo@myhome.test
                    </li>
                </ul>
            </div>
        </div>

        {{-- Bagian Bawah: Copyright --}}
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-[30px] text-sm text-tedja-secondary">
            <p>&copy; {{ date('Y') }} MyHome. All rights reserved.</p>
            <p>All your privacy data secured.</p>
        </div>
    </div>
</footer>