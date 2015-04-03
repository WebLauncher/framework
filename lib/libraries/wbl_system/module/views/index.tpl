<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html  xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>System Tools</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
		
		<script>
		    var root = '{$root}';
		    var page = '{$page}';
		</script>
	</head>
	<body style="padding:1em;">
		<header class="clearfix">
			<h1 class="pull-left">System Tools</h1>
			<div class="pull-right" id="status">
				
			</div>
		</header>
		<div role="tabpanel">
    		<ul class="nav nav-tabs">
    			<li role="presentation" class="active">
    				<a href="#trace" data-toggle="tab"><span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span> Trace</a>
    			</li>
    			{if $can_build}
    			<li role="presentation">
    				<a href="#build" data-toggle="tab"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> Build</a>
    			</li>
    			{/if}
    			<li role="presentation">
    				<a href="#server" data-toggle="tab"><span class="glyphicon glyphicon-hdd" aria-hidden="true"></span> Server</a>
    			</li>
    			<li role="presentation">
    				<a href="#phpinfo" data-toggle="tab"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> PHP Info</a>
    			</li>
    			{if count($errors)}
    			<li role="presentation">
    				<a href="#errors" data-toggle="tab"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> Error Log</a>
    			</li>
    			{/if}
    		</ul>
    		<div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="trace">
                    <br/>
                    <div class="col-md-12">
                    	<label>{$files|@count} trace files available</label>
                    	<select id="trace_list" class="form-control">
                    	   {foreach item=file key=date from=$files}
                    	   <option value="{$file}"{if $page==$file} selected="selected"{/if}>{$date}</option>
                    	   {/foreach}
                    	</select>
                    </div>
                    <div id="load_trace" class="col-md-12">
            
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="build">
                    
                </div>
                <div role="tabpanel" class="tab-pane" id="server">
                	<div class="col-md-12">{$server}</div>
                </div>
                <div role="tabpanel" class="tab-pane" id="phpinfo">
                	<div class="col-md-12">
                		<iframe src="{$root}?a=__sys_trace_phpinfo" id="phpinfo_frame" width="100%" height="500" border="0" style="border:none;"></iframe>
                	</div>
                </div>
                {if $errors}
                <div role="tabpanel" class="tab-pane" id="errors">
                	<br/>
                	<div class="col-md-12">
                		<label>{$errors|@count} errors</label>
                		{foreach item=error from=$errors}
                		<div class="alert alert-danger" role="alert" style="background: #{$error->error->back};border-color:#{$error->error->color};color:#{$error->error->color};">
                			{$error->error->name}: 
                			<strong>{$error->text}</strong> ({$error->date})<br/>
                			<a href="{$error->file}">{$error->file} (@ line: {$error->line})</a> {if $error->class}Class: <strong>{$error->class}</strong>{/if} {if $error->method} Method: <strong>{$error->method}</strong>{/if}
                		</div> 
                		{/foreach}               		
                	</div>
                </div>
                {/if}
            </div>
		</div>
		
	</body>
	{literal}
	<script type="text/javascript" charset="utf-8">
		function load_trace(page,obj){
			if(page)
            	$('#load_trace').load(root+'?a=__sys_trace_get&page='+page);
        }
        
        function load_build(){
            $('#build').load(root+'?a=__sys_trace_build');
        }
        
        function status(message,type){
        	if(!type)
        		type='success';
        	$('#status').html('<div class="alert alert-'+type+'" role="alert">'+message+'</div>');
        }

        $(function(){
        	$('#phpinfo_frame').height($(window).height()-200);
        	
            load_trace(page);

	        $('#trace_list').change(function(){
	           load_trace($(this).val());
	        });
	        
	        load_build();
	    });

	</script>
	{/literal}
</html>
