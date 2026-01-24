<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    contacts: Object,
    unreadCount: Number,
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

const deleteContact = (id) => {
    if (confirm('Дали сте сигурни дека сакате да ја избришете оваа порака?')) {
        router.delete(`/admin/contacts/${id}`);
    }
};
</script>

<template>
    <Head title="Пораки" />
    
    <AuthenticatedLayout>
        <template #header>
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="h4 mb-1 text-white">Пораки од контакт форма</h2>
                    <p class="text-white-50 mb-0 small">
                        <span v-if="unreadCount > 0" class="badge bg-danger me-2">{{ unreadCount }} непрочитани</span>
                        Вкупно {{ contacts.total }} пораки
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
                                    <th class="border-0 ps-4" style="width: 40px;"></th>
                                    <th class="border-0">Име</th>
                                    <th class="border-0">Тема</th>
                                    <th class="border-0">Е-пошта</th>
                                    <th class="border-0">Датум</th>
                                    <th class="border-0 text-end pe-4">Акции</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr 
                                    v-for="contact in contacts.data" 
                                    :key="contact.id"
                                    :class="{ 'bg-light': !contact.is_read }"
                                >
                                    <td class="ps-4">
                                        <span v-if="!contact.is_read" class="badge bg-primary rounded-pill">Ново</span>
                                    </td>
                                    <td>
                                        <Link 
                                            :href="`/admin/contacts/${contact.id}`"
                                            class="text-decoration-none fw-semibold"
                                            :class="contact.is_read ? 'text-muted' : 'text-dark'"
                                        >
                                            {{ contact.name }}
                                        </Link>
                                    </td>
                                    <td>
                                        <Link 
                                            :href="`/admin/contacts/${contact.id}`"
                                            class="text-decoration-none"
                                            :class="contact.is_read ? 'text-muted' : 'text-dark'"
                                        >
                                            {{ contact.subject }}
                                        </Link>
                                    </td>
                                    <td class="text-muted">{{ contact.email }}</td>
                                    <td class="text-muted small">{{ formatDate(contact.created_at) }}</td>
                                    <td class="text-end pe-4">
                                        <Link 
                                            :href="`/admin/contacts/${contact.id}`"
                                            class="btn btn-sm btn-outline-primary me-1"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                                            </svg>
                                        </Link>
                                        <button 
                                            @click="deleteContact(contact.id)"
                                            class="btn btn-sm btn-outline-danger"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                                <tr v-if="contacts.data.length === 0">
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" class="mb-3 opacity-50">
                                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>
                                        </svg>
                                        <p class="mb-0">Нема пораки</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Pagination -->
                <div v-if="contacts.last_page > 1" class="card-footer bg-white border-top">
                    <nav class="d-flex justify-content-center">
                        <ul class="pagination pagination-sm mb-0">
                            <li v-for="link in contacts.links" :key="link.label" class="page-item" :class="{ active: link.active, disabled: !link.url }">
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
