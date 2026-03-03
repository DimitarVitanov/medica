<script setup>
import { ref, computed } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { useTranslate } from '@/composables/useTranslate';

const props = defineProps({
    variant: {
        type: String,
        default: 'purple',
        validator: (v) => ['purple', 'light'].includes(v),
    },
});

const { t } = useTranslate();
const page = usePage();

const form = useForm({
    email: '',
});

const subscribed = computed(() => page.props.flash?.subscribed === true);
const showSuccess = ref(false);

const submit = () => {
    form.post('/subscribe', {
        preserveScroll: true,
        onSuccess: () => {
            showSuccess.value = true;
            form.reset();
        },
    });
};
</script>

<template>
    <section class="newsletter-section py-5" :class="variant === 'light' ? 'variant-light' : 'variant-purple text-white'">
        <div class="container text-center py-4">
            <!-- Success State -->
            <div v-if="showSuccess || subscribed" class="success-state">
                <div class="success-icon mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                </div>
                <h2 class="display-6 fw-bold mb-3">{{ t('newsletter.successTitle') }}</h2>
                <p class="lead mb-0" :class="variant === 'light' ? 'text-muted' : 'opacity-75'">{{ t('newsletter.successMessage') }}</p>
            </div>

            <!-- Subscribe Form -->
            <div v-else>
                <div class="newsletter-icon mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                        <polyline points="22,6 12,13 2,6"/>
                    </svg>
                </div>
                <h2 class="display-6 fw-bold mb-3">{{ t('newsletter.title') }}</h2>
                <p class="lead mb-4" :class="variant === 'light' ? 'text-muted' : 'opacity-75'">{{ t('newsletter.subtitle') }}</p>
                
                <form @submit.prevent="submit" class="newsletter-form mx-auto">
                    <div class="input-group input-group-lg">
                        <input 
                            v-model="form.email" 
                            type="email" 
                            class="form-control newsletter-input" 
                            :placeholder="t('newsletter.placeholder')"
                            required
                        />
                        <button 
                            type="submit" 
                            class="btn fw-bold px-4" 
                            :class="variant === 'light' ? 'btn-purple text-white' : 'btn-light text-purple'"
                            :disabled="form.processing"
                        >
                            <span v-if="form.processing">{{ t('newsletter.subscribing') }}</span>
                            <span v-else class="d-flex align-items-center justify-content-center gap-2">
                                {{ t('newsletter.subscribe') }}
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="5" y1="12" x2="19" y2="12"/>
                                    <polyline points="12 5 19 12 12 19"/>
                                </svg>
                            </span>
                        </button>
                    </div>
                    <div v-if="form.errors.email" class="mt-2 small" :class="variant === 'light' ? 'text-danger' : 'text-warning'">
                        <span v-if="form.errors.email.includes('taken') || form.errors.email.includes('unique')">
                            {{ t('newsletter.alreadySubscribed') }}
                        </span>
                        <span v-else>{{ t('newsletter.invalidEmail') }}</span>
                    </div>
                </form>
            </div>
        </div>
    </section>
</template>

<style scoped>
.variant-purple {
    background: linear-gradient(135deg, #6B4C9A 0%, #8B6BAE 100%);
}

.variant-light {
    background: #f8f9fa;
    color: #1e293b;
}

.variant-light .newsletter-icon,
.variant-light .success-icon {
    color: #6B4C9A;
}

.newsletter-icon,
.success-icon {
    opacity: 0.9;
}

.variant-purple .success-state .success-icon {
    color: #a5f3a6;
}

.variant-light .success-state .success-icon {
    color: #16a34a;
}

.newsletter-form {
    max-width: 520px;
}

.newsletter-input {
    border-radius: 50px 0 0 50px !important;
    padding: 0.75rem 1.5rem;
    font-size: 1rem;
}

.variant-purple .newsletter-input {
    border: none;
}

.variant-light .newsletter-input {
    border: 2px solid #dee2e6;
}

.btn-purple {
    background: linear-gradient(135deg, #6B4C9A 0%, #8B6BAE 100%);
    border: none;
}

.btn-purple:hover {
    background: linear-gradient(135deg, #5B3C8A 0%, #7B5B9E 100%);
    color: white;
}

.newsletter-input:focus {
    box-shadow: none;
    outline: none;
}

.newsletter-form .btn {
    border-radius: 0 50px 50px 0 !important;
    white-space: nowrap;
}

.text-purple {
    color: #6B4C9A !important;
}

@media (max-width: 575px) {
    .newsletter-form {
        max-width: 100%;
        padding: 0 0.5rem;
    }

    .newsletter-form .input-group {
        flex-direction: column;
        width: 100%;
    }
    
    .newsletter-input {
        border-radius: 50px !important;
        margin-bottom: 0.75rem;
        width: 100% !important;
    }
    
    .newsletter-form .btn {
        border-radius: 50px !important;
        width: 100%;
        display: flex !important;
        align-items: center;
        justify-content: center;
    }

    .newsletter-form .btn span {
        width: 100%;
        justify-content: center;
    }
}
</style>
