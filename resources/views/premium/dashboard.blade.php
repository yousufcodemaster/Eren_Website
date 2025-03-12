@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Welcome Section -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Welcome, {{ Auth::user()->name }}!</h1>
            <p class="text-gray-600 mt-2">Premium {{ Auth::user()->premium_type }} Member</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Profile Management Card -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Profile Management</h2>
                <form action="{{ route('premium.profile.update') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Username</label>
                        <input type="text" name="name" id="name" value="{{ Auth::user()->name }}" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" value="{{ Auth::user()->email }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                        <input type="password" name="current_password" id="current_password"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label for="new_password" class="block text-sm font-medium text-gray-700">New Password</label>
                        <input type="password" name="new_password" id="new_password"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Update Profile
                    </button>
                </form>
            </div>

            <!-- Plan Management Card -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Plan Management</h2>
                
                <!-- Current Plan -->
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900">Current Plan</h3>
                    <div class="mt-2 p-4 bg-gray-50 rounded-lg">
                        <p class="text-gray-900 font-medium">{{ Auth::user()->premium_type }} Plan</p>
                        <p class="text-sm text-gray-600 mt-1">Your current subscription details</p>
                    </div>
                </div>

                <!-- Available Plans -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Available Plans</h3>
                    <div class="space-y-4">
                        @php
                            $availablePlans = ['External', 'Streamer', 'Bypass', 'Reseller'];
                            $currentPlan = Auth::user()->premium_type;
                        @endphp

                        @foreach($availablePlans as $plan)
                            @if($plan !== $currentPlan)
                                <div class="border rounded-lg p-4 hover:border-indigo-500 transition-colors">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <h4 class="font-medium text-gray-900">{{ $plan }} Plan</h4>
                                            <p class="text-sm text-gray-600">Upgrade to {{ $plan }} features</p>
                                        </div>
                                        <form action="{{ route('premium.plan.upgrade') }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="plan" value="{{ $plan }}">
                                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                Upgrade
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Usage Statistics -->
        <div class="mt-6 bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Usage Statistics</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-500">Total Requests</h3>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">0</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-500">Remaining Quota</h3>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">1000</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-500">Plan Expiry</h3>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">Never</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 