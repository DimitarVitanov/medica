<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    category: Object,
});

const form = useForm({
    name: '',
    name_en: '',
    price: '',
    order: 0,
    is_active: true,
});

const submit = () => {
    form.post(`/admin/lab-analyses/categories/${props.category.id}/analyses`);
};
</script>

<template>
    <Head title="Додај анализа - Админ" />

    <AuthenticatedLayout>
        <template #header>
            <div class="header-wrapper">
                <div class="header-content">
                    <h1 class="page-title">Додај анализа</h1>
                    <p class="page-subtitle">Категорија: {{ category.name }}</p>
                </div>
                <Link href="/admin/lab-analyses" class="btn-back">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                    Назад
                </Link>
            </div>
        </template>

        <div class="form-card">
            <form @submit.prevent="submit">
                <div class="form-group">
                    <label class="form-label">Име на анализа (МК) *</label>
                    <input v-model="form.name" type="text" class="form-input" placeholder="пр. Витамин Д" />
                    <div v-if="form.errors.name" class="form-error">{{ form.errors.name }}</div>
                </div>

                <div class="form-group">
                    <label class="form-label">Име на анализа (EN)</label>
                    <input v-model="form.name_en" type="text" class="form-input" placeholder="e.g. Vitamin D" />
                    <div v-if="form.errors.name_en" class="form-error">{{ form.errors.name_en }}</div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Цена (ден.) *</label>
                        <input v-model="form.price" type="number" step="0.01" min="0" class="form-input" placeholder="пр. 100" />
                        <div v-if="form.errors.price" class="form-error">{{ form.errors.price }}</div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Редослед</label>
                        <input v-model="form.order" type="number" class="form-input" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Статус</label>
                    <label class="toggle-label">
                        <input v-model="form.is_active" type="checkbox" class="toggle-input" />
                        <span class="toggle-switch"></span>
                        <span>{{ form.is_active ? 'Активна' : 'Неактивна' }}</span>
                    </label>
                </div>

                <div class="form-actions">
                    <Link href="/admin/lab-analyses" class="btn-cancel">Откажи</Link>
                    <button type="submit" :disabled="form.processing" class="btn-submit">
                        {{ form.processing ? 'Се зачувува...' : 'Зачувај' }}
                    </button>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.header-wrapper { display: flex; align-items: center; justify-content: space-between; width: 100%; }
.header-content { display: flex; flex-direction: column; gap: 0.25rem; }
.page-title { font-size: 1.5rem; font-weight: 700; color: #1e293b; margin: 0; }
.page-subtitle { font-size: 0.875rem; color: #64748b; margin: 0; }
.btn-back { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1rem; color: #64748b; font-size: 0.875rem; font-weight: 500; border-radius: 8px; text-decoration: none; background: #f1f5f9; transition: all 0.2s; }
.btn-back:hover { background: #e2e8f0; color: #1e293b; }

.form-card { background: #fff; border-radius: 16px; padding: 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.05), 0 4px 12px rgba(102,126,234,0.08); max-width: 640px; }
.form-group { margin-bottom: 1.5rem; }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
.form-label { display: block; font-size: 0.8rem; font-weight: 600; color: #475569; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px; }
.form-input { width: 100%; padding: 0.75rem 1rem; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 0.95rem; transition: all 0.2s; background: #f8fafc; }
.form-input:focus { outline: none; border-color: #667eea; background: #fff; box-shadow: 0 0 0 4px rgba(102,126,234,0.1); }
.form-error { color: #ef4444; font-size: 0.8rem; margin-top: 0.25rem; }

.toggle-label { display: flex; align-items: center; gap: 0.75rem; cursor: pointer; padding: 0.75rem 0; }
.toggle-input { display: none; }
.toggle-switch { width: 44px; height: 24px; background: #cbd5e1; border-radius: 12px; position: relative; transition: all 0.3s; flex-shrink: 0; }
.toggle-switch::after { content: ''; width: 20px; height: 20px; background: #fff; border-radius: 50%; position: absolute; top: 2px; left: 2px; transition: all 0.3s; }
.toggle-input:checked + .toggle-switch { background: #667eea; }
.toggle-input:checked + .toggle-switch::after { left: 22px; }

.form-actions { display: flex; justify-content: flex-end; gap: 1rem; padding-top: 1rem; border-top: 1px solid #f1f5f9; }
.btn-cancel { padding: 0.625rem 1.25rem; color: #64748b; font-size: 0.875rem; font-weight: 500; border-radius: 10px; text-decoration: none; background: #f1f5f9; transition: all 0.2s; }
.btn-cancel:hover { background: #e2e8f0; }
.btn-submit { padding: 0.625rem 1.5rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; font-size: 0.875rem; font-weight: 600; border: none; border-radius: 10px; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 15px rgba(102,126,234,0.3); }
.btn-submit:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(102,126,234,0.4); }
.btn-submit:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }

@media (max-width: 768px) { .form-row { grid-template-columns: 1fr; } .header-wrapper { flex-direction: column; align-items: flex-start; gap: 1rem; } }
</style>
