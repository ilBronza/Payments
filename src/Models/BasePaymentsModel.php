<?php

namespace IlBronza\Payments\Models;

use IlBronza\CRUD\Models\PackagedBaseModel;
use IlBronza\CRUD\Traits\Model\CRUDGetOrCreateTrait;

class BasePaymentsModel extends PackagedBaseModel
{
	use CRUDGetOrCreateTrait;

	static $packageConfigPrefix = 'payments';

	static function getByName(string $name) : ? static
	{
		return cache()->remember(
			static::staticCacheKey($name),
			3600 * 24,
			function () use($name)
			{
				return static::where('name', $name)->first();
			}
		);
	}
}