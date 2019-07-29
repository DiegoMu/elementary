<div>
	<p><?=$data['type']?></p>
	<p><?=$data['client_ip']?></p>
	<p><?=$data['time_stamp']?></p>
	<p class='<?=$error_txt_class?>'><?=$data['message']?></p>
	<table>
		<thead>
			<th>
				<tr>Stack trace</tr>
			</th>
		</thead>
		<tbody>
		<?php foreach ($data['stack_trace'] as $stack_trace_message):?>
			<tr>
				<td>#<?=$stack_trace_message?></td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
</div>