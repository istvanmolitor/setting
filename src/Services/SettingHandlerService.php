<?php

namespace Molitor\Setting\Services;

use Exception;

class SettingHandlerService
{
    protected array $settingFormClasses = [];

    protected null|array $settingForms = null;

    public function register(string $className): void
    {
        $this->settingFormClasses[] = $className;
    }

    public function getSettingForms(): array
    {
        if ($this->settingForms === null) {
            $this->settingForms = [];
            foreach ($this->settingFormClasses as $className) {
                $fettingForm = app($className);
                if (!($fettingForm instanceof SettingForm)) {
                    throw new Exception("Class {$className} must implement " . SettingForm::class);
                }
                $this->settingForms[$fettingForm->getSlug()] = $fettingForm;
            }
        }
        return $this->settingForms;
    }

    public function getDefaultSlug(): string
    {
        $handles = $this->getSettingForms();
        return array_key_first($handles);
    }

    public function getBySlug(string $slug): SettingForm|null
    {
        $handles = $this->getSettingForms();
        return $handles[$slug] ?? null;
    }

    public function getTabs(): array
    {
        $tabs = [];
        /** @var SettingForm $handler */
        foreach ($this->getSettingForms() as $handler) {
            $tabs[] = $handler->getTab();
        }
        return $tabs;
    }

    public function saveFormData(string $slug, array $formData): void
    {
        $settingHandler = $this->getBySlug($slug);
        if($settingHandler) {
            $settingHandler->saveFormData($formData);
        }
    }

    public function getFormSchema(string $slug): array
    {
        $settingHandler = $this->getBySlug($slug);
        if(!$settingHandler) {
            return [];
        }
        return $settingHandler->getForm();
    }

    public function getFormData(string $slug): array
    {
        $settingHandler = $this->getBySlug($slug);
        if(!$settingHandler) {
            return [];
        }
        return $settingHandler->getFormData();
    }

    public function getDefaults(string $slug): array
    {
        $settingHandler = $this->getBySlug($slug);
        if(!$settingHandler) {
            return [];
        }
        return $settingHandler->getDefaults();
    }
}
