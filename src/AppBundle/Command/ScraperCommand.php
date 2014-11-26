<?php
/**
 * @author Jesús Flores <jesus.flores@bq.com>
 */

namespace AppBundle\Command;


use AppBundle\Entity\Game;
use AppBundle\Entity\Image;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\Constraints\DateTime;

class ScraperCommand extends ContainerAwareCommand {

    const PC_PLATFORM = 94;

    protected $apiKey;

    protected function configure()
    {

        $this
            ->setName('app:scrape')
            ->setDescription('Get fresh new data')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->apiKey = $this->getContainer()->getParameter('giant_bomb_api_key');
        $this->scrapePc();
    }

    protected function scrapePc()
    {
        $apiBaseUrl = 'http://www.giantbomb.com/api/releases/';
        $platform = $this->getContainer()->get('doctrine')->getManager()->getRepository('AppBundle:Platform')->find(self::PC_PLATFORM);
        $date1week = date_create(date('Y-m-d'));
        date_add($date1week, date_interval_create_from_date_string('7 days'));
        $filter = 'filter=release_date:'.date('Y-m-d').'|'.date('Y-m-d', $date1week->getTimestamp()).',platform:'.self::PC_PLATFORM;
        $finalUrl = $apiBaseUrl.'?api_key='.$this->apiKey.'&format=json&'.$filter;
        var_dump($finalUrl);
        $jsonData = file_get_contents($finalUrl);
        $this->insertGameArray(json_decode($jsonData,TRUE), $platform);
    }

    protected function insertGameArray(array $games, $platform){
        if(count($games) > 0){
            $em = $this->getContainer()->get('doctrine')->getManager();
            foreach($games['results'] as $game){
                // find if it exists by name and platform
                $existingGame = $em->getRepository('AppBundle:Game')->findOneBy(array('name' => $game['name'], 'platform' => $platform->getId()));
                if(!$existingGame){
                    $newGame = new Game();
                    $newGame->setName($game['name']);
                    $newGame->setReleaseDay($game['expected_release_day']);
                    $newGame->setReleaseMonth($game['expected_release_day']);
                    $newGame->setReleaseYear($game['expected_release_year']);
                    $newGame->setPlatform($platform);
                    $em->persist($newGame);
                    $em->flush();
                    $this->processImages($game['image'], $newGame);
                }
            }
        }
    }

    protected function processImages($image, $game){
        $em = $this->getContainer()->get('doctrine')->getManager();
        // save only thumb by now
        if(!empty($image['thumb_url'])){
            $newImage = new Image();
            $newImage->setGame($game);
            $newImage->setUrl($image['thumb_url']);
            $em->persist($newImage);
        }
        $em->flush();
    }

} 