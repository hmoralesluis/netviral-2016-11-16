<?php

namespace App\AdminBundle\Controller;


use App\AdminBundle\Entity\BankAccount;
use App\AdminBundle\Entity\BenefitTable;
use App\AdminBundle\Entity\Message;
use App\AdminBundle\Entity\Transaction;
use App\AdminBundle\Entity\User;
use App\AdminBundle\Entity\UserModule;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;


/**
 * User controller.
 *
 * @Route("/management/user")
 */
class UserController extends Controller
{

    /**
     * Lists all User entities.
     *
     * @Route("/", name="management_user_modulo")
     * @Method("GET")
     * @Template()
     */
    public function ModuloAction()
    {
        $em = $this->getDoctrine()->getManager();
        var_dump('ok');
        exit;
    }

    /**
     * Lists all User entities.
     *
     * @Route("/", name="management_user")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AdminBundle:User')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Lists all User entities.
     *
     * @Route("/module/content", name="management_user_module_content")
     * @Method("GET")
     * @Template()
     */
    public function matrixAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AdminBundle:Module')->findAll();
        return $this->render('AdminBundle:Modulo:index.html.twig', array(
            'entities' => $entities

        ));

    }


    private function getFullNetwork($user, $result)
    {
        $list = $user->getNetworkUsers();
        if (count($list) == 0) {
            return $result;
        }
        for ($i = 0; $i < count($list); $i++) {
            $result[] = $list[$i];
            $result = $this->getFullNetwork($list[$i], $result);
        }
        return $result;
    }


    /**
     * Lists Country.
     *
     * @Route("/management", name="management_country")
     */
    public function countryAction($id = null)
    {
        $entity = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        if (!is_null($id)) {
            $entity = $em->getRepository('AdminBundle:User')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find User entity.');
            }
        }

        $countries = $em->getRepository('AdminBundle:Country')->findAll();
        return $this->render('AdminBundle:Configuration:country.html.twig', array(
            'entity' => $entity,
            'countries' => $countries,
        ));
    }

    private function fillList($result_list, $data_list)
    {
        foreach ($data_list as $data) {
            $result_list[] = $data;
        }
        return $result_list;
    }

    /**
     * Listado de Mensajes en la Bandeja de Entrada
     *
     * @Route("/network/message", name="management_user_message")
     */
    public function messageAction()
    {
        $em = $this->getDoctrine()->getManager();
        $logged = $this->getUser();
        $list = $em->getRepository('AdminBundle:Message')->findBy(array(
            'state' => 'N',
            'receptor' => $logged->getUsername()
        ));
        return $this->render('AdminBundle:Email:message.html.twig', array('listaemail' => $list));
    }

    /**
     * Lists NetworkBussines.
     *
     * @Route("/network/message/send", name="management_user_send")
     */
    public function sendAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $logged = $this->getUser();
        $date = date_create_from_format('Y-m-d', date('Y-m-d'));
        if ($request->getMethod() == 'POST') {
            $em->getConnection()->beginTransaction();
            $email = new Message();
            $email->setSender($logged->getUsername());
            $email->setReceptor($request->get('to'));
            $email->setAsunto($request->get('subject'));
            $email->setBody($request->get('message'));
            $email->setState("N");
            $email->setDate($date);
            $em->persist($email);
            $em->flush();
            $em->getConnection()->commit();
        }

        $list = $em->getRepository('AdminBundle:Message')->findBy(array(
            'state' => 'N',
            'receptor' => $logged->getUsername()
        ));

        return $this->render('AdminBundle:Email:message.html.twig', array('listaemail' => $list));

    }

    /**
     * Lists NetworkBussines.
     *
     * @Route("/network/message/compose", name="management_user_compose")
     */
    public function composeAction()
    {
        $em = $this->getDoctrine()->getManager();
        $logged = $this->getUser();
        $list = $em->getRepository('AdminBundle:Message')->findBy(array(
            'state' => 'N',
            'receptor' => $logged->getUsername(),
        ));

        return $this->render('AdminBundle:Email:compose.html.twig', array('listaemail' => $list));
    }

    /**
     * Lists NetworkBussines.
     *
     * @Route("/network", name="management_user_network")
     */
    public function networkAction()
    {
        $em = $this->getDoctrine()->getManager();
        $logged = $this->getUser();
        $user = $em->getRepository('AdminBundle:User')->findOneBy(array('username' => $logged->getUsername()));
        $firstGeneration = $user->getNetworkUsers();
        $full_network = $this->getFullNetwork($user, array());
        //var_dump($full_network);
        $benefitTable = $em->getRepository('AdminBundle:BenefitTable')->findOneBy(array('username' => $logged->getUsername()));
        $has_table = true;
        if (!$benefitTable) {
            $has_table = false;
        }
        $network_bussines = array();
        if ($has_table) {
            if (count($benefitTable->getDirectBenefitList()) != 0 && count($benefitTable->getIndirectBenefitList()) != 0) {
                $network_bussines = $this->fillList($network_bussines, $benefitTable->getDirectBenefitList());
                $network_bussines = $this->fillList($network_bussines, $benefitTable->getIndirectBenefitList());
            } else {
                if (count($benefitTable->getDirectBenefitList()) != 0 && count($benefitTable->getIndirectBenefitList()) == 0) {
                    $network_bussines = $benefitTable->getDirectBenefitList();
                } else {
                    $network_bussines = $benefitTable->getIndirectBenefitList();
                }
            }
        }
        return $this->render('AdminBundle:Bussines:network.html.twig', array(
            'firstGeneration' => $firstGeneration, 'network' => $full_network, 'network_bussines' => $network_bussines
        ));
    }

    /**
     * Finds and displays a User entity.
     *
     * @Route("/profile/{id}", name="management_user_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id = null)
    {
        $entity = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $countries = $em->getRepository('AdminBundle:Country')->findAll();
        $fullInformation = true;
        if (!is_null($id)) {
            if ($entity->getId() != $id) {
                $entity = $em->getRepository('AdminBundle:User')->find($id);
                if (!$entity) {
                    throw $this->createNotFoundException('Unable to find User entity.');
                }
                $fullInformation = false;
            }
        }

        $result = array('entity' => $entity, 'fullInformation' => $fullInformation);

        if ($fullInformation) {
            $notificationTypes = $em->getRepository('AdminBundle:NotificationType')->findAll();
            $associatedNotificationTypes = $entity->getNotificationTypes();
            $result['countries'] = $countries;
            $result['notificationTypes'] = $notificationTypes;
            $result['associatedNotificationTypes'] = $associatedNotificationTypes;
        }

        return $result;
    }

    /**
     * @Route("/associate/notificationType", name="management_user_associate_notificationType")
     */
    public function associateNotificationTypeAction(Request $request)
    {
        $entity = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $notificationTypes = $em->getRepository('AdminBundle:NotificationType')->findAll();
        $entity = $em->getRepository('AdminBundle:User')->findOneBy(array('username' => $entity->getUsername()));
        foreach ($notificationTypes as $type) {
            $value = $request->get($type->getId());
            $associated = false;
            if ($value == '1') {
                foreach ($entity->getNotificationTypes() as $associatedNotification) {
                    if ($associatedNotification->getId() == $type->getId()) {
                        $associated = true;
                        break;
                    }
                }
                if ($associated == false) {
                    $entity->addNotificationType($type);
                }
            } else {
                foreach ($entity->getNotificationTypes() as $associatedNotification) {
                    if ($associatedNotification->getId() == $type->getId()) {
                        $entity->removeNotificationType($type);
                        break;
                    }
                }
            }
        }
        $em->flush();
        $this->get('session')->getFlashBag()->add(
            'notice',
            'Se han configurado correctamente los tipos de notificaciones asociadas'
        );
        return $this->redirect($this->generateUrl('management_user_show'));
    }

    /**
     * @Route("/avatar", name="management_user_avatar")
     */
    public function setAvatarAction(Request $request)
    {
        $entity = $this->getUser();
        if ($request->getMethod() == 'POST') {
            $file = $_FILES["file"]['name'];
            $temp = explode('.', $file);
            $extension = $temp[count($temp) - 1];
            $name = $entity->getUsername() . "." . $extension; //olivio.marrero.jpg
            $target = 'bundles/admin/usuarios/' . $name;
            if (file_exists($target)) {
                unlink($target);
            }
            if (copy($_FILES['file']['tmp_name'], $target)) {
                $em = $this->getDoctrine()->getManager();
                $entity = $em->getRepository('AdminBundle:User')->findOneBy(array('username' => $entity->getUsername()));
                if (!$entity) {
                    throw $this->createNotFoundException('Unable to find User entity.');
                }
                $entity->setPhotoExtension($extension);
                $em->flush();
            }
        }

        $this->get('session')->getFlashBag()->add(
            'notice',
            'Se ha cambiado el avatar.'
        );

        return $this->redirect($this->generateUrl('management_user_show'));
    }

    /**
     * @Route("/avatar/delete", name="management_user_avatar_delete")
     */
    public function deleteAvatarAction()
    {
        $entity = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AdminBundle:User')->findOneBy(array('username' => $entity->getUsername()));
        $file = 'bundles/admin/usuarios/' . $entity->getUsername() . '.' . $entity->getPhotoExtension();
        if (file_exists($file)) {
            unlink($file);
        }
        $entity->setPhotoExtension(null);
        $em->flush();

        $this->get('session')->getFlashBag()->add(
            'notice',
            'Su avatar ha sido eliminado.'
        );

        return $this->redirect($this->generateUrl('management_user_show'));
    }

    /**
     * @Route("/password/change", name="management_user_password_change")
     */
    public function changePassworkAction(Request $request)
    {
        $oldPass = $request->get('oldPassword');
        $password = $request->get('password');
        $confimPassword = $request->get('confimPassword');
        if ($request->getMethod() == 'POST') {
            if (!empty($oldPass) && !empty($password) && !empty($confimPassword)) {
                $entity = $this->getUser();
                $encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
                $encripted = $encoder->encodePassword($oldPass, $entity->getSalt());
                if ($encripted == $entity->getPassword()) {
                    if ($password == $confimPassword) {
                        $em = $this->getDoctrine()->getManager();
                        $entity = $em->getRepository('AdminBundle:User')->findOneBy(array('username' => $entity->getUsername()));
                        $entity->setPassword($password);
                        $em->flush();

                        $this->get('session')->getFlashBag()->add(
                            'notice',
                            'La contraseña ha sido cambiada.'
                        );

                        return $this->redirect($this->generateUrl('management_user_show'));
                    }
                }
            }
        }
    }

    public static function getGeneration($user, $cont)
    {
        if (is_null($user->getAssociatedUser())) {
            return $cont;
        } else {
            $cont = $cont + 1;
            return UserController::getGeneration($user->getAssociatedUser(), $cont);
        }
    }

    public static function getPositionInGeneration($associated_user)
    {
        $brothers = $associated_user->getNetworkUsers();
        //ordering
        $newer = null;
        for ($i = 0; $i < count($brothers) - 1; $i++) {
            for ($j = $i + 1; $j < count($brothers); $j++) {
                if ($brothers[$j]->getPositionInGeneration() < $brothers[$i]->getPositionInGeneration()) {
                    $newer = $brothers[$j];
                    $brothers[$j] = $brothers[$i];
                    $brothers[$i] = $newer;
                }
            }
        }
        //find missing index
        $index = null;
        for ($c = 0; $c < count($brothers) - 1; $c++) {
            if ($brothers[$c + 1]->getPositionInGeneration() != $brothers[$c]->getPositionInGeneration() + 1) {
                $index = $brothers[$c]->getPositionInGeneration() + 1;
                break;
            }
        }
        if (is_null($index) && count($brothers) != 0) {
            $index = $brothers[count($brothers) - 1]->getPositionInGeneration() + 1;
        } else {
            $index = 1;
        }
        return $index;
    }

    //pos 2,4,6 y después 10,15,20,25 y de 5 en 5 infinitamente
    public static function IsIndirectBenefit($pos)
    {
        if ($pos == 2 || $pos == 4 || $pos == 6) {
            return true;
        } else {
            if (($pos % 10 == 0 || ($pos - 5) % 10 == 0) && $pos != 5) {
                return true;
            }
        }
        return false;
    }

    public static function FindBenefitTableReferring($user)
    {
        if ($user->getGeneration() >= 3) {
            $directReferring = $user->getAssociatedUser();
            if (!UserController::IsIndirectBenefit($directReferring->getPositionInGeneration())) {
                return $directReferring->getAssociatedUser();
            } else {
                return UserController::FindBenefitTableReferring($directReferring);
            }
        } else {
            if ($user->getGeneration() == 1) {
                return null;
            } else { //second generation
                if (!UserController::IsIndirectBenefit($user->getPositionInGeneration())) {
                    return $user->getAssociatedUser();
                }
            }
        }
        return null;
    }

    /**
     * Create User entity.
     *
     * @Route("/create", name="management_user_create")
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $session = $this->get('session');
        $affiliate = $session->get('affiliate');

        $name = $request->get('name');
        $lastname = $request->get('lastname');
        $sex = $request->get('sex');
        $email = $request->get('email');
        $country = $request->get('country');
        $username = $request->get('username');
        $password = $request->get('pass');
        $module = $request->get('m');
        //$module = 2;
        if ($request->getMethod() == 'POST') {
            try {
                $em->getConnection()->beginTransaction();

                $bankAccount = new BankAccount();
                $bankAccount->setCode(md5($username));
                $bankAccount->setLastUpdate(date_create_from_format('Y-m-d', date('Y-m-d')));
                $bankAccount->setMoney(0);
                $em->persist($bankAccount);

                $user = new User();
                $user->setName($name);
                $user->setLastName($lastname);
                $user->setSex($sex);
                $user->setEmail($email);
                $user->setLocale($em->getRepository('AdminBundle:Country')->findOneBy(array('alpha2Code' => $country)));
                $user->setUsername($username);
                $user->setPassword($password);
                $user->setActive(true);
                $user->setSignUpDate(date_create_from_format('Y-m-d', date('Y-m-d')));
                $referring = $em->getRepository('AdminBundle:User')->find(1); //Administrator
                if (isset($affiliate)) {
                    $referring = $em->getRepository('AdminBundle:User')->findOneBy(array('username' => $affiliate));
                }
                $positionInGeneration = $this->getPositionInGeneration($referring);
                $user->setPositionInGeneration($positionInGeneration);
                $user->setAssociatedUser($referring);
                $user->setGeneration($this->getGeneration($user, 1));
                $role = $em->getRepository('AdminBundle:Role')->find(3); //Free
                if ($module != 1) { //not Free
                    $role = $em->getRepository('AdminBundle:Role')->find(2); //Payment
                }
                $user->setRole($role);
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
                    $benefitTable = $em->getRepository('AdminBundle:BenefitTable')->findOneBy(array('username' => $benefitTableReferring->getUsername()));
                    if (empty($benefitTable) || is_null($benefitTable)) {
                        $benefitTable = new BenefitTable();
                        $benefitTable->setUsername($benefitTableReferring->getUsername());
                        $em->persist($benefitTable);
                    }
                    if ($role->isPayment()) {
                        $directBenefit ? $user->setDirectBenefitTable($benefitTable) : $user->setIndirectBenefitTable($benefitTable);
                    }
                }
                //*************************************************************************
                $em->persist($user);
                //***************************
                $userModule = new UserModule();
                $userModule->setUser($user);
                $module = $em->getRepository('AdminBundle:Module')->find($module);
                $userModule->setModule($module);
                $userModule->setActivationDate(date_create_from_format('Y-m-d', date('Y-m-d')));
                $em->persist($userModule);
                if ($role->isPayment() && $has_Referring) {
                    $transaction = new Transaction();
                    $transaction->setModule($module->getName());
                    $transaction->setNickname($username);
                    $transaction->setUser($benefitTableReferring);
                    $transaction->setMoney($module->getCost());
                    $transaction->setGeneration(intval($this->getGeneration($user, 1)) - intval($benefitTableReferring->getGeneration()));
                    $transaction->setDate(date_create_from_format('Y-m-d', date('Y-m-d')));
                    $transaction->setTransactionType($em->getRepository('AdminBundle:TransactionType')->find(1)); //Module buy
                    $em->persist($transaction);
                }
                $em->flush();
                $em->getConnection()->commit();
            } catch (\Exception $e) {
                $em->getConnection()->rollback();
                $em->close();
                throw $e;
            }
        }
        $this->addFlash(
            'notice',
            'Su usuario ha sido creado correctamente, puede loguearse si lo desea en el menu principal .'
        );

        return $this->redirect($this->generateUrl('homepage'));
    }

    /**
     * Update User entity.
     *
     * @Route("/update", name="management_user_update")
     */
    public function updateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AdminBundle:User')->findOneBy(array('username' => $request->get('username')));
        if (!$entity) {
            throw $this->createNotFoundException('Error, no existe el usuario ' . $request->get('username'));
        } else {
            if ($request->getMethod() == 'POST') {
                try {
                    $em->getConnection()->beginTransaction();
                    $entity->setUsername($request->get('username'));
                    $entity->setName($request->get('name'));
                    $entity->setLastName($request->get('lastName'));
                    $entity->setSex($request->get('sex'));
                    $birthday = $request->get('birthday');
                    if ($birthday != '') {
                        $entity->setBirthday(date_create_from_format('Y-n-j', $birthday));
                    }
                    $entity->setLocale($em->getRepository('AdminBundle:Country')->findOneBy(array('alpha2Code' => $request->get('country'))));
                    $entity->setCity($request->get('city'));
                    $entity->setAddress($request->get('address'));
                    $entity->setEmail($request->get('email'));
                    $entity->setSkype($request->get('skype'));
                    $entity->setWhatsapp($request->get('whatsapp'));
                    $entity->setFacebook($request->get('facebook'));
                    $entity->setTwitter($request->get('twitter'));
                    $entity->setGoogle($request->get('google'));
                    $entity->setContactPhone($request->get('contactPhone'));
                    $entity->setAbout($request->get('about'));
                    $em->persist($entity);
                    $em->flush();

                    $this->get('session')->getFlashBag()->add(
                        'notice',
                        'Se han guardado los cambios.'
                    );
                    $em->getConnection()->commit();
                } catch (\Exception $e) {
                    $em->getConnection()->rollback();
                    $em->close();
                    throw $e;
                }
            }
            return $this->redirect($this->generateUrl('management_user_show'));
        }
    }

    /**
     * Associate specific module to an User.
     *
     * @Route("/associate/module/{id}", name="management_user_associate_module")
     */
    public function buyModule($id)
    {
        $em = $this->getDoctrine()->getManager();
        $username = $this->getUser()->getUsername();
        $user = $em->getRepository('AdminBundle:User')->findOneBy(array('username' => $username));
        $module = $em->getRepository('AdminBundle:Module')->find($id);
        /*****en esta parte se debe comprobar el saldo para poder pagar con paypal***/
        //si el usuario no es de pago, pues lo combierto en usuario de pago
        if (!$user->getRole()->isPayment()) {
            $role = $em->getRepository('AdminBundle:Role')->find(2);
            $user->setRole($role);
        }
        //ahora el usuario para del banco de usuarios free a formar parte de la red de negocios de alguien
        //************ building network bussines in Benefit Table *****************
        $benefitTable = null;
        $has_Referring = true;
        $directBenefit = true;
        $referring = $user->getAssociatedUser();
        $positionInGeneration = $this->getPositionInGeneration($referring);
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
            $benefitTable = $em->getRepository('AdminBundle:BenefitTable')->findOneBy(array('username' => $benefitTableReferring->getUsername()));
            if (empty($benefitTable) || is_null($benefitTable)) {
                $benefitTable = new BenefitTable();
                $benefitTable->setUsername($benefitTableReferring->getUsername());
                $em->persist($benefitTable);
            }
            $directBenefit ? $user->setDirectBenefitTable($benefitTable) : $user->setIndirectBenefitTable($benefitTable);
        }
        //*************************************************************************
        //asocio el modulo
        $userModule = new UserModule();
        $userModule->setUser($user);
        $userModule->setModule($module);
        $userModule->setActivationDate(date_create_from_format('Y-m-d', date('Y-m-d')));
        $em->persist($userModule);
        if ($has_Referring) {
            //registro una transaccion
            $transaction = new Transaction();
            $transaction->setDate(date_create_from_format('Y-n-j', date('Y-m-d')));
            $transaction->setModule($module->getName());
            $transaction->setNickname($username);
            $transaction->setUser($benefitTableReferring);
            $transaction->setMoney($module->getCost());
            $transaction->setGeneration(intval($this->getGeneration($user, 1)) - intval($benefitTableReferring->getGeneration()));
            $transaction->setTransactionType($em->getRepository('AdminBundle:TransactionType')->find(1)); //Compra / Venta de módulo
            $em->persist($transaction);
        }
        $em->flush();
        return $this->redirect($this->generateUrl('management'));
    }
}
