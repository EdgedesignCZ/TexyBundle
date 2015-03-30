<?php

namespace Edge\TexyBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class EdgeTexyBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new DependencyInjection\EdgeTexyExtension();
    }
}
