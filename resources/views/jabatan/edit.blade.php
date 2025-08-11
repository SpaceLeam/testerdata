<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Jabatan - Robot System</title>
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
                    <h2 class="text-3xl font-bold text-robot-blue mb-2">EDIT JABATAN</h2>
                    <p class="text-gray-400">Update data jabatan #{{ $jabatan->id_jbt }}</p>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('jabatan.index') }}" class="bg-robot-gray border border-gray-600 px-4 py-2 rounded-lg hover:bg-gray-700 transition-all duration-300 flex items-center space-x-2">
                        <span>←</span>
                        <span>BACK</span>
                    </a>
                    <a href="{{ route('jabatan.show', $jabatan->id_jbt) }}" class="bg-robot-blue/20 text-robot-blue border border-robot-blue/30 px-4 py-2 rounded-lg hover:bg-robot-blue/30 transition-all duration-300 flex items-center space-x-2">
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
        <div class="bg-robot-gray border border-gray-600 rounded-lg p-8">
            <form method="POST" action="{{ route('jabatan.update', $jabatan->id_jbt) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- ID Jabatan (Read Only) -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-robot-blue uppercase tracking-wider">ID JABATAN</label>
                    <div class="bg-robot-dark border border-gray-600 rounded-lg px-4 py-3">
                        <span class="text-robot-blue font-bold">#{{ $jabatan->id_jbt }}</span>
                        <span class="text-gray-400 text-sm ml-2">(Read Only)</span>
                    </div>
                </div>

                <!-- Nama Jabatan -->
                <div class="space-y-2">
                    <label for="nama_jbt" class="block text-sm font-medium text-robot-blue uppercase tracking-wider">
                        NAMA JABATAN <span class="text-robot-red">*</span>
                    </label>
                    <input type="text" 
                           id="nama_jbt" 
                           name="nama_jbt" 
                           value="{{ old('nama_jbt', $jabatan->nama_jbt) }}"
                           class="w-full bg-robot-dark border border-gray-600 rounded-lg px-4 py-3 text-gray-100 focus:outline-none focus:border-robot-blue focus:ring-1 focus:ring-robot-blue @error('nama_jbt') border-robot-red @enderror"
                           placeholder="Enter position name..."
                           maxlength="50"
                           required>
                    @error('nama_jbt')
                        <p class="text-robot-red text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-gray-400 text-sm">Maximum 50 characters</p>
                </div>

                <!-- Status Info -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-robot-blue uppercase tracking-wider">STATUS</label>
                    <div class="bg-robot-dark border border-gray-600 rounded-lg px-4 py-3">
                        <span class="inline-flex items-center space-x-2">
                            <div class="w-2 h-2 bg-robot-green rounded-full animate-pulse"></div>
                            <span class="text-robot-green">ACTIVE</span>
                            <span class="text-gray-400 text-sm">(Auto-managed)</span>
                        </span>
                    </div>
                </div>

                <!-- Timestamps -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-robot-blue uppercase tracking-wider">CREATED AT</label>
                        <div class="bg-robot-dark border border-gray-600 rounded-lg px-4 py-3">
                            <span class="text-gray-400">
                                {{ $jabatan->created_at ? \Carbon\Carbon::parse($jabatan->created_at)->format('d/m/Y H:i:s') : '-' }}
                            </span>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-robot-blue uppercase tracking-wider">LAST UPDATED</label>
                        <div class="bg-robot-dark border border-gray-600 rounded-lg px-4 py-3">
                            <span class="text-gray-400">
                                {{ $jabatan->updated_at ? \Carbon\Carbon::parse($jabatan->updated_at)->format('d/m/Y H:i:s') : '-' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="pt-6 border-t border-gray-600">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-400">
                            <span class="text-robot-red">*</span> Required fields
                        </div>
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('jabatan.index') }}" class="bg-robot-gray border border-gray-600 px-6 py-2 rounded-lg hover:bg-gray-700 transition-all duration-300">
                                CANCEL
                            </a>
                            <button type="submit" class="bg-robot-blue/20 text-robot-blue border border-robot-blue/30 px-6 py-2 rounded-lg hover:bg-robot-blue/30 transition-all duration-300 flex items-center space-x-2">
                                <span>💾</span>
                                <span>UPDATE</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Help Text -->
        <div class="mt-6 bg-robot-blue/10 border border-robot-blue/20 rounded-lg p-4">
            <div class="flex items-start space-x-3">
                <span class="text-robot-blue text-lg">ℹ️</span>
                <div class="text-sm text-gray-300">
                    <p class="font-semibold text-robot-blue mb-1">SYSTEM INFO:</p>
                    <ul class="space-y-1">
                        <li>• Position name must be unique and descriptive</li>
                        <li>• Changes will be logged with timestamp</li>
                        <li>• Status cannot be changed manually</li>
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
</body>
</html>