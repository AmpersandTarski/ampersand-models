-----------------------------------------------------------------------
--!RJ:De verzameling patterns uit dit bestand modelleren de executie van services, om van daaruit te kunnen afleiden c.q. onderbouwen hoe zulke services dan moeten worden gedefinieerd. Ik heb een poging gedaan om de patterns zodanig op te splitsen dat eerst de 'structurele patterns' aan bod komen (die de taal definieren op basis waarvan we kunnen spreken over de executie (en later de definitie) van services, om op basis daarvan wat patterns te definieren die betrekking hebben op (de procesgang betreffende) het beheer van services.
--!RJ:DIT IS WORK IN PROGRESS EN VERTAALT NOG NIET PER SE.
-----------------------------------------------------------------------
{- Revision history
RJ/20110129 - Verdere uitwerking
RJ/20110119 - Ingetypt n.a.v. plaatje van Stef, met wat gedachten erbij
-}
-----------------------------------------------------------------------
-- Markup uses `reStructuredTexts <http://docutils.sourceforge.net/docs/user/rst/quickref.html>`__
-----------------------------------------------------------------------

PATTERN "Activities" -- Author(s) rieks.joosten@tno.nl
--!RJ: Pattern uses Historie.pat, 
--!RJ: Pattern uses SessionAccounts.pat
PURPOSE PATTERN "Activities" IN DUTCH
{+Dit pattern introduceert de taal die nodig is om discussies te kunnen voeren die betrekking hebben op het uitvoeren van (deels geautomatiseerd) werk. Het betreft dan onder meer het inrichten van werk en het specificeren van activiteiten. Maar het betreft ook het achteraf evalueren van het werk, of het auditeren van wie welke activiteit wanneer (en waar) heeft gedaan, op basis waarvan, en wat die activiteit dan heeft ingehouden (welke gegevens zijn aangemaakt, ingezien, gewijzigd, of verwijderd.-}

CONCEPT Activiteit "de (runtime) executie van 1 Service op een verzameling gegevens (zg. 'datawolk')." ""
PURPOSE CONCEPT Activiteit IN DUTCH
{+In organisaties komt het regelmatig voor dat 1 actor (een persoon of een computer(account)) werk verricht op 1 verzameling van onderling samenhangende gegevens en waarbij dit werk wordt verricht op 1 plaats en op 1 tijdstip (c.q. een relatief kort tijdsbestek die als een ononderbroken geheel en daarom ook als 1 tijdstip kan worden gezien). Bovendien vindt binnen dat tijdsbestek geen overdracht van werk plaats. Een ander kenmerk is dat dit werk wordt verricht op basis van een gebeurtenis (event, trigger?) die als 'het gesignaleerd zijn van werk' kan worden opgevat. De datawolk waarop de activiteit werkt bevat dan ook alle gegevens die nodig zijn om alle handelingen die onderdeel kunnen uitmaken van de activiteit, te kunnen uitvoeren. De specificatie op basis waarvan de datawolk wordt samengesteld, alsmede de specificatie van het soort handelingen dat op die datawolk kan worden uitgevoerd, noemen we een Service - zie aldaar. Een activiteit heet daarom ook wel 'service instantie'."-}

CONCEPT Datawolk "een verzameling onderling samenhangende gegevens."
PURPOSE CONCEPT Datawolk IN DUTCH
{+Om werk op een efficiente manier te kunnen doen is het zaak om per activiteit alle daarvoor benodigde c.q. nuttige gegevens bij de hand te hebben, maar niet (nodeloos) meer. Een verzameling van zulke gegevens wordt aangeduid met de term 'datawolk'. Datawolken zijn daarmee dus niet elke willekeurige vezameling van bij elkaar geraapte gegevens.

Om de historie van datawolken bij te kunnen houden, postuleren we dat elke datawolk een 'Inhoud' is (zie Historie.pat voor de details hiervan.)"-}
GEN Datawolk ISA Inhoud

execSession :: Activiteit * Session [INJ,UNI] PRAGMA "" " wordt op het huidige moment uitgevoerd (geexecuteerd) in ".
PURPOSE RELATION execSession IN DUTCH
{+Elke handeling die wordt uitgevoerd in een activiteit moet voldoen aan de randcondities zoals die zijn gespecificeerd in de Service waarvan de actiteit een instantie is. Dat houdt in dat dus ook alle gegevens beschikbaar moeten zijn om deze randcondities te kunnen evalueren. De gegevens van de sessie waarbinnen de activiteit wordt uitgevoerd zijn doorgaans juist gegevens die voor zulke evaluatie nodig zijn (zoals de User, het UserAccount, de actieve rollen enzovoorts). Deeze relatie maakt het mogelijk om sessie gegevens deel te laten uitmaken van de datawolk van de activiteit.-}

isCalledBy :: Activity * Activity [INJ,UNI] PRAGMA "" " is called by ".
PURPOSE RELATION isCalledBy IN DUTCH
{+Activiteiten die andere activiteiten aanroepen moeten (een deel van) hun datawolk doorgeven aan de activiteiten die ze aanroepen. Activiteiten die 'uit het niets' worden aangeroepen moeten op een andere wijze aan hun datawolk komen. Daarom is het nodig te weten of, en zo ja door welke andere activiteit, een activiteit is aangeroepen.-}
ENDPATTERN
-----------------------------------------------------------------------
PATTERN "Activiteitenlijm" -- Author(s) rieks.joosten@tno.nl

typeof :: Activiteit -> Service.

RULE "activity typechecking": isCalledBy; typeof |- typeof; uses~
PURPOSE RULE "activity typechecking" IN DUTCH
{+Om er zeker van te zijn dat runtime executie plaatsvindt in overeenstemming met hoe dat is ontworpen, mogen activiteiten elkaar alleen aanroepen als zij services instantieren waarvan is gespecificeerd dat zij elkaar overeenkomstig mogen aanroepen.-}

RULE "rbac": execSession |- typeof; roleSvc~; sessionRole~
PURPOSE RULE "rbac" IN DUTCH
{+Een activiteit mag alleen worden uitgevoerd in een sessie als de service waarvan de activiteit een instantie is uitgevoerd mag worden door een rol die in de betreffende sessie is geactiveerd.-}



ENDPATTERN
-----------------------------------------------------------------------
PATTERN "Service Specifications -- Author(s) rieks.joosten@tno.nl
PURPOSE PATTERN "Service Specifications" IN DUTCH
{+Om Services te kunnen specificeren is een precieze taal nodig waarvan de noties en de relaties daartussen zodanig eenduidig zijn vastgelegd dat zo snel mogelijk aan belanghebbenden kan worden uitgelegd waartoe services dienen en besluiten met betrekking tot de definitie van enige service effectief kan worden onderbouwd.-}

CONCEPT Service "de specificatie van een samenhangend geheel van mogelijkheden om extensies van relaties in de zien c.q.  te veranderen, en wel zodanig dat dit bijdraagt aan het verwezenlijken van een doel." ""
PURPOSE CONCEPT Service IN DUTCH
{+Automatisering beoogt mensen te ondersteunen in hun taakrealisatie, bijvoorbeeld door het onthouden van grote hoeveelheden data die mensen niet (foutloos) zelf kunnen onthouden, het uitvoeren van steeds weer dezelfde handelingen die door mensen als 'saai' of 'eentonig' worden ervaren waardoor mensen bij de uitvoering gemakkelijk fouten zouden maken. Een Service specificeert de criteria voor het (runtime) selecteren van een verzameling gegevens en een verzameling (CRUD) handelingen die runtime op (een deel van) de dan geselecteerde gegevens kunnen worden uitgevoerd; het runtime uitvoeren van handelingen op zo'n datawolk noemen we een activiteit (zie aldaar), of service instantie. Of deze handelingen op zo'n moment feitelijk worden uitgevoerd hangt af van wat de Actor verkiest te doen die zo'n Service runtime heeft ge instantieerd. Services specificeren dus een een interface tussen mens en machine waarvan de preciese inhoud pas runtime wordt vastgesteld.-}

purpose :: Service -> Purpose PRAGMA "The mission of " " is to fulfill ".
PURPOSE RELATION purpose IN DUTCH
{+Om te waarborgen dat elk stuk automatisering nut heeft, moet voordat een service wordt gespecificeerd zijn vastgesteld waartoe deze dient. Een gevolg hiervan is dat gedurende het bestaan van zo'n service kan worden getoetst of de gespecificeerde effecten van zo'n service (bijvoorbeeld de bijdragen die de service levert aan het herstellen van signaal-overtredingen) ook daadwerkelijk dit doel dienen.-}

uses :: Service * Service PRAGMA "Every invocation of " " may result in the invocation of ".
PURPOSE RELATION uses IN DUTCH
{+Een service specificatie zegt dat een (andere) service wordt gebruikt omdat degene die de service specificieert vindt dat het gebruik van deze (andere) service bijdraagt aan het doel waartoe de service dient. De runtime consequentie hiervan is dat (runtime) instanties van de (aanroepende) service (runtime) instanties van de (andere) service kunnen aanroepen. [**hier verder uitleggen hoe dat dan zit met wat er uit de datawolk van de aanroepende service instantie gebeurt om de datawolk van de runtime instantie van de (andere) service te bepalen**]. Om recursie mogelijk te maken mag een service ook 'zichzelf' aanroepen. De runtime consequentie is dan dat er een nieuwe instantie van dezelfde service ontstaat met een eigen datawolk. [**ook hier aangeven hoe die datawolk dan uit de datawolk van de aanroepende instantie ontstaat**].-}

-- wijzigen (editen) van relatie-extensies; dit vereist interactie met gebruikers. Dit modelleren we vooralsnog met behulp van rollen (i.e. symbolische namen voor gebruikers).

edits :: Service * Relation PRAGMA "Every invocation of " " may affect/change the extension of".
PURPOSE RELATION edits IN DUTCH
{+Een relatie wordt als 'editable' aangemerkt in een service specificatie omdat degene die de service specificeert vindt dat dit bijdraagt aan het doel waartoe de service dient. De runtime consequentie hiervan is dat (runtime) instanties van deze service de extensie van elke relatie die 'editable' is binnen de service, kan wijzigen. Daarbij is een wijziging ofwel het aanmaken van feiten in die extensie, het veranderen van in de extensie bestaande feiten of het verwijderen van feiten.-}

roleSvc :: Role * Service PRAGMA "Every actor that has been assigned "  " is allowed to access/invoke ".
PURPOSE RELATION roleSvc IN DUTCH
{+Een rol wordt toegekend aan een service (of omgekeerd wordt een service toegekend aan een rol) om werkverdelingen te kunnen maken. Het toekennen van een rol aan een service heeft als runtime consequentie dat de service mag worden aangeroepen (uitgevoerd) in een sessie van een actor die deze rol vervult.-}

mayEdit :: Role * Relation PRAGMA "Every actor that has been assigned " " is allowed to affect/change the extension of".
PURPOSE RELATION mayEdit IN DUTCH
{+Voor elke rol wordt (in eerste instantie op de tekentafel, later ook door beheerders) vastgelegd welke relaties mogen worden ge-edit door (actoren die) de rol (vervullen). -}

RULE "noneditable relations": I |- edits~; edits
PURPOSE RULE "noneditable relations" IN DUTCH
{+De extensie van sommige relaties zal regelmatig moeten worden gewijzigd, en van andere relaties niet. Daarom moet er tenminste 1 rol bestaan waarvan de spelers de extensie kunnen wijzigen.-}

RULE "editCompletion": roleSvc~; mayEdit |- edits
PHRASE "Stef, dit is wat er echt staat: Voor elk paar (service, relatie) geldt dat als er een rol bestaat die de service mag aanroepen en de relatie mag editen, het gevolg hiervan is dat de service deze relatie moet kunnen editen. Dat lijkt me niet de bedoeling."
PHRASE "Voor elke rol ligt vast in welke relaties ge-edit mag worden. Ook ligt vast welke services deze rol mag gebruiken. Dit tesamen bepaalt welke relaties in een service editable zijn."
PURPOSE RULE "editCompletion" IN DUTCH
{+-}

RULE editPermission: roleSvc; edits = mayEdit
PHRASE "Als een rol een service mag aanroepen waarin een relatie wordt ge-edit, dient deze rol daarvoor gemachtigd te zijn. Omgekeerd geldt ook dat als een rol gemachtigd is om een relatie te editen, dan moet er een service bestaan waarin hij dat kan doen."

roleSig :: Role * Signal PRAGMA "One purpose the existence of " " is to restore compliance with ".
PURPOSE RELATION roleSvc IN DUTCH
{+-}

restores :: Service * Signal PRAGMA "One purpose of the existence of " " is to restore compliance with".
PURPOSE RELATION roleSig IN DUTCH
{+-}

RULE restoreSignal: roleSvc~; roleSig |- restores
I |- restores~; restores
PHRASE "Als een rol een service mag aanroepen die ertoe dient om een regelovertreding op te heffen, dan moet ook de rol dat als doel toegekend hebben gekregen. Omgekeerd geldt ook dat als een rol ertoe dient om een signaal te beheren, er ook een service moet bestaan die dit tot doel heeft."

ENDPATTERN