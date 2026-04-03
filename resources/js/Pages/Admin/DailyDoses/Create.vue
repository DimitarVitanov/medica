<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import RichTextEditor from '@/Components/RichTextEditor.vue';

const activeTab = ref('mk');

const form = useForm({
    title: '',
    author: 'ПЗУ Медика',
    category: '',
    excerpt: '',
    content: '',
    title_en: '',
    excerpt_en: '',
    content_en: '',
    image: null,
    published_at: new Date().toISOString().split('T')[0],
    is_published: false,
});

const categories = ['Настан', 'Нова услуга', 'Достигнување', 'Тим', 'Пациенти', 'Друго'];

const submit = () => {
    form.post('/admin/daily-doses');
};
</script>

<template>
    <Head title="Додај Дневна Доза - Админ" />

    <AuthenticatedLayout>
        <template #header>
            <div class="d-flex align-items-center gap-3">
                <Link href="/admin/daily-doses" class="text-muted text-decoration-none">← Назад</Link>
                <h5 class="fw-bold text-dark mb-0">Додај Дневна Доза</h5>
            </div>
        </template>

        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <form @submit.prevent="submit" class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Автор *</label>
                                    <input v-model="form.author" type="text" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Категорија</label>
                                    <select v-model="form.category" class="form-select">
                                        <option value="">Без категорија</option>
                                        <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Language Tabs -->
                            <ul class="nav nav-tabs mb-3">
                                <li class="nav-item">
                                    <button type="button" class="nav-link" :class="{ active: activeTab === 'mk' }" @click="activeTab = 'mk'">
                                        🇲🇰 Македонски
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="nav-link" :class="{ active: activeTab === 'en' }" @click="activeTab = 'en'">
                                        🇬🇧 English
                                    </button>
                                </li>
                            </ul>

                            <!-- Macedonian Fields -->
                            <div v-show="activeTab === 'mk'">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Наслов *</label>
                                    <input v-model="form.title" type="text" class="form-control" :class="{ 'is-invalid': form.errors.title }" required>
                                    <div v-if="form.errors.title" class="invalid-feedback">{{ form.errors.title }}</div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Краток опис</label>
                                    <textarea v-model="form.excerpt" rows="2" class="form-control" placeholder="Краток опис за листата..."></textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Содржина *</label>
                                    <RichTextEditor v-model="form.content" />
                                </div>
                            </div>

                            <!-- English Fields -->
                            <div v-show="activeTab === 'en'">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Title (EN)</label>
                                    <input v-model="form.title_en" type="text" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Short Description (EN)</label>
                                    <textarea v-model="form.excerpt_en" rows="2" class="form-control" placeholder="Short description for listing..."></textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Content (EN)</label>
                                    <RichTextEditor v-model="form.content_en" />
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Слика</label>
                                <input type="file" @input="form.image = $event.target.files[0]" class="form-control" accept="image/*">
                                <div v-if="form.errors.image" class="text-danger small mt-1">{{ form.errors.image }}</div>
                                <small class="text-muted">Сликата автоматски ќе се конвертира во WebP формат. Макс. 10MB.</small>
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
                                <Link href="/admin/daily-doses" class="btn btn-outline-secondary">Откажи</Link>
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
