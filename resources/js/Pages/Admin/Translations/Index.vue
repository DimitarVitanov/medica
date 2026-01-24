<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, computed } from 'vue';

const props = defineProps({
    services: Array,
    blogs: Array,
    sliders: Array,
    sections: Array,
    locales: Array,
});

const activeTab = ref('services');
const activeLocale = ref('en');

const tabs = [
    { key: 'services', label: 'Услуги', icon: '🏥' },
    { key: 'blogs', label: 'Блогови', icon: '📰' },
    { key: 'sliders', label: 'Слајдери', icon: '🖼️' },
    { key: 'sections', label: 'Секции', icon: '📄' },
];

const translatableFields = {
    services: ['title', 'short_description', 'description'],
    blogs: ['title', 'excerpt', 'content'],
    sliders: ['title', 'subtitle', 'description', 'button_text', 'button2_text'],
    sections: ['title', 'content', 'data.address', 'data.lead_text', 'data.description', 'data.additional_text'],
};

const fieldLabels = {
    title: 'Наслов',
    short_description: 'Краток опис',
    description: 'Опис',
    excerpt: 'Извадок',
    content: 'Содржина',
    subtitle: 'Поднаслов',
    button_text: 'Текст на копче',
    button2_text: 'Текст на копче 2',
    'data.address': 'Адреса',
    'data.lead_text': 'Воведен текст',
    'data.description': 'Опис',
    'data.additional_text': 'Дополнителен текст',
};

const currentItems = computed(() => {
    return props[activeTab.value] || [];
});

const currentFields = computed(() => {
    return translatableFields[activeTab.value] || [];
});

const form = useForm({
    translations: [],
});

const getTranslation = (item, field, locale) => {
    if (!item.translations) return '';
    const trans = item.translations.find(t => t.field === field && t.locale === locale);
    return trans?.value || '';
};

const getOriginalValue = (item, field) => {
    if (field.startsWith('data.')) {
        const dataField = field.replace('data.', '');
        return item.data?.[dataField] || '';
    }
    return item[field] || '';
};

const saveTranslation = (item, field, value) => {
    const modelType = {
        services: 'App\\Models\\Service',
        blogs: 'App\\Models\\Blog',
        sliders: 'App\\Models\\Slider',
        sections: 'App\\Models\\Section',
    }[activeTab.value];

    form.translations = [{
        translatable_type: modelType,
        translatable_id: item.id,
        locale: activeLocale.value,
        field: field,
        value: value,
    }];

    form.post('/admin/translations/bulk', {
        preserveScroll: true,
        onSuccess: () => {
            // Update local state
            if (!item.translations) item.translations = [];
            const existing = item.translations.find(t => t.field === field && t.locale === activeLocale.value);
            if (existing) {
                existing.value = value;
            } else {
                item.translations.push({ field, locale: activeLocale.value, value });
            }
        },
    });
};

const debounce = (fn, delay) => {
    let timeout;
    return (...args) => {
        clearTimeout(timeout);
        timeout = setTimeout(() => fn(...args), delay);
    };
};

const debouncedSave = debounce(saveTranslation, 800);
</script>

<template>
    <Head title="Преводи - Админ" />

    <AuthenticatedLayout>
        <template #header>
            <div class="header-content">
                <h1 class="page-title">Преводи</h1>
                <p class="page-subtitle">Преведете ги содржините на англиски јазик</p>
            </div>
        </template>

        <div class="translations-page">
            <!-- Tabs -->
            <div class="tabs-wrapper">
                <div class="tabs">
                    <button 
                        v-for="tab in tabs" 
                        :key="tab.key"
                        @click="activeTab = tab.key"
                        class="tab-btn"
                        :class="{ active: activeTab === tab.key }"
                    >
                        <span class="tab-icon">{{ tab.icon }}</span>
                        <span class="tab-label">{{ tab.label }}</span>
                    </button>
                </div>
                
                <div class="locale-switch">
                    <span class="locale-label">Преведи на:</span>
                    <div class="locale-btns">
                        <button 
                            v-for="locale in locales.filter(l => l !== 'mk')" 
                            :key="locale"
                            @click="activeLocale = locale"
                            class="locale-btn"
                            :class="{ active: activeLocale === locale }"
                        >
                            {{ locale === 'en' ? '🇬🇧 English' : locale.toUpperCase() }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="content-area">
                <div v-if="currentItems.length === 0" class="empty-state">
                    <p>Нема содржини за превод</p>
                </div>

                <div v-else class="items-list">
                    <div v-for="item in currentItems" :key="item.id" class="item-card">
                        <div class="item-header">
                            <h3 class="item-title">{{ item.title || item.key }}</h3>
                            <span class="item-id">#{{ item.id }}</span>
                        </div>
                        
                        <div class="fields-grid">
                            <div v-for="field in currentFields" :key="field" class="field-row">
                                <div class="field-original">
                                    <label class="field-label">
                                        {{ fieldLabels[field] }} (МК)
                                    </label>
                                    <div class="field-value">{{ getOriginalValue(item, field) || '-' }}</div>
                                </div>
                                
                                <div class="field-arrow">→</div>
                                
                                <div class="field-translation">
                                    <label class="field-label">
                                        {{ fieldLabels[field] }} ({{ activeLocale.toUpperCase() }})
                                    </label>
                                    <textarea 
                                        v-if="field === 'content' || field === 'description' || field === 'data.description' || field === 'data.additional_text'"
                                        :value="getTranslation(item, field, activeLocale)"
                                        @input="debouncedSave(item, field, $event.target.value)"
                                        class="field-input textarea"
                                        :placeholder="`Превод на ${fieldLabels[field].toLowerCase()}...`"
                                        rows="3"
                                    ></textarea>
                                    <input 
                                        v-else
                                        type="text"
                                        :value="getTranslation(item, field, activeLocale)"
                                        @input="debouncedSave(item, field, $event.target.value)"
                                        class="field-input"
                                        :placeholder="`Превод на ${fieldLabels[field].toLowerCase()}...`"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.header-content { display: flex; flex-direction: column; gap: 0.25rem; }
.page-title { font-size: 1.5rem; font-weight: 700; color: #1e293b; margin: 0; }
.page-subtitle { font-size: 0.875rem; color: #64748b; margin: 0; }

.translations-page {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.tabs-wrapper {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    flex-wrap: wrap;
}

.tabs {
    display: flex;
    gap: 0.5rem;
    background: #fff;
    padding: 0.5rem;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}

.tab-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 1rem;
    background: transparent;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s;
    font-size: 0.875rem;
    font-weight: 500;
    color: #64748b;
}

.tab-btn:hover {
    background: #f8fafc;
    color: #1e293b;
}

.tab-btn.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
}

.tab-icon {
    font-size: 1.1rem;
}

.locale-switch {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.locale-label {
    font-size: 0.8rem;
    color: #64748b;
}

.locale-btns {
    display: flex;
    gap: 0.5rem;
}

.locale-btn {
    padding: 0.5rem 1rem;
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    cursor: pointer;
    font-size: 0.8rem;
    font-weight: 500;
    transition: all 0.2s;
}

.locale-btn:hover {
    border-color: #667eea;
}

.locale-btn.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    border-color: transparent;
}

.content-area {
    min-height: 400px;
}

.empty-state {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 4rem;
    background: #fff;
    border-radius: 16px;
    color: #94a3b8;
}

.items-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.item-card {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05), 0 4px 12px rgba(102, 126, 234, 0.08);
}

.item-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 1.5rem;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
    border-bottom: 1px solid #f1f5f9;
}

.item-title {
    font-size: 1rem;
    font-weight: 600;
    color: #1e293b;
    margin: 0;
}

.item-id {
    font-size: 0.75rem;
    color: #94a3b8;
}

.fields-grid {
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}

.field-row {
    display: grid;
    grid-template-columns: 1fr auto 1fr;
    gap: 1rem;
    align-items: start;
}

.field-original,
.field-translation {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.field-label {
    font-size: 0.75rem;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.field-value {
    font-size: 0.9rem;
    color: #1e293b;
    padding: 0.75rem 1rem;
    background: #f8fafc;
    border-radius: 8px;
    min-height: 42px;
    line-height: 1.5;
}

.field-arrow {
    padding-top: 2rem;
    color: #cbd5e1;
    font-size: 1.25rem;
}

.field-input {
    width: 100%;
    padding: 0.75rem 1rem;
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 0.9rem;
    color: #1e293b;
    transition: all 0.2s;
}

.field-input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15);
}

.field-input.textarea {
    resize: vertical;
    min-height: 80px;
}

.field-input::placeholder {
    color: #94a3b8;
}

@media (max-width: 768px) {
    .tabs-wrapper {
        flex-direction: column;
        align-items: stretch;
    }
    
    .tabs {
        overflow-x: auto;
    }
    
    .field-row {
        grid-template-columns: 1fr;
    }
    
    .field-arrow {
        display: none;
    }
}
</style>
