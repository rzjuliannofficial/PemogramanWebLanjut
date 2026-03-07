<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'POS Application')</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        :root {
            /* Soft, Professional Colors */
            --primary: #5B7CFF;
            --primary-light: #7B9FFF;
            --primary-dark: #3D5BCE;
            --accent: #6B8FE8;
            
            --success: #34C759;
            --warning: #FF9500;
            --danger: #FF3B30;
            --info: #00B4D8;
            
            /* Neutral Colors - Soft & Warm */
            --bg-primary: #F7F8FC;
            --bg-secondary: #FFFFFF;
            --bg-hover: #F0F4FF;
            
            --text-primary: #1A2137;
            --text-secondary: #5A6B7F;
            --text-tertiary: #8B94A8;
            
            --border: #E8EEF5;
            --border-light: #F0F4FF;
            
            /* Shadows - Soft */
            --shadow-sm: 0 2px 6px rgba(26, 33, 55, 0.08);
            --shadow-md: 0 4px 12px rgba(26, 33, 55, 0.1);
            --shadow-lg: 0 8px 24px rgba(26, 33, 55, 0.12);
        }
        
        html {
            scroll-behavior: smooth;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', sans-serif;
            background: var(--bg-primary);
            min-height: 100vh;
            display: flex;
            color: var(--text-primary);
            line-height: 1.5;
            font-weight: 400;
        }
        
        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, #FFFFFF 0%, #F8FAFF 100%);
            border-right: 1px solid var(--border);
            min-height: 100vh;
            padding: 2rem 0;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            overflow-y: auto;
            box-shadow: 2px 0 8px rgba(26, 33, 55, 0.06);
        }
        
        .sidebar-brand {
            padding: 0 2rem 2rem;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid var(--border);
        }
        
        .sidebar-brand h2 {
            color: var(--text-primary);
            font-size: 1.4rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            letter-spacing: -0.3px;
        }
        
        .sidebar-menu {
            list-style: none;
            padding: 0 1rem;
        }
        
        .sidebar-menu li {
            margin-bottom: 0.35rem;
        }
        
        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 0.85rem 1.25rem;
            color: var(--text-secondary);
            text-decoration: none;
            border-radius: 9px;
            transition: all 0.25s ease;
            font-size: 0.93rem;
            font-weight: 500;
            position: relative;
            margin: 0 0;
        }
        
        .sidebar-menu a:hover {
            background: var(--bg-hover);
            color: var(--primary);
            padding-left: 1.5rem;
        }
        
        .sidebar-menu a.active {
            background: linear-gradient(135deg, rgba(91, 124, 255, 0.08) 0%, rgba(91, 124, 255, 0.04) 100%);
            color: var(--primary);
            font-weight: 600;
            border-left: 3px solid var(--primary);
            padding-left: calc(1.25rem - 3px);
        }
        
        .sidebar-menu .icon {
            margin-right: 1rem;
            font-size: 1.2rem;
            min-width: 20px;
        }
        
        /* ===== MAIN CONTENT ===== */
        .main-content {
            margin-left: 280px;
            flex: 1;
            padding: 2.5rem;
        }
        
        /* ===== BUTTONS ===== */
        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 9px;
            border: none;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.25s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            letter-spacing: -0.2px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white;
            box-shadow: var(--shadow-md);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }
        
        .btn-secondary {
            background: linear-gradient(135deg, var(--info) 0%, #00C9E9 100%);
            color: white;
            box-shadow: var(--shadow-md);
        }
        
        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }
        
        .btn-success {
            background: var(--success);
            color: white;
        }
        
        .btn-danger {
            background: var(--danger);
            color: white;
        }
        
        .content-area {
            background: var(--bg-secondary);
            padding: 2.5rem;
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border);
        }
        
        /* ===== DROPDOWN ===== */
        .dropdown-menu {
            position: relative;
            width: 100%;
        }
        
        .dropdown-toggle {
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            padding: 1rem 1.5rem;
            border-radius: 10px;
            transition: all 0.2s ease;
            border: none;
            background: transparent;
            color: inherit;
            font-size: inherit;
            font-family: inherit;
            text-align: left;
            user-select: none;
        }
        
        .dropdown-toggle:hover {
            background: var(--bg-hover);
        }
        
        .dropdown-toggle::after {
            content: '›';
            font-size: 1.5rem;
            transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            flex-shrink: 0;
            margin-left: auto;
        }
        
        .dropdown-toggle.show::after {
            transform: rotate(90deg);
        }
        
        .dropdown-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            position: static;
        }
        
        .dropdown-content.show {
            max-height: 500px;
        }
        
        .dropdown-content a {
            padding: 0.75rem 1.25rem !important;
            border-left: none !important;
            color: var(--text-secondary) !important;
            display: block;
            transition: all 0.2s ease;
            border-radius: 0;
            font-weight: 500;
            white-space: nowrap;
        }
        
        .dropdown-content a:hover {
            background: var(--bg-hover) !important;
            color: var(--primary) !important;
            padding-left: 1.75rem !important;
        }
        
        /* ===== SCROLLBAR ===== */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }
        
        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }
        
        .sidebar::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 3px;
        }
        
        .sidebar::-webkit-scrollbar-thumb:hover {
            background: var(--text-tertiary);
        }
        
        /* ===== RESPONSIVE ===== */
        @media (max-width: 1024px) {
            .sidebar {
                width: 260px;
            }
            
            .main-content {
                margin-left: 260px;
                padding: 2rem;
            }
        }
        
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                padding: 1rem;
                border-bottom: 1px solid var(--border);
                box-shadow: var(--shadow-sm);
            }
            
            .sidebar-menu {
                display: none;
            }
            
            .main-content {
                margin-left: 0;
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-brand">
            <h2>💳 PoS</h2>
        </div>
        <ul class="sidebar-menu">
            <li><a href="/" class="{{ request()->is('/') ? 'active' : '' }}"><span class="icon">📊</span> Dashboard</a></li>
            <li class="dropdown-menu">
                <a href="#" class="dropdown-toggle {{ request()->is('category/*') ? 'active' : '' }}">
                    <span class="icon">🛍️</span> Products
                </a>
                <div class="dropdown-content">
                    <a href="/category/food-beverage">Food & Beverage</a>
                    <a href="/category/beauty-health">Beauty & Health</a>
                    <a href="/category/home-care">Home Care</a>
                    <a href="/category/baby-kid">Baby & Kid</a>
                </div>
            </li>
            <li><a href="/sales" class="{{ request()->is('sales') ? 'active' : '' }}"><span class="icon">💰</span> Transactions</a></li>
            <li><a href="/user/1/name/Admin"><span class="icon">👤</span> Profile</a></li>
        </ul>
    </aside>

    <main class="main-content">
        @yield('content')
    </main>
    
    <script>
        // Dropdown menu handler
        document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                const menu = this.closest('.dropdown-menu');
                const content = menu.querySelector('.dropdown-content');
                
                // Close other dropdowns
                document.querySelectorAll('.dropdown-content').forEach(c => {
                    if (c !== content) {
                        c.classList.remove('show');
                        c.closest('.dropdown-menu').querySelector('.dropdown-toggle').classList.remove('show');
                    }
                });
                
                // Toggle current dropdown
                content.classList.toggle('show');
                this.classList.toggle('show');
            });
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.dropdown-menu')) {
                document.querySelectorAll('.dropdown-content').forEach(c => {
                    c.classList.remove('show');
                    c.closest('.dropdown-menu').querySelector('.dropdown-toggle').classList.remove('show');
                });
            }
        });
    </script>
</body>
</html>
