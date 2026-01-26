<script setup>
import { ref, computed } from 'vue';
import { useTranslate } from '@/composables/useTranslate';
import { usePage } from '@inertiajs/vue3';

const { t } = useTranslate();
const page = usePage();

const props = defineProps({
    show: Boolean,
    workingHours: Object,
});

const emit = defineEmits(['close']);

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

const departments = computed(() => {
    // If workingHours with locations is passed from admin, use it
    if (props.workingHours?.locations && props.workingHours.locations.length > 0) {
        return props.workingHours.locations.map((loc) => ({
            name: getLocalizedField(loc, 'department'),
            phone: loc.phone || '034-340-444',
            hours: getLocalizedField(loc, 'hours'),
        }));
    }
    
    // Fallback with translations
    return [
        { name: t('services.generalPsychiatric'), phone: '034-340-444', hours: `${t('workingHours.monFri')}: 08:00 - 15:00` },
        { name: t('services.generalLabor'), phone: '034-326-301', hours: `${t('workingHours.monFri')}: 08:00 - 20:00` },
        { name: t('services.gynecology'), phone: '034-322-991', hours: `${t('workingHours.monFri')}: 09:00 - 16:00` },
        { name: t('services.laboratory'), phone: '034-320-444', hours: `${t('workingHours.monFri')}: 08:00 - 16:00` },
        { name: t('services.aestheticMedicine'), phone: '034-320-444', hours: `${t('workingHours.monFri')}: 08:00 - 16:00` },
    ];
});

const close = () => {
    emit('close');
};
</script>

<template>
    <Teleport to="body">
        <Transition name="modal">
            <div v-if="show" class="modal-overlay" @click.self="close">
                <div class="modal-container">
                    <div class="modal-header">
                        <div>
                            <h3 class="modal-title">{{ t('services.bookAppointment') }}</h3>
                            <p class="modal-subtitle">{{ t('appointment.subtitle') }}</p>
                        </div>
                        <button @click="close" class="close-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="modal-body">
                        <div class="departments-list">
                            <a 
                                v-for="dept in departments" 
                                :key="dept.phone"
                                :href="`tel:${dept.phone.replace(/-/g, '')}`"
                                class="department-card"
                            >
                                <div class="dept-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                                    </svg>
                                </div>
                                <div class="dept-info">
                                    <h4 class="dept-name">{{ dept.name }}</h4>
                                    <p class="dept-hours">{{ dept.hours }}</p>
                                </div>
                                <div class="dept-phone">
                                    <span class="phone-number">{{ dept.phone }}</span>
                                    <span class="call-text">{{ t('appointment.callNow') }}</span>
                                </div>
                            </a>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <p class="footer-note">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/>
                            </svg>
                            {{ t('appointment.footerNote') }} <a href="/contact">{{ t('appointment.contactPage') }}</a> {{ t('appointment.footerNoteEnd') }}
                        </p>
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>

<style scoped>
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(4px);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    padding: 1rem;
}

.modal-container {
    background: #fff;
    border-radius: 20px;
    width: 100%;
    max-width: 550px;
    max-height: 90vh;
    overflow: hidden;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 1.5rem;
    background: linear-gradient(135deg, #6B4C9A 0%, #8B6BAE 100%);
    color: #fff;
}

.modal-title {
    font-size: 1.25rem;
    font-weight: 700;
    margin: 0 0 0.25rem;
}

.modal-subtitle {
    font-size: 0.875rem;
    opacity: 0.9;
    margin: 0;
}

.close-btn {
    background: rgba(255, 255, 255, 0.2);
    border: none;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    cursor: pointer;
    transition: background 0.2s;
}

.close-btn:hover {
    background: rgba(255, 255, 255, 0.3);
}

.modal-body {
    padding: 1rem;
    max-height: 400px;
    overflow-y: auto;
}

.departments-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.department-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    text-decoration: none;
    color: inherit;
    transition: all 0.2s;
}

.department-card:hover {
    background: #fff;
    border-color: #6B4C9A;
    box-shadow: 0 4px 15px rgba(107, 76, 154, 0.15);
    transform: translateY(-2px);
}

.dept-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, rgba(107, 76, 154, 0.1) 0%, rgba(139, 107, 174, 0.1) 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6B4C9A;
    flex-shrink: 0;
}

.dept-info {
    flex: 1;
    min-width: 0;
}

.dept-name {
    font-size: 0.9rem;
    font-weight: 600;
    color: #1e293b;
    margin: 0 0 0.25rem;
}

.dept-hours {
    font-size: 0.75rem;
    color: #64748b;
    margin: 0;
}

.dept-phone {
    text-align: right;
    flex-shrink: 0;
}

.phone-number {
    display: block;
    font-size: 1rem;
    font-weight: 700;
    color: #6B4C9A;
}

.call-text {
    display: block;
    font-size: 0.7rem;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.modal-footer {
    padding: 1rem 1.5rem;
    background: #f8f9fa;
    border-top: 1px solid #e9ecef;
}

.footer-note {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.8rem;
    color: #64748b;
    margin: 0;
}

.footer-note a {
    color: #6B4C9A;
    font-weight: 600;
}

/* Transitions */
.modal-enter-active,
.modal-leave-active {
    transition: all 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
    opacity: 0;
}

.modal-enter-from .modal-container,
.modal-leave-to .modal-container {
    transform: scale(0.9) translateY(20px);
}

@media (max-width: 576px) {
    .modal-container {
        max-height: 85vh;
    }
    
    .department-card {
        flex-wrap: wrap;
    }
    
    .dept-phone {
        width: 100%;
        text-align: left;
        margin-top: 0.5rem;
        padding-top: 0.5rem;
        border-top: 1px dashed #e9ecef;
    }
}
</style>
