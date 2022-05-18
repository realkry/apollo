<?php

namespace Metapp\Apollo\Form\View\Helper;

class FormCheckbox extends \Laminas\Form\View\Helper\FormCheckbox
{
    /**
     * {@inheritdoc}
     */
    public function getInlineClosingBracket()
    {
        return '><span class="checkmark"></span>';
    }
}
