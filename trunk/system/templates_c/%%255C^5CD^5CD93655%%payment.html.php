<?php /* Smarty version 2.6.26, created on 2013-03-26 10:02:56
         compiled from smp/payment.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'smp/payment.html', 47, false),)), $this); ?>
<!DOCTYPE html>
<html><head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=320,user-scalable=no" />
    <link href="../assets/styles/default.css" rel="stylesheet" />
    <link href="../assets/styles/page/payment.css" rel="stylesheet" />
	<script src="../assets/scripts/lib/jquery-1.7.1.min.js" type="text/javascript"></script>
	<script src="../assets/scripts/main.js" type="text/javascript"></script>

   	<title>コントロールパネル</title>

   	<script type="text/javascript">

   		function getVal(){
			var obj_year = document.getElementById('year');
   			var obj_month = document.getElementById('month');
   			var obj_id = document.getElementById('id');

   			var year = obj_year.value;
   			var month = obj_month.value;
   			var id = obj_id.value;

   			window.location.href="payment_detail.php"+"?year="+year+"&&month="+month+"&&id="+id;

   		}

   	</script>


</head>
<body id="login">

<header id="dashboard_header">
	<h1>
    	<a href="index.php">コントロールパネル</a>
    </h1>
</header>

<div id="container">
	<header>
		<h1><span>&nbsp;</span>支払情報</h1>
	</header>
	<section class="content" id="select">
		<ul>
			<li>
				年：
<?php echo smarty_function_html_options(array('name' => 'year','id' => 'year','options' => $this->_tpl_vars['year']), $this);?>

			</li>
			<li>
				月：
<?php echo smarty_function_html_options(array('name' => 'month','id' => 'month','options' => $this->_tpl_vars['month']), $this);?>

			</li>
		</ul>
		<input type="hidden" id="id" name="id" value="<?php echo $this->_tpl_vars['id']; ?>
"/>

	</section>

	<p class="btn"><ul><li><input type="button" value="表示する" onclick="getVal()" />	</ul></li></p>

</div>

<footer>Copyright (C) Prego. / All rights reserved.</footer>

</body>
</html>