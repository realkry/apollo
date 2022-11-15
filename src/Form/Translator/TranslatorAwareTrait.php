<?php
namespace Metapp\Apollo\Form\Translator;

use Laminas\I18n\Translator\TranslatorInterface;

trait TranslatorAwareTrait
{
    /**
     * @var TranslatorInterface|null
     */
    protected $translator;

    /**
     * @return TranslatorInterface|null
     */
    public function getTranslator()
    {
        return $this->translator;
    }

    /**
     * @param TranslatorInterface $translator
     */
    public function setTranslator(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }
}