<script setup>
import { computed } from 'vue';

const props = defineProps({
    aboutData: Object,
    statsData: Object,
});

const stats = computed(() => {
    return props.statsData?.stats || [
        { number: '27+', label: 'Години искуство' },
        { number: '50k+', label: 'Задоволни пациенти' },
        { number: '15+', label: 'Специјалисти' },
        { number: '6', label: 'Ординации' },
    ];
});

const aboutContent = computed(() => {
    return props.aboutData || {
        title: 'Вашето здравје е наш приоритет',
        lead_text: 'ПЗУ Медика е формирана во 1993 година, како прва приватна здравствена установа во општина Струмица.',
        description: 'Цели 27 години "ПЗУ Медика" работи во голем за зачувување и унапредување на здравјето на своите пациенти.',
        additional_text: 'ПЗУ Медика располага со две ординации по Општа Медицина, Психијатриска ординација, Гинеколошко акушерска ординација, ординација по Трудова медицина и биохемиска лабораторија.',
    };
});

const highlights = [
    {
        icon: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>`,
        title: 'Општа Медицина',
    },
    {
        icon: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 4.5a2.5 2.5 0 0 0-4.96-.46 2.5 2.5 0 0 0-1.98 3 2.5 2.5 0 0 0 1.32 4.24 3 3 0 0 0 .34 5.58 2.5 2.5 0 0 0 2.96 3.08A2.5 2.5 0 0 0 12 21.5V4.5Z"/><path d="M12 4.5a2.5 2.5 0 0 1 4.96-.46 2.5 2.5 0 0 1 1.98 3 2.5 2.5 0 0 1-1.32 4.24 3 3 0 0 1-.34 5.58 2.5 2.5 0 0 1-2.96 3.08A2.5 2.5 0 0 1 12 21.5V4.5Z"/></svg>`,
        title: 'Психијатрија',
    },
    {
        icon: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M12 15v6"/><path d="M9 18h6"/></svg>`,
        title: 'Гинекологија',
    },
    {
        icon: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 3h6v2H9z"/><path d="M10 5v6.5L6 20h12l-4-8.5V5"/><path d="M8.5 14h7"/></svg>`,
        title: 'Лабораторија',
    },
];
</script>

<template>
    <section id="aboutus" class="about-section">
        <div class="container py-5">
            <div class="row align-items-center g-5">
                <!-- Left Side - Content -->
                <div class="col-lg-6">
                    <div class="about-content">
                        <span class="section-badge">За нас</span>
                        <h2 class="section-title" v-html="aboutContent.title?.replace(' наш приоритет', ' <span class=\'highlight\'>наш приоритет</span>') || 'Вашето здравје е <span class=\'highlight\'>наш приоритет</span>'">
                        </h2>
                        
                        <p class="lead-text">
                            {{ aboutContent.lead_text }}
                        </p>
                        
                        <p class="body-text">
                            {{ aboutContent.description }}
                        </p>
                        
                        <p class="body-text">
                            {{ aboutContent.additional_text }}
                        </p>
                        
                        <!-- Highlights -->
                        <div class="highlights-grid">
                            <div 
                                v-for="(item, index) in highlights" 
                                :key="index"
                                class="highlight-item"
                            >
                                <div class="highlight-icon" v-html="item.icon"></div>
                                <span class="highlight-text">{{ item.title }}</span>
                            </div>
                        </div>
                        
                        <a href="/about" class="btn-learn-more">
                            <span>Дознај повеќе</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <!-- Right Side - Stats & Visual -->
                <div class="col-lg-6">
                    <div class="about-visual">
                        <!-- Stats Grid -->
                        <div class="stats-grid">
                            <div 
                                v-for="(stat, index) in stats" 
                                :key="index"
                                class="stat-card"
                                :class="{ 'featured': index === 0 }"
                            >
                                <span class="stat-number">{{ stat.number }}</span>
                                <span class="stat-label">{{ stat.label }}</span>
                            </div>
                        </div>
                        
                        <!-- Decorative Elements -->
                        <div class="deco-circle deco-1"></div>
                        <div class="deco-circle deco-2"></div>
                        <div class="deco-dots"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
.about-section {
    background: linear-gradient(180deg, #F8F5FC 0%, #FFFFFF 50%, #F8F5FC 100%);
    position: relative;
    overflow: hidden;
    padding: 4rem 0;
}

.about-content {
    position: relative;
    z-index: 2;
}

.section-badge {
    display: inline-block;
    background: linear-gradient(135deg, rgba(107, 76, 154, 0.1) 0%, rgba(139, 107, 174, 0.1) 100%);
    color: #6B4C9A;
    padding: 0.5rem 1.25rem;
    border-radius: 30px;
    font-size: 0.85rem;
    font-weight: 600;
    letter-spacing: 1px;
    margin-bottom: 1.5rem;
}

.section-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2D2D2D;
    line-height: 1.2;
    margin-bottom: 1.5rem;
}

