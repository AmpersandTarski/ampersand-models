PATTERN Concepts
--! PATTERN Concepts USES Sets
-- GLUE type = isElementOf -- Eruitgegooid; we hebben immers ook pop :: Concept -> Set 
GEN Atom ISA Element -- See pattern Sets.
 type :: Atom -> Concept PRAGMA "Atom " " is of type ".  -- Empty Relation
RULE "atomtype": type = isElementOf;pop~
  PHRASE "An atom has a type, which is a concept in whose population the atom occurs or any more general concept than that."
 left  :: Pair -> Atom  PRAGMA "Pair " " has " " as its left Atom".  -- Empty Relation
 right :: Pair -> Atom  PRAGMA "Pair " " has " " as its right Atom".  -- Empty Relation
-- KEY "keyLink": Pair(left,right)
RULE pairKey: I[Pair] =  in[Pair*Relation];in~ /\ left;left~ /\ right;right~ PHRASE "A pair is uniquely characterized by its relation and its left and right atoms." -- This used to be just Pair(left,right), but for transactions we also need the relation to be part of this - see CSLTransactions.pat
 src :: Pair -> Concept.
RULE "leftype": left |- src;pop;isElementOf~
  PHRASE "The left atom of a link is in the set that corresponds to the source concept of that link."
trg :: Pair -> Concept.
RULE "rightype":  right |- trg;pop;isElementOf~
  PHRASE "The right atom of a link is in the set that corresponds to the target concept of that link."
RULE "leftsrc": left~;src |- type --COMPUTING type,src
  PHRASE "The type of the left atom of a link is the src of that link."
RULE "rightsrc": right~;trg |- type --COMPUTING type,trg
  PHRASE "The type of the right atom of a link is the trg of that link."
RULE "leftype": left;type |- src --COMPUTING type,src
  PHRASE "The type of the left atom of a link is the src of that link."
RULE "rightype":  right;type |- trg --COMPUTING type,trg
  PHRASE "The type of the right atom of a link is the trg of that link."
ENDPATTERN


PATTERN Rules
 definedIn :: Rule -> Pattern PRAGMA "Rule " " is defined in Pattern "
-- RJ/15082007: Note that the functionality of this relation means that two rules that consist of one and the same expression, are considered to be different rules. This is not the way in which the tool currently behaves 
  = [ ("isElementOf;isSubsetOf* |- isElementOf", "Sets")
    ; ("isa* |- pop;isSubsetOf*;pop~", "Sets")
    ; ("type = isElementOf;pop~", "Concepts")
    ; ("right;right~/\\left;left~ = I", "Concepts")
    ; ("left |- src;pop;isElementOf~", "Concepts")
    ; ("right |- trg;pop;isElementOf~", "Concepts")
    ; ("appliesIn = definedIn;uses~", "Rules")
    ; ("appliesIn;extends*~ |- appliesIn", "Rules")
    ; ("in;appliesIn |- sign[Relation*Declaration]~;in", "Rules")
    ; ("in;sign |- src;source~/\\trg;target~", "Relations")
    ; ("sign;sign~/\\in~;in = I[Relation]", "Relations")
    ; ("in;sub* |- in", "Relations")
    ; ("I = name;name~/\\source;source~/\\target;target~", "Relations")
    ; ("sub* = sign;sub*;sign~/\\in;extends*;in~", "Relations")
    ; ("in~;val |- val;in~", "Valuations")
    ; ("in;val~;appliesIn |- in;in", "Valuations")
    ; ("definedIn = sign~;in;definedIn", "Patterns")
    ; ("I = definedIn~;definedIn[Rule*Pattern]", "Patterns")
    ; ("in~;sign[Relation*Declaration] |- uses;definedIn~", "Patterns")
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
    ; ("in;appliesIn |- sign[Relation*Declaration]~;in", "RAP")
    ; ("in;sign |- src;source~/\\trg;target~", "RAP")
    ; ("sign;sign~/\\in~;in = I[Relation]", "RAP")
    ; ("in;sub* |- in", "RAP")
    ; ("I = name;name~/\\source;source~/\\target;target~", "RAP")
    ; ("sub* = sign;sub*;sign~/\\in;extends*;in~", "RAP")
    ; ("in~;val |- val;in~", "RAP")
    ; ("in;val~;appliesIn |- in;in", "RAP")
    ; ("definedIn = sign~;in;definedIn", "RAP")
    ; ("I = definedIn~;definedIn[Rule*Pattern]", "RAP")
    ; ("in~;sign[Relation*Declaration] |- uses;definedIn~", "RAP")
    ; ("in;extends* |- in", "RAP")
    ; ("extends*;uses |- uses", "RAP")
    ; ("scope = in;extends*", "RAP")
    ].
