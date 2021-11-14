<?php

namespace Yrial\Simrandom\Tests\Repository;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Yrial\Simrandom\Entity\SavedChallenge;

class SavedChallengeRepositoryTest extends KernelTestCase
{

    private ?EntityManager $entityManager;

    public function testSaveChallenge()
    {
        $savedChallenge = new SavedChallenge();
        $savedChallenge->setName('puipoupi');

        $repo = $this->entityManager
            ->getRepository(SavedChallenge::class);

        $savedChallenge = $repo->savedChallenge($savedChallenge);

        $this->assertNotEmpty($savedChallenge->getId());


    }

    public function testRemoveOldLinks()
    {

    }

    public function testFinishedChallenge()
    {

    }

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
