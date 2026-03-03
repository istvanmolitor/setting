<?php

namespace Molitor\Setting\Services;

use Exception;
use Molitor\Setting\Events\SettingAfterSaveEvent;
use Molitor\Setting\Events\SettingBeforeSaveEvent;

class SettingHandler
{
    protected array $settingFormClasses = [];

    protected null|array $settingForms = null;

    public function registerSettingForm(string $className): void
    {
        $this->settingFormClasses[] = $className;
    }

    public function getSettingForms(): array
    {
        if ($this->settingForms === null) {
            $this->settingForms = [];
            foreach ($this->settingFormClasses as $className) {
                /** @var SettingForm $settingForm */
                $settingForm = app($className);
                if (!($settingForm instanceof SettingForm)) {
                    throw new Exception("Class {$className} must implement " . SettingForm::class);
                }
                $this->settingForms[$settingForm->getSlug()] = $settingForm;
            }
        }
        return $this->settingForms;
    }

    public function getSettingFormBySlug(string $slug): SettingForm|null
    {
        $handles = $this->getSettingForms();
        return $handles[$slug] ?? null;
    }

    public function toArray(): array
    {
        $tabs = [];
        /** @var SettingForm $settingForm */
        foreach ($this->getSettingForms() as $settingForm) {
            $tabs[] = [
                'slug' => $settingForm->getSlug(),
                'label' => $settingForm->getLabel(),
            ];
        }
        return $tabs;
    }

    public function saveSettingFormValues(string $slug, array $values): void
    {
        $settingForm = $this->getSettingFormBySlug($slug);
        if ($settingForm) {
            $previousSettingFormValues = $this->getSettingFormValues($slug);

            $settingForm->beforeSave($previousSettingFormValues, $values);
            SettingBeforeSaveEvent::dispatch($slug, $previousSettingFormValues, $values);

            $settingForm->saveValues($values);

            $settingForm->afterSave($values, $values);
            SettingAfterSaveEvent::dispatch($slug, $values, $values);
        }
    }

    public function getFormSchema(string $slug): array
    {
        $settingHandler = $this->getSettingFormBySlug($slug);
        if(!$settingHandler) {
            return [];
        }
        return $settingHandler->getForm();
    }

    public function getSettingFormValues(string $slug): array
    {
        $settingHandler = $this->getSettingFormBySlug($slug);
        if(!$settingHandler) {
            return [];
        }
        return $settingHandler->getValues();
    }

    public function getDefaults(string $slug): array
    {
        $settingHandler = $this->getSettingFormBySlug($slug);
        if(!$settingHandler) {
            return [];
        }
        return $settingHandler->getDefaultValues();
    }

    public function get(string $slug, string $name): mixed
    {
        $settingHandler = $this->getSettingFormBySlug($slug);
        if(!$settingHandler) {
            return null;
        }
        return $settingHandler->get($name);
    }
}
