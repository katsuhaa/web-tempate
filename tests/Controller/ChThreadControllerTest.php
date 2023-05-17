<?php

namespace App\Test\Controller;

use App\Entity\ChThread;
use App\Repository\ChThreadRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ChThreadControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private ChThreadRepository $repository;
    private string $path = '/ch/thread/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(ChThread::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('ChThread index');

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
            'ch_thread[thread_title]' => 'Testing',
            'ch_thread[parent_id]' => 'Testing',
            'ch_thread[create_date]' => 'Testing',
            'ch_thread[update_date]' => 'Testing',
        ]);

        self::assertResponseRedirects('/ch/thread/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new ChThread();
        $fixture->setThread_title('My Title');
        $fixture->setParent_id('My Title');
        $fixture->setCreate_date('My Title');
        $fixture->setUpdate_date('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('ChThread');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new ChThread();
        $fixture->setThread_title('My Title');
        $fixture->setParent_id('My Title');
        $fixture->setCreate_date('My Title');
        $fixture->setUpdate_date('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'ch_thread[thread_title]' => 'Something New',
            'ch_thread[parent_id]' => 'Something New',
            'ch_thread[create_date]' => 'Something New',
            'ch_thread[update_date]' => 'Something New',
        ]);

        self::assertResponseRedirects('/ch/thread/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getThread_title());
        self::assertSame('Something New', $fixture[0]->getParent_id());
        self::assertSame('Something New', $fixture[0]->getCreate_date());
        self::assertSame('Something New', $fixture[0]->getUpdate_date());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new ChThread();
        $fixture->setThread_title('My Title');
        $fixture->setParent_id('My Title');
        $fixture->setCreate_date('My Title');
        $fixture->setUpdate_date('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/ch/thread/');
    }
}
