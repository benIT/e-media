<?php

namespace AppBundle\Services;

use App\Exception\MethodNotFoundException;
use Doctrine\Common\Util\Inflector;
use Symfony\Component\Validator\Exception\NoSuchMetadataException;
use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\DirectoryNamerInterface;


class SubdirUniqDirectoryNamer implements DirectoryNamerInterface
{
    /**
     * {@inheritdoc}
     */
    public function directoryName($object, PropertyMapping $mapping)
    {
        if (method_exists(!$object, 'getId')) {
            throw new MethodNotFoundException();
        }

        return $object->getId();
    }
}
