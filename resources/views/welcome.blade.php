<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Eren Regedit - Elite Panel Solutions</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
        <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    </head>
    <body class="bg-gray-900">
        <!-- Background effects -->
        <div id="particles-js" class="fixed inset-0 z-0"></div>
        <div class="bubbles fixed inset-0 z-0">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
        
        <!-- Content Container -->
        <div class="relative z-10">
            <!-- Header -->
            <header>
                <a href="#" class="logo heading-glow">Eren <span>Regedit</span></a>
                <nav>
                    <ul>
                        <li><a href="#" class="interactive-element">Home</a></li>
                        <li><a href="#plans" class="interactive-element">Plans</a></li>
                        @if (Route::has('login'))
                            @auth
                                <li><a href="{{ url('/dashboard') }}" class="interactive-element">Dashboard</a></li>
                            @else
                                <li><a href="{{ route('login') }}" class="interactive-element">Login</a></li>
                                @if (Route::has('register'))
                                    <li><a href="{{ route('register') }}" class="btn btn-primary interactive-element">Register</a></li>
                                @endif
                            @endauth
                        @endif
                    </ul>
                </nav>
            </header>

            <!-- Hero Section -->
            <section class="hero section">
                <div class="hero-content">
                    <h1 class="heading-glow">Experience Gaming <span>Without Limits</span></h1>
                    <p>Eren Regedit provides cutting-edge solutions for gamers who demand the ultimate performance and advantage in their gameplay experience.</p>
                    <div class="hero-buttons">
                        <a href="#plans" class="btn btn-primary interactive-element">Explore Plans</a>
                        <a href="{{ route('login') }}" class="btn btn-secondary interactive-element">Get Started</a>
                    </div>
                </div>
            </section>

            <!-- Plans Section -->
            <section id="plans" class="plans section">
                <div class="section-title">
                    <h2 class="heading-glow">Available Plans</h2>
                    <p>Choose the perfect solution that fits your gaming needs</p>
                </div>

                <div class="plans-container">
                    <div class="plan-card pricing-card">
                        <div class="plan-name">All-in-one</div>
                        <p class="plan-description">Our complete package with all features and benefits for the ultimate gaming advantage.</p>
                        <div class="plan-price">$59.99/mo</div>
                        <a href="#" class="btn btn-primary interactive-element">Get Started</a>
                    </div>

                    <div class="plan-card pricing-card">
                        <div class="plan-name">External</div>
                        <p class="plan-description">External solution for those who need flexibility and compatibility with various game setups.</p>
                        <div class="plan-price">$39.99/mo</div>
                        <a href="#" class="btn btn-primary interactive-element">Get Started</a>
                    </div>

                    <div class="plan-card pricing-card">
                        <div class="plan-name">Streamer</div>
                        <p class="plan-description">Specially designed for content creators with stream-friendly features and optimizations.</p>
                        <div class="plan-price">$44.99/mo</div>
                        <a href="#" class="btn btn-primary interactive-element">Get Started</a>
                    </div>

                    <div class="plan-card pricing-card">
                        <div class="plan-name">Bypass</div>
                        <p class="plan-description">Advanced solution that ensures smooth gameplay without interference.</p>
                        <div class="plan-price">$34.99/mo</div>
                        <a href="#" class="btn btn-primary interactive-element">Get Started</a>
                    </div>

                    <div class="plan-card pricing-card">
                        <div class="plan-name">Reseller</div>
                        <p class="plan-description">Business opportunity for those who want to share our premium solutions with others.</p>
                        <div class="plan-price">$149.99/mo</div>
                        <a href="#" class="btn btn-primary interactive-element">Get Started</a>
                    </div>
                </div>
            </section>
        </div>

        <script src="{{ asset('js/custom.js') }}"></script>
        <script>
            particlesJS('particles-js', {
                "particles": {
                    "number": {
                        "value": 80,
                        "density": {
                            "enable": true,
                            "value_area": 800
                        }
                    },
                    "color": {
                        "value": "#ffffff"
                    },
                    "shape": {
                        "type": "circle"
                    },
                    "opacity": {
                        "value": 0.5,
                        "random": false,
                        "anim": {
                            "enable": false,
                            "speed": 1
                        }
                    },
                    "size": {
                        "value": 3,
                        "random": true
                    },
                    "line_linked": {
                        "enable": true,
                        "distance": 150,
                        "color": "#ffffff",
                        "opacity": 0.4,
                        "width": 1
                    },
                    "move": {
                        "enable": true,
                        "speed": 6,
                        "direction": "none",
                        "random": false,
                        "straight": false,
                        "out_mode": "out",
                        "bounce": false
                    }
                },
                "interactivity": {
                    "detect_on": "canvas",
                    "events": {
                        "onhover": {
                            "enable": true,
                            "mode": "repulse"
                        },
                        "onclick": {
                            "enable": true,
                            "mode": "push"
                        },
                        "resize": true
                    }
                },
                "retina_detect": true
            });
        </script>
    </body>
</html>
