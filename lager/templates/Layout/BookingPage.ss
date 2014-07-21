<h2>Offene Vorgänge</h2>
<a href="{$Link}new">Neuen Vorgang erstellen</a>
<% if OpenBookings %>
<table class="record_list">
<tr>
	<th class="icon_col">E/A</th>
	<th>Datum</th>
	<th>Kostenstelle</th>
	<th>Benutzer</th>
	<th class="icon_col">Bearbeiten</th>
	<th class="icon_col">Buchen</th>
	<th class="icon_col">Löschen</th>
</tr>

<% loop OpenBookings %>
<tr>
<td><img src="mysite/img/{$Direction}.png" alt="$Direction" /></td>
<td>$Date.Nice</td>
<td>$CostCenter.Name</td>
<td>$Member.Surname, $Member.FirstName</td>
<td><a href="{$Top.Link}edit/$ID"><img src="mysite/img/pencil.png" alt="Bearbeiten" /></a></td>
<td><a href="{$Top.Link}confirm/$ID"><img src="mysite/img/check.png" alt="Buchen" /></a></td>
<td><a href="{$Top.Link}delete/$ID"><img src="mysite/img/trash.png" alt="Löschen" /></a></td>
</tr>
<% end_loop %>

</table>
<% else %>
<br />
Keine offenen Vorgänge.
<% end_if %>

<h2>Gebuchte Vorgänge</h2>
<% if BookedBookings %>
<table class="record_list">
<tr>
	<th class="icon_col">E/A</th>
	<th>Datum</th>
	<th>Kostenstelle</th>
	<th>Benutzer</th>
	<th class="icon_col">Rückbuchen</th>
</tr>

<% loop OpenBookings %>
<tr>
<td><img src="mysite/img/{$Direction}.png" alt="$Direction" /></td>
<td>$Date.Nice</td>
<td>$CostCenter.Name</td>
<td>$Member.Surname, $Member.FirstName</td>
<td><a href="{$Top.Link}unbook/$ID"><img src="mysite/img/unbook.png" alt="Buchung Rückgängig" /></a></td>
</tr>
<% end_loop %>

</table>
<% else %>
Keine geschlossenen Vorgänge.
<% end_if %>