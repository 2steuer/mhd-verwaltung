<table id="type_table">

<tr>
<th>Name</th>
<th>Beschreibung</th>
<th>Bearbeiten</th>
<th>Löschen</th>
</tr>

<% loop CheckTypes %>
<tr class="$EvenOdd">
<td class="col1">$Name</td>
<td clsas="col2">$Description</td>
<td class="col3"><a href="{$Top.Link}edit/$ID"><img src="mysite/img/pencil.png" alt="Bearbeiten" /></a></td>
<td class="col4"><a href="{$Top.Link}delete/$ID"><img src="mysite/img/trash.png" alt="Löschen" /></a></td>
</tr>
<% end_loop %>

</table>
<br />
<a href="{$Link}add/">Prüfungstyp hinzufügen</a>