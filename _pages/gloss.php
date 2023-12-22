<?php
declare(strict_types=1);

page_header('SITE_TITLE_GLOSS');

?>
<div class="row">
<div class="col text-center">
<h1 class="my-3 title"><i class="bi bi-highlighter"></i> <span data-l10n="LBL_METHOD_GLOSS">Educational Annotation</span></h1>
</div>
</div>

<div class="row my-3 justify-content-center">
<div class="col-lg-6 col-md-9 col-sm-12">
	<p><span data-l10n="TXT_GLOSS_010">This is a language learning tool designed to show you the source and target language side-by-side. This is <em>not translation</em>. While this tool does try to provide the correct target language translation based on the source language context, it leaves word order and conjugation/inflection as an exercise for the reader.</span> <a href="#info" data-l10n="LBL_READ_MORE">Read more…</a></p>
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

<div class="row my-5 justify-content-center">
<div class="col-lg-9 col-md-9 col-sm-12">
	<h5 data-l10n="HDR_GLOSS_INFO" id="info">Uses of annotation</h5>
	<p data-l10n="TXT_GLOSS_020">Let's start with an example. If we take the Greenlandic prompt "<em>Kalaallisut oqaaseqatigiit nutserneqartussat</em>" and <a href="./n1k">annotate it</a>, we get a breakdown of each word's analysis and then a translation of the roots (lemmas), morphemes, inflexion, and cases therein.</p>

	<p>Looking at the word "<em>nutserneqartussat</em>", we can see that the root "<em>nutser</em>" semantically has to do with turning into something (<code>Sem/turn_into</code>) and is translated as "<em>translate</em>". We don't have a translation for the morpheme <code>NIQAR</code> (it turns the construction passive), but <code>TUQ</code> means "<em>one who</em>", and <code>SSAQ</code> means "<em>future</em>".</p>
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
