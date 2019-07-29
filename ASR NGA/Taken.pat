CONTEXT Taken 

PURPOSE PATTERN Taken
	{+
		Naast een wens om inzicht te krijgen in de klantverzoeken die binnenkomen, bestaan er ook een aantal wensen om inzicht te krijgen in de taken.
		In deze paragraaf wordt hier verder op ingegaan. 
	
	-}

PATTERN Taken

	PURPOSE CONCEPT Behandelaar REF "Personeelsgids, begrippenlijst"
    {+ 
		Alleen medewerkers met toegang tot de NGA applicatie adidas kunnen taken oppakken en behandelen.
    -}
    CONCEPT Behandelaar "Een behandelaar is een medewerker die toegang heeft tot de applicatie adidas en taken kan oppakken." "DFO NGA Generieke functionaliteit medewerkerapplicatie"
		
	PURPOSE CONCEPT Taak REF "DFO NGA Generieke functionaliteit medewerkerapplicatie"
    {+

    -}
    CONCEPT Taak "Een taak is een item in de werklijst van een behandelaar." "DFO NGA Generieke functionaliteit medewerkerapplicatie"

    PURPOSE CONCEPT Status REF "DFO NGA Generieke functionaliteit medewerkerapplicatie"
    {+

    -}
    CONCEPT Status "De status geeft aan in welke toestand een klantverzoek of taak zich bevindt" "DFO NGA Generieke functionaliteit medewerkerapplicatie"

    PURPOSE CONCEPT Team REF "DFO NGA Generieke functionaliteit medewerkerapplicatie"
    {+

    -}
    CONCEPT Team "Een team is een groep van behandelaars met dezelfde verantwoordelijkheden." "DFO NGA Generieke functionaliteit medewerkerapplicatie"


     PURPOSE CONCEPT Rol REF "DFO NGA Generieke functionaliteit medewerkerapplicatie"
        {+
          De volgende rollen worden binnen een team onderkend: Teamleider, Senior medewerker, Medior medewerker en Junior medewerker. 
        -}
     
     CONCEPT Rol "De rol geeft aan wat de bevoegdheden van de behandelaar zijn." "DFO NGA Generieke functionaliteit medewerkerapplicatie"

     --KEY Rol : Rol(bevatRol~, TXT " ", bevatRol~;bevatRol)

     PURPOSE CONCEPT Prioriteit REF "DFO NGA Generieke functionaliteit medewerkerapplicatie"
        {+
		  Mochten er meerdere taken aan Ã©Ã©n behandelaar zijn toegewezen, dan worden deze behandeld in volgorde van prioriteit. 
          Deze prioriteit loopt van 1 t/m 5 waarbij 5 de hoogste prioriteit heeft en 1 de laagste. 
        -}
     CONCEPT Prioriteit "De prioriteit geeft aan wat de volgorde is waarin taken behandeld moeten worden." "DFO NGA Generieke functionaliteit medewerkerapplicatie."

     PURPOSE CONCEPT Taaktype REF "DFO NGA Generieke functionaliteit medewerkerapplicatie"
        {+
          Het concept taaktype geeft aan op welke situatie de taak betrekking heeft.
          Hiermee kan bijvoorbeeld onderscheid gemaakt worden tussen taken voor uitval offerte, uitval claim of toekennen commerciele korting.
        -}
     CONCEPT Taaktype "Het taaktype geeft aan voor welke situatie de taak aangemaakt is." "DFO NGA Generieke functionaliteit medewerkerapplicatie"

	-----------------------------------------------------------
    --        ISA relaties
    -----------------------------------------------------------
    
	
	-----------------------------------------------------------
    --        Relaties
    -----------------------------------------------------------
    
	-----------------------------------------------------------
    --        De relatie hoortBij
    -----------------------------------------------------------
    PURPOSE RELATION hoortBij[Taak*Klantverzoek] REF ""
    {+
		 Na deze opsomming van definities volgt een uiteenzetting over de afspraken, die betekenis geven aan de taal van 'Managementinformatie over klantverzoeken en taken'.
        Waar mogelijk geven we bij elke zin of deel daarvan een aantal voorbeelden (frasen genaamd) van het gebruik van deze zin.
    -}
    RELATION hoortBij[Taak*Klantverzoek] [UNI,TOT]
    PRAGMA "" " hoort bij de "
    MEANING "De uitspraak ``Taak $t$ hoort bij klantverzoek $a$.'' behoort tot de gemeenschappelijke taal."

	 -----------------------------------------------------------
    --        De relatie heeftEen
    -----------------------------------------------------------
    PURPOSE RELATION heeftEen[Taak*Status] REF "DFO NGA Generieke functionaliteit medewerkerapplicatie"
    {+

    -}
    RELATION heeftEen[Taak*Status]
    PRAGMA "" " heeft de status "
    MEANING "De uitspraak ``Taak $t$ heeft de status $s$.'' behoort tot de gemeenschappelijke taal."


     -----------------------------------------------------------
    --        De relatie heeftPrioriteit
    -----------------------------------------------------------
    PURPOSE RELATION heeftPrioriteit[Taak*Prioriteit] REF "DFO NGA Generieke functionaliteit medewerkerapplicatie"
    {+

    -}
    RELATION heeftPrioriteit[Taak*Prioriteit]
    PRAGMA "" " heeft de prioriteit "
    MEANING "De uitspraak ``Taak $t$ heeft de prioriteit $p$.'' behoort tot de gemeenschappelijke taal."

     -----------------------------------------------------------
    --        De relatie heeftRol
    -----------------------------------------------------------
    PURPOSE RELATION heeftRol[Behandelaar*Rol] REF "DFO NGA Generieke functionaliteit medewerkerapplicatie"
    {+

    -}
    RELATION heeftRol[Behandelaar*Rol]
    PRAGMA "" " heeft de rol "
    MEANING "De uitspraak ``Behandelaar $b$ heeft de rol $r$.'' behoort tot de gemeenschappelijke taal."


     -----------------------------------------------------------
    --        De relatie bevatRol
    -----------------------------------------------------------
    PURPOSE RELATION bevatRol[Team*Rol] REF "DFO NGA Generieke functionaliteit medewerkerapplicatie"
    {+

    -}
    RELATION bevatRol[Team*Rol]
    PRAGMA "" " bevat de rol "
    MEANING "De uitspraak ``Team $t$ bevat de rol $r$.'' behoort tot de gemeenschappelijke taal."


     ----------------------------------------------------------
    --        De relatie isVanType
    -----------------------------------------------------------
    PURPOSE RELATION isVanType[Taak*Taaktype] REF "DFO NGA Generieke functionaliteit medewerkerapplicatie"
    {+

    -}
    RELATION isVanType[Taak*Taaktype]
    PRAGMA "" " is van type "
    MEANING "De uitspraak ``Taak $t$ is van type $y$.'' behoort tot de gemeenschappelijke taal."

	-----------------------------------------------------------
    --        De relatie ingedeeldIn
    -----------------------------------------------------------
    PURPOSE RELATION ingedeeldIn[Behandelaar*Team] REF "DFO NGA Generieke functionaliteit medewerkerapplicatie"
    {+

    -}
    RELATION ingedeeldIn[Behandelaar*Team]  [UNI,TOT]
    PRAGMA "" " is ingedeeld in het team "
    MEANING "De uitspraak ``Behandelaar $b$ is ingedeeld in team $t$.'' behoort tot de gemeenschappelijke taal."
	
	-----------------------------------------------------------
    --        De relatie behandeld
    --     FIXME is de relatie nog nodig????????????????
    -----------------------------------------------------------
    PURPOSE RELATION behandeld[Behandelaar*Taak] REF "DFO NGA Generieke functionaliteit medewerkerapplicatie"
    {+

    -}
    RELATION behandeld[Behandelaar*Taak]  [UNI]
    PRAGMA "" " behandelt de taak "
    MEANING "De uitspraak ``Behandelaar $b$ behandelt taak $t$.'' behoort tot de gemeenschappelijke taal."

	
ENDPATTERN

ENDCONTEXT