<?php

namespace IlBronza\Payments\Models;

use IlBronza\Payments\Models\BasePaymentsModel;

class Paymenttype extends BasePaymentsModel
{
	static $modelConfigPrefix = 'paymenttype';
	
	static $deletingRelationships = [];
}
