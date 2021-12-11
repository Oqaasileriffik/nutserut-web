<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title data-l10n="SITE_TITLE">Nutserut - Greenlandic-Danish Machine Translation</title>

	<link rel="shortcut icon" href="https://oqaasileriffik.gl/favicon.ico">
	<link rel="stylesheet"  href="https://fonts.googleapis.com/css?family=Gudea%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic%7CRoboto%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic&#038;ver=5.5.3" type="text/css" media="all" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7/font/bootstrap-icons.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="static/nutserut.css?<?=filemtime(__DIR__.'/static/nutserut.css');?>">
	<script src="https://cdn.jsdelivr.net/npm/jquery@3.6/dist/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1/dist/js/bootstrap.bundle.min.js"></script>
	<script src="static/l10n.js?<?=filemtime(__DIR__.'/static/l10n.js');?>"></script>
	<script src="static/nutserut.js?<?=filemtime(__DIR__.'/static/nutserut.js');?>"></script>
</head>
<body class="d-flex flex-column">

<header>
	<div class="container">
	<div class="logo">
		<a href="https://oqaasileriffik.gl/" class="text-decoration-none">
		<h1 data-l10n="HDR_TITLE">Oqaasileriffik</h1>
		<h3 data-l10n="HDR_SUBTITLE">The Language Secretariat of Greenland</h3>
		</a>
	</div>
	</div>

	<div class="menu">
	<div class="container">
		<div class="lang-select">
			<a class="dropdown text-decoration-none fs-5" id="dropLanguages" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-globe2"></i></a>
			<ul class="dropdown-menu" aria-labelledby="dropLanguages">
				<li><a href="#" class="item l10n" data-which="kal" title="Kalaallisut"><tt>KAL</tt> <span>Kalaallisut</span></a></li>
				<li><a href="#" class="item l10n" data-which="dan" title="Dansk"><tt>DAN</tt> <span>Dansk</span></a></li>
				<li><a href="#" class="item l10n" data-which="eng" title="English"><tt>ENG</tt> <span>English</span></a></li>
			</ul>
		</div>
	</div>
	</div>
</header>

<div class="container flex-grow-1">

<div class="row">
<div class="col text-center">
<h1 class="my-3 title">Nutserut</h1>
<p><button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#whatis"><i class="bi bi-info-square"></i> <span data-l10n="LBL_WHATIS">What is Nutserut?</span></button></p>
</div>
</div>

<div class="modal fade" id="whatis" tabindex="-1" aria-labelledby="whatisLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="whatisLabel"><i class="bi bi-info-square-fill"></i> <span data-l10n="HDR_WHATIS">What is Nutserut?</span></h5>
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
		<input type="radio" class="btn-check" name="optPair" id="pairKal2dan" value="kal2dan" autocomplete="off" checked>
		<label class="btn btn-outline-primary" for="pairKal2dan" data-l10n="BTN_KAL2DAN">Kalaallisut<i class="bi bi-arrow-right-short"></i>Danish</label>
		<input type="radio" class="btn-check" name="optPair" id="pairDan2kal" value="dan2kal" autocomplete="off">
		<label class="btn btn-outline-primary" for="pairDan2kal" data-l10n="BTN_DAN2KAL">Danish<i class="bi bi-arrow-right-short"></i>Kalaallisut</label>
		</div>
	</div>
</div>
</div>

<div class="row my-5">
<div class="col">
	<div class="mb-3">
	<label for="input" class="form-label"><h5><span class="kal2dan" style="display: none;" data-l10n="HDR_INPUT_KAL">Greenlandic sentence to be translated</span><span class="dan2kal" style="display: none;" data-l10n="HDR_INPUT_DAN">Danish sentence to be translated</span></h5></label>
	<textarea class="form-control" id="input" rows="3" spellcheck="false"></textarea>
	</div>
	<div class="text-center">
	<button class="btn btn-primary btnTranslate"><span class="kal2dan" style="display: none;"><i class="bi bi-translate"></i> <span data-l10n="BTN_XLATE_DAN">Translate to Danish</span></span><span class="dan2kal" style="display: none;"><i class="bi bi-translate"></i> <span data-l10n="BTN_XLATE_KAL">Translate to Greenlandic</span></span></button>
	</div>
</div>
</div>

<div class="row my-3" id="garbage" style="display: none;">
<div class="col">
	<div class="card text-white bg-danger mb-3">
	<div class="card-header"><h5 class="text-white" data-l10n="HDR_GARBAGE">Garbage in, garbage out!</h5></div>
	<div class="card-body">
	<p class="card-text" data-l10n="TXT_GARBAGE_010">Some words didn't get a proper analysis, which impairs the quality of the translation. Check your input and correct any errors.</p>
	<p class="card-text" id="garbage-body"></p>
	<p class="card-text" data-l10n="TXT_GARBAGE_020">If you feel the service is mistaken, you can give us feedback about a given word with the button after it.</p>
	</div>
	</div>
</div>
</div>

<div class="row my-3" id="output" style="display: none;">
<div class="col">
	<div class="card mb-3">
	<div class="card-header"><h5 data-l10n="HDR_TRANSLATION">Translation</h5></div>
	<div class="card-body">
	<p class="card-text"></p>
	</div>
	</div>
</div>
</div>

<div class="row my-3" id="output-gloss" style="display: none;">
<div class="col">
	<div class="card mb-3">
	<div class="card-header"><h5 data-l10n="HDR_GLOSSED">Translation of chunks, without reordering</h5></div>
	<div class="card-body">
	<p class="card-text"></p>
	</div>
	</div>
</div>
</div>

<div class="row my-3" id="output-moved" style="display: none;">
<div class="col">
	<div class="card mb-3">
	<div class="card-header"><h5 data-l10n="HDR_MOVED">Translation with experimental chunk reordering</h5></div>
	<div class="card-body">
	<p class="card-text"></p>
	</div>
	</div>
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
			<div><span class="copyr">©</span> 2021 <span class="sep">|</span> Oqaasileriffik</div>
		</section>
	</div>
</footer>

</body>
</html>