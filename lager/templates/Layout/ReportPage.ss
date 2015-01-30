$TimeSpanSelectionForm


<% if $ShowReport %>
    <h2>Kostenstelle: $CostCenter.Name ($Start - $End)</h2>
    <table class="record_list" style="width: 400px;">
        <tr>
            <th>Artikel</th>
            <th>Menge</th>
        </tr>

        <% loop $ReportLines %>
            <tr class="$EvenOdd">
                <td>$Resource.Name</td>
                <td style="text-align: center; width: 50px;">$Count</td>
            </tr>
        <% end_loop %>
    </table>
<% end_if %>