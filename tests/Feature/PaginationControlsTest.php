<?php

namespace Tests\Feature;

use App\Livewire\ApplicantsMasterlist;
use App\Livewire\Blacklists;
use App\Livewire\ShelterMaterialsList;
use App\Livewire\Traits\HandlesPagination;
use Tests\TestCase;

class PaginationControlsTest extends TestCase
{
    public function test_paginated_livewire_components_share_pagination_control_trait(): void
    {
        $components = [
            ApplicantsMasterlist::class,
            Blacklists::class,
            ShelterMaterialsList::class,
        ];

        foreach ($components as $component) {
            $this->assertTrue(
                in_array(HandlesPagination::class, class_uses_recursive($component), true),
                "Expected {$component} to use the shared pagination trait."
            );
        }
    }
}
