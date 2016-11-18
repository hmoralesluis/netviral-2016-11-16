<?php
namespace App\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use App\AdminBundle\Entity\ProductType;
use Doctrine\ORM\EntityNotFoundException;

class LoadProductTypeData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $path = 'web/bundles/admin/data/ProductType.csv';
        if (!file_exists($path))
            exit("File not found");
        $rows = file($path);
        foreach ($rows as $row) {
            $fields = explode(";", $row);
            $producttype = new ProductType();
            $producttype->setName($fields[0]);
            $producttype->setActive($fields[1]);
            $manager->persist($producttype);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 6; // the order in which fixtures will be loaded
    }
}