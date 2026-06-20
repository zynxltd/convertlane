import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.data('offersFilter', (offers) => ({
    offers,
    vertical: 'all',
    model: 'all',
    geo: 'all',
    status: 'all',
    search: '',
    page: 1,
    perPage: 10,

    init() {
        const params = new URLSearchParams(window.location.search);
        if (params.get('vertical')) this.vertical = params.get('vertical');
        if (params.get('model')) this.model = params.get('model');
        if (params.get('geo')) this.geo = params.get('geo');
        if (params.get('status')) this.status = params.get('status');
        if (params.get('q')) this.search = params.get('q');

        ['search', 'vertical', 'model', 'geo', 'status'].forEach((key) => {
            this.$watch(key, () => {
                this.page = 1;
            });
        });
    },

    get filteredIndices() {
        const q = this.search.trim().toLowerCase();

        return this.offers.reduce((indices, offer, index) => {
            if (offer.status === 'private') return indices;
            if (this.vertical !== 'all' && offer.vertical !== this.vertical) return indices;
            if (this.model !== 'all' && offer.model !== this.model) return indices;
            if (this.geo !== 'all' && !offer.geos.includes(this.geo)) return indices;
            if (this.status !== 'all' && offer.status !== this.status) return indices;
            if (q) {
                const hay = `${offer.name} ${offer.id} ${offer.vertical_name}`.toLowerCase();
                if (!hay.includes(q)) return indices;
            }
            indices.push(index);
            return indices;
        }, []);
    },

    get filtered() {
        return this.filteredIndices.map((index) => this.offers[index]);
    },

    get totalPages() {
        return Math.max(1, Math.ceil(this.filteredIndices.length / this.perPage));
    },

    get paginatedIndices() {
        const start = (this.page - 1) * this.perPage;

        return this.filteredIndices.slice(start, start + this.perPage);
    },

    rowVisible(index) {
        return this.paginatedIndices.includes(index);
    },

    goToPage(nextPage) {
        this.page = Math.min(Math.max(1, nextPage), this.totalPages);
    },

    resetFilters() {
        this.vertical = 'all';
        this.model = 'all';
        this.geo = 'all';
        this.status = 'all';
        this.search = '';
        this.page = 1;
    },
}));

Alpine.data('theme', () => ({
    dark: false,

    init() {
        const stored = localStorage.getItem('cl_theme');
        this.dark = stored === 'dark';
        this.apply();
    },

    toggle() {
        this.dark = !this.dark;
        localStorage.setItem('cl_theme', this.dark ? 'dark' : 'light');
        this.apply();
    },

    apply() {
        document.documentElement.classList.toggle('dark', this.dark);
    },
}));

function initParallaxBackgrounds() {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }

    const layers = document.querySelectorAll('[data-parallax-bg]');
    if (!layers.length) {
        return;
    }

    let ticking = false;

    const update = () => {
        const viewportHeight = window.innerHeight;

        layers.forEach((layer) => {
            const section = layer.closest('.beach-parallax');
            if (!section) {
                return;
            }

            const rect = section.getBoundingClientRect();
            if (rect.bottom < 0 || rect.top > viewportHeight) {
                return;
            }

            const progress = (viewportHeight - rect.top) / (viewportHeight + rect.height);
            const offset = (progress - 0.5) * 80;
            layer.style.transform = `translate3d(0, ${offset}px, 0) scale(1.08)`;
        });

        ticking = false;
    };

    const onScroll = () => {
        if (!ticking) {
            ticking = true;
            requestAnimationFrame(update);
        }
    };

    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('resize', onScroll, { passive: true });
    update();
}

document.addEventListener('DOMContentLoaded', initParallaxBackgrounds);

Alpine.start();
