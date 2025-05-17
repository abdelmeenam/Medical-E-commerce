@extends('layouts.shop')

@section('title', 'Checkout')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Checkout</h1>

    <!-- Alert for displaying AJAX response messages -->
    <div id="checkout-alert" class="hidden mb-6">
        <div id="success-alert" class="hidden bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            <span id="success-message"></span>
        </div>
        <div id="error-alert" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <span id="error-message"></span>
        </div>
    </div>

    @if($cart->countItem() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Customer Information Form -->
            <div class="lg:col-span-7">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Customer Information</h2>

                    <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
                        @csrf
                        <div class="mb-4">
                            <label for="full_name" class="block text-gray-700 font-medium mb-2">Full Name *</label>
                            <input type="text" name="full_name" id="full_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('full_name') border-red-500 @enderror" value="{{ old('full_name') }}" required>
                            <p class="text-red-500 text-sm mt-1 hidden" id="full_name-error"></p>
                            @error('full_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="phone" class="block text-gray-700 font-medium mb-2">Phone Number *</label>
                            <input type="tel" name="phone" id="phone" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('phone') border-red-500 @enderror" value="{{ old('phone') }}" required>
                            <p class="text-red-500 text-sm mt-1 hidden" id="phone-error"></p>
                            @error('phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 font-medium mb-2">Email Address (Optional)</label>
                            <input type="email" name="email" id="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror" value="{{ old('email') }}">
                            <p class="text-red-500 text-sm mt-1 hidden" id="email-error"></p>
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="address" class="block text-gray-700 font-medium mb-2">Delivery Address *</label>
                            <textarea name="address" id="address" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('address') border-red-500 @enderror" required>{{ old('address') }}</textarea>
                            <p class="text-red-500 text-sm mt-1 hidden" id="address-error"></p>
                            @error('address')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="notes" class="block text-gray-700 font-medium mb-2">Order Notes (Optional)</label>
                            <textarea name="notes" id="notes" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('notes') }}</textarea>
                            <p class="text-red-500 text-sm mt-1 hidden" id="notes-error"></p>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-5">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Order Summary</h2>
                        <div class="space-y-4">
                            @foreach($cart->get() as $item)
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0 h-12 w-12">
                                            <img class="h-12 w-12 rounded-lg object-cover" src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}">
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-gray-800 font-medium">{{ $item->product->name }}</span>
                                            <span class="text-gray-500 text-sm">Qty: {{ $item->quantity }}</span>
                                        </div>
                                    </div>
                                    <span class="text-gray-800 font-medium">${{ number_format($item->product->price * $item->quantity, 2) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="p-6 bg-gray-50">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-gray-600 font-medium">Shipping</span>
                            <span class="text-gray-800 font-medium">$0</span>
                        </div>
                        <div class="flex justify-between items-center text-lg font-bold">
                            <span class="text-gray-800">Total</span>
                            <span class="text-blue-600">${{ number_format($cart->total(), 2) }}</span>
                        </div>

                        <button type="button" id="place-order-btn" class="w-full mt-6 bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg">
                            Place Order
                        </button>

                        <!-- Loading spinner (hidden by default) -->
                        <div id="loading-spinner" class="hidden w-full mt-6 bg-blue-600 text-white font-medium py-3 px-4 rounded-lg text-center">
                            <svg class="animate-spin h-5 w-5 text-white inline mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Processing...
                        </div>

                        <div class="mt-4 text-center">
                            <a href="{{ route('cart.index') }}" class="text-blue-600 hover:text-blue-800">
                                Return to Cart
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <h2 class="text-xl font-semibold text-gray-800">Your cart is empty</h2>
            <p class="text-gray-600 mt-2">You need to add products to your cart before checking out.</p>
            <a href="{{ route('shop.home') }}" class="mt-6 inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded">
                Browse Products
            </a>
        </div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('checkout-form');
        const placeOrderBtn = document.getElementById('place-order-btn');
        const loadingSpinner = document.getElementById('loading-spinner');
        const checkoutAlert = document.getElementById('checkout-alert');
        const successAlert = document.getElementById('success-alert');
        const errorAlert = document.getElementById('error-alert');
        const successMessage = document.getElementById('success-message');
        const errorMessage = document.getElementById('error-message');

        // Reset error displays
        function resetErrors() {
            const errorElements = document.querySelectorAll('[id$="-error"]');
            errorElements.forEach(el => {
                el.textContent = '';
                el.classList.add('hidden');
            });

            // Hide alerts
            checkoutAlert.classList.add('hidden');
            successAlert.classList.add('hidden');
            errorAlert.classList.add('hidden');
        }

        // Display validation errors
        function displayErrors(errors) {
            resetErrors();

            if (typeof errors === 'string') {
                // Handle single error message
                errorMessage.textContent = errors;
                checkoutAlert.classList.remove('hidden');
                errorAlert.classList.remove('hidden');
                return;
            }

            // Handle object of errors
            for (const field in errors) {
                const errorField = document.getElementById(`${field}-error`);
                if (errorField) {
                    errorField.textContent = errors[field];
                    errorField.classList.remove('hidden');
                } else {
                    // If no specific field error element, display in general error alert
                    errorMessage.textContent = errors[field];
                    checkoutAlert.classList.remove('hidden');
                    errorAlert.classList.remove('hidden');
                }
            }
        }

        // Handle form submission
        placeOrderBtn.addEventListener('click', function(e) {
            e.preventDefault();
            resetErrors();

            // Show loading state
            placeOrderBtn.classList.add('hidden');
            loadingSpinner.classList.remove('hidden');

            // Collect form data
            const formData = new FormData(form);

            // Send AJAX request
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    successMessage.textContent = data.message;
                    checkoutAlert.classList.remove('hidden');
                    successAlert.classList.remove('hidden');

                    // Redirect after a brief delay to show the success message
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 1500);
                } else if (data.error) {
                    // Show error message
                    displayErrors(data.error);
                    // Restore button
                    placeOrderBtn.classList.remove('hidden');
                    loadingSpinner.classList.add('hidden');
                }
            })
            .catch(error => {
                // Handle network errors
                errorMessage.textContent = 'Network error. Please try again.';
                checkoutAlert.classList.remove('hidden');
                errorAlert.classList.remove('hidden');

                // Restore button
                placeOrderBtn.classList.remove('hidden');
                loadingSpinner.classList.add('hidden');

                console.error('Error:', error);
            });
        });
    });
</script>
@endpush

@endsection
