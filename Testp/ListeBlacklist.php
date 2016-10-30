<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="Resources/CSS/Style.css"/>
    </head>
    <body id="IPsource">
        <?php include './Header.php';?>
        <?php include './Menu.php';?>
        <form action="IPSourceLapstimecible.php" method="POST">
            <table aling="center" width="255" cellspacing="2" cellpadding="2" border="0">
                <tr>
                    <td colspan="2" align="center" bgcolor="#cccccc">FIND IP BY TIME</td>
                </tr>
                <tr><td> </td></tr>
                <tr>
                    <td aling="right">IP Source</td>
                    <td><input type="text" name="ipsrc" id="ipsrc" size="19"/></td>
                </tr>
                <tr>
                    <td aling="right">IP Visiteur</td>
                    <td><input type="text" name="ipdst" id="ipdst" size="19"/></td>
                </tr>
                <tr>
                    <td aling="right">DATE Start</td>
                    <td><input type="date" name="datestart" id="datestart" size="19"/></td>
                </tr>
                <tr>
                    <td aling="right">TIME Start</td>
                    <td><input type="time" name="timestart" id="timestart" size="19"/></td>
                </tr>
                <tr>
                    <td aling="right">DATE End</td>
                    <td><input type="date" name="dateend" id="dateend" size="19"/></td>
                </tr>
                <tr>
                    <td aling="right">TIME End</td>
                    <td><input type="time" name="timeend" id="timeend" size="19"/></td>
                </tr>
                <tr>
                    <br>
                    <td colspan="2" aling="center"><input type="submit" value="Find IP"/></td>
                </tr>
            </table>
        </form>
    </body>
</html>

