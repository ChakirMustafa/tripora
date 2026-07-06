import { Controller } from '@hotwired/stimulus';

/**
 * Fades/slides child elements marked with [data-reveal-target="item"]
 * into view as they enter the viewport, using IntersectionObserver.
 * No-ops gracefully if the browser doesn't support it, and respects
 * prefers-reduced-motion by revealing everything immediately.
 */
export default class extends Controller {
    static targets = ['item'];

    connect() {
        // Content is fully visible by default (see .reveal-pending in
        // app.css) so nothing breaks if this controller never runs.
        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        if (prefersReducedMotion || typeof IntersectionObserver === 'undefined') {
            return;
        }

        this.observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        this.observer.unobserve(entry.target);
                    }
                });
            },
            { threshold: 0.15, rootMargin: '0px 0px -40px 0px' }
        );

        this.itemTargets.forEach((item, index) => {
            item.classList.add('reveal-pending');
            item.style.transitionDelay = `${Math.min(index * 60, 300)}ms`;
            this.observer.observe(item);
        });
    }

    disconnect() {
        this.observer?.disconnect();
    }
}
