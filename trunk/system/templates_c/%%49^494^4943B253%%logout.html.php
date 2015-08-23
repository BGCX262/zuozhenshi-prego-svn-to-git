<?php /* Smarty version 2.6.26, created on 2013-03-24 22:24:22
         compiled from logout.html */ ?>
<header id="dashboard_header">
	<h1> <a href="index.php">繧ｳ繝ｳ繝医Ο繝ｼ繝ｫ繝代ロ繝ｫ</a> </h1>
	<ul>
		<li id="rt_admin">
    		<a href="javascript:;">
    			<img src="./assets/images/common/header/blank_face.gif">
    			<?php echo $this->_tpl_vars['login']['staff_name']; ?>

    		</a>
    	</li>
		<li id="rt_logout">
			<form name="logout_form" id="form_logout" action="logout.php" method="post">
				<p><input type="submit" id="button_logout" value="Logout" /></p>
			</form>
		</li>
	</ul>
</header>