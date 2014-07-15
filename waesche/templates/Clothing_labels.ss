<html>
	<% base_tag %>
	<head>
		<title>Labels drucken</title>
	</head>

        <link rel="stylesheet" type="text/css" href="mysite/css/normalize.min.css" />
        <link rel="stylesheet/less" type="text/css" href="mysite/css/format.less" />

        <script type="text/javascript" src="mysite/js/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="mysite/js/modernizr-2.6.2.min.js"></script>  
        <script type="text/javascript" src="mysite/js/less-1.3.3.min.js"></script>

<body>

<% loop Clothings %>
<div class="clothing_label">
<div class="label_type">$Name</div>
<div class="label_owner"><% if Owner %>$Owner.Name<% else %>Lager<% end_if %></div>
<div class="label_code">ID: $IDCode</div>
</div>
<% end_loop %>
</body>
</html>