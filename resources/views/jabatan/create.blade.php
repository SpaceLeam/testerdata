<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Jabatan - Robot System</title>
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
                    <h1 class="text-xl font-bold text-robot-blue">ROBOT SYSTEM</h1>
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
        <!-- Breadcrumb -->
        <div class="mb-6 text-sm text-gray-400">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('jabatan.index') }}" class="hover:text-robot-blue transition-colors">
                            JABATAN
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <span class="mx-3">/</span>
                            <span class="text-robot-blue">CREATE</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-bold text-robot-blue mb-2">ADD NEW JABATAN</h2>
                    <p class="text-gray-400">Tambahkan jabatan baru ke database sistem</p>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('jabatan.index') }}" class="bg-robot-gray border border-gray-600 px-4 py-2 rounded-lg hover:bg-gray-700 transition-all duration-300 flex items-center space-x-2">
                        <span>←</span>
                        <span>BACK</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
        <div class="mb-6 bg-robot-red/20 border border-robot-red/30 text-robot-red p-4 rounded-lg">
            <div class="flex items-center space-x-2 mb-2">
                <span>❌</span>
                <span class="font-bold">VALIDATION ERRORS:</span>
            </div>
            <ul class="ml-6 space-y-1">
                @foreach ($errors->all() as $error)
                <li class="text-sm">• {{ $error }}</li>
                @endforeach
            </ul>
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
            <form method="POST" action="{{ route('jabatan.store') }}" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Jabatan -->
                    <div class="md:col-span-2">
                        <label for="nama_jbt" class="block text-sm font-medium text-robot-blue mb-2">
                            NAMA JABATAN *
                        </label>
                        <input type="text" 
                               name="nama_jbt" 
                               id="nama_jbt" 
                               value="{{ old('nama_jbt') }}"
                               placeholder="Masukkan nama jabatan..."
                               class="w-full bg-robot-dark border border-gray-600 rounded-lg px-4 py-3 text-gray-100 placeholder-gray-400 focus:outline-none focus:border-robot-blue focus:ring-1 focus:ring-robot-blue transition-all duration-300"
                               maxlength="50"
                               required>
                        <p class="mt-2 text-xs text-gray-400">Maksimal 50 karakter</p>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-600">
                    <a href="{{ route('jabatan.index') }}" class="bg-robot-gray border border-gray-600 px-6 py-2 rounded-lg hover:bg-gray-700 transition-all duration-300">
                        CANCEL
                    </a>
                    <button type="submit" class="bg-robot-blue/20 text-robot-blue border border-robot-blue/30 px-6 py-2 rounded-lg hover:bg-robot-blue/30 transition-all duration-300 flex items-center space-x-2">
                        <span>💾</span>
                        <span>SAVE</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Info Panel -->
        <div class="mt-8 bg-robot-blue/10 border border-robot-blue/20 rounded-lg p-6">
            <div class="flex items-start space-x-3">
                <div class="w-6 h-6 bg-robot-blue rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                    <span class="text-robot-dark text-xs font-bold">i</span>
                </div>
                <div>
                    <h3 class="text-robot-blue font-bold mb-2">SYSTEM INFORMATION</h3>
                    <ul class="text-sm text-gray-300 space-y-1">
                        <li>• Data akan tersimpan dengan status aktif secara otomatis</li>
                        <li>• Nama jabatan tidak boleh kosong dan maksimal 50 karakter</li>
                        <li>• Sistem akan mencatat timestamp pembuatan dan pembaruan</li>
                        <li>• Data yang tersimpan dapat diubah atau dihapus kemudian</li>
                    </ul>
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

    <script>
        // Form validation
        document.getElementById('nama_jbt').addEventListener('input', function() {
            const input = this;
            const maxLength = 50;
            const remaining = maxLength - input.value.length;
            
            if (remaining < 10) {
                input.classList.add('border-robot-yellow');
                input.classList.remove('border-gray-600');
            } else {
                input.classList.remove('border-robot-yellow');
                input.classList.add('border-gray-600');
            }
        });
    </script>
</body>
</html>