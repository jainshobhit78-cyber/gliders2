@extends('frontend.layouts.app')

@section('content')

    <!-- HERO BANNER -->
    <section class="product-hero" style="background-image: url('{{ asset('uploads/products/' . $product->wallpaper) }}')">

        <div class="hero-overlay"></div>

        <div class="container">
            <div class="detail-hero-content">
                <h1>{{ $product->title }}</h1>
            </div>
        </div>
    </section>

    @php
        // Original product image logic
        $originalProductImage = $product->images->first() 
            ? asset('uploads/products/' . $product->images->first()->image) 
            : ($product->wallpaper ? asset('uploads/products/' . $product->wallpaper) : asset('frontend/images/section/9.png'));

        // Clean table out of description
        $cleanDescription = preg_replace('/<table[^>]*>.*?<\/table>/is', '', $product->description);
        $cleanDescription = trim(strip_tags($cleanDescription));

        $techSpecs = [
            // SU-30 MKI Brake Parachute
            3 => [
                'title' => 'Technical',
                'title_span' => 'Specifications',
                'subtext' => $cleanDescription ?: 'Designed for precision, built for performance. Explore the key technical details of our parachute systems.',
                'image' => $originalProductImage,
                'items' => [
                    [
                        'icon' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 3H3v18h18V3zM3 9h18M3 15h18M9 3v18M15 3v18"/></svg>',
                        'heading' => 'Span of Main Parachute',
                        'value' => '7 sqm',
                        'desc' => 'Defines the total surface footprint area of the decelerator canopy cluster.'
                    ],
                    [
                        'icon' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 6h16M4 12h16M4 18h16"/></svg>',
                        'heading' => 'No. of Rigging Lines',
                        'value' => '32 Lines',
                        'desc' => 'High-strength structural cords connecting the canopy to the aircraft tail attachment links.'
                    ],
                    [
                        'icon' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>',
                        'heading' => 'Normal Landing Speed',
                        'value' => '260 kmph (72.2 m/s)',
                        'desc' => 'Recommended airspeed limit under standard runway contact parameters.'
                    ],
                    [
                        'icon' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0zM12 9v4M12 17h.01"/></svg>',
                        'heading' => 'Emergency Landing Speed',
                        'value' => '300 kmph (83.3 m/s)',
                        'desc' => 'Maximum design threshold speed for parachute deployment during structural emergencies.'
                    ],
                    [
                        'icon' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 12v10H4V12M2 7h20v5H2zM12 22V7"/></svg>',
                        'heading' => 'Max. Operational Load',
                        'value' => '23 kg',
                        'desc' => 'Packaged systems maximum mass limits for standard aircraft assembly installations.'
                    ],
                    [
                        'icon' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
                        'heading' => 'Basic Material',
                        'value' => 'Fabric Nylon 66, 93 gm undyed',
                        'desc' => 'Heavy-duty weave specification offering high thermal dissipation and shock resistance.'
                    ],
                    [
                        'icon' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>',
                        'heading' => 'Design of Canopy',
                        'value' => 'Canopy Unicross Design',
                        'desc' => 'Cross-configured canopy geometry ensuring maximum drag efficiency and structural stability.'
                    ],
                    [
                        'icon' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>',
                        'heading' => 'Life of Parachute',
                        'value' => '10 years / 45 streamings',
                        'desc' => 'Total certified operating lifetime limits before overhaul recycling is required.'
                    ]
                ]
            ],
            // Default fallback
            'default' => [
                'title' => 'Technical',
                'title_span' => 'Specifications',
                'subtext' => $cleanDescription ?: 'Designed for precision, built for performance. Explore the key technical details of our parachute systems.',
                'image' => $originalProductImage,
                'items' => [
                    [
                        'icon' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>',
                        'heading' => 'Rate of Descent',
                        'value' => '7.5 m/s',
                        'desc' => 'Stabilized constant descent speed limit under maximum operational payload configuration.'
                    ],
                    [
                        'icon' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>',
                        'heading' => 'Canopy Diameter',
                        'value' => '7.0 meter',
                        'desc' => 'Nominal canopy span diameter layout when fully inflated under load.'
                    ],
                    [
                        'icon' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 12v10H4V12M2 7h20v5H2z"/></svg>',
                        'heading' => 'Dropping Load',
                        'value' => '130 kgs',
                        'desc' => 'Total operating payload capability range supported by structural risers.'
                    ],
                    [
                        'icon' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
                        'heading' => 'Dropping Height',
                        'value' => '400 ft AGL to 15,000 ft AGL',
                        'desc' => 'Minimum and maximum operational dispatch heights above ground level.'
                    ],
                    [
                        'icon' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
                        'heading' => 'Design of Canopy',
                        'value' => 'Parabolic with zipped skirt',
                        'desc' => 'Optimized geometry profile featuring pinched structural margins around the skirt limits.'
                    ]
                ]
            ]
        ];

        // 2. Main Capabilities data
        $mainCapabilities = [
            // SU-30 MKI Brake Parachute
            3 => [
                'title' => 'Main Capabilities',
                'image' => $product->wallpaper ? asset('uploads/products/' . $product->wallpaper) : $originalProductImage,
                'items' => [
                    [
                        'heading' => 'Aerodynamic Deceleration',
                        'desc' => 'Generates extreme drag force to significantly reduce the landing run distance of the SU-30 MKI fighter jet, allowing safe landing on shorter or tactical runways.'
                    ],
                    [
                        'heading' => 'High-Strength Thermal Canopy',
                        'desc' => 'Manufactured with specialized heat-resistant, high-tensile strength polyamide nylon material. It is designed to withstand high thermal loads and intense deployment shocks.'
                    ],
                    [
                        'heading' => 'Reliable Pilot-Chute Extraction',
                        'desc' => 'Features an integrated auxiliary pilot chute system that guarantees stable, twist-free, and rapid deployment from the rear tail-cone compartment at speeds up to 300 km/h.'
                    ],
                    [
                        'heading' => 'Extensively Field-Tested',
                        'desc' => 'Validated under extreme operational environments, ensuring highly reliable deceleration performance in temperatures ranging from -50°C to +60°C.'
                    ]
                ]
            ],
            // Default Fallback
            'default' => [
                'title' => 'Main Capabilities',
                'image' => $product->wallpaper ? asset('uploads/products/' . $product->wallpaper) : $originalProductImage,
                'items' => [
                    [
                        'heading' => 'High Operational Reliability',
                        'desc' => 'Designed and manufactured to the highest military standards, ensuring extreme reliability and mission success.'
                    ],
                    [
                        'heading' => 'Extreme Weather Tolerance',
                        'desc' => 'Fully operational in severe climates, ranging from desert heat to freezing high-altitude environments.'
                    ],
                    [
                        'heading' => 'Rigorous Quality Assurance',
                        'desc' => 'Undergoes multi-stage inspections and stress testing to comply with international aerospace and defense certifications.'
                    ]
                ]
            ]
        ];

        // Try resolving dynamic specifications from the database
        if (!empty($product->technical_specs) && is_array($product->technical_specs) && count($product->technical_specs) > 0) {
            $specsItems = [];
            foreach ($product->technical_specs as $item) {
                $specsItems[] = [
                    'icon' => !empty($item['icon']) ? $item['icon'] : '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>',
                    'heading' => $item['parameter'] ?? '',
                    'value' => $item['value'] ?? '',
                    'desc' => $item['description'] ?? ''
                ];
            }
            $specs = [
                'title' => 'Technical',
                'title_span' => 'Specifications',
                'subtext' => $product->specs_subtext ?: $cleanDescription,
                'image' => $product->specs_image ? asset('uploads/products/' . $product->specs_image) : $originalProductImage,
                'items' => $specsItems
            ];
        } else {
            $specs = $techSpecs[$product->id] ?? $techSpecs['default'];
        }

        // Try resolving dynamic capabilities from the database
        if (!empty($product->main_capabilities) && is_array($product->main_capabilities) && count($product->main_capabilities) > 0) {
            $capsItems = [];
            foreach ($product->main_capabilities as $item) {
                $capsItems[] = [
                    'heading' => $item['heading'] ?? '',
                    'desc' => $item['description'] ?? ''
                ];
            }
            $caps = [
                'title' => 'Main Capabilities',
                'image' => $product->caps_image 
                    ? asset('uploads/products/' . $product->caps_image) 
                    : ($product->wallpaper ? asset('uploads/products/' . $product->wallpaper) : $originalProductImage),
                'items' => $capsItems
            ];
        } else {
            $caps = $mainCapabilities[$product->id] ?? $mainCapabilities['default'];
        }
    @endphp

    <!-- SECTION 1: TECHNICAL SPECIFICATIONS (MOCKUP SPECS CLONE) -->
    <section class="system-capabilities-section">
        <div class="capabilities-image-pane">
            <div class="capabilities-img-wrapper">
                <img src="{{ $specs['image'] }}" alt="{{ $product->title }}">
                <div class="capabilities-gradient-overlay"></div>
                
                <!-- Bottom-Right Reliability Card Overlay -->
                <div class="reliability-badge">
                    <div class="badge-icon-wrap">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 11l2 2 4-4"/></svg>
                    </div>
                    <div class="badge-text">
                        <h4>Engineered for Reliability</h4>
                        <p>Every component is rigorously tested for mission-critical performance.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="container capabilities-container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="capabilities-content-box">
                        <h2 class="capabilities-section-title">
                            {{ $specs['title'] }} <span>{{ $specs['title_span'] ?? '' }}</span>
                        </h2>
                        <p class="capabilities-subtext">{!! $specs['subtext'] !!}</p>
                        
                        <div class="accordion capabilities-accordion" id="specsAccordion">
                            @foreach($specs['items'] as $index => $item)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="specs-heading-{{ $index }}">
                                        <button class="accordion-button collapsed" 
                                                type="button" 
                                                data-bs-toggle="collapse" 
                                                data-bs-target="#specs-collapse-{{ $index }}" 
                                                aria-expanded="false" 
                                                aria-controls="specs-collapse-{{ $index }}">
                                            
                                            <!-- Col 1: Icon -->
                                            <span class="spec-icon-wrap">{!! $item['icon'] !!}</span>
                                            
                                            <!-- Col 2: Label -->
                                            <span class="spec-label">{{ $item['heading'] }}</span>
                                            
                                            <!-- Col 3: Divider Line -->
                                            <span class="spec-divider"></span>
                                            
                                            <!-- Col 4: Value -->
                                            <span class="spec-value">{{ $item['value'] ?? '' }}</span>
                                            
                                            <!-- Col 5: Plus Indicator -->
                                            <span class="plus-icon">+</span>
                                        </button>
                                    </h2>
                                    <div id="specs-collapse-{{ $index }}" 
                                         class="accordion-collapse collapse" 
                                         aria-labelledby="specs-heading-{{ $index }}" 
                                         data-bs-parent="#specsAccordion">
                                        <div class="accordion-body">
                                            <p>{{ $item['desc'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 2: MAIN CAPABILITIES (RAFAEL STYLE CLONE) -->
    <section class="main-capabilities-section">
        <div class="caps-image-pane">
            <div class="caps-img-wrapper">
                <img src="{{ $caps['image'] }}" alt="{{ $product->title }}">
                <div class="caps-gradient-overlay"></div>
            </div>
        </div>
        
        <div class="container caps-container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="caps-content-box">
                        <h2 class="caps-section-title">
                            {{ $caps['title'] }}
                        </h2>
                        
                        <div class="accordion caps-accordion" id="capsAccordion">
                            @foreach($caps['items'] as $index => $item)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="caps-heading-{{ $index }}">
                                        <button class="accordion-button {{ $index === 0 ? '' : 'collapsed' }}" 
                                                type="button" 
                                                data-bs-toggle="collapse" 
                                                data-bs-target="#caps-collapse-{{ $index }}" 
                                                aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" 
                                                aria-controls="caps-collapse-{{ $index }}">
                                            <span>{{ $item['heading'] }}</span>
                                            <span class="plus-minus-icon"></span>
                                        </button>
                                    </h2>
                                    <div id="caps-collapse-{{ $index }}" 
                                         class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" 
                                         aria-labelledby="caps-heading-{{ $index }}" 
                                         data-bs-parent="#capsAccordion">
                                        <div class="accordion-body">
                                            <p>{{ $item['desc'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- IMAGE GALLERY SLIDER -->
    <section class="gallery-section-full">

        <h2 class="gallery-title">Product Gallery</h2>

        <div class="swiper gallerySwiper">
            <div class="swiper-wrapper">

                @foreach($product->images as $image)
                    <div class="swiper-slide">
                        <div class="gallery-item">
                            <img src="{{ asset('uploads/products/' . $image->image) }}" alt="{{ $product->title }}">
                        </div>
                    </div>
                @endforeach

            </div>

            <!-- Pagination -->
            <div class="swiper-pagination"></div>

            <!-- Navigation -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>

    </section>

    <!-- EXPLORE MORE SECTION -->
    <section class="explore-more-section">
        <div class="container ">
            <h2 class="explore-title">Explore More</h2>

            <div class="swiper exploreSwiper">
                <div class="swiper-wrapper">

                    @foreach($categories as $item)
                        <div class="swiper-slide">
                            <a href="{{ route('products.category', $item->id) }}" class="explore-item">

                                <div class="explore-image">
                                    <img src="{{ asset('uploads/category/' . $item->image) }}" alt="{{ $item->name }}">
                                </div>

                                <div class="explore-text">
                                    {{ $item->name }}
                                </div>

                            </a>
                        </div>
                    @endforeach

                </div>

                <!-- Pagination -->
                <div class="swiper-pagination explore-pagination"></div>
            </div>
        </div>
    </section>

    <section class="contact-news-section-2 py-5">
        <div class="container">
            <div class="row g-4">

                <!-- LEFT CONTACT FORM -->
                <div class="col-lg-12">
                    <div class="contact-box">
                        <h2>Enquire About This Product</h2>

                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('contact.store') }}" method="POST">
                            @csrf

                            <input type="text" name="name" placeholder="Your Name" required>
                            <input type="email" name="email" placeholder="Your Email" required>
                            <input type="text" name="phone" placeholder="Phone Number" required>
                            <textarea name="message" rows="5" placeholder="Your Message" required></textarea>

                            @error('captcha')
                                <div class="alert alert-danger p-2" style="font-size: 13px; margin-bottom: 10px; background: rgba(220, 53, 69, 0.2); border: 1px solid rgba(220, 53, 69, 0.4); color: #ff8080;">{{ $message }}</div>
                            @enderror
                            <div class="captcha-wrapper mb-3" style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
                                <span style="color: #fff; white-space: nowrap; font-weight: 600;">Security Check: What is {{ session('captcha_num1') }} + {{ session('captcha_num2') }}?</span>
                                <input type="number" name="captcha" placeholder="Answer" required style="margin: 0; width: 100px; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                            </div>

                            <button type="submit">Send message</button>
                        </form>
                    </div>
                </div>


            </div>
        </div>
    </section>

@endsection



@section('scripts')
    <script>
        var swiper = new Swiper(".gallerySwiper", {
            slidesPerView: 3,
            spaceBetween: 20,
            loop: true,
            speed: 800,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },

            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },

            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },

            breakpoints: {
                320: {
                    slidesPerView: 1
                },
                768: {
                    slidesPerView: 2
                },
                1200: {
                    slidesPerView: 3
                }
            }
        });
    </script>

    <script>
        var exploreSwiper = new Swiper(".exploreSwiper", {
            slidesPerView: 5,
            spaceBetween: 30,
            loop: true,
            // centeredSlides: true,
            speed: 900,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },

            pagination: {
                el: ".explore-pagination",
                clickable: true,
            },

            breakpoints: {
                320: {
                    slidesPerView: 1
                },
                576: {
                    slidesPerView: 2
                },
                992: {
                    slidesPerView: 3
                },
                1200: {
                    slidesPerView: 4
                }
            }
        });
    </script>

@endsection