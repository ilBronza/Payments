<?php

namespace IlBronza\Payments\Http\Controllers\Parameters\RelationshipsManagers;

use Illuminate\Database\Eloquent\Model;

trait ResolvesPolymorphicRelations
{
    protected function getPolymorphicRelationParameters(string $relation): array
    {
        $related = $this->getModel()->{$relation};

        if (! $related instanceof Model
            || ! method_exists($related, 'getPackageConfigPrefix')
            || ! method_exists($related, 'getModelConfigPrefix')) {
            return [];
        }

        $package = $related->getPackageConfigPrefix();
        $model = $related->getModelConfigPrefix();

        if (! config("{$package}.enabled", true)) {
            return [];
        }

        $controller = config("{$package}.models.{$model}.controllers.show");

        // A missing target or a model without a show must not break its parent's show.
        return is_string($controller) && $controller !== '' ? [$relation => $controller] : [];
    }
}
