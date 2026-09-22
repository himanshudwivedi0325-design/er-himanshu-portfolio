# Himanshu Dwivedi - Premium Portfolio Website

A visually stunning, high-performance single-page portfolio website designed for **Himanshu Dwivedi**, a 3rd-year Diploma in Computer Science Engineering student, Full Stack Developer, AI Creator, and DSA Mentor (Founder of PrepWithHD).

## Features

- **Premium Theme**: Dark mode theme (`#050806` / `#08110e`) with neon green (`#8cff00`) and cyan (`#19f4ff`) glow accents.
- **Glassmorphism**: Elegant card layouts with backdrop blurs and semi-transparent borders.
- **Micro-Animations**:
  - Custom cursor glow that follows mouse movements with inertia and expands on hover.
  - Scroll progress bar at the top of the page.
  - Interactive typing animation for professional roles.
  - 3D card tilt effect on the profile card.
  - Dynamic numerical count-up animation for statistics.
  - Smooth scroll reveal for sections as they enter the viewport.
- **Testimonial Slider**: Auto-sliding reviews with manual dot indicators.
- **Contact Form**: Real-time validation, error shake animations, and an interactive mock submission.
- **SEO & Semantics**: Search engine optimized using meta tags, Open Graph tags, and structured JSON-LD data.

## Project Structure

```text
himanshu-portfolio/
├── index.html   # Semantic HTML5 structure
├── style.css    # Custom responsive CSS & animations
├── script.js    # Interactive features & animations
└── README.md    # Project documentation
```

## How to Run

1. Open `index.html` directly in your web browser.
2. Alternatively, you can run a local development server (e.g., VS Code Live Server or python's `http.server`) to ensure smooth asset loading:
   ```bash
   python -m http.server 8000
   ```
   Then open `http://localhost:8000` in your browser.

## Customization

- **Updating Biography**: Modify the `<article class="about-card">` in `index.html`.
- **Changing Skills**: Update the progress bar percentages and skill cards in `index.html` (inside `<section id="skills">`).
- **Replacing Resume**: Save your resume as `resume.pdf` in the root directory.
- **Adding Projects**: Update the `<section id="projects">` in `index.html` with your custom SVGs, tech stacks, and links.
