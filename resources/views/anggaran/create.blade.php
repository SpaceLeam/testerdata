<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Anggaran - Data Management</title>
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
        .form-glow:focus { box-shadow: 0 0 0 3px rgba(0, 245, 255, 0.3); }
    </style>
</head>
<body class="bg-cyber-dark text-gray-100 min-h-screen robot-grid">
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <!-- Header Section -->
        <div class="bg-cyber-gray border border-gray-700 rounded-lg p-6 mb-6 glow-border">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold glow-text">CREATE NEW ANGGARAN</h1>
                    <p class="text-gray-400 mt-2">Initialize New Budget Entry</p>
                </div>
                <a href="{{ route('anggaran.index') }}" 
                   class="bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-700 transition duration-300">
                    ← BACK TO LIST
                </a>
            </div>
        </div>

        <!-- Error Display -->
        @if ($errors->any())
            <div class="bg-red-900 border border-red-600 text-red-100 px-4 py-3 rounded-lg mb-6">
                <div class="flex items-center mb-2">
                    <span class="text-red-400 mr-2 text-xl">⚠</span>
                    <h3 class="font-semibold">VALIDATION ERROR DETECTED</h3>
                </div>
                <ul class="list-disc list-inside space-y-1 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Section -->
        <div class="bg-cyber-gray border border-gray-700 rounded-lg overflow-hidden">
            <div class="bg-cyber-blue px-6 py-4 border-b border-gray-600">
                <h2 class="text-xl font-semibold text-neon-cyan flex items-center">
                    <span class="mr-2">🤖</span>
                    DATA INPUT INTERFACE
                </h2>
            </div>

            <form method="POST" action="{{ route('anggaran.store') }}" class="p-6 space-y-6">
                @csrf
                <!-- ID Anggaran -->
<div class="space-y-2">
    <label for="id_agr" class="block text-sm font-medium text-gray-300 uppercase tracking-wider">
        ID ANGGARAN *
    </label>
    <input type="number" 
           id="id_agr" 
           name="id_agr" 
           value="{{ old('id_agr') }}"
           required
           placeholder="Masukkan ID unik untuk anggaran"
           class="w-full bg-cyber-blue border border-gray-600 rounded-lg px-4 py-3 text-gray-100 placeholder-gray-400 focus:border-neon-cyan focus:ring-1 focus:ring-neon-cyan form-glow transition duration-300">
    @error('id_agr')
        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

                <!-- Kategori Anggaran -->
                <div class="space-y-2">
                    <label for="id_kag" class="block text-sm font-medium text-gray-300 uppercase tracking-wider">
                        KATEGORI ANGGARAN *
                    </label>
                    <select id="id_kag" 
                            name="id_kag" 
                            required
                            class="w-full bg-cyber-blue border border-gray-600 rounded-lg px-4 py-3 text-gray-100 focus:border-neon-cyan focus:ring-1 focus:ring-neon-cyan form-glow transition duration-300">
                        <option value="">-- SELECT KATEGORI --</option>
                        @foreach($kategoriAnggaran as $kategori)
                            <option value="{{ $kategori->id_kag }}" 
                                    {{ old('id_kag') == $kategori->id_kag ? 'selected' : '' }}
                                    class="bg-cyber-blue">
                                {{ $kategori->nama_kag }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_kag')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama Anggaran -->
                <div class="space-y-2">
                    <label for="nama_agr" class="block text-sm font-medium text-gray-300 uppercase tracking-wider">
                        NAMA ANGGARAN *
                    </label>
                    <input type="text" 
                           id="nama_agr" 
                           name="nama_agr" 
                           value="{{ old('nama_agr') }}"
                           maxlength="100"
                           required
                           placeholder="Enter budget name..."
                           class="w-full bg-cyber-blue border border-gray-600 rounded-lg px-4 py-3 text-gray-100 placeholder-gray-400 focus:border-neon-cyan focus:ring-1 focus:ring-neon-cyan form-glow transition duration-300">
                    @error('nama_agr')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-gray-500 text-xs">Maximum 100 characters</p>
                </div>

             
                <!-- Action Buttons -->
                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-600">
                    <a href="{{ route('anggaran.index') }}" 
                       class="bg-gray-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-gray-700 transition duration-300 transform hover:scale-105">
                        CANCEL
                    </a>
                    <button type="submit" 
                            class="bg-neon-cyan text-cyber-dark px-8 py-3 rounded-lg font-semibold hover:bg-cyan-400 transition duration-300 transform hover:scale-105 glow-border">
                        CREATE ANGGARAN
                    </button>
                </div>
            </form>
        </div>

        <!-- Info Panel -->
        <div class="mt-6 bg-cyber-blue border border-gray-600 rounded-lg p-4">
            <div class="flex items-start space-x-3">
                <div class="text-neon-cyan text-xl">ℹ</div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-200 mb-2">SYSTEM INFORMATION</h3>
                    <ul class="text-xs text-gray-400 space-y-1">
                        <li>• All fields marked with (*) are required</li>
                        <li>• Nama anggaran must be unique within the system</li>
                        <li>• Status ACTIVE will make the budget available for transactions</li>
                        <li>• Data will be automatically timestamped</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center text-gray-500 text-sm">
            <p>Anggaran Management System | Robot AI Technology v2.0</p>
        </div>
    </div>

    <script>
        // Enhanced radio button styling
        document.querySelectorAll('input[type="radio"]').forEach(radio => {
            radio.addEventListener('change', function() {
                document.querySelectorAll('input[name="' + this.name + '"]').forEach(r => {
                    const indicator = r.parentElement.querySelector('div div');
                    if (r.checked) {
                        indicator.classList.remove('opacity-0');
                        indicator.classList.add('opacity-100');
                    } else {
                        indicator.classList.add('opacity-0');
                        indicator.classList.remove('opacity-100');
                    }
                });
            });
        });

        // Initialize radio buttons on page load
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('input[type="radio"]:checked').forEach(radio => {
                const indicator = radio.parentElement.querySelector('div div');
                indicator.classList.remove('opacity-0');
                indicator.classList.add('opacity-100');
            });
        });
    </script>
</body>
</html> 