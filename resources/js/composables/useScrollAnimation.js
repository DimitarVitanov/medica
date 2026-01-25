import { onMounted, onUnmounted } from 'vue';

export function useScrollAnimation() {
    let observer = null;

    const initScrollAnimations = () => {
        // Select all elements with data-animate attribute
        const animatedElements = document.querySelectorAll('[data-animate]');
        
        // Batch DOM reads/writes to avoid forced reflow
        observer = new IntersectionObserver((entries) => {
            // Use requestAnimationFrame to batch DOM writes
            requestAnimationFrame(() => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        const el = entry.target;
                        const animation = el.dataset.animate || 'fade-up';
                        const delay = parseInt(el.dataset.animateDelay) || 0;
                        
                        if (delay > 0) {
                            setTimeout(() => {
                                requestAnimationFrame(() => {
                                    el.classList.add('animated', `animate-${animation}`);
                                });
                            }, delay);
                        } else {
                            el.classList.add('animated', `animate-${animation}`);
                        }
                        
                        // Unobserve after animation
                        observer.unobserve(el);
                    }
                });
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        // Batch initial class additions
        requestAnimationFrame(() => {
            animatedElements.forEach((el) => {
                el.classList.add('animate-init');
                observer.observe(el);
            });
        });
    };

    const destroyScrollAnimations = () => {
        if (observer) {
            observer.disconnect();
            observer = null;
        }
    };

    onMounted(() => {
        // Use requestIdleCallback for non-critical initialization
        if ('requestIdleCallback' in window) {
            requestIdleCallback(initScrollAnimations, { timeout: 200 });
        } else {
            setTimeout(initScrollAnimations, 100);
        }
    });

    onUnmounted(() => {
        destroyScrollAnimations();
    });

    return {
        initScrollAnimations,
        destroyScrollAnimations
    };
}
