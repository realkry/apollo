<?php

namespace Metapp\Apollo\Form\Builder\Traits;

trait FormBuilderTrait
{
    protected bool $ajax = true;
    protected bool $autoGenerateResponseDiv = true;
    protected bool $resetForm = true;
    protected string|null $resultText = null;
    protected string|null $actionUrl = null;
    protected string|null $resultUrl = null;

    /**
     * @return bool
     */
    public function isAjax(): bool
    {
        return $this->ajax;
    }

    /**
     * @param bool $ajax
     * @return FormBuilderTrait
     */
    public function setAjax(bool $ajax): FormBuilderTrait
    {
        $this->ajax = $ajax;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAutoGenerateResponseDiv(): bool
    {
        return $this->autoGenerateResponseDiv;
    }

    /**
     * @param bool $autoGenerateResponseDiv
     * @return FormBuilderTrait
     */
    public function setAutoGenerateResponseDiv(bool $autoGenerateResponseDiv): FormBuilderTrait
    {
        $this->autoGenerateResponseDiv = $autoGenerateResponseDiv;
        return $this;
    }

    /**
     * @return bool
     */
    public function isResetForm(): bool
    {
        return $this->resetForm;
    }

    /**
     * @param bool $resetForm
     * @return FormBuilderTrait
     */
    public function setResetForm(bool $resetForm): FormBuilderTrait
    {
        $this->resetForm = $resetForm;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getResultText(): ?string
    {
        return $this->resultText;
    }

    /**
     * @param string|null $resultText
     * @return FormBuilderTrait
     */
    public function setResultText(?string $resultText): FormBuilderTrait
    {
        $this->resultText = $resultText;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getActionUrl(): ?string
    {
        return $this->actionUrl;
    }

    /**
     * @param string|null $actionUrl
     * @return FormBuilderTrait
     */
    public function setActionUrl(?string $actionUrl): FormBuilderTrait
    {
        $this->actionUrl = $actionUrl;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getResultUrl(): ?string
    {
        return $this->resultUrl;
    }

    /**
     * @param string|null $resultUrl
     * @return FormBuilderTrait
     */
    public function setResultUrl(?string $resultUrl): FormBuilderTrait
    {
        $this->resultUrl = $resultUrl;
        return $this;
    }
}
