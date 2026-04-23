<script setup>
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import AppointmentModal from '@/Components/AppointmentModal.vue';
import { useTranslate } from '@/composables/useTranslate';

const { t, translateModel } = useTranslate();

const props = defineProps({
    slug: {
        type: String,
        default: ''
    },
    blog: Object,
    relatedBlogs: Array,
    workingHours: Object,
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

// Category translation mapping
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
const optimizeUnsplashUrl = (url, width = 1200, height = 600) => {
    if (!url || !url.includes('unsplash.com')) return url;
    const baseUrl = url.split('?')[0];
    return `${baseUrl}?w=${width}&h=${height}&fit=crop&auto=format&q=80`;
};

// Use blog from props (database) with translations
const blog = computed(() => {
    if (props.blog) {
        return {
            id: props.blog.id,
            slug: props.blog.slug,
            title: translateModel(props.blog, 'title'),
            author: props.blog.author,
            date: formatDate(props.blog.published_at),
            category: translateCategory(props.blog.category),
            image: props.blog.image ? (props.blog.image.startsWith('http') ? optimizeUnsplashUrl(props.blog.image, 1200, 600) : `/storage/${props.blog.image}`) : 'https://images.unsplash.com/photo-1584036561566-baf8f5f1b144?w=1200&h=600&fit=crop&auto=format&q=80',
            content: translateModel(props.blog, 'description') || props.blog.content || '',
            excerpt: translateModel(props.blog, 'short_description') || translateModel(props.blog, 'excerpt') || props.blog.excerpt || '',
        };
    }
    return null;
});

const articleSchema = computed(() => {
    if (!blog.value) return '';
    return JSON.stringify({
        "@context": "https://schema.org",
        "@type": "Article",
        "headline": blog.value.title,
        "description": blog.value.excerpt || blog.value.content.replace(/<[^>]*>/g, '').substring(0, 155),
        "image": blog.value.image,
        "author": {
            "@type": "Person",
            "name": blog.value.author
        },
        "publisher": {
            "@type": "Organization",
            "name": "ПЗУ Медика",
            "logo": { "@type": "ImageObject", "url": "https://medica.mk/images/logo.webp" }
        },
        "datePublished": props.blog.published_at,
        "dateModified": props.blog.updated_at || props.blog.published_at,
        "mainEntityOfPage": `https://medica.mk/news/${blog.value.slug}`,
        "articleSection": blog.value.category,
        "inLanguage": "mk"
    });
});

const breadcrumbSchema = computed(() => {
    if (!blog.value) return '';
    return JSON.stringify({
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [
            { "@type": "ListItem", "position": 1, "name": "Почетна", "item": "https://medica.mk" },
            { "@type": "ListItem", "position": 2, "name": "Блог", "item": "https://medica.mk/news" },
            { "@type": "ListItem", "position": 3, "name": blog.value.title, "item": `https://medica.mk/news/${blog.value.slug}` }
        ]
    });
});

const displayRelatedBlogs = computed(() => {
    if (props.relatedBlogs && props.relatedBlogs.length > 0) {
        return props.relatedBlogs.map(b => ({
            id: b.id,
            slug: b.slug,
            title: translateModel(b, 'title'),
            author: b.author,
            date: formatDate(b.published_at),
            category: translateCategory(b.category),
            image: b.image ? (b.image.startsWith('http') ? optimizeUnsplashUrl(b.image, 600, 400) : `/storage/${b.image}`) : 'https://images.unsplash.com/photo-1584036561566-baf8f5f1b144?w=600&h=400&fit=crop&auto=format&q=75',
            excerpt: translateModel(b, 'short_description') || translateModel(b, 'excerpt') || b.excerpt || '',
        }));
    }
    return [];
});
</script>

<template>
    <Head>
        <title>{{ blog.title }} - ПЗУ Медика Струмица | Медицински Блог</title>
        <meta name="description" :content="blog.content.replace(/<[^>]*>/g, '').substring(0, 155) + '...'" />
        <meta name="keywords" :content="`${blog.title}, ${blog.category}, медицина струмица, здравје, ПЗУ Медика, ${blog.author}`" />
        <meta name="robots" content="index, follow, max-image-preview:large" />
        <meta name="author" :content="blog.author" />
        <link rel="canonical" :href="`https://medica.mk/news/${blog.slug}`" />
        
        <!-- Open Graph -->
        <meta property="og:title" :content="`${blog.title} - ПЗУ Медика Струмица`" />
        <meta property="og:description" :content="blog.content.replace(/<[^>]*>/g, '').substring(0, 155)" />
        <meta property="og:type" content="article" />
        <meta property="og:url" :content="`https://medica.mk/news/${blog.slug}`" />
        <meta property="og:image" :content="blog.image" />
        <meta property="og:image:width" content="1200" />
        <meta property="og:image:height" content="630" />
        <meta property="og:locale" content="mk_MK" />
        <meta property="og:site_name" content="ПЗУ Медика" />
        <meta property="article:author" :content="blog.author" />
        <meta property="article:published_time" :content="blog.date" />
        <meta property="article:section" :content="blog.category" />
        
        <!-- Twitter -->
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:title" :content="`${blog.title} - ПЗУ Медика`" />
        <meta name="twitter:description" :content="blog.content.replace(/<[^>]*>/g, '').substring(0, 120)" />
        <meta name="twitter:image" :content="blog.image" />

        <component :is="'script'" type="application/ld+json" v-html="articleSchema" />
        <component :is="'script'" type="application/ld+json" v-html="breadcrumbSchema" />
    </Head>
    
    <div class="blog-page">
        <Navbar :dark="true" :logo-height="80" @open-appointment="showAppointmentModal = true" />
        
        <!-- Hero Image -->
        <section class="blog-hero position-relative">
            <img :src="blog.image" :alt="blog.title" class="hero-img">
            <div class="hero-overlay"></div>
            <div class="container position-relative h-100 d-flex align-items-end pb-5">
                <div class="text-white pb-4">
                    <span class="badge bg-white text-purple mb-3 px-3 py-2">{{ blog.category }}</span>
                    <h1 class="display-4 fw-bold mb-3">{{ blog.title }}</h1>
                    <div class="d-flex align-items-center gap-4">
                        <div class="d-flex align-items-center gap-2">
                            <div class="author-avatar bg-white rounded-circle d-flex align-items-center justify-content-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#6B4C9A" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                                </svg>
                            </div>
                            <span>{{ blog.author }}</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                            <span>{{ blog.date }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Blog Content -->
        <section class="py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <!-- Breadcrumb -->
                        <nav aria-label="breadcrumb" class="mb-4">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/" class="text-purple">{{ t('nav.home') }}</a></li>
                                <li class="breadcrumb-item"><a href="/news" class="text-purple">{{ t('news.title') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ blog.title }}</li>
                            </ol>
                        </nav>
                        
                        <!-- Article Content -->
                        <article class="blog-content bg-white rounded-4 shadow-sm p-4 p-lg-5">
                            <div v-html="blog.content" class="article-body"></div>
                            
                            <!-- Share -->
                            <div class="border-top pt-4 mt-5">
                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="text-muted">{{ t('news.share') }}:</span>
                                        <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle p-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                            </svg>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle p-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                            </svg>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle p-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                            </svg>
                                        </a>
                                    </div>
                                    <a href="/news" class="btn btn-purple rounded-pill px-4 py-2 d-inline-flex align-items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M19 12H5M12 19l-7-7 7-7"/>
                                        </svg>
                                        <span>{{ t('newsPage.backToBlog') }}</span>
                                    </a>
                                </div>
                            </div>
                        </article>
                        
                        <!-- Related Articles -->
                        <div class="mt-5">
                            <h4 class="fw-bold mb-4">{{ t('news.relatedPosts') }}</h4>
                            <div class="row g-4">
                                <div v-for="related in displayRelatedBlogs" :key="related.id" class="col-md-6">
                                    <article class="related-card bg-white rounded-4 overflow-hidden shadow-sm h-100">
                                        <div class="related-img-wrapper">
                                            <img :src="related.image" :alt="related.title" class="related-img">
                                        </div>
                                        <div class="p-3">
                                            <span class="badge bg-purple-soft text-purple small mb-2">{{ related.category }}</span>
                                            <h6 class="fw-bold mb-2">
                                                <a :href="`/news/${related.slug}`" class="text-decoration-none text-dark">{{ related.title }}</a>
                                            </h6>
                                            <p class="text-muted small mb-0">{{ related.author }}</p>
                                        </div>
                                    </article>
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
.blog-page {
    min-height: 100vh;
    background: #F8F9FA;
}

.text-purple {
    color: #6B4C9A !important;
}

.bg-purple {
    background: linear-gradient(135deg, #6B4C9A 0%, #8B6BAE 100%) !important;
}

.bg-purple-soft {
    background-color: rgba(107, 76, 154, 0.1) !important;
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

/* Hero */
.blog-hero {
    height: 450px;
    overflow: hidden;
    padding-top: 100px;
}

.hero-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.3) 50%, rgba(0,0,0,0.1) 100%);
}

.author-avatar {
    width: 36px;
    height: 36px;
}

/* Article */
.article-body :deep(h4) {
    color: #6B4C9A;
    margin-top: 2rem;
    margin-bottom: 1rem;
    font-weight: 600;
}

.article-body :deep(p) {
    line-height: 1.8;
    color: #444;
    margin-bottom: 1rem;
}

.article-body :deep(.lead) {
    font-size: 1.15rem;
    color: #333;
    font-weight: 500;
}

.article-body :deep(ul) {
    padding-left: 1.5rem;
}

.article-body :deep(li) {
    margin-bottom: 0.5rem;
    line-height: 1.7;
}

/* Related */
.related-card {
    transition: all 0.3s ease;
}

.related-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(107, 76, 154, 0.12) !important;
}

.related-img-wrapper {
    height: 150px;
    overflow: hidden;
}

.related-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.related-card:hover .related-img {
    transform: scale(1.05);
}

@media (max-width: 767px) {
    .blog-hero {
        height: 350px;
    }
    
    .display-4 {
        font-size: 1.75rem;
    }
}
</style>
