<script setup>
import { ref, computed } from 'vue';
import { usePage, router, Link } from '@inertiajs/vue3';
import { useTranslate } from '@/composables/useTranslate';

const { t, locale } = useTranslate();
const page = usePage();

const props = defineProps({
    dark: {
        type: Boolean,
        default: false,
    },
    logoHeight: {
        type: [Number, String],
        default: 100,
    },
    activeLink: {
        type: String,
        default: '',
    },
});

defineEmits(['openAppointment']);

const navLinks = computed(() => [
    { name: t('nav.home'), href: '/', key: 'home' },
    { name: t('nav.about'), href: '/#aboutus', key: 'about' },
    { name: t('nav.services'), href: '/services', key: 'services' },
    { name: t('nav.news'), href: '/news', key: 'news' },
    { name: t('nav.contact'), href: '/contact', key: 'contact' },
]);

const logoStyle = computed(() => ({
    height: typeof props.logoHeight === 'number' ? `${props.logoHeight}px` : props.logoHeight,
}));

const isMenuOpen = ref(false);
const langMenuOpen = ref(false);
const isScrolled = ref(false);

const locales = computed(() => page.props.locales || { mk: 'Македонски', en: 'English' });

// Handle scroll for sticky navbar background
if (typeof window !== 'undefined') {
    window.addEventListener('scroll', () => {
        isScrolled.value = window.scrollY > 50;
    });
}

const switchLocale = (loc) => {
    router.get(window.location.pathname, { lang: loc }, {
        preserveState: true,
        preserveScroll: true,
    });
    langMenuOpen.value = false;
};
</script>

