<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue';
import { useTranslate } from '@/composables/useTranslate';

const { t, translateModel } = useTranslate();

const props = defineProps({
    sliders: {
        type: Array,
        default: () => [],
    },
});

const emit = defineEmits(['openAppointment']);

const getImageUrl = (image) => {
    if (!image) return 'https://images.unsplash.com/photo-1629909613654-28e377c37b09?w=600&h=400&fit=crop';
    if (image.startsWith('http')) return image;
    return `/storage/${image}`;
};

// Generate srcset for responsive images
const getImageSrcset = (image) => {
    if (!image || image.startsWith('http')) return '';
    
    const pathInfo = image.split('/');
    const filename = pathInfo.pop();
    const directory = pathInfo.join('/');
    const [name, ext] = filename.split('.');
    
    const sizes = [320, 480, 768, 1200, 1600];
    const srcset = sizes.map(size => {
        const sizeName = size === 320 ? 'xs' : size === 480 ? 'sm' : size === 768 ? 'md' : size === 1200 ? 'lg' : 'xl';
        return `/storage/${directory}/${name}-${sizeName}.webp ${size}w`;
    });
    
    return srcset.join(', ');
};

// Preload first slide image for LCP optimization
const preloadFirstImage = () => {
    if (props.sliders && props.sliders.length > 0) {
        const firstImage = getImageUrl(props.sliders[0].image);
        const link = document.createElement('link');
        link.rel = 'preload';
        link.as = 'image';
        link.href = firstImage;
        link.fetchpriority = 'high';
        document.head.appendChild(link);
    }
};

const slides = computed(() => {
    if (props.sliders && props.sliders.length > 0) {
        return props.sliders.map(slider => ({
            id: slider.id,
            title: translateModel(slider, 'title'),
            subtitle: translateModel(slider, 'subtitle'),
            description: translateModel(slider, 'description'),
            button_text: translateModel(slider, 'button_text'),
            button2_text: translateModel(slider, 'button2_text'),
            button_link: slider.button_link,
            button2_link: slider.button2_link,
            image: getImageUrl(slider.image),
            srcset: getImageSrcset(slider.image),
            rawImage: slider.image,
        }));
    }
    return [
        {
            id: 1,
            title: 'DEXA СКЕН',
            subtitle: 'Рана и сигурна детекција на остеопороза',
            description: 'Современа апаратура, брз и безболен преглед со стручен медицински тим.',
            button_text: t('services.bookAppointment'),
            button2_text: t('common.learnMore'),
            image: 'https://images.unsplash.com/photo-1629909613654-28e377c37b09?w=600&h=400&fit=crop',
        },
    ];
});

const currentSlide = ref(0);
let slideInterval = null;

const nextSlide = () => {
    currentSlide.value = (currentSlide.value + 1) % slides.value.length;
};

const goToSlide = (index) => {
    currentSlide.value = index;
};

onMounted(() => {
    preloadFirstImage();
    slideInterval = setInterval(nextSlide, 5000);
});

onUnmounted(() => {
    if (slideInterval) {
        clearInterval(slideInterval);
    }
});
</script>

<template>
    <section class="hero-section position-relative overflow-hidden">
        <!-- Background curved gradient shape -->
        <div class="gradient-shape-wrapper">
            <svg class="gradient-shape" viewBox="0 0 800 900" preserveAspectRatio="none">
                <defs>
                    <linearGradient id="purpleGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color: rgba(220, 195, 240, 0.6)" />
                        <stop offset="50%" style="stop-color: rgba(180, 150, 210, 0.4)" />
                        <stop offset="100%" style="stop-color: rgba(140, 110, 180, 0.2)" />
                    </linearGradient>
                </defs>
                <path d="M0,0 L0,900 Q400,850 350,450 Q300,50 500,0 Z" fill="url(#purpleGradient)" />
            </svg>
        </div>
        
        <div class="container position-relative" style="z-index: 2;">
            <div class="row align-items-center min-vh-100 py-5">
                <!-- Left Content -->
                <div class="col-lg-5 col-xl-5">
                    <div class="hero-content ps-lg-4" style="padding-top: 80px;">
                        <transition name="fade" mode="out-in">
                            <div :key="currentSlide">
                                <h1 class="hero-title mb-3">{{ slides[currentSlide].title }}</h1>
                                <p class="hero-subtitle mb-4">{{ slides[currentSlide].subtitle }}</p>
                                <p class="hero-description mb-4">{{ slides[currentSlide].description }}</p>
                                
                                <div class="d-flex flex-wrap align-items-center gap-3 mb-4">
                                    <button 
                                        v-if="!slides[currentSlide].button_link || slides[currentSlide].button_link === '/contact'"
                                        @click="emit('openAppointment')" 
                                        class="btn btn-purple rounded-pill px-4 py-2"
                                    >
                                        {{ slides[currentSlide].button_text || t('services.bookAppointment') }}
                                    </button>
                                    <a 
                                        v-else
                                        :href="slides[currentSlide].button_link" 
                                        class="btn btn-purple rounded-pill px-4 py-2"
                                    >
                                        {{ slides[currentSlide].button_text || t('services.bookAppointment') }}
                                    </a>
                                    <a :href="slides[currentSlide].button2_link || '/services'" class="btn btn-light-outline rounded-pill px-4 py-2">
                                        {{ slides[currentSlide].button2_text || t('common.learnMore') }}
                                    </a>
                                </div>
                                
                                <!-- Slider dots -->
                                <div class="d-flex gap-2 mt-4" role="tablist" aria-label="Slider navigation">
                                    <button 
                                        v-for="(slide, index) in slides" 
                                        :key="slide.id"
                                        class="slider-dot"
                                        :class="{ active: currentSlide === index }"
                                        :aria-label="`Go to slide ${index + 1}`"
                                        :aria-selected="currentSlide === index"
                                        role="tab"
                                        @click="goToSlide(index)"
                                    ></button>
                                </div>
                            </div>
                        </transition>
                    </div>
                </div>
                
                <!-- Right Image -->
                <div class="col-lg-7 col-xl-7">
                    <div class="hero-image-wrapper position-relative" style="padding-top: 60px;">
                        <transition name="slide-fade" mode="out-in">
                            <div :key="currentSlide" class="image-container position-relative">
                                <!-- Image with purple gradient border -->
                                <div class="image-outer-frame">
                                    <div class="image-inner">
                                        <picture>
                                            <source 
                                                v-if="slides[currentSlide].srcset"
                                                :srcset="slides[currentSlide].srcset"
                                                sizes="(max-width: 480px) 320px, (max-width: 768px) 480px, (max-width: 1200px) 768px, 1200px"
                                                type="image/webp"
                                            />
                                            <img 
                                                :src="slides[currentSlide].image" 
                                                :alt="slides[currentSlide].title"
                                                class="hero-img"
                                                :loading="currentSlide === 0 ? 'eager' : 'lazy'"
                                                :fetchpriority="currentSlide === 0 ? 'high' : 'auto'"
                                                decoding="async"
                                                width="600"
                                                height="340"
                                            />
                                        </picture>
                                    </div>
                                </div>
                                <!-- Badge -->
                                <div class="image-badge">
                                    <span class="badge-text">Medica</span>
                                </div>
                            </div>
                        </transition>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
