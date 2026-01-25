<script setup>
import { ref, computed, onMounted, defineAsyncComponent } from 'vue';
import { Link } from '@inertiajs/vue3';
import { useTranslate } from '@/composables/useTranslate';

// Lazy load Swiper to reduce initial bundle and avoid forced reflow on page load
const Swiper = defineAsyncComponent(() => 
    import('swiper/vue').then(m => m.Swiper)
);
const SwiperSlide = defineAsyncComponent(() => 
    import('swiper/vue').then(m => m.SwiperSlide)
);

// Import CSS only when needed
let swiperCssLoaded = false;
const loadSwiperCss = () => {
    if (swiperCssLoaded) return;
    import('swiper/css');
    import('swiper/css/pagination');
    swiperCssLoaded = true;
};

const { t, translateModel } = useTranslate();

const props = defineProps({
    services: {
        type: Array,
        default: () => [],
    },
});

// Lazy load modules
const modules = ref([]);
const swiperReady = ref(false);

onMounted(() => {
    // Delay Swiper initialization to avoid blocking main thread
    requestIdleCallback(() => {
        loadSwiperCss();
        import('swiper/modules').then(({ Pagination, Autoplay }) => {
            modules.value = [Pagination, Autoplay];
            swiperReady.value = true;
        });
    }, { timeout: 500 });
});

const serviceIcons = {
    'opsta-medicina': `<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4.8 2.3A.3.3 0 1 0 5 2H4a2 2 0 0 0-2 2v5a6 6 0 0 0 6 6v0a6 6 0 0 0 6-6V4a2 2 0 0 0-2-2h-1a.2.2 0 1 0 .3.3"/><path d="M8 15v1a6 6 0 0 0 6 6v0a6 6 0 0 0 6-6v-4"/><circle cx="20" cy="10" r="2"/></svg>`,
    'ginekologija': `<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"/><path d="M12 15v6"/><path d="M9 18h6"/></svg>`,
    'psihijatrija': `<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 4.5a2.5 2.5 0 0 0-4.96-.46 2.5 2.5 0 0 0-1.98 3 2.5 2.5 0 0 0 1.32 4.24 3 3 0 0 0 .34 5.58 2.5 2.5 0 0 0 2.96 3.08A2.5 2.5 0 0 0 12 21.5V4.5Z"/><path d="M12 4.5a2.5 2.5 0 0 1 4.96-.46 2.5 2.5 0 0 1 1.98 3 2.5 2.5 0 0 1-1.32 4.24 3 3 0 0 1-.34 5.58 2.5 2.5 0 0 1-2.96 3.08A2.5 2.5 0 0 1 12 21.5V4.5Z"/></svg>`,
    'estetska-medicina': `<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .963 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.963 0z"/></svg>`,
    'laboratorija': `<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9 3h6v2H9z"/><path d="M10 5v6.5L6 20h12l-4-8.5V5"/><path d="M8.5 14h7"/></svg>`,
    'medicina-na-trud': `<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M16 20V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/><rect width="20" height="14" x="2" y="6" rx="2"/><path d="M12 12h.01"/></svg>`,
    'semejna-medicina': `<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>`,
};

const defaultIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>`;

const displayServices = computed(() => {
    if (props.services && props.services.length > 0) {
        return props.services.map(service => ({
            id: service.id,
            title: translateModel(service, 'title'),
            description: translateModel(service, 'short_description'),
            icon: serviceIcons[service.slug] || defaultIcon,
            slug: service.slug,
        }));
    }
    return [];
});

const activeCard = ref(null);
</script>

<template>
    <section class="services-section">
        <div class="container py-5">
            <!-- Header -->
            <div class="row mb-5">
                <div class="col-lg-6">
                    <p class="section-label">{{ t('home.ourServices').toUpperCase() }}</p>
                    <h2 class="section-heading">{{ t('home.servicesSubtitle') }}</h2>
                </div>
                <div class="col-lg-6 d-flex align-items-end justify-content-lg-end">
                    <Link href="/services" class="view-all-link">
                        {{ t('common.viewAll') }}
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </Link>
                </div>
            </div>
            
            <!-- Mobile Grid (visible on mobile only) -->
            <div class="services-grid-mobile">
                <Link 
                    v-for="service in displayServices" 
                    :key="service.id"
                    :href="`/services#${service.slug}`"
                    class="service-card-mobile"
                >
                    <div class="icon-wrapper-mobile" v-html="service.icon"></div>
                    <h4 class="service-title-mobile">{{ service.title }}</h4>
                </Link>
            </div>
            
            <!-- Desktop Swiper (hidden on mobile) -->
            <div class="services-swiper-wrapper" style="contain: layout style;">
                <Swiper
                    v-if="swiperReady"
                    :modules="modules"
                    :slides-per-view="3"
                    :space-between="20"
                    :pagination="{ clickable: true }"
                    :grab-cursor="true"
                    :autoplay="{ delay: 3000, disableOnInteraction: false }"
                    :loop="true"
                    :breakpoints="{
                        992: { slidesPerView: 4, spaceBetween: 24 },
                        1200: { slidesPerView: 5, spaceBetween: 24 },
                        1400: { slidesPerView: 6, spaceBetween: 24 },
                    }"
                    class="services-swiper"
                >
                    <SwiperSlide v-for="service in displayServices" :key="service.id">
                        <Link 
                            :href="`/services#${service.slug}`"
                            class="service-card"
                            :class="{ 'active': activeCard === service.id }"
                            @mouseenter="activeCard = service.id"
                            @mouseleave="activeCard = null"
                        >
                            <div class="card-inner">
                                <div class="icon-wrapper" v-html="service.icon"></div>
                                <h4 class="service-title">{{ service.title }}</h4>
                                <p class="service-desc">{{ service.description }}</p>
                                <div class="card-arrow">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 17L17 7M17 7H7M17 7V17"/></svg>
                                </div>
                            </div>
                            <div class="card-gradient"></div>
                        </Link>
                    </SwiperSlide>
                </Swiper>
            </div>
        </div>
    </section>
</template>

<style scoped>
.services-section {
    background: linear-gradient(180deg, #FFFFFF 0%, #F8F5FC 100%);
    position: relative;
}

.services-section::before {
    content: '';
    position: absolute;
    top: -30%;
    right: -10%;
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, rgba(139, 107, 174, 0.08) 0%, transparent 70%);
    pointer-events: none;
}

.services-section::after {
    content: '';
    position: absolute;
    bottom: -20%;
    left: -10%;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(139, 107, 174, 0.06) 0%, transparent 70%);
    pointer-events: none;
}

.section-label {
    color: #6B4C9A;
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 3px;
    margin-bottom: 1rem;
}

.section-heading {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2D2D2D;
    line-height: 1.2;
}

