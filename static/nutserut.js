'use strict';

let g_pair = 'kal2dan';

function escHTML(t) {
	return t.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&apos;');
}

function translateResult(rv) {
	if (rv.hasOwnProperty('input')) {
		$('#input').val(rv.input);
	}

	if (rv.hasOwnProperty('garbage') && rv.garbage.length) {
		let gb = '<ul>';
		for (let i=0 ; i<rv.garbage.length ; ++i) {
			let err = '';
			if (rv.garbage[i][0] === 'spell') {
				err = '<i class="data-word" data-type="spell">'+escHTML(rv.garbage[i][1])+'</i> blev stavekontrolleret til <i class="data-ana">'+escHTML(rv.garbage[i][2])+'</i>';
			}
			else if (rv.garbage[i][0] === 'heur') {
				err = '<i class="data-word" data-type="heur">'+escHTML(rv.garbage[i][1])+'</i> fik heuristisk analyse <i class="data-ana">'+escHTML(rv.garbage[i][2])+'</i>';
			}
			else if (rv.garbage[i][0] === 'null') {
				err = '<i class="data-word" data-type="null">'+escHTML(rv.garbage[i][1])+'</i> kunne slet ikke analyseres';
			}
			if (err) {
				gb += '<li><div class="d-flex"><div class="me-auto">'+err+'</div><div><a href="#" class="link-light ms-3 text-nowrap"><i class="bi bi-send"></i> Feedback</a></div></div></li>';
			}
		}
		gb += '</ul>';
		$('#garbage-body').html(gb);
		$('#garbage-body').find('.link-light').off().click(function() { alert('NOT YET IMPLEMENTED'); return false; });
		$('#garbage').show();
	}

	if (rv.hasOwnProperty('gloss')) {
		$('#output-gloss').show().find('.card-text').text(rv.gloss);
	}
	if (rv.hasOwnProperty('moved')) {
		$('#output-moved').show().find('.card-text').text(rv.moved);
	}
	if (rv.hasOwnProperty('output')) {
		$('#output').show().find('.card-text').text(rv.output);
	}
}

function ajax_fail(jqXHR) {
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
		$('#output-gloss,#output-moved').show().find('.card-text').text('… arbejder …');
		$.post('callback.php', {a: 'kal2qdx', t: txt}).done(translateResult).fail(ajax_fail);
	}
	else {
		$('#output').show().find('.card-text').text('… arbejder …');
		$.post('callback.php', {a: 'dan2kal', t: txt}).done(translateResult).fail(ajax_fail);
	}
}

function init() {
	$('#garbage,#output,#output-gloss,#output-moved').hide();
	$('.btnTranslate').click(btnTranslate);

	$('input[name=optPair]').change(function() {
		g_pair = $('input[name=optPair]:checked').val();
		$('.dan2kal,.kal2dan').hide();
		$('.'+g_pair).show();
	});

	$('input[name=optPair]').first().change();
}

window.addEventListener('load', init);
