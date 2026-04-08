import './bootstrap';
import './theme';

document.addEventListener('click', (event) => {
	const card = event.target.closest('[data-card-url]');

	if (!card) {
		return;
	}

	if (event.target.closest('a, button, form, input, select, textarea, label')) {
		return;
	}

	window.location.href = card.dataset.cardUrl;
});

document.addEventListener('keydown', (event) => {
	if (event.key !== 'Enter' && event.key !== ' ') {
		return;
	}

	const card = event.target.closest('[data-card-url]');

	if (!card) {
		return;
	}

	event.preventDefault();
	window.location.href = card.dataset.cardUrl;
});
