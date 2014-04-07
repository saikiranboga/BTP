<?php
error_reporting(E_ALL);
ini_set("display_error", 1);

//$server = "localhost:3306";
//$username = "root";
//$password = "root";
//$database = "metagen";
//
//$conn = mysql_connect($server, $username, $password, $database);
//if ($conn == NULL)
//    echo "DB connection error";


if (!empty($_GET['q']))
    require_once('sphinxapi.php');

$q = isset($_GET['q']) ? $_GET['q'] : '';

//mysql_real_escape_string($q);

$q = preg_replace('/\s+/', ' ', $q);
/*
  $q = preg_replace('/\s+/',' | ',$q);

  $q = preg_replace('/\\\/','',$q);
  $q = preg_replace('/\/+/','\\/',$q);

  $q = preg_replace('/\++/','\\+',$q);
 */

$keys = explode(" ", $q);

function EscapeSphinxQL($string) {
    $from = array('\\', '(', ')', '|', '-', '!', '@', '~', '"', '&', '/', '=', "'", "\x00", "\n", "\r", "\x1a", '+', ' ', '[', ']', '|'); // '^', '$', 
    $to = array('\\\\', '\\\(', '\\\)', '\\\|', '\\-', '\\\!', '\\\@', '\\\~', '\\\"', '\\\&', '\/', '\\\=', "\\'", "\\x00", "\\n", "\\r", "\\x1a", '\+', ' | ', '\[', '\]', '\|'); // '\\\^',  '\\\$',
    return str_replace($from, $to, $string);
}

$q = EscapeSphinxQL($q);

