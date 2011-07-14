<div class="users stats">
    <div>
        <h2><?php echo __l('Dashboard'); ?></h2>
        <div>
           <table class="list">
			<tr>
				<th colspan='2'>&nbsp;</th>
				<?php foreach($periods as $key => $period){ ?>
				<th>
					<?php echo $period['display']; ?>
				</th>
				<?php } ?>
			</tr>
			<?php
			foreach($models as $unique_model){ ?>
				<?php foreach($unique_model as $model => $fields){
					$aliasName = isset($fields['alias']) ? $fields['alias'] : $model;
				?>
						<?php $element = isset($fields['rowspan']) ? 'rowspan ="'.$fields['rowspan'].'"' : ''; ?>
						<?php $element .= isset($fields['colspan']) ? 'colspan ="'.$fields['colspan'].'"' : ''; ?>
						<?php if(!isset($fields['isSub'])): ?>
							<tr>
							<td class="dr sub-title" <?php echo $element;?>>
								<?php echo $fields['display']; ?>
							</td>
						<?php endif;?>
						<?php if(isset($fields['isSub'])):	?>
							<td class="dr">
								<?php echo $fields['display']; ?>
							</td>
						<?php endif; ?>
						<?php if(!isset($fields['rowspan'])): ?>
							<?php foreach($periods as $key => $period) { ?>
									<td>
										<?php
                                            if(empty($fields['type'])) {
                                                $fields['type'] = 'cInt';
                                            }
                                            if (!empty($fields['link'])):
                                                $fields['link']['stat'] = $key;
                                                echo $html->link($html->{$fields['type']}(${$aliasName.$key}), $fields['link'], array('escape' => false, 'title' => __l('Click to View Details')));
											else:
                                                echo $html->{$fields['type']}(${$aliasName.$key});
                                            endif;
                                        ?>
									</td>
							<?php } ?>
							</tr>
						<?php endif; ?>

				 <?php } ?>
			<?php } ?>
			</table>
        </div>
    </div>
    <div>
		<h2><?php echo __l('Recently Registered Users'); ?></h2>
		<div>
            <?php
                if (!empty($recentUsers)):
                    $users = '';
                    foreach ($recentUsers as $user):
						$users .= sprintf('%s, ',$html->link($html->cText($user['User']['username'], false), array('controller'=> 'users', 'action' => 'view', $user['User']['username'], 'admin' => false)));
					endforeach;
					echo substr($users, 0, -2);
				else:
			?>
				<p class="notice"><?php echo __l('Recently no users registered');?></p>
			<?php
				endif;
			?>
		</div>
	</div>
	<div>
        <h2><?php echo __l('Online Users') . ' (' . $html->cInt(count($onlineUsers), false) . ')'?></h2>
        <div>
            <?php
                if (!empty($onlineUsers)):
                    $users = '';
					$i=0;
                    foreach ($onlineUsers as $user):
						$users .= sprintf('%s, ',$html->link($html->cText($user['User']['username'], false), array('controller'=> 'users', 'action' => 'view', $user['User']['username'], 'admin' => false)));
					if($i > 10){
						break;
					}
					$i++;
					endforeach;
					echo substr($users, 0, -2);
				else:
			?>
					<p class="notice"><?php echo __l('Recently no users online');?></p>
			<?php
				endif;
			?>
		</div>
	</div>
	<div>
        <h2><?php echo __l('Disk Space Stats'); ?></h2>
			<?php
				echo $html->link(__l('Purge Cache'), array('controller' => 'users', 'action' => 'clear_cache', 'admin' => 'true'));
			?>
            <dl class="list clearfix">
                <dt class="altrow"><?php echo __l('Used Cache Disk Space');?></dt>
		  			<dd class="altrow"><?php echo $tmpCacheFileSize; ?></dd>
                <dt><?php echo __l('Used Log Disk Space');?></dt>
		  			<dd><?php echo $tmpLogsFileSize; ?></dd>
            </dl>
	</div>
	<div>
		<h2><?php echo __l('Recent Errors & Logs'); ?></h2>
		<div>
			<h3><?php echo __l('Error Log')?></h3>
			<?php
				echo $html->link(__l('Clear Error Log'), array('controller' => 'users', 'action' => 'admin_clear_logs', 'type' => 'error_log'));
			?>
			<div><textarea rows="15" cols="90"><?php echo $error_log;?></textarea></div>
			<h3><?php echo __l('Debug Log')?></h3>
			<?php
			echo $html->link(__l('Clear Debug Log'), array('controller' => 'users', 'action' => 'admin_clear_logs', 'type' => 'debug_log'));
			?>
			<div><textarea rows="15" cols="90"><?php echo $debug_log;?></textarea></div>		</div>
	</div>
</div>