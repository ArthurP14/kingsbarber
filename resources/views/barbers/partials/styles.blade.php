<style>
:root{
  --bg:#EEEEEB; --bg2:#E2E2DD; --card:#FFFFFF; --ink:#101010; --muted:#575752; --line:#CBCBC4;
  --accent:#C99A1C; --accent-text:#7A5A00; --accent-ink:#101010;
  --display:"Archivo","Arial Narrow","Helvetica Neue",Arial,sans-serif;
  --body:"DM Sans",system-ui,-apple-system,"Segoe UI",Roboto,Arial,sans-serif;
  box-sizing:border-box;
  padding-top:env(safe-area-inset-top,0px);
  padding-bottom:env(safe-area-inset-bottom,0px);
}
@media (prefers-color-scheme: dark){
  :root:not([data-theme="light"]){
    --bg:#0C0C0D; --bg2:#151517; --card:#161618; --ink:#F2F0EA; --muted:#A4A49D; --line:#2B2B2E;
    --accent:#E0B33A; --accent-text:#E0B33A; --accent-ink:#101010;
  }
}
:root[data-theme="dark"]{
  --bg:#0C0C0D; --bg2:#151517; --card:#161618; --ink:#F2F0EA; --muted:#A4A49D; --line:#2B2B2E;
  --accent:#E0B33A; --accent-text:#E0B33A; --accent-ink:#101010;
}
*,*::before,*::after{box-sizing:inherit}
html{height:100%;scroll-behavior:smooth;scroll-padding-top:calc(env(safe-area-inset-top,0px) + 72px)}
body{margin:0;min-height:100%;background:var(--bg);color:var(--ink);font-family:var(--body);font-size:17px;line-height:1.6;-webkit-font-smoothing:antialiased;overflow-x:hidden}
a{color:inherit}
button,summary{font:inherit;color:inherit;cursor:pointer}
:focus-visible{outline:3px solid var(--accent);outline-offset:3px;border-radius:4px}
.wrap{max-width:1240px;margin:0 auto;padding:0 32px}
.display{font-family:var(--display);font-weight:900;font-stretch:62%;font-variation-settings:"wdth" 62;text-transform:uppercase;line-height:.88;letter-spacing:-.005em}

/* Header */
header.top{position:sticky;top:env(safe-area-inset-top,0px);z-index:40;background:color-mix(in srgb,var(--bg) 88%,transparent);backdrop-filter:blur(10px);border-bottom:1px solid var(--line)}
header.top .wrap{display:flex;align-items:center;justify-content:space-between;height:68px;gap:16px}
.brand{font-family:var(--display);font-weight:900;font-variation-settings:"wdth" 75;font-size:26px;text-transform:uppercase;text-decoration:none;letter-spacing:.01em}
nav.links{display:flex;align-items:center;gap:28px}
nav.links a{text-decoration:none;font-weight:500;font-size:15px;color:var(--muted)}
nav.links a:hover{color:var(--ink)}
.menu-btn{display:none;background:none;border:1.5px solid var(--line);border-radius:6px;padding:8px 14px;font-weight:600;min-height:44px}
.btn{display:inline-flex;align-items:center;justify-content:center;background:var(--accent);color:var(--accent-ink);border:0;border-radius:4px;padding:13px 26px;font-weight:700;text-decoration:none;font-size:16px;min-height:48px}
.btn:hover{filter:brightness(1.08)}
.btn.ghost{background:transparent;color:var(--ink);border:1.5px solid var(--ink)}
.btn.small{padding:8px 18px;min-height:42px;font-size:15px}
nav.links a.btn{color:var(--accent-ink)}

