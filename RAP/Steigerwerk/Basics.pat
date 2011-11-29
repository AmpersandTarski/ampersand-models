PATTERN Scopes -- WIJZIGER: rieks.joosten@tno.nl -- DependsOnFile SessionAccounts.pat
{-
The notion of 'Scope' is introduced so as to allow anything to become and/or remain graspable (see [Anderson]).
The notion of 'Domain' is introduced so as to accommodate the assignment of accountability for actions, which is imperative for cooperating in our world.
-}

CONCEPT Scope "a boundary for which there exists an explicit or implicit criterion (that has no parts that need dereferencing) that can be used to uniquely determine what is within this boundary (within scope) and what is not (outside scope)" "RJ"

scopeCriterion :: Scope * Text [UNI] PRAGMA "The description/criterion for deciding what is inside or outside " ", is given by ".

hasSubscope :: Scope * Scope [ASY] PRAGMA "" " has " " as a subscope ". PURPOSE RELATION hasSubscope IN DUTCH {+A scope s1 has scope s2 as a subscope iff everything that is in s2 is also in s1. Note that this relation is not 'Inj', because that would harm the generality of this relation-}

CONCEPT Domain "an identifier for a person or organization that can be held accountable for the execution of actions (e.g. service calls). Since domains are identifiers, they cannot act. However, we do say that domains are accountable for actions, meaning that there is an identified person, called the manager of that domain, that performs all actions related to bearing the accountability." "RJ"

GEN Domain ISA Scope
--MEANING "In order for any domain to be accountable, a criterion must exist that can be used to decide whether or not the domain can be held accountable."

hasSubdomain :: Domain * Domain [INJ,ASY] PRAGMA "" " has " " as a subDomain ". PURPOSE RELATION hasSubdomain IN DUTCH {+Whenever domains become too large to manage, they need to be split up such that the responsibility for tasks that the domain manager would otherwise have to do itself, can be delegated. For example, the domain 'TNO' has 'TNO ICT' as a subdomain.-}

scopeDomain :: Scope -> Domain PRAGMA "The accountability for " " is born by".

RULE I[Domain];scopeDomain = I[Domain]
MEANING "The accountability for everything (that happens) within (the scope of) a domain lies with that very domain."

RULE hasSubdomain |- hasSubscope
MEANING "Everything that a subscope of scope s can be held accountable for, is also the accountability of s itself."
ENDPATTERN
---------------------------------------------------------------------
PATTERN "ScopeManagement" -- WIJZIGER: rieks.joosten@tno.nl

scopeResponsible :: Scope * Person [UNI] PRAGMA "For everything that happens within " ", " " is responsible (R in RA(S)CI)".
scopeAccountable :: Scope -> Domain PRAGMA  "For everything that happens within " ", the manager of " " is accountable (A in RA(S)CI)".
scopeAccountable :: Scope -> Person PRAGMA  "For everything that happens within " ", " " is accountable (A in RA(S)CI)".

RULE scopeAccountable = scopeAccountable;domainManager MEANING "The person that fulfills the role of manager of the domain that is accountable for a scope, is accountable for that scope."

domainManager:: Domain -> Person PRAGMA "For all actions that occur under the responsibility of " ", " " is accountable (in the RA(S)CI sense)". 
PURPOSE RELATION domainManager IN DUTCH {+Since only Actors (e.g. Persons) can act, and Domains are said to bear responsibility (or better: accountability), it is necessary to assign a (human) actor that is capable of performing all actions that come with this accountability.-}

RULE domainManager |- scopeAccountable MEANING "Voor elk domein geldt dat diens manager accountable is voor alles wat binnen de scope van dat domein gebeurt." 

ENDPATTERN
---------------------------------------------------------------------
-- Als de 'Responsible' niet wordt ingevuld, dan moet automatisch de scope-accountable persoon hierbij worden ingevuld. Dat gebeurt op dit moment nog niet.
SERVICE NewScope : I[Scope] -- I[Session];sUser;userAssignedRole;'BeheerAccount';V[Role*Scope]
= [ "Scope" : I[Scope]
  , "Beschrijving" : scopeCriterion
  , "Accountable"  : scopeAccountable[Scope*Domain]
  , "Responsible"  : scopeResponsible
  ]

{- Als een persoon een domein manager is, en hij maakt een nieuwe scope aan, dan impliceert dit dat hijzelf ook (in eerste instantie) de accountability van die scope op zich neemt.
-- Als de 'Responsible' niet wordt ingevuld, dan moet automatisch de scope-accountable persoon hierbij worden ingevuld. Dat gebeurt op dit moment nog niet.SERVICE NewScope2 : I[Scope] -- I[Session];sUser;userPerson;domainManager~;V[Domain*Scope])
= [ "Scope" : I[Scope]
  , "Beschrijving" : scopeCriterion
  , "Accountable"  : V[Scope*Session];sUser;userPerson;domainManager~
  , "Responsible"  : scopeResponsible 
  ]
-}
---------------------------------------------------------------------