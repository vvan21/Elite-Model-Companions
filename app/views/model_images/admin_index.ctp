<div class="modelImages index">
	<h2><?php __('Model Images');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('elite_model_id');?></th>
			<th><?php echo $this->Paginator->sort('location');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($modelImages as $modelImage):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $modelImage['ModelImage']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($modelImage['EliteModel']['name'], array('controller' => 'elite_models', 'action' => 'view', $modelImage['EliteModel']['id'])); ?>
		</td>
		<td><?php echo $modelImage['ModelImage']['location']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $modelImage['ModelImage']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $modelImage['ModelImage']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $modelImage['ModelImage']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $modelImage['ModelImage']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Model Image', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Elite Models', true), array('controller' => 'elite_models', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Elite Model', true), array('controller' => 'elite_models', 'action' => 'add')); ?> </li>
	</ul>
</div>