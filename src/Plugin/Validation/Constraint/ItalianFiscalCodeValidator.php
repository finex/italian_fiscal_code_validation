<?php


<?php

namespace Drupal\italian_fiscal_code_validation\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use CodiceFiscale\Validator;

/**
 * Validates the ID validity checker constraint.
 */
class ItalianFiscalCodeValidator extends ConstraintValidator {

  /**
   * {@inheritdoc}
   */
  public function validate($items, Constraint $constraint) {

    if (!$constraint instanceof PicItalian) {
      throw new UnexpectedTypeException($constraint, __NAMESPACE__ . '\\PicItalian');
    }

    if (!empty($items)) {
      foreach ($items as $item) {
        if (!$item instanceof PersonalIdItem) {
          throw new UnexpectedTypeException($item, __NAMESPACE__ . '\\PersonalIdItem');
        }
        $this->validateString($item->value, $constraint);
      }
    }

  }

  /**
   * Codice Fiscale validator.
   *
   * @param string $value
   *   Value to be validated.
   * @param \Symfony\Component\Validator\Constraint $constraint
   *   The constraint holding the messages.
   */
  public function validateString($value, $constraint) {

    $trimmed = trim($value);
    $validator = new Validator($trimmed);
    $response = $validator->isFormallyValid();

    if ($response != TRUE) {
      $this->context->addViolation($constraint->errorFormalCheck, [
        '%value' => $trimmed,
      ]);
      return;
    }
    else {
      $message = t("Codice Fiscale %trimmed is formally correct", ["%trimmed" => $trimmed]);
      \Drupal::logger('personal_id')->notice($message);
      \Drupal::messenger()->addMessage($message, 'status', TRUE);
    }

    if ($trimmed !== strtoupper($trimmed)) {
      $this->context->addViolation($constraint->errorNotCapitalized, [
        '%value' => $trimmed,
      ]);
      return;
    }

  }

}
