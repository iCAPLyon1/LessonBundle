<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nicolas
 * Date: 07/11/13
 * Time: 14:29
 * To change this template use File | Settings | File Templates.
 */

namespace Icap\LessonBundle\Installation\Updater;

use Doctrine\Common\Persistence\Mapping\MappingException;
use Icap\LessonBundle\Entity\Chapter;


class Updater13 {
    private $container;
    private $conn;
    private $logger;

    public function __construct($container)
    {
        $this->container = $container;
        $this->conn = $container->get('doctrine.dbal.default_connection');
    }

    public function setLogger($logger)
    {
        $this->logger = $logger;
    }

    public function postUpdate()
    {
        //generate missing slugs
        $this->setSlug();

    }

    public function setSlug(){
        $this->logger->displayLog("setSlug start");
        $em = $this->container->get('doctrine.orm.entity_manager');
        $chapters = $em->getRepository("IcapLessonBundle:Chapter")->findAll();
        foreach ($chapters as $chapter) {
            $this->logger->displayLog("chapter found");
            if($chapter->getSlug() == null){
                $this->logger->displayLog("chapter slug updated");
                $chapter->setSlug(null);
            }
        }
        $em->flush();
    }

}