---------------------------------------------------------------------
--!Zodra multiple inheritance werkt moeten alle voorkomens van 'isaObl' en 'isaExp' worden verwijderd.
---------------------------------------------------------------------
PATTERN Obligations --!EXTENDS Holons, BusinessRules
-- Author(s): rieks.joosten@tno.nl
--!RJ: This pattern is ready for review/publication
PURPOSE PATTERN "Obligations" IN ENGLISH
{+The responsibility of a Holon, which is born by its HolonManager, consist of Obligations that are to be fulfilled by/within the Holon. This pattern allows HolonManager to maintain an overview of the Obligations for which (s)he is accountable, as well as the Holons to which this accountability is directed.-}
PURPOSE PATTERN "Obligations" IN DUTCH
{+De verantwoordelijkheden van een Holon, die door diens HolonManager worden gedragen, bestaan uit Verplichtingen die door/binnen de Holon moeten worden waargemaakt c.q. nagekomen. Dit pattern voorziet HolonManagers van de mogelijkheid een overzicht bij te houden van diens Verplichtingen, alsmede (per Verplichting) van de Holon aan wie verantwoording over de Verplichting moet worden afgelegd.-}

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
PATTERN Expectations  --!EXTENDS Holons, BusinessRules
-- Author(s): rieks.joosten@tno.nl
--!RJ: This pattern is ready for review/publication
--!PATTERN Expectations USES Holons, BusinessRules
PURPOSE PATTERN "Expectations" IN ENGLISH
{+By making Expectations of a Holon explicit, the HolonManager is able to indicate for each of its Obligations what arrangements have been made to fulfill c.q. comply with that Obligation. This allows the HolonManager to take responsibility for how (s)he has organized its work.-}
PURPOSE PATTERN "Obligations" IN DUTCH
{+Door Verwachtingen van een Holon expliciet te maken kan de HolonManager van elk van zijn Verplichtingen aangeven hoe deze is ingericht. Dat maakt zijn inrichting transparant en stelt hem in staat daarover verantwoordeing af te leggen.-}

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
PATTERN "BusinessConscience" --!EXTENDS Holons, BusinessRules, Obligations, Expectations 
-- Author(s): rieks.joosten@tno.nl
--!RJ: This pattern is ready for review
PURPOSE PATTERN "BusinessConscience" IN ENGLISH
{+-}
PURPOSE PATTERN "BusinessConscience" IN ENGLISH
{+The BusinessConscience of a Holon is a set of RulesOfConscience which are both Obligations and Expectations to itself. RulesOfConscience are useful because they can be treated without interference of other Holons. They allow the HolonManager to create and maintain the internal organization (arrangements) of the Holon. Thus, it helps to make the Holon arrangements transparent, which in turn facilitates the HolonManager in bearing his responsibilities.-}
PURPOSE PATTERN "BusinessConscience" IN DUTCH
{+Het BedrijfsGeweten van een Holon bestaat uit een verzameling Gewetensvragen, d.w.z. Verplichtingen en Verwachtingen van een Holon aan zichzelf. Gewetensvragen zijn nuttig om apart te behandelen omdat ze zonder interferentie van externe Holonen kunnen worden behandeld, en de HolonManager in staat stellen de interne Holon organisatie op poten te zetten c.q. te beschrijven. Dat helpt zijn inrichting transparant te maken en stelt hem in staat daarover verantwoordeing af te leggen.-}

