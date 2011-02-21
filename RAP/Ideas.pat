----------------------------------------------------------------------
PATTERN "IdentifierDefinitions" -- Author(s) rieks.joosten@tno.nl

CONCEPT Identifier "the composition of a Namespace (i.e. a Scope) and a Symbol (text, sequence of bits) that uniquely identifies the entity (i.e. something that actually exists) that it has been assigned. The accountability for the identifying property of this identifier is assumed to be the scopeDomain of the Namespace." "RJ"

CONCEPT Symbol "a sequence of  bits, possibly with a slight interpretation added so that one may also say 'a sequence of characters'." "RJ"

CONCEPT Namespace "a Scope within which a well-specified set of Symbols have an identifying property. The scopeDomain of the Namespace is accountable for the identifying property of Symbols within the Namespace." "RJ"

CONCEPT Entity "something that actually exists. Within ADL, this may be interpreted to mean any Atom associated with the domain or one of its superdomains." "RJ"

symbol :: Identifier -> Symbol PRAGMA "Within the namespace associated with " ", precisely one entity is identified through ".

namespace :: Identifier -> Namespace PRAGMA "The symbol associated with " " identifies, within " ", precisely one entity".

assigned :: Identifier -> Entity PRAGMA "The symbol associated with " " has been assigned to refer to " " within the identifiers namespace".

RULE identifyuniquely: I[Identifier] = assigned;assigned~ -- RJ: Stef, is dit wel nodig?
PHRASE "Identifiers MUST uniquely identify an entity."

GEN Namespace ISA Scope
hasSubnamespace :: Namespace * Namespace [INJ,ASY] PRAGMA "" " has " " as a subNamespace"
PHRASE "A namespace hierarchy allows names to be derefenced even though they are not defined in the namespace itself.".

RULE hasSubnamespace |- hasSubscope
PHRASE "Subnamespaces are subscopes, albeit hierarchical ones."

ENDPATTERN
----------------------------------------------------------------------
PATTERN "DereferencingIdentifiers" -- Author(s) rieks.joosten@tno.nl

CONCEPT Idquery "the composition of a Namespace (i.e. a Scope) and a Symbol (text, sequence of bits) whose purpose it is to find out whether or not this combination uniquely identifies an entity. Where Identifiers are meant to associate entities to symbols (name giving), Idqueries do the converse by interpreting symbols and finding the associated entities (if any)." "RJ"

symbol :: Idquery -> Symbol PRAGMA "Within the namespace associated with " ", " "may or may not be dereferenceable".

namespace :: Idquery -> Namespace PRAGMA "The symbol associated with " " may or may not be dereferenceable within ".

RULE allPairsRepresentAnIdquery: V[Namespace*Symbol] = namespace~;I[Idquery];symbol
PHRASE "For every pair (Namespace,Symbol), there exists one Idquery."

RULE allIdqueriesRepresentOnePair: I[Idquery] = namespace;namespace~ /\ symbol;symbol~
PHRASE "For every Idquery, there exists one pair (Namespace,Symbol)."

identifies :: Idquery * Entity [UNI] PRAGMA "" " uniquely identifies "
PHRASE "The entity that is identified by a symbol within a namespace does not need to be explicitly defined through an identifier of that namespace. It can also be inferred from its meaning in higher-level namespaces, as long as this meaning is unambiguous.".

RULE undereferenceable: I[Idquery] = identifies; identifies~
PHRASE "This rule signals all identifiers that do not, or do no longer, refer to an entity."

RULE dereferenceable: identifies = ((namespace;namespace~ /\ symbol;symbol~);assigned) \/ ((namespace;hasSubscope~;namespace~ /\ symbol;symbol~); identifies)
PHRASE "A symbol is dereferenceable within namespace n either if it is the name of an identifier in that namespace, or it is dereferenceable in a namespace that is a superscope."

RULE identifyuniquely: I[Idquery] = identifies;identifies~
PHRASE "The result of dereferencing symbols must be unambiguous."

ENDPATTERN
----------------------------------------------------------------------
PATTERN Textfunctions -- Author(s) rieks.joosten@tno.nl

CONCEPT Tekst "a sequence of characters that humans are considered capable of reading." "RJ"

