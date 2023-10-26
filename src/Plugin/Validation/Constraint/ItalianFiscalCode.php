<?php


<?php

namespace Drupal\italian_fiscal_code_validator\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * Provides an ID validity checker constraint.
 *
 * @Constraint(
 *   id = "ItalianFiscalCode",
 *   label = @Translation("Matches the pattern of Italian Personal Identification Code", context = "Validation"),
 * )
 */
class ItalianFiscalCode extends Constraint {

  /**
   * Error that will be shown if the provided value contains lowercase chars.
   *
   * @var string
   */
  public $errorNotCapitalized = '"%value" is not fully capitalized. Please check your input.';


  /**
   * Error that will be shown if the provided value checksum is invalid.
   *
   * @var string
   */

  public $errorFormalCheck = '"%value" is not formally correct. Please check your input.';

}
