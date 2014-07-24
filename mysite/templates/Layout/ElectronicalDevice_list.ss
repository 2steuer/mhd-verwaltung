<a href="{$Top.Link}add">$SingularName hinzufügen</a>&nbsp;<a href="{$Top.Link}printlist" target="_blank">Liste drucken</a>
<table class="record_list">
<tr>
	<th>Name</th>
	<th>Standort</th>

	<% if ShowView %>
	<th>Details</th>
	<% end_if %>

	<% if ShowEdit %>
	<th>Bearbeiten</th>
	<% end_if %>

	<% if ShowDelete %>
	<th>Löschen</th>
	<% end_if %>
</tr>

<% loop ActiveRecords %>
<tr class="$EvenOdd">
	<td class="col1">$Name</td>

	<td class="col2">$Place.Name</td>
	<% if Top.ShowView %>
<td class="icon_col"><a href="{$Top.Link}view/$ID"><img src="mysite/img/clipboard.png" alt="Details" /></a></td>
	<% end_if %>

	<% if Top.ShowEdit %>
<td class="icon_col"><a href="{$Top.Link}edit/$ID"><img src="mysite/img/pencil.png" alt="Bearbeiten" /></a></td>
	<% end_if %>

	<% if Top.ShowDelete %>
<td class="icon_col"><a href="{$Top.Link}delete/$ID"><img src="mysite/img/trash.png" alt="Löschen" /></a></td>
	<% end_if %>

</tr>
<% end_loop %>

</table>
<% if ShowAdd %>
<br />
<a href="{$Top.Link}add">$SingularName hinzufügen</a>
<% end_if %>