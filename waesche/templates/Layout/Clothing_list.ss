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


<form id="print_label_checkform" method="post" action="{$Link}doclothingaction" target="_blank">
    <input type="hidden" name="redirect-action" value="" id="form-destination" />
<table class="record_list">
<thead>
    <tr>
	<th>Typ</th>
	<th>Größe</th>
	<th>Standort</th>
	<th>ID</th>
    <th>&nbsp;</th>
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
	<td class="col1">{$Type.Name}</td>
	<td>$Size</td>
	<td>$Owner.Name</td>

	<td>$IDCode</td>

    <td class="icon_col"><% if $ChangeInProgress %><img src="mysite/img/out.png" alt="Änderung in Auftrag gegeben" /><% end_if %></td>

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


<div id="print_actions">
Wählen: <a href="#" id="all_link">Alle</a> | <a href="#" id="none_link">Keine</a>
</div>

<br />
    Aufgaben:
    <ul>
<% if ShowAdd %>
<li><a href="{$Top.Link}add">$SingularName hinzufügen</a></li>
<% end_if %>
<li><a href="#" id="print_link">Gewählte Labels drucken</a></li>
    <li>Gewählte umlabeln auf <select name="StaffMemberID">
    <% loop $StaffMembers %>
        <option value="$ID">$Name</option>
    <% end_loop %>
    </select> <a href="#" id="print_change_request">Auftrag erzeugen</a></li>
        <li><a href="#" id="add_marked">Gewählte zur Merkliste hinzufügen</a></li>
    </ul>
</form>
<% else %>
Keine $PluralName vorhanden.
<% if ShowAdd %>
<br />
<a href="{$Top.Link}add">$SingularName hinzufügen</a>&nbsp;
<% end_if %>

<% end_if %>
