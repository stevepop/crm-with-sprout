<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sprout - Multi-Tenant Demo</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50 text-gray-700 dark:bg-gray-900 dark:text-gray-300">
<div class="max-w-3xl mx-auto px-4 sm:px-6 py-8">
    <header class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Multi-Tenant Demo</h1>

        @if (Route::has('login'))
            <div class="flex space-x-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium">Register</a>
                    @endif
                @endauth
            </div>
        @endif
    </header>

    <main>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-6 p-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">About This Demo</h2>
            <a class="mb-4">
                This application demonstrates a multi-tenant system built with <a href="https://sprout.ollieread.com/" target="_blank" class="text-blue-700"> Sprout</a> in a Laravel application. It shows how to isolate
                tenant data within a single database while maintaining a single codebase.
            </p>

            <div class="space-y-3 mt-4">
                <div>
                    <span class="font-semibold text-indigo-600 dark:text-indigo-400">Domain-based identification:</span>
                    <span>Each tenant is identified by their domain name</span>
                </div>
                <div>
                    <span class="font-semibold text-indigo-600 dark:text-indigo-400">Data isolation:</span>
                    <span>All tenants share a single database with isolated data access</span>
                </div>
                <div>
                    <span class="font-semibold text-indigo-600 dark:text-indigo-400">Automatic tenant detection:</span>
                    <span>The system automatically determines which tenant is accessing the application</span>
                </div>
                <div>
                    <span class="font-semibold text-indigo-600 dark:text-indigo-400">Scoped data access:</span>
                    <span>Tenant data is automatically scoped to prevent cross-tenant access</span>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-6 p-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Getting Started</h2>
            <p class="mb-4">
                To explore this demo, you can register a new account or log in using the navigation links above.
                Each tenant will have their own isolated environment with independent data.
            </p>
            <p class="mb-2">
                For testing purposes, you can access these demo tenants:
            </p>
            <div class="bg-gray-100 dark:bg-gray-700 rounded p-3 font-mono text-sm">
                tenant1.[your-domain] or tenant1.localhost<br>
                tenant2.[your-domain] or tenant2.localhost
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Implementation Details</h2>
            <p class="mb-2">
                This demo is built using the <a href="https://sprout.ollieread.com/docs/1.x/installation" class="text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">Sprout Laravel package</a>,
                which provides a robust foundation for multi-tenant applications.
            </p>
            <p class="mb-2">
                Sprout middleware resolves the current tenant based on the subdomain. While Sprout supports multiple
                resolution methods (subdomains, paths, headers, session, or cookies), this demo specifically uses
                the subdomain approach. Once the tenant is identified, the application automatically
                scopes all database queries to the current tenant.
            </p>
            <p class="mb-4">
                The implementation follows best practices for multi-tenant applications in Laravel, including:
            </p>
            <ul class="list-disc pl-5 space-y-2">
                <li>Central user authentication with tenant-specific roles</li>
                <li>Automatic query scoping for tenant data isolation</li>
            </ul>
        </div>
    </main>

    <footer class="mt-12 text-center text-gray-500 text-sm">
        Multi-Tenant Demo With Sprout by Steve Popoola &copy; {{ date('Y') }}
    </footer>
</div>
</body>
</html>
