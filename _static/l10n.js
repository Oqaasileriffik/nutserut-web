/*!
 * Copyright 2021-2024 Oqaasileriffik <oqaasileriffik@oqaasileriffik.gl> at https://oqaasileriffik.gl/
 *
 * This project is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This project is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this project.  If not, see <http://www.gnu.org/licenses/>.
 */
'use strict';

let l10n = {
	lang: 'en',
	s: {},
	tags: {},
	};

l10n.s.dan = {
	BTN_COPY_URL: "Kopier URL",
	BTN_DAN2KAL: "Dansk<i class=\"bi bi-arrow-right-short\"></i>kalaallisut",
	BTN_FEEDBACK_SEND: "Send feedback",
	BTN_FRONTPAGE: "Forside",
	BTN_GLOSS_DAN: "Glosser med dansk",
	BTN_GLOSS_ENG: "Glosser med engelsk",
	BTN_KAL2DAN: "Kalaallisut<i class=\"bi bi-arrow-right-short\"></i>dansk",
	BTN_KAL2ENG: "Kalaallisut<i class=\"bi bi-arrow-right-short\"></i>engelsk",
	BTN_WHATIS_CLOSE: "Forstået",
	BTN_XLATE_DAN: "Oversæt til dansk",
	BTN_XLATE_KAL: "Oversæt til grønlandsk",
	ERR_FEEDBACK_EMAIL: "Ugyldig emailaddresse!",
	ERR_FEEDBACK_LONG: "Kommentaren skal være under 500 tegn!",
	FTR_CLOSED: "lukket",
	FTR_CONTACT: "Kontakt",
	FTR_HOURS: "Åbningstider",
	FTR_MON_FRI: "mandag - fredag",
	FTR_NEWS: "Nyhedstilmelding",
	FTR_NEWS_BUTTON: "Tilmeld",
	FTR_NEWS_TEXT: "Tilmeld for nyheder via e-mail",
	FTR_SAT_SUN: "lørdag - søndag",
	HDR_ANNOTATION: "Glossering",
	HDR_FEEDBACK: "Feedback om <em>%INPUT%</em>",
	HDR_GARBAGE: "Mulige fejl i input!",
	HDR_GLOSSED: "Ledoversættelse uden flytning",
	HDR_GLOSS_INFO: "Hvordan glossering kan bruges",
	HDR_HYBRID_INFO: "Hybrid regelbaseret og maskinlæring",
	HDR_HYB_ITIS: "Hybrid kunstig intelligens er …",
	HDR_HYB_ITISNOT: "Hybrid kunstig intelligens er <em>ikke</em> …",
	HDR_INPUT_DAN: "Dansk sætning der skal oversættes",
	HDR_INPUT_KAL: "Grønlandsk sætning der skal oversættes",
	HDR_INPUT_KAL_GLOSS: "Grønlandsk sætning der skal glosseres",
	HDR_ITIS: "Nutserut er …",
	HDR_ITISNOT: "Nutserut er <em>ikke</em> …",
	HDR_L2: "Værktøj til sprogindlæring",
	HDR_MACHINE_INFO: "Maskinlæring",
	HDR_ML_ITIS: "Kunstig intelligens er …",
	HDR_ML_ITISNOT: "Kunstig intelligens er <em>ikke</em> …",
	HDR_MOVED: "Oversættelse med eksperimentel flytning af led",
	HDR_MT: "Maskinoversættelse",
	HDR_PRE2023_INFO: "Regelbaseret maskinoversættelse",
	HDR_SHARE: "URL til denne oversættelse",
	HDR_SUBTITLE: "Grønlands Sprogsekretariat",
	HDR_TITLE: "Oqaasileriffik",
	HDR_TRANSLATION: "Oversættelse",
	HDR_WHATIS: "Hvad er Nutserut?",
	LBL_ANA_ERR: "Ufuldstændige analyse",
	LBL_CONTEXT: "Kontekst",
	LBL_FEEDBACK: "Feedback",
	LBL_FEEDBACK_EMAIL: "Din email (ikke påkrævet)",
	LBL_FEEDBACK_TEXT: "Din feedback",
	LBL_METHOD_GLOSS: "Pædagogisk glossering",
	LBL_METHOD_HYBRID: "Hybrid kunstig intelligens",
	LBL_METHOD_MACHINE: "Kunstig intelligens",
	LBL_METHOD_PRE: "Før-2023-metoden",
	LBL_READ_MORE: "Læs mere…",
	LBL_SHARE: "Del",
	LBL_WHATIS: "Hvad er Nutserut?",
	LBL_WHATIS_HYBRID: "Hvad er hybrid kunstig intelligens?",
	LBL_WHATIS_MACHINE: "Hvad er kunstig intelligens?",
	MSG_WORKING: "… arbejder …",
	SITE_TITLE: "Nutserut - Grønlandsk-dansk maskinoversættelse",
	SITE_TITLE_GLOSS: "Nutserut - Pædagogisk glossering",
	SITE_TITLE_HYBRID: "Nutserut - Hybrid kunstig intelligens",
	SITE_TITLE_MACHINE: "Nutserut - Naiv kunstig intelligens",
	SITE_TITLE_PRE: "Nutserut - Grønlandsk-dansk regelbaseret maskinoversættelse",
	TXT_FEEDBACK_THANKS: "Feedback modtaget - mange tak!",
	TXT_GARBAGE_010: "Nogle ord kunne ikke analyseres, hvilket forringer eller umuliggør oversættelsen. Tjek dit input for eventuelle fejl og ret fejlene.",
	TXT_GARBAGE_020: "Hvis du mener systemet har taget fejl kan du give os feedback om et givent ord med knappen efter det.",
	TXT_GARBAGE_HEUR: "%INPUT% fik heuristisk analyse %OUTPUT%",
	TXT_GARBAGE_NULL: "%INPUT% kunne slet ikke analyseres",
	TXT_GARBAGE_SPELL: "%INPUT% blev stavekontrolleret til %OUTPUT%",
	LBL_GLOSS_010: "Dette værktøj til sprogindlæring vil vise dig kilde- og mål-sproget side-om-side, hvilket gør det nemmere at at forstå det grønlandske i den givne kontekst. Dette er <em>ikke oversættelse</em>. Selvom dette værktøj prøver at give den rigtige målsprogsoversættelse ud fra kildesprogets kontekst, så er ordrækkefølge og bøjning efterladt som en øvelse til læseren.",
	TXT_GLOSS_020: "F.eks., hvis vi tager den grønlandske tekst \"<em>Kalaallisut oqaaseqatigiit nutserneqartussat</em>\" og <a href=\"./n1k\">glosserer den</a>, så får vi detaljer om hvert ords analyse og en oversættelse af deres rødder (lemmaer), morfemer, bøjningsklasser, og kasus.",
	TXT_GLOSS_030: "Hvis vi kigger på ordet \"<em>nutserneqartussat</em>\" kan vi se at roden \"<em>nutser</em>\" semantisk har at gøre med at blive lavet om til noget (<code>Sem/turn_into</code>) og oversættes som \"<em>oversætte</em>\". Morfemet <code>NIQAR</code> gør konstruktionen passiv, <code>TUQ</code> betyder \"<em>den som</em>\", <code>SSAQ</code> betyder \"<em>planlagt</em>\", så den ordrette oversættelse er \"planlagt den som vil blive oversat\", hvilket vi kan omskrive til \"som skal oversættes\".",
	TXT_HYBRID_010: "Dette er en maskinlæringsmodel trænet på parallel menneskeskrevne tekster der har været en tur gennem vores regelbaserede grønlandske parser. I denne første fase til forhåndsvisning, har vi ikke lagt noget arbejde i at rense eller verificere at teksterne faktisk er parallelle eller endda korrekt grønlandsk. Men sammenlignet med den <a href=\"./machine\">naive kunstige intelligens</a>-model, er det tydeligt at vi kan kraftigt forbedre oversættelseskvaliteten ved at udføre lingvistisk annotation, selv hvis de parallelle tekster er af tvivlsom kvalitet.",
	TXT_HYBRID_020: "I 2024, og fremover, vil vi arbejde med at verificere kvaliteten af vores parallelle korpora, samt forbedre den grønlandske parser og stave- og grammatikkontrol, for at have et bedre grundlag at træne på.",
	TXT_HYBRID_030: "Vi garanterer at dine data ikke gemmes, med mindre du selv vælger at dele en oversættelse. Og vi vil gøre alle vores underliggende algoritmer og teknologier, og de af vores træningsdata der er offentlige, tilgængeligt for alle til at bygge videre på.",
	TXT_HYB_IS_010: "en maskinlæringsmodel trænet på lingvistisk annoterede parallele menneskeskrevne tekster.",
	TXT_ISNOT_010: "et menneske; systemet forstår altså ikke stave- eller grammatikfejl, og disse vil kraftigt forringe kvaliteten af oversættelsen.",
	TXT_ISNOT_020: "en ordbog; systemet skal have hele sætninger som input, ikke fragmenter eller enkelte ord.",
	TXT_ISNOT_030: "færdigudviklet; der er stadig meget at lave. Der mangler oversættelser til nogle af ordene, og en del sætninger fejlanalyseres. Især lange, komplicerede sætninger kan stadig producere en forvrøvlet oversættelse. Men vi ved hvordan vi skal forbedre systemet - og arbejder på det.",
	TXT_IS_010: "et avanceret regelbaseret maskinoversættelsessystem udviklet af Oqaasileriffik.",
	TXT_IS_020: "et værktøj til at læse nyheder eller andre tekster - det vil blive kraftigt forbedret i tiden fremover.",
	TXT_IS_030: "en god hjælper hvis man vil lære grønlandsk.",
	TXT_IS_040: "førsteudgaven (alpha-version) af systemet.",
	TXT_MACHINE_010: "Dette er en maskinlæringsmodel trænet på rå parallelle menneskeskrevne tekster. Dette er ca. så godt det kan gøres uden nogen lingvistisk viden. I denne første fase til forhåndsvisning, har vi ikke lagt noget arbejde i at rense eller verificere at teksterne faktisk er parallelle eller endda korrekt grønlandsk. Vi har offentliggjort denne model for at vise hvad det er muligt at lave ud fra de tosprogede tekster man kan finde online, og så man nemt kan sammenligne med <a href=\"./hybrid\">hybrid kunstig intelligens</a>-modellen hvor vi har tilføjet lidt lingvistisk annotation.",
	TXT_ML_ISNOT_030: "intelligent; på trods af at medierne refererer til maskinlæring som kunstig intelligens, så er det det forkerte term. Trænede modeller udviser ingen intelligens eller spontane tanker. Dette holder også stik for selv de største Large Language Models såsom ChatGPT.",
	TXT_ML_IS_010: "en maskinlæringsmodel trænet på rå parallele menneskeskrevne tekster.",
	TXT_PRE2023_010: "Dette projekt blev startet i 2017 med det mål at lave en regelbaseret maskinoversættelse mellem grønlandsk og dansk. Indtil medio-2023 var dette den eneste brugbare metode til at håndtere et polysyntetisk sprog med meget få tosprogede tekster, men siden da har udvikling på maskinlæringsområdet kommet frem til metoder hvor man kan træne en model der er lige så god.",
	TXT_PRE2023_020: "Gennem udviklingen af dette projekt, implementerede vi også store forbedringer til den grønlandske parser, og dette bliver brugt i mange andre sammenhæng og formål, såsom <a href=\"./hybrid\">hybrid kunstig intelligens</a>.",
};

