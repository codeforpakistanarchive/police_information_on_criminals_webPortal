<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>LandropIpad - REST API DASHBOARD!</title>
    
<style type="text/css">

body {
 background-color: #fff;
 margin: 40px;
 font-family: Lucida Grande, Verdana, Sans-serif;
 font-size: 13px;
 color: #4F5155;
}

a {
 color: #003399;
 background-color: transparent;
 font-weight: normal;
}

h1 {
 color: #444;
 background-color: transparent;
 border-bottom: 1px solid #D0D0D0;
 font-size: 16px;
 font-weight: bold;
 margin: 24px 0 2px 0;
 padding: 5px 0 6px 0;
}

code {
 font-family: Monaco, Verdana, Sans-serif;
 font-size: 12px;
 background-color: #f9f9f9;
 border: 1px solid #D0D0D0;
 color: #002166;
 display: block;
 margin: 14px 0 14px 0;
 padding: 12px 10px 12px 10px;
}

</style>
</head>
<body>

<h1>LandroIpad - REST API DASHBOARD!</h1>

<p>Below is the list of available REST API functions.</p>

<ul>
	<li>Version functions
	  <ul>
        <li><strong>Current Version</strong> - /api/version/all - GET<br>
	      <code>
          <strong>Sample Script</strong><br>
          curl -H &quot;Content-type: application/json&quot; -X GET -d '' &quot;http://192.168.0.6/api/version/all/version_no/current&quot;
          </code><br>
	    </li>
        <li><strong>All Version</strong> - /api/version/all - GET<br>
	      <code>
          <strong>Sample Script</strong><br>
           curl -H &quot;Content-type: application/json&quot; -X GET -d '' &quot;http://192.168.0.6/api/version/all&quot;
           <br />
           curl -H &quot;Content-type: application/json&quot; -X GET -d '' &quot;http://192.168.0.6/api/version/all/version_no&quot;
          </code><br>
	    </li>
      </ul>
	</li>
    <li>User functions
	  <ul>
	    <li ><strong>login</strong> - /api/user/login<br>
	      
          <code> <strong>Sample Script</strong><br>
          curl -H &quot;Content-type: application/json&quot; -X POST -d '{&quot;email&quot;:&quot;hafiz@testing.com&quot;,&quot;password&quot;:&quot;123456789&quot;}' &quot;http://localhost:81/landroipad/api/user/login&quot; </code>
          <br>
	    </li>
        <li><strong>signup</strong> - /api/user/signup<br>
	      <code>
          <strong>Sample Script</strong><br>
          curl -H &quot;Content-type: application/json&quot; -X POST -d '{&quot;email&quot;:&quot;hafiz@testing.com&quot;,&quot;password&quot;:&quot;123456789&quot;,&quot;fname&quot;:&quot;Hafiz&quot;,&quot;lname&quot;:&quot;Haseeb&quot;,&quot;mobile&quot;:&quot;03236002904&quot;,&quot;dob&quot;:&quot;16-02-1990&quot;,&quot;address&quot;:&quot;some address&quot;,&quot;city&quot;:&quot;lahore&quot;,&quot;state&quot;:&quot;punjab&quot;,&quot;zip&quot;:&quot;54570&quot;}' &quot;http://localhost:81/landroipad/api/user/signup&quot;
          </code><br>
	    </li>
      </ul>
	</li>
</ul>

<p><br />
  :: To test these scripts on windows, <a href="https://curl.haxx.se/dlwiz/?type=bin&amp;os=Win32&amp;flav=-&amp;ver=2000%2FXP">download Curl</a>.<br>
  <br>
Page rendered in {elapsed_time} seconds</p>

</body>
</html>