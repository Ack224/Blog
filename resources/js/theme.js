const STORAGE_KEY = 'theme';

function setThemeClass(theme) {
	const root = document.documentElement;
	root.classList.toggle('dark', theme === 'dark');
}

function getStoredTheme() {
	return localStorage.getItem(STORAGE_KEY);
}

function getSystemTheme() {
	return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
}

function getDefaultTheme() {
	return document.documentElement.dataset.defaultTheme || 'light';
}

function resolveInitialTheme() {
	return getStoredTheme() || getDefaultTheme() || getSystemTheme();
}

function applyTheme(theme) {
	const resolvedTheme = theme === 'dark' ? 'dark' : 'light';

	localStorage.setItem(STORAGE_KEY, resolvedTheme);
	setThemeClass(resolvedTheme);
}

function toggleTheme() {
	const currentTheme = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
	const nextTheme = currentTheme === 'dark' ? 'light' : 'dark';

	applyTheme(nextTheme);
	return nextTheme;
}

setThemeClass(resolveInitialTheme());

window.themeManager = {
	apply: applyTheme,
	toggle: toggleTheme,
	current: () => (document.documentElement.classList.contains('dark') ? 'dark' : 'light'),
};

