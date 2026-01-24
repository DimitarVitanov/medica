<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref } from 'vue';

const props = defineProps({
    service: Object,
});

const form = useForm({
    title: props.service.title,
    short_description: props.service.short_description || '',
    description: props.service.description || '',
    features: props.service.features || [],
    icon: props.service.icon || '',
    color: props.service.color || '#6B4C9A',
    image: null,
    order: props.service.order || 0,
    is_active: props.service.is_active,
});

const newFeature = ref('');

const addFeature = () => {
    if (newFeature.value.trim()) {
        form.features.push(newFeature.value.trim());
        newFeature.value = '';
    }
};

const removeFeature = (index) => {
    form.features.splice(index, 1);
};

const submit = () => {
    form.post(`/admin/services/${props.service.id}`, {
        _method: 'PUT',
    });
};
</script>

<template>
    <Head title="Уреди Услуга - Админ" />

    <AuthenticatedLayout>
        <template #header>
            <div class="d-flex align-items-center gap-3">
                <Link href="/admin/services" class="text-muted text-decoration-none">← Назад</Link>
                <h5 class="fw-bold text-dark mb-0">Уреди: {{ service.title }}</h5>
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

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Краток опис</label>
                                <input v-model="form.short_description" type="text" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Опис</label>
                                <textarea v-model="form.description" rows="5" class="form-control"></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Карактеристики</label>
                                <div class="input-group mb-2">
                                    <input v-model="newFeature" type="text" class="form-control" placeholder="Додај карактеристика..." @keyup.enter.prevent="addFeature">
                                    <button type="button" @click="addFeature" class="btn btn-purple">+</button>
                                </div>
                                <ul class="list-group">
                                    <li v-for="(feature, index) in form.features" :key="index" class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ feature }}
                                        <button type="button" @click="removeFeature(index)" class="btn btn-sm btn-outline-danger">×</button>
                                    </li>
                                </ul>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Боја</label>
                                    <input v-model="form.color" type="color" class="form-control form-control-color w-100" style="height: 42px;">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Редослед</label>
                                    <input v-model="form.order" type="number" class="form-control">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Слика</label>
                                <input type="file" @input="form.image = $event.target.files[0]" class="form-control">
                                <small v-if="service.image" class="text-muted">Тековна: {{ service.image }}</small>
                            </div>

                            <div class="mb-4">
                                <div class="form-check">
                                    <input v-model="form.is_active" type="checkbox" class="form-check-input" id="is_active">
                                    <label class="form-check-label" for="is_active">Активна</label>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                                <Link href="/admin/services" class="btn btn-outline-secondary">Откажи</Link>
                                <button type="submit" :disabled="form.processing" class="btn btn-purple">
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
.btn-purple {
    background: linear-gradient(135deg, #6B4C9A 0%, #8B6BAE 100%);
    color: white;
    border: none;
}

.btn-purple:hover {
    background: linear-gradient(135deg, #5B3C8A 0%, #7B5B9E 100%);
    color: white;
}

.form-control:focus {
    border-color: #8B6BAE;
    box-shadow: 0 0 0 0.25rem rgba(107, 76, 154, 0.25);
}

.form-check-input:checked {
    background-color: #6B4C9A;
    border-color: #6B4C9A;
}
</style>
