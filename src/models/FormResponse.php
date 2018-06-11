<?php

namespace WATR\Models;

/**
 * FormResponse Model
 */
class FormResponse
{
    /**
     * @var string Form identifier
     */
    public $form_id;

    /**
     * @var string token
     */
    public $token;

    /**
     * @var date submission date
     */
    public $submitted_at;

    /**
     * @var date landed date
     */
    public $landed_at;

    /**
     * @var Form definition of form
     */
    public $definition;

    /**
     * var Answer[] settings
     */
    public $answers = [];

    /**
     * Constructor
     */
    public function __construct($json)
    {
        $this->form_id = $json->form_id;
        $this->token = $json->token;
        $this->submitted_at = \DateTime::createFromFormat(
            'Y-m-d\TH:i:s\Z',
            $json->submitted_at
        );
        $this->landed_at = \DateTime::createFromFormat(
            'Y-m-d\TH:i:s\Z',
            $json->landed_at
        );
        $this->definition = new FormDefinition($json->definition);

        foreach($json->answers as $answer)
        {
            array_push($this->answers, new Answer($answer));
        }
    }

    /**
     * Get Answer with definition
     */
    public function getAnswerByRef($ref)
    {
        $field = $this->definition->getFieldByRef($ref);
        $result = null;

        if($ref == -1){ return -1; }

        foreach($this->answers as $answer)
        {
            if($answer->field_identifier == $field->id)
            {
                $result = $answer;
            }
        }

        return [
            'field' => $field,
            'answer' => $result
        ];
    }
}