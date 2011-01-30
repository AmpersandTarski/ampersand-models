------------------------------------------------------
PATTERN Assets -- WIJZIGER: rieks.joosten@tno.nl
--! USES: Holons.pat
-- Markup uses `reStructuredTexts <http://docutils.sourceforge.net/docs/user/rst/quickref.html>`__

CONCEPT Asset "one (of possibly many) implementation of a function."
PURPOSE CONCEPT Asset IN ENGLISH
{+For an organization, its departments, processes, applications, systems, buildings, employees, customers, providers, etc. are all of value, and hence an asset. For example, the financial department is valuable to the organization that is part of because its function (keeping track of spendings, income, balancing them and such) contributes to the sustained existence of the organization. Similarly, employees are important because they do the work aimed at fulfilling the organizations mission Computer applications are important because they support the employees, customers and others in doing their work efficiently."-}
EXPLAIN CONCEPT Asset IN ENGLISH
{+The traditional definition of 'asset' as being anything of value for the business' must be specified more precisely so as to know what real world things are assets, and which are not. Also, a more precise definition is required in order to identify assets and distinguish between assets, not only for the present, but for the future as well. We define an asset as the combination of a (business) function (the execution of which generating value for the business) and a specific configuration of real-world things that together are capable of executing this function. We also use the term 'asset' to refer to specifications or ideas about configurations that do not yet exist, yet are considered in the process of building a new asset or revising (changing, updating) an existing one.-}

GEN Asset ISA Holon
{- Assets are Holons to ensure that 

- they are managed, i.e. there is a role (e.g. owner, manager) to which responsibilities with resepct to the asset are assigned;
- there are specifications that the asset is required to fulfill/abide by; such specifications define the function that the asset is required to perform.
-}

holonAsset :: Holon * Asset PRAGMA "" " considers " " to be of value for itself".
EXPLAIN RELATION holonAsset IN ENGLISH
{+Holons may rely on processes, people, systems, etc. to help them implement their own functionality. Thus, such processes, people, systems etc. are of value to such a holon and hence are considered assets to that holon. The expectations that a holon has of an asset should imply the function that the holon requires the asset to fulfill.-}

CONCEPT Function "the capability of producing specific (in)tangible results."
GEN Function ISA Holon
{- Functions are Holons to ensure that 

- they are managed, i.e. there is a role (e.g. owner, manager) to which responsibilities with resepct to the function are assigned. Note that this responsibility is constrained to the function to be performed. Therefore, care should be taken to minimize any specification with respect to specific individuals or materials or ways of doing things.
- there are specifications that the asset is required to fulfill/abide by; such specifications define the function that the asset is required to perform.
-}

function :: Asset -> Function PRAGMA "" " is een specifieke implementatie (realisatie) van ".
PURPOSE RELATION function IN DUTCH
{+Als we zeggen dat een Asset bij een functie hoort, dan bedoelen we dat deze Asset ooit heeft bestaan (en misschien nog bestaat) met de bedoeling om deze functie (operationeel) te realiseren. Zolang als oudere versies van die Asset bewaard blijven, moet de koppeling naar het functie ook bewaard blijven.
-}

version :: Asset -> Version PRAGMA "Het versienummer van" "is".
PURPOSE RELATION version IN DUTCH
{+Om de bestaansvolgorde van assets in de tijd te registreren, is aan elke asset een versie toegekend.-}

subversion :: Asset * SubVersion [UNI] PRAGMA "" "wordt door " " onderscheiden van andere assets die dezelfde functionaliteit implementeren en hetzelfde versienummer hebben".
PURPOSE RELATION subversion IN DUTCH
{+De implementatie van functionaliteiten verandert in de loop der tijd, bijvoorbeeld om bugs te fixen, om veranderingen in de onderliggende technologie te kunnen accommoderen of werkwijzes aan te kunnen passen aan voortschrijdende inzichten. Hoe de nieuwe implementatie er uit gaat zien is meestal een besluit waarin een aantal alternatieve implementaties met elkaar worden vergeleken. Om deze alternatieve implementaties, die gekenmerkt worden doordat ze dezelfde functie implementeren en hetzelfde versienummer hebben, toch van elkaar te onderscheiden, krijgt elk een subversienummer toegekend.-}
RULE subversions MAINTAINS function;function~ /\ version;version~ /\ -I |- subversion;I-;subversion~
EXPLANATION "Elke twee assets die dezelfde functie implementeren en hetzelfde versienummer hebben worden van elkaar onderscheiden door middel van (onderling verschillende) subversienummers."
PURPOSE RULE subversions IN ENGLISH
{+De implementatie van functionaliteiten verandert in de loop der tijd, bijvoorbeeld om bugs te fixen, om veranderingen in de onderliggende technologie te kunnen accommoderen of werkwijzes aan te kunnen passen aan voortschrijdende inzichten. Hoe de nieuwe implementatie er uit gaat zien is meestal een besluit waarin een aantal alternatieve implementaties met elkaar worden vergeleken. Om deze alternatieve implementaties, die gekenmerkt worden doordat ze dezelfde functie implementeren en hetzelfde versienummer hebben, toch van elkaar te onderscheiden, moeten ze onderscheiden kunnen worden. Daarom moet elk paar assets dat dezelfde functie implementeert en hetzelfde versienummer heeft, onderling verschillende subversienummers moeten hebben.-}

RULE keyAsset MAINTAINS (I/\-(subversion;subversion~));(function;function~ /\ version;version~) \/ (I/\subversion;subversion~);(function;function~ /\ version;version~ /\ subversion;subversion~) |- I
EXPLANATION "Elke (mogelijkje) implementatie van een functie is uniek gekarakteriseerd door de functie, het versienummer en - zo die bestaat - het subversienummer. Dit wil zeggen dat als de functie en het versienummer vastliggen, dan is er ofwel 1 asset of zijn er meerdere assets die van elkaar worden onderscheiden middels een subversienummer."

decided :: Asset * Asset [SYM,ASY] PRAGMA "" " is vastgesteld".
PURPOSE RELATION decided IN DUTCH
{+De implementatie van functionaliteiten verandert in de loop der tijd, bijvoorbeeld om bugs te fixen, om veranderingen in de onderliggende technologie te kunnen accommoderen of werkwijzes aan te kunnen passen aan voortschrijdende inzichten. Hoe de nieuwe implementatie er uit gaat zien is meestal een besluit waarin een aantal alternatieve implementaties met elkaar worden vergeleken om op grond daarvan te besluiten met welk van deze alternatieven het 'leven' van de functie moet worden voortgezet. Een asset die is vastgesteld (decided) is die welke is gekozen om de functie ervan mee voort te zetten.-}
asset :: Function * Asset [UNI] PRAGMA "" " wordt op het actuele (huidige) moment operationeel gerealiseerd door ".
PURPOSE RELATION asset IN DUTCH
{+Een functie wordt geoperationaliseerd door hoogstens 1 asset. Een nog niet geoperationaliseerde functie wordt geacht in ontwikkeling (onder constructie) te zijn. De realisatie van een operationele functie, d.w.z. de asset die op dat moment de feitelijke functionaliteit levert, kan echter ook worden veranderd of aangepast, bijvoorbeeld om bugs te fixen of procedurele wijzigingen (die immers de functie niet aantasten) te accommoderen. Veranderingen in de implementatie worden kenbaar als een verandering in het versienummer. Om de operationele asset van een functie te kunnen terugvinden wijst  deze relatie de operationele asset aan voor de betreffende functie.-}
{-De tekst die hier eerst stond hoorde op het proceslevel thuis en moet daar dan ook komen te staan:
Als een assets vervangen wordt, is dat kenbaar doordat het versie van (de asset die aan) de functie (is gerelateerd) een opvolgende waarde krijgt. We willen dan dat de functie te allen tijde naar de jongste functie verwijst.-}
RULE "decision" MAINTAINS asset |- asset;decided
EXPLANATION "Het vaststellen dat een functie operationeel gerealiseerd wordt door een asset impliceert dat die asset uit alle mogelijk alternatieven is geslecteerd om het 'leven' van de functie mee voort te zetten."
RULE "actuele asset" MAINTAINS version~;decided;function;asset;decided;version |- isLagereVersieDan \/ I[Version]
PURPOSE RULE "actuele asset" IN DUTCH
{+Op elk moment moet een functie verwijzen naar zijn actuele asset, d.w.z. de asset die op dat moment gebruikt wordt om de door de functie gespecificeerde resultaten operationeel te realiseren. De afspraak is dat de operationeel in gebruik zijnde asset voor een zekere functie die is, welke het hoogste versienummer heeft van alle voor die functie vastgestelde assets.-}
PURPOSE RULE "actuele asset" IN ENGLISH
{+On any given moment in time, a function must refer to its most recent asset.
That is why the relation 'asset' points to the most recent asset of a function."-}

isDirecteVoorgangerVanAsset :: Asset * Asset [UNI,ASY] PRAGMA "" "is de directe voorganger van".
PURPOSE RELATION isDirecteVoorgangerVanAsset IN DUTCH
{+Door de opeenvolging van assets te registreren onstaat een basis op grond waarvan we zullen kunnen natrekken hoe de asset van een functie tot stand is gekomen in de loop van de geschiedenis, althans voor zover de registratie van opeenvolgende assets reikt.-}
RULE "isDirecteVoorgangerVanAsset is irreflexief" MAINTAINS isDirecteVoorgangerVanAsset |- -I
RULE "voorganger" MAINTAINS isDirecteVoorgangerVanAsset = version;isDirecteVoorgangerVanVersie;version~ /\ function;function~
EXPLANATION "Asset X is de voorganger van Asset Y als beiden dezelfde functie implementeren en het versienummer van X direct voorafgaat aan dat van Y."
PURPOSE RULE "voorganger" IN DUTCH
{+Van elke Asset moet traceerbaar zijn volgens welk pad van bewerkingen/veranderingen die Asset tot stand is gekomen. Daartoe moet van elke Asset diens directe voorganger bekend zijn. Deze directe voorganger is de Asset die het direct aan het versienummer voorafgaande versienummer heeft, en dezelfde functie implementeert.-}
RULE "voorgangers zijn vastgesteld" MAINTAINS isDirecteVoorgangerVanAsset;isDirecteVoorgangerVanAsset~ |- decided
EXPLANATION "Een asset kan alleen worden 'opgevolgd' als hij is vastgesteld."
PURPOSE RULE "voorgangers zijn vastgesteld" IN DUTCH
{+Het kan zijn dat een asset wordt ingericht op basis van, of ter vervanging van een reeds bestaande. Om te voorkomen dat assets worden ingericht op basis van bestaande assets die nooit zijn geoperationaliseerd, verlangen we dat dit 'voortborduren op' alleen kan op basis van assets die zijn vastgesteld.-}

isIndirecteVoorgangerVan :: Asset * Asset [ASY] PRAGMA "" "is een (van de mogelijk meerdere) directe opvolger van".
PURPOSE RELATION isIndirecteVoorgangerVan IN DUTCH
{+Om van elke asset te kunnen achterhalen hoe zijn geschiedenis is gelopen, moet een ononderbroken 'keten' van assets worden geconstrueerd, althans voor zover de geschiedenis is opgeslagen.-}
RULE "isIndirecteVoorgangerVan is irreflexief" MAINTAINS isIndirecteVoorgangerVan |- -I
RULE "historie" MAINTAINS isDirecteVoorgangerVanAsset;(I \/ isIndirecteVoorgangerVan) |- isIndirecteVoorgangerVan
EXPLANATION "de historie van een asset bestaat uit alle directe en indirecte voorgangers van die asset."
PURPOSE RULE "historie" IN DUTCH
{+Een asset registratie met historie bevat niet alleen gegevens over alle operationele assets, maar ook over die welke daaraan zijn voorafgegaan (tot op zekere hoogte althans) en ook over assets die nog 'onder constructie' zijn. Deze assets zijn dus via historische links aan elkaar gerelateerd, en wel zodanig dat van elke functie de complete implemenatie geschiedenis kan worden gereconstrueerd tot aan een zeker tijdstip.-}

ENDPATTERN
------------------------------------------------------
PATTERN Versienummers -- WIJZIGER: rieks.joosten@tno.nl

CONCEPT Version "een representatie van de relatieve leeftijd van een asset ten opzichte van andere assets die dezelfde functie implementeren." ""
PURPOSE CONCEPT Version IN DUTCH
{+Versies (of versienummers) worden gebruikt om in de tijd elkaar opvolgende instanties van een functie (assets) of van een object van elkaar te kunnen onderscheiden.-}

isDirecteVoorgangerVanVersie :: Version * Version [UNI,ASY] PRAGMA "" "is de directe voorganger van " ", hetgeen wil zeggen dat er geen versie is die zowel groter dan de eerstgenoemde versie als kleiner dan de laatstgenoemde versie is".
PURPOSE RELATION isDirecteVoorgangerVanVersie IN DUTCH
{+Om vast te kunnen stellen dat van een een stuk functie-geschiedenis geen enkele verandering ontbreekt, moeten we de opeenvolging van assets kunnen natrekken. Dat kan alleen als  de volgorde van versienummers expliciet is vastgelegd. Merk op dat hoewel van elk versienummer vastgesteld moet kunnen worden wat zijn voorganger is, dit niet per se geldt voor zijn opvolger. Dat laat bijvoorbeeld toe dat van een zekere asset die niet meer voldoet, voor de volgende versie verschillende alternatieven kunnen worden beschouwd, die dan allemaal voornoemde asset als voorganger hebben.-}
RULE "isDirecteVoorgangerVanVersie irreflexief" MAINTAINS isDirecteVoorgangerVanVersie |- -I

isLagereVersieDan :: Version * Version [ASY] PRAGMA "" "bestond eerder dan".
PURPOSE RELATION isLagereVersieDan IN DUTCH
{+Versies hebben zin zolang we kunnen vaststellen voor elk tweetal versies welk van de twee ouder is.
Daarom bestaat een relatie "isLagereVersieDan", die aangeeft of een bijbehorende asset eerder bestond dan een andere.-}
RULE "isLagereVersieDan irreflexief" MAINTAINS isLagereVersieDan |- -I
RULE "isLagereVersieDan transitief" MAINTAINS isLagereVersieDan;isLagereVersieDan |- isLagereVersieDan

RULE "lagere versies" MAINTAINS (I \/ isLagereVersieDan);isDirecteVoorgangerVanVersie |- isLagereVersieDan

ENDPATTERN
------------------------------------------------------