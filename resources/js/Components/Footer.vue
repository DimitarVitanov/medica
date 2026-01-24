<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import { useTranslate } from '@/composables/useTranslate';

const { t } = useTranslate();

const props = defineProps({
    contactData: Object,
    socialLinks: Object,
});

const contact = computed(() => {
    return props.contactData || {
        phone: '034-360-444',
        email: 'info@medica.mk',
        address: 'ул. Вањо Китанов бр. 19, Струмица',
    };
});

const social = computed(() => {
    return props.socialLinks || {
        facebook: '',
        instagram: '',
    };
});

const quickLinks = computed(() => [
    { name: t('nav.home'), href: '/' },
    { name: t('nav.about'), href: '/about-us' },
    { name: t('nav.services'), href: '/services' },
    { name: t('nav.news'), href: '/blogs' },
    { name: t('nav.contact'), href: '/contact' },
]);

const currentYear = new Date().getFullYear();
</script>

<template>
    <footer class="bg-dark text-white pt-5 pb-3">
        <div class="container">
            <div class="row g-4">
                <!-- Brand Column -->
                <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                    <a href="/" class="d-inline-block text-decoration-none mb-3">
                        <img src="/images/logo.png" alt="Медика" class="footer-logo" loading="lazy">
                    </a>
                    <p class="text-white-50 small lh-lg mb-4">
                        {{ t('footer.description') }}
                    </p>
                    
                    <!-- Social Links -->
                    <div class="d-flex gap-2">
                        <a v-if="social.facebook" :href="social.facebook" target="_blank" class="btn btn-outline-light btn-sm rounded-circle p-2" aria-label="Facebook">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a v-if="social.instagram" :href="social.instagram" target="_blank" class="btn btn-outline-light btn-sm rounded-circle p-2" aria-label="Instagram">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div class="col-lg-2 col-md-6 col-6">
                    <h6 class="text-white fw-semibold mb-3 pb-2 border-bottom border-purple">{{ t('footer.quickLinks') }}</h6>
                    <ul class="list-unstyled mb-0">
                        <li v-for="link in quickLinks" :key="link.name" class="mb-2">
                            <Link :href="link.href" class="text-white-50 text-decoration-none small link-hover">
                                {{ link.name }}
                            </Link>
                        </li>
                    </ul>
                </div>
                
                <!-- Services -->
                <div class="col-lg-3 col-md-6 col-6">
                    <h6 class="text-white fw-semibold mb-3 pb-2 border-bottom border-purple">{{ t('nav.services') }}</h6>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><Link href="/services" class="text-white-50 text-decoration-none small link-hover">{{ t('services.generalMedicine') }}</Link></li>
                        <li class="mb-2"><Link href="/services" class="text-white-50 text-decoration-none small link-hover">{{ t('services.psychiatry') }}</Link></li>
                        <li class="mb-2"><Link href="/services" class="text-white-50 text-decoration-none small link-hover">{{ t('services.gynecology') }}</Link></li>
                        <li class="mb-2"><Link href="/services" class="text-white-50 text-decoration-none small link-hover">{{ t('services.laboratory') }}</Link></li>
                        <li class="mb-2"><Link href="/services" class="text-white-50 text-decoration-none small link-hover">{{ t('services.occupationalMedicine') }}</Link></li>
                        <li class="mb-2"><Link href="/services" class="text-white-50 text-decoration-none small link-hover">{{ t('services.familyMedicine') }}</Link></li>
                        <li class="mb-2"><Link href="/services" class="text-white-50 text-decoration-none small link-hover">{{ t('services.aestheticMedicine') }}</Link></li>
                    </ul>
                </div>
                
                <!-- Contact Info -->
                <div class="col-lg-3 col-md-6">
                    <h6 class="text-white fw-semibold mb-3 pb-2 border-bottom border-purple">{{ t('nav.contact') }}</h6>
                    <ul class="list-unstyled mb-4">
                        <li class="d-flex align-items-start gap-2 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-purple flex-shrink-0 mt-1">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
                            </svg>
                            <span class="text-white-50 small">{{ contact.address }}</span>
                        </li>
                        <li class="d-flex align-items-start gap-2 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-purple flex-shrink-0 mt-1">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                            </svg>
                            <span class="text-white-50 small">{{ contact.phone }}</span>
                        </li>
                        <li class="d-flex align-items-start gap-2 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-purple flex-shrink-0 mt-1">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>
                            </svg>
                            <span class="text-white-50 small">{{ contact.email }}</span>
                        </li>
                        <li class="d-flex align-items-start gap-2 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-purple flex-shrink-0 mt-1">
                                <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                            </svg>
                            <div class="text-white-50 small">
                                <strong class="text-white d-block mb-1">{{ t('contact.workingHours') }}</strong>
                                <span>{{ t('contact.monFri') }}: 08:00 - 20:00</span><br>
                                <span>{{ t('contact.sat') }}: 08:00 - 14:00</span>
                            </div>
                        </li>
                    </ul>
                    
                    <!-- CTA Button -->
                    <Link href="/contact" class="btn btn-purple rounded-pill px-4 py-2 d-inline-flex align-items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        <span>{{ t('services.bookAppointment') }}</span>
                    </Link>
                </div>
            </div>
            
            <!-- Divider -->
            <hr class="my-4 border-secondary opacity-25">
            
            <!-- Footer Bottom -->
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="text-white-50 small mb-0">
                        © {{ currentYear }} <strong class="text-white">ПЗУ Медика</strong>. {{ t('footer.allRightsReserved') }}.
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                    <a href="/privacy" class="text-white-50 text-decoration-none small me-3 link-hover">Политика на приватност</a>
                    <a href="/terms" class="text-white-50 text-decoration-none small link-hover">Услови за користење</a>
                </div>
            </div>
        </div>
    </footer>
</template>

<style scoped>
.footer-logo {
    height: 100px;
    width: auto;
}

.text-purple {
    color: #8B6BAE !important;
}

.border-purple {
    border-color: #6B4C9A !important;
}

.btn-purple {
    background: linear-gradient(135deg, #6B4C9A 0%, #8B6BAE 100%);
    color: white;
    border: none;
}

.btn-purple:hover {
    background: linear-gradient(135deg, #5B3C8A 0%, #7B5B9E 100%);
    color: white;
    transform: translateY(-2px);
}

.btn-outline-light:hover {
    background: linear-gradient(135deg, #6B4C9A 0%, #8B6BAE 100%);
    border-color: transparent;
}

.link-hover:hover {
    color: #C9A8E0 !important;
}

.bg-dark {
    background: linear-gradient(180deg, #1a1a2e 0%, #0f0f1a 100%) !important;
}
</style>
