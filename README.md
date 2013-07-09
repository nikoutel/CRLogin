CRLogin
=========


**A challenge-response authentication system for web applications**  

Ensures that your password is not being send in plain text.  

It is not always possible to use TLS/SSL encryption for secure data communication. In this case if you log in to a website or web application, your password is transmitted in plain text over the wire leaving it vulnerable to listening attacks / sniffing.  
`CRLogin` does not send a password in plain text.  
The server sends a unique challenge to the client. The client computes a unique response using the servers challenge and the hashed and salted password and sends this to the server.   
The server computes the same thing and compares it with the received response. If they are identical, the user is authenticated.  
The response is never the same. So if someone manages to steal it, it will be of no use.



## Notes ##
* **This project is still under development! There may be security measures that are not yet implemented.**
* If you can, you should use TLS/SSL encryption.
* `CRLogin` protects your password from eavesdropping. Other data you may send will be not secure.
If you want all data protected, use TLS/SSL encryption.
* This is using JavaScript cryptography which may not have the best reputation, but it is still better than sending your password in plain text over a unsecure, untrusted network.
* The passwords are stored in the database salted and hashed with bcrypt.

## Data store ##
`CRLogin` comes with a data access layer built around PHP's data object (current database driver options are MySQL and SQLite) but the project is data store agnostic. You can use any other data store that uses the CRUD operation described by the `DataAccessor` interface.

## Requirements ##
*   PHP 5.3.0 (min)
*   MySQL 5.1 (min)
*   jQuery 1.7.1 (min) - is included


## Installation ##
Just copy the files in your document root directory,
run the installation script, located in the `install` directory, in your browser, choose your language and follow the instructions.  
(This intsall script is temporary. It's just a quick install solution.
A new, more dynamic and configurable application is on its way.)

#### Manual installation ####

If for any strange reason the above method does not work you have to do the installation manually.  
Create a file `install_config.php` according to the demo file `install_config_demo.php`.  
If you want you can create a new database or use a existing one.   
The user defined in the configuration file must have access to this database.  
Create the table in the database. Have a look at the `install_lib.php` file to see the details.  
Delete the `install` folder. Done.  
Check the demo page.

#### Configuration ####

Besides the `install_config.php` which is created automatically by the install script, a number of options can be configured in the `config.php` file.

## Todo ##

* Permission levels
* Failed login attempts count/Brute force detection
* Additional security layers
* Better installation script
* Administration/configuration page 
* Email verification
* Translate to more languages   
and many more

## Licence ##
This software is licensed under the [MPL](http://www.mozilla.org/MPL/2.0/) 2.0:
```
    This Source Code Form is subject to the terms of the Mozilla Public
    License, v. 2.0. If a copy of the MPL was not distributed with this
    file, You can obtain one at http://mozilla.org/MPL/2.0/.
```

## Acknowledgements ##
This project is using the following JavaScript Libraries:  
  
* [jQuery](http://jquery.com/): Copyright The jQuery Project - licensed under the MIT licenses.
* [jsBCrypt](http://code.google.com/p/javascript-bcrypt/): Copywrite nevins.bartolomeo@gmail.com - licensed under the BSD License. 
* [jsSHA](http://caligatio.github.io/jsSHA/): Copyright Brian Turek - licensed under the BSD License.