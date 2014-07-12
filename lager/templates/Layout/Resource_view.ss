<% with Record %>
<table class="dev_details">
<tr>
<td class="col1">Name</td>
<td>$Name</td>
</tr>

<tr>
<td>Kategorie</td>
<td>$Category.Name</td>
</tr>

<tr>
<td>Beschreibung</td>
<td>$Description</td>
</tr>

<tr>
<td>Barcode</td>
<td>$Barcode</td>
</tr>

<tr>
<td>Bestand</td>
<td class="$WarningClass">$Quantity</td>
</tr>

<tr>
<td>Bild</td>
<td>$Picture.SetWidth(350)</td>
</tr>

</table>
<% end_with %>
<br />
<a href="$Link">Zurück</a>