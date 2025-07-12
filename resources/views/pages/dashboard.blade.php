@extends('layouts.app')

@section('title', 'General Dashboard')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">

            <div class="section-header">

                <div class="vertical">
                    <h1>Dashboard</h1>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
@endpush
