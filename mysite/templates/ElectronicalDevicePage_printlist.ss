<!DOCTYPE html>

<html>
    <head>
        <% base_tag %>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <title>VDE-Geräteliste &laquo; {$SiteConfig.SiteTitle}</title>

        <link rel="stylesheet" type="text/css" href="mysite/css/normalize.min.css" />
        <link rel="stylesheet/less" type="text/css" href="mysite/css/format.less" />

        <script type="text/javascript" src="mysite/js/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="mysite/js/modernizr-2.6.2.min.js"></script>
        <script type="text/javascript" src="mysite/js/less-1.3.3.min.js"></script>
    </head>

<body class="printlist">
<h1>Geräteliste MHD</h1>
<% loop Places %>
    <% if $Devices %>
<h2>Ort: $Name</h2>
<div class="printlist_description">$Description</div>
    <table class="printlist_table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Bezeichnung</th>
            <th>Bemerkungen</th>
            <th>Barcode</th>
            <th>Check</th>
        </tr>
        </thead>

        <% loop Devices %>
            <tr>
                <td class="id_td">$ID</td>
                <td class="name_td">$Name</td>
                <td class="desc_td">$Description</td>
                <td class="barcode_td">$Barcode</td>
                <td class="check_td">&nbsp;</td>
            </tr>
        <% end_loop %>
    </table>
    <% end_if %>
<% end_loop %>
</body>
</html>