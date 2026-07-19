import { Controller } from '@hotwired/stimulus';

/**
 * A small, dependency-free autocomplete combobox for picking a German
 * city. Shows popular cities on focus (empty input) and filters the
 * whitelist as the visitor types — mirroring a familiar search-engine
 * suggestion panel that opens downward below the input.
 *
 * Markup contract:
 *  - `input` target: the text field (role="combobox")
 *  - `panel` target: the listbox rendered below the input
 *  - `cities` value: the full city list (name, slug, state, population)
 *  - `popular` value: slugs to show as default suggestions
 */
export default class extends Controller {
    static targets = ['input', 'panel'];
    static values = {
        cities: Array,
        popular: Array,
        limit: { type: Number, default: 8 },
    };

    connect() {
        this.activeIndex = -1;
        this.currentOptions = [];
        this.onDocumentClick = this.onDocumentClick.bind(this);
        document.addEventListener('click', this.onDocumentClick);
    }

    disconnect() {
        document.removeEventListener('click', this.onDocumentClick);
    }

    onFocus() {
        this.renderForQuery(this.inputTarget.value);
        this.open();
    }

    onInput() {
        this.renderForQuery(this.inputTarget.value);
        this.open();
    }

    onKeydown(event) {
        if (!this.isOpen) {
            return;
        }

        switch (event.key) {
            case 'ArrowDown':
                event.preventDefault();
                this.moveActive(1);
                break;
            case 'ArrowUp':
                event.preventDefault();
                this.moveActive(-1);
                break;
            case 'Enter':
                if (this.activeIndex > -1 && this.currentOptions[this.activeIndex]) {
                    event.preventDefault();
                    this.chooseCity(this.currentOptions[this.activeIndex]);
                }
                break;
            case 'Escape':
                this.close();
                break;
            default:
                break;
        }
    }

    onDocumentClick(event) {
        if (!this.element.contains(event.target)) {
            this.close();
        }
    }

    select(event) {
        // mousedown (not click) so this fires before the input's blur event
        // would otherwise close the panel and remove the option first.
        event.preventDefault();
        const { slug } = event.params;
        const city = this.citiesValue.find((c) => c.slug === slug);
        if (city) {
            this.chooseCity(city);
        }
    }

    chooseCity(city) {
        this.inputTarget.value = city.name;
        this.close();
        this.element.querySelector('form')?.requestSubmit();
    }

    renderForQuery(query) {
        const normalized = normalize(query);

        const list = normalized === ''
            ? this.citiesValue.filter((c) => this.popularValue.includes(c.slug))
            : this.citiesValue.filter((c) => normalize(c.name).includes(normalized));

        this.currentOptions = list.slice(0, this.limitValue);
        this.activeIndex = -1;

        const heading = normalized === '' ? 'Beliebte Städte' : `Städte · „${escapeHtml(query)}“`;
        this.panelTarget.innerHTML = this.currentOptions.length
            ? this.renderOptions(this.currentOptions, heading)
            : this.renderEmptyState(query);
    }

    renderOptions(cities, heading) {
        const rows = cities.map((city, index) => `
            <li
                role="option"
                id="city-option-${escapeHtml(city.slug)}"
                class="city-search__option"
                data-action="mousedown->city-search#select"
                data-city-search-slug-param="${escapeHtml(city.slug)}"
                aria-selected="${index === this.activeIndex ? 'true' : 'false'}"
            >
                <span class="city-search__option-icon" aria-hidden="true">📍</span>
                <span class="city-search__option-text">
                    <span class="city-search__option-name">${escapeHtml(city.name)}</span>
                    <span class="city-search__option-meta">${escapeHtml(city.state)} · ${formatPopulation(city.population)} Einwohner</span>
                </span>
            </li>
        `).join('');

        return `<p class="city-search__heading">${heading}</p><ul class="city-search__list" role="presentation">${rows}</ul>`;
    }

    renderEmptyState(query) {
        return `
            <p class="city-search__heading">Keine Treffer für „${escapeHtml(query)}“</p>
            <p class="city-search__empty">
                homely startet mit den 24 größten Städten Deutschlands — wähl eine davon, weitere folgen bald.
            </p>
        `;
    }

    moveActive(delta) {
        if (!this.currentOptions.length) {
            return;
        }

        const count = this.currentOptions.length;
        this.activeIndex = (this.activeIndex + delta + count) % count;
        this.updateActiveOption();
    }

    updateActiveOption() {
        const options = this.panelTarget.querySelectorAll('[role="option"]');
        options.forEach((option, index) => {
            const isActive = index === this.activeIndex;
            option.setAttribute('aria-selected', isActive ? 'true' : 'false');
            option.classList.toggle('is-active', isActive);
        });

        const active = this.currentOptions[this.activeIndex];
        this.inputTarget.setAttribute('aria-activedescendant', active ? `city-option-${active.slug}` : '');
    }

    open() {
        this.panelTarget.hidden = false;
        this.inputTarget.setAttribute('aria-expanded', 'true');
        this.isOpen = true;
    }

    close() {
        this.panelTarget.hidden = true;
        this.inputTarget.setAttribute('aria-expanded', 'false');
        this.inputTarget.removeAttribute('aria-activedescendant');
        this.isOpen = false;
        this.activeIndex = -1;
    }
}

function normalize(value) {
    return (value ?? '')
        .toLowerCase()
        .trim()
        .replace(/ä/g, 'ae').replace(/ö/g, 'oe').replace(/ü/g, 'ue').replace(/ß/g, 'ss');
}

function formatPopulation(value) {
    return new Intl.NumberFormat('de-DE').format(value);
}

function escapeHtml(value) {
    return (value ?? '').replace(/[&<>"']/g, (char) => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;',
    }[char]));
}
