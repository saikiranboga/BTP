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
                if (!form1.metagenome_id.value && !form1.fold_type.value) {
                    alert("Atleast one field must be entered inorder to search!");
                    form1.S1.focus();
                    return(false);
                }
                else {
                    return(true);
                }
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
                        <li><a href="Align.php">Align</a></li>
                        <li class="cur"><strong><a href="Query.php">Query</a></strong></li>
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
                                if (isset($_POST['B2'])) {
                                    $id = $_POST['metagenome_id'];
                                    $escapeId = mysqli_escape_string($db_con, $id);

                                    $fold_type = $_POST['fold_type'];
                                    $escapeFoldType = mysqli_escape_string($db_con, $fold_type);

                                    if ($fold_type && $id)
                                        $sql = "select assession_number,description from repr_fold where metagenomic_sample_code like('$escapeId') and description like('$escapeFoldType')";
                                    else if ($id)
                                        $sql = "select assession_number,description from repr_fold where metagenomic_sample_code like('$escapeId')";
                                    else if ($fold_type){
                                        $sql = "select assession_number,description from repr_fold where description like('$fold_type')";
                                    }

                                    $result = mysqli_query($db_con, $sql);

                                    $i = 0;
                                    while ($row = mysqli_fetch_array($result)) {
                                        $repr_annotation[$i] = $row['assession_number'];
                                        $repr_description[$i] = $row['description'];
                                        $sql = "select class from fold_type_class where fold_type='$repr_description[$i]'";
                                        //echo $sql;
                                        $result_class = mysqli_query($db_con, $sql);
                                        $r = mysqli_fetch_array($result_class);
                                        if($r['class']){
                                            $repr_class[$i] = $r['class'];
                                        }
                                        else{
                                            $repr_class[$i] = "--";
                                        }
                                        $i += 1;
                                    }?>
                                    <div>
                                        <table  width="100%">
                                            <tr>
                                                <td style="background: #FFD773;padding-left: 10px;">
                                                    <p style="text-decoration: underline"><font size=3pt face='times new roman'>Query</font></p>
                                                    <pre><font size=3pt face='times new roman'>metagenome id: <?php echo $escapeId ?></font>

<font size=3pt face='times new roman'>fold type: <?php 
                                                    if($fold_type == "") {
                                                        echo "--";
                                                        
                                                    }else{
                                                        echo $fold_type;
                                                    }
                                                    ?></font>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div  name="results">
                                                        <table id="results_query" width="100%">
                                                            <?php if(isset($repr_annotation)){ ?>
                                                            <tr>
                                                                <th width="50%">Annotation</th>
                                                                <th>Fold Type</th>
                                                                <th>Class</th>
                                                            </tr>
                                                            <?php
                                                            for ($i = 0; $i < count($repr_annotation); $i++) {
                                                                if ($repr_annotation[$i] !== 'NA' && $repr_description[$i] !== 'NA') {
                                                                    echo "<tr>";
                                                                    echo '<td width="50%" style="font-size:12px"><PRE>' . substr($repr_annotation[$i], 0, 50) . "...</PRE></td>";
                                                                    echo "<td>" . $repr_description[$i] . "</td>";
                                                                    echo "<td>" . $repr_class[$i] . "</td>";
                                                                    echo "</tr>";
                                                                }
                                                            }
                                                            }
                                                            else{
                                                                echo "<tr><td>No Matches found.</td></tr>";
                                                            }
                                                            ?>
                                                        </table>
                                                    </div>
                                                </td>
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
                                                <form name="form1" action="Query.php" method="post" enctype="multipart/form-data" onsubmit="javascript:return checkform();">
                                                    <table width="100%">
                                                        <tr>
                                                            <td width="30%">
                                                                <span style="font-size:13pt" >Metagenome ID: </span><br/>
                                                                <span style="font-size:13pt" >Fold type: </span>
                                                            </td>
                                                            <td>
                                                                <input style="font-size:13pt" type="text" name="metagenome_id" /><br/>
                                                                <input style="font-size:13pt" type="text" name="fold_type" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="center" colspan="2">
                                                                &nbsp &nbsp &nbsp &nbsp &nbsp
                                                                <input style="font-size:13pt" type="submit" value="Submit" name="B2"/>
                                                                &nbsp &nbsp &nbsp &nbsp &nbsp
                                                                <input style="font-size:13pt" type="reset" value="Clear" name="RS"/>
                                                            </td>
                                                        </tr>
                                                    </table>
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
            Last Updated: 29 Nov 2013
        </div>

        <!-- This contains the hidden content for inline calls -->
        <div style='display:none'>
            <div id='inline_content' style='padding:10px; background:#fff;'>
                <p><strong>This content comes from a hidden element on this page.</strong></p>
            </div>
        </div>

    </body>
</html>