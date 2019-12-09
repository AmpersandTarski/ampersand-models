<?php
// default settings are listed at "C:\Ampersand\Git\ampersand\static\zwolle\src\defaultSettings.php"
use Ampersand\Log\Logger;
use Ampersand\Log\NotificationHandler;
use Ampersand\Config;

define ('LOCALSETTINGS_VERSION', 1.5);
date_default_timezone_set('Europe/Amsterdam');
set_time_limit (30); //Execution time limit is set to a default of 30 seconds. Use 0 to have no time limit. (not advised)

/**************************************************************************************************
 * LOGGING functionality
 *************************************************************************************************/
error_reporting(E_ALL & ~E_NOTICE);
ini_set("display_errors", true);
Config::set('debugMode', 'global', true); // default = false

// Log file handler
$fileHandler = new \Monolog\Handler\RotatingFileHandler(__DIR__ . '/log/error.log', 0, \Monolog\Logger::WARNING);
//$fileHandler->pushProcessor(new \Monolog\Processor\WebProcessor()); // Adds IP adres and url info to log records
Logger::registerGenericHandler($fileHandler);

if(Config::get('debugMode')){
    $fileHandler = new \Monolog\Handler\RotatingFileHandler(__DIR__ . '/log/debug.log', 0, \Monolog\Logger::DEBUG);
    Logger::registerGenericHandler($fileHandler);
    
    // Browsers debuggers
    //$browserHandler = new \Monolog\Handler\ChromePHPHandler(\Monolog\Logger::DEBUG); // Log handler for Google Chrome
    //$browserHandler = new \Monolog\Handler\FirePHPHandler(\Monolog\Logger::DEBUG); // Log handler for Firebug in Mozilla Firefox
    //Logger::registerGenericHandler($browserHandler);
}

$execEngineHandler = new \Monolog\Handler\RotatingFileHandler(__DIR__ . '/log/execengine.log', 0, \Monolog\Logger::INFO);
Logger::registerHandlerForChannel('EXECENGINE', $execEngineHandler);

// User log handler
Logger::registerHandlerForChannel('USERLOG', new NotificationHandler(\Monolog\Logger::INFO));

/**************************************************************************************************
 * SERVER settings
 *************************************************************************************************/
// Config::set('serverURL', 'global', 'http://localhost/' . Config::get('contextName')); // set the base url for the application
// Config::set('apiPath', 'global', '/api/v1'); // relative path to api (default is '/api/v1')

/**************************************************************************************************
 * DATABASE settings
 *************************************************************************************************/
// Config::set('dbHost', 'mysqlDatabase', 'localhost');
// Config::set('dbUser', 'mysqlDatabase', 'ampersand');
// Config::set('dbPassword', 'mysqlDatabase', 'ampersand');
// Config::set('dbName', 'mysqlDatabase', '');

/**************************************************************************************************
 * FRONTEND INTERFACE settings (default = false)
 *************************************************************************************************/
   Config::set('interfaceAutoCommitChanges', 'transactions', true); // (default=false) specifies whether changes in an interface are automatically commited when allowed (all invariants hold)
   Config::set('interfaceAutoSaveChanges', 'transactions', true); // (default=false) specifies whether changes in interface are directly communicated (saved) to server

/**************************************************************************************************
 * FRONTEND NOTIFICATION settings (default = true)
 *************************************************************************************************/
 Config::set('defaultShowSignals', 'notifications', true);
 Config::set('defaultShowInfos', 'notifications', true);
 Config::set('defaultShowWarnings', 'notifications', true);
 Config::set('defaultShowSuccesses', 'notifications', true);
 Config::set('defaultAutoHideSuccesses', 'notifications', true);
 Config::set('defaultShowErrors', 'notifications', true);
 Config::set('defaultShowInvariants', 'notifications', true);

/**************************************************************************************************
 * LOGIN FUNCTIONALITY
 * 
 * The login functionality requires the ampersand SIAM module
 * The module can be downloaded at: https://github.com/AmpersandTarski/ampersand-models/tree/master/SIAM
 * Copy and rename the SIAM_Module-example.adl into SIAM_Module.adl
 * Include this file into your project
 * Uncomment the config setting below
 *************************************************************************************************/
Config::set('loginEnabled', 'global', false);

/**************************************************************************************************
 * EXTENSIONS
 *************************************************************************************************/
require_once(__DIR__ . '/extensions/ExecEngine/ExecEngine.php'); // Enable ExecEngine
    Config::set('allowedRolesForRunFunction', 'execEngine', array('Administrator'));
    Config::set('autoRerun', 'execEngine', true);
    Config::set('maxRunCount', 'execEngine', 10);

require_once(__DIR__ . '/extensions/ExcelImport/ExcelImport.php'); // Enable ExcelImport
//    Config::set('allowedRolesForExcelImport', 'excelImport', array('Administrator', 'ExcelUploader', 'ExcelImporter'));

?>