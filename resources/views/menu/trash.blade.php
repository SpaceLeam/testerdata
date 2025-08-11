<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trash Bin - Robot Dark Theme</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            font-family: 'Courier New', monospace;
        }
        
        .cyber-border {
            border: 2px solid #ff4444;
            box-shadow: 0 0 20px rgba(255, 68, 68, 0.3);
        }
        
        .cyber-glow {
            box-shadow: 0 0 30px rgba(255, 68, 68, 0.5);
        }
        
        .robot-card {
            background: rgba(15, 23, 42, 0.9);
            border: 1px solid #334155;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
        }
        
        .neon-text {
            text-shadow: 0 0 10px #ff4444;
        }
        
        .neon-text-green {
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
            background: linear-gradient(90deg, transparent, rgba(255, 68, 68, 0.1), transparent);
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
        
        .btn-danger {
            background: linear-gradient(45deg, #1e293b, #334155);
            border: 1px solid #ff4444;
            transition: all 0.3s ease;
        }
        
        .btn-danger:hover {
            background: linear-gradient(45deg, #ff4444, #cc3333);
            color: #fff;
            box-shadow: 0 0 20px rgba(255, 68, 68, 0.5);
        }
        
        .btn-restore {
            background: linear-gradient(45deg, #1e293b, #334155);
            border: 1px solid #fbbf24;
            transition: all 0.3s ease;
        }
        
        .btn-restore:hover {
            background: linear-gradient(45deg, #fbbf24, #f59e0b);
            color: #000;
            box-shadow: 0 0 20px rgba(251, 191, 36, 0.5);
        }
        
        .search-cyber {
            background: rgba(15, 23, 42, 0.8);
            border: 1px solid #475569;
            transition: all 0.3s ease;
        }
        
        .search-cyber:focus {
            border-color: #ff4444;
            box-shadow: 0 0 15px rgba(255, 68, 68, 0.3);
        }
        
        .trash-row {
            background: rgba(239, 68, 68, 0.05);
            border-left: 3px solid #ef4444;
        }
    </style>
</head>
<body class="min-h-screen text-gray-100">
    
    <!-- Header -->
    <div class="bg-slate-900 border-b border-slate-700 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <i class="fas fa-trash text-2xl text-red-400 mr-3 neon-text"></i>
                    <h1 class="text-xl font-bold text-red-400 neon-text">TRASH BIN SYSTEM</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('menu.index') }}" class="btn-cyber px-4 py-2 rounded-lg text-sm">
                        <i class="fas fa-arrow-left mr-2"></i>BACK TO MENU
                    </a>
                    <span class="text-sm text-gray-400">SYSTEM ONLINE</span>
                    <div class="w-3 h-3 bg-red-400 rounded-full animate-pulse"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
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

        <!-- Control Panel -->
        <div class="robot-card rounded-lg p-6 mb-8 scan-line">
            <div class="flex flex-col lg:flex-row justify-between items-center gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-red-400 neon-text mb-2">
                        <i class="fas fa-trash-restore mr-2"></i>DELETED MENU DATABASE
                    </h2>
                    <p class="text-gray-400">Manage deleted menu items - restore or permanently delete</p>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-3">
                    <button onclick="confirmEmptyTrash()" class="btn-danger px-6 py-3 rounded-lg font-semibold text-center">
                        <i class="fas fa-fire mr-2"></i>EMPTY TRASH
                    </button>
                </div>
            </div>
        </div>

        <!-- Search & Filter -->
        <div class="robot-card rounded-lg p-6 mb-8">
            <form method="GET" action="{{ route('menu.trash') }}" class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ request('search') }}" 
                            placeholder="Search deleted menu name, access, or ID..." 
                            class="search-cyber w-full pl-10 pr-4 py-3 rounded-lg text-gray-100 focus:outline-none"
                        >
                    </div>
                </div>
                <button type="submit" class="btn-cyber px-8 py-3 rounded-lg font-semibold">
                    <i class="fas fa-search mr-2"></i>SCAN
                </button>
            </form>
        </div>

        <!-- Trash Table -->
        <div class="robot-card rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-800 border-b border-slate-700">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-red-400 uppercase tracking-wider">
                                <i class="fas fa-hashtag mr-2"></i>ID
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-red-400 uppercase tracking-wider">
                                <i class="fas fa-tag mr-2"></i>MENU NAME
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-red-400 uppercase tracking-wider">
                                <i class="fas fa-key mr-2"></i>ACCESS LEVEL
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-red-400 uppercase tracking-wider">
                                <i class="fas fa-clock mr-2"></i>DELETED AT
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-red-400 uppercase tracking-wider">
                                <i class="fas fa-cogs mr-2"></i>ACTIONS
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700">
                        @forelse($menu as $item)
                        <tr class="hover:bg-slate-800 transition-colors trash-row">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-300">
                                {{ str_pad($item->id_mnu, 3, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-100">
                                    <i class="fas fa-trash-alt text-red-400 mr-2"></i>
                                    {{ $item->nama_mnu }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $accessColors = [
                                        'admin' => 'bg-red-900 text-red-300 border-red-500',
                                        'moderator' => 'bg-red-900 text-red-300 border-red-500',
                                        'user' => 'bg-red-900 text-red-300 border-red-500'
                                    ];
                                    $accessIcons = [
                                        'admin' => 'fas fa-shield-alt',
                                        'moderator' => 'fas fa-user-shield',
                                        'user' => 'fas fa-users'
                                    ];
                                    $colorClass = $accessColors[strtolower($item->akses_mnu)] ?? 'bg-gray-900 text-gray-300 border-gray-500';
                                    $iconClass = $accessIcons[strtolower($item->akses_mnu)] ?? 'fas fa-user';
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $colorClass }}">
                                    <i class="{{ $iconClass }} mr-1"></i>
                                    {{ $item->akses_mnu }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400 font-mono">
                                {{ \Carbon\Carbon::parse($item->updated_at)->format('Y-m-d H:i:s') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex space-x-2">
                                    <button onclick="restoreMenu({{ $item->id_mnu }})" class="text-yellow-400 hover:text-yellow-300 transition-colors" title="Restore">
                                        <i class="fas fa-undo"></i>
                                    </button>
                                    <button onclick="forceDeleteMenu({{ $item->id_mnu }})" class="text-red-400 hover:text-red-300 transition-colors" title="Delete Permanently">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                                <i class="fas fa-trash text-4xl mb-4 text-green-400"></i>
                                <p class="text-lg text-green-400 neon-text-green">Trash is empty</p>
                                <p class="text-sm">No deleted menu items found</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($menu->hasPages())
        <div class="robot-card rounded-lg p-6 mt-8">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-400">
                    Showing <span class="font-medium text-red-400">{{ $menu->firstItem() }}</span> to <span class="font-medium text-red-400">{{ $menu->lastItem() }}</span> of <span class="font-medium text-red-400">{{ $menu->total() }}</span> results
                </div>
                <div class="flex space-x-2">
                    @if($menu->onFirstPage())
                        <button class="btn-cyber px-4 py-2 rounded-lg text-sm opacity-50 cursor-not-allowed" disabled>
                            <i class="fas fa-chevron-left mr-1"></i>PREV
                        </button>
                    @else
                        <a href="{{ $menu->previousPageUrl() }}" class="btn-cyber px-4 py-2 rounded-lg text-sm">
                            <i class="fas fa-chevron-left mr-1"></i>PREV
                        </a>
                    @endif

                    @foreach($menu->getUrlRange(1, $menu->lastPage()) as $page => $url)
                        @if($page == $menu->currentPage())
                            <button class="btn-cyber px-4 py-2 rounded-lg text-sm bg-red-600">{{ $page }}</button>
                        @else
                            <a href="{{ $url }}" class="btn-cyber px-4 py-2 rounded-lg text-sm">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if($menu->hasMorePages())
                        <a href="{{ $menu->nextPageUrl() }}" class="btn-cyber px-4 py-2 rounded-lg text-sm">
                            NEXT<i class="fas fa-chevron-right ml-1"></i>
                        </a>
                    @else
                        <button class="btn-cyber px-4 py-2 rounded-lg text-sm opacity-50 cursor-not-allowed" disabled>
                            NEXT<i class="fas fa-chevron-right ml-1"></i>
                        </button>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Restore Confirmation Modal -->
    <div id="restoreModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="robot-card rounded-lg p-6 m-4 max-w-md w-full">
            <div class="flex items-center mb-4">
                <i class="fas fa-undo text-yellow-400 text-2xl mr-3"></i>
                <h3 class="text-lg font-semibold text-yellow-400">CONFIRM RESTORE</h3>
            </div>
            <p class="text-gray-300 mb-6">Are you sure you want to restore this menu item? It will be moved back to the active menu list.</p>
            <div class="flex justify-end space-x-3">
                <button onclick="closeRestoreModal()" class="btn-cyber px-4 py-2 rounded-lg">
                    CANCEL
                </button>
                <button onclick="confirmRestore()" class="btn-restore px-4 py-2 rounded-lg">
                    RESTORE
                </button>
            </div>
        </div>
    </div>

    <!-- Force Delete Confirmation Modal -->
    <div id="forceDeleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="robot-card rounded-lg p-6 m-4 max-w-md w-full">
            <div class="flex items-center mb-4">
                <i class="fas fa-skull-crossbones text-red-400 text-2xl mr-3"></i>
                <h3 class="text-lg font-semibold text-red-400">PERMANENT DELETE</h3>
            </div>
            <p class="text-gray-300 mb-6">
                <strong class="text-red-400">WARNING:</strong> This action cannot be undone! 
                The menu item will be permanently deleted from the database.
            </p>
            <div class="flex justify-end space-x-3">
                <button onclick="closeForceDeleteModal()" class="btn-cyber px-4 py-2 rounded-lg">
                    CANCEL
                </button>
                <button onclick="confirmForceDelete()" class="btn-danger px-4 py-2 rounded-lg">
                    DELETE FOREVER
                </button>
            </div>
        </div>
    </div>

    <!-- Empty Trash Confirmation Modal -->
    <div id="emptyTrashModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="robot-card rounded-lg p-6 m-4 max-w-md w-full">
            <div class="flex items-center mb-4">
                <i class="fas fa-fire text-red-400 text-2xl mr-3"></i>
                <h3 class="text-lg font-semibold text-red-400">EMPTY TRASH</h3>
            </div>
            <p class="text-gray-300 mb-6">
                <strong class="text-red-400">DANGER:</strong> This will permanently delete ALL items in trash! 
                This action cannot be undone.
            </p>
            <div class="flex justify-end space-x-3">
                <button onclick="closeEmptyTrashModal()" class="btn-cyber px-4 py-2 rounded-lg">
                    CANCEL
                </button>
                <button onclick="confirmEmptyTrash()" class="btn-danger px-4 py-2 rounded-lg">
                    EMPTY TRASH
                </button>
            </div>
        </div>
    </div>

    <script>
        let restoreId = null;
        let forceDeleteId = null;

        function restoreMenu(id) {
            restoreId = id;
            document.getElementById('restoreModal').classList.remove('hidden');
            document.getElementById('restoreModal').classList.add('flex');
        }

        function closeRestoreModal() {
            document.getElementById('restoreModal').classList.add('hidden');
            document.getElementById('restoreModal').classList.remove('flex');
            restoreId = null;
        }

        function confirmRestore() {
            if (restoreId) {
                // Create form and submit for Laravel
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/menu/restore/${restoreId}`;
                
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                
                form.appendChild(csrfToken);
                document.body.appendChild(form);
                form.submit();
            }
        }

        function forceDeleteMenu(id) {
            forceDeleteId = id;
            document.getElementById('forceDeleteModal').classList.remove('hidden');
            document.getElementById('forceDeleteModal').classList.add('flex');
        }

        function closeForceDeleteModal() {
            document.getElementById('forceDeleteModal').classList.add('hidden');
            document.getElementById('forceDeleteModal').classList.remove('flex');
            forceDeleteId = null;
        }

        function confirmForceDelete() {
            if (forceDeleteId) {
                // Create form and submit for Laravel
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/menu/force-delete/${forceDeleteId}`;
                
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

        function confirmEmptyTrash() {
            document.getElementById('emptyTrashModal').classList.remove('hidden');
            document.getElementById('emptyTrashModal').classList.add('flex');
        }

        function closeEmptyTrashModal() {
            document.getElementById('emptyTrashModal').classList.add('hidden');
            document.getElementById('emptyTrashModal').classList.remove('flex');
        }

        function confirmEmptyTrash() {
            // Create form and submit for Laravel
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/menu/empty-trash';
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            
            form.appendChild(csrfToken);
            document.body.appendChild(form);
            form.submit();
        }

        // Auto-hide alerts
        setTimeout(() => {
            const successAlert = document.getElementById('success-alert');
            const errorAlert = document.getElementById('error-alert');
            if (successAlert) successAlert.classList.add('hidden');
            if (errorAlert) errorAlert.classList.add('hidden');
        }, 5000);
    </script>
</body>
</html>