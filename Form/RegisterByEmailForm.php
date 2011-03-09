<?php

namespace OpenSky\Bundle\GigyaBundle\Form;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\TextField;

class RegisterByEmailForm extends Form
{
    protected function configure()
    {
        $this->add(new TextField('email'));
    }
}
