<?php

namespace App\Models;


use App\Models\Interfaces\DocumentTypeInterface;
use Illuminate\Database\Eloquent\Model;;


class DocumentType extends Model implements DocumentTypeInterface
{
    /**
     * Table name.
     *
     * @var array
     */

    public $table = 'document_types';

    /**
     * The attributes that are guarded.
     *
     * @var array
     */
    protected $guarded = [
    ];


}