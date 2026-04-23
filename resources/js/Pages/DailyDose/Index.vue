<script setup>
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import AppointmentModal from '@/Components/AppointmentModal.vue';
import { useTranslate } from '@/composables/useTranslate';
import { useScrollAnimation } from '@/composables/useScrollAnimation';

const { t, translateModel } = useTranslate();
useScrollAnimation();

const props = defineProps({
    doses: { type: Array, default: () => [] },
    workingHours: Object,
    socialLinks: Object,
});

const showAppointmentModal = ref(false);

const formatDate = (dateString) => {
    if (!dateString) return '';
    const date = new Date(dateString);
    return date.toLocaleDateString('mk-MK', { day: '2-digit', month: 'long', year: 'numeric' });
};

const formatDay = (dateString) => {
    if (!dateString) return '';
    return new Date(dateString).getDate();
};

const formatMonth = (dateString) => {
    if (!dateString) return '';
    return new Date(dateString).toLocaleDateString('mk-MK', { month: 'short' }).toUpperCase();
};

const formatYear = (dateString) => {
    if (!dateString) return '';
    return new Date(dateString).getFullYear();
};

const getImageUrl = (image) => {
    if (!image) return null;
    if (image.startsWith('http')) return image;
    return `/storage/${image}`;
};

const items = computed(() => {
    return (props.doses || []).map(dose => ({
        id: dose.id,
        slug: dose.slug,
        title: translateModel(dose, 'title') || dose.title,
        excerpt: translateModel(dose, 'excerpt') || dose.excerpt || '',
        image: getImageUrl(dose.image),
        author: dose.author,
        category: dose.category,
        date: formatDate(dose.published_at),
        day: formatDay(dose.published_at),
        month: formatMonth(dose.published_at),
        year: formatYear(dose.published_at),
        views: dose.views,
    }));
});

const doseListSchema = computed(() => JSON.stringify({
    "@context": "https://schema.org",
    "@type": "CollectionPage",
    "name": "Дневна Доза - ПЗУ Медика Струмица",
    "description": "Најнови случувања и новости од ПЗУ Медика.",
    "url": "https://medica.mk/daily-dose",
    "publisher": { "@type": "Organization", "name": "ПЗУ Медика", "@id": "https://medica.mk/#organization" },
    "breadcrumb": {
        "@type": "BreadcrumbList",
        "itemListElement": [
            { "@type": "ListItem", "position": 1, "name": "Почетна", "item": "https://medica.mk" },
            { "@type": "ListItem", "position": 2, "name": "Дневна Доза", "item": "https://medica.mk/daily-dose" }
        ]
    }
}));

// Group by year + month for timeline sections
const groupedByMonth = computed(() => {
    const groups = {};
    items.value.forEach(item => {
        const key = `${item.year}-${item.month}`;
        if (!groups[key]) {
            groups[key] = { label: `${item.month} ${item.year}`, items: [] };
        }
        groups[key].items.push(item);
    });
    return Object.values(groups);
});
</script>

