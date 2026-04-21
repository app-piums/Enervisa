// Vanilla port of the "lightning-split" React component.
// Animates a wavy diagonal divider between two layers with an electric arc SVG overlay.

const CONFIG = {
    timeClampSec: 0.05,
    segments: 64,
    amps: [1.2, -1.0, 0.7, -0.45],
    freqs: [1.1, 3.4, 7.2, 11.5],
    speeds: [-1.9, 0.8, 1.35, -2.4],
    shimmer: { speed: 10.5, freq: 24.0, amp: 0.8 },
    clipOffset: 28,
    easeStiffness: 9,
    defaultPos: 60,
    hoverLeft: 110,
    hoverRight: 20,
};

const clamp = (v) => Math.max(0, Math.min(100, v));

export function initLightningSplit(root) {
    const leftLayer = root.querySelector('[data-ls-left]');
    const svg = root.querySelector('[data-ls-svg]');
    if (!leftLayer || !svg) return;

    const polylines = svg.querySelectorAll('polyline');

    let target = CONFIG.defaultPos;
    let displayPos = CONFIG.defaultPos;
    let time = 0;
    let last = performance.now();
    let rafId = 0;

    const onMove = (e) => {
        const rect = root.getBoundingClientRect();
        const x = ((e.clientX - rect.left) / rect.width) * 100;
        target = x < 50 ? CONFIG.hoverLeft : CONFIG.hoverRight;
    };
    const onLeave = () => {
        target = CONFIG.defaultPos;
    };
    const onTouch = (e) => {
        if (!e.touches.length) return;
        const rect = root.getBoundingClientRect();
        const x = ((e.touches[0].clientX - rect.left) / rect.width) * 100;
        target = x < 50 ? CONFIG.hoverLeft : CONFIG.hoverRight;
    };

    root.addEventListener('mousemove', onMove, { passive: true });
    root.addEventListener('mouseleave', onLeave, { passive: true });
    root.addEventListener('touchmove', onTouch, { passive: true });
    root.addEventListener('touchend', onLeave, { passive: true });

    const tick = (now) => {
        const dt = Math.min(CONFIG.timeClampSec, (now - last) / 1000);
        last = now;
        time += dt;
        displayPos += (target - displayPos) * (1 - Math.exp(-CONFIG.easeStiffness * dt));

        const topX = clamp(displayPos);
        const bottomX = clamp(displayPos - CONFIG.clipOffset);

        let polyStr = '';
        let polyPct = '';
        for (let i = 0; i <= CONFIG.segments; i++) {
            const tn = i / CONFIG.segments;
            const y = tn * 100;
            const base = topX * (1 - tn) + bottomX * tn;
            let off = 0;
            for (let k = 0; k < CONFIG.amps.length; k++) {
                off += CONFIG.amps[k] * Math.sin(
                    2 * Math.PI * (CONFIG.freqs[k] * tn + CONFIG.speeds[k] * time) + k * 1.3
                );
            }
            off += CONFIG.shimmer.amp * Math.sin(
                2 * Math.PI * (CONFIG.shimmer.freq * tn + CONFIG.shimmer.speed * time)
            );
            off += 0.35 * Math.sin(time * 18.0 + tn * 55.0);
            off += 0.2 * Math.sin(time * 33.0 - tn * 80.0);
            const x = clamp(base + off);
            polyStr += (i ? ' ' : '') + x.toFixed(2) + ',' + y.toFixed(2);
            polyPct += (i ? ', ' : '') + x.toFixed(2) + '% ' + y.toFixed(2) + '%';
        }

        const clipPoly = `polygon(0% 0%, ${polyPct}, 0% 100%)`;
        polylines.forEach((pl) => pl.setAttribute('points', polyStr));
        leftLayer.style.clipPath = clipPoly;
        leftLayer.style.webkitClipPath = clipPoly;

        rafId = requestAnimationFrame(tick);
    };
    rafId = requestAnimationFrame(tick);

    return () => {
        cancelAnimationFrame(rafId);
        root.removeEventListener('mousemove', onMove);
        root.removeEventListener('mouseleave', onLeave);
        root.removeEventListener('touchmove', onTouch);
        root.removeEventListener('touchend', onLeave);
    };
}
