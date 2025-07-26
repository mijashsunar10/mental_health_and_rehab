@extends('template.template')
@section('pagecontent')
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        }

        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }

        .calendar-day {
            transition: all 0.2s ease;
        }

        .calendar-day:hover {
            transform: translateY(-1px);
        }

        .available-slot {
            background: linear-gradient(135deg, #10b981, #059669);
        }

        .unavailable-slot {
            background: linear-gradient(135deg, #ef4444, #dc2626);
        }

        .selected-slot {
            background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
<section class="bg-gray-50">
    <!-- Header Navigation -->

    <div class="max-w-7xl mx-auto">
        <!-- Hero Section -->
        <div class="gradient-bg text-white">
            <div class="px-6 py-12">
                <div class="flex flex-col lg:flex-row items-start gap-8">
                    <div
                        class="w-48 h-48 rounded-2xl overflow-hidden flex-shrink-0 border-4 border-white/20 shadow-2xl">
                        <img src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?w=400&h=400&fit=crop&crop=face"
                            alt="Dr. Anil Bhan" class="w-full h-full object-cover" />
                    </div>

                    <div class="flex-1">
                        <div class="mb-4">
                            <h1 class="text-4xl lg:text-5xl font-bold mb-3">Dr. Sangam Darlami</h1>
                            <p class="text-xl mb-2 text-blue-100"> Consultant Psychiatrist</p>
                            <p class="text-lg mb-3 text-blue-100">Calm Core Recovery ,Pokhara</p>
                            <div class="flex items-center gap-2 text-sm text-blue-100">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd"
                                        d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>NMC Number: CV789123</span>
                            </div>
                        </div>
                        <!-- department -->
                        <div class="flex flex-wrap gap-3 mb-6">
                            <span class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-medium">
                                D.N.B. (Psychiatry)
                            </span>
                            <span class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-medium">
                                MBBS </span>
                        </div>

                        <div class="grid grid-cols-3 gap-6 max-w-md">
                            <div class="text-center">
                                <div class="text-3xl font-bold mb-1">30+</div>
                                <div class="text-sm text-blue-100">Years Experience</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold mb-1">15K+</div>
                                <div class="text-sm text-blue-100">Sucessfully Patients treated</div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="lg:w-80 w-full">
                        <div class="glass-effect rounded-2xl p-6 shadow-xl">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Book Appointment</h3>
                            <div class="space-y-3">
                                <button onclick="showBookingModal()"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-xl transition-all duration-200 transform hover:scale-[1.02]">
                                    <div class="flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        Book Consultation
                                    </div>
                                </button>
                                <!-- <button
                                    class="w-full border-2 border-blue-600 text-blue-600 hover:bg-blue-50 font-medium py-3 px-4 rounded-xl transition-all duration-200">
                                    Video Consultation
                                </button> -->
                                <div class="pt-3 border-t border-gray-200">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex flex-col lg:flex-row gap-8 px-6 py-8">
            <!-- Left Content -->
            <div class="flex-1">
                <!-- Tab Navigation -->
                <div class="bg-white rounded-xl shadow-sm border mb-6">
                    <div class="flex gap-1 p-1">
                        <button
                            class="tab-btn flex-1 py-3 px-4 text-sm font-medium rounded-lg transition-all duration-200 bg-blue-50 text-blue-600"
                            data-tab="overview">
                            Overview
                        </button>
                        <button
                            class="tab-btn flex-1 py-3 px-4 text-sm font-medium rounded-lg transition-all duration-200 text-gray-600 hover:text-gray-800"
                            data-tab="experience">
                            Experience
                        </button>
                        <button
                            class="tab-btn flex-1 py-3 px-4 text-sm font-medium rounded-lg transition-all duration-200 text-gray-600 hover:text-gray-800"
                            data-tab="qualifications">
                            Qualifications
                        </button>
                        <button
                            class="tab-btn flex-1 py-3 px-4 text-sm font-medium rounded-lg transition-all duration-200 text-gray-600 hover:text-gray-800"
                            data-tab="awards">
                            Awards
                        </button>
                    </div>
                </div>

                <!-- Tab Contents -->
                <div class="bg-white rounded-xl shadow-sm border p-8">
                    <!-- Overview Tab -->
                    <div id="overview-content" class="tab-content animate-fade-in">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">About Dr. Sangam Darlami</h2>
                        <div class="prose max-w-none text-gray-700 leading-relaxed space-y-4">
                            <p>
                                As a pioneering member of the team that performed India's first successful Heart
                                Transplantation in 1994, Dr. Bhan has been instrumental in establishing cardiac surgical
                                programs at Puttaparthi (1992), Whitefield (2001), and Max Heart and Vascular Institute
                                Saket (2004).
                            </p>
                            <p>
                                Having performed over 15,000 cardiovascular surgeries, including complex aortic
                                surgeries, heart transplants, and pediatric cardiac procedures, Dr. Bhan's expertise in
                                minimally invasive cardiac surgery has revolutionized treatment approaches across India.
                            </p>
                        </div>

                        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-blue-50 rounded-xl p-6">
                                <h3 class="font-semibold text-gray-800 mb-4">Specializations</h3>
                                <div class="space-y-2">
                                    <div class="flex items-center gap-2 text-sm">
                                        <div class="w-2 h-2 bg-blue-600 rounded-full"></div>
                                        <span>Aortic Surgery</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-sm">
                                        <div class="w-2 h-2 bg-blue-600 rounded-full"></div>
                                        <span>Heart Transplantation</span>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-green-50 rounded-xl p-6">
                                <h3 class="font-semibold text-gray-800 mb-4">Languages</h3>
                                <div class="flex flex-wrap gap-2">
                                    <span class="bg-white px-3 py-1 rounded-full text-sm">English</span>
                                    <span class="bg-white px-3 py-1 rounded-full text-sm">Hindi</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Experience Tab -->
                    <div id="experience-content" class="tab-content hidden">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Professional Experience</h2>
                        <div class="space-y-6">
                            <div class="border-l-4 border-blue-600 pl-6">
                                <h3 class="text-lg font-semibold text-gray-800">Director & Head - Cardiovascular Surgery
                                </h3>
                                <p class="text-blue-600 font-medium">Medanta - The Medicity, Gurugram</p>
                                <p class="text-sm text-gray-600">2010 - Present</p>
                                <p class="text-gray-700 mt-2">Leading the cardiovascular surgery department with over
                                    2000 successful surgeries annually.</p>
                            </div>

                            <div class="border-l-4 border-gray-300 pl-6">
                                <h3 class="text-lg font-semibold text-gray-800">Senior Consultant</h3>
                                <p class="text-gray-600 font-medium">Max Heart and Vascular Institute</p>
                                <p class="text-sm text-gray-600">2004 - 2010</p>
                                <p class="text-gray-700 mt-2">Established and led the cardiac surgery program.</p>
                            </div>

                        </div>
                    </div>

                    <!-- Qualifications Tab -->
                    <div id="qualifications-content" class="tab-content hidden">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Educational Qualifications</h2>
                        <div class="space-y-4">
                            <div
                                class="bg-gradient-to-r from-blue-50 to-transparent rounded-xl p-6 border-l-4 border-blue-600">
                                <h3 class="text-lg font-semibold text-gray-800">Fellowship in Heart Transplantation</h3>
                                <p class="text-gray-600">University of Pittsburgh Medical Center, USA • 1994</p>
                            </div>

                            <div
                                class="bg-gradient-to-r from-yellow-50 to-transparent rounded-xl p-6 border-l-4 border-yellow-500">
                                <h3 class="text-lg font-semibold text-gray-800">MBBS (Gold Medalist)</h3>
                                <p class="text-gray-600">Medical College Srinagar • 1985</p>
                                <p class="text-sm text-yellow-600 font-medium">Best Outgoing Graduate</p>
                            </div>
                        </div>
                    </div>

                    <!-- Awards Tab -->
                    <div id="awards-content" class="tab-content hidden">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Awards & Recognition</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div
                                class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-xl p-6 border border-yellow-200">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-10 h-10 bg-yellow-500 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-800">Padma Bhushan</h3>
                                        <p class="text-sm text-gray-600">Government of India, 2010</p>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-700">For distinguished service in the field of medicine</p>
                            </div>

                            <div
                                class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-200">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-800">Dr. B.C. Roy Award</h3>
                                        <p class="text-sm text-gray-600">Medical Council of India, 2008</p>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-700">National Award for excellence in medicine</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar -->
            <div class="lg:w-96 space-y-6">
                <!-- Calendar Widget -->
                <div class="bg-white rounded-xl shadow-sm border p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Select Appointment Date</h3>
                    <div id="calendar-container">
                        <!-- Calendar will be generated here -->
                    </div>
                </div>

                <!-- Available Slots -->
                <div class="bg-white rounded-xl shadow-sm border p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Available Time Slots</h3>
                    <div id="time-slots-container">
                        <p class="text-gray-500 text-center py-4">Select a date to view available slots</p>
                    </div>
                </div>

                <!-- Quick Info -->
            </div>
        </div>
    </div>

    <!-- Booking Modal -->
    <div id="booking-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 transform transition-all duration-300 scale-95">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800">Confirm Appointment</h2>
                <button onclick="hideBookingModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="space-y-4">
                <div class="bg-gray-50 rounded-xl p-4">
                    <h3 class="font-semibold text-gray-800 mb-2">Dr. Anil Bhan</h3>
                    <p class="text-sm text-gray-600">Cardiovascular Surgery</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                        <div id="selected-date" class="bg-blue-50 p-3 rounded-lg text-sm font-medium text-blue-800">
                            Not selected
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Time</label>
                        <div id="selected-time" class="bg-blue-50 p-3 rounded-lg text-sm font-medium text-blue-800">
                            Not selected
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Patient Name</label>
                    <input type="text"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Enter patient name">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                    <input type="tel"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Enter phone number">
                </div>

                <div class="flex gap-3 pt-4">
                    <button onclick="hideBookingModal()"
                        class="flex-1 border border-gray-300 text-gray-700 py-3 rounded-lg font-medium hover:bg-gray-50">
                        Cancel
                    </button>
                    <button class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-medium">
                        Confirm Booking
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Global variables
        let selectedDate = null;
        let selectedTime = null;

        // Calendar functionality
        function generateCalendar() {
            const today = new Date();
            const currentMonth = today.getMonth();
            const currentYear = today.getFullYear();

            const monthNames = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"];

            const firstDay = new Date(currentYear, currentMonth, 1).getDay();
            const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();

            let calendarHTML = `
                <div class="flex items-center justify-between mb-4">
                    <h4 class="font-semibold text-gray-800">${monthNames[currentMonth]} ${currentYear}</h4>
                    <div class="flex gap-2">
                        <button class="p-1 hover:bg-gray-100 rounded">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>
                        <button class="p-1 hover:bg-gray-100 rounded">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="grid grid-cols-7 gap-1 mb-2">
                    <div class="text-center text-xs font-medium text-gray-500 py-2">Sun</div>
                    <div class="text-center text-xs font-medium text-gray-500 py-2">Mon</div>
                    <div class="text-center text-xs font-medium text-gray-500 py-2">Tue</div>
                    <div class="text-center text-xs font-medium text-gray-500 py-2">Wed</div>
                    <div class="text-center text-xs font-medium text-gray-500 py-2">Thu</div>
                    <div class="text-center text-xs font-medium text-gray-500 py-2">Fri</div>
                    <div class="text-center text-xs font-medium text-gray-500 py-2">Sat</div>
                </div>
                <div class="grid grid-cols-7 gap-1">
            `;

            // Empty cells for days before month starts
            for (let i = 0; i < firstDay; i++) {
                calendarHTML += '<div class="h-10"></div>';
            }

            // Days of the month
            for (let day = 1; day <= daysInMonth; day++) {
                const date = new Date(currentYear, currentMonth, day);
                const dateStr = date.toISOString().split('T')[0];
                const isToday = day === today.getDate() && currentMonth === today.getMonth() && currentYear === today.getFullYear();
                const isPast = date < today;
                const isWeekend = date.getDay() === 0 || date.getDay() === 6;

                let dayClass = 'calendar-day h-10 flex items-center justify-center text-sm cursor-pointer rounded-lg transition-all duration-200';

                if (isPast) {
                    dayClass += ' text-gray-300 cursor-not-allowed';
                } else if (isWeekend) {
                    dayClass += ' text-gray-400 cursor-not-allowed';
                } else {
                    dayClass += ' text-gray-700 hover:bg-blue-50 hover:text-blue-600';
                }

                if (isToday) {
                    dayClass += ' bg-blue-100 text-blue-600 font-semibold';
                }

                calendarHTML += `
                    <div class="${dayClass}" 
                         onclick="${!isPast && !isWeekend ? `selectDate('${dateStr}', ${day})` : ''}"
                         data-date="${dateStr}">
                        ${day}
                    </div>
                `;
            }

            calendarHTML += '</div>';
            document.getElementById('calendar-container').innerHTML = calendarHTML;
        }

        function selectDate(dateStr, day) {
            // Remove previous selection
            document.querySelectorAll('.calendar-day').forEach(el => {
                el.classList.remove('bg-blue-600', 'text-white', 'selected');
            });

            // Add selection to clicked date
            const selectedEl = document.querySelector(`[data-date="${dateStr}"]`);
            selectedEl.classList.add('bg-blue-600', 'text-white', 'selected');

            selectedDate = dateStr;
            generateTimeSlots(dateStr);

            // Update modal
            const date = new Date(dateStr);
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            document.getElementById('selected-date').textContent = date.toLocaleDateString('en-US', options);
        }

        function generateTimeSlots(dateStr) {
            const slots = [
                { time: '09:00 AM', available: true },
                { time: '09:30 AM', available: false },
                { time: '10:00 AM', available: true },
                { time: '10:30 AM', available: true },
                { time: '11:00 AM', available: false },
                { time: '11:30 AM', available: true },
                { time: '02:00 PM', available: true },
                { time: '02:30 PM', available: true },
                { time: '03:00 PM', available: false },
                { time: '03:30 PM', available: true },
                { time: '04:00 PM', available: true },
                { time: '04:30 PM', available: true }
            ];

            let slotsHTML = '<div class="grid grid-cols-2 gap-2">';

            slots.forEach(slot => {
                const slotClass = slot.available
                    ? 'available-slot text-white cursor-pointer hover:opacity-90 transform hover:scale-105'
                    : 'unavailable-slot text-white cursor-not-allowed opacity-60';

                slotsHTML += `
                    <div class="${slotClass} p-3 rounded-lg text-center text-sm font-medium transition-all duration-200"
                         onclick="${slot.available ? `selectTimeSlot('${slot.time}', this)` : ''}"
                         data-time="${slot.time}">
                        ${slot.time}
                        ${slot.available ? '' : '<div class="text-xs mt-1">Booked</div>'}
                    </div>
                `;
            });

            slotsHTML += '</div>';
            document.getElementById('time-slots-container').innerHTML = slotsHTML;
        }

        function selectTimeSlot(time, element) {
            // Remove previous selection
            document.querySelectorAll('[data-time]').forEach(el => {
                el.classList.remove('selected-slot');
                if (el.classList.contains('available-slot')) {
                    el.className = el.className.replace('selected-slot', 'available-slot');
                }
            });

            // Add selection to clicked slot
            element.classList.remove('available-slot');
            element.classList.add('selected-slot');

            selectedTime = time;
            document.getElementById('selected-time').textContent = time;
        }

        // Tab functionality
        function initializeTabs() {
            const tabButtons = document.querySelectorAll('.tab-btn');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const targetTab = button.getAttribute('data-tab');

                    // Remove active state from all tabs
                    tabButtons.forEach(btn => {
                        btn.classList.remove('bg-blue-50', 'text-blue-600');
                        btn.classList.add('text-gray-600');
                    });

                    // Add active state to clicked tab
                    button.classList.remove('text-gray-600');
                    button.classList.add('bg-blue-50', 'text-blue-600');

                    // Hide all tab contents
                    tabContents.forEach(content => {
                        content.classList.add('hidden');
                        content.classList.remove('animate-fade-in');
                    });

                    // Show target tab content with animation
                    const targetContent = document.getElementById(targetTab + '-content');
                    targetContent.classList.remove('hidden');
                    setTimeout(() => {
                        targetContent.classList.add('animate-fade-in');
                    }, 10);
                });
            });
        }

        // Modal functionality
        function showBookingModal() {
            if (!selectedDate || !selectedTime) {
                alert('Please select a date and time slot first.');
                return;
            }

            const modal = document.getElementById('booking-modal');
            modal.classList.remove('hidden');

            // Animate modal appearance
            setTimeout(() => {
                modal.querySelector('.bg-white').classList.remove('scale-95');
                modal.querySelector('.bg-white').classList.add('scale-100');
            }, 10);
        }

        function hideBookingModal() {
            const modal = document.getElementById('booking-modal');
            modal.querySelector('.bg-white').classList.remove('scale-100');
            modal.querySelector('.bg-white').classList.add('scale-95');

            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        // Smooth scroll for sticky elements
        function initializeScrollEffects() {
            window.addEventListener('scroll', () => {
                const navbar = document.querySelector('nav');
                if (window.scrollY > 50) {
                    navbar.classList.add('shadow-lg');
                } else {
                    navbar.classList.remove('shadow-lg');
                }
            });
        }

        // Initialize everything when DOM is loaded
        document.addEventListener('DOMContentLoaded', function () {
            generateCalendar();
            initializeTabs();
            initializeScrollEffects();

            // Close modal when clicking outside
            document.getElementById('booking-modal').addEventListener('click', function (e) {
                if (e.target === this) {
                    hideBookingModal();
                }
            });

            // Add keyboard support for modal
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') {
                    hideBookingModal();
                }
            });
        });

        // Add some interactive effects
        document.addEventListener('DOMContentLoaded', function () {
            // Add hover effects to cards
            const cards = document.querySelectorAll('.bg-white');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function () {
                    this.style.transform = 'translateY(-2px)';
                    this.style.boxShadow = '0 10px 25px rgba(0,0,0,0.1)';
                });

                card.addEventListener('mouseleave', function () {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = '';
                });
            });

            // Add loading states to buttons
            const buttons = document.querySelectorAll('button');
            buttons.forEach(button => {
                button.addEventListener('click', function (e) {
                    if (this.textContent.includes('Book') || this.textContent.includes('Confirm')) {
                        const originalText = this.textContent;
                        this.innerHTML = `
                            <div class="flex items-center justify-center gap-2">
                                <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Processing...
                            </div>
                        `;

                        setTimeout(() => {
                            this.textContent = originalText;
                        }, 2000);
                    }
                });
            });
        });
    </script>
</section>

@endsection