<template>
    <Head>
        <title>{{ t('dailyDose.title') }} - ПЗУ Медика Струмица</title>
        <meta name="description" :content="t('dailyDose.latestUpdates')" />
        <meta name="keywords" content="медика струмица, дневна доза, новости клиника, настани медика" />
        <meta name="robots" content="index, follow" />
        <link rel="canonical" href="https://medica.mk/daily-dose" />
        <meta property="og:title" :content="`${t('dailyDose.title')} - ПЗУ Медика`" />
        <meta property="og:description" :content="t('dailyDose.latestUpdates')" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="https://medica.mk/daily-dose" />
        <meta property="og:locale" content="mk_MK" />
        <meta property="og:site_name" content="ПЗУ Медика" />

        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:title" :content="`${t('dailyDose.title')} - ПЗУ Медика`" />
        <meta name="twitter:description" :content="t('dailyDose.latestUpdates')" />
        <meta name="twitter:image" content="https://medica.mk/images/logo.webp" />

        <component :is="'script'" type="application/ld+json" v-html="doseListSchema" />
    </Head>

    <div class="dd-page">
        <Navbar :dark="true" :logo-height="80" active-link="dailyDose" @open-appointment="showAppointmentModal = true" />

        <!-- Header -->
        <header class="dd-header">
            <div class="container py-5">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-3">
                        <li class="breadcrumb-item"><a href="/" class="text-white-50">{{ t('nav.home') }}</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">{{ t('dailyDose.title') }}</li>
                    </ol>
                </nav>
                <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="dd-header-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 22h16a2 2 0 002-2V4a2 2 0 00-2-2H8a2 2 0 00-2 2v16a2 2 0 01-2 2zm0 0a2 2 0 01-2-2v-9c0-1.1.9-2 2-2h2"/><path d="M18 14h-8"/><path d="M15 18h-5"/><path d="M10 6h8v4h-8z"/></svg>
                    </div>
                    <h1 class="display-5 fw-bold text-white mb-0">{{ t('dailyDose.title') }}</h1>
                </div>
                <p class="lead text-white-50 mb-0">{{ t('dailyDose.subtitle') }}</p>
            </div>
        </header>

        <!-- Timeline Content -->
        <section class="dd-timeline-section py-5">
            <div class="container">
                <!-- Empty State -->
                <div v-if="items.length === 0" class="text-center py-5">
                    <div class="dd-empty-icon mb-4">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="1"><path d="M4 22h16a2 2 0 002-2V4a2 2 0 00-2-2H8a2 2 0 00-2 2v16a2 2 0 01-2 2zm0 0a2 2 0 01-2-2v-9c0-1.1.9-2 2-2h2"/><path d="M18 14h-8"/><path d="M15 18h-5"/><path d="M10 6h8v4h-8z"/></svg>
                    </div>
                    <h4 class="text-muted">{{ t('dailyDose.noPostsYet') }}</h4>
                </div>

                <!-- Timeline -->
                <div v-else class="dd-timeline">
                    <div v-for="(group, gi) in groupedByMonth" :key="gi" class="dd-timeline-group">
                        <!-- Month Label -->
                        <div class="dd-month-label" data-animate="fade-up">
                            <span>{{ group.label }}</span>
                        </div>

                        <!-- Timeline Items -->
                        <div v-for="(item, idx) in group.items" :key="item.id"
                             class="dd-timeline-item" :class="{ 'dd-right': idx % 2 !== 0 }"
                             data-animate="fade-up">
                            <!-- Date Marker -->
                            <div class="dd-date-marker">
                                <div class="dd-date-day">{{ item.day }}</div>
                                <div class="dd-date-month">{{ item.month }}</div>
                            </div>

                            <!-- Card -->
                            <a :href="`/daily-dose/${item.slug}`" class="dd-card">
                                <div v-if="item.image" class="dd-card-img-wrap">
                                    <img :src="item.image" :alt="item.title" class="dd-card-img" loading="lazy">
                                </div>
                                <div class="dd-card-body">
                                    <div class="dd-card-meta">
                                        <span v-if="item.category" class="dd-card-tag">{{ item.category }}</span>
                                        <span class="dd-card-date">{{ item.date }}</span>
                                    </div>
                                    <h3 class="dd-card-title">{{ item.title }}</h3>
                                    <p v-if="item.excerpt" class="dd-card-excerpt">{{ item.excerpt }}</p>
                                    <div class="dd-card-footer">
                                        <span class="dd-card-author">{{ item.author }}</span>
                                        <span class="dd-card-read">{{ t('dailyDose.readMore') }} →</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <Footer :socialLinks="socialLinks" @open-appointment="showAppointmentModal = true" />
        <AppointmentModal :show="showAppointmentModal" :workingHours="workingHours" @close="showAppointmentModal = false" />
    </div>
</template>

<style scoped>
.dd-page {
    min-height: 100vh;
    background: #FAFAFA;
}

/* Header */
.dd-header {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
    padding-top: 100px;
    padding-bottom: 2rem;
}

.dd-header-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: rgba(255,255,255,0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #e2e8f0;
}

/* Timeline */
.dd-timeline-section {
    background: #FAFAFA;
}

.dd-timeline {
    position: relative;
    max-width: 900px;
    margin: 0 auto;
}

