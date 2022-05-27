<?php

namespace Yrial\Simrandom\Application\Inflector;

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
use Yrial\Simrandom\Domain\Command\Challenge\FindChallenge\FindChallengeCommand;
use Yrial\Simrandom\Domain\Command\Challenge\FindChallenge\JsonDetailChallengeCommand;
use Yrial\Simrandom\Domain\Command\Challenge\GetChallenge\GetChallengeCommand;
use Yrial\Simrandom\Domain\Command\Challenge\GetChallenge\JsonListChallengeCommand;
use Yrial\Simrandom\Domain\Command\Cleaning\CleaningCommand;
use Yrial\Simrandom\Domain\Command\Result\GenerateResultCommand;
use Yrial\Simrandom\Domain\Command\Result\JsonResultCommand;
use Yrial\Simrandom\Domain\Command\Result\SavedResultCommand;
use Yrial\Simrandom\Domain\Command\SavedChallenge\FindSavedChallengeCommand;
use Yrial\Simrandom\Domain\Command\SavedChallenge\JsonFindSavedChallenge;
use Yrial\Simrandom\Domain\Command\SavedChallenge\JsonRememberedChallengeCommand;
use Yrial\Simrandom\Domain\Command\SavedChallenge\RememberChallengeCommand;

enum HandlerCommand: string
{
    case GenerateResultCommand = GenerateResultCommand::class;
    case SavedResultCommand = SavedResultCommand::class;
    case JsonResultCommand = JsonResultCommand::class;
    case GetChallengeCommand = GetChallengeCommand::class;
    case JsonListChallengeCommand = JsonListChallengeCommand::class;
    case FindChallengeCommand = FindChallengeCommand::class;
    case JsonDetailChallengeCommand = JsonDetailChallengeCommand::class;
    case SaveChallengeCommand = RememberChallengeCommand::class;
    case JsonSavingChallengeCommand = JsonRememberedChallengeCommand::class;
    case FindSavedChallengeCommand = FindSavedChallengeCommand::class;
    case JsonFindSavedChallengeCommand = JsonFindSavedChallenge::class;
    case CleaningCommand = CleaningCommand::class;

    /**
     * @return string
     */
    public function getHandlerClass(): string
    {
        return match ($this) {
            HandlerCommand::GenerateResultCommand => GenerateResultHandler::class,
            HandlerCommand::SavedResultCommand => SavedResultHandler::class,
            HandlerCommand::JsonResultCommand => JsonResultHandler::class,
            HandlerCommand::GetChallengeCommand => GetChallengeHandler::class,
            HandlerCommand::JsonListChallengeCommand => JsonChallengeListHandler::class,
            HandlerCommand::FindChallengeCommand => FindChallengeHandler::class,
            HandlerCommand::JsonDetailChallengeCommand => JsonChallengeDetailHandler::class,
            HandlerCommand::SaveChallengeCommand => SaveChallengeHandler::class,
            HandlerCommand::JsonSavingChallengeCommand, HandlerCommand::JsonFindSavedChallengeCommand => JsonSavingChallengeHandler::class,
            HandlerCommand::FindSavedChallengeCommand => FindSavedChallengeHandler::class,
            HandlerCommand::CleaningCommand => CleaningHandler::class,
        };
    }
}