<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const form = useForm({
    title: '',
    author: '',
    category: '',
    excerpt: '',
    content: '',
    image: null,
    published_at: new Date().toISOString().split('T')[0],
    is_published: false,
});

const categories = ['Здравје', 'Естетика', 'Дијагностика', 'Известувања', 'Совети'];

const submit = () => {
    form.post('/admin/blogs');
};
</script>

<template>
    <Head title="Додај Блог - Админ" />

    <AuthenticatedLayout>
        <template #header>
            <div class="d-flex align-items-center gap-3">
                <Link href="/admin/blogs" class="text-muted text-decoration-none">← Назад</Link>
                <h5 class="fw-bold text-dark mb-0">Додај Блог</h5>
            </div>
        </template>

        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <form @submit.prevent="submit" class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Наслов *</label>
                                <input v-model="form.title" type="text" class="form-control" :class="{ 'is-invalid': form.errors.title }" required>
                                <div v-if="form.errors.title" class="invalid-feedback">{{ form.errors.title }}</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Автор *</label>
                                    <input v-model="form.author" type="text" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Категорија *</label>
                                    <select v-model="form.category" class="form-select" required>
                                        <option value="" disabled>Избери категорија</option>
                                        <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Краток опис</label>
                                <textarea v-model="form.excerpt" rows="2" class="form-control" placeholder="Краток опис за листата..."></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Содржина *</label>
                                <textarea v-model="form.content" rows="10" class="form-control" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Слика</label>
                                <input type="file" @input="form.image = $event.target.files[0]" class="form-control" accept="image/*">
                                <div v-if="form.errors.image" class="text-danger small mt-1">{{ form.errors.image }}</div>
                                <small class="text-muted">Сликата автоматски ќе се конвертира во WebP формат.</small>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Датум на објава</label>
                                    <input v-model="form.published_at" type="date" class="form-control">
                                </div>
                                <div class="col-md-6 d-flex align-items-end">
                                    <div class="form-check">
                                        <input v-model="form.is_published" type="checkbox" class="form-check-input" id="is_published">
                                        <label class="form-check-label" for="is_published">Објави веднаш</label>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                                <Link href="/admin/blogs" class="btn btn-outline-secondary">Откажи</Link>
                                <button type="submit" :disabled="form.processing" class="btn btn-primary">
                                    <span v-if="form.processing" class="spinner-border spinner-border-sm me-2"></span>
                                    Зачувај
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.form-control:focus, .form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.form-check-input:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
}
</style>
