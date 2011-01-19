PATTERN Holons -- WIJZIGER: rieks.joosten@tno.nl
PURPOSE PATTERN Holons IN ENGLISH
{+In order for a manager to 'be in control', (s)he must oversee its 'scope of control', implying that this should be small enough. Since managers are humans, every of their tasks should meet Anderson's 'cope-ability criterion' [Anderson]_, which states that if humans are required to oversee anything more complex than some 5 (give or take 2) concepts, they start to err. This pattern provides the basics that enable scoping within (or across) organizations such that Anderson's cope-ability criterion can be met.-}
PURPOSE PATTERN Holons IN DUTCH
{+Om 'in control' te kunnen zijn vereist van managers dat ze hun 'scope of control' overzien en bijgevolg dat deze dan ook klein genoeg moeten zijn. Immers, managers zijn ook mensen waarvoor Anderson's 'behapbaarheidscriterium' geldt Anderson]_, die zegt dat als mensen taken uitvoeren die overzicht vereisen over meer dan 5 concepten (plus of min 2), ze fouten gaan maken. Dit pattern levert de basisingredienten voor het maken van afbakeningen door organisaties heen zodanig dat aan Anderson's behapbaarheidscriterium kan worden voldaan.-}
-----------------------------------------------------------------------
{- Revision history
RJ/20101207 - Explanation stuff in both English and Dutch (draft)
RJ/20101206 - Obligations/Expectations are concepts both of which ISA Rule
RJ/20101120 - Used by PolicyMgt, RISC
RJ/20100916 - Documentation update
RJ/20100803 - distinction between obligation rules and expectation rules.
RJ/20100729 - Created holons pattern (split off from PolicyMgt)
-}
-----------------------------------------------------------------------
-- Markup uses `reStructuredTexts <http://docutils.sourceforge.net/docs/user/rst/quickref.html>`__

