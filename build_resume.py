# -*- coding: utf-8 -*-
import os
from reportlab.lib import pagesizes, colors
from reportlab.lib.styles import getSampleStyleSheet, ParagraphStyle
from reportlab.platypus import SimpleDocTemplate, Paragraph, Spacer, Table, TableStyle, HRFlowable
import fitz

pdf_path = "uploads/himanshu_resume.pdf"
os.makedirs("uploads", exist_ok=True)

# A4 dimensions: 595.27 x 841.89 pt
doc = SimpleDocTemplate(
    pdf_path,
    pagesize=pagesizes.A4,
    leftMargin=30,
    rightMargin=30,
    topMargin=22,
    bottomMargin=20
)

styles = getSampleStyleSheet()

primary_color = colors.HexColor("#0f172a") # Slate 900
accent_color = colors.HexColor("#1d4ed8")  # Blue 700
body_color = colors.HexColor("#1e293b")    # Slate 800
muted_color = colors.HexColor("#475569")   # Slate 600
line_color = colors.HexColor("#cbd5e1")

name_style = ParagraphStyle(
    "ResumeName",
    parent=styles["Normal"],
    fontName="Helvetica-Bold",
    fontSize=19,
    leading=21,
    textColor=primary_color,
    alignment=1
)

title_style = ParagraphStyle(
    "ResumeTitle",
    parent=styles["Normal"],
    fontName="Helvetica-Bold",
    fontSize=9,
    leading=11,
    textColor=accent_color,
    alignment=1
)

contact_style = ParagraphStyle(
    "ResumeContact",
    parent=styles["Normal"],
    fontName="Helvetica",
    fontSize=8,
    leading=10.5,
    textColor=muted_color,
    alignment=1
)

sec_title_style = ParagraphStyle(
    "SecTitle",
    parent=styles["Normal"],
    fontName="Helvetica-Bold",
    fontSize=9.5,
    leading=11.5,
    textColor=accent_color,
    spaceAfter=1
)

body_style = ParagraphStyle(
    "Body",
    parent=styles["Normal"],
    fontName="Helvetica",
    fontSize=8,
    leading=10.2,
    textColor=body_color
)

bullet_style = ParagraphStyle(
    "Bullet",
    parent=body_style,
    leftIndent=10,
    firstLineIndent=-7,
    spaceAfter=1
)

job_title_style = ParagraphStyle(
    "JobTitle",
    parent=styles["Normal"],
    fontName="Helvetica-Bold",
    fontSize=8.5,
    leading=10.5,
    textColor=primary_color
)

job_meta_style = ParagraphStyle(
    "JobMeta",
    parent=styles["Normal"],
    fontName="Helvetica-Bold",
    fontSize=8,
    leading=10.5,
    textColor=muted_color,
    alignment=2
)

story = []

# Header
story.append(Paragraph("Er. Himanshu Dwivedi", name_style))
story.append(Spacer(1, 2))
story.append(Paragraph("FULL STACK WEB DEVELOPER &bull; COMPUTER SCIENCE ENGINEERING (2024 - 2027)", title_style))
story.append(Spacer(1, 3))

contact_text = (
    'Gonda, Uttar Pradesh, India &nbsp;|&nbsp; '
    '<b>Email:</b> <a href="mailto:himanshudwivedi0325@gmail.com"><font color="#1d4ed8">himanshudwivedi0325@gmail.com</font></a> &nbsp;|&nbsp; '
    '<b>Portfolio:</b> <a href="https://himanshudwivedi0325-design.github.io/er-himanshu-portfolio/"><font color="#1d4ed8">himanshudwivedi-portfolio</font></a><br/>'
    '<b>GitHub:</b> <a href="https://github.com/himanshudwivedi0325-design"><font color="#1d4ed8">github.com/himanshudwivedi0325-design</font></a> &nbsp;|&nbsp; '
    '<b>LinkedIn:</b> <a href="https://www.linkedin.com/in/er-himanshu-dwivedi"><font color="#1d4ed8">linkedin.com/in/er-himanshu-dwivedi</font></a>'
)
story.append(Paragraph(contact_text, contact_style))
story.append(Spacer(1, 4))
story.append(HRFlowable(width="100%", thickness=1, color=line_color, spaceAfter=4))

