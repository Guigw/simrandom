<?php

namespace Yrial\Simrandom\Application\Inflector;

use Yrial\Simrandom\Application\Command\ChallengeDraw\ChallengeDrawCommand;
use Yrial\Simrandom\Application\Handler\Challenge\FindChallengeHandler;
use Yrial\Simrandom\Application\Handler\Challenge\GetChallengeHandler;
use Yrial\Simrandom\Application\Handler\ChallengeDraw\ChallengeDrawCommandHandler;
use Yrial\Simrandom\Application\Handler\ChallengeDraw\FindChallengeDrawHandler;
use Yrial\Simrandom\Application\Handler\Draw\DrawHandler;
use Yrial\Simrandom\Application\Query\DrawQuery;
use Yrial\Simrandom\Application\Query\FindChallengeDrawQuery;
use Yrial\Simrandom\Application\Query\FindChallengeQuery;
use Yrial\Simrandom\Application\Query\GetChallengeQuery;
use Yrial\Simrandom\Domain\Command\ChallengeDraw\ChallengeDrawCommand as DomainChallengeDrawCommand;
use Yrial\Simrandom\Domain\Handler\Challenge\FindChallengeHandler as DomainFindChallengeHandler;
use Yrial\Simrandom\Domain\Handler\Challenge\GetChallengeHandler as DomainGetChallengeHandler;
use Yrial\Simrandom\Domain\Handler\ChallengeDraw\FindChallengeDrawHandler as DomainFindChallengeDrawHandler;
use Yrial\Simrandom\Domain\Handler\ChallengeDraw\SaveChallengeDrawHandler;
use Yrial\Simrandom\Domain\Handler\Draw\DrawHandler as DomainDrawHandler;
use Yrial\Simrandom\Domain\Handler\Draw\SaveDrawHandler;
use Yrial\Simrandom\Domain\Query\Challenge\Find\ChallengeFindQuery as DomainChallengeFindQuery;
use Yrial\Simrandom\Domain\Query\Challenge\Get\ChallengeGetQuery as DomainChallengeGetQuery;
use Yrial\Simrandom\Domain\Query\ChallengeDraw\FindChallengeDrawQuery as DomainFindChallengeDrawQuery;
use Yrial\Simrandom\Domain\Query\Draw\DrawQuery as DomainDrawQuery;
use Yrial\Simrandom\Domain\Query\Draw\SaveDrawQuery;

enum HandlerCommand: string
{
    case DomainChallengeGetQuery = DomainChallengeGetQuery::class;
    case DomainChallengeFindQuery = DomainChallengeFindQuery::class;
    case DomainDrawQuery = DomainDrawQuery::class;
    case DomainSaveDrawQuery = SaveDrawQuery::class;
    case DomainFindChallengeDrawQuery = DomainFindChallengeDrawQuery::class;
    case DomainChallengeDrawCommand = DomainChallengeDrawCommand::class;
    case ChallengeGetQuery = GetChallengeQuery::class;
    case FindChallengeQuery = FindChallengeQuery::class;
    case DrawQuery = DrawQuery::class;
    case FindChallengeDrawQuery = FindChallengeDrawQuery::class;
    case ChallengeDrawCommand = ChallengeDrawCommand::class;

    /**
     * @return string
     */
    public function getHandlerClass(): string
    {
        return match ($this) {
            HandlerCommand::DomainChallengeGetQuery => DomainGetChallengeHandler::class,
            HandlerCommand::DomainChallengeFindQuery => DomainFindChallengeHandler::class,
            HandlerCommand::ChallengeGetQuery => GetChallengeHandler::class,
            HandlerCommand::FindChallengeQuery => FindChallengeHandler::class,
            HandlerCommand::DomainDrawQuery => DomainDrawHandler::class,
            HandlerCommand::DomainSaveDrawQuery => SaveDrawHandler::class,
            HandlerCommand::DrawQuery => DrawHandler::class,
            HandlerCommand::DomainFindChallengeDrawQuery => DomainFindChallengeDrawHandler::class,
            HandlerCommand::FindChallengeDrawQuery => FindChallengeDrawHandler::class,
            HandlerCommand::DomainChallengeDrawCommand => SaveChallengeDrawHandler::class,
            HandlerCommand::ChallengeDrawCommand => ChallengeDrawCommandHandler::class
        };
    }
}
