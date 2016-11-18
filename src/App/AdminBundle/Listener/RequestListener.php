<?php
namespace App\AdminBundle\Listener;

class RequestListener
{
    public function onKernelRequest(GetResponseEvent $event)
    {
        $event->getRequest()->setFormat('pdf', 'application/pdf');
        $event->getRequest()->setFormat('xls', 'application/vnd.ms-xls');
        $event->getRequest()->setFormat('doc', 'application/vnd.ms-doc');
    }
} 