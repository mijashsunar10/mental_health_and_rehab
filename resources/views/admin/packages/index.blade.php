@extends('template.template')

@section('pagecontent')
    <div class="bg-white rounded-lg shadow-md p-6 mt-20 max-w-[80%] mx-auto">
        <!-- Header with controls -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <h1 class="text-2xl font-bold text-blue-800">Addiction Treatment Packages</h1>
            
            <div class="flex flex-col sm:flex-row items-end sm:items-center gap-3 w-full md:w-auto">
                <!-- View toggle -->
                <div class="flex bg-gray-100 rounded-lg p-1">
                  
                    @auth
                        @if(auth()->user()->role === \App\Enums\UserRole::Admin)
                        
                                <button id="tableViewBtn" class="px-3 py-1 rounded-lg bg-blue-600 text-white flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5 4a1 1 0 00-1 1v2a1 1 0 001 1h2a1 1 0 001-1V5a1 1 0 00-1-1H5zm0 4a1 1 0 00-1 1v2a1 1 0 001 1h2a1 1 0 001-1V9a1 1 0 00-1-1H5zm5-4a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 01-1 1h-2a1 1 0 01-1-1V5zm0 4a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 01-1 1h-2a1 1 0 01-1-1V9zm5-5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1h2a1 1 0 001-1V5zm0 4a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1h2a1 1 0 001-1V9z" clip-rule="evenodd" />
                                    </svg>
                                    Table
                                </button>

                        @endif
                    @endauth
                    <button id="cardViewBtn" class="px-3 py-1 rounded-lg flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        Cards
                    </button>
                </div>
                
                <!-- Filter dropdown -->
                <select id="packageFilter" class="border border-gray-300 rounded-md px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="all">All Packages</option>
                    <option value="online">Online Only</option>
                    <option value="offline">Offline Only</option>
                </select>
                @auth
                    @if(auth()->user()->role === \App\Enums\UserRole::Admin)
                    
                    <!-- Create button -->
                        <a href="{{ route('admin.packages.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm whitespace-nowrap">
                            Create New Package
                        </a>
                @endif
                @endauth
            </div>
        </div>

                @auth
                 @if(auth()->user()->role === \App\Enums\UserRole::Admin)

                    <!-- Table View -->
                    <div id="tableView" class="overflow-x-auto">
                        <table class="min-w-full bg-white divide-y divide-gray-200">
                            <thead class="bg-blue-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-blue-800 uppercase tracking-wider">Image</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-blue-800 uppercase tracking-wider">Title</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-blue-800 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-blue-800 uppercase tracking-wider">Options</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-blue-800 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($packages as $package)
                                    <tr class="package-row" data-type="{{ $package->type }}">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($package->image)
                                                <img src="{{ asset('storage/'.$package->image) }}" alt="{{ $package->title }}" class="w-12 h-12 object-cover rounded-md">
                                            @else
                                                <div class="w-12 h-12 bg-blue-100 rounded-md flex items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $package->title }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 rounded-full text-xs 
                                                {{ $package->type === 'online' ? 'bg-green-500 text-white' : 'bg-green-500 text-white' }}">
                                                {{ ucfirst($package->type) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            @foreach($package->options as $option)
                                                <div class="text-sm text-gray-600 mb-1">
                                                    <span class="font-medium">{{ $option['name'] }}</span> - 
                                                    ${{ number_format($option['price'], 2) }} ({{ $option['duration'] }})
                                                </div>
                                            @endforeach
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('admin.packages.show', $package) }}" class="text-blue-600 hover:text-blue-900" title="View">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                                    </svg>

                                                </a>

                                                @auth
                                                @if(auth()->user()->role === \App\Enums\UserRole::Admin)
                                                <a href="{{ route('admin.packages.edit', $package) }}" class="text-blue-600 hover:text-blue-900" title="Edit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                    </svg>
                                                </a>
                                                <form action="{{ route('admin.packages.destroy', $package) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this package?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Delete">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                                </form>
                                                @endif
                                                @endauth
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                @endif
                @endauth



        <!-- Card View -->
        <!-- Card View -->
       <!-- Card View -->
            <div id="cardView" class="hidden grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($packages as $package)
                    <div class="package-card bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden hover:shadow-lg transition-transform transform hover:-translate-y-1 duration-300" data-type="{{ $package->type }}">
                        
                        <!-- Image -->
                        <div class="h-44 bg-gray-100 relative">
                            @if($package->image)
                                <img src="{{ asset('storage/'.$package->image) }}" alt="{{ $package->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                            <span class="absolute top-2 right-2 px-3 py-1 rounded-full text-xs font-semibold 
                                {{ $package->type === 'online' ? 'bg-green-500 text-white' : 'bg-green-500 text-white' }}">
                                {{ ucfirst($package->type) }}
                            </span>
                        </div>

                        <!-- Content -->
                        <div class="p-5">
                            <!-- Package Title -->
                            <h3 class="font-bold text-lg text-gray-900 mb-4 truncate">{{ $package->title }}</h3>

                            <!-- Options as vertical rows -->
                            <div class="space-y-3 mb-5">
                                @foreach($package->options as $option)
                                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-100 text-sm space-y-1">
                                        <p><span class="font-semibold text-gray-900">👨‍⚕ Doctor:</span> {{ $option['name'] }}</p>
                                        <p><span class="font-semibold text-gray-900">💲 Price:</span> <span class="text-green-600 font-medium">${{ number_format($option['price'], 2) }}</span></p>
                                        <p><span class="font-semibold text-gray-900">⏳ Duration:</span> {{ $option['duration'] }}</p>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Actions -->
                            <div class="flex justify-between items-center">
                                <!-- Admin actions -->
                                <div class="flex space-x-2">
                                   <a href="{{ route('admin.packages.show', $package) }}" 
                                                class="flex items-center gap-1 text-blue-600 hover:text-blue-800 px-3 py-2 rounded-lg hover:bg-blue-50 transition"
                                                title="View">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                                    </svg>
                                                    <span>View</span>
                                                </a>


                                      @auth
                                        @if(auth()->user()->role === \App\Enums\UserRole::Admin)


                                    <a href="{{ route('admin.packages.edit', $package) }}" class="text-yellow-600 hover:text-yellow-800 p-2 rounded-full hover:bg-yellow-50" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.packages.destroy', $package) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this package?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 p-2 rounded-full hover:bg-red-50" title="Delete">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </form>

                                    @endif
                                    @endauth
                                </div>

                                <div x-data="{ showRegisterModal: false }" class="relative">

        <!-- Buy Now button -->
        @if($package->type === 'online')
            @guest
                <button @click="showRegisterModal = true" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm transition">
                    Buy Now
                </button>
            @else
                <a href="{{ route('packages.purchase', $package) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm transition">
                    Buy Now
                </a>
            @endguest
        @endif
     <!-- Modal (overlay) -->
    <div
        x-cloak
        x-show="showRegisterModal"
        x-transition.opacity
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">

        <!-- Modal panel -->
        <div
            x-show="showRegisterModal"
            x-transition.scale.origin.center
            @click.outside="showRegisterModal = false"
            class="w-[90%] max-w-md bg-white rounded-xl shadow-lg p-6 relative">

            <!-- Close -->
            <button
                @click="showRegisterModal = false"
                class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
                ✕
            </button>

            <h2 class="text-lg font-semibold text-gray-900 mb-2">Register Required</h2>
            <p class="text-gray-600 mb-6">
                Before buying this package, you have to register an account.
            </p>

            <div class="flex justify-end gap-3">
                <button
                    @click="showRegisterModal = false"
                    class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-800">
                    Cancel
                </button>
                <a href="{{ route('register') }}"
                   class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white">
                    Register
                </a>
            </div>
        </div>
    </div>
