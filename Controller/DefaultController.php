<?php

namespace MultiServerControl\MineControlBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MultiServerControl\MineControlBundle\Manager\MineControlManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Process\Process;


class DefaultController extends Controller
{
    /**
     * @Route("/minecraft/{command}")
     * @Template()
     */
    public function indexAction($command)
    {


        $mineControlManager = new MineControlManager();
        $mineControlManager->start();
        return array('name' => $command);
    }
}
