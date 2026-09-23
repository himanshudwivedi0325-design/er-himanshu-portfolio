# 🚀 GitHub Pages 1-Minute Live Deployment Guide

Aapka original portfolio ka static HTML version bilkul ready ho chuka hai with:
- 100% same neon design, animations aur layout
- Nayi blazer wali official studio portrait photo (`assets/himanshu.jpg`)
- Google Schema.org (`Person`, `ProfilePage`) & Googlebot SEO tags
- WhatsApp & Email contact form
- Google Search Console verification file (`googlefa7a1a36ea6554fc.html`)

---

## Sirf Ye 3 Steps Karein:

### Step 1: GitHub par Nayi Repository Banayein
1. Apne browser me **[github.com/new](https://github.com/new)** open karein.
2. Repository name daalein:  
   👉 `portfolio` (ya `himanshu-portfolio` ya `<aapka-username>.github.io`)
3. Ise **Public** hi rehne dein aur **"Create repository"** button par click karein.

---

### Step 2: Code ko Push Karein (Sirf 2 Commands)
Apne terminal ya powershell me ye commands run karein:

```powershell
cd "C:\Users\hp\.gemini\antigravity\scratch\himanshu-portfolio"
git remote add origin https://github.com/<AAPKA_GITHUB_USERNAME>/<REPO_NAME>.git
git push -u origin main
```
*(Yahan `<AAPKA_GITHUB_USERNAME>` aur `<REPO_NAME>` ki jagah apna username aur repo ka naam likhein).*

---

### Step 3: GitHub Pages ON Karein
1. Apni GitHub Repository me upar **Settings** par click karein.
2. Left sidebar me **Pages** par click karein.
3. **Build and deployment** me:
   - Branch: **`main`** select karein
   - Folder: **`/ (root)`** select karein
4. **Save** par click karein!

🎉 **1 se 2 minute ke andar aapka portfolio live ho jayega:**  
`https://<aapka-username>.github.io/<repo-name>/`

---

## Step 4: Google Search Console me Submit Karein (Google par aane ke liye)
1. [Google Search Console](https://search.google.com/search-console) open karein.
2. Apna live GitHub Pages URL daalein. (Verification file `googlefa7a1a36ea6554fc.html` pehle se repo me maujood hai, to instant verify ho jayega).
3. **Sitemaps** me jaakar `sitemap.xml` submit karein aur **"Request Indexing"** par click karein.

Ab Googlebot bina kisi rukawat ke aapki website aur photo index kar lega!
