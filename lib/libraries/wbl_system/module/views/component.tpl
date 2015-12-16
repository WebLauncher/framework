<li>
	{if count($obj.kids)}<span><i class="glyphicon glyphicon-minus-sign"></i></span>{/if} <a class="btn btn-default btn-select" data-toggle="modal" data-target="#modal_component" path="{$obj.path}" href="#">{$obj.component}</a>
	<a href="{$obj.path}" target="_blank" class="btn btn-primary btn-sm" title="View page"><i class="glyphicon glyphicon glyphicon-paperclip"></i></a>
	<a href="#" path="{$obj.path}" data-toggle="modal" data-target="#modal_component" target="_blank" class="btn btn-danger btn-select btn-sm" title="Add Sub-component"><i class="glyphicon glyphicon glyphicon-plus"></i></a>
	{if count($obj.kids)}
	<ul>
		{foreach item=kid from=$obj.kids}
		{include file="component.tpl" obj=$kid}
		{/foreach}
	</ul>
	{/if}
</li>
