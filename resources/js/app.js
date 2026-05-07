import './bootstrap';
import combobox from './combobox';

document.addEventListener('alpine:init', () => {
    Alpine.data('combobox', combobox);
});