l10n.s.eng = {
	BTN_COPY_URL: "Copy URL",
	BTN_DAN2KAL: "Danish<i class=\"bi bi-arrow-right-short\"></i>Kalaallisut",
	BTN_FEEDBACK_SEND: "Send feedback",
	BTN_FRONTPAGE: "Front page",
	BTN_GLOSS_DAN: "Annotate with Danish",
	BTN_GLOSS_ENG: "Annotate with English",
	BTN_KAL2DAN: "Kalaallisut<i class=\"bi bi-arrow-right-short\"></i>Danish",
	BTN_KAL2ENG: "Kalaallisut<i class=\"bi bi-arrow-right-short\"></i>English",
	BTN_WHATIS_CLOSE: "Understood",
	BTN_XLATE_DAN: "Translate to Danish",
	BTN_XLATE_KAL: "Translate to Greenlandic",
	ERR_FEEDBACK_EMAIL: "Invalid email address!",
	ERR_FEEDBACK_LONG: "Comment must be under 500 characters!",
	FTR_CLOSED: "Closed",
	FTR_CONTACT: "Contact",
	FTR_HOURS: "Opening hours",
	FTR_MON_FRI: "Monday - Friday",
	FTR_NEWS: "Newsletter sign-up",
	FTR_NEWS_BUTTON: "Sign up",
	FTR_NEWS_TEXT: "Sign up for news via e-mail",
	FTR_SAT_SUN: "Saturday - Sunday",
	HDR_ANNOTATION: "Annotation",
	HDR_FEEDBACK: "Feedback for <em>%INPUT%</em>",
	HDR_GARBAGE: "Possible errors in the input!",
	HDR_GLOSSED: "Translation of chunks, without reordering",
	HDR_GLOSS_INFO: "Uses of annotation",
	HDR_HYBRID_INFO: "Hybrid Rule-Based and Machine Learning",
	HDR_HYB_ITIS: "Hybrid artificial intelligence is …",
	HDR_HYB_ITISNOT: "Hybrid artificial intelligence is <em>not</em> …",
	HDR_INPUT_DAN: "Danish sentence to be translated",
	HDR_INPUT_KAL: "Greenlandic sentence to be translated",
	HDR_INPUT_KAL_GLOSS: "Greenlandic sentence to be annotated",
	HDR_ITIS: "Nutserut is …",
	HDR_ITISNOT: "Nutserut is <em>not</em> …",
	HDR_L2: "Language Learning Tools",
	HDR_MACHINE_INFO: "Machine Learning",
	HDR_ML_ITIS: "Artificial intelligence is …",
	HDR_ML_ITISNOT: "Artificial intelligence is <em>not</em> …",
	HDR_MOVED: "Translation with experimental chunk reordering",
	HDR_MT: "Machine Translation",
	HDR_PRE2023_INFO: "Rule-based Machine Translation",
	HDR_SHARE: "URL to this translation result",
	HDR_SUBTITLE: "The Language Secretariat of Greenland",
	HDR_TITLE: "Oqaasileriffik",
	HDR_TRANSLATION: "Translation",
	HDR_WHATIS: "What is Nutserut?",
	LBL_ANA_ERR: "Incomplete analysis",
	LBL_CONTEXT: "Context",
	LBL_FEEDBACK: "Feedback",
	LBL_FEEDBACK_EMAIL: "Your email (optional)",
	LBL_FEEDBACK_TEXT: "Your feedback",
	LBL_METHOD_GLOSS: "Educational Annotation",
	LBL_METHOD_HYBRID: "Hybrid Artificial Intelligence",
	LBL_METHOD_MACHINE: "Artificial Intelligence",
	LBL_METHOD_PRE: "Pre-2023 Method",
	LBL_READ_MORE: "Read more…",
	LBL_SHARE: "Share",
	LBL_WHATIS: "What is Nutserut?",
	LBL_WHATIS_HYBRID: "What is hybrid artificial intelligence?",
	LBL_WHATIS_MACHINE: "What is artificial intelligence?",
	MSG_WORKING: "… working …",
	SITE_TITLE: "Nutserut - Tools for translating Greenlandic",
	SITE_TITLE_GLOSS: "Nutserut - Educational Annotation",
	SITE_TITLE_HYBRID: "Nutserut - Hybrid Artificial Intelligence",
	SITE_TITLE_MACHINE: "Nutserut - Naive Artificial Intelligence",
	SITE_TITLE_PRE: "Nutserut - Greenlandic-Danish Rule-Based Machine Translation",
	TXT_FEEDBACK_THANKS: "Feedback received - thank you!",
	TXT_GARBAGE_010: "Some words didn't get a proper analysis, which impairs or ruins the quality of the translation. Check your input for errors and correct them.",
	TXT_GARBAGE_020: "If you feel the service is mistaken, you can give us feedback about a given word with the button after it.",
	TXT_GARBAGE_HEUR: "%INPUT% got a heuristic analysis %OUTPUT%",
	TXT_GARBAGE_NULL: "%INPUT% didn't get any analysis",
	TXT_GARBAGE_SPELL: "%INPUT% was spell-checked to %OUTPUT%",
	LBL_GLOSS_010: "This language learning tool is designed to show you the source and target language side-by-side, in order to understand Greenlandic in its original context. This is <em>not translation</em>. While this tool does try to provide the correct target language translation based on the source language context, it leaves word order and conjugation/inflection as an exercise for the reader.",
	TXT_GLOSS_020: "For example, if we take the Greenlandic prompt \"<em>Kalaallisut oqaaseqatigiit nutserneqartussat</em>\" and <a href=\"./n1k\">annotate it</a>, we get a breakdown of each word's analysis and then a translation of the roots (lemmas), morphemes, inflexion, and cases therein.",
	TXT_GLOSS_030: "Looking at the word \"<em>nutserneqartussat</em>\", we can see that the root \"<em>nutser</em>\" semantically has to do with turning into something (<code>Sem/turn_into</code>) and is translated as \"<em>translate</em>\". The morpheme <code>NIQAR</code> turns the construction passive, <code>TUQ</code> means \"<em>one who</em>\", <code>SSAQ</code> means \"<em>future</em>\", so the verbatim phrase is \"future one who becomes translated\", which we can write cleaner as \"to be translated\".",
	TXT_HYBRID_010: "This is a machine translation model trained from parallel human-authored texts that have been through parts of our rule-based Greenlandic language analysis engine. In this first preview phase, no effort has gone into cleaning up or verifying that the texts are truly parallel or even correct Greenlandic. But when compared to the <a href=\"./machine\">naive artificial intelligence</a> engine, it is evident that by providing linguistic expertise we can greatly improve the translation quality, even if the parallel texts are of dubious quality.",
	TXT_HYBRID_020: "In 2024, and onwards, we will work on verifying that the parallel corpora are of good quality, and on improving the Greenlandic analyser to provide better data, including better spelling- and grammar-checking.",
	TXT_HYBRID_030: "We guarantee that none of your data is stored, unless you explicitly share a translation. And we will make all the underlying algorithms and technology, and the public parts of our training data, available for everyone to build on.",
	TXT_HYB_IS_010: "a machine translation model trained from linguistically annotated parallel human-authored texts.",
	TXT_ISNOT_010: "a human; the service does not understand spelling or grammatical errors, and these will greatly impair the quality of the translation.",
	TXT_ISNOT_020: "a dictionary; this service expects whole sentences, not fragments or single words.",
	TXT_ISNOT_030: "finished; there is still a lot to do. Some words still lack translations, and a number of sentences will be misanalyzed. Especially long complex sentences may still result in a mangled translation. But we know how to improve the service, and we are working on it.",
	TXT_IS_010: "an advanced rule-based machine translation service, developed by Oqaasileriffik.",
	TXT_IS_020: "a tool to read news or other texts - it will be drastically improved in the future.",
	TXT_IS_030: "a good helper if you're learning Greenlandic.",
	TXT_IS_040: "the first release (alpha version) of the service.",
	TXT_MACHINE_010: "This is a machine translation model trained from raw parallel human-authored texts. This is about as good as you can get with zero linguistic expertise. In this first phase, no effort has gone into cleaning up or verifying that the texts are truly parallel or even correct Greenlandic. We made this model public to show what is possible from the bilingual texts one can find online, and as a comparison to the <a href=\"./hybrid\">hybrid artificial intelligence</a> engine where we provide a little linguistic expertise.",
	TXT_ML_ISNOT_030: "intelligent; despite the media commonly referring to machine learning models as artificial intelligence, this is a misnomer. There is no intelligence or independent thought expressed by learned models. This is true even for large language models like ChatGPT.",
	TXT_ML_IS_010: "a machine translation model trained from raw parallel human-authored texts.",
	TXT_PRE2023_010: "Started in 2017, this project aimed at making a rule-based machine translation engine between Greenlandic and Danish. Until mid-2023, this was the only viable method for handling a polysynthetic language with sparse bilingual corpora, but advances in machine learning has since allowed for trained machine translation models that perform equally well.",
	TXT_PRE2023_020: "During the development of this project, we greatly improved the Greenlandic language analysis engine, which has many other uses - one of which is seen in the <a href=\"./hybrid\">hybrid artificial intelligence</a> engine.",
};

