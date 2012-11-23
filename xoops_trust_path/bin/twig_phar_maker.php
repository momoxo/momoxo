<?php

$twig_dir = '/tmp/Twig';

if (is_dir($twig_dir)) {
  system("cd {$twig_dir} && git checkout master && git pull --rebase");
} else {
  system("git clone git://github.com/fabpot/Twig.git {$twig_dir}");
}

$versions = explode("\n", trim(shell_exec("cd {$twig_dir}; git tag")));
$latest_version = array_shift($versions);
foreach ($versions as $version) {
  if (version_compare($latest_version, $version, "<")) {
    $latest_version = $version;
  }
}
system("cd {$twig_dir}; git checkout {$latest_version}");

$phar = new Phar('twig.phar', 0, 'twig.phar');
$phar->buildFromDirectory($twig_dir . '/lib');
$phar->compressFiles(Phar::GZ);
$phar->setStub('
<?php
require_once "phar://twig.phar/Twig/Autoloader.php";
Twig_Autoloader::register();
__HALT_COMPILER();
?>
');

echo 'Created!!';
