README for Searching applications.

File `SearchRegisterForRecord.adl` is an application that implements a registration of people, as well as an interface that allows to search for people in that registration given text that you type in a search form. It is a demonstration of how residues can help you if you want to search records. 

File `SearchRegisterWithSpecializations.adl` is a functionally similar application; however, it has defined a specialization: `CLASSIFY Man ISA NaturalPerson`, and a relation that is typical for men: `manAttribute :: Man * ManAttribute`. This application shows two different ways of searching:

- Example 1 shows how to implicitly select Men when you are searching.
- Example 2 shows how to select both Men and non-Men when you are searching.