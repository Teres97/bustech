<?php
/**
 * Created by PhpStorm.
 * User: eduard
 * Date: 20.02.18
 * Time: 12:52
 */

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class ArticleController
{
    /**
     * @Route("/")
     */
    public function homepage()
    {
        return new Response('Hello World!');
    }
}