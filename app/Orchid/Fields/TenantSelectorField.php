<?php

declare(strict_types=1);

namespace App\Orchid\Fields;

use Orchid\Screen\Field;
use App\Models\Tenant;

class TenantSelectorField extends Field
{
    /**
     * @var string
     */
    public $view = 'platform.fields.tenantselector';

    /**
     * Required Attributes
     *
     * @var array
     */
    public $required = [
        'name',
    ];

    /**
     * Default attributes
     *
     * @var array
     */
    public $attributes = [
        'value' => null,
    ];

    /**
     * Attributes available for a particular tag
     *
     * @var array
     */
    public $inlineAttributes = [
        'value',
        'name',
    ];

    public function tenants()
    {
        $tenants = Tenant::all()->pluck('name', 'id')->toArray();

        return $this->set('tenants', $tenants);
    }
}
