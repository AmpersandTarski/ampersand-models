CONTEXT Taken 

PURPOSE PATTERN Taken
	{+
		Naast een wens om inzicht te krijgen in de klantverzoeken die binnenkomen, bestaan er ook een aantal wensen om inzicht te krijgen in de taken.
		Hierbij moet gedacht worden aan de behandelaar die met een taak bezig is. Welke acties heeft hij/zij met deze taak gedaan.
		Hoeveel taken staan nog open.
		
		VERDER INVULLEN
	
	-}

PATTERN Taken

	PURPOSE CONCEPT Behandelaar REF "Personeelsgids, begrippenlijst"
    {+ (niet logisch!!! Oplossing: waarom krijg ik nu een definitie van behandelaar?)
     Alleen medewerkers met toegang tot de NGA applicatie adidas kunnen taken oppakken en behandelen.
     Daarom definieren we het begrip behandelaar binnen deze grens.
     Een behandelaar kan alle taken oppakken, echter bepaalde taken dienen gefiatteerd te worden.
     Een behandelaar kan op enig moment maximaal 1 rol vervullen binnen een team.
    -}
    CONCEPT Behandelaar "Een behandelaar is een medewerker die toegang heeft tot de applicatie adidas" "DFO NGA Generieke functionaliteit medewerkerapplicatie."
		
	PURPOSE CONCEPT Taak REF "DFO NGA Generieke functionaliteit medewerkerapplicatie"
    {+

    -}
    CONCEPT Taak "Een taak is datgene dat de behandelaar in zijn werklijst ziet als werk dat hij of zij moet doen." "DFO NGA Generieke functionaliteit medewerkerapplicatie."

    PURPOSE CONCEPT Status REF "DFO NGA Generieke functionaliteit medewerkerapplicatie"
    {+

    -}
    CONCEPT Status "De status geeft aan in welke toestand een klantverzoek of taak zich bevindt" "DFO NGA Generieke functionaliteit medewerkerapplicatie."

    PURPOSE CONCEPT Team REF "DFO NGA Generieke functionaliteit medewerkerapplicatie"
    {+

    -}
    CONCEPT Team "Een team is een groep van behandelaars met dezelfde verantwoordelijkheden" "DFO NGA Generieke functionaliteit medewerkerapplicatie."


     PURPOSE CONCEPT Rol REF "DFO NGA Generieke functionaliteit medewerkerapplicatie"
        {+
          Het DFO onderkent de volgende rollen binnen een team: Teamleider, Senior medewerker, Medior medewerker en Junior medewerker. 
        -}
     
     CONCEPT Rol "De behandelaar heeft binnen een team altijd een rol waarmee zijn bevoegdheden vastliggen."
     --KEY Rol : Rol(bevatRol~, TXT " ", bevatRol~;bevatRol)

     PURPOSE CONCEPT Prioriteit REF "DFO NGA Generieke functionaliteit medewerkerapplicatie"
        {+
          Mochten er meerdere taken aan één behandelaar zijn toegewezen, dan geldt de volgorde van oppakken zoals aangegeven in de prioriteitentabel. 
          Elk taaktype heeft een prioriteit. 
          Deze prioriteit loopt van 1 t/m 5 waarbij 5 de hoogste prioriteit heeft en 1 de laagste. 
        -}
     CONCEPT Prioriteit "De prioriteit geeft aan wat de volgorde is waarop taken behandeld moeten worden."

     PURPOSE CONCEPT Taaktype REF "DFO NGA Generieke functionaliteit medewerkerapplicatie"
        {+
          Het concept taaktype geeft aan op welke situatie de taak betrekking heeft.
          Hiermee kan bijvoorbeeld onderscheid gemaakt worden tussen taken voor uitval offerte, uitval claim of toekennen commerciele korting.
        -}
     CONCEPT Taaktype "Een taaktype is een categorie waarin taken worden ingedeeld, op basis waarvan werktoewijzing kan plaatsvinden."

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

    -}
    RELATION hoortBij[Taak*Klantverzoek] [UNI,TOT]
    PRAGMA "" " hoort bij "
    MEANING "De uitspraak ``Taak $t$ hoort bij klantverzoek $a$.'' behoort tot de gemeenschappelijke taal."

	 -----------------------------------------------------------
    --        De relatie heeftEen
    -----------------------------------------------------------
    PURPOSE RELATION heeftEen[Taak*Status] REF "DFO NGA Generieke functionaliteit medewerkerapplicatie"
    {+

    -}
    RELATION heeftEen[Taak*Status]
    PRAGMA "" " heeft een de status "
    MEANING "De uitspraak ``Taak $t$ heeft status $s$.'' behoort tot de gemeenschappelijke taal."


     -----------------------------------------------------------
    --        De relatie heeftPrioriteit
    -----------------------------------------------------------
    PURPOSE RELATION heeftPrioriteit[Taak*Prioriteit] REF ""
    {+

    -}
    RELATION heeftPrioriteit[Taak*Prioriteit]
    PRAGMA "" " heeft de prioriteit "
    MEANING "De uitspraak ``Taak $t$ heeft prioriteit $p$.'' behoort tot de gemeenschappelijke taal."

     -----------------------------------------------------------
    --        De relatie heeftRol
    -----------------------------------------------------------
    PURPOSE RELATION heeftRol[Behandelaar*Rol] REF ""
    {+

    -}
    RELATION heeftRol[Behandelaar*Rol]
    PRAGMA "" " heeft de rol "
    MEANING "De uitspraak ``Behandelaar $b$ heeft de rol $r$.'' behoort tot de gemeenschappelijke taal."


     -----------------------------------------------------------
    --        De relatie bevatRol
    -----------------------------------------------------------
    PURPOSE RELATION bevatRol[Team*Rol] REF ""
    {+

    -}
    RELATION bevatRol[Team*Rol]
    PRAGMA "" " bevat de rol "
    MEANING "De uitspraak ``Team $t$ bevat de rol $r$.'' behoort tot de gemeenschappelijke taal."


     ----------------------------------------------------------
    --        De relatie isVanType
    -----------------------------------------------------------
    PURPOSE RELATION isVanType[Taak*Taaktype] REF ""
    {+

    -}
    RELATION isVanType[Taak*Taaktype]
    PRAGMA "" " is van type "
    MEANING "De uitspraak ``Taak $t$ is van type $y$.'' behoort tot de gemeenschappelijke taal."

	-----------------------------------------------------------
    --        De relatie ingedeeldIn
    -----------------------------------------------------------
    PURPOSE RELATION ingedeeldIn[Behandelaar*Team] REF "xxx"
    {+

    -}
    RELATION ingedeeldIn[Behandelaar*Team]  [UNI,TOT]
    PRAGMA "" " is ingedeeld in het team "
    MEANING "De uitspraak ``Behandelaar $m$ is ingedeeld in team $t$.'' behoort tot de gemeenschappelijke taal."
	
	-----------------------------------------------------------
    --        De relatie behandeld
    --     FIXME is de relatie nog nodig????????????????
    -----------------------------------------------------------
    PURPOSE RELATION behandeld[Behandelaar*Taak] REF "DFO NGA Generieke functionaliteit medewerkerapplicatie"
    {+

    -}
    RELATION behandeld[Behandelaar*Taak]  [UNI]
    PRAGMA "" " behandeld de taak "
    MEANING "De uitspraak ``Behandelaar $m$ behandelt taak $t$.'' behoort tot de gemeenschappelijke taal."

	
ENDPATTERN

ENDCONTEXT