.hero-section {
    min-height: 100vh;
    background: linear-gradient(180deg, #FDFBFE 0%, #FFFFFF 100%);
}

.gradient-shape-wrapper {
    position: absolute;
    top: 0;
    left: 0;
    width: 50%;
    height: 100%;
    z-index: 1;
    pointer-events: none;
}

.gradient-shape {
    width: 100%;
    height: 100%;
}

.hero-title {
    font-size: 2.75rem;
    font-weight: 700;
    color: #2D2D2D;
    letter-spacing: 2px;
}

.hero-subtitle {
    font-size: 1.25rem;
    font-weight: 400;
    color: #555;
    line-height: 1.4;
    margin: 0;
}

.hero-description {
    font-size: 0.9rem;
    line-height: 1.7;
    max-width: 340px;
    color: #888;
}

.btn-purple {
    background: linear-gradient(135deg, #8B6BAE 0%, #6B4C9A 100%);
    color: white;
    border: none;
    font-size: 0.85rem;
    font-weight: 500;
    box-shadow: 0 4px 15px rgba(107, 76, 154, 0.25);
}

.btn-purple:hover {
    background: linear-gradient(135deg, #7A5A9D 0%, #5A3B89 100%);
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(107, 76, 154, 0.35);
}

.btn-light-outline {
    background: rgba(255, 255, 255, 0.8);
    border: 1px solid #ddd;
    color: #666;
    font-size: 0.85rem;
}

.btn-light-outline:hover {
    border-color: #6B4C9A;
    color: #6B4C9A;
    background: white;
}

.slider-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    border: none;
    background: #D0D0D0;
    cursor: pointer;
    transition: all 0.3s ease;
    padding: 0;
}

.slider-dot.active {
    background: #6B4C9A;
    width: 24px;
    border-radius: 4px;
}

.hero-image-wrapper {
    padding-left: 2rem;
}

.image-outer-frame {
    position: relative;
    padding: 6px;
    background: linear-gradient(145deg, #E8D0F5 0%, #C9A8E0 30%, #A87DC8 60%, #8B6BAE 100%);
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(139, 107, 174, 0.2);
}

.image-inner {
    border-radius: 16px;
    overflow: hidden;
    background: white;
}

.hero-img {
    width: 100%;
    height: 340px;
    object-fit: cover;
    display: block;
}

.image-badge {
    position: absolute;
    top: 20px;
    right: 15px;
    background: linear-gradient(135deg, #8B6BAE 0%, #6B4C9A 100%);
    color: white;
    padding: 0.4rem 1.25rem;
    border-radius: 20px;
    box-shadow: 0 4px 15px rgba(107, 76, 154, 0.35);
    z-index: 10;
}

.badge-text {
    font-family: 'Georgia', serif;
    font-style: italic;
    font-size: 0.85rem;
}

/* Transitions */
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.4s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

.slide-fade-enter-active,
.slide-fade-leave-active {
    transition: all 0.4s ease;
}

.slide-fade-enter-from {
    opacity: 0;
    transform: translateX(20px);
}

.slide-fade-leave-to {
    opacity: 0;
    transform: translateX(-20px);
}

@media (max-width: 991px) {
    .hero-section {
        overflow-x: hidden;
    }
    
    .hero-title {
        font-size: 2rem;
    }
    
    .hero-subtitle {
        font-size: 1.1rem;
    }
    
    .gradient-shape-wrapper {
        width: 100%;
        height: 50%;
        overflow: hidden;
    }
    
    .hero-image-wrapper {
        margin-top: 2rem;
        padding-left: 0;
        max-width: 100%;
    }
    
    .image-outer-frame {
        max-width: 100%;
    }
}

@media (max-width: 576px) {
    .hero-title {
        font-size: 1.75rem;
    }
    
    .hero-img {
        height: 250px;
    }
}
</style>
