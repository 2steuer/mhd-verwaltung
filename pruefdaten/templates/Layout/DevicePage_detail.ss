<a href="$Link">Zurück zur Übersicht</a>
<% with Device %>
	<h3>Allgemeine Informationen</h3>
	<table class="dev_details">
	<tr>
		<td class="col1">ID#</td>
		<td>$ID</td>
	</tr>
	<tr>
		<td>Bezeichnung</td>
		<td><b>$Name</b></td>
	</tr>
	<tr>
		<td>Bemerkungen</td>
		<td>$Description</td>
	</tr>
	<tr>
		<td>Seriennummer</td>
		<td>$Serial</td>
	</tr>
	<tr>
		<td>Barcode</td>
		<td>$Barcode</td>
	</tr>
	</table>

<% loop Checks %>
	<h2>$Type.Name</h2>

	<table class="dev_details">
	<tr>
	<td class="col1">Nächste Prüfung</td>
	<td class="$AlertClass">$NextCheck.Nice</td>
	</tr>
	<% if $Comment %>
	<tr>
	<td>Bemerkung</td>
	<td>$Comment</td>
	</tr>
	</table>

	<% end_if %>

	<h3>Dienstleister</h3>
	<table class="dev_details">
	<% with Supplier %>
	<tr>
	<td class="col1">Firma</td>
	<td><b>$Name</b></td>
	</tr>
	
	<tr>
	<td>Ansprechpartner</td>
	<td>$ContactName</td>
	</tr>

	<tr>
	<td>Addresse</td>
	<td>$Street<br />$PLZ $City</td>
	</tr>

	<tr>
	<td>Telefon</td>
	<td>$Phone</td>
	</tr>

	<tr>
	<td>Fax</td>
	<td>$Fax</td>
	</tr>

	<tr>
	<td>E-Mail</td>
	<td>$Email</td>
	</tr>

	<tr>
	<td>Web</td>
	<td>$Web</td>
	</tr>
	<% end_with %>
	</table>
	<h3>Vergangene Prüfungen</h3>
	<table class="checks_details">
		<tr>
		<th class="col1">Datum</th>
		<th class="col2">Bemerkungen</th>
		<th class="col3">Download Prüfbericht</th>
		<th class="col4">Eingetragen von</th>
		<th class="col5"></th>
		</tr>

		<% loop ActiveRecords %>
			<tr class="$EvenOdd">
			<td class="col1">$Date.Nice</td>
			<td class="col2">$Comment</td>
			<td class="col3"><% if $CheckDocument %><a href="$CheckDocument.Filename"><img src="mysite/img/folder.png" alt="Prüfbericht" /></a><% end_if %></td>
			<td class="col4">$Member.Surname, $Member.FirstName</td>
			<td class="col5"><a href="{$Top.Link}deletecheckrecord/$ID"><img src="mysite/img/trash.png" alt="Löschen" /></a></td>
			</tr>
		<% end_loop %>	
	</table>
	<br />
<a href="{$Top.Link}/addcheckrecord/{$Up.ID}/$ID">Prüfung eintragen</a>

<% end_loop %>
<% end_with %>
