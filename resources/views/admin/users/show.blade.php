@extends('layouts.admin')

@section('title', ' - View User')

@section('content')
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">User Details</h1>
            <div>
                <a href="{{ route('admin.users.edit', $user->id) }}"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded mr-2">
                    <i class="fas fa-edit mr-2"></i> Edit
                </a>
                <a href="{{ route('admin.users.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-arrow-left mr-2"></i> Back
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-xl font-bold mb-4">User Information</h3>

                        <div class="mb-4">
                            <p class="text-gray-600 text-sm">ID</p>
                            <p class="font-medium">{{ $user->id }}</p>
                        </div>

                        <div class="mb-4">
                            <p class="text-gray-600 text-sm">Name</p>
                            <p class="font-medium">{{ $user->name }}</p>
                        </div>

                        <div class="mb-4">
                            <p class="text-gray-600 text-sm">Username</p>
                            <p class="font-medium">{{ $user->username }}</p>
                        </div>

                        <div class="mb-4">
                            <p class="text-gray-600 text-sm">Email</p>
                            <p class="font-medium">{{ $user->email }}</p>
                        </div>

                        <div class="mb-4">
                            <p class="text-gray-600 text-sm">Role</p>
                            @if($user->role === 'admin')
                                <span class="bg-purple-100 text-purple-800 py-1 px-3 rounded-full text-xs">Admin</span>
                            @else
                                <span class="bg-blue-100 text-blue-800 py-1 px-3 rounded-full text-xs">User</span>
                            @endif
                        </div>
                    </div>

                    <div>
                        <h3 class="text-xl font-bold mb-4">Account Timeline</h3>

                        <div class="mb-4">
                            <p class="text-gray-600 text-sm">Account Created</p>
                            <p class="font-medium">{{ $user->created_at->format('F j, Y, g:i a') }}</p>
                        </div>

                        <div class="mb-4">
                            <p class="text-gray-600 text-sm">Last Updated</p>
                            <p class="font-medium">{{ $user->updated_at->format('F j, Y, g:i a') }}</p>
                        </div>

                        @if($user->email_verified_at)
                            <div class="mb-4">
                                <p class="text-gray-600 text-sm">Email Verified</p>
                                <p class="font-medium">{{ $user->email_verified_at->format('F j, Y, g:i a') }}</p>
                            </div>
                        @else
                            <div class="mb-4">
                                <p class="text-gray-600 text-sm">Email Verification</p>
                                <span class="bg-yellow-100 text-yellow-800 py-1 px-3 rounded-full text-xs">Not Verified</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection