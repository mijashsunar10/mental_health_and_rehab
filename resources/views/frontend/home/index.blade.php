@extends('template.template')

@section('pagecontent')

<section class="bg-background text-foreground overflow-x-hidden">
    <!-- Hero Section -->
    <section class="" id="">
        @include('frontend.home.hero')
    </section>
    
    <section id="about
">
        @include('frontend.home.about')
        {{-- @include('frontend.home.aboutus1') --}}
    </section>
    

    <!-- Global JS -->
    @vite(['resources/js/app.js'])
</section>
@endsection