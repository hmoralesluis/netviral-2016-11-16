<?php
namespace App\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use App\AdminBundle\Entity\ShopSubcategory;

class LoadShopSubcategoryData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $subcategorias = array(
            array('category_id'=>'1','name'=>'FACEBOOK ACCOUNTS'),
            array('category_id'=>'1','name'=>'FACEBOOK FOLLOWERS'),
            array('category_id'=>'1','name'=>'FACEBOOK GROUP MEMBERS'),
            array('category_id'=>'1','name'=>'FACEBOOK LIKES'),
            array('category_id'=>'1','name'=>'FACEBOOK LIKES COMMENT'),
            array('category_id'=>'1','name'=>'FACEBOOK LIKES PHOTO'),
            array('category_id'=>'1','name'=>'FACEBOOK SHARES'),
            array('category_id'=>'1','name'=>'FACEBOOK VOTES'),
            array('category_id'=>'2','name'=>'TWITTER FAVOURITES'),
            array('category_id'=>'2','name'=>'TWITTER FOLLOWERS'),
            array('category_id'=>'2','name'=>'TWITTER RETWEETS'),
            array('category_id'=>'3','name'=>'INSTAGRAM FOLLOWERS'),
            array('category_id'=>'3','name'=>'INSTAGRAM LIKES'),
            array('category_id'=>'3','name'=>'INSTAGRAM COMMENTS'),
            array('category_id'=>'4','name'=>'YOUTUBE VIEWS'),
            array('category_id'=>'4','name'=>'YOUTUBE LIKES'),
            array('category_id'=>'4','name'=>'YOUTUBE SUBSCRIBERS'),
            array('category_id'=>'4','name'=>'YOUTUBE SHARES'),
            array('category_id'=>'4','name'=>'YOUTUBE DISLIKES'),
            array('category_id'=>'5','name'=>'PINTEREST FOLLOWERS'),
            array('category_id'=>'5','name'=>'PINTEREST REPINS'),
            array('category_id'=>'5','name'=>'PINTEREST LIKES'),
            array('category_id'=>'6','name'=>'GOOGLE+ FOLLOWERS'),
            array('category_id'=>'6','name'=>'GOOGLE+ CIRCLES'),
            array('category_id'=>'6','name'=>'GOOGLE+ SHARES'),
            array('category_id'=>'7','name'=>'TRAFFIC WEB'),
            array('category_id'=>'8','name'=>'GSA BACK LINKS'),
            array('category_id'=>'9','name'=>'SOUNCLOUD PLAYS'),
            array('category_id'=>'9','name'=>'SOUNDCLOUD FOLLOWERS'),
            array('category_id'=>'10','name'=>'DATABASE'),
            array('category_id'=>'11','name'=>'WHATSAPP MARKETING'),
            array('category_id'=>'12','name'=>'DESIGN'),
        );

        foreach ($subcategorias as $subcategoria) {
            $country = new ShopSubcategory();
            //$country->setcategory($subcategoria['category_id']);
            $country->setName($subcategoria['name']);
            $manager->persist($country);
        }
        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 10; // the order in which fixtures will be loaded
    }
}