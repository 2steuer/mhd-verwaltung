<% if QuickSearchEnabled %>
<% if ActiveRecords %>
<div id="quicksearchform">$QuickSearchForm</div>
<% end_if %>
<% end_if %>

<% if CustomSearchForm %>
<div id="search_filter_form">
<h3>Kleidungsstücke filtern</h3>
$CustomSearchForm</div>
<% end_if %>

<% if ActiveRecords %>
<% if ShowAdd %>
<a href="{$Top.Link}add">$SingularName hinzufügen</a>&nbsp;
<% end_if %>


<form id="print_label_checkform" method="post" action="{$Link}printlabels" target="_blank">
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
</table>
</form>

<div id="print_actions">
Wählen: <a href="#" id="all_link">Alle</a> | <a href="#" id="none_link">Keine</a>
</div>

<br />
<% if ShowAdd %>
<a href="{$Top.Link}add">$SingularName hinzufügen</a>&nbsp;
<% end_if %>
<a href="#" id="print_link">Gewählte Labels drucken</a>

<% else %>
Keine $PluralName vorhanden.
<% if ShowAdd %>
<br />
<a href="{$Top.Link}add">$SingularName hinzufügen</a>&nbsp;
<% end_if %>

<% end_if %>
