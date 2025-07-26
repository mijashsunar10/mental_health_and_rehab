<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>

            @auth
            <flux:navlist variant="outline">
              
                <flux:navlist.group :heading="__('Platform')" class="grid">
                    <flux:navlist.item
                        icon="home"
                        {{-- <-- add this line --}}
                        :href="
                            auth()->user()->role === \App\Enums\UserRole::Admin 
                                ? route('admin.dashboard') 
                                : (auth()->user()->role === \App\Enums\UserRole::Doctor 
                                    ? route('doctor.dashboard') 
                                    : route('dashboard'))
                        "
                        :current="
                            request()->routeIs('dashboard') || 
                            request()->routeIs('admin.dashboard') || 
                            request()->routeIs('doctor.dashboard')
                        "
                        wire:navigate
                    >
                        {{ __('Dashboard') }}
                    </flux:navlist.item>

                      <flux:navlist.item
                            icon="home"
                            href="{{ route('home') }}"
                            :current="request()->routeIs('home')"
                            class="cursor-pointer me-5 flex items-center space-x-2 rtl:space-x-reverse mt-2"
                        >
                            {{ __('Home') }}
                        </flux:navlist.item>

                    
                    

              @php
                $user = auth()->user();
            @endphp

            {{-- @if($user && $user->role === 'admin')
                <flux:navlist.item icon="book-open-text" href="{{ route('admin.register') }}" target="_blank" class="mt-2 font-bold text-3xl">
                    {{ __('Register New Admin') }}
                </flux:navlist.item>

                <flux:navlist.item icon="book-open-text" href="{{ route('doctor.register') }}" target="_blank" class="mt-2 font-bold text-3xl">
                    {{ __('Register New Doctor') }}
                </flux:navlist.item>
            @endif --}}

               
                    @if(auth()->user()->role === \App\Enums\UserRole::Admin)
                        <flux:navlist.item
                            icon="users"
                            href="{{ route('admin.register') }}"
                            :current="request()->routeIs('admin.register')"
                            class="cursor-pointer me-5 flex items-center space-x-2 rtl:space-x-reverse mt-2"
                        >
                            {{ __('Register New Admin ') }}
                        </flux:navlist.item>
                    @endif

                    @if(auth()->user()->role === \App\Enums\UserRole::Admin)
                        <flux:navlist.item
                            icon="book-open-text"
                            href="{{ route('doctor.register') }}"
                            :current="request()->routeIs('doctor.register')"
                            class="cursor-pointer me-5 flex items-center space-x-2 rtl:space-x-reverse mt-2"
                        >
                            {{ __('Register New Doctor ') }}
                        </flux:navlist.item>
                    @endif
{{-- For Admin --}}
                @if(auth()->user()->role === \App\Enums\UserRole::Admin)
                    <flux:navlist.item
                        icon="users"
                        href="{{ route('users.index') }}"
                        :current="request()->routeIs('users.index')"
                        class="cursor-pointer me-5 flex items-center space-x-2 rtl:space-x-reverse mt-2"
                    >
                        {{ __('User List (Admin)') }}
                    </flux:navlist.item>
                @endif

                {{-- For Doctor --}}
                @if(auth()->user()->role === \App\Enums\UserRole::Doctor)
                    <flux:navlist.item
                        icon="users"
                        href="{{ route('users.index') }}"
                        :current="request()->routeIs('users.index')"
                        class="cursor-pointer me-5 flex items-center space-x-2 rtl:space-x-reverse mt-2"
                    >
                        {{ __('User List ') }}
                    </flux:navlist.item>
                @endif

            

              @if(auth()->user()->role === \App\Enums\UserRole::User)
                    <flux:navlist.item
                        icon="users"
                        href="{{ route('doctors.index') }}"
                        :current="request()->routeIs('doctors.index')"
                        class="cursor-pointer me-5 flex items-center space-x-2 rtl:space-x-reverse mt-2"
                    >
                        {{ __('Doctor List') }}
                    </flux:navlist.item>
                @endif





                @if(auth()->user()->role === \App\Enums\UserRole::Admin)
                        <flux:navlist.item
                            icon="users"
                            href="{{ route('doctors.index') }}"
                            :current="request()->routeIs('doctors.index')"
                            class="cursor-pointer me-5 flex items-center space-x-2 rtl:space-x-reverse mt-2"
                        >
                            {{ __('Doctor List') }}
                        </flux:navlist.item>
                @endif


             <flux:navlist.item icon="chat-bubble-oval-left-ellipsis" :href="route('chat')" :current="request()->routeIs('chat')" wire:navigate>{{ __('  Chat') }}</flux:navlist.item>


              

                @if(auth()->user()->role === \App\Enums\UserRole::Admin || auth()->user()->role === \App\Enums\UserRole::Doctor)
                <flux:navlist.item
                    icon="users"
                    href="{{ route('jitsi.meeting') }}"
                    :current="request()->routeIs('jitsi.meeting')"
                    onclick="return confirmAndOpenMeeting(event, '{{ route('jitsi.meeting') }}')"
                    class="cursor-pointer me-5 flex items-center space-x-2 rtl:space-x-reverse mt-2"
                >
                    {{ __('Start a Meeting') }}
                </flux:navlist.item>
            @endif

            @if(auth()->user()->role === \App\Enums\UserRole::Admin)
                        <flux:navlist.item
                            icon="plus"
                            href="{{ route('ourteam.create') }}"
                            :current="request()->routeIs('ourteam.create')"
                            class="cursor-pointer me-5 flex items-center space-x-2 rtl:space-x-reverse mt-2"
                        >
                            {{ __('Add Team Member') }}
                        </flux:navlist.item>
            @endif

             @if(auth()->user()->role === \App\Enums\UserRole::Admin)
                        <flux:navlist.item
                            icon="plus"
                            href="{{ route('faqs.create') }}"
                            :current="request()->routeIs('faqs.create')"
                            class="cursor-pointer me-5 flex items-center space-x-2 rtl:space-x-reverse mt-2"
                        >
                            {{ __('Add Faqs') }}
                        </flux:navlist.item>
            @endif

     

     


                    




                </flux:navlist.group>
            </flux:navlist>
            @endauth


            <flux:spacer />

            <flux:navlist variant="outline">
                <flux:navlist.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit" target="_blank">
                {{ __('Repository') }}
                </flux:navlist.item>

                <flux:navlist.item icon="book-open-text" href="https://laravel.com/docs/starter-kits#livewire" target="_blank">
                {{ __('Documentation') }}
                </flux:navlist.item>
            </flux:navlist>

            <!-- Desktop User Menu -->
            <flux:dropdown class="hidden lg:block" position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    {{-- :initials="auth()->user()->initials()" --}}
                    :avatar="auth()->user()->photo ?? null"
                    :initials="auth()->user()->photo ? null : auth()->user()->initials()"
                    icon:trailing="chevrons-up-down"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts

        <script>
            function confirmAndOpenMeeting(event, url) {
                event.preventDefault(); // Prevent default navigation
                if (confirm('Do you want to start a new meeting?')) {
                    window.open(url, '_blank'); // Open in a new tab
                }
                return false;
            }
        </script>

    </body>

</html>