CONCEPT Concat "a computation that associates two Teksts, called the left and right teksts, with a third (result) tekst, such that the result tekst is the concatenation of the left and the right teksts." "RJ"

cleft  :: Concat -> Tekst PRAGMA "The first argument (left part) of " " is ".
cright :: Concat -> Tekst PRAGMA "The second argument (right part) of " " is ".
concat :: Concat -> Tekst PRAGMA "The result of concatenating the first argument with the second argument of " " is ".

RULE I[Concat] = cleft;cleft~ /\ cright;cright~
PHRASE "Every concatenation is uniquely characterized by its first and second arguments."

ENDPATTERN

----------------------------------------------------------------------
PATTERN "Contexts" -- Author(s) rieks.joosten@tno.nl
{- The 'Contexts' pattern provides all anchors for Calls (i.e. Service instances) from which contextual information/data can be obtained. Currently, the following types of contextual information are foreseen (even though not all are modelled):
1) Organizational contexts
2) Residential/environmental contexts
3) Session contexts

THE CURRENT VERSION OF THIS PATTERN ONLY SUPPORTS SESSION CONTEXTS

Organizational context anchors are called 'Org's. Orgs MUST be used for obtaining information that is related to the organization that is responsible for executing a service call, e.g. the computer-account that is used to run the server that executes the service call. Since running a service call always is (or: should be) the responsibility of precisely one organisation, we require every service call to be associated to precisely one Org.

Residential/environmental context anchors are called 'Env's. Envs MUST be used for obtaining information that is related to the (physical) location within which the service call is executed, e.g. environment variables, GPS location of the server, environmental temperature and such. Since running a service call is always done in a single environment, we require every service call to be associated to precisely one Env.

Session context anchors are called 'Session's. Sessions MUST be used for obtaining information that is related to communication channels that the Service uses for obtaining (requests for) operating instructions, or for sending messages to. An example of Session information would be the session's user, the organisation that is responsible for sending requests and handling the messages sent to it. Since Services are defined as interfaces between an ADL environment and another environment, e.g. a MySQL database, PHPcode, etc., it seems natural that every service call has at most one Session.
-}
{-
callOrg :: Call -> Org PRAGMA "The context of the organization that is responsible for running " " is accessible through "
orgDomain :: Org -> Domain PRAGMA "Accountability for all context information disclosed through " " is assumed by ".

callEnv :: Call -> Env PRAGMA "The context of the (physical) environment that is responsible for running " " is accessible through "
envDomain :: Env -> Domain PRAGMA "Accountability for all residential/environmental context information disclosed through " " is assumed by ".
-}

CONCEPT Session "a contextual anchor for service calls, through which they are required to obtain any information related to a communication channel. Examples hereof are the sessions user, and the organization that is responsible for (the content of) messages sent to the service call." "RJ"

CONCEPT Call "a runtime instance of a service." "RJ"

callSession :: Call -> Session PRAGMA "The session context within which " " executes, is accessible through "
PHRASE "The context within which a service call operates includes a subcontext dedicated to a communications channel.".

sessionDomain :: Session -> Domain PRAGMA "Accountability for all session information disclosed through " " is assumed by "
PHRASE "If a service call is run under accountability of an organization O1, but the service call is triggered by a request made by an organization O2, then O1 will be accountable for the service call, whereas O2 will be accountable for (the correctness and perhaps reliability of) all session information, a common example of which would be the user-identifier. Also, since any actor whose actions O2 is accountable for should be controlled by O2, it seems natural to have O2 assign things like permissions, roles and other attributes that the session discloses.".

CONCEPT DomainIdentifier "an Identifier that refers to an entity that is a domain" "RJ"

sessionUser :: Session * DomainIdentifier PRAGMA "The actor that sends and receives messages to and from services in " " is identified by "
PHRASE "The identifier that identifies the actor that sends and receives messages to and from services in a session, is (at least) dereferenceable to that actor within session's domain. For example, if a session s4711 has a sessiondomain 'TNO' and a sessionUser identifier 'rieks.joosten@tno.nl', then within the domain 'TNO', this identifier can be dereferenced to identify the actor that exchanged messages with services in s4711".

ENDPATTERN
----------------------------------------------------------------------