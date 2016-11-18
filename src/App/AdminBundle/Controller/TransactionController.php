<?php

namespace App\AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 *
 * Class TransactionController
 * @package App\AdminBundle\Controller
 * @Route("/management/transaction")
 *
 */
class TransactionController extends Controller
{
    /**
     * @Route("/", name="management_transaction")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $id = $this->getUser()->getId();
        $daily_transactions = $em->getRepository('AdminBundle:Transaction')->findDailyTransaction($id);
        $weekly_transactions = $em->getRepository('AdminBundle:Transaction')->findWeeklyTransaction($id);
        $monthly_transactions = $em->getRepository('AdminBundle:Transaction')->findMonthlyTransaction($id);
        $quarterly_transactions = $em->getRepository('AdminBundle:Transaction')->findQuarterlyTransaction($id);
        $yearly_transactions = $em->getRepository('AdminBundle:Transaction')->findYearlyTransaction($id);
        return $this->render('AdminBundle:Transaction:index.html.twig', array(
            'daily_transactions' => $daily_transactions, 'weekly_transactions' => $weekly_transactions,
            'monthly_transactions' => $monthly_transactions, 'quarterly_transactions' => $quarterly_transactions,
            'yearly_transactions' => $yearly_transactions
        ));
    }
}
