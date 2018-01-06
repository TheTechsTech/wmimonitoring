<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >
<head>
	<title>WMI Monitoring Login</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link rel="stylesheet" type="text/css" href="<?=base_url() ?>css/default.css" />
	<!--[if IE 6]>
		<link rel="stylesheet" href="<?=base_url() ?>css/fix.css" type="text/css" />
	<![endif]-->
</head>
<body>
    <div id="container">
			<div id="header">
		 	</div>
			<div id="slogan">
            	<img src="<?=base_url() ?>images/site/wmimonitoring.jpg" width="120" height="120" alt="logo" />
            	<h1>WMI Monitoring</h1>
				<p>Another Way to Monitoring Your Computer.</p>
            	</div>
    		<div id="content">
                <center>
                    <div style="color:red"><?=validation_errors();?></div>
                    <form action="<?=site_url("admin/login")?>" method="post">
                    <table>
                        <tbody>
                            <tr><td><label for="username">User Name</label></td><td><input type="text" name="username" id="username" value="<?=set_value('username')?>"/></td></tr>
                            <tr><td><label for="password">Password</label></td><td><input type="password" name="password" id="password"/></td></tr>
                            <tr><td colspan="2" align="center"><input type="submit" name="Simpan" id="Login" value="Submit" /></td></tr>
                        </tbody>
                    </table>
                    </form>
                </center>
            </div>
          	<div id="footer">
			<div class="copy">Copyright &copy; 2009 | <a href="http://wmimonitoring.sourceforge.net/">wmimonitoring.sourceforge.net</a></div>
		</div>
	</div>
</body>
</html>

