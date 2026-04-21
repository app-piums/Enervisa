import * as THREE from 'three';

const vertexShader = /* glsl */ `
    varying vec2 vUv;
    void main() {
        vUv = uv;
        gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0);
    }
`;

// Animated energy field with electric plasma and bolt-like highlights.
const fragmentShader = /* glsl */ `
    precision highp float;
    varying vec2 vUv;
    uniform float uTime;
    uniform vec2 uResolution;
    uniform vec2 uMouse;

    // Brand colors
    const vec3 BLUE_DARK = vec3(0.059, 0.145, 0.251);   // #0f2540
    const vec3 BLUE     = vec3(0.106, 0.227, 0.361);    // #1B3A5C
    const vec3 ORANGE   = vec3(0.910, 0.325, 0.114);    // #E8531D
    const vec3 ORANGE_L = vec3(0.953, 0.478, 0.290);    // #f37a4a

    // 2D simplex noise (Ashima)
    vec3 permute(vec3 x) { return mod(((x*34.0)+1.0)*x, 289.0); }
    float snoise(vec2 v){
        const vec4 C = vec4(0.211324865405187, 0.366025403784439,
                -0.577350269189626, 0.024390243902439);
        vec2 i  = floor(v + dot(v, C.yy));
        vec2 x0 = v -   i + dot(i, C.xx);
        vec2 i1 = (x0.x > x0.y) ? vec2(1.0, 0.0) : vec2(0.0, 1.0);
        vec4 x12 = x0.xyxy + C.xxzz;
        x12.xy -= i1;
        i = mod(i, 289.0);
        vec3 p = permute(permute(i.y + vec3(0.0, i1.y, 1.0))
            + i.x + vec3(0.0, i1.x, 1.0));
        vec3 m = max(0.5 - vec3(dot(x0,x0), dot(x12.xy,x12.xy),
            dot(x12.zw,x12.zw)), 0.0);
        m = m*m; m = m*m;
        vec3 x = 2.0 * fract(p * C.www) - 1.0;
        vec3 h = abs(x) - 0.5;
        vec3 ox = floor(x + 0.5);
        vec3 a0 = x - ox;
        m *= 1.79284291400159 - 0.85373472095314 * (a0*a0 + h*h);
        vec3 g;
        g.x  = a0.x  * x0.x  + h.x  * x0.y;
        g.yz = a0.yz * x12.xz + h.yz * x12.yw;
        return 130.0 * dot(m, g);
    }

    float fbm(vec2 p) {
        float v = 0.0;
        float a = 0.5;
        for (int i = 0; i < 5; i++) {
            v += a * snoise(p);
            p *= 2.0;
            a *= 0.5;
        }
        return v;
    }

    void main() {
        vec2 uv = vUv;
        vec2 p = uv * 2.0 - 1.0;
        p.x *= uResolution.x / uResolution.y;

        float t = uTime;

        // Deep blue base gradient with slight radial lift.
        float radial = smoothstep(1.6, 0.2, length(p * vec2(0.95, 0.8)));
        vec3 base = mix(BLUE_DARK, BLUE, smoothstep(-0.2, 1.0, uv.y));
        base = mix(base, BLUE_DARK, 0.22 * (1.0 - radial));

        // Ridged plasma pattern (sharper and less "wavy").
        float e1 = 1.0 - abs(snoise(p * vec2(3.1, 2.0) + vec2(t * 0.9, -t * 0.6)));
        float e2 = 1.0 - abs(snoise(p * vec2(7.0, 4.4) + vec2(-t * 1.8, t * 1.2)));
        float plasma = pow(clamp(e1 * 0.72 + e2 * 0.48, 0.0, 1.0), 2.0);

        // Two animated electric "fault lines" crossing the frame.
        float boltAPath = p.x + 0.16 * sin(p.y * 8.0 + t * 3.3) + 0.08 * snoise(vec2(p.y * 7.0, t * 1.5));
        float boltBPath = p.x - 0.45 + 0.13 * sin(p.y * 10.0 - t * 4.2) + 0.06 * snoise(vec2(p.y * 11.0, -t * 1.9));
        float boltA = smoothstep(0.10, 0.0, abs(boltAPath));
        float boltB = smoothstep(0.08, 0.0, abs(boltBPath));

        float micro = snoise(p * 24.0 + vec2(t * 10.0, -t * 7.0));
        float flicker = 0.65 + 0.35 * sin(t * 24.0 + p.y * 45.0 + micro * 3.0);
        float bolts = clamp((boltA * 1.2 + boltB) * flicker, 0.0, 1.0);

        vec3 col = base;
        col = mix(col, ORANGE, plasma * 0.52);
        col += ORANGE_L * plasma * 0.25;
        col += vec3(0.58, 0.80, 1.0) * bolts * 0.75;
        col += vec3(1.0) * bolts * 0.55;

        // Vignette
        float vig = smoothstep(1.4, 0.3, length(p * 0.6));
        col *= 0.6 + 0.4 * vig;

        gl_FragColor = vec4(col, 1.0);
    }
`;

export function initShader(canvas) {
    const renderer = new THREE.WebGLRenderer({
        canvas,
        antialias: false,
        alpha: false,
        powerPreference: 'high-performance',
    });
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));

    const scene = new THREE.Scene();
    const camera = new THREE.OrthographicCamera(-1, 1, 1, -1, 0, 1);

    const uniforms = {
        uTime: { value: 0 },
        uResolution: { value: new THREE.Vector2(1, 1) },
        uMouse: { value: new THREE.Vector2(0.5, 0.5) },
    };

    const material = new THREE.ShaderMaterial({
        vertexShader,
        fragmentShader,
        uniforms,
    });
    const geometry = new THREE.PlaneGeometry(2, 2);
    const mesh = new THREE.Mesh(geometry, material);
    scene.add(mesh);

    function resize() {
        const w = canvas.clientWidth;
        const h = canvas.clientHeight;
        renderer.setSize(w, h, false);
        uniforms.uResolution.value.set(w, h);
    }
    resize();
    window.addEventListener('resize', resize);

    canvas.addEventListener('mousemove', (e) => {
        const rect = canvas.getBoundingClientRect();
        uniforms.uMouse.value.set(
            (e.clientX - rect.left) / rect.width,
            1 - (e.clientY - rect.top) / rect.height
        );
    });

    const clock = new THREE.Clock();
    let rafId;
    function animate() {
        uniforms.uTime.value = clock.getElapsedTime();
        renderer.render(scene, camera);
        rafId = requestAnimationFrame(animate);
    }
    animate();

    // Pause when offscreen to save resources
    const io = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting && !rafId) {
                animate();
            } else if (!entry.isIntersecting && rafId) {
                cancelAnimationFrame(rafId);
                rafId = null;
            }
        });
    });
    io.observe(canvas);
}
