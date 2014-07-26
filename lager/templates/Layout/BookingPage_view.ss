<% with Booking %>
<h3>Details zur Buchung</h3>
    <table class="dev_details">
        <tr>
            <td class="col1">Datum</td>
            <td>$Date.Nice</td>
        </tr>
        <tr>
            <td>Typ</td>
            <td><% if Direction = 'in' %>Wareneingang<% else %>Warenausgang<% end_if %></td>
        </tr>
        <tr>
            <td>Bemerkungen</td>
            <td>$Comment</td>
        </tr>
    </table>
    <% if Entries %>
        <h3>Artikel</h3>
        <table class="resource_list">
            <tr>
                <th>Artikel</th>
                <th>Anzahl</th>
            </tr>

            <% loop Entries %>
                <tr class="$EvenOdd">
                    <td>$Resource.Name</td>
                    <td class="count_col">$Count</td>
                </tr>
            <% end_loop %>
        </table>
    <% else %>
        <br />
    Keine Artikel im Vorgang.
    <% end_if %>

<% end_with %>