<?php
/*
 * This file is part of the Mundoreader Symfony Base package.
 *
 * (c) Mundo Reader S.L.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Platform;
/**
 * Class LoadPlatformData
 * 
 * @category SymfonyBundle
 * @author   Jesús Flores <jesus.flores@bq.com>
 * @license  http://opensource.org/licenses/GPL-3.0 GNU General Public License
 * @link     http://bq.com
 */
class LoadPlatformData  implements FixtureInterface
{

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $platformXbox360 = new Platform();
        $platformXbox360->setExternalId(20);
        $platformXbox360->setName('Xbox360');

        $manager->persist($platformXbox360);

        $platformPS3 = new Platform();
        $platformPS3->setExternalId(35);
        $platformPS3->setName('PS3');

        $manager->persist($platformPS3);

        $platformPC = new Platform();
        $platformPC->setExternalId(94);
        $platformPC->setName('PC');

        $manager->persist($platformPC);

        $platformXboxOne= new Platform();
        $platformXboxOne->setExternalId(145);
        $platformXboxOne->setName('XboxOne');

        $manager->persist($platformXboxOne);

        $platformPS4 = new Platform();
        $platformPS4->setExternalId(146);
        $platformPS4->setName('PS4');

        $manager->persist($platformPS4);
        $manager->flush();
    }

} 