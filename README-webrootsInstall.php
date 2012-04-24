a2provision -o quizmo

--install PDO
pecl install pdo
add extension=pdo.so to the php.ini

--install PDO_OCI
  (http://www.edmann.com/Computers-Technology/2009/10/08/Oracle-PDO-OCI-PHP-install-fedora-CentOS)
pecl download pdo_oci
  tar zxvf PDO_OCIxxx
  cd into it
  phpize
  ./configure
  make
  make install
add extension=pdo_oci.so to the php.ini


dom.so
yum install php-xml

--PHPUnit...
have to do phpunit 3.4 because it's the last version that only requires php 5.1.4
https://github.com/sebastianbergmann/phpunit/tarball/3.4/phpunit
http://www.phpunit.de/manual/3.4/en/installation.html
  skip down to the part about manually installing, I was unable to get it via pear

added the following lines to the php.ini:
Note: (phpunit is run from the command line.  as such, it uses the system php.ini(/etc/php.ini))
  include_path = ".:/web/quizmo/app/quizmo/protected/tests/phpunit"
  extension=dom.so


--For testing purposes we basically need the webroot's php.ini run from the system
add:
  extension=ldap.so