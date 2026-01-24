import { onMounted, onUnmounted } from 'vue';

export function useScrollAnimation() {
    let observer = null;

    const initScrollAnimations = () => {
        // Select all elements with data-animate attribute
        const animatedElements = document.querySelectorAll('[data-animate]');
        
        observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    const animation = el.dataset.animate || 'fade-up';
                    const delay = el.dataset.animateDelay || 0;
                    
                    setTimeout(() => {
                        el.classList.add('animated', `animate-${animation}`);
                    }, parseInt(delay));
                    
                    // Unobserve after animation
                    observer.unobserve(el);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        animatedElements.forEach((el) => {
            el.classList.add('animate-init');
            observer.observe(el);
        });
    };

    const destroyScrollAnimations = () => {
        if (observer) {
            observer.disconnect();
            observer = null;
        }
    };

    onMounted(() => {
        // Small delay to ensure DOM is ready
        setTimeout(initScrollAnimations, 100);
    });

    onUnmounted(() => {
        destroyScrollAnimations();
    });

    return {
        initScrollAnimations,
        destroyScrollAnimations
    };
}
