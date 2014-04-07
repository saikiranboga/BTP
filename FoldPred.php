<?php
error_reporting(E_ALL);
ini_set("display_error", 1);

require_once 'includes/path.php';
require_once 'includes/sqlConnect.php';
?>

<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="keywords" content="GENE, GENES, BIOLOGY, BIOINFORMATICS, GENOME, PROTEIN, GENOMICS, ASIA," />
    <meta name="description" content="annotations of unannotated proteins from metagenomic datasets" />

    <link rel="stylesheet" href="css/index.css" type="text/css" />
    <link rel="shortcut icon" href="images/favicon.ico">

    <link rel="stylesheet" href="css/jquery-ui-1.8.16.custom.css" type="text/css"/>
    <link rel="stylesheet" href="css/examples.css" type="text/css"/>        

    <title>Annotation prediction-Keyword Search</title>

    <style type="text/css">
      #myGrid, #myGrid div,#myGrid2, #myGrid2 div{
        padding: 0;
        margin: 0;
      }
      .grid-header{
        padding: 0;
        margin: 0;
      }
    </style>

  </head>

  <body>


    <table border="0" width="100%;"  cellspacing="0" cellpadding="0">
      <tr bgcolor="#FFCF00">
        <td width="15%"></td>
        <td style="text-align: center;">
          <h3 style="margin-top: 10px">
            <span style="color: #102E37;font-family:  'arial'; font-weight: bold;font-size: 2.1em;padding-left: 0;margin-bottom: 10px">PREDICTING ANNOTATIONS OF UNANNOTATED PROTIENS</span>
          </h3>
        </td>
        <td width="10%"></td>
      </tr>

      <tr bgcolor="#F3F3F3">

        <td>&nbsp;</td>
        <td colspan="2">
          <ul id="nav">
            <li><a href="index.php">Home</a></li>
            <li><a href="Align.php">Align</a></li>
            <li><a href="Query">Query</a></li>
            <li><a href="Federation">Federation</a></li>
            <li><a href="tutorial">Tutorial</a></li>
            <li><a href="faqs">FAQs</a></li>
            <li><a href="download">Download</a></li>
            <li><a href="links">Links</a></li>
            <li><a href="team">Team</a></li>
            <li><a href="feedback">Feedback</a></li>
          </ul>
        </td>

      </tr>
      <tr bgcolor="#ffffff">
        <td valign="top" bgcolor="#F3F3F3">
          <div id="table_of_contents">
          </div>
        </td>
        <td  align="left" valign="top" style="box-shadow: inset 0 0 2px #999;">
          <div id="content">
            <div class="pagecontent">
              <div class="dropCase">
                <?php
                
                if (isset($_POST['foldPred'])) {
                  //Biomine
                  echo "<p>Obtaining fold prediction from Biomine</p>";
                  //passthru("perl Scripts/get_fold_biomine_modified.pl data/query");
                  exec("perl Scripts/get_fold_biomine_modified.pl data/query");
                  
                  $dat = exec("cat data/query");
                  echo "<pre>Query:\n$dat</pre>";
                  
                  $dat = exec("cat data/query_fold_biomine");
                  echo "<pre>Fold Prediction from Biomine:\n$dat</pre>";
                  
                  echo "<p>Completed...</p>";
                  
                  //PFPred
                  echo "<p>Obtaining fold prediction from PFPred</p>";
                  exec("perl get_fold_PFPPred_modified.pl data/query");
                  
                  $dat = exec("cat data/query");
                  echo "<pre>Query:\n$dat</pre>";
                  
                  $dat = exec("cat data/query_PFPPred_fold");
                  echo "<pre>Fold Prediction from PFPred:\n$dat</pre>";
                  
                  echo "<p>Completed...</p>";
                  
                }
                
                ?>
              </div>
            </div>
        </td>
        <td  bgcolor="#F3F3F3">&nbsp;</td>
      </tr>

      <tr bgcolor="#F3F3F3"><td colspan="3">&nbsp;</td></tr>
    </table>

    <div id="footer">
      Last Updated: 29 Dec 2013
    </div>
  </body>
</html>