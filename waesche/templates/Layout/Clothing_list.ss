<% if QuickSearchEnabled %>
<div id="quicksearchform">$QuickSearchForm</div>
<% end_if %>

<% if ActiveRecords %>
<table class="record_list">
<tr>
	<th>Typ</th>
	<th>Größe</th>
	<th>Standort</th>
	<th>ID</th>

	<% if ShowView %>
	<th>Details</th>
	<% end_if %>

	<% if ShowEdit %>
	<th>Bearbeiten</th>
	<% end_if %>

	<% if ShowDelete %>
	<th>Löschen</th>
	<% end_if %>

	<th>Label</th>
</tr>

<form id="print_label_checkform" method="post" action="printlabels">
<% loop ActiveRecords %>
<tr class="$EvenOdd">
	<td class="col1">{$Type.Name}</td>
	<td>$Size</td>
	<td>
	<% if Owner %>
	$Owner.Name
	<% else %>
	Lager
	<% end_if %>
	</td>

	<td>$IDCode</td>

	<% if Top.ShowView %>
<td class="icon_col"><a href="{$Top.Link}view/$ID"><img src="mysite/img/clipboard.png" alt="Details" /></a></td>
	<% end_if %>

	<% if Top.ShowEdit %>
<td class="icon_col"><a href="{$Top.Link}edit/$ID"><img src="mysite/img/pencil.png" alt="Bearbeiten" /></a></td>
	<% end_if %>

	<% if Top.ShowDelete %>
<td class="icon_col"><a href="{$Top.Link}delete/$ID"><img src="mysite/img/trash.png" alt="Löschen" /></a></td>
	<% end_if %>

	<td class="icon_col"><input type="checkbox" name="SelectPrint[]" class="selectprintBox" value="$ID"></td>

</tr>
<% end_loop %>
</form>

</table>

<div id="print_actions">
Wählen: <a href="#" id="all_link">Alle</a> | <a href="#" id="none_link">Keine</a>
</div>

<% if ShowAdd %>
<br />
<a href="{$Top.Link}add">$SingularName hinzufügen</a>
<% end_if %>

<% else %>
Keine $PluralName vorhanden.

<% end_if %>
