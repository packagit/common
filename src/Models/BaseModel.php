<?php

namespace Packagit\Common\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseModel.
 * @property int $id
 */
class BaseModel extends Model
{
    protected $guarded = ['id'];

    /**
     * @param \DateTimeInterface $date
     *
     * @return string
     */
    protected function serializeDate(\DateTimeInterface $date)
    {
        if (version_compare(app()->version(), '7.0.0') < 0) {
            return parent::serializeDate($date);
        }

        return $date->format(Carbon::DEFAULT_TO_STRING_FORMAT);
    }
}
