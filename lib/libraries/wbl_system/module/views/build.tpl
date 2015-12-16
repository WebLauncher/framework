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
	input.error {
		border: 1px solid #f00;
	}
	label.error {
		color: #f00;
		font-weight: normal;
	}
    .modal-backdrop {
        z-index: 0;
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
		$('.tree li>a.btn-select').click(function() {
			$('[name="path"]').val($(this).attr('path'));
			$('[name="parent"]').val($(this).attr('path'));
			$('.tree li>a.active').removeClass('active');
			$(this).addClass('active');
		});
		$('#add_component').submit(function() {
			if ($('#add_component').valid()) {
				$.get($('#add_component [name="path"]').val() + '/' + $('#add_component [name="name"]').val(), {
					a : 'build',
					title : $('#add_component [name="title"]').val() 
				}, function() {
					load_build();
					status('Component <strong>' + $('#add_component [name="name"]').val() + '</strong> was created!');
				});
			} else
				alert('Please fill in the form properly!');
			return false;
		});
		$('#add_model').submit(function() {
			if ($('#add_model').valid()) {
				$.get($('#add_model [name="path"]').val() + '/', {
					a : 'build-model:' + $('#add_model [name="name"]').val()
				}, function() {
					load_build();
					status('Model <strong>' + $('#add_model [name="name"]').val() + '</strong> was created!');
				});
			} else
				alert('Please fill in the form properly!');
			return false;
		});
		$('.btn-add-model').click(function() {
			var model = $(this).attr('model');
			$(this).hide();
			$.get(root, {
				a : 'build-model:' + model
			}, function() {
				status('Model <strong>' + model + '</strong> was created!');
				load_build();
			});
		});
	}); 
</script>
{/literal}
<div class="clearfix col-md-12">
    <br/>
    <div class="col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Components
            </div>
            <div class="panel-body">
                <div class="tree">
                    <ul style="margin:0;padding:0;">
                        {include file="component.tpl" obj=$components}
                    </ul>
                </div>
            </div>
        </div>

    </div>
    <div class="col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading clearfix">
                <div class="pull-left">Models ({$models|@count})</div>
                <div class="pull-right">
                    <a href="#" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modal_model"><i class="glyphicon glyphicon glyphicon-plus"></i> Add model class</a>
                </div>
            </div>
            <div class="panel-body">
                <div class="clearfix">
                    <div class="col-md-3">
                        <span class="text-primary"><span class="glyphicon glyphicon-hdd"></span> DB Table</span>
                    </div>
                    <div class="col-md-3">
                        <span class="text-muted"><span class="glyphicon glyphicon-file"></span> Class File</span>
                    </div>
                </div>
                <ul class="list-group">
                    {foreach item="model" from=$models}
                    <li class="list-group-item">
                        {if $model.db}<span class="text-primary"><span class="glyphicon glyphicon-hdd"></span> {$model.name}</span>{/if}
                        {if $model.file}<br/><small class="text-muted"><span class="glyphicon glyphicon-file"></span> {$model.path}</small>{/if}
                        {if !$model.file}<a href="#" class="btn btn-primary badge btn-add-model" model="{$model.name}" title="Add class file"><span class="glyphicon glyphicon-plus"></span><span class="glyphicon glyphicon-file"></span></a>{/if}
                    </li>
                    {/foreach}
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_component" tabindex="-1" role="dialog" aria-labelledby="modal_component">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Add new component</h4>
            </div>
            <div class="modal-body">
                <form id="add_component">
                    <input type="hidden" name="path" value="{$components.path}"/>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Parent Component</label>
                        <input type="text" class="form-control" readonly="readonly" name="parent" value="{$main_module|default:'site'}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Name</label>
                        <input type="text" class="form-control" name="name" required="required" placeholder="Enter name">
                        {validator form="add_component" field="name" rule="pattern|^[a-z_][a-z0-9]+$" message="Please user only [a-z] and _ (underscore)." }
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Title</label>
                        <input type="text" class="form-control" name="title" placeholder="Title">
                    </div>
                    <button type="submit" class="btn btn-primary">
                        Add
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_model" tabindex="-1" role="dialog" aria-labelledby="modal_model">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Add new model class</h4>
            </div>
            <div class="modal-body">
                <form id="add_model">
                    <input type="hidden" name="path" value="{$components.path}"/>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Parent Component</label>
                        <input type="text" class="form-control" name="parent" readonly="readonly" value="{$main_module|default:'site'}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Name</label>
                        <input type="text" class="form-control" name="name" required="required" placeholder="Enter name">
                        {validator form="add_model" field="name" rule="pattern|^[a-z_]+$" message="Please user only [a-z] and _ (underscore)." }
                    </div>
                    <button type="submit" class="btn btn-primary">
                        Add
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>