CONCEPT HolonManager "the set of people that are accountable for complying with all obligations of a Holon."
CONCEPT Holon "a scope ('afbakening' in Dutch) whose purpose is to fulfill c.q. maintain a set of rules, called the obligations of that scope."
PURPOSE CONCEPT Holon IN ENGLISH
{+The purpose of a Holon is to demarcate the scope of control of a (set of) person(s) (that are collectively referred to as 'HolonManager') that allows them to fulfill, or abide by a set of rules that they decided to commit to (comply with). Hence, every individual state, province, municipality, organization, company, department, community, family, person, process, system, network, etc.can be considered a Holon."-}
PURPOSE CONCEPT Holon IN DUTCH
{+Het doel van een Holon is om een 'scope of control' af te bakenen van een (verzameling) perso(o)n(en) (die gezamenlijk worden aangeduid met de term HolonManager') welke hen in staat stellen om een verzameling regels vast te stellen die zij zich verplichten na te leven c.q. te vervullen. Dat maakt elke staat, provincie, gemeente, organisatie, bedrijf, afdeling, gemeenschap, gezin, persoon, proces, systeem, netwerk, enz. een Holon."-}
-- Onderstaandbedoelde wikipedialink is: `WikiPedia <http://en.wikipedia.org/wiki/Holon_%28philosophy%29>`_
PURPOSE CONCEPT Holon IN ENGLISH
{+In order for an organization to be(come) accountable, it must be aware of its

- span of control (scope);
- obligations towards others and itself;
- expectations, both of the world, other organizations and itself.

We use the term Holon [#Holon]_ as the conceptual anchor that identifies the rules that constitute obligations or expections to (a part of) an scope of control. 

.. [#Holon] Our use of this term is loosely inspired on  the contents found at <http://en.wikipedia.org/wiki/Holon_%28philosophy%29>`_

One idea behind Holons is that it provides a scope within which work becomes manageable for humans; this allows people to focus on only that part of all the work that is 'inside scope'. This is necessary in order to stay within the intrinsic human limitations as referred to e.g. by [Anderson]_.

Examples of (our) holons are:

- a military patrol in a UN mission in Uruzgan (e.g. having been assigned the task of trying to find roadbombs);
- a financial department of an enterprise;
- a process whose aim it is to get all bills paid for orders of stocked items;
- a system whose purpose it is to deliver documents upon request;
- a person who wants to live a life in luxury;

All holons have in common that there is a set of rules that they are committed to comply with. These 'obligations' (or 'rules-of-engagement'), specific for each holon, define (and constrain) the work that is done within (the scope of) a holon. Thus, a holon should be able to report on the level of compliance to these rules. Also, a holon may want to assess the risk involved by non-compliance. Examples of obligations for holons are:

- the military patrol may have a rule 'firing shall not be done on civilians';
- the financial department may have a rule 'income shall exceed expenses by at least 10%';
- the process may have a rule 'unpaid bills sent more than 4 weeks ago shall be handed over to an incasso bureau';
- the system may have a rule 'documents shall only be sent to subscribers';
- the person may have a rule 'I must not do anything that may harm other people'.

All holons also have in common that there is a set of rules that they expect to be complied with, either by other holons, by themselves, or by nature (G.O.D. = a Gathering Of Deities). These 'expectations' are the consequence of acknowledging that no holon can do everything all by itself. It is useful for a holon to know its expectations (and from whom this is expeced) so that it can verify whether or not its expectations are being met, and take action if this is not the case.
-}
PURPOSE CONCEPT Holon IN DUTCH
{+Om verantwoordelijk (accountable) te kunnen zijn moet een organisatie zich bewust zijn van zijn

- 'span of control' (scope);
- verplichtingen jegens anderen en zichzelf;
- verwachtingen, zowel naar de wereld, andere organisaties en zichzelf.

We gebruiken de term Holon [#Holon]_ als conceptueel anker dat de regels identificeert die de verplichtingen en verwachtingen zijn ten aanzien van een zekere 'scope of control'. 

.. [#Holon] Ons gebruik van deze term is losjes geinspireerd op de inhoud van  <http://en.wikipedia.org/wiki/Holon_%28philosophy%29>`_

Eén idee achter Holons is dat het een afbakening (scope) levert waarbinnen werk beheersbaar wordt voor mensen. Mensen kunnen zo hun aandacht richten op dat waar daarbinnen valt en al het andere (tijdelijk) buitensluiten). Dit is nodig om binnen de intrinsiek menselijke begrenzingen te blijven zoals onder meer door [Anderson]_ zijn opgeschreven.

Voorbeelden van (onze) holons zijn:

- een militaire patrouille op een VN missie in Uruzgan (die bijvoorbeeld de taak heeft gekregen om bermbommen op te sporen en te vernietigen);
- de financiele afdeling van een onderneming;
- een proces waarin wordt gezorgd dat uitstaande rekeningen worden betaald;
- een systeem die op verzoek documenten beschikbaar maakt;
- een persoon die een luxueus leven wil leiden.

Alle holons hebben gemeenschappelijk dat er een verzameling regels is waarop de verplichting rust ze waar te maken/houden. Deze 'verplichtingen' (of 'rules-of-engagement') zijn specifiek voor elke holon; ze definieren (en begrenzen) het werk dat binnen (de 'scope of control' van) een holon wordt gedaan. Holonen moeten dus kunnen rapporteren over de mate van compliance aan hun verplichtingen. Ook moeten zij het risico kunnen inschatten dat het gevolg is van non-compliance. Voorbeelden van verplichtingen zijn:

- voor de militaire patrouille: 'op burgers mag niet worden gevuurd';
- de financiele afdeling: 'elk jaarinkomen van de organisatie moet tenminste 10% hoger zijn dan alle gezamenlijke uitgaven van datzelfde jaar';
- het proces: 'onbetaalde rekeningen die langer dan 4 weken geleden zijn verstuurd moeten worden overgedragen aan een incassobureau';
- het systeem: 'documenten mogen alleen beschikbaar worden gemaakt aan abonnees';
- de persoon: 'ik mag niets doen dat anderen benadeelt.'.

Alle holons hebben gemeenschappelijk dat er een verzameling regels is waarvan wordt verwacht dat ze waar gemaakt zullen worden, hetzij door andere holonen, hetzij door zichzelf, of door de natuur (G.O.D. = 'Gathering Of Deities'). Deze 'verwachtingen' zijn het gevolg van de erkenning binnen een holon dat deze niet alles zelf, d.w.z. binnen de eigen 'span of control' kan doen. Het is nuttig voor een holon om diens verwachtingen te kennen (en van wie dit wordt verwacht) zo dat kan worden getoetst of deze verwachtingen uitkomen en om actie te kunnen ondernemen als dat niet zo blijkt te zijn. 
-}

holonManager :: Holon -> HolonManager PRAGMA "The set of people, each of which is accountable for complying with all obligations of " " is referred to as ".

isParentOf :: Holon * Holon [ASY] PRAGMA "" " is a parent of ".
PURPOSE RELATION isParentOf IN ENGLISH
{+In order to accommodate hierarchies, a parent-child relation must be available. Since it is characteristic for holons to be part of multiple hierarchies (also called holarchies), we do not specify a multiplicity.-}
PURPOSE RELATION isParentOf IN DUTCH
{+Om hierarchien te kunnen modeleren is een ouder-kind relatie nodig. Multipliciteiten zijn niet gespecificeerd omdat het karakteristiek voor holons is om deel te kunnen zijn van meerdere hierarchien (ook: holarchien).-}

RULE "holons are not their own parents" MAINTAINS isParentOf |- -I
PURPOSE RULE "holons are not their own parents" IN ENGLISH
{+Holons cannot be their own parents (or their own children) in the same way that people are not their own children or parents.-}
PURPOSE RULE "holons are not their own parents" IN DUTCH
{+Net zoals bij mensen kan een holon noch zijn eigen ouder zijn, noch zijn eigen kind.-}

ENDPATTERN