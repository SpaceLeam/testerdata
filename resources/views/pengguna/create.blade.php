<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengguna - Robot System</title>
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
                    <h2 class="text-3xl font-bold text-robot-blue mb-2">CREATE NEW PENGGUNA</h2>
                    <p class="text-gray-400">Tambah data pengguna baru ke sistem</p>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('pengguna.index') }}" class="bg-robot-gray border border-gray-600 px-4 py-2 rounded-lg hover:bg-gray-700 transition-all duration-300 flex items-center space-x-2">
                        <span>←</span>
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

        <!-- Form -->
        <div class="bg-robot-gray border border-gray-600 rounded-lg p-6">
            <form method="POST" action="{{ route('pengguna.store') }}" class="space-y-6">
                @csrf
                
                <!-- Jabatan -->
                <div>
                    <label for="id_jbt" class="block text-sm font-medium text-robot-blue mb-2">
                        JABATAN <span class="text-robot-red">*</span>
                    </label>
                    <select name="id_jbt" id="id_jbt" class="w-full bg-robot-dark border border-gray-600 rounded-lg px-4 py-2 text-gray-100 focus:outline-none focus:border-robot-blue @error('id_jbt') border-robot-red @enderror">
                        <option value="">-- Select Jabatan --</option>
                        @foreach($jabatan as $jbt)
                        <option value="{{ $jbt->id_jbt }}" {{ old('id_jbt') == $jbt->id_jbt ? 'selected' : '' }}>
                            {{ $jbt->nama_jbt }}
                        </option>
                        @endforeach
                    </select>
                    @error('id_jbt')
                    <p class="mt-1 text-sm text-robot-red">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama -->
                <div>
                    <label for="nama_pgn" class="block text-sm font-medium text-robot-blue mb-2">
                        NAMA PENGGUNA <span class="text-robot-red">*</span>
                    </label>
                    <input type="text" name="nama_pgn" id="nama_pgn" value="{{ old('nama_pgn') }}" 
                           class="w-full bg-robot-dark border border-gray-600 rounded-lg px-4 py-2 text-gray-100 focus:outline-none focus:border-robot-blue @error('nama_pgn') border-robot-red @enderror" 
                           placeholder="Enter nama pengguna">
                    @error('nama_pgn')
                    <p class="mt-1 text-sm text-robot-red">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email_pgn" class="block text-sm font-medium text-robot-blue mb-2">
                        EMAIL <span class="text-robot-red">*</span>
                    </label>
                    <input type="email" name="email_pgn" id="email_pgn" value="{{ old('email_pgn') }}" 
                           class="w-full bg-robot-dark border border-gray-600 rounded-lg px-4 py-2 text-gray-100 focus:outline-none focus:border-robot-blue @error('email_pgn') border-robot-red @enderror" 
                           placeholder="Enter email address">
                    @error('email_pgn')
                    <p class="mt-1 text-sm text-robot-red">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="katasandi_pgn" class="block text-sm font-medium text-robot-blue mb-2">
                        PASSWORD <span class="text-robot-red">*</span>
                    </label>
                    <input type="password" name="katasandi_pgn" id="katasandi_pgn" 
                           class="w-full bg-robot-dark border border-gray-600 rounded-lg px-4 py-2 text-gray-100 focus:outline-none focus:border-robot-blue @error('katasandi_pgn') border-robot-red @enderror" 
                           placeholder="Enter password (min 6 characters)">
                    @error('katasandi_pgn')
                    <p class="mt-1 text-sm text-robot-red">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex items-center space-x-4 pt-4">
                    <button type="submit" class="bg-robot-blue/20 text-robot-blue border border-robot-blue/30 px-6 py-2 rounded-lg hover:bg-robot-blue/30 transition-all duration-300 flex items-center space-x-2">
                        <span>💾</span>
                        <span>SAVE PENGGUNA</span>
                    </button>
                    <a href="{{ route('pengguna.index') }}" class="bg-robot-gray border border-gray-600 px-6 py-2 rounded-lg hover:bg-gray-700 transition-all duration-300 flex items-center space-x-2">
                        <span>❌</span>
                        <span>CANCEL</span>
                    </a>
                </div>
            </form>
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