@extends('layouts.shop')

@section('title', 'Medical E-Commerce | Home')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Medical Products</h1>
        <p class="text-gray-600 mt-2">Browse our selection of high-quality medical products</p>
    </div>

    <!-- Products Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($products as $product)
            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow duration-300">
                @if($product->image)
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                        <span class="text-gray-400">No image available</span>
                    </div>
                @endif
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-800">{{ $product->name }}</h3>
                    <p class="text-gray-600 text-sm mt-1 line-clamp-2">{{ $product->description }}</p>
                    <div class="mt-3 flex items-center justify-between">
                        <span class="text-blue-600 font-bold">${{ number_format($product->price, 2) }}</span>
                        <form id="add-to-cart-form-{{ $product->id }}" data-product-id="{{ $product->id }}" method="POST">
                            @csrf

                            <button type="button" onclick="addToCart('{{ $product->id }}')"  class="flex items-center bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded-md transition-colors duration-200 add-to-cart" data-product-id="{{ $product->id }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-8 text-center">
                <p class="text-lg text-gray-600">No products found in this category.</p>
                <a href="{{ route('shop.home') }}" class="mt-4 inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">View All Products</a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $products->links() }}
    </div>
</div>
@endsection


@push('scripts')
<script>
    function addToCart(productId) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

        // Show loading indicator (optional)
        const addButton = document.getElementById(`add-btn-${productId}`);
        if (addButton) {
            addButton.disabled = true;
            addButton.innerText = 'Adding...';
        }

        fetch(`{{ url('cart') }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: 1
            })
        })
        .then(response => {
            // First check if the response is ok
            if (!response.ok) {
                return response.json().then(err => {
                    throw err;
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                alert('Product added to cart successfully!');
                // refresh the browser
                location.reload();
            }
        })
        .catch(error => {
            // Show error message from the server if available
            if (error.error) {
                alert(error.error);
            } else {
                alert('An error occurred. Please try again.');
            }
        }).finally(() => {
            // Always reset the button state
            if (addButton) {
                addButton.disabled = false;
                addButton.innerText = 'Add to Cart';
            }
        });

    }
</script>
@endpush

