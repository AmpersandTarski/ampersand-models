---------------------------------------------------------------------
--!Zodra multiple inheritance werkt moeten alle voorkomens van 'isaObl' en 'isaExp' worden verwijderd.
---------------------------------------------------------------------
PATTERN Obligations -- Author(s): rieks.joosten@tno.nl
--!RJ: This pattern is ready for review/publication
--!PATTERN Obligations USES Holons, BusinessRules

CONCEPT Obligation "a rule that a holon is committed to comply with."
PURPOSE CONCEPT Obligation IN ENGLISH
{+A rule becomes an obligation for a holon as soon as that holon is committed to comply with that rule.-}
PURPOSE CONCEPT Obligation IN DUTCH
{+Een regel wordt een verplichting voor een holon zodra de holon zich verplicht heeft de regel waar te maken c.q. na te leven.-}
GEN Obligation ISA BusinessRule

obligationOf :: Obligation -> Holon PRAGMA "Being compliant with " " is a commitment of ".
PURPOSE RELATION obligationOf IN ENGLISH
{+Holons serve as scopes within which commitments exist to comply with rules.-} 
PURPOSE RELATION obligationOf IN DUTCH
{+Holons dienen als afbakeningen waarbinnen verplichtingen bestaan met betrekking tot het naleven c.q. voldoen aan specifieke regels.-}

RULE "obligation rules": obligationOf |- ruleScope
PURPOSE RULE "obligation rules" IN ENGLISH 
{+Any obligation within a Holon must be a rule that can (and hence: must) be interpretable/evaluatable within the scope of that Holon.-}
PURPOSE RULE "obligation rules" IN DUTCH 
{+Elke verplichting binnen een Holon moet een regel zijn die ook binnen diezelfde Holon kan (en dus ook: moet) worden geinterpreteerd c.q. geevalueerd.-}

obligedTo:: Obligation * Holon [TOT] PRAGMA "Being compliant with " " is an obligation to ".
PURPOSE RELATION obligedTo IN ENGLISH
{+For appropriate governance, it is necessary that each holon identifies the holon(s) that it has obligations to. A holon can assign an obligation to itself, meaning that it has to organize work that ensures compliance with this rule. A holon can assign an obligation to another holon, meaning that it expects that other holon to hold it accountable for compliance with this rule. Any rule within a Holon for which no (other) Holon exists that demands compliance to be accounted for, is not considered an Obligation.-}
PURPOSE RELATION obligedTo IN DUTCH
{+Voor een goede governance is het nodig dat elke holon de (andere) holonen identificeert aan welke verplichtingen zijn gesteld. Een holon kan verplichtingen hebben ten aanzien van zichzelf, hetgeen betekent dat hij zichzelf verantwoordelijk houdt voor het nakomen ervan. Een holon kan verplichtingen hebben ten aanzien van andere holonen, hetgeen inhoudt dat het verwacht dat die andere holon hem verantwoordelijk houden voor het nakemon ervan. Een regel (van een zekere Holon) waarvan het nakomen door geen enkele Holon wordt vereist, geldt niet als een verplichting.-}

ENDPATTERN
---------------------------------------------------------------------
PATTERN Expectations -- Author(s): rieks.joosten@tno.nl
--!RJ: This pattern is ready for review/publication
--!PATTERN Expectations USES Holons, BusinessRules