def add_header(title):
    story.append(Paragraph(title.upper(), sec_title_style))
    story.append(HRFlowable(width="100%", thickness=0.8, color=accent_color, spaceAfter=3, spaceBefore=1))

# 1. Summary
add_header("Professional Summary")
summary = (
    "Proactive Full Stack Web Developer and Computer Science Engineering student (expected graduation 2027) with proven "
    "hands-on expertise in developing scalable web systems, low-latency WebSocket communication architectures, and normalized "
    "MySQL databases. Creator of <b>HDTalk</b> (real-time chat & media platform) and founder of <b>PrepWithHD</b>. "
    "Skilled in translating complex requirements into robust, high-performance web applications with clean, production-ready code."
)
story.append(Paragraph(summary, body_style))
story.append(Spacer(1, 4))

# 2. Technical Skills
add_header("Technical Skills & Core Competencies")
skills_rows = [
    [Paragraph("<b>Languages & Web:</b>", body_style), Paragraph("PHP, JavaScript (ES6+), SQL, HTML5, CSS3, Modern Responsive UI Engineering", body_style)],
    [Paragraph("<b>Real-Time & Networking:</b>", body_style), Paragraph("WebSockets, WebRTC, Event-Driven Networking, Duplex Streaming, RESTful APIs", body_style)],
    [Paragraph("<b>Databases & Architecture:</b>", body_style), Paragraph("MySQL (Relational Schema Design, Complex Joins, Query Optimization, Indexing)", body_style)],
    [Paragraph("<b>Frameworks & Design:</b>", body_style), Paragraph("Bootstrap 5, CSS Grid/Flexbox, DOM Manipulation, Staggered Motion Animations", body_style)],
    [Paragraph("<b>Tools, Hosting & DevOps:</b>", body_style), Paragraph("Git, GitHub, VS Code, Linux CLI, Apache Server, Render Cloud, Cloudflare DNS/SSL", body_style)],
    [Paragraph("<b>Key Competencies:</b>", body_style), Paragraph("Bilingual Typing (English & Hindi 60+ WPM), SDLC, OOP, Code Refactoring, Problem Solving", body_style)],
]
sk_table = Table(skills_rows, colWidths=[140, 395])
sk_table.setStyle(TableStyle([
    ('VALIGN', (0,0), (-1,-1), 'TOP'),
    ('BOTTOMPADDING', (0,0), (-1,-1), 1),
    ('TOPPADDING', (0,0), (-1,-1), 1),
    ('LEFTPADDING', (0,0), (-1,-1), 0),
    ('RIGHTPADDING', (0,0), (-1,-1), 0),
]))
story.append(sk_table)
story.append(Spacer(1, 4))

# 3. Featured Projects
add_header("Featured Engineering Projects")

def add_proj(title, meta, bullets):
    r = [Paragraph(title, job_title_style), Paragraph(meta, job_meta_style)]
    t = Table([r], colWidths=[385, 150])
    t.setStyle(TableStyle([
        ('VALIGN', (0,0), (-1,-1), 'TOP'),
        ('BOTTOMPADDING', (0,0), (-1,-1), 0),
        ('TOPPADDING', (0,0), (-1,-1), 0),
        ('LEFTPADDING', (0,0), (-1,-1), 0),
        ('RIGHTPADDING', (0,0), (-1,-1), 0),
    ]))
    story.append(t)
    for b in bullets:
        story.append(Paragraph(f"&bull; {b}", bullet_style))
    story.append(Spacer(1, 2.5))

add_proj(
    "<b>HDTalk &mdash; Real-Time Communication Platform</b> | <a href='https://hdtalk.onrender.com'><font color='#1d4ed8'>hdtalk.onrender.com</font></a>",
    "Creator & Lead Developer | 2026",
    [
        "Engineered a production real-time communication platform utilizing <b>WebSockets</b> for instantaneous bi-directional messaging and media sharing.",
        "Built lightweight event-driven socket connection handlers to maintain persistent low-latency sessions across concurrent clients.",
        "Crafted an ultra-responsive dark-mode user interface with modular CSS and native JavaScript ensuring fluid cross-device execution."
    ]
)