RULE "appliesInDEF": appliesIn = definedIn;uses~
  PHRASE "Rules are defined in a pattern. When that pattern is used in a context, all rules of that pattern apply within the context. Within the context itself, extra rules may be defined for the purpose of glueing patterns together. So all rules that apply in a context are the ones defined in patterns used by the context plus the rules defined within that context."
-- RJ/15082007: Note that because 'definedIn' is functional, it may happen that rule A defined in pattern A within context C has the same RA-expression as rule B in pattern B in context C, but they are still treated as different rules, which should mean that a violation of rule A in context C will show up twice, as the same data would constitute a violation of rule B. I'm not sure whether or not this is of concern. 
 extends :: Context * Context [IRF,ASY] PRAGMA "Context " " (specific) extends Context " " (generic)"
  = [ ("RAP", "RAP") ].
RULE "appliesExtends": appliesIn;extends*~ |- appliesIn
  PHRASE "If you work in a context (e.g. the context of Marlays bank) you may define a new context (e.g. Mortgages) as an extention of an existing context. This means that all rules that apply in the context `Marlays bank' apply in the context `Mortgages' as well. The rules that apply in the generic context (`Marlays bank') are a isSubsetOf of the rules that apply in the specific context (`Mortgages')."
 in :: Declaration * Rule [SUR,TOT]
  = [ ("isElementOf[Atom*Set]", "isElementOf;isSubsetOf* |- isElementOf")
    ; ("isSubsetOf[Set*Set]", "isElementOf;isSubsetOf* |- isElementOf")
    ; ("isSubsetOf[Set*Set]", "isa* |- pop;isSubsetOf*;pop~")
    ; ("isa[Concept*Concept]", "isa* |- pop;isSubsetOf*;pop~")
    ; ("pop[Concept*Set]", "isa* |- pop;isSubsetOf*;pop~")
    ; ("isElementOf[Atom*Set]", "type = isElementOf;pop~")
    ; ("isa[Concept*Concept]", "type = isElementOf;pop~")
    ; ("pop[Concept*Set]", "type = isElementOf;pop~")
    ; ("type[Atom*Concept]", "type = isElementOf;pop~")
    ; ("right[Pair*Atom]", "right;right~/\\left;left~ = I")
    ; ("left[Pair*Atom]", "right;right~/\\left;left~ = I")
    ; ("isElementOf[Atom*Set]", "left |- src;pop;isElementOf~")
    ; ("pop[Concept*Set]", "left |- src;pop;isElementOf~")
    ; ("left[Pair*Atom]", "left |- src;pop;isElementOf~")
    ; ("src[Pair*Concept]", "left |- src;pop;isElementOf~")
    ; ("isElementOf[Atom*Set]", "right |- trg;pop;isElementOf~")
    ; ("pop[Concept*Set]", "right |- trg;pop;isElementOf~")
    ; ("right[Pair*Atom]", "right |- trg;pop;isElementOf~")
    ; ("trg[Pair*Concept]", "right |- trg;pop;isElementOf~")
    ; ("appliesIn[Rule*Context]", "appliesIn = definedIn;uses~")
    ; ("definedIn[Rule*Pattern]", "appliesIn = definedIn;uses~")
    ; ("uses[Context*Pattern]", "appliesIn = definedIn;uses~")
    ; ("appliesIn[Rule*Context]", "appliesIn;extends*~ |- appliesIn")
    ; ("extends[Context*Context]", "appliesIn;extends*~ |- appliesIn")
    ; ("appliesIn[Rule*Context]", "in;appliesIn |- sign[Relation*Declaration]~;in")
    ; ("in[Declaration*Rule]", "in;appliesIn |- sign[Relation*Declaration]~;in")
    ; ("sign[Relation*Declaration]", "in;appliesIn |- sign[Relation*Declaration]~;in")
    ; ("in[Relation*Context]", "in;appliesIn |- sign[Relation*Declaration]~;in")
    ; ("in[Pair*Relation]", "in;sign |- src;source~/\\trg;target~")
    ; ("sign[Relation*Declaration]", "in;sign |- src;source~/\\trg;target~")
    ; ("src[Pair*Concept]", "in;sign |- src;source~/\\trg;target~")
    ; ("source[Declaration*Concept]", "in;sign |- src;source~/\\trg;target~")
    ; ("trg[Pair*Concept]", "in;sign |- src;source~/\\trg;target~")
    ; ("target[Declaration*Concept]", "in;sign |- src;source~/\\trg;target~")
    ; ("sign[Relation*Declaration]", "sign;sign~/\\in~;in = I[Relation]")
    ; ("in[Pair*Relation]", "sign;sign~/\\in~;in = I[Relation]")
    ; ("in[Pair*Relation]", "in;sub* |- in")
    ; ("sub[Relation*Relation]", "in;sub* |- in")
    ; ("name[Declaration*Identifier]", "I = name;name~/\\source;source~/\\target;target~")
    ; ("source[Declaration*Concept]", "I = name;name~/\\source;source~/\\target;target~")
    ; ("target[Declaration*Concept]", "I = name;name~/\\source;source~/\\target;target~")
    ; ("extends[Context*Context]", "sub* = sign;sub*;sign~/\\in;extends*;in~")
    ; ("sub[Declaration*Declaration]", "sub* = sign;sub*;sign~/\\in;extends*;in~")
    ; ("sub[Relation*Relation]", "sub* = sign;sub*;sign~/\\in;extends*;in~")
    ; ("sign[Relation*Declaration]", "sub* = sign;sub*;sign~/\\in;extends*;in~")
    ; ("in[Relation*Context]", "sub* = sign;sub*;sign~/\\in;extends*;in~")
    ; ("val[Declaration*Pair]", "in~;val |- val;in~")
    ; ("val[Rule*Valuation]", "in~;val |- val;in~")
    ; ("in[Declaration*Rule]", "in~;val |- val;in~")
    ; ("in[Pair*Valuation]", "in~;val |- val;in~")
    ; ("in[Pair*Valuation]", "in;val~;appliesIn |- in;in")
    ; ("val[Rule*Valuation]", "in;val~;appliesIn |- in;in")
    ; ("appliesIn[Rule*Context]", "in;val~;appliesIn |- in;in")
    ; ("in[Pair*Relation]", "in;val~;appliesIn |- in;in")
    ; ("in[Relation*Context]", "in;val~;appliesIn |- in;in")
    ; ("definedIn[Signature*Pattern]", "definedIn = sign~;in;definedIn")
    ; ("in[Declaration*Rule]", "definedIn = sign~;in;definedIn")
    ; ("definedIn[Rule*Pattern]", "definedIn = sign~;in;definedIn")
    ; ("definedIn[Rule*Pattern]", "I = definedIn~;definedIn[Rule*Pattern]")
    ; ("in[Relation*Context]", "in~;sign[Relation*Declaration] |- uses;definedIn~")
    ; ("sign[Relation*Declaration]", "in~;sign[Relation*Declaration] |- uses;definedIn~")
    ; ("uses[Context*Pattern]", "in~;sign[Relation*Declaration] |- uses;definedIn~")
    ; ("definedIn[Rule*Pattern]", "in~;sign[Relation*Declaration] |- uses;definedIn~")
    ; ("extends[Context*Context]", "in;extends* |- in")
    ; ("in[Relation*Context]", "in;extends* |- in")
    ; ("extends[Context*Context]", "extends*;uses |- uses")
    ; ("uses[Context*Pattern]", "extends*;uses |- uses")
    ; ("extends[Context*Context]", "scope = in;extends*")
    ; ("in[Relation*Context]", "scope = in;extends*")
    ; ("scope[Relation*Context]", "scope = in;extends*")
    ].
    
 sign :: Relation -> Declaration [SUR,INJ]  -- Rel 20
  = [ ("Rel 1", "isElementOf[Atom*Set]")
    ; ("Rel 2", "isSubsetOf[Set*Set]")
    ; ("Rel 3", "isa[Concept*Concept]")
    ; ("Rel 4", "pop[Concept*Set]")
    ; ("Rel 5", "type[Atom*Concept]")
    ; ("Rel 6", "right[Pair*Atom]")
    ; ("Rel 7", "left[Pair*Atom]")
    ; ("Rel 8", "src[Pair*Concept]")
    ; ("Rel 9", "trg[Pair*Concept]")
    ; ("Rel 10","appliesIn[Rule*Context]")
    ; ("Rel 11","definedIn[Rule*Pattern]")
    ; ("Rel 12","definedIn[Declaration*Pattern]")
    ; ("Rel 13","uses[Context*Pattern]")
    ; ("Rel 14","extends[Context*Context]")
    ; ("Rel 15","in[Declaration*Rule]")
    ; ("Rel 16","in[Relation*Context]")
    ; ("Rel 17","in[Pair*Relation]")
    ; ("Rel 18","in[Pair*Valuation]")
    ; ("Rel 20","sign[Relation*Declaration]")
    ; ("Rel 21","source[Declaration*Concept]")
    ; ("Rel 22","target[Declaration*Concept]")
    ; ("Rel 23","name[Declaration*Identifier]")
    ; ("Rel 24","sub[Declaration*Declaration]")
    ; ("Rel 25","sub[Relation*Relation]")
    ; ("Rel 26","val[Declaration*Pair]")
    ; ("Rel 27","val[Rule*Valuation]")
    ; ("Rel 28","scope[Relation*Context]")
    ].

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
RULE "inAppliesIn": in;appliesIn |- sign[Relation*Declaration]~;in
  PHRASE "You always work in one particular context, called the <it>current context</it>. Every declaration is bound to precisely one relation in your current context. Notice that the same declaration may be bound to different relations in different contexts, because one rule (which is defined in a pattern) applies in all contexts that use this rule."
