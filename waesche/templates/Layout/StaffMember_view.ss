<% with Record %>
<table class="dev_details">
<tr>
<td>Name</td>
<td>$Name</td>
</tr>

    <tr>
        <td>Mitarbeiternummer</td>
        <td>$StaffNumber</td>
    </tr>

<tr>
<td>Anmerkungen</td>
<td>$Notes</td>
</tr>

</table>


<% if Clothings %>

<h2>Kleidungsstücke</h2>

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

<% loop Clothings %>
<tr class="$EvenOdd">
<td>$Type.Name</td>
<td>$Size</td>
<td>$IDCode</td>
<td class="icon_col"><% if $ChangeInProgress %><img src="mysite/img/out.png" alt="Änderung in Auftrag gegeben" /><% end_if %></td>
<td class="icon_col"><a href="{$Top.GenericPageLink(Clothing, 'view/')}{$ID}"><img src="mysite/img/clipboard.png" alt="Details" /></a></td>
<td class="icon_col"><a href="{$Top.GenericPageLink(Clothing, 'edit/')}{$ID}"><img src="mysite/img/pencil.png" alt="Bearbeiten" /></a></td>
    <td class="icon_col"><input type="checkbox" name="SelectPrint[]" class="selectprintBox" value="$ID"></td>
</tr>
<% end_loop %>

</table>

    <div id="print_actions">
        Wählen: <a href="#" id="all_link">Alle</a> | <a href="#" id="none_link">Keine</a>
    </div>


    Aufgaben:
    <ul>
        <% if ShowAdd %>
            <li><a href="{$Top.Link}add">$SingularName hinzufügen</a></li>
        <% end_if %>
        <li><a href="{$Top.GenericPageLink(Clothing, 'printuserlabels/')}{$Record.ID}" target="_blank">Kleidungslabels drucken</a></li>
        <li><a target="_blank" href="{$Top.Link}printconfirmation/{$Record.ID}">Bestätigung drucken</a></li>
        <li><a href="#" id="print_link">Gewählte Labels drucken</a></li>
        <li>Gewählte umlabeln auf <select name="StaffMemberID">
            <% loop $Top.StaffMembers %>
                <option value="$ID">$Name</option>
            <% end_loop %>
        </select> <a href="#" id="print_change_request">Auftrag erzeugen</a></li>
    </ul>


    <a href="$Link">Zurück</a>

</form>

<% else %>
<br />
Dieser Helfer hat keine Kleidung. <br />

<% end_if %>

<% end_with %>
<br />
