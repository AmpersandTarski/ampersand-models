# This is the CHANGELOG file for SIAMv4

The authoratative source for this module is on **git@ci.tno.nl:ampersand/ssif.git**.

Last update: RJ/20200720

## New Features and changes in SIAM v 4.0 (conceptual changes have been made)

Many things have changed in this version of SIAM, most notably:
- **Accounts are now related to Parties and Actors** - see file "SIAM_Basics.adl" for details.
- Parties are entities that have and maintain knowledge. They include Organizations and Persons.
- Actors are entities that can do things. This includes Persons. 
- the 'User' refers to the (Actor,Party) pair associated with the Account, and the `Userid` identifies the Account and that pair
- the system itself is also an Actor, and it is owned by some Party, which is modeled by the (new) notion of 'I_Am'.
- The concept `UserID` has been renamed into `Userid`, which results in less errors. Note that `Userid` now explicitly identifies the Account itself (or if you will, the (Actor,Party) pair that the Account is associated with).
- Code has been refactored such that whenever users want to register/change something, they do that using apprpriate forms
  (e.g. an AccountRegForm, or a LoginForm).
- Consequently, many filenames have changed.
- The term 'devil role' has been replaced with 'system role'. Consequently, the relation `devilRole` has been renamed into `systemRole`.
- God-accounts no longer assign all (non-system) roles to the Account, but add them to the sessionAllowedRoles in sessions where the user has logged in with a god-account.
- Checks for SIAM versioning have been removed (as they weren't used in practice)

### Candidate features for future implementation
- support for non-human Actors (using e.g. APIKeys).
- generic authenticators.
- (reinstate) DID-pair support.
- registration of Accounts for third Party Actors.

## Upgrading to SIAM v 3.0 (from any previous version)

If you do not yet use a SIAM Module Loader file in your project, you should start using one, as follows:

1. Copy the provided SIAM_Module-example.adl to your project directory, and rename it to SIAM_Module.adl
2. The file contains INCLUDE statements starting with `INCLUDE "../SIAM/`,
   which specifies the path from where files are to be INCLUDEd.
   You should make sure the specified path is correct (edit it if needed).
3. (Un)comment INCLUDE statements as you like - the comments on the lines indicate what the loaded files are used for.
4. In the section `--[VIEWS]--`, make changes as you like (*).
5. In the section `--[[Examples of possibly useful RULEs]]--`, make changes as you like (*).
(*) When making changes, think about how you will retain such changes when upgrading to new versions of SIAM.
    Also, make sure you retain the rule that initializes Accounts (while you may change what it does, of course).

If you use a SIAM Module Loader file, that is adapted from the SIAM_Module-example.adl file of the previous version, you should:

1. Do whatever you thought of is necessary to save any changes you made (steps 3, 4, 5 above).
2. Walk through steps 1-5 again, doing whatever is necessary to restore your saved changes.

## Changes in SIAM v 3.0

- WARNING: The contents of files has been rearranged. This means that when upgrading,
  so you should review the INCLUDE statements that you have to (un)comment (again).

The most important new features/concepts/relations:

- A new concept UID (User ID object) has been introduced.
  - This concept allows identification of accounts by third Party identifiers.
  - This concept is needed to facilitate user logins/authentication by third Parties (e.g. Google)
  - The loginWithAssistance*.ifc files allow for using third Party logins 'by hand' (for debugging purposes).
  - An extension is available that automatically creates accounts when a user has an authenticated UID but no associated account.

- The purpose of Person- and Party registration has been made explicit
  (i.e. to provide a set of relations for the purpose of being re-used in different projects)
  - Consequently, the TOT-property has been removed from relations.
  - PersonRegExtensions have been added as a separate file,
    currently containing the relations `personMiddleName` and `personInitials`.
    In future, other common person-attributes can be added here.

- Support for 'PersonRef's, i.e. textstrings that refer to a person.
  Some use-cases require Accounts to refer to Person-objects (as in `accPerson`), whereas
  other use-cases require Accounts to just refer to a Person (his name).
  This module implements
  - minimal support for person refs, by `accPersonRef[Account*PersonRef]` (in SIAM_PersonRefs.adl)
  - minimal support for person objects, by the `Person` object (in SIAM_PersonReg.adl)
  - some common extension relations for `Person` attributes (in SIAM_PersonRegExts.adl)
  If the `Person` object support is there, the PersonRef will be created automatically
  (as the concatenation of the first and last names of the person)

- Support for 'PartyRef's, i.e. textstrings that refer to an organization.
  The 'PersonRef' stuff has been similarly applied to Parties.
  This is a bit more simple, because Parties do not have first- and last names.
  The functionality, however, is the same as with Persons.

- Support for account (de)activation, by means of `accIsActive[Account*Account] [PROP]`
  By default, accounts are not active. Applications should specify a rule for this.
  This can conveniently be done in the rule that initializes accounts.

- Support for account initialization, by means of `accIsInitialized[Account*Account] [PROP]`
  Initially, accounts do not have this property populated, thus allowing rules to distinguish
  between initialized and uninitialized accounts. Applications are free to specify their own
  initialization rules, allowing them to provide accounts e.g. with a default role 'User',
  and to activate accounts immediately after their creation.

- Support for account creation, by means of `arfCreateAccountReq` (for account admins)
  and `arfAutoLoginReq` (to enable anonymous users to create an account and login immediately)
  which are `[PROP]`erties that can conveniently be used in INTERFACEs
  Various examples of such interfaces are provided (see the loader file)

- INTERFACEs (to be used as templates in your own application) for login, logout, and
  user registration (that use PROPBUTTONs and other state-of-the-ampersand-art views)

- support that enables you to specify the default INTERFACEs for anonymous sessions
  (that would typically be a 'login'-interface) and user sessions (that would typically
  be the interface where you want the user to go after a succesful login).
  This support is by means of the relations `sessionAnonIfc`, `sessionUserIfc` and `accUserIfc`.

- Support for 'devil roles', i.e. roles that cannot be assigned to accounts.
  In particular, they won't be assigned to God accounts.
  The roles 'SYSTEM', 'ExecEngine' and 'Anonymous' are set as devil roles by default.

- Support for 'anonymous sessions', i.e. sessions in which a user has not yet logged in
  - the role "Anonymous" is activated in sessions in which no user is logged in.
  - the role "Anonymous" is deactivated whenever a user is logged in.
  - accounts may not have "Anonymous" as an allowed role.
  - the role "Anonymous" can be used to create INTERFACEs specifically for anonymous sessions.
  - The `[PROP]`-relations `sessionIsAnon` and `sessionIsUser` are shorthands that allow simple testing for such sessions.

Changes:

- LoAs now have representation type INTEGER (rather than being objects).
- All occurrences of `ISOLevel` have been replaced with `LoA` (Level of Authenticity, as used in standards). This holds both for the concept of that name as for occurrences found in relation names.
- `isoLevelGTE` has been renamed into `loaGTE`
- `autoLoginAccount` has been renamed into `accAutoLoginReq`

## Release notes for SIAM v 2.0

This is the readme file for SIAM v 2.0
When upgrading from a previous version (i.e. the unversioned situation, which is considered to be SIAM v 1.0), you should:

- check the files that you imported from your own SIAM_Module import file, as v 2.0 has separated features that used to be embedded in other files, so that you may choose to include them or leave them out. See the SIAM_Module-example.adl files for details.
- ensure that you start use 'versioning' (i.e. include the versioning line of the SIAM_Module-example.adl file in your own loader file)

The purpose of this module is to enable Ampersand engineers to quickly integrate their application with stuff for handling Sessions, Identities, and Access Management (SIAM).
In particular this includes:

- a simple registration for Persons in terms of first- and last names.
- a simple registration for Parties in terms of short and full names.
- an extension that defines Persona, i.e. a Person and Party that have a particular relation.
- an extension that enables one account to be logged in automatically.
- an extension that allows sessions to be suspended.
- an extension that defines ISO authentication levels and comparisons between them.
- an extension that logs login times (this awaits resolution of issue [#285](https://github.com/AmpersandTarski/ampersand/issues/285))
- a simple Login facility (username, password)
- an assisted login facility (i.e. you can either do the simple login, or choose the account to use for login - this is particularly suited for developers)

The concepts and relations are defined such that it allows for expansion.
In particular, `IDENT` statements are not used (except for Persona).
Also, the concept `User` is not defined. The reason for this is that consensus about its meaning is notoriously lacking. Not defining this concept allows application developers to use their own ideas for this. Note, however, that there is a concept `Userid`, and there are relations `accUserid` and `sessionUserid` that use it.