<?php

/**
 * This file is created by Matthieu Baillieu
 * 
 * 11/04/2017 - tinkergotinker@gmail.com
 */

namespace Cocorico\CoreBundle\Model;

use Cocorico\CoreBundle\Entity\EditoPick;
use Cocorico\CoreBundle\Validator\Constraints as CocoricoAssert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * BaseEditorPick
 * 
 * @ORM\MappedSuperclass
 */
abstract class BaseEditorPick
{
    
}