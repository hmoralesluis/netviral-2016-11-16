<?php
namespace App\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use App\AdminBundle\Entity\TransactionType;

class LoadTransactionTypeData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $path = 'web/bundles/admin/data/TransactionType.csv';
        if (!file_exists($path))
            exit("File not found");
        $rows = file($path);
        foreach ($rows as $row) {
            $fields = explode(";", $row);
            $transactiontype = new TransactionType();
            $transactiontype->setName($fields[0]);
            $manager->persist($transactiontype);
        }
        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 9; // the order in which fixtures will be loaded
    }
}