<?php

namespace App\Test\Controller;

use App\Entity\Kiban;
use App\Repository\KibanRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class KibanControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private KibanRepository $repository;
    private string $path = '/kiban/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Kiban::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Kiban index');

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
            'kiban[name]' => 'Testing',
            'kiban[various]' => 'Testing',
            'kiban[order_data]' => 'Testing',
            'kiban[due_date]' => 'Testing',
            'kiban[stock_date]' => 'Testing',
        ]);

        self::assertResponseRedirects('/kiban/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Kiban();
        $fixture->setName('My Title');
        $fixture->setVarious('My Title');
        $fixture->setOrder_data('My Title');
        $fixture->setDue_date('My Title');
        $fixture->setStock_date('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Kiban');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Kiban();
        $fixture->setName('My Title');
        $fixture->setVarious('My Title');
        $fixture->setOrder_data('My Title');
        $fixture->setDue_date('My Title');
        $fixture->setStock_date('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'kiban[name]' => 'Something New',
            'kiban[various]' => 'Something New',
            'kiban[order_data]' => 'Something New',
            'kiban[due_date]' => 'Something New',
            'kiban[stock_date]' => 'Something New',
        ]);

        self::assertResponseRedirects('/kiban/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getVarious());
        self::assertSame('Something New', $fixture[0]->getOrder_data());
        self::assertSame('Something New', $fixture[0]->getDue_date());
        self::assertSame('Something New', $fixture[0]->getStock_date());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Kiban();
        $fixture->setName('My Title');
        $fixture->setVarious('My Title');
        $fixture->setOrder_data('My Title');
        $fixture->setDue_date('My Title');
        $fixture->setStock_date('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/kiban/');
    }
}