<template>
    <nav class="navbar navbar-expand-lg py-3 position-fixed w-100" :class="{ 'navbar-dark': dark, 'navbar-scrolled': isScrolled }" style="z-index: 1000;">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="/images/logo.png" alt="Медика - Приватна Здравствена Установа" class="navbar-logo" :style="logoStyle">
            </a>
            
            <button 
                class="navbar-toggler border-0" 
                type="button" 
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav"
                aria-controls="navbarNav"
                :aria-expanded="isMenuOpen"
                aria-label="Toggle navigation menu"
                @click="isMenuOpen = !isMenuOpen"
            >
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" :stroke="dark && !isScrolled ? '#fff' : '#333'" stroke-width="2" aria-hidden="true">
                    <line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/>
                </svg>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav" :class="{ show: isMenuOpen }">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item" v-for="link in navLinks" :key="link.key">
                        <Link 
                            class="nav-link px-3" 
                            :class="{ 'active fw-semibold': link.key === activeLink }"
                            :href="link.href"
                        >
                            {{ link.name }}
                        </Link>
                    </li>
                </ul>
                
                <button @click="$emit('openAppointment')" class="btn btn-purple rounded-pill px-4">
                    {{ t('services.bookAppointment') }}
                </button>
                
                <!-- Language Picker -->
                <div class="lang-picker ms-3">
                    <button @click="langMenuOpen = !langMenuOpen" class="lang-btn">
                        <span class="lang-flag">{{ locale === 'mk' ? '🇲🇰' : '🇬🇧' }}</span>
                        <span class="lang-code">{{ locale.toUpperCase() }}</span>
                        <svg class="lang-arrow" :class="{ open: langMenuOpen }" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                    </button>
                    <div v-if="langMenuOpen" class="lang-dropdown">
                        <button 
                            v-for="(name, code) in locales" 
                            :key="code"
                            @click="switchLocale(code)"
                            class="lang-option"
                            :class="{ active: code === locale }"
                        >
                            <span class="lang-flag">{{ code === 'mk' ? '🇲🇰' : '🇬🇧' }}</span>
                            <span class="lang-name">{{ name }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>

<style scoped>
.navbar {
    transition: all 0.3s ease;
}

.navbar-scrolled {
    background: rgba(255, 255, 255, 0.98) !important;
    backdrop-filter: blur(10px);
    box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
    padding-top: 0.5rem !important;
    padding-bottom: 0.5rem !important;
}

.navbar-scrolled .nav-link {
    color: #333 !important;
}

.navbar-scrolled .nav-link:hover,
.navbar-scrolled .nav-link.active {
    color: #6B4C9A !important;
}

.navbar-scrolled.navbar-dark .nav-link {
    color: #333 !important;
}

.navbar-scrolled .navbar-logo {
    height: 60px !important;
}

.navbar-logo {
    width: auto;
    transition: all 0.3s ease;
}

.navbar-logo:hover {
    opacity: 0.85;
}

.nav-link {
    color: #666;
    font-size: 0.9rem;
    font-weight: 500;
}

.nav-link:hover,
.nav-link.active {
    color: #6B4C9A !important;
}

/* Dark mode for navbar on dark backgrounds */
.navbar-dark .nav-link {
    color: rgba(255, 255, 255, 0.85);
}

.navbar-dark .nav-link:hover {
    color: #fff !important;
}

.navbar-dark .btn-purple {
    background: #fff;
    color: #6B4C9A;
}

.navbar-dark .btn-purple:hover {
    background: #f0f0f0;
    color: #5B3C8A;
}

.navbar-dark .lang-btn {
    background: rgba(255, 255, 255, 0.15);
    border-color: rgba(255, 255, 255, 0.3);
}

.navbar-dark .lang-code {
    color: #fff;
}

.btn-purple {
    background: linear-gradient(135deg, #8B6BAE 0%, #6B4C9A 100%);
    color: white;
    border: none;
    font-size: 0.875rem;
    font-weight: 500;
}

.btn-purple:hover {
    background: linear-gradient(135deg, #7A5A9D 0%, #5A3B89 100%);
    color: white;
}

/* Language Picker */
.lang-picker {
    position: relative;
}

.lang-btn {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.5rem 0.75rem;
    background: rgba(255,255,255,0.9);
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s;
    font-size: 0.8rem;
}

.lang-btn:hover {
    border-color: #6B4C9A;
}

.lang-flag {
    font-size: 1rem;
}

.lang-code {
    font-weight: 600;
    color: #1e293b;
}

.lang-arrow {
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
    min-width: 140px;
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.12);
    overflow: hidden;
    z-index: 1001;
}

.lang-option {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    width: 100%;
    padding: 0.65rem 1rem;
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
    background: linear-gradient(135deg, rgba(107, 76, 154, 0.1) 0%, rgba(139, 107, 174, 0.1) 100%);
}

.lang-name {
    font-size: 0.85rem;
    font-weight: 500;
    color: #1e293b;
}

/* Mobile menu styles */
@media (max-width: 991px) {
    .navbar-collapse {
        background: linear-gradient(135deg, #6B4C9A 0%, #8B6BAE 100%);
        padding: 1.5rem;
        border-radius: 12px;
        margin-top: 1rem;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    }
    
    .navbar-collapse .nav-link {
        color: rgba(255, 255, 255, 0.9) !important;
        padding: 0.75rem 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .navbar-collapse .nav-link:hover,
    .navbar-collapse .nav-link.active {
        color: #fff !important;
    }
    
    .navbar-collapse .btn-purple {
        background: #fff;
        color: #6B4C9A;
        width: 100%;
        margin-top: 1rem;
        padding: 0.75rem;
    }
    
    .navbar-collapse .lang-picker {
        margin-top: 1rem;
        margin-left: 0;
    }
    
    .navbar-collapse .lang-btn {
        width: 100%;
        justify-content: center;
        background: rgba(255, 255, 255, 0.15);
        border-color: rgba(255, 255, 255, 0.3);
    }
    
    .navbar-collapse .lang-code {
        color: #fff;
    }
    
    .navbar-collapse .lang-dropdown {
        position: relative;
        top: 0.5rem;
        width: 100%;
    }
}
</style>
