# INSTALL

### EXAMPLE SETUP FOR OS X MAMP ENVIRONMENT (MAMP v2.0.5)

Disclaimer: the configuration provided below is intended for a sandbox environment only. Do not use this for production.

* Get the source
  
```sh
git clone git@github.com:jazahn/Quizmo.git Quizmo
```
   
* Add the following section to your Apache vhosts config <code>/Applications/MAMP/conf/apache/extra/httpd-vhosts.conf</code>:
	 
```apache
<VirtualHost *:80>
	ServerName quizmo.harvard.edu
	DocumentRoot "/Applications/MAMP/htdocs/Quizmo/quizmo"
	<Directory /Applications/MAMP/htdocs/Quizmo/quizmo>
		Options All
		AllowOverride All
		Order deny,allow
		Deny from all
		Allow from 127.0.0.1 localhost
	</Directory>
</VirtualHost>
```
	 
* Uncomment the Include line for vhosts in <code>/Applications/MAMP/conf/apache/httpd.conf</code>:
	 
```apache
# Virtual hosts
Include /Applications/MAMP/conf/apache/extra/httpd-vhosts.conf
```
 
* Update your <code>/etc/hosts</code>:
 
```sh
127.0.0.1	quizmo.harvard.edu
```

* Open the MAMP control panel. Go to _Preferences..._ then _Ports_ and set the Apache port to 80 and the mysql port to 3306. Click OK.  (Or just click the "Set to default Apache and MySQL ports" button)
* Click Start Servers in the MAMP control panel. The Apache Server and MySQL Server status should become green.
* Run the following shell script to install the application (setup config, create schema, etc):

```sh
/Applications/MAMP/htdocs/Catool/scripts/install_mamp.sh
```

* Now try to run the tests

```sh
cd /Applications/MAMP/htdocs/Quizmo/quizmo/protected/tests
phpunit unit
```

* If there were no errors in the install process, you should now be able to open http://quizmo.harvard.edu/ in your web browser, at which point you will be prompted to login.

# DEPENDENCIES

### The following third party libraries are bundled with the application:

* rc4crypt. _RC4Crypt is a petite library that allows you to use RC4 encryption easily in PHP. GPLv2 license._
* smarty. 
* 
