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
    blogs: {
        type: Array,
        default: () => [],
    },
    socialLinks: Object,
});

const showAppointmentModal = ref(false);

const formatDate = (dateString) => {
    if (!dateString) return '';
    const date = new Date(dateString);
    return date.toLocaleDateString('mk-MK', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    });
};

// Category colors and translation mapping
const categoryColors = {
    'Здравје': 'bg-danger',
    'Health': 'bg-danger',
    'Естетика': 'bg-success',
    'Aesthetics': 'bg-success',
    'Дијагностика': 'bg-info',
    'Diagnostics': 'bg-info',
};

const categoryTranslations = {
    'Здравје': 'news.categoryHealth',
    'Естетика': 'news.categoryAesthetics',
    'Дијагностика': 'news.categoryDiagnostics',
};

const translateCategory = (category) => {
    const key = categoryTranslations[category];
    return key ? t(key) : category;
};

// Optimize Unsplash URLs for better performance
const optimizeUnsplashUrl = (url) => {
    if (!url || !url.includes('unsplash.com')) return url;
    // Add auto=format for WebP support, q=75 for quality, fit=crop
    const baseUrl = url.split('?')[0];
    return `${baseUrl}?w=600&h=400&fit=crop&auto=format&q=75`;
};

const blogs = computed(() => {
    if (props.blogs && props.blogs.length > 0) {
        return props.blogs.map(blog => ({
            id: blog.id,
            slug: blog.slug,
            title: translateModel(blog, 'title'),
            author: blog.author,
            date: formatDate(blog.published_at),
            category: translateCategory(blog.category),
            categoryColor: categoryColors[blog.category] || 'bg-purple',
            excerpt: translateModel(blog, 'short_description') || translateModel(blog, 'excerpt'),
            image: blog.image ? (blog.image.startsWith('http') ? optimizeUnsplashUrl(blog.image) : `/storage/${blog.image}`) : 'https://images.unsplash.com/photo-1584036561566-baf8f5f1b144?w=600&h=400&fit=crop&auto=format&q=75',
        }));
    }
    return [];
});
</script>

<template>
    <Head>
        <title>Блог и Новости - ПЗУ Медика Струмица | Медицински Совети</title>
        <meta name="description" content="Најнови медицински новости и совети за здравје од специјалистите на ПЗУ Медика Струмица. Информации за Ковид-19, мезотерапија, DEXA скенирање и повеќе." />
        <meta name="keywords" content="медицински блог, здравствени совети, ковид 19 македонија, мезотерапија струмица, dexa scan, остеопороза, естетска медицина блог" />
        <meta name="robots" content="index, follow, max-image-preview:large" />
        <meta name="author" content="ПЗУ Медика" />
        <link rel="canonical" href="https://medica.mk/news" />
        
        <!-- Open Graph -->
        <meta property="og:title" content="Блог и Новости - ПЗУ Медика Струмица" />
        <meta property="og:description" content="Најнови медицински новости и совети за здравје од нашите специјалисти." />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="https://medica.mk/news" />
        <meta property="og:image" content="https://medica.mk/images/og-blog.jpg" />
        <meta property="og:locale" content="mk_MK" />
        <meta property="og:site_name" content="ПЗУ Медика" />
        
        <!-- Twitter -->
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:title" content="Блог и Новости - ПЗУ Медика" />
        <meta name="twitter:description" content="Медицински совети и новости од нашите специјалисти." />
    </Head>
    
    <div class="news-page">
        <Navbar :dark="true" :logo-height="80" active-link="news" @open-appointment="showAppointmentModal = true" />
        
        <!-- Custom Header -->
        <header class="page-header">
            <!-- Hero Content -->
            <div class="container py-5">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-3">
                        <li class="breadcrumb-item"><a href="/" class="text-white-50">{{ t('nav.home') }}</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">{{ t('news.title') }}</li>
                    </ol>
                </nav>
                <h1 class="display-4 fw-bold text-white mb-3">{{ t('home.latestNews') }}</h1>
                <p class="lead text-white-50 mb-0">{{ t('news.subtitle') }}</p>
            </div>
        </header>
        
        <!-- Blog Grid - Full Width Modern Layout -->
        <section class="py-5">
            <div class="container">
                <div class="row g-4">
                    <!-- First two blogs - larger cards side by side -->
                    <div v-for="(blog, index) in blogs.slice(0, 2)" :key="blog.id" class="col-lg-6">
                        <article class="blog-card blog-card-large h-100 bg-white rounded-4 overflow-hidden shadow-sm">
                            <a :href="`/news/${blog.slug}`" class="d-block blog-img-wrapper">
                                <img :src="blog.image" :alt="blog.title" class="blog-img">
                                <span class="badge position-absolute top-0 end-0 m-3 px-3 py-2" :class="blog.categoryColor">
                                    {{ blog.category }}
                                </span>
                            </a>
                            <div class="p-4">
                                <h3 class="fw-bold mb-2">
                                    <a :href="`/news/${blog.slug}`" class="text-decoration-none text-dark blog-title">
                                        {{ blog.title }}
                                    </a>
                                </h3>
                                <p class="text-purple small mb-3 fw-semibold">{{ t('news.author') }} - {{ blog.author }}</p>
                                <p class="text-muted mb-4">{{ blog.excerpt }}</p>
                                <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                    <div class="d-flex align-items-center gap-2 text-muted small">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                                        </svg>
                                        <span>{{ blog.date }}</span>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                    
                    <!-- Third blog - full width horizontal card (only if 3+ blogs) -->
                    <div v-if="blogs.length > 2" class="col-12">
                        <article class="blog-card blog-card-horizontal d-flex flex-column flex-md-row bg-white rounded-4 overflow-hidden shadow-sm">
                            <a :href="`/news/${blogs[2].slug}`" class="blog-img-wrapper-horizontal">
                                <img :src="blogs[2].image" :alt="blogs[2].title" class="blog-img">
                                <span class="badge position-absolute top-0 start-0 m-3 px-3 py-2" :class="blogs[2].categoryColor">
                                    {{ blogs[2].category }}
                                </span>
                            </a>
                            <div class="p-4 d-flex flex-column justify-content-center flex-grow-1">
                                <h3 class="fw-bold mb-2">
                                    <a :href="`/news/${blogs[2].slug}`" class="text-decoration-none text-dark blog-title">
                                        {{ blogs[2].title }}
                                    </a>
                                </h3>
                                <p class="text-purple small mb-3 fw-semibold">{{ t('news.author') }} - {{ blogs[2].author }}</p>
                                <p class="text-muted mb-4">{{ blogs[2].excerpt }}</p>
                                <div class="d-flex align-items-center gap-4">
                                    <div class="d-flex align-items-center gap-2 text-muted small">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                                        </svg>
                                        <span>{{ blogs[2].date }}</span>
                                    </div>
                                    <a :href="`/news/${blogs[2].slug}`" class="btn btn-purple rounded-pill px-4 py-2 ms-auto d-inline-flex align-items-center gap-2">
                                        <span>{{ t('common.readMore') }}</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M5 12h14M12 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </section>
        
        <Footer :socialLinks="socialLinks" />
        
        <AppointmentModal :show="showAppointmentModal" @close="showAppointmentModal = false" />
    </div>
