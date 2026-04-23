<script setup>
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import AppointmentModal from '@/Components/AppointmentModal.vue';
import { useTranslate } from '@/composables/useTranslate';
import { absoluteSiteUrl } from '@/composables/useAbsoluteSiteUrl';

const { t, translateModel } = useTranslate();

const props = defineProps({
    dose: Object,
    recentDoses: { type: Array, default: () => [] },
    workingHours: Object,
    socialLinks: Object,
});

const showAppointmentModal = ref(false);

const formatDate = (dateString) => {
    if (!dateString) return '';
    const date = new Date(dateString);
    return date.toLocaleDateString('mk-MK', { day: '2-digit', month: 'long', year: 'numeric' });
};

const getImageUrl = (image) => {
    if (!image) return null;
    if (image.startsWith('http')) return image;
    return `/storage/${image}`;
};

const dose = computed(() => ({
    id: props.dose.id,
    slug: props.dose.slug,
    title: translateModel(props.dose, 'title') || props.dose.title,
    content: translateModel(props.dose, 'content') || props.dose.content || '',
    excerpt: translateModel(props.dose, 'excerpt') || props.dose.excerpt || '',
    image: getImageUrl(props.dose.image),
    author: props.dose.author,
    category: props.dose.category,
    date: formatDate(props.dose.published_at),
    views: props.dose.views,
}));

const doseImageAbsolute = computed(() => absoluteSiteUrl(dose.value.image));

const articleSchema = computed(() => JSON.stringify({
    "@context": "https://schema.org",
    "@type": "Article",
    "headline": dose.value.title,
    "description": dose.value.excerpt || dose.value.content.replace(/<[^>]*>/g, '').substring(0, 155),
    "image": doseImageAbsolute.value || undefined,
    "author": { "@type": "Organization", "name": dose.value.author || "ПЗУ Медика" },
    "publisher": {
        "@type": "Organization",
        "name": "ПЗУ Медика",
        "logo": { "@type": "ImageObject", "url": "https://medica.mk/images/logo.webp" }
    },
    "datePublished": props.dose.published_at,
    "dateModified": props.dose.updated_at || props.dose.published_at,
    "mainEntityOfPage": `https://medica.mk/daily-dose/${dose.value.slug}`,
    "inLanguage": "mk"
}));

const breadcrumbSchema = computed(() => JSON.stringify({
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
        { "@type": "ListItem", "position": 1, "name": "Почетна", "item": "https://medica.mk" },
        { "@type": "ListItem", "position": 2, "name": "Дневна Доза", "item": "https://medica.mk/daily-dose" },
        { "@type": "ListItem", "position": 3, "name": dose.value.title, "item": `https://medica.mk/daily-dose/${dose.value.slug}` }
    ]
}));

const recent = computed(() => {
    return (props.recentDoses || []).map(d => ({
        id: d.id,
        slug: d.slug,
        title: translateModel(d, 'title') || d.title,
        excerpt: translateModel(d, 'excerpt') || d.excerpt || '',
        image: getImageUrl(d.image),
        date: formatDate(d.published_at),
        category: d.category,
    }));
});
</script>

