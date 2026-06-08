(function () {
    const media = document.querySelector('.hero-media');
    const canvas = document.getElementById('hero-video-canvas');
    if (!media || !canvas) {
        return;
    }

    const ctx = canvas.getContext('2d');
    let raf = null;
    const start = performance.now();
    let videoReady = false;
    let rotateTimer = null;
    const isRotateMode = media.classList.contains('hero-media--rotate');
    const crossfadeMs = 1800;
    const kenVariants = ['zoom-in', 'zoom-out', 'pan-left', 'pan-right'];
    const progressDots = media.querySelectorAll('.hero-media-progress-dot');

    const blobs = [
        { x: 0.25, y: 0.35, r: 0.48, hue: 188, phase: 0 },
        { x: 0.72, y: 0.28, r: 0.42, hue: 270, phase: 1.8 },
        { x: 0.55, y: 0.68, r: 0.5, hue: 175, phase: 3.2 },
        { x: 0.15, y: 0.72, r: 0.36, hue: 200, phase: 4.5 },
    ];

    function mediaSize() {
        return {
            w: media.clientWidth || window.innerWidth,
            h: media.clientHeight || window.innerHeight,
        };
    }

    function resize() {
        const size = mediaSize();
        const dpr = Math.min(window.devicePixelRatio || 1, 2);
        canvas.width = Math.floor(size.w * dpr);
        canvas.height = Math.floor(size.h * dpr);
        canvas.style.width = `${size.w}px`;
        canvas.style.height = `${size.h}px`;
        ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
    }

    function draw(t) {
        const size = mediaSize();
        const w = size.w;
        const h = size.h;
        const elapsed = (t - start) * 0.001;

        ctx.fillStyle = '#050a14';
        ctx.fillRect(0, 0, w, h);
        ctx.globalCompositeOperation = 'screen';

        blobs.forEach((b) => {
            const x = (b.x + Math.sin(elapsed * 0.18 + b.phase) * 0.1) * w;
            const y = (b.y + Math.cos(elapsed * 0.14 + b.phase) * 0.08) * h;
            const radius = b.r * Math.min(w, h) * (0.94 + Math.sin(elapsed * 0.22 + b.phase) * 0.07);
            const grad = ctx.createRadialGradient(x, y, 0, x, y, radius);

            grad.addColorStop(0, `hsla(${b.hue}, 80%, 62%, 0.45)`);
            grad.addColorStop(0.4, `hsla(${b.hue}, 70%, 48%, 0.2)`);
            grad.addColorStop(1, `hsla(${b.hue}, 60%, 30%, 0)`);

            ctx.fillStyle = grad;
            ctx.beginPath();
            ctx.arc(x, y, radius, 0, Math.PI * 2);
            ctx.fill();
        });

        ctx.globalCompositeOperation = 'source-over';
    }

    function loop(t) {
        draw(t);
        raf = requestAnimationFrame(loop);
    }

    function startCanvas() {
        if (isRotateMode) {
            return;
        }
        media.classList.add('hero-media--canvas');
        canvas.hidden = false;
        resize();
        if (!raf) {
            raf = requestAnimationFrame(loop);
        }
    }

    function stopCanvas() {
        if (raf) {
            cancelAnimationFrame(raf);
            raf = null;
        }
        canvas.hidden = true;
        media.classList.remove('hero-media--canvas');
    }

    function markVideoReady() {
        if (!videoReady) {
            videoReady = true;
            media.classList.add('hero-media--video');
            stopCanvas();
        }
    }

    function setKenBurns(video, sourceIndex) {
        video.dataset.ken = kenVariants[sourceIndex % kenVariants.length];
    }

    function setTone(sourceIndex, delay) {
        window.setTimeout(() => {
            media.setAttribute('data-hero-tone', String(sourceIndex % 4));
        }, delay || 0);
    }

    function restartProgress(sourceIndex, interval) {
        progressDots.forEach((dot, i) => {
            const fill = dot.querySelector('.hero-media-progress-fill');
            dot.classList.toggle('is-active', i === sourceIndex);
            if (fill) {
                fill.style.animation = 'none';
                void fill.offsetWidth;
                if (i === sourceIndex) {
                    fill.style.animation = `heroProgressFill ${interval / 1000}s linear forwards`;
                }
            }
        });
    }

    function loadSource(video, url) {
        return new Promise((resolve, reject) => {
            if (video.dataset.src === url && video.readyState >= 4) {
                resolve();
                return;
            }

            function cleanup() {
                video.removeEventListener('canplaythrough', onReady);
                video.removeEventListener('error', onError);
            }

            function onReady() {
                cleanup();
                video.dataset.src = url;
                resolve();
            }

            function onError() {
                cleanup();
                reject();
            }

            video.addEventListener('canplaythrough', onReady);
            video.addEventListener('error', onError);
            video.src = url;
            video.load();
        });
    }

    function playLayer(layer) {
        const video = layer.querySelector('.hero-video');
        if (!video) {
            return;
        }
        video.loop = true;
        if (video.currentTime < 0.05 || video.ended) {
            video.currentTime = 0;
        }
        const attempt = video.play();
        if (attempt?.catch) {
            attempt.catch(() => {});
        }
    }

    function initSingleVideo(video) {
        if (!video) {
            return;
        }

        function showVideo() {
            markVideoReady();
            video.classList.add('is-ready');
        }

        video.addEventListener('canplaythrough', showVideo);
        video.addEventListener('loadeddata', showVideo);
        video.addEventListener('error', () => {
            if (!videoReady) {
                startCanvas();
            }
        });

        video.load();
        video.loop = true;
        video.play().catch(() => {});
    }

    function initRotatingVideos(sources, interval) {
        const layers = Array.from(media.querySelectorAll('.hero-video-layer'));
        if (layers.length < 2 || sources.length < 2) {
            return;
        }

        media.style.setProperty('--hero-clip-duration', `${interval / 1000}s`);
        media.style.setProperty('--hero-crossfade', `${crossfadeMs / 1000}s`);

        let index = 0;
        let activeLayer = layers[0];
        let hiddenLayer = layers[1];
        let swapping = false;

        function nextIndex(current) {
            return (current + 1) % sources.length;
        }

        function prepareLayer(layer, sourceIndex) {
            const video = layer.querySelector('.hero-video');
            if (!video) {
                return Promise.resolve();
            }

            layer.classList.remove('is-active', 'is-leaving');
            setKenBurns(video, sourceIndex);

            return loadSource(video, sources[sourceIndex]).then(() => {
                video.pause();
                video.currentTime = 0;
            });
        }

        function crossfadeToNext() {
            if (swapping) {
                return;
            }

            const video = hiddenLayer.querySelector('.hero-video');
            if (!video || video.readyState < 4) {
                return;
            }

            swapping = true;
            const next = nextIndex(index);

            setTone(next, 0);
            restartProgress(next, interval);
            playLayer(hiddenLayer);
            hiddenLayer.classList.add('is-active');
            activeLayer.classList.add('is-leaving');

            window.setTimeout(() => {
                activeLayer.classList.remove('is-active', 'is-leaving');
                const videoOut = activeLayer.querySelector('.hero-video');
                if (videoOut) {
                    videoOut.pause();
                }

                const previous = activeLayer;
                activeLayer = hiddenLayer;
                hiddenLayer = previous;
                index = next;
                swapping = false;

                prepareLayer(hiddenLayer, nextIndex(index)).catch(() => {});
            }, crossfadeMs);
        }

        prepareLayer(hiddenLayer, nextIndex(0))
            .then(() => {
                setKenBurns(activeLayer.querySelector('.hero-video'), 0);
                return loadSource(activeLayer.querySelector('.hero-video'), sources[0]);
            })
            .then(() => {
                markVideoReady();
                setTone(0, 0);
                restartProgress(0, interval);
                playLayer(activeLayer);
                activeLayer.classList.add('is-active');
                rotateTimer = window.setInterval(crossfadeToNext, interval);
            })
            .catch(() => {
                startCanvas();
            });
    }

    function initVideo() {
        let sources = [];
        try {
            sources = JSON.parse(media.getAttribute('data-hero-videos') || '[]');
        } catch {
            sources = [];
        }

        const interval = parseInt(media.getAttribute('data-hero-rotate') || '0', 10);
        const rotate = isRotateMode && sources.length > 1 && interval > 0;

        if (rotate) {
            initRotatingVideos(sources, interval);
            return;
        }

        initSingleVideo(media.querySelector('.hero-video'));
    }

    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    resize();

    if (!reducedMotion) {
        initVideo();
        if (!isRotateMode) {
            window.setTimeout(() => {
                if (!videoReady) {
                    startCanvas();
                }
            }, 1500);
        }
    } else {
        startCanvas();
        media.querySelectorAll('.hero-video').forEach((video) => {
            video.pause();
        });
        draw(performance.now());
    }

    window.addEventListener('resize', () => {
        if (!videoReady) {
            resize();
        }
    });

    window.addEventListener('pagehide', () => {
        if (rotateTimer) {
            window.clearInterval(rotateTimer);
        }
    });
})();
