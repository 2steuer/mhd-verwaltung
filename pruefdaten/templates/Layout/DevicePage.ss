<div id="barcodeform">$BarcodeSearchForm</div>
<% loop Categories %>

<h2>$Name</h2>
<% if ActiveDevices %>

<table class="deviceTable">
<tr>
<th>Gegenstand</th>
<th>Nächste Prüfung</th>
<th>Details</th>
<th>Prüfung eintragen</th>
<th>Bearbeiten</th>
<th>Löschen</th>
</tr>

<% loop Devices %>
<tr class="$EvenOdd">
<td class="col1">$Name</td>
<td class="col2">
	<% loop Checks %>
	<div><span class="$AlertClass">$NextCheck.Nice</span> ($Type.Name)</div>
	<% end_loop %>
</td>
<td class="col3"><a href="{$Top.Link}detail/$ID"><img src="mysite/img/clipboard.png" alt="Details" /></a></td>
<td class="col3"><a href="{$Top.Link}addcheckrecord/$ID"><img src="mysite/img/check.png" alt="Prüfung eintragen" /></a></td>
<td class="col3"><a href="{$Top.Link}edit/$ID"><img src="mysite/img/pencil.png" alt="Bearbeiten" /></a></td>
<td class="col3"><a href="{$Top.Link}delete/$ID"><img src="mysite/img/trash.png" alt="Löschen" /></a></td>
</tr>
<% end_loop %>

</table>

<% end_if %>
<br />
<a href="{$Top.Link}adddevice/$ID">Gerät hinzufügen</a>

<% end_loop %>