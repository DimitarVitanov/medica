<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    subscribers: Object,
    totalCount: Number,
    activeCount: Number,
});

const formatDate = (dateString) => {
    if (!dateString) return '';
    const date = new Date(dateString);
    return date.toLocaleDateString('mk-MK', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    });
};

const deleteSubscriber = (id) => {
    if (confirm('Дали сте сигурни дека сакате да го избришете овој претплатник?')) {
        router.delete(`/admin/subscribers/${id}`);
    }
};
</script>

<template>
    <Head title="Претплатници" />
    
    <AuthenticatedLayout>
        <template #header>
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="h4 mb-1 text-white">Претплатници на билтен</h2>
                    <p class="text-white-50 mb-0 small">
                        <span class="badge bg-success me-2">{{ activeCount }} активни</span>
                        Вкупно {{ totalCount }} претплатници
                    </p>
                </div>
            </div>
        </template>
        
        <div class="container-fluid py-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 ps-4">#</th>
                                    <th class="border-0">Е-пошта</th>
                                    <th class="border-0">Статус</th>
                                    <th class="border-0">Датум</th>
                                    <th class="border-0 text-end pe-4">Акции</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(subscriber, index) in subscribers.data" :key="subscriber.id">
                                    <td class="ps-4 text-muted">{{ (subscribers.current_page - 1) * subscribers.per_page + index + 1 }}</td>
                                    <td>
                                        <span class="fw-semibold">{{ subscriber.email }}</span>
                                    </td>
                                    <td>
                                        <span v-if="subscriber.is_active" class="badge bg-success-subtle text-success">Активен</span>
                                        <span v-else class="badge bg-secondary-subtle text-secondary">Неактивен</span>
                                    </td>
                                    <td class="text-muted small">{{ formatDate(subscriber.created_at) }}</td>
                                    <td class="text-end pe-4">
                                        <button 
                                            @click="deleteSubscriber(subscriber.id)"
                                            class="btn btn-sm btn-outline-danger"
                                            title="Избриши"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                                <tr v-if="subscribers.data.length === 0">
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" class="mb-3 opacity-50">
                                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>
                                        </svg>
                                        <p class="mb-0">Нема претплатници</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Pagination -->
                <div v-if="subscribers.last_page > 1" class="card-footer bg-white border-top">
                    <nav class="d-flex justify-content-center">
                        <ul class="pagination pagination-sm mb-0">
                            <li v-for="link in subscribers.links" :key="link.label" class="page-item" :class="{ active: link.active, disabled: !link.url }">
                                <Link 
                                    v-if="link.url"
                                    :href="link.url"
                                    class="page-link"
                                    v-html="link.label"
                                />
                                <span v-else class="page-link" v-html="link.label" />
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
