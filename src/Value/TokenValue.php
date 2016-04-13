<?php
namespace Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value;

use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Interfaces\ValueInterface;
use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value\AbstractValue;

/**
 * Class for the Token Value.
 *
 * @license https://opensource.org/licenses/MIT MIT
 */
class TokenValue extends AbstractValue implements ValueInterface
{
    /**
     * @var string
     */
    protected $value = '';

    /**
     * @inheritDoc
     */
    protected $fieldName = 'Token';

    /**
     * @inheritDoc
     */
    protected $fieldId = 'tokenNumber';

    /**
     * @var string
     */
    private $regex = "/^([a-z0-9]*-[a-z0-9]*-[a-z0-9]*-[a-z0-9]*-[a-z0-9]*)$/";


    /**
     * @inheritDoc
     */
    public function __construct($value = false)
    {
        if ($value) {
            if (preg_match($this->regex, $value)) {
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
