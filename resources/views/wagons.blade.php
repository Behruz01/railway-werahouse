@extends('layouts.layout')

@section('title')
    <title>Wagons | Admin Portal</title>
@endsection

@section('wagons')
    active
@endsection

@section('content')
    <!-- ========== MAIN CONTENT ========== -->
    <main id="content" role="main" class="main">
        <!-- Content -->
        <livewire:wagons/>
        <!-- End Content -->

        @include('layouts.includes.footer')

    </main>
    <!-- ========== END MAIN CONTENT ========== -->
@endsection
