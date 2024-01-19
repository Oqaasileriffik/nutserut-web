<?php
declare(strict_types=1);

page_header('SITE_TITLE_HYBRID');

?>
<div class="row">
<div class="col text-center">
<h1 class="my-3 title">Nutserut</h1>
<h2 class="my-3 text-blue subtitle"><i class="bi bi-boxes"></i> <span data-l10n="LBL_METHOD_HYBRID">Hybrid Artificial Intelligence</span></h2>
<p><button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#whatis_hybrid"><i class="bi bi-info-square"></i> <span data-l10n="LBL_WHATIS_HYBRID">What is hybrid artificial intelligence?</span></button></p>
</div>
</div>

<div class="modal fade showFirstLoad" id="whatis_hybrid" tabindex="-1" aria-labelledby="whatisLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title text-blue" id="whatisLabel"><i class="bi bi-info-square-fill"></i> <span data-l10n="LBL_WHATIS_HYBRID">What is hybrid artificial intelligence?</span></h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body">
			<h3 data-l10n="HDR_HYB_ITIS">Hybrid artificial intelligence is …</h3>
			<ul>
				<li data-l10n="TXT_HYB_IS_010">a machine translation model trained from linguistically annotated parallel human-authored texts.</li>
			</ul>

			<hr>
			<h3 data-l10n="HDR_HYB_ITISNOT">Hybrid artificial intelligence is <em>not</em> …</h3>
			<ul>
				<li data-l10n="TXT_ISNOT_010">a human; the service does not understand spelling or grammatical errors, and these will greatly impair the quality of the translation.</li>
				<li data-l10n="TXT_ISNOT_020">a dictionary; this service expects whole sentences, not fragments or single words.</li>
				<li data-l10n="TXT_ML_ISNOT_030">intelligent; despite the media commonly referring to machine learning models as artificial intelligence, this is a misnomer. There is no intelligence or independent thought expressed by learned models. This is true even for large language models like ChatGPT.</li>
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
		<input type="radio" class="btn-check" name="optPair" id="h-kal2dan" value="h-kal2dan" autocomplete="off" checked>
		<label class="btn btn-outline-primary" for="h-kal2dan" data-l10n="BTN_KAL2DAN">Kalaallisut<i class="bi bi-arrow-right-short"></i>Danish</label>
		<input type="radio" class="btn-check" name="optPair" id="m-dan2kal" value="m-dan2kal" autocomplete="off">
		<label class="btn btn-outline-primary" for="m-dan2kal" data-l10n="BTN_DAN2KAL">Danish<i class="bi bi-arrow-right-short"></i>Kalaallisut</label>
		</div>
	</div>
</div>
</div>

<div class="row my-5">
<div class="col">
	<div class="mb-3">
	<label for="input" class="form-label d-flex"><h5 class="text-blue me-auto"><span class="h-kal2dan" style="display: none;" data-l10n="HDR_INPUT_KAL">Greenlandic sentence to be translated</span><span class="m-dan2kal" style="display: none;" data-l10n="HDR_INPUT_DAN">Danish sentence to be translated</span></h5><div class="small ms-3" id="inputCount"></div></label>
	<textarea class="form-control" id="input" rows="3" spellcheck="false"></textarea>
	</div>
	<div class="text-center">
	<button class="btn btn-primary btnTranslate"><span class="h-kal2dan" style="display: none;"><i class="bi bi-translate"></i> <span data-l10n="BTN_XLATE_DAN">Translate to Danish</span></span><span class="m-dan2kal" style="display: none;"><i class="bi bi-translate"></i> <span data-l10n="BTN_XLATE_KAL">Translate to Greenlandic</span></span></button>
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
	<p class="card-text"></p>
	</div>
	</div>
</div>
</div>

<div class="row my-5 justify-content-center">
<div class="col-lg-9 col-md-9 col-sm-12">
	<h5 data-l10n="HDR_HYBRID_INFO" id="info">Hybrid Rule-Based and Machine Learning</h5>
	<p data-l10n="TXT_HYBRID_010">This is a machine translation model trained from parallel human-authored texts that have been through parts of the rule-based Greenlandic language analysis engine. In this first phase, no effort has gone into cleaning up or verifying that the texts are truly parallel or even correct Greenlandic. When compared to the <a href="./machine">naive artificial intelligence</a> engine, it is evident that by providing linguistic expertise we can greatly improve the translation quality, even if the parallel texts are of dubious quality.</p>
	<p data-l10n="TXT_HYBRID_020">In 2024 and onwards, we will work on verifying that the parallel corpora are of good quality, and on improving the Greenlandic analyser to provide better data, including better spelling- and grammar-checking.</p>
	<p data-l10n="TXT_HYBRID_030">We guarantee that none of your data is stored, unless you explicitly share a translation. And we will make all the underlying algorithms and technology, and the public parts of our training data, available for everyone to build on.</p>
</div>
</div>

<div class="row my-5">
<div class="col">
	<div class="text-center">
		<hr>
		<a href="./" class="btn btn-outline-primary m-1"><span data-l10n="BTN_FRONTPAGE">Front page</span></a>
		<a href="./machine" class="btn btn-outline-primary m-1"><i class="bi bi-cpu"></i> <span data-l10n="LBL_METHOD_MACHINE">Artificial Intelligence</span></a>
		<a href="./pre" class="btn btn-outline-primary m-1"><i class="bi bi-diagram-3"></i> <span data-l10n="LBL_METHOD_PRE">Pre-2023 Method</span></a>
		<a href="./gloss" class="btn btn-outline-primary m-1"><i class="bi bi-highlighter"></i> <span data-l10n="LBL_METHOD_GLOSS">Educational Annotation</span></a>
	</div>
</div>
</div>
