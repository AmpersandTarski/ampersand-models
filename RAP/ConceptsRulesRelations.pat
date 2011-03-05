PATTERN Concepts --!EXTENDS Sets
PURPOSE PATTERN Concepts IN ENGLISH
{+In order for stakeholders to agree to the specifications of an application, they must commit to a common language in which these specifications can be formally expressed. This pattern defines the way in which Concepts are expressed in such languages, according to the Ampersand method.-}

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

-- GLUE type = isElementOf -- Eruitgegooid; we hebben immers ook pop :: Concept -> Set Maar misschien willen we ook wel (a) GEN Concept ISA Set; (b) GEN Atom ISA Element en (c) type[Atom*Concept] |- isElementOf[Element*Set]
GEN Atom ISA Element -- See pattern Sets.

type :: Atom -> Concept PRAGMA "" " is defined as being of type "
PURPOSE RELATION type[Atom*Concept] IN ENGLISH
{+Atoms must have a defined type, in particular in the light of multiple inheritance.-}

RULE "atomtypes": type = isElementOf;pop~
PHRASE "An atom has a type, which is a concept in whose population the atom occurs or any more general concept than that."
PURPOSE RULE atomtypes IN ENGLISH
{+Atoms need to be classified in order to be able to talk about and reason with them in an abstract fashion. Every atom is classified as a member of some Set if the Atom represents a (real world) entity that has all properties that are expected of instances of the Concept of which the Set contains its representatives.-}

left  :: Fact -> Atom  PRAGMA "Fact " " has " " as its left Atom"
PURPOSE RELATION left IN ENGLISH
{+-}

right :: Fact -> Atom  PRAGMA "Fact " " has " " as its right Atom"
PURPOSE RELATION left IN ENGLISH
{+-}

-- KEY "factLink": Fact(left,right)
RULE factKey: I[Fact] =  in[Fact*Relation];in~ /\ left;left~ /\ right;right~ PHRASE "A fact is uniquely characterized by its relation and its left and right atoms." -- This used to be just Fact(left,right), but for transactions we also need the relation to be part of this - see ContextContents.pat
 src :: Fact -> Concept.
RULE "leftype": left[Fact*Atom] |- src;pop;isElementOf~
  PHRASE "The left atom of a fact is in the set that corresponds to the source concept of that fact."
trg :: Fact -> Concept.
RULE "rightype":  right[Fact*Atom] |- trg;pop;isElementOf~
  PHRASE "The right atom of a fact is in the set that corresponds to the target concept of that fact."
RULE "leftsrc": left~;src |- type --COMPUTING type,src
  PHRASE "The type of the left atom of a fact is the src of that fact."
RULE "rightsrc": right~;trg |- type --COMPUTING type,trg
  PHRASE "The type of the right atom of a fact is the trg of that fact."
RULE "leftype": left;type |- src --COMPUTING type,src
  PHRASE "The type of the left atom of a fact is the src of that fact."
RULE "rightype":  right;type |- trg --COMPUTING type,trg
  PHRASE "The type of the right atom of a fact is the trg of that fact."
ENDPATTERN


PATTERN Rules --!EXTENDS Concepts
PURPOSE PATTERN Rules IN ENGLISH
{+In order for stakeholders to agree to the specifications of an application, they must commit to a common language in which these specifications can be formally expressed. This pattern defines the way in which Rules are expressed in such languages, according to the Ampersand method.-}

 definedIn :: Rule -> Pattern PRAGMA "Rule " " is defined in Pattern "
