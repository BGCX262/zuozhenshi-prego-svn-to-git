<?php /* Smarty version 2.6.26, created on 2013-03-24 22:24:22
         compiled from index.html */ ?>
<!DOCTYPE html>
<html><head>
	<meta charset="UTF-8">
	
    <link href="./assets/styles/default.css" rel="stylesheet" />
    <link href="./assets/styles/page/index.css" rel="stylesheet" />
	<script src="./assets/scripts/lib/jquery-1.7.1.min.js" type="text/javascript"></script>
	<script src="./assets/scripts/import.js" type="text/javascript"></script>
	<script src="./assets/scripts/plugin/jquery.datasort.js" type="text/javascript"></script>
	<script src="./assets/scripts/index.js" type="text/javascript"></script>
    
   	<title>コントロールパネル</title>

</head>
<body>
<?php echo $this->_tpl_vars['logout']; ?>

<div id="container">
<?php echo $this->_tpl_vars['menu']; ?>

    <article id="article" class="load">
    	<h2>デスクメニュー 一覧</h2>
        
        
        <nav class="top_nav"></nav>
        
		<div id="sections">
        
			<section id="modules" class="top_content" name="section0" summary="Plugin">
				<h3 class="ctrl"></h3>
                
                <ul class="btns_mini activemenu plugin_mode">
                    <li class="left"><a href="javascript:;">d</a></li>
                    <li class="right"><a href="javascript:;">c</a></li>
                </ul>
                
                <div id="module_container">
                
                	<?php $_from = $this->_tpl_vars['pregomenu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['menum'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['menum']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['pk'] => $this->_tpl_vars['pv']):
        $this->_foreach['menum']['iteration']++;
?>
                	<?php if ($this->_tpl_vars['pv']['auth']): ?>
		    			<div id="module_<?php echo $this->_tpl_vars['pk']; ?>
">
							<h3 class="<?php echo $this->_tpl_vars['pv']['class']; ?>
"><?php echo $this->_tpl_vars['pv']['name']; ?>
<span></span></h3>
							<ul>
								<?php $_from = $this->_tpl_vars['pv']['li']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['menuli'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['menuli']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['lik'] => $this->_tpl_vars['liv']):
        $this->_foreach['menuli']['iteration']++;
?>
								<?php if ($this->_tpl_vars['liv']['auth']): ?>
									<li><a href="<?php echo $this->_tpl_vars['lik']; ?>
.php"><?php echo $this->_tpl_vars['liv']['name']; ?>
</a></li>
								<?php endif; ?>
								<?php endforeach; endif; unset($_from); ?>
							</ul>
						</div>
					<?php endif; ?>
	    			<?php endforeach; endif; unset($_from); ?>
	    			
            	</div>
        	</section>
        </div>
    	</article>    
	</div>

	<footer id="dashboard_footer"><?php echo $this->_tpl_vars['footer']; ?>
</footer>

</body>
</html>