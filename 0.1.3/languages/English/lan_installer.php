<?php
/*
+ ------------------------------------------------------------------------------+
|	Русский языковой пакет для e107 0.7.26										|
|	Сайт: http://www.e107club.ru												|
|	Почта: translate@e107club.ru												|
|	Ревизия: 1.1																|
|	Кодировка: utf-8															|
|	Дата: 18.10.2012 05:05:00													|
|	Автор: © Кадников Александр	[Predator]										|
|	© е107 Клуб 2010-2011. Все права защищены.									|
+ ------------------------------------------------------------------------------+
|	Russian Language Pack for e107 0.7.26										|
|	Site: http://www.e107club.ru												|
|	Email: translate@e107club.ru												|
|	Revision: 1.1																|
|	Charset: utf-8																|
|	Date: 18.10.2012 05:05:00													|
|	Author: © Alexander Kadnikov [Predator]										|
|	© е107 Club 2010-2012. All Rights Reserved.									|
+-------------------------------------------------------------------------------+
*/

define("LANINS_001", "The setup program: Content Management Systems е107");
define("LANINS_002", "Step");
define("LANINS_003", "1");
define("LANINS_004", "Language Selection");
define("LANINS_005", "Please choose language to use during installation procedure");
define("LANINS_006", "Сontinue");
define("LANINS_007", "4");
define("LANINS_008", "PHP &amp; MySQL Versions Check / File Permissions Check");
define("LANINS_009", "Retest File Permissions");
define("LANINS_010", "File not writable: ");
define("LANINS_010a", "Folder not writable: ");
define("LANINS_011", "Error");
define("LANINS_012", "MySQL Functions don't seem to exist. This probably means that either the MySQL PHP Extension isn't installed or your PHP installation wasn't compiled with MySQL support.");
define("LANINS_013", "Couldn't determine your MySQL version number. This is a non fatal error, so please continue installing, but be aware that e107 requires MySQL >= 5.0 to function correctly.");
define("LANINS_014", "File Permissions");
define("LANINS_015", "PHP Version");
define("LANINS_016", "MySQL");
define("LANINS_017", "<b>Check passed</b>");
define("LANINS_018", "Ensure all the listed files exist and are writable by the server. This normally involves CHMODing them 777, but environments vary - contact your host if you have any problems.");
define("LANINS_019", "The version of PHP installed on your server isn't capable of running e107. e107 requires a PHP version of at least 5.0 to run correctly. Either upgrade your PHP version, or contact your host for an upgrade.");
define("LANINS_020", "Continue Installation");
define("LANINS_021", "2");
define("LANINS_022", "MySQL Server Details");
define("LANINS_023", "Please enter your MySQL settings here.

If you have root permissions you can create a new database by ticking the box, if not you must create a database or use a pre-existing one.

If you have only one database use a prefix so that other scripts can share the same database.
If you do not know your MySQL details contact your web host.");
define("LANINS_024", "MySQL Server:");
define("LANINS_025", "MySQL Username:");
define("LANINS_026", "MySQL Password:");
define("LANINS_027", "MySQL Database:");
define("LANINS_028", "Create Database?");
define("LANINS_029", "Table prefix:");
define("LANINS_030", "The MySQL server you would like e107 to use. It can also include a port number. e.g. «hostname:port» or a path to a local socket e.g. «:/path/to/socket» for the localhost.");
define("LANINS_031", "The username you wish e107 to use for connecting to your MySQL server");
define("LANINS_032", "The Password for the user you just entered");
define("LANINS_033", "The MySQL database you wish e107 to reside in, sometimes referred to as a schema. If the user has database create permissions you can opt to create the database automatically if it doesn't already exist.");
define("LANINS_034", "The prefix you wish e107 to use when creating the e107 tables. Useful for multiple installs of e107 in one database schema.");
define("LANINS_035", "Continue");
define("LANINS_036", "3");
define("LANINS_037", "MySQL Connection Verification");
define("LANINS_038", " and Database Creation");
define("LANINS_039", "Please make sure you fill in all fields, most importantly, MySQL Server, MySQL Username and MySQL Database (These are always required by the MySQL Server)");
define("LANINS_040", "Errors");
define("LANINS_041", "e107 was unable to establish a connection to the MySQL server using the information you entered. Please return to the last page and ensure the information is correct.");
define("LANINS_042", "Connection to the MySQL server established and verified.");
define("LANINS_043", "Unable to create database, please ensure you have the correct permissions to create databases on your server.");
define("LANINS_044", "Successfully created database.");
define("LANINS_045", "Please click on the button to proceed to next stage.");
define("LANINS_046", "5");
define("LANINS_047", "Administrator Details");
define("LANINS_048", "Go Back To Last Step");
define("LANINS_049", "The two passwords you entered are not the same. Please go back and try again.");
define("LANINS_050", "XML Extension");
define("LANINS_051", "Installed");
define("LANINS_052", "Not Installed");
define("LANINS_053", "e107 0.7.2x++ requires the PHP XML Extension to be installed. Please contact your host or read the information at <a href='http://php.net/manual/en/ref.xml.php' target='_blank'>php.net</a> before continuing");
//not used: define("LANINS_054", " before continuing");
define("LANINS_055", "Install Confirmation");
define("LANINS_056", "6");
define("LANINS_057", " e107 now has all the information it needs to complete the installation.
Please click the button to create the database tables and save all your settings.");
define("LANINS_058", "7");
define("LANINS_060", "Unable to read the sql datafile
Please ensure the file <b>core_sql.php</b> exists in the <b>/admin/sql</b> directory.");
define("LANINS_061", "e107 was unable to create all of the required database tables.
Please clear the database and rectify any problems before trying again.");
define("LANINS_062", "[b]Welcome to your new website![/b]<br />e107 cms installation completed successfully and the system is now ready to accept content.<br />Your Adminpanel [link={e_ADMIN_ABS}admin.php]local here[/link], click to go there now. You must log in using the username and password that you specified during installation.<br /><br />
[b]Support:[/b] [link=http://www.e107club.ru]e107 Club[/link] - Official portal of user support of Russian community е107 cms.<br />
[b]Developers e107:[/b] [link=http://e107.org]e107 Inc.[/link] - Official website developers.<br />
[b]Plugins:[/b] [link=http://e107.org/plugins]Plugins[/link] - Plugins for е107 cms.<br /><br />
Thanks you for using the system e107 cms, we hope that our system will satisfy all your needs in the development of the site.<br /><b>Attention!</b> (you can delete this message, having entered into Adminpanel.)");
define("LANINS_063", "Welcome to Content management system e107");
define("LANINS_069", "<b>Setup program e107 has successfully completed the operation!</b><br/><br/> Content management system е107 - is successfully installed!<br/> for safety reasons you should install immediately access rights to a file <b>config.php</b> in CHMOD = 555. Also, please, delete a file <b>install.php</b> from your server, after pushing the button more low.");
define("LANINS_070", "e107 was unable to save the main config file to your server. Please ensure the <b>config.php</b> file has the correct permissions");
define("LANINS_071", "Finalising Installation");
define("LANINS_072", "Admin Username");
define("LANINS_073", "This is the name you will use to login into the site. If you wish to use this as your display name also");
define("LANINS_074", "Admin Display Name");
define("LANINS_075", "This is the name that you wish your users to see displayed in your profile, forums and other areas. If you wish to use the same as your username then leave this blank.");
define("LANINS_076", "Admin Password");
define("LANINS_077", "Please type the admin password you wish to use here");
define("LANINS_078", "Admin Password Confirmation");
define("LANINS_079", "Please type the admin password again for confirmation");
define("LANINS_080", "Admin Email");
define("LANINS_081", "Enter your email address");
define("LANINS_082", "user@e107club.ru");
define("LANINS_083", "MySQL Reported Error:");
define("LANINS_084", "The installer could not establish a connection to the database");
define("LANINS_085", "The installer could not select database:");
define("LANINS_086", "Admin Username, Admin Password and Admin Email are <b>required</b> fields. Please return to the last page and ensure the information is correctly entered.");
define("LANINS_087", "Misc");
define("LANINS_088", "Home");
define("LANINS_089", "Downloads");
define("LANINS_090", "Members");
define("LANINS_091", "Submit News");
define("LANINS_092", "Contact Us");
define("LANINS_093", "Grants access to private menu items");
define("LANINS_094", "Example private forum class");
define("LANINS_095", "Integrity Check");
define("LANINS_096", 'Latest Comments');
define("LANINS_097", '[more ...]');
//define("LANINS_098", 'Articles');
//define("LANINS_099", 'Articles Front Page ...');
define("LANINS_100", 'Latest Forum Posts');
define("LANINS_101", 'Update menu Settings');
define("LANINS_102", 'Date / Time');
//define("LANINS_103", 'Reviews');
//define("LANINS_104", 'Review Front Page ...');
define("LANINS_105", "A database name or prefix beginning with some digits followed by 'e' or 'E' is not acceptable.  <br />A database name or prefix can not be empty.");
define("LANINS_106", 'WARNING - E107 cannot write to the directories and/or files listed. While this will not stop E107 installing, it will mean that certain features are not available. You will need to change the file permissions to use these features');
define('LANINS_DB_UTF8_CAPTION', 'MySQL Charset:');
define('LANINS_DB_UTF8_LABEL',   'Force UTF-8 Database?');
define('LANINS_DB_UTF8_TOOLTIP', 'If set, the installation script will make the database UTF-8 compatible if possible. UTF-8 Database are required for the next major e107 version.');
define("LANINS_201", "Build of the present version of system and russian localization are prepared by a portal command е107 Club.<br />Author of translation and localization: Alexander Kadnikov [Predator]<br />© <a href='http://www.e107club.ru'>e107 Club</a>, 2010-");
define("LANINS_RES", ". All Rights Reserved.");
define("LANINS_VER", "0.7.26 Full Build 6.1 No prefix");

?>