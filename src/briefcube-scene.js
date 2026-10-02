import * as THREE from 'three';

const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

const sceneRoot = document.querySelector('[data-cube-scene]');
const form = document.querySelector('[data-brief-form]');

let rotateCube = () => {};

if (sceneRoot) {
  const canvas = sceneRoot.querySelector('[data-cube-canvas]');

  try {
    const renderer = new THREE.WebGLRenderer({ canvas, alpha: true, antialias: true });
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    renderer.outputColorSpace = THREE.SRGBColorSpace;

    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(38, 1, 0.1, 100);
    camera.position.set(0, 0.1, 7.3);

    const rig = new THREE.Group();
    scene.add(rig);

    const cube = new THREE.Mesh(
      new THREE.BoxGeometry(2.62, 2.62, 2.62),
      ['#cfff3e', '#8f7cff', '#f7f4ed', '#3a2f70', '#e6e1ff', '#141419'].map(
        (color) => new THREE.MeshStandardMaterial({ color, roughness: 0.32, metalness: 0.08 })
      )
    );
    cube.rotation.set(-0.28, 0.52, 0.05);
    rig.add(cube);

    const edges = new THREE.LineSegments(
      new THREE.EdgesGeometry(cube.geometry),
      new THREE.LineBasicMaterial({ color: 0x17171c, transparent: true, opacity: 0.62 })
    );
    edges.rotation.copy(cube.rotation);
    rig.add(edges);

    const orbMaterial = new THREE.MeshBasicMaterial({ color: 0x6854f2, transparent: true, opacity: 0.9 });
    [[-2.2, 1.8, -0.3, 0.12], [2.0, -1.45, -0.1, 0.18], [2.35, 1.65, -1.2, 0.08]].forEach(([x, y, z, size]) => {
      const orb = new THREE.Mesh(new THREE.SphereGeometry(size, 24, 24), orbMaterial);
      orb.position.set(x, y, z);
      rig.add(orb);
    });

    scene.add(new THREE.HemisphereLight(0xffffff, 0x8b7eff, 2.4));
    const keyLight = new THREE.DirectionalLight(0xffffff, 3.4);
    keyLight.position.set(4, 5, 5);
    scene.add(keyLight);
    const rimLight = new THREE.PointLight(0xceff3e, 20, 11);
    rimLight.position.set(-4, -1, 3);
    scene.add(rimLight);

    const target = { x: -0.28, y: 0.52 };
    const pointer = { x: 0, y: 0 };
    const angles = [0.52, 1.72, 2.91, 4.09];

    rotateCube = (index) => {
      target.y = angles[index] ?? angles[0];
    };

    const resize = () => {
      const { width, height } = sceneRoot.getBoundingClientRect();
      renderer.setSize(width, height, false);
      camera.aspect = width / height;
      camera.updateProjectionMatrix();
    };
    new ResizeObserver(resize).observe(sceneRoot);
    resize();

    sceneRoot.addEventListener('pointermove', (event) => {
      const rect = sceneRoot.getBoundingClientRect();
      pointer.x = ((event.clientX - rect.left) / rect.width - 0.5) * 0.42;
      pointer.y = ((event.clientY - rect.top) / rect.height - 0.5) * 0.22;
    });
    sceneRoot.addEventListener('pointerleave', () => {
      pointer.x = 0;
      pointer.y = 0;
    });

    const clock = new THREE.Clock();
    const draw = () => {
      const elapsed = clock.getElapsedTime();
      cube.rotation.x += (target.x + pointer.y - cube.rotation.x) * 0.055;
      cube.rotation.y += (target.y + pointer.x - cube.rotation.y) * 0.055;
      cube.rotation.z = Math.sin(elapsed * 0.55) * 0.04;
      edges.rotation.copy(cube.rotation);
      rig.position.y = Math.sin(elapsed * 0.75) * 0.1;
      renderer.render(scene, camera);

      if (!reduceMotion) window.requestAnimationFrame(draw);
    };
    draw();
  } catch (error) {
    sceneRoot.classList.add('is-canvas-unavailable');
  }
}

if (form) {
  const choices = form.querySelectorAll('[data-brief-choice]');
  const stepButtons = form.querySelectorAll('[data-cube-step]');
  const questions = Array.from(form.querySelectorAll('[data-question]'));

  const choose = (button) => {
    const { field, value } = button.dataset;
    const input = form.querySelector(`[name="${field}"]`);
    const question = button.closest('[data-question]');
    const summary = form.querySelector(`[data-summary="${field}"]`);

    question.querySelectorAll('[data-brief-choice]').forEach((choice) => choice.classList.remove('is-selected'));
    button.classList.add('is-selected');
    input.value = value;
    summary.textContent = value;
  };

  choices.forEach((button) => button.addEventListener('click', () => choose(button)));
  questions.forEach((question) => choose(question.querySelector('[data-brief-choice]')));

  stepButtons.forEach((button) => {
    button.addEventListener('click', () => {
      stepButtons.forEach((step) => step.classList.remove('is-active'));
      button.classList.add('is-active');
      rotateCube(Number(button.dataset.cubeStep));
      questions[Number(button.dataset.cubeStep)]?.scrollIntoView({ behavior: reduceMotion ? 'auto' : 'smooth', block: 'center' });
    });
  });
}

const header = document.querySelector('[data-site-header]');
const menuToggle = document.querySelector('[data-menu-toggle]');

menuToggle?.addEventListener('click', () => {
  const isOpen = header.classList.toggle('is-menu-open');
  menuToggle.setAttribute('aria-expanded', String(isOpen));
});

document.querySelectorAll('.site-nav a').forEach((link) => {
  link.addEventListener('click', () => {
    header?.classList.remove('is-menu-open');
    menuToggle?.setAttribute('aria-expanded', 'false');
  });
});
