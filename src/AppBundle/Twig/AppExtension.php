<?php

namespace AppBundle\Twig;

use Symfony\Component\Translation\TranslatorInterface;

class AppExtension extends \Twig_Extension
{
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('boolean', array($this, 'booleanFilter')),
        );
    }

    public function booleanFilter($value)
    {
        if ($value) {
            return $this->translator->trans('yes', [], 'common');
        } else {
            return $this->translator->trans('no', [], 'common');
        }
    }

    public function getName()
    {
        return 'app_extension';
    }
}
