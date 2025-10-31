<div class="space-y-4">
    @forelse($purchases as $purchase)
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-3">
                        <h3 class="text-lg font-semibold text-gray-800">
                            {{ $purchase->package->title }}
                        </h3>
                        <span class="px-3 py-1 rounded-full text-xs font-medium
                            {{ $purchase->status === 'active' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $purchase->status === 'completed' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $purchase->status === 'expired' ? 'bg-gray-100 text-gray-800' : '' }}">
                            {{ ucfirst($purchase->status) }}
                        </span>
                    </div>

                    <p class="text-sm text-gray-600 mb-4">{{ $purchase->package->description }}</p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                        <div class="flex items-center text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <div>
                                <p class="font-medium">Amount Paid</p>
                                <p class="text-gray-600">NPR {{ number_format($purchase->amount, 2) }}</p>
                            </div>
                        </div>

                        @if($purchase->selected_option && is_array($purchase->selected_option))
                            <div class="flex items-center text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                <div>
                                    <p class="font-medium">Sessions</p>
                                    <p class="text-gray-600">{{ $purchase->selected_option['sessions'] ?? 'N/A' }} sessions</p>
                                </div>
                            </div>
                        @endif

                        <div class="flex items-center text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <div>
                                <p class="font-medium">Duration</p>
                                <p class="text-gray-600">
                                    {{ \Carbon\Carbon::parse($purchase->start_date)->format('M d, Y') }} -
                                    {{ \Carbon\Carbon::parse($purchase->end_date)->format('M d, Y') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    @if($purchase->payment)
                        <div class="mt-4 p-3 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-700">
                                <strong>Payment Method:</strong> {{ ucfirst($purchase->payment->payment_method ?? 'N/A') }}
                                @if($purchase->payment->transaction_id)
                                    | <strong>Transaction ID:</strong> {{ $purchase->payment->transaction_id }}
                                @endif
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-xl shadow-md p-12 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No packages</h3>
            <p class="text-gray-600">This patient hasn't purchased any packages.</p>
        </div>
    @endforelse
</div>
