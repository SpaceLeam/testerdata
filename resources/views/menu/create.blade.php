<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Menu - Robot Dark Theme</title>
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
        
        .input-cyber {
            background: rgba(15, 23, 42, 0.8);
            border: 1px solid #475569;
            transition: all 0.3s ease;
        }
        
        .input-cyber:focus {
            border-color: #00ff88;
            box-shadow: 0 0 15px rgba(0, 255, 136, 0.3);
        }
        
        .btn-danger {
            background: linear-gradient(45deg, #7f1d1d, #991b1b);
            border: 1px solid #dc2626;
            transition: all 0.3s ease;
        }
        
        .btn-danger:hover {
            background: linear-gradient(45deg, #dc2626, #ef4444);
            box-shadow: 0 0 20px rgba(220, 38, 38, 0.5);
        }
        
        .matrix-bg {
            background-image: 
                radial-gradient(circle at 20% 80%, rgba(0, 255, 136, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(0, 255, 136, 0.1) 0%, transparent 50%);
        }
    </style>
</head>
<body class="min-h-screen text-gray-100 matrix-bg">
    
    <!-- Header -->
    <div class="bg-slate-900 border-b border-slate-700 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <i class="fas fa-robot text-2xl text-green-400 mr-3 neon-text"></i>
                    <h1 class="text-xl font-bold text-green-400 neon-text">MENU CREATION PROTOCOL</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-400">SYSTEM ONLINE</span>
                    <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Breadcrumb -->
        <div class="flex items-center space-x-2 text-sm text-gray-400 mb-8">
            <a href="/menu" class="hover:text-green-400 transition-colors">
                <i class="fas fa-list mr-1"></i>MENU DATABASE
            </a>
            <i class="fas fa-chevron-right"></i>
            <span class="text-green-400">CREATE NEW ENTRY</span>
        </div>

        <!-- Back Button -->
        <div class="mb-6">
            <a href="/menu" class="btn-cyber px-6 py-3 rounded-lg font-semibold inline-flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>RETURN TO DATABASE
            </a>
        </div>

        <!-- Alert Messages -->
        <div id="success-alert" class="hidden mb-6 p-4 bg-green-900 border border-green-500 rounded-lg">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-400 mr-2"></i>
                <span class="text-green-200">Data validation successful!</span>
            </div>
        </div>

        <div id="error-alert" class="hidden mb-6 p-4 bg-red-900 border border-red-500 rounded-lg">
            <div class="flex items-center">
                <i class="fas fa-exclamation-triangle text-red-400 mr-2"></i>
                <span class="text-red-200">Error detected in input parameters!</span>
            </div>
        </div>

        <!-- Main Form -->
        <div class="robot-card rounded-lg p-8 scan-line">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-green-400 neon-text mb-2">
                    <i class="fas fa-plus-circle mr-2"></i>NEW MENU ENTRY
                </h2>
                <p class="text-gray-400">Configure system menu access parameters</p>
            </div>

            <form method="POST" action="/menu" id="menuForm" class="space-y-6">
                <!-- CSRF Token -->
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <!-- Menu Name Field -->
                <div>
                    <label for="nama_mnu" class="block text-sm font-medium text-green-400 mb-2">
                        <i class="fas fa-tag mr-2"></i>MENU NAME
                    </label>
                    <input 
                        type="text" 
                        name="nama_mnu" 
                        id="nama_mnu" 
                        placeholder="Enter menu name..." 
                        class="input-cyber w-full px-4 py-3 rounded-lg text-gray-100 focus:outline-none"
                        required
                    >
                    <div class="text-red-400 text-sm mt-1 hidden" id="nama_mnu_error">
                        <i class="fas fa-exclamation-circle mr-1"></i>Menu name is required
                    </div>
                </div>

                <!-- Access Level Field -->
                <div>
                    <label for="akses_mnu" class="block text-sm font-medium text-green-400 mb-2">
                        <i class="fas fa-key mr-2"></i>ACCESS LEVEL
                    </label>
                    <select 
                        name="akses_mnu" 
                        id="akses_mnu" 
                        class="input-cyber w-full px-4 py-3 rounded-lg text-gray-100 focus:outline-none"
                        required
                    >
                        <option value="">Select access level...</option>
                        <option value="admin">
                            <i class="fas fa-shield-alt mr-1"></i>ADMIN - Full System Access
                        </option>
                        <option value="moderator">
                            <i class="fas fa-user-shield mr-1"></i>MODERATOR - Limited System Access
                        </option>
                        <option value="user">
                            <i class="fas fa-user mr-1"></i>USER - Basic Access
                        </option>
                        <option value="guest">
                            <i class="fas fa-user-times mr-1"></i>GUEST - View Only
                        </option>
                    </select>
                    <div class="text-red-400 text-sm mt-1 hidden" id="akses_mnu_error">
                        <i class="fas fa-exclamation-circle mr-1"></i>Access level is required
                    </div>
                </div>

                <!-- Security Warning -->
                <div class="bg-yellow-900 border border-yellow-500 rounded-lg p-4">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-triangle text-yellow-400 mr-3 mt-1"></i>
                        <div>
                            <h4 class="text-yellow-400 font-semibold mb-1">SECURITY PROTOCOL</h4>
                            <p class="text-yellow-200 text-sm">
                                Menu access levels control system permissions. Admin access grants full system control. 
                                Ensure proper authorization before creating high-level access entries.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex flex-col sm:flex-row gap-4 pt-6">
                    <button 
                        type="submit" 
                        class="btn-cyber px-8 py-4 rounded-lg font-semibold text-lg flex-1 sm:flex-none"
                    >
                        <i class="fas fa-save mr-2"></i>CREATE MENU ENTRY
                    </button>
                    
                    <button 
                        type="button" 
                        onclick="resetForm()" 
                        class="btn-danger px-8 py-4 rounded-lg font-semibold text-lg flex-1 sm:flex-none"
                    >
                        <i class="fas fa-undo mr-2"></i>RESET FORM
                    </button>
                </div>
            </form>
        </div>

        <!-- System Status -->
        <div class="robot-card rounded-lg p-6 mt-8">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-green-400 neon-text">
                        <i class="fas fa-database mr-2"></i>SYSTEM STATUS
                    </h3>
                    <p class="text-gray-400 text-sm">Database connection established</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse mr-2"></div>
                        <span class="text-sm text-green-400">ONLINE</span>
                    </div>
                    <div class="text-sm text-gray-400 font-mono">
                        <i class="fas fa-clock mr-1"></i>
                        <span id="currentTime"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Real-time clock
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('en-US', { 
                hour12: false,
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            document.getElementById('currentTime').textContent = timeString;
        }
        
        updateTime();
        setInterval(updateTime, 1000);

        // Form validation
        function validateForm() {
            let isValid = true;
            
            // Reset errors
            document.querySelectorAll('[id$="_error"]').forEach(el => el.classList.add('hidden'));
            
            // Validate menu name
            const menuName = document.getElementById('nama_mnu').value.trim();
            if (!menuName) {
                document.getElementById('nama_mnu_error').classList.remove('hidden');
                isValid = false;
            }
            
            // Validate access level
            const accessLevel = document.getElementById('akses_mnu').value;
            if (!accessLevel) {
                document.getElementById('akses_mnu_error').classList.remove('hidden');
                isValid = false;
            }
            
            return isValid;
        }

        // Form submission
        document.getElementById('menuForm').addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
                document.getElementById('error-alert').classList.remove('hidden');
                setTimeout(() => {
                    document.getElementById('error-alert').classList.add('hidden');
                }, 5000);
            }
        });

        // Reset form
        function resetForm() {
            document.getElementById('menuForm').reset();
            document.querySelectorAll('[id$="_error"]').forEach(el => el.classList.add('hidden'));
        }

        // Auto-hide alerts
        setTimeout(() => {
            const successAlert = document.getElementById('success-alert');
            const errorAlert = document.getElementById('error-alert');
            if (successAlert && !successAlert.classList.contains('hidden')) {
                successAlert.classList.add('hidden');
            }
            if (errorAlert && !errorAlert.classList.contains('hidden')) {
                errorAlert.classList.add('hidden');
            }
        }, 5000);

        // Add typing effect for inputs
        document.querySelectorAll('.input-cyber').forEach(input => {
            input.addEventListener('focus', function() {
                this.style.boxShadow = '0 0 20px rgba(0, 255, 136, 0.4)';
            });
            
            input.addEventListener('blur', function() {
                this.style.boxShadow = '';
            });
        });
    </script>
</body>

</html>