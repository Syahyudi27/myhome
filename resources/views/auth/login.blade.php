@extends('layouts.master')
@section('title', 'Sign In - Homi')

@section('content')
    <!-- Navigation Bar -->
    <x-nav-home />

    <main class="flex min-h-screen">
        <form action="{{ route('login') }}" method="POST"
            class="flex items-center flex-1 pl-[calc(((100%-1280px)/2)+75px)] pt-[114px]">
            @csrf
            <div class="flex flex-col h-fit w-[500px] shrink-0 rounded-[20px] border border-tedja-border p-[30px] gap-5 bg-white">
                <h1 class="font-bold text-[28px] leading-[42px]">Sign In to My Account</h1>
                
                <div class="flex flex-col gap-2">
                    <label for="email" class="font-semibold">Email Address</label>
                    <div class="relative">
                        <img src="{{ asset('assets/images/icons/sms.svg') }}"
                            class="absolute size-6 transform -translate-y-1/2 top-1/2 left-5" alt="icon">
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                            class="appearance-none outline-none w-full rounded-full ring-1 ring-tedja-border py-[14px] pl-[54px] px-5 font-semibold placeholder:font-normal focus:ring-1 focus:ring-tedja-blue transition-all duration-300"
                            placeholder="Type your email address">
                    </div>
                    @error('email')
                        <span class="text-sm text-tedja-red">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex flex-col gap-2">
                    <label for="password" class="font-semibold">Password</label>
                    <div class="relative">
                        <img src="{{ asset('assets/images/icons/lock.svg') }}"
                            class="absolute size-6 transform -translate-y-1/2 top-1/2 left-5" alt="icon">
                        <input type="password" id="password" name="password" required
                            class="appearance-none outline-none w-full rounded-full ring-1 ring-tedja-border py-[14px] pl-[54px] px-5 font-semibold placeholder:font-normal focus:ring-1 focus:ring-tedja-blue transition-all duration-300"
                            placeholder="Type your password">
                    </div>
                    @error('password')
                        <span class="text-sm text-tedja-red">{{ $message }}</span>
                    @enderror
                    <a href="{{ route('password.request') }}" class="hover:underline text-sm w-fit">Forgot my password</a>
                </div>

                <button type="submit"
                    class="rounded-full py-[14px] px-5 bg-tedja-green w-full text-center font-semibold">
                    Sign In
                </button>
            </div>
        </form>

        <div class="relative flex w-full max-w-[640px]">
            <div class="fixed top-0 h-screen w-full max-w-[640px] overflow-hidden">
                <img src="{{ asset('assets/images/backgrounds/login-banner.png') }}" class="w-full h-full object-cover" alt="banner">
                <div class="absolute bottom-0 w-full px-[30px] pb-[30px]">
                    <div class="flex flex-col rounded-[30px] border border-tedja-border p-4 gap-[14px] bg-white">
                        <div class="flex">
                            @for ($i = 0; $i < 5; $i++)
                                <img src="{{ asset('assets/images/icons/Star 1.svg') }}" class="flex shrink-0" alt="star">
                            @endfor
                        </div>
                        <p class="font-semibold leading-[28px]">Tedja by Angga membantu kami mendapatkan rumah idaman dengan
                            interest yang rendah, gaji UMR juga bisa hidup bahagia!</p>
                        <div class="flex items-center gap-[14px]">
                            <div class="flex size-[60px] rounded-full overflow-hidden">
                                <img src="{{ asset('assets/images/photos/profile.png') }}" class="w-full h-full object-cover"
                                    alt="photo profile">
                            </div>
                            <div>
                                <p class="font-semibold">Sarina Dwi</p>
                                <p class="text-sm text-tedja-secondary">House Designer</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection