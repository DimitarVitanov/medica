<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, computed } from 'vue';

const props = defineProps({
    section: Object,
});

const sectionLabels = {
    'about_us': 'За нас',
    'working_hours': 'Работно време',
    'stats': 'Статистики',
    'contact': 'Контакт информации',
};

// Initialize data with proper defaults based on section type
const initializeData = () => {
    let data = props.section.data;
    
    // Parse if it's a string
    if (typeof data === 'string') {
        try {
            data = JSON.parse(data);
        } catch (e) {
            data = {};
        }
    }
    
    data = data || {};
    
    if (props.section.key === 'working_hours' && !data.locations) {
        data.locations = [];
    }
    if (props.section.key === 'stats' && !data.stats) {
        data.stats = [];
    }
    if (props.section.key === 'contact') {
        data.phone = data.phone || '';
        data.email = data.email || '';
        data.address = data.address || '';
        data.facebook = data.facebook || '';
        data.instagram = data.instagram || '';
    }
    
    return data;
};

const sectionData = initializeData();

const form = useForm({
    title: props.section.title || '',
    content: props.section.content || '',
    section_data: JSON.parse(JSON.stringify(sectionData)),
    is_active: props.section.is_active,
});

const sectionLabel = computed(() => sectionLabels[props.section.key] || props.section.key);

const submit = () => {
    form.put(`/admin/sections/${props.section.id}`);
};

// For working hours - manage array of locations
const addWorkingHoursItem = () => {
    if (!form.section_data.locations) {
        form.section_data.locations = [];
    }
    form.section_data.locations.push({
        department: '',
        hours: '',
        address: '',
        phone: '',
        doctor: '',
    });
};

const removeWorkingHoursItem = (index) => {
    form.section_data.locations.splice(index, 1);
};

// For stats - manage array of stats
const addStatItem = () => {
    if (!form.section_data.stats) {
        form.section_data.stats = [];
    }
    form.section_data.stats.push({
        number: '',
        label: '',
    });
};

const removeStatItem = (index) => {
    form.section_data.stats.splice(index, 1);
};
</script>

<template>
    <Head :title="`Уреди ${sectionLabel} - Админ`" />

    <AuthenticatedLayout>
        <template #header>
            <div class="d-flex align-items-center gap-3">
                <Link href="/admin/sections" class="text-muted text-decoration-none">← Назад</Link>
                <h5 class="fw-bold text-dark mb-0">Уреди: {{ sectionLabel }}</h5>
            </div>
        </template>

        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <form @submit.prevent="submit" class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            
                            <!-- About Us Section -->
                            <template v-if="section.key === 'about_us'">
                                <h6 class="fw-bold border-bottom pb-2 mb-4">Содржина за секцијата "За нас"</h6>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Наслов</label>
                                    <input v-model="form.section_data.title" type="text" class="form-control" placeholder="Вашето здравје е наш приоритет">
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Главен текст</label>
                                    <textarea v-model="form.section_data.lead_text" rows="2" class="form-control" placeholder="ПЗУ Медика е формирана во 1993 година..."></textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Опис</label>
                                    <textarea v-model="form.section_data.description" rows="4" class="form-control"></textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Дополнителен текст</label>
                                    <textarea v-model="form.section_data.additional_text" rows="3" class="form-control"></textarea>
                                </div>
                            </template>
                            
                            <!-- Stats Section -->
                            <template v-if="section.key === 'stats'">
                                <h6 class="fw-bold border-bottom pb-2 mb-4">Статистики</h6>
                                
                                <div v-for="(stat, index) in form.section_data.stats" :key="index" class="card mb-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="fw-semibold">Статистика {{ index + 1 }}</span>
                                            <button type="button" @click="removeStatItem(index)" class="btn btn-sm btn-outline-danger">Избриши</button>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="form-label">Број</label>
                                                <input v-model="stat.number" type="text" class="form-control" placeholder="27+">
                                            </div>
                                            <div class="col-md-8">
                                                <label class="form-label">Опис</label>
                                                <input v-model="stat.label" type="text" class="form-control" placeholder="Години искуство">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <button type="button" @click="addStatItem" class="btn btn-outline-primary mb-4">
                                    + Додај статистика
                                </button>
                            </template>
                            
                            <!-- Working Hours Section -->
                            <template v-if="section.key === 'working_hours'">
                                <h6 class="fw-bold border-bottom pb-2 mb-4">Работно време по ординации</h6>
                                
                                <div v-if="form.section_data.locations && form.section_data.locations.length > 0" class="mb-3">
                                    <p class="text-muted small">Вкупно {{ form.section_data.locations.length }} ординации</p>
                                </div>
                                <div v-for="(location, index) in form.section_data.locations" :key="index" class="card mb-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="fw-semibold">Ординација {{ index + 1 }}</span>
                                            <button type="button" @click="removeWorkingHoursItem(index)" class="btn btn-sm btn-outline-danger">Избриши</button>
                                        </div>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Оддел/Ординација</label>
                                                <input v-model="location.department" type="text" class="form-control" placeholder="Општа и Психијатриска Ординација">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Работно време</label>
                                                <input v-model="location.hours" type="text" class="form-control" placeholder="Пон до Петок 08:00 - 15:00">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Адреса</label>
                                                <input v-model="location.address" type="text" class="form-control" placeholder="Вањо Китанов бр. 19">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Телефон</label>
                                                <input v-model="location.phone" type="text" class="form-control" placeholder="034-360-444">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Доктор (опционално)</label>
                                                <input v-model="location.doctor" type="text" class="form-control" placeholder="Др. Име Презиме">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <button type="button" @click="addWorkingHoursItem" class="btn btn-outline-primary mb-4">
                                    + Додај ординација
                                </button>
                            </template>
                            
                            <!-- Contact Section -->
                            <template v-if="section.key === 'contact'">
                                <h6 class="fw-bold border-bottom pb-2 mb-4">Контакт информации</h6>
                                
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Телефон</label>
                                        <input v-model="form.section_data.phone" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Е-пошта</label>
                                        <input v-model="form.section_data.email" type="email" class="form-control">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Адреса</label>
                                        <input v-model="form.section_data.address" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Facebook URL</label>
                                        <input v-model="form.section_data.facebook" type="url" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Instagram URL</label>
                                        <input v-model="form.section_data.instagram" type="url" class="form-control">
                                    </div>
                                </div>
                            </template>
                            
                            <!-- Active Toggle -->
                            <div class="mb-4 mt-4">
                                <div class="form-check">
                                    <input v-model="form.is_active" type="checkbox" class="form-check-input" id="is_active">
                                    <label class="form-check-label" for="is_active">Активна секција</label>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                                <Link href="/admin/sections" class="btn btn-outline-secondary">Откажи</Link>
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
</style>
