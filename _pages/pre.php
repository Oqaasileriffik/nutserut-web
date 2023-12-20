<?php
declare(strict_types=1);

page_header('SITE_TITLE_PRE');

?>
<div class="row">
<div class="col text-center">
<h1 class="my-3 title">Nutserut</h1>
<h2 class="my-3 subtitle"><i class="bi bi-diagram-3"></i> <span data-l10n="LBL_METHOD_PRE">Pre-2023 Method</span></h2>
<p><button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#whatis_pre"><i class="bi bi-info-square"></i> <span data-l10n="LBL_WHATIS">What is Nutserut?</span></button></p>
</div>
</div>

<div class="modal fade showFirstLoad" id="whatis_pre" tabindex="-1" aria-labelledby="whatisLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title text-blue" id="whatisLabel"><i class="bi bi-info-square-fill"></i> <span data-l10n="HDR_WHATIS">What is Nutserut?</span></h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body">
			<h3 data-l10n="HDR_ITIS">Nutserut is …</h3>
			<ul>
				<li data-l10n="TXT_IS_010">an advanced rule-based machine translation service, developed by Oqaasileriffik</li>
				<li data-l10n="TXT_IS_020">a good tool to read news or other texts</li>
				<li data-l10n="TXT_IS_030">a good helper if you're learning Greenlandic</li>
				<li data-l10n="TXT_IS_040">the first release (alpha version) of the service</li>
			</ul>

			<hr>
			<h3 data-l10n="HDR_ITISNOT">Nutserut is <em>not</em> …</h3>
			<ul>
				<li data-l10n="TXT_ISNOT_010">a human; the service does not understand spelling or grammatical errors, and these will greatly impair the quality of the translation</li>
				<li data-l10n="TXT_ISNOT_020">a dictionary; this service expects whole sentences, not fragments or single words</li>
				<li data-l10n="TXT_ISNOT_030">finished; there is still a lot to do, and we know how to progress from here</li>
			</ul>
		</div>
		<div class="modal-footer text-center">
			<button type="button" class="btn btn-primary" data-bs-dismiss="modal"><i class="bi bi-check2"></i> <span data-l10n="BTN_WHATIS_CLOSE">Understood</span></button>
		</div>
	</div>
</div>
</div>

<div class="row my-5">
<div class="col">
	<div class="text-center">
		<div class="btn-group" role="group" aria-label="Toggle translation direction">
		<input type="radio" class="btn-check" name="optPair" id="kal2dan" value="kal2dan" autocomplete="off" checked>
		<label class="btn btn-outline-primary" for="kal2dan" data-l10n="BTN_KAL2DAN">Kalaallisut<i class="bi bi-arrow-right-short"></i>Danish</label>
		<input type="radio" class="btn-check" name="optPair" id="dan2kal" value="dan2kal" autocomplete="off">
		<label class="btn btn-outline-primary" for="dan2kal" data-l10n="BTN_DAN2KAL">Danish<i class="bi bi-arrow-right-short"></i>Kalaallisut</label>
		</div>
	</div>
</div>
</div>

<div class="row my-5">
<div class="col">
	<div class="mb-3">
	<label for="input" class="form-label d-flex"><h5 class="text-blue me-auto"><span class="kal2dan" style="display: none;" data-l10n="HDR_INPUT_KAL">Greenlandic sentence to be translated</span><span class="dan2kal" style="display: none;" data-l10n="HDR_INPUT_DAN">Danish sentence to be translated</span></h5><div class="small ms-3" id="inputCount"></div></label>
	<textarea class="form-control" id="input" rows="3" spellcheck="false"></textarea>
	</div>
	<div class="text-center">
	<button class="btn btn-primary btnTranslate"><span class="kal2dan" style="display: none;"><i class="bi bi-translate"></i> <span data-l10n="BTN_XLATE_DAN">Translate to Danish</span></span><span class="dan2kal" style="display: none;"><i class="bi bi-translate"></i> <span data-l10n="BTN_XLATE_KAL">Translate to Greenlandic</span></span></button>
	</div>
</div>
</div>

<?php
require_once __DIR__.'/garbage.php';
?>

<div class="row my-3" id="output" style="display: none;">
<div class="col">
	<div class="card mb-3">
	<div class="card-header d-flex"><h5 class="me-auto" data-l10n="HDR_TRANSLATION">Translation</h5><div><a href="#" class="ms-3 text-nowrap btnShare"><i class="bi bi-share-fill"></i> <span data-l10n="LBL_SHARE">Share</span></a></div></div>
	<div class="card-body">
	<p class="card-text" lang="da"></p>
	</div>
	</div>
</div>
</div>

<div class="row my-3" id="output-gloss" style="display: none;">
<div class="col">
	<div class="card mb-3">
	<div class="card-header d-flex"><h5 class="me-auto" data-l10n="HDR_GLOSSED">Translation of chunks, without reordering</h5><div><a href="#" class="ms-3 text-nowrap btnShare"><i class="bi bi-share-fill"></i> <span data-l10n="LBL_SHARE">Share</span></a></div></div>
	<div class="card-body">
	<p class="card-text" lang="kl"></p>
	</div>
	</div>
</div>
</div>

<div class="row my-3" id="output-moved" style="display: none;">
<div class="col">
	<div class="card mb-3">
	<div class="card-header d-flex"><h5 class="me-auto" data-l10n="HDR_MOVED">Translation with experimental chunk reordering</h5><div><a href="#" class="ms-3 text-nowrap btnShare"><i class="bi bi-share-fill"></i> <span data-l10n="LBL_SHARE">Share</span></a></div></div>
	<div class="card-body">
	<p class="card-text" lang="kl"></p>
	</div>
	</div>
</div>
</div>

<div class="row my-5">
<div class="col">
	<div class="text-center">
		<hr>
		<a href="./" class="btn btn-outline-primary m-1"><span data-l10n="BTN_FRONTPAGE">Front page</span></a>
		<a href="./gloss" class="btn btn-outline-primary m-1"><i class="bi bi-highlighter"></i> <span data-l10n="LBL_METHOD_GLOSS">Educational Annotation</span></a>
		<a href="./hybrid" class="btn btn-outline-primary m-1"><i class="bi bi-boxes"></i> <span data-l10n="LBL_METHOD_HYBRID">Hybrid Artificial Intelligence</span></a>
		<a href="./machine" class="btn btn-outline-primary m-1"><i class="bi bi-cpu"></i> <span data-l10n="LBL_METHOD_MACHINE">Artificial Intelligence</span></a>
	</div>
</div>
</div>
