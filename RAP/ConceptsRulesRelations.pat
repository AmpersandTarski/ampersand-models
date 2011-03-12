PATTERN "Concepts and Relations"  --!EXTENDS Sets
PURPOSE PATTERN "Concepts and Relations" IN ENGLISH
{+In order for stakeholders to agree to the specifications of an application, they must commit to a common language in which these specifications can be formally expressed. This pattern defines the way in which Concepts are expressed in such languages, according to the Ampersand method.-}

--[Concepts and Atoms]--------------------------------------

CONCEPT Concept "an abstraction (like 'student', 'number', and 'course'), that needs to be replaced by an actual student, number, or course, is called a concept ."
PURPOSE CONCEPT Concept IN ENGLISH
{+In Ampersand, an abstraction like `student', `number', and `course', that
you need to replace by an actual student, number, or course, is called
concept a concept . Concepts should not be confused with atoms: concepts are
abstract, and atoms are concrete. Atoms are the terms, the individual
things in the real world that you can point out. A concept is an abstraction,
it is not the individual thing but the type of thing. We can say for
example that Caroline (an atom) is a student (a concept), ABBA is a
pop group, and NL 44 is a residence permit.-}
GEN Concept ISA Set

CONCEPT Atom "a reference to a single, specific, concrete entity (= something that actually exists) in the real world."
PURPOSE CONCEPT Atom IN ENGLISH
{+An atom refers to an individual object in the real world, such as the
student called `Caroline'. But what if there are three dierent Carolines?
What does it mean to say: "Caroline has passed the exam for Spanish
Medieval Literature."? This sentence might be true for one Caroline,
but false for the others. Clearly, to avoid ambiguous sentences, an atom
must identify exactly one real-world object, no more, no less. Or rather,
it suffices that the atom identifies one object within the context in which
we are working: if the context is a group with only one Caroline, there
will be no ambiguity. Similarly, ABBA is unique among all pop groups
in the world; there ought to be only one building permit with number
5678; etcetera. [BOOKp41]-}

GEN Atom ISA Element -- See pattern Sets.
type :: Atom -> Concept PRAGMA "" " is defined as being of type "
PURPOSE RELATION type[Atom*Concept] IN ENGLISH
{+For every Atom, it must be clear which Concept(s) it instantiates. When created, an Atom is assigned a type, i.e. a (single) Concept that it instantiates. This is what the relation 'type' models. Note, however, that if this Concept is a specialization of another Concept, the Atom also instantiates this other Concept. This is NOT modelled by the 'type' relation.-} --? But maybe this kind of 'type' relation should be modelled as well ??

RULE "atomtypes": type[Atom*Concept] |- isElementOf
PHRASE "An atom has a type, which is a concept that it is an element of (when the concept is seen as a set)."
PURPOSE RULE atomtypes IN ENGLISH
{+Atoms need to be classified in order to be able to talk about and reason with them in an abstract fashion. Every atom is classified as a member of some Set if the Atom represents a (real world) entity that has all properties that are expected of instances of the Concept of which the Set contains its representatives.-}

isa :: Concept * Concept [ASY] PRAGMA "every " " is a " " as well".
PURPOSE RELATION isa IN ENGLISH
{+Concept specialization (or the converse: generalization) is one of the key means by which to organize atoms. The 'isa' relation is introduced to accommodate for this. -}

RULE "isaDef": isa[Concept*Concept] |- isSubsetOf
PHRASE "Any Atom that is typed as a Concept that is a specialization of a more general Concept, is also in (the set that) the more general Concept."
PURPOSE RULE "isaDef" IN ENGLISH
{+Whenever an Atom has been defined as (an element of a) Concept (set), and that Concept 'isa' Concept', then of course the Atom must also be an element of (the) Concept' (set). The properties of Sets ensure that this idea is carried on towards all other Concepts that are (indirect) generalizations of the Concept in which the Atom has been typed.-}

--[Declarations (of relations)]-----------------------------

CONCEPT Declaration "a statement where (the name of) a 'source concept', (the name of) a 'target concept' and (the name of) a relation is associated with a (pragmatic) definition (i.e. its meaning or intension for the business)"
PURPOSE CONCEPT Declaration IN ENGLISH
{+In order to use computers for business purposes, it must be possible for business intensions to be mapped onto a formalism that computers can work with. Using relation algebra as such a formalism, it must thus be possible to specify  meaningful links between the intensions of the business and relations as they are known in relation algebra.

Also, in order to be able to disambiguate (the name of) a relation as it appears in texts (e.g. rules), two relations that have the same name yet a different intension (as can be seen by either the source or target concept), must be distinguishable. Declarations allow for such distinctions.-}

CONCEPT Pragma "a representation for assigning meaning to links in a relation"
PURPOSE CONCEPT Pragma IN ENGLISH
{+In order to provide a mapping between a (binary) busines phrase and data within a database, we need a mechanism that can provide the meaning of a link of atoms. This mechanism works as follows. Every link is part of a (single) Relation, which in turn has a (single) Declaration as its signature, and this Declaration provides a (single) representation of the semantics of a link of atoms. Thus, every link of atoms is assigned the semantics as defined by the Pragma of the Declaration of the Relation of which the link is a part.-}

pragma :: Declaration -> Pragma PRAGMA "The semantics associated with " " is defined by "
PURPOSE RELATION pragma IN ENGLISH
{+In order to (ultimately) be able to assign semantics to links in a relation, the Pragma is introduced.-}

KEY "declarationKey": Declaration(relation,source,target)

relation :: Declaration -> Text
PURPOSE RELATION relation IN ENGLISH
{+In order to detect the appearance of Relations in expressions (terms), every Declaration is assigned a text that is the name of any Relation that it is the signature of.-}

source :: Declaration -> Concept PRAGMA "The source (first, left) concept of " " is ".
target :: Declaration -> Concept PRAGMA "The target (second, right) concept of " " is ".

--[Links]---------------------------------------------------

--Note that a Pair is just a set of two atoms. A Link differs from a Pair in that it is associated with a relation.
CONCEPT Link "two atoms (a 'left' and 'right' one) that together are part of the population of a relation"
PURPOSE CONCEPT Link IN ENGLISH
{+In order to represent a (binary) fact, which is a semantic (meaningful) link between two real world things, we need two atoms to represent these real world things and (the declaration of) a relation whose intension provides the semantic link between these two. A link of atoms associated to a (single) relation is thus capable of representing a binary fact. Note however that such a link is also capable of representing non-facts, i.e. statements that are *not* true in the real world. Since there is need for this as well (**example, please**), we use links.

Also note that any Link may have multiple meanings, although such meanings must be related. A Link (of Atoms) has multiple meanings if either of its Atoms has multiple types. An Atom has multiple types if it is created in a Relation (which uniquely defines the type of both Atoms), while the (unique) type of such an Atom happens to be a specialization of some concept. For example, the Link (Rieks, 1234567890) may appear in the relation phone[Employee*Phonenumber], but in cases wehre 'Employee ISA Person', then it also appears in the relation phone[Person*Phonenumber]. -}

KEY "linkKey": Link(left,right,inExtensionOf)

left  :: Link -> Atom  PRAGMA "Link " " has " " as its left Atom"
right :: Link -> Atom  PRAGMA "Link " " has " " as its right Atom"
inExtensionOf :: Link * Declaration [TOT] PRAGMA "Link " " is part of the extension of ".
PURPOSE RELATION inExtensionOf IN ENGLISH
{+The extension of a Declaration is the set of all links whose meaning is defined by this Declaration. Conversely, it must be possible for any link to determine the meaning(s) that it has. The latter requires that every Link be assigned (at least) one Declaration.-}

elementOf :: Link * Relation [TOT] PRAGMA "" " is an element of "
PURPOSE RELATION elementOf[Link*Relation] IN ENGLISH
{+While a link is obviously an element of one Relation, it may not be obvious that it can be an element in more than one Relations. This is the case if a Declaration exists the type of either the left or right Atom of the Link ISA more generic Concept-}

--?Volgt dit niet vanzelf: elementOf;signature |- inExtensionOf~

--[Relations]-----------------------------------------------

--?CONCEPT Extension "the set of Links of a single relation, where each link represents a single fact that is true in a specific (business) context" "Book,p48"
CONCEPT Relation "a set of links, the meaning of which is defined by precisely one Declaration, in one specific Context"
PURPOSE CONCEPT Relation IN ENGLISH
{+For any Link (of Atoms), its Relation disambiguates its meaning if necessary. A Link (of Atoms) has multiple meanings if the type of either of its Atoms is a specialization of some Concept. For example, the Link (Rieks, 1234567890) may appear in the relation phone[Employee*Phonenumber], but in cases wehre 'Employee ISA Person', then it also appears in the relation phone[Person*Phonenumber].-}

KEY "relationKey": Relation(signature,scope)
--PHRASE "Within any context, the relations name and the source and target of its declaration, together uniquely determine a relation."

signature :: Relation -> Declaration [SUR] PRAGMA "" " provides unambiguous meaning to any of its Links, as defined by ".
PURPOSE RELATION signature IN ENGLISH
{+Every two Links in a relation must represent a statement that has the same intension; the only difference in meaning that such two Links represent, is given by the atoms of these links. To ensure this, each Relation is assigned a single Declaration, which provides this similar intension.-}

RULE "relation contents": elementOf[Link*Relation] = (left; type; source~ /\ right; type; target~ /\ inExtensionOf); signature~
PHRASE "The contents of a Relation, i.e. the set of Links that it contains, consists of every link that is in the extension of the Declaration that is identified by the type of the left and right Atoms of the link, and the signature of the Relation."
PURPOSE RULE "relation contents" IN ENGLISH
{+At all times, the contents (population, extension) of a relation should be uniquely defined.-}

scope :: Relation -> Context PRAGMA "The scope of " " is limited to "
PURPOSE RELATION scope IN ENGLISH
{+Within a Context, the contents of the relation must be limited to the set of Links that have a meaning within that Context. For example, **invullen**.-}

RULE "scopeDEF": scope = in;extends*
--PHRASE "A relation is in scope of a context if it is defined in that context or in one of its more specific contexts."
PHRASE "A Relation is in scope of a Context if (and only if) it is used in a Rule that applies in that Context"

--[typing of links]-----------------------------------------

RULE "left atom extension":   left[Link*Atom] |- inExtensionOf; source; isElementOf~
PHRASE "The left atom of a link is in the set that corresponds to the source concept of that link."

RULE "right atom extension":  right[Link*Atom] |- inExtensionOf; target; isElementOf~
PHRASE "The right atom of a link is in the set that corresponds to the target concept of that link."

RULE "type of left atom":   left~;inExtensionOf; source |- type --COMPUTING type,inExtensionOf; source
PHRASE "The type of the left atom of a link is the inExtensionOf; source of that link."

RULE "type of right atom":  right~;inExtensionOf; target |- type --COMPUTING type,inExtensionOf; target
PHRASE "The type of the right atom of a link is the inExtensionOf; target of that link."

RULE "leftype":   left;type |- inExtensionOf; source --COMPUTING type,inExtensionOf; source
PHRASE "The type of the left atom of a link is the inExtensionOf; source of that link."

RULE "rightype":  right;type |- inExtensionOf; target --COMPUTING type,inExtensionOf; target
PHRASE "The type of the right atom of a link is the inExtensionOf; target of that link."

--[Rules and Patterns]--------------------------------------

-- CONCEPT Rule is defined in pattern "Formalized BusinessRules"
CONCEPT Pattern "The definition of a piece of (business) language, i.e. concepts, relations between them and (formalized) rules"
PURPOSE CONCEPT Pattern IN ENGLISH
{+In order to address a set of related issues, a language is necessary in which these issues can adequately expressed. Such a language not only consists of (simple) sentences, but also contains constraints (rules) expressed therein, thus specifying the crucial semantics. Patterns are used to introduce the language and constraints necessary to address a set of related issues.-}

-- CONCEPT Context is defined PATTERN ContextContents

--?RJ/15082007: Note that the functionality of this relation means that two rules that consist of one and the same expression, are considered to be different rules. This is not the way in which the tool currently behaves 
definedIn :: Rule -> Pattern PRAGMA "Rule " " is defined in Pattern "
PURPOSE RELATION definedIn[Rule*Pattern] IN ENGLISH
{+-}

uses :: Context * Pattern  PRAGMA "Context " " uses Pattern "
PURPOSE RELATION uses[Context*Pattern] IN ENGLISH
{+Within a (business) context, all language that is being used by automata wihtin that context, should be formally specified and committed to by the business. Since patterns are used to formally specify (parts of) a language, businesses can benefit by selecting (proven) patterns as part of the formal specification of their business language.-} 

appliesIn :: Rule * Context PRAGMA "Rule " " applies in Context "
PURPOSE RELATION appliesIn IN ENGLISH
{+Data integrity within a Context means that all data within that context must satisfy all applicable rules in that context. Hence, it is necessary to know which rules apply in which contexts.-} 

RULE "appliesInDEF": appliesIn = definedIn; uses[Context*Pattern]~
PHRASE "The set of rules that apply in a context is the set of all rules that are defined in any of the patterns used by that context."

--?RJ/15082007: Note that because 'definedIn' is functional, it may happen that rule A defined in pattern A within context C has the same RA-expression as rule B in pattern B in context C, but they are still treated as different rules, which should mean that a violation of rule A in context C will show up twice, as the same data would constitute a violation of rule B. I'm not sure whether or not this is of concern. 
extends :: Context * Context [ASY] PRAGMA "Context " " (specific) extends Context " " (generic)"
  = [ ("RAP", "RAP") ].
RULE "appliesExtends": appliesIn[Rule*Context];extends*~ |- appliesIn[Rule*Context]
PHRASE "If you work in a context (e.g. the context of Marlays bank) you may define a new context (e.g. Mortgages) as an extention of an existing context. This means that all rules that apply in the context 'Marlays bank' apply in the context `Mortgages' as well. The set of rules that apply in the generic context ('Marlays bank') is a subset of the rules that apply in the specific context ('Mortgages')."

in :: Declaration * Rule [SUR,TOT]
in :: Relation -> Context PRAGMA "Relation " " is defined in Context "  -- Rel 16

RULE "inAppliesIn": in;appliesIn |- signature[Relation*Declaration]~;in
  PHRASE "You always work in one particular context, called the <it>current context</it>. Every declaration is bound to precisely one relation in your current context. Notice that the same declaration may be bound to different relations in different contexts, because one rule (which is defined in a pattern) applies in all contexts that use this rule."

--[Valuations]----------------------------------------------

--!Onderstaande regel moet ge-ontcommentarieerd worden als de ISA goed werkt.
--GEN Rule ISA Relation
isaRelation :: Rule -> Relation [INJ] PRAGMA "" " is a ".

RULE "rule-relations in context": appliesIn[Rule*Context] |- isaRelation; in[Relation*Context]
PHRASE "Whenever a Rule applies in a Context, then its population is part of that Context as well."

RULE inValAppliesIn: elementOf; isaRelation~; appliesIn |- elementOf; in[Relation*Context]
  PHRASE "For every valuation of rule r that contains a link l, that link is element of a relation in each context in which r applies."
ENDPATTERN

PATTERN Patterns
PURPOSE PATTERN Patterns IN ENGLISH
{+In order for stakeholders to agree to the specifications of an application, they must commit to a common language in which these specifications can be formally expressed. This pattern defines the way in which Patterns are used in such languages, according to the Ampersand method.-}

 definedIn :: Declaration -> Pattern


RULE "inDefinedIn": in;definedIn = definedIn
  PHRASE "Every relation used in a rule is declared in the same pattern as that rule and every relation declared in that pattern is used in one of its rules. In the current ADL compiler, this rule is not enforced. Consequently, you can use any relation declared in this pattern's context and any relation in any context which is more generic."
RULE "iDefinedIn": I = definedIn~;definedIn[Rule*Pattern]
  PHRASE ""
RULE "inSign": in~;signature[Relation*Declaration] |- uses[Context*Pattern];definedIn~
  PHRASE "A relation is bound to a declaration, which is defined in a pattern used in the relation's context."
RULE "inExtends2": in;extends* |- in
  PHRASE "Any relation in a context is also known in more generic contexts. The reason is that a relation is a set of links, so subsets are subrelations."
RULE "extendsUses2": extends*;uses[Context*Pattern] |- uses[Context*Pattern]
  PHRASE "A pattern used by a context is implicitly used by more specific contexts."

ENDPATTERN

PATTERN "Properties of Relations"
PURPOSE PATTERN "Properties of Relations" IN ENGLISH
{+In order for stakeholders to agree to the specifications of an application, they must commit to a common language in which these specifications can be formally expressed. This pattern defines the way in which multiplicities of relations  are expressed in such languages, according to the Ampersand method.-}

univalent  :: Declaration*Declaration [PROP].
total      :: Declaration*Declaration [PROP].
functional :: Declaration*Declaration [PROP].
injective  :: Declaration*Declaration [PROP].
surjective :: Declaration*Declaration [PROP].
invfunc    :: Declaration*Declaration [PROP].
flp        :: Declaration*Declaration [SYM,UNI,TOT,SUR,INJ].
RULE "functionalDEF": functional = univalent /\ total --COMPUTING functional
RULE "invfuncDEF": invfunc = injective /\ surjective --COMPUTING invfunc
RULE "surjectiveDEF": total;flp = surjective --COMPUTING surjective,total
RULE "univalentDEF": injective;flp = univalent --COMPUTING univalent,injective

--[Properties for homogeneous relations]--------------------

reflexive     :: Declaration*Declaration [PROP].
irreflexive   :: Declaration*Declaration [PROP].
symmetric     :: Declaration*Declaration [PROP].
asymmetric    :: Declaration*Declaration [PROP].
antisymmetric :: Declaration*Declaration [PROP].
transitive    :: Declaration*Declaration [PROP].
property      :: Declaration*Declaration [PROP].
RULE "propertyDEF":   property = symmetric /\ antisymmetric
RULE "homogeneous properties": reflexive \/ irreflexive \/ symmetric \/ asymmetric \/ antisymmetric \/ transitive \/ property |- source; target~
PHRASE "The properties 'reflexive', 'irreflexive', 'symmetric', 'asymmetric', 'antisymmetric', 'transitive', and 'property' are only applicable on homogeneous relations, i.e. relations whose source and target concepts are the same."

ENDPATTERN