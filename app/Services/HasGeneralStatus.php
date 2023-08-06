<?php

namespace App\Services;

trait HasGeneralStatus
{
    public function scopeActive($query)
    {
        return $query->where('status', config('general-status-options.active.value'));
    }

    public function scopeDisabled($query)
    {
        return $query->where('status', config('general-status-options.disabled.value'));
    }

    public function isActive()
    {
        return $this->status == config('general-status-options.active.value');
    }

    public function statusLabel()
    {
        if ($this->isActive()) {
            $class = 'bg-teal';
        } else {
            $class = 'bg-navy';
        }

        return '<span class="badge '. $class .'">'. config('general-status-options.' . $this->status . '.label') .'</span>';
    }

    public function scopeStatus($query, $status)
    {
        if ($status == config('general-status-options.active.value')) {
            return $query->active();
        } elseif ($status == config('general-status-options.disabled.value')) {
            return $query->disabled();
        }

        return $query;
    }

    public function generalStatusRule()
    {
        return ValidationRuleFromConfigArrayService::createRule(config('general-status-options'));
    }
}
