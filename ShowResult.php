<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="keywords" content="GENE, GENES, BIOLOGY, BIOINFORMATICS, GENOME, PROTEIN, GENOMICS, ASIA," />
        <meta name="description" content="tdicting annotations of unannotated proteins from metagenomic datasets" />
        <link rel="stylesheet" href="css/index.css" type="text/css" />
        <link rel="shortcut icon" href="images/favicon.ico">
        <title>Annotation prediction-Home </title>

        <link rel="stylesheet" href="css/colorbox.css" type="text/css"/>
        <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="js/jquery.colorbox-min.js"></script>
        <script>
            $(document).ready(function() {
                $(".inline").colorbox({inline: true});
            });

        </script>

        <script language="javascript">

            function checkform()
            {
                if (form1.S1.value === 0) {
                    alert("Please enter the protein sequence!");
                    form1.S1.focus();
                    return(false);
                }
                else {
                    var seqstr = form1.S1.value;

                    str = seqstr.toLowerCase();

                    if (str.indexOf('>') !== 0) {
                        alert("Sorry,your input sequence is not in Fasta format. Please see the example and input again!");
                        form1.S1.focus();
                        return(false);
                    }
                    else {
                        var indexMatch = str.indexOf("\n");

                        str = str.substr(indexMatch, str.length - indexMatch - 1);

                        while (indexMatch !== -1) {
                            str = str.replace(" ", "");
                            indexMatch = str.indexOf(" ");
                        }
                    }

                    indexMatch = str.indexOf("\n");
                    while (indexMatch !== -1) {
                        str = str.replace("\n", "");
                        indexMatch = str.indexOf("\n");
                    }

                    indexMatch = str.indexOf("\r");
                    while (indexMatch !== -1) {
                        str = str.replace("\r", "");
                        indexMatch = str.indexOf("\r");
                    }

                    if (str.length < 10) {
                        alert("Sorry,Your input sequence is:" + str.length + " aa long and less than 10aa. Please input again!");
                        form1.S1.focus();
                        return(false);
                    }

                    var xnum = 0;
                    var amino = "acdefghiklmnpqrstvwy";
                    for (var i = 0; i < str.length; i++) {
                        var letter = str.charAt(i);
                        if (amino.indexOf(letter) === -1) {
                            alert("Sorry,your input sequence includes invalid character:'" + letter + "'. Please see the example and input again!");
                            form1.S1.focus();
                            return(false);
                        }
                    }

                }
                return(true);
            }

            function openwin()
            {
                window.open("example.html", "newwindow", "height=450, width=690, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=no,location=no, status=no");

            }

            function acopenwin()
            {
                window.open("accession_number.htm", "newwindow", "height=280, width=550, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=no,location=no, status=no");

            }

            function OpenNewsWin()
            {
                window.open("News.htm", "newwindow", "height=300, width=550, top=0, left=0, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=no, status=no");

            }

            function showAlign(qseq, midline, hseq) {
                //this.innerHTML = qseq + "\n" + midline + "\n" + hseq;
                //alert(this.innerHTML);
                //alert(qseq + "\n" + midline + "\n" + hseq);
            }
            
            function showNCBI(nQuery)
            {
                document.getElementById("dynamic" + nQuery).innerHTML = '<p style="padding:5px;">Fetching results from NCBI nr database...</p>';
                if (window.XMLHttpRequest)
                {// code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                }
                else
                {// code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function()
                {
                    if (xmlhttp.readyState === 4 && xmlhttp.status === 200)
                    {
                        data = document.getElementById("dynamic" + nQuery).innerHTML;
                        data = '<p style="background:#FFD773;padding: 5px;">NCBI Search Results</p>' + xmlhttp.responseText;
                        document.getElementById("dynamic" + nQuery).innerHTML = data;
                        $(".inline").colorbox({inline: true, maxWidth: '900px'});
                    }
                };
                xmlhttp.open("GET", "getNCBI.php?qNum=" + nQuery, true);
                xmlhttp.send();

            }

            //  function to toggle displaying results in detail for query
            function toggle(num) {
//                alert("result" + num);
                if (document.getElementById("result" + num).style.display === "none")
                {
                    document.getElementById("result" + num).style.display = "block";
                }
                else {
                    document.getElementById("result" + num).style.display = "none";
                }
            }
        </script>
    </head>
    <body   bgcolor="#F3F3F3" style="min-width: 1050px;">
        <table border="0" width="100%;"  cellspacing="0" cellpadding="0">
            <tr bgcolor="#FFCF00">
                <td width="15%"></td>
                <td style="text-align: center;">
                    <h3>
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
                        <li class="cur"><strong><a href="Align.php">Align</a></strong></li>
                        <li><a href="Query.php">Query</a></li>
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
                <td  align="left" valign="top" bgcolor="#FFFFFF" style="box-shadow: inset 0 0 2px #999;">
                    <div id="content">
                        <div class="pagecontent">
                            <div class="dropCase">

                                <?php
                                include 'includes/sqlConnect.php';
                                include 'includes/path.php';
                                if (isset($_GET['q']) && file_exists("results/".$_GET['q'].".out")) {
                                    $filename = $_GET['q'];
                                    $query = "";
                                    $file = fopen("uploads/$filename", "r");
                                    while(!feof($file)){
                                            $query .= fgets($file, 4096);
                                    }
                                    fclose($file);
                                    splitQueries($query);
                                    $numQuery = 0;
                                    exec("echo \"$query\" > $blastQuery");
                                    // ALWAYS USE 2>&1 IN EXEC WHILE DEBUGGING
                                    $command = "cat results/${filename}.out";
                                    exec($command, $output, $status);
                                    // avoid blast+ search, read result from file
                                    //$lay = 'cat /home/saikiranboga/BTP/temp.xml';
                                    //exec($lay, $output, $status);

                                    $xmlString = implode("\n", $output);
                                    $xml = simplexml_load_string($xmlString);
                                    foreach ($xml->children() as $fgen) {
                                        if ($fgen->getName() == 'BlastOutput_iterations') {
                                            foreach ($fgen->children() as $sgen) {
                                                if ($sgen->getName() == 'Iteration') {
                                                    $query_ID[$numQuery] = $sgen->{'Iteration_query-ID'};
                                                    $query_def[$numQuery] = $sgen->{'Iteration_query-def'};
                                                    $query_len[$numQuery] = $sgen->{'Iteration_query-len'};
                                                    foreach ($sgen->children() as $tgen) {
                                                        if ($tgen->getName() == 'Iteration_hits') {
                                                            foreach ($tgen->children() as $qgen) {
                                                                if ($qgen->getName() == 'Hit') {
                                                                    $Hit_def[$numQuery][] = $qgen->Hit_def;
                                                                    $Hit_len[$numQuery][] = $qgen->Hit_len;
                                                                    foreach ($qgen->children() as $pgen) {
                                                                        if ($pgen->getName() == 'Hit_hsps') {
                                                                            foreach ($pgen->children() as $hgen) {
                                                                                if ($hgen->getName() == 'Hsp') {
                                                                                    $Hsp_bitScore[$numQuery][] = $hgen->{'Hsp_bit-score'};
                                                                                    $Hsp_score[$numQuery][] = $hgen->{'Hsp_score'};
                                                                                    $Hsp_evalue[$numQuery][] = $hgen->{'Hsp_evalue'};
                                                                                    $Hsp_queryFrom[$numQuery][] = $hgen->{'Hsp_query-from'};
                                                                                    $Hsp_queryTo[$numQuery][] = $hgen->{'Hsp_query-to'};
                                                                                    $Hsp_hitFrom[$numQuery][] = $hgen->{'Hsp_hit-from'};
                                                                                    $Hsp_hitTo[$numQuery][] = $hgen->{'Hsp_hit-to'};
                                                                                    $Hsp_queryFrame[$numQuery][] = $hgen->{'Hsp_query-frame'};
                                                                                    $Hsp_hitFrame[$numQuery][] = $hgen->{'Hsp_hit-frame'};
                                                                                    $Hsp_identity[$numQuery][] = $hgen->{'Hsp_identity'};
                                                                                    $Hsp_positive[$numQuery][] = $hgen->{'Hsp_positive'};
                                                                                    $Hsp_gaps[$numQuery][] = $hgen->{'Hsp_gaps'};
                                                                                    $Hsp_alignLen[$numQuery][] = $hgen->{'Hsp_align-len'};
                                                                                    $Hsp_qseq[$numQuery][] = $hgen->{'Hsp_qseq'};
                                                                                    $Hsp_hseq[$numQuery][] = $hgen->{'Hsp_hseq'};
                                                                                    $Hsp_midline[$numQuery][] = $hgen->{'Hsp_midline'};
                                                                                    break;
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                    $numQuery++;
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                    <div>
                                        <table  id='table1'cellSpacing='0' cellPadding='0'  width="100%">


                                            <?php
                                            for ($qNum = 0; $qNum < $numQuery; $qNum++) {
                                                foreach ($Hit_def[$qNum] as $Hit) {
                                                    $escapeHit = mysqli_escape_string($db_con, $Hit);
                                                    $sql = "select repr_element from repr_elements where element like('$escapeHit')";
                                                    $result = mysqli_query($db_con, $sql);
                                                    if (!($row = mysqli_fetch_array($result)))
                                                        $repr_element[] = $Hit;
                                                    else
                                                        $repr_element[] = $row['repr_element'];

                                                    $escapeRepr_element = mysqli_escape_string($db_con, $repr_element[sizeof($repr_element) - 1]);
                                                    $sql = "select description from repr_fold where assession_number like('$escapeRepr_element')";
                                                    $result = mysqli_query($db_con, $sql);
                                                    if (!($row = mysqli_fetch_array($result)))
                                                        $description[] = "NA";
                                                    else
                                                        $description[] = $row['description'];
                                                    $escapeDescription = mysqli_escape_string($db_con, $description[sizeof($description) - 1]);
                                                    $sql = "select class from fold_type_class where fold_type like('$escapeDescription')";
                                                    $result = mysqli_query($db_con, $sql);
                                                    if (!($row = mysqli_fetch_array($result))) {
                                                        $class[] = "NA";
                                                    } else {
                                                        $class[] = $row['class'];
                                                    }
                                                }
                                                ?>
                                                <tr>
                                                    <td>
                                                        <p> </p>
                                                    </td>
                                                </tr>
                                                <!--
                                                    #FFD773
                                                -->
                                                <tr>
                                                    <td style="padding: 5px; background: #FFD773">
                                                        <font size=3pt face='times new roman'>Query <?php print $qNum + 1; ?></font>
                                                        <pre><?php echo $query_def[$qNum] . '<a  onclick="toggle(' . $qNum . ')" >[+]</a>'; ?></pre>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div name="results" style="display: none" <?php echo 'id="result' . $qNum . '"'; ?> >
                                                            <table id="results" width="100%">
                                                                <tr>
                                                                    <th>Annotation</th>
                                                                    <th>E-Value</th>
                                                                    <th>Score</th>
                                                                    <th>Fold Type</th>
                                                                    <th>Class</th>
                                                                </tr>

                                                                <?php
                                                                for ($i = 0; $i < count($Hit_def[$qNum]); $i++) {
                                                                    if ($class[$i] !== 'NA') {
                                                                        echo "<tr>";
                                                                        echo '<td><pre>' . substr($Hit_def[$qNum][$i], 0, 45) . '..<a class="inline" href="#inline_content' . $i . '">[+]</a></pre>';
                                                                        echo "<div style='display:none'>
                                                                            <div id='inline_content" . $i . "' style='padding:10px; background:#fff;'>
                                                                                <p><PRE>>" . $Hit_def[$qNum][$i];
                                                                        echo "<br/>Length = " . $Hit_len[$qNum][$i] . "<br/>";
                                                                        echo "<br/>Score = " . $Hsp_bitScore[$qNum][$i] . " bits (" . $Hsp_score[$qNum][$i] . ") ";
                                                                        echo "Expect = " . trunc((double) $Hsp_evalue[$qNum][$i], 2) . ".";
                                                                        echo "<br/>Identities = " . $Hsp_identity[$qNum][$i] . "/" . $Hsp_alignLen[$qNum][$i] . " (" . (round($Hsp_identity[$qNum][$i] / $Hsp_alignLen[$qNum][$i], 2) * 100) . "%) ";
                                                                        echo "Positives = " . $Hsp_positive[$qNum][$i] . "/" . $Hsp_alignLen[$qNum][$i] . "(" . (round($Hsp_positive[$qNum][$i] / $Hsp_alignLen[$qNum][$i], 2) * 100) . "%) ";
                                                                        echo "Gaps = " . $Hsp_gaps[$qNum][$i] . "/" . $Hsp_alignLen[$qNum][$i] . "(" . (round($Hsp_gaps[$qNum][$i] / $Hsp_alignLen[$qNum][$i], 2) * 100) . "%) ";
                                                                        echo "<br/><br/>Query  " . $Hsp_qseq[$qNum][$i];
                                                                        echo "<br/>       " . $Hsp_midline[$qNum][$i];
                                                                        echo "<br/>Sbjct  " . $Hsp_hseq[$qNum][$i];
                                                                        echo "<br/><br/>Representative Sequence: " . $repr_element[$qNum][$i] . "</PRE>";
                                                                        echo "</p>
                                                                            </div>
                                                                          </div>";
                                                                        echo "</td>";
                                                                        echo "<td><pre>" . trunc((double) $Hsp_evalue[$qNum][$i], 2) . "</td></pre>";
                                                                        echo "<td><pre>" . $Hsp_score[$qNum][$i] . "</td></pre>";
                                                                        echo "<td><pre>" . $description[$i] . "</td></pre>";
                                                                        echo "<td><pre>" . $class[$i] . "</td></pre>";
                                                                        echo "</tr>";
                                                                    }
                                                                }
                                                                ?>
                                                            </table>
                                                            <!--*As told by Ma'am this feature not required*-->
                                                            <div id="<?php echo "dynamic" . $qNum; ?>">
                                                                <button onclick="showNCBI(<?php echo $qNum; ?>)">Search NCBI</button>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                            </tr>
                                            <tr>
                                                <td align="center" style="padding-top: 10px">
                                                    <a href="index.php">HOME</a>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <table width="100%" bgcolor="#F0F8FF">
                                        <tr>
                                            <td valign="top">
                                                Your query either doesn't exists or has not been processed yet.
                                            </td>
                                        </tr>
                                    </table>
                                    <?php
                                }
                                ?>


                                <?php

                                function trunc($number, $places) {
                                    if ($number == 0) {
                                        return 0;
                                    }
                                    $num = ($number < 0 ? -$number : $number);
                                    $d = \ceil(\log10((double) $num));
                                    $power = $places - (int) $d;

                                    $magnitude = pow(10, $power);
                                    $shifted = round($number * $magnitude);
                                    return $shifted / $magnitude;
                                }

                                function splitQueries($query) {
                                    $queries = explode('>', $query);

                                    for ($i = 0; $i < count($queries) - 1; $i++) {
                                        exec('echo ">' . $queries[$i + 1] . '" > data/query' . $i);
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </td>
                <td  bgcolor="#F3F3F3">&nbsp;</td>
            </tr>

            <tr bgcolor="#F3F3F3"><td colspan="3">&nbsp;</td></tr>
        </table>
        <div id="footer">
            Last Updated: 29 Nov 2013
        </div>

    </body>
</html>