--!RJ/15082007: Note that the functionality of this relation means that two rules that consist of one and the same expression, are considered to be different rules. This is not the way in which the tool currently behaves 
  = [ ("isElementOf;isSubsetOf* |- isElementOf", "Sets")
    ; ("isa* |- pop;isSubsetOf*;pop~", "Sets")
    ; ("type = isElementOf;pop~", "Concepts")
    ; ("right;right~/\\left;left~ = I", "Concepts")
    ; ("left |- src;pop;isElementOf~", "Concepts")
    ; ("right |- trg;pop;isElementOf~", "Concepts")
    ; ("appliesIn = definedIn;uses~", "Rules")
    ; ("appliesIn;extends*~ |- appliesIn", "Rules")
    ; ("in;appliesIn |- sign[Relation*FactType]~;in", "Rules")
    ; ("in;sign |- src;source~/\\trg;target~", "Relations")
    ; ("sign;sign~/\\in~;in = I[Relation]", "Relations")
    ; ("in;sub* |- in", "Relations")
    ; ("I = name;name~/\\source;source~/\\target;target~", "Relations")
    ; ("sub* = sign;sub*;sign~/\\in;extends*;in~", "Relations")
    ; ("in~;val |- val;in~", "Valuations")
    ; ("in;val~;appliesIn |- in;in", "Valuations")
    ; ("definedIn = sign~;in;definedIn", "Patterns")
    ; ("I = definedIn~;definedIn[Rule*Pattern]", "Patterns")
    ; ("in~;sign[Relation*FactType] |- uses;definedIn~", "Patterns")
    ; ("in;extends* |- in", "Patterns")
    ; ("extends*;uses |- uses", "Patterns")
    ; ("scope = in;extends*", "Patterns")
    ].
 uses :: Context * Pattern  PRAGMA "Context " " uses Pattern "
  = [ ("RAP", "Sets")
    ; ("RAP", "Concepts")
    ; ("RAP", "Rules")
    ; ("RAP", "Relations")
    ; ("RAP", "Valuations")
    ; ("RAP", "Patterns")
    ].
 appliesIn :: Rule * Context PRAGMA "Rule " " applies in Context "
  = [ ("isElementOf;isSubsetOf* |- isElementOf", "RAP")
    ; ("isa* |- pop;isSubsetOf*;pop~", "RAP")
    ; ("type = isElementOf;pop~", "RAP")
    ; ("right;right~/\\left;left~ = I", "RAP")
    ; ("left |- src;pop;isElementOf~", "RAP")
    ; ("right |- trg;pop;isElementOf~", "RAP")
    ; ("appliesIn = definedIn;uses~", "RAP")
    ; ("appliesIn;extends*~ |- appliesIn", "RAP")
    ; ("in;appliesIn |- sign[Relation*FactType]~;in", "RAP")
    ; ("in;sign |- src;source~/\\trg;target~", "RAP")
    ; ("sign;sign~/\\in~;in = I[Relation]", "RAP")
    ; ("in;sub* |- in", "RAP")
    ; ("I = name;name~/\\source;source~/\\target;target~", "RAP")
    ; ("sub* = sign;sub*;sign~/\\in;extends*;in~", "RAP")
    ; ("in~;val |- val;in~", "RAP")
    ; ("in;val~;appliesIn |- in;in", "RAP")
    ; ("definedIn = sign~;in;definedIn", "RAP")
    ; ("I = definedIn~;definedIn[Rule*Pattern]", "RAP")
    ; ("in~;sign[Relation*FactType] |- uses;definedIn~", "RAP")
    ; ("in;extends* |- in", "RAP")
    ; ("extends*;uses |- uses", "RAP")
    ; ("scope = in;extends*", "RAP")
    ].
RULE "appliesInDEF": appliesIn = definedIn;uses~
  PHRASE "Rules are defined in a pattern. When that pattern is used in a context, all rules of that pattern apply within the context. Within the context itself, extra rules may be defined for the purpose of glueing patterns together. So all rules that apply in a context are the ones defined in patterns used by the context plus the rules defined within that context."
-- RJ/15082007: Note that because 'definedIn' is functional, it may happen that rule A defined in pattern A within context C has the same RA-expression as rule B in pattern B in context C, but they are still treated as different rules, which should mean that a violation of rule A in context C will show up twice, as the same data would constitute a violation of rule B. I'm not sure whether or not this is of concern. 
 extends :: Context * Context [ASY] PRAGMA "Context " " (specific) extends Context " " (generic)"
  = [ ("RAP", "RAP") ].
