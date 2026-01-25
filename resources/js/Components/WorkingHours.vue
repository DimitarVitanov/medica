<script setup>
import { computed } from 'vue';
import { useTranslate } from '@/composables/useTranslate';
import { usePage } from '@inertiajs/vue3';

const { t } = useTranslate();
const page = usePage();

const props = defineProps({
    workingData: Object,
    services: {
        type: Array,
        default: () => [],
    },
});

// Get current locale
const currentLocale = computed(() => page.props.locale || 'mk');
const isEnglish = computed(() => currentLocale.value === 'en');

// Get translated field based on locale
const getLocalizedField = (loc, field) => {
    if (isEnglish.value && loc[`${field}_en`]) {
        return loc[`${field}_en`];
    }
    return loc[field] || '';
};

const locations = computed(() => {
    // If workingData with locations is passed from admin, use it
    if (props.workingData?.locations && props.workingData.locations.length > 0) {
        return props.workingData.locations.map((loc, index) => ({
            id: index + 1,
            title: t('workingHours.title'),
            department: getLocalizedField(loc, 'department'),
            hours: getLocalizedField(loc, 'hours'),
            address: getLocalizedField(loc, 'address'),
            phone: loc.phone || '034-360-444',
            doctor: getLocalizedField(loc, 'doctor'),
        }));
    }
    
    // Fallback with translations
    return [
        { id: 1, title: t('workingHours.title'), department: t('services.generalPsychiatric'), hours: `${t('workingHours.monFri')}: 08:00 - 15:00`, address: t('addresses.vanjoKitanov'), phone: '034-360-444' },
        { id: 2, title: t('workingHours.title'), department: t('services.generalLabor'), hours: `${t('workingHours.monFri')}: 08:00 - 20:00`, doctor: t('addresses.ganchePeshev'), phone: '034-326-301' },
        { id: 3, title: t('workingHours.title'), department: t('services.gynecology'), hours: `${t('workingHours.monFri')}: 09:00 - 16:00`, address: t('addresses.blagojJankov'), phone: '034-322-991' },
        { id: 4, title: t('workingHours.title'), department: t('services.laboratory'), hours: `${t('workingHours.monFri')}: 08:00 - 16:00`, address: t('addresses.bratstvoEdinstvo'), phone: '034-323-444' },
        { id: 5, title: t('workingHours.title'), department: t('services.aestheticMedicine'), hours: `${t('workingHours.monFri')}: 08:00 - 16:00`, address: t('addresses.bratstvoEdinstvo'), phone: '034-320-444' },
    ];
});
</script>

<template>
    <section class="working-hours-section">
        <!-- Background Image Overlay -->
        <div class="bg-overlay"></div>
        
        <div class="container-fluid px-0">
            <div class="hours-grid">
                <div 
                    v-for="(location, index) in locations" 
                    :key="location.id" 
                    class="hours-card"
                    :class="{ 'card-accent': index === 0 }"
                >
                    <div class="card-content">
                        <h4 class="card-title">{{ location.title }}</h4>
                        <p class="card-department">{{ location.department }}</p>
                        
                        <div class="card-info">
                            <div class="info-item">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/>
                                    <polyline points="12 6 12 12 16 14"/>
                                </svg>
                                <span>{{ location.hours }}</span>
                            </div>
                            
                            <div v-if="location.doctor" class="info-item">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                    <circle cx="12" cy="7" r="4"/>
                                </svg>
                                <span>{{ location.doctor }}</span>
                            </div>
                            
                            <div v-if="location.address" class="info-item">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                    <circle cx="12" cy="10" r="3"/>
                                </svg>
                                <span>{{ location.address }}</span>
                            </div>
                            
                            <div class="info-item phone">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                                </svg>
                                <span>{{ location.phone }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
.working-hours-section {
    position: relative;
    background: linear-gradient(135deg, #5B3C8A 0%, #6B4C9A 25%, #7B5CAA 50%, #8B6BAE 75%, #9B7BBE 100%);
    overflow: hidden;
    width: 100vw;
    margin-left: calc(-50vw + 50%);
}

.bg-overlay {
    display: none;
}

.hours-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    position: relative;
    z-index: 2;
}

.hours-card {
    background: transparent;
    padding: 2rem 1.5rem;
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
    border-right: 1px solid rgba(255, 255, 255, 0.15);
}

.hours-card:last-child {
    border-right: none;
}

.hours-card:hover {
    background: rgba(255, 255, 255, 0.08);
}

.hours-card.card-accent {
    background: transparent;
}

.card-content {
    position: relative;
    z-index: 2;
}

.card-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #fff;
    margin-bottom: 0.5rem;
}

.card-department {
    font-size: 0.8rem;
    color: rgba(255, 255, 255, 0.85);
    margin-bottom: 1.25rem;
    font-weight: 500;
    min-height: 2.4em;
    line-height: 1.2;
}

.card-info {
    display: flex;
    flex-direction: column;
    gap: 0.6rem;
}

.info-item {
    display: flex;
    align-items: flex-start;
    gap: 0.6rem;
    font-size: 0.8rem;
    color: rgba(255, 255, 255, 0.9);
}

.info-item svg {
    flex-shrink: 0;
    margin-top: 2px;
    opacity: 0.8;
}

.info-item.phone {
    color: #FFD700;
    font-weight: 600;
}

.info-item.phone svg {
    color: #FFD700;
    opacity: 1;
}


/* Tablet */
@media (max-width: 1199px) {
    .hours-grid {
        grid-template-columns: repeat(3, 1fr);
    }
    
    .hours-card:nth-child(3) {
        border-right: none;
    }
    
    .hours-card:nth-child(4),
    .hours-card:nth-child(5) {
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }
}

/* Mobile landscape */
@media (max-width: 767px) {
    .hours-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .hours-card {
        padding: 1.5rem 1.25rem;
        border-right: none;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .hours-card:nth-child(odd) {
        border-right: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .hours-card:last-child,
    .hours-card:nth-last-child(2):nth-child(odd) {
        border-bottom: none;
    }
    
    .card-title {
        font-size: 1.1rem;
    }
    
    .card-department {
        font-size: 0.75rem;
    }
    
    .info-item {
        font-size: 0.75rem;
    }
}

/* Mobile portrait */
@media (max-width: 480px) {
    .working-hours-section {
        background: linear-gradient(180deg, #5B3C8A 0%, #6B4C9A 20%, #7B5CAA 40%, #8B6BAE 60%, #9B7BBE 80%, #AB8BCE 100%);
    }
    
    .hours-grid {
        grid-template-columns: 1fr;
    }
    
    .hours-card {
        border-right: none !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.12);
        padding: 1.25rem 1rem;
    }
    
    .hours-card:last-child {
        border-bottom: none;
    }
    
    .card-department {
        min-height: auto;
    }
}
</style>