$words = explode(" | ", $q);
//$keys = $words;
//$q = preg_replace('/[^\w~\|\(\)\^\$\?"\/=-]+/',' ',trim(strtolower($q)));
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="keywords" content="GENE, GENES, BIOLOGY, BIOINFORMATICS, GENOME, PROTEIN, GENOMICS, ASIA," />
        <meta name="description" content="annotations of unannotated proteins from metagenomic datasets" />

        <link rel="stylesheet" href="css/index.css" type="text/css" />
        <link rel="shortcut icon" href="images/favicon.ico">

        <link rel="stylesheet" href="css/slick.grid.css" type="text/css"/>
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
                <td   valign="top" bgcolor="#F3F3F3">

                    <div id="table_of_contents">
                    </div>

                </td>
                <td  align="left" valign="top" style="box-shadow: inset 0 0 2px #999;">
                    <div id="content">
                        <div class="pagecontent">
                            <div class="dropCase">
                                <table width="100%">

                                    <tr>
                                        <td valign="top">
                                            <div style="padding: 0; margin: 0">Keywords: <?php
                                                foreach ($keys as $i => $wrd) {
                                                    echo htmlentities($wrd) . ", ";
                                                }
                                                ?></div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td valign="top"  style="padding: 0; margin: 0;">
                                            <div  id="grid1-header" class="grid-header" style="width:800px;">
                                                <label>Gene Sequence Matches</label>
                                            </div>
                                            <div id="myGrid" style="width:800px;height:394px;"></div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td valign="top">
                                            <div  id="grid2-header" class="grid-header" style="width:450px">
                                                <label>Folds, Class Matches</label>
                                            </div>
                                            <div id="myGrid2" style="width:450px;height:394px;"></div>
                                        </td>
                                    </tr>
                                </table>

                            </div>
                        </div>
                </td>
                <td  bgcolor="#F3F3F3">&nbsp;</td>
            </tr>

            <tr bgcolor="#F3F3F3"><td colspan="3">&nbsp;</td></tr>
        </table>

        <!-- ********************************************************************************************* -->      

        <?php
        if ($q != '') {

            $s = new SphinxClient;

            $s->setServer('127.0.0.1', 9312);
            $s->SetConnectTimeout(1);
            $s->setMatchMode(SPH_MATCH_EXTENDED);
// Set the maximum number of search results to return
            $s->SetLimits(0, 1001, 1000);
            $s->SetArrayResult(true);
            $s->SetWeights(array(100, 1));
            $s->SetMaxQueryTime(5000000);
            $s->SetSortMode(SPH_SORT_RELEVANCE);
//$sortby = "assession_number";
//$s->SetSortMode(SPH_SORT_ATTR_ASC, $sortby);

            $index = "repr_fold fold_type_class";

//$result  = $s->Query($search3, $index);

            $result_idx1 = $s->AddQuery($q, 'repr_fold');
            $result_idx2 = $s->AddQuery($q, 'fold_type_class');
            $result = $s->RunQueries();

            $result1['total'] = 0;
            $result2['total'] = 0;

            $result1 = $result[$result_idx1];

            $result2 = $result[$result_idx2];

//print_r($result1);
//print_r($result2);

            $error = $s->GetLastError();
            $warning = $s->GetLastWarning();

            $assess_n = "assession_number";
            $desc = "description";
            $code = "metagenomic_sample_code";
            $pred1 = "pred1";
            $pred2 = "pred2";

            require_once('sqlConnect.php');

            $ids1 = "";
            $ids2 = "";
            $num_res1 = $result1['total'];

            if ($num_res1 > 0) {
                foreach ($result1['matches'] as $id => $other) {
                    $data = $other['attrs'];
                    $ids1 .= "assession_number=\"" . mysqli_real_escape_string($db_con, $data['assession_number']) . "\" OR ";
                }
            }


            $num_res2 = $result2['total'];
            if ($num_res2 > 0) {
                foreach ($result2['matches'] as $id => $other) {
                    $data = $other['attrs'];
                    $ids2 .= "fold_type=\"" . mysqli_real_escape_string($db_con, $data['fold_type']) . "\" OR ";
                }
            }

            $ids1 = substr($ids1, 0, -4);
            $ids2 = substr($ids2, 0, -4);

//echo "SQL Query1: ".$ids1."\n";
//echo "SQL Query2: ".$ids2."\n";
//echo "</br>Error: ";
//var_dump($error);
//echo "</br>Warning: ";
//var_dump($warning);
//print_r($result);
            ?>

            <script src="js/jquery-1.7.min.js"></script>
            <script src="js/jquery.event.drag-2.2.js"></script>

            <script src="js/slick.core.js"></script>
            <script src="js/slick.grid.js"></script>
            <script src="js/slickgridPlugins/slick.rowselectionmodel.js"></script>

            <script>

                function formatter(row, cell, value, columnDef, dataContext) {
                    if (value == null)
                        return '';
                    return value.toString();
                }

                // GRID FOR repr_fold TABLE
                var grid;

                var options = {
                    enableCellNavigation: false,
                    enableColumnReorder: false,
                    enableTextSelectionOnCells: true
                            //forceFitColumns         : true
                };

    <?php if ($num_res1 < 15) { ?>

                    options['autoHeight'] = true;
                    num_rows = <?php echo $num_res1; ?>;
                    $('#myGrid').height(num_rows * 25 + 40);

    <?php } ?>

                h = $('#grid1-header').html();
                h = h + "<span><?php echo "Number of matches: " . $num_res1; ?></span>";
                $('#grid1-header').html(h);
                $(function() {
                    var data = [];
                    var columns = [
                        {id: "srno", name: "SrNo", field: "SrNo", minWidth: 40, maxWidth: 40, formatter: formatter},
                        {id: "assessnum", name: "AssessNum", field: "AssessNum", minWidth: 180, maxWidth: 500, formatter: formatter},
                        {id: "code", name: "Code", field: "Code", width: 50, minWidth: 40, maxWidth: 60, formatter: formatter},
                        {id: "pred1", name: "Pred1", field: "Pred1", minWidth: 180, maxWidth: 320, formatter: formatter},
                        {id: "pred2", name: "Pred2", field: "Pred2", minWidth: 180, maxWidth: 200, formatter: formatter},
                        {id: "desc", name: "Desc", field: "Desc", minWidth: 150, maxWidth: 200, formatter: formatter}
                    ];

    <?php
    $searchingFor = "/";
    foreach ($words as $key => $value) {
        $searchingFor .= "$value|";
    }
    $searchingFor = substr($searchingFor, 0, -1);
    $searchingFor .= "/i";
//$searchingFor = "/" . $q . "/i";
//$replacePattern = "<b>$0<\/b>";
    $replacePattern = "<span style=\'background: #dadada\'>$0<\/span>";

    function escapeJavaScriptText($string) {
        return str_replace('"', '\"', str_replace("\r", '', (string) $string));
    }

    if ($num_res1 > 0) {
        $sql_qry1 = "SELECT * FROM `repr_fold` WHERE $ids1";
        $mysqlResult1 = mysqli_query($db_con, $sql_qry1);
        $i = 0;
        while ($rows = mysqli_fetch_array($mysqlResult1)) {
            //echo "$i : ";
            //echo "$rows[$assess_n] $rows[$code] $rows[$pred1] $rows[$pred2] $rows[$desc]\n";
            ?>
                            data[<?php echo $i ?>] = {
                                SrNo: <?php echo "\"" . ($i + 1) . "\""; ?>,
                                AssessNum: <?php echo "\"" . escapeJavaScriptText(preg_replace($searchingFor, $replacePattern, $rows[$assess_n])) . "\""; ?>,
                                Code: <?php echo "\"" . escapeJavaScriptText(preg_replace($searchingFor, $replacePattern, $rows[$code])) . "\""; ?>,
                                Pred1: <?php echo "\"" . escapeJavaScriptText(preg_replace($searchingFor, $replacePattern, $rows[$pred1])) . "\""; ?>,
                                Pred2: <?php echo "\"" . escapeJavaScriptText(preg_replace($searchingFor, $replacePattern, $rows[$pred2])) . "\""; ?>,
                                Desc: <?php echo "\"" . escapeJavaScriptText(preg_replace($searchingFor, $replacePattern, $rows[$desc])) . "\""; ?>
                            };
            <?php
            $i++;
        }
    }
    if ($num_res1 > 0) {
        ?>
                        grid = new Slick.Grid("#myGrid", data, columns, options);
                        grid.setSelectionModel(new Slick.RowSelectionModel());
        <?php
    } else {
        ?>
                        $('#myGrid').parent().hide();
        <?php
    }
    ?>
                });


                // GRID FOR FOLD_TYPE_CLASS

                var fold_grid;

                var fold_options = {
                    enableCellNavigation: false,
                    enableColumnReorder: false,
                    enableTextSelectionOnCells: true
                            //forceFitColumns         : true
                };

    <?php if ($num_res2 < 15) { ?>

                    fold_options['autoHeight'] = true;
                    num_rows = <?php echo $num_res2; ?>;
                    $('#myGrid2').height(num_rows * 25 + 40);

    <?php } ?>

                h = $('#grid2-header').html();
                h = h + "<span><?php echo "Number of matches: " . $num_res2; ?></span>";
                $('#grid2-header').html(h);

                $(function() {
                    var data = [];
                    var columns = [
                        {id: "srno", name: "SrNo", field: "SrNo", minWidth: 40, maxWidth: 40, formatter: formatter},
                        {id: "foldtypeclass", name: "FoldTypeClass", field: "FoldTypeClass", minWidth: 180, maxWidth: 500, formatter: formatter},
                        {id: "class", name: "Class", field: "Class", minWidth: 200, maxWidth: 200, formatter: formatter}
                    ];

    <?php
//echo "Number of matches: " . $num_res2 . "\n";
    if ($num_res2 > 0) {
        $sql_qry2 = "SELECT * FROM `fold_type_class` WHERE $ids2";
        $mysqlResult2 = mysqli_query($db_con, $sql_qry2);
        $i = 0;
        while ($rows = mysqli_fetch_array($mysqlResult2)) {
            //echo "$i : ";
            //echo $rows['fold_type'] . "  " . $rows['class'] . "\n";
            ?>
                            data[<?php echo $i ?>] = {
                                SrNo: <?php echo "\"" . ($i + 1) . "\""; ?>,
                                FoldTypeClass: <?php echo "\"" . escapeJavaScriptText(preg_replace($searchingFor, $replacePattern, $rows['fold_type'])) . "\""; ?>,
                                Class: <?php echo "\"" . escapeJavaScriptText(preg_replace($searchingFor, $replacePattern, $rows['class'])) . "\""; ?>
                            };
            <?php
            $i++;
        }
    }
    if ($num_res2 > 0) {
        ?>
                        fold_grid = new Slick.Grid("#myGrid2", data, columns, fold_options);
                        fold_grid.setSelectionModel(new Slick.RowSelectionModel());
        <?php
    } else {
        ?>
                        $('#myGrid2').parent().hide();
        <?php
    }
    if ($num_res1 <= 0 && $num_res2 <= 0) {
        ?>
                        $("<tr><td><p>No Results Found!</p></td></tr>").appendTo($('#myGrid2').parent().parent());
        <?php
    }
    ?>
                });
            </script>
            <?php
        }
        mysqli_close($db_con);
//echo $searchingFor;
        ?>
        <div id="footer">
            Last Updated: 29 Dec 2013
        </div>
    </body>
</html>