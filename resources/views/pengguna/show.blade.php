<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengguna - Robot System</title>
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
                    <h2 class="text-3xl font-bold text-robot-blue mb-2">DETAIL PENGGUNA</h2>
                    <p class="text-gray-400">Informasi lengkap pengguna sistem</p>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('pengguna.index') }}" class="bg-robot-gray border border-gray-600 px-4 py-2 rounded-lg hover:bg-gray-700 transition-all duration-300 flex items-center space-x-2">
                        <span>←</span>
                        <span>BACK</span>
                    </a>
                    <a href="{{ route('pengguna.edit', $pengguna->id_pgn) }}" class="bg-robot-yellow/20 text-robot-yellow border border-robot-yellow/30 px-4 py-2 rounded-lg hover:bg-robot-yellow/30 transition-all duration-300 flex items-center space-x-2">
                        <span>✏️</span>
                        <span>EDIT</span>
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

        <!-- Detail Card -->
        <div class="bg-robot-gray border border-gray-600 rounded-lg overflow-hidden">
            <div class="bg-robot-blue/10 border-b border-robot-blue/20 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-robot-blue">USER PROFILE</h3>
                    <div class="flex items-center space-x-2">
                        <span class="w-2 h-2 bg-robot-green rounded-full"></span>
                        <span class="text-sm text-robot-green">ACTIVE</span>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- User Info -->
                    <div class="space-y-4">
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 bg-robot-blue/20 rounded-full flex items-center justify-center">
                                <span class="text-2xl text-robot-blue">👤</span>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-gray-100">{{ $pengguna->nama_pgn }}</h4>
                                <p class="text-sm text-gray-400">USER ID: #{{ $pengguna->id_pgn }}</p>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div class="flex items-center space-x-3">
                                <span class="text-robot-blue">📧</span>
                                <div>
                                    <p class="text-sm text-gray-400">Email Address</p>
                                    <p class="text-gray-100">{{ $pengguna->email_pgn }}</p>
                                </div>
                            </div>

                            <div class="flex items-center space-x-3">
                                <span class="text-robot-blue">👔</span>
                                <div>
                                    <p class="text-sm text-gray-400">Jabatan</p>
                                    <span class="bg-robot-blue/20 text-robot-blue px-2 py-1 rounded text-sm">
                                        {{ $pengguna->nama_jbt ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex items-center space-x-3">
                                <span class="text-robot-blue">🔐</span>
                                <div>
                                    <p class="text-sm text-gray-400">Status</p>
                                    <span class="bg-robot-green/20 text-robot-green px-2 py-1 rounded text-sm">
                                        {{ $pengguna->status_pgn == 1 ? 'ACTIVE' : 'INACTIVE' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- System Info -->
                    <div class="space-y-4">
                        <h5 class="text-lg font-semibold text-robot-blue mb-4">SYSTEM INFO</h5>
                        
                        <div class="bg-robot-dark/50 border border-gray-700 rounded-lg p-4 space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-400">Created At</span>
                                <span class="text-sm text-gray-100">
                                    {{ $pengguna->created_at ? \Carbon\Carbon::parse($pengguna->created_at)->format('d/m/Y H:i:s') : '-' }}
                                </span>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-400">Updated At</span>
                                <span class="text-sm text-gray-100">
                                    {{ $pengguna->updated_at ? \Carbon\Carbon::parse($pengguna->updated_at)->format('d/m/Y H:i:s') : '-' }}
                                </span>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-400">Database ID</span>
                                <span class="text-sm text-robot-blue font-mono">#{{ $pengguna->id_pgn }}</span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="space-y-3">
                            <a href="{{ route('pengguna.edit', $pengguna->id_pgn) }}" class="w-full bg-robot-yellow/20 text-robot-yellow border border-robot-yellow/30 px-4 py-3 rounded-lg hover:bg-robot-yellow/30 transition-all duration-300 flex items-center justify-center space-x-2">
                                <span>✏️</span>
                                <span>EDIT PENGGUNA</span>
                            </a>
                            
                            <form method="POST" action="{{ route('pengguna.destroy', $pengguna->id_pgn) }}" onsubmit="return confirm('Are you sure you want to delete this pengguna?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-robot-red/20 text-robot-red border border-robot-red/30 px-4 py-3 rounded-lg hover:bg-robot-red/30 transition-all duration-300 flex items-center justify-center space-x-2">
                                    <span>🗑️</span>
                                    <span>DELETE PENGGUNA</span>
                                </button>
                            </form>
                        </div>
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