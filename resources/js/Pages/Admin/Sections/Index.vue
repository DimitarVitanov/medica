<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    sections: Array,
});

const sectionLabels = {
    'about_us': 'За нас',
    'working_hours': 'Работно време',
    'stats': 'Статистики',
    'contact': 'Контакт информации',
};

const sectionIcons = {
    'about_us': '👤',
    'working_hours': '🕐',
    'stats': '📊',
    'contact': '📞',
};
</script>

<template>
    <Head title="Секции - Админ" />

    <AuthenticatedLayout>
        <template #header>
            <div class="header-content">
                <h1 class="page-title">Секции</h1>
                <p class="page-subtitle">Уредувајте ги содржините на почетната страница</p>
            </div>
        </template>

        <div class="sections-grid">
            <Link 
                v-for="section in sections" 
                :key="section.id"
                :href="`/admin/sections/${section.id}/edit`"
                class="section-card"
            >
                <div class="section-icon">{{ sectionIcons[section.key] || '📄' }}</div>
                <div class="section-info">
                    <h3 class="section-name">{{ sectionLabels[section.key] || section.key }}</h3>
                    <p class="section-desc">{{ section.title }}</p>
                </div>
                <div class="section-status">
                    <span :class="section.is_active ? 'status-active' : 'status-inactive'" class="status-badge">
                        {{ section.is_active ? 'Активна' : 'Неактивна' }}
                    </span>
                </div>
                <div class="section-arrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                </div>
            </Link>
            
            <div v-if="!sections || !sections.length" class="empty-state">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/></svg>
                <p>Нема секции</p>
            </div>
        </div>

        <div class="info-card">
            <div class="info-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
            </div>
            <div class="info-text">
                <strong>Напомена:</strong> Овде можете да ги уредувате содржините на секциите на почетната страница - За нас, Работно време, Статистики итн.
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.header-content { display: flex; flex-direction: column; gap: 0.25rem; }
.page-title { font-size: 1.5rem; font-weight: 700; color: #1e293b; margin: 0; }
.page-subtitle { font-size: 0.875rem; color: #64748b; margin: 0; }

.sections-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

.section-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.25rem 1.5rem;
    background: #fff;
    border-radius: 16px;
    text-decoration: none;
    transition: all 0.2s ease;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05), 0 4px 12px rgba(102, 126, 234, 0.08);
}

.section-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
}

.section-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.section-info {
    flex: 1;
    min-width: 0;
}

.section-name {
    font-size: 1rem;
    font-weight: 600;
    color: #1e293b;
    margin: 0 0 0.25rem;
}

.section-desc {
    font-size: 0.8rem;
    color: #64748b;
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.section-status {
    flex-shrink: 0;
}

.status-badge {
    display: inline-block;
    padding: 0.375rem 0.75rem;
    border-radius: 20px;
    font-size: 0.65rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-active { background: #dcfce7; color: #16a34a; }
.status-inactive { background: #fee2e2; color: #dc2626; }

.section-arrow {
    color: #cbd5e1;
    flex-shrink: 0;
}

.section-card:hover .section-arrow {
    color: #667eea;
}

.empty-state {
    grid-column: 1 / -1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 4rem 1rem;
    background: #fff;
    border-radius: 16px;
    color: #94a3b8;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}

.empty-state svg { margin-bottom: 1rem; opacity: 0.4; }
.empty-state p { margin: 0; font-size: 0.9rem; }

.info-card {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    margin-top: 1.5rem;
    padding: 1rem 1.25rem;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.08) 0%, rgba(118, 75, 162, 0.08) 100%);
    border: 1px solid rgba(102, 126, 234, 0.15);
    border-radius: 12px;
}

.info-icon {
    color: #667eea;
    flex-shrink: 0;
    margin-top: 2px;
}

.info-text {
    font-size: 0.85rem;
    color: #475569;
    line-height: 1.5;
}

.info-text strong {
    color: #1e293b;
}

@media (max-width: 768px) {
    .sections-grid {
        grid-template-columns: 1fr;
    }
}
</style>
