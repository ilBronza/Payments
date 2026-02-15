<?php


namespace IlBronza\Payments\Providers\DatatablesFields\Orderrows;

use IlBronza\Datatables\DatatablesFields\DatatableField;

class DatatableFieldTotal extends DatatableField
{
	public function transformValue($value)
	{
		$result = 0;

		foreach($value as $_value)
			$result += $_value->getCalculatedCostCompanyTotal();


		return number_format($result, 2, ',', '.');
	}

}