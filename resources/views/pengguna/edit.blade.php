<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengguna - Robot System</title>
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
                    <h2 class="text-3xl font-bold text-robot-blue mb-2">EDIT PENGGUNA</h2>
                    <p class="text-gray-400">Ubah informasi pengguna sistem</p>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('pengguna.index') }}" class="bg-robot-gray border border-gray-600 px-4 py-2 rounded-lg hover:bg-gray-700 transition-all duration-300 flex items-center space-x-2">
                        <span>←</span>
                        <span>BACK</span>
                    </a>
                    <a href="{{ route('pengguna.show', $pengguna->id_pgn) }}" class="bg-robot-blue/20 text-robot-blue border border-robot-blue/30 px-4 py-2 rounded-lg hover:bg-robot-blue/30 transition-all duration-300 flex items-center space-x-2">
                        <span>👁️</span>
                        <span>VIEW</span>
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

        <!-- Form Card -->
        <div class="bg-robot-gray border border-gray-600 rounded-lg overflow-hidden">
            <div class="bg-robot-blue/10 border-b border-robot-blue/20 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-robot-blue">UPDATE USER DATA</h3>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-400">ID: #{{ $pengguna->id_pgn }}</span>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <form method="POST" action="{{ route('pengguna.update', $pengguna->id_pgn) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div class="space-y-4">
                            <!-- Nama Pengguna -->
                            <div>
                                <label for="nama_pgn" class="block text-sm font-medium text-robot-blue mb-2">
                                    👤 NAMA PENGGUNA
                                </label>
                                <input type="text" 
                                       id="nama_pgn" 
                                       name="nama_pgn" 
                                       value="{{ old('nama_pgn', $pengguna->nama_pgn) }}" 
                                       class="w-full bg-robot-dark border border-gray-600 rounded-lg px-4 py-3 text-gray-100 focus:outline-none focus:border-robot-blue focus:ring-1 focus:ring-robot-blue transition-all duration-300 @error('nama_pgn') border-robot-red @enderror"
                                       placeholder="Masukkan nama pengguna"
                                       required>
                                @error('nama_pgn')
                                <p class="mt-1 text-sm text-robot-red">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email_pgn" class="block text-sm font-medium text-robot-blue mb-2">
                                    📧 EMAIL ADDRESS
                                </label>
                                <input type="email" 
                                       id="email_pgn" 
                                       name="email_pgn" 
                                       value="{{ old('email_pgn', $pengguna->email_pgn) }}" 
                                       class="w-full bg-robot-dark border border-gray-600 rounded-lg px-4 py-3 text-gray-100 focus:outline-none focus:border-robot-blue focus:ring-1 focus:ring-robot-blue transition-all duration-300 @error('email_pgn') border-robot-red @enderror"
                                       placeholder="Masukkan email pengguna"
                                       required>
                                @error('email_pgn')
                                <p class="mt-1 text-sm text-robot-red">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-4">
                            <!-- Jabatan -->
                            <div>
                                <label for="id_jbt" class="block text-sm font-medium text-robot-blue mb-2">
                                    👔 JABATAN
                                </label>
                                <select id="id_jbt" 
                                        name="id_jbt" 
                                        class="w-full bg-robot-dark border border-gray-600 rounded-lg px-4 py-3 text-gray-100 focus:outline-none focus:border-robot-blue focus:ring-1 focus:ring-robot-blue transition-all duration-300 @error('id_jbt') border-robot-red @enderror"
                                        required>
                                    <option value="">Pilih Jabatan</option>
                                    @foreach($jabatan as $item)
                                        <option value="{{ $item->id_jbt }}" {{ old('id_jbt', $pengguna->id_jbt) == $item->id_jbt ? 'selected' : '' }}>
                                            {{ $item->nama_jbt }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_jbt')
                                <p class="mt-1 text-sm text-robot-red">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="katasandi_pgn" class="block text-sm font-medium text-robot-blue mb-2">
                                    🔐 PASSWORD (Opsional)
                                </label>
                                <input type="password" 
                                       id="katasandi_pgn" 
                                       name="katasandi_pgn" 
                                       class="w-full bg-robot-dark border border-gray-600 rounded-lg px-4 py-3 text-gray-100 focus:outline-none focus:border-robot-blue focus:ring-1 focus:ring-robot-blue transition-all duration-300 @error('katasandi_pgn') border-robot-red @enderror"
                                       placeholder="Biarkan kosong jika tidak ingin mengubah">
                                @error('katasandi_pgn')
                                <p class="mt-1 text-sm text-robot-red">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-sm text-gray-400">Minimal 6 karakter. Kosongkan jika tidak ingin mengubah password.</p>
                            </div>
                        </div>
                    </div>

                    <!-- System Info Display -->
                    <div class="bg-robot-dark/50 border border-gray-700 rounded-lg p-4">
                        <h5 class="text-sm font-semibold text-robot-blue mb-3">SYSTEM INFORMATION</h5>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                            <div>
                                <span class="text-gray-400">Created:</span>
                                <span class="text-gray-100 ml-2">{{ $pengguna->created_at ? \Carbon\Carbon::parse($pengguna->created_at)->format('d/m/Y H:i') : '-' }}</span>
                            </div>
                            <div>
                                <span class="text-gray-400">Updated:</span>
                                <span class="text-gray-100 ml-2">{{ $pengguna->updated_at ? \Carbon\Carbon::parse($pengguna->updated_at)->format('d/m/Y H:i') : '-' }}</span>
                            </div>
                            <div>
                                <span class="text-gray-400">Status:</span>
                                <span class="bg-robot-green/20 text-robot-green px-2 py-1 rounded text-xs ml-2">
                                    {{ $pengguna->status_pgn == 1 ? 'ACTIVE' : 'INACTIVE' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-700">
                        <a href="{{ route('pengguna.show', $pengguna->id_pgn) }}" class="bg-robot-gray border border-gray-600 px-6 py-3 rounded-lg hover:bg-gray-700 transition-all duration-300">
                            CANCEL
                        </a>
                        <button type="submit" class="bg-robot-blue/20 text-robot-blue border border-robot-blue/30 px-6 py-3 rounded-lg hover:bg-robot-blue/30 transition-all duration-300 flex items-center space-x-2">
                            <span>💾</span>
                            <span>UPDATE DATA</span>
                        </button>
                    </div>
                </form>
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

    <script>
        // Form validation enhancement
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const inputs = form.querySelectorAll('input, select');
            
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.classList.add('ring-2', 'ring-robot-blue/50');
                });
                
                input.addEventListener('blur', function() {
                    this.classList.remove('ring-2', 'ring-robot-blue/50');
                });
            });
        });
    </script>
</body>
</html>