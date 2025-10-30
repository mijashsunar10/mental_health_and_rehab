@extends('template.template')

@section('pagecontent')
    <style>
        @media print {
            #header, #footer, .no-print {
                display: none !important;
            }
            body {
                margin: 0;
                padding: 0;
            }
            .receipt-container {
                margin: 0 !important;
                padding: 20px !important;
            }
        }
    </style>

    <div class=" mt-18 py-8 receipt-container">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if (session()->has('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg no-print">
                    {{ session('success') }}
                </div>
            @endif

            @if (session()->has('info'))
                <div class="mb-4 p-4 bg-blue-100 border border-blue-400 text-blue-700 rounded-lg no-print">
                    {{ session('info') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <!-- Receipt Header -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-8 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-bold mb-2">Payment Receipt</h1>
                            <p class="text-blue-100">Thank you for your payment</p>
                        </div>
                        <div class="text-right">
                            <div class="bg-white text-blue-600 px-4 py-2 rounded-lg">
                                <svg class="w-12 h-12 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <p class="text-xs font-semibold mt-1">PAID</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Receipt Body -->
                <div class="p-8">
                    <!-- Transaction Details -->
                    <div class="grid grid-cols-2 gap-6 mb-8">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Receipt Number</p>
                            <p class="text-lg font-semibold text-gray-800">#{{ $appointment->id }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500 mb-1">Payment Date</p>
                            <p class="text-lg font-semibold text-gray-800">{{ $appointment->payment_date->format('M d, Y g:i A') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Transaction ID</p>
                            <p class="text-lg font-semibold text-gray-800">{{ $appointment->transaction_id }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500 mb-1">Payment Method</p>
                            <p class="text-lg font-semibold text-gray-800">Khalti</p>
                        </div>
                    </div>

                    <hr class="my-6">

                    <!-- Patient & Doctor Details -->
                    <div class="grid md:grid-cols-2 gap-6 mb-8">
                        <div class="bg-gray-50 rounded-xl p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Patient Information</h3>
                            <div class="space-y-3">
                                <div>
                                    <p class="text-sm text-gray-500">Name</p>
                                    <p class="font-medium text-gray-800">{{ $appointment->patient->name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Email</p>
                                    <p class="font-medium text-gray-800">{{ $appointment->patient->email ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Phone</p>
                                    <p class="font-medium text-gray-800">{{ $appointment->patient->phone ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-blue-50 rounded-xl p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Doctor Information</h3>
                            <div class="space-y-3">
                                <div>
                                    <p class="text-sm text-gray-500">Name</p>
                                    <p class="font-medium text-gray-800">{{ $appointment->doctor->name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Specialization</p>
                                    <p class="font-medium text-gray-800">{{ $appointment->doctor->specialization ?? 'Psychiatrist' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">NMC Number</p>
                                    <p class="font-medium text-gray-800">{{ $appointment->doctor->nmc_number ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Appointment Details -->
                    <div class="bg-green-50 rounded-xl p-6 mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Appointment Details</h3>
                        <div class="grid md:grid-cols-3 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Date</p>
                                <p class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('l, F d, Y') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Time</p>
                                <p class="font-medium text-gray-800">
                                    {{ \Carbon\Carbon::parse($appointment->start_time)->format('g:i A') }} -
                                    {{ \Carbon\Carbon::parse($appointment->end_time)->format('g:i A') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Appointment Type</p>
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-medium
                                    {{ $appointment->appointment_type === 'physical' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                    @if($appointment->appointment_type === 'physical')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                        Physical Visit
                                    @else
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                        Virtual Call
                                    @endif
                                </span>
                            </div>
                        </div>

                        @if($appointment->patient_notes)
                            <div class="mt-4 pt-4 border-t border-green-200">
                                <p class="text-sm text-gray-500 mb-1">Reason for Visit</p>
                                <p class="text-gray-700">{{ $appointment->patient_notes }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Payment Summary -->
                    <div class="bg-gray-100 rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Payment Summary</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Consultation Fee</span>
                                <span class="font-medium text-gray-800">Rs. {{ number_format($appointment->payment_amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between pt-3 border-t-2 border-gray-300">
                                <span class="text-lg font-semibold text-gray-800">Total Paid</span>
                                <span class="text-lg font-bold text-blue-600">Rs. {{ number_format($appointment->payment_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-8 flex gap-4 no-print">
                        <button onclick="window.print()" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition-colors">
                            <div class="flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                </svg>
                                Print Receipt
                            </div>
                        </button>
                        <a href="{{ route('home') }}" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-medium py-3 px-6 rounded-lg transition-colors text-center">
                            <div class="flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                Back to Home
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Footer Note -->
                <div class="bg-gray-50 px-8 py-4 text-center">
                    <p class="text-sm text-gray-600">
                        This is an official receipt for your appointment payment. Please keep this for your records.
                    </p>
                    <p class="text-xs text-gray-500 mt-2">
                        If you have any questions, please contact our support team.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
