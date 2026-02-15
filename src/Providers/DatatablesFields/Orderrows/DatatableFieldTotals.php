<?php


namespace IlBronza\Payments\Providers\DatatablesFields\Orderrows;

use IlBronza\Datatables\DatatablesFields\DatatableField;

class DatatableFieldTotals extends DatatableField
{
	public function transformValue($value)
	{
		$result = [];

		foreach($value as $_value)
			$result[] =  number_format($_value->getCalculatedCostCompanyTotal(), 2, ',', '.');


		return implode("<br />", $result);
	}

}