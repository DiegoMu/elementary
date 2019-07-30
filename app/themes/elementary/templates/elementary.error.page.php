<div>
	<h1><?=$data['type']?></h1>
	<h2><?=$data['client_ip']?></h2>
	<h2><?=$data['time_stamp']?></h2>
	<h2 class='<?=$error_txt_class?>'><?=$data['message']?></h2>
	<?php if(!empty($data['stack_trace'])):?>
	<table class="table table-sm table-bordered">
		<thead>
			<tr>
				<th>Stack trace</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($data['stack_trace'] as $stack_trace_message):?>
			<tr class="table-warning">
				<td>#<?=$stack_trace_message?></td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
<?php endif;?>
</div>