<?php

namespace Xoops\Tests\Unit\Logger;

use Mockery as m;
use Xoops\Logger\CompositeLogger;

class CompositeLoggerTest extends \PHPUnit_Framework_TestCase
{
    public function testAttachAndDetach()
    {
        $compositeLogger = new CompositeLogger();

        $leafLogger = m::mock('Psr\Log\LoggerInterface');
        $leafLogger->shouldReceive('log')->once();

        $compositeLogger->attach($leafLogger);

        $compositeLogger->log('DUMMY_LEVEL', 'DUMMY_MESSAGE');

        $compositeLogger->detach($leafLogger);

        $compositeLogger->log('DUMMY_LEVEL', 'DUMMY_MESSAGE');
    }

    public function testMultipleLoggers()
    {
        $logger1 = m::mock('Psr\Log\LoggerInterface');
        $logger2 = m::mock('Psr\Log\LoggerInterface');

        $logger1->shouldReceive('log')->once();
        $logger2->shouldReceive('log')->once();

        $compositeLogger = new CompositeLogger();
        $compositeLogger->attach($logger1);
        $compositeLogger->attach($logger2);
        $compositeLogger->log('LEVEL', 'MESSAGE');
    }

    public function testEmergency()
    {
        $logger = m::mock('Psr\Log\LoggerInterface');
        $logger->shouldReceive('emergency')->with('MESSAGE', array('CONTEXT'))->once();

        $compositeLogger = new CompositeLogger();
        $compositeLogger->attach($logger);
        $compositeLogger->emergency('MESSAGE', array('CONTEXT'));
    }

    public function testAlert()
    {
        $logger = m::mock('Psr\Log\LoggerInterface');
        $logger->shouldReceive('alert')->with('MESSAGE', array('CONTEXT'))->once();

        $compositeLogger = new CompositeLogger();
        $compositeLogger->attach($logger);
        $compositeLogger->alert('MESSAGE', array('CONTEXT'));
    }

    public function testCritical()
    {
        $logger = m::mock('Psr\Log\LoggerInterface');
        $logger->shouldReceive('critical')->with('MESSAGE', array('CONTEXT'))->once();

        $compositeLogger = new CompositeLogger();
        $compositeLogger->attach($logger);
        $compositeLogger->critical('MESSAGE', array('CONTEXT'));
    }

    public function testError()
    {
        $logger = m::mock('Psr\Log\LoggerInterface');
        $logger->shouldReceive('error')->with('MESSAGE', array('CONTEXT'))->once();

        $compositeLogger = new CompositeLogger();
        $compositeLogger->attach($logger);
        $compositeLogger->error('MESSAGE', array('CONTEXT'));
    }

    public function testWarning()
    {
        $logger = m::mock('Psr\Log\LoggerInterface');
        $logger->shouldReceive('warning')->with('MESSAGE', array('CONTEXT'))->once();

        $compositeLogger = new CompositeLogger();
        $compositeLogger->attach($logger);
        $compositeLogger->warning('MESSAGE', array('CONTEXT'));
    }

    public function testNotice()
    {
        $logger = m::mock('Psr\Log\LoggerInterface');
        $logger->shouldReceive('notice')->with('MESSAGE', array('CONTEXT'))->once();

        $compositeLogger = new CompositeLogger();
        $compositeLogger->attach($logger);
        $compositeLogger->notice('MESSAGE', array('CONTEXT'));
    }

    public function testInfo()
    {
        $logger = m::mock('Psr\Log\LoggerInterface');
        $logger->shouldReceive('info')->with('MESSAGE', array('CONTEXT'))->once();

        $compositeLogger = new CompositeLogger();
        $compositeLogger->attach($logger);
        $compositeLogger->info('MESSAGE', array('CONTEXT'));
    }

    public function testDebug()
    {
        $logger = m::mock('Psr\Log\LoggerInterface');
        $logger->shouldReceive('debug')->with('MESSAGE', array('CONTEXT'))->once();

        $compositeLogger = new CompositeLogger();
        $compositeLogger->attach($logger);
        $compositeLogger->debug('MESSAGE', array('CONTEXT'));
    }

    public function testLog()
    {
        $logger = m::mock('Psr\Log\LoggerInterface');
        $logger->shouldReceive('log')->with('LEVEL', 'MESSAGE', array('CONTEXT'))->once();

        $compositeLogger = new CompositeLogger();
        $compositeLogger->attach($logger);
        $compositeLogger->log('LEVEL', 'MESSAGE', array('CONTEXT'));
    }
}