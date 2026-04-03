<script setup>
import { computed } from 'vue';
import { useTranslate } from '@/composables/useTranslate';

const { t, translateModel } = useTranslate();

const props = defineProps({
    doses: { type: Array, default: () => [] },
});

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

const items = computed(() => {
    return (props.doses || []).slice(0, 3).map(dose => ({
        id: dose.id,
        slug: dose.slug,
        title: translateModel(dose, 'title') || dose.title,
        excerpt: translateModel(dose, 'excerpt') || dose.excerpt || '',
        image: getImageUrl(dose.image),
        author: dose.author,
        category: dose.category,
        date: formatDate(dose.published_at),
    }));
});
</script>

<template>
    <section v-if="items.length > 0" class="dd-section py-5">
        <div class="container py-4">
            <!-- Header -->
            <div class="row mb-5 align-items-end">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="dd-icon-wrap">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 22h16a2 2 0 002-2V4a2 2 0 00-2-2H8a2 2 0 00-2 2v16a2 2 0 01-2 2zm0 0a2 2 0 01-2-2v-9c0-1.1.9-2 2-2h2"/><path d="M18 14h-8"/><path d="M15 18h-5"/><path d="M10 6h8v4h-8z"/></svg>
                        </div>
                        <span class="dd-badge">{{ t('dailyDose.title') }}</span>
                    </div>
                    <h2 class="fw-bold mb-1" style="font-family: 'Georgia', serif; color: #1a1a2e;">{{ t('dailyDose.subtitle') }}</h2>
                    <p class="text-muted mb-0">{{ t('dailyDose.latestUpdates') }}</p>
                </div>
                <div class="col-lg-4 d-flex justify-content-lg-end mt-3 mt-lg-0">
                    <a href="/daily-dose" class="btn btn-outline-dd rounded-pill px-4 py-2 d-inline-flex align-items-center gap-2">
                        <span>{{ t('dailyDose.viewAll') }}</span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>

            <!-- Cards Grid -->
            <div class="row g-4">
                <!-- Featured (first item) -->
                <div class="col-lg-6">
                    <a :href="`/daily-dose/${items[0].slug}`" class="dd-featured d-block h-100 position-relative overflow-hidden rounded-4">
                        <img v-if="items[0].image" :src="items[0].image" :alt="items[0].title" class="dd-featured-img" loading="lazy">
                        <div v-else class="dd-featured-placeholder"></div>
                        <div class="dd-featured-overlay"></div>
                        <div class="dd-featured-content position-absolute bottom-0 start-0 p-4 text-white">
                            <span v-if="items[0].category" class="badge bg-white text-dark mb-2 px-2 py-1 small">{{ items[0].category }}</span>
                            <h3 class="dd-featured-title mb-2">{{ items[0].title }}</h3>
                            <p class="dd-featured-excerpt mb-3">{{ items[0].excerpt }}</p>
                            <div class="d-flex align-items-center gap-3 small opacity-75">
                                <span>{{ items[0].author }}</span>
                                <span>{{ items[0].date }}</span>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Side items (2nd & 3rd) -->
                <div class="col-lg-6">
                    <div class="d-flex flex-column gap-4 h-100">
                        <a v-for="item in items.slice(1)" :key="item.id"
                           :href="`/daily-dose/${item.slug}`"
                           class="dd-side-card d-flex bg-white rounded-4 overflow-hidden shadow-sm flex-grow-1 text-decoration-none">
                            <div v-if="item.image" class="dd-side-img-wrap">
                                <img :src="item.image" :alt="item.title" class="dd-side-img" loading="lazy">
                            </div>
                            <div class="p-3 d-flex flex-column justify-content-center flex-grow-1">
                                <span v-if="item.category" class="dd-side-tag mb-1">{{ item.category }}</span>
                                <h5 class="dd-side-title mb-1">{{ item.title }}</h5>
                                <p class="dd-side-excerpt mb-2">{{ item.excerpt }}</p>
                                <div class="d-flex align-items-center gap-2 text-muted small">
                                    <span>{{ item.author }}</span>
                                    <span>•</span>
                                    <span>{{ item.date }}</span>
                                </div>
                            </div>
                        </a>

                        <!-- If only 1 item, show CTA -->
                        <div v-if="items.length === 1" class="dd-cta-card d-flex align-items-center justify-content-center bg-white rounded-4 shadow-sm flex-grow-1 p-4 text-center">
                            <div>
                                <p class="text-muted mb-3">{{ t('dailyDose.noPostsYet') }}</p>
                                <a href="/daily-dose" class="btn btn-outline-dd rounded-pill px-4 py-2">{{ t('dailyDose.viewAll') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
.dd-section {
    background: linear-gradient(180deg, #f8f5fc 0%, #FFFFFF 100%);
}

.dd-icon-wrap {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: linear-gradient(135deg, #1a1a2e 0%, #0f3460 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.dd-badge {
    font-size: 0.78rem;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    color: #1a1a2e;
    font-family: 'Georgia', serif;
}

.btn-outline-dd {
    color: #1a1a2e;
    border: 2px solid #1a1a2e;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-outline-dd:hover {
    background: #1a1a2e;
    color: white;
}

/* Featured Card */
.dd-featured {
    min-height: 380px;
    cursor: pointer;
    text-decoration: none;
    background: #1a1a2e;
}

.dd-featured-img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.dd-featured:hover .dd-featured-img {
    transform: scale(1.05);
}

.dd-featured-placeholder {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, #1a1a2e 0%, #0f3460 100%);
}

.dd-featured-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(26,26,46,0.9) 0%, rgba(26,26,46,0.3) 50%, transparent 100%);
}

.dd-featured-content {
    z-index: 2;
}

.dd-featured-title {
    font-size: 1.4rem;
    font-weight: 700;
    font-family: 'Georgia', serif;
    line-height: 1.3;
}

.dd-featured-excerpt {
    font-size: 0.9rem;
    opacity: 0.8;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Side Cards */
.dd-side-card {
    transition: all 0.3s ease;
    border: 1px solid rgba(0,0,0,0.05);
    color: inherit;
}

.dd-side-card:hover {
    transform: translateX(5px);
    box-shadow: 0 10px 30px rgba(26,26,46,0.1) !important;
}

.dd-side-img-wrap {
    width: 160px;
    min-width: 160px;
    overflow: hidden;
}

.dd-side-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.dd-side-card:hover .dd-side-img {
    transform: scale(1.05);
}

.dd-side-tag {
    display: inline-block;
    font-size: 0.7rem;
    font-weight: 600;
    color: #6B4C9A;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.dd-side-title {
    font-size: 1rem;
    font-weight: 700;
    color: #1a1a2e;
    font-family: 'Georgia', serif;
    line-height: 1.3;
}

.dd-side-excerpt {
    font-size: 0.82rem;
    color: #777;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

@media (max-width: 991px) {
    .dd-featured {
        min-height: 300px;
    }
}

@media (max-width: 767px) {
    .dd-featured {
        min-height: 260px;
    }

    .dd-side-img-wrap {
        width: 110px;
        min-width: 110px;
    }

    .dd-side-title {
        font-size: 0.9rem;
    }

    .dd-side-excerpt {
        display: none;
    }

    .dd-featured-title {
        font-size: 1.15rem;
    }
}
</style>
