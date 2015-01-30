$Form

<h2>Notwendige Prüfungstypen</h2>

<table id="checks_table">
<tr>
<th>Typ</th>
<th>Dienstleister</th>
<th>Bemerkung</th>
<th>Bearbeiten</th>
<th>Löschen</th>
<tr>
<% with Device %>
<% loop Checks %>
<tr class="$EvenOdd">
<td class="col1">{$Type.Name}</td>
<td class="col2">$Supplier.DropDownName</td>
<td class="col3">$Comment</td>
<td class="col4"><a href="{$Top.Link}editcheck/$ID"><img src="mysite/img/pencil.png" alt="Bearbeiten" /></a></td>
<td class="col4"><a href="{$Top.Link}deletecheck/$ID"><img src="mysite/img/trash.png" alt="Löschen" /></a></td>

</tr>
<% end_loop %>
<% end_with %>
</table>

<br />
<a href="{$Link}addcheck/{$Device.ID}">Prüfungstyp hinzufügen</a>
