import { usePage } from '@inertiajs/vue3';

export function useTrans() {
    const page = usePage();

    const t = (key, params = {}) => {
        let text = key.split('.').reduce(
            (o, i) => (o && o[i] !== undefined ? o[i] : null),
            page.props.translations
        );

        if (!text) return key;

        Object.keys(params).forEach(paramKey => {
            const value = params[paramKey];

            text = text
                .replace(new RegExp(`:${paramKey}`, 'g'), value)
                .replace(new RegExp(`\\{${paramKey}\\}`, 'g'), value);
        });

        return text;
    };

    return { t };
}
