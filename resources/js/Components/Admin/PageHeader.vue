<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    title: String,
    subtitle: String,
    backLink: String,
    backText: {
        type: String,
        default: 'Назад'
    }
});
</script>

<template>
    <div class="page-header">
        <div class="header-left">
            <Link v-if="backLink" :href="backLink" class="back-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                <span>{{ backText }}</span>
            </Link>
            <div class="header-text">
                <h1 class="page-title">{{ title }}</h1>
                <p v-if="subtitle" class="page-subtitle">{{ subtitle }}</p>
            </div>
        </div>
        <div class="header-right">
            <slot name="actions" />
        </div>
    </div>
</template>

<style scoped>
.page-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 1rem;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.back-btn {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.5rem 0.75rem;
    border-radius: 8px;
    background: #f3f4f6;
    color: #6b7280;
    font-size: 0.8rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s ease;
}

.back-btn:hover {
    background: #e5e7eb;
    color: #374151;
}

.header-text {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.page-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1a1c23;
    margin: 0;
}

.page-subtitle {
    font-size: 0.875rem;
    color: #6b7280;
    margin: 0;
}

.header-right {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}
</style>
