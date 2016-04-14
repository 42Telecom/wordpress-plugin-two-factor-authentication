<?php
namespace Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value;

use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Interfaces\ValueInterface;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\AbstractValue;

/**
 * Class for the API Callback url Value.
 *
 * @license https://opensource.org/licenses/MIT MIT
 */
class APICallBackUrlValue extends AbstractValue implements ValueInterface
{

    /**
     * @var string
     */
    protected $value = '';

    /**
     * @inheritDoc
     */
    protected $fieldName = 'API Callback url';

    /**
     * @inheritDoc
     */
    protected $fieldId = 'apiCallbackUrl';

    /**
     * @inheritDoc
     */
    public function __construct($value = false)
    {
        if ($value === '') {
            $this->value = '';
        } elseif ($value != '') {
            if (filter_var($value, FILTER_VALIDATE_URL)) {
                $this->value = $value;
            } else {
                add_settings_error(
                    'fortytwo2fa',
                    esc_attr($this->fieldId),
                    'Wrong ' . $this->fieldName . ' format',
                    'error'
                );
            }
        } else {
            $options = get_option('fortytwo2fa');

            if (isset($options[$this->fieldId])) {
                $this->value = $options[$this->fieldId];
            }
        }
    }
}
