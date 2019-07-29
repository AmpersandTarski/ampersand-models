{-----------------------------------------------------------------------
RJ/20100221: De Compliant Service Layer (CSL) is op het moment van schrijven, een in wezen ongeordende verzameling services met de eigenschap dat elk daarvan tijdens executie (a) een vz. regels afdwingt en (b) overtredingen van een (andere) vz. regels signaleert; voorts geldt voor de vz. regels als bedoeld onder (a) dat er voor de hele CSL slechts Ã©Ã©n zo'n vz. is. Ditzelfde geldt voor de vz. regels als bedoeld onder (b).
Het is al langer bekend dat deze situatie ongewenst is en dat in verschillende gevallen verschillende regelverzamelingen zijn die in stand gehouden moeten worden.
-}----------------------------------------------------------------------
PATTERN Proces --!EXTENDS Texts
-- Author(s) rieks.joosten@tno.nl
PURPOSE PATTERN Proces IN DUTCH 
{+ CONCEPT "Proces"
Onder een 'Proces' wordt verstaan:
a) een verzameling van (soorten) producten/dienstenresultaten die voor de organisatie een waarde vertegenwoordigen en die door middel van het uitvoeren van werk binnen het proces worden geproduceerd/geleverd;
b) een door de organisatie vastgestelde verzameling regels/invarianten die de grenzen afbakenen waarbinnen het werk zoals bedoeld onder a) moet worden gedaan, en die zo goed mogelijk moeten worden afgedwongen;
c) een door de organisatie gespecificeerde verzameling regels/invarianten die signaleren dat een ongewenste situatie is ontstaan dan wel dreigt te ontstaan, en wel zodanig dat bij elke signaalregel tenminste Ã©Ã©n Service is gespecificeerd die werkers ondersteunt bij het oplossen dan wel voorkomen van voornoemde situatie. Zie ook het concept 'Service'.-}

procesDescription :: Proces * Text [UNI] PRAGMA "" " wordt omschreven door middel van ".
resultProces :: Result -> Proces PRAGMA "" " wordt opgeleverd binnen ".
procesRule   :: Proces * Rule PRAGMA "Binnen " " wordt " " afgedwongen".

ENDPATTERN
----------------------------------------------------------------------
SERVICE NewProces : I[Session];sUser;userAssignedRole;'Procesontwerper';V[Role*Proces]
= [ "Proces (voluit)" : procesDescription
  , "Resulta(a)t(en)" : resultProces~
  , "Regels"          : procesRule
  ]
----------------------------------------------------------------------
PATTERN Service --!EXTENDS Texts
-- Author(s) rieks.joosten@tno.nl
{- CONCEPT "Service"
Onder een 'Service' van een proces wordt een expressie/regel/invariant verstaan waarvan overtredingen signaleren dat er binnen het proces een ongewenste situatie is ontstaan dan wel dreigt te ontstaan, samen met een [Body] die de werkers ondersteunt bij het oplossen dan wel voorkomen van voornoemde situatie.
-}

svcDescription :: Service * Text [UNI] PRAGMA "" " wordt omschreven door middel van ".
svcProces :: Service -> Proces PRAGMA "" " ondersteunt werkers bij het oplossen dan wel voorkomen van een ongewenste situatie binnen ".
svcRule :: Service -> Rule PRAGMA "" " dient ter oplossing van overtredingen van ".
svcBody :: Service -> Body PRAGMA "" " ondersteunt werkers bij het oplossen van overtredingen van de service regel middels ".

ENDPATTERN
----------------------------------------------------------------------
SERVICE NewService : I[Session];sUser;userAssignedRole;'Serviceontwerper';V[Role*Service]
= [ "Service (voluit)" : svcDescription
  , "Regel/invariant" : svcRule
  , "Body" : svcBody -- Dit zijn die dingen die we nu tussen '=[' en ']' aangeven. Dat moet nog verder worden uitgwerkt.
  ]

----------------------------------------------------------------------
PATTERN Decorum --!EXTENDS Service
 -- Author(s) rieks.joosten@tno.nl

CONCEPT "Decorum" "al hetgeen mensen op een willekeurig tijdstip kunnen overzien, en zich volgens Anderson beperkt tot 3 +/- 2 concepten (ideeen, zaken) met de bijbehorende attributen. Zodra dit meer wordt gaan mensen (volgens Anderson) fouten maken. Een van de belangrijkste manieren om mensen te faciliteren bij het uitvoeren van hun taken is dan ook om al hetgeen ze op enig moment kunnen doen, te beperken tot een overzichtelijk, herkenbaar en behapbaar geheel. Dit doet denken aan het decor van toneelstukken: het bakent de context af waarbinnen acteurs/actoren de handelingen verrichten (binnen de grenzen die het draaiboek daaraan stelt). Onder een 'Decorum' of 'Decor' verstaan we dan ook een presentatiewijze (bijvoorbeeld via een webpagina) waarbinnen een of meer services kunnen worden gebruikt die voor de actor/gebruiker een samenhangend geheel vormen. Elk Decor(um) is persoonsgebonden, hetgeen betekent dat elke persoon de inhoud van elk van zijn Decors bepaalt - uiteraard binnen de grenzen die daarbij door bedrijfsregels worden gesteld. Het idee is erg vergelijkbaar met iGoogle (http://www.google.nl/ig), waar individuen in de gelegenheid worden gesteld meerde pagina's (tabs) in te richten met 'gadgets'. Een iGoogle tab komt dan overeen met een Decor(um) en een gadget met een Service." "RJ"

decorumOwner   :: Decorum -> Person PRAGMA "" " bevat een groep services die voor " "  een nuttige samenhang vertonen".
decorumService :: Decorum * Service PRAGMA "" " bevat " " (definetime)".
decorumMenu    :: Decorum * Service PRAGMA "" " bevat " " (runtime)".
--decorumGUI   :: Decorum * GUI     "" " kan worden gebruikt via ".

GEN Decorum ISA Service

RULE decorumMenu |- decorumService MEANING "Het menu van een focus bevat alleen services waarvan expliciet is gespecificeerd dat ze de focus ondersteunen."
-- RULE: Een Decorum mag slechts worden uitgevoerd in sessies waarin het gebruikersaccount is gekoppeld aan de decorumOwner.
-- RULE: Elke service uit het decorumMenu heeft een niet-lege lijst van atomen om op te werken, of is in staat nieuwe atomen te maken (create)."

ENDPATTERN
----------------------------------------------------------------------