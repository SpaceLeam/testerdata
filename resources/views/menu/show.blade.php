<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Menu - Robot Dark Theme</title>
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
        
        .btn-danger {
            background: linear-gradient(45deg, #7f1d1d, #991b1b);
            border: 1px solid #dc2626;
            transition: all 0.3s ease;
        }
        
        .btn-danger:hover {
            background: linear-gradient(45deg, #dc2626, #ef4444);
            color: #fff;
            box-shadow: 0 0 20px rgba(220, 38, 38, 0.5);
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }
        
        .info-item {
            background: rgba(30, 41, 59, 0.5);
            border: 1px solid #475569;
            border-radius: 0.5rem;
            padding: 1.5rem;
            transition: all 0.3s ease;
        }
        
        .info-item:hover {
            border-color: #00ff88;
            box-shadow: 0 0 15px rgba(0, 255, 136, 0.2);
        }
        
        .pulse-dot {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
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
                    <span class="text-sm text-gray-400">VIEW MODE</span>
                    <div class="w-3 h-3 bg-blue-400 rounded-full pulse-dot"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Breadcrumb -->
        <div class="mb-8">
            <nav class="flex items-center space-x-2 text-sm text-gray-400">
                <a href="{{ route('menu.index') }}" class="hover:text-green-400 transition-colors">
                    <i class="fas fa-home mr-1"></i>Menu Database
                </a>
                <i class="fas fa-chevron-right"></i>
                <span class="text-green-400">View Menu</span>
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

        <!-- Menu Details -->
        <div class="robot-card rounded-lg p-8 scan-line">
            <!-- Header -->
            <div class="mb-8 border-b border-slate-700 pb-6">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                    <div>
                        <h2 class="text-3xl font-bold text-green-400 neon-text mb-2">
                            <i class="fas fa-eye mr-2"></i>MENU RECORD VIEW
                        </h2>
                        <p class="text-gray-400">Complete menu access control information</p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('menu.edit', $menu->id_mnu) }}" class="btn-cyber px-6 py-3 rounded-lg font-semibold text-center">
                            <i class="fas fa-edit mr-2"></i>EDIT MENU
                        </a>
                        <button onclick="deleteMenu({{ $menu->id_mnu }})" class="btn-danger px-6 py-3 rounded-lg font-semibold text-center">
                            <i class="fas fa-trash mr-2"></i>DELETE
                        </button>
                    </div>
                </div>
            </div>

            <!-- Info Grid -->
            <div class="info-grid mb-8">
                <!-- Menu ID -->
                <div class="info-item">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-hashtag text-green-400 mr-2"></i>
                        <h3 class="text-lg font-semibold text-green-400">MENU ID</h3>
                    </div>
                    <div class="bg-slate-800 px-4 py-3 rounded-lg">
                        <span class="text-2xl font-mono text-gray-100">{{ str_pad($menu->id_mnu, 3, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">System generated unique identifier</p>
                </div>

                <!-- Menu Name -->
                <div class="info-item">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-tag text-green-400 mr-2"></i>
                        <h3 class="text-lg font-semibold text-green-400">MENU NAME</h3>
                    </div>
                    <div class="bg-slate-800 px-4 py-3 rounded-lg">
                        <span class="text-xl text-gray-100">{{ $menu->nama_mnu }}</span>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Display name in the system interface</p>
                </div>

                <!-- Access Level -->
                <div class="info-item">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-key text-green-400 mr-2"></i>
                        <h3 class="text-lg font-semibold text-green-400">ACCESS LEVEL</h3>
                    </div>
                    <div class="bg-slate-800 px-4 py-3 rounded-lg">
                        @php
                            $accessColors = [
                                'admin' => 'bg-green-900 text-green-300 border-green-500',
                                'moderator' => 'bg-blue-900 text-blue-300 border-blue-500',
                                'user' => 'bg-purple-900 text-purple-300 border-purple-500'
                            ];
                            $accessIcons = [
                                'admin' => 'fas fa-shield-alt',
                                'moderator' => 'fas fa-user-shield',
                                'user' => 'fas fa-users'
                            ];
                            $accessDescriptions = [
                                'admin' => 'Full system access with all privileges',
                                'moderator' => 'Limited administrative access',
                                'user' => 'Basic access with restricted permissions'
                            ];
                            $colorClass = $accessColors[strtolower($menu->akses_mnu)] ?? 'bg-gray-900 text-gray-300 border-gray-500';
                            $iconClass = $accessIcons[strtolower($menu->akses_mnu)] ?? 'fas fa-user';
                            $description = $accessDescriptions[strtolower($menu->akses_mnu)] ?? 'Standard user access';
                        @endphp
                        <div class="flex items-center">
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium border {{ $colorClass }}">
                                <i class="{{ $iconClass }} mr-2"></i>
                                {{ strtoupper($menu->akses_mnu) }}
                            </span>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">{{ $description }}</p>
                </div>

                <!-- Status -->
                <div class="info-item">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-power-off text-green-400 mr-2"></i>
                        <h3 class="text-lg font-semibold text-green-400">STATUS</h3>
                    </div>
                    <div class="bg-slate-800 px-4 py-3 rounded-lg">
                        <div class="flex items-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-900 text-green-300 border border-green-500">
                                <i class="fas fa-check-circle mr-2"></i>
                                ACTIVE
                            </span>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Menu is currently active and accessible</p>
                </div>

                <!-- Created Date -->
                <div class="info-item">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-calendar-alt text-green-400 mr-2"></i>
                        <h3 class="text-lg font-semibold text-green-400">CREATED</h3>
                    </div>
                    <div class="bg-slate-800 px-4 py-3 rounded-lg">
                        <div class="text-gray-100">
                            <div class="text-lg font-mono">{{ \Carbon\Carbon::parse($menu->created_at)->format('Y-m-d H:i:s') }}</div>
                            <div class="text-sm text-gray-400 mt-1">{{ \Carbon\Carbon::parse($menu->created_at)->diffForHumans() }}</div>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Record creation timestamp</p>
                </div>

                <!-- Updated Date -->
                <div class="info-item">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-edit text-green-400 mr-2"></i>
                        <h3 class="text-lg font-semibold text-green-400">LAST UPDATED</h3>
                    </div>
                    <div class="bg-slate-800 px-4 py-3 rounded-lg">
                        <div class="text-gray-100">
                            <div class="text-lg font-mono">{{ \Carbon\Carbon::parse($menu->updated_at)->format('Y-m-d H:i:s') }}</div>
                            <div class="text-sm text-gray-400 mt-1">{{ \Carbon\Carbon::parse($menu->updated_at)->diffForHumans() }}</div>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Last modification timestamp</p>
                </div>
            </div>

            <!-- System Information -->
            <div class="border-t border-slate-700 pt-6">
                <h3 class="text-lg font-semibold text-green-400 mb-4">
                    <i class="fas fa-info-circle mr-2"></i>SYSTEM INFORMATION
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-slate-800 px-4 py-3 rounded-lg">
                        <div class="text-sm text-gray-400">Database Table</div>
                        <div class="text-gray-100 font-mono">md_menu</div>
                    </div>
                    <div class="bg-slate-800 px-4 py-3 rounded-lg">
                        <div class="text-sm text-gray-400">Primary Key</div>
                        <div class="text-gray-100 font-mono">id_mnu</div>
                    </div>
                    <div class="bg-slate-800 px-4 py-3 rounded-lg">
                        <div class="text-sm text-gray-400">Status Field</div>
                        <div class="text-gray-100 font-mono">status_mnu = 1</div>
                    </div>
                    <div class="bg-slate-800 px-4 py-3 rounded-lg">
                        <div class="text-sm text-gray-400">Record Type</div>
                        <div class="text-gray-100 font-mono">ACTIVE</div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-slate-700 mt-6">
                <a href="{{ route('menu.edit', $menu->id_mnu) }}" class="btn-cyber px-8 py-3 rounded-lg font-semibold text-center">
                    <i class="fas fa-edit mr-2"></i>EDIT MENU
                </a>
                
                <a href="{{ route('menu.index') }}" class="btn-secondary px-8 py-3 rounded-lg font-semibold text-center">
                    <i class="fas fa-arrow-left mr-2"></i>BACK TO LIST
                </a>
                
                <button onclick="deleteMenu({{ $menu->id_mnu }})" class="btn-danger px-8 py-3 rounded-lg font-semibold text-center">
                    <i class="fas fa-trash mr-2"></i>DELETE MENU
                </button>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="robot-card rounded-lg p-6 m-4 max-w-md w-full">
            <div class="flex items-center mb-4">
                <i class="fas fa-exclamation-triangle text-red-400 text-2xl mr-3"></i>
                <h3 class="text-lg font-semibold text-red-400">CONFIRM DELETION</h3>
            </div>
            <p class="text-gray-300 mb-6">Are you sure you want to delete this menu item? This action will move it to trash.</p>
            <div class="flex justify-end space-x-3">
                <button onclick="closeDeleteModal()" class="btn-secondary px-4 py-2 rounded-lg">
                    CANCEL
                </button>
                <button onclick="confirmDelete()" class="btn-danger px-4 py-2 rounded-lg">
                    DELETE
                </button>
            </div>
        </div>
    </div>

    <script>
        let deleteId = null;

        function deleteMenu(id) {
            deleteId = id;
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('deleteModal').classList.add('flex');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.getElementById('deleteModal').classList.remove('flex');
            deleteId = null;
        }

        function confirmDelete() {
            if (deleteId) {
                // Create form and submit for Laravel
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/menu/${deleteId}`;
                
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                
                form.appendChild(csrfToken);
                form.appendChild(methodInput);
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Auto-hide alerts
        setTimeout(() => {
            const successAlert = document.getElementById('success-alert');
            const errorAlert = document.getElementById('error-alert');
            if (successAlert) {
                successAlert.style.opacity = '0';
                setTimeout(() => successAlert.classList.add('hidden'), 300);
            }
            if (errorAlert) {
                errorAlert.style.opacity = '0';
                setTimeout(() => errorAlert.classList.add('hidden'), 300);
            }
        }, 5000);

        // Add subtle hover effects
        document.addEventListener('DOMContentLoaded', function() {
            const infoItems = document.querySelectorAll('.info-item');
            
            infoItems.forEach(item => {
                item.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                });
                
                item.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
</body>
</html>