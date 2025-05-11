@extends('layouts.layout')

@section('title')
    <title>Orders | Admin Portal</title>
@endsection

@section('orders')
    active
@endsection

@section('content')
    <!-- ========== MAIN CONTENT ========== -->
    <main id="content" role="main" class="main">
        <!-- Content -->
        <livewire:orders/>
        <!-- End Content -->

        @include('layouts.includes.footer')

    </main>
    <!-- ========== END MAIN CONTENT ========== -->
@endsection
