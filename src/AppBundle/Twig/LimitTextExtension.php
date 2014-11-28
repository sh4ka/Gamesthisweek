<?php
/*
 * This file is part of the Mundoreader Symfony Base package.
 *
 * (c) Mundo Reader S.L.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Twig;

/**
 * Class LimitTextExtension
 * 
 * @category SymfonyBundle
 * @package  AppBundle\Twig
 * @author   Jesús Flores <jesus.flores@bq.com>
 * @license  http://opensource.org/licenses/GPL-3.0 GNU General Public License
 * @link     http://bq.com
 */
class LimitTextExtension extends \Twig_Extension
{

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('ui_trim', '\AppBundle\Twig\LimitTextExtension::limitFilter'),
        );
    }

    public static function limitFilter($text, $limit = 20, $fill = ' ...')
    {
        if(strlen($text) > $limit){
            return substr($text, 0, $limit) . $fill;
        }
        return $text;
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'limit_text';
    }


} 