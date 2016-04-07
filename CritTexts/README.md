CritTexts README

This text describes how you can exercise the CritTexts.adl pattern.

There are two interfaces, with equivalent functionality:

- "Criteria and Variables" allows you to see the functionality as a regular user would.
  What you do here is create criteria, and enter texts for them.
  You can specify a variable in a criterion by mentioning its name between square brackets.
  An example is: 'The salesprice of the car is [salesprice].'
  You can mention any number of variables in a criterion.
  Whenever you mention one or more variables, they are automatically created.
  You can supply values to variables (bottom of screen)
  Whenever you do so, the showtext will fill in such values in the criterion-text.
  Play with it, e.g.:
  - enter, change or delete criteria, or
  - enter, change or delete the value of variables,
  and see what happens
- "Debug Information"
  This has the same functionality as the previous interface.
  The difference is that here, you will see 
  the contents of the Ampersand-relations (i.e. the internal working)