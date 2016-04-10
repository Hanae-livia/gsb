<?php

namespace GSB\GSB;


use Slim\Http\Request;

/**
 * Valide les champs d'un formulaire
 */
class Validator
{
    protected $rules = [];
    protected $params = [];

    public function __construct(Request $request)
    {
        $this->params = $request->getParams(); // Récupère les params de la requête ($_GET / $_POST)
    }

    /**
     * Récupère les règles de validation
     * @param array $rules
     */
    public function addRules(array $rules)
    {
        $this->rules = $rules;
    }

    public function validate()
    {
        $valid = true;

        var_dump($this->rules);
        var_dump($this->params);
        var_dump('---------------');
        foreach ($this->rules as $name => $rule) {
            var_dump('LOOP ' . $name . ' => ' . $rule);
            $value = trim($this->params[$name]);

            switch ($rule) {
                case 'notEmpty':
                    $valid = $this->isNotEmpty($value);
                    break;

                default:
                    break;
            }
        }
        var_dump($valid);
        return $valid;
    }

    protected function isNotEmpty($value)
    {
        return !empty($value);
    }
}
