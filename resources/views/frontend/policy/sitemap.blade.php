@extends('frontend.layouts.app')

@section('content')

    <section class="sitemap-page">
        <div class="container">

            <div class="sitemap-card">

                <h1>Sitemap</h1>

                <div class="sitemap-grid">

                    <div class="sitemap-column">
                        <h3>Main Pages</h3>
                        <ul>
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li><a href="{{ route('about') }}">About Us</a></li>
                            <li><a href="{{ route('products.index') }}">Products</a></li>
                            <li><a href="{{ route('media') }}">Media</a></li>
                            <li><a href="{{ route('news.categories') }}">News</a></li>
                        </ul>
                    </div>

                    <div class="sitemap-column">
                        <h3>Important Links</h3>
                        <ul>
                            <li><a href="{{ route('privacy.policy') }}">Privacy Policy</a></li>
                            <li><a href="{{ route('terms.conditions') }}">Terms & Conditions</a></li>
                            <li><a href="{{ route('sitemap') }}">Sitemap</a></li>
                        </ul>
                    </div>

                    <div class="sitemap-column">
                        <h3>Departments</h3>
                        <ul>
                            <li><a href="{{ route('finance') }}">Finance</a></li>
                            <li><a href="{{ route('vigilance') }}">Vigilance</a></li>
                            <li><a href="{{ route('vendors') }}">Vendors</a></li>
                            <li><a href="{{ route('rajbhasha') }}">Rajbhasha</a></li>
                            <li><a href="{{ route('careers') }}">Careers</a></li>
                            <li><a href="{{ route('rti') }}">RTI</a></li>
                        </ul>
                    </div>

                </div>

            </div>

        </div>
    </section>

@endsection