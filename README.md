BTP
===

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
