<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref } from 'vue';

const form = useForm({
    title: '',
    short_description: '',
    description: '',
    features: [],
    icon: '',
    color: '#6B4C9A',
    image: null,
    order: 0,
    is_active: true,
    // English translations
    title_en: '',
    short_description_en: '',
    description_en: '',
    features_en: [],
});

const activeTab = ref('mk');
const newFeature = ref('');
const newFeatureEn = ref('');

const addFeature = () => {
    if (newFeature.value.trim()) {
        form.features.push(newFeature.value.trim());
        newFeature.value = '';
    }
};

const removeFeature = (index) => {
    form.features.splice(index, 1);
};

const addFeatureEn = () => {
    if (newFeatureEn.value.trim()) {
        form.features_en.push(newFeatureEn.value.trim());
        newFeatureEn.value = '';
    }
};

const removeFeatureEn = (index) => {
    form.features_en.splice(index, 1);
};

const submit = () => {
    form.post('/admin/services');
};
</script>

<template>
    <Head title="Додај Услуга - Админ" />

    <AuthenticatedLayout>
        <template #header>
            <div class="d-flex align-items-center gap-3">
                <Link href="/admin/services" class="text-muted text-decoration-none">← Назад</Link>
                <h5 class="fw-bold text-dark mb-0">Додај Услуга</h5>
            </div>
        </template>

        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <form @submit.prevent="submit" class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <!-- Language Tabs -->
                            <ul class="nav nav-tabs mb-4">
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
                            </div>

                            <!-- English Fields -->
                            <div v-show="activeTab === 'en'">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Title (English)</label>
                                    <input v-model="form.title_en" type="text" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Short Description (English)</label>
                                    <input v-model="form.short_description_en" type="text" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Description (English)</label>
                                    <textarea v-model="form.description_en" rows="5" class="form-control"></textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Features (English)</label>
                                    <div class="input-group mb-2">
                                        <input v-model="newFeatureEn" type="text" class="form-control" placeholder="Add feature..." @keyup.enter.prevent="addFeatureEn">
                                        <button type="button" @click="addFeatureEn" class="btn btn-purple">+</button>
                                    </div>
                                    <ul class="list-group">
                                        <li v-for="(feature, index) in form.features_en" :key="index" class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ feature }}
                                            <button type="button" @click="removeFeatureEn(index)" class="btn btn-sm btn-outline-danger">×</button>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Common Fields (always visible) -->
                            <hr class="my-4">

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
