<?php


namespace Metapp\Apollo\Twig\Interfaces;

use Twig\Environment;

interface TwigAwareInterface
{
    /**
     * @param Environment $twig
     * @return mixed
     */
    public function setTwig(Environment $twig);
}
