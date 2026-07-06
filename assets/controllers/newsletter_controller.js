import { Controller } from '@hotwired/stimulus';

/**
 * Lightweight client-side handler for the footer email capture form.
 * There is no backend endpoint wired up yet, so this simply validates
 * the input and shows an inline confirmation — replace with a real
 * submission once a newsletter/waitlist endpoint exists.
 */
export default class extends Controller {
    static targets = ['input', 'button', 'note'];

    subscribe(event) {
        event.preventDefault();

        if (!this.inputTarget.checkValidity()) {
            this.inputTarget.reportValidity();
            return;
        }

        this.buttonTarget.disabled = true;
        this.buttonTarget.textContent = 'Added';
        this.noteTarget.textContent = "You're on the list — we'll email you when we launch new cities.";
        this.inputTarget.value = '';
    }
}
