<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        :root {
            --sidebar-width: 250px;
            --sidebar-collapsed-width: 60px;
            --primary-color: #1a1a1a;
            --hover-color: #2d2d2d;
            --text-color: #2a2a2a;
            --transition-speed: 0.3s;
        }

        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: var(--primary-color);
            color: var(--text-color);
            transition: width var(--transition-speed) ease;
            z-index: 1000;
            overflow-x: hidden;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar-header {
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #333;
        }

        .toggle-btn {
            position: absolute;
            right: -12px;
            top: 20px;
            background: var(--primary-color);
            border: none;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            color: var(--text-color);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #333;
        }

        .toggle-btn:hover {
            background: var(--hover-color);
        }

        .sidebar-menu {
            padding: 10px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            text-decoration: none;
            color: var(--text-color);
            border-radius: 6px;
            margin: 8px 0;
            transition: background var(--transition-speed);
        }

        .menu-item:hover {
            background: var(--hover-color);
        }

        .menu-item i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
        }

        .menu-text {
            transition: opacity var(--transition-speed);
        }

        .collapsed .menu-text {
            opacity: 0;
            visibility: hidden;
        }

        .collapsed .sidebar-header h2 {
            display: none;
        }

        /* Main content adjustment */
        .main-content {
            margin-left: var(--sidebar-width);
            transition: margin-left var(--transition-speed) ease;
            padding: 20px;
        }

        .main-content.collapsed {
            margin-left: var(--sidebar-collapsed-width);
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .sidebar {
                width: var(--sidebar-collapsed-width);
            }
            
            .main-content {
                margin-left: var(--sidebar-collapsed-width);
            }

            .menu-text {
                opacity: 0;
                visibility: hidden;
            }

            .sidebar.expanded {
                width: var(--sidebar-width);
            }

            .sidebar.expanded .menu-text {
                opacity: 1;
                visibility: visible;
            }
        }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-header">
            <h2>Admin Panel</h2>
            <button class="toggle-btn" id="toggle-sidebar">
                ◀
            </button>
        </div>
        <nav class="sidebar-menu">
            <a href="dashboard" class="menu-item">
                <i>📊</i>
                <span class="menu-text">Dashboard</span>
            </a>
            <a href="../ChatUse/admin_chat" class="menu-item">
                <i>💬</i>
                <span class="menu-text">Chats</span>
            </a>
            <a href="user" class="menu-item">
                <i>👥</i>
                <span class="menu-text">Users</span>
            </a>
            <a href="logout" class="menu-item">
                <i>🚪</i>
                <span class="menu-text">Logout</span>
            </a>
        </nav>
    </aside>

    <main class="main-content">
        <!-- Your page content goes here -->
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.sidebar');
            const mainContent = document.querySelector('.main-content');
            const toggleBtn = document.getElementById('toggle-sidebar');
            const mediaQuery = window.matchMedia('(max-width: 768px)');

            // Toggle button text content
            function updateToggleButton(isCollapsed) {
                toggleBtn.textContent = isCollapsed ? '▶' : '◀';
            }

            // Toggle sidebar
            toggleBtn.addEventListener('click', () => {
                if (mediaQuery.matches) {
                    sidebar.classList.toggle('expanded');
                    updateToggleButton(!sidebar.classList.contains('expanded'));
                } else {
                    sidebar.classList.toggle('collapsed');
                    mainContent.classList.toggle('collapsed');
                    updateToggleButton(sidebar.classList.contains('collapsed'));
                }
            });

            // Handle responsive behavior
            function handleResize(e) {
                if (e.matches) {
                    // Mobile view
                    sidebar.classList.remove('collapsed');
                    mainContent.classList.remove('collapsed');
                    sidebar.classList.remove('expanded');
                } else {
                    // Desktop view
                    sidebar.classList.remove('expanded');
                }
                updateToggleButton(sidebar.classList.contains('collapsed'));
            }

            mediaQuery.addListener(handleResize);
            handleResize(mediaQuery);
        });
    </script>
</body>
</html>