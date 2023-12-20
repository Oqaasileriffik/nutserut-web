<?php
declare(strict_types=1);
require_once __DIR__.'/_inc/lib.php';

if (preg_match('~/(pre|hybrid|machine|gloss)/$~', $_SERVER['REQUEST_URI'], $m)) {
	header('Location: ../'.$m[1]);
	exit();
}
else if (preg_match('~/pre[^a-z/]*~', $_SERVER['REQUEST_URI'])) {
	require_once __DIR__.'/_pages/pre.php';
}
else if (preg_match('~/gloss[^a-z/]*~', $_SERVER['REQUEST_URI'])) {
	require_once __DIR__.'/_pages/gloss.php';
}
else if (preg_match('~/hybrid[^a-z/]*~', $_SERVER['REQUEST_URI'])) {
	require_once __DIR__.'/_pages/hybrid.php';
}
else if (preg_match('~/machine[^a-z/]*~', $_SERVER['REQUEST_URI'])) {
	require_once __DIR__.'/_pages/machine.php';
}
else {
	require_once __DIR__.'/_pages/index.php';
}

?>

<!-- Shared components -->
<div class="modal fade" id="feedback" tabindex="-1" aria-labelledby="feedbackLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title text-blue"><i class="bi bi-send"></i> <span id="feedbackLabel" data-l10n="HDR_FEEDBACK">Feedback for <em>%INPUT%</em></span></h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body">
			<div class="mb-3">
				<label for="feedbackContext" class="form-label text-orange" data-l10n="LBL_CONTEXT">Context</label>
				<textarea class="form-control" id="feedbackContext" rows="3" disabled readonly></textarea>
			</div>
			<div class="mb-3">
				<label for="feedbackAnalysis" class="form-label text-orange" data-l10n="LBL_ANA_ERR">Incomplete analysis</label>
				<input type="text" class="form-control" id="feedbackAnalysis" disabled readonly>
			</div>
			<div class="mb-3">
				<div class="d-flex"><label for="feedbackComment" class="form-label text-orange me-auto" data-l10n="LBL_FEEDBACK_TEXT">Your feedback</label><div class="small ms-3" id="feedbackCount"></div></div>
				<textarea class="form-control" id="feedbackComment" rows="3"></textarea>
			</div>
			<div class="mb-3">
				<label for="feedbackEmail" class="form-label text-orange" data-l10n="LBL_FEEDBACK_EMAIL">Your email (optional)</label>
				<input type="email" class="form-control" id="feedbackEmail">
			</div>
		</div>
		<div class="modal-footer text-center">
			<button type="button" class="btn btn-primary btnFeedbackSend"><i class="bi bi-forward"></i> <span data-l10n="BTN_FEEDBACK_SEND">Send feedback</span></button>
		</div>
	</div>
</div>
</div>

<div class="modal fade" id="share" tabindex="-1" aria-labelledby="shareLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title text-blue" id="shareLabel"><i class="bi bi-share-fill me-1"></i> <span data-l10n="HDR_SHARE">URL to this translation result</span></h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body d-flex">
			<div class="flex-fill">
				<input type="text" class="form-control" id="shareURL">
			</div>
			<div class="ms-3">
				<button class="btn btn-primary" id="btnCopyUrl"><i class="bi bi-clipboard"></i> <span data-l10n="BTN_COPY_URL">Copy URL</span></button>
			</div>
		</div>
	</div>
</div>
</div>

<div class="position-fixed top-0 end-0 p-3" style="z-index: 100">
<div id="toastFeedback" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
	<div class="toast-body text-orange fs-5" data-l10n="TXT_FEEDBACK_THANKS">Feedback received - thank you!</div>
</div>
</div>

</div>

<footer>
	<div class="container footer">
		<section class="row main-footer">
			<div class="col">
				<div class="footer-title">
				<h2 data-l10n="FTR_CONTACT">Contact</h2>
				</div>
				<div class="row flex-nowrap mb-2">
					<div class="col-auto pr-0"><i aria-hidden="true" class="bi bi-envelope-fill"></i></div>
					<div class="col nowrap"><a href="mailto:oqaasileriffik@oqaasileriffik.gl" class="text-decoration-none">oqaasileriffik@oqaasileriffik.gl</a></div>
				</div>
				<div class="row flex-nowrap mb-2">
					<div class="col-auto pr-0"><i aria-hidden="true" class="bi bi-telephone-fill"></i></div>
					<div class="col nowrap"><a href="tel:+299384060" class="text-decoration-none">(+299) 38 40 60</a></div>
				</div>
				<div class="row flex-nowrap">
					<div class="col-auto pr-0"><i aria-hidden="true" class="bi bi-geo-alt-fill"></i></div>
					<div class="col"><a href="https://www.google.com/maps?q=Oqaasileriffik,%20Nuuk" class="text-decoration-none">Ceresvej 7-1<br>Postboks 980<br>3900 Nuuk<br>Kalaallit Nunaat</a></div>
				</div>
			</div>

			<div class="col">
				<div class="footer-title">
				<h2 data-l10n="FTR_HOURS">Opening hours</h2>
				</div>
				<div class="row mb-2">
					<div class="col" data-l10n="FTR_MON_FRI">Monday - Friday</div>
					<div class="col">8:00 - 16:00</div>
				</div>
				<div class="row text-orange">
					<div class="col" data-l10n="FTR_SAT_SUN">Saturday - Sunday</div>
					<div class="col" data-l10n="FTR_CLOSED">Closed</div>
				</div>
			</div>

			<div class="col-auto">
				<div class="footer-title">
				<h2 data-l10n="FTR_NEWS">Newsletter sign-up</h2>
				</div>
				<div class="row mb-4">
					<div class="col" data-l10n="FTR_NEWS_TEXT">Sign up for news via e-mail</div>
				</div>
				<a role="button" class="btn btn-outline-secondary" href="https://groups.google.com/a/oqaasileriffik.gl/forum/#!forum/news/join" target="_blank" rel="noopener">
					<div class="row flex-nowrap">
							<div class="col-auto pr-0"><i aria-hidden="true" class="bi bi-envelope"></i></div>
							<div class="col" data-l10n="FTR_NEWS_BUTTON">Sign up</div>
					</div>
				</a>
			</div>
		</section>
	</div>
	<div class="footer-line">
	</div>
	<div class="footer copyright text-center">
		<section>
			<div><span class="copyr">©</span> 2021-<?=date('Y');?> <span class="sep">|</span> Oqaasileriffik</div>
		</section>
	</div>
</footer>

<script async src="https://www.googletagmanager.com/gtag/js?id=G-N1BDG3Y82F"></script>
<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());

	gtag('config', 'G-N1BDG3Y82F');
</script>

<script>
	var _paq = window._paq = window._paq || [];
	_paq.push(['trackPageView']);
	_paq.push(['enableLinkTracking']);
	(function() {
		var u="//oqaasileriffik.gl/matomo/";
		_paq.push(['setTrackerUrl', u+'matomo.php']);
		_paq.push(['setSiteId', '3']);
		var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
		g.async=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
	})();
</script>

</body>
</html>
