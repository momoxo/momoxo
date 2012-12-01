#!/usr/bin/env phpunit --colors --strict
<?php

require_once __DIR__ . '/auto-use-source.php';

$cases = array();

$cases[1]['source'] = '<?php

require "../../mainfile.php";';
$cases[1]['expected'] = '<?php

use XCore\Kernel\Root;

require "../../mainfile.php";';

// ✄ - - - - - - - - - - - - - - - - - - - - - - - -

$cases[2]['source'] = '<?php
/**
 * comment
 */

require "../../mainfile.php";';
$cases[2]['expected'] = '<?php
/**
 * comment
 */

use XCore\Kernel\Root;

require "../../mainfile.php";';

// ✄ - - - - - - - - - - - - - - - - - - - - - - - -

$cases[3]['source'] = '<?php
/**
 * comment
 */

namespace Foo;

require "../../mainfile.php";';
$cases[3]['expected'] = '<?php
/**
 * comment
 */

namespace Foo;

use XCore\Kernel\Root;

require "../../mainfile.php";';

// ✄ - - - - - - - - - - - - - - - - - - - - - - - -

$cases[4]['source'] = '<?php

namespace Foo;

use Foo\Bar\Baz;
use Foo\Bar\Baz2;

require "../../mainfile.php";
';

$cases[4]['expected'] = '<?php

namespace Foo;

use Foo\Bar\Baz;
use Foo\Bar\Baz2;
use XCore\Kernel\Root;

require "../../mainfile.php";
';

// ✄ - - - - - - - - - - - - - - - - - - - - - - - -

$cases[5]['source'] = '<?php
/**
 *
 * @package Xcore
 * @version $Id: admin.php,v 1.3 2008/09/25 15:10:19 kilica Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <https://github.com/momoxo/momoxo>
 * @license https://github.com/momoxo/momoxo/blob/master/docs/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */
/*------------------------------------------------------------------------*
 |  This file was entirely rewritten by the XOOPS Cube Legacy project for |
 |   keeping compatibility with XOOPS 2.0.x <http://www.xoops.org>        |
 *------------------------------------------------------------------------*/

include "mainfile.php";
';
$cases[5]['expected'] = '<?php
/**
 *
 * @package Xcore
 * @version $Id: admin.php,v 1.3 2008/09/25 15:10:19 kilica Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <https://github.com/momoxo/momoxo>
 * @license https://github.com/momoxo/momoxo/blob/master/docs/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */
/*------------------------------------------------------------------------*
 |  This file was entirely rewritten by the XOOPS Cube Legacy project for |
 |   keeping compatibility with XOOPS 2.0.x <http://www.xoops.org>        |
 *------------------------------------------------------------------------*/

use XCore\Kernel\Root;

include "mainfile.php";
';

// ✄ - - - - - - - - - - - - - - - - - - - - - - - -


$cases[6]['source'] = '<?php

namespace Foo;

use Foo\Bar\Baz;

require "../../mainfile.php";
';

$cases[6]['expected'] = '<?php

namespace Foo;

use Foo\Bar\Baz;
use XCore\Kernel\Root;

require "../../mainfile.php";
';

// ✄ - - - - - - - - - - - - - - - - - - - - - - - -


$cases[7]['source'] = '<?php

namespace Foo\Bar;

use Foo\Bar\Baz;
use Foo\Bar\Hoge;

/**
 * Comment
 */
class ClassName
{
}';

$cases[7]['expected'] =  '<?php

namespace Foo\Bar;

use Foo\Bar\Baz;
use Foo\Bar\Hoge;
use XCore\Kernel\Root;

/**
 * Comment
 */
class ClassName
{
}';

// ✄ - - - - - - - - - - - - - - - - - - - - - - - -

class AutoNamespaceTest extends PHPUnit_Framework_TestCase
{
	public function test_auto_use()
	{
		$case = $GLOBALS['cases'][1];
		$this->assertSame($case['expected'], auto_use($case['source'], 'XCore\Kernel\Root'));
	}

	public function test_auto_use_with_comment()
	{
		$case = $GLOBALS['cases'][2];
		$this->assertSame($case['expected'], auto_use($case['source'], 'XCore\Kernel\Root'));
	}

	public function test_auto_use_with_namespace()
	{
		$case = $GLOBALS['cases'][3];
		$this->assertSame($case['expected'], auto_use($case['source'], 'XCore\Kernel\Root'));
	}

	public function test_auto_use_with_use()
	{
		$case = $GLOBALS['cases'][4];
		$this->assertSame($case['expected'], auto_use($case['source'], 'XCore\Kernel\Root'));
	}

	public function test_auto_use_5()
	{
		$case = $GLOBALS['cases'][5];
		$this->assertSame($case['expected'], auto_use($case['source'], 'XCore\Kernel\Root'));
	}

	public function test_auto_use_6()
	{
		$case = $GLOBALS['cases'][6];
		$this->assertSame($case['expected'], auto_use($case['source'], 'XCore\Kernel\Root'));
	}

	public function test_auto_use_7()
	{
		$case = $GLOBALS['cases'][7];
		$this->assertSame($case['expected'], auto_use($case['source'], 'XCore\Kernel\Root'));
	}
}