</template>

<style scoped>
.news-page {
    min-height: 100vh;
    background: #F5F5F5;
}

/* Header */
.page-header {
    background: linear-gradient(135deg, #6B4C9A 0%, #8B6BAE 100%);
    padding-top: 100px;
    padding-bottom: 2rem;
}

.navbar-logo {
    height: 40px;
    width: auto;
}

.navbar-dark .nav-link {
    color: rgba(255, 255, 255, 0.8);
}

.navbar-dark .nav-link:hover,
.navbar-dark .nav-link.active {
    color: #fff;
}

.text-purple {
    color: #6B4C9A !important;
}

.btn-purple {
    background: linear-gradient(135deg, #6B4C9A 0%, #8B6BAE 100%);
    color: white;
    border: none;
}

.btn-purple:hover {
    background: linear-gradient(135deg, #5B3C8A 0%, #7B5B9E 100%);
    color: white;
}

/* Blog Cards */
.blog-card {
    transition: all 0.3s ease;
}

.blog-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 50px rgba(107, 76, 154, 0.15) !important;
}

.blog-card-large .blog-img-wrapper {
    height: 280px;
    overflow: hidden;
    position: relative;
    display: block;
}

.blog-card-horizontal .blog-img-wrapper-horizontal {
    width: 400px;
    min-width: 400px;
    height: 280px;
    overflow: hidden;
    position: relative;
    display: block;
}

.blog-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.blog-card:hover .blog-img {
    transform: scale(1.08);
}

.blog-title {
    transition: color 0.3s ease;
}

.blog-title:hover {
    color: #6B4C9A !important;
}

/* Category badges */
.bg-danger {
    background: #dc3545 !important;
}

.bg-success {
    background: #28a745 !important;
}

.bg-info {
    background: #17a2b8 !important;
}

@media (max-width: 991px) {
    .blog-card-horizontal {
        flex-direction: column !important;
    }
    
    .blog-card-horizontal .blog-img-wrapper-horizontal {
        width: 100%;
        min-width: 100%;
        height: 220px;
    }
}

@media (max-width: 767px) {
    .display-4 {
        font-size: 2rem;
    }
    
    .blog-card-large .blog-img-wrapper {
        height: 200px;
    }
}
</style>
