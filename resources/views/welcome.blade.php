<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Eren Regedit - Elite Panel Solutions</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
        <style>
            /* Particles.js container */
            #particles-js {
                position: fixed;
                width: 100%;
                height: 100%;
                background-color: transparent;
                z-index: 0;
            }

            /* Bubbles Animation */
            .bubbles {
                pointer-events: none;
            }

            .bubbles span {
                position: absolute;
                display: block;
                width: 20px;
                height: 20px;
                background: rgba(255, 255, 255, 0.1);
                border-radius: 50%;
                bottom: -150px;
                animation: bubble 15s infinite;
                transition-timing-function: linear;
            }

            .bubbles span:nth-child(1) {
                left: 10%;
                animation-delay: 0s;
                animation-duration: 12s;
            }

            .bubbles span:nth-child(2) {
                left: 20%;
                width: 40px;
                height: 40px;
                animation-delay: 2s;
                animation-duration: 16s;
            }

            .bubbles span:nth-child(3) {
                left: 35%;
                animation-delay: 4s;
                animation-duration: 13s;
            }

            .bubbles span:nth-child(4) {
                left: 50%;
                width: 60px;
                height: 60px;
                animation-delay: 6s;
                animation-duration: 15s;
            }

            .bubbles span:nth-child(5) {
                left: 65%;
                animation-delay: 8s;
                animation-duration: 14s;
            }

            .bubbles span:nth-child(6) {
                left: 80%;
                width: 30px;
                height: 30px;
                animation-delay: 10s;
                animation-duration: 12s;
            }

            @keyframes bubble {
                0% {
                    transform: translateY(0) rotate(0);
                    opacity: 1;
                }
                100% {
                    transform: translateY(-1000px) rotate(720deg);
                    opacity: 0;
                }
            }
        </style>
    </head>
    <body class="bg-gray-900 text-white font-['Poppins']">
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
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <header class="py-8 flex justify-between items-center">
                <a href="#" class="text-2xl font-bold text-white hover:text-purple-400 transition">Eren <span class="text-purple-500">Regedit</span></a>
                <nav>
                    <ul class="flex space-x-8">
                        <li><a href="#" class="text-gray-300 hover:text-white transition">Home</a></li>
                        <li><a href="#plans" class="text-gray-300 hover:text-white transition">Plans</a></li>
                        @if (Route::has('login'))
                            @auth
                                <li><a href="{{ url('/dashboard') }}" class="text-gray-300 hover:text-white transition">Dashboard</a></li>
                            @else
                                <li><a href="{{ route('login') }}" class="text-gray-300 hover:text-white transition">Login</a></li>
                                @if (Route::has('register'))
                                    <li><a href="{{ route('register') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition">Register</a></li>
                                @endif
                            @endauth
                        @endif
                    </ul>
                </nav>
            </header>

            <!-- Hero Section -->
            <section class="py-16 mb-16">
                <div class="max-w-3xl">
                    <h1 class="text-5xl font-bold leading-tight mb-6">Experience Gaming <span class="text-purple-500">Without Limits</span></h1>
                    <p class="text-xl text-gray-300 mb-8">Eren Regedit provides cutting-edge solutions for gamers who demand the ultimate performance and advantage in their gameplay experience.</p>
                    <div class="flex space-x-4">
                        <a href="#plans" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-medium transition">Explore Plans</a>
                        <a href="{{ route('login') }}" class="bg-gradient-to-r from-yellow-400 to-orange-500 text-gray-900 px-6 py-3 rounded-lg font-medium hover:opacity-90 transition">Get Started</a>
                    </div>
                </div>
            </section>

            <!-- Plans Section -->
            <section id="plans" class="py-16 mb-16">
                <div class="text-center mb-12">
                    <h2 class="text-4xl font-bold mb-4">Available Plans</h2>
                    <p class="text-xl text-gray-300">Choose the perfect solution that fits your gaming needs</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- ALL-IN-ONE -->
                    <div class="bg-gray-800 rounded-lg p-6 border border-gray-700 hover:border-purple-500 transition">
                        <div class="text-2xl font-bold mb-3">All-in-one</div>
                        <p class="text-gray-300 mb-5 h-20">Our complete package with all features and benefits for the ultimate gaming advantage.</p>
                        
                        <div class="flex flex-col mb-6 space-y-2">
                            <div class="font-bold text-xl text-purple-400">Permanent</div>
                            <div class="text-3xl font-bold">$75</div>
                        </div>
                        
                        <div class="flex flex-col mb-6 space-y-2">
                            <div class="font-bold text-xl text-purple-400">Monthly</div>
                            <div class="text-3xl font-bold">(Not Available)</div>
                        </div>
                        
                        <a href="#" class="block text-center bg-purple-600 hover:bg-purple-700 text-white py-3 rounded-lg transition">Get Started</a>
                    </div>

                    <!-- EXTERNAL -->
                    <div class="bg-gray-800 rounded-lg p-6 border border-gray-700 hover:border-purple-500 transition">
                        <div class="text-2xl font-bold mb-3">External</div>
                        <p class="text-gray-300 mb-5 h-20">External solution for those who need flexibility and compatibility with various game setups.</p>
                        
                        <div class="flex flex-col mb-6 space-y-2">
                            <div class="font-bold text-xl text-purple-400">Permanent</div>
                            <div class="text-3xl font-bold">$20</div>
                        </div>
                        
                        <div class="flex flex-col mb-6 space-y-2">
                            <div class="font-bold text-xl text-purple-400">Monthly</div>
                            <div class="text-3xl font-bold">$9/mo</div>
                        </div>
                        
                        <a href="#" class="block text-center bg-purple-600 hover:bg-purple-700 text-white py-3 rounded-lg transition">Get Started</a>
                    </div>

                    <!-- STREAMER -->
                    <div class="bg-gray-800 rounded-lg p-6 border border-gray-700 hover:border-purple-500 transition">
                        <div class="text-2xl font-bold mb-3">Streamer</div>
                        <p class="text-gray-300 mb-5 h-20">Specially designed for content creators with stream-friendly features and optimizations.</p>
                        
                        <div class="flex flex-col mb-6 space-y-2">
                            <div class="font-bold text-xl text-purple-400">Permanent</div>
                            <div class="text-3xl font-bold">$50</div>
                        </div>
                        
                        <div class="flex flex-col mb-6 space-y-2">
                            <div class="font-bold text-xl text-purple-400">Monthly</div>
                            <div class="text-3xl font-bold">$20/mo</div>
                        </div>
                        
                        <a href="#" class="block text-center bg-purple-600 hover:bg-purple-700 text-white py-3 rounded-lg transition">Get Started</a>
                    </div>

                    <!-- BYPASS -->
                    <div class="bg-gray-800 rounded-lg p-6 border border-gray-700 hover:border-purple-500 transition">
                        <div class="text-2xl font-bold mb-3">Bypass</div>
                        <p class="text-gray-300 mb-5 h-20">Advanced solution that ensures smooth gameplay without interference.</p>
                        
                        <div class="flex flex-col mb-6 space-y-2">
                            <div class="font-bold text-xl text-purple-400">Permanent</div>
                            <div class="text-3xl font-bold">$17</div>
                        </div>
                        
                        <div class="flex flex-col mb-6 space-y-2">
                            <div class="font-bold text-xl text-purple-400">Monthly</div>
                            <div class="text-3xl font-bold">$7/mo</div>
                        </div>
                        
                        <a href="#" class="block text-center bg-purple-600 hover:bg-purple-700 text-white py-3 rounded-lg transition">Get Started</a>
                    </div>

                    <!-- RESELLER -->
                    <div class="bg-gray-800 rounded-lg p-6 border border-gray-700 hover:border-purple-500 transition">
                        <div class="text-2xl font-bold mb-3">Reseller</div>
                        <p class="text-gray-300 mb-5 h-20">Business opportunity for those who want to share our premium solutions with others.</p>
                        
                        <div class="flex flex-col mb-6 space-y-2">
                            <div class="font-bold text-xl text-purple-400">Permanent</div>
                            <div class="text-3xl font-bold">(Not Available)</div>
                        </div>
                        
                        <div class="flex flex-col mb-6 space-y-2">
                            <div class="font-bold text-xl text-purple-400">Monthly</div>
                            <div class="text-3xl font-bold">$80/mo</div>
                        </div>
                        
                        <a href="#" class="block text-center bg-purple-600 hover:bg-purple-700 text-white py-3 rounded-lg transition">Get Started</a>
                    </div>
                </div>
            </section>
        </div>

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
