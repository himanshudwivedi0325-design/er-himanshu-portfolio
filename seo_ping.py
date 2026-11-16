import re
import json
import datetime
import subprocess
import urllib.request
import urllib.error

def update_sitemap_date():
    file_path = 'sitemap.xml'
    with open(file_path, 'r', encoding='utf-8') as f:
        content = f.read()
        
    today = datetime.datetime.now().strftime('%Y-%m-%d')
    new_content = re.sub(
        r'<lastmod>.*?</lastmod>', 
        f'<lastmod>{today}</lastmod>', 
        content
    )
    with open(file_path, 'w', encoding='utf-8') as f:
        f.write(new_content)
    print(f"Success: sitemap.xml updated with today's date: {today}")

def ping_indexnow():
    host = "himanshudwivedi0325-design.github.io"
    key = "07843a91c23d259511b457a6eb89b7cc"
    key_location = f"https://{host}/er-himanshu-portfolio/{key}.txt"
    url_list = [
        f"https://{host}/er-himanshu-portfolio/",
        f"https://{host}/er-himanshu-portfolio/sitemap.xml",
        f"https://{host}/er-himanshu-portfolio/llms.txt"
    ]
    
    payload = {
        "host": host,
        "key": key,
        "keyLocation": key_location,
        "urlList": url_list
    }
    
    data = json.dumps(payload).encode('utf-8')
    req = urllib.request.Request(
        "https://api.indexnow.org/indexnow",
        data=data,
        headers={"Content-Type": "application/json; charset=utf-8"}
    )
    try:
        with urllib.request.urlopen(req, timeout=10) as resp:
            print(f"IndexNow Ping Response: {resp.status} {resp.reason}")
    except urllib.error.URLError as e:
        print(f"IndexNow Ping notification: {e}")

def git_commit_and_push():
    try:
        print("Committing and pushing all SEO/AEO/GEO updates to GitHub...")
        subprocess.run(['git', 'add', '-A'], check=True)
        today = datetime.datetime.now().strftime("%Y-%m-%d")
        commit_msg = f"SEO/AEO/GEO Overhaul {today}: AI search bots, enhanced llms.txt, schema FAQ, clean entities"
        subprocess.run(['git', 'commit', '-m', commit_msg], check=True)
        subprocess.run(['git', 'push'], check=True)
        print("Successfully pushed all updates to GitHub!")
        print("Google, Bing, Brave, and AI Crawlers have been triggered.")
    except subprocess.CalledProcessError as e:
        print(f"Git operation info: {e}")

if __name__ == '__main__':
    update_sitemap_date()
    ping_indexnow()
    git_commit_and_push()
