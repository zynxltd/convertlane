import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.data('offersFilter', (offers) => ({
    offers,
    vertical: 'all',
    model: 'all',
    geo: 'all',
    status: 'all',
    inHouseOnly: false,
    search: '',

    init() {
        const params = new URLSearchParams(window.location.search);
        if (params.get('vertical')) this.vertical = params.get('vertical');
        if (params.get('model')) this.model = params.get('model');
        if (params.get('geo')) this.geo = params.get('geo');
        if (params.get('status')) this.status = params.get('status');
        if (params.get('in_house') === '1') this.inHouseOnly = true;
        if (params.get('q')) this.search = params.get('q');
    },

    get filtered() {
        const q = this.search.trim().toLowerCase();

        return this.offers.filter((offer) => {
            if (this.vertical !== 'all' && offer.vertical !== this.vertical) return false;
            if (this.model !== 'all' && offer.model !== this.model) return false;
            if (this.geo !== 'all' && !offer.geos.includes(this.geo)) return false;
            if (this.status !== 'all' && offer.status !== this.status) return false;
            if (this.inHouseOnly && !offer.in_house) return false;
            if (q) {
                const hay = `${offer.name} ${offer.brand} ${offer.description} ${offer.vertical_name}`.toLowerCase();
                if (!hay.includes(q)) return false;
            }
            return true;
        });
    },

    get resultLabel() {
        const n = this.filtered.length;
        const total = this.offers.length;
        return n === total
            ? `Showing all ${total} offers`
            : `Showing ${n} of ${total} offers`;
    },

    resetFilters() {
        this.vertical = 'all';
        this.model = 'all';
        this.geo = 'all';
        this.status = 'all';
        this.inHouseOnly = false;
        this.search = '';
    },
}));

Alpine.data('theme', () => ({
    dark: true,

    init() {
        const stored = localStorage.getItem('cl_theme');
        this.dark = stored !== 'light';
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
