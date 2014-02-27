README file for Ampersand app HRM

Revision history:
RJ/20140227: created the first version.

APPLICATION CONTENT:
This is a very simple implementation of a set of rules that allows Human Resource Management (HRM) to keep track of company equipment that it issues to employees. Employees fulfill organizational functions that make them eligable for certain kinds of equipment. The process specifies that employees may only have instances of equipment that fit their organizational role.

APPLICATION IMPLEMENTATION SPECIFICS:
The application makes use of ExecEngine rules to compute the staus of employees (see "HRM Status.adl"). Rudimentary box coloring is a relatively recent addition that you can find in 'index.php'.

GETTING IT TO WORK:
execute 'prototype.exe HRM.adl'
It has been seen to work on prototype v3.0.1.2897

FURTHER PURPOSES: 
[1] this application has some neat rules that include the dagger '!' operator. See the rules "Unique equipment responsibility" in the Ontology file, and the rules in the Status file that compute status properties.
[2] this application may lend itself nicely for having students tinker with it. For example, an exercise could be to add suff so that the manager of an employee may grant an employee to be issued equipment that is not available to him because of his function.

Have fun!