.dd-timeline::before {
    content: '';
    position: absolute;
    left: 50%;
    top: 0;
    bottom: 0;
    width: 2px;
    background: linear-gradient(to bottom, #6B4C9A 0%, #e0d6f0 100%);
    transform: translateX(-50%);
}

/* Month Label */
.dd-month-label {
    text-align: center;
    position: relative;
    z-index: 2;
    margin: 2.5rem 0 2rem;
}

.dd-month-label span {
    display: inline-block;
    padding: 0.4rem 1.5rem;
    background: linear-gradient(135deg, #6B4C9A 0%, #8B6BAE 100%);
    color: white;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    font-family: 'Georgia', serif;
}

/* Timeline Item */
.dd-timeline-item {
    position: relative;
    display: flex;
    align-items: flex-start;
    gap: 2rem;
    margin-bottom: 2.5rem;
    padding-right: calc(50% + 2rem);
}

.dd-timeline-item.dd-right {
    flex-direction: row-reverse;
    padding-right: 0;
    padding-left: calc(50% + 2rem);
}

/* Date Marker */
.dd-date-marker {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    width: 52px;
    height: 52px;
    border-radius: 50%;
    background: white;
    border: 3px solid #6B4C9A;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    z-index: 2;
    box-shadow: 0 2px 10px rgba(107, 76, 154, 0.15);
}

.dd-date-day {
    font-size: 1rem;
    font-weight: 800;
    color: #6B4C9A;
    line-height: 1;
}

.dd-date-month {
    font-size: 0.55rem;
    font-weight: 700;
    color: #8B6BAE;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Card */
.dd-card {
    display: block;
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 2px 20px rgba(0,0,0,0.06);
    text-decoration: none;
    color: inherit;
    transition: all 0.3s ease;
    flex: 1;
    border: 1px solid rgba(107, 76, 154, 0.08);
}

.dd-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 40px rgba(107, 76, 154, 0.12);
    border-color: rgba(107, 76, 154, 0.15);
}

.dd-card-img-wrap {
    height: 200px;
    overflow: hidden;
    position: relative;
}

.dd-card-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.dd-card:hover .dd-card-img {
    transform: scale(1.05);
}

.dd-card-body {
    padding: 1.25rem 1.5rem 1.5rem;
}

.dd-card-meta {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 0.75rem;
}

.dd-card-tag {
    display: inline-block;
    padding: 0.2rem 0.75rem;
    background: rgba(107, 76, 154, 0.08);
    color: #6B4C9A;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}

.dd-card-date {
    font-size: 0.78rem;
    color: #999;
    font-family: 'Georgia', serif;
    font-style: italic;
}

.dd-card-title {
    font-size: 1.15rem;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 0.5rem;
    line-height: 1.4;
    font-family: 'Georgia', serif;
}

.dd-card-excerpt {
    font-size: 0.9rem;
    color: #666;
    line-height: 1.6;
    margin-bottom: 1rem;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.dd-card-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 0.75rem;
    border-top: 1px solid #f0f0f0;
}

.dd-card-author {
    font-size: 0.8rem;
    color: #999;
    font-weight: 500;
}

.dd-card-read {
    font-size: 0.82rem;
    color: #6B4C9A;
    font-weight: 600;
    transition: color 0.2s;
}

.dd-card:hover .dd-card-read {
    color: #5B3C8A;
}

/* Responsive */
@media (max-width: 767px) {
    .dd-timeline::before {
        left: 24px;
    }

    .dd-timeline-item,
    .dd-timeline-item.dd-right {
        flex-direction: row;
        padding-right: 0;
        padding-left: 60px;
        gap: 0;
    }

    .dd-date-marker {
        left: 24px;
        width: 44px;
        height: 44px;
    }

    .dd-date-day {
        font-size: 0.85rem;
    }

    .dd-date-month {
        font-size: 0.5rem;
    }

    .dd-month-label {
        margin: 1.5rem 0 1rem;
    }

    .dd-card-img-wrap {
        height: 160px;
    }

    .dd-card-title {
        font-size: 1rem;
    }

    .dd-card-body {
        padding: 1rem;
    }

    .display-5 {
        font-size: 1.75rem;
    }
}
</style>
