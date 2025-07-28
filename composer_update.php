<?php
putenv('COMPOSER_HOME=' . __DIR__ . '/vendor/bin/composer');
echo shell_exec('composer update maatwebsite/excel 2>&1');
?>
