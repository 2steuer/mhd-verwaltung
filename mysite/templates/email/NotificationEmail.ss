<html>
<head>
	

	<style type="text/css">
tr.odd {
	background-color: lightgrey;
}

h1 {
	font-size: 18px;
}
	</style>
</head>

<body>
Hallo $Member.FirstName $Member.Surname, <br />
Folgende Geräte bedürfen demnächst einer Prüfung.<br />

<% if UrgentChecks %>
<h1>Dringende Prüfungen</h1>

<table>
<tr>
<th>Gerät</th>
<th>Kategorie</th>
<th>Prüfungstyp</th>
<th>Fällig am</th>
</tr>

<% loop UrgentChecks %>
<tr class="$EvenOdd">
<td>$Device.Name</td>
<td>$Device.Category.Name</td>
<td>$Type.Name</td>
<td>$NextCheck.Nice</td>
</tr>
<% end_loop %>
</table>
<% end_if %>

<% if OtherChecks %>
<h1>Bald fällige Prüfungen</h1>
<table>
<tr>
<th>Gerät</th>
<th>Kategorie</th>
<th>Prüfungstyp</th>
<th>Fällig am</th>
</tr>

<% loop OtherChecks %>
<tr class="$EvenOdd">
<td>$Device.Name</td>
<td>$Device.Category.Name</td>
<td>$Type.Name</td>
<td>$NextCheck.Nice</td>
</tr>

<% end_loop %>
</table>
<% end_if %>
</body>
</html>