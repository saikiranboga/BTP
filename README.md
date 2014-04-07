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
    - Blast+ binaries existing on system
    - Metagenomic db sequences already formated by blast+
    - NCBI nr db already formated by blast+

* Configure MySql database containing metagenome annotation and there details in sqlConnect.php

* Webserver with PHP (Tested on Apache 2.4.6 from LAMP package)

* Sphinx standalone keyword search setup as given below.

###Keyword Search Instructions:###

1. **Sphinx 2.1.4-id64-release (rel21-r4421)** is used as backend support.
2. **sphinxsearch_2.1.4-release-0ubuntu11~lucid_amd64.deb** is installed on ubuntu server.
3. When installed, it is distributed into three places:
  - **/usr/bin/indexer**	(Used for indexing)
  - **/usr/bin/search**	(Used for searching through commandline)
  - **/usr/bin/searchd**	(Deamon used for searching through APIs)
4. Configuration file for both indexer and searchd are stored in
	- **/etc/sphinxsearch/sphinx.conf**
5. Indexing can be done by running the following command
  - **indexer repr_fold fold_type_class** (OR)
  - **/usr/bin/indexer repr_fold fold_type_class**
6. Command line search can be done with the following command
  - **search “search-word”** (OR)
  - **/usr/bin/search “search-word”**
7. sphinxapi.php is the API used in php for searching through php.
8. Default port for connecting to searchd is 3306.
9. When keyword search form is submitted from Query.php page, it is redirected to keywordQuery.php page and results are displayed.
