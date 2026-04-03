<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    doses: Array,
});

const formatDate = (date) => {
    if (!date) return '-';
    return new Date(date).toLocaleDateString('mk-MK', { day: '2-digit', month: '2-digit', year: 'numeric' });
};

const deleteDose = (id) => {
    if (confirm('Дали сте сигурни дека сакате да ја избришете оваа дневна доза?')) {
        router.delete(`/admin/daily-doses/${id}`);
    }
};

const getImageUrl = (image) => {
    if (!image) return null;
    if (image.startsWith('http')) return image;
    return `/storage/${image}`;
};
</script>

<template>
    <Head title="Дневна Доза - Админ" />

    <AuthenticatedLayout>
        <template #header>
            <div class="d-flex align-items-center justify-content-between w-100">
                <h5 class="fw-bold text-dark mb-0">Дневна Доза</h5>
                <Link href="/admin/daily-doses/create" class="btn btn-primary btn-sm rounded-pill px-3">
                    + Додај нова
                </Link>
            </div>
        </template>

        <div class="container-fluid">
            <div v-if="doses.length === 0" class="text-center py-5 text-muted">
                <p class="mb-3">Нема додадени дневни дози</p>
                <Link href="/admin/daily-doses/create" class="btn btn-primary rounded-pill px-4">Додај прва</Link>
            </div>

            <div v-else class="table-responsive">
                <table class="table table-hover align-middle bg-white rounded-3 overflow-hidden shadow-sm">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 60px;">Слика</th>
                            <th>Наслов</th>
                            <th>Автор</th>
                            <th>Категорија</th>
                            <th>Датум</th>
                            <th>Статус</th>
                            <th style="width: 120px;">Акции</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="dose in doses" :key="dose.id">
                            <td>
                                <img v-if="dose.image" :src="getImageUrl(dose.image)" :alt="dose.title" class="rounded" style="width:48px;height:48px;object-fit:cover;">
                                <div v-else class="bg-light rounded d-flex align-items-center justify-content-center" style="width:48px;height:48px;">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#aaa" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="9" cy="9" r="2"/><path d="M21 15l-3.086-3.086a2 2 0 00-2.828 0L6 21"/></svg>
                                </div>
                            </td>
                            <td class="fw-semibold">{{ dose.title }}</td>
                            <td class="text-muted">{{ dose.author }}</td>
                            <td><span v-if="dose.category" class="badge bg-info text-white">{{ dose.category }}</span></td>
                            <td class="text-muted small">{{ formatDate(dose.published_at) }}</td>
                            <td>
                                <span class="badge rounded-pill" :class="dose.is_published ? 'bg-success' : 'bg-warning text-dark'">
                                    {{ dose.is_published ? 'Објавена' : 'Нацрт' }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <Link :href="`/admin/daily-doses/${dose.id}/edit`" class="btn btn-sm btn-outline-primary">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </Link>
                                    <button @click="deleteDose(dose.id)" class="btn btn-sm btn-outline-danger">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
