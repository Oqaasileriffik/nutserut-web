(function (root, factory) {
	if (typeof define === 'function' && define.amd) {
		define([], factory);
	}
	else if (typeof module === 'object' && module.exports) {
		module.exports = factory();
	}
	else {
		root.nutserut = factory();
	}
}(typeof self !== 'undefined' ? self : this, function () {
	'use strict';

	let g_pair = 'kal2dan';
	let g_lang = 'en';
	let g_rv = {};
	let g_slug = '';

	function escHTML(t) {
		return t.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&apos;');
	}

	function haveLocalStorage() {
		try {
			let storage = window.localStorage;
			let x = 'LocalStorageTest';
			storage.setItem(x, x);
			storage.removeItem(x);
		}
		catch (e) {
			return false;
		}
		return true;
	}

	function ls_get(key, def) {
		let v = null;
		try {
			v = window.localStorage.getItem(key);
		}
		catch (e) {
		}
		if (v === null) {
			if (def !== null && typeof def === 'object') {
				v = Object.assign({}, def);
			}
			else {
				v = def;
			}
		}
		else {
			v = JSON.parse(v);
		}
		return v;
	}

	function ls_set(key, val) {
		try {
			window.localStorage.setItem(key, JSON.stringify(val));
		}
		catch (e) {
		}
	}

	function ls_del(key) {
		window.localStorage.removeItem(key);
	}

	function sort_readings(a, b) {
		if (/¤MERGED/.test(a)) {
			return -1;
		}
		return 1;
	}

	function format_reading(txt) {
		txt = txt.replace(/ ¤\S+/g, '');
		txt = escHTML(txt);
		txt = txt.replace(/&quot;(.+?)&quot; /g, '<span class="text-success">"$1"</span> ');
		txt = txt.replace(/ (i?(?:N|V|Pali|Conj|Adv|Interj|Pron|Prop|Num|Symbol|Adj|Part|Prep))\b/g, ' <span class="text-primary">$1</span>');
		txt = txt.replace(/ ([A-Z]+)\b/g, ' <span class="text-danger">$1</span>');
		return txt;
	}

	function glossify(txt) {
		let html = '';
		let cs = txt.split(/\n(?="<)/);
		for (let i=0 ; i<cs.length ; ++i) {
			let rs = cs[i].split(/\n\t/);
			let wf = rs.shift();
			html += '<b>'+escHTML(wf.substring(2, wf.length-2))+"</b>\n";
			rs.sort(sort_readings);
			html += '<i class="bi bi-hash"></i><span class="ms-2 gloss-src">'+format_reading(rs[0])+"</span>\n";
			html += '<i class="bi bi-highlighter"></i><span class="ms-2 gloss-trg">'+format_reading(rs[1])+"</span>\n";
		}
		return html;
	}

	function btnFeedbackSend() {
		let modal = $('#feedback');

		let comment = $.trim($('#feedbackComment').val());
		if (!comment) {
			feedbackFocus();
			return false;
		}
		if (comment.length > 500) {
			alert(l10n_translate('ERR_FEEDBACK_LONG'));
			return false;
		}

		let email = $.trim($('#feedbackEmail').val());
		if (email && !/^\S+?@\S+?\.\S+$/.test(email)) {
			alert(l10n_translate('ERR_FEEDBACK_EMAIL'));
			return false;
		}

		$.post('callback.php', {
			a: 'feedback',
			hash: g_rv.hash,
			which: modal.attr('data-which'),
			comment: comment,
			email: email,
			}).done(function() {
				bootstrap.Modal.getOrCreateInstance(modal.get(0)).hide();
				let toast = new bootstrap.Toast(document.getElementById('toastFeedback'));
				toast.show();
			}).fail(ajax_fail);
	}

	function feedbackFocus() {
		$('#feedbackComment').focus();
	}

	function feedbackChange() {
		let cnt = '('+$('#feedbackComment').val().length+'/500)';
		$('#feedbackCount').text(cnt);
	}

	function feedbackShow() {
		let modal = $('#feedback');
		let err = $(this).closest('.d-flex');
		modal.attr('data-which', err.find('.data-word').attr('data-which'));
		$('#feedbackLabel').html($('#feedbackLabel').html().replace('%INPUT%', err.find('.data-word').text()));

		let popup = bootstrap.Modal.getOrCreateInstance(modal.get(0));
		$('#feedbackContext').val(g_rv.input);
		$('#feedbackAnalysis').val(err.find('.me-auto').text());
		$('#feedbackComment').val('').change();
		popup.show();

		modal.on('shown.bs.modal', feedbackFocus);
		setTimeout(feedbackFocus, 1000);
		return false;
	}

	function translateResult(rv) {
		g_rv = rv;

		if (rv.hasOwnProperty('input')) {
			$('#input').val(rv.input).change();
		}

		if (rv.hasOwnProperty('garbage') && rv.garbage.length) {
			let gb = '<ul>';
			for (let i=0 ; i<rv.garbage.length ; ++i) {
				let err = '';
				if (rv.garbage[i][0] === 'spell') {
					err = l10n_translate('TXT_GARBAGE_SPELL', {INPUT: '<i class="data-word" data-which="'+i+'">'+escHTML(rv.garbage[i][1])+'</i>', OUTPUT: '<i class="data-ana">'+escHTML(rv.garbage[i][2])+'</i>'});
				}
				else if (rv.garbage[i][0] === 'heur') {
					err = l10n_translate('TXT_GARBAGE_HEUR', {INPUT: '<i class="data-word" data-which="'+i+'">'+escHTML(rv.garbage[i][1])+'</i>', OUTPUT: '<i class="data-ana">'+escHTML(rv.garbage[i][2])+'</i>'});
				}
				else if (rv.garbage[i][0] === 'null') {
					err = l10n_translate('TXT_GARBAGE_NULL', {INPUT: '<i class="data-word" data-which="'+i+'">'+escHTML(rv.garbage[i][1])+'</i>'});
				}
				if (err) {
					gb += '<li><div class="d-flex"><div class="me-auto">'+err+'</div><div><a href="#" class="link-light ms-3 text-nowrap btnFeedback"><i class="bi bi-send"></i> '+l10n_translate('LBL_FEEDBACK')+'</a></div></div></li>';
				}
			}
			gb += '</ul>';
			$('#garbage-body').html(gb);
			$('#garbage-body').find('.link-light').off().click(function() { alert('NOT YET IMPLEMENTED'); return false; });
			$('#garbage').show();

			$('.btnFeedback').off().click(feedbackShow);
		}

		if (rv.hasOwnProperty('gloss')) {
			$('#output-gloss').show().find('.card-text').text(rv.gloss);
		}
		if (rv.hasOwnProperty('moved')) {
			$('#output-moved').show().find('.card-text').text(rv.moved);
		}
		if (rv.hasOwnProperty('output')) {
			if (/^g-/.test(g_pair)) {
				$('#output').show().find('.card-text').html(glossify(rv.output));
			}
			else {
				$('#output').show().find('.card-text').text(rv.output);
			}
		}
	}

	function ajax_fail(jqXHR) {
		if (jqXHR.responseJSON.errors.length == 1) {
			alert(jqXHR.responseJSON.errors[0]);
			return false;
		}

		$('#garbage,#output,#output-gloss,#output-moved').hide();
		let html = '<span class="text-danger fw-bold">';
		for (let i=0 ; i<jqXHR.responseJSON.errors.length ; ++i) {
			html += escHTML(jqXHR.responseJSON.errors[i])+'<br>';
		}
		html += '</span>';
		$('#output').show().find('.card-text').html(html);
	}

	function btnTranslate() {
		$('#garbage,#output,#output-gloss,#output-moved').hide();
		let txt = $.trim($('#input').val());
		if (!txt) {
			return;
		}

		if (g_pair === 'kal2dan') {
			$('#output-gloss,#output-moved').show().find('.card-text').text(l10n_translate('MSG_WORKING'));
			$.post('callback.php', {a: 'kal2qdx', t: txt}).done(translateResult).fail(ajax_fail);
		}
		else {
			$('#output').show().find('.card-text').text(l10n_translate('MSG_WORKING'));
			$.post('callback.php', {a: g_pair, t: txt}).done(translateResult).fail(ajax_fail);
		}
	}

	function inputChange() {
		let cnt = '('+$('#input').val().length+'/500)';
		$('#inputCount').text(cnt);
	}

	function btnCopyUrl() {
		$('#shareURL').focus();
		$('#shareURL').get(0).select();
		document.execCommand('copy');
	}

	function shareResult(rv) {
		let modal = $('#share');
		let popup = bootstrap.Modal.getOrCreateInstance(modal.get(0));
		let url = location.href;
		url = url.replace(/[^\/]+$/, '') + rv.slug;
		history.pushState({}, document.title, './'+rv.slug);
		$('#shareURL').val(url);
		modal.on('shown.bs.modal', btnCopyUrl);
		popup.show();
	}

	function loadResult(rv) {
		if (rv.action === 'kal2qdx') {
			rv.action = 'kal2dan';
		}
		if (!/\/(pre|gloss|hybrid|machine)\b/.test(location.pathname)) {
			if (/^g-/.test(rv.action)) {
				location = './gloss?'+g_slug;
			}
			else if (/^h-/.test(rv.action)) {
				location = './hybrid?'+g_slug;
			}
			else if (/^m-/.test(rv.action)) {
				location = './machine?'+g_slug;
			}
			else {
				location = './pre?'+g_slug;
			}
		}
		else {
			$('#'+rv.action).click();
			translateResult(rv);
		}
	}

	function btnShare() {
		if (!g_rv) {
			return;
		}
		$.post('callback.php', {a: 'share', hash: g_rv.hash}).done(shareResult).fail(ajax_fail);
	}

	function ls_get(key, def) {
		let v = null;
		try {
			v = window.localStorage.getItem(key);
		}
		catch (e) {
		}
		if (v === null) {
			v = def;
		}
		else {
			v = JSON.parse(v);
		}
		return v;
	}

	function ls_set(key, val) {
		try {
			window.localStorage.setItem(key, JSON.stringify(val));
		}
		catch (e) {
		}
	}

	function l10n_detectLanguage() {
		g_lang = ls_get('lang', navigator.language).replace(/^([^-_]+).*$/, '$1');
		if (/\/(da|en|kl)$/i.test(location.pathname)) {
			g_lang = location.pathname.slice(-2);
		}
		if (!l10n.s.hasOwnProperty(g_lang)) {
			g_lang = 'en';
		}
		return g_lang;
	}

	function l10n_translate(s, g) {
		s = '' + s; // Coerce to string

		if (s === 'EMPTY') {
			return '';
		}

		let t = '';

		// If the string doesn't exist in the locale, fall back
		if (!l10n.s[g_lang].hasOwnProperty(s)) {
			// Try English
			if (l10n.s.hasOwnProperty('en') && l10n.s.en.hasOwnProperty(s)) {
				t = l10n.s.en[s];
			}
			// ...then Danish
			else if (l10n.s.hasOwnProperty('da') && l10n.s.da.hasOwnProperty(s)) {
				t = l10n.s.da[s];
			}
			// ...give up and return as-is
			else {
				t = s;
			}
		}
		else {
			t = l10n.s[g_lang][s];
		}

		let did = false;
		do {
			did = false;
			let rx = /\{([A-Z0-9_]+)\}/g;
			let ms = [];
			let m = null;
			while ((m = rx.exec(t)) !== null) {
				ms.push(m[1]);
			}
			for (let i=0 ; i<ms.length ; ++i) {
				let nt = l10n_translate(ms[i]);
				if (nt !== ms[i]) {
					t = t.replace('{'+ms[i]+'}', nt);
					did = true;
				}
			}

			rx = /%([a-zA-Z0-9]+)%/;
			m = null;
			while ((m = rx.exec(t)) !== null) {
				let rpl = '\ue001'+m[1]+'\ue001';
				if (typeof g === 'object' && g.hasOwnProperty(m[1])) {
					rpl = g[m[1]];
				}
				t = t.replace(m[0], rpl);
				did = true;
			}
		} while (did);

		t = t.replace(/\ue001/g, '%');
		return t;
	};

	function _l10n_world_helper() {
		let e = $(this);
		let k = e.attr('data-l10n');
		let v = l10n_translate(k);

		if (k === v) {
			return;
		}

		if (/^TXT_/.test(k)) {
			v = '<p>'+v.replace(/\n+<ul>/g, '</p><ul>').replace(/\n+<\/ul>/g, '</ul>').replace(/<\/ul>\n+/g, '</ul><p>').replace(/\n+<li>/g, '<li>').replace(/\n\n+/g, '</p><p>').replace(/\n/g, '<br>')+'</p>';
		}
		e.html(v);
		if (/^TXT_/.test(k)) {
			l10n_world(e);
		}
	}

	function l10n_world(node) {
		if (!node) {
			node = document;
		}
		$(node).find('[data-l10n]').each(_l10n_world_helper);
		$(node).find('[data-l10n-alt]').each(function() {
			let e = $(this);
			let k = e.attr('data-l10n-alt');
			let v = l10n_translate(k);
			e.attr('alt', v);
		});
		$(node).find('[data-l10n-href]').each(function() {
			let e = $(this);
			let k = e.attr('data-l10n-href');
			let v = l10n_translate(k);
			e.attr('href', v);
		});
		if (node === document) {
			$('html').attr('lang', g_lang);
		}
	}

	function init() {
		$('#garbage,#output,#output-gloss,#output-moved').hide();
		$('.btnTranslate').click(btnTranslate);

		$('.btnFeedbackSend').click(btnFeedbackSend);
		$('#feedbackComment').change(feedbackChange).keyup(feedbackChange).change();
		$('#input').change(inputChange).keyup(inputChange).change();

		$('.btnShare').click(btnShare);
		$('.btnCopyUrl').click(btnCopyUrl);

		$('input[name=optPair]').change(function() {
			g_pair = $('input[name=optPair]:checked').val();
			$('.dan2kal,.kal2dan,.m-dan2kal,.m-kal2dan,.h-kal2dan,.g-kal2eng,.g-kal2dan').hide();
			$('.'+g_pair).show();
			console.log(g_pair);
		}).first().click();

		$('input[name=optPair]').first().change();

		$('a.l10n').click(function() {
			g_lang = $(this).attr('data-which');
			ls_set('lang', g_lang);
			l10n_world();
			return false;
		});
		l10n_detectLanguage();
		l10n_world();

		let rx = /[?/]([a-z0-9]{3,})$/;
		let m = null;
		if (((m = rx.exec(location.pathname)) !== null && m[1] != 'pre' && m[1] != 'gloss' && m[1] != 'hybrid' && m[1] != 'machine') || ((m = rx.exec(location.search)) !== null)) {
			g_slug = m[1];
			$.post('callback.php', {a: 'load', slug: m[1]}).done(loadResult).fail(ajax_fail);
		}

		$('.showFirstLoad').each(function() {
			let m = $(this);
			let id = m.attr('id');
			m.on('hidden.bs.modal', function() {
				ls_set('seen-modal-'+id, true);
			});
			if (!ls_get('seen-modal-'+id, false)) {
				let modal = new bootstrap.Modal(m.get(0));
				modal.show();
			}
		});
	}

	window.addEventListener('load', init);

	// Export useful functions
	return {
		init: init,
		};
}));
