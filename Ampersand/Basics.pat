PATTERN Scopes -- WIJZIGER: rieks.joosten@tno.nl
{-
The notion of 'Scope' is introduced so as to allow anything to become and/or remain graspable (see [Anderson]).
The notion of 'Domain' is introduced so as to accommodate the assignment of accountability for actions, which is imperative for cooperating in our world.
-}

CONCEPT Scope "a boundary for which there exists an explicit or implicit criterion (that has no parts that need dereferencing) that can be used to uniquely determine what is within this boundary (within scope) and what is not (outside scope)" "RJ"

scopeCriterion :: Scope * Text [UNI] PRAGMA "The description/criterion for deciding what is inside or outside " ", is given by ".

hasSubscope :: Scope * Scope [ASY] PRAGMA "" " has " " as a subscope "
EXPLANATION "A scope s1 has scope s2 as a subscope iff everything that is in s2 is also in s1. Note that this relation is not 'Inj', because that would harm the generality of this relation".

CONCEPT Domain "an identifier for a person or organization that can be held accountable for the execution of actions (e.g. service calls). Since domains are identifiers, they cannot act. However, we do say that domains are accountable for actions, meaning that there is an identified person, called the manager of that domain, that performs all actions related to bearing the accountability." "RJ"

GEN Domain ISA Scope
--EXPLANATION "In order for any domain to be accountable, a criterion must exist that can be used to decide whether or not the domain can be held accountable."

hasSubdomain :: Domain * Domain [INJ,ASY] PRAGMA "" " has " " as a subDomain "
EXPLANATION "Whenever domains become too large to manage, they need to be split up such that the responsibility for tasks that the domain manager would otherwise have to do itself, can be delegated. For example, the domain 'TNO' has 'TNO ICT' as a subdomain.".

scopeDomain :: Scope -> Domain PRAGMA "The accountability for " " is born by".

I[Domain];scopeDomain = I[Domain]
EXPLANATION "The accountability for everything (that happens) within (the scope of) a domain lies with that very domain."

hasSubdomain |- hasSubscope
EXPLANATION "Everything that a subscope of scope s can be held accountable for, is also the accountability of s itself."
ENDPATTERN
----------------------------------------------------------------------
PATTERN "ScopeManagement" -- WIJZIGER: rieks.joosten@tno.nl

scopeResponsible :: Scope * Person [UNI] PRAGMA "For everything that happens within " ", " " is responsible (R in RA(S)CI)".
scopeAccountable :: Scope -> Person PRAGMA  "For everything that happens within " ", " " is accountable (A in RA(S)CI)".

domainManager:: Domain -> Person PRAGMA "For all actions that occur under the responsibility of " ", " " is accountable (in the RA(S)CI sense)"
EXPLANATION "Since only Actors (e.g. Persons) can act, and Domains are said to bear responsibility (or better: accountability), it is necessary to assign a (human) actor that is capable of performing all actions that come with this accountability.".

ENDPATTERN
----------------------------------------------------------------------
SERVICE NewScope : I[Scope] -- I[Session];sUser;userAssignedRole;'BeheerAccount';V[Role*Scope]
= [ "Scope" : I[Scope]
  , "Beschrijving" : scopeCriterion
  ]
----------------------------------------------------------------------
PATTERN "People" -- WIJZIGER: rieks.joosten@tno.nl
{- This pattern is meant solely for the purpose to define the concept so that other patterns can extend thereon as they see fit. Note that this is wholly in line with the design discipline of creating basic patterns as the smallest you might think of, and leaving any non-mandatory additions up to pattern extensions -}

CONCEPT "Person" "(a description of) an individual human being." "RJ"

ENDPATTERN
----------------------------------------------------------------------
PATTERN "PeopleExtensions" -- WIJZIGER: rieks.joosten@tno.nl
-- For the moment, we include a few items that we may use for identification purposes within sessions, or to contact people through email and/or (cell)phone