RULE "appliesExtends": appliesIn;extends*~ |- appliesIn
  PHRASE "If you work in a context (e.g. the context of Marlays bank) you may define a new context (e.g. Mortgages) as an extention of an existing context. This means that all rules that apply in the context `Marlays bank' apply in the context `Mortgages' as well. The rules that apply in the generic context (`Marlays bank') are a isSubsetOf of the rules that apply in the specific context (`Mortgages')."
 in :: FactType * Rule [SUR,TOT]
  = [ ("isElementOf[Atom*Set]", "isElementOf;isSubsetOf* |- isElementOf")
    ; ("isSubsetOf[Set*Set]", "isElementOf;isSubsetOf* |- isElementOf")
    ; ("isSubsetOf[Set*Set]", "isa* |- pop;isSubsetOf*;pop~")
    ; ("isa[Concept*Concept]", "isa* |- pop;isSubsetOf*;pop~")
    ; ("pop[Concept*Set]", "isa* |- pop;isSubsetOf*;pop~")
    ; ("isElementOf[Atom*Set]", "type = isElementOf;pop~")
    ; ("isa[Concept*Concept]", "type = isElementOf;pop~")
    ; ("pop[Concept*Set]", "type = isElementOf;pop~")
    ; ("type[Atom*Concept]", "type = isElementOf;pop~")
    ; ("right[Fact*Atom]", "right;right~/\\left;left~ = I")
    ; ("left[Fact*Atom]", "right;right~/\\left;left~ = I")
    ; ("isElementOf[Atom*Set]", "left |- src;pop;isElementOf~")
    ; ("pop[Concept*Set]", "left |- src;pop;isElementOf~")
    ; ("left[Fact*Atom]", "left |- src;pop;isElementOf~")
    ; ("src[Fact*Concept]", "left |- src;pop;isElementOf~")
    ; ("isElementOf[Atom*Set]", "right |- trg;pop;isElementOf~")
    ; ("pop[Concept*Set]", "right |- trg;pop;isElementOf~")
    ; ("right[Fact*Atom]", "right |- trg;pop;isElementOf~")
    ; ("trg[Fact*Concept]", "right |- trg;pop;isElementOf~")
    ; ("appliesIn[Rule*Context]", "appliesIn = definedIn;uses~")
    ; ("definedIn[Rule*Pattern]", "appliesIn = definedIn;uses~")
    ; ("uses[Context*Pattern]", "appliesIn = definedIn;uses~")
    ; ("appliesIn[Rule*Context]", "appliesIn;extends*~ |- appliesIn")
    ; ("extends[Context*Context]", "appliesIn;extends*~ |- appliesIn")
    ; ("appliesIn[Rule*Context]", "in;appliesIn |- sign[Relation*FactType]~;in")
    ; ("in[FactType*Rule]", "in;appliesIn |- sign[Relation*FactType]~;in")
    ; ("sign[Relation*FactType]", "in;appliesIn |- sign[Relation*FactType]~;in")
    ; ("in[Relation*Context]", "in;appliesIn |- sign[Relation*FactType]~;in")
    ; ("in[Fact*Relation]", "in;sign |- src;source~/\\trg;target~")
    ; ("sign[Relation*FactType]", "in;sign |- src;source~/\\trg;target~")
    ; ("src[Fact*Concept]", "in;sign |- src;source~/\\trg;target~")
    ; ("source[FactType*Concept]", "in;sign |- src;source~/\\trg;target~")
    ; ("trg[Fact*Concept]", "in;sign |- src;source~/\\trg;target~")
    ; ("target[FactType*Concept]", "in;sign |- src;source~/\\trg;target~")
    ; ("sign[Relation*FactType]", "sign;sign~/\\in~;in = I[Relation]")
    ; ("in[Fact*Relation]", "sign;sign~/\\in~;in = I[Relation]")
    ; ("in[Fact*Relation]", "in;sub* |- in")
    ; ("sub[Relation*Relation]", "in;sub* |- in")
    ; ("name[FactType*Identifier]", "I = name;name~/\\source;source~/\\target;target~")
    ; ("source[FactType*Concept]", "I = name;name~/\\source;source~/\\target;target~")
    ; ("target[FactType*Concept]", "I = name;name~/\\source;source~/\\target;target~")
    ; ("extends[Context*Context]", "sub* = sign;sub*;sign~/\\in;extends*;in~")
    ; ("sub[FactType*FactType]", "sub* = sign;sub*;sign~/\\in;extends*;in~")
    ; ("sub[Relation*Relation]", "sub* = sign;sub*;sign~/\\in;extends*;in~")
    ; ("sign[Relation*FactType]", "sub* = sign;sub*;sign~/\\in;extends*;in~")
    ; ("in[Relation*Context]", "sub* = sign;sub*;sign~/\\in;extends*;in~")
    ; ("val[FactType*Fact]", "in~;val |- val;in~")
    ; ("val[Rule*Valuation]", "in~;val |- val;in~")
    ; ("in[FactType*Rule]", "in~;val |- val;in~")
    ; ("in[Fact*Valuation]", "in~;val |- val;in~")
    ; ("in[Fact*Valuation]", "in;val~;appliesIn |- in;in")
    ; ("val[Rule*Valuation]", "in;val~;appliesIn |- in;in")
    ; ("appliesIn[Rule*Context]", "in;val~;appliesIn |- in;in")
    ; ("in[Fact*Relation]", "in;val~;appliesIn |- in;in")
    ; ("in[Relation*Context]", "in;val~;appliesIn |- in;in")
    ; ("definedIn[Signature*Pattern]", "definedIn = sign~;in;definedIn")
    ; ("in[FactType*Rule]", "definedIn = sign~;in;definedIn")
    ; ("definedIn[Rule*Pattern]", "definedIn = sign~;in;definedIn")
    ; ("definedIn[Rule*Pattern]", "I = definedIn~;definedIn[Rule*Pattern]")
    ; ("in[Relation*Context]", "in~;sign[Relation*FactType] |- uses;definedIn~")
    ; ("sign[Relation*FactType]", "in~;sign[Relation*FactType] |- uses;definedIn~")
    ; ("uses[Context*Pattern]", "in~;sign[Relation*FactType] |- uses;definedIn~")
    ; ("definedIn[Rule*Pattern]", "in~;sign[Relation*FactType] |- uses;definedIn~")
    ; ("extends[Context*Context]", "in;extends* |- in")
    ; ("in[Relation*Context]", "in;extends* |- in")
    ; ("extends[Context*Context]", "extends*;uses |- uses")
    ; ("uses[Context*Pattern]", "extends*;uses |- uses")
    ; ("extends[Context*Context]", "scope = in;extends*")
    ; ("in[Relation*Context]", "scope = in;extends*")
    ; ("scope[Relation*Context]", "scope = in;extends*")
    ].
    
 sign :: Relation -> FactType [SUR,INJ]  -- Rel 20
  = [ ("Rel 1", "isElementOf[Atom*Set]")
    ; ("Rel 2", "isSubsetOf[Set*Set]")
    ; ("Rel 3", "isa[Concept*Concept]")
    ; ("Rel 4", "pop[Concept*Set]")
    ; ("Rel 5", "type[Atom*Concept]")
    ; ("Rel 6", "right[Fact*Atom]")
    ; ("Rel 7", "left[Fact*Atom]")
    ; ("Rel 8", "src[Fact*Concept]")
    ; ("Rel 9", "trg[Fact*Concept]")
    ; ("Rel 10","appliesIn[Rule*Context]")
    ; ("Rel 11","definedIn[Rule*Pattern]")
    ; ("Rel 12","definedIn[FactType*Pattern]")
    ; ("Rel 13","uses[Context*Pattern]")
    ; ("Rel 14","extends[Context*Context]")
    ; ("Rel 15","in[FactType*Rule]")
    ; ("Rel 16","in[Relation*Context]")
    ; ("Rel 17","in[Fact*Relation]")
    ; ("Rel 18","in[Fact*Valuation]")
    ; ("Rel 20","sign[Relation*FactType]")
    ; ("Rel 21","source[FactType*Concept]")
    ; ("Rel 22","target[FactType*Concept]")
    ; ("Rel 23","name[FactType*Identifier]")
    ; ("Rel 24","sub[FactType*FactType]")
    ; ("Rel 25","sub[Relation*Relation]")
    ; ("Rel 26","val[FactType*Fact]")
    ; ("Rel 27","val[Rule*Valuation]")
    ; ("Rel 28","scope[Relation*Context]")
    ].

