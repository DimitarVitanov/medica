<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const form = useForm({
    title: '',
    subtitle: '',
    description: '',
    image: null,
    button_text: 'Закажи термин',
    button_link: '/contact',
    button2_text: 'Повеќе информации',
    button2_link: '/services',
    order: 0,
    is_active: true,
});

const submit = () => {
    form.post('/admin/sliders');
};
</script>

<template>
    <Head title="Додај Слајдер - Админ" />

    <AuthenticatedLayout>
        <template #header>
            <div class="d-flex align-items-center gap-3">
                <Link href="/admin/sliders" class="text-muted text-decoration-none">← Назад</Link>
                <h5 class="fw-bold text-dark mb-0">Додај Слајдер</h5>
            </div>
        </template>

        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <form @submit.prevent="submit" class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Наслов *</label>
                                <input v-model="form.title" type="text" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Поднаслов</label>
                                <input v-model="form.subtitle" type="text" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Опис</label>
                                <textarea v-model="form.description" rows="3" class="form-control"></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Слика</label>
                                <input type="file" @input="form.image = $event.target.files[0]" class="form-control">
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Копче 1 - Текст</label>
                                    <input v-model="form.button_text" type="text" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Копче 1 - Линк</label>
                                    <input v-model="form.button_link" type="text" class="form-control">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Копче 2 - Текст</label>
                                    <input v-model="form.button2_text" type="text" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Копче 2 - Линк</label>
                                    <input v-model="form.button2_link" type="text" class="form-control">
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Редослед</label>
                                    <input v-model="form.order" type="number" class="form-control">
                                </div>
                                <div class="col-md-6 d-flex align-items-end">
                                    <div class="form-check">
                                        <input v-model="form.is_active" type="checkbox" class="form-check-input" id="is_active">
                                        <label class="form-check-label" for="is_active">Активен</label>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                                <Link href="/admin/sliders" class="btn btn-outline-secondary">Откажи</Link>
                                <button type="submit" :disabled="form.processing" class="btn btn-warning">
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
