<?php

namespace Drupal\italian_fiscal_code_validator\Plugin\Validation\Constraint;

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

    if (!empty($items)) {
      foreach ($items as $item) {
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
    // else {
    //   $message = t("Codice Fiscale %trimmed is formally correct", ["%trimmed" => $trimmed]);
    //   \Drupal::logger('italian_fiscal_code_validator')->notice($message);
    //   \Drupal::messenger()->addMessage($message, 'status', TRUE);
    // }

    if ($trimmed !== strtoupper($trimmed)) {
      $this->context->addViolation($constraint->errorNotCapitalized, [
        '%value' => $trimmed,
      ]);
      return;
    }

  }

}
