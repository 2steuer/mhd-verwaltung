<% if StockClothing %>

<table class="list_table">

<tr>
<th>Kleidungsstück</th>
<th>Größe</th>
<th>ID</th>
</tr>

<% loop StockClothing %>
<tr class="$EvenOdd">
<td>$Type.Name</td>
<td>$Size</td>
<td>$IDCode</td>
</tr>
<% end_loop %>

</table>

<% else %>
<br />
Keine Kleidung im Lager.
<% end_if %>
