<?php

declare(strict_types=1);

namespace App\Traits;

use Twig\Environment;

/**
 * TwigTrait.
 */
trait TwigTrait
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * @param Environment $em
     *
     * @required
     */
    public function setTwig(Environment $em): void
    {
        $this->twig = $em;
    }
}
