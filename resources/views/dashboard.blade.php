<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200" x-data="{ showOrgInfo: false }">
                    <h3 class="text-lg font-medium mb-4">Welcome to {{ $organisation->name }} Dashboard</h3>

                    <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-sm text-gray-500">Current Organisation</span>
                                <div class="text-lg font-medium">{{ $organisation->name }}</div>
                            </div>
                            <button
                                @click="showOrgInfo = !showOrgInfo"
                                class="text-sm px-3 py-1 bg-blue-100 hover:bg-blue-200 rounded-md"
                            >
                                <span x-text="showOrgInfo ? 'Hide Details' : 'Show Details'"></span>
                            </button>
                        </div>

                        <div x-show="showOrgInfo" class="mt-3 text-sm border-t border-blue-100 pt-3">
                            <div class="grid grid-cols-2 gap-2">
                                <div><strong>Organisation ID:</strong> {{ $organisation->id }}</div>
                                <div><strong>Subdomain:</strong> {{ $organisation->subdomain }}</div>
                                <div><strong>Email:</strong> {{ $organisation->email }}</div>
                                <div><strong>Phone:</strong> {{ $organisation->phone }}</div>
                                <div><strong>Created:</strong> {{ $organisation->created_at->format('Y-m-d') }}</div>
                                <div><strong>Users:</strong> {{ $organisation->users->count() }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-6">
                        <div class="bg-white p-4 rounded-lg shadow border border-gray-200">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-indigo-100 mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-500">Total Contacts</div>
                                    <div class="text-2xl font-semibold">{{ $contactCount }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-4 rounded-lg shadow border border-gray-200">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-blue-100 mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-500">Leads</div>
                                    <div class="text-2xl font-semibold">{{ $contactsByStatus['lead'] }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-4 rounded-lg shadow border border-gray-200">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-green-100 mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-500">Customers</div>
                                    <div class="text-2xl font-semibold">{{ $contactsByStatus['customer'] }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-4 rounded-lg shadow border border-gray-200">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-gray-100 mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-500">Inactive</div>
                                    <div class="text-2xl font-semibold">{{ $contactsByStatus['inactive'] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
