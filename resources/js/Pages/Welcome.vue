<script setup>
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';
import HeroSlider from '@/Components/HeroSlider.vue';
import AboutUs from '@/Components/AboutUs.vue';
import ServicesSection from '@/Components/ServicesSection.vue';
import NewsSection from '@/Components/NewsSection.vue';
import DailyDoseSection from '@/Components/DailyDoseSection.vue';
import WorkingHours from '@/Components/WorkingHours.vue';
import NewsletterSubscription from '@/Components/NewsletterSubscription.vue';
import Footer from '@/Components/Footer.vue';
import AppointmentModal from '@/Components/AppointmentModal.vue';
import { useScrollAnimation } from '@/composables/useScrollAnimation';

useScrollAnimation();

const props = defineProps({
    sliders: Array,
    services: Array,
    blogs: Array,
    dailyDoses: Array,
    aboutUs: Object,
    stats: Object,
    workingHours: Object,
    contactInfo: Object,
    socialLinks: Object,
    seo: Object,
});

const showAppointmentModal = ref(false);
</script>

<template>
    <Head :title="seo?.title || 'ПЗУ Медика - Приватна Здравствена Установа'">
        <meta name="description" :content="seo?.description || 'ПЗУ Медика - Приватна здравствена установа во Струмица.'">
        <meta name="keywords" :content="seo?.keywords || 'медика, поликлиника медика, поликлиника медика струмица, ПЗУ Медика, клиника струмица, доктор струмица, здравје, приватна болница струмица'">
        <meta property="og:title" :content="seo?.title || 'ПЗУ Медика'">
        <meta property="og:description" :content="seo?.description || 'Приватна здравствена установа во Струмица.'">
        <meta property="og:image" :content="seo?.og_image || '/images/logo.webp'">
        <meta property="og:type" content="website">
    </Head>
    
    <div>
        <Navbar :logo-height="100" active-link="home" @open-appointment="showAppointmentModal = true" />
        <HeroSlider :sliders="sliders" @open-appointment="showAppointmentModal = true" />
        <div data-animate="fade-up">
            <AboutUs :aboutData="aboutUs" :statsData="stats" />
        </div>
        <div data-animate="fade-up" class="d-none">
            <ServicesSection :services="services" />
        </div>
        <div data-animate="fade-up">
            <NewsSection :blogs="blogs" />
        </div>
        <div data-animate="fade-up">
            <DailyDoseSection :doses="dailyDoses" />
        </div>
        <div data-animate="fade-up">
            <NewsletterSubscription variant="light" />
        </div>
         <WorkingHours :workingData="workingHours" />
        <Footer :contactData="contactInfo" :socialLinks="socialLinks" @open-appointment="showAppointmentModal = true" />
        
        <AppointmentModal :show="showAppointmentModal" :workingHours="workingHours" @close="showAppointmentModal = false" />
    </div>
</template>
