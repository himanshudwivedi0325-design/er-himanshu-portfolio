<?php
/**
 * Himanshu Dwivedi Portfolio — Dynamic Landing Page (index.php)
 * Fetches all content dynamically from the MySQL database.
 * Preserves 100% of the original premium design, styles, and animations.
 */

require_once 'config/db.php';

// 1. Fetch Hero Section
try {
    $hero_stmt = $pdo->query("SELECT * FROM hero LIMIT 1");
    $hero = $hero_stmt->fetch();
    if (!$hero) {
        $hero = (object)[
            'heading' => 'Himanshu Dwivedi',
            'subheading' => 'Diploma in Computer Science Engineering student (2024 - 2027).'
        ];
    }
} catch (PDOException $e) {
    $hero = (object)[
        'heading' => 'Himanshu Dwivedi',
        'subheading' => 'Diploma in Computer Science Engineering student (2024 - 2027).'
    ];
}

// 2. Fetch About Section
try {
    $about_stmt = $pdo->query("SELECT * FROM about LIMIT 1");
    $about = $about_stmt->fetch();
    $about_content = $about ? $about->content : '';
} catch (PDOException $e) {
    $about_content = '';
}

// 3. Fetch Skills
try {
    $skills_stmt = $pdo->query("SELECT * FROM skills ORDER BY percentage DESC");
    $skills = $skills_stmt->fetchAll();
    
    // Categorize skills dynamically
    $frontend_skills = [];
    $backend_skills = [];
    $tools_skills = [];
    
    foreach ($skills as $skill) {
        $name = strtolower($skill->skill_name);
        if (strpos($name, 'html') !== false || strpos($name, 'css') !== false || strpos($name, 'javascript') !== false || strpos($name, 'bootstrap') !== false || strpos($name, 'react') !== false || strpos($name, 'frontend') !== false) {
            $frontend_skills[] = $skill;
        } elseif (strpos($name, 'php') !== false || strpos($name, 'mysql') !== false || strpos($name, 'database') !== false || strpos($name, 'laravel') !== false || strpos($name, 'sql') !== false || strpos($name, 'backend') !== false) {
            $backend_skills[] = $skill;
        } else {
            $tools_skills[] = $skill;
        }
    }
} catch (PDOException $e) {
    $skills = [];
    $frontend_skills = [];
    $backend_skills = [];
    $tools_skills = [];
}

// 4. Fetch Projects
try {
    $projects_stmt = $pdo->query("SELECT * FROM projects ORDER BY id DESC");
    $projects = $projects_stmt->fetchAll();
} catch (PDOException $e) {
    $projects = [];
}

// 5. Fetch Active Resume
try {
    $resume_stmt = $pdo->query("SELECT * FROM resume ORDER BY id DESC LIMIT 1");
    $resume = $resume_stmt->fetch();
    $resume_url = $resume ? 'uploads/' . htmlspecialchars($resume->file_name, ENT_QUOTES, 'UTF-8') : '#';
} catch (PDOException $e) {
    $resume_url = '#';
}

