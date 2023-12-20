<?php
declare(strict_types=1);

page_header('SITE_TITLE_GLOSS');

?>
<div class="row">
<div class="col text-center">
<h1 class="my-3 title">Nutserut</h1>
<h2 class="my-3 subtitle"><i class="bi bi-highlighter"></i> <span data-l10n="LBL_METHOD_GLOSS">Educational Annotation</span></h2>
<p><button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#whatis_gloss"><i class="bi bi-info-square"></i> <span data-l10n="LBL_WHATIS_GLOSS">What is educational annotation?</span></button></p>
</div>
</div>

<div class="modal fade showFirstLoad" id="whatis_gloss" tabindex="-1" aria-labelledby="whatisLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title text-blue" id="whatisLabel"><i class="bi bi-info-square-fill"></i> <span data-l10n="LBL_WHATIS_GLOSS">What is educational annotation?</span></h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body">
			<h3 data-l10n="HDR_GLOSS_ITIS">Educational annotation is …</h3>
			<ul>
				<li data-l10n="TXT_GLOSS_IS_010">TODO</li>
			</ul>

			<hr>
			<h3 data-l10n="HDR_GLOSS_ITISNOT">Educational annotation is <em>not</em> …</h3>
			<ul>
				<li data-l10n="TXT_GLOSS_ISNOT_010">TODO</li>
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
		<input type="radio" class="btn-check" name="optPair" id="g-kal2eng" value="g-kal2eng" autocomplete="off" checked>
		<label class="btn btn-outline-primary" for="g-kal2eng" data-l10n="BTN_KAL2ENG">Kalaallisut<i class="bi bi-arrow-right-short"></i>English</label>
		<!--
		<input type="radio" class="btn-check" name="optPair" id="g-kal2dan" value="g-kal2dan" autocomplete="off">
		<label class="btn btn-outline-primary" for="g-kal2dan" data-l10n="BTN_KAL2DAN">Kalaallisut<i class="bi bi-arrow-right-short"></i>Danish</label>
		-->
		</div>
	</div>
</div>
</div>

<div class="row my-5">
<div class="col">
	<div class="mb-3">
	<label for="input" class="form-label d-flex"><h5 class="text-blue me-auto" data-l10n="HDR_INPUT_KAL_GLOSS">Greenlandic sentence to be annotated</h5><div class="small ms-3" id="inputCount"></div></label>
	<textarea class="form-control" id="input" rows="3" spellcheck="false"></textarea>
	</div>
	<div class="text-center">
	<button class="btn btn-primary btnTranslate"><span class="g-kal2eng" style="display: none;"><i class="bi bi-translate"></i> <span data-l10n="BTN_GLOSS_ENG">Annotate with English</span></span><span class="g-kal2dan" style="display: none;"><i class="bi bi-translate"></i> <span data-l10n="BTN_GLOSS_DAN">Annotate with Danish</span></span></button>
	</div>
</div>
</div>

<?php
require_once __DIR__.'/garbage.php';
?>

<div class="row my-3" id="output" style="display: none;">
<div class="col">
	<div class="card mb-3">
	<div class="card-header d-flex"><h5 class="me-auto" data-l10n="HDR_ANNOTATION">Annotation</h5><div><a href="#" class="ms-3 text-nowrap btnShare"><i class="bi bi-share-fill"></i> <span data-l10n="LBL_SHARE">Share</span></a></div></div>
	<div class="card-body">
	<pre><code class="card-text"></code></pre>
	</div>
	</div>
</div>
</div>

<div class="row my-5">
<div class="col">
	<div class="text-center">
		<hr>
		<a href="./" class="btn btn-outline-primary m-1"><span data-l10n="BTN_FRONTPAGE">Front page</span></a>
		<a href="./hybrid" class="btn btn-outline-primary m-1"><i class="bi bi-boxes"></i> <span data-l10n="LBL_METHOD_HYBRID">Hybrid Artificial Intelligence</span></a>
		<a href="./machine" class="btn btn-outline-primary m-1"><i class="bi bi-cpu"></i> <span data-l10n="LBL_METHOD_MACHINE">Artificial Intelligence</span></a>
		<a href="./pre" class="btn btn-outline-primary m-1"><i class="bi bi-diagram-3"></i> <span data-l10n="LBL_METHOD_PRE">Pre-2023 Method</span></a>
	</div>
</div>
</div>
