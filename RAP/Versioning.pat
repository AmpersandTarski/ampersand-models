PATTERN Versioning -- Author(s) stef.joosten@ou.nl, rieks.joosten@tno.nl
--!PATTERN Versioning USES Events
PURPOSE PATTERN Versioning IN DUTCH
{+Een historische database wordt ingezet zodat gebruikers kunnen nagaan wat geregistreerd is geweest op enig moment
in het verleden.
Een vraag als: ``Waar woonde Pieter de Vries op 12 oktober 1959''
is standaard uitvraagbaar, vanwege de eigenschap dat de registratie een historische is.

Deze specificatie maakt onderscheid tussen een object en de contents van dat object.
Een dossier is een voorbeeld van zo'n soort object: de contents wijzigt in de loop van de tijd.
Er kunnen stukken aan het dossier worden toegevoegd, eruit verwijderd, gewijzigd, enzovoorts.
Alles wat in de loop van de tijd kan veranderen van waarde, valt hieronder.
Zo kan een object ''leeftijd_van_Jan'' als contents ''23'' hebben.
Een half jaar later kan de contents anders zijn, bijvoorbeeld ''24''.
De verandering van de contents van een object vindt plaats op basis van een event.

Deze specificatie beschrijft een administratie van gebeurtenissen,
die het mogelijk maakt de contents van objecten in het verleden te reconstrueren.
In deze zin lijkt de functionaliteit op wat version management systemen zoals
Subversion (ook bekend als SVN) of Apple's time machine te bieden hebben.-}

PURPOSE CONCEPT Contents IN DUTCH
{+Door expliciet over contents te spreken,
hoeven we nog niet vast te leggen of deze contents bestaat uit een enkel gegeven of een complexe structuur van gegevens.
Voor historie is slechts van belang dat een contents bestaat.
Daarom spreken we over: ``contents''
als een op zichzelf staand begrip.
-}
CONCEPT Contents "the substance contained in something at a given point in time." ""
PURPOSE CONCEPT Version IN DUTCH
{+Omdat de waarde van een object in de tijd kan veranderen, spreken we van de relatieve leeftijd van inhouden.
Omdat elke verandering optreedt aan de hand van een event, en gebeurtenissen elkaar opvolgen, kunnen we de relatieve leeftijd uitdrukken als versienummer.
Het begrip version is daarvoor bedoeld.
-}
CONCEPT Version "the relative age of contents with respect to earlier contents" ""
PURPOSE CONCEPT CommitEvent IN ENGLISH
{+The term 'CommitEvent' is defined to enable events that do not result in (versioned) changes to be distinguished from other events-}
CONCEPT CommitEvent "an event that is the direct cause of some (versioned) change"
GEN CommitEvent ISA Event

KEY keyContents: Contents(object,version)
--RULE keyContents: object;object~ /\ version;version~ |- I
--  PHRASE "De contents van een object is uniek gekarakteriseerd door het versienummer. Dat wil zeggen: als het object en het versienummer vastliggen, dan is er één contents (of er is geen contents)."
--  PHRASE "When the object and version number is known, any object is uniquely determined. Note the difference with 'object', which identifies the most recent version of an object."

object :: Contents -> Object PRAGMA "" "is contained in " "".
PURPOSE RELATION object IN DUTCH
{+Als we zeggen dat een contents bij een object hoort,
dan bedoelen we dat dat object ooit deze contents heeft gehad.
Oudere versies van die contents moeten bewaard blijven.
-}

version :: Contents -> Version PRAGMA "The version of " "is".
PURPOSE RELATION version IN DUTCH
{+Om de tijdsvolgorde te registreren krijgt elke contents een versienummer.
-}

RULE "actualContent": version~;object;contents;version |- lt \/ I[Version]
PURPOSE RULE "actualContent" IN DUTCH
{+Op elk moment moet een object verwijzen naar zijn actuele contents.
Daarom verwijst de relatie 'contents' naar de meest recente contents van een object.-}
PURPOSE RULE "actualContent" IN ENGLISH
{+On any given moment in time, an object must refer to its most recent contents.
That is why the relation 'contents' (contents) points to the most recent contents of an object."-}

lt :: Version * Version {-[ASY,TRN]-} PRAGMA "" "is more recent than".
PURPOSE RELATION lt IN DUTCH
{+Versies hebben zin zolang we kunnen vaststellen voor elk tweetal versies welk van de twee recenter is.
Daarom bestaat een relatie "lt".
Stel bijvoorbeeld dat de contents van het object ``adres_van_Jan`` op 23 januari jongstleden ``Dorpsstraat 49`` was.
Een week later was de contents van datzelfde object ``Zwerk 102``.
We zeggen nu dat de laatstgenoemde contents recenter is dan de eerstgenoemde.
-}

contents :: Object -> Contents PRAGMA "The current contents of " " is ".
PURPOSE RELATION contents IN DUTCH
{+Deze contents kan vervangen worden, waarbij het object een volgend versienummer krijgt.
We willen dan dat het object te allen tijde naar het jongste object verwijst.-}

RULE "opvolgend versienummer": preCommitEventContent~;postCommitEventContent /\ object;object~ /\ -I |- version;isOpvolgerVan~;version~
  PHRASE "Als door het optreden van een event de contents van een object is veranderd, dan is de version van de nieuwe contents gelijk aan de opvolger van de version heeft de oude contents."
PURPOSE RULE "opvolgend versienummer" IN DUTCH
{+Van elke contents wordt een version bijgehouden, om voor gebruikers de leeftijd ten opzichte van andere inhouden zichtbaar te maken. Als een contents verandert, krijgt die een opvolgende version toegekend.-}
PURPOSE RULE "opvolgend versienummer" IN ENGLISH
{+A version number is maintained for the purpose of visualizing the age of a contents relative to other contents. Whenever the contents of an object changes, it will be assigned the consecutive version number.-}

isOpvolgerVan :: Version * Version [INJ,ASY,IRF] PRAGMA "" "is de opvolger van, c.q. volgt direct op".
PURPOSE RELATION isOpvolgerVan IN DUTCH
{+Om vast te kunnen stellen dat van een een stuk object-geschiedenis geen enkele verandering ontbreekt, moeten we de opeenvolging van object inhouden kunnen natrekken. Dat doen we door expliciet de volgorde van versienummers vast te stellen. Merk op van elke version vastgesteld moet kunnen worden wat zijn **voorganger** is, en niet per se wat zijn opvolger is - multirealiteit staat immers wel toe dat een contents meerdere consecutieve opvolgers kan hebben, maar niet dat een contents door meerdere andere inhouden kan worden voorafgegaan.-}

RULE "ouder dan": (I \/ lt);isOpvolgerVan~ |- lt

preCommitEventContent :: CommitEvent * Contents PRAGMA "" "has changed " "into another contents"
PURPOSE RELATION preCommitEventContent IN DUTCH
{+Verandering aan een object vindt plaats op basis van een event.
Deze event noemen we de aanleiding van de verandering.
Stel ``g`` is een event, die een verandering teweeg brengt in object ``o``,
dan geven we de contents voorafgaand aan ``g`` aan als ``preCommitEventContent(o)`` en de contents na afloop van ``g`` als ``postCommitEventContent(o)``
-}
PURPOSE RELATION preCommitEventContent IN ENGLISH
{+Changing an object occurs on the basis of an event.
We way that this event induces the change.
Let ``g`` be an event that changes object ``o``.
The contents of ``o`` before ``g`` occurs is identified by ``preCommitEventContent(o)``.
-}

postCommitEventContent :: CommitEvent * Contents PRAGMA "" "has changed some contents into "
PURPOSE RELATION postCommitEventContent IN DUTCH
{+Gebeurtenissen kunnen de contents van een object veranderen, maar dat hoeft natuurlijk niet.
Gebeurtenissen kunnen immers ook aanleiding zijn om de contents alleen maar te bekijken/inspecteren.-}
PURPOSE RELATION postCommitEventContent IN ENGLISH
{+When an event occurs, it may change an object.
The contents of ``o`` after event ``g`` has occured is identified by ``postCommitEventContent(o)``.
-}

isVoorgangerVan :: Contents * Contents [UNI,ASY,IRF] PRAGMA "" "is the direct predecessor of ".
PURPOSE RELATION isVoorgangerVan IN DUTCH
{+Om te kunnen natrekken hoe de contents van een object tot stand is gekomen moet een ononderbroken ketting van inhouden kunnen worden geconstrueerd, voor zover de geschiedenis is opgeslagen.-}

RULE "voorganger": isVoorgangerVan = postCommitEventContent~;preCommitEventContent /\ version;isOpvolgerVan;version~ /\ object;object~
PHRASE "Contents X is de voorganger van contents Y als er een event is waarin X werd getransformeerd in Y en vice versa."
PURPOSE RULE "voorganger" IN DUTCH
{+Van elke contents moet traceerbaar zijn volgens welk pad van bewerkingen/veranderingen die contents tot stand is gekomen.
Daartoe moet van elke contents diens directe voorganger bekend zijn.
Deze directe voorganger is de contents die middels een enkele bewerking
werd getransformeerd in de contents waarvan het de voorganger is.
Echter, omdat bewerkingen meerdere inhouden kunnen transformeren,
moet de version van de contents ook volgen op die van diens voorganger.
Beide inhouden moeten hetzelfde object betreffen.
-}

isDirecteOpvolgerVan :: Contents * Contents [ASY,IRF] PRAGMA "" "is een directe opvolger van".
PURPOSE RELATION isDirecteOpvolgerVan IN DUTCH
{+Om te kunnen natrekken hoe de contents van een object tot stand is gekomen,
moet een ononderbroken ketting van inhouden kunnen worden geconstrueerd
op basis van de opgeslagen geschiedenis.-}

RULE "directe opvolgers": isDirecteOpvolgerVan = preCommitEventContent~;postCommitEventContent /\ version;isOpvolgerVan~;version~ /\ object;object~
PHRASE "Contents Y is een opvolger van contents X als er een event is waarin X werd getransformeerd in Y en vice versa."
PURPOSE RULE "directe opvolgers" IN DUTCH
{+Vanuit elke contents willen we kunnen navigeren naar de verzameling van verschillende inhouden die daaruit zijn ontstaan.
De verzameling van (directe) opvolgers van een zekere contents
zijn die inhouden die middels een enkele bewerking zijn ontstaan uit een bewerking op die contents.
Echter, omdat bewerkingen inhouden van meerdere objecten kunnen transformeren,
moet de version van de opvolger volgen op die van de bewerkte contents
en moeten beide inhouden hetzelfde object betreffen.
-}

isIndirecteOpvolgerVan :: Contents * Contents [ASY,IRF] PRAGMA "" "is een (van de mogelijk meerdere) directe opvolger van".
PURPOSE RELATION isIndirecteOpvolgerVan IN DUTCH
{+Om te kunnen natrekken hoe de contents van een object tot stand is gekomen,
moet een ononderbroken ketting van inhouden kunnen worden geconstrueerd,
voor zover de geschiedenis is opgeslagen.-}

RULE "alle opvolgers": isDirecteOpvolgerVan;(I \/ isIndirecteOpvolgerVan) |- isIndirecteOpvolgerVan
PHRASE "Contents Y is een indirecte opvolger van contents X als er een of meer gebeurtenissen zijn waarin X werd getransformeerd in Y en vice versa."
PURPOSE RULE "alle opvolgers" IN DUTCH
{+Een historische database wordt geacht alleen die inhouden te bevatten
die deel uitmaken van de geschiedenis van de verzameling inhouden van het actuele moment.
Daarom moet van elke contents kunnen worden vastgesteld dat tenminste 1 contents bestaat,
die actueel is voor het huidige moment en die een (indirecte) opvolger is van deze (eerste) contents.
-}

RULE "keepContentClean": object;contents |- I \/ isIndirecteOpvolgerVan~ 
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

changed :: CommitEvent * Object PRAGMA "De bewerking waartoe" "de directe aanleiding is geweest, heeft de contents van" "gewijzigd".
PURPOSE RELATION changed IN ENGLISH
{+When an event occurs, this results in a changed object.
That object can be seen as an output to the operation that is being perfomed
-}

ENDPATTERN