--!RJ: Het onderstaande is raar; je wilt liever dat een Relation wordt gedefinieerd in een Pattern, en als dat Pattern applicable is in een Context, dan zit die Relation daar dus ook in.
 in :: Relation -> Context PRAGMA "Relation " " is defined in Context "  -- Rel 16
  = [ ("Rel 1",  "RAP")
    ; ("Rel 2",  "RAP")
    ; ("Rel 3",  "RAP")
    ; ("Rel 4",  "RAP")
    ; ("Rel 5",  "RAP")
    ; ("Rel 6",  "RAP")
    ; ("Rel 7",  "RAP")
    ; ("Rel 8",  "RAP")
    ; ("Rel 9",  "RAP")
    ; ("Rel 10", "RAP")
    ; ("Rel 11", "RAP")
    ; ("Rel 12", "RAP")
    ; ("Rel 13", "RAP")
    ; ("Rel 14", "RAP")
    ; ("Rel 15", "RAP")
    ; ("Rel 16", "RAP")
    ; ("Rel 17", "RAP")
    ; ("Rel 18", "RAP")
    ; ("Rel 20", "RAP")
    ; ("Rel 21", "RAP")
    ; ("Rel 22", "RAP")
    ; ("Rel 23", "RAP")
    ; ("Rel 24", "RAP")
    ; ("Rel 25", "RAP")
    ; ("Rel 26", "RAP")
    ; ("Rel 27", "RAP")
    ; ("Rel 28", "RAP")
    ].
