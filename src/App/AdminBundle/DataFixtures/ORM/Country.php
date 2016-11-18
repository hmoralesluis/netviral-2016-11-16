<?php
namespace App\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use App\AdminBundle\Entity\Country;

class LoadCountryData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $path = 'web/bundles/admin/data/Country.csv';
        if (!file_exists($path))
            exit("File not found");
        $rows = file($path);
        foreach ($rows as $row) {
            $fields = explode(";", $row);
            $country = new Country();
            $country->setName($fields[0]);
            $country->setAlpha2Code($fields[1]);
            $country->setAlpha3Code($fields[2]);
            $country->setNumericCode($fields[3]);
            $manager->persist($country);
        }
        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }
}