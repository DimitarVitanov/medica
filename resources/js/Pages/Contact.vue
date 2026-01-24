<script setup>
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import AppointmentModal from '@/Components/AppointmentModal.vue';
import { useTranslate } from '@/composables/useTranslate';
import { useScrollAnimation } from '@/composables/useScrollAnimation';

const { t } = useTranslate();
useScrollAnimation();

const props = defineProps({
    socialLinks: Object,
    workingHours: Object,
    contactSubjects: String,
});

// Parse contact subjects from props
const subjectOptions = computed(() => {
    if (props.contactSubjects) {
        return props.contactSubjects.split(',').map(s => s.trim()).filter(Boolean);
    }
    return ['Закажување преглед', 'Општи информации', 'Поплака', 'Друго'];
});

const page = usePage();
const showAppointmentModal = ref(false);

const form = useForm({
    name: '',
    email: '',
    phone: '',
    subject: '',
    message: '',
});

const formSubmitted = ref(false);

// Map department keys to translation keys
const departmentTranslationMap = {
    'Општа и Психијатриска Ординација': 'services.generalPsychiatric',
    'Општа и Трудова Ординација': 'services.generalLabor',
    'Гинеколошка Ординација': 'services.gynecology',
    'Лабораторија': 'services.laboratory',
    'Ординација по Естетска Медицина': 'services.aestheticMedicine',
};

const translateDepartment = (dept) => {
    const key = departmentTranslationMap[dept];
    return key ? t(key) : dept;
};

// Dynamic locations from database
const locations = computed(() => {
    if (props.workingHours?.locations && props.workingHours.locations.length > 0) {
        return props.workingHours.locations.map((loc, index) => ({
            id: index + 1,
            name: translateDepartment(loc.department),
            address: loc.address || '',
            phone: loc.phone || '',
            hours: loc.hours || '',
            doctor: loc.doctor || '',
        }));
    }
    
    // Fallback data
    return [
        { id: 1, name: t('services.generalPsychiatric'), address: 'ул. Вањо Китанов бр. 19, Струмица', phone: '034-360-444', hours: `${t('workingHours.monFri')}: 08:00 - 15:00` },
        { id: 2, name: t('services.generalLabor'), address: 'ул. Ганче Пешев, Струмица', phone: '034-326-301', hours: `${t('workingHours.monFri')}: 08:00 - 20:00` },
        { id: 3, name: t('services.gynecology'), address: 'ул. Благој Јанков Мучето бр. 56, Струмица', phone: '034-322-991', hours: `${t('workingHours.monFri')}: 09:00 - 16:00` },
        { id: 4, name: t('services.laboratory'), address: 'ул. Братство и Единство бр. 41, Струмица', phone: '034-323-444', hours: `${t('workingHours.monFri')}: 08:00 - 16:00` },
        { id: 5, name: t('services.aestheticMedicine'), address: 'ул. Братство и Единство бр. 41, Струмица', phone: '034-320-444', hours: `${t('workingHours.monFri')}: 08:00 - 16:00` },
    ];
});

// Get all unique phones and emails from locations
const allPhones = computed(() => {
    const phones = locations.value.map(loc => loc.phone).filter(Boolean);
    return [...new Set(phones)];
});

const allEmails = ['info@medica.mk'];

const submitForm = () => {
    form.post('/contact', {
        preserveScroll: true,
        onSuccess: () => {
            formSubmitted.value = true;
            form.reset();
        },
    });
};
</script>

