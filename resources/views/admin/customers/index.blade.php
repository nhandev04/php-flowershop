@extends('layouts.admin')

@section('title', 'Customer Management')

@section('content')
    <div class="container-fluid p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Customer List</h1>
            <a href="{{ route('admin.customers.create') }}"
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                <i class="fas fa-plus mr-2"></i> Add Customer
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 dark:bg-green-900/20 border border-green-400 dark:border-green-800 text-green-700 dark:text-green-200 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 p-4 rounded shadow mb-4 transition-colors duration-300">
            <form method="GET" action="{{ route('admin.customers.index') }}" class="flex gap-4 flex-wrap">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300" for="search">Search</label>
                    <input id="search" name="search" type="text" value="{{ request('search') }}"
                        placeholder="Name, email, phone..."
                        class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-300" />
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                        <i class="fas fa-search mr-1"></i> Search
                    </button>
                    <a href="{{ route('admin.customers.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                        <i class="fas fa-times mr-1"></i> Clear
                    </a>
                </div>
            </form>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded shadow overflow-x-auto transition-colors duration-300">
            <table class="w-full table-auto">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-2 text-left">
                            <a href="{{ route('admin.customers.index', array_merge(request()->query(), ['sort' => 'id', 'direction' => request('sort') == 'id' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center hover:text-gray-700 dark:hover:text-gray-200 text-gray-900 dark:text-white">
                                ID
                                @if(request('sort') == 'id')
                                    <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @else
                                    <i class="fas fa-sort ml-1 opacity-50"></i>
                                @endif
                            </a>
                        </th>
                        <th class="px-4 py-2 text-left">
                            <a href="{{ route('admin.customers.index', array_merge(request()->query(), ['sort' => 'name', 'direction' => request('sort') == 'name' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center hover:text-gray-700 dark:hover:text-gray-200 text-gray-900 dark:text-white">
                                Name
                                @if(request('sort') == 'name')
                                    <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @else
                                    <i class="fas fa-sort ml-1 opacity-50"></i>
                                @endif
                            </a>
                        </th>
                        <th class="px-4 py-2 text-left">
                            <a href="{{ route('admin.customers.index', array_merge(request()->query(), ['sort' => 'email', 'direction' => request('sort') == 'email' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center hover:text-gray-700 dark:hover:text-gray-200 text-gray-900 dark:text-white">
                                Email
                                @if(request('sort') == 'email')
                                    <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @else
                                    <i class="fas fa-sort ml-1 opacity-50"></i>
                                @endif
                            </a>
                        </th>
                        <th class="px-4 py-2 text-left text-gray-900 dark:text-white">Phone</th>
                        <th class="px-4 py-2 text-left">
                            <a href="{{ route('admin.customers.index', array_merge(request()->query(), ['sort' => 'created_at', 'direction' => request('sort') == 'created_at' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center hover:text-gray-700 dark:hover:text-gray-200 text-gray-900 dark:text-white">
                                Created At
                                @if(request('sort') == 'created_at')
                                    <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @else
                                    <i class="fas fa-sort ml-1 opacity-50"></i>
                                @endif
                            </a>
                        </th>
                        <th class="px-4 py-2 text-left text-gray-900 dark:text-white">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($customers as $customer)
                        <tr class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-4 py-2 text-gray-900 dark:text-white">{{ $customer->id }}</td>
                            <td class="px-4 py-2 text-gray-900 dark:text-white">{{ $customer->name }}</td>
                            <td class="px-4 py-2 text-gray-900 dark:text-white">{{ $customer->email }}</td>
                            <td class="px-4 py-2 text-gray-900 dark:text-white">{{ $customer->phone ?? '—' }}</td>
                            <td class="px-4 py-2 text-gray-900 dark:text-white">{{ $customer->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-2 flex gap-3">
                                <a href="{{ route('admin.customers.show', $customer->id) }}"
                                    class="text-blue-500 hover:text-blue-700">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.customers.edit', $customer->id) }}"
                                    class="text-yellow-500 hover:text-yellow-700">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.customers.destroy', $customer->id) }}"
                                    onsubmit="return confirm('Delete this customer?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-2 text-center text-gray-500 dark:text-gray-400">No customers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $customers->links() }}
        </div>
    </div>
@endsection