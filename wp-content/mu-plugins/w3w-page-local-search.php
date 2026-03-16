<?php
/**
 * Plugin Name: W3W - Pesquisa Local Discursos (Worker / Sem Bloqueio)
 * Version: 2.2.1
 * Author: Marcolino Melo - MKTL
 */

if (!defined('ABSPATH')) exit;

function w3w_dls_is_target_page(): bool {
    $uri = strtok($_SERVER['REQUEST_URI'] ?? '', '?');
    return (stripos($uri, '/presidente/intervencoes-e-discursos') !== false)
        || (function_exists('is_page') && is_page('intervencoes-e-discursos'));
}

add_action('wp_enqueue_scripts', function () {
    if (is_admin() || !w3w_dls_is_target_page()) return;

    $css = <<<CSS
#w3wDlsBar{
    margin:0 0 12px 0;
    background:rgba(255,255,255,.85)
}

#w3wDlsBar .w3w-row{
    display:flex;
    gap:10px;
    align-items:center
}

#w3wDlsInput{
    flex:1;
    padding:10px 12px;
    border:1px solid rgba(0,0,0,.18);
    outline:none
}

#w3wDlsClear{
    color:#FFFFFF;
    border:1px solid rgba(0,0,0,.18);
    background:#236093;
    cursor:pointer;
    white-space:nowrap
}

#w3wDlsMeta{
    margin-top:8px;
    font-size:13px;
    opacity:.8
}

.w3w-dls-list{
    display:grid;
    gap:12px;
    margin-top:0
}

.w3w-dls-card{
    padding:14px 14px 12px;
    border:1px solid rgba(0,0,0,.10);
    background:#f1f2f3
}

.w3w-dls-date{
    font-weight:700;
    margin:0 0 6px 0
}

.w3w-dls-title{
    margin:0 0 10px 0
}

