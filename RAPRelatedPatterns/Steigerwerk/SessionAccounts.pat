PATTERN "People" -- WIJZIGER: rieks.joosten@tno.nl
PURPOSE PATTERN "People" IN ENGLISH
{+ This pattern is meant solely for the purpose to define the concept 'Person' so that other patterns can extend thereon as they see fit.
Note that this is wholly in line with the design discipline of creating basic patterns as the smallest you might think of,
and leaving any non-mandatory additions up to pattern extensions -}

CONCEPT "Person" "(a description of) an individual human being." "RJ"

ENDPATTERN
---------------------------------------------------------------------
PATTERN "PeopleExtensions" -- WIJZIGER: rieks.joosten@tno.nl
-- For the moment, we include a few items that we may use for identification purposes within sessions, or to contact people through email and/or (cell)phone

emailOf :: Emailaddr * Person PRAGMA "Emails sent to " " are expected to be received by ".
phoneOf :: Phonenumber * Person PRAGMA "The phone identified by " " is expected to be used by ".

iscalled :: Person * Text PRAGMA "Referring to " " is done e.g. by calling this person ".
PURPOSE RELATION iscalled IN ENGLISH
{+Symbols, labels, texts or other references that people use to refer to other people are called 'names' for such people. An individual generally has many names, which are used depending e.g. on context and social conventions.+}

anonymous :: Person * Person [SYM,ASY] PRAGMA "" " is said to be anonymous".
PURPOSE RELATION anonymous IN ENGLISH
{+When thinking about it, it is obvious that people exist that do not have a name, or of whom none of their names is known. People for which this is the case are said to by 'anonymous'.+}

RULE "anonymous people": anonymous = I /\ -(iscalled; iscalled~)
MEANING "Any person without a name has the property of being 'anonymous'."

RULE "unique emailaddrs": I[Person] = emailOf~;emailOf
MEANING "Within Personen zijn uniek gekarakteriseerd door hun email adres"

ENDPATTERN
---------------------------------------------------------------------
INTERFACE Persoon : I[Person] -- I[Session];sUser;userPerson;(I \/ personAssignedRole;'Beheerder';V[Role*Person])
-- Wijzigen van gegevens mag alleen door de beheerder of de persoon zelf.
= [ "Id"  : I[Person]
  , "name" : iscalled
  , "email addr" : emailOf~
  , "telefoonnr" : phoneOf~
  ]

INTERFACE Personen : I[Person] -- I[Session];sUser;V[UserAccount*Person]
-- gebruiker moet zijn ingelogd
= [ "Id"  : I[Person]
  , "name" : iscalled
  , "email addr" : emailOf~
  , "telefoonnr" : phoneOf~
  ]
---------------------------------------------------------------------
PATTERN "UserAccounts" -- WIJZIGER: rieks.joosten@tno.nl
PURPOSE PATTERN "UserAccounts" IN DUTCH
{+UserAccounts (of: Accounts) dienen ertoe om (samen met Rollen) de populaties te kunnen uitdunnen waarop SERVICEs werken tot hetgeen voor de persoon die is ingelogd, relevant is.+}

CONCEPT "UserAccount" "a set of properties (e.g. (at most one) Password, (any number of) Roles, (any number of) Persons) to be used in a session for limiting the set of actions (Services) that can be executed within that session." "RJ"
-- Toekomstige uitbreidingen: 'PersonalUserAccount' is een UserAccount waarvan mag worden aangenomen dat de relatie 'userPerson' functioneel is.

userPerson :: UserAccount * Person [UNI] PRAGMA "" " has been assigned to ".
userPassword :: UserAccount * Password [UNI] PRAGMA "" " mag alleen worden geactiveerd in een sessie als " " aan de andere kant van de sessie bekend is".

{- Het hiernavolgende mag pas als we echte expressies aan kunnen in regels...
Dan mag ook de 'UNI' weg bij 'userPerson'.
personalAccount :: UserAccount * UserAccount
personalAccount = (userPerson~;userPerson |- I) MEANING "Onder een 'personal seraccount' of 'personal account' verstaan we een account waaraan precies Ã©Ã©n Person is  gekoppeld."
-}
ENDPATTERN
---------------------------------------------------------------------
INTERFACE "User" : I[UserAccount] -- I[Session];sUser;(I \/ userPerson;personAssignedRole;'Beheerder';V[Role*UserAccount])
= [ "Accountverantwoordelijke (persoon)": userPerson
  , "Wachtwoord"  : userPassword
  ]

INTERFACE "UserAccounts" : I[UserAccount] -- I[Session];sUser;userPerson;(I \/ personAssignedRole;'Beheerder';V[Role*Person]);userPerson~
= [ "Accounts"    : I[UserAccount]
  ]
---------------------------------------------------------------------
PATTERN "Sessies en inloggen" -- WIJZIGER: rieks.joosten@tno.nl

sUser  :: Session * UserAccount [UNI] PRAGMA "" " draait onder ".
sUsers :: Session * UserAccount [UNI] PRAGMA "" " draait, of heeft gedraaid onder ".

RULE sUser |- sUsers MEANING "Als ooit in een sessie ingelogd is geweest, kan de sessie alleen worden gecontinueerd met behulp van het oorspronkelijke sessie account."

-- ALIAS: sUser sAccount
sAccount :: Session * UserAccount [UNI] PRAGMA "" " draait onder ".
RULE sAccount = sUser MEANING "De relatie-namen sAccount' en 'sUser' zijn aliassen van elkaar."