emailOf :: Emailaddr -> Person PRAGMA "Emails sent to " " are expected to be received by ".
phoneOf :: Phonenumber -> Person PRAGMA "The phone identified by " " is expected to be used by ".

I[Person] = emailOf~;emailOf
EXPLANATION "Personen zijn uniek gekarakteriseerd door hun email adres"

ENDPATTERN
----------------------------------------------------------------------
SERVICE Persoon : I[Person] -- I[Session];sUser;userPerson;(I \/ personAssignedRole;'Beheerder';V[Role*Person])
-- Wijzigen van gegevens mag alleen door de beheerder of de persoon zelf.
= [ "Id"  : I[Person]
  , "email addr" : emailOf~
  , "telefoonnr" : phoneOf~
  ]

SERVICE Personen : I[Person] -- I[Session];sUser;V[UserAccount*Person]
-- gebruiker moet zijn ingelogd
= [ "Id"  : I[Person]
  , "email addr" : emailOf~
  , "telefoonnr" : phoneOf~
  ]
----------------------------------------------------------------------
PATTERN "UserAccounts" -- WIJZIGER: rieks.joosten@tno.nl
-- Accounts (en rollen) hebben we nodig om de SERVICEs zoals die verderop staan de populaties te kunnen uitdunnen tot hetgeen voor de persoon die is ingelogd, relevant is.

CONCEPT "UserAccount" "een identifier voor een registratie in een database aan de hand waarvan alle gegevens kunnen worden teruggevonden zoals die in een sessie-context nodig (kunnen) zijn." "RJ"
-- Toekomstige uitbreidingen: 'PersonalUserAccount' is een UserAccount waarvan mag worden aangenomen dat de relatie 'userPerson' functioneel is.

userPerson :: UserAccount * Person [UNI] PRAGMA "" " has been assigned to ".
userPassword :: UserAccount * Password [UNI] PRAGMA "" " mag alleen worden geactiveerd in een sessie als " " aan de andere kant van de sessie bekend is".

{- Het hiernavolgende mag pas als we echte expressies aan kunnen in regels...
Dan mag ook de 'UNI' weg bij 'userPerson'.
personalAccount :: UserAccount * UserAccount
personalAccount = (userPerson~;userPerson |- I) EXPLANATION "Onder een 'personal seraccount' of 'personal account' verstaan we een account waaraan precies één Person is  gekoppeld."
-}
ENDPATTERN
------------------------------------------------------------------------
SERVICE "User" : I[UserAccount] -- I[Session];sUser;(I \/ userPerson;personAssignedRole;'Beheerder';V[Role*UserAccount])
= [ "Accountverantwoordelijke (persoon)": userPerson
  , "Wachtwoord"  : userPassword
  ]

SERVICE "UserAccounts" : I[UserAccount] -- I[Session];sUser;userPerson;(I \/ personAssignedRole;'Beheerder';V[Role*Person]);userPerson~
= [ "Accounts"    : I[UserAccount]
  ]
------------------------------------------------------------------------
PATTERN "Sessies en inloggen" -- WIJZIGER: rieks.joosten@tno.nl

sUser  :: Session * UserAccount [UNI] PRAGMA "" " draait onder ".
sUsers :: Session * UserAccount [UNI] PRAGMA "" " draait, of heeft gedraaid onder ".

sUser |- sUsers EXPLANATION "Als ooit in een sessie ingelogd is geweest, kan de sessie alleen worden gecontinueerd met behulp van het oorspronkelijke sessie account."

-- ALIAS: sUser sAccount
sAccount :: Session * UserAccount [UNI] PRAGMA "" " draait onder ".
sAccount = sUser EXPLANATION "De relatie-namen sAccount' en 'sUser' zijn aliassen van elkaar."

loginSession  :: Login -> Session [INJ] PRAGMA "" " is a request to communicate with ".
loginUsername :: Login * UserAccount [UNI].
loginPassword :: Login * Password [UNI].

