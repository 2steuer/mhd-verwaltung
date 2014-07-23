$Form

<% with $Booking %>

<h2>Artikel</h2>
<a href="{$Top.Link}addentry/$ID">Artikel hinzufügen</a>

<table class="record_list">
    <tr>
        <th>Artikel</th>
        <th>Anzahl</th>
        <th>Entfernen</th>
    </tr>

    <% loop Entries %>
        <tr class="$EvenOdd">
            <td>$Resource.Name</td>
            <td>$Count</td>
            <td class="icon_col"><a href="{$Top.Link}deleteentry/$ID"><img src="mysite/img/trash.png" alt="Eintrag entfernen" /></a></td>
        </tr>
    <% end_loop %>
</table>
<% end_with %>