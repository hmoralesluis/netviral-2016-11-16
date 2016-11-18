<?php
namespace App\AdminBundle\DataFixtures\ORM;

use App\AdminBundle\Controller\UserController;
use App\AdminBundle\Entity\BenefitTable;
use App\AdminBundle\Entity\Transaction;
use App\AdminBundle\Entity\BankAccount;
use App\AdminBundle\Entity\User;
use App\AdminBundle\Entity\UserModule;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $roles = array('Membresía de Pago');
        $nombres = array('José', 'Juan', 'Maidelín', 'Alejandro', 'Marcelo', 'Martha', 'Sheila', 'Adolfo', 'Olivio',
            'Hamlet', 'Reinier', 'Nancy', 'Dagoberto', 'Adrian', 'Vivian', 'Yoan', 'Raul', 'Darien', 'Miriam', 'Anabel');
        $apellidos = array('Marrero', 'Vega', 'Rodriguez', 'Pérez', 'Torres', 'Prieto', 'Bernal', 'García', 'Martell',
            'Cantero', 'Hernández', 'Gómez', 'Companioni', 'Cañizares', 'Angulo', 'Carcassees', 'Caseres', 'Prades',
            'Pina', 'Marin');
        $countries = array('FR', 'ES', 'EN');
        $sexo = array('Mujer', 'Hombre');

        $notificationTypes = $manager->getRepository('AdminBundle:NotificationType')->findAll();

        $date = date('Y-n-j');

        $bankAccount = new BankAccount();
        $bankAccount->setCode(md5('admin'));
        $bankAccount->setLastUpdate(date_create_from_format('Y-n-j', $date));
        $bankAccount->setMoney(0);
        $manager->persist($bankAccount);

        $admin = new User();
        $admin->setName('Administrador');
        $admin->setLastName('');
        $admin->setSex('Hombre');
        $admin->setUsername('admin');
        $admin->setPassword('adminpass');
        $admin->setRole($manager->getRepository('AdminBundle:Role')->find(1));
        $admin->setActive(true);
        $admin->setEmail('admin@domain.com');
        $admin->setSignUpDate(date_create_from_format('Y-m-d', date('Y-m-d')));
        $admin->setGeneration(1);
        $admin->setPositionInGeneration(1);
        $admin->setLocale($manager->getRepository('AdminBundle:Country')->findOneBy(array('name' => 'Spain')));
        foreach ($notificationTypes as $notificationType) {
            $admin->addNotificationType($notificationType);
        }
        $admin->setBankAccount($bankAccount);
        $modules = $manager->getRepository('AdminBundle:Module')->findAll();
        foreach($modules as $module){
            $userModule = new UserModule();
            $userModule->setUser($admin);
            $userModule->setModule($module);
            $userModule->setActivationDate(date_create_from_format('Y-n-j', $date));
            $manager->persist($userModule);
        }
        $manager->persist($admin);
        $manager->flush();

        for ($i = 1; $i <= 100; $i++) {

            $bankAccount = new BankAccount();
            $bankAccount->setCode(md5('user' . $i));
            $bankAccount->setLastUpdate(date_create_from_format('Y-n-j', $date));
            $bankAccount->setMoney(0);
            $manager->persist($bankAccount);

            $user = new User();
            $user->setName($nombres[rand(0, count($nombres) - 1)]);
            $user->setLastName($apellidos[rand(0, count($apellidos) - 1)]);
            $user->setSex($sexo[rand(0, count($sexo) - 1)]);
            $user->setUsername('user' . $i);
            $user->setPassword('userpass' . $i);
            $role = $roles[rand(0, count($roles) - 1)];
            $role = $manager->getRepository('AdminBundle:Role')->findOneBy(array('name' => $role));
            $user->setRole($role);
            $user->setActive(true);
            $user->setEmail('user' . $i . '@domain.com');
            $user->setSignUpDate(date_create_from_format('Y-n-j', $date));
            $referring = $manager->getRepository('AdminBundle:User')->find(1); //Administrator
            $users = $manager->getRepository('AdminBundle:User')->findAll();
            if (count($users) != 1) {
                $referring = $users[rand(0, count($users) - 1)];
            }
            $user->setGeneration($referring->getGeneration() + 1);
            $count = $manager->getRepository('AdminBundle:User')->getCountInGeneration($referring->getGeneration() + 1) + 1;
            $positionInGeneration = intval($count);
            $user->setPositionInGeneration($positionInGeneration);
            $user->setAssociatedUser($referring);
            $user->setLocale($manager->getRepository('AdminBundle:Country')->findOneBy(array('alpha2Code' => $countries[rand(0, count($countries) - 1)])));
            foreach ($notificationTypes as $notificationType) {
                $user->addNotificationType($notificationType);
            }
            $user->setBankAccount($bankAccount);
            //************ building network bussines in Benefit Table *****************
            $benefitTable = null;
            $has_Referring = true;
            $directBenefit = true;
            $benefitTableReferring = $referring; //by default is direct Benefit [1,3,5,7,8,9,11,12,13,14]
            if (UserController::IsIndirectBenefit($positionInGeneration)) {
                //is indirect Benefit [2,4,6,10,15,20,25...]
                $benefitTableReferring = UserController::FindBenefitTableReferring($user);
                if (is_null($benefitTableReferring)) {
                    $has_Referring = false;
                }
                $directBenefit = false;
            }
            if ($has_Referring) { //if generation is 2 and position is also 2 or an indirect fenefit, this user has not referring
                $benefitTable = $manager->getRepository('AdminBundle:BenefitTable')->findOneBy(array('username' => $benefitTableReferring->getUsername()));
                if (empty($benefitTable) || is_null($benefitTable)) {
                    $benefitTable = new BenefitTable();
                    $benefitTable->setUsername($benefitTableReferring->getUsername());
                    $manager->persist($benefitTable);
                }
                if ($role->isPayment()) {
                    $directBenefit ? $user->setDirectBenefitTable($benefitTable) : $user->setIndirectBenefitTable($benefitTable);
                }
            }
            //*************************************************************************
            $manager->persist($user);
            //associate to module
            $userModule = new UserModule();
            $userModule->setUser($user);
            $module = $manager->getRepository('AdminBundle:Module')->find(1); //Free
            if ($role->isPayment()) {
                $module = $manager->getRepository('AdminBundle:Module')->find(2); //Register
            }
            $userModule->setModule($module);
            $userModule->setActivationDate(date_create_from_format('Y-n-j', $date));
            $manager->persist($userModule);
            //begin creating a transaction for referring affiliate
            if ($role->isPayment() && $has_Referring) {
                $transaction = new Transaction();
                $transaction->setDate(date_create_from_format('Y-n-j', $date));
                $transaction->setModule($module->getName());
                $transaction->setNickname('user' . $i);
                $transaction->setUser($benefitTableReferring);
                $transaction->setMoney($module->getCost()); //apply compensation plan by user's role
                $transaction->setGeneration(intval($referring->getGeneration() + 1) - intval($benefitTableReferring->getGeneration()));
                $transaction->setTransactionType($manager->getRepository('AdminBundle:TransactionType')->find(1)); //Module buy
                $manager->persist($transaction);
            }
            $manager->flush();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 12; // the order in which fixtures will be loaded
    }
}