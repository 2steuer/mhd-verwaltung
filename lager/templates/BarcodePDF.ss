<html>
<head>
    <title>Barcodes</title>
    <style type="text/css">
        .a-page {
            text-align: center;
            width: 62mm;
            height: 29mm;
            padding: 3mm;

        }

        .articleName {
            font-size: 12pt;
            font-weight: bold;
        }
    </style>
</head>

<body>
<% loop Articles %>
<div class="a-page">
    <barcode code="$RealBarcode" type="EAN13" size="1" height="0.5" />
    <div class="articleName">$Name</div>
</div>
<% end_loop %>
</body>
</html>