.section-title .highlight {
    background: linear-gradient(135deg, #6B4C9A 0%, #8B6BAE 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.lead-text {
    font-size: 1.1rem;
    color: #444;
    line-height: 1.7;
    margin-bottom: 1rem;
    font-weight: 500;
}

.body-text {
    font-size: 0.95rem;
    color: #666;
    line-height: 1.8;
    margin-bottom: 1rem;
}

.highlights-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
    margin: 2rem 0;
}

.highlight-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1rem;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(107, 76, 154, 0.08);
    transition: all 0.3s ease;
}

.highlight-item:hover {
    transform: translateX(5px);
    box-shadow: 0 4px 15px rgba(107, 76, 154, 0.12);
}

.highlight-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, rgba(107, 76, 154, 0.1) 0%, rgba(139, 107, 174, 0.05) 100%);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6B4C9A;
    flex-shrink: 0;
}

.highlight-text {
    font-size: 0.85rem;
    font-weight: 600;
    color: #2D2D2D;
}

.btn-learn-more {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    background: linear-gradient(135deg, #6B4C9A 0%, #8B6BAE 100%);
    color: #fff;
    padding: 0.875rem 2rem;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.95rem;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 8px 25px rgba(107, 76, 154, 0.25);
}

.btn-learn-more:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 35px rgba(107, 76, 154, 0.35);
    color: #fff;
}

.btn-learn-more:hover svg {
    transform: translateX(5px);
}

.btn-learn-more svg {
    transition: transform 0.3s ease;
}

/* Right Side Visual */
.about-visual {
    position: relative;
    padding: 2rem;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
    position: relative;
    z-index: 2;
}

.stat-card {
    background: #fff;
    border-radius: 20px;
    padding: 2rem 1.5rem;
    text-align: center;
    box-shadow: 0 10px 40px rgba(107, 76, 154, 0.1);
    transition: all 0.3s ease;
    border: 1px solid rgba(107, 76, 154, 0.08);
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 50px rgba(107, 76, 154, 0.15);
}

.stat-card.featured {
    background: linear-gradient(135deg, #6B4C9A 0%, #8B6BAE 100%);
    border: none;
}

.stat-card.featured .stat-number,
.stat-card.featured .stat-label {
    color: #fff;
}

.stat-number {
    display: block;
    font-size: 2.5rem;
    font-weight: 800;
    color: #6B4C9A;
    line-height: 1;
    margin-bottom: 0.5rem;
}

.stat-label {
    font-size: 0.85rem;
    color: #666;
    font-weight: 500;
}

/* Decorative Elements */
.deco-circle {
    position: absolute;
    border-radius: 50%;
    pointer-events: none;
}

.deco-1 {
    width: 200px;
    height: 200px;
    background: linear-gradient(135deg, rgba(107, 76, 154, 0.08) 0%, transparent 70%);
    top: -50px;
    right: -50px;
}

.deco-2 {
    width: 150px;
    height: 150px;
    background: linear-gradient(135deg, rgba(139, 107, 174, 0.1) 0%, transparent 70%);
    bottom: 0;
    left: 0;
}

.deco-dots {
    position: absolute;
    width: 100px;
    height: 100px;
    bottom: 20%;
    right: 10%;
    background-image: radial-gradient(circle, rgba(107, 76, 154, 0.2) 2px, transparent 2px);
    background-size: 15px 15px;
    z-index: 1;
}

/* Responsive */
@media (max-width: 991px) {
    .section-title {
        font-size: 2rem;
    }
    
    .about-visual {
        margin-top: 2rem;
    }
}

@media (max-width: 767px) {
    .about-section {
        padding: 3rem 0;
    }
    
    .section-title {
        font-size: 1.75rem;
    }
    
    .lead-text {
        font-size: 1rem;
    }
    
    .highlights-grid {
        grid-template-columns: 1fr;
    }
    
    .stats-grid {
        gap: 1rem;
    }
    
    .stat-card {
        padding: 1.5rem 1rem;
    }
    
    .stat-number {
        font-size: 2rem;
    }
}

@media (max-width: 480px) {
    .section-title {
        font-size: 1.5rem;
    }
    
    .btn-learn-more {
        width: 100%;
        justify-content: center;
    }
}
</style>
