<?php
namespace App\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use App\AdminBundle\Entity\Module;

class LoadModuleData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $path = 'web/bundles/admin/data/Module.csv';
        if (!file_exists($path))
            exit("File not found");
        $rows = file($path);
        foreach ($rows as $row) {
            $fields = explode(";", $row);
            $module = new Module();
            $module->setName($fields[0]);
            $module->setOptionPath($fields[1]);
            $module->setDescription($fields[2]);
            $module->setLongDescription($fields[3]);
            $module->setCost($fields[4]);
			$module->setActiveDays($fields[5]);
            $module->setOnBody(intval($fields[6]) == 1 ? true : false );
            $manager->persist($module);
        }
        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 4; // the order in which fixtures will be loaded
    }
}