CONCEPT Expectation "a rule that a holon expects compliance with."
PURPOSE CONCEPT Expectation IN ENGLISH
{+A rule becomes an expectation for a holon as soon as that holon expects the rule to be complied with (either by itself, another holon or G.O.D.[#G.O.D.]_

.. [#G.O.D.] We use the abbreviation 'G.O.D.' (Group of Deities) to indicate that an expectation is not directed to a specific holon. This is e.g. the case for expectations such as 'lightning strikes less than twice a year' or 'tomorrow, the sun will rise (again)'.
-}
PURPOSE CONCEPT Expectation IN DUTCH
{+Een regel wordt een verwachting voor een holon zodra die holon verwacht dat de regel waargemaakt c.q. nageleefd gaat worden; dit kan zijn door de holon zelf, een andere holon, of G.O.D.[#G.O.D.]_

.. [#G.O.D.] We gebruiken de afkorting 'G.O.D.' (Group of Deities) om mee aan te geven dat de verwachting niet aan een holon is gericht. Dat geldt bijvoorbeeld voor verwachtingen als 'het aantal blikseminslagen per jaar is minder dan 2' of 'morgen komt de zon (weer) op'.
-}

GEN Expectation ISA BusinessRule

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
--!Zodra multiple inheritance werkt moeten alle voorkomens van 'isaObl' en 'isaExp' worden verwijderd.
PATTERN "BusinessConscience" -- Author(s): rieks.joosten@tno.nl
--!RJ: This pattern is ready for review
--!PATTERN BusinessConscience USES Holons, BusinessRules, Obligations, Expectations

CONCEPT RuleOfConscience "a rule that is both an obligation and an expectation of a holon to itself" ""
PURPOSE CONCEPT RuleOfConscience IN ENGLISH
{+Every holon manager must decide how to fulfill its obligations towards other holons. Usually, this results in the holon manager defining rules that he expects its holon to fulfill, and assuming that he is coherent, this thus constitutes an obligation for the holon as well. This process continues until the holon manager has an expectation that is a truism (or triviality), or it can be mapped onto one or more expectations to other holons. The registration of obligations and expectations that the holon manager has defined for the holon (s)he manages, serves as the holon's conscience for doing things.-}
PURPOSE CONCEPT RuleOfConscience IN DUTCH
{+Elke holon manager moet beslissen hoe zijn verplichtingen ten opzichte van andere holons na te komen. Om dit te doen zal de holon manager zijn verplichtingen 'vertalen' in verwachtingen naar de eigen holon en/of andere holons. Een vertaling naar de eigen holon levert een regel op die zowel een verplichting als een verwachting is ten aanzien van deze holon. Het doorvertalen van (de zo ontstane) verplichtingen gaat door totdat ofwel de verplichting een trivialiteit is, of totdat de verplichting kan worden vertaald naar een of meer verwachtingen naar (een) andere holon(en). De registratie van verplichtingen/verwachtingen aan de eigen holon noemen we het geweten van de holon; daarmee zijn deze verplichtingen/verwachtingen gewetensvragen voor die holon.-}

conscienceOf :: RuleOfConscience -> Holon PRAGMA "" " is part of the conscience of ".
PURPOSE RELATION conscienceOf IN ENGLISH
{+Awareness of all obligations/expectations that a holon has with respect to itself is a prerequisite for holon managers in order for them to be accountable.-}
PURPOSE RELATION conscienceOf IN DUTCH
{+Zich bewust zijn van alle verplichtingen/verwachtingen die een holon ten aanzien van zichzelf heeft, is een noodzakelijke voorwaarde voor holon managers om verantwoording te kunnen afleggen.-}

--!Zodra multiple inheritance werkt onderstaande regel vervangen door: GEN RuleOfConscience ISA Obligation
isaObl :: RuleOfConscience -> Obligation
oisa :: Obligation * RuleOfConscience [UNI] PRAGMA "" " is a "
--RULE "obligationGewetensvragen": oisa = obligationOf;obligedTo~ PHRASE "Een verplichting is een gewetensvraag als de holon die de verplichting waar moet maken en de holon aan wie daarvoor verantwoordelijkheid moet worden afgelegd, dezelfde zijn."
RULE "obligationGewetensvragen": oisa; isaObl = obligationOf;obligedTo~ PHRASE "Een verplichting is een gewetensvraag als de holon die de verplichting waar moet maken en de holon aan wie daarvoor verantwoordelijkheid moet worden afgelegd, dezelfde zijn."

ruleOfConscience :: Obligation * Obligation [PROP] PRAGMA "" "is also a rule of conscience for its holon".
PURPOSE RELATION ruleOfConscience IN ENGLISH
{+The property 'ruleOfConscience' of an obligation indicates that the obligation is a RuleOfConscience for its holon.-}
PURPOSE RELATION ruleOfConscience IN DUTCH
{+Aan de eigenschap 'ruleOfConscience' van een verplichting is zichtbaar dat deze verplichting ook een Gewetensvraag is voor diens holon.-}

--!Zodra multiple inheritance werkt onderstaande regel vervangen door: GEN RuleOfConscience ISA Expectation
isaExp :: RuleOfConscience -> Expectation
eisa :: Expectation * RuleOfConscience [UNI] PRAGMA "" " is a "
RULE "expectationGewetensvragen": eisa; isaExp = expectationOf;expectedFrom~ PHRASE "Een verwachting is een gewetensvraag als de holon die de verwachting geacht wordt waar te maken en de holon die dit verwacht, dezelfde zijn."

ruleOfConscience :: Expectation * Expectation [PROP] PRAGMA "" "is also a rule of conscience for its holon".
PURPOSE RELATION ruleOfConscience IN ENGLISH
{+The property 'ruleOfConscience' of an expectation indicates that the expectation is a RuleOfConscience for its holon.-}
PURPOSE RELATION ruleOfConscience IN DUTCH
{+Aan de eigenschap 'ruleOfConscience' van een verwachting is zichtbaar dat deze verwachting ook een Gewetensvraag is voor diens holon.-}

--!Zodra multiple inheritance werkt onderstaande regel weggooien
RULE "gewetensvraagRules": isaObl;I[BusinessRule] = isaExp -- Deze is niet meer nodig als de multiple inheritance goed werkt.

RULE "gewetensvragen": I[RuleOfConscience];isaObl; oisa = I[RuleOfConscience]; isaExp; eisa PHRASE "Voor alle gewetensvragen geldt dat ze zowel een verplichting als een verwachting zijn."
PURPOSE RULE "gewetensvragen" IN ENGLISH
{+The special case where a rule is both an obligation and an expectation of a holon to/from itself is important for a holon manager to get a grasp on. (to be extended)-}
PURPOSE RULE "gewetensvragen" IN DUTCH
{+Het geweten van een holon, d.w.z. de verzameling van al diens gewetensvragen, voorziet de holon manager van het overzicht van de besluiten die hij genomen heeft met betrekking tot de inrichting van zijn holon. Wie bijvoorbeeld aan een wet wil voldoen zal dit willen uitsplitsen in een aantal gewetensvragen (verwachtingen aan zichzelf die daarmee ook verplichtingen zijn). Deze kunnen op dezelfde manier worden 'doorvertaald' totdat de gewetensvraag als het ware wordt 'beantwoord' doordat er een concrete verwachting aan een derde partij mee geassocieerd kan worden, dan wel de gewetensvraag een truisme (d.w.z. een waarheid als een koe) is, dat verdere doorvertaling niet meer nodig is.-}

ENDPATTERN
---------------------------------------------------------------------