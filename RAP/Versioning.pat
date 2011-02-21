PATTERN Versioning -- MAINTAINER stef.joosten@ou.nl; modified by rieks.joosten@tno.nl)
--!PATTERN Versioning USES Events
PURPOSE PATTERN Versioning IN DUTCH
{+Een historische database wordt ingezet zodat gebruikers kunnen nagaan wat geregistreerd is geweest op enig moment
in het verleden.
Een vraag als: ``Waar woonde Pieter de Vries op 12 oktober 1959''
is standaard uitvraagbaar, vanwege de eigenschap dat de registratie een historische is.

Deze specificatie maakt onderscheid tussen een object en de inhoud van dat object.
Een dossier is een voorbeeld van zo'n soort object: de inhoud wijzigt in de loop van de tijd.
Er kunnen stukken aan het dossier worden toegevoegd, eruit verwijderd, gewijzigd, enzovoorts.
Alles wat in de loop van de tijd kan veranderen van waarde, valt hieronder.
Zo kan een object ''leeftijd_van_Jan'' als inhoud ''23'' hebben.
Een half jaar later kan de inhoud anders zijn, bijvoorbeeld ''24''.
De verandering van de inhoud van een object vindt plaats op basis van een gebeurtenis.

Deze specificatie beschrijft een administratie van gebeurtenissen,
die het mogelijk maakt de inhoud van objecten in het verleden te reconstrueren.
In deze zin lijkt de functionaliteit op wat versie management systemen zoals
Subversion (ook bekend als SVN) of Apple's time machine te bieden hebben.-}

PURPOSE CONCEPT Inhoud IN DUTCH
{+Door expliciet over inhoud te spreken,
hoeven we nog niet vast te leggen of deze inhoud bestaat uit een enkel gegeven of een complexe structuur van gegevens.
Voor historie is slechts van belang dat een inhoud bestaat.
Daarom spreken we over: ``inhoud''
als een op zichzelf staand begrip.
-}
CONCEPT Inhoud "de waarde van een object op een bepaald moment." ""
PURPOSE CONCEPT Versie IN DUTCH
{+Omdat de waarde van een object in de tijd kan veranderen, spreken we van de relatieve leeftijd van inhouden.
Omdat elke verandering optreedt aan de hand van een gebeurtenis, en gebeurtenissen elkaar opvolgen, kunnen we de relatieve leeftijd uitdrukken als versienummer.
Het begrip versie is daarvoor bedoeld.
-}
CONCEPT Versie "de relatieve leeftijd van een inhoud ten opzichte van eerdere inhouden" ""

KEY keyInhoud: Inhoud(object,versie)
--RULE keyInhoud: object;object~ /\ versie;versie~ |- I
--  PHRASE "De inhoud van een object is uniek gekarakteriseerd door het versienummer. Dat wil zeggen: als het object en het versienummer vastliggen, dan is er één inhoud (of er is geen inhoud)."
--  PHRASE "When the object and versie number is known, any object is uniquely determined. Note the difference with 'object', which identifies the most recent versie of an object."

object :: Inhoud -> Object PRAGMA "" "hoort bij" "".
PURPOSE RELATION object IN DUTCH
{+Als we zeggen dat een inhoud bij een object hoort,
dan bedoelen we dat dat object ooit deze inhoud heeft gehad.
Oudere versies van die inhoud moeten bewaard blijven.
-}

versie :: Inhoud -> Versie PRAGMA "Het versienummer van" "is".
PURPOSE RELATION versie IN DUTCH
{+Om de tijdsvolgorde te registreren krijgt elke inhoud een versienummer.
-}

RULE "actuele inhoud": versie~;object;inhoud;versie |- lt \/ I[Versie]
PURPOSE RULE "actuele inhoud" IN DUTCH
{+Op elk moment moet een object verwijzen naar zijn actuele inhoud.
Daarom verwijst de relatie 'inhoud' naar de meest recente inhoud van een object.-}
PURPOSE RULE "actuele inhoud" IN ENGLISH
{+On any given moment in time, an object must refer to its most recent content.
That is why the relation 'inhoud' (content) points to the most recent content of an object."-}

lt :: Versie * Versie {-[ASY,TRN]-} PRAGMA "" "is recenter dan".
PURPOSE RELATION lt IN DUTCH
{+Versies hebben zin zolang we kunnen vaststellen voor elk tweetal versies welk van de twee recenter is.
Daarom bestaat een relatie "lt".
Stel bijvoorbeeld dat de inhoud van het object ``adres_van_Jan`` op 23 januari jongstleden ``Dorpsstraat 49`` was.
Een week later was de inhoud van datzelfde object ``Zwerk 102``.
We zeggen nu dat de laatstgenoemde inhoud recenter is dan de eerstgenoemde.
-}

inhoud :: Object -> Inhoud PRAGMA "" "bevat op het actuele moment".
PURPOSE RELATION inhoud IN DUTCH
{+Deze inhoud kan vervangen worden, waarbij het object een volgend versienummer krijgt.
We willen dan dat het object te allen tijde naar het jongste object verwijst.-}

RULE "opvolgend versienummer": pre~;post /\ object;object~ /\ -I |- versie;isOpvolgerVan~;versie~
  PHRASE "Als door het optreden van een gebeurtenis de inhoud van een object is veranderd, dan is de versie van de nieuwe inhoud gelijk aan de opvolger van de versie heeft de oude inhoud."
PURPOSE RULE "opvolgend versienummer" IN DUTCH
{+Van elke inhoud wordt een versie bijgehouden, om voor gebruikers de leeftijd ten opzichte van andere inhouden zichtbaar te maken. Als een inhoud verandert, krijgt die een opvolgende versie toegekend.-}
PURPOSE RULE "opvolgend versienummer" IN ENGLISH
{+A version number is maintained for the purpose of visualizing the age of a content relative to other contents. Whenever the content of an object changes, it will be assigned the consecutive version number.-}

isOpvolgerVan :: Versie * Versie [INJ,ASY,IRF] PRAGMA "" "is de opvolger van, c.q. volgt direct op".
PURPOSE RELATION isOpvolgerVan IN DUTCH
{+Om vast te kunnen stellen dat van een een stuk object-geschiedenis geen enkele verandering ontbreekt, moeten we de opeenvolging van object inhouden kunnen natrekken. Dat doen we door expliciet de volgorde van versienummers vast te stellen. Merk op van elke versie vastgesteld moet kunnen worden wat zijn **voorganger** is, en niet per se wat zijn opvolger is - multirealiteit staat immers wel toe dat een inhoud meerdere consecutieve opvolgers kan hebben, maar niet dat een inhoud door meerdere andere inhouden kan worden voorafgegaan.-}

RULE "ouder dan": (I \/ lt);isOpvolgerVan~ |- lt

pre :: CommitEvent*Inhoud PRAGMA "" "is de rechtstreekse aanleiding geweest om een operatie op" "uit te voeren".
PURPOSE RELATION pre IN DUTCH
{+Verandering aan een object vindt plaats op basis van een gebeurtenis.
Deze gebeurtenis noemen we de aanleiding van de verandering.
Stel ``g`` is een gebeurtenis, die een verandering teweeg brengt in object ``o``,
dan geven we de inhoud voorafgaand aan ``g`` aan als ``pre(o)`` en de inhoud na afloop van ``g`` als ``post(o)``
-}
PURPOSE RELATION pre IN ENGLISH
{+Changing an object occurs on the basis of an event.
We way that this event induces the change.
Let ``g`` be an event that changes object ``o``.
The content of ``o`` before ``g`` occurs is identified by ``pre(o)``.
-}

post :: CommitEvent * Inhoud PRAGMA "De bewerking waartoe" "de directe aanleiding is geweest, heeft" "als resultaat opgeleverd".
PURPOSE RELATION post IN DUTCH
{+Gebeurtenissen kunnen de inhoud van een object veranderen, maar dat hoeft natuurlijk niet.
Gebeurtenissen kunnen immers ook aanleiding zijn om de inhoud alleen maar te bekijken/inspecteren.-}
PURPOSE RELATION post IN ENGLISH
{+When an event occurs, it may change an object.
The content of ``o`` after event ``g`` has occured is identified by ``post(o)``.
-}

op :: CommitEvent -> Bewerking PRAGMA "" "is de rechtstreekse aanleiding geweest om" "uit te voeren".

isVoorgangerVan :: Inhoud * Inhoud [UNI,ASY{-,IRR-}] PRAGMA "" "is de directe voorganger van".
PURPOSE RELATION isVoorgangerVan IN DUTCH
{+Om te kunnen natrekken hoe de inhoud van een object tot stand is gekomen moet een ononderbroken ketting van inhouden kunnen worden geconstrueerd, voor zover de geschiedenis is opgeslagen.-}
RULE isVoorgangerVan |- -I PHRASE "de relatie 'isVoorgangerVan' is irreflexief."

RULE "voorganger": isVoorgangerVan = post~;pre /\ versie;isOpvolgerVan;versie~ /\ object;object~
PHRASE "Inhoud X is de voorganger van inhoud Y als er een gebeurtenis is waarin X werd getransformeerd in Y en vice versa."
PURPOSE RULE "voorganger" IN DUTCH
{+Van elke inhoud moet traceerbaar zijn volgens welk pad van bewerkingen/veranderingen die inhoud tot stand is gekomen.
Daartoe moet van elke inhoud diens directe voorganger bekend zijn.
Deze directe voorganger is de inhoud die middels een enkele bewerking
werd getransformeerd in de inhoud waarvan het de voorganger is.
Echter, omdat bewerkingen meerdere inhouden kunnen transformeren,
moet de versie van de inhoud ook volgen op die van diens voorganger.
Beide inhouden moeten hetzelfde object betreffen.
-}

isDirecteOpvolgerVan :: Inhoud * Inhoud [ASY{-,IRR-}] PRAGMA "" "is een directe opvolger van".
PURPOSE RELATION isDirecteOpvolgerVan IN DUTCH
{+Om te kunnen natrekken hoe de inhoud van een object tot stand is gekomen,
moet een ononderbroken ketting van inhouden kunnen worden geconstrueerd
op basis van de opgeslagen geschiedenis.-}
RULE isOpvolgerVan |- -I PHRASE "de relatie 'isOpvolgerVan' is irreflexief."

RULE "directe opvolgers": isDirecteOpvolgerVan = pre~;post /\ versie;isOpvolgerVan~;versie~ /\ object;object~
PHRASE "Inhoud Y is een opvolger van inhoud X als er een gebeurtenis is waarin X werd getransformeerd in Y en vice versa."
PURPOSE RULE "directe opvolgers" IN DUTCH
{+Vanuit elke inhoud willen we kunnen navigeren naar de verzameling van verschillende inhouden die daaruit zijn ontstaan.
De verzameling van (directe) opvolgers van een zekere inhoud
zijn die inhouden die middels een enkele bewerking zijn ontstaan uit een bewerking op die inhoud.
Echter, omdat bewerkingen inhouden van meerdere objecten kunnen transformeren,
moet de versie van de opvolger volgen op die van de bewerkte inhoud
en moeten beide inhouden hetzelfde object betreffen.
-}

isIndirecteOpvolgerVan :: Inhoud * Inhoud [ASY{-,IRR-}] PRAGMA "" "is een (van de mogelijk meerdere) directe opvolger van".
PURPOSE RELATION isIndirecteOpvolgerVan IN DUTCH
{+Om te kunnen natrekken hoe de inhoud van een object tot stand is gekomen,
moet een ononderbroken ketting van inhouden kunnen worden geconstrueerd,
voor zover de geschiedenis is opgeslagen.-}
RULE isOpvolgerVan |- -I PHRASE "de relatie 'isOpvolgerVan' is irreflexief."

RULE "alle opvolgers": isDirecteOpvolgerVan;(I \/ isIndirecteOpvolgerVan) |- isIndirecteOpvolgerVan
PHRASE "Inhoud Y is een indirecte opvolger van inhoud X als er een of meer gebeurtenissen zijn waarin X werd getransformeerd in Y en vice versa."
PURPOSE RULE "alle opvolgers" IN DUTCH
{+Een historische database wordt geacht alleen die inhouden te bevatten
die deel uitmaken van de geschiedenis van de verzameling inhouden van het actuele moment.
Daarom moet van elke inhoud kunnen worden vastgesteld dat tenminste 1 inhoud bestaat,
die actueel is voor het huidige moment en die een (indirecte) opvolger is van deze (eerste) inhoud.
-}

RULE "database schoon houden": object;inhoud |- I \/ isIndirecteOpvolgerVan~ 
PURPOSE RULE "database schoon houden" IN DUTCH
{+Een historische database wordt geacht alleen die inhouden te bevatten
die deel uitmaken van de geschiedenis van de verzameling inhouden van het actuele moment.-}

RULE "changelog": changed = (pre /\ post;-I);object /\ (post /\ pre;-I);object
PURPOSE RULE "changelog" IN DUTCH
{+In de 'changelog' kan van elke gebeurtenis die geleid heeft tot inhoudelijke veranderingen
worden vastgesteld welke objecten dat betrof.
Ook omgekeerd kan van elk object worden teruggevonden
welke gebeurtenissen hebben geleid tot inhoudelijke veranderingen in het object.
-}

changed :: CommitEvent * Object PRAGMA "De bewerking waartoe" "de directe aanleiding is geweest, heeft de inhoud van" "gewijzigd".
PURPOSE RELATION changed IN ENGLISH
{+When an event occurs, this results in a changed object.
That object can be seen as an output to the operation that is being perfomed
-}

ENDPATTERN