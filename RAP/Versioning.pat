PATTERN Versioning -- Author(s) stef.joosten@ou.nl, rieks.joosten@tno.nl
--!PATTERN Versioning USES Events
PURPOSE PATTERN Versioning IN DUTCH
{+Een historische database wordt ingezet zodat gebruikers kunnen nagaan wat geregistreerd is geweest op enig moment
in het verleden.
Een vraag als: ``Waar woonde Pieter de Vries op 12 oktober 1959''
is standaard uitvraagbaar, vanwege de eigenschap dat de registratie een historische is.

Deze specificatie maakt onderscheid tussen een object en de content van dat object.
Een dossier is een voorbeeld van zo'n soort object: de content wijzigt in de loop van de tijd.
Er kunnen stukken aan het dossier worden toegevoegd, eruit verwijderd, gewijzigd, enzovoorts.
Alles wat in de loop van de tijd kan veranderen van waarde, valt hieronder.
Zo kan een object ''leeftijd_van_Jan'' als content ''23'' hebben.
Een half jaar later kan de content anders zijn, bijvoorbeeld ''24''.
De verandering van de content van een object vindt plaats op basis van een event.

Deze specificatie beschrijft een administratie van gebeurtenissen,
die het mogelijk maakt de content van objecten in het verleden te reconstrueren.
In deze zin lijkt de functionaliteit op wat version management systemen zoals
Subversion (ook bekend als SVN) of Apple's time machine te bieden hebben.-}

PURPOSE CONCEPT Content IN DUTCH
{+Door expliciet over content te spreken,
hoeven we nog niet vast te leggen of deze content bestaat uit een enkel gegeven of een complexe structuur van gegevens.
Voor historie is slechts van belang dat een content bestaat.
Daarom spreken we over: ``content''
als een op zichzelf staand begrip.
-}
CONCEPT Content "de waarde van een object op een bepaald moment." ""
PURPOSE CONCEPT Version IN DUTCH
{+Omdat de waarde van een object in de tijd kan veranderen, spreken we van de relatieve leeftijd van inhouden.
Omdat elke verandering optreedt aan de hand van een event, en gebeurtenissen elkaar opvolgen, kunnen we de relatieve leeftijd uitdrukken als versienummer.
Het begrip version is daarvoor bedoeld.
-}
CONCEPT Version "de relatieve leeftijd van een content ten opzichte van eerdere inhouden" ""
PURPOSE CONCEPT CommitEvent IN ENGLISH
{+The term 'CommitEvent' is defined to enable events that do not result in (versioned) changes to be distinguished from other events-}
CONCEPT CommitEvent "an event that is the direct cause of some (versioned) change"
GEN CommitEvent ISA Event

KEY keyContent: Content(object,version)
--RULE keyContent: object;object~ /\ version;version~ |- I
--  PHRASE "De content van een object is uniek gekarakteriseerd door het versienummer. Dat wil zeggen: als het object en het versienummer vastliggen, dan is er één content (of er is geen content)."
--  PHRASE "When the object and version number is known, any object is uniquely determined. Note the difference with 'object', which identifies the most recent version of an object."

object :: Content -> Object PRAGMA "" "hoort bij" "".
PURPOSE RELATION object IN DUTCH
{+Als we zeggen dat een content bij een object hoort,
dan bedoelen we dat dat object ooit deze content heeft gehad.
Oudere versies van die content moeten bewaard blijven.
-}

version :: Content -> Version PRAGMA "Het versienummer van" "is".
PURPOSE RELATION version IN DUTCH
{+Om de tijdsvolgorde te registreren krijgt elke content een versienummer.
-}

RULE "actualContent": version~;object;content;version |- lt \/ I[Version]
PURPOSE RULE "actualContent" IN DUTCH
{+Op elk moment moet een object verwijzen naar zijn actuele content.
Daarom verwijst de relatie 'content' naar de meest recente content van een object.-}
PURPOSE RULE "actualContent" IN ENGLISH
{+On any given moment in time, an object must refer to its most recent content.
That is why the relation 'content' (content) points to the most recent content of an object."-}

lt :: Version * Version {-[ASY,TRN]-} PRAGMA "" "is recenter dan".
PURPOSE RELATION lt IN DUTCH
{+Versies hebben zin zolang we kunnen vaststellen voor elk tweetal versies welk van de twee recenter is.
Daarom bestaat een relatie "lt".
Stel bijvoorbeeld dat de content van het object ``adres_van_Jan`` op 23 januari jongstleden ``Dorpsstraat 49`` was.
Een week later was de content van datzelfde object ``Zwerk 102``.
We zeggen nu dat de laatstgenoemde content recenter is dan de eerstgenoemde.
-}

content :: Object -> Content PRAGMA "" "bevat op het actuele moment".
PURPOSE RELATION content IN DUTCH
{+Deze content kan vervangen worden, waarbij het object een volgend versienummer krijgt.
We willen dan dat het object te allen tijde naar het jongste object verwijst.-}

RULE "opvolgend versienummer": preCommitEventContent~;postCommitEventContent /\ object;object~ /\ -I |- version;isOpvolgerVan~;version~
  PHRASE "Als door het optreden van een event de content van een object is veranderd, dan is de version van de nieuwe content gelijk aan de opvolger van de version heeft de oude content."
PURPOSE RULE "opvolgend versienummer" IN DUTCH
{+Van elke content wordt een version bijgehouden, om voor gebruikers de leeftijd ten opzichte van andere inhouden zichtbaar te maken. Als een content verandert, krijgt die een opvolgende version toegekend.-}
PURPOSE RULE "opvolgend versienummer" IN ENGLISH
{+A version number is maintained for the purpose of visualizing the age of a content relative to other contents. Whenever the content of an object changes, it will be assigned the consecutive version number.-}

isOpvolgerVan :: Version * Version [INJ,ASY,IRF] PRAGMA "" "is de opvolger van, c.q. volgt direct op".
PURPOSE RELATION isOpvolgerVan IN DUTCH
{+Om vast te kunnen stellen dat van een een stuk object-geschiedenis geen enkele verandering ontbreekt, moeten we de opeenvolging van object inhouden kunnen natrekken. Dat doen we door expliciet de volgorde van versienummers vast te stellen. Merk op van elke version vastgesteld moet kunnen worden wat zijn **voorganger** is, en niet per se wat zijn opvolger is - multirealiteit staat immers wel toe dat een content meerdere consecutieve opvolgers kan hebben, maar niet dat een content door meerdere andere inhouden kan worden voorafgegaan.-}

RULE "ouder dan": (I \/ lt);isOpvolgerVan~ |- lt

preCommitEventContent :: CommitEvent * Content PRAGMA "" "has changed " "into another content"
PURPOSE RELATION preCommitEventContent IN DUTCH
{+Verandering aan een object vindt plaats op basis van een event.
Deze event noemen we de aanleiding van de verandering.
Stel ``g`` is een event, die een verandering teweeg brengt in object ``o``,
dan geven we de content voorafgaand aan ``g`` aan als ``preCommitEventContent(o)`` en de content na afloop van ``g`` als ``postCommitEventContent(o)``
-}
PURPOSE RELATION preCommitEventContent IN ENGLISH
{+Changing an object occurs on the basis of an event.
We way that this event induces the change.
Let ``g`` be an event that changes object ``o``.
The content of ``o`` before ``g`` occurs is identified by ``preCommitEventContent(o)``.
-}

postCommitEventContent :: CommitEvent * Content PRAGMA "" "has changed some content into "
PURPOSE RELATION postCommitEventContent IN DUTCH
{+Gebeurtenissen kunnen de content van een object veranderen, maar dat hoeft natuurlijk niet.
Gebeurtenissen kunnen immers ook aanleiding zijn om de content alleen maar te bekijken/inspecteren.-}
PURPOSE RELATION postCommitEventContent IN ENGLISH
{+When an event occurs, it may change an object.
The content of ``o`` after event ``g`` has occured is identified by ``postCommitEventContent(o)``.
-}

isVoorgangerVan :: Content * Content [UNI,ASY{-,IRR-}] PRAGMA "" "is de directe voorganger van".
PURPOSE RELATION isVoorgangerVan IN DUTCH
{+Om te kunnen natrekken hoe de content van een object tot stand is gekomen moet een ononderbroken ketting van inhouden kunnen worden geconstrueerd, voor zover de geschiedenis is opgeslagen.-}
RULE isVoorgangerVan |- -I PHRASE "de relatie 'isVoorgangerVan' is irreflexief."

RULE "voorganger": isVoorgangerVan = postCommitEventContent~;preCommitEventContent /\ version;isOpvolgerVan;version~ /\ object;object~
PHRASE "Content X is de voorganger van content Y als er een event is waarin X werd getransformeerd in Y en vice versa."
PURPOSE RULE "voorganger" IN DUTCH
{+Van elke content moet traceerbaar zijn volgens welk pad van bewerkingen/veranderingen die content tot stand is gekomen.
Daartoe moet van elke content diens directe voorganger bekend zijn.
Deze directe voorganger is de content die middels een enkele bewerking
werd getransformeerd in de content waarvan het de voorganger is.
Echter, omdat bewerkingen meerdere inhouden kunnen transformeren,
moet de version van de content ook volgen op die van diens voorganger.
Beide inhouden moeten hetzelfde object betreffen.
-}

isDirecteOpvolgerVan :: Content * Content [ASY{-,IRR-}] PRAGMA "" "is een directe opvolger van".
PURPOSE RELATION isDirecteOpvolgerVan IN DUTCH
{+Om te kunnen natrekken hoe de content van een object tot stand is gekomen,
moet een ononderbroken ketting van inhouden kunnen worden geconstrueerd
op basis van de opgeslagen geschiedenis.-}
RULE isOpvolgerVan |- -I PHRASE "de relatie 'isOpvolgerVan' is irreflexief."

RULE "directe opvolgers": isDirecteOpvolgerVan = preCommitEventContent~;postCommitEventContent /\ version;isOpvolgerVan~;version~ /\ object;object~
PHRASE "Content Y is een opvolger van content X als er een event is waarin X werd getransformeerd in Y en vice versa."
PURPOSE RULE "directe opvolgers" IN DUTCH
{+Vanuit elke content willen we kunnen navigeren naar de verzameling van verschillende inhouden die daaruit zijn ontstaan.
De verzameling van (directe) opvolgers van een zekere content
zijn die inhouden die middels een enkele bewerking zijn ontstaan uit een bewerking op die content.
Echter, omdat bewerkingen inhouden van meerdere objecten kunnen transformeren,
moet de version van de opvolger volgen op die van de bewerkte content
en moeten beide inhouden hetzelfde object betreffen.
-}

isIndirecteOpvolgerVan :: Content * Content [ASY{-,IRR-}] PRAGMA "" "is een (van de mogelijk meerdere) directe opvolger van".
PURPOSE RELATION isIndirecteOpvolgerVan IN DUTCH
{+Om te kunnen natrekken hoe de content van een object tot stand is gekomen,
moet een ononderbroken ketting van inhouden kunnen worden geconstrueerd,
voor zover de geschiedenis is opgeslagen.-}
RULE isOpvolgerVan |- -I PHRASE "de relatie 'isOpvolgerVan' is irreflexief."

RULE "alle opvolgers": isDirecteOpvolgerVan;(I \/ isIndirecteOpvolgerVan) |- isIndirecteOpvolgerVan
PHRASE "Content Y is een indirecte opvolger van content X als er een of meer gebeurtenissen zijn waarin X werd getransformeerd in Y en vice versa."
PURPOSE RULE "alle opvolgers" IN DUTCH
{+Een historische database wordt geacht alleen die inhouden te bevatten
die deel uitmaken van de geschiedenis van de verzameling inhouden van het actuele moment.
Daarom moet van elke content kunnen worden vastgesteld dat tenminste 1 content bestaat,
die actueel is voor het huidige moment en die een (indirecte) opvolger is van deze (eerste) content.
-}

RULE "keepContentClean": object;content |- I \/ isIndirecteOpvolgerVan~ 
PURPOSE RULE "keepContentClean" IN DUTCH
{+Een historische database wordt geacht alleen die inhouden te bevatten
die deel uitmaken van de geschiedenis van de verzameling inhouden van het actuele moment.-}

RULE "changelog": changed = (preCommitEventContent /\ postCommitEventContent;-I);object /\ (postCommitEventContent /\ preCommitEventContent;-I);object
PURPOSE RULE "changelog" IN DUTCH
{+In de 'changelog' kan van elke event die geleid heeft tot inhoudelijke veranderingen
worden vastgesteld welke objecten dat betrof.
Ook omgekeerd kan van elk object worden teruggevonden
welke gebeurtenissen hebben geleid tot inhoudelijke veranderingen in het object.
-}

changed :: CommitEvent * Object PRAGMA "De bewerking waartoe" "de directe aanleiding is geweest, heeft de content van" "gewijzigd".
PURPOSE RELATION changed IN ENGLISH
{+When an event occurs, this results in a changed object.
That object can be seen as an output to the operation that is being perfomed
-}

ENDPATTERN