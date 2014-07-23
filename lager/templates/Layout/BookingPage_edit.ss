$Form

<% with $Booking %>

<h2>Artikel</h2>
<a href="{$Top.Link}addentry/$ID">Artikel hinzufügen</a>
<% if Top.ResourceMessage %>
    <br />
    <span class="notice">$Top.ResourceMessage</span>
<% end_if %>


<form method="post" action="{$Top.Link}updateCounts/$ID">
<table class="resource_list">
    <tr>
        <th>Artikel</th>
        <th>Anzahl</th>
        <th>Entfernen</th>
    </tr>

    <% loop Entries %>
        <tr class="$EvenOdd">
            <td>$Resource.Name</td>
            <td class="count_col"><input type="number" value="$Count" name="counts[$ID]" /></td>
            <td class="icon_col"><a href="{$Top.Link}deleteentry/$ID"><img src="mysite/img/trash.png" alt="Eintrag entfernen" /></a></td>
        </tr>
    <% end_loop %>
    <tr>
        <td></td>
        <td><input type="submit" value="Speichern" /></td>
    </tr>
</table>
</form>
<% end_with %>