<script setup>
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import AppointmentModal from '@/Components/AppointmentModal.vue';
import NewsletterSubscription from '@/Components/NewsletterSubscription.vue';
import { useTranslate } from '@/composables/useTranslate';
import { useScrollAnimation } from '@/composables/useScrollAnimation';

const { t, locale, translateModel } = useTranslate();
useScrollAnimation();

const props = defineProps({
    categories: {
        type: Array,
        default: () => [],
    },
    disclaimer: Object,
    workingHours: Object,
    socialLinks: Object,
});

const showAppointmentModal = ref(false);
const searchQuery = ref('');
const activeCategory = ref(null);

const disclaimerText = computed(() => {
    if (!props.disclaimer) return '';
    return translateModel(props.disclaimer, 'content') || '';
});

const filteredCategories = computed(() => {
    if (!props.categories) return [];

    let cats = props.categories.map(cat => {
        const catName = translateModel(cat, 'name') || cat.name;
        const analyses = (cat.active_analyses || []).map(a => {
            const enTrans = (a.translations || []).find(tr => tr.field === 'name' && tr.locale === 'en');
            return {
                ...a,
                displayName: translateModel(a, 'name') || a.name,
                searchName: [a.name, enTrans ? enTrans.value : ''].join(' ').toLowerCase(),
            };
        });
        return {
            ...cat,
            displayName: catName,
            filteredAnalyses: analyses,
        };
    });

    // Filter by active category
    if (activeCategory.value !== null) {
        cats = cats.filter(c => c.id === activeCategory.value);
    }

    // Filter by search query (searches both MK and EN names)
    if (searchQuery.value.trim()) {
        const query = searchQuery.value.toLowerCase().trim();
        cats = cats.map(cat => ({
            ...cat,
            filteredAnalyses: cat.filteredAnalyses.filter(a =>
                a.searchName.includes(query) || a.displayName.toLowerCase().includes(query)
            ),
        })).filter(cat =>
            cat.filteredAnalyses.length > 0 || cat.displayName.toLowerCase().includes(query)
        );
    }

    return cats;
});

const totalAnalyses = computed(() => {
    return filteredCategories.value.reduce((sum, cat) => sum + cat.filteredAnalyses.length, 0);
});

const setCategory = (catId) => {
    activeCategory.value = activeCategory.value === catId ? null : catId;
};

const clearSearch = () => {
    searchQuery.value = '';
    activeCategory.value = null;
};

const formatPrice = (price) => {
    return Math.round(parseFloat(price));
};
</script>

