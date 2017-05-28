<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Edit.com WordPress Minimum Requirements Test</title>
	<style type="text/css">
		ul.checklist {list-style:none;width:350px;border:1px solid #ddd;}
		ul.checklist li {margin-bottom:5px;padding:5px;border-bottom:1px solid #ddd;}
		ul.checklist li.last {border-bottom-width:0;}
		.compatible {color:green;font-weight:bold;}
		.prob-compatible {color:lightgreen;font-weight:bold;}
		.not-compatible {color:red;font-weight:bold;}
		BODY {font: 14px tahoma;}
	</style>
</head>

<body>
	<h1>Edit.com WordPress Minimum Requirements Test</h1>
	To run effectively, our WordPress configurations <strong>require</strong>:
	<ul class="checklist">
		<li>
			PHP version 5.2+<br>
			<?php 
				if (version_compare(PHP_VERSION, '5.2.0') >= 0) {
				    echo '<span class="compatible">Yes! My PHP version is: ' . PHP_VERSION . '</span>';
				} else {
					echo '<span class="not-compatible">No! My PHP version is: ' . PHP_VERSION . '</span>';
				}
			?>
		</li>
		<li>MySQL 4.1+<br />
			<?php 
				if (extension_loaded('mysqlnd') || extension_loaded('pdo_mysql') || extension_loaded('mysql') || extension_loaded('mysqli')) {
				    echo '<span class="prob-compatible">Yes (probably). The PHP MySQL extension is loaded (PHP thinks MySQL is loaded), however we can\'t be sure MySQL is running or detect the version without creating a database.</span>';
				} else {
					echo '<span class="not-compatible">No! The PHP MySQL extensions are not loaded. This means PHP cannot connect to MySQL (usually because there is no MySQL server OR PHP is not configured properly).</span>';
				}
			?>
		</li>
		<li class="last">URL Rewrite support (Apache: mod_rewrite)<br/>
			<?php 
				if (stripos($_SERVER['SERVER_SOFTWARE'],'apache') !== false) {
				    echo '<span class="compatible">Yes! The server is running Apache: '. $_SERVER['SERVER_SOFTWARE'] .'</span><br /><br />';
					
					if (in_array('mod_rewrite', apache_get_modules())) {
					    echo '<span class="compatible">And... Yes! The Apache mod_rewrite extension is also loaded.</span>';
					} else {
						echo '<span class="not-compatible">But... No, the Apache mod_rewrite extension does not appear to be loaded.</span>';
					}
				} else {
					echo '<span class="not-compatible">No! The server does not appear to be running Apache: '. $_SERVER['SERVER_SOFTWARE'] .'</span>';
				}
			?>
		</li>
	</ul>
	
	<h2>PHP Detail Info (phpinfo)</h2>
	<?php phpinfo(); ?>
</body>
</html>


