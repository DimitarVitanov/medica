const SITE_ORIGIN = 'https://medica.mk';

/**
 * Returns an absolute https URL for Open Graph, Twitter, and JSON-LD.
 * Relative paths (e.g. /storage/...) become https://medica.mk/storage/...
 */
export function absoluteSiteUrl(url) {
    if (!url) return null;
    if (url.startsWith('http://') || url.startsWith('https://')) return url;
    if (url.startsWith('//')) return `https:${url}`;
    const path = url.startsWith('/') ? url : `/${url}`;
    return `${SITE_ORIGIN}${path}`;
}