ENDPATTERN

PATTERN Relations
 source :: Declaration -> Concept
  = [ ("isElementOf[Atom*Set]", "Atom")
    ; ("isSubsetOf[Set*Set]", "Set")
    ; ("isa[Concept*Concept]", "Concept")
    ; ("pop[Concept*Set]", "Concept")
    ; ("type[Atom*Concept]", "Atom")
    ; ("right[Pair*Atom]", "Pair")
    ; ("left[Pair*Atom]", "Pair")
    ; ("src[Pair*Concept]", "Pair")
    ; ("trg[Pair*Concept]", "Pair")
    ; ("appliesIn[Rule*Context]", "Rule")
    ; ("definedIn[Rule*Pattern]", "Rule")
    ; ("definedIn[Declaration*Pattern]", "Declaration")
    ; ("uses[Context*Pattern]", "Context")
    ; ("extends[Context*Context]", "Context")
    ; ("in[Declaration*Rule]", "Declaration")
    ; ("in[Relation*Context]", "Relation")
    ; ("in[Pair*Relation]", "Pair")
    ; ("in[Pair*Valuation]", "Pair")
    ; ("sign[Relation*Declaration]", "Relation")
    ; ("source[Declaration*Concept]", "Declaration")
    ; ("target[Declaration*Concept]", "Declaration")
    ; ("name[Declaration*Identifier]", "Declaration")
    ; ("sub[Declaration*Declaration]", "Declaration")
    ; ("sub[Relation*Relation]", "Relation")
    ; ("val[Declaration*Pair]", "Declaration")
    ; ("val[Rule*Valuation]", "Rule")
    ; ("scope[Relation*Context]", "Relation")
    ].
 target :: Declaration -> Concept
  = [ ("isElementOf[Atom*Set]", "Set")
    ; ("isSubsetOf[Set*Set]", "Set")
    ; ("isa[Concept*Concept]", "Concept")
    ; ("pop[Concept*Set]", "Set")
    ; ("type[Atom*Concept]", "Concept")
    ; ("right[Pair*Atom]", "Atom")
    ; ("left[Pair*Atom]", "Atom")
    ; ("src[Pair*Concept]", "Concept")
    ; ("trg[Pair*Concept]", "Concept")
    ; ("appliesIn[Rule*Context]", "Context")
    ; ("definedIn[Rule*Pattern]", "Pattern")
    ; ("definedIn[Declaration*Pattern]", "Pattern")
    ; ("uses[Context*Pattern]", "Pattern")
    ; ("extends[Context*Context]", "Context")
    ; ("in[Declaration*Rule]", "Rule")
    ; ("in[Relation*Context]", "Context")
    ; ("in[Pair*Relation]", "Relation")
    ; ("in[Pair*Valuation]", "Valuation")
    ; ("sign[Relation*Declaration]", "Declaration")
    ; ("source[Declaration*Concept]", "Concept")
    ; ("target[Declaration*Concept]", "Concept")
    ; ("name[Declaration*Identifier]", "Identifier")
    ; ("sub[Declaration*Declaration]", "Declaration")
    ; ("sub[Relation*Relation]", "Relation")
    ; ("val[Declaration*Pair]", "Pair")
    ; ("val[Rule*Valuation]", "Valuation")
    ; ("scope[Relation*Context]", "Context")
    ].
 in :: Pair * Relation.