.w3w-dls-link a{
    display:inline-block;
    color:#FFFFFF !important;
    background-color: transparent;
    background-image: linear-gradient(90deg, #4A7FC2 50%, #236093 100%);
    padding:8px 20px;
    text-decoration:none !important
}

.w3w-dls-link a:hover{
    background-image: linear-gradient(90deg, #236093 50%, #4A8FC2 100%);
}

.w3w-dls-desc{
  
}

.w3w-tag{
    display:inline-block;
    background:#e6eef6;
    color:#1f4e79;
    padding:4px 10px;
    border-radius:20px;
    font-size:12px;
    margin-right:6px;
    margin-bottom:4px;
    font-weight:600;
}

.w3w-dls-link a:hover{
    background:#4A8FC2;
}

.w3w-dls-hidden{
    display:none !important
}

.w3w-dls-original-hidden{
    display:none !important
}

.w3w-dls-note{
    font-size:13px;
    opacity:.75;
    margin-top:8px
}
CSS;

    wp_register_style('w3w-dls', false);
    wp_enqueue_style('w3w-dls');
    wp_add_inline_style('w3w-dls', $css);

    $js = <<<'JS'
(function(){
  // ---------------- utils ----------------
  function norm(s){
    return (s||'').toString().toLowerCase()
      .normalize('NFD').replace(/[\u0300-\u036f]/g,'');
  }

  function debounce(fn, wait){
    var t;
    return function(){
      var ctx = this, args = arguments;
      clearTimeout(t);
      t = setTimeout(function(){ fn.apply(ctx, args); }, wait);
    };
  }

  function setMeta(txt){
    var el = document.getElementById('w3wDlsMeta');
    if(el) el.textContent = txt;
  }

  function setNote(txt){
    var el = document.getElementById('w3wDlsNote');
    if(!el) return;

    if(!txt){
      el.style.display = 'none';
      el.textContent = '';
    } else {
      el.style.display = 'block';
      el.textContent = txt;
    }
  }

  function getActivePanel(){
    return document.querySelector('.e-n-tabs-content > [role="tabpanel"].e-active')
        || document.querySelector('.e-n-tabs-content > [role="tabpanel"][style*="display: block"]')
        || document.querySelector('.e-n-tabs-content > [role="tabpanel"]:not([hidden])')
        || document.querySelector('.e-n-tabs-content > [role="tabpanel"]')
        || null;
  }

  function getActiveTabLabel(){
    var t = document.querySelector('.e-n-tabs-heading .e-n-tab-title[aria-selected="true"] .e-n-tab-title-text');
    return t ? (t.innerText || '').trim().toLowerCase() : '';
  }

  function isArchive(){
    // Ativa esta lógica se quiseres que tabs "arquivo" usem sempre worker pesado
    // return getActiveTabLabel().includes('arquivo');
    return false;
  }

  function ensureBar(panel){
    var bar = document.getElementById('w3wDlsBar');

    if(!bar){
      bar = document.createElement('div');
      bar.id = 'w3wDlsBar';
      bar.innerHTML =
        '<div class="w3w-row">' +
          '<input id="w3wDlsInput" type="search" placeholder="Pesquisar intervenções nesta tab..." autocomplete="off" />' +
          '<button id="w3wDlsClear" type="button">Limpar</button>' +
        '</div>' +
        '<div id="w3wDlsMeta">—</div>' +
        '<div id="w3wDlsNote" class="w3w-dls-note" style="display:none;"></div>';
    }

    if(!panel) return bar;

    // Se a barra já estiver dentro do painel ativo, não mexe no DOM
    if(panel.contains(bar)) return bar;

    var list = panel.querySelector('.w3w-dls-list');
    var te = panel.querySelector('.elementor-widget-text-editor');
    var firstChild = panel.firstElementChild;

    if(list && list.parentNode){
      list.parentNode.insertBefore(bar, list);
    } else if(te && te.parentNode){
      te.parentNode.insertBefore(bar, te);
    } else if(firstChild){
      panel.insertBefore(bar, firstChild);
    } else {
      panel.appendChild(bar);
    }

    return bar;
  }

  function ensureList(panel){
    var list = panel.querySelector('.w3w-dls-list');
    if(list) return list;

    list = document.createElement('div');
    list.className = 'w3w-dls-list';

    var te = panel.querySelector('.elementor-widget-text-editor');
    if(te){
      te.classList.add('w3w-dls-original-hidden');
      te.insertAdjacentElement('afterend', list);
    } else {
      panel.appendChild(list);
    }

    return list;
  }

  function makeCard(e){
    var card = document.createElement('div');
    card.className = 'w3w-dls-card';
    card.setAttribute('data-w3w-hay', e.hay || '');

    var date = document.createElement('div');
    date.className = 'w3w-dls-date';
    date.textContent = e.date || '';
    if(!e.date) date.style.display = 'none';

    var title = document.createElement('div');
    title.className = 'w3w-dls-title';
    title.textContent = e.title || '';
    if(!e.title) title.style.display = 'none';

    var desc = document.createElement('div');
    desc.className = 'w3w-dls-desc';

    var tags = (e.desc || '').split(',');
    desc.innerHTML = tags.map(function(t){
      t = t.trim();
      if(!t) return '';
      return '<span class="w3w-tag">'+t+'</span>';
    }).join('');

    var link = document.createElement('div');
    link.className = 'w3w-dls-link';

    if(e.href){
      var a = document.createElement('a');
      a.href = e.href;
      a.target = '_blank';
      a.rel = 'noopener';
      a.textContent = e.linkText || 'Discurso Completo';
      link.appendChild(a);
    } else {
      link.style.display = 'none';
    }

    card.appendChild(date);
    card.appendChild(title);
    card.appendChild(desc);
    card.appendChild(link);

    return card;
  }

  // ---------------- Worker (off-main-thread) ----------------
  function makeWorker(){
    var code = `
      function norm(s){
        return (s||'').toString().toLowerCase()
          .normalize('NFD').replace(/[\\u0300-\\u036f]/g,'');
      }

      function stripTags(s){
        return (s||'')
          .replace(/<br\\s*\\/?\\s*>/gi,' ')
          .replace(/&nbsp;/gi,' ')
          .replace(/&amp;/gi,'&')
          .replace(/&quot;/gi,'"')
          .replace(/&#039;/gi,"'")
          .replace(/&lt;/gi,'<')
          .replace(/&gt;/gi,'>')
          .replace(/<[^>]+>/g,'')
          .replace(/\\s+/g,' ')
          .trim();
      }

      var dateRe = /\\b\\d{1,2}\\s+de\\s+(janeiro|fevereiro|março|abril|maio|junho|julho|agosto|setembro|outubro|novembro|dezembro)\\s+de\\s+\\d{4}\\b/i;

      function findLink(pInner){
        var m = (pInner||'').match(/<a\\s+[^>]*href=["']([^"']+)["'][^>]*>([\\s\\S]*?)<\\/a>/i);
        if(!m) return null;
        var txt = stripTags(m[2]) || 'Discurso Completo';
        return { href: m[1], text: txt };
      }

      function isDateLine(pInner){
        var sm = (pInner.match(/<strong[^>]*>([\\s\\S]*?)<\\/strong>/i) || [])[1];
        var st = stripTags(sm || '');
        if(st && dateRe.test(st)) return st;

        var t = stripTags(pInner || '');
        if(t && dateRe.test(t)) return t;

        return '';
      }

      self.onmessage = function(ev){
        var msg = ev.data || {};
        if(msg.type !== 'START') return;

        var html = msg.html || '';
        var parts = html.split(/<p[^>]*>/i);

        var i = 0;
        var cur = null;
        var out = [];
        var BATCH = msg.batch || 120;

        function flush(){
          if(out.length){
            self.postMessage({type:'BATCH', items: out});
            out = [];
          }
        }

        function step(){
          var start = Date.now();

          while(i < parts.length){
            var chunk = parts[i++];
            var pInner = chunk.split(/<\\/p>/i)[0] || '';
            if(!pInner) continue;

            var d = isDateLine(pInner);
            if(d){
              if(cur){
                if((cur.title || cur.desc || cur.href)){
                  cur.hay = norm([cur.date, cur.title, cur.desc, cur.linkText].join(' | '));
                  out.push(cur);
                }
                if(out.length >= BATCH) flush();
              }
              cur = {date:d, title:'', desc:'', href:'', linkText:''};
              continue;
            }

            if(!cur) continue;

            var link = findLink(pInner);
            if(link){
              var lt = norm(link.text);
              if(lt.includes('discurso') || lt.includes('pdf')){
                cur.href = link.href;
                cur.linkText = link.text;
                continue;
              }
            }

            var txt = stripTags(pInner);
            if(!txt) continue;

            if(!cur.title) cur.title = txt;
            else cur.desc += (cur.desc ? ' ' : '') + txt;

            if(Date.now() - start > 25) break;
          }

          if(i < parts.length){
            setTimeout(step, 0);
          } else {
            if(cur && (cur.title || cur.desc || cur.href)){
              cur.hay = norm([cur.date, cur.title, cur.desc, cur.linkText].join(' | '));
              out.push(cur);
            }
            flush();
            self.postMessage({type:'DONE'});
          }
        }

        step();
      };
    `;

    var blob = new Blob([code], {type:'application/javascript'});
    var url = URL.createObjectURL(blob);
    return new Worker(url);
  }

  // Estado por painel
  var state = new WeakMap();

  function stopWorkerIfAny(st){
    try {
      if(st && st.worker){
        st.worker.terminate();
        st.worker = null;
      }
    } catch(e){}
  }

  function startConvert(panel){
    if(!panel) return;

    var st = state.get(panel);
    if(st && (st.converting || st.converted)) return;

    var te = panel.querySelector('.elementor-widget-text-editor');
    if(!te){
      state.set(panel, {
        converted:true,
        converting:false,
        total:0,
        worker:null,
        queue:[],
        rendering:false,
        done:false
      });
      return;
    }

    var list = ensureList(panel);
    ensureBar(panel);
    list.innerHTML = '';

    st = {
      converted:false,
      converting:true,
      total:0,
      worker:null,
      queue:[],
      rendering:false,
      done:false
    };
    state.set(panel, st);

    var html = te.innerHTML || '';

    if(isArchive()){
      setNote('A preparar Arquivo histórico…');

      st.worker = makeWorker();

      function pumpRender(){
        if(st.rendering) return;
        st.rendering = true;

        (function step(){
          var start = performance.now();
          var frag = document.createDocumentFragment();
          var n = 0;

          while(st.queue.length && n < 25 && (performance.now() - start) < 10){
            frag.appendChild(makeCard(st.queue.shift()));
            st.total++;
            n++;
          }

          if(n) list.appendChild(frag);

          if(n){
            setMeta(st.total + ' Intervenções/Discursos' + (st.converting ? ' (a carregar…)' : ''));
          }

          if(st.queue.length){
            requestAnimationFrame(step);
          } else {
            st.rendering = false;
            if(st.done){
              st.converting = false;
              st.converted = true;
              setNote('');
              setMeta(st.total + ' Intervenções/Discursos');
              stopWorkerIfAny(st);
            }
          }
        })();
      }

      st.worker.onmessage = function(ev){
        var m = ev.data || {};

        if(m.type === 'BATCH'){
          for(var i=0; i<m.items.length; i++){
            st.queue.push(m.items[i]);
          }
          pumpRender();
        }

        if(m.type === 'DONE'){
          st.done = true;
          pumpRender();
        }
      };

      st.worker.postMessage({type:'START', html: html, batch: 120});
    } else {
      var parts = html.split(/<p[^>]*>/i);
      var cur = null;
      var dateRe = /\b\d{1,2}\s+de\s+(janeiro|fevereiro|março|abril|maio|junho|julho|agosto|setembro|outubro|novembro|dezembro)\s+de\s+\d{4}\b/i;

      function stripTags(s){
        return (s || '').replace(/<[^>]+>/g,'').replace(/&nbsp;/g,' ').replace(/\s+/g,' ').trim();
      }

      function dateFrom(pInner){
        var sm = (pInner.match(/<strong[^>]*>([\s\S]*?)<\/strong>/i) || [])[1];
        var stt = stripTags(sm || '');
        if(stt && dateRe.test(stt)) return stt;

        var t = stripTags(pInner || '');
        if(t && dateRe.test(t)) return t;

        return '';
      }

      function linkFrom(pInner){
        var m = (pInner || '').match(/<a\s+[^>]*href=["']([^"']+)["'][^>]*>([\s\S]*?)<\/a>/i);
        if(!m) return null;
        return {href:m[1], text: stripTags(m[2]) || 'Discurso Completo'};
      }

      var frag = document.createDocumentFragment();

      for(var k=0; k<parts.length; k++){
        var pInner = (parts[k].split(/<\/p>/i)[0] || '');
        if(!pInner) continue;

        var d = dateFrom(pInner);
        if(d){
          if(cur){
            cur.hay = norm([cur.date, cur.title, cur.desc, cur.linkText].join(' | '));
            frag.appendChild(makeCard(cur));
            st.total++;
          }
          cur = {date:d, title:'', desc:'', href:'', linkText:''};
          continue;
        }

        if(!cur) continue;

        var link = linkFrom(pInner);
        if(link && (norm(link.text).includes('discurso') || norm(link.text).includes('pdf'))){
          cur.href = link.href;
          cur.linkText = link.text;
          continue;
        }

        var txt = stripTags(pInner);
        if(!txt) continue;

        if(!cur.title) cur.title = txt;
        else cur.desc += (cur.desc ? ' ' : '') + txt;
      }

      if(cur){
        cur.hay = norm([cur.date, cur.title, cur.desc, cur.linkText].join(' | '));
        frag.appendChild(makeCard(cur));
        st.total++;
      }

      list.appendChild(frag);
      st.converting = false;
      st.converted = true;
      setNote('');
      setMeta(st.total + ' Intervenções/Discursos');
    }
  }

  function applyFilter(panel, term){
    if(!panel) return;
    term = norm(term).trim();

    var list = panel.querySelector('.w3w-dls-list');
    if(!list){
      setMeta('—');
      return;
    }

    var cards = Array.prototype.slice.call(list.querySelectorAll('.w3w-dls-card'));
    var total = cards.length;
    var visible = 0;

    if(!term){
      cards.forEach(function(c){
        c.classList.remove('w3w-dls-hidden');
      });
      setMeta(total + ' Intervenções/Discursos');
      return;
    }

    cards.forEach(function(c){
      var hay = c.getAttribute('data-w3w-hay') || '';
      var ok = hay.indexOf(term) !== -1;

      if(ok){
        c.classList.remove('w3w-dls-hidden');
        visible++;
      } else {
        c.classList.add('w3w-dls-hidden');
      }
    });

    setMeta(visible + ' / ' + total + ' resultados (carregados)');
  }

  function refresh(options){
    options = options || {};

    var panel = getActivePanel();
    if(!panel) return;

    var input = document.getElementById('w3wDlsInput');
    var hadFocus = document.activeElement === input;
    var selStart = hadFocus && typeof input.selectionStart === 'number' ? input.selectionStart : null;
    var selEnd = hadFocus && typeof input.selectionEnd === 'number' ? input.selectionEnd : null;
    var currentValue = input ? input.value : '';

    if(!options.skipBar){
      ensureBar(panel);
    }

    startConvert(panel);

    input = document.getElementById('w3wDlsInput');
    if(input){
      input.value = currentValue;
    }

    applyFilter(panel, input ? input.value : '');

    if(hadFocus && input){
      input.focus({ preventScroll: true });

      if(selStart !== null && selEnd !== null){
        try {
          input.setSelectionRange(selStart, selEnd);
        } catch(e){}
      }
    }
  }

  document.addEventListener('DOMContentLoaded', function(){
    ensureBar(getActivePanel());

    var delegatedInputHandler = debounce(function(){
      refresh({ skipBar: true });
    }, 180);

    document.addEventListener('input', function(e){
      if(e.target && e.target.id === 'w3wDlsInput'){
        delegatedInputHandler();
      }
    });

    document.addEventListener('click', function(e){
      if(e.target && e.target.id === 'w3wDlsClear'){
        var input = document.getElementById('w3wDlsInput');
        if(input){
          input.value = '';
          input.focus({ preventScroll: true });
          try {
            input.setSelectionRange(0, 0);
          } catch(err){}
        }
        refresh({ skipBar: true });
        return;
      }

      var btn = e.target.closest('.e-n-tab-title[role="tab"]');
      if(btn){
        setTimeout(function(){
          refresh();
          var input = document.getElementById('w3wDlsInput');
          if(input){
            input.focus({ preventScroll: true });
          }
        }, 80);
      }
    });

    refresh();
  });
})();
JS;

    wp_register_script('w3w-dls', false, [], null, true);
    wp_enqueue_script('w3w-dls');
    wp_add_inline_script('w3w-dls', $js);
}, 20);