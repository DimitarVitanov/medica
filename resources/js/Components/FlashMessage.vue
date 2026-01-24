<script setup>
import { ref, watch, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const show = ref(false);
const message = ref('');
const type = ref('success');

const showMessage = () => {
    const flash = page.props.flash;
    if (flash?.success) {
        message.value = flash.success;
        type.value = 'success';
        show.value = true;
        autoHide();
    } else if (flash?.error) {
        message.value = flash.error;
        type.value = 'error';
        show.value = true;
        autoHide();
    } else if (flash?.warning) {
        message.value = flash.warning;
        type.value = 'warning';
        show.value = true;
        autoHide();
    } else if (flash?.info) {
        message.value = flash.info;
        type.value = 'info';
        show.value = true;
        autoHide();
    }
};

const autoHide = () => {
    setTimeout(() => {
        show.value = false;
    }, 5000);
};

const close = () => {
    show.value = false;
};

onMounted(() => {
    showMessage();
});

watch(() => page.props.flash, () => {
    showMessage();
}, { deep: true });
</script>

<template>
    <Transition name="slide-fade">
        <div v-if="show" class="flash-message" :class="`flash-${type}`">
            <div class="flash-content">
                <div class="flash-icon">
                    <!-- Success -->
                    <svg v-if="type === 'success'" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                    <!-- Error -->
                    <svg v-else-if="type === 'error'" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
                    </svg>
                    <!-- Warning -->
                    <svg v-else-if="type === 'warning'" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                    </svg>
                    <!-- Info -->
                    <svg v-else xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/>
                    </svg>
                </div>
                <span class="flash-text">{{ message }}</span>
            </div>
            <button @click="close" class="flash-close">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>
    </Transition>
</template>

<style scoped>
.flash-message {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    padding: 1rem 1.25rem;
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    min-width: 320px;
    max-width: 500px;
}

.flash-content {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.flash-icon {
    flex-shrink: 0;
}

.flash-text {
    font-size: 0.95rem;
    font-weight: 500;
}

.flash-close {
    background: none;
    border: none;
    cursor: pointer;
    opacity: 0.6;
    transition: opacity 0.2s;
    padding: 0;
    display: flex;
}

.flash-close:hover {
    opacity: 1;
}

/* Success */
.flash-success {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    border: 1px solid #6ee7b7;
    color: #065f46;
}

/* Error */
.flash-error {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    border: 1px solid #f87171;
    color: #991b1b;
}

/* Warning */
.flash-warning {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    border: 1px solid #fbbf24;
    color: #92400e;
}

/* Info */
.flash-info {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    border: 1px solid #60a5fa;
    color: #1e40af;
}

/* Transition */
.slide-fade-enter-active {
    transition: all 0.3s ease-out;
}

.slide-fade-leave-active {
    transition: all 0.3s ease-in;
}

.slide-fade-enter-from {
    transform: translateX(100%);
    opacity: 0;
}

.slide-fade-leave-to {
    transform: translateX(100%);
    opacity: 0;
}

@media (max-width: 576px) {
    .flash-message {
        left: 20px;
        right: 20px;
        min-width: auto;
    }
}
</style>
