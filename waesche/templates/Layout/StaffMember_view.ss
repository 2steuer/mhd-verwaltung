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
<th>Details</th>
</tr>

<% loop Clothings %>
<tr class="$EvenOdd">
<td>$Type.Name</td>
<td>$Size</td>
<td>$IDCode</td>
<td class="icon_col"><a href="{$Top.GenericPageLink(Clothing, 'view/')}{$ID}"><img src="mysite/img/clipboard.png" alt="Details" /></a></td>
</tr>
<% end_loop %>

</table>

<% else %>
<br />
Dieser Helfer hat keine Kleidung. <br />

<% end_if %>

<% end_with %>
<br />
<a href="$Link">Zurück</a> &nbsp; <a href="{$Top.GenericPageLink(Clothing, 'printuserlabels/')}{$Record.ID}" target="_blank">Kleidungslabels drucken</a>