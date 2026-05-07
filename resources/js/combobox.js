export default function combobox({ value = null, searchable = false, placeholder = '—' } = {}) {
    return {
        open: false,
        search: '',
        value: value !== null ? value : null,
        options: [],
        highlighted: -1,
        searchable,
        placeholder,
        position: 'below',
        listHeight: 240,
        _observer: null,

        init() {
            this._loadOptions(this.$refs.optionsData?.dataset.options);
            this._observer = new MutationObserver(() => {
                this._loadOptions(this.$refs.optionsData.dataset.options);
                this.value = null;
                this.search = '';
            });
            this._observer.observe(this.$refs.optionsData, { attributes: true });
        },

        destroy() {
            this._observer?.disconnect();
        },

        _loadOptions(json) {
            try { this.options = JSON.parse(json || '[]'); }
            catch { this.options = []; }
        },

        _updateGeometry() {
            const rect = this.$refs.trigger?.getBoundingClientRect();
            if (!rect) return;
            const overhead = this.searchable ? 52 : 0; // search input area height
            const spaceBelow = window.innerHeight - rect.bottom - 8;
            const spaceAbove = rect.top - 8;
            if (spaceBelow >= spaceAbove || spaceBelow >= 150) {
                this.position = 'below';
                this.listHeight = Math.min(240, Math.max(80, spaceBelow - overhead));
            } else {
                this.position = 'above';
                this.listHeight = Math.min(240, Math.max(80, spaceAbove - overhead));
            }
        },

        get selectedLabel() {
            return this.options.find(o => o.value == this.value)?.label ?? '';
        },

        get filtered() {
            if (!this.searchable || !this.search.trim()) return this.options;
            const q = this.search.toLowerCase();
            return this.options.filter(o => o.label.toLowerCase().includes(q));
        },

        select(option) {
            this.value = option.value;
            this.open = false;
            this.search = '';
            this.highlighted = -1;
            this.$nextTick(() => {
                this.$refs.input?.dispatchEvent(new Event('input', { bubbles: true }));
                this.$refs.input?.dispatchEvent(new Event('change', { bubbles: true }));
            });
        },

        toggle() {
            this.open = !this.open;
            if (this.open) {
                this._updateGeometry();
                if (this.searchable) {
                    this.$nextTick(() => this.$refs.searchInput?.focus());
                }
            }
            if (!this.open) { this.search = ''; this.highlighted = -1; }
        },

        close() {
            this.open = false;
            this.search = '';
            this.highlighted = -1;
        },

        navigate(dir) {
            const count = this.filtered.length;
            if (!count) return;
            if (dir === 'down') this.highlighted = this.highlighted < count - 1 ? this.highlighted + 1 : 0;
            else this.highlighted = this.highlighted > 0 ? this.highlighted - 1 : count - 1;
            this.$nextTick(() => {
                this.$refs.listbox?.querySelector('[data-highlighted="true"]')?.scrollIntoView({ block: 'nearest' });
            });
        },

        selectHighlighted() {
            if (this.highlighted >= 0 && this.filtered[this.highlighted]) {
                this.select(this.filtered[this.highlighted]);
            }
        },

        isSelected(option) {
            return this.value != null && this.value == option.value;
        },
    };
}
