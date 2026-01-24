<script setup>
import { usePage, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const page = usePage();
const isOpen = ref(false);

const currentLocale = computed(() => page.props.locale);
const locales = computed(() => page.props.locales);

const currentLocaleName = computed(() => {
    return locales.value[currentLocale.value] || currentLocale.value;
});

const switchLocale = (locale) => {
    router.get(window.location.pathname, { lang: locale }, {
        preserveState: true,
        preserveScroll: true,
    });
    isOpen.value = false;
};

const toggleDropdown = () => {
    isOpen.value = !isOpen.value;
};

const closeDropdown = () => {
    isOpen.value = false;
};
</script>

<template>
    <div class="lang-picker" v-click-outside="closeDropdown">
        <button @click="toggleDropdown" class="lang-btn">
            <span class="lang-flag">{{ currentLocale === 'mk' ? '🇲🇰' : '🇬🇧' }}</span>
            <span class="lang-code">{{ currentLocale.toUpperCase() }}</span>
            <svg class="lang-arrow" :class="{ open: isOpen }" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="6 9 12 15 18 9"/>
            </svg>
        </button>
        
        <Transition name="dropdown">
            <div v-if="isOpen" class="lang-dropdown">
                <button 
                    v-for="(name, code) in locales" 
                    :key="code"
                    @click="switchLocale(code)"
                    class="lang-option"
                    :class="{ active: code === currentLocale }"
                >
                    <span class="lang-flag">{{ code === 'mk' ? '🇲🇰' : '🇬🇧' }}</span>
                    <span class="lang-name">{{ name }}</span>
                    <svg v-if="code === currentLocale" class="check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                </button>
            </div>
        </Transition>
    </div>
</template>

<style scoped>
.lang-picker {
    position: relative;
}

.lang-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0.75rem;
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s;
}

.lang-btn:hover {
    border-color: #667eea;
}

.lang-flag {
    font-size: 1.1rem;
}

.lang-code {
    font-size: 0.8rem;
    font-weight: 600;
    color: #1e293b;
}

.lang-arrow {
    width: 14px;
    height: 14px;
    color: #64748b;
    transition: transform 0.2s;
}

.lang-arrow.open {
    transform: rotate(180deg);
}

.lang-dropdown {
    position: absolute;
    top: calc(100% + 4px);
    right: 0;
    min-width: 160px;
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    overflow: hidden;
    z-index: 100;
}

.lang-option {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    width: 100%;
    padding: 0.75rem 1rem;
    background: none;
    border: none;
    cursor: pointer;
    transition: background 0.15s;
    text-align: left;
}

.lang-option:hover {
    background: #f8fafc;
}

.lang-option.active {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
}

.lang-name {
    flex: 1;
    font-size: 0.875rem;
    font-weight: 500;
    color: #1e293b;
}

.check-icon {
    width: 16px;
    height: 16px;
    color: #667eea;
}

.dropdown-enter-active,
.dropdown-leave-active {
    transition: all 0.2s ease;
}

.dropdown-enter-from,
.dropdown-leave-to {
    opacity: 0;
    transform: translateY(-8px);
}
</style>
