<div class="descriptions view">
<h2><?php echo __('Description'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($description['Description']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Product'); ?></dt>
		<dd>
			<?php echo $this->Html->link($description['Product']['title'], array('controller' => 'products', 'action' => 'view', $description['Product']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($description['Description']['description']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Description'), array('action' => 'edit', $description['Description']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Description'), array('action' => 'delete', $description['Description']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $description['Description']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Descriptions'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Description'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Products'), array('controller' => 'products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product'), array('controller' => 'products', 'action' => 'add')); ?> </li>
	</ul>
</div>
