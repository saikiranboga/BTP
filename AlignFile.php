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
                                require_once 'includes/' . $PHPMailer;
                                if (isset($_POST['B1'])) {

// Copied from http://www.php.net/manual/en/features.file-upload.php
                                    // Check $_FILES['S1']['error'] value.
//                                        header('Content-Type: text/plain; charset=utf-8');

                                    try {

                                        // Undefined | Multiple Files | $_FILES Corruption Attack
                                        // If this request falls under any of them, treat it invalid.
                                        if (
                                                !isset($_FILES['S1']['error']) ||
                                                is_array($_FILES['S1']['error'])
                                        ) {
                                            throw new RuntimeException('Invalid parameters.');
                                        }

                                        // Check $_FILES['S1']['error'] value.
                                        switch ($_FILES['S1']['error']) {
                                            case UPLOAD_ERR_OK:
                                                break;
                                            case UPLOAD_ERR_NO_FILE:
                                                throw new RuntimeException('No file sent.');
                                            case UPLOAD_ERR_INI_SIZE:
                                            case UPLOAD_ERR_FORM_SIZE:
                                                throw new RuntimeException('Exceeded filesize limit.');
                                            default:
                                                throw new RuntimeException('Unknown errors.');
                                        }

                                        // You should also check filesize here.
                                        if ($_FILES['S1']['size'] > 1000000) {
                                            throw new RuntimeException('Exceeded filesize limit.');
                                        }

                                        // DO NOT TRUST $_FILES['S1']['mime'] VALUE !!
                                        // Check MIME Type by yourself.
                                        $finfo = new finfo(FILEINFO_MIME_TYPE);
//                                                echo "<br/> finfo: " . $finfo->file($_FILES['S1']['tmp_name']) . "That's it<br/>";
                                        if (false === $ext = array_search(
                                                $finfo->file($_FILES['S1']['tmp_name']), array(
//                                                    'jpg' => 'image/jpeg',
//                                                    'png' => 'image/png',
//                                                    'gif' => 'image/gif',
                                            'txt' => 'text/plain',
                                                ), true
                                                )) {
                                            throw new RuntimeException('Invalid file format.');
                                        }

                                        // You should name it uniquely.
                                        // DO NOT USE $_FILES['S1']['name'] WITHOUT ANY VALIDATION !!
                                        // On this example, obtain safe unique name from its binary data.
                                        $filename = sha1_file($_FILES['S1']['tmp_name']);
                                        echo $filename . "<br/>";
                                        if (!move_uploaded_file(
                                                        $_FILES['S1']['tmp_name'], sprintf('./uploads/%s', $filename)
                                                )
                                        ) {
                                            throw new RuntimeException('Failed to move uploaded file.');
                                        }

                                        echo 'File is uploaded successfully.';
                                        exec("sh bash/processUpload.sh $filename > /dev/null &");
                                        $mail = new PHPMailer;
//$mail->isSendmail();                                  // Set email format to sendmail
                                        $mail->isSMTP();                                      // Set mailer to use SMTP
                                        $mail->Host = 'smtp.gmail.com:587';  // Specify main and backup server
                                        $mail->SMTPAuth = true;                               // Enable SMTP authentication
                                        $mail->Username = 'metagen.noreply@gmail.com';                            // SMTP username
                                        $mail->Password = 'metagennoreply';                           // SMTP password
                                        $mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted

                                        $mail->From = 'metagen.noreply@gmail.com';
                                        $mail->FromName = 'MetaGen';
                                        $mail->addAddress($_POST['email']);  // Add a recipient
//$mail->addAddress('ellen@example.com');               // Name is optional
//$mail->addReplyTo('metagen.noreply@gmail.com', 'MetaGen');
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');

                                        $mail->WordWrap = 50;                                 // Set word wrap to 50 characters
//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
                                        $mail->isHTML(true);                                  // Set email format to HTML

                                        $mail->Subject = 'MetaGen Query Result';
                                        $mail->Body = 'Result for query is at: http://localhost/ShowResult.php?q=' . $filename;
                                        $mail->AltBody = 'Result for query is at: http://localhost/ShowResult.php?q=' . $filename;

                                        if (!$mail->send()) {
                                            echo 'Message could not be sent.';
                                            echo 'Mailer Error: ' . $mail->ErrorInfo;
                                            exit;
                                        }
                                        echo 'Message has been sent';
                                    } catch (RuntimeException $e) {

                                        echo $e->getMessage();
                                    }
// Ends of copied
//                                        echo "Upload: " . $_FILES["S1"]["name"] . "<br/>";
//                                        echo "Type: " . $_FILES["S1"]["type"] . "<br/>";
//                                        echo "Size: " . $_FILES["S1"]["size"] . "<br/>";
//                                        echo "Stored in: " . $_FILES["S1"]["tmp_name"] . "<br/>";
//                                            if (file_exists("uploads/" . $_FILES["S1"]["name"])) {
//                                                echo $_FILES["S1"]["name"] . " already exists.<br/>";
//                                            } else {
//                                                move_uploaded_file($_FILES["S1"]["tmp_name"], "uploaded/" . $_FILES["S1"]["name"]);
//                                            }
//                                        }
//                                    }
                                } else {
                                    ?>
                                    <table width="100%" bgcolor="#F0F8FF">
                                        <tr>
                                            <td valign="top">
                                                <form name="form1" action="AlignFile.php" method="post" enctype="multipart/form-data" onsubmit="javascript:return checkform();">
                                                    <input type="hidden" name="mode" value="string"/>
                                                    <table width="100%">
                                                        <tr>
                                                            <td height="20">
                                                                Email id (Link to result will be sent on this email):
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <input type="email" name="email"/>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td height="20">
                                                                Please select input protein sequence file (<a href="#" onclick="openwin();"><b><u>Example</u></b></a>):&nbsp;
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <input type="file" name="S1"/>
                                                            </td>
                                                        </tr>
                                                        <tr>
    <!--                                                            <td>
                                                                    <textarea name="S1" style="width:99%; height:220px; overflow: auto; resize: none; margin: 0; border:1px solid #A1A1A1;"><?php
                                                            echo $query;
                                                            ?></textarea
                                                            </td>-->
                                                        </tr>

                                                        <tr>
                                                            <td align="center">
                                                                &nbsp &nbsp &nbsp &nbsp &nbsp
                                                                <input style="font-size:13pt" type="submit" value="Submit" name="B1"/>
                                                                &nbsp &nbsp &nbsp &nbsp &nbsp
                                                                <input style="font-size:13pt" type="reset" value="Clear" name="RB"/>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </form>
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