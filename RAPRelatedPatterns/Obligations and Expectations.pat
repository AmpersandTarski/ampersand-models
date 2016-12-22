---------------------------------------------------------------------
--!Zodra multiple inheritance werkt moeten alle voorkomens van 'isaObl' en 'isaExp' worden verwijderd.
---------------------------------------------------------------------
PATTERN Obligations --!EXTENDS Businessfunctions, BusinessRules
-- Author(s): rieks.joosten@tno.nl
--!RJ: This pattern is ready for review/publication
PURPOSE PATTERN "Obligations" IN ENGLISH
{+The responsibility of a BusinessFunction, which is born by its BFManager, consist of Obligations that are to be fulfilled by/within the BusinessFunction. This pattern allows BFManager to maintain an overview of the Obligations for which (s)he is accountable, as well as the Businessfunctions to which this accountability is directed.+}
PURPOSE PATTERN "Obligations" IN DUTCH
{+De verantwoordelijkheden van een bedrijfsfunctie, die door diens BFManager worden gedragen, bestaan uit Verplichtingen die door/binnen de bedrijfsfunctie moeten worden waargemaakt c.q. nagekomen. Dit pattern voorziet BFManagers van de mogelijkheid een overzicht bij te houden van diens Verplichtingen, alsmede (per Verplichting) van de bedrijfsfunctie aan wie verantwoording over de Verplichting moet worden afgelegd.+}

CONCEPT Obligation "a rule that a BusinessFunction is committed to comply with."
PURPOSE CONCEPT Obligation IN ENGLISH
{+A rule becomes an obligation for a BusinessFunction as soon as that BusinessFunction is committed to comply with that rule.+}
PURPOSE CONCEPT Obligation IN DUTCH
{+Een regel wordt een verplichting voor een bedrijfsfunctie zodra de bedrijfsfunctie zich verplicht heeft de regel waar te maken c.q. na te leven.+}
GEN Obligation ISA BusinessRule

obligationOf :: Obligation -> BusinessFunction PRAGMA "Being compliant with " " is a commitment of ".
PURPOSE RELATION obligationOf IN ENGLISH
{+Businessfunctions serve as scopes within which commitments exist to comply with rules.+} 
PURPOSE RELATION obligationOf IN DUTCH
{+Bedrijfsfuncties dienen als afbakeningen waarbinnen verplichtingen bestaan met betrekking tot het naleven c.q. voldoen aan specifieke regels.+}

RULE "obligation rules": obligationOf |- intensionAuthority
PURPOSE RULE "obligation rules" IN ENGLISH 
{+Any obligation within a BusinessFunction must be a rule that can (and hence: must) be interpretable/evaluatable within the scope of that BusinessFunction.+}
PURPOSE RULE "obligation rules" IN DUTCH 
{+Elke verplichting binnen een bedrijfsfunctie moet een regel zijn die ook binnen diezelfde bedrijfsfunctie kan (en dus ook: moet) worden geinterpreteerd c.q. geevalueerd.+}

obligedTo:: Obligation * BusinessFunction [TOT] PRAGMA "Being compliant with " " is an obligation to ".
PURPOSE RELATION obligedTo IN ENGLISH
{+For appropriate governance, it is necessary that each BusinessFunction identifies the BusinessFunction(s) that it has obligations to. A BusinessFunction can assign an obligation to itself, meaning that it has to organize work that ensures compliance with this rule. A BusinessFunction can assign an obligation to another BusinessFunction, meaning that it expects that other BusinessFunction to hold it accountable for compliance with this rule. Any rule within a BusinessFunction for which no (other) BusinessFunction exists that demands compliance to be accounted for, is not considered an Obligation.+}
PURPOSE RELATION obligedTo IN DUTCH
{+Voor een goede governance is het nodig dat elke bedrijfsfunctie de (andere) bedrijfsfuncties identificeert aan welke verplichtingen zijn gesteld. Een bedrijfsfunctie kan verplichtingen hebben ten aanzien van zichzelf, hetgeen betekent dat hij zichzelf verantwoordelijk houdt voor het nakomen ervan. Een bedrijfsfunctie kan verplichtingen hebben ten aanzien van andere bedrijfsfuncties, hetgeen inhoudt dat het verwacht dat die andere bedrijfsfunctie hem verantwoordelijk houden voor het nakemon ervan. Een regel (van een zekere bedrijfsfunctie) waarvan het nakomen door geen enkele bedrijfsfunctie wordt vereist, geldt niet als een verplichting.+}