// Include Header Component
require_once 'includes/header.php';
?>

    <main>
      <!-- Hero Section -->
      <section class="hero" id="home" aria-label="Introduction">
        <div class="floating-bg" aria-hidden="true">
          <div class="blob green"></div>
          <div class="blob cyan"></div>
          <div class="blob gold"></div>
          <div class="particles" id="particles"></div>
        </div>

        <div class="container hero-grid">
          <div class="hero-content reveal">
            <div class="availability" role="status"><span></span> Open to internships & collaborative projects</div>
            <h1 class="hero-title"><span style="position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0;">Er. Himanshu Dwivedi Portfolio - Who is Er. Himanshu Dwivedi - </span>Hi, I'm <span class="gradient-text">Er. <?php echo htmlspecialchars($hero->heading, ENT_QUOTES, 'UTF-8'); ?></span></h1>
            <div class="hero-role" aria-label="Professional roles">
              I am a <span class="typing-wrap"><span id="typingText">Full Stack Developer & Engineer</span><span class="typing-cursor"></span></span>
            </div>
            <p class="hero-subtitle">
              <?php echo htmlspecialchars($hero->subheading, ENT_QUOTES, 'UTF-8'); ?>
            </p>
            <div class="hero-buttons">
              <a class="btn btn-primary" href="#projects">My Projects</a>
              <a class="btn btn-secondary" href="#resume">View Resume / CV</a>
              <a class="btn btn-ghost" href="https://wa.me/919369418177?text=Hello%20Himanshu,%20I%20visited%20your%20portfolio%20and%20would%20like%20to%20connect%20with%20you!" target="_blank" rel="noopener noreferrer">Get In Touch</a>
            </div>
            <div class="hero-meta" aria-label="Highlights">
              <span class="meta-pill">Er. Himanshu Dwivedi</span>
              <span class="meta-pill">Founder of PrepWithHD</span>
              <span class="meta-pill">ADCA & CCC Certified</span>
              <span class="meta-pill">Bilingual Typing (Eng & Hin)</span>
            </div>
          </div>

          <div class="hero-visual reveal" data-parallax="0.16">
            <div class="profile-orbit" aria-hidden="true"></div>
            <div class="profile-card glass tilt-card">
              <a class="profile-image-link" href="assets/himanshu.jpg" target="_blank" aria-label="View Himanshu Dwivedi profile image in full size">
                <div class="profile-image-shell">
                  <img src="assets/himanshu.jpg" alt="Himanshu Dwivedi" class="profile-real-photo" />
                  <div class="profile-photo-overlay"></div>
                </div>
              </a>
              <div class="profile-badge one glass">⚡ <span>Full Stack<small>PHP & MySQL</small></span></div>
              <div class="profile-badge two glass">💻 <span>Builder<small>PrepWithHD</small></span></div>
            </div>
          </div>
        </div>
      </section>

      <!-- About Section -->
      <section class="section" id="about" aria-label="About Himanshu">
        <div class="container">
          <div class="section-head reveal">
            <div class="eyebrow">About Me</div>
            <h2 class="section-title">Developer with a <span>builder mindset</span></h2>
            <p class="section-copy">Focused on practical web applications, database management, and creating useful tools for students.</p>
          </div>

          <div class="about-grid">
            <article class="about-card glass reveal">
              <h3 style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;">
                <span>Who is Er. Himanshu Dwivedi?</span>
                <span style="font-size: 0.74rem; background: rgba(245, 158, 11, 0.12); color: var(--green); border: 1px solid rgba(245, 158, 11, 0.25); border-radius: 999px; padding: 3px 10px;">Official Bio</span>
              </h3>
              <p style="margin-bottom: 14px; line-height: 1.7; color: var(--text);">
                <strong>Er. Himanshu Dwivedi</strong> is an Indian Full Stack Developer and Diploma in Computer Science Engineering student (2024–2027) based in Uttar Pradesh. Known for crafting responsive web tools, he is the founder of the student resource platform <strong>PrepWithHD</strong> and developer of interactive projects including <strong>Progress Typing Test</strong>.
              </p>
              <p style="line-height: 1.7; color: var(--muted);">
                <?php 
                if (!empty($about_content)) {
                    // Render database content safely, preserving line breaks
                    echo nl2br(htmlspecialchars($about_content, ENT_QUOTES, 'UTF-8'));
                } else {
                    echo "Loading about information...";
                }
                ?>
              </p>
            </article>

            <div class="stats-grid reveal" id="statsGrid">
              <article class="stat-card glass reveal-child">
                <span class="stat-number" data-count="<?php echo count($projects); ?>">0</span>
                <span class="stat-label">Active Projects</span>
              </article>
              <article class="stat-card glass reveal-child">
                <span class="stat-number" data-count="<?php echo count($skills); ?>">0</span>
                <span class="stat-label">Core Technologies</span>
              </article>
              <article class="stat-card glass reveal-child">
                <span class="stat-number" data-count="60">0</span>
                <span class="stat-label">Typing Speed (WPM)</span>
              </article>
            </div>
          </div>
        </div>
      </section>

      <!-- Skills Section -->
      <section class="section" id="skills" aria-label="Technical Skills">
        <div class="container">
          <div class="section-head reveal">
            <div class="eyebrow">Skills</div>
            <h2 class="section-title">My Technical <span>Arsenal</span></h2>
            <p class="section-copy">The core web technologies, certifications, and capabilities I use to build my applications.</p>
            
            <!-- Interactive Skills Tabs -->
            <div class="skills-tabs-nav">
              <button class="tab-btn active" data-tab="frontend-pane">Frontend</button>
              <button class="tab-btn" data-tab="backend-pane">Backend & Database</button>
              <button class="tab-btn" data-tab="tools-pane">Tools & Certs</button>
            </div>
          </div>

          <!-- Skills Tabs Content -->
          <div class="skills-tabs-content mt-4">
            <!-- Frontend Tab -->
            <div class="tab-pane active" id="frontend-pane">
              <div class="skills-grid reveal">
                <?php if (!empty($frontend_skills)): ?>
                  <?php foreach ($frontend_skills as $skill): ?>
                    <article class="skill-card glass reveal-child">
                      <div class="skill-top">
                        <div class="skill-icon">
                          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M16 18l6-6-6-6M8 6L2 12l6 6"/>
                          </svg>
                        </div>
                        <span class="skill-percent"><?php echo (int)$skill->percentage; ?>%</span>
                      </div>
                      <h3><?php echo htmlspecialchars($skill->skill_name, ENT_QUOTES, 'UTF-8'); ?></h3>
                      <div class="progress-track">
                        <div class="progress-fill" data-width="<?php echo (int)$skill->percentage; ?>%" aria-label="<?php echo htmlspecialchars($skill->skill_name, ENT_QUOTES, 'UTF-8'); ?> proficiency at <?php echo (int)$skill->percentage; ?>%"></div>
                      </div>
                    </article>
                  <?php endforeach; ?>
                <?php else: ?>
                  <p class="text-center text-muted py-4 w-100">No frontend skills added yet.</p>
                <?php endif; ?>
              </div>
            </div>

            <!-- Backend Tab -->
            <div class="tab-pane" id="backend-pane">
              <div class="skills-grid">
                <?php if (!empty($backend_skills)): ?>
                  <?php foreach ($backend_skills as $skill): ?>
                    <article class="skill-card glass">
                      <div class="skill-top">
                        <div class="skill-icon">
                          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M16 18l6-6-6-6M8 6L2 12l6 6"/>
                          </svg>
                        </div>
                        <span class="skill-percent"><?php echo (int)$skill->percentage; ?>%</span>
                      </div>
                      <h3><?php echo htmlspecialchars($skill->skill_name, ENT_QUOTES, 'UTF-8'); ?></h3>
                      <div class="progress-track">
                        <div class="progress-fill" style="width: <?php echo (int)$skill->percentage; ?>%;" data-width="<?php echo (int)$skill->percentage; ?>%" aria-label="<?php echo htmlspecialchars($skill->skill_name, ENT_QUOTES, 'UTF-8'); ?> proficiency at <?php echo (int)$skill->percentage; ?>%"></div>
                      </div>
                    </article>
                  <?php endforeach; ?>
                <?php else: ?>
                  <p class="text-center text-muted py-4 w-100">No backend skills added yet.</p>
                <?php endif; ?>
              </div>
            </div>

            <!-- Tools Tab -->
            <div class="tab-pane" id="tools-pane">
              <div class="skills-grid">
                <?php if (!empty($tools_skills)): ?>
                  <?php foreach ($tools_skills as $skill): ?>
                    <article class="skill-card glass">
                      <div class="skill-top">
                        <div class="skill-icon">
                          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M16 18l6-6-6-6M8 6L2 12l6 6"/>
                          </svg>
                        </div>
                        <span class="skill-percent"><?php echo (int)$skill->percentage; ?>%</span>
                      </div>
                      <h3><?php echo htmlspecialchars($skill->skill_name, ENT_QUOTES, 'UTF-8'); ?></h3>
                      <div class="progress-track">
                        <div class="progress-fill" style="width: <?php echo (int)$skill->percentage; ?>%;" data-width="<?php echo (int)$skill->percentage; ?>%" aria-label="<?php echo htmlspecialchars($skill->skill_name, ENT_QUOTES, 'UTF-8'); ?> proficiency at <?php echo (int)$skill->percentage; ?>%"></div>
                      </div>
                    </article>
                  <?php endforeach; ?>
                <?php else: ?>
                  <p class="text-center text-muted py-4 w-100">No tools or certifications added yet.</p>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Experience & Education Timeline -->
      <section class="section" id="experience" aria-label="Education and Milestones">
        <div class="container">
          <div class="section-head reveal">
            <div class="eyebrow">Timeline</div>
            <h2 class="section-title">Education & <span>Milestones</span></h2>
            <p class="section-copy">My academic path, professional certifications, and ongoing development projects.</p>
          </div>

          <div class="timeline reveal">
            <!-- Item 1 -->
            <div class="timeline-item reveal-child">
              <div class="timeline-node"></div>
              <div class="timeline-card glass">
                <time datetime="2024/2027">2024 - 2027 (Expected)</time>
                <h3>Diploma in Computer Science Engineering</h3>
                <p>Focusing on computer science fundamentals, including database design, web development, algorithms, and software engineering principles.</p>
              </div>
            </div>

            <!-- Item 2 -->
            <div class="timeline-item reveal-child">
              <div class="timeline-node"></div>
              <div class="timeline-card glass">
                <time datetime="2026">2026 - Present</time>
                <h3>Founder & Lead Developer</h3>
                <p><strong>PrepWithHD</strong> — Developing a centralized student portal designed for sharing academic notes, study guides, and semester resources. Working on backend databases and responsive UI.</p>
              </div>
            </div>

            <!-- Item 3 -->
            <div class="timeline-item reveal-child">
              <div class="timeline-node"></div>
              <div class="timeline-card glass">
                <time datetime="2023/2024">2023 - 2024</time>
                <h3>Advance Diploma in Computer Applications (ADCA)</h3>
                <p>Completed a 1-year comprehensive course covering office automation, database concepts, basic programming, and IT applications.</p>
              </div>
            </div>

            <!-- Item 4 -->
            <div class="timeline-item reveal-child">
              <div class="timeline-node"></div>
              <div class="timeline-card glass">
                <time datetime="2023">2023</time>
                <h3>Course on Computer Concepts (CCC)</h3>
                <p>Earned a 3-month certification from **NIELIT** (National Institute of Electronics & Information Technology), verifying core IT literacy and digital concepts.</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Projects Section -->
      <section class="section" id="projects" aria-label="Featured Projects">
        <div class="container">
          <div class="section-head reveal">
            <div class="eyebrow">Projects</div>
            <h2 class="section-title">Featured <span>Work</span></h2>
            <p class="section-copy">A showcase of the primary applications I am building and testing.</p>
          </div>

          <div class="projects-grid reveal">
            <?php if (!empty($projects)): ?>
              <?php 
              foreach ($projects as $project): 
                $is_featured = (strpos(strtolower($project->title), 'prepwithhd') !== false);
                $featured_class = $is_featured ? 'featured' : '';
              ?>
                <article class="project-card glass reveal-child <?php echo $featured_class; ?>">
                  <?php if ($is_featured): ?>
                    <span class="featured-badge"><i class="fa-solid fa-star me-1"></i> Featured Project</span>
                  <?php endif; ?>
                  <div class="project-media">
                    <?php if (!empty($project->image) && file_exists('uploads/' . $project->image)): ?>
                      <img src="uploads/<?php echo htmlspecialchars($project->image, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($project->title, ENT_QUOTES, 'UTF-8'); ?>" style="width:100%; height:218px; object-fit:cover;" />
                    <?php else: ?>
                      <!-- Coding Vector Graphic fallback -->
                      <svg viewBox="0 0 400 218" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <rect width="400" height="218" fill="#060f0c"/>
                        <circle cx="200" cy="109" r="60" fill="url(#proj-glow-<?php echo $project->id; ?>)" opacity="0.15"/>
                        <rect x="80" y="49" width="240" height="120" rx="10" fill="#091814" stroke="#14352b" stroke-width="2"/>
                        <circle cx="100" cy="64" r="5" fill="#ff5f6d"/>
                        <circle cx="112" cy="64" r="5" fill="#ffd166"/>
                        <circle cx="124" cy="64" r="5" fill="#8cff00"/>
                        <path d="M140 100l-15 15 15 15M260 100l15 15-15 15M190 135l20-40" stroke="#8cff00" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        <defs>
                          <radialGradient id="proj-glow-<?php echo $project->id; ?>" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(200 109) rotate(90) scale(60)">
                            <stop stop-color="#8cff00"/><stop offset="1" stop-color="#8cff00" stop-opacity="0"/>
                          </radialGradient>
                        </defs>
                      </svg>
                    <?php endif; ?>
                  </div>
                  <div class="project-body">
                    <div class="badges">
                      <?php 
                      $tags = explode(',', $project->tech_stack);
                      foreach ($tags as $tag): 
                      ?>
                        <span class="badge"><?php echo htmlspecialchars(trim($tag), ENT_QUOTES, 'UTF-8'); ?></span>
                      <?php endforeach; ?>
                    </div>
                    <h3><?php echo htmlspecialchars($project->title, ENT_QUOTES, 'UTF-8'); ?></h3>
                    <p><?php echo htmlspecialchars($project->description, ENT_QUOTES, 'UTF-8'); ?></p>
                    
                    <div class="project-links">
                      <?php if (!empty($project->github_link)): ?>
                        <a class="btn btn-primary" href="<?php echo htmlspecialchars($project->github_link, ENT_QUOTES, 'UTF-8'); ?>" target="_blank" rel="noopener noreferrer">GitHub</a>
                      <?php endif; ?>
                      
                      <?php if (!empty($project->live_link)): ?>
                        <a class="btn btn-secondary" href="<?php echo htmlspecialchars($project->live_link, ENT_QUOTES, 'UTF-8'); ?>" target="_blank" rel="noopener noreferrer">Live Demo</a>
                      <?php else: ?>
                        <span class="btn btn-secondary" style="opacity: 0.6; cursor: not-allowed;" aria-disabled="true">Under Dev</span>
                      <?php endif; ?>
                    </div>
                  </div>
                </article>
              <?php endforeach; ?>
            <?php else: ?>
              <p>No projects added yet.</p>
            <?php endif; ?>
          </div>
        </div>
      </section>

      <!-- Academic Coursework Section -->
      <section class="section" id="coursework" aria-label="Academic Coursework">
        <div class="container">
          <div class="section-head reveal">
            <div class="eyebrow">Academics</div>
            <h2 class="section-title">Core <span>Coursework</span></h2>
            <p class="section-copy">Important theoretical and practical concepts I study in my Computer Science Diploma.</p>
          </div>

          <div class="coursework-grid reveal">
            <!-- Concept 1 -->
            <article class="coursework-card glass reveal-child">
              <div class="coursework-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
              </div>
              <h3>Web Technologies</h3>
              <p>Studying both client-side and server-side web technologies, focusing on responsive layouts, script executions, and server integrations.</p>
            </article>

            <!-- Concept 2 -->
            <article class="coursework-card glass reveal-child">
              <div class="coursework-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/><path d="M3 12c0 1.66 4 3 9 3s9-1.34 9-3"/></svg>
              </div>
              <h3>Database Management</h3>
              <p>Learning relational database designs, SQL queries, table normalization, and establishing secure connections between databases and applications.</p>
            </article>

            <!-- Concept 3 -->
            <article class="coursework-card glass reveal-child">
              <div class="coursework-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6A1 1 0 0 0 17.7 9l3.6-3.6a1 1 0 0 0 0-1.4l-1.6-1.6a1 1 0 0 0-1.4 0zM2 22h4v-4H2zM12 12h4v-4h-4z"/></svg>
              </div>
              <h3>Software Engineering</h3>
              <p>Understanding Software Development Life Cycle (SDLC) models, software requirements gathering, testing strategies, and writing clean, maintainable code.</p>
            </article>

            <!-- Concept 4 -->
            <article class="coursework-card glass reveal-child">
              <div class="coursework-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
              </div>
              <h3>Object-Oriented Programming</h3>
              <p>Grasping fundamental OOP concepts such as Classes, Objects, Inheritance, Polymorphism, Encapsulation, and Abstraction.</p>
            </article>
          </div>
        </div>
      </section>

      <!-- Resume / CV Section -->
      <section class="section" id="resume" aria-label="My Resume">
        <div class="container">
          <div class="section-head reveal">
            <div class="eyebrow">Resume</div>
            <h2 class="section-title">Professional <span>CV</span></h2>
            <p class="section-copy">My structured professional resume. You can view it below or print it directly.</p>
            
            <div style="display: flex; gap: 12px; justify-content: center; margin-top: 16px;">
              <button class="btn btn-secondary" onclick="window.print()">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="margin-right: 6px;">
                  <polyline points="6 9 6 2 18 2 18 9"/>
                  <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                  <rect x="6" y="14" width="12" height="8"/>
                </svg>
                <span>Print Resume</span>
              </button>
              
              <?php if ($resume_url !== '#'): ?>
                <a class="btn btn-primary" href="<?php echo $resume_url; ?>" download="Himanshu_Dwivedi_Resume.pdf">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="margin-right: 6px;">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="7 10 12 15 17 10"/>
                    <line x1="12" y1="15" x2="12" y2="3"/>
                  </svg>
                  <span>Download PDF</span>
                </a>
              <?php endif; ?>
            </div>
          </div>

          <div class="resume-wrapper glass reveal">
            <!-- Resume Header -->
            <div class="resume-header">
              <div class="resume-title-area">
                <h2>Himanshu Dwivedi</h2>
                <p class="resume-subtitle">Full Stack Developer & CSE Student</p>
              </div>
              <div class="resume-contact-info">
                <p>📧 himanshudwivedi0325@gmail.com</p>
                <p>📍 Uttar Pradesh, India</p>
                <p>🔗 github.com/himanshudwivedi</p>
                <p>🔗 linkedin.com/in/himanshu-webdev</p>
              </div>
            </div>

            <!-- Resume Content Grid -->
            <div class="resume-content">
              <!-- Left Column: Summary, Experience, Projects -->
              <div class="resume-main-col">
                <div class="resume-block">
                  <h3>Professional Summary</h3>
                  <p>
                    Motivated Computer Science Engineering student (expected graduation 2027) with a strong foundation in full-stack web development. Enthusiastic builder passionate about backend databases, responsive user interfaces, and creating practical tools for student productivity.
                  </p>
                </div>

                <div class="resume-block">
                  <h3>Education & Academic Path</h3>
                  <div class="resume-item">
                    <div class="resume-item-header">
                      <h4>Diploma in Computer Science Engineering</h4>
                      <span class="resume-date">2024 - 2027</span>
                    </div>
                    <p class="resume-org">Board of Technical Education</p>
                    <p>Focusing on computer science fundamentals, data structures, relational database management systems, and software engineering principles.</p>
                  </div>
                  <div class="resume-item">
                    <div class="resume-item-header">
                      <h4>Advance Diploma in Computer Applications (ADCA)</h4>
                      <span class="resume-date">2023 - 2024</span>
                    </div>
                    <p class="resume-org">1-Year Certification Course</p>
                    <p>Acquired strong expertise in office automation tools, database management concepts, and IT operations.</p>
                  </div>
                  <div class="resume-item">
                    <div class="resume-item-header">
                      <h4>Course on Computer Concepts (CCC)</h4>
                      <span class="resume-date">2023</span>
                    </div>
                    <p class="resume-org">NIELIT (3-Month Certification)</p>
                    <p>Certified in core digital literacy, operating systems, internet technologies, and cybersecurity concepts.</p>
                  </div>
                </div>

                <div class="resume-block">
                  <h3>Key Projects</h3>
                  <div class="resume-item">
                    <div class="resume-item-header">
                      <h4>PrepWithHD Portal (Founder & Lead Developer)</h4>
                      <span class="resume-date">2026 - Present</span>
                    </div>
                    <p>A centralized web platform built with PHP, MySQL, and Bootstrap to help diploma students access semester notes, syllabus files, and study resources. Developed secure document uploads, user login systems, and optimized database queries.</p>
                  </div>
                  <div class="resume-item">
                    <div class="resume-item-header">
                      <h4>Personal Portfolio Website</h4>
                      <span class="resume-date">2026</span>
                    </div>
                    <p>A premium, responsive portfolio website showcasing qualifications, certifications, and projects using HTML5, CSS3, and JavaScript. Featuring a custom glowing cursor, magnetic buttons, and staggered scroll reveals.</p>
                  </div>
                </div>
              </div>

              <!-- Right Column: Skills, Languages, Certifications -->
              <div class="resume-side-col">
                <div class="resume-block">
                  <h3>Technical Skills</h3>
                  <ul class="resume-skills-list">
                    <li><strong>Languages:</strong> HTML5, CSS3, JavaScript (ES6+), PHP, SQL</li>
                    <li><strong>Frameworks/Libraries:</strong> Bootstrap</li>
                    <li><strong>Databases:</strong> MySQL</li>
                    <li><strong>Tools & Platforms:</strong> Git, GitHub, VS Code</li>
                    <li><strong>Additional:</strong> AI Integration, AI Prompting</li>
                  </ul>
                </div>

                <div class="resume-block">
                  <h3>Key Competencies</h3>
                  <ul class="resume-bullets">
                    <li>Bilingual Typing (English & Hindi, 60+ WPM)</li>
                    <li>Relational Database Design</li>
                    <li>Responsive Web Development</li>
                    <li>Software Development Life Cycle (SDLC)</li>
                  </ul>
                </div>

                <div class="resume-block">
                  <h3>Certifications</h3>
                  <ul class="resume-bullets">
                    <li>1-Year ADCA Certification</li>
                    <li>3-Month CCC Certificate (NIELIT)</li>
                    <li>Bilingual Typing Speed Validation (60+ WPM)</li>
                  </ul>
                </div>

                <div class="resume-block">
                  <h3>Languages</h3>
                  <ul class="resume-bullets">
                    <li>English (Professional)</li>
                    <li>Hindi (Native)</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Contact Section -->
      <section class="section" id="contact" aria-label="Contact Himanshu">
        <div class="container">
          <div class="section-head reveal">
            <div class="eyebrow">Contact</div>
            <h2 class="section-title">Let's Build <span>Together</span></h2>
            <p class="section-copy">Have an internship opportunity or want to discuss a project? Drop me a message!</p>
          </div>

          <div class="contact-grid">
            <div class="contact-panel glass reveal">
              <h3>Get In Touch</h3>
              <p>I am actively looking for opportunities to learn and apply my technical skills. Feel free to connect with me.</p>
              
              <div class="contact-list">
                <a href="mailto:himanshudwivedi0325@gmail.com" class="contact-link" aria-label="Email Himanshu at himanshudwivedi0325@gmail.com">
                  <div class="contact-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                  </div>
                  <span>himanshudwivedi0325@gmail.com</span>
                </a>
                <div class="contact-link">
                  <div class="contact-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                  </div>
                  <span>India</span>
                </div>
              </div>
            </div>

            <form class="contact-form glass reveal" id="contactForm" novalidate aria-label="Contact form">
              <!-- Spam Protection Honeypot Field -->
              <div style="display:none;" aria-hidden="true">
                <label for="honeypot">Leave this field blank</label>
                <input type="text" id="honeypot" name="honeypot" tabindex="-1" autocomplete="off" />
              </div>

              <div class="form-grid">
                <div class="form-group">
                  <label for="name">Your Name</label>
                  <input type="text" id="name" name="name" required placeholder="John Doe" aria-describedby="nameError" />
                  <span class="error-text" id="nameError" role="alert"></span>
                </div>
                <div class="form-group">
                  <label for="email">Your Email</label>
                  <input type="email" id="email" name="email" required placeholder="john@example.com" aria-describedby="emailError" />
                  <span class="error-text" id="emailError" role="alert"></span>
                </div>
                <div class="form-group full">
                  <label for="subject">Subject</label>
                  <input type="text" id="subject" name="subject" required placeholder="Internship / Project Discussion" aria-describedby="subjectError" />
                  <span class="error-text" id="subjectError" role="alert"></span>
                </div>
                <div class="form-group full">
                  <label for="message">Message</label>
                  <textarea id="message" name="message" required placeholder="Hi Himanshu, I would love to connect with you about..." aria-describedby="messageError"></textarea>
                  <span class="error-text" id="messageError" role="alert"></span>
                </div>
              </div>
              <button type="submit" class="btn btn-primary">Send Message</button>
              <div class="form-message" id="formMessage" role="status" aria-live="polite"></div>
            </form>
          </div>
        </div>
      </section>
    </main>

<?php
// Include Footer Component
require_once 'includes/footer.php';
?>
