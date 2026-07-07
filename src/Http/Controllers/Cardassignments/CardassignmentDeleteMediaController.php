<?php

namespace IlBronza\Payments\Http\Controllers\Cardassignments;

use IlBronza\CRUD\Models\Media;
use IlBronza\CRUD\Traits\CRUDDeleteMediaTrait;

class CardassignmentDeleteMediaController extends CardassignmentCRUD
{
    use CRUDDeleteMediaTrait;

    public $allowedMethods = ['deleteMedia'];

    public function deleteMedia($cardAssignment, Media $media)
    {
        return $this->_deleteMedia($cardAssignment, $media);
    }
}
