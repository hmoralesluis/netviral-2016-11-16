<?php
namespace App\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use App\AdminBundle\Entity\ShopSubcategoryProduct;

class LoadShopSubcategoryProductData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $subcategorias = array(
            array('subcategory_id'=>'1','filename'=>'FACEBOOK/FACEBOOK ACCOUNTS/cambiar-contraseña-de-facebook.png','precio'=>'','Deliverytime'=>''),
            array('subcategory_id'=>'2','filename'=>'FACEBOOK/FACEBOOK FOLLOWERS/10.000 FACEBOOK FOLLOWERS.jpg','precio'=>'199.9','Deliverytime'=>'5-14 DAYS'),
            array('subcategory_id'=>'2','filename'=>'FACEBOOK/FACEBOOK FOLLOWERS/20.000 FACEBOOK FOLLOWERS.jpg','precio'=>'389.9','Deliverytime'=>'7-21 DAYS'),
            array('subcategory_id'=>'2','filename'=>'FACEBOOK/FACEBOOK FOLLOWERS/30.000 FACEBOOK FOLLOWERS.jpg','precio'=>'579.9','Deliverytime'=>'7-25 DAYS'),
            array('subcategory_id'=>'2','filename'=>'FACEBOOK/FACEBOOK FOLLOWERS/50.000 FACEBOOK FOLLOWERS.jpg','precio'=>'899.9','Deliverytime'=>'10-30 DAYS'),
            array('subcategory_id'=>'2','filename'=>'FACEBOOK/FACEBOOK FOLLOWERS/1000 FACEBOOK FOLLOWERS.jpg','precio'=>'29.9','Deliverytime'=>'3-7 DAYS'),
            array('subcategory_id'=>'2','filename'=>'FACEBOOK/FACEBOOK FOLLOWERS/2000 FACEBOOK FOLLOWERS.jpg','precio'=>'49.9','Deliverytime'=>'3-7 DAYS'),
            array('subcategory_id'=>'2','filename'=>'FACEBOOK/FACEBOOK FOLLOWERS/3000 FACEBOOK FOLLOWERS.jpg','precio'=>'69.9','Deliverytime'=>'3-7 DAYS'),
            array('subcategory_id'=>'2','filename'=>'FACEBOOK/FACEBOOK FOLLOWERS/5000 FACEBOOK FOLLOWERS.jpg','precio'=>'99.9','Deliverytime'=>'5-12 DAYS'),
            array('subcategory_id'=>'3','filename'=>'FACEBOOK/FACEBOOK GROUP MEMBERS/10.000 FACEBOOK GROUP MEMBERS.jpg','precio'=>'24.9','Deliverytime'=>'2-7 DAYS'),
            array('subcategory_id'=>'3','filename'=>'FACEBOOK/FACEBOOK GROUP MEMBERS/20.000 FACEBOOK GROUP MEMBERS.jpg','precio'=>'44.95','Deliverytime'=>'2-7 DAYS'),
            array('subcategory_id'=>'3','filename'=>'FACEBOOK/FACEBOOK GROUP MEMBERS/30.000 FACEBOOK GROUP MEMBERS.jpg','precio'=>'65','Deliverytime'=>'3-7 DAYS'),
            array('subcategory_id'=>'3','filename'=>'FACEBOOK/FACEBOOK GROUP MEMBERS/50.000 FACEBOOK GROUP MEMBERS.jpg','precio'=>'99.95','Deliverytime'=>'5-12 DAYS'),
            array('subcategory_id'=>'3','filename'=>'FACEBOOK/FACEBOOK GROUP MEMBERS/100.000 FACEBOOK GROUP MEMBERS.jpg','precio'=>'189','Deliverytime'=>'5-14 DAYS'),
            array('subcategory_id'=>'4','filename'=>'FACEBOOK/FACEBOOK LIKES/500 LIKES.jpg','precio'=>'19.95','Deliverytime'=>'2-4 DAYS'),
            array('subcategory_id'=>'4','filename'=>'FACEBOOK/FACEBOOK LIKES/1000 LIKES.jpg','precio'=>'29.95','Deliverytime'=>'3-4 DAYS'),
            array('subcategory_id'=>'4','filename'=>'FACEBOOK/FACEBOOK LIKES/2000 LIKES.jpg','precio'=>'49.95','Deliverytime'=>'3-7 DAYS'),
            array('subcategory_id'=>'4','filename'=>'FACEBOOK/FACEBOOK LIKES/3000 LIKES.jpg','precio'=>'59','Deliverytime'=>'3-7 DAYS'),
            array('subcategory_id'=>'4','filename'=>'FACEBOOK/FACEBOOK LIKES/5000 LIKES.jpg','precio'=>'99','Deliverytime'=>'3-7 DAYS'),
            array('subcategory_id'=>'4','filename'=>'FACEBOOK/FACEBOOK LIKES/10000 LIKES.jpg','precio'=>'179','Deliverytime'=>'3-10 DAYS'),
            array('subcategory_id'=>'4','filename'=>'FACEBOOK/FACEBOOK LIKES/20000 LIKES.jpg','precio'=>'299','Deliverytime'=>'7-15 DAYS'),
            array('subcategory_id'=>'4','filename'=>'FACEBOOK/FACEBOOK LIKES/30000 LIKES.jpg','precio'=>'395','Deliverytime'=>'7-21 DAYS'),
            array('subcategory_id'=>'4','filename'=>'FACEBOOK/FACEBOOK LIKES/50000 LIKES.jpg','precio'=>'595','Deliverytime'=>'7-25 DAYS'),
            array('subcategory_id'=>'4','filename'=>'FACEBOOK/FACEBOOK LIKES/100.000 LIKES.jpg','precio'=>'1449','Deliverytime'=>'15-35 DAYS'),
            array('subcategory_id'=>'4','filename'=>'FACEBOOK/FACEBOOK LIKES/200.000 LIKES.jpg','precio'=>'2495','Deliverytime'=>'20-50 DAYS'),
            array('subcategory_id'=>'4','filename'=>'FACEBOOK/FACEBOOK LIKES/500.000 LIKES.jpg','precio'=>'3995','Deliverytime'=>'50-100 DAYS'),
            array('subcategory_id'=>'5','filename'=>'FACEBOOK/FACEBOOK LIKES PHOTO/500 LIKES.jpg','precio'=>'0','Deliverytime'=>'0 DAYS'),
            array('subcategory_id'=>'5','filename'=>'FACEBOOK/FACEBOOK LIKES PHOTO/1000 LIKES.jpg','precio'=>'29','Deliverytime'=>'3-4 DAYS'),
            array('subcategory_id'=>'5','filename'=>'FACEBOOK/FACEBOOK LIKES PHOTO/2000 LIKES.jpg','precio'=>'39','Deliverytime'=>'3-7 DAYS'),
            array('subcategory_id'=>'5','filename'=>'FACEBOOK/FACEBOOK LIKES PHOTO/3000 LIKES.jpg','precio'=>'49','Deliverytime'=>'3-7 DAYS'),
            array('subcategory_id'=>'5','filename'=>'FACEBOOK/FACEBOOK LIKES PHOTO/5000 LIKES.jpg','precio'=>'69','Deliverytime'=>'3-10 DAYS'),
            array('subcategory_id'=>'5','filename'=>'FACEBOOK/FACEBOOK LIKES PHOTO/10000 LIKES.jpg','precio'=>'99','Deliverytime'=>'5-15 DAYS'),
            array('subcategory_id'=>'5','filename'=>'FACEBOOK/FACEBOOK LIKES PHOTO/20000 LIKES.jpg','precio'=>'189','Deliverytime'=>'7-21 DAYS'),
            array('subcategory_id'=>'5','filename'=>'FACEBOOK/FACEBOOK LIKES PHOTO/30000 LIKES.jpg','precio'=>'269','Deliverytime'=>'7-21 DAYS'),
            array('subcategory_id'=>'5','filename'=>'FACEBOOK/FACEBOOK LIKES PHOTO/50000 LIKES.jpg','precio'=>'499','Deliverytime'=>'10-35 DAYS'),
            array('subcategory_id'=>'6','filename'=>'FACEBOOK/FACEBOOK LIKES COMMENT/500 LIKES.jpg','precio'=>'0','Deliverytime'=>'0 DAYS'),
            array('subcategory_id'=>'6','filename'=>'FACEBOOK/FACEBOOK LIKES COMMENT/1000 LIKES.jpg','precio'=>'29.9','Deliverytime'=>'3-4 DAYS'),
            array('subcategory_id'=>'6','filename'=>'FACEBOOK/FACEBOOK LIKES COMMENT/2000 LIKES.jpg','precio'=>'39.9','Deliverytime'=>'3-7 DAYS'),
            array('subcategory_id'=>'6','filename'=>'FACEBOOK/FACEBOOK LIKES COMMENT/3000 LIKES.jpg','precio'=>'49.9','Deliverytime'=>'3-7 DAYS'),
            array('subcategory_id'=>'6','filename'=>'FACEBOOK/FACEBOOK LIKES COMMENT/5000 LIKES.jpg','precio'=>'69.9','Deliverytime'=>'3-10 DAYS'),
            array('subcategory_id'=>'6','filename'=>'FACEBOOK/FACEBOOK LIKES COMMENT/10000 LIKES.jpg','precio'=>'99.9','Deliverytime'=>'5-15 DAYS'),
            array('subcategory_id'=>'6','filename'=>'FACEBOOK/FACEBOOK LIKES COMMENT/20000 LIKES.jpg','precio'=>'189.9','Deliverytime'=>'7-21 DAYS'),
            array('subcategory_id'=>'6','filename'=>'FACEBOOK/FACEBOOK LIKES COMMENT/30000 LIKES.jpg','precio'=>'269.9','Deliverytime'=>'7-21 DAYS'),
            array('subcategory_id'=>'6','filename'=>'FACEBOOK/FACEBOOK LIKES COMMENT/50000 LIKES.jpg','precio'=>'499.9','Deliverytime'=>'10-35 DAYS'),
            array('subcategory_id'=>'7','filename'=>'FACEBOOK/FACEBOOK VOTES/facebook votes.png','precio'=>'19','Deliverytime'=>'2-7 DAYS'),
            array('subcategory_id'=>'7','filename'=>'FACEBOOK/FACEBOOK VOTES/facebook votes.png','precio'=>'29','Deliverytime'=>'2-7 DAYS'),
            array('subcategory_id'=>'7','filename'=>'FACEBOOK/FACEBOOK VOTES/facebook votes.png','precio'=>'39','Deliverytime'=>'2-7 DAYS'),
            array('subcategory_id'=>'7','filename'=>'FACEBOOK/FACEBOOK VOTES/facebook votes.png','precio'=>'49','Deliverytime'=>'2-7 DAYS'),
            array('subcategory_id'=>'7','filename'=>'FACEBOOK/FACEBOOK VOTES/facebook votes.png','precio'=>'99','Deliverytime'=>'2-10 DAYS'),
            array('subcategory_id'=>'7','filename'=>'FACEBOOK/FACEBOOK VOTES/facebook votes.png','precio'=>'189','Deliverytime'=>'3-12 DAYS'),
            array('subcategory_id'=>'7','filename'=>'FACEBOOK/FACEBOOK VOTES/facebook votes.png','precio'=>'399','Deliverytime'=>'5-20 DAYS'),
            array('subcategory_id'=>'7','filename'=>'FACEBOOK/FACEBOOK VOTES/facebook votes.png','precio'=>'795','Deliverytime'=>'5-30 DAYS'),
            array('subcategory_id'=>'7','filename'=>'FACEBOOK/FACEBOOK VOTES/facebook votes.png','precio'=>'1499','Deliverytime'=>'7-35 DAYS'),
            array('subcategory_id'=>'8','filename'=>'FACEBOOK/FACEBOOK FOLLOWERS/1000 FACEBOOK FOLLOWERS.jpg','precio'=>'29.9','Deliverytime'=>'3-7 DAYS'),
            array('subcategory_id'=>'8','filename'=>'FACEBOOK/FACEBOOK FOLLOWERS/2000 FACEBOOK FOLLOWERS.jpg','precio'=>'49.9','Deliverytime'=>'3-7 DAYS'),
            array('subcategory_id'=>'8','filename'=>'FACEBOOK/FACEBOOK FOLLOWERS/3000 FACEBOOK FOLLOWERS.jpg','precio'=>'69.9','Deliverytime'=>'3-7 DAYS'),
            array('subcategory_id'=>'8','filename'=>'FACEBOOK/FACEBOOK FOLLOWERS/5000 FACEBOOK FOLLOWERS.jpg','precio'=>'99.9','Deliverytime'=>'5-12 DAYS'),
            array('subcategory_id'=>'8','filename'=>'FACEBOOK/FACEBOOK FOLLOWERS/10.000 FACEBOOK FOLLOWERS.jpg','precio'=>'199.9','Deliverytime'=>'5-14 DAYS'),
            array('subcategory_id'=>'8','filename'=>'FACEBOOK/FACEBOOK FOLLOWERS/20.000 FACEBOOK FOLLOWERS.jpg','precio'=>'389.9','Deliverytime'=>'7-21 DAYS'),
            array('subcategory_id'=>'8','filename'=>'FACEBOOK/FACEBOOK FOLLOWERS/30.000 FACEBOOK FOLLOWERS.jpg','precio'=>'579.9','Deliverytime'=>'7-25 DAYS'),
            array('subcategory_id'=>'8','filename'=>'FACEBOOK/FACEBOOK FOLLOWERS/50.000 FACEBOOK FOLLOWERS.jpg','precio'=>'899.9','Deliverytime'=>'10-30 DAYS'),
            array('subcategory_id'=>'8','filename'=>'FACEBOOK/FACEBOOK FOLLOWERS/100.000 FACEBOOK FOLLOWERS.jpg','precio'=>'1499.9','Deliverytime'=>'10-45 DAYS'),
            array('subcategory_id'=>'9','filename'=>'FACEBOOK/FACEBOOK SHARES/FACEBOOK SHARE.jpg','precio'=>'19','Deliverytime'=>'2-7 DAYS'),
            array('subcategory_id'=>'9','filename'=>'FACEBOOK/FACEBOOK SHARES/FACEBOOK SHARE.jpg','precio'=>'29','Deliverytime'=>'2-7 DAYS'),
            array('subcategory_id'=>'9','filename'=>'FACEBOOK/FACEBOOK SHARES/FACEBOOK SHARE.jpg','precio'=>'39','Deliverytime'=>'2-7 DAYS'),
            array('subcategory_id'=>'9','filename'=>'FACEBOOK/FACEBOOK SHARES/FACEBOOK SHARE.jpg','precio'=>'49','Deliverytime'=>'2-7 DAYS'),
            array('subcategory_id'=>'9','filename'=>'FACEBOOK/FACEBOOK SHARES/FACEBOOK SHARE.jpg','precio'=>'99','Deliverytime'=>'2-10 DAYS'),
            array('subcategory_id'=>'9','filename'=>'FACEBOOK/FACEBOOK SHARES/FACEBOOK SHARE.jpg','precio'=>'189','Deliverytime'=>'3-12 DAYS'),
            array('subcategory_id'=>'9','filename'=>'FACEBOOK/FACEBOOK SHARES/FACEBOOK SHARE.jpg','precio'=>'399','Deliverytime'=>'5-20 DAYS'),
            array('subcategory_id'=>'9','filename'=>'FACEBOOK/FACEBOOK SHARES/FACEBOOK SHARE.jpg','precio'=>'795','Deliverytime'=>'5-30 DAYS'),
            array('subcategory_id'=>'9','filename'=>'FACEBOOK/FACEBOOK SHARES/FACEBOOK SHARE.jpg','precio'=>'1499','Deliverytime'=>'7-35 DAYS'),
        );

        foreach ($subcategorias as $subcategoria) {
            $country = new ShopSubcategoryProduct();
            //$country->setSubcategory($subcategoria['subcategory_id']);
            $country->setFileName($subcategoria['filename']);
            $country->setPrice($subcategoria['precio']);
            $country->setDeliverytime($subcategoria['Deliverytime']);
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