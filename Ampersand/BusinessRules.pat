PATTERN BusinessRules -- WIJZIGER: rieks.joosten@tno.nl
--!PATTERN Rules USES Holons
PURPOSE PATTERN BusinessRules IN ENGLISH
{+Business Rules are meant for communication with stakeholders in the business [ROSS2003]_, i.e. for communication with humans. This pattern specifies the structure of both unformal rules as are used in the business, and formalized business rules, i.e. business rules that are logical expressions of primitives that can be evaluated automatically (provided each primitive can be assigned a value). 

Within this pattern, it is required that there is an equivalence between 'ordinary' Business Rules as expressed in a natural language, and Formalized Business Rules as expressed in a formal language such as relation algebra.
-}
-- Markup uses `reStructuredTexts <http://docutils.sourceforge.net/docs/user/rst/quickref.html>`_
-----------------------------------------------------------------------
{- Revision history
RJ/20110220 - "Techneutenweekend-changes", including inclusion of revision history. The English comments are complete.
-}
-----------------------------------------------------------------------
-- Markup uses `reStructuredTexts <http://docutils.sourceforge.net/docs/user/rst/quickref.html>`__

CONCEPT BusinessRule "a statement that can either be complied with, or not"
PURPOSE CONCEPT BusinessRule IN ENGLISH 
{+BusinessRules exist within a Holon to distinguish compliant (wanted) situations from non-compliant (unwanted) situations and consequently have a single meaning (intension). Every rule is represented by a single natural language statement that we assume adequately expresses the intension (meaning) of the rule within its Holon. While statements may be formulated ambiguously, the rule itself is considered to have a single meaning (intension), which the holon manager is considedered to have decided (implicitly or explicitly). Therefore, it may or may not be possible for third parties to assess the meaning of a rule, or to evaluate a rule (i.e. determine wether or not it is complied with). It may or may not be possible to convey the meaning of a rule outside the scope.-}

ruleScope :: BusinessRule -> Holon PRAGMA "" " must be interpreted/evaluated within the scope of ".
PURPOSE RELATION ruleScope IN ENGLISH
{+Every rule has a distinct meaning and purpose. This meaning (purpose, intension) is assigned within a specific holon (and the holon manager is accountable for this meaning). The consequence of this should be that the rule should only be evaluated using data that is meaningful within this holon.-}
PURPOSE RELATION ruleScope IN DUTCH
{+Elke regel heeft een specifiek doel en betekenis. Deze betekenis c.q. dit doel is toegekend binnen een zekere Holon. Dit houdt in dat evaluatie van deze regel alleen plaats mag vinden met gegevens die binnen dezelfde holon betekenisvol zijn.-}

ruleText :: BusinessRule -> Text PRAGMA "" " is expressed in natural language as ".
PURPOSE RELATION ruleText IN ENGLISH 
{+BusinessRules can be  expressed in a natural language in an attempt to convey their meaning to stakeholders that may discuss them. The manager of the holon for which this statement represents a rule is the ultimate authority with respect to the meaning of the rule. Inother words: if you want to know the meaning (implications) of a rule, ask the holon manager.-}

RULE "ruleKey": I[BusinessRule] = ruleText;ruleText~ /\ ruleScope;ruleScope~
PURPOSE RULE "ruleKey" IN ENGLISH
{+Every rule is uniquely characterized by its holon and its natural language expression.-}
PURPOSE RULE "ruleKey" IN DUTCH
{+Elke regel is uniek gekarakterisserd door diens holon en diens natuurlijke taal uitdrukking (tekst).-}

ENDPATTERN
-----------------------------------------------------------------------
PATTERN "Formalized BusinessRules" -- WIJZIGER: rieks.joosten@tno.nl
--!PATTERN "Formalized BusinessRules" USES BusinessRules, Expressions

CONCEPT Rule "a rule associated with a formal expression that upon evaluation results in either 'TRUE' or 'FALSE'"
PURPOSE CONCEPT Rule IN ENGLISH 
{+Rules are specializations of BusinessRules that relate to a (single) formal expression, using e.g. relation algebra or predicate logic. This formal expression defines the rule's intension (meaning). Rules allow meaning to be conveyed to third parties that are proficient with the formalism. Hence, such parties may  assess the meaning of Rules and evaluate them. Consequently, the meaning of the rule may be conveyed to outside the scope.-}

GEN Rule ISA BusinessRule

formalExpr :: Rule -> Expression PRAGMA "The formal expression of " " is given by ".
PURPOSE RELATION formalExpr IN ENGLISH 
{+BusinessRules can be expressed in a formal langauge such as relation algebra allowing them to be used in automated contexts.-}

RULE "formal rule uniqueness": formalExpr; formalExpr~ |- I \/ ruleScope; -I; ruleScope~
PURPOSE RULE "formal rule uniqueness" IN ENGLISH
{+Since the meaning of Rules is formally defined by its (formal) expression, it is important that this meaning is represented to humans (the business) with a single natural language statement. If this were not the case, then this would allow ambiguities in rules, as different rules (having different natural language representations and being assigned to a single holon) could have a single formal representation.-}

ENDPATTERN
-----------------------------------------------------------------------
PATTERN "Expressions" -- WIJZIGER: rieks.joosten@tno.nl

subExprOf :: Expression * Expression [ASY,IRF] PRAGMA "" " is an expression contained within ".
PURPOSE RELATION subExprOf IN ENGLISH
{+In order to be able to evaluate expressions, it is necessary to be able to decompose complex expressions into more basic parts. Considering that expressions are logical combinations of (other) expressions, any expression 'e' that is combined with at least one operator (and optionally other expressions) such that the result is a valid expression, is called a subexpression of the latter expression. The latter expression is called a parent (expression) of 'e', and 'e' is called a subexpression or child expression of any of its parents. Expressions cannot be subexpressions of themselves and shall not result in cyclic chains.-}

primitive :: Expression * Expression [SYM,ASY] PRAGMA "" " is a primitive, meaning that " " has no subexpressions".
PURPOSE RELATION primitive IN ENGLISH
{+Some expressions cannot be decomposed into smaller parts, i.e. they have no subexpressions. Such 'atomic' expressions are called 'primitives', i.e. have the 'primitive' property.-}

RULE primitives: primitive = I /\ -(subExprOf~;subExprOf)
PHRASE "Expressions that have no subexpressions are (called) primitives."
PURPOSE RULE primitives IN ENGLISH
{+Primitive expressions are distinct from non-primitives in the sense that they directly relate to data that may be operated upon (CRUD), whereas nonprimitive expressions need to be computed from primitives and subexpressions.-}

ENDPATTERN