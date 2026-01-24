<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    sliders: Array,
});

const deleteSlider = (id) => {
    if (confirm('Дали сте сигурни дека сакате да го избришете овој слајдер?')) {
        router.delete(`/admin/sliders/${id}`);
    }
};
</script>

<template>
    <Head title="Слајдери - Админ" />

    <AuthenticatedLayout>
        <template #header>
            <div class="header-wrapper">
                <div class="header-content">
                    <h1 class="page-title">Слајдери</h1>
                    <p class="page-subtitle">Управувајте со слајдерите на почетната страница</p>
                </div>
                <Link href="/admin/sliders/create" class="btn-primary-custom">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Додај слајдер
                </Link>
            </div>
        </template>

        <div class="data-card">
            <div class="table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th class="w-60">#</th>
                            <th>Наслов</th>
                            <th>Поднаслов</th>
                            <th class="w-100">Статус</th>
                            <th class="w-150 text-end">Акции</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="slider in sliders" :key="slider.id">
                            <td class="meta-text">{{ slider.order }}</td>
                            <td class="title-text">{{ slider.title }}</td>
                            <td class="desc-cell">{{ slider.subtitle }}</td>
                            <td>
                                <span :class="slider.is_active ? 'status-active' : 'status-inactive'" class="status-badge">
                                    {{ slider.is_active ? 'Активен' : 'Неактивен' }}
                                </span>
                            </td>
                            <td class="actions-cell">
                                <Link :href="`/admin/sliders/${slider.id}/edit`" class="action-btn edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </Link>
                                <button @click="deleteSlider(slider.id)" class="action-btn delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                </button>
                            </td>
                        </tr>
                        <tr v-if="!sliders.length">
                            <td colspan="5">
                                <div class="empty-state">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                    <p>Нема слајдери</p>
                                    <Link href="/admin/sliders/create" class="empty-action">Додај прв слајдер</Link>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.header-wrapper { display: flex; align-items: center; justify-content: space-between; width: 100%; }
.header-content { display: flex; flex-direction: column; gap: 0.25rem; }
.page-title { font-size: 1.5rem; font-weight: 700; color: #1e293b; margin: 0; }
.page-subtitle { font-size: 0.875rem; color: #64748b; margin: 0; }

.btn-primary-custom {
    display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.625rem 1.25rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff;
    font-size: 0.875rem; font-weight: 600; border-radius: 10px; text-decoration: none;
    transition: all 0.2s ease; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}
.btn-primary-custom:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4); color: #fff; }

.data-card { background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05), 0 4px 12px rgba(102, 126, 234, 0.08); }
.table-wrapper { overflow-x: auto; }
.data-table { width: 100%; border-collapse: collapse; }
.data-table thead { background: #f8fafc; }
.data-table th { padding: 1rem 1.25rem; text-align: left; font-size: 0.7rem; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #e2e8f0; }
.data-table th.text-end { text-align: right; }
.data-table th.w-60 { width: 60px; }
.data-table th.w-100 { width: 100px; }
.data-table th.w-150 { width: 150px; }
.data-table td { padding: 1rem 1.25rem; font-size: 0.9rem; color: #475569; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
.data-table tr:last-child td { border-bottom: none; }
.data-table tbody tr:hover td { background: #f8fafc; }

.title-text { font-weight: 600; color: #1e293b; }
.meta-text { color: #64748b; }
.desc-cell { color: #64748b; max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

.status-badge { display: inline-block; padding: 0.375rem 0.75rem; border-radius: 20px; font-size: 0.65rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
.status-active { background: #dcfce7; color: #16a34a; }
.status-inactive { background: #fee2e2; color: #dc2626; }

.actions-cell { text-align: right; white-space: nowrap; }
.action-btn { display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; border: none; border-radius: 8px; cursor: pointer; transition: all 0.2s ease; text-decoration: none; }
.action-btn.edit { background: #eff6ff; color: #3b82f6; margin-right: 0.5rem; }
.action-btn.edit:hover { background: #3b82f6; color: #fff; }
.action-btn.delete { background: #fef2f2; color: #ef4444; }
.action-btn.delete:hover { background: #ef4444; color: #fff; }

.empty-state { display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 4rem 1rem; color: #94a3b8; }
.empty-state svg { margin-bottom: 1rem; opacity: 0.4; }
.empty-state p { margin: 0 0 1rem; font-size: 0.9rem; }
.empty-action { padding: 0.5rem 1rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; font-size: 0.8rem; font-weight: 600; border-radius: 8px; text-decoration: none; transition: all 0.2s ease; box-shadow: 0 2px 10px rgba(102, 126, 234, 0.3); }
.empty-action:hover { transform: translateY(-1px); box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4); }

@media (max-width: 768px) { .header-wrapper { flex-direction: column; align-items: flex-start; gap: 1rem; } .btn-primary-custom { width: 100%; justify-content: center; } }
</style>
