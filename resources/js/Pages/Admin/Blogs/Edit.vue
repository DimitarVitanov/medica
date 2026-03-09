<script setup>
import { ref, computed } from 'vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    blog: Object,
});

const formatDate = (date) => {
    if (!date) return new Date().toISOString().split('T')[0];
    return new Date(date).toISOString().split('T')[0];
};

const form = useForm({
    title: props.blog.title,
    author: props.blog.author,
    category: props.blog.category,
    excerpt: props.blog.excerpt || '',
    content: props.blog.content,
    image: null,
    published_at: formatDate(props.blog.published_at),
    is_published: props.blog.is_published,
});

const categories = ['Здравје', 'Естетика', 'Дијагностика', 'Известувања', 'Совети'];

const converting = ref(false);

const isWebp = computed(() => {
    return props.blog.image && props.blog.image.toLowerCase().endsWith('.webp');
});

const imageUrl = computed(() => {
    if (!props.blog.image) return null;
    return `/storage/${props.blog.image}`;
});

const submit = () => {
    form.post(`/admin/blogs/${props.blog.id}/update`);
};

const convertToWebp = () => {
    converting.value = true;
    router.post(`/admin/blogs/${props.blog.id}/convert-image`, {}, {
        preserveScroll: true,
        onFinish: () => { converting.value = false; },
    });
};
</script>

<template>
    <Head title="Уреди Блог - Админ" />

    <AuthenticatedLayout>
        <template #header>
            <div class="d-flex align-items-center gap-3">
                <Link href="/admin/blogs" class="text-muted text-decoration-none">← Назад</Link>
                <h5 class="fw-bold text-dark mb-0">Уреди: {{ blog.title }}</h5>
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
                                <textarea v-model="form.excerpt" rows="2" class="form-control"></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Содржина *</label>
                                <textarea v-model="form.content" rows="10" class="form-control" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Слика</label>
                                <input type="file" @input="form.image = $event.target.files[0]" class="form-control" accept="image/*">
                                <div v-if="form.errors.image" class="text-danger small mt-1">{{ form.errors.image }}</div>

                                <!-- Current Image Preview -->
                                <div v-if="blog.image" class="mt-3 p-3 bg-light rounded">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <small class="text-muted fw-semibold">Тековна слика:</small>
                                        <span class="badge" :class="isWebp ? 'bg-success' : 'bg-warning text-dark'">
                                            {{ isWebp ? 'WebP' : blog.image.split('.').pop().toUpperCase() }}
                                        </span>
                                    </div>
                                    <img :src="imageUrl" :alt="blog.title" class="img-fluid rounded mb-2" style="max-height: 200px;">
                                    <div class="d-flex align-items-center gap-2 mt-2">
                                        <small class="text-muted text-truncate flex-grow-1">{{ blog.image }}</small>
                                        <button
                                            v-if="!isWebp"
                                            type="button"
                                            @click="convertToWebp"
                                            :disabled="converting"
                                            class="btn btn-sm btn-outline-success flex-shrink-0"
                                        >
                                            <span v-if="converting" class="spinner-border spinner-border-sm me-1"></span>
                                            {{ converting ? 'Конвертирање...' : 'Конвертирај во WebP' }}
                                        </button>
                                    </div>
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
                                        <label class="form-check-label" for="is_published">Објавен</label>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                                <Link href="/admin/blogs" class="btn btn-outline-secondary">Откажи</Link>
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
