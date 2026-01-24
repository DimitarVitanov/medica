<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    stats: Object,
    recent_blogs: Array,
});
</script>

<template>
    <Head title="Админ Панел" />

    <AuthenticatedLayout>
        <template #header>
            <div class="header-content">
                <h1 class="page-title">Контролна табла</h1>
                <p class="page-subtitle">Преглед на вашиот сајт</p>
            </div>
        </template>

        <div class="dashboard">
            <!-- Stats Grid -->
            <div class="stats-grid">
                <Link href="/admin/services" class="stat-card stat-purple">
                    <div class="stat-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                    </div>
                    <div class="stat-info">
                        <span class="stat-value">{{ stats.services }}</span>
                        <span class="stat-label">Услуги</span>
                    </div>
                    <div class="stat-arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                    </div>
                </Link>

                <Link href="/admin/blogs" class="stat-card stat-blue">
                    <div class="stat-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    </div>
                    <div class="stat-info">
                        <span class="stat-value">{{ stats.blogs }}</span>
                        <span class="stat-label">Блогови</span>
                    </div>
                    <div class="stat-arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                    </div>
                </Link>

                <div class="stat-card stat-green">
                    <div class="stat-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    </div>
                    <div class="stat-info">
                        <span class="stat-value">{{ stats.published_blogs }}</span>
                        <span class="stat-label">Објавени</span>
                    </div>
                </div>

                <Link href="/admin/sliders" class="stat-card stat-orange">
                    <div class="stat-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    </div>
                    <div class="stat-info">
                        <span class="stat-value">{{ stats.sliders }}</span>
                        <span class="stat-label">Слајдери</span>
                    </div>
                    <div class="stat-arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                    </div>
                </Link>
            </div>

            <!-- Content Grid -->
            <div class="content-grid">
                <!-- Recent Blogs -->
                <div class="content-card">
                    <div class="card-header">
                        <h2 class="card-title">Последни блогови</h2>
                        <Link href="/admin/blogs" class="card-action">Види сите</Link>
                    </div>
                    <div class="card-body">
                        <div v-if="recent_blogs.length" class="blog-list">
                            <div v-for="blog in recent_blogs" :key="blog.id" class="blog-item">
                                <div class="blog-info">
                                    <h3 class="blog-title">{{ blog.title }}</h3>
                                    <p class="blog-meta">{{ blog.author }} · {{ blog.category }}</p>
                                </div>
                                <span :class="blog.is_published ? 'badge-success' : 'badge-warning'" class="status-badge">
                                    {{ blog.is_published ? 'Објавен' : 'Нацрт' }}
                                </span>
                            </div>
                        </div>
                        <div v-else class="empty-state">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            <p>Нема блогови</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="content-card">
                    <div class="card-header">
                        <h2 class="card-title">Брзи акции</h2>
                    </div>
                    <div class="card-body">
                        <div class="actions-grid">
                            <Link href="/admin/blogs/create" class="action-btn action-blue">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                <span>Нов блог</span>
                            </Link>
                            <Link href="/admin/services/create" class="action-btn action-purple">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                <span>Нова услуга</span>
                            </Link>
                            <Link href="/admin/sliders/create" class="action-btn action-orange">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                <span>Нов слајдер</span>
                            </Link>
                            <Link href="/admin/sections" class="action-btn action-teal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/></svg>
                                <span>Секции</span>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.header-content {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.page-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
}

.page-subtitle {
    font-size: 0.875rem;
    color: #64748b;
    margin: 0;
}

.dashboard {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
}

.stat-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
    background: #fff;
    border-radius: 16px;
    text-decoration: none;
    transition: all 0.2s ease;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05), 0 4px 12px rgba(102, 126, 234, 0.08);
}

.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
}

.stat-icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.stat-purple .stat-icon { background: linear-gradient(135deg, #6B4C9A 0%, #8B6BAE 100%); color: #fff; }
.stat-blue .stat-icon { background: linear-gradient(135deg, #3B82F6 0%, #60A5FA 100%); color: #fff; }
.stat-green .stat-icon { background: linear-gradient(135deg, #10B981 0%, #34D399 100%); color: #fff; }
.stat-orange .stat-icon { background: linear-gradient(135deg, #F59E0B 0%, #FBBF24 100%); color: #fff; }

.stat-info {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.stat-value {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1e293b;
    line-height: 1;
}

.stat-label {
    font-size: 0.875rem;
    color: #64748b;
    margin-top: 0.25rem;
}

.stat-arrow {
    color: #cbd5e1;
}

/* Content Grid */
.content-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
}

.content-card {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05), 0 4px 12px rgba(102, 126, 234, 0.08);
}

.card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #f1f5f9;
}

.card-title {
    font-size: 1rem;
    font-weight: 600;
    color: #1e293b;
    margin: 0;
}

.card-action {
    font-size: 0.8rem;
    font-weight: 500;
    color: #667eea;
    text-decoration: none;
}

.card-action:hover {
    text-decoration: underline;
}

.card-body {
    padding: 1rem 1.5rem 1.5rem;
}

/* Blog List */
.blog-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.blog-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.875rem 1rem;
    background: #f8fafc;
    border-radius: 10px;
    transition: all 0.2s ease;
}

.blog-item:hover {
    background: #f1f5f9;
}

.blog-info {
    flex: 1;
    min-width: 0;
}

.blog-title {
    font-size: 0.9rem;
    font-weight: 600;
    color: #1e293b;
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.blog-meta {
    font-size: 0.75rem;
    color: #94a3b8;
    margin: 0.25rem 0 0;
}

.status-badge {
    padding: 0.375rem 0.75rem;
    border-radius: 20px;
    font-size: 0.65rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.badge-success {
    background: #dcfce7;
    color: #16a34a;
}

.badge-warning {
    background: #fef3c7;
    color: #d97706;
}

.empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 3rem 1rem;
    color: #94a3b8;
}

.empty-state svg {
    margin-bottom: 1rem;
    opacity: 0.4;
}

.empty-state p {
    margin: 0;
    font-size: 0.9rem;
}

/* Actions Grid */
.actions-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 0.75rem;
}

.action-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    padding: 1.5rem 1rem;
    border-radius: 12px;
    text-decoration: none;
    transition: all 0.2s ease;
    border: 1px solid transparent;
}

.action-btn span {
    font-size: 0.8rem;
    font-weight: 600;
}

.action-btn:hover {
    transform: translateY(-2px);
}

.action-blue {
    background: #eff6ff;
    border-color: #dbeafe;
    color: #3b82f6;
}
.action-blue:hover {
    background: #3b82f6;
    border-color: #3b82f6;
    color: #fff;
}

.action-purple {
    background: #f5f3ff;
    border-color: #ede9fe;
    color: #7c3aed;
}
.action-purple:hover {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-color: transparent;
    color: #fff;
}

.action-orange {
    background: #fffbeb;
    border-color: #fef3c7;
    color: #f59e0b;
}
.action-orange:hover {
    background: #f59e0b;
    border-color: #f59e0b;
    color: #fff;
}

.action-teal {
    background: #f0fdfa;
    border-color: #ccfbf1;
    color: #14b8a6;
}
.action-teal:hover {
    background: #14b8a6;
    border-color: #14b8a6;
    color: #fff;
}

/* Responsive */
@media (max-width: 1200px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 991px) {
    .content-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 576px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .actions-grid {
        grid-template-columns: 1fr;
    }
}
</style>
