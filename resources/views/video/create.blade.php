@extends('layouts.main')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-50">
    <div class="w-full max-w-2xl p-8 bg-white rounded-lg shadow-md">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">Upload New Video</h1>

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">There were {{ $errors->count() }} errors with your submission</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('videos.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm" class="space-y-6">
            @csrf
            
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <div class="mt-1">
                    <input type="text" name="title" id="title" required
                           class="block w-full px-4 py-3 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border border-gray-300">
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <div class="mt-1">
                    <textarea name="description" id="description" rows="4" required
                              class="block w-full px-4 py-3 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border border-gray-300"></textarea>
                </div>
            </div>

            <div>
                <label for="video" class="block text-sm font-medium text-gray-700">Video File</label>
                <div class="mt-1 flex items-center">
                    <label for="video" class="cursor-pointer">
                        <span class="inline-flex items-center px-4 py-3 bg-blue-50 border border-blue-200 rounded-md shadow-sm text-sm font-medium text-blue-700 hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="-ml-1 mr-2 h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                            Choose video file
                        </span>
                        <input type="file" name="video" id="video" required accept="video/*" class="sr-only">
                    </label>
                    <span id="fileName" class="ml-4 text-sm text-gray-600">No file selected</span>
                </div>
                <p class="mt-2 text-sm text-gray-500">MP4, MOV or AVI. Max 100MB.</p>
                
                <!-- Video Preview -->
                <div id="videoPreviewContainer" class="mt-4 hidden">
                    <video id="videoPreview" controls class="w-full rounded-lg border border-gray-200" style="max-height: 240px;">
                        Your browser doesn't support video preview
                    </video>
                    <div class="mt-2 text-sm text-gray-500 text-center" id="videoInfo"></div>
                </div>
            </div>

            <!-- Upload Progress -->
            <div id="uploadProgress" class="hidden">
                <div class="flex justify-between mb-1">
                    <span class="text-sm font-medium text-gray-700">Uploading your video...</span>
                    <span class="text-sm font-medium text-gray-700" id="progressPercent">0%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div id="progressBar" class="bg-blue-600 h-2.5 rounded-full transition-all duration-300 ease-out" style="width: 0%"></div>
                </div>
                <div class="mt-2 text-sm text-gray-500" id="uploadStatus">
                    Preparing upload - this may take a while for large videos...
                </div>
            </div>

            <div class="flex items-center justify-end space-x-4 pt-4">
                <a href="{{ route('videos.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Cancel
                </a>
                <button type="submit" id="submitBtn" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Upload Video
                </button>
                <button type="button" id="loadingBtn" class="hidden items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-400 cursor-not-allowed">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Processing...
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('uploadForm');
    const fileInput = document.getElementById('video');
    const fileName = document.getElementById('fileName');
    const videoPreviewContainer = document.getElementById('videoPreviewContainer');
    const videoPreview = document.getElementById('videoPreview');
    const videoInfo = document.getElementById('videoInfo');
    const submitBtn = document.getElementById('submitBtn');
    const loadingBtn = document.getElementById('loadingBtn');
    const uploadProgress = document.getElementById('uploadProgress');
    const progressBar = document.getElementById('progressBar');
    const progressPercent = document.getElementById('progressPercent');
    const uploadStatus = document.getElementById('uploadStatus');

    // Show selected file and preview
    fileInput.addEventListener('change', function() {
        if (this.files.length > 0) {
            const file = this.files[0];
            fileName.textContent = file.name;
            
            // Show video preview
            if (file.type.startsWith('video/')) {
                const videoURL = URL.createObjectURL(file);
                videoPreview.src = videoURL;
                videoPreviewContainer.classList.remove('hidden');
                
                // Show video info
                videoInfo.textContent = `${formatBytes(file.size)} • ${file.type}`;
                
                // When video metadata is loaded, show duration
                videoPreview.onloadedmetadata = function() {
                    const duration = formatTime(videoPreview.duration);
                    videoInfo.textContent = `${formatBytes(file.size)} • ${file.type} • ${duration}`;
                };
            }
        } else {
            fileName.textContent = 'No file selected';
            videoPreviewContainer.classList.add('hidden');
        }
    });

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Show loading state
        submitBtn.classList.add('hidden');
        loadingBtn.classList.remove('hidden');
        uploadProgress.classList.remove('hidden');
        uploadStatus.textContent = "Starting upload - please be patient, this may take several minutes...";
        
        // Prepare form data
        const formData = new FormData(form);
        
        // Create AJAX request
        const xhr = new XMLHttpRequest();
        
        // Upload progress event - with simulated slower progress for better UX
        let lastUpdate = 0;
        xhr.upload.addEventListener('progress', function(e) {
            if (e.lengthComputable) {
                // Simulate slower progress for first 90%
                let percent = Math.round((e.loaded / e.total) * 100);
                
                // Don't jump too quickly - minimum 1 second between updates
                const now = Date.now();
                if (now - lastUpdate < 1000 && percent < 90) return;
                lastUpdate = now;
                
                // Slow down progress display
                if (percent < 90) {
                    percent = Math.min(percent, 90); // Cap at 90% until complete
                }
                
                progressBar.style.width = percent + '%';
                progressPercent.textContent = percent + '%';
                
                if (percent < 30) {
                    uploadStatus.textContent = `Uploading... (${formatBytes(e.loaded)} of ${formatBytes(e.total)}) - This may take a while...`;
                } else if (percent < 70) {
                    uploadStatus.textContent = `Upload in progress... (${formatBytes(e.loaded)} of ${formatBytes(e.total)}) - Almost halfway there!`;
                } else if (percent < 90) {
                    uploadStatus.textContent = `Finishing up... (${formatBytes(e.loaded)} of ${formatBytes(e.total)}) - Almost done!`;
                } else {
                    uploadStatus.textContent = 'Finalizing upload - please wait...';
                }
            }
        });
        
        // Request completed
        xhr.addEventListener('load', function() {
            if (xhr.status >= 200 && xhr.status < 300) {
                progressBar.style.width = '100%';
                progressPercent.textContent = '100%';
                uploadStatus.textContent = 'Upload complete! Processing your video...';
                
                // Redirect after short delay
                setTimeout(() => {
                    window.location.href = "{{ route('videos.index') }}";
                }, 1500);
            } else {
                // Error handling
                uploadStatus.textContent = 'Upload failed. Please try again.';
                uploadStatus.classList.add('text-red-500');
                submitBtn.classList.remove('hidden');
                loadingBtn.classList.add('hidden');
            }
        });
        
        // Request error
        xhr.addEventListener('error', function() {
            uploadStatus.textContent = 'Upload failed. Please check your connection and try again.';
            uploadStatus.classList.add('text-red-500');
            submitBtn.classList.remove('hidden');
            loadingBtn.classList.add('hidden');
        });
        
        // Send request
        xhr.open('POST', form.action, true);
        xhr.send(formData);
    });
    
    // Helper function to format bytes
    function formatBytes(bytes, decimals = 2) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const dm = decimals < 0 ? 0 : decimals;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
    }
    
    // Helper function to format time (HH:MM:SS)
    function formatTime(seconds) {
        const h = Math.floor(seconds / 3600);
        const m = Math.floor((seconds % 3600) / 60);
        const s = Math.floor(seconds % 60);
        
        return [
            h > 0 ? h.toString().padStart(2, '0') : null,
            m.toString().padStart(2, '0'),
            s.toString().padStart(2, '0')
        ].filter(Boolean).join(':');
    }
});
</script>
@endsection