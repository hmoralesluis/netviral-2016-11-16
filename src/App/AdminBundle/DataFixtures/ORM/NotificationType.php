<?php
namespace App\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use App\AdminBundle\Entity\NotificationType;
use Doctrine\ORM\EntityNotFoundException;

class LoadNotificationTypeData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $path = 'web/bundles/admin/data/NotificationType.csv';
        if (!file_exists($path))
            exit("File not found");
        $rows = file($path);
        foreach ($rows as $row) {
            $fields = explode(";", $row);
            $notificationtype = new NotificationType();
            $notificationtype->setName($fields[0]);
            $manager->persist($notificationtype);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 7; // the order in which fixtures will be loaded
    }
}