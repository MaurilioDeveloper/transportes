<?php

namespace App\Traits;

use Illuminate\Validation\Factory as Validate;

trait Standard
{

    /**
     * @param $dadosForm
     * @return string
     * Method used in others method for Validation create and update data
     */
    public function validationData($dadosForm, $class)
    {
        $validate = $this->validate->make($dadosForm, $class::$rules);
        if ($validate->fails()) {
            $messages = $validate->messages();
            $displayErrors = '';

            foreach ($messages->all("<p>:message</p>") as $error) {
                $displayErrors .= $error;
            }

            return $displayErrors;
        }
    }
}