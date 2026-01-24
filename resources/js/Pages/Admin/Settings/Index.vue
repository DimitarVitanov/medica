<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    settings: Object,
});

// Helper to get setting value from grouped data
const getSetting = (group, key, defaultValue = '') => {
    const groupData = props.settings?.[group];
    if (Array.isArray(groupData)) {
        const setting = groupData.find(s => s.key === key);
        return setting?.value || defaultValue;
    }
    return defaultValue;
};

// Parse contact subjects from stored JSON or use defaults
const defaultSubjects = 'Закажување преглед,Општи информации,Поплака,Друго';
const contactSubjectsValue = getSetting('contact', 'contact_subjects', defaultSubjects);

const form = useForm({
    settings: [
        { key: 'site_name', value: getSetting('general', 'site_name', 'ПЗУ Медика'), group: 'general' },
        { key: 'site_phone', value: getSetting('general', 'site_phone', '034-360-444'), group: 'general' },
        { key: 'site_email', value: getSetting('general', 'site_email', 'info@medica.mk'), group: 'general' },
        { key: 'site_address', value: getSetting('general', 'site_address', 'ул. Вањо Китанов бр. 19, Струмица'), group: 'general' },
        { key: 'working_hours', value: getSetting('general', 'working_hours', 'Пон - Пет: 08:00 - 20:00'), group: 'general' },
        { key: 'facebook_url', value: getSetting('social', 'facebook_url', ''), group: 'social' },
        { key: 'instagram_url', value: getSetting('social', 'instagram_url', ''), group: 'social' },
        { key: 'meta_title', value: getSetting('seo', 'meta_title', 'ПЗУ Медика - Приватна Здравствена Установа'), group: 'seo' },
        { key: 'meta_description', value: getSetting('seo', 'meta_description', 'ПЗУ Медика - Приватна здравствена установа во Струмица.'), group: 'seo' },
        { key: 'meta_keywords', value: getSetting('seo', 'meta_keywords', 'медика, струмица, доктор, здравје'), group: 'seo' },
        { key: 'og_image', value: getSetting('seo', 'og_image', '/images/logo.png'), group: 'seo' },
        { key: 'contact_subjects', value: contactSubjectsValue, group: 'contact' },
        { key: 'contact_email', value: getSetting('contact', 'contact_email', 'info@medica.mk'), group: 'contact' },
    ],
});

// Contact subjects management
const subjectsList = ref(contactSubjectsValue.split(',').map(s => s.trim()).filter(Boolean));
const newSubject = ref('');

const addSubject = () => {
    if (newSubject.value.trim() && !subjectsList.value.includes(newSubject.value.trim())) {
        subjectsList.value.push(newSubject.value.trim());
        updateSubjectsValue();
        newSubject.value = '';
    }
};

const removeSubject = (index) => {
    subjectsList.value.splice(index, 1);
    updateSubjectsValue();
};

const updateSubjectsValue = () => {
    form.settings[11].value = subjectsList.value.join(',');
};

const submit = () => {
    form.post('/admin/settings');
};
</script>

