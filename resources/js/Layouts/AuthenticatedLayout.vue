<script setup>
import { ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import FlashMessage from '@/Components/FlashMessage.vue';

const sidebarCollapsed = ref(false);
const mobileOpen = ref(false);

const navItems = [
    { name: 'Контролна табла', href: '/admin', icon: 'dashboard', route: 'admin.dashboard' },
    { name: 'Пораки', href: '/admin/contacts', icon: 'contacts', route: 'admin.contacts.*' },
    { name: 'Секции', href: '/admin/sections', icon: 'sections', route: 'admin.sections.*' },
    { name: 'Услуги', href: '/admin/services', icon: 'services', route: 'admin.services.*' },
    { name: 'Блогови', href: '/admin/blogs', icon: 'blogs', route: 'admin.blogs.*' },
    { name: 'Слајдери', href: '/admin/sliders', icon: 'sliders', route: 'admin.sliders.*' },
    { name: 'Преводи', href: '/admin/translations', icon: 'translations', route: 'admin.translations.*' },
    { name: 'Поставки', href: '/admin/settings', icon: 'settings', route: 'admin.settings.*' },
];

const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
    <div class="admin-shell">
        <FlashMessage />
        <!-- Sidebar -->
        <aside class="sidebar" :class="{ collapsed: sidebarCollapsed, 'mobile-open': mobileOpen }">
            <div class="sidebar-inner">
                <!-- Brand -->
                <div class="brand">
                    <Link href="/admin" class="brand-link">
                        <div class="brand-icon">
                            <picture>
                                <source srcset="/images/logo.webp" type="image/webp">
                                <img src="/images/logo.png" alt="M">
                            </picture>
                        </div>
                        <span class="brand-name">ПЗУ Медика</span>
                    </Link>
                    <button @click="sidebarCollapsed = !sidebarCollapsed" class="collapse-btn desktop-only" :class="{ 'collapsed-state': sidebarCollapsed }">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline :points="sidebarCollapsed ? '9 18 15 12 9 6' : '15 18 9 12 15 6'"/></svg>
                    </button>
                </div>

                <!-- Nav -->
                <nav class="nav">
                    <div class="nav-group">
                        <span class="nav-label">Мени</span>
                        <ul class="nav-list">
                            <li v-for="item in navItems" :key="item.name">
                                <Link :href="item.href" class="nav-link" :class="{ active: route().current(item.route) }">
                                    <span class="nav-icon">
                                        <svg v-if="item.icon === 'dashboard'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="7" height="7" rx="2"/><rect x="14" y="3" width="7" height="7" rx="2"/><rect x="14" y="14" width="7" height="7" rx="2"/><rect x="3" y="14" width="7" height="7" rx="2"/></svg>
                                        <svg v-if="item.icon === 'contacts'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                                        <svg v-if="item.icon === 'sections'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M3 15h18"/></svg>
                                        <svg v-if="item.icon === 'services'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                                        <svg v-if="item.icon === 'blogs'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14.5 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                                        <svg v-if="item.icon === 'sliders'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="9" cy="9" r="2"/><path d="M21 15l-3.086-3.086a2 2 0 00-2.828 0L6 21"/></svg>
                                        <svg v-if="item.icon === 'translations'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M5 8l6 6"/><path d="M4 14l6-6 2-3"/><path d="M2 5h12"/><path d="M7 2h1"/><path d="M22 22l-5-10-5 10"/><path d="M14 18h6"/></svg>
                                        <svg v-if="item.icon === 'settings'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06a1.65 1.65 0 001.82.33H9a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 012 2 2 2 0 01-2 2h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
                                    </span>
                                    <span class="nav-text">{{ item.name }}</span>
                                </Link>
                            </li>
                        </ul>
                    </div>
                </nav>

                <!-- User -->
                <div class="sidebar-footer">
                    <div class="user-card">
                        <div class="user-avatar">{{ $page.props.auth.user.name.charAt(0) }}</div>
                        <div class="user-info">
                            <span class="user-name">{{ $page.props.auth.user.name }}</span>
                            <span class="user-email">{{ $page.props.auth.user.email }}</span>
                        </div>
                    </div>
                    <button @click="logout" class="logout-btn" title="Одјави се">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    </button>
                </div>
            </div>
        </aside>

        <!-- Main -->
        <main class="main">
            <!-- Header -->
            <header class="header">
                <div class="header-left">
                    <button @click="mobileOpen = !mobileOpen" class="mobile-menu-btn mobile-only">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                    </button>
                    <slot name="header" />
                </div>
                <div class="header-right">
                    <Link href="/" target="_blank" class="header-btn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                        <span>Отвори сајт</span>
                    </Link>
                </div>
            </header>

            <!-- Content -->
            <div class="content">
                <slot />
            </div>
        </main>

        <!-- Mobile overlay -->
        <div v-if="mobileOpen" class="overlay" @click="mobileOpen = false"></div>
    </div>
</template>

<style scoped>
/* ===== ADMIN SHELL ===== */
.admin-shell {
    display: flex;
    min-height: 100vh;
    background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
}

/* ===== SIDEBAR ===== */
.sidebar {
    position: fixed;
    left: 0;
    top: 0;
    bottom: 0;
    width: 260px;
    background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
    box-shadow: 4px 0 20px rgba(102, 126, 234, 0.15);
    z-index: 100;
    transition: width 0.25s ease, transform 0.25s ease;
}

.sidebar.collapsed {
    width: 76px;
}

.sidebar.collapsed .brand-name,
.sidebar.collapsed .nav-text,
.sidebar.collapsed .nav-label,
.sidebar.collapsed .user-info {
    display: none;
}

.sidebar.collapsed .brand {
    justify-content: center;
    padding: 1.25rem 0.5rem;
    position: relative;
}

.sidebar.collapsed .brand-link {
    justify-content: center;
}

.sidebar.collapsed .brand-icon {
    width: 44px;
    height: 44px;
}

.sidebar.collapsed .collapse-btn.collapsed-state {
    display: flex;
    position: absolute;
    right: -14px;
    top: 50%;
    transform: translateY(-50%);
    width: 28px;
    height: 28px;
    background: #fff;
    border-radius: 50%;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    color: #667eea;
}

.sidebar.collapsed .nav-link {
    justify-content: center;
    padding: 0.75rem;
}

.sidebar.collapsed .sidebar-footer {
    flex-direction: column;
    gap: 0.75rem;
    padding: 0.75rem 0.5rem;
}

.sidebar.collapsed .user-card {
    justify-content: center;
}

.sidebar.collapsed .logout-btn {
    width: 100%;
}

.sidebar-inner {
    display: flex;
    flex-direction: column;
    height: 100%;
    padding: 0.5rem;
}

/* Brand */
.brand {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.25rem 0.75rem;
    margin-bottom: 0.5rem;
}

.brand-link {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    text-decoration: none;
    overflow: hidden;
}

.brand-icon {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    background: rgba(255,255,255,0.2);
    backdrop-filter: blur(10px);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.brand-icon img {
    width: 24px;
    height: 24px;
    filter: brightness(0) invert(1);
}

.brand-name {
    font-size: 1.1rem;
    font-weight: 700;
    color: #fff;
    white-space: nowrap;
    transition: opacity 0.2s, width 0.2s;
    text-shadow: 0 1px 2px rgba(0,0,0,0.1);
}

.collapse-btn {
    width: 28px;
    height: 28px;
    border: none;
    border-radius: 8px;
    background: rgba(255,255,255,0.15);
    color: rgba(255,255,255,0.8);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}

.collapse-btn:hover {
    background: rgba(255,255,255,0.25);
    color: #fff;
}

/* Nav */
.nav {
    flex: 1;
    overflow-y: auto;
    padding: 0 0.25rem;
}

.nav-group {
    margin-bottom: 1.5rem;
}

.nav-label {
    display: block;
    padding: 0.5rem 0.75rem;
    font-size: 0.65rem;
    font-weight: 600;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: rgba(255,255,255,0.5);
    transition: opacity 0.2s, width 0.2s;
}

.nav-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.nav-link {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1rem;
    margin-bottom: 4px;
    border-radius: 12px;
    color: rgba(255,255,255,0.75);
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
    transition: all 0.2s ease;
}

.nav-link:hover {
    background: rgba(255,255,255,0.1);
    color: #fff;
}

.nav-link.active {
    background: rgba(255,255,255,0.2);
    color: #fff;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.nav-icon {
    width: 20px;
    height: 20px;
    flex-shrink: 0;
}

.nav-icon svg {
    width: 100%;
    height: 100%;
}

.nav-text {
    white-space: nowrap;
    transition: opacity 0.2s, width 0.2s;
}

/* Sidebar Footer */
.sidebar-footer {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 1rem 0.75rem;
    margin-top: auto;
    border-top: 1px solid rgba(255,255,255,0.1);
}

.user-card {
    display: flex;
    align-items: center;
    gap: 0.625rem;
    flex: 1;
    min-width: 0;
}

.user-avatar {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: rgba(255,255,255,0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-weight: 700;
    font-size: 0.9rem;
    flex-shrink: 0;
}

.user-info {
    display: flex;
    flex-direction: column;
    min-width: 0;
    transition: opacity 0.2s, width 0.2s;
}

.user-name {
    font-size: 0.85rem;
    font-weight: 600;
    color: #fff;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.user-email {
    font-size: 0.7rem;
    color: rgba(255,255,255,0.6);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.logout-btn {
    width: 38px;
    height: 38px;
    border: none;
    border-radius: 10px;
    background: rgba(255,255,255,0.15);
    color: rgba(255,255,255,0.9);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: all 0.2s;
}

.logout-btn svg {
    width: 18px;
    height: 18px;
}

.logout-btn:hover {
    background: rgba(255,255,255,0.25);
    color: #fff;
}

/* ===== MAIN ===== */
.main {
    flex: 1;
    margin-left: 260px;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    transition: margin-left 0.25s ease;
}

.sidebar.collapsed ~ .main {
    margin-left: 76px;
}

/* Header */
.header {
    position: sticky;
    top: 0;
    z-index: 50;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    padding: 1rem 2rem;
    background: rgba(255,255,255,0.8);
    backdrop-filter: blur(12px);
    border-bottom: 1px solid rgba(102, 126, 234, 0.1);
}

.header-left {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.header-right {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.header-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 10px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: #fff;
    font-size: 0.8rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s;
    box-shadow: 0 2px 10px rgba(102, 126, 234, 0.3);
}

.header-btn svg {
    width: 16px;
    height: 16px;
}

.header-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    color: #fff;
}

.mobile-menu-btn {
    width: 42px;
    height: 42px;
    border: none;
    border-radius: 12px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 10px rgba(102, 126, 234, 0.3);
}

.mobile-menu-btn svg {
    width: 22px;
    height: 22px;
}

/* Content */
.content {
    flex: 1;
    padding: 2rem;
}

/* Overlay */
.overlay {
    position: fixed;
    inset: 0;
    background: rgba(102, 126, 234, 0.3);
    backdrop-filter: blur(4px);
    z-index: 99;
}

/* Utilities */
.desktop-only { display: flex; }
.mobile-only { display: none; }

/* Responsive */
@media (max-width: 1024px) {
    .sidebar {
        transform: translateX(-100%);
        width: 260px;
    }
    
    .sidebar.mobile-open {
        transform: translateX(0);
    }
    
    .sidebar.collapsed {
        width: 260px;
    }
    
    .main {
        margin-left: 0;
    }
    
    .sidebar.collapsed ~ .main {
        margin-left: 0;
    }
    
    .desktop-only { display: none; }
    .mobile-only { display: flex; }
    
    .content {
        padding: 1rem;
    }
}
</style>
