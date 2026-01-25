<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { router } from '@inertiajs/vue3';

const isLoading = ref(false);
const progress = ref(0);
const isFirstLoad = ref(true);

let progressInterval = null;

const startLoading = () => {
    isLoading.value = true;
    progress.value = 0;
    
    progressInterval = setInterval(() => {
        if (progress.value < 90) {
            progress.value += Math.random() * 10;
        }
    }, 100);
};

const finishLoading = () => {
    progress.value = 100;
    clearInterval(progressInterval);
    
    setTimeout(() => {
        isLoading.value = false;
        progress.value = 0;
    }, 600);
};

onMounted(() => {
    // Hide the initial HTML loader when Vue mounts
    const initialLoader = document.getElementById('il');
    if (initialLoader) initialLoader.remove();
    
    // Initial page load - same duration as navigation
    if (isFirstLoad.value) {
        startLoading();
        setTimeout(finishLoading, 800);
        isFirstLoad.value = false;
    }
    
    // Inertia navigation events
    router.on('start', startLoading);
    router.on('finish', finishLoading);
});

onUnmounted(() => {
    router.off('start', startLoading);
    router.off('finish', finishLoading);
    clearInterval(progressInterval);
});
</script>

<template>
    <Transition name="loader">
        <div v-if="isLoading" class="page-loader">
            <div class="loader-backdrop"></div>
            <div class="loader-content">
                <div class="logo-wrapper">
                    <img src="/images/logo.png" alt="Медика" class="loader-logo">
                    <div class="pulse-ring"></div>
                    <div class="pulse-ring delay-1"></div>
                    <div class="pulse-ring delay-2"></div>
                </div>
                <div class="progress-dots">
                    <span class="dot"></span>
                    <span class="dot"></span>
                    <span class="dot"></span>
                </div>
            </div>
        </div>
    </Transition>
</template>

<style scoped>
.page-loader {
    position: fixed;
    inset: 0;
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
}

.loader-backdrop {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, #ffffff 0%, #f8f5fc 100%);
}

.loader-content {
    position: relative;
    z-index: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 2rem;
}

.logo-wrapper {
    position: relative;
    width: 140px;
    height: 140px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.loader-logo {
    width: 90px;
    height: auto;
    position: relative;
    z-index: 2;
    filter: drop-shadow(0 8px 24px rgba(107, 76, 154, 0.25));
    animation: float 2s ease-in-out infinite;
}

.pulse-ring {
    position: absolute;
    inset: 0;
    border-radius: 50%;
    border: 2px solid rgba(107, 76, 154, 0.3);
    animation: pulse-expand 2s ease-out infinite;
}

.pulse-ring.delay-1 {
    animation-delay: 0.4s;
}

.pulse-ring.delay-2 {
    animation-delay: 0.8s;
}

.progress-dots {
    display: flex;
    gap: 8px;
}

.dot {
    width: 10px;
    height: 10px;
    background: linear-gradient(135deg, #6B4C9A 0%, #8B6BAE 100%);
    border-radius: 50%;
    animation: bounce 1.4s ease-in-out infinite;
}

.dot:nth-child(2) {
    animation-delay: 0.2s;
}

.dot:nth-child(3) {
    animation-delay: 0.4s;
}

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-8px); }
}

@keyframes pulse-expand {
    0% {
        transform: scale(0.8);
        opacity: 1;
    }
    100% {
        transform: scale(1.5);
        opacity: 0;
    }
}

@keyframes bounce {
    0%, 80%, 100% {
        transform: scale(0.6);
        opacity: 0.5;
    }
    40% {
        transform: scale(1);
        opacity: 1;
    }
}

/* Loader transition */
.loader-enter-active {
    transition: opacity 0.2s ease;
}

.loader-leave-active {
    transition: opacity 0.5s ease;
}

.loader-enter-from,
.loader-leave-to {
    opacity: 0;
}

.loader-leave-to .loader-logo {
    transform: scale(1.1);
}

.loader-leave-to .pulse-ring {
    opacity: 0;
}
</style>
