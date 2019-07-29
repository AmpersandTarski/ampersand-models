PATTERN BusinessFunctions
-- Author(s): rieks.joosten@tno.nl
--!RJ: This pattern is ready for review/publication
PURPOSE PATTERN BusinessFunctions IN ENGLISH
{+In order for a person to be responsible (accountable) and be 'in control' over some scope, (s)he must oversee it, implying that this scope should be small enough. Since people are human, every of their tasks should meet Anderson's 'cope-ability criterion' [Anderson]_, which states that if humans are required to oversee anything more complex than some 5 (give or take 2) concepts, they start to err. This pattern provides the basics that enable scoping within (or across) organizations such that Anderson's cope-ability criterion can be met.+}
PURPOSE PATTERN BusinessFunctions IN DUTCH
{+Wie verantwoordelijk is voor, c.q. 'in control' wil zijn over een zekere scope (afbakening), moet deze kunnen overzien. Dat impliceert dat deze afbakening klein genoeg moeten zijn. Immers, voor alle mensen geldt Anderson's 'behapbaarheidscriterium' Anderson]_, die zegt dat als mensen taken uitvoeren die overzicht vereisen over meer dan 5 concepten (plus of min 2), ze fouten gaan maken. Dit pattern levert de basisingredienten voor het maken van afbakeningen door organisaties heen zodanig dat aan Anderson's behapbaarheidscriterium kan worden voldaan.+}
-----------------------------------------------------------------------
{- Revision history
RJ/20110323 - Documentary modifications, introducing the idea of a business function
RJ/20110220 - "Techneutenweekend-changes"
RJ/20101207 - Explanation stuff in both English and Dutch (draft)
RJ/20101206 - Obligations/Expectations are concepts both of which ISA BusinessRule
RJ/20101120 - Used by PolicyMgt, RISC
RJ/20100916 - Documentation update
RJ/20100803 - distinction between obligation rules and expectation rules.
RJ/20100729 - Created BusinessFunctions pattern (split off from PolicyMgt)
-}
-----------------------------------------------------------------------
-- Markup uses `reStructuredTexts <http://docutils.sourceforge.net/docs/user/rst/quickref.html>`__

