<div>
    <div class="min-h-screen flex items-center justify-center bg-cover bg-center bg-no-repeat bg-fixed" 
         style="background-image: url('https://images.unsplash.com/photo-1576091160550-2173dba999ef?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');">
        
        <div class="backdrop-blur-sm  w-full">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8 flex justify-center">
                <div class="w-full max-w-md">
                    <div class="text-center mb-8">
                        <h2 class="text-4xl font-bold text-white mb-2">
                            Register New Dcotor
                        </h2>
                        <p class="text-lg text-white">
                            Create a new administrator account for Calcore Recovery
                        </p>
                    </div>

                    <div class="bg-white rounded-xl shadow-2xl border border-gray-200 overflow-hidden transition-all duration-300 hover:shadow-3xl">
                        @if(session('success'))
                            <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-6 flex items-center">
                                <svg class="h-6 w-6 mr-2 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <span class="font-medium">{{ session('success') }}</span>
                            </div>
                        @endif

                        <div class="p-8">
                            <form class="space-y-6" wire:submit.prevent="register" enctype="multipart/form-data">
                                <div>
                                    <label for="name" class="block text-lg font-medium text-gray-800 mb-1">Full Name</label>
                                    <input id="name" name="name" type="text" wire:model="name" required
                                        class="w-full px-4 py-3 text-gray-800 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 placeholder-gray-500"
                                        placeholder="John Doe">
                                    @error('name'))
                                        <p class="mt-2 text-red-600 flex items-center text-sm">
                                            <svg class="h-5 w-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                  <div>
                                    <label for="nmc_number" class="block text-lg font-medium text-gray-800 mb-1">NMC NUMBER</label>
                                    <input id="nmc_number" name="nmc_number" type="text" wire:model="nmc_number" required
                                        class="w-full px-4 py-3 text-gray-800 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 placeholder-gray-500"
                                        placeholder="John Doe">
                                    @error('nmc_number'))
                                        <p class="mt-2 text-red-600 flex items-center text-sm">
                                            <svg class="h-5 w-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-lg font-medium text-gray-800 mb-1">Email Address</label>
                                    <input id="email" name="email" type="email" wire:model="email" required
                                        class="w-full px-4 py-3 text-gray-800 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 placeholder-gray-500"
                                        placeholder="admin@calcorerecovery.com">
                                    @error('email'))
                                        <p class="mt-2 text-red-600 flex items-center text-sm">
                                            <svg class="h-5 w-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                {{-- <input type="file" wire:model="photo"> --}}

                             


                                <div>
                                    <label for="password" class="block text-lg font-medium text-gray-800 mb-1">Password</label>
                                    <div class="relative">
                                        <input id="password" name="password" type="password" wire:model="password" required
                                            class="w-full px-4 py-3 text-gray-800 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 placeholder-gray-500"
                                            placeholder="••••••••"
                                            x-ref="password">
                                        <button type="button" 
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-blue-600"
                                            x-data="{ show: false }" 
                                            @click="show = !show; $refs.password.type = show ? 'text' : 'password'">
                                            <svg x-show="!show" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <svg x-show="show" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                            </svg>
                                        </button>
                                    </div>
                                    @error('password'))
                                        <p class="mt-2 text-red-600 flex items-center text-sm">
                                            <svg class="h-5 w-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password_confirmation" class="block text-lg font-medium text-gray-800 mb-1">Confirm Password</label>
                                    <input id="password_confirmation" name="password_confirmation" type="password" wire:model="password_confirmation" required
                                        class="w-full px-4 py-3 text-gray-800 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 placeholder-gray-500"
                                        placeholder="••••••••">
                                </div>
                                <div>
                                    <button type="submit"
                                        class="w-full py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md transition duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                        <span class="flex items-center justify-center">
                                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                            Register Doctor
                                        </span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>