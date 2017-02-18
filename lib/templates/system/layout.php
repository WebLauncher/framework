<?php if ($render_type == 'all'): ?>

    <?php echo $p['doctype']; ?>
    <?php echo $p['html_tag']; ?>
    <head>
        <meta http-equiv="Content-Type" content="{$p.content_type}"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <?php foreach ($p['meta_tags'] as $tag) {
            echo '<meta name="' . $tag['name'] . '" content="' . $tag['content'] . '" />';
        } ?>
        <title><?php echo tr($p['title'], 0, "titles"); ?></title>

        <?php echo eval($__before_skin); ?>

        <?php foreach ($p['css_files'] as $style) {
            if ($style['browser_cond'])
                echo '<!--[' . $style['browser_cond'] . ']>';
            echo '<link rel="stylesheet" type="' . $style['type'] . '" href="' . eval($style['href']) . '" media="' . $style['media'] . '"/>';
        } ?>

        <?php foreach ($p['js_files'] as $js) {
            echo '<script src="' . eval($js['src']) . '" type="' . $js['type'] . '"></script>';
        } ?>

        <?php if (isset_or($p['session']['script'])) {
            echo '<script src="' . $root_module . 'script_file_' . $random . '.js" type="text/javascript"></script>';
        } ?>

        <?php echo isset_or($page_before_close_head); ?>
    </head>
    <?php echo $p['body_tag']; ?>
    <?php echo isset_or($page_after_start_body); ?>
    <noscript><?php echo eval(isset_or($__noscript)); ?></noscript>
    <?php echo isset_or($p['settings']['before_page_text']); ?>
    <?php echo $page_trace; ?>
    <?php echo $page; ?>
    <?php echo isset_or($p['settings']['after_page_text']['value']); ?>
    <?php echo isset_or($page_before_close_body); ?>
    </body>
    <?php echo isset_or($page_after_body); ?>
    </html>

<?php else: ?>
    <?php echo eval(${$render_type}); ?>
    <?php echo $bottom_script; ?>
<?php endif; ?>