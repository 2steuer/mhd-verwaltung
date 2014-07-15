<% with Record %>
<table class="dev_details">
<tr>
<td>Typ</td>
<td>$Type.Name</td>
</tr>

<tr>
<td>Größe</td>
<td>$Size</td>
</tr>

<tr>
<td>Standort</td>
<td>
<% if Owner %>
	<a href="{$Top.GenericPageLink(StaffMember, 'view/')}{$Owner.ID}">$Owner.Name</a>
<% else %>
	Lager
<% end_if %>
</td>
</tr>

<tr>
<td>ID</td>
<td>$IDCode</td>
</tr>

<tr>
<td>Anmerkungen</td>
<td>$Notes</td>
</tr>


</table>
<% end_with %>


<br />
<a href="$Link">Zurück</a>