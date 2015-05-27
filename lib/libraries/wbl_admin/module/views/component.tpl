<li>
	{if count($obj.kids)}<span><i class="glyphicon glyphicon-minus-sign"></i></span>{/if} <a class="btn btn-default" path="{$obj.path}" href="#">{$obj.component}</a>
	{if count($obj.kids)}
	<ul>
		{foreach item=kid from=$obj.kids}
		{include file="component.tpl" obj=$kid}
		{/foreach}
	</ul>
	{/if}
</li>
