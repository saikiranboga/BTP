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
                    /*
                     var seqstr = form1.S1.value;
                     
                     str = seqstr.toLowerCase();
                     
                     if (str.indexOf('>') !== 0) {
                     alert("Sorry,your input sequence is not in Fasta format. Please see the example and input again!");
                     form1.S1.focus();
                     return(false);
                     }
                     
                     var indexMatch = str.indexOf("\n");
                     
                     */

                    str = substr(str, indexMatch);

                    while (indexMatch !== -1) {
                        str = str.replace(" ", "");
                        indexMatch = str.indexOf(" ");

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
        </script>
    </head>
    <body   bgcolor="#F3F3F3" style="min-width: 900px;">
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
                                include 'sqlConnect.php';
                                $query = ">AACY020565195|1_395|-|Metagene|4215|Terminal|partial\nMASKKQVNKKKSKASKNNSSKVKTKKAVSKKAPAKKAPAKKTVAKKAPAKKAPAKKTVAKKAPAKKAPAKKTVAKKAPAKKTVAKKSSSKKSPTKKIKLQYSVGDFIVYPSHGVGEITDIQTFEIAEEKLE";
                                if (isset($_POST['B1'])) {
                                    $query = $_POST['S1'];
                                    //exec("echo \"$query\" > /home/saikiranboga/BTP/query");
                                    // ALWAYS USE 2>&1 IN EXEC WHILE DEBUGGING
                                    //$command = '/home/saikiranboga/BTP/blast+/bin/blastp -query /home/saikiranboga/BTP/query -db /home/saikiranboga/BTP/blast+/db/unannotated.fasta -outfmt=5';
                                    //exec($command, $output, $status);
                                    // avoid blast+ search, read result from file
                                    $lay = 'cat /home/saikiranboga/BTP/temp.xml';
                                    exec($lay, $output, $status);

                                    $xmlString = implode("\n", $output);
                                    $xml = simplexml_load_string($xmlString);
                                    foreach ($xml->children() as $fgen) {
                                        if ($fgen->getName() == 'BlastOutput_iterations') {
                                            foreach ($fgen->children() as $sgen) {
                                                if ($sgen->getName() == 'Iteration') {
                                                    foreach ($sgen->children() as $tgen) {
                                                        if ($tgen->getName() == 'Iteration_hits') {
                                                            foreach ($tgen->children() as $qgen) {
                                                                if ($qgen->getName() == 'Hit') {
                                                                    $Hit_def[] = $qgen->Hit_def;
                                                                    $Hit_len[] = $qgen->Hit_len;
                                                                    foreach ($qgen->children() as $pgen) {
                                                                        if ($pgen->getName() == 'Hit_hsps') {
                                                                            foreach ($pgen->children() as $hgen) {
                                                                                if ($hgen->getName() == 'Hsp') {
                                                                                    $Hsp_bitScore[] = $hgen->{'Hsp_bit-score'};
                                                                                    $Hsp_score[] = $hgen->{'Hsp_score'};
                                                                                    $Hsp_evalue[] = $hgen->{'Hsp_evalue'};
                                                                                    $Hsp_queryFrom[] = $hgen->{'Hsp_query-from'};
                                                                                    $Hsp_queryTo[] = $hgen->{'Hsp_query-to'};
                                                                                    $Hsp_hitFrom[] = $hgen->{'Hsp_hit-from'};
                                                                                    $Hsp_hitTo[] = $hgen->{'Hsp_hit-to'};
                                                                                    $Hsp_queryFrame[] = $hgen->{'Hsp_query-frame'};
                                                                                    $Hsp_hitFrame[] = $hgen->{'Hsp_hit-frame'};
                                                                                    $Hsp_identity[] = $hgen->{'Hsp_identity'};
                                                                                    $Hsp_positive[] = $hgen->{'Hsp_positive'};
                                                                                    $Hsp_gaps[] = $hgen->{'Hsp_gaps'};
                                                                                    $Hsp_alignLen[] = $hgen->{'Hsp_align-len'};
                                                                                    $Hsp_qseq[] = $hgen->{'Hsp_qseq'};
                                                                                    $Hsp_hseq[] = $hgen->{'Hsp_hseq'};
                                                                                    $Hsp_midline[] = $hgen->{'Hsp_midline'};
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    foreach ($Hit_def as $Hit) {
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
                                        if (!($row = mysqli_fetch_array($result)))
                                            $class[] = "NA";
                                        else
                                            $class[] = $row['class'];
                                    }
                                    ?>
                                    <div>
                                        <table  id='table1'cellSpacing='0' cellPadding='0'  width="100%">

                                            <tr>
                                                <td>
                                                    <p><font size=3pt face='times new roman'>Your input sequence is:</font></p>
                                                </td>
                                            </tr>
                                            <!--
                                                #FFD773
                                            -->
                                            <tr>
                                                <td style="padding: 5px; background: #FFD773">
                                                        <?php echo $query ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div  name="results" style="padding-left: 40px;">
                                                        <table>
                                                            <tr>
                                                                <th>Annotation</th>
                                                                <th>E-Value</th>
                                                                <th>Score</th>
                                                                <th>Fold Type</th>
                                                                <th>Class</th>
                                                            </tr>
                                                            
                                                            <?php
                                                            for ($i = 0; $i < count($Hit_def); $i++) {
                                                                if ($class[$i] !== 'NA') {
                                                                    echo "<tr>";
                                                                    echo "<td>" . $Hit_def[$i] . ' <a class="inline" href="#inline_content'.$i.'">[+]</a>';
                                                                    echo "<div style='display:none'>
                                                                            <div id='inline_content".$i."' style='padding:10px; background:#fff;'>
                                                                                <p><PRE>>".$Hit_def[$i];
                                                                    echo "<br/>Length = ".$Hit_len[$i]."<br/>";
                                                                    echo "<br/>Score = ".$Hsp_bitScore[$i]." bits (".$Hsp_score[$i].") ";
                                                                    echo "Expect = ".trunc((double) $Hsp_evalue[$i], 2).".";
                                                                    echo "<br/>Identities = ".$Hsp_identity[$i]."/".$Hsp_alignLen[$i]." (".(round($Hsp_identity[$i]/$Hsp_alignLen[$i], 2)*100)."%) ";
                                                                    echo "Positives = ".$Hsp_positive[$i]."/".$Hsp_alignLen[$i]."(".(round($Hsp_positive[$i]/$Hsp_alignLen[$i], 2)*100)."%) ";
                                                                    echo "Gaps = ".$Hsp_gaps[$i]."/".$Hsp_alignLen[$i]."(".(round($Hsp_gaps[$i]/$Hsp_alignLen[$i], 2)*100)."%) ";
                                                                    echo "<br/><br/>Query  ".$Hsp_qseq[$i];
                                                                    echo "<br/>       ".$Hsp_midline[$i];
                                                                    echo "<br/>Sbjct  ".$Hsp_hseq[$i];
                                                                    echo "<br/><br/>Representative Sequence: ".$repr_element[$i]."</PRE>";
                                                                    echo "</p>
                                                                            </div>
                                                                          </div>";
                                                                    echo "</td>";
                                                                    echo "<td>" . trunc((double) $Hsp_evalue[$i], 2) . "</td>";
                                                                    echo "<td>" . $Hsp_score[$i] . "</td>";
                                                                    echo "<td>" . $description[$i] . "</td>";
                                                                    echo "<td>" . $class[$i] . "</td>";
                                                                    echo "</tr>";
                                                                }
                                                            }
                                                            ?>
                                                        </table>
                                                    </div>
                                            </tr>
                                            <tr>
                                                <td align="center">
                                                    <a href="index.php">HOME</a>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
    <?
} else {
    ?>
                                    <table width="100%" bgcolor="#F0F8FF">
                                        <tr>
                                            <td valign="top">
                                                <form name="form1" action="Align.php" method="post" enctype="multipart/form-data" onsubmit="javascript:return checkform();">
                                                    <input type="hidden" name="mode" value="string"/>
                                                    <tr>
                                                        <td height="20">
                                                            Input the protein sequence (<a href="#" onclick="openwin();"><b><u>Example</u></b></a>):&nbsp;
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <textarea name="S1" style="width:99%; height:220px; overflow: auto; resize: none; margin: 0; border:1px solid #A1A1A1;"><?php echo $query; ?></textarea>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td align="center">
                                                            &nbsp &nbsp &nbsp &nbsp &nbsp
                                                            <input style="font-size:13pt" type="submit" value="Submit" name="B1"/>
                                                            &nbsp &nbsp &nbsp &nbsp &nbsp
                                                            <input style="font-size:13pt" type="reset" value="Clear" name="RB"/>
                                                        </td>
                                                    </tr>
                                                </form>
                                            </td>
                                        </tr>
                                    </table>
    <?
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
?>
                            </div>
                        </div>
                </td>
                <td  bgcolor="#F3F3F3">&nbsp;</td>
            </tr>

            <tr bgcolor="#F3F3F3"><td colspan="3">&nbsp;</td></tr>
        </table>
        <div id="footer">
            Last Updated: 27 Nov 2013
        </div>

        <!-- This contains the hidden content for inline calls -->
        <div style='display:none'>
            <div id='inline_content' style='padding:10px; background:#fff;'>
                <p><strong>This content comes from a hidden element on this page.</strong></p>
            </div>
        </div>

    </body>
</html>