<template>
    <Head>
        <title>{{ dose.title }} - {{ t('dailyDose.title') }} | ПЗУ Медика</title>
        <meta name="description" :content="dose.excerpt || dose.content.replace(/<[^>]*>/g, '').substring(0, 155)" />
        <meta name="keywords" :content="`${dose.title}, дневна доза медика, поликлиника медика, ПЗУ Медика Струмица, ${dose.category || ''}`" />
        <meta name="robots" content="index, follow, max-image-preview:large" />
        <meta name="author" :content="dose.author" />
        <link rel="canonical" :href="`https://medica.mk/daily-dose/${dose.slug}`" />
        <meta property="og:title" :content="`${dose.title} - ПЗУ Медика`" />
        <meta property="og:description" :content="dose.excerpt || dose.content.replace(/<[^>]*>/g, '').substring(0, 155)" />
        <meta property="og:type" content="article" />
        <meta property="og:url" :content="`https://medica.mk/daily-dose/${dose.slug}`" />
        <meta property="og:image" v-if="doseImageAbsolute" :content="doseImageAbsolute" />
        <meta property="og:locale" content="mk_MK" />
        <meta property="og:site_name" content="ПЗУ Медика" />
        <meta property="article:author" :content="dose.author" />

        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:title" :content="`${dose.title} - ПЗУ Медика`" />
        <meta name="twitter:description" :content="dose.excerpt || dose.content.replace(/<[^>]*>/g, '').substring(0, 120)" />
        <meta name="twitter:image" v-if="doseImageAbsolute" :content="doseImageAbsolute" />

        <component :is="'script'" type="application/ld+json" v-html="articleSchema" />
        <component :is="'script'" type="application/ld+json" v-html="breadcrumbSchema" />
    </Head>

    <div class="dd-show-page">
        <Navbar :dark="true" :logo-height="80" @open-appointment="showAppointmentModal = true" />

        <!-- Hero -->
        <section v-if="dose.image" class="dd-hero position-relative">
            <img :src="dose.image" :alt="dose.title" class="dd-hero-img">
            <div class="dd-hero-overlay"></div>
            <div class="container position-relative h-100 d-flex align-items-end pb-5">
                <div class="text-white pb-3">
                    <span v-if="dose.category" class="badge bg-white text-purple mb-3 px-3 py-2">{{ dose.category }}</span>
                    <h1 class="dd-hero-title mb-2">{{ dose.title }}</h1>
                    <div class="d-flex align-items-center gap-3 text-white-50 small">
                        <span>{{ dose.author }}</span>
                        <span>•</span>
                        <span>{{ dose.date }}</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- No-image header -->
        <section v-else class="dd-header-simple">
            <div class="container py-5">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-3">
                        <li class="breadcrumb-item"><a href="/" class="text-white-50">{{ t('nav.home') }}</a></li>
                        <li class="breadcrumb-item"><a href="/daily-dose" class="text-white-50">{{ t('dailyDose.title') }}</a></li>
                        <li class="breadcrumb-item active text-white">{{ dose.title }}</li>
                    </ol>
                </nav>
                <span v-if="dose.category" class="badge bg-white text-purple mb-3 px-3 py-2">{{ dose.category }}</span>
                <h1 class="display-5 fw-bold text-white mb-2">{{ dose.title }}</h1>
                <div class="d-flex align-items-center gap-3 text-white-50">
                    <span>{{ dose.author }}</span>
                    <span>•</span>
                    <span>{{ dose.date }}</span>
                </div>
            </div>
        </section>

        <!-- Content -->
        <section class="py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <!-- Breadcrumb (if hero image) -->
                        <nav v-if="dose.image" aria-label="breadcrumb" class="mb-4">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/" class="text-purple">{{ t('nav.home') }}</a></li>
                                <li class="breadcrumb-item"><a href="/daily-dose" class="text-purple">{{ t('dailyDose.title') }}</a></li>
                                <li class="breadcrumb-item active">{{ dose.title }}</li>
                            </ol>
                        </nav>

                        <article class="dd-article bg-white rounded-4 shadow-sm p-4 p-lg-5">
                            <div v-html="dose.content" class="dd-article-body"></div>

                            <!-- Footer -->
                            <div class="border-top pt-4 mt-5">
                                <div class="d-flex justify-content-end">
                                    <a href="/daily-dose" class="btn btn-purple rounded-pill px-4 py-2 d-inline-flex align-items-center gap-2">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                                        <span>{{ t('dailyDose.backToTimeline') }}</span>
                                    </a>
                                </div>
                            </div>
                        </article>

                        <!-- Recent Posts -->
                        <div v-if="recent.length > 0" class="mt-5">
                            <h4 class="fw-bold mb-4" style="font-family: 'Georgia', serif;">{{ t('dailyDose.recentPosts') }}</h4>
                            <div class="row g-4">
                                <div v-for="r in recent" :key="r.id" class="col-md-4">
                                    <a :href="`/daily-dose/${r.slug}`" class="dd-recent-card d-block bg-white rounded-4 overflow-hidden shadow-sm h-100 text-decoration-none">
                                        <div v-if="r.image" class="dd-recent-img-wrap">
                                            <img :src="r.image" :alt="r.title" class="dd-recent-img" loading="lazy">
                                        </div>
                                        <div class="p-3">
                                            <span v-if="r.category" class="badge bg-purple-soft text-purple small mb-2">{{ r.category }}</span>
                                            <h6 class="fw-bold mb-1 text-dark">{{ r.title }}</h6>
                                            <small class="text-muted">{{ r.date }}</small>
                                        </div>
                                    </a>
                                </div>
                            </div>
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
.dd-show-page {
    min-height: 100vh;
    background: #F8F9FA;
}

.text-purple { color: #6B4C9A !important; }
.bg-purple-soft { background-color: rgba(107, 76, 154, 0.1) !important; }

.btn-purple {
    background: linear-gradient(135deg, #6B4C9A 0%, #8B6BAE 100%);
    color: white;
    border: none;
}
.btn-purple:hover {
    background: linear-gradient(135deg, #5B3C8A 0%, #7B5B9E 100%);
    color: white;
}

/* Hero with image */
.dd-hero {
    height: 500px;
    overflow: hidden;
    padding-top: 100px;
}

.dd-hero-img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center 30%;
}

.dd-hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(26,26,46,0.9) 0%, rgba(26,26,46,0.4) 50%, rgba(26,26,46,0.1) 100%);
}

.dd-hero-title {
    font-size: 2.25rem;
    font-weight: 800;
    font-family: 'Georgia', serif;
    line-height: 1.3;
}

/* No-image header */
.dd-header-simple {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
    padding-top: 100px;
    padding-bottom: 2rem;
}

/* Article */
.dd-article-body :deep(h2),
.dd-article-body :deep(h3),
.dd-article-body :deep(h4) {
    color: #1a1a2e;
    font-family: 'Georgia', serif;
    margin-top: 1.5rem;
    margin-bottom: 0.75rem;
    font-weight: 700;
}

.dd-article-body :deep(p) {
    line-height: 1.8;
    color: #444;
    margin-bottom: 1rem;
}

.dd-article-body :deep(ul),
.dd-article-body :deep(ol) {
    padding-left: 1.5rem;
    margin-bottom: 1rem;
}

.dd-article-body :deep(li) {
    margin-bottom: 0.4rem;
    line-height: 1.7;
}

.dd-article-body :deep(blockquote) {
    border-left: 3px solid #6B4C9A;
    padding-left: 1rem;
    margin: 1.5rem 0;
    color: #666;
    font-style: italic;
    font-family: 'Georgia', serif;
}

.dd-article-body :deep(a) {
    color: #6B4C9A;
    text-decoration: underline;
}

/* Recent Cards */
.dd-recent-card {
    transition: all 0.3s ease;
}

.dd-recent-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(107, 76, 154, 0.12) !important;
}

.dd-recent-img-wrap {
    height: 130px;
    overflow: hidden;
}

.dd-recent-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.dd-recent-card:hover .dd-recent-img {
    transform: scale(1.05);
}

@media (max-width: 767px) {
    .dd-hero {
        height: 380px;
    }

    .dd-hero-title {
        font-size: 1.5rem;
    }

    .display-5 {
        font-size: 1.5rem;
    }
}
</style>
