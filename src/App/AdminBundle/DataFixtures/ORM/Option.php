<?php
namespace App\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use App\AdminBundle\Entity\Option;
use Doctrine\ORM\EntityNotFoundException;

class LoadOptionData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $path = 'web/bundles/admin/data/Option.csv';
        if (!file_exists($path))
            exit("File not found");
        $rows = file($path);
        $associatedList = array();
        $id = 1;
        foreach ($rows as $row) {
            $fields = explode(";", $row);
            $option = new Option();
            $option->setName($fields[1]);
            $option->setPath(empty($fields[2]) ? null : $fields[2]);
            $option->setIcon($fields[3]);
            if (!empty($fields[0]) && !is_null($fields[0])) {
                $associatedList[$id] = intval($fields[0]);
            }
            $manager->persist($option);
            $id++;
        }

        $manager->flush();

        foreach($associatedList as $el => $associated){
            $o = $manager->getRepository('AdminBundle:Option')->find(intval($el));
            $AsociatedOption = $manager->getRepository('AdminBundle:Option')->find(intval($associated));
            $o->setAsociatedOption($AsociatedOption);
        }

        $path = 'web/bundles/admin/data/RoleOption.csv';
        if (!file_exists($path))
            exit("File not found");
        $rows = file($path);
        foreach ($rows as $row) {
            $fields = explode(";", $row);
            if (count($fields) == 2) {
                $option = $manager->getRepository('AdminBundle:Option')->find(intval($fields[1]));
                if(!$option){
                    throw $this->CreateNotFoundException('No se ha encontrado la funcionalidad con id ' . $fields[1]);
                }
                $role = $manager->getRepository('AdminBundle:Role')->find(intval($fields[0]));
                if(!$role){
                    throw $this->CreateNotFoundException('No se ha encontrado el rol con id ' . $fields[0]);
                }
                $role->addOption($option);
            }
        }
        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 3; // the order in which fixtures will be loaded
    }
}