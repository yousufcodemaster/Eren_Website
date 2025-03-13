@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white mb-4">Premium Plans</h1>
        <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
            Instead of trying every panel, try <span class="text-purple-600 font-bold">ALL IN ONE</span>
        </p>
    </div>

    <!-- All-in-One Plan -->
    <div class="max-w-4xl mx-auto mb-16">
        <div class="bg-gradient-to-br from-purple-600 to-indigo-700 rounded-2xl shadow-2xl transform hover:scale-[1.02] transition-all duration-300 overflow-hidden">
            <div class="p-8 text-center">
                <h2 class="text-3xl font-bold text-white mb-2">ALL IN ONE</h2>
                <div class="text-5xl font-extrabold text-white my-6">$75</div>
                <p class="text-purple-200 text-xl font-bold uppercase tracking-wider">PERMANENT</p>
                
                <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-white/20 backdrop-blur-sm p-4 rounded-xl">
                        <h3 class="text-white font-bold mb-2">EXTERNAL</h3>
                        <p class="text-purple-100">Full external features</p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm p-4 rounded-xl">
                        <h3 class="text-white font-bold mb-2">STREAMER</h3>
                        <p class="text-purple-100">Streaming optimization</p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm p-4 rounded-xl">
                        <h3 class="text-white font-bold mb-2">BYPASS</h3>
                        <p class="text-purple-100">Anti-detection systems</p>
                    </div>
                </div>
                
                <a href="{{ route('register') }}" class="mt-8 inline-block px-8 py-4 bg-white text-purple-700 font-bold rounded-xl shadow-lg hover:bg-purple-50 transition-all duration-300">
                    Get Started
                </a>
            </div>
        </div>
    </div>

    <!-- Individual Plans -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-6xl mx-auto">
        <!-- PERMANENT Plans -->
        <div>
            <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-white mb-6">PERMANENT PLANS</h2>
            <div class="space-y-6">
                <!-- EXTERNAL PERMANENT -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden border border-gray-200 dark:border-gray-700">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-xl font-bold text-gray-800 dark:text-white">EXTERNAL</h3>
                            <div class="text-2xl font-bold text-purple-600">$20</div>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">External enhancement features for improved gameplay</p>
                        <a href="{{ route('register') }}" class="block text-center w-full py-2 px-4 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors duration-300">
                            Select Plan
                        </a>
                    </div>
                </div>
                
                <!-- STREAMER PERMANENT -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden border border-gray-200 dark:border-gray-700">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-xl font-bold text-gray-800 dark:text-white">STREAMER</h3>
                            <div class="text-2xl font-bold text-purple-600">$50</div>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">Optimized for streamers with additional features</p>
                        <a href="{{ route('register') }}" class="block text-center w-full py-2 px-4 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors duration-300">
                            Select Plan
                        </a>
                    </div>
                </div>
                
                <!-- BYPASS PERMANENT -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden border border-gray-200 dark:border-gray-700">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-xl font-bold text-gray-800 dark:text-white">BYPASS</h3>
                            <div class="text-2xl font-bold text-purple-600">$17</div>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">Advanced bypass systems for anti-detection</p>
                        <a href="{{ route('register') }}" class="block text-center w-full py-2 px-4 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors duration-300">
                            Select Plan
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- MONTHLY Plans -->
        <div>
            <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-white mb-6">MONTHLY PLANS</h2>
            <div class="space-y-6">
                <!-- EXTERNAL MONTHLY -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden border border-gray-200 dark:border-gray-700">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-xl font-bold text-gray-800 dark:text-white">EXTERNAL</h3>
                            <div class="text-2xl font-bold text-purple-600">$9/mo</div>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">External enhancement features with monthly billing</p>
                        <a href="{{ route('register') }}" class="block text-center w-full py-2 px-4 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors duration-300">
                            Select Plan
                        </a>
                    </div>
                </div>
                
                <!-- STREAMER MONTHLY -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden border border-gray-200 dark:border-gray-700">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-xl font-bold text-gray-800 dark:text-white">STREAMER</h3>
                            <div class="text-2xl font-bold text-purple-600">$20/mo</div>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">Optimized for streamers with monthly billing</p>
                        <a href="{{ route('register') }}" class="block text-center w-full py-2 px-4 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors duration-300">
                            Select Plan
                        </a>
                    </div>
                </div>
                
                <!-- BYPASS MONTHLY -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden border border-gray-200 dark:border-gray-700">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-xl font-bold text-gray-800 dark:text-white">BYPASS</h3>
                            <div class="text-2xl font-bold text-purple-600">$7/mo</div>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">Advanced bypass systems with monthly billing</p>
                        <a href="{{ route('register') }}" class="block text-center w-full py-2 px-4 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors duration-300">
                            Select Plan
                        </a>
                    </div>
                </div>
                
                <!-- RESELLER MONTHLY -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden border border-gray-200 dark:border-gray-700">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-xl font-bold text-gray-800 dark:text-white">RESELLER</h3>
                            <div class="text-2xl font-bold text-purple-600">$80/mo</div>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">Business opportunity for those who want to resell our solutions</p>
                        <a href="{{ route('register') }}" class="block text-center w-full py-2 px-4 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors duration-300">
                            Select Plan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- FAQ Section -->
    <div class="mt-16 max-w-4xl mx-auto">
        <h2 class="text-3xl font-bold text-center text-gray-800 dark:text-white mb-8">Frequently Asked Questions</h2>
        <div class="space-y-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">What is included in the ALL IN ONE package?</h3>
                <p class="text-gray-600 dark:text-gray-400 mt-2">The ALL IN ONE package includes permanent access to all features: External, Streamer, and Bypass functionalities.</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">How do monthly subscriptions work?</h3>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Monthly subscriptions are automatically renewed each month until canceled. You can cancel anytime from your account dashboard.</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Are updates included?</h3>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Yes, all plans include free updates for the duration of your subscription or permanently for lifetime purchases.</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">What's the difference between permanent and monthly plans?</h3>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Permanent plans require a one-time payment for lifetime access, while monthly plans are subscription-based with recurring payments.</p>
            </div>
        </div>
    </div>
</div>
@endsection 