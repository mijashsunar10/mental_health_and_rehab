<x-layouts.app :title="__('Admin_Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative mb-6 w-full">
            <flux:heading size="xl" level="1" class="text-gray-800 dark:text-white">{{ __('Dashboard') }}</flux:heading>
            <flux:subheading size="lg" class="mb-6 text-gray-600 dark:text-gray-300">{{ __('Account Settings') }}</flux:subheading>
            <flux:separator variant="subtle" class="dark:border-gray-700" />
        </div>

        @if(session('success'))
            <div class="p-4 mb-6 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-900 dark:text-green-200">
                {{ session('success') }}
            </div>
        @endif

        <!-- Settings Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Appearance Settings Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 border-l-4 border-indigo-500 dark:border-indigo-400">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="p-3 rounded-full bg-indigo-100 text-indigo-600 dark:bg-indigo-900 dark:text-indigo-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                            </svg>
                        </div>
                        <h3 class="ml-3 text-lg font-semibold text-gray-800 dark:text-white">Appearance</h3>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">Customize theme, layout and visual preferences</p>
                    <a href="/settings/appearance" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors duration-300 dark:bg-indigo-500 dark:hover:bg-indigo-600">
                        Customize Appearance
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Password Change Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 border-l-4 border-blue-500 dark:border-blue-400">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600 dark:bg-blue-900 dark:text-blue-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <h3 class="ml-3 text-lg font-semibold text-gray-800 dark:text-white">Password</h3>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">Update your account password and security settings</p>
                    <a href="/settings/password" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-300 dark:bg-blue-500 dark:hover:bg-blue-600">
                        Change Password
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Profile Update Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 border-l-4 border-purple-500 dark:border-purple-400">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600 dark:bg-purple-900 dark:text-purple-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h3 class="ml-3 text-lg font-semibold text-gray-800 dark:text-white">Profile</h3>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">Update your personal information and contact details</p>
                    <a href="/settings/profile" class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition-colors duration-300 dark:bg-purple-500 dark:hover:bg-purple-600">
                        Edit Profile
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>