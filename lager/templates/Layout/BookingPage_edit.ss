$Form

<% with $Booking %>

<h2>Artikel</h2>
<a href="{$Top.Link}addentry/$ID">Artikel hinzufügen</a>
<% if Top.ResourceMessage %>
    <br />
    <span class="notice">$Top.ResourceMessage</span>
<% end_if %>

<div id="quick_add_form">
<h3>Barcode scannen</h3>
    $Top.QuickEntryForm</div>


<form method="post" action="{$Top.Link}updateCounts/$ID">
<table class="resource_list" id="booking-entries-table">
    <thead>
    <tr>
        <th>Artikel</th>
        <th>Anzahl</th>
        <th>Entfernen</th>
    </tr>
    </thead>
<tbody id="entries-table-body">
    <% loop Entries %>
        <tr class="$EvenOdd" id="entry-$ID">
            <td class="name_col">$Resource.Name</td>
            <td class="count_col"><input type="number" value="$Count" name="counts[$ID]" /></td>
            <td class="icon_col"><a href="{$Top.Link}deleteentry/$ID"><img src="mysite/img/trash.png" alt="Eintrag entfernen" /></a></td>
        </tr>
    <% end_loop %>
</tbody>
    <tfoot>
    <tr>
        <td></td>
        <td><input type="submit" value="Speichern" /></td>
    </tr>
    </tfoot>
</table>
</form>
<% end_with %>
<h3>Vorgang buchen</h3>
<a href="{$Link}confirmbooking/$Booking.ID/e">Vorgang jetzt buchen</a>