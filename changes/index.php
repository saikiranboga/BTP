<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
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

                    var indexMatch = str.indexOf("\n");
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
                window.open("example.htm", "newwindow", "height=450, width=690, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=no,location=no, status=no");

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
                alert(qseq + "\n" + midline + "\n" + hseq);
            }

            function showNCBI()
            {
                document.getElementById("dynamic").innerHTML = "<p>Fetching results from NCBI nr database...</p>";
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
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                    {
                        document.getElementById("dynamic").innerHTML = xmlhttp.responseText;
                    }
                }
                xmlhttp.open("GET", "tmp.php", true);
                xmlhttp.send();
            }
        </script>
    </head>
    <body>
        <?php
        include 'sqlConnect.php';
        $query = ">AACY020565195|1_395|-|Metagene|4215|Terminal|partial\nMASKKQVNKKKSKASKNNSSKVKTKKAVSKKAPAKKAPAKKTVAKKAPAKKAPAKKTVAKKAPAKKAPAKKTVAKKAPAKKTVAKKSSSKKSPTKKIKLQYSVGDFIVYPSHGVGEITDIQTFEIAEEKLE";
        if (isset($_POST['B1'])) {
            $query = $_POST['S1'];
            exec("echo \"$query\" > /home/vivek/BTPWork/query");

            // ALWAYS USE 2>&1 IN EXEC WHILE DEBUGGING
//            $command = '/home/vivek/BTPWork/blast+/bin/blastp -query /home/vivek/BTPWork/query -db /home/vivek/BTPWork/blast+/db/unannotated.fasta -outfmt 5 -num_threads 4';
//            exec($command, $output, $status);

            // avoid blast+ search, read result from file
            $lay = 'cat /home/vivek/BTPWork/tmp.xml';
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

//            var_dump($Hit_def);
//            var_dump($Hsp_bitScore);
//            var_dump($Hsp_evalue);
//            var_dump($Hsp_queryFrom);
//            var_dump($Hsp_queryTo);
//            var_dump($Hsp_hitFrom);
//            var_dump($Hsp_hitTo);
//            var_dump($Hsp_queryFrame);
//            var_dump($Hsp_hitFrame);
//            var_dump($Hsp_identity);
//            var_dump($Hsp_positive);
//            var_dump($Hsp_gaps);
//            var_dump($Hsp_alignLen);
//            var_dump($Hsp_qseq);
//            var_dump($Hsp_hseq);
//            var_dump($Hsp_midline);

            foreach ($Hit_def as $Hit) {
                $escapeHit = mysqli_escape_string($db_con, $Hit);
                $sql = "select repr_element from repr_elements where element like('$escapeHit')";
                $result = mysqli_query($db_con, $sql);

                // display error in sql query
//                if (!$result) {
//                    echo $sql . "<br/>";
//                    printf("Error: %s\n", mysqli_error($db_con));
//                    exit();
//                }

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

            <!--            <table>
                            <tr><th>Accession for Match</th><th>Fold Type</th><th>Class</th></tr>
            <?php
            for ($i = 0; $i < count($Hit_def); $i++) {
                if ($class[$i] !== 'NA') {
                    echo "<tr>";
                    echo "<td>" . $repr_element[$i] . "</td>";
                    echo "<td>" . $description[$i] . "</td>";
                    echo "<td>" . $class[$i] . "</td>";
                    echo "</tr>";
                }
            }
            ?>
                        </table>-->

            <div align='center'>
                <table  style='BORDER-RIGHT: #808080 1px solid; BORDER-LEFT: #808080 1px solid' cellSpacing='0' cellPadding='0' width='700' bgColor='#f0f8ff' id='table1'>
                    <tr><td style='BORDER-BOTTOM: #a1a1a1 1px solid' bgColor='#dff0ff' height='80'><table id='table2'><tr><td><table width=700><tr><td align=center><font size=+2 face='times new roman'><b>PFP-FunDSeqE</b>:</font><font size=+2 face='times new roman'> Predicting protein fold pattern with functional domain and sequential evolution information</font></td></tr></table></td></tr><tr><td vAlign='bottom' height='30'><p align='left'>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<font size=4pt face='times new roman'> <font face='times new roman'>|</font> <a target='_blank' href='../bioinf/PFP-FunDSeqE/Readme.htm'><font color='blue' face='times new roman'><u>Read Me</u></font></a> &nbsp;<font face='times new roman'>|</font> &nbsp;<a target='_blank' href='../bioinf/PFP-FunDSeqE/Data.htm'><font color='blue' face='times new roman'><u>Data</u></font></a> &nbsp;<font face='times new roman'>|</font> &nbsp;<a target='_blank' href='../bioinf/PFP-FunDSeqE/Citation.htm'><font color='blue' face='times new roman'><u>Citation</u></font></a> &nbsp;<font face='times new roman'>|</font> </td></tr></table></td></tr><tr><td>&nbsp</td></tr><tr><td align=left><font size=5pt face='times new roman'>Your input sequence(129aa) is:</font></td></tr><tr><td align=left><br><font face='times new roman'>>QuerySeq</font><br><font face='times new roman'>M</font><font face='times new roman'>F</font><font face='times new roman'>R</font><font face='times new roman'>Q</font><font face='times new roman'>C</font><font face='times new roman'>A</font><font face='times new roman'>K</font><font face='times new roman'>R</font><font face='times new roman'>Y</font><font face='times new roman'>A</font><font face='times new roman'>S</font><font face='times new roman'>S</font><font face='times new roman'>L</font><font face='times new roman'>P</font><font face='times new roman'>P</font><font face='times new roman'>N</font><font face='times new roman'>A</font><font face='times new roman'>L</font><font face='times new roman'>K</font><font face='times new roman'>P</font><font face='times new roman'>A</font><font face='times new roman'>F</font><font face='times new roman'>G</font><font face='times new roman'>P</font><font face='times new roman'>P</font><font face='times new roman'>D</font><font face='times new roman'>K</font><font face='times new roman'>V</font><font face='times new roman'>A</font><font face='times new roman'>A</font><font face='times new roman'>Q</font><font face='times new roman'>K</font><font face='times new roman'>F</font><font face='times new roman'>K</font><font face='times new roman'>E</font><font face='times new roman'>S</font><font face='times new roman'>L</font><font face='times new roman'>M</font><font face='times new roman'>A</font><font face='times new roman'>T</font><font face='times new roman'>E</font><font face='times new roman'>K</font><font face='times new roman'>H</font><font face='times new roman'>A</font><font face='times new roman'>K</font><font face='times new roman'>D</font><font face='times new roman'>T</font><font face='times new roman'>S</font><font face='times new roman'>N</font><font face='times new roman'>M</font><font face='times new roman'>W</font><font face='times new roman'>V</font><font face='times new roman'>K</font><font face='times new roman'>I</font><font face='times new roman'>S</font><font face='times new roman'>V</font><font face='times new roman'>W</font><font face='times new roman'>V</font><font face='times new roman'>A</font><font face='times new roman'>L</font><br><font face='times new roman'>P</font><font face='times new roman'>A</font><font face='times new roman'>I</font><font face='times new roman'>A</font><font face='times new roman'>L</font><font face='times new roman'>T</font><font face='times new roman'>A</font><font face='times new roman'>V</font><font face='times new roman'>N</font><font face='times new roman'>T</font><font face='times new roman'>Y</font><font face='times new roman'>F</font><font face='times new roman'>V</font><font face='times new roman'>E</font><font face='times new roman'>K</font><font face='times new roman'>E</font><font face='times new roman'>H</font><font face='times new roman'>A</font><font face='times new roman'>E</font><font face='times new roman'>H</font><font face='times new roman'>R</font><font face='times new roman'>E</font><font face='times new roman'>H</font><font face='times new roman'>L</font><font face='times new roman'>K</font><font face='times new roman'>H</font><font face='times new roman'>V</font><font face='times new roman'>P</font><font face='times new roman'>D</font><font face='times new roman'>S</font><font face='times new roman'>E</font><font face='times new roman'>W</font><font face='times new roman'>P</font><font face='times new roman'>R</font><font face='times new roman'>D</font><font face='times new roman'>Y</font><font face='times new roman'>E</font><font face='times new roman'>F</font><font face='times new roman'>M</font><font face='times new roman'>N</font><font face='times new roman'>I</font><font face='times new roman'>R</font><font face='times new roman'>S</font><font face='times new roman'>K</font><font face='times new roman'>P</font><font face='times new roman'>F</font><font face='times new roman'>F</font><font face='times new roman'>W</font><font face='times new roman'>G</font><font face='times new roman'>D</font><font face='times new roman'>G</font><font face='times new roman'>D</font><font face='times new roman'>K</font><font face='times new roman'>T</font><font face='times new roman'>L</font><font face='times new roman'>F</font><font face='times new roman'>W</font><font face='times new roman'>N</font><font face='times new roman'>P</font><font face='times new roman'>V</font><br><font face='times new roman'>V</font><font face='times new roman'>N</font><font face='times new roman'>R</font><font face='times new roman'>H</font><font face='times new roman'>I</font><font face='times new roman'>E</font><font face='times new roman'>H</font><font face='times new roman'>D</font><font face='times new roman'>D</font></td></tr><tr><td>&nbsp</td></tr><tr><td align=center><font size=5pt color='#56AA17' face='times new roman'>------- PFP-FunDSeqE Computation Result -------</td></tr>
                    <tr><td>&nbsp</td></tr>
                    <tr><td>
                            <div  name="results" style="padding-left: 40px; background: white; border: solid black; overflow-y:scroll; max-height: 300px">
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
                                            echo "<td>" . $repr_element[$i] . ' <a onclick="showAlign(\'' . $Hsp_qseq[$i] . '\',\'' . $Hsp_midline[$i] . '\',\'' . $Hsp_qseq[$i] . '\')" href=#>[+]</a></td>';
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
                    <tr><td align="center"><a href="index.php">HOME</a></td></tr>
                    <tr><td>&nbsp</td></tr>
                    <tr><td style='BORDER-TOP: #808080 1px solid' align='middle' bgColor='#dff0ff' height='50'><font size=4pt face='times new roman'>Contact @ <a href='mailto:hbshen@sjtu.edu.cn'><u>Hong-Bin</u></a></font></td></tr>
                </table>
            </div>
            <?
        } else {
            ?>
            <div align="center">
                <table width="700" bgcolor="#F0F8FF" style="border-left:1px solid #808080;border-right:1px solid #808080" >
                    <tr>
                        <td bgcolor="#DFF0FF" style="border-bottom:1px solid #A1A1A1" height="80">
                            <table>
                                <tr>
                                    <td align=center>
                                        <table width="92%">

                                            <tr width=600><td width=600><font size=+2><b>PFP-Pred</b>:</font>
                                                    <font size=+2> protein fold prediction</font>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="30" valign="bottom">&nbsp &nbsp &nbsp

                                        |
                                        <a href="Readme.htm" target=_blank><font size=+1><u>Read Me</u></font></a> |
                                        <a href="Data.htm" target=_blank><font size=+1><u>Data</u></font></a> &nbsp| &nbsp
                                        <a href="Citation.htm" target=_blank><font size=+1><u>Citation</u></font></a> &nbsp| &nbsp

                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" align="center">
                            <table width="650" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td height="25" style="border-left:0px solid #A1A1A1"></td>
                                </tr>
                                <tr>
                                    <td height="320" style="border:1px solid #A1A1A1">
                                        <table width="100%" cellspacing="0" cellpadding="10" bgcolor="#DFF0FF">

                                            <form name="form1" action="index.php" method="post" enctype="multipart/form-data" onsubmit="javascript:return checkform();">
                                                <input type="hidden" name="mode" value="string">


                                                <tr>
                                                    <td height="20">Input the protein sequence 							(<a href="#"onclick="openwin();"><b><u>Example</u></b></a>):&nbsp;</td>
                                                </tr>	

                                                <tr>
                                                    <td style="padding-top:0px">
                                                        <textarea rows="2" name="S1" cols="20" style="width:100%; height:220px; border:1px solid #A1A1A1;" ><?php echo $query ?></textarea>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td align="center">
                                                        &nbsp &nbsp &nbsp &nbsp &nbsp
                                                        <input style="font-size:13pt"; type="submit" value="Submit" name="B1">
                                                        &nbsp &nbsp &nbsp &nbsp &nbsp
                                                        <input style="font-size:13pt"type="reset" value="Clear" name="RB"></td>			

                                                </tr>
                                            </form>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr><td>&nbsp</td></tr>
                    <tr><td>
                            <font color="#3333FF" ><b>Reference:</b></font><br>
                            Hong-Bin Shen and Kuo-Chen Chou, "Ensemble classifier for protein folding pattern recognition". <em>Bioinformatics</em>, 2006, <b>22</b>: 1717-22.
                        </td></tr>
                    <tr>
                        <td height="50" align="center" bgcolor="#DFF0FF" style="border-top:1px solid #808080">
                            Contact @ <a href="mailto:hbshen@sjtu.edu.cn"><u>Hong-Bin</u></a></td>
                    </tr>
                </table>
            </div>
            <?
        }
        ?>

        <div id="dynamic"><button onclick="showNCBI()">Search NCBI</button></div>

    </body>
</html>

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