.section-heading span {
    background: linear-gradient(135deg, #6B4C9A 0%, #8B6BAE 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.view-all-link {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: #6B4C9A;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    margin-bottom: 1rem;
}

.view-all-link:hover {
    color: #8B6BAE;
    gap: 0.75rem;
}

/* Mobile Grid Styles */
.services-grid-mobile {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 0.75rem;
}

.service-card-mobile {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding: 1.25rem 0.75rem;
    background: #fff;
    border: 1px solid rgba(107, 76, 154, 0.1);
    border-radius: 16px;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(107, 76, 154, 0.05);
}

.service-card-mobile:active {
    transform: scale(0.98);
    background: rgba(107, 76, 154, 0.02);
}

.icon-wrapper-mobile {
    width: 44px;
    height: 44px;
    background: linear-gradient(135deg, rgba(107, 76, 154, 0.1) 0%, rgba(139, 107, 174, 0.05) 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6B4C9A;
    margin-bottom: 0.75rem;
}

.icon-wrapper-mobile :deep(svg) {
    width: 24px;
    height: 24px;
}

.service-title-mobile {
    font-size: 0.8rem;
    font-weight: 600;
    color: #2D2D2D;
    margin: 0;
    line-height: 1.3;
}

/* Hide mobile grid on desktop */
@media (min-width: 768px) {
    .services-grid-mobile {
        display: none;
    }
}

/* Hide swiper on mobile */
.services-swiper-wrapper {
    display: none;
}

@media (min-width: 768px) {
    .services-swiper-wrapper {
        display: block;
        position: relative;
        padding: 0 0 3rem;
    }
}

.services-swiper {
    padding: 1rem 0 2.5rem;
}

.services-swiper :deep(.swiper-pagination) {
    display: none;
}

@media (min-width: 992px) {
    .services-swiper :deep(.swiper-pagination) {
        display: block;
    }
    
    .services-swiper :deep(.swiper-pagination-bullet) {
        width: 10px;
        height: 10px;
        background: #6B4C9A;
        opacity: 0.3;
    }

    .services-swiper :deep(.swiper-pagination-bullet-active) {
        opacity: 1;
        background: linear-gradient(135deg, #6B4C9A 0%, #8B6BAE 100%);
    }
}

.service-card {
    position: relative;
    display: flex;
    flex-direction: column;
    text-decoration: none;
    background: #FFFFFF;
    border: 1px solid rgba(107, 76, 154, 0.1);
    border-radius: 20px;
    padding: 1.5rem 1.25rem;
    height: auto;
    min-height: 200px;
    cursor: pointer;
    overflow: visible;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 20px rgba(107, 76, 154, 0.06);
}

.service-card:hover {
    background: #FFFFFF;
    border-color: rgba(107, 76, 154, 0.25);
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(107, 76, 154, 0.12);
}

.service-card:hover .card-gradient {
    opacity: 1;
}

.service-card:hover .card-arrow {
    opacity: 1;
    transform: translate(0, 0);
}

.service-card:hover .icon-wrapper {
    transform: scale(1.1);
    background: linear-gradient(135deg, #6B4C9A 0%, #8B6BAE 100%);
    color: #fff;
}

.card-inner {
    position: relative;
    z-index: 2;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.card-gradient {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(139, 107, 174, 0.05) 0%, transparent 50%);
    opacity: 0;
    transition: opacity 0.4s ease;
    pointer-events: none;
}

.icon-wrapper {
    width: 52px;
    height: 52px;
    background: linear-gradient(135deg, rgba(107, 76, 154, 0.1) 0%, rgba(139, 107, 174, 0.05) 100%);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6B4C9A;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
}

.icon-wrapper :deep(svg) {
    width: 26px;
    height: 26px;
}

.service-title {
    font-size: 0.95rem;
    font-weight: 600;
    color: #2D2D2D;
    margin-bottom: 0.35rem;
    line-height: 1.3;
}

.service-desc {
    font-size: 0.8rem;
    color: #777;
    line-height: 1.45;
    margin: 0;
}

.card-arrow {
    display: none;
}

/* Tablet */
@media (max-width: 991px) {
    .section-heading {
        font-size: 2rem;
    }
}

/* Mobile landscape */
@media (max-width: 767px) {
    .services-section {
        padding: 2rem 0;
    }
    
    .section-heading {
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }
    
    .section-heading br {
        display: none;
    }
    
    .section-label {
        font-size: 0.7rem;
        letter-spacing: 2px;
    }
    
    .service-card {
        min-height: 160px;
        padding: 1rem;
        border-radius: 16px;
    }
    
    .icon-wrapper {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        margin-bottom: 0.75rem;
    }
    
    .service-title {
        font-size: 0.85rem;
        margin-bottom: 0.25rem;
    }
    
    .service-desc {
        font-size: 0.7rem;
        line-height: 1.4;
    }
    
    .card-arrow {
        display: none;
    }
    
    .view-all-link {
        font-size: 0.9rem;
    }
    
    .services-swiper-wrapper {
        padding-bottom: 1.5rem;
    }
    
    .services-swiper {
        padding-bottom: 2rem;
    }
}

/* Mobile portrait */
@media (max-width: 480px) {
    .section-heading {
        font-size: 1.25rem;
    }
    
    .service-card {
        min-height: 140px;
        padding: 0.875rem;
    }
    
    .icon-wrapper {
        width: 36px;
        height: 36px;
    }
    
    .service-title {
        font-size: 0.8rem;
    }
    
    .service-desc {
        font-size: 0.7rem;
        line-height: 1.4;
    }
}
</style>
