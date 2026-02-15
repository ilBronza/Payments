<?php


namespace IlBronza\Payments\Providers\DatatablesFields\Orderrows;

use IlBronza\Datatables\DatatablesFields\DatatableField;

class DatatableFieldOrders extends DatatableField
{
	public function transformValue($value)
	{
		$result = [];

		foreach($value as $_value)
		{
			$order = $_value->getOrder();
			$result[] = "<a href='{$order?->getEditUrl()}'>{$order?->getName()}</a>";
		}

		return implode("<br />", $result);
	}

}