RULE "inAppliesIn": in;appliesIn |- sign[Relation*FactType]~;in
  PHRASE "You always work in one particular context, called the <it>current context</it>. Every declaration is bound to precisely one relation in your current context. Notice that the same declaration may be bound to different relations in different contexts, because one rule (which is defined in a pattern) applies in all contexts that use this rule."
ENDPATTERN

PATTERN Relations
PURPOSE PATTERN Relations IN ENGLISH
{+In order for stakeholders to agree to the specifications of an application, they must commit to a common language in which these specifications can be formally expressed. This pattern defines the way in which Relations (between Concepts) are expressed in such languages, according to the Ampersand method.-}

 source :: FactType -> Concept
  = [ ("isElementOf[Atom*Set]", "Atom")
    ; ("isSubsetOf[Set*Set]", "Set")
    ; ("isa[Concept*Concept]", "Concept")
    ; ("pop[Concept*Set]", "Concept")
    ; ("type[Atom*Concept]", "Atom")
    ; ("right[Fact*Atom]", "Fact")
    ; ("left[Fact*Atom]", "Fact")
    ; ("src[Fact*Concept]", "Fact")
    ; ("trg[Fact*Concept]", "Fact")
    ; ("appliesIn[Rule*Context]", "Rule")
    ; ("definedIn[Rule*Pattern]", "Rule")
    ; ("definedIn[FactType*Pattern]", "FactType")
    ; ("uses[Context*Pattern]", "Context")
    ; ("extends[Context*Context]", "Context")
    ; ("in[FactType*Rule]", "FactType")
    ; ("in[Relation*Context]", "Relation")
    ; ("in[Fact*Relation]", "Fact")
    ; ("in[Fact*Valuation]", "Fact")
    ; ("sign[Relation*FactType]", "Relation")
    ; ("source[FactType*Concept]", "FactType")
    ; ("target[FactType*Concept]", "FactType")
    ; ("name[FactType*Identifier]", "FactType")
    ; ("sub[FactType*FactType]", "FactType")
    ; ("sub[Relation*Relation]", "Relation")
    ; ("val[FactType*Fact]", "FactType")
    ; ("val[Rule*Valuation]", "Rule")
    ; ("scope[Relation*Context]", "Relation")
    ].
 target :: FactType -> Concept
  = [ ("isElementOf[Atom*Set]", "Set")
    ; ("isSubsetOf[Set*Set]", "Set")
    ; ("isa[Concept*Concept]", "Concept")
    ; ("pop[Concept*Set]", "Set")
    ; ("type[Atom*Concept]", "Concept")
    ; ("right[Fact*Atom]", "Atom")
    ; ("left[Fact*Atom]", "Atom")
    ; ("src[Fact*Concept]", "Concept")
    ; ("trg[Fact*Concept]", "Concept")
    ; ("appliesIn[Rule*Context]", "Context")
    ; ("definedIn[Rule*Pattern]", "Pattern")
    ; ("definedIn[FactType*Pattern]", "Pattern")
    ; ("uses[Context*Pattern]", "Pattern")
    ; ("extends[Context*Context]", "Context")
    ; ("in[FactType*Rule]", "Rule")
    ; ("in[Relation*Context]", "Context")
    ; ("in[Fact*Relation]", "Relation")
    ; ("in[Fact*Valuation]", "Valuation")
    ; ("sign[Relation*FactType]", "FactType")
    ; ("source[FactType*Concept]", "Concept")
    ; ("target[FactType*Concept]", "Concept")
    ; ("name[FactType*Identifier]", "Identifier")
    ; ("sub[FactType*FactType]", "FactType")
    ; ("sub[Relation*Relation]", "Relation")
    ; ("val[FactType*Fact]", "Fact")
    ; ("val[Rule*Valuation]", "Valuation")
    ; ("scope[Relation*Context]", "Context")
    ].
--!RJ: een Fact zit wat mij betreft in precies 1 Relation, omdat als een Fact gewijzigd wordt, deze niet altijd in alle relaties tegelijk gewijzigd zou moeten worden.
 in :: Fact * Relation.
RULE "inSign": in;sign |- src;source~/\trg;target~
  PHRASE "A fact (i.e. tuple) in a relation matches the declaration of that relation. That is: the left atom of a fact is atom of the source of the relation in which that fact resides. Idem for the target."
