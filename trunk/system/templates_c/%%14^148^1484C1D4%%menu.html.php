<?php /* Smarty version 2.6.26, created on 2013-03-24 22:24:22
         compiled from menu.html */ ?>
	<aside id="accordion">
    	<div id="aside_inner">
    		<p><a href="javascript:;">→</a></p>
    		<?php $_from = $this->_tpl_vars['pregomenu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['menum'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['menum']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['mk'] => $this->_tpl_vars['mv']):
        $this->_foreach['menum']['iteration']++;
?>
	    		<?php if ($this->_tpl_vars['mv']['auth']): ?>
	    			<ul id="side_module_<?php echo $this->_tpl_vars['mk']-1; ?>
" class="<?php echo $this->_tpl_vars['mv']['class']; ?>
_m">
		    			<li><a href="javascript:;"><span><?php echo $this->_tpl_vars['mv']['name']; ?>
</span></a></li>
						<ol>
				    		<?php $_from = $this->_tpl_vars['mv']['li']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['menuli'] = array('total' => count($_from), 'iteration' => 0);
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
						</ol>
		    		</ul>
	    		<?php endif; ?>
    		<?php endforeach; endif; unset($_from); ?>
        </div>
    </aside>