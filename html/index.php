<?php

use XCore\Kernel\DelegateUtils;

require_once './mainfile.php';
require_once './header.php';

$xoopsOption['show_cblock'] = 1;
DelegateUtils::call('Xcorepage.Top.Access');

require_once './footer.php';
