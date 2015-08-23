<?php /* Smarty version 2.6.26, created on 2013-03-21 01:37:12
         compiled from service_category.html */ ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link href="./assets/styles/default.css" rel="stylesheet" />
<script src="./assets/scripts/lib/jquery-1.7.1.min.js" type="text/javascript"></script>
<script src="./assets/scripts/import.js" type="text/javascript"></script>
<script src="./assets/scripts/plugin/jquery.datasort.js" type="text/javascript"></script>
<title>コントロールパネル</title>

<script type="text/javascript">
$(function() {	
	var html = '<table class="formTable"><tbody>';
	html += '<tr><td class="must"><a href="javascript:;" class="del_item">削除</a>';
	html += '<input type="text" class="text" name="category_name[]" maxlength="100" /></td></tr>';
	html += '<input type="hidden" name="category_id[]" />';
	html += '</tbody></table>';
	setAppendCtrl("#category",html);
});
</script>

</head>
<body>
<?php echo $this->_tpl_vars['logout']; ?>

<div id="container">
<?php echo $this->_tpl_vars['menu']; ?>

<article id="article" class="load">
		<h2>サービスマスタ</h2>
		<nav>
			<ul>
				<li><a href="service_list.php"><span>一覧</span></a></li>
				<li><a href="service_edit.php"><span>登録</span></a></li>
				<li class="active"><a href="service_category.php"><span>カテゴリ</span></a></li>
			</ul>
		</nav>
		<section id="content">
			<h3>カテゴリ</h3>
<?php if ($this->_tpl_vars['phase'] == 'input'): ?>
			<p class="message">登録内容を確認し、登録ボタンをクリックしてください。</p>
			<form name="fm" action="service_category.php" method="post">
				<h4>一覧</h4>
				
				<ul class="btns b10">
					<li class="btn left c"><a href="javascript:;">追加</a></li>
					<li class="btn right c"><a href="javascript:;">空白削除</a></li>
				</ul>
				
				<div id="category" class="appendZebra">
					<table class="formTable">
						<thead>
							<tr>
								<th>カテゴリ名</th>
							</tr>
						</thead>
					</table>
					<?php $_from = $this->_tpl_vars['forms']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['v']):
?>
					<table class="formTable">
						<tbody>
						
							<tr>
								<td class="must">
									<a href="javascript:;" class="del_item">削除</a> 
									<input type="text" class="text" name="category_name[]" value="<?php echo $this->_tpl_vars['v']['category_name']; ?>
" maxlength="100"/>
									<?php echo $this->_tpl_vars['err']['category_name'][($this->_foreach['member']['iteration']-1)]; ?>

								</td>
							</tr>
							<input type="hidden" name="category_id[]" value="<?php echo $this->_tpl_vars['v']['id']; ?>
" />
						
						</tbody>
					</table>
					<?php endforeach; endif; unset($_from); ?>
				</div>
				
				<p class="button">
				<!-- 
					<button type="button" class="btn_back" onclick="location.href="";"><span>戻る</span></button>
				 -->
						<button type="submit" class="btn_update" class="submit"><span>更新</span></button>
				</p>
				<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['forms']['id']; ?>
" />
				<input type="hidden" name="mode" value="" />
			</form>
		</section>
	</article>
</div>
<?php endif; ?>
<?php if ($this->_tpl_vars['phase'] == 'complete'): ?>
<p class="message"><?php echo $this->_tpl_vars['message']; ?>
</p>
	<ul class="result_btn">
	<li><a href="service_category.php">一覧に戻る</a></li>
	<li><a href="service_category.php">続けて新規登録する</a></li>
	</ul>
<?php endif; ?>
<footer id="dashboard_footer"><?php echo $this->_tpl_vars['footer']; ?>
</footer>
</body>
</html>