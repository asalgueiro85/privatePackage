<?php
namespace AppBundle\Twig;

class AppExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            'age' => new \Twig_Filter_Method($this, 'ageDate'),
        );
    }

    public function ageDate($date)
    {
        $fecha = time() - strtotime($date->format('Y-m-d'));
        $age = floor((($fecha / 3600) / 24) / 360);
        return $age;
    }

    public function getName()
    {
        return 'app_extension';
    }
}