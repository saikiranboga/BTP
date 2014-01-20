BTP
===

b-tech project

Description:
--------------------------------------------------------------------------------
Web application to align input protein sequence to existing metagenome sequences
and predict there protein structures.

Installing:
--------------------------------------------------------------------------------
Installing and running the project requires:

* Paths to following to be configured in path.php 
-Blast+ binaries existing on system
-Metagenomic db sequences already formated by blast+

* Configure MySql database containing metagenome annotation and there details in sqlConnect.php

* Webserver with PHP (Tested on Apache 2.4.6 from LAMP package)