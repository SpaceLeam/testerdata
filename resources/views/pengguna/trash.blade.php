<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trash Pengguna - Robot System</title>
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
                    <h2 class="text-3xl font-bold text-robot-red mb-2">TRASH PENGGUNA</h2>
                    <p class="text-gray-400">Data pengguna yang telah dihapus</p>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('pengguna.index') }}" class="bg-robot-blue/20 text-robot-blue border border-robot-blue/30 px-4 py-2 rounded-lg hover:bg-robot-blue/30 transition-all duration-300 flex items-center space-x-2">
                        <span>⬅️</span>
                        <span>BACK TO LIST</span>
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

        <!-- Info Banner -->
        <div class="mb-6 bg-robot-yellow/20 border border-robot-yellow/30 text-robot-yellow p-4 rounded-lg">
            <div class="flex items-center space-x-2">
                <span>⚠️</span>
                <span>Data di trash dapat dipulihkan atau dihapus permanen</span>
            </div>
        </div>

        <!-- Data Table -->
        <div class="bg-robot-gray border border-gray-600 rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-robot-red/10 border-b border-robot-red/20">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-robot-red uppercase tracking-wider">ID</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-robot-red uppercase tracking-wider">NAMA</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-robot-red uppercase tracking-wider">EMAIL</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-robot-red uppercase tracking-wider">JABATAN</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-robot-red uppercase tracking-wider">DELETED AT</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-robot-red uppercase tracking-wider">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-600">
                        @forelse($pengguna as $item)
                        <tr class="hover:bg-robot-red/5 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-robot-red">
                                #{{ $item->id_pgn }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-100">
                                {{ $item->nama_pgn }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                {{ $item->email_pgn }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-100">
                                <span class="bg-robot-red/20 text-robot-red px-2 py-1 rounded text-xs">
                                    {{ $item->nama_jbt ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                {{ $item->updated_at ? \Carbon\Carbon::parse($item->updated_at)->format('d/m/Y H:i') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <form method="POST" action="{{ route('pengguna.restore', $item->id_pgn) }}" class="inline" onsubmit="return confirm('Are you sure you want to restore this pengguna?')">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="bg-robot-green/20 text-robot-green border border-robot-green/30 px-3 py-1 rounded text-xs hover:bg-robot-green/30 transition-all duration-300">
                                            RESTORE
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('pengguna.forceDelete', $item->id_pgn) }}" class="inline" onsubmit="return confirm('Are you sure you want to permanently delete this pengguna? This action cannot be undone!')">

                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-robot-red/20 text-robot-red border border-robot-red/30 px-3 py-1 rounded text-xs hover:bg-robot-red/30 transition-all duration-300">
                                            DELETE FOREVER
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-400">
                                <div class="flex flex-col items-center space-y-2">
                                    <span class="text-2xl">🗑️</span>
                                    <span>Trash is empty</span>
                                    <span class="text-sm">No deleted data found</span>
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
                    <a href="{{ $pengguna->previousPageUrl() }}" class="bg-robot-red/20 text-robot-red border border-robot-red/30 px-3 py-2 rounded hover:bg-robot-red/30 transition-all duration-300">PREV</a>
                @endif

                {{-- Page Numbers --}}
                @foreach ($pengguna->getUrlRange(1, $pengguna->lastPage()) as $page => $url)
                    @if ($page == $pengguna->currentPage())
                        <span class="bg-robot-red text-robot-dark px-3 py-2 rounded font-bold">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="bg-robot-gray border border-gray-600 px-3 py-2 rounded hover:bg-gray-700 transition-all duration-300">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($pengguna->hasMorePages())
                    <a href="{{ $pengguna->nextPageUrl() }}" class="bg-robot-red/20 text-robot-red border border-robot-red/30 px-3 py-2 rounded hover:bg-robot-red/30 transition-all duration-300">NEXT</a>
                @else
                    <span class="bg-robot-gray border border-gray-600 px-3 py-2 rounded text-gray-500 cursor-not-allowed">NEXT</span>
                @endif
            </div>
        </div>
        @endif

        <!-- Bulk Actions (Optional) -->
        @if($pengguna->count() > 0)
        <div class="mt-6 p-4 bg-robot-gray border border-gray-600 rounded-lg">
            <h3 class="text-lg font-semibold text-robot-red mb-3">BULK ACTIONS</h3>
            <div class="flex items-center space-x-4">
                <button onclick="confirmBulkRestore()" class="bg-robot-green/20 text-robot-green border border-robot-green/30 px-4 py-2 rounded-lg hover:bg-robot-green/30 transition-all duration-300">
                    RESTORE ALL
                </button>
                <button onclick="confirmBulkDelete()" class="bg-robot-red/20 text-robot-red border border-robot-red/30 px-4 py-2 rounded-lg hover:bg-robot-red/30 transition-all duration-300">
                    DELETE ALL FOREVER
                </button>
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

    <script>
        function confirmBulkRestore() {
            if (confirm('Are you sure you want to restore all items from trash?')) {
                // Implement bulk restore logic here
                alert('Bulk restore feature needs to be implemented in the controller');
            }
        }

        function confirmBulkDelete() {
            if (confirm('Are you sure you want to permanently delete all items from trash? This action cannot be undone!')) {
                // Implement bulk delete logic here
                alert('Bulk delete feature needs to be implemented in the controller');
            }
        }
    </script>
</body>
</html>