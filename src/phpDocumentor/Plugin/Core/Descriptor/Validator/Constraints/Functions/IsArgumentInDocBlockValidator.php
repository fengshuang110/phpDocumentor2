<?php
/**
 * phpDocumentor
 *
 * PHP Version 5.3
 *
 * @copyright 2010-2014 Mike van Riel / Naenius (http://www.naenius.com)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://phpdoc.org
 */

namespace phpDocumentor\Plugin\Core\Descriptor\Validator\Constraints\Functions;

use phpDocumentor\Descriptor\ArgumentDescriptor;
use phpDocumentor\Descriptor\Collection;
use phpDocumentor\Descriptor\MethodDescriptor;
use phpDocumentor\Descriptor\FunctionDescriptor;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;

/**
 * Validates if a Method or Function's arguments all have an accompanying param tag in the DocBlock.
 */
class IsArgumentInDocBlockValidator extends ConstraintValidator
{
    /**
     * @see \Symfony\Component\Validator\ConstraintValidatorInterface::validate()
     */
    public function validate($value, Constraint $constraint)
    {
        if (is_array($value)) {
            $args = @$value[1];
        } else {
            $args = $value->getArguments();
        }

        if (count($args) > 0) {
            $params = $args->getAll();
            foreach ($params as $param) {
                $type = $param->getTypes();
                if (is_array($type) && empty($type)) {
                    $this->context->addViolationAt(
                        'argument',
                        $constraint->message,
                        array($param->getName(), $value->getFullyQualifiedStructuralElementName())
                    );
                }
            }

            $this->context->addViolationAt(
                'argument',
                $constraint->message,
                array($argument->getName(), $value->getFullyQualifiedStructuralElementName())
            );
        }
    }

    /**
     * Returns whether the list of param tags features the given argument.
     *
     * @param ParamDescriptor[]|Collection $parameters
     * @param ArgumentDescriptor           $argument
     *
     * @return boolean
     */
    private function existsParamTagWithArgument($parameters, ArgumentDescriptor $argument)
    {
        foreach ($parameters as $parameter) {
            if ($argument->getName() == $parameter->getVariableName()) {
                return true;
            }
        }

        return false;
    }
}
