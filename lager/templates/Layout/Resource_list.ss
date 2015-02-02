<% if ShowAdd %>
    <a href="{$Top.Link}add">$SingularName hinzufügen</a>
<% end_if %>

<form id="check_resource_form" target="_blank" method="post" action="{$Top.Link}barcodepdf">
<table class="record_list">
<tr>
	<th>Name</th>
    <th>Barcode</th>
	<th>Bestand</th>

	<% if ShowView %>
	<th>&nbsp;</th>
	<% end_if %>

	<% if ShowEdit %>
	<th>&nbsp;</th>
	<% end_if %>

	<% if ShowDelete %>
	<th>&nbsp;</th>
	<% end_if %>

    <!-- Checkbox Column -->
    <th></th>
</tr>

<% loop ActiveRecords %>
<tr class="$EvenOdd">
	<td class="col2">$Name</td>
    <td class="col2">$Barcode</td>

	<td class="col2 $WarningClass">$Quantity</td>
	<% if Top.ShowView %>
<td class="icon_col"><a href="{$Top.Link}view/$ID"><img src="mysite/img/clipboard.png" alt="Details" /></a></td>
	<% end_if %>

	<% if Top.ShowEdit %>
<td class="icon_col"><a href="{$Top.Link}edit/$ID"><img src="mysite/img/pencil.png" alt="Bearbeiten" /></a></td>
	<% end_if %>

	<% if Top.ShowDelete %>
<td class="icon_col"><a href="{$Top.Link}delete/$ID"><img src="mysite/img/trash.png" alt="Löschen" /></a></td>
	<% end_if %>
<td><input type="checkbox" name="SelectedResources[]" value="$ID" class="selectprintBox"/> </td>
</tr>
<% end_loop %>

</table>
</form>
<div id="print_actions">
    Wählen: <a href="#" id="all_link">Alle</a> | <a href="#" id="none_link">Keine</a>
</div>

<br />
Aufgaben:
<ul>
<% if ShowAdd %>
<li><a href="{$Top.Link}add">$SingularName hinzufügen</a></li>
<% end_if %>
    <li><a href="#" id="generate_barcode_pdf_link">Gewählte Barcodes drucken</a></li>
</ul>