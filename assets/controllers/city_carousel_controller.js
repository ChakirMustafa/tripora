import { Controller } from '@hotwired/stimulus';

/**
 * Drives the "prev / next" buttons for the horizontally scrolling
 * popular-cities row. Falls back to native touch/trackpad scrolling
 * on small screens where the buttons are hidden.
 */
export default class extends Controller {
    static targets = ['track'];

    next() {
        this.scrollByCard(1);
    }

    prev() {
        this.scrollByCard(-1);
    }

    scrollByCard(direction) {
        const card = this.trackTarget.querySelector('.listing-card');
        const gap = 16;
        const distance = card ? card.offsetWidth + gap : 216;

        this.trackTarget.scrollBy({ left: distance * direction, behavior: 'smooth' });
    }
}
