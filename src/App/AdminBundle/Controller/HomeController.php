<?php

namespace App\AdminBundle\Controller;

use App\AdminBundle\Entity\Option;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 *
 * Class HomeController
 * @package App\AdminBundle\Controller
 * @Route("/")
 *
 */
class HomeController extends Controller
{
    public static function UserOptions($context, $em, $user)
    {
        $sesion = $context->get('session');
        $options = $em->getRepository('AdminBundle:Option')->findAll(); //by default is admin [full access]
        if (!$context->isGranted('ROLE_ADMIN')) {
            $options = $user->getRole()->getOptions();
        }
        $option_list = array();
        foreach ($options as $option) {
            $option_list[] = $option;
        }
        foreach ($user->getUserModule() as $um) {
            $associated = false;
            $name = $um->getModule()->getName();
            $path = $um->getModule()->getOptionPath();
            foreach ($option_list as $option) {
                if ($option->getName() == $name) {
                    $associated = true;
                    break;
                }
            }
            if ($um->getModule()->getId() > 2 && !$associated) {
                $op = $em->getRepository('AdminBundle:Option')->findOneBy(array('name' => $name));
                if (!$op) {
                    $op = new Option();
                    $op->setName($name);
                    $op->setPath($path);
                    $op->setIcon('icon-folder-close');
                    $em->persist($op);
                    $em->flush();
                }
                $option_list[] = $op;
            }
        }
        $sesion->set('options_to_show', $option_list);
    }

    /**
     * @Route("/management", name="management", defaults={"_locale": "es"})
     */
    public function indexAction($_locale)
    {
        $sesion = $this->get('session');
        if(!is_null($_locale)){
            $sesion->set('_locale', $_locale);
        } else {
            $sesion->set('_locale', 'es');
        }

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AdminBundle:User')->findOneBy(array('username' => $this->getUser()->getUsername()));

        $em->flush();
        $sesion->set('associatedNotificationTypes', $user->getNotificationTypes());
        $sesion->set('modules', $em->getRepository('AdminBundle:Module')->findAll());
        $sesion->set('associatedModules', $user->getUserModule());
        $sesion->set('earning', $user->getBankAccount()->getMoney());
        $this->UserOptions($this, $em, $user);
        return $this->render('AdminBundle:Home:home.html.twig', array(
            'entity' => $user
        ));
    }

    /**
     * @Route("/management/get_sales", name="management_get_sales")
     * @Method("POST")
     */
    public function getSalesAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $id = $request->get('id');
        $daily_sales = $em->getRepository('AdminBundle:Transaction')->findDailyTransaction($id);
        $weekly_sales = $em->getRepository('AdminBundle:Transaction')->findWeeklyTransaction($id);
        $user = $em->getRepository('AdminBundle:User')->findOneBy(array('username' => $this->getUser()->getUsername()));
        $result = array('daily' => $daily_sales, 'weekly' => $weekly_sales, 'earning' => $user->getBankAccount()->getMoney());
        die(json_encode($result));
    }

    /**
     * @Route("/management/get_messages", name="management_get_messages")
     * @Method("POST")
     */
    public function getMessagesAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $id = $request->get('id');
        $messages = $em->getRepository('AdminBundle:Message')->findBy(array('receptor' => $this->getUser()->getUsername(), 'state' => 'N'));
        $result = array();
        $result[$id]['amount'] = count($messages);
        foreach ($messages as $message) {
            $sender = $em->getRepository('AdminBundle:User')->findOneBy(array('username' => $message->getSender()));
            if (is_null($sender->getPhotoExtension())) {
                $result[$id]['messages'][$message->getId()]['photo'] = "/netviralpro/web/bundles/admin/img/avatar.png";
            } else {
                $result[$id]['messages'][$message->getId()]['photo'] = "/netviralpro/web/bundles/admin/usuarios/" . $message->getSender() . '.' . $sender->getPhotoExtension();
            }

            $result[$id]['messages'][$message->getId()]['sender'] = $message->getSender();
            $result[$id]['messages'][$message->getId()]['time'] = 'Hoy';
            $result[$id]['messages'][$message->getId()]['topic'] = $message->getAsunto();
        }
        die(json_encode($result));
    }

    /**
     * @Route("/management/get_notifications", name="management_get_notifications")
     * @Method("POST")
     */
    public function getNotificationsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id = $request->get('id');
        $user = $em->getRepository('AdminBundle:User')->findOneBy(array('username' => $this->getUser()->getUsername()));
        $user_notifications = $user->getNotifications();

        $transacciones = $em->getRepository('AdminBundle:Transaction')->findOneBy(array('nickname' => $this->getUser()->getUsername()));

        $counter_ganancias = 34;
        //foreach ($transacciones as $ganancias) {
             //$totalganancias = $totalganancias + $ganancias.money();
        //}

        $notifications = array();
        foreach ($user_notifications as $notification) {
//            if (($notification->getDate()->format('Y-m-d') == date('Y-m-d')) && $notification->getNotificationType()->getId() != 1) {
                $notifications[] = $notification;
  //          }
        }

        $result = array();
        $result[$id]['amount'] = count($notifications);
        $counter_type2 = $counter_type3 = $counter_type4 = 0;

        foreach ($notifications as $notification) {
            if($notification->getNotificationType()->getId() == 2){ //nuevos usuarios
                $counter_type2++;
                $result[$id]['notifications'][$notification->getId()]['icon'] = 'icon-plus';
                $result[$id]['notifications'][$notification->getId()]['label'] = 'label-success';
            } elseif($notification->getNotificationType()->getId() == 3){ //ventas realizadas
                $counter_type3++;
                $result[$id]['notifications'][$notification->getId()]['icon'] = 'icon-money';
                $result[$id]['notifications'][$notification->getId()]['label'] = 'label-important';
            } else {
                $counter_type4++; //Nuevos mensajes
                $result[$id]['notifications'][$notification->getId()]['icon'] = 'icon-bullhorn';
                $result[$id]['notifications'][$notification->getId()]['label'] = 'label-info';
            }
            $result[$id]['notifications'][$notification->getId()]['title'] = $notification->getNotificationType()->getName();

            if ($notification->getDate()->format('Y-m-d') == date('Y-m-d')){
                $VFecha = 'Hoy';
            }else{
                $VFecha = $notification->getDate()->format('Y-m-d');
            }

            $result[$id]['notifications'][$notification->getId()]['time'] = $VFecha;
        }
        $result[$id]['types2'] = $counter_type2;
        $result[$id]['types3'] = $counter_type3;
        $result[$id]['types4'] = $counter_type4;
        $result[$id]['ganancias'] = $counter_ganancias;
        die(json_encode($result));
    }

    /**
     * @Route("/management/get_ganancias", name="management_get_ganancias")
     * @Method("POST")
     */
    public function getGananciasAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id = $request->get('id');
        $user = $em->getRepository('AdminBundle:Transaction')->findOneBy(array('user_id' => $this->getUser()->getUsername()));

        $totalganancias = 0;
        foreach ($user as $ganancias) {
          //  $totalganancias = $totalganancias + $ganancias.money();
        }
        $result = array();
        $result[$id]['amount'] = 45;//$totalganancias;
        die(json_encode($result));
    }

}
