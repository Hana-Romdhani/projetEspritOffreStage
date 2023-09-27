<?php

namespace App\Test\Controller;

use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UtilisateurControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private UtilisateurRepository $repository;
    private string $path = '/gerer/utilisateur/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Utilisateur::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Utilisateur index');

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
            'utilisateur[nom]' => 'Testing',
            'utilisateur[prenom]' => 'Testing',
            'utilisateur[email]' => 'Testing',
            'utilisateur[pwd]' => 'Testing',
            'utilisateur[numeroTel]' => 'Testing',
            'utilisateur[address]' => 'Testing',
            'utilisateur[role]' => 'Testing',
            'utilisateur[urlImage]' => 'Testing',
            'utilisateur[date]' => 'Testing',
            'utilisateur[isdelete]' => 'Testing',
            'utilisateur[datederniereconnx]' => 'Testing',
            'utilisateur[domaineDeCompetence]' => 'Testing',
            'utilisateur[tarifHoraire]' => 'Testing',
            'utilisateur[portfolio]' => 'Testing',
            'utilisateur[siteweb]' => 'Testing',
            'utilisateur[gender]' => 'Testing',
            'utilisateur[description]' => 'Testing',
            'utilisateur[formeJuridique]' => 'Testing',
            'utilisateur[refSpecialite]' => 'Testing',
        ]);

        self::assertResponseRedirects('/gerer/utilisateur/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Utilisateur();
        $fixture->setNom('My Title');
        $fixture->setPrenom('My Title');
        $fixture->setEmail('My Title');
        $fixture->setPwd('My Title');
        $fixture->setNumeroTel('My Title');
        $fixture->setAddress('My Title');
        $fixture->setRole('My Title');
        $fixture->setUrlImage('My Title');
        $fixture->setDate('My Title');
        $fixture->setIsdelete('My Title');
        $fixture->setDatederniereconnx('My Title');
        $fixture->setDomaineDeCompetence('My Title');
        $fixture->setTarifHoraire('My Title');
        $fixture->setPortfolio('My Title');
        $fixture->setSiteweb('My Title');
        $fixture->setGender('My Title');
        $fixture->setDescription('My Title');
        $fixture->setFormeJuridique('My Title');
        $fixture->setRefSpecialite('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Utilisateur');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Utilisateur();
        $fixture->setNom('My Title');
        $fixture->setPrenom('My Title');
        $fixture->setEmail('My Title');
        $fixture->setPwd('My Title');
        $fixture->setNumeroTel('My Title');
        $fixture->setAddress('My Title');
        $fixture->setRole('My Title');
        $fixture->setUrlImage('My Title');
        $fixture->setDate('My Title');
        $fixture->setIsdelete('My Title');
        $fixture->setDatederniereconnx('My Title');
        $fixture->setDomaineDeCompetence('My Title');
        $fixture->setTarifHoraire('My Title');
        $fixture->setPortfolio('My Title');
        $fixture->setSiteweb('My Title');
        $fixture->setGender('My Title');
        $fixture->setDescription('My Title');
        $fixture->setFormeJuridique('My Title');
        $fixture->setRefSpecialite('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'utilisateur[nom]' => 'Something New',
            'utilisateur[prenom]' => 'Something New',
            'utilisateur[email]' => 'Something New',
            'utilisateur[pwd]' => 'Something New',
            'utilisateur[numeroTel]' => 'Something New',
            'utilisateur[address]' => 'Something New',
            'utilisateur[role]' => 'Something New',
            'utilisateur[urlImage]' => 'Something New',
            'utilisateur[date]' => 'Something New',
            'utilisateur[isdelete]' => 'Something New',
            'utilisateur[datederniereconnx]' => 'Something New',
            'utilisateur[domaineDeCompetence]' => 'Something New',
            'utilisateur[tarifHoraire]' => 'Something New',
            'utilisateur[portfolio]' => 'Something New',
            'utilisateur[siteweb]' => 'Something New',
            'utilisateur[gender]' => 'Something New',
            'utilisateur[description]' => 'Something New',
            'utilisateur[formeJuridique]' => 'Something New',
            'utilisateur[refSpecialite]' => 'Something New',
        ]);

        self::assertResponseRedirects('/gerer/utilisateur/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNom());
        self::assertSame('Something New', $fixture[0]->getPrenom());
        self::assertSame('Something New', $fixture[0]->getEmail());
        self::assertSame('Something New', $fixture[0]->getPwd());
        self::assertSame('Something New', $fixture[0]->getNumeroTel());
        self::assertSame('Something New', $fixture[0]->getAddress());
        self::assertSame('Something New', $fixture[0]->getRole());
        self::assertSame('Something New', $fixture[0]->getUrlImage());
        self::assertSame('Something New', $fixture[0]->getDate());
        self::assertSame('Something New', $fixture[0]->getIsdelete());
        self::assertSame('Something New', $fixture[0]->getDatederniereconnx());
        self::assertSame('Something New', $fixture[0]->getDomaineDeCompetence());
        self::assertSame('Something New', $fixture[0]->getTarifHoraire());
        self::assertSame('Something New', $fixture[0]->getPortfolio());
        self::assertSame('Something New', $fixture[0]->getSiteweb());
        self::assertSame('Something New', $fixture[0]->getGender());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getFormeJuridique());
        self::assertSame('Something New', $fixture[0]->getRefSpecialite());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Utilisateur();
        $fixture->setNom('My Title');
        $fixture->setPrenom('My Title');
        $fixture->setEmail('My Title');
        $fixture->setPwd('My Title');
        $fixture->setNumeroTel('My Title');
        $fixture->setAddress('My Title');
        $fixture->setRole('My Title');
        $fixture->setUrlImage('My Title');
        $fixture->setDate('My Title');
        $fixture->setIsdelete('My Title');
        $fixture->setDatederniereconnx('My Title');
        $fixture->setDomaineDeCompetence('My Title');
        $fixture->setTarifHoraire('My Title');
        $fixture->setPortfolio('My Title');
        $fixture->setSiteweb('My Title');
        $fixture->setGender('My Title');
        $fixture->setDescription('My Title');
        $fixture->setFormeJuridique('My Title');
        $fixture->setRefSpecialite('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/gerer/utilisateur/');
    }
}
