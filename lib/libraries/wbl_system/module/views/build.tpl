{literal}
<style type="text/css" media="screen">
	.tree {
		min-height: 20px;
		margin-bottom: 20px;
	}
	.tree li {
		list-style-type: none;
		margin: 0;
		padding: 10px 5px 0 5px;
		position: relative
	}
	.tree li::before, .tree li::after {
		content: '';
		left: -20px;
		position: absolute;
		right: auto
	}
	.tree li::before {
		border-left: 1px solid #999;
		bottom: 50px;
		height: 100%;
		top: 0;
		width: 1px
	}
	.tree li::after {
		border-top: 1px solid #999;
		height: 20px;
		top: 25px;
		width: 25px
	}
	.tree li span {
		display: inline-block;
		padding: 3px;
		text-decoration: none
	}
	.tree li.parent_li > span {
		cursor: pointer
	}
	.tree > ul > li::before, .tree > ul > li::after {
		border: 0
	}
	.tree li:last-child::before {
		height: 30px
	}
	.tree li.parent_li > span:hover, .tree li.parent_li > span:hover+ ul li span {
		color: #337ab7;
	}

</style>
<script>
	$(function() {
		$('.tree li:has(ul)').addClass('parent_li').find(' > span').attr('title', 'Collapse this branch');
		$('.tree li.parent_li > span').on('click', function(e) {
			var children = $(this).parent('li.parent_li').find(' > ul > li');
			if (children.is(":visible")) {
				children.hide('fast');
				$(this).attr('title', 'Expand this branch').find(' > i').addClass('glyphglyphicon glyphicon-plus-sign').removeClass('glyphglyphicon glyphicon-minus-sign');
			} else {
				children.show('fast');
				$(this).attr('title', 'Collapse this branch').find(' > i').addClass('glyphglyphicon glyphicon-minus-sign').removeClass('glyphglyphicon glyphicon-plus-sign');
			}
			e.stopPropagation();
		});
		$('.tree li>a').click(function() {
			$('[name="path"]').val($(this).attr('path'));
			$('[name="parent"]').val($(this).html());
			$('.tree li>a.active').removeClass('active');
			$(this).addClass('active');
			return false;
		});
		$('#add_component').submit(function() {
			if($('#add_component [name="name"]').val()){
				$.get($('#add_component [name="path"]').val() + '/' + $('#add_component [name="name"]').val(), {
					a : 'build'
				}, function() {
					load_build();
					status('Component <strong>'+$('#add_component [name="name"]').val()+'</strong> was created!');
				});
			}
			else alert('Please add a name!');
			return false;
		});
		$('#add_model').submit(function() {
			if($('#add_model [name="name"]').val()){
				$.get($('#add_model [name="path"]').val() + '/', {
					a : 'build-model:' + $('#add_model [name="name"]').val()
				}, function() {
					load_build();
					status('Model <strong>'+$('#add_model [name="name"]').val()+'</strong> was created!');
				});
			}
			else alert('Please add a name!');
			return false;
		});
	});
</script>
{/literal}
<div class="clearfix col-md-12">
	<h2>Components</h2>
	<div class="alert alert-info" role="alert">Select a component to add sub-components.</div>
	<div class="col-md-3">
		<div class="tree">
			<ul>
				{include file="component.tpl" obj=$components}
			</ul>
		</div>
	</div>
	<div class="col-md-9">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					Add new component
				</div>
				<div class="panel-body">
					<form id="add_component">
						<input type="hidden" name="path" value="{$components.path}"/>
						<div class="form-group">
							<label for="exampleInputEmail1">Parent Component</label>
							<input type="text" class="form-control" readonly="readonly" name="parent" value="{$main_module|default:'site'}">
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">Name</label>
							<input type="text" class="form-control" name="name" required="required" placeholder="Enter name">
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Title</label>
							<input type="text" class="form-control" name="title" placeholder="Title">
						</div>
						<button type="submit" class="btn btn-default">
							Add
						</button>
					</form>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					Add new model
				</div>
				<div class="panel-body">
					<form id="add_model">
						<input type="hidden" name="path" value="{$components.path}"/>
						<div class="form-group">
							<label for="exampleInputEmail1">Parent Component</label>
							<input type="text" class="form-control" name="parent" readonly="readonly" value="{$main_module|default:'site'}">
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">Name</label>
							<input type="text" class="form-control" name="name" required="required" placeholder="Enter name">
						</div>
						<button type="submit" class="btn btn-default">
							Add
						</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
