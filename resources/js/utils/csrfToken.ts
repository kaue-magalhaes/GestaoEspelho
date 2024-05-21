export function getCsrfToken(): string {
    const metaTag = document.querySelector('meta[name="csrf-token"]');
    if (!metaTag) {
        throw new Error('CSRF token not found');
    }
    return metaTag.getAttribute('content') || '';
}
