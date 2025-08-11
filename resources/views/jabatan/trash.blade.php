<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trash - Data Jabatan - Robot System</title>
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
                    <h2 class="text-3xl font-bold text-robot-red mb-2">TRASH DATABASE</h2>
                    <p class="text-gray-400">Data jabatan yang telah dihapus</p>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('jabatan.index') }}" class="bg-robot-blue/20 text-robot-blue border border-robot-blue/30 px-4 py-2 rounded-lg hover:bg-robot-blue/30 transition-all duration-300 flex items-center space-x-2">
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

        <!-- Info Panel -->
        <div class="mb-6 bg-robot-red/10 border border-robot-red/30 rounded-lg p-4">
            <div class="flex items-center space-x-3">
                <span class="text-robot-red text-xl">⚠️</span>
                <div>
                    <h3 class="text-robot-red font-semibold">TRASH ZONE</h3>
                    <p class="text-gray-400 text-sm">Data di sini dapat dipulihkan atau dihapus permanen. Hati-hati dengan tindakan hapus permanen!</p>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="bg-robot-gray border border-gray-600 rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-robot-red/10 border-b border-robot-red/20">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-robot-red uppercase tracking-wider">ID</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-robot-red uppercase tracking-wider">NAMA JABATAN</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-robot-red uppercase tracking-wider">CREATED</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-robot-red uppercase tracking-wider">DELETED</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-robot-red uppercase tracking-wider">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-600">
                        @forelse($jabatan as $item)
                        <tr class="hover:bg-robot-red/5 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-robot-red">
                                #{{ $item->id_jbt }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-100">
                                <span class="line-through text-gray-500">{{ $item->nama_jbt }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                {{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                {{ $item->updated_at ? \Carbon\Carbon::parse($item->updated_at)->format('d/m/Y H:i') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <form method="POST" action="{{ route('jabatan.restore', $item->id_jbt) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="bg-robot-green/20 text-robot-green border border-robot-green/30 px-3 py-1 rounded text-xs hover:bg-robot-green/30 transition-all duration-300" onclick="return confirm('Apakah Anda yakin ingin memulihkan data ini?')">
                                            RESTORE
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('jabatan.forceDelete', $item->id_jbt) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-robot-red/20 text-robot-red border border-robot-red/30 px-3 py-1 rounded text-xs hover:bg-robot-red/30 transition-all duration-300" onclick="return confirm('PERINGATAN: Data akan dihapus permanen dan tidak dapat dipulihkan. Apakah Anda yakin?')">
                                            DELETE FOREVER
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                                <div class="flex flex-col items-center space-y-2">
                                    <span class="text-2xl">🗑️</span>
                                    <span>Trash is empty</span>
                                    <span class="text-sm text-gray-500">No deleted data found</span>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($jabatan->hasPages())
        <div class="mt-6 flex justify-center">
            <div class="flex items-center space-x-2">
                {{-- Previous Page Link --}}
                @if ($jabatan->onFirstPage())
                    <span class="bg-robot-gray border border-gray-600 px-3 py-2 rounded text-gray-500 cursor-not-allowed">PREV</span>
                @else
                    <a href="{{ $jabatan->previousPageUrl() }}" class="bg-robot-red/20 text-robot-red border border-robot-red/30 px-3 py-2 rounded hover:bg-robot-red/30 transition-all duration-300">PREV</a>
                @endif

                {{-- Page Numbers --}}
                @foreach ($jabatan->getUrlRange(1, $jabatan->lastPage()) as $page => $url)
                    @if ($page == $jabatan->currentPage())
                        <span class="bg-robot-red text-robot-dark px-3 py-2 rounded font-bold">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="bg-robot-gray border border-gray-600 px-3 py-2 rounded hover:bg-gray-700 transition-all duration-300">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($jabatan->hasMorePages())
                    <a href="{{ $jabatan->nextPageUrl() }}" class="bg-robot-red/20 text-robot-red border border-robot-red/30 px-3 py-2 rounded hover:bg-robot-red/30 transition-all duration-300">NEXT</a>
                @else
                    <span class="bg-robot-gray border border-gray-600 px-3 py-2 rounded text-gray-500 cursor-not-allowed">NEXT</span>
                @endif
            </div>
        </div>
        @endif

        <!-- Bulk Actions (Optional) -->
        @if($jabatan->count() > 0)
        <div class="mt-6 bg-robot-gray border border-gray-600 rounded-lg p-4">
            <h3 class="text-robot-red font-semibold mb-3">BULK ACTIONS</h3>
            <div class="flex items-center space-x-4">
                <button onclick="confirmBulkRestore()" class="bg-robot-green/20 text-robot-green border border-robot-green/30 px-4 py-2 rounded hover:bg-robot-green/30 transition-all duration-300">
                    RESTORE ALL
                </button>
                <button onclick="confirmBulkDelete()" class="bg-robot-red/20 text-robot-red border border-robot-red/30 px-4 py-2 rounded hover:bg-robot-red/30 transition-all duration-300">
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
            if (confirm('Apakah Anda yakin ingin memulihkan semua data di trash?')) {
                // Implement bulk restore logic here
                alert('Feature will be implemented soon');
            }
        }

        function confirmBulkDelete() {
            if (confirm('PERINGATAN: Semua data akan dihapus permanen dan tidak dapat dipulihkan. Apakah Anda yakin?')) {
                // Implement bulk delete logic here
                alert('Feature will be implemented soon');
            }
        }
    </script>
</body>
</html>