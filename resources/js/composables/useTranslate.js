import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { translations } from '@/translations';

export function useTranslate() {
    const page = usePage();
    const locale = computed(() => page.props.locale || 'mk');

    const t = (key) => {
        const keys = key.split('.');
        let value = translations[locale.value] || translations['mk'];
        
        for (const k of keys) {
            value = value?.[k];
            if (value === undefined) break;
        }
        
        // Fallback to Macedonian if not found
        if (value === undefined) {
            value = translations['mk'];
            for (const k of keys) {
                value = value?.[k];
                if (value === undefined) break;
            }
        }
        
        return value || key;
    };

    // For translating dynamic content from database
    const translateModel = (item, field) => {
        if (!item) return '';
        
        // If translations are loaded and we're not on default locale
        if (item.translations && locale.value !== 'mk') {
            const trans = item.translations.find(
                t => t.field === field && t.locale === locale.value
            );
            if (trans?.value) {
                // Parse JSON if it's a string that looks like JSON array
                if (typeof trans.value === 'string' && trans.value.startsWith('[')) {
                    try {
                        return JSON.parse(trans.value);
                    } catch (e) {
                        return trans.value;
                    }
                }
                return trans.value;
            }
        }
        
        // Fallback to original field
        return item[field] || '';
    };

    return { 
        t, 
        translateModel,
        locale,
    };
}
