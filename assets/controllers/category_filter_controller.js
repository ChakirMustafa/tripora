import { Controller } from '@hotwired/stimulus';

/**
 * Airbnb-style category bar: clicking a category tab filters the
 * listing cards across every grid section on the homepage down to
 * that category, and hides any section left with no matching cards.
 *
 * Markup contract:
 *  - `tab` target: one button per category (the "Alle" tab uses
 *    category param "all")
 *  - `section` target: each grid section that contains cards
 *  - `card` target: each listing card, carrying `data-category`
 */
export default class extends Controller {
    static targets = ['tab', 'section', 'card'];

    select(event) {
        const { category } = event.params;

        this.tabTargets.forEach((tab) => {
            tab.classList.toggle('is-active', tab === event.currentTarget);
        });

        this.cardTargets.forEach((card) => {
            const show = category === 'all' || card.dataset.category === category;
            card.hidden = !show;
        });

        this.sectionTargets.forEach((section) => {
            const hasVisibleCard = section
                .querySelectorAll('[data-category-filter-target="card"]');
            section.hidden = ![...hasVisibleCard].some((card) => !card.hidden);
        });
    }
}
