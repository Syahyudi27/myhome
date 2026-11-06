  <nav class="relative w-full flex items-center justify-center px-[75px] sm:text-center">
        <div class="fixed top-0 flex items-center justify-between w-full max-w-[1130px] rounded-xl p-4 bg-white mt-[30px] z-30">
            <a href="{{ route('front.index') }}" class="flex shrink-0">
                <img src="{{ asset('assets/images/logos/logo-black.svg') }}" alt="logo">
            </a>
            <ul class="flex items-center gap-[30px]">
                <li class="group active">
                    <a href="{{ route('front.index') }}" class="hover:font-bold group-[.active]:font-bold transition-all duration-300">Home</a>
                </li>
                <li class="group">
                    <a href="#" class="hover:font-bold group-[.active]:font-bold transition-all duration-300">Browse</a>
                </li>
                <li class="group">
                    <a href="#" class="hover:font-bold group-[.active]:font-bold transition-all duration-300">Rewards</a>
                </li>
                <li class="group">
                    <a href="#" class="hover:font-bold group-[.active]:font-bold transition-all duration-300">Stories</a>
                </li>
            </ul>
            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}" class="group rounded-xl border border-tedja-black py-[14px] px-5 hover:bg-tedja-black flex items-center transition-all duration-300">
                    <span class="font-semibold group-hover:text-white transition-all duration-300">Sign In</span>
                </a>
                <a href="{{ route('register') }}" class="group rounded-xl border border-tedja-black py-[14px] px-5 hover:bg-tedja-black flex items-center transition-all duration-300">
                    <span class="font-semibold group-hover:text-white transition-all duration-300">Sign Up</span>
                </a>
            </div>
        </div>
    </nav>