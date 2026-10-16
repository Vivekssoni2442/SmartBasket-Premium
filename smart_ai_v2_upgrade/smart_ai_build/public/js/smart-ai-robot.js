(function(){
'use strict';
if(window.__SMART_BASKET_AI_V2__) return;
window.__SMART_BASKET_AI_V2__=true;

document.addEventListener('DOMContentLoaded',function(){
  const root=document.querySelector('[data-smart-ai]');
  if(!root) return;
  const panel=root.querySelector('[data-smart-ai-panel]');
  const openBtn=root.querySelector('[data-smart-ai-open]');
  const closeBtn=root.querySelector('[data-smart-ai-close]');
  const minBtn=root.querySelector('[data-smart-ai-minimize]');
  const form=root.querySelector('[data-smart-ai-form]');
  const input=root.querySelector('[data-smart-ai-input]');
  const chat=root.querySelector('[data-smart-ai-chat]');
  const stage=root.querySelector('[data-smart-ai-stage]');
  const thought=root.querySelector('[data-smart-ai-thought]');
  const badge=root.querySelector('[data-smart-ai-action-badge]');
  const status=root.querySelector('[data-smart-ai-status]');
  const mic=root.querySelector('[data-smart-ai-mic]');
  const modeBtns=[...root.querySelectorAll('[data-ai-mode]')];
  const language=root.querySelector('[data-ai-language]');
  const voiceSelect=root.querySelector('[data-ai-voice]');
  const autoSpeak=root.querySelector('[data-ai-autospeak]');
  const liveBar=root.querySelector('[data-ai-live-bar]');
  const liveText=root.querySelector('[data-ai-live-text]');
  const stopLive=root.querySelector('[data-ai-stop-live]');

  const endpoint=root.dataset.endpoint;
  let mode='type', listening=false, speaking=false, autoSpeakOn=true, recognition=null, voices=[];
  let history=[];
  let actionTimer=null;

  const ACTIONS={
    dance:{label:'Dancing 💃',expr:'dance',reply:'Of course! I am dancing for you 💃'},
    cry:{label:'Crying 😢',expr:'cry',reply:'Okay… I am crying 😢'},
    laugh:{label:'Laughing 😂',expr:'laugh',reply:'Haha! 😂 I am laughing!'},
    wave:{label:'Waving 👋',expr:'wave',reply:'Hi! 👋 I am waving to you.'},
    jump:{label:'Jumping 🦘',expr:'jump',reply:'Watch me jump! 🦘'},
    happy:{label:'Happy 😊',expr:'happy',reply:'Yay! I am happy 😊'},
    angry:{label:'Angry 😠',expr:'angry',reply:'Okay, I will look angry for a moment 😠'},
    sleep:{label:'Sleeping 😴',expr:'sleep',reply:'Shhh… I am sleeping 😴'},
    think:{label:'Thinking 🤔',expr:'think',reply:'Hmm… let me think 🤔'},
    normal:{label:'Normal',expr:'normal',reply:''}
  };

  function setOpen(open){
    if(open){panel.hidden=false;document.body.classList.add('smart-ai-open');setExpression('normal');thought.textContent='How can I help you?';if(autoSpeakOn) speak('Hi! I am Smart AI. How can I help you?');}
    else{panel.hidden=true;stopRecognition();speechSynthesis.cancel();}
  }
  function setMode(next){
    mode=next;modeBtns.forEach(b=>b.classList.toggle('is-active',b.dataset.aiMode===next));
    if(next==='live'){liveBar.hidden=false;startRecognition(true);} else {liveBar.hidden=true;stopRecognition();input.focus();}
  }
  function setExpression(expr,duration){
    stage.dataset.expression=expr||'normal';
    const a=ACTIONS[expr]||ACTIONS.normal;
    if(a.label && expr!=='normal'){badge.hidden=false;badge.textContent=a.label;thought.textContent=a.reply||a.label;} else {badge.hidden=true;thought.textContent='How can I help you?';}
    if(actionTimer) clearTimeout(actionTimer);
    if(duration){actionTimer=setTimeout(()=>{stage.dataset.expression='normal';badge.hidden=true;thought.textContent='How can I help you?';},duration);}
  }
  function localAction(text){
    const s=text.toLowerCase().trim();
    const tests=[
      ['dance',/\b(dance|dancing|नाच|नाचो|नृत्य)\b/],
      ['cry',/\b(cry|crying|रो|रोओ|रोना)\b/],
      ['laugh',/\b(laugh|laughing|हंस|हंसो|हंसना)\b/],
      ['wave',/\b(wave|waving|हाथ हिला|हाथ हिलाओ)\b/],
      ['jump',/\b(jump|jumping|कूद|कूदो)\b/],
      ['happy',/\b(be happy|happy|खुश|खुश हो)\b/],
      ['angry',/\b(angry|गुस्सा|गुस्से में)\b/],
      ['sleep',/\b(sleep|sleeping|सो|सो जाओ|सोना)\b/],
      ['think',/\b(think|thinking|सोच|सोचो)\b/]
    ];
    for(const [name,re] of tests) if(re.test(s)) return name;
    return null;
  }
  function appAction(text){
    const s=text.toLowerCase();
    if(/\b(open|go to|show|kholo|खोलो|जाओ)\b/.test(s)){
      if(/cart|कार्ट/.test(s)) return root.dataset.cartUrl;
      if(/order|orders|ऑर्डर/.test(s)) return root.dataset.ordersUrl;
      if(/profile|प्रोफाइल/.test(s)) return root.dataset.profileUrl;
      if(/setting|सेटिंग/.test(s)) return root.dataset.settingsUrl;
      if(/product|products|प्रोडक्ट/.test(s)) return root.dataset.productsUrl;
    }
    return null;
  }
  function escapeHtml(s){return String(s).replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[c]));}
  function addMessage(text,who,sources){
    const empty=chat.querySelector('.smart-ai__empty'); if(empty) empty.remove();
    const wrap=document.createElement('div');wrap.className='smart-ai__message '+who;
    let html='<div class="smart-ai__bubble">'+escapeHtml(text)+'</div>';
    if(sources&&sources.length){html+='<div class="smart-ai__sources">'+sources.map((x,i)=>'<a href="'+escapeHtml(x.uri)+'" target="_blank" rel="noopener">['+(i+1)+'] '+escapeHtml(x.title||x.uri)+'</a>').join('')+'</div>';}
    wrap.innerHTML=html;chat.appendChild(wrap);chat.scrollTop=chat.scrollHeight;
  }
  function setStatus(text){if(status) status.textContent=text;}
  function speak(text){
    if(!('speechSynthesis' in window)||!text) return;
    speechSynthesis.cancel();const u=new SpeechSynthesisUtterance(text);
    const lang=language.value==='auto'?guessLang(text):language.value;u.lang=lang;
    const chosen=voiceSelect.value!=='auto'?voices.find(v=>v.name===voiceSelect.value):pickVoice(lang);if(chosen) u.voice=chosen;
    u.rate=.98;u.pitch=1.02;speaking=true;u.onend=()=>{speaking=false;};speechSynthesis.speak(u);
  }
  function guessLang(text){if(/[\u0900-\u097F]/.test(text))return'hi-IN';if(/[\u0A80-\u0AFF]/.test(text))return'gu-IN';return'en-IN';}
  function pickVoice(lang){return voices.find(v=>v.lang===lang)||voices.find(v=>v.lang&&v.lang.startsWith(lang.split('-')[0]))||voices[0];}
  function loadVoices(){if(!('speechSynthesis'in window))return;voices=speechSynthesis.getVoices()||[];const old=voiceSelect.value;voiceSelect.innerHTML='<option value="auto">Auto voice</option>';voices.forEach(v=>{const o=document.createElement('option');o.value=v.name;o.textContent=v.name+' — '+v.lang;voiceSelect.appendChild(o);});if([...voiceSelect.options].some(o=>o.value===old))voiceSelect.value=old;}
  if('speechSynthesis'in window){loadVoices();speechSynthesis.onvoiceschanged=loadVoices;}

  function startRecognition(autoLive){
    const SR=window.SpeechRecognition||window.webkitSpeechRecognition;
    if(!SR){setStatus('Browser voice recognition is not available');return;}
    if(listening)return;
    recognition=new SR();recognition.continuous=!!autoLive;recognition.interimResults=true;recognition.lang=language.value==='auto'?'hi-IN':language.value;
    recognition.onstart=()=>{listening=true;mic.classList.add('is-listening');setStatus('Listening…');if(liveText)liveText.textContent='Speak now';};
    recognition.onresult=e=>{let finalText='';let interim='';for(let i=e.resultIndex;i<e.results.length;i++){const t=e.results[i][0].transcript;if(e.results[i].isFinal)finalText+=t;else interim+=t;}if(liveText)liveText.textContent=interim||finalText||'Listening…';if(finalText){input.value=finalText;send(finalText);}};
    recognition.onerror=e=>{setStatus('Voice error: '+e.error);listening=false;mic.classList.remove('is-listening');};
    recognition.onend=()=>{listening=false;mic.classList.remove('is-listening');if(mode==='live'&&autoLive&&!panel.hidden){setTimeout(()=>startRecognition(true),300);}else setStatus('Ready • Google Search connected');};
    recognition.start();
  }
  function stopRecognition(){if(recognition){try{recognition.stop();}catch(e){}recognition=null;}listening=false;mic.classList.remove('is-listening');}

  async function send(text){
    text=(text||'').trim();if(!text)return;
    addMessage(text,'user');input.value='';setStatus('Working…');
    const local=localAction(text);
    if(local){const a=ACTIONS[local];setExpression(local,local==='sleep'?4500:2800);addMessage(a.reply,'assistant');if(autoSpeakOn)speak(a.reply);setStatus('Ready • action complete');return;}
    const url=appAction(text);if(url){setExpression('wave',1000);addMessage('Opening that for you…','assistant');if(autoSpeakOn)speak('Opening that for you.');setTimeout(()=>location.href=url,350);return;}
    const typing=document.createElement('div');typing.className='smart-ai__message assistant';typing.innerHTML='<div class="smart-ai__bubble smart-ai__typing">Thinking and checking the web…</div>';chat.appendChild(typing);chat.scrollTop=chat.scrollHeight;
    try{
      const res=await fetch(endpoint,{method:'POST',headers:{'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':root.dataset.csrf},body:JSON.stringify({message:text,language:language.value,history:history.slice(-12)})});
      const data=await res.json();typing.remove();
      if(!res.ok)throw new Error(data.message||'AI request failed');
      const answer=data.answer||'I could not generate a response right now.';history.push({role:'user',text},{role:'assistant',text:answer});addMessage(answer,'assistant',data.sources||[]);setExpression('think',900);thought.textContent='I found an answer for you.';if(autoSpeakOn)speak(answer);setStatus('Ready • Google Search connected');
    }catch(err){typing.remove();const msg='I could not reach Smart AI right now. Please check the AI server/API configuration.';addMessage(msg,'assistant');setStatus('Connection problem');console.error(err);}
  }

  openBtn&&openBtn.addEventListener('click',()=>setOpen(true));closeBtn&&closeBtn.addEventListener('click',()=>setOpen(false));minBtn&&minBtn.addEventListener('click',()=>setOpen(false));
  form&&form.addEventListener('submit',e=>{e.preventDefault();send(input.value);});
  mic&&mic.addEventListener('click',()=>listening?stopRecognition():startRecognition(false));
  modeBtns.forEach(b=>b.addEventListener('click',()=>setMode(b.dataset.aiMode)));
  language&&language.addEventListener('change',()=>{if(mode==='live'){stopRecognition();startRecognition(true);}});
  autoSpeak&&autoSpeak.addEventListener('click',()=>{autoSpeakOn=!autoSpeakOn;autoSpeak.classList.toggle('is-on',autoSpeakOn);if(!autoSpeakOn)speechSynthesis.cancel();});
  stopLive&&stopLive.addEventListener('click',()=>{stopRecognition();setMode('type');});
  root.querySelectorAll('[data-ai-quick]').forEach(b=>b.addEventListener('click',()=>send(b.dataset.aiQuick)));
  document.addEventListener('keydown',e=>{if(e.key==='Escape'&&!panel.hidden)setOpen(false);});

  window.SmartBasketAI={open:()=>setOpen(true),close:()=>setOpen(false),ask:send,act:setExpression,speak};
});
})();
