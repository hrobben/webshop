<?php

namespace WebshopBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class WebshopBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
