<!DOCTYPE html>
<html>
<head>
    <title>Create Doctor Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Create Doctor Profile</h1>
            <a href="{{ route('doctors.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Back</a>
        </div>

        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <form action="{{ route('doctors.store') }}" method="POST">
                @csrf

                <!-- Display current user info -->
                <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Doctor Name
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 bg-gray-100" 
                            value="{{ auth()->user()->name }}" readonly>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            NMC Number
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 bg-gray-100" 
                            value="{{ auth()->user()->nmc_number }}" readonly>
                    </div>
                </div>

                <!-- Rest of your form remains the same -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <h2 class="text-xl font-semibold border-b pb-2">Professional Details</h2>
                        
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="hospital">
                                Hospital/Clinic <span class="text-red-500">*</span>
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                id="hospital" name="hospital" type="text" required>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="phone">
                                Contact Number <span class="text-red-500">*</span>
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                id="phone" name="phone" type="tel" required>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h2 class="text-xl font-semibold border-b pb-2">Medical Information</h2>
                        
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="specializations">
                                Specializations <span class="text-red-500">*</span>
                            </label>
                            <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                id="specializations" name="specializations" rows="3" required></textarea>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h2 class="text-xl font-semibold border-b pb-2">Qualifications <span class="text-red-500">*</span></h2>
                        <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                            id="qualifications" name="qualifications" rows="3" required></textarea>
                    </div>

                    <div class="space-y-4">
                        <h2 class="text-xl font-semibold border-b pb-2">Experience <span class="text-red-500">*</span></h2>
                        <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                            id="experience" name="experience" rows="3" required></textarea>
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Create Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>