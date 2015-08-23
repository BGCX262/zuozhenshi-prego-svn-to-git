<?php /* Smarty version 2.6.26, created on 2013-03-24 22:40:55
         compiled from page.html */ ?>
<?php if ($this->_tpl_vars['page']['end'] > 1): ?>
	<?php if ($this->_tpl_vars['page']['current'] > 1): ?>
		<a href="javascript:toPage(<?php echo $this->_tpl_vars['page']['current']-1; ?>
)" >前の<?php echo $this->_tpl_vars['page']['item']; ?>
件</a>&nbsp;&nbsp;
	<?php endif; ?>
	
	<?php $_from = $this->_tpl_vars['page']['paging']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
		<?php if ($this->_tpl_vars['page']['current'] == $this->_tpl_vars['v']): ?>
			<a class="current"><?php echo $this->_tpl_vars['v']; ?>
</a>
		<?php else: ?>
			<a href="javascript:toPage(<?php echo $this->_tpl_vars['v']; ?>
)" ><?php echo $this->_tpl_vars['v']; ?>
</a>
		<?php endif; ?>
	<?php endforeach; endif; unset($_from); ?>
	<?php if ($this->_tpl_vars['page']['end'] > $this->_tpl_vars['page']['current']): ?>
		<a href="javascript:toPage(<?php echo $this->_tpl_vars['page']['current']+1; ?>
)" >次の<?php echo $this->_tpl_vars['page']['item']; ?>
件</a>
	<?php endif; ?>
<?php endif; ?>