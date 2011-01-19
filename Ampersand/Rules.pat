PATTERN Rules -- WIJZIGER: rieks.joosten@tno.nl **ENGLISH explanations zijn op orde**
PURPOSE PATTERN Rules IN ENGLISH
{+Business Rules are meant for communication with stakeholders in the business [ROSS2003]_, i.e. for communication with humans. This pattern specifies the structure of **formalized** business rules, i.e. business rules that are logical expressions of primitives that can be evaluated automatically (provided each primitive can be assigned a value). 

Within this pattern, it is required that there is an equivalence between 'ordinary' Business Rules as expressed in a natural language, and Formalized Business Rules as expressed in a formal language such as relation algebra.
-}
--** Dit moet worden aangepast aan wat er op het bord staat **--
-- Markup uses `reStructuredTexts <http://docutils.sourceforge.net/docs/user/rst/quickref.html>`_

CONCEPT Rule "a statement that can either be complied with, or not"
PURPOSE CONCEPT Rule IN ENGLISH 
{+Rules exist (within a Holon, or scope) to to distinguish compliant (wanted) situations from non-compliant (unwanted) situations. Rules are expressed in a natural language i.e.: expressed by some text; this text has a specific meaning within the rule's scope. It may or may not be possible for third parties to assess the meaning of a rule, or to evaluate a rule. It may or may not be possible to convey the meaning of a rule to outside the scope. -}

ruleScope :: Rule -> Holon PRAGMA "" " must be interpreted/evaluated within the scope of ".
PURPOSE RELATION ruleScope IN ENGLISH
{+Every rule has a distinct meaning and purpose. This meaning/purpose is assigned within a specific Holon (scope). The consequence of this should be that the rule should only be evaluated using data that is meaningful within this Holon.-}
PURPOSE RELATION ruleScope IN DUTCH
{+Elke regel heeft een specifiek doel en betekenis. Deze betekenis c.q. dit doel is toegekend binnen een zekere Holon (scope). Dit houdt in dat evaluatie van deze regel alleen plaats mag vinden met data die binnen dezelfde Holon betekenisvol is.-}

ruleText :: Rule -> Text PRAGMA "" " is expressed in natural language as ".
PURPOSE RELATION ruleText IN ENGLISH 
{+Rules can be  expressed in a natural language in an attempt to convey their meaning to stakeholders that may discuss them.-}

RULE "rule keys" MAINTAINS I[Rule] = ruleText;ruleText~ /\ ruleScope;ruleScope~
PURPOSE RULE "rule keys" IN ENGLISH
{+Every rule is uniquely characterized by its scope (Holon) and its natural language expression.-}
PURPOSE RULE "rule keys" IN DUTCH
{+Elke regel is uniek gekarakterisserd door diens scope (Holon) en diens natuurlijke taal uitdrukking (tekst).-}

ENDPATTERN
-----------------------------------------------------------------------
PATTERN "Formalized Rules" -- WIJZIGER: rieks.joosten@tno.nl

CONCEPT FormalRule "a logical expression that upon evaluation results in either 'TRUE' or 'FALSE'"
PURPOSE CONCEPT FormalRule IN ENGLISH 
{+Formal Rules are Rules that are not only represented by a natural language text, but also by a precisely formulated  formal expression, using e.g. relation algebra or predicate logic. The formal expression of a FormalRule defines the meaning of the Rule, whereas the natural language text is merely a set of words to give (business) people a rough idea of what the rule is about. For all Formal Rules, it is possible for third parties to assess the meaning, as well as to evaluate the Rule. Also, it is possible to convey this meaning to outside the scope because the formalism (algebra, logic) is considered a universal and thus shared knowledge.-}

GEN FormalRule ISA Rule

formalExpr :: FormalRule -> Expression PRAGMA "The formal expression of " " is given by ".
PURPOSE RELATION formalExpr IN ENGLISH 
{+Rules can be expressed in a formal langauge such as relation algebra allowing them to be used in automated contexts.-}

RULE "formal rule uniqueness" MAINTAINS formalExpr; formalExpr~ |- I \/ ruleScope; -I; ruleScope~
PURPOSE RULE "formal rule uniqueness" IN ENGLISH
{+Within a Holon, the formal representation of a rule can be associated only with a single natural language expression representing the same rule. If this were not the case, then this would allow ambiguities in rules, as different rules (having different natural language representations and being assigned to a single holon) could have a single formal representation.-}

ENDPATTERN
-----------------------------------------------------------------------
PATTERN "Expressions" -- WIJZIGER: rieks.joosten@tno.nl

subExprOf :: Expression * Expression [ASY] PRAGMA "" " is an expression contained within ".
PURPOSE RELATION subExprOf IN ENGLISH
{+In order to be able to evaluate expressions, it is necessary to be able to decompose complex expressions into more basic parts. Considering that expressions are logical combinations of (other) expressions, any expression 'e' that is combined with at least one operator (and optionally other expressions) such that the result is a valid expression, is called a subexpression of the latter expression. The latter expression is called a parent (expression) of 'e', and 'e' is called a subexpression or child expression of any of its parents.-}

--! onderstaande regel is 'asymmetric' omdat-ie bedoeld is om er ook de irreflexiviteit mee te handhaven.
RULE "subExprOf is asymmetric" MAINTAINS subExprOf /\ subExprOf~ |- I
PURPOSE RULE "subExprOf is asymmetric" IN ENGLISH
{+It shall be ensured that the decomposition of expressions does not result in cyclic chains.-}

RULE "subExprOf is irreflexive" MAINTAINS subExprOf |- -I
EXPLANATION "Expressions shall not be considered as subexpressions of themselves."
PURPOSE RULE "subExprOf is irreflexive" IN ENGLISH
{+In order to be very clear about the meaning of the term 'subexpression', we explicitly state that there are no expressions that are subexpressions of themselves.-}
--! zie voorgaande regel - parser kan nog geen (expr) /\ (expr) aan...

primitive :: Expression * Expression [SYM,ASY] PRAGMA "" " is a primitive, meaning that " " has no subexpressions".
PURPOSE RELATION primitive IN ENGLISH
{+Some expressions cannot be decomposed into smaller parts, i.e. they have no subexpressions. Such 'atomic' expressions are called 'primitives', i.e. have the 'primitive' property.-}

RULE primitives MAINTAINS primitive = I /\ -(subExprOf~;subExprOf)
EXPLANATION "Expressions that have no subexpressions are (called) primitives."
PURPOSE RULE primitives IN ENGLISH
{+Primitive expressions are distinct from non-primitives in the sense that they directly relate to data that may be operated upon (CRUD), whereas nonprimitive expressions need to be computed from primitives and subexpressions.-}

ENDPATTERN