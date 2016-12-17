PURPOSE: The original purpose of this Ampersand application (Nov 2014) was 
     to get an idea whether or not, (and if so, how,) the DEMO method of 
     Jan Dietz and the Ampersand method overlap or complement one another. 
     In order to do this, we have created an Ampersand application based on 
     the EU-Rent example given in "DEMO-3 Way of Working.pdf" (this is in 
     the directory "DEMO (Jan Dietz)", which also contains some notational 
     stuff and a link to the DEMO website.)
     In Dec 2016, the application has been modified to better suit the needs
     for showing off what we can do with Ampersand. For example, the 
     application has been extended with features that allow users to 
     register or login.
     Also, it has been adapted to accommodate for the many changes in the
     Ampersand compiler and prototype generator have seen. 

APPLICATION STATUS: The Ampersand application is found in "EURent.adl" and
     in the files that this file INCLUDEs. The application is known to have 
     compiled with "Ampersand-v3.7.3 [development:ba1988e]".

MODULES: this application requires the module "SIAM" (which stands for
     Sessions, Identity and Access Management).

KNOWN WORK THAT MAY NEED TO BE DONE:
     - documentation is not complete (not all concepts, relations etc.
       have been documented. Also, several PATTERNs/PROCESSes have been
       removed as the ordering of stuff has been reshoveled
       and currently there is no clear idea as to what constitutes
       a PATTERN or PROCESS).
     - "Ampersand-v3.7.3 [development:ba1988e]" contains some bugs, 
       and lacks some features that make the prototype look a bit odd
       here and there. Currently known issues can be found on 
       https://github.com/AmpersandTarski/Ampersand/issues/, and include
       - #578 (Implement meta model for navigation menu)
         The navigation bar menu (bar on the top of a page) is populated
         with various links that should not be there. The links that are
         useful are:
         - Customer Car Rentals - this is the 'home page' for customers
           that want to create a rental or access a past rental from 
           their own computer.
         - EU-Rent Branch Office - this is the 'home page' for employees
           that work in an EURent branch office. They can create, update
           rentals, service customers as they come to pick-up or drop-off
           a rental car, etc.
         A preview of what the navbar should look like can be found in
         the navbar menu item 'navbar' (which may be 'hidden' under the 
         hamburger-icon that is adjacent to the home-icon)
       - #579 (MYSQL error 2006: MySQL server has gone away in query: COMMIT)
         This issue has been circumvented in the code by splitting up
         one rule into a lot of rules. There is no impact on the 
         actual functionality of the prototype.
       - #486 (DB performance: remove distinct statements in subqueries)
         and #508 (Duplicates shown in user interface.). 
         These (related) issues cause the prototype to display multiple
         instances of boxes or relation-content. The superfluous
         instances will disappear when these issues are resolved.

PREPARING FOR COMPILATION AND COMPILING THE PROTOTYPE: 
     It is assumed that you have a project directory, i.e. a directory in
     which you can store projects (such as EURent) and modules (such as SIAM)
     1) Copy the entire EURent directory to your project directory, 
        including its subdirectories. Thus, you now have a directory
        'EURent' within your project directory.
        Note: you may discard the subdirectories 'DEMO (Jan Dietz)' and
         'DEMO (website, fspec) - original', which are there just for
        documentary/historical reasons.
     2) Copy the entire SIAM module to your project directory, including
        its subdirectories. You can find the SIAM module in the repository
        'ampersand-models'. Thus, you now also have a directory 'SIAM'
        in your project directory.
     3) Make sure you get ampersand.exe, and have the capability for 
        running prototypes, as described in the ampersand documentation
        [reference needed]
     4) Make a command shell (DOS box), and set the current directory
        to your project directory. You can create your prototype in the
        directory `C:\xampp\htdocs\EURent` by executing the command:
           ampersand.exe EURent.adl -p"C:\xampp\htdocs\EURent 

RUNNING THE PROTOTYPE
--[Startup/Installing the database]--
  1) Point your broswer to http://localhost/EURent/#/admin/installer 
     (assuming that C:\xampp\htdocs is the root of the webserver you use)
     Click on the red button 'Reinstall database'
     After a few seconds, the button will turn green.
     Now you have installed the EURent application.
     You can do this step at any time you want to start afresh.
  
--[Customers]--
The menu item 'Customer Car Rentals' shows the home page that EURent
customers see when they access the application from their own devices.
A customer can (click the appropriate button to):
  - login using a pre-registered username and password.
    For demo/development purposes, there is a button 'Show accounts to
    login with'. Pressing it shows the available customer accounts,
    that can be selected for a login. Obviously, in a 'real' application,
    this button would not be available.
  - register a userid and password if he has none.     
  - create a new rental.

--[EURent employees]--
The menu item 'EU-Rent Branch Office' shows the homoe page that EURent
employees see when they access the application from a computer in a
branch office. An employee can (click the appropriate button to):
  - login using his userid and password (just providing them suffices).
  - Click the button 'Show accounts to login with'. 
    Pressing it shows the available employee accounts, that can be 
    selected for a login. Obviously, in a 'real' application,
    this button would not be available.

From there on, it should be more or less self-evident what can(not) be done.