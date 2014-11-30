<?php
/*
 * This file is part of the Mundoreader Symfony Base package.
 *
 * (c) Mundo Reader S.L.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultController
 * 
 * @category SymfonyBundle
 * @package  AppBundle\Controller
 * @author   Jesús Flores <jesus.flores@bq.com>
 * @license  http://opensource.org/licenses/GPL-3.0 GNU General Public License
 * @link     http://bq.com
 */
class DefaultController extends Controller
{

    public function showAction()
    {
        $em = $this->getDoctrine()->getManager();
        $games = $em->getRepository('AppBundle:Game')->findAll();
        $platforms = $em->getRepository('AppBundle:Platform')->findAll();
        return $this->render('Home/index.html.twig', array(
                'games' => $games,
                'platforms' => $platforms
            )
        );
    }

    public function detailsAction($id){
        $em = $this->getDoctrine()->getManager();
        $game = $em->getRepository('AppBundle:Game')->find($id);
        $platforms = $em->getRepository('AppBundle:Platform')->findAll();
        return $this->render('Game/details.html.twig', array(
                'game' => $game,
                'platforms' => $platforms
            )
        );
    }

    public function showJsonAction()
    {
        $em = $this->getDoctrine()->getManager();
        $serializer = $this->container->get('serializer');
        $games = $serializer->serialize($em->getRepository('AppBundle:Game')->findAll(), 'json');
        return new Response($games);
    }
} 