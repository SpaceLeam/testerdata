
<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anggaran - Data Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        'cyber-dark': '#0a0a0f',
                        'cyber-gray': '#1a1a2e',
                        'cyber-blue': '#16213e',
                        'neon-cyan': '#00f5ff',
                        'neon-purple': '#b74cfb'
                    }
                }
            }
        }
    </script>
    <style>
        .glow-border { box-shadow: 0 0 15px rgba(0, 245, 255, 0.3); }
        .glow-text { text-shadow: 0 0 10px rgba(0, 245, 255, 0.8); }
        .robot-grid { background-image: radial-gradient(rgba(0, 245, 255, 0.1) 1px, transparent 1px); background-size: 20px 20px; }
    </style>
</head>
<body class="bg-cyber-dark text-gray-100 min-h-screen robot-grid">
    <div class="container mx-auto px-4 py-8">   
        <!-- Header Section -->
        <div class="bg-cyber-gray border border-gray-700 rounded-lg p-6 mb-6 glow-border">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold glow-text">ANGGARAN SYSTEM</h1>
                    <p class="text-gray-400 mt-2">Budget Management Interface v2.0</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('anggaran.create') }}" 
                       class="bg-neon-cyan text-cyber-dark px-6 py-3 rounded-lg font-semibold hover:bg-cyan-400 transition duration-300 transform hover:scale-105">
                        + ADD NEW
                    </a>
                    <a href="{{ route('anggaran.trash') }}" 
                       class="bg-red-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-700 transition duration-300">
                        TRASH
                    </a>
                </div>
            </div>
        </div>

        <!-- Search Section -->
        <div class="bg-cyber-blue border border-gray-600 rounded-lg p-4 mb-6">
            <form method="GET" action="{{ route('anggaran.index') }}">
                <div class="flex space-x-4">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Search anggaran atau kategori..."
                           class="flex-1 bg-cyber-gray border border-gray-600 rounded-lg px-4 py-2 text-gray-100 placeholder-gray-400 focus:border-neon-cyan focus:ring-1 focus:ring-neon-cyan">
                    <button type="submit" 
                            class="bg-neon-purple text-white px-6 py-2 rounded-lg font-semibold hover:bg-purple-600 transition duration-300">
                        SCAN
                    </button>
                    @if(request('search'))
                        <a href="{{ route('anggaran.index') }}" 
                           class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition duration-300">
                            RESET
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Alerts -->
        @if(session('success'))
            <div class="bg-green-900 border border-green-600 text-green-100 px-4 py-3 rounded-lg mb-4">
                <div class="flex items-center">
                    <span class="text-green-400 mr-2">✓</span>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-900 border border-red-600 text-red-100 px-4 py-3 rounded-lg mb-4">
                <div class="flex items-center">
                    <span class="text-red-400 mr-2">!</span>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        <!-- Data Table -->
        <div class="bg-cyber-gray border border-gray-700 rounded-lg overflow-hidden">
            <div class="bg-cyber-blue px-6 py-4 border-b border-gray-600">
                <h2 class="text-xl font-semibold text-neon-cyan">DATA RECORDS</h2>
            </div>
            
            @if($anggaran->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-cyber-blue">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Nama Anggaran</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Kategori</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            @foreach($anggaran as $item)
                                <tr class="hover:bg-cyber-blue transition duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-neon-cyan font-mono">
                                        #{{ str_pad($item->id_agr, 4, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-100">{{ $item->nama_agr }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-300">{{ $item->nama_kag ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($item->status_agr == 1)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-900 text-green-200 border border-green-600">
                                                ● ACTIVE
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-900 text-red-200 border border-red-600">
                                                ● INACTIVE
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('anggaran.show', $item->id_agr) }}" 
                                               class="bg-blue-600 text-white px-3 py-1 rounded text-xs font-semibold hover:bg-blue-700 transition duration-200">
                                                VIEW
                                            </a>
                                            <a href="{{ route('anggaran.edit', $item->id_agr) }}" 
                                               class="bg-neon-purple text-white px-3 py-1 rounded text-xs font-semibold hover:bg-purple-600 transition duration-200">
                                                EDIT
                                            </a>
                                            <form method="POST" action="{{ route('anggaran.destroy', $item->id_agr) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        onclick="return confirm('Yakin ingin menghapus data ini?')"
                                                        class="bg-red-600 text-white px-3 py-1 rounded text-xs font-semibold hover:bg-red-700 transition duration-200">
                                                    DELETE
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-600">
                    {{ $anggaran->links('pagination::tailwind') }}
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <div class="text-6xl text-gray-600 mb-4">🤖</div>
                    <h3 class="text-lg font-medium text-gray-300 mb-2">NO DATA FOUND</h3>
                    <p class="text-gray-400">System tidak menemukan data anggaran.</p>
                    <a href="{{ route('anggaran.create') }}" 
                       class="inline-block mt-4 bg-neon-cyan text-cyber-dark px-6 py-2 rounded-lg font-semibold hover:bg-cyan-400 transition duration-300">
                        CREATE FIRST ENTRY
                    </a>
                </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center text-gray-500 text-sm">
            <p>Anggaran Management System | Powered by Robot AI Technology</p>
        </div>
    </div>
</body>
</html>