<!-- <?php echo strtoupper($page->request_method); ?> <?php if($page->ajax): ?>XHR<?php endif;?>: <?php echo $page->query; ?> -->
<h3><span class="label label-default"><?=strtoupper($page->request_method)?></span><?php if($page->ajax): ?> <span class="label label-warning">XHR</span><?php endif;?> <?=$page->paths['current_full']?></h3>
<div role="tabpanel">
					<ul id="nav_menu" class="col-md-2 nav nav-pills nav-stacked" role="tablist">
						<li class="active">
							<a href="#div_statistics" data-toggle="tab" aria-controls="div_statistics"><span class="glyphicon glyphicon-stats" aria-hidden="true"></span> Statistics</a>
						</li>
						<li>
                            <a href="#div_request" data-toggle="tab" aria-controls="div_page"><span class="glyphicon glyphicon-transfer" aria-hidden="true"></span> Request</a>
                        </li>
						<li>
							<a href="#div_page" data-toggle="tab" aria-controls="div_page"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Page {$p}</a>
						</li>
                        <li>
                            <a href="#div_browser" data-toggle="tab" aria-controls="div_browser"><span class="glyphicon glyphicon-globe" aria-hidden="true"></span> Browser {$p.browser}</a>
                        </li>
						<li>
							<a href="#div_session" data-toggle="tab" aria-controls="div_session"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Session {$p.session}</a>
						</li>
						<li>
							<a href="#div_paths" data-toggle="tab" aria-controls="div_paths"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Paths {$p.paths}</a>
						</li>
						<li>
                            <a href="#div_template" data-toggle="tab" aria-controls="div_template"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Template Vars</a>
                        </li>
						<li>
							<a href="#div_db" data-toggle="tab" aria-controls="div_db"><span class="glyphicon glyphicon-hdd" aria-hidden="true"></span> Database</a>
						</li>
						<?php if($page->logged) { ?>
						<li>
							<a href="#div_user" data-toggle="tab" aria-controls="div_user"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Logged User {$p.user}</a>
						</li>
						<?php } ?>
					</ul>
			<div class="col-md-10 tab-content">
						<div role="tabpanel" id="div_statistics" class="tab-pane panel panel-default active">
							<div class="panel-body">
							    <h3><span class="glyphicon glyphicon-time" aria-hidden="true"></span> Time</h3>
							    <table class="table table-condensed">
							        <tr class="active">
							        	<th style="width:30%;">Total execution:</th>
							        	<th><strong><?=isset_or($times['system'],'N/A'); ?> s</strong></th>
							        </tr>
							        <tr>
                                        <td>Init:</td>
                                        <td><strong><?=isset_or($times['init'],'N/A'); ?> s</strong></td>
                                    </tr>
							        <tr>
							        	<td>Scripts execution:</td>
							        	<td><strong><?=isset_or($times['render_scripts'],'N/A'); ?> s</strong></td>
							        </tr>
							        <tr>
							        	<td>Templates render:</td>
							        	<td><strong><?=isset_or($times['render_templates'],'N/A'); ?> s</strong></td>
							        </tr>
							        <?php if($page->db_conn) {?>
							        <tr>
                                        <td>DB queries:</td>
                                        <td><strong><?=$page -> db_conn -> total_execution_time() ?> s</strong></td>
                                    </tr>
                                    <?php } ?>
							    </table>
							    <h3><span class="glyphicon glyphicon-tasks" aria-hidden="true"></span> Memory</h3>
							    <table class="table table-condensed">
							    	<tr>
							    		<td style="width:30%;">Maximum allowed:</td>
							    		<td><strong><?=$memory['max'] ?></strong></td>
							    	</tr>
							    	<tr>
							    		<td>Before init:</td>
							    		<td><strong><?=$memory['system_before_init'] ?></strong></td>
							    	</tr>
							    	<tr>
							    		<td>After init: </td>
							    		<td><strong><?=isset_or($memory['system_after_init'],'N/A'); ?></strong></td>
							    	</tr>
							    	<tr>
							    		<td>Before render:</td>
							    		<td><strong><?=isset_or($memory['system_before_render'],'N/A') ?></strong></td>
							    	</tr>
							    	<tr>
							    		<td>After render:</td>
							    		<td><strong><?=isset_or($memory['system_after_render'],'N/A'); ?> </strong></td>
							    	</tr>
							    </table>
							</div>
						</div>
						<div role="tabpanel" id="div_request" class="tab-pane panel panel-default">
                            <div class="panel-body">
                            <?php if(!$page->ispostback) { ?>
                            <h4>$_GET</h4>
                            <?=self::get_debug($_GET) ?>
                            <?php }else{ ?>
                            <h4>$_POST</h4>
                            <?=self::get_debug($_POST) ?>
                            <?php } ?>
                            
                            <h4>$_COOKIE</h4>
                            <?=self::get_debug($_COOKIE) ?>
                            
                            <?php if(count($_ENV)) { ?>
                            <h4>$_ENV</h4>
                            <?=self::get_debug($_ENV) ?>
                            <?php } ?>
                            
                            <?php if(count($_FILES)) { ?>
                            <h4>$_FILES</h4>
                            <?=self::get_debug($_FILES) ?>
                            <?php } ?>
                            </div>
                        </div>
						<div role="tabpanel" id="div_page" class="tab-pane panel panel-default">
		                    <div class="panel-body">
							<?=$db ?>
							</div>
						</div>
						<div role="tabpanel" id="div_browser" class="tab-pane panel panel-default">
                            <div class="panel-body">
                            <?=$browser ?>
                            </div>
                        </div>
						<div role="tabpanel" id="div_session" class="tab-pane panel panel-default">
		                    <div class="panel-body">
		                    <?=$session ?>
		                    </div>
						</div>
						<div role="tabpanel" id="div_paths" class="tab-pane panel panel-default">
		                    <div class="panel-body">
		                    <?=$paths ?>
		                    </div>
						</div>
						<div role="tabpanel" id="div_template" class="tab-pane panel panel-default">
                            <div class="panel-body">
                            <?=$template ?>
                            </div>
                        </div>
                        <?php if($page->db_conn) { ?>
						<div role="tabpanel" id="div_db" class="tab-pane panel panel-default">
		                    <div class="panel-body">
		                        <table class="table table-condensed">
                                    <tr>
                                        <td style="width:30%;">Connection:</td>
                                        <td><strong><?=$db_conn['dns'] ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>No Queries:</td>
                                        <td><strong><?=$db_conn['db_no_valid_queries'] ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Slowest Query:</td>
                                        <td><strong><?=$db_conn['db_slowest_query'] ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Tables:</td>
                                        <td><strong><?=$db_conn['tables'] ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Queries:</td>
                                        <td><strong><?=$db_conn['db_queries'] ?></strong></td>
                                    </tr>
                                </table>
		                        
		                    </div>
						</div>
						<?php } ?>
						<?php if($page->logged) { ?>
						<div role="tabpanel" id="div_user" class="tab-pane panel panel-default">
		                    <div class="panel-body">
		                        <?=$user ?>
		                    </div>
						</div>
						<?php } ?>
					</div>
		</div>
	</div>
</div>