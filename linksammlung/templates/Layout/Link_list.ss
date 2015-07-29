

<% if ActiveRecords %>
<% if ShowAdd %>
<a href="{$Top.Link}add">$SingularName hinzufügen</a>&nbsp;
<% end_if %>


<table class="record_list">
<thead>
    <tr>
	<th>Bezeichnung</th>
	<th>Link</th>
	<% if ShowView %>
	<th>Details</th>
	<% end_if %>

	<% if ShowEdit %>
	<th>Bearbeiten</th>
	<% end_if %>

	<% if ShowDelete %>
	<th>Löschen</th>
	<% end_if %>

	<th>&nbsp;</th>
</tr>
</thead>

<% loop ActiveRecords %>
<tr class="$EvenOdd">
	<td class="col1">$Name</td>
	<td><a href="$Link">&raquo; aufrufen</a></td>

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

<% else %>
Keine $PluralName vorhanden.
<% if ShowAdd %>
<br />
<a href="{$Top.Link}add">$SingularName hinzufügen</a>&nbsp;
<% end_if %>

<% end_if %>
