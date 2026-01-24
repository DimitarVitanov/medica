<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    contact: Object,
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

const deleteContact = () => {
    if (confirm('Дали сте сигурни дека сакате да ја избришете оваа порака?')) {
        router.delete(`/admin/contacts/${props.contact.id}`);
    }
};
</script>

<template>
    <Head :title="`Порака: ${contact.subject}`" />
    
    <AuthenticatedLayout>
        <template #header>
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="h4 mb-1 text-white">{{ contact.subject }}</h2>
                    <p class="text-white-50 mb-0 small">
                        Од: {{ contact.name }} &bull; {{ formatDate(contact.created_at) }}
                    </p>
                </div>
                <div class="d-flex gap-2">
                    <Link href="/admin/contacts" class="btn btn-outline-light btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-1">
                            <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
                        </svg>
                        Назад
                    </Link>
                    <button @click="deleteContact" class="btn btn-danger btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-1">
                            <polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                        </svg>
                        Избриши
                    </button>
                </div>
            </div>
        </template>
        
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="mb-4 pb-3 border-bottom">
                                <h5 class="mb-3">{{ contact.subject }}</h5>
                                <div class="d-flex gap-4 text-muted small">
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-1">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                                        </svg>
                                        {{ contact.name }}
                                    </span>
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-1">
                                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>
                                        </svg>
                                        {{ contact.email }}
                                    </span>
                                    <span v-if="contact.phone">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-1">
                                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                                        </svg>
                                        {{ contact.phone }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="message-content" style="white-space: pre-wrap;">{{ contact.message }}</div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom">
                            <h6 class="mb-0">Информации</h6>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-3">
                                    <small class="text-muted d-block">Статус</small>
                                    <span v-if="contact.is_read" class="badge bg-success">Прочитано</span>
                                    <span v-else class="badge bg-primary">Непрочитано</span>
                                </li>
                                <li class="mb-3">
                                    <small class="text-muted d-block">Примено</small>
                                    <span>{{ formatDate(contact.created_at) }}</span>
                                </li>
                                <li v-if="contact.read_at" class="mb-3">
                                    <small class="text-muted d-block">Прочитано на</small>
                                    <span>{{ formatDate(contact.read_at) }}</span>
                                </li>
                            </ul>
                            
                            <hr>
                            
                            <div class="d-grid gap-2">
                                <a :href="`mailto:${contact.email}?subject=Re: ${contact.subject}`" class="btn btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-1">
                                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>
                                    </svg>
                                    Одговори по е-пошта
                                </a>
                                <a v-if="contact.phone" :href="`tel:${contact.phone}`" class="btn btn-outline-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-1">
                                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                                    </svg>
                                    Јави се
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.message-content {
    font-size: 1rem;
    line-height: 1.7;
    color: #374151;
}
</style>
