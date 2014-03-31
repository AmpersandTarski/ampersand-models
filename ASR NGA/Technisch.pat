CONTEXT Technisch 
PURPOSE PATTERN "Ondersteunende concepten en relaties"
	{+
		Deze paragraaf is bedoeld om de definities en afspraken die nodig zijn om het onderliggend model valide te maken een plaats te geven.
		De beschreven definties en afspraken zullen niet met de business besproken worden. 
	
	-}

PATTERN "Ondersteunende concepten en relaties"

	PURPOSE CONCEPT Offerte REF "Requirements overzicht.ppt"
    {+

    -}
    CONCEPT Offerte "Het verzoek tot een offerte van een AOV en/of een ziektekosten Producttype(en)" "Requirements overzicht.ppt"

    PURPOSE CONCEPT ContractAanvraag REF "LSD DAVPAC ContractApplication, LSD INC ContractApplication"
    {+

    -}
    CONCEPT ContractAanvraag "Het verzoek tot het afsluiten van een AOV en/of een ziektekostencontract" "Requirements overzicht.ppt"

    PURPOSE CONCEPT AdministratieveWijziging REF "LSD DAVPAC Endorsment"
    {+

    -}
    CONCEPT AdministratieveWijziging "Het verzoek tot een administratieve wijziging" "Requirements overzicht.ppt"

    PURPOSE CONCEPT EersteZiektemelding REF "LSD INC ClaimApplication"
    {+

    -}
    CONCEPT EersteZiektemelding "Een eersteZiekteMelding, is een ziekmelding die doorgegeven wordt 48 uur na 1e ziektedag." "Requirements overzicht.ppt"


	PURPOSE CONCEPT Statusovergang REF "Ampersand"
        {+
          Het concept Statusovergang wordt gebruikt om het moment vast te leggen waarop een toestand overgaat naar een nieuwe toestand.
          Hiermee kan historische informatie over de relatie opgebouwd worden.
          Daarmee kan opgevraagd worden wat de toestand van de huidige relatie is, maar ook wat de vorige toestand van de relatie was.
        -}
    CONCEPT Statusovergang "Een Statusovergang geeft informatie over de huidige status en de vorige status van een klantverzoek of taak."
	
	PURPOSE CONCEPT Toewijzing REF "Ampersand"
		{+
		  Het concept toewijzing wordt gebruikt om aan te geven aan wie een taak is toegewezen
		-}
	CONCEPT Toewijzing "Een Statusovergang geeft informatie over de huidige status en de vorige status van een klantverzoek of taak."
	
    CONCEPT Gebeurtenis "Een Gebeurtenis bevat de toestand van een relatie op een bepaald moment in de tijd."
        
    CONCEPT Tijdstip "Het moment waarop een statusovergang of toewijzing heeft plaatsgevonden."
    
	-----------------------------------------------------------
    --        ISA relaties      
    -----------------------------------------------------------  
    CLASSIFY Statusovergang ISA Gebeurtenis
    --CLASSIFY Toewijzing ISA Gebeurtenis

	--CLASSIFY ContractAanvraag ISA Klantverzoek
    --CLASSIFY Offerte ISA Klantverzoek
    --CLASSIFY EersteZiektemelding ISA Klantverzoek
    --CLASSIFY AdministratieveWijziging ISA Klantverzoek

	
	-----------------------------------------------------------
    --        Relaties
    -----------------------------------------------------------
	
	-----------------------------------------------------------
    --        De relatie vorige
    -----------------------------------------------------------
    PURPOSE RELATION vorige[Statusovergang*Status] REF ""
    {+

    -}
    RELATION vorige[Statusovergang*Status] [UNI]
    PRAGMA "" " is overgegaan van "
    MEANING "De uitspraak ``Statusovergang $t$ heeft als vorige status $s$.'' behoort tot de gemeenschappelijke taal."

    -----------------------------------------------------------
    --        De relatie huidige
    -----------------------------------------------------------
    PURPOSE RELATION huidige[Statusovergang*Status] REF ""
    {+

    -}
    RELATION huidige[Statusovergang*Status] [UNI]
    PRAGMA "" " is overgegaan naar "
    MEANING "De uitspraak ``Statusovergang $t$ heeft als huidige status $s$.'' behoort tot de gemeenschappelijke taal."

    -----------------------------------------------------------
    --        De relatie taakRelevant
    -----------------------------------------------------------
    PURPOSE RELATION taakRelevant[Taak*Statusovergang] REF ""
    {+

    -}
    RELATION taakRelevant[Taak*Statusovergang]
    PRAGMA "" " heeft een taakrelevante statusovergang "
    MEANING "De uitspraak ``Taak $t$ heeft statusovergang $s$.'' behoort tot de gemeenschappelijke taal."

	-----------------------------------------------------------
    --        De relatie heeftPlaatsgevondenOp
    -----------------------------------------------------------
    PURPOSE RELATION heeftPlaatsgevondenOp[Gebeurtenis*Tijdstip] REF "xxx"
    {+

    -}
    RELATION heeftPlaatsgevondenOp[Gebeurtenis*Tijdstip]  
    PRAGMA "" " heeft plaatsgevonden op "
    MEANING "De uitspraak ``Gebeurtenis $g$ heeft plaatsgevonden op tijdstip $t$.'' behoort tot de gemeenschappelijke taal."
    
    -----------------------------------------------------------
    --        De relatie teamTaak
    -----------------------------------------------------------
    PURPOSE RELATION isToegewezen[Taak*Toewijzing] REF ""
    {+

    -}
    RELATION isToegewezen[Taak*Toewijzing] 
    PRAGMA "" " is toegewezen aan "
    MEANING "De uitspraak ``Taak $t$ is toegewezen aan toewijzing $w$.'' behoort tot de gemeenschappelijke taal."


    -----------------------------------------------------------
    --        De relatie toegewezenAanTeam
    -----------------------------------------------------------
    PURPOSE RELATION toegewezenAanTeam[Toewijzing*Team] REF ""
    {+

    -}
    RELATION toegewezenAanTeam[Toewijzing*Team] [UNI,TOT]
    PRAGMA "" " is toegewezen aan team "
    MEANING "De uitspraak ``Taak $t$ is toegewezen aan team $x$.'' behoort tot de gemeenschappelijke taal."

    -----------------------------------------------------------
    --        De relatie toegewezenAanBehandelaar
    -----------------------------------------------------------
    PURPOSE RELATION toegewezenAanBehandelaar[Toewijzing*Behandelaar] REF ""
    {+

    -}
    RELATION toegewezenAanBehandelaar[Toewijzing*Behandelaar]  [UNI]
    PRAGMA "" " is toegewezen aan Behandelaar "
    MEANING "De uitspraak ``Taak $t$ is toegewezen aan Behandelaar $m$.'' behoort tot de gemeenschappelijke taal."
    


ENDPATTERN
ENDCONTEXT