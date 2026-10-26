(()=>{
const $=s=>document.querySelector(s), clamp=(v,a=0,b=1)=>Math.min(b,Math.max(a,v));
const ease=t=>t<.5?4*t*t*t:1-Math.pow(-2*t+2,3)/2;      // smooth in-out
const J=$('.journey'),ship=$('.ship'),earth=$('.earth'),stars=$('#stars'),copy=$('.hero-copy'),
 logo=$('#logo'),about=$('.about'),words=[...document.querySelectorAll('.about .w')],hint=$('.scroll-hint');
const HOLE=.085, CX=.009, CY=-.003, BASE=1.25;   // circle geometry inside spaceship image
let mx=0,my=0,cur=0,tx=0,tw=0,cb=null,hb=null;
// --- starfield (behind the earth, visible through the porthole) ---
function drawStars(){
  const d=Math.min(devicePixelRatio||1,2), w=innerWidth, h=innerHeight;
  stars.width=w*d; stars.height=h*d;
  const g=stars.getContext('2d'); g.scale(d,d);
  let s=7; const rnd=()=>(s=(s*16807)%2147483647)/2147483647;   // fixed seed = same sky every load
  const n=Math.round(w*h/5200);
  for(let i=0;i<n;i++){
    const x=rnd()*w, y=rnd()*h, big=rnd()>.93, r=big?.6+rnd()*.9:.25+rnd()*.5, a=big?.8+rnd()*.2:.35+rnd()*.55;
    const t=rnd(); g.fillStyle=t<.15?`rgba(190,215,255,${a})`:t>.88?`rgba(255,228,200,${a})`:`rgba(255,255,255,${a})`;
    g.beginPath(); g.arc(x,y,r,0,6.2832); g.fill();
  }
}
drawStars();
const base=el=>({x:el.offsetLeft+el.offsetWidth/2,y:el.offsetTop+el.offsetHeight/2});
addEventListener('mousemove',e=>{mx=e.clientX/innerWidth-.5;my=e.clientY/innerHeight-.5});
const target=()=>clamp(-J.getBoundingClientRect().top/(J.offsetHeight-innerHeight));
cur=target();
function frame(){
  tx=target(); cur+=(tx-cur)*.09; if(Math.abs(tx-cur)<.0002)cur=tx;   // smooth scroll damping
  const p=cur, vw=innerWidth, vh=innerHeight;
  const W=Math.max(vw,vh*1.503), H=W/1.503;
  const cx=vw/2+CX*W, cy=vh/2+CY*H;                                    // circle centre on screen
  const R0=HOLE*W*BASE, far=Math.hypot(Math.max(cx,vw-cx),Math.max(cy,vh-cy));
  const S=far/R0*1.12;                                                 // scale so the circle covers the screen
  // 1) camera flies through the circle
  const z=ease(clamp(p/.42));
  const scale=BASE+(S*BASE-BASE)*z*z;
  const tilt=1-clamp(p/.08);
  ship.style.transform=`rotateY(${mx*5*tilt}deg) rotateX(${-my*3*tilt}deg) scale(${scale})`;
  ship.style.opacity=1-clamp((p-.36)/.1);
  // 2) earth rises up inside the circle and fills the screen
  const e=ease(clamp(p/.5));
  earth.style.transform=`translate3d(0,${(1-e)*46}%,0) scale(${1+e*.12+p*.2})`;
  // 3) hero copy rides the zoom: it is carried outwards (left) with the circle frame, no fade
  if(!cb){copy.style.transform=hint.style.transform='none';cb=base(copy);hb=base(hint)}
  const k=(scale/BASE)-1;
  copy.style.transform=`translate3d(${k*(cb.x-cx)}px,${k*(cb.y-cy)*.12}px,0)`;
  hint.style.transform=`translate3d(${k*(hb.x-cx)}px,${k*(hb.y-cy)*.12}px,0)`;
  stars.style.transform=`scale(${1+p*.3})`;
  // 4) ONE logo: circle centre -> top-left
  if(!tw)tw=logo.offsetWidth;
  const m=ease(clamp((p-.1)/.3)), end=.42;
  const sx=1+(end-1)*m, w=tw*sx, hgt=logo.offsetHeight*sx;
  const x0=cx-tw/2, y0=cy-logo.offsetHeight/2, x1=vw*.05, y1=22;
  logo.style.transform=`translate3d(${x0+(x1-x0)*m}px,${y0+(y1-y0)*m}px,0) scale(${sx})`;
  // 5) about text: word-by-word reveal
  const a=clamp((p-.5)/.2), fade=clamp((p-.46)/.05)*(1-clamp((p-.72)/.06));
  about.style.opacity=fade; about.style.transform=`translate3d(0,${(1-clamp((p-.46)/.12))*40}px,0)`;
  words.forEach((w,i)=>{w.style.opacity=.22+.78*clamp(a*words.length-i)});
  requestAnimationFrame(frame);
}
addEventListener('resize',()=>{tw=0;cb=null;drawStars()});
document.fonts&&document.fonts.ready.then(()=>{tw=0;cb=null});
frame();
const f=$('#lead'),msg=$('#msg'),cnt=$('#svc-count'),btn=f.querySelector('.btn');
$('#wa').href=`https://wa.me/${WX.wa}?text=${encodeURIComponent('Hi Webnix Studio, I want to discuss a project.')}`;
const picked=()=>[...f.querySelectorAll('input[name="services[]"]:checked')];
f.addEventListener('change',()=>{const n=picked().length;cnt.textContent=n?`${n} selected`:'Pick one or more';cnt.classList.toggle('on',n>0);$('#svc').classList.remove('err')});
f.addEventListener('submit',async e=>{
  e.preventDefault(); msg.style.color='';
  f.querySelectorAll('.err').forEach(x=>x.classList.remove('err'));
  const bad=[...f.querySelectorAll('[required]')].filter(i=>!i.value.trim()||(i.type==='email'&&!i.checkValidity()));
  bad.forEach(i=>i.classList.add('err'));
  if(bad.length||!picked().length){
    if(!picked().length)$('#svc').classList.add('err');
    msg.textContent=bad.length?'Please fill the highlighted fields.':'Please pick at least one service.';msg.style.color='#ffb4b4';
    (bad[0]||$('#svc')).scrollIntoView({block:'center',behavior:'smooth'});return;
  }
  msg.textContent='Sending...';btn.disabled=true;
  try{
    const r=await fetch(WX.api,{method:'POST',body:new FormData(f)}), j=await r.json();
    msg.textContent=j.message; msg.style.color=j.ok?'#7ff0c8':'#ffb4b4';
    if(j.ok){f.reset();cnt.textContent='Pick one or more';cnt.classList.remove('on')}
  }catch(_){msg.textContent='Network error, try again.';msg.style.color='#ffb4b4'}
  btn.disabled=false;
});
})();
