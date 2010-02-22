{-----------------------------------------------------------------------
RJ/20100221: De Compliant Service Layer (CSL) is op het moment van schrijven, een in wezen ongeordende verzameling services met de eigenschap dat elk daarvan tijdens executie (a) een vz. regels afdwingt en (b) overtredingen van een (andere) vz. regels signaleert; voorts geldt voor de vz. regels als bedoeld onder (a) dat er voor de hele CSL slechts één zo'n vz. is. Ditzelfde geldt voor de vz. regels als bedoeld onder (b).
Het is al langer bekend dat deze situatie ongewenst is en dat in verschillende gevallen verschillende regelverzamelingen zijn die in stand gehouden moeten worden.
-}----------------------------------------------------------------------
PATTERN Proces -- WIJZIGER: rieks.joosten@tno.nl
{- CONCEPT "Proces"
Onder een 'Proces' van een organisatie (domein) wordt verstaan:
a) een verzameling van (soorten) producten/dienstenresultaten die voor de organisatie een waarde vertegenwoordigen en die door middel van het uitvoeren van werk binnen het proces worden geproduceerd/geleverd;
b) een door de organisatie vastgestelde verzameling regels/invarianten die de grenzen afbakenen waarbinnen het werk zoals bedoeld onder a) moet worden gedaan, en die zo goed mogelijk moeten worden afgedwongen;
c) een door de organisatie gespecificeerde verzameling regels/invarianten die signaleren dat een ongewenste situatie is ontstaan dan wel dreigt te ontstaan, en wel zodanig dat bij elke signaalregel tenminste één Service is gespecificeerd die werkers ondersteunt bij het oplossen dan wel voorkomen van voornoemde situatie. Zie ook het concept 'Service'.
-}

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
PATTERN Service -- WIJZIGER: rieks.joosten@tno.nl
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
PATTERN Focus -- WIJZIGER: rieks.joosten@tno.nl
CONCEPT "Focus" "Mensen zijn op elk tijdstip gefocust op een beperkt aantal zaken/activiteiten die met een zeker onderwerp van doen hebben. Deze focus begrenst als het ware hun perceptievermogen waardoor ze in staat zijn geconcentreerd aan iets te werken. We faciliteren dit door aan een focus een of meer services te hangen die bij mens bij zo'n focus ondersteunt. Ook faciliteren we dit door focus-templates te maken, i.e. een focus met een aantal generiek bruikbare services daarvoor, die mensen dan kunnen overnemen en personificeren. Verder is het achterliggende idee dat aan elke focus een GUI hangt die de aan deze focus hangende services voor de focus-eigenaar ontsluit." "RJ"

focusOwner   :: Focus -> Person PRAGMA "" " bevat een groep services die voor " "  een nuttige samenhang vertonen".
focusService :: Focus * Service PRAGMA "" " bevat " " (definetime)".
focusMenu    :: Focus * Service PRAGMA "" " bevat " " (runtime)".
--focusGUI   :: Focus * GUI     PRAGMA "" " kan worden gebruikt via ".

GEN Focus ISA Service

focusMenu |- focusService EXPLANATION "Het menu van een focus bevat alleen services waarvan expliciet is gespecificeerd dat ze de focus ondersteunen."
-- RULE: Een focus mag slechts worden uitgevoerd in sessies waarin het gebruikersaccount is gekoppeld aan de focuseigenaar.
-- RULE: Elke service uit het focusMenu heeft een niet-lege lijst van atomen om op te werken, of is in staat nieuwe atomen te maken (create)."

ENDPATTERN
----------------------------------------------------------------------