CONCEPT RuleOfConscience "a rule that is both an obligation and an expectation of a holon to itself" ""
PURPOSE CONCEPT RuleOfConscience IN ENGLISH
{+Every HolOnManager must decide how to fulfill its obligations towards other holons. Usually, this results in the HolOnManager defining rules that he expects its holon to fulfill, and assuming that he is coherent, this thus constitutes an obligation for the holon as well. This process continues until the HolOnManager has an expectation that is a truism (or triviality), or it can be mapped onto one or more expectations to other holons. The registration of obligations and expectations that the HolOnManager has defined for the holon (s)he manages, serves as the holon's conscience for doing things.-}
PURPOSE CONCEPT RuleOfConscience IN DUTCH
{+Elke HolOnManager moet beslissen hoe zijn verplichtingen ten opzichte van andere holons na te komen. Om dit te doen zal de HolOnManager zijn verplichtingen 'vertalen' in verwachtingen naar de eigen holon en/of andere holons. Een vertaling naar de eigen holon levert een regel op die zowel een verplichting als een verwachting is ten aanzien van deze holon. Het doorvertalen van (de zo ontstane) verplichtingen gaat door totdat ofwel de verplichting een trivialiteit is, of totdat de verplichting kan worden vertaald naar een of meer verwachtingen naar (een) andere holon(en). De registratie van verplichtingen/verwachtingen aan de eigen holon noemen we het geweten van de holon; daarmee zijn deze verplichtingen/verwachtingen gewetensvragen voor die holon.-}

conscienceOf :: RuleOfConscience -> Holon PRAGMA "" " is part of the conscience of ".
PURPOSE RELATION conscienceOf IN ENGLISH
{+Awareness of all obligations/expectations that a holon has with respect to itself is a prerequisite for HolOnManagers in order for them to be accountable.-}
PURPOSE RELATION conscienceOf IN DUTCH
{+Zich bewust zijn van alle verplichtingen/verwachtingen die een holon ten aanzien van zichzelf heeft, is een noodzakelijke voorwaarde voor HolOnManagers om verantwoording te kunnen afleggen.-}

--!Zodra multiple inheritance werkt onderstaande regel vervangen door: GEN RuleOfConscience ISA Obligation
isaObl :: RuleOfConscience -> Obligation
oisa :: Obligation * RuleOfConscience [UNI] PRAGMA "" " is a "
--RULE "obligationGewetensvragen": oisa = obligationOf;obligedTo~ PHRASE "Een verplichting is een gewetensvraag als de holon die de verplichting waar moet maken en de holon aan wie daarvoor verantwoordelijkheid moet worden afgelegd, dezelfde zijn."
RULE "conscience obligations": oisa; isaObl = I /\ obligationOf;obligedTo~ PHRASE "Een verplichting is een gewetensvraag als de holon die de verplichting waar moet maken en de holon aan wie daarvoor verantwoordelijkheid moet worden afgelegd, dezelfde zijn."

ruleOfConscience :: Obligation * Obligation [PROP] PRAGMA "" "is also a rule of conscience for its holon".
PURPOSE RELATION ruleOfConscience[Obligation*Obligation] IN ENGLISH
{+The property 'ruleOfConscience' of an obligation indicates that the obligation is a RuleOfConscience for its holon.-}
PURPOSE RELATION ruleOfConscience[Obligation*Obligation] IN DUTCH
{+Aan de eigenschap 'ruleOfConscience' van een verplichting is zichtbaar dat deze verplichting ook een Gewetensvraag is voor diens holon.-}

--!Zodra multiple inheritance werkt onderstaande regel vervangen door: GEN RuleOfConscience ISA Expectation
isaExp :: RuleOfConscience -> Expectation
eisa :: Expectation * RuleOfConscience [UNI] PRAGMA "" " is a "
RULE "expectationGewetensvragen": eisa; isaExp = I /\ expectationOf;expectedFrom~ PHRASE "Een verwachting is een gewetensvraag als de holon die de verwachting geacht wordt waar te maken en de holon die dit verwacht, dezelfde zijn."

ruleOfConscience :: Expectation * Expectation [PROP] PRAGMA "" "is also a rule of conscience for its holon".
PURPOSE RELATION ruleOfConscience[Expectation*Expectation] IN ENGLISH
{+The property 'ruleOfConscience' of an expectation indicates that the expectation is a RuleOfConscience for its holon.-}
PURPOSE RELATION ruleOfConscience[Expectation*Expectation] IN DUTCH
{+Aan de eigenschap 'ruleOfConscience' van een verwachting is zichtbaar dat deze verwachting ook een Gewetensvraag is voor diens holon.-}

--!Zodra multiple inheritance werkt onderstaande regel weggooien
RULE "conscienceRulesDEF": isaObl;I[BusinessRule] = isaExp -- Deze is niet meer nodig als de multiple inheritance goed werkt.

RULE "conscienceRules": I[RuleOfConscience];isaObl; oisa = I[RuleOfConscience]; isaExp; eisa 
PHRASE "Every RuleOfConscience is both an Obligation and an Expectation."
-- PHRASE "Voor alle gewetensvragen geldt dat ze zowel een verplichting als een verwachting zijn."
PURPOSE RULE "conscienceRules" IN ENGLISH
{+The special case where a rule is both an obligation and an expectation of a holon to/from itself is important for a HolOnManager to get a grasp on. (to be extended)-}
PURPOSE RULE "conscienceRules" IN DUTCH
{+Het geweten van een holon, d.w.z. de verzameling van al diens gewetensvragen, voorziet de HolOnManager van het overzicht van de besluiten die hij genomen heeft met betrekking tot de inrichting van zijn holon. Wie bijvoorbeeld aan een wet wil voldoen zal dit willen uitsplitsen in een aantal gewetensvragen (verwachtingen aan zichzelf die daarmee ook verplichtingen zijn). Deze kunnen op dezelfde manier worden 'doorvertaald' totdat de gewetensvraag als het ware wordt 'beantwoord' doordat er een concrete verwachting aan een derde partij mee geassocieerd kan worden, dan wel de gewetensvraag een truisme (d.w.z. een waarheid als een koe) is, dat verdere doorvertaling niet meer nodig is.-}

ENDPATTERN
---------------------------------------------------------------------
PATTERN "Holon Arrangements" --!EXTENDS Holons, BusinessRules, Obligations, Expectations, BusinessConscience
-- Author(s): rieks.joosten@tno.nl
PURPOSE PATTERN "Holon Arrangements" IN ENGLISH
{+A first step towards providing assurance with respect to a Holon's commitment to fulfill its Obligations, is to provide an overview of the Expectations that the Holon has defined for the purpose of complying with its Obligations. Such an overview makes the arrangements of the Holon transparant and auditable.-}
PURPOSE PATTERN "Holon Arrangements" IN DUTCH
{+Een eerste stap naar assurance met betrekking tot het nakomen door een Holon van zijn Verplichtingen, is het verstrekken van een overzicht van de Verwachtingen van de Holon op basis waarvan deze meent aan zijn verplichtingen te gaan voldoen. Zo'n overzicht maakt de inrichting van de Holon transparant en auditeerbaar.-}

dependsOn :: Obligation * Expectation [SUR] PRAGMA "Fulfillment of/compliance with " " depends directly on the fulfillment of "
PURPOSE RELATION dependsOn IN ENGLISH
{+In order for a Holon to fulfill c.q. comply with an Obligation, arrangements have to be made. The arrangements made for an Obligation consist of a (possibly empty) set of Expectations that the Holon requires to be fulfilled. An Obligation is well-arranged if, according to the HolonManager, the Obligation will be fulfilled if all related Expectations are fulfilled. In order to evaluate the arrangements of a Holon, its manager needs an overview of the arrangements that are specifically intended to support fulfillment or each of its Obligations. Also, a manager may need an overview of the Obligations that any of its Expectations is arranged to support, so that it may drop any Expectation that does not fulfill such a purpose.-}
PURPOSE RELATION dependsOn IN DUTCH
{+Om aan een zekere verplichting te kunnen voldoen moet een Holon daartoe worden ingericht. Deze inrichting bestaat uit een (mogelijk lege) verzameling van verwachtingen van deze Holon. Een verplichting is goed ingericht (volgens de HolonManager) als geldt dat als aan alle bij een verplichting horende verwachtingen is voldaan, dit impliceert dat ook aan de verplichting zal worden voldaan. Om de inrichting van een verplichting te kunnen evalueren c.q. laten auditeren is een overzicht nodig van de verwachtingen waar elke verplichting van afhangt. Omgekeerd geldt dat om vast te kunnen stellen dat een verwachting niet langer nodig is omdat er geen verplichtingen van afhankelijk zijn, eenzelfde overzicht is vereist.-}

RULE "dependsOnSameHolon": obligationOf~; dependsOn; expectationOf |- I[Holon]
PHRASE "Obligations only depend on Expectations within a single Holon."
PURPOSE RULE "dependsOnSameHolon" IN ENGLISH
{+Within every Holon, it is useful to have an overview of how Obligations (e.g. to external Holons) depend on Expectations (that other Holons have to fulfill). Such overviews are necessary e.g. in order to assess the risks of not being able to fulfill one's Obligations.-}
PURPOSE RULE "dependsOnSameHolon" IN DUTCH
{+Binnen een zekere Holon is het nuttig om een overzicht te hebben van hoe Verplichtingen (bijvoorbeeld naar externe partijen) afhangen van Verwachtingen (die aan externe partijen zijn gesteld). Zulke overzichten zijn bijvoorbeeld nodig om de risico's te kunnen inschatten van het niet nakomen van Verplicthingen.-}

--!Zodra multiple inheritance werkt moeten alle voorkomens van 'isaObl' en 'isaExp' worden verwijderd.
RULE "rulesOfConscience do not depend on themselves": isaObl; dependsOn; isaExp~ |- -I[RuleOfConscience]
PHRASE "Rules of conscience do not depend on themselves."

dependsOnStar :: Obligation * Expectation PRAGMA "Fulfillment of/compliance with " " depends directly or indirectly on the fulfillment of "
PURPOSE RELATION dependsOnStar IN ENGLISH
{+In order to get an overview of dependencies across Holons, it is necessary to have an overview of how an Obligation that a Holon has towards another Holon, depends on the expectations of that (first) Holon from other Holons.-}
PURPOSE RELATION dependsOnStar IN DUTCH
{+Om een overzicht te krijgen over de afhankelijkheden over Holon-ketens heen, is het nodig om van elke Verplichting die een zekere Holon heeft ten aanzien van een andere Holon, te weten van welke Verwachtingen naar andere Holons deze afhankelijk is.-}

RULE "interHolonDependencies": dependsOnStar; (I \/ isaExp~;isaObl;dependsOn) |- dependsOnStar
PHRASE "An Obligation of a Holon directly or indirectly depends on an Expectation of that same Holon if there is a a path between them that contains of zero or more RulesofConscience." 
PURPOSE RULE "interHolonDependencies" IN ENGLISH
{+In order to construct an overview of dependencies between chains of Holons, it is necessary to know of every Holon which of its Obligations (to other Holons) depend on which of its Expectations (to other Holons and/or Nobody/G.O.D.)-}
PURPOSE RULE "interHolonDependencies" IN DUTCH
{+Om een overzicht van afhankelijkheden over ketens heen te kunnen construeren is het nodig om van elke Holon te weten welke van zijn Verplichtingen (aan andere Holons dan zichzelf) afhankelijk zijn van welke van zijn Verwachtingen (aan andere Holons c.q. aan Niemand/G.O.D.).-}

ENDPATTERN
---------------------------------------------------------------------