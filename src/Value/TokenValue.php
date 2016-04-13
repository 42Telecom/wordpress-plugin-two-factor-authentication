<?php
namespace Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Value;

use Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Interfaces\ValueInterface;

/**
 * Class for the Token Value.
 *
 * @license https://opensource.org/licenses/MIT MIT
 */
class TokenValue implements ValueInterface
{
    /**
     * @var string
     */
    private $token = '';
    /**
     * @var string
     */
    private $regex = "/^([a-z0-9]*-[a-z0-9]*-[a-z0-9]*-[a-z0-9]*-[a-z0-9]*)$/";
    /**
     * @var string
     */
    private $fieldName = 'tokenNumber';


    /**
     * @inheritDoc
     */
    public function __construct($value = false)
    {
        if ($value) {
            if (preg_match($this->regex, $value)) {
                $this->token = $value;
            } else {
                add_settings_error(
                    'fortytwo2fa',
                    esc_attr($this->fieldName),
                    'Wrong Token format',
                    'error'
                );
            }
        } else {
            $options = get_option('fortytwo2fa');

            if (isset($options[$this->fieldName])) {
                $this->token = $options[$this->fieldName];
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function __toString()
    {
        return $this->token;
    }
}