CONCEPT BFManager "a person that is accountable for realizing the business function as specified by a set of obligations."
PURPOSE CONCEPT BFManager IN ENGLISH
{+Within societies, organisations etc. is must be possible to assign responsibilities to people for providing a business function.+}
PURPOSE CONCEPT BFManager IN DUTCH
{+In een maatschappij, organisatie etc. moet het mogelijk zijn om mensen verantwoordelijk te maken voor het uitvoeren van een (bedrijfs)functie.+}
CONCEPT BusinessFunction "a scope ('afbakening' in Dutch) whose purpose is to fulfill c.q. maintain a set of rules, called the obligations of that scope."
PURPOSE CONCEPT BusinessFunction IN ENGLISH
{+The purpose of a BusinessFunction is to demarcate the scope of control of a (set of) person(s) (that are collectively referred to as 'BFManager') that allows them to fulfill, or abide by a set of rules that they decided to commit to (comply with) for this particular scope. Hence, every individual state, province, municipality, organization, company, department, community, family, person, process, system, network, etc.can be considered a BusinessFunction.+}
PURPOSE CONCEPT BusinessFunction IN DUTCH
{+Het doel van een bedrijfsfunctie is om een 'scope of control' af te bakenen van een (verzameling) perso(o)n(en) (die gezamenlijk worden aangeduid met de term BFManager') welke hen in staat stellen om een verzameling regels vast te stellen die zij zich verplichten na te leven c.q. te vervullen, althans binnen deze afbakening. Dat maakt elke staat, provincie, gemeente, organisatie, bedrijf, afdeling, gemeenschap, gezin, persoon, proces, systeem, netwerk, enz. een bedrijfsfunctie."+}
-- Onderstaandbedoelde wikipedialink is: `WikiPedia <http://en.wikipedia.org/wiki/Holon_%28philosophy%29>`_
PURPOSE CONCEPT BusinessFunction IN ENGLISH
{+In order for a party (government, company, parts thereof or individuals) to be(come) accountable, it must be aware of its

- span of control (scope);
- obligations towards others and itself;
- expectations, both of the world, other organizations and itself.

The term BusinessFunction [#BusinessFunction]_ is used as the conceptual anchor that identifies the rules that constitute obligations (and expectaions) of a scope (of control). 

.. [#BusinessFunction] Our use of this term is loosely inspired on  the contents found at <http://en.wikipedia.org/wiki/Holon_%28philosophy%29>`_

One idea behind BusinessFunctions is that it provides a scope within which work becomes manageable for humans; this allows people to focus on only that part of all the work that is 'inside scope'. This is necessary in order to stay within the intrinsic human limitations as referred to e.g. by [Anderson]_.

Examples of (our) BusinessFunctions are:

- a military patrol in a UN mission in Uruzgan (e.g. having been assigned the task of trying to find roadbombs);
- a financial department of an enterprise;
- a process whose aim it is to get all bills paid for orders of stocked items;
- a system whose purpose it is to deliver documents upon request;
- a person who wants to live a life in luxury;

All BusinessFunctions have in common that there is a set of rules that they are committed to comply with. These 'obligations' (or 'rules-of-engagement'), specific for each BusinessFunction, define (and constrain) the work that is done within (the scope of) a BusinessFunction. Thus, a BusinessFunction should be able to report on the level of compliance to these rules. Also, a BusinessFunction may want to assess the risk involved by non-compliance. Examples of obligations for BusinessFunctions are:

- the military patrol may have a rule 'firing shall not be done on civilians';
- the financial department may have a rule 'income shall exceed expenses by at least 10%';
- the process may have a rule 'unpaid bills sent more than 4 weeks ago shall be handed over to an incasso bureau';
- the system may have a rule 'documents shall only be sent to subscribers';
- the person may have a rule 'I must not do anything that may harm other people'.

All BusinessFunctions also have in common that there is a set of rules that they expect to be complied with, either by other BusinessFunctions, by themselves, or by nature (G.O.D. = a Gathering Of Deities). These 'expectations' are the consequence of acknowledging that no BusinessFunction can do everything all by itself. It is useful for a BusinessFunction to know its expectations (and from whom this is expeced) so that it can verify whether or not its expectations are being met, and take action if this is not the case.
-}
PURPOSE CONCEPT BusinessFunction IN DUTCH
{+Om verantwoordelijk (accountable) te kunnen zijn moet een organisatie zich bewust zijn van zijn

- 'span of control' (scope);
- verplichtingen jegens anderen en zichzelf;
- verwachtingen, zowel naar de wereld, andere organisaties en zichzelf.

We gebruiken de term bedrijfsfunctie [#bedrijfsfunctie]_ als conceptueel anker dat de regels identificeert die de verplichtingen en verwachtingen zijn ten aanzien van een zekere 'scope of control'. 

.. [#bedrijfsfunctie] Ons gebruik van deze term is losjes geinspireerd op de inhoud van  <http://en.wikipedia.org/wiki/Holon_%28philosophy%29>`_

EÃ©n idee achter bedrijfsfuncties is dat het een afbakening (scope) levert waarbinnen werk beheersbaar wordt voor mensen. Mensen kunnen zo hun aandacht richten op dat waar daarbinnen valt en al het andere (tijdelijk) buitensluiten). Dit is nodig om binnen de intrinsiek menselijke begrenzingen te blijven zoals onder meer door [Anderson]_ zijn opgeschreven.

Voorbeelden van (onze) bedrijfsfuncties zijn:

- een militaire patrouille op een VN missie in Uruzgan (die bijvoorbeeld de taak heeft gekregen om bermbommen op te sporen en te vernietigen);
- de financiele afdeling van een onderneming;
- een proces waarin wordt gezorgd dat uitstaande rekeningen worden betaald;
- een systeem die op verzoek documenten beschikbaar maakt;
- een persoon die een luxueus leven wil leiden.

Alle bedrijfsfuncties hebben gemeenschappelijk dat er een verzameling regels is waarop de verplichting rust ze waar te maken/houden. Deze 'verplichtingen' (of 'rules-of-engagement') zijn specifiek voor elke bedrijfsfunctie; ze definieren (en begrenzen) het werk dat binnen (de 'scope of control' van) een bedrijfsfunctie wordt gedaan. bedrijfsfuncties moeten dus kunnen rapporteren over de mate van compliance aan hun verplichtingen. Ook moeten zij het risico kunnen inschatten dat het gevolg is van non-compliance. Voorbeelden van verplichtingen zijn:

- voor de militaire patrouille: 'op burgers mag niet worden gevuurd';
- de financiele afdeling: 'elk jaarinkomen van de organisatie moet tenminste 10% hoger zijn dan alle gezamenlijke uitgaven van datzelfde jaar';
- het proces: 'onbetaalde rekeningen die langer dan 4 weken geleden zijn verstuurd moeten worden overgedragen aan een incassobureau';
- het systeem: 'documenten mogen alleen beschikbaar worden gemaakt aan abonnees';
- de persoon: 'ik mag niets doen dat anderen benadeelt.'.

Alle bedrijfsfuncties hebben gemeenschappelijk dat er een verzameling regels is waarvan wordt verwacht dat ze waar gemaakt zullen worden, hetzij door andere bedrijfsfuncties, hetzij door zichzelf, of door de natuur (G.O.D. = 'Gathering Of Deities'). Deze 'verwachtingen' zijn het gevolg van de erkenning binnen een bedrijfsfunctie dat deze niet alles zelf, d.w.z. binnen de eigen 'span of control' kan doen. Het is nuttig voor een bedrijfsfunctie om diens verwachtingen te kennen (en van wie dit wordt verwacht) zo dat kan worden getoetst of deze verwachtingen uitkomen en om actie te kunnen ondernemen als dat niet zo blijkt te zijn. 
-}

bfManager :: BusinessFunction -> BFManager PRAGMA "The set of people, each of which is accountable for complying with all obligations of " " is referred to as ".
PURPOSE RELATION bfManager IN ENGLISH
{+Accountability for compliance with obligations of a BusinessFunction, for the commitment to such obligations and decisions about what to expect (expectations), must be explicitly assigned. To that end, the role of 'BFManager' is introduced as a placeolder for the person(s) that actually bear the accountability.+}
PURPOSE RELATION bfManager IN DUTCH
{+De verantwoordelijkheid voor het naleven van de verplichtingen van een bedrijfsfunctie, voor het aangaan van commitments (verplichtingen) en het opstellen van verwachtingen, moet uitdrukkelijk zijn belegd. De rol van 'BFManager' is ingevoerd als 'placeholder' voor de perso(o)n(en) die deze verantwoordelijkheid dragen voor de betreffende bedrijfsfunctie.+}

-- Holarchies
isSuperBFOf :: BusinessFunction * BusinessFunction [ASY,IRF] PRAGMA "" " is a parent-BusinessFunction of ".
PURPOSE RELATION isSuperBFOf IN ENGLISH
{+In order to accommodate hierarchies (also called holarchies), a parent-child relation must be available. Note that BusinessFunctions can be part of multiple holarchies. For example, the financial department of an international company is not only part of the companyhierarchy, but also of a judicial hierarchy (since countries have different laws) and a financial hierarchy (it may be member of an international financial organization that makes rules for financial institutions.+}
PURPOSE RELATION isSuperBFOf IN DUTCH
{+Om bedrijfsfunctie hierarchien (holarchieen) te kunnen modeleren is een 'ouder-kind' relatie nodig. Merk op dat bedrijfsfuncties deel kunnen uitmaken van meerdere holarchien. Zo zal bijvoorbeeld de financiele afdeling van een internationaal bedrijf niet alleen deel uitmaken van de berijfshierarchie, maar ook van een juridische hierarchie (omdat verschillende landen verschillende financiele wetgeving hebben) en in een financiele hierarchie (bijvoorbeeld een internationale organisatiestructuur waarin regels worden gemaakt die aan financiele instellingen worden opgelegd.+}

RULE "superBFs": isAncestorOf /\ isAncestorOf~ = -V 
MEANING "BusinessFunctions cannot be their own parents (or their own children) in the same way that people are not their own children or parents."
PURPOSE RULE "superBFs" IN ENGLISH
{+BusinessFunctions cannot be their own parents (or their own children) in the same way that people are not their own children or parents.+}
PURPOSE RULE "superBFs" IN DUTCH
{+Net zoals bij mensen kan een bedrijfsfunctie noch zijn eigen ouder zijn, noch zijn eigen kind.+}

isAncestorOf :: BusinessFunction * BusinessFunction PRAGMA "" " is an indirect superBF (ancestor) of".
RULE "businessFunction ancestors": (I \/ isAncestorOf); isSuperBFOf |- isAncestorOf
MEANING "The set of ancestors of a BusinessFunction consists of its parents as well as all ancestors of these parents." 

ENDPATTERN
---------------------------------------------------------------------