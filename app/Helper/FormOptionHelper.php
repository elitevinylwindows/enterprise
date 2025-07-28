<?php

namespace App\Helper;

use App\Models\FormOption;
   use Illuminate\Support\Facades\DB;

class FormOptionHelper
{
    /**
     * Get filtered form options by group name and color condition
     */

public static function getOptionsByGroupAndCondition($groupName, $color = null)
{
    return FormOption::whereHas('group', function ($query) use ($groupName, $color) {
        $query->where('name', $groupName);

        if ($color) {
            $query->where(function ($q) use ($color) {
                $q->whereNull('condition')
                  ->orWhere('condition', 'like', "%$color%");
            });
        }
    })->get();
}

}