CONCEPT Login "een relatie tussen een persoon (mens) en een sessie, waarbij (tot op zekere hoogte) is geverifieed dat het echt de bedoelde persoon is die in de sessie communiceert met de geautomatiseerde wereld."
PURPOSE CONCEPT "Login" IN DUTCH
{+Om te voorkomen dat Jan en alleman applicaties c.q. systemen kunnen gebruiken op een manier zoals dat niet is bedoeld, verwachten we dat het mogelijk is dat van alles dat de applicatie doet kan worden vastgesteld op wiens verzoek dit is gebeurd. We willen elke geautomatiseerde handeling kunnen herleiden tot personen die deze handelingen hebben getriggerd. Dat kan omdat elke handeling in een sessie plaatsvindt, deze sessie is gekoppeld aan een UserAccount en dit UserAccount vervolgens weer aan een persson. Wat rest is dat er een continue runtime check moet plaatsvinden dat de persoon die aan het UserAccount is gekoppeld, ook daadwerkelijk communiceert met de applicatie onder dat account. Deze check kan tot op zekere hoogte continu plaatsvinden en ook tot op zekere hoogte verifieren dat de persoon in kwestie binnen de sessie communiceert.+}

loginSession  :: Login -> Session [INJ] PRAGMA "" " is a request to communicate with ".
loginUsername :: Login * UserAccount [UNI].
loginPassword :: Login * Password [UNI].

RULE sUser = loginSession~;(loginUsername /\ loginPassword;userPassword~)
MEANING "Inloggen leidt tot een sessionuser desda het wachtwoord is ingevuld dat bij de username hoort."

ENDPATTERN
---------------------------------------------------------------------
INTERFACE "Login" : I[Session] /\ -(sUser;sUser~)
-- Logins are allowed in sessions that do not have a sessionuser.
= [ "username" : loginSession~;loginUsername
  , "password" : loginSession~;loginPassword
  , "succes"   : (I /\ sUser;sUser~);V[Session*Text];'U bent ingelogd'
  ]

POPULATION text[Text*Text] CONTAINS [ ("U bent ingelogd", "U bent ingelogd") ]
---------------------------------------------------------------------
PATTERN "RBAC" -- MODIFIER: rieks.joosten@tno.nl
{- One of the major problems with RBAC is that organizations do not distinguish between  roles for human execution (roles assigned to people) and automated execution (roles assigned to user accounts). That's why we explicitly define this distinction and also do not allow roles to be assigned both to people and accounts
-}

personAssignedRole :: Person * Role [] PRAGMA "Aan " " is " " toegekend".
userAssignedRole :: UserAccount * Role [] PRAGMA "Aan " " is " " toegekend".
sessionRole :: Session * Role [] PRAGMA "Binnen " " is " " geactiveerd".

RULE sessionRole = sessionUser;userAssignedRole {- /\ sessionType; sessionTypeRole-} MEANING "Binnen een rol worden alle rollen geactiveerd die aan het UserAccount zijn verbonden{-, althans voor zover ze binnen het soort sessie actief mogen worden-}."

{- BUG3: overtredingen voor onderstaande regel worden niet goed uitgerekend.
V[Person*UserAccount] = -(personAssignedRole;userAssignedRole~)
MEANING "Rollen zijn of voor personen of voor user accounts, maar niet voor beide. Het zijn immers andere dingen."
-}
ENDPATTERN
---------------------------------------------------------------------
INTERFACE "AssignRoleToUser" : I[UserAccount] -- I[Session];sUser;userAssignedRole;'BeheerAccount';(I/\-(personAssignedRole~;personAssignedRole));V[Role*UserAccount]
-- Onder beheersaccounts mogen alle rollen worden toegekend aan users zolang als het maar geen persoonsrollen zijn.
= [ "Username" : userAssignedRole
  ]

INTERFACE "AssignUserToRole" : I[Role] -- I[Session];sUser;userAssignedRole;'BeheerAccount';V[Role];(I/\-(personAssignedRole~;personAssignedRole))
-- Onder beheersaccounts mogen alle rollen worden toegekend aan users zolang als het maar geen persoonsrollen zijn.
= [ "Role/Permissionset" : userAssignedRole~
  ]

INTERFACE "AssignRoleToPerson" : I[Person] -- I[Session];sUser;userAssignedRole;'BeheerAccount';(I/\-(userAssignedRole~;userAssignedRole));V[Role*Person]
-- Onder beheersaccounts mogen alle rollen worden toegekend aan personen zolang als het maar geen user/accountrollen zijn.
= [ "Person (Id)" : personAssignedRole
  ]

INTERFACE "AssignPersonToRole" : I[Role] -- I[Session];sUser;userAssignedRole;'BeheerAccount';V[Role];(I/\-(userAssignedRole~;userAssignedRole))
-- Onder beheersaccounts mogen alle rollen worden toegekend aan personen zolang als het maar geen user/accountrollen zijn.
= [ "Role/Function" : personAssignedRole~
  ]

-- Hier kan een BeheerFocus worden gedefinieerd waarin bovengenoemde 4 services te vinden zijn.
---------------------------------------------------------------------
PATTERN Texts
{- Dit pattern is bedoeld om teksten af te kunnen drukken binnen services. Dit pattern zou niet nodig zijn geweest als de volgende syntax zou hebben gewerkt:
  POPULATION I[Text] CONTAINS [ ("U bent ingelogd", "U bent ingelogd") ]
Een voorbeeld van hoe dit wordt gebruikt, is gegeven bij de INTERFACE 'Login'
-}
text :: Text * Text.  text |- I[Text]
ENDPATTERN
---------------------------------------------------------------------