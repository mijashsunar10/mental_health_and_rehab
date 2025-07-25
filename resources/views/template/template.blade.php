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
    <script src="https://cdn.tiny.cloud/1/ngdj1fhhw4watoul19rz744sdabe5zisfd26xlmufomkup6s/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea.tinymce',
            plugins: 'advlist autolink lists link image charmap preview anchor pagebreak',
            toolbar_mode: 'floating',
            height: 500,
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
        });
    </script>
    


     
</head>
<body class="min-h-screen flex flex-col">
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
