<li>
	{if count($obj.kids)}<span><i class="glyphicon glyphicon-minus-sign"></i></span>{/if} <a class="btn btn-default btn-select" path="{$obj.path}" href="#">{$obj.component}</a>
	<a href="{$obj.path}" target="_blank" class="btn btn-primary"><i class="glyphicon glyphicon glyphicon-paperclip"></i></a>
	{if count($obj.kids)}
	<ul>
		{foreach item=kid from=$obj.kids}
		{include file="component.tpl" obj=$kid}
		{/foreach}
	</ul>
	{/if}
</li>
