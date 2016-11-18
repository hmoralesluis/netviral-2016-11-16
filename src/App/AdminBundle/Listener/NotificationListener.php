<?php
namespace App\AdminBundle\Listener;

use App\AdminBundle\Entity\Message;
use App\AdminBundle\Entity\Notification;
use App\AdminBundle\Entity\Product;
use App\AdminBundle\Entity\Transaction;
use App\AdminBundle\Entity\User;
use App\AdminBundle\Entity\UserModule;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Routing\Router;

class NotificationListener
{

    private $router, $container;

    public function __construct(Router $router, $container)
    {
        $this->router = $router;
        $this->container = $container;
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $em = $this->container->get('doctrine')->getEntityManager();
        $entity = $args->getEntity();
        if ($entity instanceof User) {
            if (!is_null($entity->getAssociatedUser())) {
                $notification = new Notification();
                $notification->setDate(date_create_from_format('Y-m-d', date('Y-m-d')));
                $notification->addUser($em->getRepository('AdminBundle:User')->findOneBy(array('username' => $entity->getAssociatedUser()->getUsername())));
                $newUsers = $em->getRepository('AdminBundle:NotificationType')->find(2); //Nuevos Usuarios
                $notification->setNotificationType($newUsers);
                $em->persist($notification);
                $em->flush();
            }
        } elseif ($entity instanceof Product) {

        } elseif ($entity instanceof Message) {
            $user = $em->getRepository('AdminBundle:User')->findOneBy(array('username' => $entity->getReceptor()));
            $notification = new Notification();
            $notification->setDate(date_create_from_format('Y-m-d', date('Y-m-d')));
            $mensajeria = $em->getRepository('AdminBundle:NotificationType')->find(1); //Message
            $notification->setNotificationType($mensajeria);
            $notification->addUser($user);
            $em->persist($notification);
            $em->flush();
        } elseif ($entity instanceof Transaction) {
            $date = date_create_from_format('Y-m-d', date('Y-m-d'));
            $user = $entity->getUser();
            //si es positiva es que alguien ($user) hizo una venta de algo, pues aplico un plan de compensación
            if ($entity->getMoney() > 0) { //transacciones de venta
                $notification = new Notification();
                $notification->setDate($date);
                $sale = $em->getRepository('AdminBundle:NotificationType')->find(3); //Sales
                $notification->setNotificationType($sale);
                $notification->addUser($user);
                $em->persist($notification);

                $apply = false; //por defecto no se aplica el plan de compensación
                $bankAccount = $user->getBankAccount();
                $earnings = $bankAccount->getMoney();
                if ($entity->getTransactionType()->getId() == 1) {//si la transacción es por compra de módulo
                    $module = $em->getRepository('AdminBundle:Module')->findOneBy(array('name' => $entity->getModule()));
                    $userModule = $em->getRepository('AdminBundle:UserModule')->findOneBy(array('user' => $user, 'module' => $module));
                    if ($module->getId() != 2) { //cualquier módulo menos el de registro, para este si, aunque no lo tenga asociado
                        if ($userModule) { //si el modulo no es el de registro (cualquier otro) y el usuario lo tiene asociado
                            $apply = true; //se aplica
                        }
                    } else {
                        $apply = true; //si es el modulo de registro siempre se aplica
                    }
                } else { //si la transacción no es por compra de módulo se aplica de todas formas
                    $apply = true;
                }

                if ($apply) { //si se aplica
                    //por defecto el plan de compensación va a ser a usuarios de pago
                    $compensationPlan = $em->getRepository('AdminBundle:CompensationPlan')->find(1); //PaymentUser
                    //si la transacción es por compra de módulo y el usuario no es de pago
                    if ($entity->getTransactionType()->getId() == 1 && !$user->getRole()->isPayment()) {
                        $compensationPlan = $em->getRepository('AdminBundle:CompensationPlan')->find(2); //FreeUser
                    } else {
                        //si es por retiro de fondo, entonces es el 100%, o el plan de compensación que se defina
                    }
                    //aplico el porciento de acuerdo al plan de compensación
                    $money = $entity->getMoney() * $compensationPlan->getPercentage() / 100;
                    $entity->setMoney($money); //actualizo el valor
                    $earnings = $earnings + $money;
                    $bankAccount->setMoney($earnings); //actualizo el valor en la cuenta bancaria
                }

                //si el usuario tiene el dinero (suma de sus ganancias por ventas) buscar los modulos que no tenga asociado y comprarlos automaticamente
                $associatedModules = array();
                //modulos asociados
                foreach ($user->getUserModules() as $um) {
                    $associatedModules[] = $um->getModule();
                }
                //modulos no asociados
                $notAssociated = $em->getRepository('AdminBundle:Module')->findUnAssigned($associatedModules);
                foreach ($notAssociated as $nam) { //not associated module
                    //por cada modulo no asociado, si las ganancias son mayores o iguales al costo de ese módulo
                    if ($earnings >= $nam->getCost()) {
                        //compro el modulo, que simplemente es asociarlo y descontarle el dinero de sus ganancias
                        $userModule = new UserModule();
                        $userModule->setUser($user);
                        $userModule->setModule($nam);
                        $userModule->setActivationDate($date);
                        $em->persist($userModule);
                        //hago el descuento y actualizo la cuenta bancaria
                        $earnings = $earnings - $nam->getCost();
                        $bankAccount->setMoney($earnings);
                        //si el rol del usuario que automáticamente compra el módulo, no es de pago, o simplemente es free
                      //  if (!$user->getRole()->isPayment()) {
                            //actualizo su membresía a un usuario de pago
                        //    $role = $em->getRepository('AdminBundle:Role')->find(2); //membresía de pago
                        //    $user->setRole($role);
                       // }
                        //registro el descuento realizado
                        $transaction = new Transaction();
                        $transaction->setDate($date);
                        $transaction->setModule($nam->getName());
                        $transaction->setNickname('Sistema');
                        $transaction->setUser($user);
                        $transaction->setMoney($nam->getCost() * -1); //un registro negativo
                        $transaction->setGeneration(0);
                        $transaction->setTransactionType($em->getRepository('AdminBundle:TransactionType')->find(1)); //Compra / Venta de módulo
                        $em->persist($transaction);
                    }
                }
            } else {
                $notification = new Notification();
                $notification->setDate($date);
                $sale = $em->getRepository('AdminBundle:NotificationType')->find(3); //Sales
                $notification->setNotificationType($sale);
                $notification->addUser($user);
                $em->persist($notification);
            }
            $em->flush();
        }
    }

    public function postUpdate(LifecycleEventArgs $args)
    {

    }

    public function preRemove(LifecycleEventArgs $args)
    {

    }
}