l10n.s.kal = {
	BTN_COPY_URL: "URL kopeeruk",
	BTN_DAN2KAL: "Qallunaatut<i class=\"bi bi-arrow-right-short\"></i>kalaallisut",
	BTN_FEEDBACK_SEND: "Oqaaseqaatit nassiuguk",
	BTN_FRONTPAGE: "Saqqaa",
	BTN_GLOSS_DAN: "Qallunaatuumut isumasioruk",
	BTN_GLOSS_ENG: "Tuluttuumut isumasioruk",
	BTN_KAL2DAN: "Kalaallisut<i class=\"bi bi-arrow-right-short\"></i>qallunaatut",
	BTN_KAL2ENG: "Kalaallisut<i class=\"bi bi-arrow-right-short\"></i>qallunaatut",
	BTN_WHATIS_CLOSE: "Paasivara",
	BTN_XLATE_DAN: "Qallunaatuunngortiguk",
	BTN_XLATE_KAL: "Kalaallisuunngortiguk",
	ERR_FEEDBACK_EMAIL: "E-maili kukkusumik allassimavoq!",
	ERR_FEEDBACK_LONG: "Oqaaseqarfissaq 500-nit ikinnerusunik naqinnernik/kisitsisinik/ilisarnaatinik/akunnernik imaqassaaq!",
	FTR_CLOSED: "matoqqavoq",
	FTR_CONTACT: "Attavik",
	FTR_HOURS: "Ammasarfiit",
	FTR_MON_FRI: "ataasinngorneq - tallimanngorneq",
	FTR_NEWS: "Nutaarsiassarsisalerneq",
	FTR_NEWS_BUTTON: "Allatsigit",
	FTR_NEWS_TEXT: "Nutaarsiassaasivitsinnut allatsigit",
	FTR_SAT_SUN: "arfininngorneq - sapaat",
	HDR_ANNOTATION: "Isumasiuineq",
	HDR_FEEDBACK: "Maluginiagaq <em>%INPUT%</em> pillugu oqaaseqaateqarneq",
	HDR_GARBAGE: "Nutsigassat kukkuneqarpasipput!",
	HDR_GLOSSED: "Oqaaseqatigiit tulleriiaarneri allanngornagit nutsereqqaarneq",
	HDR_GLOSS_INFO: "Isumasiuummik atuineq",
	HDR_HYB_ITIS: "Silassorissuusiaq passuteqqitaq <em>tassaavoq</em> ...",
	HDR_HYB_ITISNOT: "Silassorissuusiaq passuteqqitaq <em>tassaanngilaq</em> ...",
	HDR_INPUT_DAN: "Qallunaatut oqaaseqatigiit nutserneqartussat",
	HDR_INPUT_KAL: "Kalaallisut oqaaseqatigiit nutserneqartussat",
	HDR_INPUT_KAL_GLOSS: "Kalaallisut oqaaseqatigiit isumasiugassat",
	HDR_ITIS: "Nutserut tassaavoq …",
	HDR_ITISNOT: "Nutserut <em>tassaanngilaq</em> …",
	HDR_L2: "Oqaatsinik ilinniutit",
	HDR_MOVED: "Oqaaseqatigiit tulleriiaarneri nikisillugit nutserineq",
	HDR_MT: "Maskiina atorlugu nutserineq",
	HDR_PRE2023_INFO: "Maskiinamik nutserut maleruagassanik tunngavilik",
	HDR_SHARE: "Nutsikkap URL-ia",
	HDR_SUBTITLE: "&nbsp;",
	HDR_TITLE: "Oqaasileriffik",
	HDR_TRANSLATION: "Nutsernera",
	HDR_WHATIS: "Nutserut suua?",
	LBL_ANA_ERR: "Nutserummit passunneqarsinnaanngitsoq",
	LBL_CONTEXT: "Oqaaseqatigiit tamakkiisut",
	LBL_FEEDBACK: "Maluginiakkannik oqaaseqaateqarfigisigut",
	LBL_FEEDBACK_EMAIL: "E-mailit (piumasaqaataanngilarli)",
	LBL_FEEDBACK_TEXT: "Maluginiakkannik oqaaseqaatit",
	LBL_METHOD_GLOSS: "Ilinniutitut isumasiuut",
	LBL_METHOD_HYBRID: "Silassorissuusiaq passuteqqitaq",
	LBL_METHOD_MACHINE: "Silassorissuusiaq",
	LBL_METHOD_PRE: "2023 sioqqullugu periuseq",
	LBL_READ_MORE: "Atuaqqigit...",
	LBL_SHARE: "Siammarteruk",
	LBL_WHATIS: "Nutserut suua?",
	LBL_WHATIS_HYBRID: "Silassorissuusiaq passuteqqitaq suua?",
	MSG_WORKING: "… ingerlavoq …",
	SITE_TITLE: "Nutserut - Kalaallisut-qallunaatut nutserut",
	SITE_TITLE_GLOSS: "Nutserut - Ilinniutitut isumasiuut",
	SITE_TITLE_HYBRID: "Nutserut - Silassorissuusiaq passuteqqitaq",
	SITE_TITLE_MACHINE: "Nutserut - Silassorissuusiaq passuteqqitaanngitsoq",
	SITE_TITLE_PRE: "Nutserut - Kalaallisut-qallunaatut nutserut",
	TXT_FEEDBACK_THANKS: "Oqaaseqaatit apuuppoq - qujanarujussuaq!",
	TXT_GARBAGE_010: "Allassimasuni oqaatsit ilai passunneqarsinnaanngillat, tamannalu pillugu nutsernera pitsaanani nutserneqarsinnaananiluunniit. Allatatit qiviaqqilaakkit kukkuneqarpatalu aaqqillugit.",
	TXT_GARBAGE_020: "Nutserut kukkusorigukku oqaaseq pineqartoq pillugu utertitsiffigaluta saaffigisinnaavatsigut tuugassaq oqaatsip kingornaniittoq toorlugu.",
	TXT_GARBAGE_HEUR: "%INPUT% paassunneqarpoq ima: %OUTPUT%",
	TXT_GARBAGE_NULL: "%INPUT% passunneqarsinnaanngilaq",
	TXT_GARBAGE_SPELL: "%INPUT% kukkunersiorneqarpoq ima: %OUTPUT%",
	LBL_GLOSS_010: "Oqaatsinik ilinniummi matumani takusinnaavatit oqaatsit misissorniakkatit oqaatsinut allanut sanillersuunneri imminnut sanileriisillugit, kalaallisut oqaatsit allanneqaqqaarneri najoqqutaralugit. Manna <em>nutserutaanngilaq</em>. Ikiuutip massuma allanneqaqqaarsimasunik oqaatsinut nutsertinniakkanut eqqortumik nutserinissaq siunertarigaluarlugu oqaatsit eqqortumik nikerartinnissaat eqqortunillu naanilersuinissaq atuaasumut sungiusaatissatut toqqammaviliivigiinnarpaa.",
	TXT_GLOSS_020: "Assersuutigalugu kalaallisut immiukkutsigu \"<em>Kalaallisut oqaaseqatigiit nutserneqartussat</em>\" <a href=\"./n1k\">isumasiorlugulu</a>, oqaatsit tamarmik misissoqqissaakkatut nuissapput taavalu nagguiit (lemmat), morfemit, naanerit kasusillu nutserneqassallutik.",
	TXT_GLOSS_030: "Oqaaseq \"<em>nutserneqartussat</em>\" misissorutsigu, takusinnaavarput nagguiup \"<em>nutser-ip</em>\" isumaa allanngornermut tunngassuteqartoq (<code>Sem/turn_into</code>) nutsigaallunilu ima \"<em>translate</em>\". Morfemi (uani: uiguut) <code>NIQAR</code> pineqartorsiutinngortitsivoq, <code>TUQ</code> isumaqarpoq \"<em>one who</em>\", <code>SSAQ</code> isumaqarpoq \"<em>future</em>\", torrutiinnarlugu nutserneqarsinnaalluni ima \"future one who becomes translated\", tamanna allaqqissaarsinnaavarput ima \"to be translated\".",
	TXT_ISNOT_010: "inuk; nutserutip oqaatsini oqaaseqatigiinnilu kukkunerit paasisinnaanngilai. Allassimasut kukkunertaqartillugit nutsikkat soorunami aamma pitsaannginnerussapput.",
	TXT_ISNOT_020: "ordbogi; nutserutip oqaaseqatigiit tamakkiisut pisariaqartippai, oqaaseqatigiit ilaannakortaannai oqaatsilluunniit ataasiakkaat kiisa pinnagit.",
	TXT_ISNOT_030: "inaarlugu ineriartortitaq; suli ineriartortitassaaqaaq. Oqaatsit ilarpassui suli nutsernertaqanngillat oqaaseqatigiillu amerlasuut suli kukkusumik nutserneqartarput. Pingaartumik oqaaseqatigiit tannerusut paatsuunganartortaqarsinnaasullu pitsaanngitsumik nutserneqassapput. Pingaarnerli tassaavoq qanoq pitsanngorsassallugu ilisimalluaratsigu pitsanngoriartornissaalu sulissutigalugu.",
	TXT_IS_010: "malittarisassanik tunngaveqarluni qarasaasiakkut nutserusiaq Oqaasileriffimmit ineriartortinneqartoq.",
	TXT_IS_020: "nutaarsiassanik allanilluunniit allassimasunik atuarnissamut iluaqutigineqarsinnaasoq piffissallu ingerlanerani pitsanngoriartortinneqartussaq.",
	TXT_IS_030: "kalaallisut oqaatsinik ilinniarnermi iluaqutigineqarsinnaasoq.",
	TXT_IS_040: "nutserusiap saqqummernera siullerpaaq (alfaversioni).",
	TXT_PRE2023_010: "Ukiumi 2017-imi aallartittumik, suliniummi matumani kalaallisut qallunaatullu akornanni maleruagassanik tunngavilimmik nutserusiornissaq siunertaasimavoq. Ukioq 2023 tikillugu tamanna suleriusissatut periarfissatuaasimavoq oqaatsinik polysyntetiskiusunik suliaqarnermi annertunngitsunik allagaatinik katersaateqarluni, maskiinalli atorlugit silassorissaanissamut periutsit ineriartorneri peqqutaallutik maskiina atorlugu nutserusiornissamik tunaartaqarluni silassorissuusiornissamut periutsit maannamut ineriartortitatulli pitsaatigisut pilersinneqarsinnaanngorput.",
	TXT_PRE2023_020: "Suliniummi matumani ineriartortitsinitsinni kalaallisut oqaatsinik oqaaseqatigiinnillu misissueqqissaaruterput allarpassuarnik atuuffilik pitsanngorsangaatsiarparput - ilaatigut tassaasoq <a href=\"./hybrid\">silassorissuusiami passuteqqitami</a> atorneqartoq.",
};

l10n.s.da = l10n.s.dan;
l10n.s.en = l10n.s.eng;
l10n.s.kl = l10n.s.kal;
