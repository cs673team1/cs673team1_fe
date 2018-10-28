# Application Overview

#### Summary:  
This document contains information on the C3PO application.  3CPO is a generic project management and
communication application that supports multiple users via remote login to a central server.  The application handles 
both project requirements and reported bugs, provides scheduling assitance for the latter into sprints, and allows 
users to communicate in real time using a chat feature.  

#### Contents:
This document is divided into two major sections; User Guide and Development Guide.  The User Guide contains user 
information and instructions that orient a new user to the system capabilities and use.  The Development Guide
contains information for system deveopers who want to understand and modify the internals of the application.  

## User Guide

### User Accounts

Before a user can access the various 3CPO features s/he must log in.  Log in provides two important functions; a) it 
authenticates the user (ensures that they are allowd to access the system), and b) it informs the system of the user
identity.  This user identity is used to note 'who did what' in the history log, who is talking via chat, etc.  

### Chat Feature

TODO 
Chat works by ...

### Sprint Management Feature

TODO
Sprint management ...

### Requirements Management Feature

TODO
Requirements (aka user stories) are managed in a panel ...

### Bug Management Feature

TODO
Bugs are entered by ...


## Development Guide

This section outlines the technologies used to implement the application, and how to install them on a machine for
development.  
 
### Internals Overview

The application is built as a web based service invoked from a web page.  As a web page both HTML and JavaScript are
used at the very front end.  Web page updates are requested and posted using the AJAX (Asynchronous JavaScript And XML)
JavaScript facility.  This 'very front end' passes control to a set of PHP files that receives the requests, queries 
the back end database, and sends back a response which AJAX uses to update the page.

The database 'back end' is mySQL.  
TODO: more on the database ... ERD, etc.

For development the user needs:
- A browser
- JavaScript
- A PHP interpreter, 7.0 or greater
   - Note: PHP requires Apache and Visual C++ redistributable libraries
- mySQL

### Installing Tools On Windows

Windows installation of PHP followed the general instructions at:
https://docs.moodle.org/35/en/Manual_install_on_Windows_7_with_Apache_and_MySQL

Note: it is important to be consistent in the downloads.  There are various environments supported, Windows 64 and 32
bit, and 'Thread Safe' and 'not Thread Safe'.  The above link advised to use 'Thread Safe' and Win 32 environments (the 
Win 64 being more experimental).  Besides that, it is also important to use a tool chain that is consistent for the
Microsoft Visual Studio redistributable libraries.  Several of the (C++) applications are built using these but you 
do not need Visual Studio installed, rather you can simply install the 'redistributable library'.  

The tool chains selected below all use the VC15 libraries, and win32, Thread Safe, builds.

In addition to these tools, the team is using JetBrains PhpStorm IDE, and of course git and GitHub.  There are notes
below for configuring these tools also.  

#### PHP

Download the PHP interpreter from https://windows.php.net/download.  Note that this is only the first of several file 
downloads that need to be combined.  In total there are 3 for PHP, plus Apache.  To ease modification download the zip 
files to a working directory, say php_v7_downloads, and unzip them there, make modifications, and later copy all the 
files to the final 'deploy' location (C:/php, see below).

- Download and unzip the PHP interpreter, use version 7.2.11 (for VC15 compatibility).  The file is 
```VC15 x86 Thread Safe (2018-Oct-10 19:16:08)```.  

For debugging support two other sets of files needed to be added to this.  

- Download and unzip the compatible 'Debug Pack' from windows.php.net/download (it is just below the interpreter file
listed above).
 
- For PhpStorm debug you also need an 'xdebug' debugger.  Download this from https://xdebug.org, select Xdebug 2.6.1
(which is a released version using PHP 7.2, VC15 TS (32 bit)).  Unzip it in the same php_v7_downloads directory as the
other files.

After downloading and unzipping the files there are a few manual tweaking steps.
1. copy the  ‘php.ini-development’ file to ‘php.ini’
2. edit the php.ini file (for debugger support), add the following:

```
[Xdebug]
zend_extension="C:/php/php_xdebug.dll"
xdebug.remote_enable=1
xdebug.remote_port="9000"
```

also set:
```
doc_root = c:\Apache24\htdocs 
```

3. deploy files to C:/php (lowercase)

#### Apache

Apache is needed by PHP.  Download from https://www.apachelounge.com/download.  Use the [Apache VC15 Binary] 
httpd-2.4.37-win32-VC15.zip.  Copy or move files to C:/Apache24.  

To test out the installation first start the server by opening a command window (cmd.exe), cd C:/Apache24/bin, 
enter httpd.exe.  Note that you need to leave this window open (or set up Apache as a background service).  To exit 
the server type control-C.  

After starting the server bring up a browser and type http://localhost.  If all is well you should see “It Works!” 

#### PhpStorm

PhpStorm is an IDE by JetBrains.  Find it at https://www.jetbrains.com.  The program supports PHP and HTML development
and integrates seamlessly with git and GitHub.  It does not however come with its own PHP interpreter, which must be
installed as noted above, and it also requires an external script debugger (Xdebug), installed as noted above, and it
needs an external git installed also.  For unit testing notes see the following: 

- https://www.jetbrains.com/help/phpstorm/enabling-php-unit-support.html
- https://www.jetbrains.com/help/phpstorm/configuring-xdebug.html

PhpStorm needs git installed, and this is outside of the scope of this README.  However one example would be the 
binaries of cygwin https://cygwin.com, which include git.  In this case (and perhaps others) PhpStorm needs to be 
informed of the path to git.  This is done via File --> Settings --> Version Control --> Git --> fill in the box, 
an example could be ```C:\cygwin64\bin\git.exe```.  It is also recommended to specify this path in the Windows Path 
system environment variable, i.e., ```Path = C:\cygwin64\bin;C:\cygwin64``` (this will require a system restart to
take effect), otherwise you may get an error when trying to connect with GitHub similar to 'can not open shared 
object file'.  See
https://stackoverflow.com/questions/27566999/git-with-intellij-idea-could-not-read-from-remote-repository for more.

If you use https for the git connection, set the remote repository to this repository by selecting VCS --> Git --> 
Remotes and entering '+' and then origin https://github.com/jonathanshapiro/cs673team1_fe.git in the pop up box.

It is also useful to tell PhpStorm that GitHub is being used.  Go to Settings --> Version Control --> GitHub and 'get a
token' by selecting the '+', enter your user name and password.  Now PhpStorm Git Push command will push back to GitHub
without asking for additional login information each time. 

Note that to make the Version Control window appear (default location is at the bottom of the PhpStorm IDE) it may
be necessary to enter 'Alt + 9'.  

#### mySQL

TODO 


### Installing Tools On Linux

TODO
  



