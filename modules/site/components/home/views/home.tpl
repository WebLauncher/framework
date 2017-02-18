{if isset_or($subpage)}
    {$subpage}
{else}
    <div class="panel panel-primary">
        <div class="panel-body">
            <div class="col-md-9">
                <p>
                <h4>Start editing you site by changing:</h4>
                <p>
                    - <a href="file:///{$p.paths.root_dir}modules/site/views/index.tpl"><strong>{$p.paths.root_dir}
                            modules/site/views/index.tpl</strong></a> for general layout <br/>
                    -
                    <a href="file:///{$p.paths.root_dir}modules/site/components/home/views/home.tpl"><strong>{$p.paths.root_dir}
                            modules/site/components/home/views/home.tpl</strong></a> for home page
                </p>
                <p>
                <h4>
                    For configurations edit:
                </h4>
                <p>
                    - <a href="file:///{$p.paths.root_dir}config.php">{$p.paths.root_dir}config.php</a> global
                    configurations<br/>
                    - <a href="file:///{$p.paths.root_dir}config.development.php">{$p.paths.root_dir}
                        config.development.php</a> development configurations<br/>
                    - <a href="file:///{$p.paths.root_dir}config.production.php">{$p.paths.root_dir}
                        config.production.php</a> production configurations<br/>
                </p>
            </div>
            <div class="col-md-3">
                <a href="{$root}_system#build" class="btn btn-primary btn-block">Build using System Tools</a>
                <a href="{$root}_system#phpinfo" class="btn btn-primary btn-block">PHPInfo in System Tools</a>
            </div>
        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading">System Check</div>
        <div class="panel-body">
            <iframe src="{$root}_check" frameborder="0" width="100%" height="200px"></iframe>
        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading">Learn <strong>WebLauncher Framework</strong></div>
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
    <div class="panel panel-primary">
        <div class="panel-heading">Contribute on <strong>WebLauncher Framework</strong></div>
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