ENDPATTERN
---------------------------------------------------------------------
PATTERN Expectations  --!EXTENDS Businessfunctions, BusinessRules
-- Author(s): rieks.joosten@tno.nl
--!RJ: This pattern is ready for review/publication
--!PATTERN Expectations USES Businessfunctions, BusinessRules
PURPOSE PATTERN "Expectations" IN ENGLISH
{+By making Expectations of a BusinessFunction explicit, the BFManager is able to indicate for each of its Obligations what arrangements have been made to fulfill c.q. comply with that Obligation. This allows the BFManager to take responsibility for how (s)he has organized its work.+}
PURPOSE PATTERN "Expectations" IN DUTCH
{+Door Verwachtingen van een BusinessFunction expliciet te maken kan de BFManager van elk van zijn Verplichtingen aangeven hoe deze is ingericht. Dat maakt zijn inrichting transparant en stelt hem in staat daarover verantwoordeing af te leggen.+}

CONCEPT Expectation "a rule that a BusinessFunction expects compliance with."
PURPOSE CONCEPT Expectation IN ENGLISH
{+A rule becomes an expectation for a BusinessFunction as soon as that BusinessFunction expects the rule to be complied with (either by itself, another BusinessFunction or G.O.D.[#G.O.D.]_

.. [#G.O.D.] We use the abbreviation 'G.O.D.' (Group of Deities) to indicate that an expectation is not directed to a specific BusinessFunction. This is e.g. the case for expectations such as 'lightning strikes less than twice a year' or 'tomorrow, the sun will rise (again)'.
-}
PURPOSE CONCEPT Expectation IN DUTCH
{+Een regel wordt een verwachting voor een bedrijfsfunctie zodra die bedrijfsfunctie verwacht dat de regel waargemaakt c.q. nageleefd gaat worden; dit kan zijn door de bedrijfsfunctie zelf, een andere bedrijfsfunctie, of G.O.D.[#G.O.D.]_

.. [#G.O.D.] We gebruiken de afkorting 'G.O.D.' (Group of Deities) om mee aan te geven dat de verwachting niet aan een bedrijfsfunctie is gericht. Dat geldt bijvoorbeeld voor verwachtingen als 'het aantal blikseminslagen per jaar is minder dan 2' of 'morgen komt de zon (weer) op'.
-}

GEN Expectation ISA BusinessRule

expectationOf  :: Expectation * BusinessFunction [UNI] PRAGMA "Compliance to " " is expected by ".
PURPOSE RELATION expectationOf[Expectation*BusinessFunction] IN ENGLISH
{+Businessfunctions serve as scopes within which expectations exist with respect to compliance with specific rules.+}
PURPOSE RELATION expectationOf[Expectation*BusinessFunction] IN DUTCH
{+Bedrijfsfuncties dienen als afbakeningen waarbinnen verwachtingen leven met betrekking tot compliance aan specifieke regels.+}

RULE "expectation rules": expectationOf |- intensionAuthority
PURPOSE RULE "expectation rules" IN ENGLISH
{+Any expectation within a BusinessFunction must be a rule that can (and hence: must) be interpretable/evaluatable within the scope of that BusinessFunction.+}
PURPOSE RULE "expectation rules" IN DUTCH
{+Elke verwachting binnen een bedrijfsfunctie moet een regel zijn die ook binnen diezelfde bedrijfsfunctie kan (en dus ook: moet) worden geinterpreteerd c.q. geevalueerd.+}

expectedFrom:: Expectation * BusinessFunction PRAGMA "Compliance to " " is expected from ".
PURPOSE RELATION expectationOf[Expectation*BusinessFunction] IN ENGLISH
{+For appropriate governance, it is necessary that each BusinessFunction identifies the BusinessFunction(s) that it assumes will comply with each of its expectations. A BusinessFunction can assign an expectation to itself, meaning that it has to organize work that ensures compliance with this rule. A BusinessFunction can assign an expectation to another BusinessFunction, meaning that it expects that other BusinessFunction to organize work that ensures compliance with this rule. Finaly, if a BusinessFunction does not assign an expectation to a BusinessFunction for doing the associated work, compliance with the rule is expected of G.O.D.[#G.O.D.]_, meaning that there is no person or organization that can be held accountable for compliance with this rule.
-}
PURPOSE RELATION expectationOf[Expectation*BusinessFunction] IN DUTCH
{+Voor een goede governance is het nodig dat elke bedrijfsfunctie de (andere) bedrijfsfuncties identificeert aan welke verwachtingen zijn gesteld. Een bedrijfsfunctie kan verwachtingen hebben ten aanzien van zichzelf, hetgeen betekent dat binnen die bedrijfsfunctie het werk moet worden georganiseerd dat 'compliance' aan die verwachting verzekert. Een bedrijfsfunctie kan verwachtingen hebben ten aanzien van andere bedrijfsfuncties, hetgeen inhoudt dat het verwacht dat die andere bedrijfsfunctie het werk organiseren dat 'compliance' aan die verwachting verzekert. Als een bedrijfsfunctie een verwachting heeft die niet gericht is aan zichzelf of een andere bedrijfsfunctie, dan zeggen we dat deze verwachting is ten aanzien van G.O.D.[#G.O.D.]_, hetgeen inhoudt dat geen enkele persoon of organisatie verantwoordelijk gehouden kan worden voor compliance aan die verwachting.+}

ENDPATTERN
---------------------------------------------------------------------
--!Zodra multiple inheritance werkt moeten alle voorkomens van 'isaObl' en 'isaExp' worden verwijderd.
PATTERN "BusinessConscience" --!EXTENDS Businessfunctions, BusinessRules, Obligations, Expectations 
-- Author(s): rieks.joosten@tno.nl
--!RJ: This pattern is ready for review
PURPOSE PATTERN "BusinessConscience" IN ENGLISH
{++}
PURPOSE PATTERN "BusinessConscience" IN ENGLISH
{+The BusinessConscience of a BusinessFunction is a set of RulesOfConscience which are both Obligations and Expectations to itself. RulesOfConscience are useful because they can be treated without interference of other Businessfunctions. They allow the BFManager to create and maintain the internal organization (arrangements) of the BusinessFunction. Thus, it helps to make the BusinessFunction arrangements transparent, which in turn facilitates the BFManager in bearing his responsibilities.+}
PURPOSE PATTERN "BusinessConscience" IN DUTCH
{+Het BedrijfsGeweten van een bedrijfsfunctie bestaat uit een verzameling Gewetensvragen, d.w.z. Verplichtingen en Verwachtingen van een bedrijfsfunctie aan zichzelf. Gewetensvragen zijn nuttig om apart te behandelen omdat ze zonder interferentie van externe bedrijfsfuncties kunnen worden behandeld, en de BFManager in staat stellen de interne bedrijfsfunctie organisatie op poten te zetten c.q. te beschrijven. Dat helpt zijn inrichting transparant te maken en stelt hem in staat daarover verantwoordeing af te leggen.+}

CONCEPT RuleOfConscience "a rule that is both an obligation and an expectation of a BusinessFunction to itself" ""
PURPOSE CONCEPT RuleOfConscience IN ENGLISH
{+Every BFManager must decide how to fulfill its obligations towards other businessfunctions. Usually, this results in the BFManager defining rules that he expects its BusinessFunction to fulfill, and assuming that he is coherent, this thus constitutes an obligation for the BusinessFunction as well. This process continues until the BFManager has an expectation that is a truism (or triviality), or it can be mapped onto one or more expectations to other businessfunctions. The registration of obligations and expectations that the BFManager has defined for the BusinessFunction (s)he manages, serves as the BusinessFunction's conscience for doing things.+}
PURPOSE CONCEPT RuleOfConscience IN DUTCH
{+Elke BFManager moet beslissen hoe zijn verplichtingen ten opzichte van andere bedrijfsfuncties na te komen. Om dit te doen zal de BFManager zijn verplichtingen 'vertalen' in verwachtingen naar de eigen bedrijfsfunctie en/of andere bedrijfsfuncties. Een vertaling naar de eigen bedrijfsfunctie levert een regel op die zowel een verplichting als een verwachting is ten aanzien van deze bedrijfsfunctie. Het doorvertalen van (de zo ontstane) verplichtingen gaat door totdat ofwel de verplichting een trivialiteit is, of totdat de verplichting kan worden vertaald naar een of meer verwachtingen naar (een) andere bedrijfsfunctie(s). De registratie van verplichtingen/verwachtingen aan de eigen bedrijfsfunctie noemen we het geweten van de bedrijfsfunctie; daarmee zijn deze verplichtingen/verwachtingen gewetensvragen voor die bedrijfsfunctie.+}

conscienceOf :: RuleOfConscience -> BusinessFunction PRAGMA "" " is part of the conscience of ".
PURPOSE RELATION conscienceOf IN ENGLISH
{+Awareness of all obligations/expectations that a BusinessFunction has with respect to itself is a prerequisite for BFManagers in order for them to be accountable.+}
PURPOSE RELATION conscienceOf IN DUTCH
{+Zich bewust zijn van alle verplichtingen/verwachtingen die een bedrijfsfunctie ten aanzien van zichzelf heeft, is een noodzakelijke voorwaarde voor BFManagers om verantwoording te kunnen afleggen.+}

--!Zodra multiple inheritance werkt onderstaande regel vervangen door: GEN RuleOfConscience ISA Obligation
isaObl :: RuleOfConscience -> Obligation
oisa :: Obligation * RuleOfConscience [UNI] PRAGMA "" " is a "
--RULE "obligationGewetensvragen": oisa = obligationOf;obligedTo~ MEANING "Een verplichting is een gewetensvraag als de bedrijfsfunctie die de verplichting waar moet maken en de bedrijfsfunctie aan wie daarvoor verantwoordelijkheid moet worden afgelegd, dezelfde zijn."
RULE "conscience obligations": oisa; isaObl = I /\ obligationOf;obligedTo~ MEANING "Een verplichting is een gewetensvraag als de bedrijfsfunctie die de verplichting waar moet maken en de bedrijfsfunctie aan wie daarvoor verantwoordelijkheid moet worden afgelegd, dezelfde zijn."

ruleOfConscience :: Obligation * Obligation [PROP] PRAGMA "" "is also a rule of conscience for its BusinessFunction".
PURPOSE RELATION ruleOfConscience[Obligation*Obligation] IN ENGLISH
{+The property 'ruleOfConscience' of an obligation indicates that the obligation is a RuleOfConscience for its BusinessFunction.+}
PURPOSE RELATION ruleOfConscience[Obligation*Obligation] IN DUTCH
{+Aan de eigenschap 'ruleOfConscience' van een verplichting is zichtbaar dat deze verplichting ook een Gewetensvraag is voor diens bedrijfsfunctie.+}

--!Zodra multiple inheritance werkt onderstaande regel vervangen door: GEN RuleOfConscience ISA Expectation
isaExp :: RuleOfConscience -> Expectation
eisa :: Expectation * RuleOfConscience [UNI] PRAGMA "" " is a "
RULE "expectationGewetensvragen": eisa; isaExp = I /\ expectationOf;expectedFrom~ MEANING "Een verwachting is een gewetensvraag als de bedrijfsfunctie die de verwachting geacht wordt waar te maken en de bedrijfsfunctie die dit verwacht, dezelfde zijn."

ruleOfConscience :: Expectation * Expectation [PROP] PRAGMA "" "is also a rule of conscience for its bedrijfsfunctie".
PURPOSE RELATION ruleOfConscience[Expectation*Expectation] IN ENGLISH
{+The property 'ruleOfConscience' of an expectation indicates that the expectation is a RuleOfConscience for its BusinessFunction.+}
PURPOSE RELATION ruleOfConscience[Expectation*Expectation] IN DUTCH
{+Aan de eigenschap 'ruleOfConscience' van een verwachting is zichtbaar dat deze verwachting ook een Gewetensvraag is voor diens bedrijfsfunctie.+}

--!Zodra multiple inheritance werkt onderstaande regel weggooien
RULE "conscienceRulesDEF": isaObl;I[BusinessRule] = isaExp -- Deze is niet meer nodig als de multiple inheritance goed werkt.

RULE "conscienceRules": I[RuleOfConscience];isaObl; oisa = I[RuleOfConscience]; isaExp; eisa 
MEANING "Every RuleOfConscience is both an Obligation and an Expectation."
-- MEANING "Voor alle gewetensvragen geldt dat ze zowel een verplichting als een verwachting zijn."
PURPOSE RULE "conscienceRules" IN ENGLISH
{+The special case where a rule is both an obligation and an expectation of a BusinessFunction to/from itself is important for a BFManager to get a grasp on. (to be extended)+}
PURPOSE RULE "conscienceRules" IN DUTCH
{+Het geweten van een bedrijfsfunctie, d.w.z. de verzameling van al diens gewetensvragen, voorziet de BFManager van het overzicht van de besluiten die hij genomen heeft met betrekking tot de inrichting van zijn bedrijfsfunctie. Wie bijvoorbeeld aan een wet wil voldoen zal dit willen uitsplitsen in een aantal gewetensvragen (verwachtingen aan zichzelf die daarmee ook verplichtingen zijn). Deze kunnen op dezelfde manier worden 'doorvertaald' totdat de gewetensvraag als het ware wordt 'beantwoord' doordat er een concrete verwachting aan een derde partij mee geassocieerd kan worden, dan wel de gewetensvraag een truisme (d.w.z. een waarheid als een koe) is, dat verdere doorvertaling niet meer nodig is.+}

ENDPATTERN
---------------------------------------------------------------------
PATTERN "BusinessFunction Arrangements" --!EXTENDS BusinessFunctions, BusinessRules, Obligations, Expectations, BusinessConscience
-- Author(s): rieks.joosten@tno.nl
PURPOSE PATTERN "BusinessFunction Arrangements" IN ENGLISH
{+A first step towards providing assurance with respect to a BusinessFunction's commitment to fulfill its Obligations, is to provide an overview of the Expectations that the BusinessFunction has defined for the purpose of complying with its Obligations. Such an overview makes the arrangements of the BusinessFunction transparant and auditable.+}
PURPOSE PATTERN "BusinessFunction Arrangements" IN DUTCH
{+Een eerste stap naar assurance met betrekking tot het nakomen door een bedrijfsfunctie van zijn Verplichtingen, is het verstrekken van een overzicht van de Verwachtingen van de bedrijfsfunctie op basis waarvan deze meent aan zijn verplichtingen te gaan voldoen. Zo'n overzicht maakt de inrichting van de bedrijfsfunctie transparant en auditeerbaar.+}

dependsOn :: Obligation * Expectation [SUR] PRAGMA "Fulfillment of/compliance with " " depends directly on the fulfillment of "
PURPOSE RELATION dependsOn IN ENGLISH
{+In order for a BusinessFunction to fulfill c.q. comply with an Obligation, arrangements have to be made. The arrangements made for an Obligation consist of a (possibly empty) set of Expectations that the BusinessFunction requires to be fulfilled. An Obligation is well-arranged if, according to the BFManager, the Obligation will be fulfilled if all related Expectations are fulfilled. In order to evaluate the arrangements of a BusinessFunction, its manager needs an overview of the arrangements that are specifically intended to support fulfillment or each of its Obligations. Also, a manager may need an overview of the Obligations that any of its Expectations is arranged to support, so that it may drop any Expectation that does not fulfill such a purpose.+}
PURPOSE RELATION dependsOn IN DUTCH
{+Om aan een zekere verplichting te kunnen voldoen moet een bedrijfsfunctie daartoe worden ingericht. Deze inrichting bestaat uit een (mogelijk lege) verzameling van verwachtingen van deze bedrijfsfunctie. Een verplichting is goed ingericht (volgens de BFManager) als geldt dat als aan alle bij een verplichting horende verwachtingen is voldaan, dit impliceert dat ook aan de verplichting zal worden voldaan. Om de inrichting van een verplichting te kunnen evalueren c.q. laten auditeren is een overzicht nodig van de verwachtingen waar elke verplichting van afhangt. Omgekeerd geldt dat om vast te kunnen stellen dat een verwachting niet langer nodig is omdat er geen verplichtingen van afhankelijk zijn, eenzelfde overzicht is vereist.+}

RULE "dependsOnSameBF": obligationOf~; dependsOn; expectationOf |- I[BusinessFunction]
MEANING "Obligations only depend on Expectations within a single BusinessFunction."
PURPOSE RULE "dependsOnSameBF" IN ENGLISH
{+Within every BusinessFunction, it is useful to have an overview of how Obligations (e.g. to external BusinessFunctions) depend on Expectations (that other BusinessFunctions have to fulfill). Such overviews are necessary e.g. in order to assess the risks of not being able to fulfill one's Obligations.+}
PURPOSE RULE "dependsOnSameBF" IN DUTCH
{+Binnen een zekere bedrijfsfunctie is het nuttig om een overzicht te hebben van hoe Verplichtingen (bijvoorbeeld naar externe partijen) afhangen van Verwachtingen (die aan externe partijen zijn gesteld). Zulke overzichten zijn bijvoorbeeld nodig om de risico's te kunnen inschatten van het niet nakomen van Verplicthingen.+}

--!Zodra multiple inheritance werkt moeten alle voorkomens van 'isaObl' en 'isaExp' worden verwijderd.
RULE "rulesOfConscience do not depend on themselves": isaObl; dependsOn; isaExp~ |- -I[RuleOfConscience]
MEANING "Rules of conscience do not depend on themselves."

dependsOnStar :: Obligation * Expectation PRAGMA "Fulfillment of/compliance with " " depends directly or indirectly on the fulfillment of "
PURPOSE RELATION dependsOnStar IN ENGLISH
{+In order to get an overview of dependencies across BusinessFunctions, it is necessary to have an overview of how an Obligation that a BusinessFunction has towards another BusinessFunction, depends on the expectations of that (first) BusinessFunction from other BusinessFunctions.+}
PURPOSE RELATION dependsOnStar IN DUTCH
{+Om een overzicht te krijgen over de afhankelijkheden over bedrijfsfunctie-ketens heen, is het nodig om van elke Verplichting die een zekere bedrijfsfunctie heeft ten aanzien van een andere bedrijfsfunctie, te weten van welke Verwachtingen naar andere bedrijfsfuncties deze afhankelijk is.+}

RULE "interBFDependencies": dependsOnStar; (I \/ isaExp~;isaObl;dependsOn) |- dependsOnStar
MEANING "An Obligation of a BusinessFunction directly or indirectly depends on an Expectation of that same BusinessFunction if there is a a path between them that contains of zero or more RulesofConscience." 
PURPOSE RULE "interBFDependencies" IN ENGLISH
{+In order to construct an overview of dependencies between chains of BusinessFunctions, it is necessary to know of every BusinessFunction which of its Obligations (to other BusinessFunctions) depend on which of its Expectations (to other BusinessFunctions and/or Nobody/G.O.D.)+}
PURPOSE RULE "interBFDependencies" IN DUTCH
{+Om een overzicht van afhankelijkheden over ketens heen te kunnen construeren is het nodig om van elke bedrijfsfunctie te weten welke van zijn Verplichtingen (aan andere bedrijfsfuncties dan zichzelf) afhankelijk zijn van welke van zijn Verwachtingen (aan andere bedrijfsfuncties c.q. aan Niemand/G.O.D.).+}

ENDPATTERN
---------------------------------------------------------------------