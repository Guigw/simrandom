<?php

namespace Yrial\Simrandom\Tests\Unit\Application\Inflector;

use PHPUnit\Framework\TestCase;
use Yrial\Simrandom\Application\Handler\Challenge\FindChallengeHandler;
use Yrial\Simrandom\Application\Handler\Challenge\GetChallengeHandler;
use Yrial\Simrandom\Application\Handler\Challenge\JsonChallengeDetailHandler;
use Yrial\Simrandom\Application\Handler\Challenge\JsonChallengeListHandler;
use Yrial\Simrandom\Application\Handler\Cleaning\CleaningHandler;
use Yrial\Simrandom\Application\Handler\Result\GenerateResultHandler;
use Yrial\Simrandom\Application\Handler\Result\JsonResultHandler;
use Yrial\Simrandom\Application\Handler\Result\SavedResultHandler;
use Yrial\Simrandom\Application\Handler\SavedChallenge\FindSavedChallengeHandler;
use Yrial\Simrandom\Application\Handler\SavedChallenge\JsonSavingChallengeHandler;
use Yrial\Simrandom\Application\Handler\SavedChallenge\SaveChallengeHandler;
use Yrial\Simrandom\Application\Inflector\HandlerCommand;

class HandlerCommandTest extends TestCase
{

    public function testGetHandlerClass()
    {
        $this->assertEquals(GenerateResultHandler::class, HandlerCommand::GenerateResultCommand->getHandlerClass());
        $this->assertEquals(SavedResultHandler::class, HandlerCommand::SavedResultCommand->getHandlerClass());
        $this->assertEquals(JsonResultHandler::class, HandlerCommand::JsonResultCommand->getHandlerClass());
        $this->assertEquals(GetChallengeHandler::class, HandlerCommand::GetChallengeCommand->getHandlerClass());
        $this->assertEquals(JsonChallengeListHandler::class, HandlerCommand::JsonListChallengeCommand->getHandlerClass());
        $this->assertEquals(FindChallengeHandler::class, HandlerCommand::FindChallengeCommand->getHandlerClass());
        $this->assertEquals(JsonChallengeDetailHandler::class, HandlerCommand::JsonDetailChallengeCommand->getHandlerClass());
        $this->assertEquals(SaveChallengeHandler::class, HandlerCommand::SaveChallengeCommand->getHandlerClass());
        $this->assertEquals(JsonSavingChallengeHandler::class, HandlerCommand::JsonSavingChallengeCommand->getHandlerClass());
        $this->assertEquals(JsonSavingChallengeHandler::class, HandlerCommand::JsonFindSavedChallengeCommand->getHandlerClass());
        $this->assertEquals(FindSavedChallengeHandler::class, HandlerCommand::FindSavedChallengeCommand->getHandlerClass());
        $this->assertEquals(CleaningHandler::class, HandlerCommand::CleaningCommand->getHandlerClass());
    }

    public function testValues()
    {
        $values = HandlerCommand::cases();
        $this->assertCount(12, $values);
        $this->assertContains(HandlerCommand::GenerateResultCommand, $values);
        $this->assertContains(HandlerCommand::SavedResultCommand, $values);
        $this->assertContains(HandlerCommand::JsonResultCommand, $values);
        $this->assertContains(HandlerCommand::GetChallengeCommand, $values);
        $this->assertContains(HandlerCommand::JsonListChallengeCommand, $values);
        $this->assertContains(HandlerCommand::FindChallengeCommand, $values);
        $this->assertContains(HandlerCommand::JsonDetailChallengeCommand, $values);
        $this->assertContains(HandlerCommand::SaveChallengeCommand, $values);
        $this->assertContains(HandlerCommand::JsonSavingChallengeCommand, $values);
        $this->assertContains(HandlerCommand::FindSavedChallengeCommand, $values);
        $this->assertContains(HandlerCommand::JsonFindSavedChallengeCommand, $values);
        $this->assertContains(HandlerCommand::CleaningCommand, $values);
    }
}