RULE "inSign": in;sign |- src;source~/\trg;target~
  PHRASE "A link (i.e. tuple) in a relation matches the declaration of that relation. That is: the left atom of a tuple is atom of the source of the relation in which that tuple resides. Idem for the target."
RULE "signInI": sign;I[Declaration];sign~/\in;I[Context];in~ = I
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
  PHRASE "Any link in relation r is also in relations of which r is a subrelation. The reason is that a relation is a set of links, so subsets are subrelations."
 name :: Declaration -> Identifier
  = [ ("isElementOf[Atom*Set]",               "isElementOf")
    ; ("isSubsetOf[Set*Set]",              "isSubsetOf")
    ; ("isa[Concept*Concept]",         "isa")
    ; ("pop[Concept*Set]",             "pop")
    ; ("type[Atom*Concept]",           "type")
    ; ("right[Pair*Atom]",             "right")
    ; ("left[Pair*Atom]",              "left")
    ; ("src[Pair*Concept]",            "src")
    ; ("trg[Pair*Concept]",            "trg")
    ; ("appliesIn[Rule*Context]",      "appliesIn")
    ; ("definedIn[Rule*Pattern]",      "definedIn")
    ; ("definedIn[Declaration*Pattern]", "definedIn")
    ; ("uses[Context*Pattern]",        "uses")
    ; ("extends[Context*Context]",     "extends")
    ; ("in[Declaration*Rule]",           "in")
    ; ("in[Relation*Context]",         "in")
    ; ("in[Pair*Relation]",            "in")
    ; ("in[Pair*Valuation]",           "in")
    ; ("sign[Relation*Declaration]",     "sign")
    ; ("source[Declaration*Concept]",    "source")
    ; ("target[Declaration*Concept]",    "target")
    ; ("name[Declaration*Identifier]",   "name")
    ; ("sub[Declaration*Declaration]",     "sub")
    ; ("sub[Relation*Relation]",       "sub")
    ; ("val[Declaration*Pair]",          "val")
    ; ("val[Rule*Valuation]",          "val")
    ; ("scope[Relation*Context]",      "scope")
    ].
