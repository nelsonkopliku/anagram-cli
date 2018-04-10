<?php

namespace Tests;

use App\Command\AnagramCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Console\Application;

class AnagramCommandTest extends TestCase
{
    private static $anagram = 'abc';

    private static $searchIn = 'itookablackcab';

    public function testExecuteAnagramTrueResponse()
    {
        $application = new Application();
        $application->add(new AnagramCommand());
        $commandTester = new CommandTester($command = $application->get('app:anagram'));
        $commandTester->execute(['command' => $command->getName(), 'a' => static::$anagram, 'b' => static::$searchIn], ['decorated' => false]);

        $this->assertRegExp('/true/', $commandTester->getDisplay());
    }

    public function testExecuteAnagramFalseResponse()
    {
        $application = new Application();
        $application->add(new AnagramCommand());
        $commandTester = new CommandTester($command = $application->get('app:anagram'));
        $commandTester->execute(['command' => $command->getName(), 'a' => static::$anagram, 'b' => 'rqweropiqwue9483752'], ['decorated' => false]);

        $this->assertRegExp('/false/', $commandTester->getDisplay());
    }

    public function testExecuteAnagramArgumentTooLong()
    {
        $application = new Application();
        $application->add(new AnagramCommand());
        $commandTester = new CommandTester($command = $application->get('app:anagram'));
        $commandTester->execute(
            ['command' => $command->getName(), 'a' => str_repeat(static::$anagram, 1000), 'b' => static::$searchIn], ['decorated' => false]
        );

        $this->assertRegExp('/\[ERROR\] Argument too long, maximum allowed 1024/', trim($commandTester->getDisplay(true)));

        $commandTester->execute(
            ['command' => $command->getName(), 'a' => static::$anagram, 'b' => str_repeat(static::$searchIn, 1000)], ['decorated' => false]
        );

        $this->assertRegExp('/\[ERROR\] Argument too long, maximum allowed 1024/', trim($commandTester->getDisplay(true)));
    }

    public function testExecuteAnagramBothArgumentsTooLong()
    {
        $application = new Application();
        $application->add(new AnagramCommand());
        $commandTester = new CommandTester($command = $application->get('app:anagram'));
        $commandTester->execute(
            ['command' => $command->getName(), 'a' => str_repeat(static::$anagram, 1000), 'b' => str_repeat(static::$searchIn, 1000)], ['decorated' => false]
        );

        $this->assertRegExp('/\[ERROR\] Argument too long, maximum allowed 1024/', trim($commandTester->getDisplay(true)));
    }
}
