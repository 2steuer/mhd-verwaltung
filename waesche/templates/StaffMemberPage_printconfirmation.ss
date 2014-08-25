<html>
	<% base_tag %>
	<head>
		<title>Bestätigung von $StaffMember.Name</title>
	</head>

<body>

<h1>Bestätigung von $StaffMember.Name</h1>

<table class="dev_details">
    <tr>
        <td>Name</td>
        <td>$StaffMember.Name</td>
    </tr>
<% if $StaffMember.Notes %>
    <tr>
        <td>Anmerkungen</td>
        <td>$StaffMember.Notes</td>
    </tr>
<% end_if %>
</table>

<h2>Kleidungsstücke</h2>

<table class="list_table">

    <tr>
        <th>Kleidungsstück</th>
        <th>Größe</th>
        <th>ID</th>
    </tr>

    <% loop $StaffMember.Clothings %>
        <tr class="$EvenOdd">
            <td>$Type.Name</td>
            <td>$Size</td>
            <td>$IDCode</td>
        </tr>
    <% end_loop %>
</table>

<div class="confirmation_text">$ConfirmationText</div>

</body>
</html>