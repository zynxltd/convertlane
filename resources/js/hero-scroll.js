(function () {
    const interval = 4000;
    const transitionMs = 450;

    const live = document.getElementById('hero-scroll-live');
    const prefix = document.getElementById('hero-prefix');
    const eyebrow = document.getElementById('hero-eyebrow');
    const tagline = document.getElementById('hero-tagline');
    const scroll = document.getElementById('hero-scroll');
    const scrollInner = document.getElementById('hero-scroll-inner');
    const scrollWords = scroll ? scroll.querySelectorAll('.hero-scroll-word') : [];

    if (!live || !scroll || !scrollInner || !scrollWords.length) {
        return;
    }

    let slides = [];

    try {
        slides = JSON.parse(scroll.getAttribute('data-slides') || '[]');
    } catch {
        slides = [];
    }

    if (!slides.length) {
        return;
    }

    const words = Array.from(scrollWords).map((el) => el.textContent.trim());
    let index = 0;
    let slotH = 0;
    let timer = null;

    function wordScale(i) {
        const word = words[i] || '';
        if (word.length > 18) {
            return 0.68;
        }
        if (word.length > 14) {
            return 0.78;
        }
        return 0.94;
    }

    function fitScrollBox() {
        let maxW = 0;
        let maxH = 0;
        const probe = document.createElement('span');
        probe.style.cssText = [
            'position:absolute',
            'visibility:hidden',
            'pointer-events:none',
            'font-family:Outfit,sans-serif',
            'font-weight:600',
            'letter-spacing:-0.03em',
            'line-height:1.15',
        ].join(';');

        const title = document.querySelector('.home-hero-title');
        const titleSize = title ? getComputedStyle(title).fontSize : '3rem';
        const parentW = scroll.parentElement ? scroll.parentElement.clientWidth : window.innerWidth;
        const maxBoxW = Math.max(parentW - 56, 220);

        document.body.appendChild(probe);

        words.forEach((word, i) => {
            probe.style.fontSize = `calc(${titleSize} * ${wordScale(i)})`;
            probe.style.whiteSpace = i === 3 ? 'normal' : 'nowrap';
            probe.style.display = 'block';
            probe.style.width = i === 3 ? `${maxBoxW}px` : 'auto';
            probe.style.maxWidth = `${maxBoxW}px`;
            probe.textContent = word;
            maxW = Math.max(maxW, probe.offsetWidth);
            maxH = Math.max(maxH, probe.offsetHeight);
        });

        document.body.removeChild(probe);

        slotH = Math.max(Math.ceil(maxH) + 4, 44);
        const boxW = Math.min(Math.ceil(maxW + 40), maxBoxW);

        scroll.style.setProperty('--hero-slot', `${slotH}px`);
        scroll.style.setProperty('--hero-scroll-width', `${boxW}px`);

        scrollWords.forEach((el) => {
            el.style.height = `${slotH}px`;
        });

        scrollInner.style.transition = 'none';
        scrollInner.style.transform = `translate3d(0,-${index * slotH}px,0)`;
    }

    function setTransform(i, animate) {
        scrollInner.style.transition = animate
            ? `transform ${transitionMs}ms cubic-bezier(0.4, 0, 0.2, 1)`
            : 'none';
        scrollInner.style.transform = `translate3d(0,-${i * slotH}px,0)`;
    }

    function fadeText(el, text) {
        if (!el) {
            return;
        }

        el.style.opacity = '0';
        window.setTimeout(() => {
            el.textContent = text;
            el.style.opacity = '1';
        }, 180);
    }

    function setText(el, text, animate) {
        if (!el) {
            return;
        }

        if (animate) {
            fadeText(el, text);
            return;
        }

        el.textContent = text;
        el.style.opacity = '1';
    }

    function showSlide(i, animateText) {
        index = i;
        const slide = slides[index] || {};

        setText(prefix, slide.verb || 'Scale', animateText);

        if (live) {
            live.textContent = `${slide.verb || 'Scale'} ${slide.word || words[index]}`;
        }

        setText(eyebrow, slide.eyebrow || '', animateText);
        setText(tagline, slide.tagline || '', animateText);
    }

    function tick() {
        const next = (index + 1) % words.length;

        if (next === 0) {
            setTransform(0, false);
            showSlide(0, true);
            return;
        }

        setTransform(next, true);
        showSlide(next, true);
    }

    function start() {
        if (timer) {
            clearInterval(timer);
        }

        timer = setInterval(tick, interval);
    }

    function init() {
        fitScrollBox();
        showSlide(0, false);
        setTransform(0, false);
        scroll.classList.add('is-ready');
        start();
    }

    init();

    window.addEventListener('resize', () => {
        fitScrollBox();
        setTransform(index, false);
    });

    if (document.fonts?.ready) {
        document.fonts.ready.then(() => {
            fitScrollBox();
            setTransform(index, false);
        });
    }

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        clearInterval(timer);
        scrollInner.style.transition = 'none';
    }
})();
