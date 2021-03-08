# TText

The TText module implements basic support for informal reasoning,
thus allowing for the creation of arguments, that are constructed 
using the basic building block we call a `TText` (Tile-Text or Toulmin-Texst).

## Basics

The essence of a TText is that it allows a human or non-human Actor to evaluate an arbitrary statement
that may contain 'variables' (i.e. placeholders for the evaluation result of other TTexts),
and thereby producing the evaluation result of that statement.

To this end, a TText has:
- a 'template', which is the statement to be evaluated with placeholders for the variables.
- an 'instance', which is the template text with the values of the variables filled in insofar these are available.
- a reference to the 'scope' within which variable substitution and instance evaluations take place.
- a 'name', that identifies the TText within its scope.
- a 'value', i.e. the result of the (human or automated) evaluation of the instance.

Example:
Suppose all below TTexts belong to the same scope "Puck vs Doe":
Suppose we already have the following TTexts:
- TText 'Defendant' has template "Person being sued by [Plaintiff]", and value "Pete Puck",
- TText 'Plaintiff' has template "Person suing [Defendant]", and value "John Doe",
Suppose we add a TText to this scope which we call 'Claim', with template "[Defendant] must pay [amount] to [Plaintiff]"
and we want an evaluation of this to result in that the claim is either 'upheld' or 'dismissed' 
so that further reasoning with the value of 'Claim' becomes possible.
Since 'Plaintiff' and 'Defendant' already have evaluation results, the instance automatically becomes
"Pete Puck must pay [amount] to John Doe".
Suppose we then add a TText called 'amount' to this scope with value '10k Euro'.
Then the instance is automatically recomputed and becomes "Pete Puck must pay 10k Euro to John Doe".
This would allow the evaluator of the Claim to determine the value of 'Claim'. 

Notes:
- the evaluation of a TText may not require that all variables (already) have values. In the above case, 
  that would have led to a deadlock in assinging values for 'Defendent' and 'Plaintiff'.
- the evaluation of a TText may require other data than the evaluation results of its variables.

## Copying

t.b.d.