RULE "signInI": sign;I[FactType];sign~/\in;I[Context];in~ = I
  PHRASE "Within any context, the declaration (i.e. name, source and target) determines a relation uniquely."
 sub :: Relation * Relation [ASY]
  = [ ("Rel 1",  "Rel 1")
    ; ("Rel 2",  "Rel 2")
    ; ("Rel 3",  "Rel 3")
    ; ("Rel 4",  "Rel 4")
    ; ("Rel 5",  "Rel 5")
    ; ("Rel 6",  "Rel 6")
    ; ("Rel 7",  "Rel 7")
    ; ("Rel 8",  "Rel 8")
    ; ("Rel 9",  "Rel 9")
    ; ("Rel 10", "Rel 10")
    ; ("Rel 11", "Rel 11")
    ; ("Rel 12", "Rel 12")
    ; ("Rel 13", "Rel 13")
    ; ("Rel 14", "Rel 14")
    ; ("Rel 15", "Rel 15")
    ; ("Rel 16", "Rel 16")
    ; ("Rel 17", "Rel 17")
    ; ("Rel 18", "Rel 18")
    ; ("Rel 20", "Rel 20")
    ; ("Rel 21", "Rel 21")
    ; ("Rel 22", "Rel 22")
    ; ("Rel 23", "Rel 23")
    ; ("Rel 24", "Rel 24")
    ; ("Rel 25", "Rel 25")
    ; ("Rel 26", "Rel 26")
    ; ("Rel 27", "Rel 27")
    ; ("Rel 28", "Rel 28")
    ].
RULE "inSub": in;sub* |- in
  PHRASE "Any fact in relation r is also in relations of which r is a subrelation. The reason is that a relation is a set of links, so subsets are subrelations."
 name :: FactType -> Identifier
  = [ ("isElementOf[Atom*Set]",               "isElementOf")
    ; ("isSubsetOf[Set*Set]",              "isSubsetOf")
    ; ("isa[Concept*Concept]",         "isa")
    ; ("pop[Concept*Set]",             "pop")
    ; ("type[Atom*Concept]",           "type")
    ; ("right[Fact*Atom]",             "right")
    ; ("left[Fact*Atom]",              "left")
    ; ("src[Fact*Concept]",            "src")
    ; ("trg[Fact*Concept]",            "trg")
    ; ("appliesIn[Rule*Context]",      "appliesIn")
    ; ("definedIn[Rule*Pattern]",      "definedIn")
    ; ("definedIn[FactType*Pattern]", "definedIn")
    ; ("uses[Context*Pattern]",        "uses")
    ; ("extends[Context*Context]",     "extends")
    ; ("in[FactType*Rule]",           "in")
    ; ("in[Relation*Context]",         "in")
    ; ("in[Fact*Relation]",            "in")
    ; ("in[Fact*Valuation]",           "in")
    ; ("sign[Relation*FactType]",     "sign")
    ; ("source[FactType*Concept]",    "source")
    ; ("target[FactType*Concept]",    "target")
    ; ("name[FactType*Identifier]",   "name")
    ; ("sub[FactType*FactType]",     "sub")
    ; ("sub[Relation*Relation]",       "sub")
    ; ("val[FactType*Fact]",          "val")
    ; ("val[Rule*Valuation]",          "val")
    ; ("scope[Relation*Context]",      "scope")
    ].
RULE "iNameSourceTarget": I = name;name~/\source;source~/\target;target~
  PHRASE "A declaration's name, source and target identify it uniquely."
 sub :: FactType * FactType [ASY]
  = [ ("isElementOf[Atom*Set]",               "isElementOf[Atom*Set]")
    ; ("isSubsetOf[Set*Set]",              "isSubsetOf[Set*Set]")  
    ; ("isa[Concept*Concept]",         "isa[Concept*Concept]")
    ; ("pop[Concept*Set]",             "pop[Concept*Set]")
    ; ("type[Atom*Concept]",           "type[Atom*Concept]")
    ; ("right[Fact*Atom]",             "right[Fact*Atom]")
    ; ("left[Fact*Atom]",              "left[Fact*Atom]")
    ; ("src[Fact*Concept]",            "src[Fact*Concept]")
    ; ("trg[Fact*Concept]",            "trg[Fact*Concept]")
    ; ("appliesIn[Rule*Context]",      "appliesIn[Rule*Context]")
    ; ("definedIn[Rule*Pattern]",      "definedIn[Rule*Pattern]")
    ; ("definedIn[FactType*Pattern]", "definedIn[FactType*Pattern]")
    ; ("uses[Context*Pattern]",        "uses[Context*Pattern]")
    ; ("extends[Context*Context]",     "extends[Context*Context]")
    ; ("in[FactType*Rule]",           "in[FactType*Rule]")
    ; ("in[Relation*Context]",         "in[Relation*Context]")
    ; ("in[Fact*Relation]",            "in[Fact*Relation]")
    ; ("in[Fact*Valuation]",           "in[Fact*Valuation]")
    ; ("sign[Relation*FactType]",     "sign[Relation*FactType]")
    ; ("source[FactType*Concept]",    "source[FactType*Concept]")
    ; ("target[FactType*Concept]",    "target[FactType*Concept]")
    ; ("name[FactType*Identifier]",   "name[FactType*Identifier]")
    ; ("sub[FactType*FactType]",     "sub[FactType*FactType]")
    ; ("sub[Relation*Relation]",       "sub[Relation*Relation]")
    ; ("val[FactType*Fact]",          "val[FactType*Fact]")
    ; ("val[Rule*Valuation]",          "val[Rule*Valuation]")
    ; ("scope[Relation*Context]",      "scope[Relation*Context]")
    ].
