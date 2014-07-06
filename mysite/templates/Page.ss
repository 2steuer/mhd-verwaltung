<!DOCTYPE html>

<html>
	<head>
		<% base_tag %>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <title>$Title &laquo; {$SiteConfig.SiteTitle}</title>
        <link rel="stylesheet" type="text/css" href="mysite/css/normalize.min.css" />
        <link rel="stylesheet/less" type="text/css" href="mysite/css/format.less" />

        <script type="text/javascript" src="mysite/js/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="mysite/js/modernizr-2.6.2.min.js"></script>  
        <script type="text/javascript" src="mysite/js/less-1.3.3.min.js"></script>
	</head>
<body>
	
<div id="wrapper">
<header>
$SiteConfig.Logo.SetHeight(90)
<% with SiteConfig %><h1>$SiteTitle</h1><% end_with %>
</header>
<div id="block">

<nav>
<% if CurrentMember %>
Eingeloggt als:<br />$CurrentMember.Surname, $CurrentMember.FirstName
<% end_if %>
<ul id="main_nav">
<% loop Menu(1) %>
        <li><a href="$Link" class="$LinkOrSection">&raquo; $MenuTitle</a>
        <% if LinkOrSection = section %>
                <% if Children %>
                        <ul id="sub_nav">                        
                        <% loop Children %>
                        <li><a href="$Link" class="$LinkOrSection">&raquo; $MenuTitle</a></li>
                        <% end_loop %>
                        </ul>
                <% end_if %>
        <% end_if %>
        </li>
<% end_loop %>
<% if CurrentMember %>
<li><a href="security/logout">&raquo; Logout</a></li>
<% end_if %>
</ul>
</nav>

<div id="content">
<h1>$Title</h1>
$Layout
</div>

</div>

<footer>
</footer>

</div>

</body>
</html>