RULE "iNameSourceTarget": I = name;name~/\source;source~/\target;target~
  PHRASE "A declaration's name, source and target identify it uniquely."
 sub :: Declaration * Declaration [ASY]
  = [ ("isElementOf[Atom*Set]",               "isElementOf[Atom*Set]")
    ; ("isSubsetOf[Set*Set]",              "isSubsetOf[Set*Set]")  
    ; ("isa[Concept*Concept]",         "isa[Concept*Concept]")
    ; ("pop[Concept*Set]",             "pop[Concept*Set]")
    ; ("type[Atom*Concept]",           "type[Atom*Concept]")
    ; ("right[Pair*Atom]",             "right[Pair*Atom]")
    ; ("left[Pair*Atom]",              "left[Pair*Atom]")
    ; ("src[Pair*Concept]",            "src[Pair*Concept]")
    ; ("trg[Pair*Concept]",            "trg[Pair*Concept]")
    ; ("appliesIn[Rule*Context]",      "appliesIn[Rule*Context]")
    ; ("definedIn[Rule*Pattern]",      "definedIn[Rule*Pattern]")
    ; ("definedIn[Declaration*Pattern]", "definedIn[Declaration*Pattern]")
    ; ("uses[Context*Pattern]",        "uses[Context*Pattern]")
    ; ("extends[Context*Context]",     "extends[Context*Context]")
    ; ("in[Declaration*Rule]",           "in[Declaration*Rule]")
    ; ("in[Relation*Context]",         "in[Relation*Context]")
    ; ("in[Pair*Relation]",            "in[Pair*Relation]")
    ; ("in[Pair*Valuation]",           "in[Pair*Valuation]")
    ; ("sign[Relation*Declaration]",     "sign[Relation*Declaration]")
    ; ("source[Declaration*Concept]",    "source[Declaration*Concept]")
    ; ("target[Declaration*Concept]",    "target[Declaration*Concept]")
    ; ("name[Declaration*Identifier]",   "name[Declaration*Identifier]")
    ; ("sub[Declaration*Declaration]",     "sub[Declaration*Declaration]")
    ; ("sub[Relation*Relation]",       "sub[Relation*Relation]")
    ; ("val[Declaration*Pair]",          "val[Declaration*Pair]")
    ; ("val[Rule*Valuation]",          "val[Rule*Valuation]")
    ; ("scope[Relation*Context]",      "scope[Relation*Context]")
    ].
