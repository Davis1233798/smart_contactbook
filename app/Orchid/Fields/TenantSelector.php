<?php

declare(strict_types=1);

namespace App\Orchid\Fields;

use App\Models\Tenant;

class TenantSelector
{
    /**
     * @var string
     */
    public $view = 'platform.fields.tenant-selector';

    /**
     * Set the options for the select menu from Tenant model.
     */
    public function options(): array
    {
        return Tenant::all()->pluck('name', 'id')->toArray();
    }
}
