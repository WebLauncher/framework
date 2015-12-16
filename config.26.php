<?php
$this->settings_table = 'x_conf_sys_settings';

$this->libraries_settings['wbl_locale']['table'] = 'x_conf_languages';

$this->libraries_settings['wbl_locale']['texts_table'] = 'x_conf_texts';

$this->libraries_settings['wbl_locale']['translations_table'] = 'x_conf_translations';

$this->libraries_settings['wbl_seo']['metas_table'] = 'x_conf_metas';

$this->libraries_settings['wbl_seo']['links_table'] = 'x_conf_pages';

$this->libraries_settings['wbl_seo']['trackings_table'] = 'x_conf_pages';

$this->logins_logs_table = 'x_conf_visits_logs';

$this->console_cronjobs_db_table = 'x_conf_cronjobs';

$this->mail_queue_table = 'x_conf_pages';

$this->skins_folder = 'skins/';

$this->seo_enabled=true;
$this->settings_enabled=true;

if(!file_exists(__DIR__.'/config.development.php'))
    file_put_contents(__DIR__.'/config.development.php', '<?php ?>');
?>