<template>
    <Head>
        <title>{{ locale === 'mk' ? 'Лабораториски Анализи - ПЗУ Медика Струмица' : 'Laboratory Analyses - PZU Medica Strumica' }}</title>
        <meta name="description" :content="locale === 'mk' ? 'Цени на лабораториски анализи во ПЗУ Медика Струмица. Биохемиска лабораторија со витамини, ензими, електролити и повеќе.' : 'Laboratory analysis prices at PZU Medica Strumica. Biochemical laboratory with vitamins, enzymes, electrolytes and more.'" />
    </Head>

    <div class="laboratory-page">
        <Navbar :dark="true" :logo-height="80" active-link="laboratory" @open-appointment="showAppointmentModal = true" />

        <!-- Header -->
        <header class="page-header">
            <div class="container py-5">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-3">
                        <li class="breadcrumb-item"><a href="/" class="text-white-50">{{ t('nav.home') }}</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">{{ t('nav.laboratory') }}</li>
                    </ol>
                </nav>
                <h1 class="display-4 fw-bold text-white mb-3">
                    {{ locale === 'mk' ? 'Лабораториски Анализи' : 'Laboratory Analyses' }}
                </h1>
                <p class="lead text-white-50 mb-0">
                    {{ locale === 'mk' ? 'Биохемиска лабораторија со модерна опрема и брзи резултати' : 'Biochemical laboratory with modern equipment and fast results' }}
                </p>
            </div>
        </header>

        <!-- Main Content -->
        <section class="py-5">
            <div class="container">
                <!-- Disclaimer Banner -->
                <div v-if="disclaimerText" class="disclaimer-banner mb-5" data-animate="fade-up">
                    <div class="d-flex align-items-start gap-3">
                        <div class="disclaimer-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/>
                            </svg>
                        </div>
                        <div v-html="disclaimerText" class="disclaimer-text"></div>
                    </div>
                </div>

                <!-- Search Bar -->
                <div class="search-bar mb-4" data-animate="fade-up">
                    <div class="search-input-wrapper">
                        <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
                        </svg>
                        <input
                            v-model="searchQuery"
                            type="text"
                            class="form-control search-input"
                            :placeholder="locale === 'mk' ? 'Пребарај анализа по име...' : 'Search analysis by name...'"
                        />
                        <button v-if="searchQuery" @click="clearSearch" class="search-clear">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M18 6 6 18"/><path d="m6 6 12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Category Filter -->
                <div class="category-filter mb-4" data-animate="fade-up">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h6 class="filter-label mb-0">{{ locale === 'mk' ? 'Категорија' : 'Category' }}</h6>
                        <span class="results-count">
                            {{ totalAnalyses }} {{ locale === 'mk' ? 'анализи' : 'analyses' }}
                        </span>
                    </div>
                    <!-- Desktop: pills -->
                    <div class="filter-pills d-none d-md-flex">
                        <button
                            class="btn btn-filter"
                            :class="{ active: activeCategory === null }"
                            @click="activeCategory = null"
                        >
                            {{ locale === 'mk' ? 'Сите' : 'All' }}
                            <span class="filter-count">{{ categories.reduce((s, c) => s + (c.active_analyses || []).length, 0) }}</span>
                        </button>
                        <button
                            v-for="cat in categories"
                            :key="cat.id"
                            class="btn btn-filter"
                            :class="{ active: activeCategory === cat.id }"
                            @click="setCategory(cat.id)"
                        >
                            {{ translateModel(cat, 'name') || cat.name }}
                            <span class="filter-count">{{ (cat.active_analyses || []).length }}</span>
                        </button>
                    </div>
                    <!-- Mobile: dropdown -->
                    <div class="d-md-none">
                        <select
                            class="form-select category-select"
                            :value="activeCategory"
                            @change="activeCategory = $event.target.value === '' ? null : Number($event.target.value)"
                        >
                            <option value="">{{ locale === 'mk' ? 'Сите категории' : 'All categories' }} ({{ categories.reduce((s, c) => s + (c.active_analyses || []).length, 0) }})</option>
                            <option
                                v-for="cat in categories"
                                :key="cat.id"
                                :value="cat.id"
                            >
                                {{ translateModel(cat, 'name') || cat.name }} ({{ (cat.active_analyses || []).length }})
                            </option>
                        </select>
                    </div>
                </div>

                <!-- Categories & Analyses -->
                <div class="categories-grid">
                    <div
                        v-for="(category, index) in filteredCategories"
                        :key="category.id"
                        class="category-card mb-4"
                        data-animate="fade-up"
                    >
                        <div class="category-header">
                            <div class="d-flex align-items-center gap-3">
                                <div class="category-icon-wrapper">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M9 3h6v2H9z"/><path d="M10 5v6.5L6 20h12l-4-8.5V5"/><path d="M8.5 14h7"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="category-title mb-0">{{ category.displayName }}</h3>
                                    <span class="category-count">
                                        {{ category.filteredAnalyses.length }} {{ locale === 'mk' ? 'анализи' : 'analyses' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table analysis-table mb-0">
                                <thead>
                                    <tr>
                                        <th>{{ locale === 'mk' ? 'Анализа' : 'Analysis' }}</th>
                                        <th class="text-end price-col">{{ locale === 'mk' ? 'Цена (ден.)' : 'Price (MKD)' }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="analysis in category.filteredAnalyses" :key="analysis.id">
                                        <td>
                                            <span class="analysis-name">{{ analysis.displayName }}</span>
                                        </td>
                                        <td class="text-end">
                                            <span class="analysis-price">{{ formatPrice(analysis.price) }}</span>
                                        </td>
                                    </tr>
                                    <tr v-if="category.filteredAnalyses.length === 0">
                                        <td colspan="2" class="text-center text-muted py-4">
                                            {{ locale === 'mk' ? 'Нема пронајдени анализи' : 'No analyses found' }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- No results -->
                    <div v-if="filteredCategories.length === 0" class="text-center py-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="1.5">
                            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
                        </svg>
                        <h4 class="mt-3 text-muted">{{ locale === 'mk' ? 'Нема резултати' : 'No results' }}</h4>
                        <p class="text-muted">{{ locale === 'mk' ? 'Обидете се со друг термин за пребарување' : 'Try a different search term' }}</p>
                        <button @click="clearSearch" class="btn btn-purple rounded-pill px-4">
                            {{ locale === 'mk' ? 'Прикажи ги сите' : 'Show all' }}
                        </button>
                    </div>
                </div>

                <!-- CTA Section -->
                <div class="cta-section mt-5 p-5 rounded-4 text-center" data-animate="fade-up">
                    <h3 class="fw-bold mb-3">
                        {{ locale === 'mk' ? 'За повеќе информации' : 'For more information' }}
                    </h3>
                    <p class="text-muted mb-4">
                        {{ locale === 'mk' ? 'Контактирајте нè за повеќе информации или закажување' : 'Contact us for more information or scheduling' }}
                    </p>
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        <a href="/contact" class="btn btn-purple rounded-pill px-5 py-3">
                            {{ t('common.contactUs') }}
                        </a>
                        <button @click="showAppointmentModal = true" class="btn btn-outline-purple rounded-pill px-5 py-3">
                            {{ t('services.bookAppointment') }}
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <NewsletterSubscription />
        <Footer :social-links="socialLinks" />
        <AppointmentModal v-if="showAppointmentModal" @close="showAppointmentModal = false" />
    </div>
</template>

<style scoped>
.laboratory-page {
    min-height: 100vh;
}

.page-header {
    background: linear-gradient(135deg, #1a0533 0%, #2d1b4e 30%, #6B4C9A 100%);
    padding-top: 100px;
    position: relative;
    overflow: hidden;
}

.page-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    opacity: 0.5;
}

/* Disclaimer */
.disclaimer-banner {
    background: linear-gradient(135deg, #FFF3E0 0%, #FFF8E1 100%);
    border: 1px solid #FFE0B2;
    border-radius: 16px;
    padding: 1.5rem;
    border-left: 4px solid #FF9800;
}

.disclaimer-icon {
    color: #FF9800;
    flex-shrink: 0;
    margin-top: 2px;
}

.disclaimer-text {
    color: #5D4037;
    line-height: 1.6;
}

/* Search Bar */
.search-bar {
    background: white;
    border-radius: 16px;
    padding: 1.25rem;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
}

.search-input-wrapper {
    position: relative;
}

.search-icon {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: #999;
    pointer-events: none;
}

.search-input {
    padding-left: 48px;
    padding-right: 40px;
    height: 52px;
    border-radius: 12px;
    border: 2px solid #e9ecef;
    font-size: 1rem;
    transition: all 0.3s ease;
    width: 100%;
}

.search-input:focus {
    border-color: #6B4C9A;
    box-shadow: 0 0 0 4px rgba(107, 76, 154, 0.1);
}

.search-clear {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #999;
    cursor: pointer;
    padding: 4px;
}

.search-clear:hover {
    color: #333;
}

/* Category Filter */
.category-filter {
    background: white;
    border-radius: 16px;
    padding: 1.25rem;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
}

.filter-label {
    font-size: 0.8rem;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.results-count {
    font-size: 0.8rem;
    color: #94a3b8;
    font-weight: 500;
}

.filter-pills {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.category-select {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid #ede7f6;
    border-radius: 10px;
    font-size: 0.9rem;
    color: #6B4C9A;
    font-weight: 500;
    background-color: #f8f5fc;
    transition: all 0.2s ease;
    cursor: pointer;
}

.category-select:focus {
    border-color: #6B4C9A;
    box-shadow: 0 0 0 4px rgba(107, 76, 154, 0.1);
    outline: none;
}

.btn-filter {
    background: #f8f5fc;
    color: #6B4C9A;
    border: 1px solid #ede7f6;
    border-radius: 10px;
    padding: 8px 14px;
    font-size: 0.82rem;
    font-weight: 500;
    transition: all 0.2s ease;
    text-align: left;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-filter:hover {
    background: #ede7f6;
    color: #6B4C9A;
    border-color: #d1c4e9;
}

.btn-filter.active {
    background: #6B4C9A;
    color: white;
    border-color: #6B4C9A;
}

.btn-filter.active .filter-count {
    background: rgba(255, 255, 255, 0.25);
    color: white;
}

.filter-count {
    background: #ede7f6;
    color: #6B4C9A;
    font-size: 0.7rem;
    font-weight: 600;
    padding: 2px 7px;
    border-radius: 6px;
    min-width: 24px;
    text-align: center;
}

/* Category Cards */
.category-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    transition: all 0.3s ease;
}

.category-card:hover {
    box-shadow: 0 8px 30px rgba(107, 76, 154, 0.12);
}

.category-header {
    background: linear-gradient(135deg, #6B4C9A 0%, #8B6BAE 100%);
    color: white;
    padding: 1.25rem 1.5rem;
}

.category-icon-wrapper {
    width: 44px;
    height: 44px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.category-title {
    font-size: 1.15rem;
    font-weight: 700;
    letter-spacing: 0.02em;
}

.category-count {
    font-size: 0.8rem;
    opacity: 0.8;
}

/* Analysis Table */
.analysis-table {
    margin: 0;
}

.analysis-table thead th {
    background: #f8f5fc;
    color: #6B4C9A;
    font-weight: 600;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    padding: 0.85rem 1.5rem;
    border-bottom: 2px solid #ede7f6;
}

.analysis-table tbody tr {
    transition: background 0.2s ease;
}

.analysis-table tbody tr:hover {
    background: #faf8fd;
}

.analysis-table tbody td {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #f0f0f0;
    vertical-align: middle;
}

.analysis-table tbody tr:last-child td {
    border-bottom: none;
}

.analysis-name {
    font-weight: 500;
    color: #333;
}

.analysis-price {
    font-weight: 700;
    color: #6B4C9A;
    font-size: 1.05rem;
}

.price-col {
    width: 140px;
}

/* CTA */
.cta-section {
    background: linear-gradient(135deg, #f8f5fc 0%, #ede7f6 100%);
}

.btn-purple {
    background: linear-gradient(135deg, #6B4C9A 0%, #8B6BAE 100%);
    color: white;
    border: none;
    font-weight: 600;
}

.btn-purple:hover {
    background: linear-gradient(135deg, #5a3d87 0%, #7a5a9d 100%);
    color: white;
}

.btn-outline-purple {
    color: #6B4C9A;
    border: 2px solid #6B4C9A;
    background: transparent;
    font-weight: 600;
}

.btn-outline-purple:hover {
    background: #6B4C9A;
    color: white;
}

/* Responsive */
@media (max-width: 991px) {
    .page-header {
        padding-top: 80px;
    }

    .page-header h1 {
        font-size: 2rem;
    }
}

@media (max-width: 767px) {
    .category-filter {
        padding: 1rem;
    }

    .search-bar {
        padding: 0.75rem;
    }

    .search-input {
        height: 44px;
        font-size: 0.9rem;
    }

    .analysis-table thead th,
    .analysis-table tbody td {
        padding: 0.75rem 1rem;
    }

    .category-header {
        padding: 1rem;
    }

    .price-col {
        width: 100px;
    }
}
</style>