/* Hero */
.hero{position:relative;min-height:calc(100svh - 68px);display:flex;flex-direction:column;justify-content:space-between;overflow:hidden;border-bottom:1px solid var(--line)}
.fade{position:absolute;top:0;bottom:0;right:0;width:68%;pointer-events:none}
.fade i{position:absolute;inset:0;display:block}
.fade i:nth-child(1){background:repeating-linear-gradient(90deg,var(--accent) 0 2px,transparent 2px 7px);-webkit-mask-image:linear-gradient(270deg,#000 0%,transparent 42%);mask-image:linear-gradient(270deg,#000 0%,transparent 42%)}
.fade i:nth-child(2){background:repeating-linear-gradient(90deg,var(--accent) 0 2px,transparent 2px 16px);-webkit-mask-image:linear-gradient(270deg,transparent 15%,#000 45%,transparent 75%);mask-image:linear-gradient(270deg,transparent 15%,#000 45%,transparent 75%)}
.fade i:nth-child(3){background:repeating-linear-gradient(90deg,var(--accent) 0 2px,transparent 2px 34px);-webkit-mask-image:linear-gradient(270deg,transparent 40%,#000 70%,transparent 100%);mask-image:linear-gradient(270deg,transparent 40%,#000 70%,transparent 100%)}
.hero .main{position:relative;padding:64px 0 40px}
h1{margin:0 0 30px;font-size:clamp(60px,12.6vw,190px)}
h1 span{display:block;animation:rise .9s cubic-bezier(.2,.7,.2,1) both}
h1 span:nth-child(2){animation-delay:.14s}
@keyframes rise{from{opacity:0;transform:translateY(38px)}to{opacity:1;transform:none}}
.hero p.lede{font-size:20px;max-width:30em;margin:0 0 30px;color:var(--muted)}
.cta-row{display:flex;flex-wrap:wrap;gap:12px}
.strip{position:relative;border-top:1px solid var(--line);background:color-mix(in srgb,var(--bg) 82%,transparent);backdrop-filter:blur(6px)}
.strip .wrap{display:flex;flex-wrap:wrap;gap:12px 40px;align-items:center;padding-top:16px;padding-bottom:16px;font-size:15px}
.strip .status{display:flex;align-items:center;gap:10px;font-weight:600}
.dot{width:10px;height:10px;border-radius:50%;background:#37B26C;flex:none}
.dot.closed{background:#D9424E}
.strip button.next{background:none;border:0;padding:0;font-weight:600;text-decoration:underline;text-underline-offset:4px;text-decoration-color:var(--accent)}
.strip .phone{margin-left:auto;color:var(--muted);text-decoration:none}

/* Marquee */
.marquee{background:var(--accent);color:var(--accent-ink);overflow:hidden;white-space:nowrap;padding:14px 0}
.marquee .track{display:inline-flex;animation:scroll 42s linear infinite}
.marquee span{font-family:var(--display);font-weight:800;font-variation-settings:"wdth" 70;font-size:26px;text-transform:uppercase;padding:0 20px;display:inline-flex;align-items:center;gap:40px}
.marquee span::after{content:"";width:9px;height:9px;background:currentColor;transform:rotate(45deg)}
@keyframes scroll{to{transform:translateX(-50%)}}
@media (prefers-reduced-motion:reduce){.marquee .track{animation:none}h1 span{animation:none}html{scroll-behavior:auto}}

section{padding:104px 0}
h2.sec{font-size:clamp(46px,7.4vw,104px);margin:0 0 18px}
.intro{color:var(--muted);max-width:34em;margin:0 0 52px;font-size:18px}

/* Story */
.story .wrap{display:grid;grid-template-columns:1.1fr .9fr;gap:72px;align-items:center}
.story p{color:var(--muted);margin:0 0 20px;max-width:32em}
.facts{display:flex;gap:44px;margin-top:38px;flex-wrap:wrap}
.facts div{border-left:3px solid var(--accent);padding-left:16px}
.facts b{display:block;font-family:var(--display);font-weight:900;font-variation-settings:"wdth" 62;font-size:58px;line-height:.95}
.facts span{color:var(--muted);font-size:15px}
.plate{position:relative;background:var(--bg2);border:1px solid var(--line);border-radius:6px;aspect-ratio:4/5;overflow:hidden;display:grid;place-items:center}
.plate .lines{position:absolute;inset:0;background:repeating-linear-gradient(0deg,var(--accent) 0 1.5px,transparent 1.5px 12px);opacity:.28;-webkit-mask-image:linear-gradient(180deg,#000,transparent 85%);mask-image:linear-gradient(180deg,#000,transparent 85%)}
.plate svg{position:relative;width:82%;height:auto}
.plate figcaption{position:absolute;left:22px;bottom:18px;font-family:var(--display);font-variation-settings:"wdth" 70;font-weight:800;font-size:22px;text-transform:uppercase;color:var(--ink)}

/* Services */
.services{background:var(--bg2);border-top:1px solid var(--line);border-bottom:1px solid var(--line)}
.grid{display:grid;grid-template-columns:repeat(4,1fr);gap:20px}
.svc{background:var(--card);border:1px solid var(--line);border-radius:6px;overflow:hidden;display:flex;flex-direction:column}
.svc .tile{height:170px;background-color:var(--bg2);position:relative;overflow:hidden}
.svc .tile img{width:100%;height:100%;object-fit:contain;display:block;transition:transform .5s cubic-bezier(.2,.7,.2,1)}
/*.svc:hover .tile img{transform:scale(1.06)}*/
.svc .tile::after{content:"";position:absolute;inset:0;background:linear-gradient(180deg,transparent 45%,rgba(0,0,0,.5));pointer-events:none;z-index:0}
.svc .tile-badge{position:absolute;top:12px;right:12px;background:rgba(0,0,0,.65);color:#fff;font-size:12px;font-weight:600;padding:5px 9px;border-radius:4px;letter-spacing:.03em;backdrop-filter:blur(6px);z-index:2}
.svc .tile.no-image{background:repeating-linear-gradient(45deg,var(--accent) 0 2px,transparent 2px 11px)}
.svc .tile.no-image::after{background:none}.svc .tile{height:150px;background-color:var(--bg2);position:relative}
.svc .tile::after{content:"";position:absolute;inset:0;background:var(--pat);opacity:.9}
.svc .body{padding:20px;display:flex;flex-direction:column;gap:2px;flex:1}
.svc h3{font-family:var(--display);font-weight:900;font-variation-settings:"wdth" 70;font-size:30px;line-height:1;text-transform:uppercase;margin:0 0 6px}
.svc .meta{color:var(--muted);font-size:15px}
.svc .row{display:flex;align-items:center;justify-content:space-between;margin-top:auto;padding-top:18px}
.svc .price{font-family:var(--display);font-weight:900;font-variation-settings:"wdth" 70;font-size:34px}
.pricenote{margin:28px 0 0;color:var(--muted)}

/* Book */
.book .wrap{display:grid;grid-template-columns:.75fr 1.4fr;gap:64px;align-items:start}
.perks{list-style:none;padding:0;margin:0}
.perks li{padding:18px 0;border-top:1px solid var(--line)}
.perks li:last-child{border-bottom:1px solid var(--line)}
.perks b{display:block;font-size:18px}
.perks span{color:var(--muted)}
.card{background:var(--card);border:1px solid var(--line);border-radius:6px;padding:30px}
.step{margin-bottom:26px}
.step h3{font-size:16px;font-weight:700;margin:0 0 10px}
.chips{display:flex;flex-wrap:wrap;gap:8px}
.chip{background:transparent;border:1.5px solid var(--line);border-radius:4px;padding:9px 14px;font-size:15px;font-weight:500;line-height:1.3;text-align:left;min-height:44px}
.chip:hover:not(:disabled){border-color:var(--ink)}
.chip[aria-pressed="true"]{background:var(--accent);border-color:var(--accent);color:var(--accent-ink)}
.chip:disabled{opacity:.35;cursor:not-allowed;text-decoration:line-through}
.chip small{display:block;font-weight:400;opacity:.8;font-size:13px}
.fields{display:grid;grid-template-columns:1fr 1fr;gap:12px}
label{font-size:14px;font-weight:600;display:block;margin-bottom:4px}
input{width:100%;font:inherit;padding:11px 12px;border:1.5px solid var(--line);border-radius:4px;background:var(--bg);color:var(--ink);min-height:46px}
.summary{display:flex;justify-content:space-between;align-items:center;gap:16px;flex-wrap:wrap;border-top:1px solid var(--line);padding-top:20px}
.summary p{margin:0;font-weight:500}
.err{color:#C0313D;font-weight:600;font-size:15px;margin:0 0 12px;min-height:1.2em}
:root:not([data-theme="light"]) .err{color:#F08A94}
@media (prefers-color-scheme: light){:root:not([data-theme="dark"]) .err{color:#C0313D}}
.done h3{font-family:var(--display);font-weight:900;font-variation-settings:"wdth" 62;text-transform:uppercase;font-size:56px;line-height:.9;margin:0 0 14px}
.done dl{display:grid;grid-template-columns:auto 1fr;gap:6px 20px;margin:20px 0}
.done dt{color:var(--muted)}
.done dd{margin:0;font-weight:600}

/* Barbers */
.crew{display:grid;grid-template-columns:repeat(3,1fr);gap:0}
.barber{padding:8px 32px 8px 0;border-right:1px solid var(--line);margin-right:32px}
.barber:last-child{border:0;margin:0;padding-right:0}
.barber .mono{font-family:var(--display);font-weight:900;font-variation-settings:"wdth" 62;font-size:120px;line-height:.8;color:var(--accent);margin-bottom:14px}
.barber h3{font-family:var(--display);font-weight:900;font-variation-settings:"wdth" 70;text-transform:uppercase;font-size:38px;line-height:1;margin:0 0 6px}
.barber .role{font-weight:600;margin-bottom:10px}
.barber p{color:var(--muted);margin:0 0 20px}

/* Reviews */
.reviews{background:var(--bg2);border-top:1px solid var(--line);border-bottom:1px solid var(--line)}
.quotes{display:grid;grid-template-columns:1.3fr 1fr 1fr;gap:0}
.quote{padding:0 32px;border-left:1px solid var(--line)}
.quote:first-child{padding-left:0;border-left:0}
.quote p{margin:0 0 22px;font-size:19px;line-height:1.5}
.quote:first-child p{font-family:var(--display);font-weight:800;font-variation-settings:"wdth" 70;text-transform:uppercase;font-size:clamp(30px,3.6vw,46px);line-height:1.02}
.quote cite{font-style:normal;color:var(--muted);font-size:15px}
.quote cite b{color:var(--ink);display:block}

/* FAQ */
.faq .wrap{display:grid;grid-template-columns:.8fr 1.2fr;gap:64px}
details{border-top:1px solid var(--line)}
details:last-child{border-bottom:1px solid var(--line)}
summary{list-style:none;display:flex;justify-content:space-between;gap:20px;align-items:center;padding:22px 0;font-weight:600;font-size:19px}
summary::-webkit-details-marker{display:none}
summary::after{content:"+";font-size:28px;line-height:1;color:var(--accent-text);transition:transform .2s}
details[open] summary::after{transform:rotate(45deg)}
details p{margin:0 0 24px;color:var(--muted);max-width:36em}

/* Visit */
.visit{background:var(--bg2);border-top:1px solid var(--line)}
.visit .wrap{display:grid;grid-template-columns:1fr 1fr;gap:72px}
address{font-style:normal;font-size:22px;line-height:1.45;margin-bottom:16px}
.walk{color:var(--muted);margin:0 0 26px}
.hours{list-style:none;padding:0;margin:0}
.hours li{display:flex;justify-content:space-between;padding:14px 0;border-bottom:1px solid var(--line)}
.hours li.today{font-weight:700;border-bottom:2px solid var(--accent)}
.hours .shut{color:var(--muted)}

footer{padding:64px 0 28px;overflow:hidden}
footer .grid2{display:grid;grid-template-columns:1.3fr 1fr 1fr;gap:40px;margin-bottom:48px}
footer h4{margin:0 0 10px;font-size:15px;color:var(--muted);font-weight:600}
footer a{display:block;text-decoration:none;padding:3px 0}
footer a:hover{text-decoration:underline}
.mark{font-size:clamp(50px,20vw,200px);line-height:.8;color:var(--accent);white-space:nowrap;margin:0 0 20px -.02em}
.copy{color:var(--muted);font-size:14px}

@media (max-width:960px){
  .wrap{padding:0 20px}
  section{padding:68px 0}
  .menu-btn{display:block}
  nav.links{display:none;position:absolute;top:100%;left:0;right:0;flex-direction:column;align-items:stretch;gap:0;background:var(--bg);border-bottom:1px solid var(--line);padding:8px 20px 20px}
  nav.links.open{display:flex}
  nav.links a{padding:14px 0;font-size:18px;border-bottom:1px solid var(--line)}
  nav.links a.btn{margin-top:14px;border:0;font-size:17px}
  .fade{width:100%;opacity:.5}
  .story .wrap,.book .wrap,.faq .wrap,.visit .wrap{grid-template-columns:1fr;gap:40px}
  .grid{grid-template-columns:1fr 1fr}
  .crew{grid-template-columns:1fr;gap:36px}
  .barber{border:0;margin:0;padding:0 0 36px;border-bottom:1px solid var(--line)}
  .quotes{grid-template-columns:1fr;gap:36px}
  .quote{padding:0;border:0}
  .plate{aspect-ratio:4/3}
  footer .grid2{grid-template-columns:1fr 1fr}
  .strip .phone{margin-left:0}
}
@media (max-width:560px){
  .grid{grid-template-columns:1fr}
  .fields{grid-template-columns:1fr}
  .card{padding:20px}
  footer .grid2{grid-template-columns:1fr}
}
</style>
