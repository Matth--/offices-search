<?php

namespace AppBundle\Services;

class FormatOffices
{
    public function formatOffices($offices)
    {
        $offices_to_return = array();
        foreach($offices as $office)
        {
            $office['city'] = ucfirst(strtolower($office['city']));
            $office['street'] = implode('-', array_map('ucwords', explode('-', strtolower($office['street']))));
            array_push($offices_to_return, $office);
        }

        return $offices_to_return;
    }
}