RULE "subRelationDEF": sub[Relation]* = sign;sub[Declaration]*;sign~/\in;extends*;in~
  PHRASE "If one relation is a subrelation of another one (the super-relation), it means that they have compatible declarations and the subrelation is in the same or a more specific context than the super-relation."
ENDPATTERN


PATTERN Valuations
 val :: Rule * Valuation.
 true :: Rule * Valuation.
 false :: Rule * Valuation.
RULE "valDEF": true \/ false = val PHRASE "All true and false valuations are valuations"
-- true /\ false # PHRASE "True valuations are disjoint from false valuations"
 val :: Declaration * Pair.
 in :: Pair * Valuation.
RULE "inVal": in~;val |- val;in~
  PHRASE "For every link in declarations of a rule r, r has a valuation containing that link."
RULE "inValAppliesIn": in;val~;appliesIn |- in;in
  PHRASE "For every valuation of rule r that contains a link l, that link is element of a relation in each context in which r applies."
ENDPATTERN

PATTERN Patterns
 definedIn :: Declaration -> Pattern
  = [ ("isElementOf[Atom*Set]", "Sets")
    ; ("isSubsetOf[Set*Set]", "Sets")
    ; ("isa[Concept*Concept]", "Concepts")
    ; ("pop[Concept*Set]", "Concepts")
    ; ("type[Atom*Concept]", "Concepts")
    ; ("right[Pair*Atom]", "Concepts")
    ; ("left[Pair*Atom]", "Concepts")
    ; ("src[Pair*Concept]", "Concepts")
    ; ("trg[Pair*Concept]", "Concepts")
    ; ("appliesIn[Rule*Context]", "Rules")
    ; ("definedIn[Rule*Pattern]", "Rules")
    ; ("definedIn[Declaration*Pattern]", "Patterns")
    ; ("uses[Context*Pattern]", "Rules")
    ; ("extends[Context*Context]", "Rules")
    ; ("in[Declaration*Rule]", "Rules")
    ; ("in[Relation*Context]", "Rules")
    ; ("in[Pair*Relation]", "Patterns")
    ; ("in[Pair*Valuation]", "Valuations")
    ; ("sign[Relation*Declaration]", "Rules")
    ; ("source[Declaration*Concept]", "Relations")
    ; ("target[Declaration*Concept]", "Relations")
    ; ("name[Declaration*Identifier]", "Relations")
    ; ("sub[Declaration*Declaration]", "Relations")
    ; ("sub[Relation*Relation]", "Relations")
    ; ("val[Declaration*Pair]", "Valuations")
    ; ("val[Rule*Valuation]", "Valuations")
    ; ("scope[Relation*Context]", "Patterns")
    ].
