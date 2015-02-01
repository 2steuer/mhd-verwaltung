<% if MarkedClothes %>


<form id="print_label_checkform" method="post" action="{$Top.GenericPageLink(Clothing, 'doclothingaction')}" target="_blank">
    <input type="hidden" name="redirect-action" value="" id="form-destination" />

<table class="list_table">

<tr>
<th>Kleidungsstück</th>
<th>Größe</th>
<th>ID</th>
    <th>&nbsp;</th>
    <th>Details</th>
    <th>Bearb.</th>
    <th>&nbsp;</th>
</tr>

<% loop MarkedClothes %>
<tr class="$EvenOdd">
<td>$Type.Name</td>
<td>$Size</td>
<td>$IDCode</td>
    <td class="icon_col"><% if $ChangeInProgress %><img src="mysite/img/out.png" alt="Änderung in Auftrag gegeben" /><% end_if %></td>
    <td class="icon_col"><a href="{$Top.ClothingPageLink('view/')}{$ID}"><img src="mysite/img/clipboard.png" alt="Details" /></a></td>
    <td class="icon_col"><a href="{$Top.ClothingPageLink('edit/')}{$ID}"><img src="mysite/img/pencil.png" alt="Bearbeiten" /></a></td>
    <td class="icon_col"><input type="checkbox" name="SelectPrint[]" class="selectprintBox" value="$ID"></td>
</tr>
<% end_loop %>

</table>
<div id="print_actions">
    Wählen: <a href="#" id="all_link">Alle</a> | <a href="#" id="none_link">Keine</a>
</div>


<br />
    Aufgaben:
    <ul>
        <li><a href="#" id="print_link">Gewählte Labels drucken</a></li>
        <li>Gewählte umlabeln auf <select name="StaffMemberID">
            <% loop $Top.StaffMembers %>
                <option value="$ID">$Name</option>
            <% end_loop %>
        </select> <a href="#" id="print_change_request">Auftrag erzeugen</a></li>
        <li><a href="#" id="remove_marked">Gewählte von der Merkliste löschen</a></li>
    </ul>



    </form>
<% else %>
<br />
Keine Kleidung auf der Merkliste.
<% end_if %>