<template>
    <Head title="Поставки - Админ" />

    <AuthenticatedLayout>
        <template #header>
            <div class="header-content">
                <h1 class="page-title">Поставки</h1>
                <p class="page-subtitle">Конфигурирајте ги основните поставки на сајтот</p>
            </div>
        </template>

        <div class="settings-grid">
            <form @submit.prevent="submit">
                <!-- General Settings -->
                <div class="settings-card">
                    <div class="card-header">
                        <h2>Општи поставки</h2>
                        <p>Основни информации за вашата установа</p>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <label>Име на сајтот</label>
                            <input v-model="form.settings[0].value" type="text" class="input">
                        </div>
                        <div class="form-row">
                            <label>Телефон</label>
                            <input v-model="form.settings[1].value" type="text" class="input">
                        </div>
                        <div class="form-row">
                            <label>Е-пошта</label>
                            <input v-model="form.settings[2].value" type="email" class="input">
                        </div>
                        <div class="form-row">
                            <label>Адреса</label>
                            <input v-model="form.settings[3].value" type="text" class="input">
                        </div>
                        <div class="form-row">
                            <label>Работно време</label>
                            <input v-model="form.settings[4].value" type="text" class="input">
                        </div>
                    </div>
                </div>

                <!-- Social Settings -->
                <div class="settings-card">
                    <div class="card-header">
                        <h2>Социјални мрежи</h2>
                        <p>Линкови до вашите профили</p>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <label>Facebook URL</label>
                            <input v-model="form.settings[5].value" type="url" class="input" placeholder="https://facebook.com/...">
                        </div>
                        <div class="form-row">
                            <label>Instagram URL</label>
                            <input v-model="form.settings[6].value" type="url" class="input" placeholder="https://instagram.com/...">
                        </div>
                    </div>
                </div>

                <!-- SEO Settings -->
                <div class="settings-card">
                    <div class="card-header">
                        <h2>SEO / Мета тагови</h2>
                        <p>Оптимизација за пребарувачи</p>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <label>Мета наслов</label>
                            <input v-model="form.settings[7].value" type="text" class="input">
                            <span class="hint">Се прикажува во табот и во резултатите од пребарување</span>
                        </div>
                        <div class="form-row">
                            <label>Мета опис</label>
                            <textarea v-model="form.settings[8].value" rows="3" class="input"></textarea>
                            <span class="hint">Препорачано 150-160 карактери</span>
                        </div>
                        <div class="form-row">
                            <label>Клучни зборови</label>
                            <input v-model="form.settings[9].value" type="text" class="input">
                            <span class="hint">Одделени со запирка</span>
                        </div>
                        <div class="form-row">
                            <label>OG слика</label>
                            <input v-model="form.settings[10].value" type="text" class="input" placeholder="/images/logo.png">
                        </div>
                    </div>
                </div>

                <!-- Contact Form Settings -->
                <div class="settings-card">
                    <div class="card-header">
                        <h2>Контакт форма</h2>
                        <p>Поставки за контакт формата на сајтот</p>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <label>Е-пошта за примање пораки</label>
                            <input v-model="form.settings[12].value" type="email" class="input" placeholder="info@medica.mk">
                            <span class="hint">На оваа адреса ќе се испраќаат пораките од контакт формата</span>
                        </div>
                        <div class="form-row">
                            <label>Теми за избор</label>
                            <div class="subjects-list">
                                <div v-for="(subject, index) in subjectsList" :key="index" class="subject-tag">
                                    <span>{{ subject }}</span>
                                    <button type="button" @click="removeSubject(index)" class="remove-btn">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                    </button>
                                </div>
                            </div>
                            <div class="add-subject">
                                <input v-model="newSubject" type="text" class="input" placeholder="Нова тема..." @keyup.enter="addSubject">
                                <button type="button" @click="addSubject" class="btn-add">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                    Додај
                                </button>
                            </div>
                            <span class="hint">Овие теми ќе се прикажуваат како избор во контакт формата</span>
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                <div class="form-actions">
                    <button type="submit" :disabled="form.processing" class="btn-save">
                        <svg v-if="!form.processing" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        <span v-if="form.processing" class="spinner"></span>
                        Зачувај поставки
                    </button>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.header-content {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.page-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
}

.page-subtitle {
    font-size: 0.875rem;
    color: #64748b;
    margin: 0;
}

.settings-grid {
    max-width: 800px;
}

.settings-card {
    background: #fff;
    border-radius: 16px;
    margin-bottom: 1.5rem;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05), 0 4px 12px rgba(102, 126, 234, 0.08);
}

.card-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #f1f5f9;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
}

.card-header h2 {
    font-size: 1rem;
    font-weight: 600;
    color: #1e293b;
    margin: 0 0 0.25rem;
}

.card-header p {
    font-size: 0.8rem;
    color: #64748b;
    margin: 0;
}

.card-body {
    padding: 1.5rem;
}

.form-row {
    margin-bottom: 1.25rem;
}

.form-row:last-child {
    margin-bottom: 0;
}

.form-row label {
    display: block;
    font-size: 0.8rem;
    font-weight: 600;
    color: #475569;
    margin-bottom: 0.5rem;
}

.input {
    width: 100%;
    padding: 0.75rem 1rem;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    color: #1e293b;
    font-size: 0.9rem;
    transition: all 0.2s;
}

.input:focus {
    outline: none;
    background: #fff;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15);
}

.input::placeholder {
    color: #94a3b8;
}

textarea.input {
    resize: vertical;
    min-height: 80px;
}

.hint {
    display: block;
    font-size: 0.7rem;
    color: #94a3b8;
    margin-top: 0.5rem;
}

.form-actions {
    display: flex;
    justify-content: flex-end;
    padding-top: 0.5rem;
}

.btn-save {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 10px;
    color: #fff;
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.btn-save svg {
    width: 18px;
    height: 18px;
}

.btn-save:hover {
    transform: translateY(-1px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
}

.btn-save:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none;
}

.spinner {
    width: 18px;
    height: 18px;
    border: 2px solid rgba(255,255,255,0.3);
    border-top-color: #fff;
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* Contact Form Subjects */
.subjects-list {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-bottom: 0.75rem;
}

.subject-tag {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0.75rem;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    border: 1px solid rgba(102, 126, 234, 0.2);
    border-radius: 8px;
    font-size: 0.85rem;
    color: #475569;
}

.subject-tag .remove-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 18px;
    height: 18px;
    padding: 0;
    background: rgba(239, 68, 68, 0.1);
    border: none;
    border-radius: 4px;
    color: #ef4444;
    cursor: pointer;
    transition: all 0.2s;
}

.subject-tag .remove-btn:hover {
    background: #ef4444;
    color: #fff;
}

.subject-tag .remove-btn svg {
    width: 12px;
    height: 12px;
}

.add-subject {
    display: flex;
    gap: 0.5rem;
}

.add-subject .input {
    flex: 1;
}

.btn-add {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.75rem 1rem;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    border: none;
    border-radius: 10px;
    color: #fff;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    white-space: nowrap;
}

.btn-add:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

.btn-add svg {
    width: 16px;
    height: 16px;
}
</style>
