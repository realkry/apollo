<?php

namespace Metapp\Apollo\Form;

use Laminas\Form\FormAbstractServiceFactory;
use Laminas\Form\FormElementManager;
use Laminas\Form\FormElementManagerFactory;
use Metapp\Apollo\Form\View\Helper\FormElement;
use Laminas\Form\View\Helper\Factory\FormElementErrorsFactory;
use Laminas\ServiceManager\Factory\InvokableFactory;

class ConfigProvider
{
    /**
     * Return general-purpose laminas-i18n configuration.
     *
     * @return array
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencyConfig(),
            'view_helpers' => $this->getViewHelperConfig(),
        ];
    }

    /**
     * Return application-level dependency configuration.
     *
     * @return array
     */
    public function getDependencyConfig(): array
    {
        return [
            'abstract_factories' => [
                FormAbstractServiceFactory::class,
            ],
            'aliases'            => [
                \Laminas\Form\Annotation\AnnotationBuilder::class => 'FormAnnotationBuilder',
                \Laminas\Form\Annotation\AttributeBuilder::class  => 'FormAttributeBuilder',
                FormElementManager::class           => 'FormElementManager',
            ],
            'factories'          => [
                'FormAnnotationBuilder' => \Laminas\Form\Annotation\BuilderAbstractFactory::class,
                'FormAttributeBuilder'  => \Laminas\Form\Annotation\BuilderAbstractFactory::class,
                'FormElementManager'    => FormElementManagerFactory::class,
            ],
        ];
    }

