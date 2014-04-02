<?php
include 'sqlConnect.php';
$query = $_POST['S1'];
exec("echo \"$query\" > /home/saikiranboga/BTP/query");

//  ALWAYS USE 2>&1 IN EXEC WHILE DEBUGGING
$command = '/home/saikiranboga/BTP/blast+/bin/blastp -query /home/saikiranboga/BTP/query -db /home/saikiranboga/BTP/blast+/db/unannotated.fasta -outfmt=5';
$lay = 'cat /home/saikiranboga/BTP/temp.xml';
exec($command, $output, $status);

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
                            }
                        }
                    }
                }
            }
        }
    }
}
$sql = "select repr_element from repr_elements where element like('$Hit_def[0]')";
echo $sql . "<br/>";
$result = mysqli_query($db_con, $sql);

echo "<table>";
if (!($row = mysqli_fetch_array($result)))
    $row['repr_element'] = $Hit_def[0];
echo "<tr>";
echo "<td>" . $row['repr_element'] . "</td>";
echo "</tr>";
$sql = "select description from repr_fold where assession_number like('{$row['repr_element']}')";
echo $sql . "<br/>";
$result = mysqli_query($db_con, $sql);
while ($rows = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $rows['description'] . "</td>";
    echo "</tr>";
    if ($rows['description'] === 'NA')
        break;
    $sql = "select class from fold_type_class where fold_type like('{$rows['description']}')";
    echo $sql . "<br/>";
    $result = mysqli_query($db_con, $sql);
    while ($rowss = mysqli_fetch_array($result)) {
        echo "<tr>";
        echo "<td>" . $rowss['class'] . "</td>";
        echo "</tr>";
    }
}
echo "</table>";
?>
<div align='center'>
    <table  style='BORDER-RIGHT: #808080 1px solid; BORDER-LEFT: #808080 1px solid' cellSpacing='0' cellPadding='0' width='700' bgColor='#f0f8ff' id='table1'>
        <tr>
            <td style='BORDER-BOTTOM: #a1a1a1 1px solid' bgColor='#dff0ff' height='80'>
                <table id='table2'>
                    <tr>
                        <td>
                            <table width=700>
                                <tr>
                                    <td align=center>
                                        <font size=+2 face='times new roman'><b>PFP-FunDSeqE</b>:</font>
                                        <font size=+2 face='times new roman'> Predicting protein fold pattern with functional domain and sequential evolution information</font>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <tr><td vAlign='bottom' height='30'><p align='left'>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<font size=4pt face='times new roman'> <font face='times new roman'>|</font> <a target='_blank' href='../bioinf/PFP-FunDSeqE/Readme.htm'><font color='blue' face='times new roman'><u>Read Me</u></font></a> &nbsp;<font face='times new roman'>|</font> &nbsp;<a target='_blank' href='../bioinf/PFP-FunDSeqE/Data.htm'><font color='blue' face='times new roman'><u>Data</u></font></a> &nbsp;<font face='times new roman'>|</font> &nbsp;<a target='_blank' href='../bioinf/PFP-FunDSeqE/Citation.htm'><font color='blue' face='times new roman'><u>Citation</u></font></a> &nbsp;<font face='times new roman'>|</font> </td></tr></table></td></tr><tr><td>&nbsp</td></tr><tr><td align=left><font size=5pt face='times new roman'>Your input sequence(129aa) is:</font></td></tr><tr><td align=left><br><font face='times new roman'>>QuerySeq</font><br><font face='times new roman'>M</font><font face='times new roman'>F</font><font face='times new roman'>R</font><font face='times new roman'>Q</font><font face='times new roman'>C</font><font face='times new roman'>A</font><font face='times new roman'>K</font><font face='times new roman'>R</font><font face='times new roman'>Y</font><font face='times new roman'>A</font><font face='times new roman'>S</font><font face='times new roman'>S</font><font face='times new roman'>L</font><font face='times new roman'>P</font><font face='times new roman'>P</font><font face='times new roman'>N</font><font face='times new roman'>A</font><font face='times new roman'>L</font><font face='times new roman'>K</font><font face='times new roman'>P</font><font face='times new roman'>A</font><font face='times new roman'>F</font><font face='times new roman'>G</font><font face='times new roman'>P</font><font face='times new roman'>P</font><font face='times new roman'>D</font><font face='times new roman'>K</font><font face='times new roman'>V</font><font face='times new roman'>A</font><font face='times new roman'>A</font><font face='times new roman'>Q</font><font face='times new roman'>K</font><font face='times new roman'>F</font><font face='times new roman'>K</font><font face='times new roman'>E</font><font face='times new roman'>S</font><font face='times new roman'>L</font><font face='times new roman'>M</font><font face='times new roman'>A</font><font face='times new roman'>T</font><font face='times new roman'>E</font><font face='times new roman'>K</font><font face='times new roman'>H</font><font face='times new roman'>A</font><font face='times new roman'>K</font><font face='times new roman'>D</font><font face='times new roman'>T</font><font face='times new roman'>S</font><font face='times new roman'>N</font><font face='times new roman'>M</font><font face='times new roman'>W</font><font face='times new roman'>V</font><font face='times new roman'>K</font><font face='times new roman'>I</font><font face='times new roman'>S</font><font face='times new roman'>V</font><font face='times new roman'>W</font><font face='times new roman'>V</font><font face='times new roman'>A</font><font face='times new roman'>L</font><br><font face='times new roman'>P</font><font face='times new roman'>A</font><font face='times new roman'>I</font><font face='times new roman'>A</font><font face='times new roman'>L</font><font face='times new roman'>T</font><font face='times new roman'>A</font><font face='times new roman'>V</font><font face='times new roman'>N</font><font face='times new roman'>T</font><font face='times new roman'>Y</font><font face='times new roman'>F</font><font face='times new roman'>V</font><font face='times new roman'>E</font><font face='times new roman'>K</font><font face='times new roman'>E</font><font face='times new roman'>H</font><font face='times new roman'>A</font><font face='times new roman'>E</font><font face='times new roman'>H</font><font face='times new roman'>R</font><font face='times new roman'>E</font><font face='times new roman'>H</font><font face='times new roman'>L</font><font face='times new roman'>K</font><font face='times new roman'>H</font><font face='times new roman'>V</font><font face='times new roman'>P</font><font face='times new roman'>D</font><font face='times new roman'>S</font><font face='times new roman'>E</font><font face='times new roman'>W</font><font face='times new roman'>P</font><font face='times new roman'>R</font><font face='times new roman'>D</font><font face='times new roman'>Y</font><font face='times new roman'>E</font><font face='times new roman'>F</font><font face='times new roman'>M</font><font face='times new roman'>N</font><font face='times new roman'>I</font><font face='times new roman'>R</font><font face='times new roman'>S</font><font face='times new roman'>K</font><font face='times new roman'>P</font><font face='times new roman'>F</font><font face='times new roman'>F</font><font face='times new roman'>W</font><font face='times new roman'>G</font><font face='times new roman'>D</font><font face='times new roman'>G</font><font face='times new roman'>D</font><font face='times new roman'>K</font><font face='times new roman'>T</font><font face='times new roman'>L</font><font face='times new roman'>F</font><font face='times new roman'>W</font><font face='times new roman'>N</font><font face='times new roman'>P</font><font face='times new roman'>V</font><br><font face='times new roman'>V</font><font face='times new roman'>N</font><font face='times new roman'>R</font><font face='times new roman'>H</font><font face='times new roman'>I</font><font face='times new roman'>E</font><font face='times new roman'>H</font><font face='times new roman'>D</font><font face='times new roman'>D</font></td></tr><tr><td>&nbsp</td></tr><tr><td align=center><font size=5pt color='#56AA17' face='times new roman'>------- PFP-FunDSeqE Computation Result -------</td></tr>
        <tr><td>&nbsp</td></tr>
        <tr><td>
                <div  name="results" style="padding-left: 40px; background: white; border: solid black; overflow-y:scroll; max-height: 300px">
                    <?php //echo implode("\n", $output);?>
                </div>
        </tr>
        <tr><td align="center"><a href="index.php">HOME</a></td></tr>
        <tr><td>&nbsp</td></tr>
        <tr><td style='BORDER-TOP: #808080 1px solid' align='middle' bgColor='#dff0ff' height='50'><font size=4pt face='times new roman'>Contact @ <a href='mailto:hbshen@sjtu.edu.cn'><u>Hong-Bin</u></a></font></td></tr>
    </table>
</div>