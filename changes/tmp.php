<?php
//        if (isset($_GET['q'])) {
//            $query = $_get['q'];
//            exec("echo \"$query\" > /home/vivek/BTPWork/query");

//            test for remote NCBI data base search
$command = '/home/vivek/BTPWork/blast+/bin/blastp -remote -query /home/vivek/BTPWork/query -db nr -outfmt 5';
exec($command, $output, $status);

// avoid blast+ search, read result from file
//$lay = 'cat /home/vivek/BTPWork/tmp2.xml';
//exec($lay, $output, $status);

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
$scoreLimit = 100;
if ($Hsp_score[0] > $scoreLimit) {
    ?>
    <pre>
                    <table>
                        <tr>
                            <th>Sequences producing significant alignment</th>
                            <th>Score (Bits)</th>
                            <th>E-Value</th>
                        </tr>
            <?php
            for ($i = 0; $i < count($Hit_def); $i++) {
                if ($Hsp_score[$i] > $scoreLimit) {
                    $accession = explode("|", $Hit_id[$i]);
                    $sequence = "<a href=\"http://www.ncbi.nlm.nih.gov/protein/$accession[1]\" >$accession[2]|$accession[3]|</a>&nbsp;&nbsp;$Hit_def[$i]";
                    if (strlen($sequence) - strlen($accession[1]) > 150)
                        $sequence = substr($sequence, 0, 150 + strlen($accession[1])) . "...";
                    echo "<td>$sequence" . '<a onclick="showAlign(\'' . $Hsp_qseq[$i] . '\',\'' . $Hsp_midline[$i] . '\',\'' . $Hsp_qseq[$i] . '\')" href=#>[+]</a></td>';
                    echo "<td>" . round((double) $Hsp_bitScore[$i], 2) . "</td>";
                    echo "<td>" . trunc((double) $Hsp_evalue[$i], 2) . "</td>";
                    echo "</tr>";
                }
            }
            ?>
                    </table>
    </pre>
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
