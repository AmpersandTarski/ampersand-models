PATTERN Versioning --!EXTENDS Events
-- Author(s) stef.joosten@ou.nl, rieks.joosten@tno.nl
--!RJ: This pattern is ready for review
PURPOSE PATTERN Versioning IN DUTCH
{+Een historische registratie wordt ingezet zodat gebruikers kunnen nagaan wat geregistreerd is geweest op enig moment
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
PURPOSE PATTERN Versioning IN ENGLISH
{+A historic registration is being used so that it can be reconstructed what the registration contained at any point in time (in the past). Questions such as ``Did our organization have a contract with Mr. de Vries at 12 oktober 1959'' can be answered, based on the property that a registration containing such data is a historic registration.

This specification distinguishes between an object and its contents. A file is an example of an object: its contents change over time as data is being added, removed, or changed. Anything that is part of that file, or has been part of it, in whatever form, is part of the contents of the object. **This may include other objects as well**. 
An object ''John's age'' may have contents ''23''. Six months later, the contents may have changed into ''24''.
Changes in contents of an object take place based on an event.

This specification describes an administration of events that allow the contents of objects in the past to be reconstructed. In this sense, the functionality closely resembles that of version management systems such as 
Subversion (also know as SVN), or Apple's time machine.-}

-- [Versions]

CONCEPT Version "the relative age of Contents of an Object with respect to other Contents of that Object." ""
PURPOSE CONCEPT Version IN DUTCH
{+Omdat de waarde van een object in de tijd kan veranderen, spreken we van de relatieve leeftijd van inhouden.
Omdat elke verandering optreedt aan de hand van een event, en gebeurtenissen elkaar opvolgen, kunnen we de relatieve leeftijd uitdrukken als versienummer.
Het begrip version is daarvoor bedoeld.-}
PURPOSE CONCEPT Version IN ENGLISH
{+Because the Contents of an Object can change over time and we want to speak about the Contents of an Object at some point in time in the past, we need to distinguish between the various Contents that once were contained within that Object. One way of doing this is by introducing Versions, i.e. indicators that are simply distinguishable from one another, and having some ordering by which it is possible to tell which of two versions is the more recent (or older) one. Thus, Versions are an expression of relative age.+}

KEY keyContents: Contents(object,version)
--RULE keyContents: object;object~ /\ version;version~ |- I
--  MEANING "De contents van een object is uniek gekarakteriseerd door het versienummer. Dat wil zeggen: als het object en het versienummer vastliggen, dan is er Ã©Ã©n contents (of er is geen contents)."
--  MEANING "When the object and version number is known, any object is uniquely determined. Note the difference with 'object', which identifies the most recent version of an object."

isSuccessorOf :: Version * Version [INJ,IRF,ASY] PRAGMA "" "is the (direct) successor of"
PURPOSE RELATION isSuccessorOf IN DUTCH
{+Om vast te kunnen stellen dat van een een stuk object-geschiedenis geen enkele verandering ontbreekt, moeten we de opeenvolging van object inhouden kunnen natrekken. Dat doen we door expliciet de volgorde van versienummers vast te stellen. Merk op van elke version vastgesteld moet kunnen worden wat zijn **voorganger** is, en niet per se wat zijn opvolger is - multirealiteit staat immers wel toe dat een contents meerdere consecutieve opvolgers kan hebben, maar niet dat een contents door meerdere andere inhouden kan worden voorafgegaan.+}
PURPOSE RELATION isSuccessorOf IN ENGLISH
{+Since Versions express the relative age of two Contents of a single Object, is is necessary that any time the contents of an Object changes, a Version can be assigned to this new Contents that can be characterized as the successor of the Version of the old Contents. This allows the logical deduction that if a version of a Contents of an Object is the successor of the version of a Contents of the same Object, then the first Contents is the successor of the second Contents as well.+}

isMoreRecentThan :: Version * Version [IRF,ASY,TRN] PRAGMA "" "is more recent than".
PURPOSE RELATION isMoreRecentThan IN DUTCH
{+Versies hebben zin zolang we kunnen vaststellen voor elk tweetal versies welk van de twee recenter is.
Daarom bestaat een relatie "isMoreRecentThan".
Stel bijvoorbeeld dat de contents van het object ``adres_van_Jan`` op 23 januari jongstleden ``Dorpsstraat 49`` was.
Een week later was de contents van datzelfde object ``Zwerk 102``.
We zeggen nu dat de laatstgenoemde contents recenter is dan de eerstgenoemde.
-}
PURPOSE RELATION isMoreRecentThan IN ENGLISH
{+Versions are meaningful to the extent that we can assess which of two versions is the more recent one. The relation 'isMoreRecentThan' models such assessments. As an example, version 'q4sy' of the contents of object 'Address_of_John' is 'Dorpsstraat 49', and version xyqu of that same object is 'Zwerk 102'. If ('xyqu','q4sy') is a Link in the relation 'isMoreRecentThan', then of the two addresses of John, 'Zwerk 102' is the most recent one.
-}

RULE "more recent versions": (I[Version] \/ isMoreRecentThan);isSuccessorOf~ |- isMoreRecentThan
MEANING "A Version is more recent than another Version iff there is a chain of succesive Versions that leads from the older Version to the more recent one."

-- [Objects and Contents]

CONCEPT Contents "the substance contained in something (an Object) at a given point in time." ""
PURPOSE CONCEPT Contents IN DUTCH
{+Door expliciet over contents te spreken,
hoeven we nog niet vast te leggen of deze contents bestaat uit een enkel gegeven of een complexe structuur van gegevens.
Voor historie is slechts van belang dat een contents bestaat.
Daarom spreken we over: ``contents''
als een op zichzelf staand begrip.-}
PURPOSE CONCEPT Contents IN ENGLISH
{+By explicitly talking about Contents, we need not define whether the Contents consists of a single data element, or a complex set of (un)structured data. For historic purposes, it only matters that a contents exists, and that's the reason we talk about 'Contents' as a term in its own right.+}
GEN Contents ISA Set

CONCEPT Object "something containing Contents." ""
PURPOSE CONCEPT Object IN DUTCH
{+Het is van belang om inhoud te scheiden van datgene dat die inhoud bevat. Tegelijk moeten we wel kunnen spreken over datgene dat die inhoud bevat, zoals we niet alleen over wijn willen kunnen spreken maar ook over de ton, de fles of het glas waar het in zit. De term 'Object' introduceren we als een generieke term voor elk ding dat een inhoud bevat. Merk op dat net zoals glazen in een doos kunnen zitten (en dan inhoud van de doos zijn), elk glas drank kan bevatten en op die titel dan weer object is.+}
PURPOSE CONCEPT Object IN ENGLISH
{+An impportant distinction is that between contents and the object containing it. We use the term 'Object' to generically refer to anything that has a contents. For example, wine can be contained in a glass, a bottle, a barrel and more, each of the latter then being an object. Note however that glasses, too, can be contained in e.g. a box, in which case they are Contents of the box, although they themselves may also be an Object iff they have a contents.+}

object :: Contents -> Object PRAGMA "" "is contained in " "".
PURPOSE RELATION object IN DUTCH
{+Als we zeggen dat een contents bij een object hoort,
dan bedoelen we dat dat object ooit deze contents heeft gehad.
Oudere versies van die contents moeten bewaard blijven.
-}
PURPOSE RELATION object IN ENGLISH
{+If we say that a Contents belongs to an Object, 
we mean that there was a time (that may or may not be the current time)
that the Contents was the actual contents of that Object.
Thus, older versions of the Contents remain registered.
-}

contents :: Object -> Contents PRAGMA "The current Contents of " " is "
PURPOSE RELATION contents IN DUTCH
{+Deze contents kan vervangen worden, waarbij het object een volgend versienummer krijgt.
We willen dan dat het object te allen tijde naar het jongste object verwijst.-}
PURPOSE RELATION contents IN ENGLISH
{+At any point in time, every Object has a single Contents. However, as the Contents of an Object may change in the course of time, we have a need to identify the most recent (actual, youngest) version of that contents - the current contents.+}

--!Rules that model the kind of content-inheritance described in the below PURPOSEs remain to be discussed and formulated.
isaContents :: Object * Contents [UNI] PRAGMA "" " is a " " because it is contained in some Object"
PURPOSE RELATION isaContents IN DUTCH
{+Een object kan zelf deel uitmaken van de inhoud van een ander object. Dat is bijvoorbeeld het geval bij hoofdstukken die deel uitmaken van de inhoud van een document, of documenten die deel uitmaken van de inhoud van een map of dossier. Als de inhoud van een hoofdstuk verandert, dan verandert daarmee ook de inhoud van het document dat die inhoud bevat en ook van de map (het dossier) dat dit document bevat.+}
PURPOSE RELATION isaContents IN ENGLISH
{+An Object may be part of the Contents of another Object. For example, a chapter may be part of the Contents of a document, or documents may be part of the contents of a file. If the Contents of a chapter changes, then so does the Contents of any document containing this chapter, and so does the Contents of any file containing this document.+}

version :: Contents -> Version PRAGMA "The version of " "is".
PURPOSE RELATION version IN DUTCH
{+Om de tijdsvolgorde te registreren krijgt elke contents een versienummer.
-}
PURPOSE RELATION version IN ENGLISH
{+Contents are assigned a Version that represents the time the Contents was assigned to its Object. Verions can be ordered in the same order as the timestamps are odered that they represent.
-}

RULE "actual content": version~;object;contents;version |- isMoreRecentThan \/ I[Version]
PURPOSE RULE "actual content" IN DUTCH
{+Op elk moment moet een object verwijzen naar zijn actuele contents.
Daarom verwijst de relatie 'contents' naar de meest recente contents van een object.-}
PURPOSE RULE "actual content" IN ENGLISH
{+On any given moment in time, an object must refer to its most recent contents.
That is why the relation 'contents' (contents) points to the most recent contents of an object."-}

-- [Events/Changing the Contents of Objects]

CONCEPT CommitEvent "an event that is the direct cause of some (versioned) change in one or more Contents"
PURPOSE CONCEPT CommitEvent IN DUTCH
{+De term 'CommitEvent' gebruiken we om gebeurtenissen die resulteren in veranderingen in objecten te kunnen onderscheiden van events die dat niet doen.+}
PURPOSE CONCEPT CommitEvent IN ENGLISH
{+The term 'CommitEvent' is defined to enable events that do not result in (versioned) changes in a Contents to be distinguished from other events.+}
GEN CommitEvent ISA Event

pre :: CommitEvent * Contents PRAGMA "" "has changed " "into another contents"
PURPOSE RELATION pre[CommitEvent*Contents] IN DUTCH
{+Verandering aan een object vindt plaats op basis van een event.
Deze event noemen we de aanleiding van de verandering.
Stel ``g`` is een event, die een verandering teweeg brengt in object ``o``,
dan geven we de contents voorafgaand aan ``g`` aan als ``pre[CommitEvent*Contents](o)`` en de contents na afloop van ``g`` als ``post[CommitEvent*Contents](o)``
-}
PURPOSE RELATION pre[CommitEvent*Contents] IN ENGLISH
{+Changing an object occurs on the basis of an event.
We way that this event induces the change.
Let ``g`` be an event that changes object ``o``.
The contents of ``o`` before ``g`` occurs is identified by ``pre[CommitEvent*Contents](o)``.
-}

post :: CommitEvent * Contents PRAGMA "" "has changed some contents into "
PURPOSE RELATION post[CommitEvent*Contents] IN DUTCH
{+Gebeurtenissen kunnen de contents van een object veranderen, maar dat hoeft natuurlijk niet.
Gebeurtenissen kunnen immers ook aanleiding zijn om de contents alleen maar te bekijken/inspecteren.-}
PURPOSE RELATION post[CommitEvent*Contents] IN ENGLISH
{+When an event occurs, it may change an object.
The contents of ``o`` after event ``g`` has occured is identified by ``post[CommitEvent*Contents](o)``.
-}

RULE "change from a single Contents": pre[CommitEvent*Contents]~;pre[CommitEvent*Contents] /\ object;object~ |- I[Contents]
MEANING "Any CommitEvent that changes the Contents of an Object shall change a single Contents of that Object."
PURPOSE RULE "change from a single Contents" IN DUTCH
{+Omdat CommitEvents meerdere inhouden kan doen veranderen, moeten we voor elk CommitEvent afdwingen dat voor elk object waarvan een inhoud door dat CommitEvent is veranderd, deze verandeging heeft plaatsgevonden op precies 1 Contents van dat object.+}
PURPOSE RULE "change from a single Contents" IN ENGLISH
{+Because CommitEvents can change multiple Contents, it shall be enforced that every CommitEvent that has changed the Contents of an Object, is based on precisely one Contents of that Object.+}

RULE "change into a single Contents": post[CommitEvent*Contents]~;post[CommitEvent*Contents] /\ object;object~ |- I[Contents]
MEANING "Any CommitEvent that changes the Contents of an Object shall result in a single Contents for that Object."
PURPOSE RULE "change into a single Contents" IN DUTCH
{+Omdat CommitEvents meerdere inhouden kan doen veranderen, moeten we voor elk CommitEvent afdwingen dat voor elk object waarvan een inhoud door dat CommitEvent is veranderd, deze verandeging heeft geresulteerd in precies 1 Contents van dat object.+}
PURPOSE RULE "change into a single Contents" IN ENGLISH
{+Because CommitEvents can change multiple Contents, it shall be enforced that every CommitEvent that has changed the Contents of an Object, has resulted in precisely one Contents of that Object.+}

RULE "commitEvents change Contents": pre[CommitEvent*Contents]~;post[CommitEvent*Contents] /\ object;object~ |- -I[Contents]
MEANING "Any CommitEvent on (the Contents of) an Object causes the Contents of that Object to be actually changed."
PURPOSE RULE "commitEvents change Contents" IN DUTCH
{+CommitEvents zijn gedefinieerd als gebeurtenissen die de inhoud van een object daadwerkelijk veranderen. Deze eigenschap moet worden afgedwongen.+}
PURPOSE RULE "commitEvents change Contents" IN ENGLISH
{+CommitEvents are defined as events that change the Contents of Objects. This property should be enforced.+}

RULE "successive versions": pre[CommitEvent*Contents]~;post[CommitEvent*Contents] /\ object;object~ |- version;isSuccessorOf~;version~
MEANING "If some CommitEvent has changed the Contents of an Object, the new Contents must be assigned a Version that is the successor of the Version of the changed Contents."
--MEANING "Als door het optreden van een event de contents van een object is veranderd, dan is de version van de nieuwe contents gelijk aan de opvolger van de version van de oude contents."
PURPOSE RULE "successive versions" IN DUTCH
{+Van elke contents wordt een version bijgehouden, om voor gebruikers de leeftijd ten opzichte van andere inhouden zichtbaar te maken. Als een contents verandert, krijgt die een opvolgende version toegekend.+}
PURPOSE RULE "successive versions" IN ENGLISH
{+Successive changes in Contents must be assigned successive Versions in order for Versions to be used as a true expression of relative age of these Contents.+}

-- [Traversing through historical contents]

isPredecessorOf :: Contents * Contents [UNI,ASY,IRF] PRAGMA "" "is the direct predecessor of ".
PURPOSE RELATION isPredecessorOf IN DUTCH
{+Om te kunnen natrekken hoe de contents van een object tot stand is gekomen moet een ononderbroken ketting van inhouden kunnen worden geconstrueerd, voor zover de geschiedenis is opgeslagen.+}

RULE "preceeding contents": isPredecessorOf = post[CommitEvent*Contents]~;pre[CommitEvent*Contents] /\ version;isSuccessorOf;version~ /\ object;object~
MEANING "Contents X is the predecessor of contents Y iff both contents belong to the same Object and there is a CommitEvent in which X was transformed into Y."
-- MEANING "Contents X is de voorganger van contents Y dan en slechts dan als beiden bij hetzelfde Object horen en er een CommitEvent is waarin X werd getransformeerd in Y."
PURPOSE RULE "preceeding contents" IN DUTCH
{+Van elke contents moet traceerbaar zijn volgens welk pad van bewerkingen/veranderingen die contents tot stand is gekomen.
Daartoe moet van elke contents diens directe voorganger bekend zijn.
Deze directe voorganger is de contents die middels een enkele bewerking
werd getransformeerd in de contents waarvan het de voorganger is.
Echter, omdat bewerkingen meerdere inhouden kunnen transformeren,
moet de version van de contents ook volgen op die van diens voorganger.
Beide inhouden moeten hetzelfde object betreffen.-}
PURPOSE RULE "preceeding contents" IN DUTCH
{+For every Contents the path of operations/changes must be traceable by which the current contents has come into existence. Thus, for every Contents C its (direct) predecessor must be known. This predecessor is the contents that belonged to the same Object as C, and was transformed into C by a single CommitEvent. However, since CommitEvents are capable of changing the contents of mulitple Objects, the Version of the contents must also be successive.+}

--!Het zou handig zijn als de onderstaande relatie middels bijv. preprocessing zou kunnen worden gedefinieerd
--isSuccessorOf :: Contents * Contents RULE "succeeding contents": isSuccessorOf = isPredecessorOf

isDescendantOf :: Contents * Contents [IRF,ASY] PRAGMA "" "is one of the (in)direct successors of ".
PURPOSE RELATION isDescendantOf IN DUTCH
{+Om te kunnen natrekken hoe de contents van een object tot stand is gekomen,
moet een ononderbroken ketting van inhouden kunnen worden geconstrueerd,
voor zover de geschiedenis is opgeslagen.-}
PURPOSE RELATION isDescendantOf IN ENGLISH
{+In order to be able to trace the Contents of an Object to its source, an uninterrupted chains of Contents must be constructed, insofar as this is registered.+}

RULE "historical path": isPredecessorOf~;(I \/ isDescendantOf) |- isDescendantOf
MEANING "Contents Y is een indirecte opvolger van contents X als er een of meer gebeurtenissen zijn waarin X werd getransformeerd in Y en vice versa."
PURPOSE RULE "historical path" IN DUTCH
{+Een historische registratie wordt geacht alleen die inhouden te bevatten
die deel uitmaken van de geschiedenis van de verzameling inhouden van het actuele moment.
Daarom moet van elke contents kunnen worden vastgesteld dat tenminste 1 contents bestaat,
die actueel is voor het huidige moment en die een (indirecte) opvolger is van deze (eerste) contents.-}
PURPOSE RULE "historical path" IN ENGLISH
{+A historical registration must only contain Contents that are part of the history of any Object contained in the registration (up to the point in time that the registration retains such information. Therefore, for every registered Contents it must be ascertained that the Object it belongs to has a current Contents that is the (indirect) successor tof this registered Contents.+}

-- [Changes (Deltas) in the historical registration]

RULE "changelog": changed = (pre[CommitEvent*Contents] /\ post[CommitEvent*Contents];-I);object /\ (post[CommitEvent*Contents] /\ pre[CommitEvent*Contents];-I);object
PURPOSE RULE "changelog" IN DUTCH
{+In de 'changelog' kan van elke event die geleid heeft tot inhoudelijke veranderingen
worden vastgesteld welke objecten dat betrof.
Ook omgekeerd kan van elk object worden teruggevonden
welke gebeurtenissen hebben geleid tot inhoudelijke veranderingen in het object.-}
PURPOSE RULE "changelog" IN ENGLISH
{+The 'changelog' can be used to determine which CommitEvents changed what Objects. This works both ways: given a CommitEvent, the changelog produces the set of Objects that have been changed by it; given an Object, it produces the set of CommitEvents that have changed the Objects Contents over time.+}

changed :: CommitEvent * Object PRAGMA "" " caused the Contents of " " to be changed"
PURPOSE RELATION changed IN ENGLISH
{+Keeping track of which CommitEvents changed what Object Contents allows us to audit changes in registries.+}
PURPOSE RELATION changed IN DUTCH
{+Het bijhouden van welke CommitEvents veranderingen veroorzaakten in welke Objecten stelt ons in staat veranderingen in registraties te auditeren.+}

ENDPATTERN