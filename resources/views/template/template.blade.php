<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.Name','Laravel') }}</title>
     <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
    <!-- Styles -->
      @vite(['resources/css/app.css', 'resources/js/app.js'])
      
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Add this in your head section -->
   <!-- Place the first <script> tag in your HTML's <head> -->
      <script src="https://cdn.tiny.cloud/1/yefhnnw3pe7wp6973ntpshfk1zrgvx879j3pni68yvvzdhop/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>

      <!-- Place the following <script> and <textarea> tags your HTML's <body> -->
      <script>
        tinymce.init({
          selector: 'textarea',
          plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
          toolbar: 'undo redo | blocks

                <li class="relative cursor-pointer  group">
                    <a href="{{ route('team.index') }}">
                        <button class="flex items-center font-semibold py-1 cursor-pointer  px-3 focus:outline-none transition-colors duration-300">
                            Team
                         <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
              fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        });
      </script>
 
<style>[x-cloak]{ display:none !important; }</style>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    


     
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