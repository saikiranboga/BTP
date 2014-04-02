<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="keywords" content="GENE, GENES, BIOLOGY, BIOINFORMATICS, GENOME, PROTEIN, GENOMICS, ASIA," />
        <meta name="description" content="tdicting annotations of unannotated proteins from metagenomic datasets" />
        <link rel="shortcut icon" href="images/favicon.ico">
        <title>Annotation prediction-Home </title>
        <script>
            //$(document).ready(function() {
            $(".inline").colorbox({inline: true});
            //    });
        </script>

        <style>
            #NCBI_results{
                border:none;
                border-collapse: collapse;
            }

            #NCBI_results td {
                border-left: 1px solid #000;
                border-right: 1px solid #000;
                padding-right: 10px;
                padding-left: 10px;
            }

            #NCBI_results td:first-child {
                border-left: none;
            }

            #NCBI_results td:last-child {
                border-right: none;
            }

            #NCBI_results th {
                border-left: 1px solid #000;
                border-right: 1px solid #000;
                border-bottom: 1px solid #000;
                padding-right: 10px;
                padding-left: 10px;
            }

            #NCBI_results th:first-child {
                border-left: none;
            }

            #NCBI_results th:last-child {
                border-right: none;
            }
        </style>
    </head>

    <?php
//        if (isset($_GET['q'])) {
//            $query = $_get['q'];
//            exec("echo \"$query\" > /home/saikiranboga/BTP/query");
//            test for remote NCBI data base search
//$command = '/home/saikiranboga/BTP/blast+/bin/blastp -remote -query /home/saikiranboga/BTP/query -db nr -outfmt 5';
//exec($command, $output, $status);
// avoid blast+ search, read result from file
    $lay = 'cat /home/saikiranboga/BTP/tmp2.xml';
    exec($lay, $output, $status);

    $xmlStr = implode("\n", $output);
    $xml = simplexml_load_string($xmlStr);

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
                                    $Hit_accession[] = $qgen->Hit_accession;
                                    $Hit_id[] = $qgen->Hit_id;
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
    echo "Significant Alignments: ".count($Hit_def);
    $scoreLimit = 100;
    if ($Hsp_score[0] > $scoreLimit) {
        ?>
        <table id="NCBI_results" width="100%">
            <tr>
                <th>Annotation</th>
                <th>Score (Bits)</th>
                <th>E-Value</th>
            </tr>
            <?php
            for ($i = 0; $i < count($Hit_def); $i++) {
                if ($Hsp_score[$i] > $scoreLimit) {
                    $accession = explode("|", $Hit_id[$i]);
                    $sequence = "<a href=\"http://www.ncbi.nlm.nih.gov/protein/$accession[1]\" >$accession[2]|$accession[3]|</a>&nbsp;&nbsp;$Hit_def[$i]";
                    if (strlen($sequence) - strlen($accession[1]) > 140)
                        $sequence = substr($sequence, 0, 140 + strlen($accession[1])) . "...";
                    echo "<td><pre>$sequence" . '<a class="inline" href="#inline_content_NCBI' . $i . '">[+]</a></pre>';

                    echo "<div style='display:none;max-width: 800px;text-overflow: ellipsis;'>
                            <div id='inline_content_NCBI" . $i . "' style='padding:10px; background:#fff;'>
                                <p><PRE>>" . $Hit_def[$i];
                    echo "<br/>Length = " . $Hit_len[$i] . "<br/>";
                    echo "<br/>Score = " . $Hsp_bitScore[$i] . " bits (" . $Hsp_score[$i] . ") ";
                    echo "Expect = " . trunc((double) $Hsp_evalue[$i], 2) . ".";
                    echo "<br/>Identities = " . $Hsp_identity[$i] . "/" . $Hsp_alignLen[$i] . " (" . (round($Hsp_identity[$i] / $Hsp_alignLen[$i], 2) * 100) . "%) ";
                    echo "Positives = " . $Hsp_positive[$i] . "/" . $Hsp_alignLen[$i] . "(" . (round($Hsp_positive[$i] / $Hsp_alignLen[$i], 2) * 100) . "%) ";
                    echo "Gaps = " . $Hsp_gaps[$i] . "/" . $Hsp_alignLen[$i] . "(" . (round($Hsp_gaps[$i] / $Hsp_alignLen[$i], 2) * 100) . "%) ";
                    echo "<br/><br/>Query  " . $Hsp_qseq[$i];
                    echo "<br/>       " . $Hsp_midline[$i];
                    echo "<br/>Sbjct  " . $Hsp_hseq[$i];
                    echo "<br/><br/>Representative Sequence: " . $repr_element[$i] . "</PRE>";
                    echo "</p>
                            </div>
                          </div>";

                    echo'</td>';
                    echo "<td>" . round((double) $Hsp_bitScore[$i], 2) . "</td>";
                    echo "<td>" . trunc((double) $Hsp_evalue[$i], 2) . "</td>";
                    echo "</tr>";
                }
            }
            ?>
        </table>
        <?
    } else {
        echo "<p> No significant hits found in NCBI database</p>";
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
</html>