PATTERN Holons -- Author(s): rieks.joosten@tno.nl
--!RJ: This pattern is ready for review/publication
PURPOSE PATTERN Holons IN ENGLISH
{+In order for a person to be 'in control' over some scope, (s)he must oversee it, implying that this scope should be small enough. Since people are human, every of their tasks should meet Anderson's 'cope-ability criterion' [Anderson]_, which states that if humans are required to oversee anything more complex than some 5 (give or take 2) concepts, they start to err. This pattern provides the basics that enable scoping within (or across) organizations such that Anderson's cope-ability criterion can be met.-}
PURPOSE PATTERN Holons IN DUTCH
{+Wie 'in control' wil zijn over een zekere scope (afbakening), moet deze kunnen overzien. Dat impliceert dat deze afbakening klein genoeg moeten zijn. Immers, voor alle mensen geldt Anderson's 'behapbaarheidscriterium' Anderson]_, die zegt dat als mensen taken uitvoeren die overzicht vereisen over meer dan 5 concepten (plus of min 2), ze fouten gaan maken. Dit pattern levert de basisingredienten voor het maken van afbakeningen door organisaties heen zodanig dat aan Anderson's behapbaarheidscriterium kan worden voldaan.-}
-----------------------------------------------------------------------
{- Revision history
RJ/20110220 - "Techneutenweekend-changes"
RJ/20101207 - Explanation stuff in both English and Dutch (draft)
RJ/20101206 - Obligations/Expectations are concepts both of which ISA BusinessRule
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
{+The purpose of a Holon is to demarcate the scope of control of a (set of) person(s) (that are collectively referred to as 'HolonManager') that allows them to fulfill, or abide by a set of rules that they decided to commit to (comply with) for this particular scope. Hence, every individual state, province, municipality, organization, company, department, community, family, person, process, system, network, etc.can be considered a Holon.-}
PURPOSE CONCEPT Holon IN DUTCH
{+Het doel van een Holon is om een 'scope of control' af te bakenen van een (verzameling) perso(o)n(en) (die gezamenlijk worden aangeduid met de term HolonManager') welke hen in staat stellen om een verzameling regels vast te stellen die zij zich verplichten na te leven c.q. te vervullen, althans binnen deze afbakening. Dat maakt elke staat, provincie, gemeente, organisatie, bedrijf, afdeling, gemeenschap, gezin, persoon, proces, systeem, netwerk, enz. een Holon."-}
-- Onderstaandbedoelde wikipedialink is: `WikiPedia <http://en.wikipedia.org/wiki/Holon_%28philosophy%29>`_
PURPOSE CONCEPT Holon IN ENGLISH
{+In order for a party (government, company, parts thereof or individuals) to be(come) accountable, it must be aware of its

- span of control (scope);
- obligations towards others and itself;
- expectations, both of the world, other organizations and itself.

The term Holon [#Holon]_ is used as the conceptual anchor that identifies the rules that constitute obligations (and expectaions) of a scope (of control). 

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
PURPOSE RELATION holonManager IN ENGLISH
{+Accountability for compliance with obligations of a Holon, for the commitment to such obligations and decisions about what to expect (expectations), must be explicitly assigned. To that end, the role of 'holon manager' is introduced as a placeolder for the person(s) that actually bear the accountability.-}
PURPOSE RELATION holonManager IN DUTCH
{+De verantwoordelijkheid voor het naleven van de verplichtingen van een Holon, voor het aangaan van commitments (verplichtingen) en het opstellen van verwachtingen, moet uitdrukkelijk zijn belegd. De rol van 'holon manager' is ingevoerd als 'placeholder' voor de perso(o)n(en) die deze verantwoordelijkheid dragen voor de betreffende holon.-}

-- Holarchies
isSuperholonOf :: Holon * Holon [ASY,IRF] PRAGMA "" " is a direct superholon (parent) of ".
PURPOSE RELATION isSuperholonOf IN ENGLISH
{+In order to accommodate hierarchies (also called holarchies), a parent-child relation must be available. Note that holons can be part of multiple holarchies. For example, the financial department of an international company is not only part of the companyhierarchy, but also of a judicial hierarchy (since countries have different laws) and a financial hierarchy (it may be member of an international financial organization that makes rules for financial institutions.-}
PURPOSE RELATION isSuperholonOf IN DUTCH
{+Om Holon hierarchien (holarchieen) te kunnen modeleren is een 'ouder-kind' relatie nodig. Merk op dat holons deel kunnen uitmaken van meerdere holarchien. Zo zal bijvoorbeeld de financiele afdeling van een internationaal bedrijf niet alleen deel uitmaken van de berijfshierarchie, maar ook van een juridische hierarchie (omdat verschillende landen verschillende financiele wetgeving hebben) en in een financiele hierarchie (bijvoorbeeld een internationale organisatiestructuur waarin regels worden gemaakt die aan financiele instellingen worden opgelegd.-}

RULE "superholons": isAncestorOf /\ isAncestorOf~ = -V
PURPOSE RULE "superholons" IN ENGLISH
{+Holons cannot be their own parents (or their own children) in the same way that people are not their own children or parents.-}
PURPOSE RULE "superholons" IN DUTCH
{+Net zoals bij mensen kan een holon noch zijn eigen ouder zijn, noch zijn eigen kind.-}

isAncestorOf :: Holon * Holon PRAGMA "" " is an indirect superholon (ancestor) of".
RULE "holon ancestors": (I \/ isAncestorOf); isSuperholonOf |- isAncestorOf
PHRASE "The set of ancestors of a holon consists of its parents as well as all ancestors of these parents." 

ENDPATTERN
---------------------------------------------------------------------
PATTERN Obligations -- Author(s): rieks.joosten@tno.nl
--!RJ: This pattern is ready for review/publication

CONCEPT Obligation "a rule that a holon is committed to comply with."
PURPOSE CONCEPT Obligation IN ENGLISH
{+A rule becomes an obligation for a holon as soon as that holon is committed to comply with that rule.-}
PURPOSE CONCEPT Obligation IN DUTCH
{+Een regel wordt een verplichting voor een holon zodra de holon zich verplicht heeft de regel waar te maken c.q. na te leven.-}
GEN Obligation ISA Rule

obligationOf :: Obligation -> Holon PRAGMA "Compliance to " " is committed to by ".
PURPOSE RELATION obligationOf IN ENGLISH
{+Holons serve as scopes within which commitments exist to comply with rules.-} 
PURPOSE RELATION obligationOf IN DUTCH
{+Holons dienen als afbakeningen waarbinnen verplichtingen bestaan met betrekking tot het naleven c.q. voldoen aan specifieke regels.-}

RULE "obligation rules": obligationOf |- ruleScope
PURPOSE RULE "obligation rules" IN ENGLISH 
{+Any obligation within a Holon must be a rule that can (and hence: must) be interpretable/evaluatable within the scope of that Holon.-}
PURPOSE RULE "obligation rules" IN DUTCH 
{+Elke verplichting binnen een Holon moet een regel zijn die ook binnen diezelfde Holon kan (en dus ook: moet) worden geinterpreteerd c.q. geevalueerd.-}

obligedTo:: Obligation * Holon [TOT] PRAGMA "Compliance to " " is an obligation to ".
PURPOSE RELATION obligedTo IN ENGLISH
{+For appropriate governance, it is necessary that each holon identifies the holon(s) that it has obligations to. A holon can assign an obligation to itself, meaning that it has to organize work that ensures compliance with this rule. A holon can assign an obligation to another holon, meaning that it expects that other holon to hold it accountable for compliance with this rule. Any rule within a Holon for which no (other) Holon exists that demands compliance to be accounted for, is not considered an Obligation.-}
PURPOSE RELATION obligedTo IN DUTCH
{+Voor een goede governance is het nodig dat elke holon de (andere) holonen identificeert aan welke verplichtingen zijn gesteld. Een holon kan verplichtingen hebben ten aanzien van zichzelf, hetgeen betekent dat hij zichzelf verantwoordelijk houdt voor het nakomen ervan. Een holon kan verplichtingen hebben ten aanzien van andere holonen, hetgeen inhoudt dat het verwacht dat die andere holon hem verantwoordelijk houden voor het nakemon ervan. Een regel (van een zekere Holon) waarvan het nakomen door geen enkele Holon wordt vereist, geldt niet als een verplichting.-}

ENDPATTERN
---------------------------------------------------------------------
PATTERN Expectations -- Author(s): rieks.joosten@tno.nl
--!RJ: This pattern is ready for review/publication

CONCEPT Expectation "a rule that a holon expects compliance with."
PURPOSE CONCEPT Expectation IN ENGLISH
{+A rule becomes an expectation for a holon as soon as that holon expects the rule to be complied with (either by itself, another holon or G.O.D.[#G.O.D.]_

.. [#G.O.D.] We use the abbreviation 'G.O.D.' (Group of Deities) to indicate that an expectation is not directed to a specific holon. This is e.g. the case for expectations such as 'lightning strikes less than twice a year' or 'tomorrow, the sun will rise (again)'.
-}
PURPOSE CONCEPT Expectation IN DUTCH
{+Een regel wordt een verwachting voor een holon zodra die holon verwacht dat de regel waargemaakt c.q. nageleefd gaat worden; dit kan zijn door de holon zelf, een andere holon, of G.O.D.[#G.O.D.]_

.. [#G.O.D.] We gebruiken de afkorting 'G.O.D.' (Group of Deities) om mee aan te geven dat de verwachting niet aan een holon is gericht. Dat geldt bijvoorbeeld voor verwachtingen als 'het aantal blikseminslagen per jaar is minder dan 2' of 'morgen komt de zon (weer) op'.
-}

GEN Expectation ISA Rule

expectationOf  :: Expectation * Holon [UNI] PRAGMA "Compliance to " " is expected by ".
PURPOSE RELATION expectationOf[Expectation*Holon] IN ENGLISH
{+Holons serve as scopes within which expectations exist with respect to compliance with specific rules.-}
PURPOSE RELATION expectationOf[Expectation*Holon] IN DUTCH
{+Holons dienen als afbakeningen waarbinnen verwachtingen leven met betrekking tot compliance aan specifieke regels.-}

RULE "expectation rules": expectationOf |- ruleScope
PURPOSE RULE "expectation rules" IN ENGLISH
{+Any expectation within a Holon must be a rule that can (and hence: must) be interpretable/evaluatable within the scope of that Holon.-}
PURPOSE RULE "expectation rules" IN DUTCH
{+Elke verwachting binnen een Holon moet een regel zijn die ook binnen diezelfde Holon kan (en dus ook: moet) worden geinterpreteerd c.q. geevalueerd.-}

expectedFrom:: Expectation * Holon PRAGMA "Compliance to " " is expected from ".
PURPOSE RELATION expectationOf[Expectation*Holon] IN ENGLISH
{+For appropriate governance, it is necessary that each holon identifies the holon(s) that it assumes will comply with each of its expectations. A holon can assign an expectation to itself, meaning that it has to organize work that ensures compliance with this rule. A holon can assign an expectation to another holon, meaning that it expects that other holon to organize work that ensures compliance with this rule. Finaly, if a holon does not assign an expectation to a holon for doing the associated work, compliance with the rule is expected of G.O.D.[#G.O.D.]_, meaning that there is no person or organization that can be held accountable for compliance with this rule.
-}
PURPOSE RELATION expectationOf[Expectation*Holon] IN DUTCH
{+Voor een goede governance is het nodig dat elke holon de (andere) holonen identificeert aan welke verwachtingen zijn gesteld. Een holon kan verwachtingen hebben ten aanzien van zichzelf, hetgeen betekent dat binnen die holon het werk moet worden georganiseerd dat 'compliance' aan die verwachting verzekert. Een holon kan verwachtingen hebben ten aanzien van andere holonen, hetgeen inhoudt dat het verwacht dat die andere holon het werk organiseren dat 'compliance' aan die verwachting verzekert. Als een holon een verwachting heeft die niet gericht is aan zichzelf of een andere holon, dan zeggen we dat deze verwachting is ten aanzien van G.O.D.[#G.O.D.]_, hetgeen inhoudt dat geen enkele persoon of organisatie verantwoordelijk gehouden kan worden voor compliance aan die verwachting.-}

ENDPATTERN
---------------------------------------------------------------------
PATTERN "BusinessConscience" -- Author(s): rieks.joosten@tno.nl
--!RJ: This pattern is ready for review/publication

CONCEPT Gewetensvraag "a rule that is both an obligation and an expectation of a holon to itself" ""
PURPOSE CONCEPT Gewetensvraag IN ENGLISH
{+Every holon manager must decide how to fulfill its obligations towards other holons. Usually, this results in the holon manager defining rules that he expects its holon to fulfill, and assuming that he is coherent, this thus constitutes an obligation for the holon as well. This process continues until the holon manager has an expectation that is a truism, or it can be mapped onto one or more expectations to other holons. The registration of obligations and expectations that the holon manager has defined for the holon (s)he manages, serves as the holon's conscience for doing things.-}
PURPOSE CONCEPT Gewetensvraag IN DUTCH
{+Elke holon manager moet beslissen hoe zijn verplichtingen ten opzichte van andere holons na te komen. Om dit te doen zal de holon manager zijn verplicthingen 'vertalen' in verwachtingen naar de eigen holon en/of andere holons. Een vertaling naar de eigen holon levert een regel op die zowel een verplichting als een verwachting is ten aanzien van deze holon. Het doorvertalen van (de zo ontstane) verplichtingen gaat door totdat ofwel de verplichting een truisme (= waarheid als een koe) is, of totdat de verplichting kan worden vertaald naar een of meer verwachtingen naar (een) andere holon(en). De registratie van verplichtingen/verwachtingen aan de eigen holon noemen we het geweten van de holon; daarmee zijn deze verplichtingen/verwachtingen gewetensvragen voor die holon.-}

conscienceOf :: Gewetensvraag -> Holon PRAGMA "" " is part of the conscience of ".
PURPOSE RELATION conscienceOf IN ENGLISH
{+Awareness of all obligations/expectations that a holon has with respect to itself is a prerequisite for holon managers in order for them to be accountable.-}
PURPOSE RELATION conscienceOf IN DUTCH
{+Zich bewust zijn van alle verplichtingen/verwachtingen die een holon ten aanzien van zichzelf heeft, is een noodzakelijke voorwaarde voor holon managers om verantwoording te kunnen afleggen.-}

GEN Gewetensvraag ISA Obligation
oisa :: Obligation * Gewetensvraag [UNI] PRAGMA "" " is a "
RULE "obligationGewetensvragen": oisa = obligationOf;obligedTo~ PHRASE "Een verplichting is een gewetensvraag als de holon die de verplichting waar moet maken en de holon aan wie daarvoor verantwoordelijkheid moet worden afgelegd, dezelfde zijn."

GEN Gewetensvraag ISA Expectation
eisa :: Expectation * Gewetensvraag [UNI] PRAGMA "" " is a "
RULE "expectationGewetensvragen": eisa = expectationOf;expectedFrom~ PHRASE "Een verwachting is een gewetensvraag als de holon die de verwachting geacht wordt waar te maken en de holon die dit verwacht, dezelfde zijn."

RULE "gewetensvragen": I[Gewetensvraag]; oisa = I[Gewetensvraag]; eisa PHRASE "Voor alle gewetensvragen geldt dat ze zowel een verplichting als een verwachting zijn."
PURPOSE RULE "gewetensvragen" IN ENGLISH
{+The special case where a rule is both an obligation and an expectation of a holon to/from itself is important for a holon manager to get a grasp on. (to be extended)-}
PURPOSE RULE "gewetensvragen" IN DUTCH
{+Het geweten van een holon, d.w.z. de verzameling van al diens gewetensvragen, voorziet de holon manager van het overzicht van de besluiten die hij genomen heeft met betrekking tot de inrichting van zijn holon. Wie bijvoorbeeld aan een wet wil voldoen zal dit willen uitsplitsen in een aantal gewetensvragen (verwachtingen aan zichzelf die daarmee ook verplichtingen zijn). Deze kunnen op dezelfde manier worden 'doorvertaald' totdat de gewetensvraag als het ware wordt 'beantwoord' doordat er een concrete verwachting aan een derde partij mee geassocieerd kan worden, dan wel de gewetensvraag een truisme (d.w.z. een waarheid als een koe) is, dat verdere doorvertaling niet meer nodig is.-}

ENDPATTERN
---------------------------------------------------------------------