RULE "inDefinedIn": in;definedIn = definedIn
  PHRASE "Every relation used in a rule is declared in the same pattern as that rule and every relation declared in that pattern is used in one of its rules. In the current ADL compiler, this rule is not enforced. Consequently, you can use any relation declared in this pattern's context and any relation in any context which is more generic."
RULE "iDefinedIn": I = definedIn~;definedIn[Rule*Pattern]
  PHRASE ""
RULE "inSign": in~;sign[Relation*Declaration] |- uses;definedIn~
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
 univalent  :: Declaration*Declaration [SYM,ASY].
 total      :: Declaration*Declaration [SYM,ASY].
 functional :: Declaration*Declaration [SYM,ASY].
 injective  :: Declaration*Declaration [SYM,ASY].
 surjective :: Declaration*Declaration [SYM,ASY].
 invfunc    :: Declaration*Declaration [SYM,ASY].
 flp        :: Declaration*Declaration [SYM,UNI,TOT,SUR,INJ].
RULE "functionalDEF": functional = univalent /\ total --COMPUTING functional
RULE "invfuncDEF": invfunc = injective /\ surjective --COMPUTING invfunc
RULE "surjectiveDEF": total;flp = surjective --COMPUTING surjective,total
RULE "univalentDEF": injective;flp = univalent --COMPUTING univalent,injective
ENDPATTERN

PATTERN TheISArelation
 isa :: Concept * Concept [ASY] PRAGMA "every " " is a " " as well".
 pop :: Concept -> Set PRAGMA "Concept " " has set " ", which contains its population"
   = [ ("Atom", "Atoms")
     ; ("Concept", "Concepts")
     ; ("Context", "Contexts")
     ; ("Identifier", "Identifiers")
     ; ("Pair", "Links")
     ; ("Pattern", "Patterns")
     ; ("Relation", "Relations")
     ; ("Rule", "Rules")
     ; ("Set", "Sets")
     ; ("Declaration", "Declarations")
     ; ("Valuation", "Valuations")
     ].
RULE "isaStar": isa* |- pop;isSubsetOf*;pop~
  PHRASE "The relation isa applies to concepts. The relation `isSubsetOf' applies to sets. They correspond to one another by means of the function pop, which associates a set to every concept. For instance `Judge isa Person' means that the concept Judge is more specific than the concept `Person'. The set of judges (corresponding to `Judge') is therefore a isSubsetOf of the set of persons (which corresponds to `Person')."
ENDPATTERN