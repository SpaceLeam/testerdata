<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu - Robot Dark Theme</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            font-family: 'Courier New', monospace;
        }
        
        .cyber-border {
            border: 2px solid #00ff88;
            box-shadow: 0 0 20px rgba(0, 255, 136, 0.3);
        }
        
        .cyber-glow {
            box-shadow: 0 0 30px rgba(0, 255, 136, 0.5);
        }
        
        .robot-card {
            background: rgba(15, 23, 42, 0.9);
            border: 1px solid #334155;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
        }
        
        .neon-text {
            text-shadow: 0 0 10px #00ff88;
        }
        
        .scan-line {
            position: relative;
            overflow: hidden;
        }
        
        .scan-line::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(0, 255, 136, 0.1), transparent);
            animation: scan 3s infinite;
        }
        
        @keyframes scan {
            0% { left: -100%; }
            100% { left: 100%; }
        }
        
        .btn-cyber {
            background: linear-gradient(45deg, #1e293b, #334155);
            border: 1px solid #00ff88;
            transition: all 0.3s ease;
        }
        
        .btn-cyber:hover {
            background: linear-gradient(45deg, #00ff88, #00cc6a);
            color: #000;
            box-shadow: 0 0 20px rgba(0, 255, 136, 0.5);
        }
        
        .btn-secondary {
            background: linear-gradient(45deg, #475569, #64748b);
            border: 1px solid #64748b;
            transition: all 0.3s ease;
        }
        
        .btn-secondary:hover {
            background: linear-gradient(45deg, #64748b, #94a3b8);
            color: #000;
            box-shadow: 0 0 20px rgba(100, 116, 139, 0.5);
        }
        
        .form-cyber {
            background: rgba(15, 23, 42, 0.8);
            border: 1px solid #475569;
            transition: all 0.3s ease;
        }
        
        .form-cyber:focus {
            border-color: #00ff88;
            box-shadow: 0 0 15px rgba(0, 255, 136, 0.3);
        }
        
        .form-cyber:focus + .form-label {
            color: #00ff88;
        }
        
        .form-label {
            transition: color 0.3s ease;
        }
        
        .error-text {
            color: #fca5a5;
            text-shadow: 0 0 5px rgba(252, 165, 165, 0.5);
        }
    </style>
</head>
<body class="min-h-screen text-gray-100">
    
    <!-- Header -->
    <div class="bg-slate-900 border-b border-slate-700 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <i class="fas fa-robot text-2xl text-green-400 mr-3 neon-text"></i>
                    <h1 class="text-xl font-bold text-green-400 neon-text">MENU MANAGEMENT SYSTEM</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-400">EDIT MODE</span>
                    <div class="w-3 h-3 bg-yellow-400 rounded-full animate-pulse"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Breadcrumb -->
        <div class="mb-8">
            <nav class="flex items-center space-x-2 text-sm text-gray-400">
                <a href="{{ route('menu.index') }}" class="hover:text-green-400 transition-colors">
                    <i class="fas fa-home mr-1"></i>Menu Database
                </a>
                <i class="fas fa-chevron-right"></i>
                <span class="text-green-400">Edit Menu</span>
            </nav>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
        <div id="success-alert" class="mb-6 p-4 bg-green-900 border border-green-500 rounded-lg">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-400 mr-2"></i>
                <span class="text-green-200">{{ session('success') }}</span>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div id="error-alert" class="mb-6 p-4 bg-red-900 border border-red-500 rounded-lg">
            <div class="flex items-center">
                <i class="fas fa-exclamation-triangle text-red-400 mr-2"></i>
                <span class="text-red-200">{{ session('error') }}</span>
            </div>
        </div>
        @endif

        @if($errors->any())
        <div id="validation-alert" class="mb-6 p-4 bg-red-900 border border-red-500 rounded-lg">
            <div class="flex items-center mb-2">
                <i class="fas fa-exclamation-triangle text-red-400 mr-2"></i>
                <span class="text-red-200 font-semibold">Validation Error</span>
            </div>
            <ul class="text-red-200 text-sm space-y-1">
                @foreach($errors->all() as $error)
                <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Edit Form -->
        <div class="robot-card rounded-lg p-8 scan-line">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-green-400 neon-text mb-2">
                    <i class="fas fa-edit mr-2"></i>EDIT MENU RECORD
                </h2>
                <p class="text-gray-400">Modify menu access control parameters</p>
            </div>

            <form method="POST" action="{{ route('menu.update', $menu->id_mnu) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Menu ID (Read-only) -->
                <div class="space-y-2">
                    <label class="form-label block text-sm font-medium text-gray-300">
                        <i class="fas fa-hashtag mr-2"></i>MENU ID
                    </label>
                    <div class="relative">
                        <input 
                            type="text" 
                            value="{{ str_pad($menu->id_mnu, 3, '0', STR_PAD_LEFT) }}" 
                            class="form-cyber w-full px-4 py-3 rounded-lg text-gray-400 focus:outline-none cursor-not-allowed" 
                            readonly
                        >
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <i class="fas fa-lock text-gray-500"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500">System generated identifier (read-only)</p>
                </div>

                <!-- Menu Name -->
                <div class="space-y-2">
                    <label for="nama_mnu" class="form-label block text-sm font-medium text-gray-300 required">
                        <i class="fas fa-tag mr-2"></i>MENU NAME
                        <span class="text-red-400">*</span>
                    </label>
                    <div class="relative">
                        <input 
                            type="text" 
                            id="nama_mnu" 
                            name="nama_mnu" 
                            value="{{ old('nama_mnu', $menu->nama_mnu) }}" 
                            class="form-cyber w-full px-4 py-3 rounded-lg text-gray-100 focus:outline-none @error('nama_mnu') border-red-500 @enderror" 
                            placeholder="Enter menu name..."
                            required
                        >
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <i class="fas fa-keyboard text-gray-500"></i>
                        </div>
                    </div>
                    @error('nama_mnu')
                    <p class="text-xs error-text">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500">Menu display name in the system</p>
                </div>

                <!-- Access Level -->
                <div class="space-y-2">
                    <label for="akses_mnu" class="form-label block text-sm font-medium text-gray-300 required">
                        <i class="fas fa-key mr-2"></i>ACCESS LEVEL
                        <span class="text-red-400">*</span>
                    </label>
                    <div class="relative">
                        <select 
                            id="akses_mnu" 
                            name="akses_mnu" 
                            class="form-cyber w-full px-4 py-3 rounded-lg text-gray-100 focus:outline-none @error('akses_mnu') border-red-500 @enderror appearance-none"
                            required
                        >
                            <option value="">Select access level...</option>
                            <option value="admin" {{ old('akses_mnu', $menu->akses_mnu) == 'admin' ? 'selected' : '' }}>
                                Admin - Full System Access
                            </option>
                            <option value="moderator" {{ old('akses_mnu', $menu->akses_mnu) == 'moderator' ? 'selected' : '' }}>
                                Moderator - Limited Administrative Access
                            </option>
                            <option value="user" {{ old('akses_mnu', $menu->akses_mnu) == 'user' ? 'selected' : '' }}>
                                User - Basic Access
                            </option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <i class="fas fa-chevron-down text-gray-500"></i>
                        </div>
                    </div>
                    @error('akses_mnu')
                    <p class="text-xs error-text">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500">Define user permission level for this menu</p>
                </div>

                <!-- Created Date (Read-only) -->
                <div class="space-y-2">
                    <label class="form-label block text-sm font-medium text-gray-300">
                        <i class="fas fa-calendar-alt mr-2"></i>CREATED DATE
                    </label>
                    <div class="relative">
                        <input 
                            type="text" 
                            value="{{ \Carbon\Carbon::parse($menu->created_at)->format('Y-m-d H:i:s') }}" 
                            class="form-cyber w-full px-4 py-3 rounded-lg text-gray-400 focus:outline-none cursor-not-allowed font-mono" 
                            readonly
                        >
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <i class="fas fa-clock text-gray-500"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500">Record creation timestamp</p>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-slate-700">
                    <button 
                        type="submit" 
                        class="btn-cyber px-8 py-3 rounded-lg font-semibold text-center flex items-center justify-center"
                    >
                        <i class="fas fa-save mr-2"></i>UPDATE MENU
                    </button>
                    
                    <a 
                        href="{{ route('menu.show', $menu->id_mnu) }}" 
                        class="btn-secondary px-8 py-3 rounded-lg font-semibold text-center flex items-center justify-center"
                    >
                        <i class="fas fa-eye mr-2"></i>VIEW DETAILS
                    </a>
                    
                    <a 
                        href="{{ route('menu.index') }}" 
                        class="btn-secondary px-8 py-3 rounded-lg font-semibold text-center flex items-center justify-center"
                    >
                        <i class="fas fa-times mr-2"></i>CANCEL
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Auto-hide alerts
        setTimeout(() => {
            const alerts = ['success-alert', 'error-alert', 'validation-alert'];
            alerts.forEach(alertId => {
                const alert = document.getElementById(alertId);
                if (alert) {
                    alert.style.opacity = '0';
                    setTimeout(() => alert.classList.add('hidden'), 300);
                }
            });
        }, 5000);

        // Form validation feedback
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('input[required], select[required]');
            
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    if (this.value.trim() === '') {
                        this.classList.add('border-red-500');
                    } else {
                        this.classList.remove('border-red-500');
                        this.classList.add('border-green-500');
                    }
                });
                
                input.addEventListener('focus', function() {
                    this.classList.remove('border-red-500', 'border-green-500');
                });
            });
        });
    </script>
</body>
</html>