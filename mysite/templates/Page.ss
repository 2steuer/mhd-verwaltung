<!DOCTYPE html>

<html>
	<head>
		<% base_tag %>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <title>$Title &laquo; {$SiteConfig.SiteTitle}</title>
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
<% if NotesEnabled %>
<div id="notes_container">
$NoteForm
</div>
<% end_if %>
</div>

</div>

<footer>
</footer>

</div>

</body>
</html>