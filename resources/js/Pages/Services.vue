<script setup>
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import AppointmentModal from '@/Components/AppointmentModal.vue';
import NewsletterSubscription from '@/Components/NewsletterSubscription.vue';
import { useTranslate } from '@/composables/useTranslate';
import { useScrollAnimation } from '@/composables/useScrollAnimation';

const { t, translateModel } = useTranslate();
useScrollAnimation();

const props = defineProps({
    services: {
        type: Array,
        default: () => [],
    },
    workingHours: Object,
    socialLinks: Object,
});

const showAppointmentModal = ref(false);

// Service icons mapping
const serviceIcons = {
    'opsta-medicina': `<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>`,
    'ginekologija': `<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2a10 10 0 1 0 10 10H12V2z"/><path d="M12 2a10 10 0 0 1 10 10"/><circle cx="12" cy="12" r="6"/></svg>`,
    'psihijatrija': `<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 4.5a2.5 2.5 0 0 0-4.96-.46 2.5 2.5 0 0 0-1.98 3 2.5 2.5 0 0 0 1.32 4.24 3 3 0 0 0 .34 5.58 2.5 2.5 0 0 0 2.96 3.08A2.5 2.5 0 0 0 12 21.5V4.5Z"/><path d="M12 4.5a2.5 2.5 0 0 1 4.96-.46 2.5 2.5 0 0 1 1.98 3 2.5 2.5 0 0 1-1.32 4.24 3 3 0 0 1-.34 5.58 2.5 2.5 0 0 1-2.96 3.08A2.5 2.5 0 0 1 12 21.5V4.5Z"/></svg>`,
    'estetska-medicina': `<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/></svg>`,
    'laboratorija': `<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9 3h6v2H9z"/><path d="M10 5v6.5L6 20h12l-4-8.5V5"/><path d="M8.5 14h7"/></svg>`,
    'medicina-na-trud': `<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M16 20V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/><rect x="6" y="10" width="12" height="12" rx="2"/><path d="M12 10v4"/><path d="M10 12h4"/></svg>`,
    'semejna-medicina': `<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>`,
};

const serviceColors = {
    'opsta-medicina': '#6B4C9A',
    'ginekologija': '#E91E63',
    'psihijatrija': '#9C27B0',
    'estetska-medicina': '#FF5722',
    'laboratorija': '#2196F3',
    'medicina-na-trud': '#4CAF50',
    'semejna-medicina': '#00BCD4',
};

const defaultIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>`;

// Use services from props (database) with translations
const services = computed(() => {
    if (props.services && props.services.length > 0) {
        return props.services.map(service => ({
            id: service.id,
            slug: service.slug,
            title: translateModel(service, 'title'),
            shortDesc: translateModel(service, 'short_description'),
            description: translateModel(service, 'description') || '',
            features: translateModel(service, 'features') || service.features || [],
            icon: serviceIcons[service.slug] || defaultIcon,
            color: serviceColors[service.slug] || '#6B4C9A',
        }));
    }
    return [];
});

const activeService = ref(null);

const openModal = (service) => {
    activeService.value = service;
};

const closeModal = () => {
    activeService.value = null;
};
</script>

<template>
    <Head>
        <title>Медицински Услуги - ПЗУ Медика Струмица | Гинекологија, Психијатрија, Лабораторија</title>
        <meta name="description" content="Медицински услуги во ПЗУ Медика Струмица: Општа медицина, Гинекологија со 4D ултразвук, Психијатрија, Естетска медицина (ботокс, мезотерапија), Биохемиска лабораторија, Медицина на труд. Закажете: 034-360-444." />
        <meta name="keywords" content="медицински услуги струмица, гинеколог струмица, 4D ултразвук струмица, психијатар струмица, лабораторија струмица, естетска медицина струмица, ботокс струмица, мезотерапија цена, DEXA scan, медицина на труд, ПАП тест струмица" />
        <meta name="robots" content="index, follow, max-image-preview:large" />
        <meta name="author" content="ПЗУ Медика" />
        <meta name="geo.region" content="MK-10" />
        <meta name="geo.placename" content="Струмица" />
        <link rel="canonical" href="https://medica.mk/services" />
        
        <!-- Open Graph -->
        <meta property="og:title" content="Медицински Услуги - ПЗУ Медика Струмица" />
        <meta property="og:description" content="Комплетни медицински услуги: Гинекологија со 4D ултразвук, Психијатрија, Естетска медицина, Биохемиска лабораторија. Закажете: 034-360-444." />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="https://medica.mk/services" />
        <meta property="og:image" content="https://medica.mk/images/og-services.jpg" />
        <meta property="og:image:width" content="1200" />
        <meta property="og:image:height" content="630" />
        <meta property="og:locale" content="mk_MK" />
        <meta property="og:site_name" content="ПЗУ Медика" />
        
        <!-- Twitter -->
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:title" content="Медицински Услуги - ПЗУ Медика Струмица" />
        <meta name="twitter:description" content="Гинекологија, Психијатрија, Естетска медицина, Лабораторија. Закажете: 034-360-444." />
        <meta name="twitter:image" content="https://medica.mk/images/og-services.jpg" />
    </Head>
    
    <div class="services-page">
        <Navbar :dark="true" :logo-height="80" active-link="services" @open-appointment="showAppointmentModal = true" />
        
        <!-- Header -->
        <header class="page-header">
            <!-- Hero -->
            <div class="container py-5">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-3">
                        <li class="breadcrumb-item"><a href="/" class="text-white-50">{{ t('nav.home') }}</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">{{ t('nav.services') }}</li>
                    </ol>
                </nav>
                <h1 class="display-4 fw-bold text-white mb-3">{{ t('home.ourServices') }}</h1>
                <p class="lead text-white-50 mb-0">{{ t('services.subtitle') }}</p>
            </div>
        </header>
        
        <!-- Services Grid -->
        <section class="py-5">
            <div class="container">
                <div class="row g-4">
                    <div v-for="(service, index) in services" :key="service.id" class="col-lg-4 col-md-6" data-animate="fade-up" :data-animate-delay="index * 100">
                        <div class="service-card h-100 bg-white rounded-4 p-4 shadow-sm" @click="openModal(service)">
                            <div class="service-icon mb-4" :style="{ color: service.color }" v-html="service.icon"></div>
                            <h4 class="fw-bold mb-2">{{ service.title }}</h4>
                            <p class="text-muted mb-4">{{ service.shortDesc }}</p>
                            
                            <!-- Preview features -->
                            <ul v-if="service.features.length" class="feature-list mb-4">
                                <li v-for="(feature, idx) in service.features.slice(0, 3)" :key="idx" class="text-muted small">
                                    {{ feature }}
                                </li>
                                <li v-if="service.features.length > 3" class="text-purple small fw-semibold">
                                    + {{ service.features.length - 3 }} {{ t('servicesPage.moreFeatures') }}...
                                </li>
                            </ul>
                            
                            <button class="btn btn-outline-purple rounded-pill px-4 py-2 mt-auto d-inline-flex align-items-center gap-2">
                                <span>{{ t('common.learnMore') }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M5 12h14M12 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Newsletter Subscription -->
        <NewsletterSubscription />
        
        <Footer :socialLinks="socialLinks" @open-appointment="showAppointmentModal = true" />
        
        <AppointmentModal :show="showAppointmentModal" :workingHours="workingHours" @close="showAppointmentModal = false" />
        
        <!-- Service Modal -->
        <Teleport to="body">
            <div v-if="activeService" class="modal-overlay" @click.self="closeModal">
                <div class="modal-content bg-white rounded-4 shadow-lg">
                    <button class="modal-close btn btn-light rounded-circle" @click="closeModal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                        </svg>
                    </button>
                    
                    <div class="modal-header-custom p-4 pb-0">
                        <div class="service-icon mb-3" :style="{ color: activeService.color }" v-html="activeService.icon"></div>
                        <h3 class="fw-bold mb-2">{{ activeService.title }}</h3>
                        <p class="text-muted">{{ activeService.shortDesc }}</p>
                    </div>
                    
                    <div class="modal-body p-4">
                        <!-- Features List -->
                        <div v-if="activeService.features.length" class="mb-4">
                            <h5 class="fw-bold mb-3 text-purple">{{ t('services.features') }}:</h5>
                            <ul class="feature-list-modal">
                                <li v-for="(feature, idx) in activeService.features" :key="idx">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-success me-2">
                                        <polyline points="20 6 9 17 4 12"/>
                                    </svg>
                                    {{ feature }}
                                </li>
                            </ul>
                        </div>
                        
                        <!-- Description -->
                        <div v-if="activeService.description" class="description-text">
                            <p v-for="(para, idx) in activeService.description.split('\n\n')" :key="idx" class="mb-3">
                                {{ para }}
                            </p>
                        </div>
                        
                        <button @click="closeModal(); showAppointmentModal = true;" class="btn btn-purple rounded-pill px-4 py-2 mt-3 d-inline-flex align-items-center gap-2">
                            <span>{{ t('services.bookAppointment') }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </Teleport>
    </div>
</template>

<style scoped>
.services-page {
    min-height: 100vh;
    background: #F5F5F5;
}

/* Header */
.page-header {
    background: linear-gradient(135deg, #9B7BC0 0%, #B89AD4 100%);
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

.btn-purple {
    background: linear-gradient(135deg, #6B4C9A 0%, #8B6BAE 100%);
    color: white;
    border: none;
}

.btn-purple:hover {
    background: linear-gradient(135deg, #5B3C8A 0%, #7B5B9E 100%);
    color: white;
}

.btn-outline-purple {
    color: #6B4C9A;
    border: 2px solid #6B4C9A;
    background: transparent;
}

.btn-outline-purple:hover {
    background: linear-gradient(135deg, #6B4C9A 0%, #8B6BAE 100%);
    border-color: transparent;
    color: white;
}

/* Service Cards */
.service-card {
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
}

.service-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 50px rgba(107, 76, 154, 0.15) !important;
}

.service-icon {
    width: 70px;
    height: 70px;
    background: rgba(107, 76, 154, 0.08);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.service-card:hover .service-icon {
    transform: scale(1.1);
}

.feature-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.feature-list li {
    padding: 0.35rem 0;
    padding-left: 1.25rem;
    position: relative;
}

.feature-list li::before {
    content: '•';
    position: absolute;
    left: 0;
    color: #6B4C9A;
    font-weight: bold;
}

/* Modal */
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.6);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    padding: 1rem;
    backdrop-filter: blur(4px);
}

.modal-content {
    max-width: 600px;
    width: 100%;
    max-height: 90vh;
    overflow-y: auto;
    position: relative;
}

.modal-close {
    position: absolute;
    top: 1rem;
    right: 1rem;
    width: 40px;
    height: 40px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10;
}

.feature-list-modal {
    list-style: none;
    padding: 0;
    margin: 0;
}

.feature-list-modal li {
    padding: 0.5rem 0;
    display: flex;
    align-items: flex-start;
}

.description-text {
    color: #555;
    line-height: 1.8;
}

@media (max-width: 767px) {
    .display-4 {
        font-size: 2rem;
    }
    
    .modal-content {
        max-height: 85vh;
    }
}
</style>
