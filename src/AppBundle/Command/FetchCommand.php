<?php
/**
 * @author Jesús Flores <jesus.flores@bq.com>
 */

namespace AppBundle\Command;


use AppBundle\Entity\Game;
use AppBundle\Entity\Image;
use AppBundle\Entity\Platform;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\Constraints\DateTime;

class FetchCommand extends ContainerAwareCommand {

    const PC_PLATFORM = 94;
    const PS3_PLATFORM = 35;
    const PS4_PLATFORM = 146;
    const XBOX360_PLATFORM = 20;
    const XBOXONE_PLATFORM = 145;

    protected $apiKey;
    protected $logger; // monolog logger

    protected function configure()
    {

        $this
            ->setName('app:fetch')
            ->setDescription('Get fresh new data')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->apiKey = $this->getContainer()->getParameter('giant_bomb_api_key');
        $this->logger = $this->getContainer()->get('logger');
        $this->fetchPc();
        $this->fetchPS3();
        $this->fetchPS4();
        $this->fetchXbox360();
        $this->fetchXboxOne();
    }

    protected function fetchGeneric($platform)
    {
        $apiBaseUrl = 'http://www.giantbomb.com/api/releases/';
        $date1week = date_create(date('Y-m-d'));
        date_add($date1week, date_interval_create_from_date_string('7 days'));
        $filter = 'filter=release_date:'.date('Y-m-d').'|'.date('Y-m-d', $date1week->getTimestamp()).',platform:'.$platform;
        $finalUrl = $apiBaseUrl.'?api_key='.$this->apiKey.'&format=json&'.$filter;
        $this->logger->debug('Getting url: '.$finalUrl);
        $jsonData = file_get_contents($finalUrl);
        return json_decode($jsonData,TRUE);
    }

    protected function getPlatform($platform){
        $this->logger->debug('Getting platform: '.$platform);
        return $this->getContainer()->get('doctrine')->getManager()->getRepository('AppBundle:Platform')->find($platform);
    }

    protected function fetchPc()
    {
        $this->insertGameArray($this->fetchGeneric(self::PC_PLATFORM), $this->getPlatform(self::PC_PLATFORM));
    }

    protected function fetchPS3()
    {
        $this->insertGameArray($this->fetchGeneric(self::PS3_PLATFORM), $this->getPlatform(self::PS3_PLATFORM));
    }

    protected function fetchPS4()
    {
        $this->insertGameArray($this->fetchGeneric(self::PS4_PLATFORM), $this->getPlatform(self::PS4_PLATFORM));
    }

    protected function fetchXbox360()
    {
        $this->insertGameArray($this->fetchGeneric(self::XBOX360_PLATFORM), $this->getPlatform(self::XBOX360_PLATFORM));
    }

    protected function fetchXboxOne()
    {
        $this->insertGameArray($this->fetchGeneric(self::XBOXONE_PLATFORM), $this->getPlatform(self::XBOXONE_PLATFORM));
    }

    protected function insertGameArray(array $games, Platform $platform){
        if(count($games) > 0){
            $em = $this->getContainer()->get('doctrine')->getManager();
            foreach($games['results'] as $game){
                // find if it exists by name
                $existingGame = $em->getRepository('AppBundle:Game')->findOneBy(array('name' => $game['name']));
                if(!$existingGame){
                    $this->logger->debug('New '.$platform->getName().' game: '.$game['name']);
                    $newGame = new Game();
                    $newGame->setName($game['name']);
                    $newGame->setReleaseDay($game['expected_release_day']);
                    $newGame->setReleaseMonth($game['expected_release_day']);
                    $newGame->setReleaseYear($game['expected_release_year']);
                    $newGame->setDetailsUrl($game['game']['api_detail_url']);
                    $newGame->setPlatform($platform);
                    $em->persist($newGame);
                    $em->flush();
                    $this->processImages($game['image'], $newGame);
                } else {
                    $this->logger->debug('Existing '.$platform->getName().' game: '.$game['name']);
                }
            }
        }
    }

    protected function processImages($image, Game $game){
        $em = $this->getContainer()->get('doctrine')->getManager();
        // save only thumb by now
        if(!empty($image['thumb_url'])){
            $this->logger->debug('Found '.$game->getName().' image: '.$image['thumb_url']);
            $newImage = new Image();
            $newImage->setGame($game);
            $newImage->setUrl($image['thumb_url']);
            $em->persist($newImage);
        } else {
            $this->logger->debug('Image for: '.$game->getName().' not found');
        }
        $em->flush();
    }

} 