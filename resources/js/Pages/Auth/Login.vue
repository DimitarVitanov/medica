<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Најава - Админ" />

        <div class="text-center mb-4">
            <h4 class="fw-bold text-dark mb-1">Добредојдовте</h4>
            <p class="text-muted small">Најавете се во админ панелот</p>
        </div>

        <div v-if="status" class="alert alert-success small" role="alert">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div class="mb-3">
                <label for="email" class="form-label small fw-semibold">Е-пошта</label>
                <input 
                    id="email"
                    type="email"
                    class="form-control form-control-lg"
                    :class="{ 'is-invalid': form.errors.email }"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="admin@medica.mk"
                >
                <div v-if="form.errors.email" class="invalid-feedback">
                    {{ form.errors.email }}
                </div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label small fw-semibold">Лозинка</label>
                <input 
                    id="password"
                    type="password"
                    class="form-control form-control-lg"
                    :class="{ 'is-invalid': form.errors.password }"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                    placeholder="••••••••"
                >
                <div v-if="form.errors.password" class="invalid-feedback">
                    {{ form.errors.password }}
                </div>
            </div>

            <div class="mb-4">
                <div class="form-check">
                    <input 
                        type="checkbox" 
                        class="form-check-input" 
                        id="remember"
                        v-model="form.remember"
                    >
                    <label class="form-check-label small" for="remember">
                        Запомни ме
                    </label>
                </div>
            </div>

            <div class="d-grid">
                <button 
                    type="submit" 
                    class="btn btn-purple btn-lg"
                    :disabled="form.processing"
                >
                    <span v-if="form.processing" class="spinner-border spinner-border-sm me-2" role="status"></span>
                    Најави се
                </button>
            </div>
        </form>
    </GuestLayout>
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

.btn-purple:disabled {
    opacity: 0.7;
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