    /**
     * Return laminas-form helper configuration.
     *
     * Obsoletes View\HelperConfig.
     *
     * @return array
     */
    public function getViewHelperConfig(): array
    {
        return [
            'aliases'   => [
                'form'         => View\Helper\Form::class,
                'Form'         => View\Helper\Form::class,
                'formbutton'   => \Laminas\Form\View\Helper\FormButton::class,
                'form_button'  => \Laminas\Form\View\Helper\FormButton::class,
                'formButton'   => \Laminas\Form\View\Helper\FormButton::class,
                'FormButton'   => \Laminas\Form\View\Helper\FormButton::class,
                'formcaptcha'  => \Laminas\Form\View\Helper\FormCaptcha::class,
                'form_captcha' => \Laminas\Form\View\Helper\FormCaptcha::class,
                'formCaptcha'  => \Laminas\Form\View\Helper\FormCaptcha::class,
                'FormCaptcha'  => \Laminas\Form\View\Helper\FormCaptcha::class,
                'captchadumb'  => \Laminas\Form\View\Helper\Captcha\Dumb::class,
                'captcha_dumb' => \Laminas\Form\View\Helper\Captcha\Dumb::class,
                // weird alias used by Laminas\Captcha
                'captcha/dumb'      => \Laminas\Form\View\Helper\Captcha\Dumb::class,
                'CaptchaDumb'       => \Laminas\Form\View\Helper\Captcha\Dumb::class,
                'captchaDumb'       => \Laminas\Form\View\Helper\Captcha\Dumb::class,
                'formcaptchadumb'   => \Laminas\Form\View\Helper\Captcha\Dumb::class,
                'form_captcha_dumb' => \Laminas\Form\View\Helper\Captcha\Dumb::class,
                'formCaptchaDumb'   => \Laminas\Form\View\Helper\Captcha\Dumb::class,
                'FormCaptchaDumb'   => \Laminas\Form\View\Helper\Captcha\Dumb::class,
                'captchafiglet'     => \Laminas\Form\View\Helper\Captcha\Figlet::class,
                // weird alias used by Laminas\Captcha
                'captcha/figlet'      => \Laminas\Form\View\Helper\Captcha\Figlet::class,
                'captcha_figlet'      => \Laminas\Form\View\Helper\Captcha\Figlet::class,
                'captchaFiglet'       => \Laminas\Form\View\Helper\Captcha\Figlet::class,
                'CaptchaFiglet'       => \Laminas\Form\View\Helper\Captcha\Figlet::class,
                'formcaptchafiglet'   => \Laminas\Form\View\Helper\Captcha\Figlet::class,
                'form_captcha_figlet' => \Laminas\Form\View\Helper\Captcha\Figlet::class,
                'formCaptchaFiglet'   => \Laminas\Form\View\Helper\Captcha\Figlet::class,
                'FormCaptchaFiglet'   => \Laminas\Form\View\Helper\Captcha\Figlet::class,
                'captchaimage'        => \Laminas\Form\View\Helper\Captcha\Image::class,
                // weird alias used by Laminas\Captcha
                'captcha/image'      => \Laminas\Form\View\Helper\Captcha\Image::class,
                'captcha_image'      => \Laminas\Form\View\Helper\Captcha\Image::class,
                'captchaImage'       => \Laminas\Form\View\Helper\Captcha\Image::class,
                'CaptchaImage'       => \Laminas\Form\View\Helper\Captcha\Image::class,
                'formcaptchaimage'   => \Laminas\Form\View\Helper\Captcha\Image::class,
                'form_captcha_image' => \Laminas\Form\View\Helper\Captcha\Image::class,
                'formCaptchaImage'   => \Laminas\Form\View\Helper\Captcha\Image::class,
                'FormCaptchaImage'   => \Laminas\Form\View\Helper\Captcha\Image::class,
                'captcharecaptcha'   => \Laminas\Form\View\Helper\Captcha\ReCaptcha::class,
                // weird alias used by Laminas\Captcha
                'captcha/recaptcha'          => \Laminas\Form\View\Helper\Captcha\ReCaptcha::class,
                'captcha_recaptcha'          => \Laminas\Form\View\Helper\Captcha\ReCaptcha::class,
                'captchaRecaptcha'           => \Laminas\Form\View\Helper\Captcha\ReCaptcha::class,
                'CaptchaRecaptcha'           => \Laminas\Form\View\Helper\Captcha\ReCaptcha::class,
                'formcaptcharecaptcha'       => \Laminas\Form\View\Helper\Captcha\ReCaptcha::class,
                'form_captcha_recaptcha'     => \Laminas\Form\View\Helper\Captcha\ReCaptcha::class,
                'formCaptchaRecaptcha'       => \Laminas\Form\View\Helper\Captcha\ReCaptcha::class,
                'FormCaptchaRecaptcha'       => \Laminas\Form\View\Helper\Captcha\ReCaptcha::class,
                'formcheckbox'               => View\Helper\FormCheckbox::class,
                'form_checkbox'              => View\Helper\FormCheckbox::class,
                'formCheckbox'               => View\Helper\FormCheckbox::class,
                'FormCheckbox'               => View\Helper\FormCheckbox::class,
                'formcollection'             => View\Helper\FormCollection::class,
                'form_collection'            => View\Helper\FormCollection::class,
                'formCollection'             => View\Helper\FormCollection::class,
                'FormCollection'             => View\Helper\FormCollection::class,
                'formcolor'                  => \Laminas\Form\View\Helper\FormColor::class,
                'form_color'                 => \Laminas\Form\View\Helper\FormColor::class,
                'formColor'                  => \Laminas\Form\View\Helper\FormColor::class,
                'FormColor'                  => \Laminas\Form\View\Helper\FormColor::class,
                'formdate'                   => \Laminas\Form\View\Helper\FormDate::class,
                'form_date'                  => \Laminas\Form\View\Helper\FormDate::class,
                'formDate'                   => \Laminas\Form\View\Helper\FormDate::class,
                'FormDate'                   => \Laminas\Form\View\Helper\FormDate::class,
                'formdatetime'               => \Laminas\Form\View\Helper\FormDateTime::class,
                'form_date_time'             => \Laminas\Form\View\Helper\FormDateTime::class,
                'formDateTime'               => \Laminas\Form\View\Helper\FormDateTime::class,
                'FormDateTime'               => \Laminas\Form\View\Helper\FormDateTime::class,
                'formdatetimelocal'          => \Laminas\Form\View\Helper\FormDateTimeLocal::class,
                'form_date_time_local'       => \Laminas\Form\View\Helper\FormDateTimeLocal::class,
                'formDateTimeLocal'          => \Laminas\Form\View\Helper\FormDateTimeLocal::class,
                'FormDateTimeLocal'          => \Laminas\Form\View\Helper\FormDateTimeLocal::class,
                'formdatetimeselect'         => \Laminas\Form\View\Helper\FormDateTimeSelect::class,
                'form_date_time_select'      => \Laminas\Form\View\Helper\FormDateTimeSelect::class,
                'formDateTimeSelect'         => \Laminas\Form\View\Helper\FormDateTimeSelect::class,
                'FormDateTimeSelect'         => \Laminas\Form\View\Helper\FormDateTimeSelect::class,
                'formdateselect'             => \Laminas\Form\View\Helper\FormDateSelect::class,
                'form_date_select'           => \Laminas\Form\View\Helper\FormDateSelect::class,
                'formDateSelect'             => \Laminas\Form\View\Helper\FormDateSelect::class,
                'FormDateSelect'             => \Laminas\Form\View\Helper\FormDateSelect::class,
                'form_element'               => View\Helper\FormElement::class,
                'formelement'                => View\Helper\FormElement::class,
                'formElement'                => View\Helper\FormElement::class,
                'FormElement'                => View\Helper\FormElement::class,
                'form_element_errors'        => View\Helper\FormElementErrors::class,
                'formelementerrors'          => View\Helper\FormElementErrors::class,
                'formElementErrors'          => View\Helper\FormElementErrors::class,
                'FormElementErrors'          => View\Helper\FormElementErrors::class,
                'form_email'                 => \Laminas\Form\View\Helper\FormEmail::class,
                'formemail'                  => \Laminas\Form\View\Helper\FormEmail::class,
                'formEmail'                  => \Laminas\Form\View\Helper\FormEmail::class,
                'FormEmail'                  => \Laminas\Form\View\Helper\FormEmail::class,
                'form_file'                  => \Laminas\Form\View\Helper\FormFile::class,
                'formfile'                   => \Laminas\Form\View\Helper\FormFile::class,
                'formFile'                   => \Laminas\Form\View\Helper\FormFile::class,
                'FormFile'                   => \Laminas\Form\View\Helper\FormFile::class,
                'formfileapcprogress'        => \Laminas\Form\View\Helper\File\FormFileApcProgress::class,
                'form_file_apc_progress'     => \Laminas\Form\View\Helper\File\FormFileApcProgress::class,
                'formFileApcProgress'        => \Laminas\Form\View\Helper\File\FormFileApcProgress::class,
                'FormFileApcProgress'        => \Laminas\Form\View\Helper\File\FormFileApcProgress::class,
                'formfilesessionprogress'    => \Laminas\Form\View\Helper\File\FormFileSessionProgress::class,
                'form_file_session_progress' => \Laminas\Form\View\Helper\File\FormFileSessionProgress::class,
                'formFileSessionProgress'    => \Laminas\Form\View\Helper\File\FormFileSessionProgress::class,
                'FormFileSessionProgress'    => \Laminas\Form\View\Helper\File\FormFileSessionProgress::class,
                'formfileuploadprogress'     => \Laminas\Form\View\Helper\File\FormFileUploadProgress::class,
                'form_file_upload_progress'  => \Laminas\Form\View\Helper\File\FormFileUploadProgress::class,
                'formFileUploadProgress'     => \Laminas\Form\View\Helper\File\FormFileUploadProgress::class,
                'FormFileUploadProgress'     => \Laminas\Form\View\Helper\File\FormFileUploadProgress::class,
                'formhidden'                 => \Laminas\Form\View\Helper\FormHidden::class,
                'form_hidden'                => \Laminas\Form\View\Helper\FormHidden::class,
                'formHidden'                 => \Laminas\Form\View\Helper\FormHidden::class,
                'FormHidden'                 => \Laminas\Form\View\Helper\FormHidden::class,
                'formimage'                  => \Laminas\Form\View\Helper\FormImage::class,
                'form_image'                 => \Laminas\Form\View\Helper\FormImage::class,
                'formImage'                  => \Laminas\Form\View\Helper\FormImage::class,
                'FormImage'                  => \Laminas\Form\View\Helper\FormImage::class,
                'forminput'                  => \Laminas\Form\View\Helper\FormInput::class,
                'form_input'                 => \Laminas\Form\View\Helper\FormInput::class,
                'formInput'                  => \Laminas\Form\View\Helper\FormInput::class,
                'FormInput'                  => \Laminas\Form\View\Helper\FormInput::class,
                'formlabel'                  => \Laminas\Form\View\Helper\FormLabel::class,
                'form_label'                 => \Laminas\Form\View\Helper\FormLabel::class,
                'formLabel'                  => \Laminas\Form\View\Helper\FormLabel::class,
                'FormLabel'                  => \Laminas\Form\View\Helper\FormLabel::class,
                'formmonth'                  => \Laminas\Form\View\Helper\FormMonth::class,
                'form_month'                 => \Laminas\Form\View\Helper\FormMonth::class,
                'formMonth'                  => \Laminas\Form\View\Helper\FormMonth::class,
                'FormMonth'                  => \Laminas\Form\View\Helper\FormMonth::class,
                'formmonthselect'            => \Laminas\Form\View\Helper\FormMonthSelect::class,
                'form_month_select'          => \Laminas\Form\View\Helper\FormMonthSelect::class,
                'formMonthSelect'            => \Laminas\Form\View\Helper\FormMonthSelect::class,
                'FormMonthSelect'            => \Laminas\Form\View\Helper\FormMonthSelect::class,
                'formmulticheckbox'          => View\Helper\FormMultiCheckbox::class,
                'form_multi_checkbox'        => View\Helper\FormMultiCheckbox::class,
                'formMultiCheckbox'          => View\Helper\FormMultiCheckbox::class,
                'FormMultiCheckbox'          => View\Helper\FormMultiCheckbox::class,
                'formnumber'                 => \Laminas\Form\View\Helper\FormNumber::class,
                'form_number'                => \Laminas\Form\View\Helper\FormNumber::class,
                'formNumber'                 => \Laminas\Form\View\Helper\FormNumber::class,
                'FormNumber'                 => \Laminas\Form\View\Helper\FormNumber::class,
                'formpassword'               => \Laminas\Form\View\Helper\FormPassword::class,
                'form_password'              => \Laminas\Form\View\Helper\FormPassword::class,
                'formPassword'               => \Laminas\Form\View\Helper\FormPassword::class,
                'FormPassword'               => \Laminas\Form\View\Helper\FormPassword::class,
                'formradio'                  => \Laminas\Form\View\Helper\FormRadio::class,
                'form_radio'                 => \Laminas\Form\View\Helper\FormRadio::class,
                'formRadio'                  => \Laminas\Form\View\Helper\FormRadio::class,
                'FormRadio'                  => \Laminas\Form\View\Helper\FormRadio::class,
                'formrange'                  => \Laminas\Form\View\Helper\FormRange::class,
                'form_range'                 => \Laminas\Form\View\Helper\FormRange::class,
                'formRange'                  => \Laminas\Form\View\Helper\FormRange::class,
                'FormRange'                  => \Laminas\Form\View\Helper\FormRange::class,
                'formreset'                  => \Laminas\Form\View\Helper\FormReset::class,
                'form_reset'                 => \Laminas\Form\View\Helper\FormReset::class,
                'formReset'                  => \Laminas\Form\View\Helper\FormReset::class,
                'FormReset'                  => \Laminas\Form\View\Helper\FormReset::class,
                'formrow'                    => View\Helper\FormRow::class,
                'form_row'                   => View\Helper\FormRow::class,
                'formRow'                    => View\Helper\FormRow::class,
                'FormRow'                    => View\Helper\FormRow::class,
                'formsearch'                 => \Laminas\Form\View\Helper\FormSearch::class,
                'form_search'                => \Laminas\Form\View\Helper\FormSearch::class,
                'formSearch'                 => \Laminas\Form\View\Helper\FormSearch::class,
                'FormSearch'                 => \Laminas\Form\View\Helper\FormSearch::class,
                'formselect'                 => \Laminas\Form\View\Helper\FormSelect::class,
                'form_select'                => \Laminas\Form\View\Helper\FormSelect::class,
                'formSelect'                 => \Laminas\Form\View\Helper\FormSelect::class,
                'FormSelect'                 => \Laminas\Form\View\Helper\FormSelect::class,
                'formsubmit'                 => \Laminas\Form\View\Helper\FormSubmit::class,
                'form_submit'                => \Laminas\Form\View\Helper\FormSubmit::class,
                'formSubmit'                 => \Laminas\Form\View\Helper\FormSubmit::class,
                'FormSubmit'                 => \Laminas\Form\View\Helper\FormSubmit::class,
                'formtel'                    => \Laminas\Form\View\Helper\FormTel::class,
                'form_tel'                   => \Laminas\Form\View\Helper\FormTel::class,
                'formTel'                    => \Laminas\Form\View\Helper\FormTel::class,
                'FormTel'                    => \Laminas\Form\View\Helper\FormTel::class,
                'formtext'                   => \Laminas\Form\View\Helper\FormText::class,
                'form_text'                  => \Laminas\Form\View\Helper\FormText::class,
                'formText'                   => \Laminas\Form\View\Helper\FormText::class,
                'FormText'                   => \Laminas\Form\View\Helper\FormText::class,
                'formtextarea'               => \Laminas\Form\View\Helper\FormTextarea::class,
                'form_text_area'             => \Laminas\Form\View\Helper\FormTextarea::class,
                'formTextarea'               => \Laminas\Form\View\Helper\FormTextarea::class,
                'formTextArea'               => \Laminas\Form\View\Helper\FormTextarea::class,
                'FormTextArea'               => \Laminas\Form\View\Helper\FormTextarea::class,
                'formtime'                   => \Laminas\Form\View\Helper\FormTime::class,
                'form_time'                  => \Laminas\Form\View\Helper\FormTime::class,
                'formTime'                   => \Laminas\Form\View\Helper\FormTime::class,
                'FormTime'                   => \Laminas\Form\View\Helper\FormTime::class,
                'formurl'                    => \Laminas\Form\View\Helper\FormUrl::class,
                'form_url'                   => \Laminas\Form\View\Helper\FormUrl::class,
                'formUrl'                    => \Laminas\Form\View\Helper\FormUrl::class,
                'FormUrl'                    => \Laminas\Form\View\Helper\FormUrl::class,
                'formweek'                   => \Laminas\Form\View\Helper\FormWeek::class,
                'form_week'                  => \Laminas\Form\View\Helper\FormWeek::class,
                'formWeek'                   => \Laminas\Form\View\Helper\FormWeek::class,
                'FormWeek'                   => \Laminas\Form\View\Helper\FormWeek::class,
            ],
            'factories' => [
                View\Helper\Form::class                         => InvokableFactory::class,
                \Laminas\Form\View\Helper\FormButton::class                   => InvokableFactory::class,
                \Laminas\Form\View\Helper\FormCaptcha::class                  => InvokableFactory::class,
                \Laminas\Form\View\Helper\Captcha\Dumb::class                 => InvokableFactory::class,
                \Laminas\Form\View\Helper\Captcha\Figlet::class               => InvokableFactory::class,
                \Laminas\Form\View\Helper\Captcha\Image::class                => InvokableFactory::class,
                \Laminas\Form\View\Helper\Captcha\ReCaptcha::class            => InvokableFactory::class,
                View\Helper\FormCheckbox::class                 => InvokableFactory::class,
                View\Helper\FormCollection::class               => InvokableFactory::class,
                \Laminas\Form\View\Helper\FormColor::class                    => InvokableFactory::class,
                \Laminas\Form\View\Helper\FormDate::class                     => InvokableFactory::class,
                \Laminas\Form\View\Helper\FormDateTime::class                 => InvokableFactory::class,
                \Laminas\Form\View\Helper\FormDateTimeLocal::class            => InvokableFactory::class,
                \Laminas\Form\View\Helper\FormDateTimeSelect::class           => InvokableFactory::class,
                \Laminas\Form\View\Helper\FormDateSelect::class               => InvokableFactory::class,
                View\Helper\FormElement::class                  => InvokableFactory::class,
                View\Helper\FormElementErrors::class            => FormElementErrorsFactory::class,
                \Laminas\Form\View\Helper\FormEmail::class                    => InvokableFactory::class,
                \Laminas\Form\View\Helper\FormFile::class                     => InvokableFactory::class,
                \Laminas\Form\View\Helper\File\FormFileApcProgress::class     => InvokableFactory::class,
                \Laminas\Form\View\Helper\File\FormFileSessionProgress::class => InvokableFactory::class,
                \Laminas\Form\View\Helper\File\FormFileUploadProgress::class  => InvokableFactory::class,
                \Laminas\Form\View\Helper\FormHidden::class                   => InvokableFactory::class,
                \Laminas\Form\View\Helper\FormImage::class                    => InvokableFactory::class,
                \Laminas\Form\View\Helper\FormInput::class                    => InvokableFactory::class,
                \Laminas\Form\View\Helper\FormLabel::class                    => InvokableFactory::class,
                \Laminas\Form\View\Helper\FormMonth::class                    => InvokableFactory::class,
                \Laminas\Form\View\Helper\FormMonthSelect::class              => InvokableFactory::class,
                View\Helper\FormMultiCheckbox::class            => InvokableFactory::class,
                \Laminas\Form\View\Helper\FormNumber::class                   => InvokableFactory::class,
                \Laminas\Form\View\Helper\FormPassword::class                 => InvokableFactory::class,
                \Laminas\Form\View\Helper\FormRadio::class                    => InvokableFactory::class,
                \Laminas\Form\View\Helper\FormRange::class                    => InvokableFactory::class,
                \Laminas\Form\View\Helper\FormReset::class                    => InvokableFactory::class,
                View\Helper\FormRow::class                      => InvokableFactory::class,
                \Laminas\Form\View\Helper\FormSearch::class                   => InvokableFactory::class,
                \Laminas\Form\View\Helper\FormSelect::class                   => InvokableFactory::class,
                \Laminas\Form\View\Helper\FormSubmit::class                   => InvokableFactory::class,
                \Laminas\Form\View\Helper\FormTel::class                      => InvokableFactory::class,
                \Laminas\Form\View\Helper\FormText::class                     => InvokableFactory::class,
                \Laminas\Form\View\Helper\FormTextarea::class                 => InvokableFactory::class,
                \Laminas\Form\View\Helper\FormTime::class                     => InvokableFactory::class,
                \Laminas\Form\View\Helper\FormUrl::class                      => InvokableFactory::class,
                \Laminas\Form\View\Helper\FormWeek::class                     => InvokableFactory::class,
            ],
            'initializers' => [
                FormElement::class => function (/** @noinspection PhpUnusedParameterInspection */ $context, $object) {
                    if ($object instanceof FormElement) {
                        $object->addType('plaintext', 'formPlainText');
                    }
                }
            ]
        ];
    }
}
