<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pengguna - Robot System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        'robot-dark': '#0a0a0a',
                        'robot-gray': '#1a1a1a',
                        'robot-blue': '#00bcd4',
                        'robot-green': '#4caf50',
                        'robot-red': '#f44336',
                        'robot-yellow': '#ffeb3b'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-robot-dark text-gray-100 min-h-screen font-mono">
    <!-- Header -->
    <header class="bg-robot-gray border-b border-robot-blue/20 sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-robot-blue rounded-full flex items-center justify-center">
                        <span class="text-robot-dark font-bold text-sm">⚡</span>
                    </div>
                    <h1 class="text-xl font-bold text-robot-blue">Tendako</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="hidden md:flex items-center space-x-2 text-sm text-gray-400">
                        <span>●</span>
                        <span>ONLINE</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-6 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-bold text-robot-blue mb-2">PENGGUNA DATABASE</h2>
                    <p class="text-gray-400">Manajemen data pengguna sistem</p>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('pengguna.trash') }}" class="bg-robot-red/20 text-robot-red border border-robot-red/30 px-4 py-2 rounded-lg hover:bg-robot-red/30 transition-all duration-300 flex items-center space-x-2">
                        <span>🗑️</span>
                        <span>TRASH</span>
                    </a>
                    <a href="{{ route('pengguna.create') }}" class="bg-robot-blue/20 text-robot-blue border border-robot-blue/30 px-4 py-2 rounded-lg hover:bg-robot-blue/30 transition-all duration-300 flex items-center space-x-2">
                        <span>➕</span>
                        <span>ADD NEW</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Alerts -->
        @if(session('success'))
        <div class="mb-6 bg-robot-green/20 border border-robot-green/30 text-robot-green p-4 rounded-lg">
            <div class="flex items-center space-x-2">
                <span>✅</span>
                <span>{{ session('success') }}</span>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-6 bg-robot-red/20 border border-robot-red/30 text-robot-red p-4 rounded-lg">
            <div class="flex items-center space-x-2">
                <span>❌</span>
                <span>{{ session('error') }}</span>
            </div>
        </div>
        @endif

        <!-- Search -->
        <div class="mb-6">
            <form method="GET" action="{{ route('pengguna.index') }}" class="flex items-center space-x-4">
                <div class="flex-1 relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search pengguna..." 
                           class="w-full bg-robot-gray border border-gray-600 rounded-lg px-4 py-2 pl-10 text-gray-100 focus:outline-none focus:border-robot-blue">
                    <span class="absolute left-3 top-2.5 text-gray-400">🔍</span>
                </div>
                <button type="submit" class="bg-robot-blue/20 text-robot-blue border border-robot-blue/30 px-6 py-2 rounded-lg hover:bg-robot-blue/30 transition-all duration-300">
                    SEARCH
                </button>
                @if(request('search'))
                <a href="{{ route('pengguna.index') }}" class="bg-robot-gray border border-gray-600 px-4 py-2 rounded-lg hover:bg-gray-700 transition-all duration-300">
                    RESET
                </a>
                @endif
            </form>
        </div>

        <!-- Data Table -->
        <div class="bg-robot-gray border border-gray-600 rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-robot-blue/10 border-b border-robot-blue/20">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-robot-blue uppercase tracking-wider">ID</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-robot-blue uppercase tracking-wider">NAMA</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-robot-blue uppercase tracking-wider">EMAIL</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-robot-blue uppercase tracking-wider">JABATAN</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-robot-blue uppercase tracking-wider">CREATED</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-robot-blue uppercase tracking-wider">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-600">
                        @forelse($pengguna as $item)
                        <tr class="hover:bg-robot-blue/5 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-robot-blue">
                                #{{ $item->id_pgn }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-100">
                                {{ $item->nama_pgn }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                {{ $item->email_pgn }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-100">
                                <span class="bg-robot-blue/20 text-robot-blue px-2 py-1 rounded text-xs">
                                    {{ $item->nama_jbt ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                {{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('pengguna.show', $item->id_pgn) }}" class="bg-robot-blue/20 text-robot-blue border border-robot-blue/30 px-3 py-1 rounded text-xs hover:bg-robot-blue/30 transition-all duration-300">
                                        VIEW
                                    </a>
                                    <a href="{{ route('pengguna.edit', $item->id_pgn) }}" class="bg-robot-yellow/20 text-robot-yellow border border-robot-yellow/30 px-3 py-1 rounded text-xs hover:bg-robot-yellow/30 transition-all duration-300">
                                        EDIT
                                    </a>
                                    <form method="POST" action="{{ route('pengguna.destroy', $item->id_pgn) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this pengguna?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-robot-red/20 text-robot-red border border-robot-red/30 px-3 py-1 rounded text-xs hover:bg-robot-red/30 transition-all duration-300">
                                            DELETE
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-400">
                                <div class="flex flex-col items-center space-y-2">
                                    <span class="text-2xl">🤖</span>
                                    <span>No data found in database</span>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($pengguna->hasPages())
        <div class="mt-6 flex justify-center">
            <div class="flex items-center space-x-2">
                {{-- Previous Page Link --}}
                @if ($pengguna->onFirstPage())
                    <span class="bg-robot-gray border border-gray-600 px-3 py-2 rounded text-gray-500 cursor-not-allowed">PREV</span>
                @else
                    <a href="{{ $pengguna->previousPageUrl() }}" class="bg-robot-blue/20 text-robot-blue border border-robot-blue/30 px-3 py-2 rounded hover:bg-robot-blue/30 transition-all duration-300">PREV</a>
                @endif

                {{-- Page Numbers --}}
                @foreach ($pengguna->getUrlRange(1, $pengguna->lastPage()) as $page => $url)
                    @if ($page == $pengguna->currentPage())
                        <span class="bg-robot-blue text-robot-dark px-3 py-2 rounded font-bold">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="bg-robot-gray border border-gray-600 px-3 py-2 rounded hover:bg-gray-700 transition-all duration-300">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($pengguna->hasMorePages())
                    <a href="{{ $pengguna->nextPageUrl() }}" class="bg-robot-blue/20 text-robot-blue border border-robot-blue/30 px-3 py-2 rounded hover:bg-robot-blue/30 transition-all duration-300">NEXT</a>
                @else
                    <span class="bg-robot-gray border border-gray-600 px-3 py-2 rounded text-gray-500 cursor-not-allowed">NEXT</span>
                @endif
            </div>
        </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-robot-gray border-t border-robot-blue/20 mt-12">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-400">
                    © 2024 Robot System. All rights reserved.
                </div>
                <div class="flex items-center space-x-4 text-sm text-gray-400">
                    <span>STATUS: OPERATIONAL</span>
                    <div class="w-2 h-2 bg-robot-green rounded-full animate-pulse"></div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>