sUser = loginSession~;(loginUsername /\ loginPassword;userPassword~)
EXPLANATION "Inloggen leidt tot een sessionuser desda het wachtwoord is ingevuld dat bij de username hoort."

ENDPATTERN
------------------------------------------------------------------------
SERVICE "Login" : I[Session] /\ -(sUser;sUser~)
-- Logins are allowed in sessions that do not have a sessionuser.
= [ "username" : loginSession~;loginUsername
  , "password" : loginSession~;loginPassword
  , "succes"   : (I /\ sUser;sUser~);V[Session*Text];'U bent ingelogd'
  ]

POPULATION text[Text*Text] CONTAINS [ ("U bent ingelogd", "U bent ingelogd") ]
------------------------------------------------------------------------
PATTERN "RBAC" -- MODIFIER: rieks.joosten@tno.nl
{- One of the major problems with RBAC is that organizations do not distinguish between  roles for human execution (roles assigned to people) and automated execution (roles assigned to user accounts). That's why we explicitly define this distinction and also do not allow roles to be assigned both to people and accounts
-}

personAssignedRole :: Person * Role [] PRAGMA "Aan " " is " " toegekend".
userAssignedRole :: UserAccount * Role [] PRAGMA "Aan " " is " " toegekend".

{- BUG3: overtredingen voor onderstaande regel worden niet goed uitgerekend.
V[Person*UserAccount] = -(personAssignedRole;userAssignedRole~)
EXPLANATION "Rollen zijn of voor personen of voor user accounts, maar niet voor beide. Het zijn immers andere dingen."
-}
ENDPATTERN
------------------------------------------------------------------------
SERVICE "AssignRoleToUser" : I[UserAccount] -- I[Session];sUser;userAssignedRole;'BeheerAccount';(I/\-(personAssignedRole~;personAssignedRole));V[Role*UserAccount]
-- Onder beheersaccounts mogen alle rollen worden toegekend aan users zolang als het maar geen persoonsrollen zijn.
= [ "Username" : userAssignedRole
  ]

SERVICE "AssignUserToRole" : I[Role] -- I[Session];sUser;userAssignedRole;'BeheerAccount';V[Role];(I/\-(personAssignedRole~;personAssignedRole))
-- Onder beheersaccounts mogen alle rollen worden toegekend aan users zolang als het maar geen persoonsrollen zijn.
= [ "Role/Permissionset" : userAssignedRole~
  ]

SERVICE "AssignRoleToPerson" : I[Person] -- I[Session];sUser;userAssignedRole;'BeheerAccount';(I/\-(userAssignedRole~;userAssignedRole));V[Role*Person]
-- Onder beheersaccounts mogen alle rollen worden toegekend aan personen zolang als het maar geen user/accountrollen zijn.
= [ "Person (Id)" : personAssignedRole
  ]

SERVICE "AssignPersonToRole" : I[Role] -- I[Session];sUser;userAssignedRole;'BeheerAccount';V[Role];(I/\-(userAssignedRole~;userAssignedRole))
-- Onder beheersaccounts mogen alle rollen worden toegekend aan personen zolang als het maar geen user/accountrollen zijn.
= [ "Role/Function" : personAssignedRole~
  ]

-- Hier kan een BeheerFocus worden gedefinieerd waarin bovengenoemde 4 services te vinden zijn.
------------------------------------------------------------------------
PATTERN Texts
{- Dit pattern is bedoeld om teksten af te kunnen drukken binnen services. Dit pattern zou niet nodig zijn geweest als de volgende syntax zou hebben gewerkt:
  POPULATION I[Text] CONTAINS [ ("U bent ingelogd", "U bent ingelogd") ]
Een voorbeeld van hoe dit wordt gebruikt, is gegeven bij de SERVICE 'Login'
-}
text :: Text * Text.  text |- I[Text]
ENDPATTERN
------------------------------------------------------------------------