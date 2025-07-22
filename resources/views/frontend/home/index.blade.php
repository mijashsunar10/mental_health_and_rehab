@extends('template.template')

@section('pagecontent')

<section class="bg-background text-foreground overflow-x-hidden">
    <!-- Hero Section -->
    <section class="">
        @include('frontend.home.hero')
    </section>

    

    <!-- Global JS -->
    @vite(['resources/js/app.js'])
</section>
@endsection