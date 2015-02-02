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
        <td>Bestellnummer</td>
        <td>$OrderingNumber</td>
    </tr>

<tr>
<td>Bestand</td>
<td class="$WarningClass">$Quantity</td>
</tr>
    <tr>
        <td>Barcode</td>
        <td><a href="#" id="print_single_bc">drucken</a></td>
    </tr>

</table>

<% end_with %>

<form id="single_bc_form" target="_blank" method="post" action="{$Link}barcodepdf">
    <input type="hidden" name="SelectedResources[]" value="{$Record.ID}" />
</form>

<br />
<a href="$Link">Zurück</a>