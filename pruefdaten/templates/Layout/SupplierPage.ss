<table id="supplier_table">

<tr>
<th>Firma</th>
<th>Ansprechpartner</th>
<th>Bearbeiten</th>
<th>Löschen</th>
</tr>

<% loop Suppliers %>
<tr class="$EvenOdd">
<td class="col1">$Name</td>
<td clsas="col2">$ContactName</td>
<td class="col3"><a href="{$Top.Link}edit/$ID"><img src="mysite/img/pencil.png" alt="Bearbeiten" /></a></td>
<td class="col4"><a href="{$Top.Link}delete/$ID"><img src="mysite/img/trash.png" alt="Löschen" /></a></td>
</tr>
<% end_loop %>

</table>
<br />
<a href="{$Link}add/">Dienstleister hinzufügen</a>