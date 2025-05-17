<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Product Logs') }} - {{ $product->name }}
            </h2>
            <a href="{{ route('admin.products.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Back to Products') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Changed By</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Changes</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($logs as $log)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $log->created_at->format('Y-m-d H:i:s') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                {{ $log->action === 'created' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $log->action === 'updated' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $log->action === 'deleted' ? 'bg-red-100 text-red-800' : '' }}">
                                                {{ ucfirst($log->action) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $log->admin->name }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            @if($log->action === 'updated')
                                                <div class="space-y-2">
                                                    @foreach($log->changes['new'] as $field => $newValue)
                                                        <div>
                                                            <span class="font-medium">{{ ucfirst($field) }}:</span>
                                                            <span class="text-red-500 line-through">{{ $log->changes['old'][$field] }}</span>
                                                            <span class="text-green-500">→ {{ $newValue }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @elseif($log->action === 'created')
                                                <div class="space-y-1">
                                                    @foreach($log->changes['new'] as $field => $value)
                                                        <div>
                                                            <span class="font-medium">{{ ucfirst($field) }}:</span>
                                                            <span class="text-green-500">{{ $value }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <div class="space-y-1">
                                                    @foreach($log->changes['old'] as $field => $value)
                                                        <div>
                                                            <span class="font-medium">{{ ucfirst($field) }}:</span>
                                                            <span class="text-red-500">{{ $value }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
