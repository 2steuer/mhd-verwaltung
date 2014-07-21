<% if StockClothing %>

<div id="search_filter_form">
<h3>Kleidungsstücke filtern</h3>
$CustomSearchForm</div>

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
<br />
<a href="{$Top.PrintLabelsLink}" target="_blank">Kleidungslabels drucken</a>
<% else %>
<br />
Keine Kleidung im Lager.
<% end_if %>
