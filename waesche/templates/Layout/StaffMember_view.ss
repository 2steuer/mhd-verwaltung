<% with Record %>
<table class="dev_details">
<tr>
<td>Name</td>
<td>$Name</td>
</tr>

<tr>
<td>Anmerkungen</td>
<td>$Notes</td>
</tr>

</table>


<% if Clothings %>

<h2>Kleidungsstücke</h2>

<table class="list_table">

<tr>
<th>Kleidungsstück</th>
<th>Größe</th>
<th>ID</th>
</tr>

<% loop Clothings %>
<tr class="$EvenOdd">
<td>$Type.Name</td>
<td>$Size</td>
<td>$IDCode</td>
</tr>
<% end_loop %>

</table>

<% else %>
<br />
Dieser Helfer hat keine Kleidung. <br />

<% end_if %>

<% end_with %>
<br />
<a href="$Link">Zurück</a>