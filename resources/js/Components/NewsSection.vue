<script setup>
import { computed } from 'vue';
import { useTranslate } from '@/composables/useTranslate';

const { t, translateModel } = useTranslate();

const props = defineProps({
    blogs: {
        type: Array,
        default: () => [],
    },
});

const formatDate = (dateString) => {
    if (!dateString) return '';
    const date = new Date(dateString);
    return date.toLocaleDateString('mk-MK', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    });
};

// Get proper image URL (handle both local storage and external URLs)
const getImageUrl = (image) => {
    if (!image) return 'https://images.unsplash.com/photo-1584036561566-baf8f5f1b144?w=400&h=300&fit=crop&auto=format&q=75';
    if (image.startsWith('http')) return image;
    return `/storage/${image}`;
};

// Generate srcset for responsive images
const getImageSrcset = (image) => {
    if (!image || image.startsWith('http')) return '';
    const pathInfo = image.split('/');
    const filename = pathInfo.pop();
    const directory = pathInfo.join('/');
    const name = filename.replace('.webp', '').replace('.jpg', '').replace('.png', '');
    
    return `/storage/${directory}/${name}-xs.webp 320w, /storage/${directory}/${name}-sm.webp 480w, /storage/${directory}/${name}-md.webp 768w`;
};

const news = computed(() => {
    if (props.blogs && props.blogs.length > 0) {
        return props.blogs.map(blog => ({
            id: blog.id,
            title: translateModel(blog, 'title'),
            author: blog.author,
            date: formatDate(blog.published_at),
            excerpt: translateModel(blog, 'excerpt'),
            image: getImageUrl(blog.image),
            srcset: getImageSrcset(blog.image),
            slug: blog.slug,
            category: blog.category,
        }));
    }
    return [];
});
</script>

<template>
    <section class="news-section py-5">
        <div class="container py-4">
            <!-- Section Header -->
            <div class="row mb-5">
                <div class="col-lg-8">
                    <span class="badge bg-purple-soft text-purple rounded-pill px-3 py-2 mb-3">{{ t('news.title') }}</span>
                    <h2 class="fw-bold text-dark mb-2">{{ t('home.latestNews') }}</h2>
                    <p class="text-muted">{{ t('home.newsSubtitle') }}</p>
                </div>
                <div class="col-lg-4 d-flex align-items-end justify-content-lg-end mt-3 mt-lg-0">
                    <a href="/news" class="btn btn-outline-purple rounded-pill px-4 py-2 d-inline-flex align-items-center gap-2">
                        <span>{{ t('common.viewAll') }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
            
            <!-- News Grid -->
            <div class="row g-4">
                <!-- Featured Article (First) -->
                <div class="col-lg-6">
                    <a :href="`/news/${news[0].slug}`" class="text-decoration-none">
                        <article class="news-card news-card-featured h-100 position-relative overflow-hidden rounded-4">
                            <img 
                                :src="news[0].image" 
                                :srcset="news[0].srcset"
                                sizes="(max-width: 768px) 320px, 480px"
                                :alt="news[0].title" 
                                class="featured-img"
                                loading="lazy"
                            >
                            <div class="featured-overlay"></div>
                            <div class="featured-content position-absolute bottom-0 start-0 p-4 text-white">
                                <span class="badge bg-white text-purple mb-3">{{ news[0].category }}</span>
                                <h3 class="fw-bold mb-2">{{ news[0].title }}</h3>
                                <p class="mb-3 opacity-75">{{ news[0].excerpt }}</p>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="author-avatar bg-white rounded-circle d-flex align-items-center justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#6B4C9A" stroke-width="2">
                                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                                            </svg>
                                        </div>
                                        <span class="small">{{ news[0].author }}</span>
                                    </div>
                                    <span class="small opacity-75">{{ news[0].date }}</span>
                                </div>
                            </div>
                        </article>
                    </a>
                </div>
                
                <!-- Side Articles -->
                <div class="col-lg-6">
                    <div class="row g-4">
                        <div v-for="item in news.slice(1)" :key="item.id" class="col-12">
                            <a :href="`/news/${item.slug}`" class="text-decoration-none">
                                <article class="news-card news-card-horizontal d-flex bg-white rounded-4 overflow-hidden shadow-sm h-100">
                                    <div class="news-img-wrapper">
                                        <img 
                                            :src="item.image" 
                                            :srcset="item.srcset"
                                            sizes="(max-width: 768px) 320px, 285px"
                                            :alt="item.title" 
                                            class="news-img"
                                            loading="lazy"
                                        >
                                    </div>
                                    <div class="p-4 d-flex flex-column justify-content-center">
                                        <span class="badge bg-purple-soft text-purple rounded-pill align-self-start mb-2">{{ item.category }}</span>
                                        <h5 class="fw-bold mb-2 text-dark">{{ item.title }}</h5>
                                        <p class="text-muted small mb-3">{{ item.excerpt }}</p>
                                        <div class="d-flex align-items-center gap-3 text-muted small">
                                            <span>{{ item.author }}</span>
                                            <span>•</span>
                                            <span>{{ item.date }}</span>
                                        </div>
                                    </div>
                                </article>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
.news-section {
    background: linear-gradient(180deg, #FFFFFF 0%, #F8F5FC 100%);
}

.text-purple {
    color: #6B4C9A !important;
}

.bg-purple-soft {
    background-color: rgba(107, 76, 154, 0.1) !important;
}

.btn-outline-purple {
    color: #6B4C9A;
    border: 2px solid #6B4C9A;
    background: transparent;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-outline-purple:hover {
    background: linear-gradient(135deg, #6B4C9A 0%, #8B6BAE 100%);
    border-color: transparent;
    color: white;
}

/* Featured Card */
.news-card-featured {
    min-height: 420px;
    max-height: 500px;
    cursor: pointer;
}

.featured-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    transition: transform 0.5s ease;
}

.news-card-featured:hover .featured-img {
    transform: scale(1.05);
}

.featured-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.2) 50%, transparent 100%);
}

.featured-content {
    z-index: 2;
}

.author-avatar {
    width: 28px;
    height: 28px;
}

/* Horizontal Cards */
.news-card-horizontal {
    transition: all 0.3s ease;
    cursor: pointer;
}

.news-card-horizontal:hover {
    transform: translateX(5px);
    box-shadow: 0 10px 30px rgba(107, 76, 154, 0.12) !important;
}

.news-img-wrapper {
    width: 180px;
    min-width: 180px;
    overflow: hidden;
}

.news-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.news-card-horizontal:hover .news-img {
    transform: scale(1.05);
}

@media (max-width: 991px) {
    .news-card-featured {
        min-height: 350px;
    }
}

@media (max-width: 767px) {
    .news-card-featured {
        min-height: 300px;
    }
    
    .news-img-wrapper {
        width: 120px;
        min-width: 120px;
    }
    
    .news-card-horizontal .p-4 {
        padding: 1rem !important;
    }
    
    .news-card-horizontal h5 {
        font-size: 1rem;
    }
    
    .news-card-horizontal p {
        display: none;
    }
}
</style>
