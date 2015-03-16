<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html  xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>System Tools</title>
		<style>
			body {
				margin: 0;
				padding: 0;
			}
			* {
				font-size: 12px;
			}
			td, th {
				vertical-align: top;
			}
			.wrapper {
				padding: 10px;
			}
			h2 {
				font-size: 14px;
				color: #fff;
				background: #eee;
				padding: 5px;
				border-bottom: 2px solid #333;
				margin: 0;
				margin-bottom: 10px;
			}
		</style>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
		<script>
		    var root = '<?php echo $page->paths['root']?>';

			$(function() {
			    $("#trace_table").height($(window).height());
			    $("#trace_table .container").height($(window).height()).width($("#trace_table .container").parent().width());
			});
		</script>
	</head>
	<body style="padding:1em;">
		<header>
			<h1>System Tools</h1>

		</header>
		<div role="tabpanel">
    		<ul class="nav nav-tabs">
    			<li role="presentation" class="active">
    				<a href="#trace" data-toggle="tab">Trace</a>
    			</li>
    			<li role="presentation">
    				<a href="#build" data-toggle="tab">Build</a>
    			</li>
    			<li role="presentation">
    				<a href="#messages" data-toggle="tab">Messages</a>
    			</li>
    		</ul>
    		<div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="trace">
                    <br/>
                    <div class="col-md-12">
                    	<select id="trace_list" class="form-control">
                    	    <?php
                    	    foreach (self::$files as $date => $file) {
                    	        echo '<option value="' . $file . '">' . $date . '</option>';
                    	    }
                    	    ?>
                    	</select>
                    </div>
                    <div id="load_trace" class="col-md-12">
            
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="build">
                    
                </div>
                <div role="tabpanel" class="tab-pane" id="messages">...</div>
            </div>
		</div>
		
	</body>
	<script type="text/javascript" charset="utf-8">
		function load_trace(page,obj){
            $('#load_trace').load(root+'?a=__sys_trace_get&page='+page);
        }
        
        function load_build(){
            $('#build').load(root+'?a=__sys_trace_build');
        }

        $(function(){
            load_trace('<?php echo $_REQUEST['page']; ?>');

	        $('#trace_list').change(function(){
	           load_trace($(this).val());
	        });
	        
	        load_build();
	    });

	</script>
</html>
