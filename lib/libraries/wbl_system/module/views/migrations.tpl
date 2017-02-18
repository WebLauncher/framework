<ul class="list-group">
    {foreach item="migration" from=$migrations key=key}
        <li class="list-group-item">
            <span class="glyphicon glyphicon-inbox text-primary"></span>
            <span class="text-primary">{$migration}</span>
            <a href="#" class="btn btn-primary badge btn-run-migration" migration="{$key}:{$migration}" title="Run"><span class="glyphicon glyphicon-play"></span></a>

        </li>
        {foreachelse}
        <li class="list-group-item">No migrations found.</li>
    {/foreach}
</ul>