<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kategori Anggaran')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        'dark-primary': '#0f172a',
                        'dark-secondary': '#1e293b',
                        'dark-accent': '#334155',
                        'robot-blue': '#0ea5e9',
                        'robot-cyan': '#06b6d4',
                        'robot-green': '#10b981'
                    }
                }
            }
        }
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-dark-primary text-gray-100 min-h-screen">
    <nav class="bg-dark-secondary shadow-lg border-b border-dark-accent">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <i class="fas fa-robot text-robot-blue text-2xl mr-3"></i>
                    <span class="text-xl font-bold text-white">Kategori Anggaran</span>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('kategori-anggaran.index') }}" class="text-gray-300 hover:text-robot-cyan transition-colors">
                        <i class="fas fa-home mr-2"></i>Home
                    </a>
                    <a href="{{ route('kategori-anggaran.trash') }}" class="text-gray-300 hover:text-robot-cyan transition-colors">
                        <i class="fas fa-trash mr-2"></i>Trash
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-6 bg-robot-green/20 border border-robot-green/50 text-robot-green px-4 py-3 rounded-lg">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-500/20 border border-red-500/50 text-red-400 px-4 py-3 rounded-lg">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html> 