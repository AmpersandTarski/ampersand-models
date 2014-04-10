CONTEXT Toewijzing 
PURPOSE PATTERN Toewijzing
	{+
		Deze paragraaf beschrijft hoe de toewijzing is geformuleerd.
		De definities en afspraken die beschreven zijn zullen niet met de business besproken worden.
		Ze zijn echter wel benodigd om het model valide te maken.		
	-}

PATTERN Toewijzing
	
	-----------------------------------------------------------
    --        ISA relaties
    -----------------------------------------------------------
    CLASSIFY Toewijzing ISA Gebeurtenis
  
  
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