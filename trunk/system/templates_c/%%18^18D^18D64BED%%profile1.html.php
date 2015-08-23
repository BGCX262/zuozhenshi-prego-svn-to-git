<?php /* Smarty version 2.6.26, created on 2013-03-25 16:44:33
         compiled from smp/profile1.html */ ?>
<!DOCTYPE html>
<html><head>
	<meta charset="UTF-8">
<link href="../assets/styles/default.css" rel="stylesheet" />
<script src="../assets/scripts/lib/jquery-1.7.1.min.js" type="text/javascript"></script>
<script src="../assets/scripts/import.js" type="text/javascript"></script>
<script src="../assets/scripts/plugin/jquery.datasort.js" type="text/javascript"></script>
<script src="../assets/scripts/popup.js" type="text/javascript"></script>
   	<title>コントロールパネル</title>
	<script type="text/javascript">
$(function(){
	$('#cartoon_url').unbind('click').click(function(){
		var url = $(this).data('url');
		window.open(url, 'mywindow2', 'width=600, height=700, menubar=no, toolbar=no, scrollbars=yes');
	});
});
</script>
</head>
<body id="login">

<header id="dashboard_header">
	<h1>
    	<a href="index.php">コントロールパネル</a>
    </h1>
</header>




<article id="article" class="load">

<div class="thisPopup" id="specialist_profile">
<section id="content">




<div id="container">
	<section class="content" id="specialist_profile">

		<h1><img src="../assets/images/common/logo.gif" alt="prego" /></h1>

		<p class="img">
		<?php if ($this->_tpl_vars['image'] != ''): ?>
			<img src="../<?php echo $this->_tpl_vars['image']; ?>
" />
		<?php endif; ?>
		</p>

		<h2><?php echo $this->_tpl_vars['spec_name']; ?>
</h2>
		<h3><?php echo $this->_tpl_vars['interlingua']; ?>
</h3>
		<h4><?php echo $this->_tpl_vars['title']; ?>
</h4>

		<p class="summary">
			<?php echo $this->_tpl_vars['summary']; ?>

		</p>

		<table class = "formTable">
			<tbody>
				<tr>
				<th>生年月日</th>
					<td><?php echo $this->_tpl_vars['spec_forms']['birthday']; ?>
</td>
					<th>所在地</th>
					<td><?php echo $this->_tpl_vars['address']; ?>
</td>
				</tr>
				<tr>
				<th>経歴</th>
					<td><?php echo $this->_tpl_vars['experience']; ?>
</td>

					<th>資格</th>
					<td><?php echo $this->_tpl_vars['qualifications']; ?>
</td>
				</tr>
				<tr>
				<th>実績</th>
					<td><?php echo $this->_tpl_vars['actual_result']; ?>
</td>
					<th>著者・著作</th>
					<td><?php echo $this->_tpl_vars['famous']; ?>
</td>
				</tr>
				<tr>
				<th>動画を見る</th>
					<td>
					<?php if ($this->_tpl_vars['profile_forms']['cartoon_url'] != ''): ?>
									<ul class="btns b10">
							<li class="btn single c"><a id="cartoon_url" href="javascript:;" data-url="<?php echo $this->_tpl_vars['profile_forms']['cartoon_url']; ?>
">動画を見る</a></li>
						</ul>
							<?php endif; ?>
					</td>
<th>サービスフィー</th>
<td><?php echo $this->_tpl_vars['profile_forms']['fee_message_a']; ?>
 <?php echo $this->_tpl_vars['profile_forms']['fee_message_b']; ?>
 <?php echo $this->_tpl_vars['profile_forms']['fee_message_c']; ?>
</td>
				</tr>
			</tbody>
		</table>

	</section>

	</section>
</div>
</article>

</div>

<footer>Copyright (C) Prego. / All rights reserved.</footer>

</body>
</html>