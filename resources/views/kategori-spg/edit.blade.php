<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kategori SPG</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .btn-gradient {
            background: linear-gradient(135deg, #3b82f6 0%, #06b6d4 100%);
        }
        .btn-gradient:hover {
            background: linear-gradient(135deg, #2563eb 0%, #0891b2 100%);
        }
    </style>
</head>
<body class="bg-slate-900 text-gray-100 min-h-screen">
    <div class="container mx-auto px-6 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center gap-4 mb-4">
                <a href="{{ route('kategori-spg.index') }}" 
                   class="text-slate-400 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h1 class="text-3xl font-bold text-white">Edit Kategori SPG</h1>
            </div>
            <p class="text-slate-400">Edit kategori Sales Promotion Girl: {{ $kategoriSpg->nama_ksp }}</p>
        </div>

        <!-- Error Messages -->
        @if($errors->any())
        <div class="bg-red-800 border border-red-600 text-red-200 px-4 py-3 rounded-lg mb-6">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Form Card -->
        <div class="bg-slate-800 rounded-lg border border-slate-700 p-6 max-w-2xl">
            <form method="POST" action="{{ route('kategori-spg.update', $kategoriSpg->id_ksp) }}">
                @csrf
                @method('PUT')
                
                <div class="mb-6">
                    <label for="id_ksp" class="block text-sm font-medium text-slate-300 mb-2">
                        ID Kategori
                    </label>
                    <input type="text" 
                           id="id_ksp" 
                           value="{{ $kategoriSpg->id_ksp }}"
                           disabled
                           class="w-full bg-slate-600 border border-slate-500 rounded-lg px-4 py-2 text-slate-300 cursor-not-allowed">
                    <p class="text-slate-400 text-sm mt-1">ID tidak dapat diubah</p>
                </div>

                <div class="mb-6">
                    <label for="nama_ksp" class="block text-sm font-medium text-slate-300 mb-2">
                        Nama Kategori SPG <span class="text-red-400">*</span>
                    </label>
                    <input type="text" 
                           id="nama_ksp" 
                           name="nama_ksp" 
                           value="{{ old('nama_ksp', $kategoriSpg->nama_ksp) }}"
                           placeholder="Masukkan nama kategori SPG"
                           class="w-full bg-slate-700 border border-slate-600 rounded-lg px-4 py-2 text-white placeholder-slate-400 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                           required>
                    @error('nama_ksp')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-4">
                    <button type="submit" 
                            class="btn-gradient text-white px-6 py-2 rounded-lg font-medium hover:shadow-lg transition-all duration-200 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Perbarui
                    </button>
                    <a href="{{ route('kategori-spg.index') }}" 
                       class="bg-slate-600 hover:bg-slate-500 text-white px-6 py-2 rounded-lg font-medium transition-colors flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Batal
                    </a>
                </div>
            </form>
        </div>

        <!-- Info Card -->
        <div class="bg-slate-800 rounded-lg border border-slate-700 p-4 max-w-2xl mt-6">
            <h3 class="text-lg font-medium text-white mb-2">Informasi</h3>
            <div class="text-sm text-slate-400 space-y-1">
                <p><span class="font-medium">Dibuat:</span> {{ \Carbon\Carbon::parse($kategoriSpg->created_at)->format('d/m/Y H:i') }}</p>
                <p><span class="font-medium">Terakhir diperbarui:</span> {{ \Carbon\Carbon::parse($kategoriSpg->updated_at)->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
</body>
</html>