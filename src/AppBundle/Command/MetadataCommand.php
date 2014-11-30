<?php
/**
 * @author Jesús Flores <jesus.flores@bq.com>
 */

namespace AppBundle\Command;


use AppBundle\Entity\Game;
use AppBundle\Entity\Image;
use AppBundle\Entity\Metadata;
use AppBundle\Entity\Platform;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\Constraints\DateTime;

class MetadataCommand extends ContainerAwareCommand {

    protected $apiKey;
    protected $logger; // monolog logger
    protected $em; // entity manager

    protected function configure()
    {

        $this
            ->setName('app:metadata')
            ->setDescription('Get fresh new metadata')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->apiKey = $this->getContainer()->getParameter('giant_bomb_api_key');
        $this->logger = $this->getContainer()->get('logger');
        $this->em = $this->getContainer()->get('doctrine')->getManager();
        $this->fetchMetadata();
    }

    protected function fetchMetadata(){
        $games = $this->em->getRepository('AppBundle:Game')->findAll();
        foreach($games as $game){
            $this->insertMetadata($this->fetchGameMetadata($game), $game);
        }
    }

    protected function fetchGameMetadata(Game $game)
    {
        $apiBaseUrl = $game->getDetailsUrl();
        $finalUrl = $apiBaseUrl.'?api_key='.$this->apiKey.'&format=json&';
        $this->logger->debug('Getting metadata url: '.$finalUrl);
        $jsonData = file_get_contents($finalUrl);
        return json_decode($jsonData,TRUE);
    }

    protected function insertMetadata(array $metadata, Game $game){
        $existingMetadata = $this->em->getRepository('AppBundle:Metadata')->findOneBy(array('game' => $game->getId()));
        if(!$existingMetadata){
            $this->logger->debug('New metadata for '.$game->getName());
            $newMetadata = new Metadata();
            $newMetadata->setGame($game);
            $newMetadata->setDetailurl($metadata['results']['deck']);
            $newMetadata->setFulldesc($metadata['results']['description']);
            $newMetadata->setDetailurl($metadata['results']['site_detail_url']);
            $this->processImages($metadata['results']['images'][0], $game);
            $this->em->persist($newMetadata);
            $this->em->flush();
        } else {
            $this->logger->debug('Existing metadata for game: '.$game->getName());
        }
    }

    protected function processImages($imageMetadata, Game $game){
        $types = ['icon', 'medium', 'screen', 'small', 'super', 'thumb', 'tiny'];
        foreach (array_keys($imageMetadata) as $key => $value)
        {
            if(empty($types[$key])){
                continue;
            }
            // icon, medium, screen, small, super, thumb, tiny
            $newImage = new Image();
            $newImage->setImageType($types[$key]);
            $newImage->setGame($game);
            $newImage->setUrl($imageMetadata[$types[$key].'_url']);
            $this->em->persist($newImage);
        }
        $this->em->flush();
    }
} 