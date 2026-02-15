<?php


namespace IlBronza\Payments\Providers\DatatablesFields\Orderrows;

use IlBronza\Datatables\DatatablesFields\DatatableField;

class DatatableFieldDescriptions extends DatatableField
{
	public function transformValue($value)
	{
		$result = [];

		foreach($value as $_value)
			$result[] = "<span uk-tooltip='{$_value->getDescription()}'>{$_value->getDescription(40)}</span>";

		return implode("<br />", $result);
	}

}