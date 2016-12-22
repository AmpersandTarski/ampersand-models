PATTERN "Expressions"
-- Author(s) rieks.joosten@tno.nl
--!RJ: This pattern is ready for review/publication

subExprOf :: Expression * Expression [ASY,IRF] PRAGMA "" " is an expression contained within ".
PURPOSE RELATION subExprOf IN ENGLISH
{+In order to be able to evaluate expressions, it is necessary to be able to decompose complex expressions into more basic parts. Considering that expressions are logical combinations of (other) expressions, any expression 'e' that is combined with at least one operator (and optionally other expressions) such that the result is a valid expression, is called a subexpression of the latter expression. The latter expression is called a parent (expression) of 'e', and 'e' is called a subexpression or child expression of any of its parents. Expressions cannot be subexpressions of themselves and shall not result in cyclic chains.+}

primitive :: Expression * Expression [PROP] PRAGMA "" " is a primitive, meaning that " " has no subexpressions".
PURPOSE RELATION primitive IN ENGLISH
{+Some expressions cannot be decomposed into smaller parts, i.e. they have no subexpressions. Such 'atomic' expressions are called 'primitives', i.e. have the 'primitive' property.+}

RULE primitives: primitive = I /\ -(subExprOf~;subExprOf)
MEANING "Expressions that have no subexpressions are (called) primitives."
PURPOSE RULE primitives IN ENGLISH
{+Primitive expressions are distinct from non-primitives in the sense that they directly relate to data that may be operated upon (CRUD), whereas nonprimitive expressions need to be computed from primitives and subexpressions.+}

ENDPATTERN