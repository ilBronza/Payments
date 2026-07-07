<?php

namespace IlBronza\Payments\Providers\DatatablesFields\Links;

use IlBronza\Datatables\DatatablesFields\Links\DatatableFieldLink;

class DatatableFieldConfirm extends DatatableFieldLink
{
    public $faIcon = 'right-left';

    public function getCustomColumnDefSingleResult()
    {
        $confirmMessage = $this->confirmMessage
            ? e(__($this->confirmMessage))
            : null;

        $onclick = $confirmMessage
            ? " onclick=\"return confirm('{$confirmMessage}')\""
            : '';

        return "
            if(item && item[0])
            {
                item = '<a href=\"' + item[0] + '\"{$onclick} " . $this->getHtmlClassesAttributeString() . ">" . $this->getIconHtml() . " ' + ((item[1]) ? item[1] : '') + '</a>';
            }
            else item = '';
        ";
    }
}
