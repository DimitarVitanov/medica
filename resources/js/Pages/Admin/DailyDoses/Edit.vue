<script setup>
import { ref, computed } from 'vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import RichTextEditor from '@/Components/RichTextEditor.vue';

const props = defineProps({
    dose: Object,
});

const formatDate = (date) => {
    if (!date) return new Date().toISOString().split('T')[0];
    return new Date(date).toISOString().split('T')[0];
};

const form = useForm({
    title: props.dose.title,
    author: props.dose.author || 'ПЗУ Медика',
    category: props.dose.category || '',
    excerpt: props.dose.excerpt || '',
    content: props.dose.content,
    image: null,
    published_at: formatDate(props.dose.published_at),
    is_published: props.dose.is_published,
});

const categories = ['Настан', 'Нова услуга', 'Достигнување', 'Тим', 'Пациенти', 'Друго'];

const imageUrl = computed(() => {
    if (!props.dose.image) return null;
    return `/storage/${props.dose.image}`;
});

const submit = () => {
    form.post(`/admin/daily-doses/${props.dose.id}/update`);
};
</script>

<template>
    <Head title="Уреди Дневна Доза - Админ" />

    <AuthenticatedLayout>
        <template #header>
            <div class="d-flex align-items-center gap-3">
                <Link href="/admin/daily-doses" class="text-muted text-decoration-none">← Назад</Link>
                <h5 class="fw-bold text-dark mb-0">Уреди: {{ dose.title }}</h5>
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
                                    <label class="form-label fw-semibold">Категорија</label>
                                    <select v-model="form.category" class="form-select">
                                        <option value="">Без категорија</option>
                                        <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Краток опис</label>
                                <textarea v-model="form.excerpt" rows="2" class="form-control"></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Содржина *</label>
                                <RichTextEditor v-model="form.content" />
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Слика</label>
                                <input type="file" @input="form.image = $event.target.files[0]" class="form-control" accept="image/*">
                                <div v-if="form.errors.image" class="text-danger small mt-1">{{ form.errors.image }}</div>

                                <div v-if="dose.image" class="mt-3 p-3 bg-light rounded">
                                    <small class="text-muted fw-semibold d-block mb-2">Тековна слика:</small>
                                    <img :src="imageUrl" :alt="dose.title" class="img-fluid rounded" style="max-height: 200px;">
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Датум на објава</label>
                                    <input v-model="form.published_at" type="date" class="form-control">
                                </div>
                                <div class="col-md-6 d-flex align-items-end">
                                    <div class="form-check">
                                        <input v-model="form.is_published" type="checkbox" class="form-check-input" id="is_published">
                                        <label class="form-check-label" for="is_published">Објавена</label>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                                <Link href="/admin/daily-doses" class="btn btn-outline-secondary">Откажи</Link>
                                <button type="submit" :disabled="form.processing" class="btn btn-primary">
                                    <span v-if="form.processing" class="spinner-border spinner-border-sm me-2"></span>
                                    Ажурирај
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
