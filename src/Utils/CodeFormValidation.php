<?php
namespace Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Utils;

/**
 * Validate and prepare value for the SMS code form.
 */
class CodeFormValidation
{
    private $wpAuthId = array(
        'value'     => '',
        'name'      => 'wp-auth-id',
        'id'        => 'wp-auth-id',
        'type'      => 'hidden',
        'required'  => true
    );

    private $wpAuthNonce = array(
        'value'     => '',
        'name'      => 'wp-auth-nonce',
        'id'        => 'wp-auth-nonce',
        'type'      => 'hidden',
        'required'  => true
    );

    private $fortytwoClientRef = array(
        'value'     => '',
        'name'      => 'fortytwo-client-ref',
        'id'        => 'fortytwo-client-ref',
        'type'      => 'hidden',
        'required'  => false
    );

    private $interimLogin = array(
        'value'     => '',
        'name'      => 'interim-login',
        'id'        => 'interim-login',
        'type'      => 'hidden',
        'required'  => false
    );

    private $redirectTo = array(
        'value'     => '',
        'name'      => 'redirect_to',
        'id'        => 'redirect_to',
        'type'      => 'hidden',
        'required'  => false
    );

    private $rememberMe = array(
        'value'     => '',
        'name'      => 'rememberme',
        'id'        => 'rememberme',
        'type'      => 'hidden',
        'required'  => false
    );

    private $code = array(
        'value'     => '',
        'name'      => 'code',
        'id'        => 'code',
        'type'      => 'text',
        'required'  => true
    );

    private $trustedDevice = array(
        'value'     => '',
        'name'      => 'trusted-device',
        'id'        => 'trusted-device',
        'type'      => 'checkbox',
        'required'  => false
    );

    /**
     * Return the list of fields
     *
     * @return array List of fields
     */
    private function getFields()
    {
        $fields[$this->wpAuthId['name']] = $this->wpAuthId;
        $fields[$this->wpAuthNonce['name']] = $this->wpAuthNonce;
        $fields[$this->fortytwoClientRef['name']] = $this->fortytwoClientRef;
        $fields[$this->interimLogin['name']] = $this->interimLogin;
        $fields[$this->redirectTo['name']] = $this->redirectTo;
        $fields[$this->rememberMe['name']] = $this->rememberMe;
        $fields[$this->code['name']] = $this->code;
        $fields[$this->trustedDevice['name']] = $this->trustedDevice;

        return $fields;
    }

    /**
     * Simple validation form [can be used to do more advanced validation]
     *
     * @param array $request POST request
     * @param mixed false if not validated or the request if validation is ok
     */
    public function validate($request)
    {
        $fieldsValidation = $this->getFields();

        foreach ($fieldsValidation as $fieldName => $field) {
            if (isset($request[$fieldName])) {
                if (($field['required']) && ($field['required'] == '')) {
                    return false;
                }
            } else {
                if ($field['required']) {
                    return false;
                }
            }
        }
        return $request;
    }
}
