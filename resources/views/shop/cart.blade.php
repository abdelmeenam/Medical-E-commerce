@extends('layouts.shop')

@section('title', 'Your Shopping Cart')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Your Cart</h1>

    @if($cart->countItem()> 0)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Product</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Quantity</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Subtotal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200" id="cart-items">
                        @foreach($cart->get() as $item)
                            <tr data-id="{{ $item->id }}" class="cart-item" id="item-{{ $item->product->id }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full" src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $item->product->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 item-price" data-price="{{ $item->product->price }}">${{ number_format( $item->product->price, 2) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <button class="update-quantity minus bg-gray-200 px-2 py-1 rounded-l text-gray-700" data-id="{{ $item->product->id }}" data-action="minus">-</button>
                                        <input type="number" value="{{ $item->quantity }}" class="quantity w-12 text-center py-1 border-y border-gray-300 focus:outline-none" min="1" max="99" data-id="{{ $item->product->id }}">
                                        <button class="update-quantity plus bg-gray-200 px-2 py-1 rounded-r text-gray-700" data-id="{{ $item->product->id }}" data-action="plus">+</button>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 item-subtotal" data-id="{{ $item->product->id }}">${{ number_format($item->quantity * $item->product->price, 2) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button class="remove-from-cart text-red-600 hover:text-red-800" data-id="{{ $item->product->id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 bg-gray-50">
                <div class="flex justify-between items-center">
                    <div>
                        <a href="{{ route('shop.home') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                            Continue Shopping
                        </a>
                    </div>
                    <div class="text-right">
                        <div class="text-lg font-bold text-gray-800" id="cart-total">Total: ${{ number_format($cart->total(), 2) }}</div>
                        <a href="{{ route('checkout.index') }}" class="mt-3 inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded">
                            Proceed to Checkout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-8 text-center" id="empty-cart">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
            </svg>
            <h2 class="text-xl font-semibold text-gray-800 mt-4">Your cart is empty</h2>
            <p class="text-gray-600 mt-2">Looks like you haven't added any products to your cart yet.</p>
            <a href="{{ route('shop.home') }}" class="mt-6 inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded">
                Start Shopping
            </a>
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get CSRF token from meta tag
    const csrf_token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Update quantity when clicking + or - buttons
    const updateQuantityButtons = document.querySelectorAll('.update-quantity');
    updateQuantityButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');
            const action = this.getAttribute('data-action');
            const inputElement = this.parentElement.querySelector('.quantity');
            let quantity = parseInt(inputElement.value);

            if (action === 'plus' && quantity < 99) {
                quantity += 1;
            } else if (action === 'minus' && quantity > 1) {
                quantity -= 1;
            }

            inputElement.value = quantity;
            updateCartItem(productId, quantity);
            updateSubtotal(productId, quantity);
            updateCartTotal();
        });
    });

    // Update quantity when input changes directly
    const quantityInputs = document.querySelectorAll('.quantity');
    quantityInputs.forEach(input => {
        input.addEventListener('change', function() {
            const productId = this.getAttribute('data-id');
            let quantity = parseInt(this.value);

            // Validate quantity
            if (isNaN(quantity) || quantity < 1) {
                quantity = 1;
            } else if (quantity > 99) {
                quantity = 99;
            }

            this.value = quantity;
            updateCartItem(productId, quantity);
            updateSubtotal(productId, quantity);
            updateCartTotal();
        });
    });

    // Remove item from cart
    const removeButtons = document.querySelectorAll('.remove-from-cart');
    removeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');
            removeCartItem(productId);
        });
    });

    // Function to update cart item quantity
    function updateCartItem(productId, quantity) {
        fetch(`/cart/${productId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf_token,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                quantity: quantity
            })
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => Promise.reject(err));
            }
            return response.json();
        })
        .then(data => {
            // Show notification if needed
            if (data.message) {
                showNotification(data.message);
            }
        })
        .catch(error => {
            showNotification(error.error, 'error');
            resetQuantityInput(productId);

    });
    }

    // Function to calculate and update subtotal for an item
    function updateSubtotal(productId, quantity) {
        const row = document.querySelector(`#item-${productId}`);
        const priceElement = row.querySelector('.item-price');
        const subtotalElement = row.querySelector('.item-subtotal');

        const price = parseFloat(priceElement.getAttribute('data-price'));
        const subtotal = price * quantity;

        subtotalElement.textContent = '$' + subtotal.toFixed(2);
    }

    // Function to update the cart total
    function updateCartTotal() {
        let total = 0;
        const subtotalElements = document.querySelectorAll('.item-subtotal');

        subtotalElements.forEach(element => {
            const subtotalText = element.textContent.replace('$', '');
            total += parseFloat(subtotalText);
        });

        document.getElementById('cart-total').textContent = 'Total: $' + total.toFixed(2);
    }

    // Function to remove item from cart
    function removeCartItem(productId) {
        fetch(`/cart/${productId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrf_token,
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Remove the item from DOM
            const itemElement = document.querySelector(`#item-${productId}`);
            itemElement.remove();

            if (data.message) {
                showNotification(data.message);
            }
            location.reload();
        })
        .catch(error => {
            console.error('Error removing item:', error);
            showNotification('Failed to remove item. Please try again.', 'error');
        });
    }

    // Function to show empty cart message
    function showEmptyCart() {
        document.querySelector('.bg-white.rounded-lg.shadow-md.overflow-hidden').style.display = 'none';

        // Create empty cart element if it doesn't exist
        if (!document.getElementById('empty-cart')) {
            const emptyCartHtml = `
                <div class="bg-white rounded-lg shadow-md p-8 text-center" id="empty-cart">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                    </svg>
                    <h2 class="text-xl font-semibold text-gray-800 mt-4">Your cart is empty</h2>
                    <p class="text-gray-600 mt-2">Looks like you haven't added any products to your cart yet.</p>
                    <a href="{{ route('shop.home') }}" class="mt-6 inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded">
                        Start Shopping
                    </a>
                </div>
            `;
            const container = document.querySelector('.container.mx-auto.px-4.py-8');
            container.insertAdjacentHTML('beforeend', emptyCartHtml);
        } else {
            document.getElementById('empty-cart').style.display = 'block';
        }
    }

    // Function to show notification
    function showNotification(message, type = 'success') {
        // Create notification element if it doesn't exist
        if (!document.getElementById('notification')) {
            const notificationHtml = `
                <div id="notification" class="fixed top-4 right-4 py-2 px-4 rounded-md shadow-md transition-opacity duration-300 opacity-0 z-50"></div>
            `;
            document.body.insertAdjacentHTML('beforeend', notificationHtml);
        }

        const notification = document.getElementById('notification');

        // Set styles based on notification type
        if (type === 'success') {
            notification.className = 'fixed top-4 right-4 py-2 px-4 rounded-md shadow-md transition-opacity duration-300 bg-green-500 text-white';
        } else {
            notification.className = 'fixed top-4 right-4 py-2 px-4 rounded-md shadow-md transition-opacity duration-300 bg-red-500 text-white';
        }

        // Set notification message
        notification.textContent = message;

        // Show notification
        notification.style.opacity = '1';

        // Hide notification after 3 seconds
        setTimeout(() => {
            notification.style.opacity = '0';
        }, 4000);
    }
});
// Optional helper to reset quantity input on error
function resetQuantityInput(productId) {
    // Reset the quantity input field to its previous value
    const input = document.querySelector(`input[data-product-id="${productId}"]`);
    console.log(input);
    if (input) {
        input.value = input.dataset.previousValue;
    }
}
</script>
@endsection
