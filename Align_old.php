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
        </script>
    </head>
    <body>
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

                                        <form name="form1" action="model.php" method="post" enctype="multipart/form-data" onsubmit="javascript:return checkform();">
                                            <input type="hidden" name="mode" value="string">


                                            <tr>
                                                <td height="20">Input the protein sequence (<a href="#"onclick="openwin();"><b><u>Example</u></b></a>):&nbsp;</td>
                                            </tr>	

                                            <tr>
                                                <td style="padding-top:0px">
                                                    <textarea rows="2" name="S1" cols="20" style="width:100%; height:220px; border:1px solid #A1A1A1;" >Enter your sequence here</textarea>
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
    </body>
</html>