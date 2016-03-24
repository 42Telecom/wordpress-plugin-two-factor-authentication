<?php
namespace Fortytwo\Wordpress\Plugin\TwoFactorAuthentication\Utils;

/**
 * Small/Basic Template Engine for the plugin.
 */

class TemplateEngine
{

    const VIEWS_DIRECTORY = '/../Views/';

    /**
     * Render the given template with the given paramaters
     *
     * @param string    $template   name of the template
     * @param array     $params     List of parameters to insert in the template
     */
    public function render($template, $params = array())
    {
        $templateString = file_get_contents(__DIR__ . self::VIEWS_DIRECTORY . $template);

        foreach ($params as $key => $value) {
            $templateString = str_replace('{{' . $key . '}}', $value, $templateString);
        }

        return $templateString;
    }
}
