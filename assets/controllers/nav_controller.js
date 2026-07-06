import { Controller } from '@hotwired/stimulus';

/**
 * Controls the site header: the mobile menu toggle and the "scrolled"
 * state used to add a border/shadow once the user scrolls past the top.
 */
export default class extends Controller {
    static targets = ['menu'];

    connect() {
        this.onScroll = this.onScroll.bind(this);
        window.addEventListener('scroll', this.onScroll, { passive: true });
        this.onScroll();
    }

    disconnect() {
        window.removeEventListener('scroll', this.onScroll);
        window.clearTimeout(this.closeTimeout);
    }

    onScroll() {
        this.element.classList.toggle('is-scrolled', window.scrollY > 8);
    }

    toggle(event) {
        const button = event.currentTarget;
        const isOpen = this.menuTarget.hasAttribute('hidden');

        if (isOpen) {
            window.clearTimeout(this.closeTimeout);
            this.menuTarget.removeAttribute('hidden');
            requestAnimationFrame(() => this.menuTarget.classList.add('mobile-menu--visible'));
            button.setAttribute('aria-expanded', 'true');
            button.setAttribute('aria-label', 'Menü schließen');
        } else {
            this.close();
        }
    }

    close() {
        this.menuTarget.classList.remove('mobile-menu--visible');
        const button = this.element.querySelector('.nav-toggle');
        if (button) {
            button.setAttribute('aria-expanded', 'false');
            button.setAttribute('aria-label', 'Menü öffnen');
        }
        window.clearTimeout(this.closeTimeout);
        this.closeTimeout = window.setTimeout(() => {
            this.menuTarget.setAttribute('hidden', '');
        }, 220);
    }

    comingSoon(event) {
        event.preventDefault();
        const input = document.getElementById('city-input');
        if (input) {
            document.getElementById('suche')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
            input.focus({ preventScroll: true });
        }
    }
}