RULE "subRelationDEF": sub[Relation]* = sign;sub[FactType]*;sign~/\in;extends*;in~
  PHRASE "If one relation is a subrelation of another one (the super-relation), it means that they have compatible declarations and the subrelation is in the same or a more specific context than the super-relation."
ENDPATTERN

PATTERN Valuations
PURPOSE PATTERN Valuations IN ENGLISH
{+In order for stakeholders to agree to the specifications of an application, they must commit to a common language in which these specifications can be formally expressed. This pattern defines the way in which Valuations are expressed in such languages, according to the Ampersand method.-}

 val :: Rule * Valuation.
 true :: Rule * Valuation.
 false :: Rule * Valuation.
RULE "valDEF": true \/ false = val PHRASE "All true and false valuations are valuations"
-- true /\ false # PHRASE "True valuations are disjoint from false valuations"
 val :: FactType * Fact.
 in :: Fact * Valuation.
RULE "inVal": in~;val |- val;in~
  PHRASE "For every fact in declarations of a rule r, r has a valuation containing that fact."
RULE "inValAppliesIn": in;val~;appliesIn |- in;in
  PHRASE "For every valuation of rule r that contains a fact l, that fact is element of a relation in each context in which r applies."
ENDPATTERN

PATTERN Patterns
PURPOSE PATTERN Patterns IN ENGLISH
{+In order for stakeholders to agree to the specifications of an application, they must commit to a common language in which these specifications can be formally expressed. This pattern defines the way in which Patterns are used in such languages, according to the Ampersand method.-}

 definedIn :: FactType -> Pattern
  = [ ("isElementOf[Atom*Set]", "Sets")
    ; ("isSubsetOf[Set*Set]", "Sets")
    ; ("isa[Concept*Concept]", "Concepts")
    ; ("pop[Concept*Set]", "Concepts")
    ; ("type[Atom*Concept]", "Concepts")
    ; ("right[Fact*Atom]", "Concepts")
    ; ("left[Fact*Atom]", "Concepts")
    ; ("src[Fact*Concept]", "Concepts")
    ; ("trg[Fact*Concept]", "Concepts")
    ; ("appliesIn[Rule*Context]", "Rules")
    ; ("definedIn[Rule*Pattern]", "Rules")
    ; ("definedIn[FactType*Pattern]", "Patterns")
    ; ("uses[Context*Pattern]", "Rules")
    ; ("extends[Context*Context]", "Rules")
    ; ("in[FactType*Rule]", "Rules")
    ; ("in[Relation*Context]", "Rules")
    ; ("in[Fact*Relation]", "Patterns")
    ; ("in[Fact*Valuation]", "Valuations")
    ; ("sign[Relation*FactType]", "Rules")
    ; ("source[FactType*Concept]", "Relations")
    ; ("target[FactType*Concept]", "Relations")
    ; ("name[FactType*Identifier]", "Relations")
    ; ("sub[FactType*FactType]", "Relations")
    ; ("sub[Relation*Relation]", "Relations")
    ; ("val[FactType*Fact]", "Valuations")
    ; ("val[Rule*Valuation]", "Valuations")
    ; ("scope[Relation*Context]", "Patterns")
    ].
RULE "inDefinedIn": in;definedIn = definedIn
  PHRASE "Every relation used in a rule is declared in the same pattern as that rule and every relation declared in that pattern is used in one of its rules. In the current ADL compiler, this rule is not enforced. Consequently, you can use any relation declared in this pattern's context and any relation in any context which is more generic."
