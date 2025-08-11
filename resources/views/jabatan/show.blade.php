<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Jabatan - Robot System</title>
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
                    <h2 class="text-3xl font-bold text-robot-blue mb-2">DETAIL JABATAN</h2>
                    <p class="text-gray-400">Informasi detail jabatan #{{ $jabatan->id_jbt }}</p>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('jabatan.index') }}" class="bg-robot-gray border border-gray-600 px-4 py-2 rounded-lg hover:bg-gray-700 transition-all duration-300 flex items-center space-x-2">
                        <span>←</span>
                        <span>BACK</span>
                    </a>
                    <a href="{{ route('jabatan.edit', $jabatan->id_jbt) }}" class="bg-robot-yellow/20 text-robot-yellow border border-robot-yellow/30 px-4 py-2 rounded-lg hover:bg-robot-yellow/30 transition-all duration-300 flex items-center space-x-2">
                        <span>✏️</span>
                        <span>EDIT</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Detail Card -->
        <div class="bg-robot-gray border border-gray-600 rounded-lg p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- ID Jabatan -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-robot-blue uppercase tracking-wider">ID JABATAN</label>
                    <div class="bg-robot-dark border border-gray-600 rounded-lg px-4 py-3">
                        <span class="text-robot-blue font-bold">#{{ $jabatan->id_jbt }}</span>
                    </div>
                </div>

                <!-- Status -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-robot-blue uppercase tracking-wider">STATUS</label>
                    <div class="bg-robot-dark border border-gray-600 rounded-lg px-4 py-3">
                        <span class="inline-flex items-center space-x-2">
                            <div class="w-2 h-2 bg-robot-green rounded-full animate-pulse"></div>
                            <span class="text-robot-green">ACTIVE</span>
                        </span>
                    </div>
                </div>

                <!-- Nama Jabatan -->
                <div class="space-y-2 md:col-span-2">
                    <label class="block text-sm font-medium text-robot-blue uppercase tracking-wider">NAMA JABATAN</label>
                    <div class="bg-robot-dark border border-gray-600 rounded-lg px-4 py-3">
                        <span class="text-gray-100 text-lg">{{ $jabatan->nama_jbt }}</span>
                    </div>
                </div>

                <!-- Created At -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-robot-blue uppercase tracking-wider">CREATED AT</label>
                    <div class="bg-robot-dark border border-gray-600 rounded-lg px-4 py-3">
                        <span class="text-gray-400">
                            {{ $jabatan->created_at ? \Carbon\Carbon::parse($jabatan->created_at)->format('d/m/Y H:i:s') : '-' }}
                        </span>
                    </div>
                </div>

                <!-- Updated At -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-robot-blue uppercase tracking-wider">UPDATED AT</label>
                    <div class="bg-robot-dark border border-gray-600 rounded-lg px-4 py-3">
                        <span class="text-gray-400">
                            {{ $jabatan->updated_at ? \Carbon\Carbon::parse($jabatan->updated_at)->format('d/m/Y H:i:s') : '-' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-8 pt-6 border-t border-gray-600">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-400">
                        System ID: JBT-{{ str_pad($jabatan->id_jbt, 6, '0', STR_PAD_LEFT) }}
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('jabatan.edit', $jabatan->id_jbt) }}" class="bg-robot-yellow/20 text-robot-yellow border border-robot-yellow/30 px-6 py-2 rounded-lg hover:bg-robot-yellow/30 transition-all duration-300">
                            EDIT DATA
                        </a>
                        <form method="POST" action="{{ route('jabatan.destroy', $jabatan->id_jbt) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this jabatan?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-robot-red/20 text-robot-red border border-robot-red/30 px-6 py-2 rounded-lg hover:bg-robot-red/30 transition-all duration-300">
                                DELETE
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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