add_proj(
    "<b>PrepWithHD &mdash; Centralized Engineering Academic Portal</b>",
    "Founder & Full Stack Developer | 2026 - Present",
    [
        "Architected an academic resource ecosystem with <b>PHP, MySQL, and Bootstrap</b> to deliver structured semester notes and syllabus roadmaps.",
        "Implemented role-based administrative authentication, secure document upload mechanisms, and optimized relational query indexing.",
        "Empowered polytechnic and diploma engineering students with high-speed access to curated semester curriculum modules."
    ]
)

add_proj(
    "<b>Bilingual Progress Typing Test Utility</b>",
    "Lead Developer | 2026",
    [
        "Engineered an interactive typing measurement tool supporting dual scripts (Hindi Kruti Dev / Mangal and standard English).",
        "Built dynamic analytics engine computing real-time Words Per Minute (WPM), accuracy thresholds, and keystroke diagnostics."
    ]
)

add_proj(
    "<b>Er. Himanshu Dwivedi Official Portfolio</b> | <a href='https://himanshudwivedi0325-design.github.io/er-himanshu-portfolio/'><font color='#1d4ed8'>Live Site</font></a>",
    "Personal Engineer Profile | 2026",
    [
        "Developed a zero-dependency portfolio incorporating comprehensive <b>JSON-LD WebSite & Person Schema</b> for Google Knowledge Graph SEO.",
        "Implemented interactive micro-interactions, glowing cursor tracking, magnetic buttons, and responsive cross-viewport layouts."
    ]
)

story.append(Spacer(1, 2))

# 4. Education
add_header("Education & Academic Credentials")

def add_edu(degree, institute, duration, details):
    r = [Paragraph(f"<b>{degree}</b> &mdash; {institute}", job_title_style), Paragraph(duration, job_meta_style)]
    t = Table([r], colWidths=[400, 135])
    t.setStyle(TableStyle([
        ('VALIGN', (0,0), (-1,-1), 'TOP'),
        ('BOTTOMPADDING', (0,0), (-1,-1), 0),
        ('TOPPADDING', (0,0), (-1,-1), 0),
        ('LEFTPADDING', (0,0), (-1,-1), 0),
        ('RIGHTPADDING', (0,0), (-1,-1), 0),
    ]))
    story.append(t)
    story.append(Paragraph(details, body_style))
    story.append(Spacer(1, 2))

add_edu(
    "Diploma in Computer Science Engineering (CSE)",
    "Board of Technical Education Uttar Pradesh",
    "2024 - 2027",
    "<i>Core Studies:</i> Data Structures & Algorithms, Relational Database Management Systems (RDBMS), Operating Systems, Web Technologies."
)

add_edu(
    "Advance Diploma in Computer Applications (ADCA)",
    "1-Year Professional Certification",
    "2023 - 2024",
    "<i>Curriculum:</i> Advanced office automation, database operations, visual programming fundamentals, and IT operations."
)

add_edu(
    "Course on Computer Concepts (CCC)",
    "NIELIT (Govt. of India)",
    "2023",
    "Certified in core digital literacy, networking concepts, computer fundamentals, and cyber hygiene."
)

story.append(Spacer(1, 2))

# 5. Certifications & Languages
add_header("Certifications, Strengths & Languages")
cert_summary = (
    "&bull; <b>Certifications:</b> 1-Year ADCA Diploma &bull; NIELIT CCC Certificate &bull; Verified Bilingual Typist (English & Hindi 60+ WPM)<br/>"
    "&bull; <b>Languages:</b> Hindi (Native Proficiency) &bull; English (Professional Working Proficiency)<br/>"
    "&bull; <b>Interests & Strengths:</b> Real-Time Systems, Full-Stack Architecture, Clean Code Practices, Problem Solving, Continuous Learning"
)
story.append(Paragraph(cert_summary, body_style))

# Build
doc.build(story)

# Render with fitz
doc_fitz = fitz.open(pdf_path)
page_cnt = len(doc_fitz)
print(f"RESULT: {page_cnt} page(s)")
for idx, p in enumerate(doc_fitz):
    pix = p.get_pixmap(dpi=150)
    pix.save(f"uploads/resume_page_{idx+1}.png")
