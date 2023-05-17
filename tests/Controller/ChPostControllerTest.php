<?php

namespace App\Test\Controller;

use App\Entity\ChPost;
use App\Repository\ChPostRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ChPostControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private ChPostRepository $repository;
    private string $path = '/ch/post/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(ChPost::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('ChPost index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'ch_post[no]' => 'Testing',
            'ch_post[postdata]' => 'Testing',
            'ch_post[thread_id]' => 'Testing',
            'ch_post[date]' => 'Testing',
        ]);

        self::assertResponseRedirects('/ch/post/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new ChPost();
        $fixture->setNo('My Title');
        $fixture->setPostdata('My Title');
        $fixture->setThread_id('My Title');
        $fixture->setDate('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('ChPost');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new ChPost();
        $fixture->setNo('My Title');
        $fixture->setPostdata('My Title');
        $fixture->setThread_id('My Title');
        $fixture->setDate('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'ch_post[no]' => 'Something New',
            'ch_post[postdata]' => 'Something New',
            'ch_post[thread_id]' => 'Something New',
            'ch_post[date]' => 'Something New',
        ]);

        self::assertResponseRedirects('/ch/post/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNo());
        self::assertSame('Something New', $fixture[0]->getPostdata());
        self::assertSame('Something New', $fixture[0]->getThread_id());
        self::assertSame('Something New', $fixture[0]->getDate());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new ChPost();
        $fixture->setNo('My Title');
        $fixture->setPostdata('My Title');
        $fixture->setThread_id('My Title');
        $fixture->setDate('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/ch/post/');
    }
}
