@extends('layouts.shop')

@section('title', 'Order Confirmed')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6 bg-green-50 border-b border-green-100">
            <div class="flex items-center justify-center mb-4">
                <div class="bg-green-100 rounded-full p-2">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>
            <h1 class="text-2xl font-bold text-center text-gray-800 mb-2">Order Confirmed!</h1>
            <p class="text-center text-gray-600">Thank you for your purchase. Your order has been received.</p>
        </div>

        <div class="p-6">
            <div class="border-b border-gray-200 pb-4 mb-4">
                <h2 class="text-lg font-semibold text-gray-800 mb-3">Order Details</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-600 text-sm">Order Number</p>
                        <p class="font-medium">{{ $order->order_number }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Date</p>
                        <p class="font-medium">{{ $order->created_at->format('F j, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Total Amount</p>
                        <p class="font-medium">${{ number_format($order->total_amount, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Status</p>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 ">
                            {{ $order->status}}
                        </span>
                    </div>
                </div>
            </div>

            <div class="border-b border-gray-200 pb-4 mb-4">
                <h2 class="text-lg font-semibold text-gray-800 mb-3">Customer Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-600 text-sm">Name</p>
                        <p class="font-medium">{{ $order->full_name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Phone</p>
                        <p class="font-medium">{{ $order->phone }}</p>
                    </div>
                    @if($order->email)
                    <div>
                        <p class="text-gray-600 text-sm">Email</p>
                        <p class="font-medium">{{ $order->email }}</p>
                    </div>
                    @endif
                    <div class="md:col-span-2">
                        <p class="text-gray-600 text-sm">Delivery Address</p>
                        <p class="font-medium">{{ $order->address }}</p>
                    </div>
                    @if($order->notes)
                    <div class="md:col-span-2">
                        <p class="text-gray-600 text-sm">Order Notes</p>
                        <p class="font-medium">{{ $order->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-3">Order Items</h2>

                <div class="space-y-4">
                    @foreach($order->products as $item)
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0 h-12 w-12">
                                    <img class="h-12 w-12 rounded-lg object-cover" src="{{ $item->image_url }}" alt="{{ $item->name }}">
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-gray-800 font-medium">{{ $item->order_item->product_name }}</span>
                                    <span class="text-gray-500 text-sm">Qty: {{ $item->order_item->quantity }} × ${{ number_format($item->order_item->unit_price, 2) }}</span>
                                </div>
                            </div>
                            <span class="text-gray-800 font-medium">${{ number_format($item->order_item->quantity * $item->order_item->unit_price, 2) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-gray-50 p-4 rounded-lg">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-gray-600">Shipping</span>
                    <span class="text-gray-800">$0.00</span>
                </div>
                <div class="flex justify-between items-center text-lg font-bold pt-2 border-t border-gray-200">
                    <span class="text-gray-800">Total</span>
                    <span class="text-blue-600">${{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
        </div>

        <div class="p-6 bg-gray-50 border-t border-gray-200 text-center">
            <p class="text-gray-600 mb-4">We'll send you a confirmation email with your order details.</p>
            <div class="flex justify-center space-x-4">
                <a href="{{ route('shop.home') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