<template>
    <Head>
        <title>Контакт - ПЗУ Медика Струмица | Закажете Преглед 034-360-444</title>
        <meta name="description" content="Контактирајте ја ПЗУ Медика Струмица. Закажете преглед на 034-360-444. Адреса: ул. Вањо Китанов бр. 19, Струмица. Работно време: Пон-Пет 08:00-20:00. Итен контакт достапен." />
        <meta name="keywords" content="контакт медика струмица, закажи преглед струмица, доктор струмица телефон, ординација контакт, медика телефон 034-360-444, медика адреса, приватна болница струмица контакт" />
        <meta name="robots" content="index, follow, max-image-preview:large" />
        <meta name="author" content="ПЗУ Медика" />
        <meta name="geo.region" content="MK-10" />
        <meta name="geo.placename" content="Струмица" />
        <meta name="geo.position" content="41.4375;22.6414" />
        <link rel="canonical" href="https://medica.mk/contact" />
        
        <!-- Open Graph -->
        <meta property="og:title" content="Контакт - ПЗУ Медика Струмица | 034-360-444" />
        <meta property="og:description" content="Закажете преглед во ПЗУ Медика. Телефон: 034-360-444. Адреса: ул. Вањо Китанов бр. 19, Струмица." />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="https://medica.mk/contact" />
        <meta property="og:image" content="https://medica.mk/images/og-contact.jpg" />
        <meta property="og:image:width" content="1200" />
        <meta property="og:image:height" content="630" />
        <meta property="og:locale" content="mk_MK" />
        <meta property="og:site_name" content="ПЗУ Медика" />
        
        <!-- Twitter -->
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:title" content="Контакт - ПЗУ Медика Струмица" />
        <meta name="twitter:description" content="Закажете преглед: 034-360-444. Адреса: ул. Вањо Китанов бр. 19, Струмица." />
        <meta name="twitter:image" content="https://medica.mk/images/og-contact.jpg" />
    </Head>
    
    <div class="contact-page">
        <Navbar :dark="true" :logo-height="80" active-link="contact" @open-appointment="showAppointmentModal = true" />
        
        <!-- Header -->
        <header class="page-header">
            <!-- Hero -->
            <div class="container py-5">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-3">
                        <li class="breadcrumb-item"><a href="/" class="text-white-50">{{ t('nav.home') }}</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">{{ t('nav.contact') }}</li>
                    </ol>
                </nav>
                <h1 class="display-4 fw-bold text-white mb-3">{{ t('contact.title') }}</h1>
                <p class="lead text-white-50 mb-0">{{ t('contact.subtitle') }}</p>
            </div>
        </header>
        
        <!-- Contact Form & Locations Section -->
        <section class="py-5">
            <div class="container">
                <div class="row g-5">
                    <!-- Left Column: Form -->
                    <div class="col-lg-5">
                        <div class="contact-form-wrapper">
                            <h3 class="fw-bold mb-2">{{ t('contact.formTitle') }}</h3>
                            <p class="text-muted mb-4">{{ t('contact.formSubtitle') }}</p>
                            
                            <!-- Success Message -->
                            <div v-if="formSubmitted || $page.props.flash?.success" class="success-message">
                                <div class="success-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                                    </svg>
                                </div>
                                <h4 class="success-title">{{ t('contact.successTitle') }}</h4>
                                <p class="success-text">{{ t('contact.successMessage') }}</p>
                                <button @click="formSubmitted = false" class="btn btn-outline-success rounded-pill px-4">
                                    {{ t('contact.sendAnother') }}
                                </button>
                            </div>
                            
                            <form v-if="!formSubmitted && !$page.props.flash?.success" @submit.prevent="submitForm">
                                <div class="mb-3">
                                    <label for="name" class="form-label small fw-semibold">{{ t('contact.name') }} *</label>
                                    <input type="text" class="form-control rounded-3" :class="{ 'is-invalid': form.errors.name }" id="name" v-model="form.name" required>
                                    <div v-if="form.errors.name" class="invalid-feedback">{{ form.errors.name }}</div>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label small fw-semibold">{{ t('contact.emailLabel') }} *</label>
                                    <input type="email" class="form-control rounded-3" :class="{ 'is-invalid': form.errors.email }" id="email" v-model="form.email" required>
                                    <div v-if="form.errors.email" class="invalid-feedback">{{ form.errors.email }}</div>
                                </div>
                                <div class="row g-3 mb-3">
                                    <div class="col-6">
                                        <label for="phone" class="form-label small fw-semibold">{{ t('contact.phoneLabel') }}</label>
                                        <input type="tel" class="form-control rounded-3" :class="{ 'is-invalid': form.errors.phone }" id="phone" v-model="form.phone" placeholder="07X XXX XXX">
                                    </div>
                                    <div class="col-6">
                                        <label for="subject" class="form-label small fw-semibold">{{ t('contact.subject') }} *</label>
                                        <select class="form-select rounded-3" :class="{ 'is-invalid': form.errors.subject }" id="subject" v-model="form.subject" required>
                                            <option value="" disabled>{{ t('contact.selectSubject') }}</option>
                                            <option v-for="subject in subjectOptions" :key="subject" :value="subject">{{ subject }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="message" class="form-label small fw-semibold">{{ t('contact.message') }} *</label>
                                    <textarea class="form-control rounded-3" :class="{ 'is-invalid': form.errors.message }" id="message" v-model="form.message" rows="4" required></textarea>
                                    <div v-if="form.errors.message" class="invalid-feedback">{{ form.errors.message }}</div>
                                </div>
                                <button type="submit" class="btn btn-purple btn-lg rounded-pill px-5 py-3 w-100 d-flex align-items-center justify-content-center gap-2" :disabled="form.processing">
                                    <span v-if="form.processing">{{ t('contact.sending') }}</span>
                                    <span v-else>{{ t('contact.send') }}</span>
                                    <svg v-if="!form.processing" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/>
                                    </svg>
                                    <span v-else class="spinner-border spinner-border-sm"></span>
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Right Column: Map & Locations -->
                    <div class="col-lg-7">
                        <!-- Map -->
                        <div class="map-wrapper rounded-4 overflow-hidden shadow-sm mb-4">
                            <iframe 
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2978.5!2d22.6414!3d41.4375!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDHCsDI2JzE1LjAiTiAyMsKwMzgnMjkuMCJF!5e0!3m2!1sen!2smk!4v1234567890"
                                width="100%" 
                                height="250" 
                                style="border:0;" 
                                allowfullscreen="" 
                                loading="lazy"
                                title="ПЗУ Медика локација"
                            ></iframe>
                        </div>
                        
                        <!-- Location Cards - 2 columns -->
                        <div class="row g-3">
                            <div v-for="loc in locations" :key="loc.id" class="col-md-6">
                                <div class="location-card">
                                    <h6 class="location-title">{{ loc.name }}</h6>
                                    <div class="location-info">
                                        <div v-if="loc.address" class="info-row">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
                                            </svg>
                                            <span>{{ loc.address }}</span>
                                        </div>
                                        <div class="info-row">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                                            </svg>
                                            <a :href="`tel:${loc.phone?.replace(/-/g, '')}`" class="phone-link">{{ loc.phone }}</a>
                                        </div>
                                        <div class="info-row">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                                            </svg>
                                            <span>{{ loc.hours }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- CTA Section -->
        <section class="py-5 bg-purple text-white text-center">
            <div class="container py-4">
                <h2 class="display-6 fw-bold mb-3">Потребен ви е итен преглед?</h2>
                <p class="lead opacity-75 mb-4">Јавете се веднаш на нашиот телефон за итни случаи</p>
                <a href="tel:+38934360444" class="btn btn-light btn-lg rounded-pill px-5 py-3 text-purple fw-bold d-inline-flex align-items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                    </svg>
                    <span>034-360-444</span>
                </a>
            </div>
        </section>
        
        <Footer :socialLinks="socialLinks" />
        
        <AppointmentModal :show="showAppointmentModal" @close="showAppointmentModal = false" />
    </div>
</template>

<style scoped>
.contact-page {
    min-height: 100vh;
}

/* Header */
.page-header {
    background: linear-gradient(135deg, #6B4C9A 0%, #8B6BAE 100%);
    padding-top: 100px;
    padding-bottom: 2rem;
}

.navbar-logo {
    height: 40px;
    width: auto;
}

.navbar-dark .nav-link {
    color: rgba(255, 255, 255, 0.8);
}

.navbar-dark .nav-link:hover,
.navbar-dark .nav-link.active {
    color: #fff;
}

.text-purple {
    color: #6B4C9A !important;
}

.bg-purple {
    background: linear-gradient(135deg, #6B4C9A 0%, #8B6BAE 100%) !important;
}

.bg-purple-soft {
    background-color: rgba(107, 76, 154, 0.1) !important;
}

/* Success Message */
.success-message {
    text-align: center;
    padding: 3rem 2rem;
    background: linear-gradient(135deg, rgba(40, 167, 69, 0.05) 0%, rgba(40, 167, 69, 0.1) 100%);
    border-radius: 16px;
    border: 1px solid rgba(40, 167, 69, 0.2);
}

.success-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    color: white;
    animation: scaleIn 0.5s ease;
}

.success-title {
    color: #28a745;
    font-weight: 700;
    margin-bottom: 0.75rem;
}

.success-text {
    color: #666;
    margin-bottom: 1.5rem;
}

@keyframes scaleIn {
    0% { transform: scale(0); opacity: 0; }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); opacity: 1; }
}

.btn-purple {
    background: linear-gradient(135deg, #6B4C9A 0%, #8B6BAE 100%);
    color: white;
    border: none;
    transition: all 0.3s ease;
}

.btn-purple:hover {
    background: linear-gradient(135deg, #5B3C8A 0%, #7B5B9E 100%);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(107, 76, 154, 0.3);
}

/* Contact Form Wrapper */
.contact-form-wrapper {
    background: #fff;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    border: 1px solid #f0f0f0;
}

/* Location Cards */
.location-card {
    background: #fff;
    border-radius: 12px;
    padding: 1.25rem;
    border: 1px solid #eee;
    transition: all 0.2s ease;
    height: 100%;
}

.location-card:hover {
    border-color: #6B4C9A;
    box-shadow: 0 4px 12px rgba(107, 76, 154, 0.1);
}

.location-title {
    color: #6B4C9A;
    font-weight: 600;
    font-size: 0.95rem;
    margin-bottom: 0.75rem;
    line-height: 1.3;
}

.location-info {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.info-row {
    display: flex;
    align-items: flex-start;
    gap: 0.5rem;
    font-size: 0.8rem;
    color: #666;
}

.info-row svg {
    flex-shrink: 0;
    margin-top: 2px;
    color: #999;
}

.phone-link {
    color: #666;
    text-decoration: none;
    transition: color 0.2s ease;
}

.phone-link:hover {
    color: #6B4C9A;
}

/* Form */
.form-control,
.form-select {
    background-color: #F8F9FA;
    border: 1px solid #e9ecef;
    padding: 0.75rem 1rem;
    font-size: 0.95rem;
}

.form-control:focus,
.form-select:focus {
    border-color: #8B6BAE;
    box-shadow: 0 0 0 0.2rem rgba(107, 76, 154, 0.1);
    background-color: #fff;
}

/* Map */
.map-wrapper {
    background: #e9ecef;
}

@media (max-width: 991px) {
    .contact-form-wrapper {
        padding: 1.5rem;
    }
}

@media (max-width: 767px) {
    .display-4 {
        font-size: 2rem;
    }
    
    .display-6 {
        font-size: 1.5rem;
    }
    
    .location-card {
        padding: 1rem;
    }
}
</style>
