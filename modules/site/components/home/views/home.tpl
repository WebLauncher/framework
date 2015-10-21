
{if isset_or($subpage)}
{$subpage}
{else}
<div class="panel panel-primary">
	<div class="panel-body">
		<div class="col-md-6">
			<a href="{$root}?a=__sys_trace" class="btn btn-primary">Start building using System Tools</a>
			<p>
				<h4>Start editing you site by changing:</h4>
				- <strong>/modules/site/views/index.tpl</strong> for general layout <br/>
				- <strong>/modules/site/components/home/views/home.tpl</strong> for home page 
			</p>
		</div>
		<div class="col-md-6">
			<p>
				<h4>
					For configurations edit:
				</h4>
				- config.php<br/>
				- config.development.php<br/>
				- config.production.php<br/>
			</p>
		</div>
	</div>
</div>
<div class="panel panel-primary">
	<div class="panel-heading">System Check</div>
	<div class="panel-body">
		<iframe src="{$root}_check" frameborder="0" width="100%" height="200px"></iframe>
	</div>
</div>

<h2>Learn <strong>WebLauncher Framework</strong></h2>
<div class="panel panel-primary">
	<div class="panel-body">
		<div class="col-md-6">
			<p>
				<h4>Read the book</h4>
				<a href="http://www.weblauncher.ro/book">Current documentation</a>
			</p>
		</div>
		<div class="col-md-6">
			<p>
				<h4>
					Read More
				</h4>
				<a href="http://www.weblauncher.ro/docs/home/">New developer home</a>
			</p>
		</div>
	</div>
</div>

<h2>Contribute on <strong>WebLauncher Framework</strong></h2>
<div class="panel panel-primary">
	<div class="panel-body">
		<div class="col-md-6">
			<p>
				<h4>Framework</h4>
				<a href="https://github.com/WebLauncher/framework">Stable version</a>
			</p>
		</div>
		<div class="col-md-6">
			<p>
				<h4>
					Book
				</h4>
				<a href="https://github.com/WebLauncher/book">Help make the book better</a>
			</p>
		</div>
	</div>
</div>
{/if}