</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // View Toggle
            const tableViewBtn = document.getElementById('tableViewBtn');
            const cardViewBtn = document.getElementById('cardViewBtn');
            const tableView = document.getElementById('tableView');
            const cardView = document.getElementById('cardView');
            
            // Set default view (table)
             // Default view
            if (tableView) {
                tableView.classList.remove('hidden');
                cardView.classList.add('hidden');
                tableViewBtn?.classList.add('bg-blue-600', 'text-white');
            } else {
                // If no table exists (non-admin), show cards
                cardView.classList.remove('hidden');
                cardViewBtn?.classList.add('bg-blue-600', 'text-white');
            }

            tableViewBtn?.addEventListener('click', function() {
                if (tableView) tableView.classList.remove('hidden');
                cardView.classList.add('hidden');
                tableViewBtn.classList.add('bg-blue-600', 'text-white');
                cardViewBtn.classList.remove('bg-blue-600', 'text-white');
            });

            cardViewBtn?.addEventListener('click', function() {
                if (tableView) tableView.classList.add('hidden');
                cardView.classList.remove('hidden');
                tableViewBtn?.classList.remove('bg-blue-600', 'text-white');
                cardViewBtn.classList.add('bg-blue-600', 'text-white');
            });
            
            // Filter Functionality
            const packageFilter = document.getElementById('packageFilter');
            
            packageFilter.addEventListener('change', function() {
                const filterValue = this.value;
                const packageRows = document.querySelectorAll('.package-row');
                const packageCards = document.querySelectorAll('.package-card');
                
                packageRows.forEach(row => {
                    if (filterValue === 'all' || row.dataset.type === filterValue) {
                        row.classList.remove('hidden');
                    } else {
                        row.classList.add('hidden');
                    }
                });
                
                packageCards.forEach(card => {
                    if (filterValue === 'all' || card.dataset.type === filterValue) {
                        card.classList.remove('hidden');
                    } else {
                        card.classList.add('hidden');
                    }
                });
            });
        });
    </script>
@endsection