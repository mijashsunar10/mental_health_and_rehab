<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Tailwind / Alpine / Fonts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        [x-cloak]{ display:none !important; }

        /* Chat bubble styles */
        .chat-bubble {
            max-width: 75%;
            padding: 8px 12px;
            border-radius: 12px;
            word-wrap: break-word;
            white-space: pre-wrap;
        }
        .chat-user { 
            background-color: #2563eb; 
            color: white !important; 
            border-bottom-right-radius: 0; 
            margin-left: auto;
        }
        .chat-assistant { 
            background-color: #f3f4f6; 
            color: #111827 !important; 
            border-bottom-left-radius: 0; 
            margin-right: auto;
        }

        /* Messages container scroll */
        .messages-container {
            overflow-y: auto;
            flex: 1;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 #f1f5f9;
        }
        .messages-container::-webkit-scrollbar {
            width: 6px;
        }
        .messages-container::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 3px;
        }
        .messages-container::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        .messages-container::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">

  @if (session('success'))
    <div class="mb-4 px-4 py-3 rounded-lg bg-green-100 text-green-800 border border-green-200">
        {{ session('success') }}
    </div>
@endif

<section id="header">
 @include('layouts.header')
</section>
  <section id="pagecontent" class="">
    @yield('pagecontent')
  </section>
  
  {{-- Add the panic button component --}}
@include('components.panic-button')
  <section id="footer">
    
    {{-- @include('layouts.footer') --}}
  </section>

</body>
</html>
