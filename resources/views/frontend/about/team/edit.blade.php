@extends('template.template')

@section('pagecontent')

<div class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Team Member</h2>
        
        <form action="{{ route('ourteam.update', $teamMember->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div class="col-span-1">
                    <label for="name" class="block text-gray-700 font-medium mb-2">Name*</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $teamMember->name) }}" 
                           class="w-full px-4 py-2 border rounded-lg focus:ring-orange-500 focus:border-orange-500 @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Position -->
                <div class="col-span-1">
                    <label for="position" class="block text-gray-700 font-medium mb-2">Position*</label>
                    <input type="text" id="position" name="position" value="{{ old('position', $teamMember->position) }}" 
                           class="w-full px-4 py-2 border rounded-lg focus:ring-orange-500 focus:border-orange-500 @error('position') border-red-500 @enderror">
                    @error('position')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
               
                
                <!-- Image Upload -->
                <div class="col-span-2">
                    <label for="image" class="block text-gray-700 font-medium mb-2">Profile Image</label>
                    <div class="flex items-center space-x-6">
                        <div class="w-24 h-24 rounded-lg overflow-hidden border border-gray-200">
                            <img src="{{ asset('storage/' . $teamMember->image_path) }}" alt="Current Image" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1">
                            <input type="file" id="image" name="image" 
                                   class="w-full px-4 py-2 border rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 @error('image') border-red-500 @enderror"
                                   accept="image/jpeg, image/png, image/jpg">
                            <p class="text-sm text-gray-500 mt-2">Leave empty to keep current image</p>
                            @error('image')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-4">
                        <img id="imagePreview" src="#" alt="New Image Preview" class="hidden max-w-full h-auto rounded-lg border border-gray-200">
                    </div>
                </div>
                
               
            </div>
            
            <div class="mt-8 flex justify-end space-x-4">
                <a href="{{ route('team.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors">
                    Update Team Member
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Image preview functionality
    document.getElementById('image').addEventListener('change', function(event) {
        const [file] = event.target.files;
        if (file) {
            const preview = document.getElementById('imagePreview');
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
        }
    });
</script>
@endsection