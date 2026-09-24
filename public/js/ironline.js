(() => {
  const BOOT = window.__BOOT__;
  const SERVICES = BOOT.services;
  const BARBERS  = BOOT.barbers;
  const HOURS    = BOOT.hours;
  const DAYNAMES = BOOT.dayNames;
  const ASSET    = BOOT.assetBase || '/';
  const $ = s => document.querySelector(s);

  const fmt = m => {
    const h = Math.floor(m / 60), mm = m % 60, ap = h >= 12 ? 'pm' : 'am';
    return (((h + 11) % 12) + 1) + (mm ? ':' + String(mm).padStart(2, '0') : '') + ' ' + ap;
  };

  $('#svcGrid').innerHTML = SERVICES.map(s => `
    <article class="svc">
      <div class="tile">
        <img src="${ASSET}images/services/${s.slug}.jpg"
             alt="${s.name}"
             loading="lazy"
             onerror="this.parentElement.classList.add('no-image')">
        <span class="tile-badge">${s.duration} min</span>
      </div>
      <div class="body">
        <h3>${s.name}</h3>
        <span class="meta">About ${s.duration} minutes</span>
        <div class="row">
          <span class="price">$${s.price}</span>
          <a class="btn ghost small" href="#book" data-svc="${s.slug}">Book</a>
        </div>
      </div>
    </article>`).join('');

  $('#crew').innerHTML = BARBERS.map(b => `
    <article class="barber">
      <div class="mono" aria-hidden="true">${b.name[0]}</div>
      <h3>${b.name}</h3>
      <div class="role">${b.role}</div>
      <p>${b.bio}</p>
      <a class="btn ghost small" href="#book" data-pick="${b.slug}">Book ${b.name}</a>
    </article>`).join('');

  const today = new Date().getDay();
  $('#hours').innerHTML = [2,3,4,5,6,0,1].map(i => {
    const h = HOURS[i];
    return `<li class="${i === today ? 'today' : ''}">
      <span>${DAYNAMES[i]}</span>
      ${h ? `<span>${fmt(h[0]*60)} to ${fmt(h[1]*60)}</span>` : '<span class="shut">Closed</span>'}
    </li>`;
  }).join('');

  const mq = SERVICES.map(s => `<span>${s.name}</span>`).join('');
  $('#marquee').innerHTML = mq + mq + mq + mq;

  $('#menuBtn').onclick = () => {
    const n = $('#nav'), o = n.classList.toggle('open');
    $('#menuBtn').setAttribute('aria-expanded', o);
  };
  $('#nav').addEventListener('click', e => {
    if (e.target.closest('a')) {
      $('#nav').classList.remove('open');
      $('#menuBtn').setAttribute('aria-expanded', 'false');
    }
  });

  fetch(BOOT.api.status).then(r => r.json()).then(s => {
    $('#statusText').textContent = s.message;
    if (!s.open) $('#dot').classList.add('closed');
  }).catch(() => {
    $('#statusText').textContent = 'Check hours below';
  });

  const cache = {};

  async function fetchSlots(date, svcId, barberId) {
    const key = `${date}|${svcId}|${barberId}`;
    if (cache[key]) return cache[key];
    const url = new URL(BOOT.api.availability, location.origin);
    url.searchParams.set('date', date);
    url.searchParams.set('service_id', svcId);
    url.searchParams.set('barber_id', barberId ?? 'any');
    const res = await fetch(url);
    const json = await res.json();
    cache[key] = json.slots || [];
    return cache[key];
  }

  function openDays(n) {
    const out = [];
    const d = new Date();
    d.setHours(0, 0, 0, 0);
    for (let i = 0; out.length < n && i < 21; i++) {
      const x = new Date(d);
      x.setDate(d.getDate() + i);
      if (HOURS[x.getDay()]) out.push(x);
    }
    return out;
  }
  function dayLabel(d) {
    const t = new Date();
    t.setHours(0, 0, 0, 0);
    const diff = Math.round((d - t) / 864e5);
    return {
      name: diff === 0 ? 'Today' : diff === 1 ? 'Tomorrow' : DAYNAMES[d.getDay()].slice(0, 3),
      date: d.toLocaleDateString(undefined, { day: 'numeric', month: 'short' }),
    };
  }
  function isoDate(d) {
    return d.getFullYear() + '-'
         + String(d.getMonth() + 1).padStart(2, '0') + '-'
         + String(d.getDate()).padStart(2, '0');
  }

  const days = openDays(7);
  const state = {
    svc: SERVICES[0].slug,
    barber: 'any',
    day: 0,
    slot: null,
    name: '',
    phone: '',
    done: null,
    err: '',
  };

  (async () => {
    const svc = SERVICES.find(s => s.slug === 'cut') || SERVICES[0];
    for (let i = 0; i < days.length; i++) {
      const slots = await fetchSlots(isoDate(days[i]), svc.id, 'any');
      const hit = slots.find(s => s.available);
      if (hit) {
        const b = $('#nextBtn');
        b.hidden = false;
        b.textContent = `Next free chair: ${dayLabel(days[i]).name} at ${hit.label}`;
        b.onclick = () => {
          Object.assign(state, {
            svc: svc.slug,
            barber: 'any',
            day: i,
            slot: hit.minute,
            done: null,
            err: '',
          });
          renderBook();
          $('#book').scrollIntoView({ behavior: 'smooth' });
        };
        return;
      }
    }
  })();

  async function renderBook() {
    const card = $('#bookCard');

    if (state.done) {
      const d = state.done;
      card.innerHTML = `
        <div class="done">
          <h3>You're booked in, ${d.name}.</h3>
          <p>We'll see you at the shop. Please arrive five minutes early.</p>
          <dl>
            <dt>Service</dt><dd>${d.svc.name} ($${d.svc.price})</dd>
            <dt>Barber</dt><dd>${d.barber.name}</dd>
            <dt>When</dt><dd>${d.when}</dd>
            <dt>Reference</dt><dd>${d.ref}</dd>
          </dl>
          <button class="btn ghost" id="again">Book another visit</button>
        </div>`;
      $('#again').onclick = () => {
        state.done = null;
        state.slot = null;
        state.name = '';
        state.phone = '';
        renderBook();
      };
      return;
    }

    const svc = SERVICES.find(s => s.slug === state.svc);
    const d = days[state.day];
    const barberId = state.barber === 'any'
      ? 'any'
      : (BARBERS.find(b => b.slug === state.barber)?.id ?? 'any');

    const slots = await fetchSlots(isoDate(d), svc.id, barberId);

    if (state.slot !== null && !slots.some(s => s.minute === state.slot && s.available)) {
      state.slot = null;
    }
    const chosen = slots.find(s => s.minute === state.slot);
    const esc = v => String(v).replace(/"/g, '&quot;');

    card.innerHTML = `
      <div class="step">
        <h3>Service</h3>
        <div class="chips" data-group="svc">
          ${SERVICES.map(s => `<button class="chip" aria-pressed="${s.slug === state.svc}" data-v="${s.slug}">${s.name}<small>$${s.price}, ${s.duration} min</small></button>`).join('')}
        </div>
      </div>
      <div class="step">
        <h3>Barber</h3>
        <div class="chips" data-group="barber">
          ${[{ slug: 'any', name: 'Any barber' }, ...BARBERS].map(b => `<button class="chip" aria-pressed="${b.slug === state.barber}" data-v="${b.slug}">${b.name}</button>`).join('')}
        </div>
      </div>
      <div class="step">
        <h3>Day</h3>
        <div class="chips" data-group="day">
          ${days.map((x, i) => {
            const l = dayLabel(x);
            return `<button class="chip" aria-pressed="${i === state.day}" data-v="${i}">${l.name}<small>${l.date}</small></button>`;
          }).join('')}
        </div>
      </div>
      <div class="step">
        <h3>Time</h3>
        <div class="chips" data-group="slot">
          ${slots.length
            ? slots.map(s => `<button class="chip" aria-pressed="${s.minute === state.slot}" data-v="${s.minute}" ${s.available ? '' : 'disabled'}>${s.label}</button>`).join('')
            : 'Closed this day.'}
        </div>
      </div>
      <div class="step">
        <div class="fields">
          <div><label for="nm">Your name</label><input id="nm" autocomplete="name" value="${esc(state.name)}"></div>
          <div><label for="ph">Phone number</label><input id="ph" type="tel" autocomplete="tel" value="${esc(state.phone)}"></div>
        </div>
      </div>
      <p class="err" role="alert">${state.err}</p>
      <div class="summary">
        <p>${chosen ? `${svc.name}, ${dayLabel(d).name} at ${chosen.label}. $${svc.price}` : 'Choose a time to continue.'}</p>
        <button class="btn" id="confirm">Confirm booking</button>
      </div>`;

    card.querySelectorAll('.chips').forEach(g => {
      g.onclick = e => {
        const b = e.target.closest('.chip');
        if (!b || b.disabled) return;
        const v = b.dataset.v, k = g.dataset.group;

        state.name = $('#nm').value;
        state.phone = $('#ph').value;
        state.err = '';

        if (k === 'svc') state.svc = v;
        if (k === 'barber') { state.barber = v; state.slot = null; }
        if (k === 'day') { state.day = +v; state.slot = null; }
        if (k === 'slot') state.slot = +v;

        renderBook();
      };
    });

    $('#confirm').onclick = async (ev) => {
      const btn = ev.currentTarget;
      if (btn.disabled) return;
      btn.disabled = true;
      btn.textContent = 'Booking…';

      state.name = $('#nm').value.trim();
      state.phone = $('#ph').value.trim();

      if (!chosen) { state.err = 'Choose a time for your visit.'; return renderBook(); }
      if (!state.name) { state.err = 'Enter your name so we know who to expect.'; return renderBook(); }
      if (state.phone.replace(/\D/g, '').length < 7) {
        state.err = 'Enter a phone number we can reach you on.';
        return renderBook();
      }

      const finalBarberId = state.barber === 'any'
        ? chosen.barber_id
        : BARBERS.find(b => b.slug === state.barber).id;

      let res;
      try {
        res = await fetch(BOOT.api.bookings, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': BOOT.csrf,
          },
          body: JSON.stringify({
            service_id: svc.id,
            barber_id: finalBarberId,
            date: isoDate(d),
            start_minute: chosen.minute,
            customer_name: state.name,
            customer_phone: state.phone,
          }),
        });
      } catch {
        state.err = 'Network error. Please try again.';
        return renderBook();
      }

      if (!res.ok) {
        const err = await res.json().catch(() => ({}));
        state.err = err.message || 'Could not confirm. Please try another time.';
        delete cache[`${isoDate(d)}|${svc.id}|${barberId}`];
        return renderBook();
      }

      const data = await res.json();
      const barber = BARBERS.find(b => b.id === finalBarberId);

      state.done = {
        name: state.name.split(' ')[0],
        svc,
        barber,
        when: `${DAYNAMES[d.getDay()]} ${dayLabel(d).date}, ${chosen.label}`,
        ref: data.reference,
      };
      state.err = '';
      renderBook();
      card.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
    };
  }

  document.addEventListener('click', e => {
    const s = e.target.closest('[data-svc]');
    const p = e.target.closest('[data-pick]');
    if (s) {
      state.svc = s.dataset.svc;
      state.done = null;
      state.slot = null;
      renderBook();
    }
    if (p) {
      state.barber = p.dataset.pick;
      state.done = null;
      state.slot = null;
      renderBook();
    }
  });

  renderBook();
})();
