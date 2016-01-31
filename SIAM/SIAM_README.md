SIAM_README.md
==============

The purpose of this module is to enable Ampersand engineers to quickly integrate their application with stuff for handling Sessions, Identities, and Access Management (SIAM). In particular this includes:
- a simple registration for Persons in terms of first- and last names.
- a simple registration for Organizations in terms of short and full names.
- the ability to use Persona, i.e. a Person and Organization that have a particular relation.
- a simple Login facility (username, password)
- an assisted login facility (i.e. you can either do the simple login, or choose the account to use for login - this is particularly suited for developers)
- a facility for logging login times (this awaits resolution of issue #285 (https://github.com/AmpersandTarski/ampersand/issues/285)

The concepts and relations are defined such that it allows for expansion. In particular, `IDENT` statements are not used (except for Persona). Also, the concept `User` is not defined. The reason for this is that consensus about its meaning is notoriously lacking. Not defining this concept allows application developers to use their own ideas for this. Note, however, that there is a concept `UserID`, and there are relations `accUserid` and `sessionUserid` that use it.