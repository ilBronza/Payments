<?php

namespace IlBronza\Payments\Http\Controllers\Parameters\RelationshipsManagers;

use IlBronza\CRUD\Providers\RelationshipsManager\RelationshipsManager;
use IlBronza\Ukn\Facades\Ukn;
use Illuminate\Support\Facades\Log;

class PaymentableRelationManager Extends RelationshipsManager
{
	public  function getAllRelationsParameters() : array
	{
		$relations = [];

		$relations['paymenttype'] = config('payments.models.paymenttype.controllers.show');

		try
		{
			$paymentable = $this->getModel()->paymentable;

			$configPrefix = $paymentable->getPackageConfigPrefix();
			$modelPrefix = $paymentable->getModelConfigPrefix();

			$relations['paymentable'] = config("{$configPrefix}.models.{$modelPrefix}.controllers.show");
		}
		catch(\Throwable $e)
		{
			Log::critical($e->getMessage());
			Ukn::e($e->getMessage());
		}
		

		return [
			'show' => [
				'relations' => $relations
			]
		];
	}
}