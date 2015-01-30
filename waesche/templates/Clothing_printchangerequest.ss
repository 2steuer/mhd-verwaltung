<html>
	<% base_tag %>
	<head>
		<title>Änderungsauftrag</title>
	    <style type="text/css">
            #address {
                position: absolute;
                top: 32mm;
                left: 20mm;
                padding: 5mm;
                width: 75mm;
                height: 30mm;
            }

            #main {
                position: absolute;
                top: 87mm;
                left: 20mm;
            }

            #newstaff td {
                width: 150px;
            }

            #clothinglist td {
                padding-right: 4mm;
            }

	    </style>
    </head>



<body>

<div id="address">
Berendsen Textilservice <br />
Herr Klein <br />
Otto-Hahn-Straße 4 <br />
D-21509 Glinde <br  />
</div>

<div id="main">
    <h3>Änderung Zuordnung Dienstbekleidung</h3>
    Sehr geehrter Herr Klein, <br />
    Ich bitte Sie herzlich um die Änderung der Zuordnung folgender Kleidungsstücke:<br  /> <br />
    <table id="clothinglist">
        <tr>
            <th>Typ</th>
            <th>Größe</th>
            <th>Träger</th>
            <th>Träger-Nr</th>
            <th>ID</th>
        </tr>

        <% loop $Clothings %>
            <tr class="$EvenOdd">
                <td>$Type.Name</td>
                <td>$Size</td>
                <td>$Owner.Name</td>
                <td>$Owner.StaffNumber</td>
                <td>$IDCode</td>
            </tr>
        <% end_loop %>
    </table>
    <br />
    <br />
    <b>Bitte Träger ändern auf:</b>
    <table id="newstaff">
        <tr>
            <td>Name</td>
            <td><b>$NewStaffMember.Name</b></td>

        </tr>
        <tr>
            <td>Träger-Nr.</td>
            <td><b>$NewStaffMember.StaffNumber</b></td>
        </tr>
    </table>
    <br /><br />
    Nach erfolgter Änderung bitte ich um Rücksendung der Kleidung zu meinen Händen. <br /><br />
    Herzlichen Dank,<br />
    Mit freundlichen Grüßen,<br /><br /><br /><br />
    Louisa Panier
</div>

</body>
</html>