RULE "iDefinedIn": I = definedIn~;definedIn[Rule*Pattern]
  PHRASE ""
RULE "inSign": in~;sign[Relation*FactType] |- uses;definedIn~
  PHRASE "A relation is bound to a declaration, which is defined in a pattern used in the relation's context."
RULE "inExtends2": in;extends* |- in
  PHRASE "Any relation in a context is also known in more generic contexts. The reason is that a relation is a set of links, so subsets are subrelations."
RULE "extendsUses2": extends*;uses |- uses
  PHRASE "A pattern used by a context is implicitly used by more specific contexts."
 scope :: Relation -> Context
  = [ ("Rel 1",  "RAP")
    ; ("Rel 2",  "RAP")
    ; ("Rel 3",  "RAP")
    ; ("Rel 4",  "RAP")
    ; ("Rel 5",  "RAP")
    ; ("Rel 6",  "RAP")
    ; ("Rel 7",  "RAP")
    ; ("Rel 8",  "RAP")
    ; ("Rel 9",  "RAP")
    ; ("Rel 10", "RAP")
    ; ("Rel 11", "RAP")
    ; ("Rel 12", "RAP")
    ; ("Rel 13", "RAP")
    ; ("Rel 14", "RAP")
    ; ("Rel 15", "RAP")
    ; ("Rel 16", "RAP")
    ; ("Rel 17", "RAP")
    ; ("Rel 18", "RAP")
    ; ("Rel 20", "RAP")
    ; ("Rel 21", "RAP")
    ; ("Rel 22", "RAP")
    ; ("Rel 23", "RAP")
    ; ("Rel 24", "RAP")
    ; ("Rel 25", "RAP")
    ; ("Rel 26", "RAP")
    ; ("Rel 27", "RAP")
    ; ("Rel 28", "RAP")
    ].
RULE "scopeDEF": scope = in;extends*
  PHRASE "A relation is in scope of a context if it is defined in that context or in one of its more specific contexts."
ENDPATTERN

PATTERN Multiplicities
PURPOSE PATTERN Multiplicities IN ENGLISH
{+In order for stakeholders to agree to the specifications of an application, they must commit to a common language in which these specifications can be formally expressed. This pattern defines the way in which multiplicities of relations  are expressed in such languages, according to the Ampersand method.-}

 univalent  :: FactType*FactType [SYM,ASY].
 total      :: FactType*FactType [SYM,ASY].
 functional :: FactType*FactType [SYM,ASY].
 injective  :: FactType*FactType [SYM,ASY].
 surjective :: FactType*FactType [SYM,ASY].
 invfunc    :: FactType*FactType [SYM,ASY].
 flp        :: FactType*FactType [SYM,UNI,TOT,SUR,INJ].
RULE "functionalDEF": functional = univalent /\ total --COMPUTING functional
RULE "invfuncDEF": invfunc = injective /\ surjective --COMPUTING invfunc
RULE "surjectiveDEF": total;flp = surjective --COMPUTING surjective,total
RULE "univalentDEF": injective;flp = univalent --COMPUTING univalent,injective
ENDPATTERN

PATTERN TheISArelation
PURPOSE PATTERN TheISArelation IN ENGLISH
{+In order for stakeholders to agree to the specifications of an application, they must commit to a common language in which these specifications can be formally expressed. This pattern defines the way in which ISA relations are used in such languages, according to the Ampersand method.-}

 isa :: Concept * Concept [ASY] PRAGMA "every " " is a " " as well".
 pop :: Concept -> Set PRAGMA "Concept " " has set " ", which contains its population"
   = [ ("Atom", "Atoms")
     ; ("Concept", "Concepts")
     ; ("Context", "Contexts")
     ; ("Identifier", "Identifiers")
     ; ("Fact", "Links")
     ; ("Pattern", "Patterns")
     ; ("Relation", "Relations")
     ; ("Rule", "Rules")
     ; ("Set", "Sets")
     ; ("FactType", "Declarations")
     ; ("Valuation", "Valuations")
     ].
RULE "isaStar": isa* |- pop;isSubsetOf*;pop~
  PHRASE "The relation isa applies to concepts. The relation `isSubsetOf' applies to sets. They correspond to one another by means of the function pop, which associates a set to every concept. For instance `Judge isa Person' means that the concept Judge is more specific than the concept `Person'. The set of judges (corresponding to `Judge') is therefore a isSubsetOf of the set of persons (which corresponds to `Person')."
ENDPATTERN