<?php
namespace AppBundle\Utils;


use AppBundle\Exception\ExternalFileNotFoundException;

class Utils
{

    public function loadPicture( $picture, $type, $user = null)
    {

        if($user == null) {
                $type_name = 'packet';
            $destinyPath = __DIR__ . '/../../../web/uploads/images/' . $type_name . '/';
        }
        else
            $destinyPath = __DIR__.'/../../../web/uploads/images/'.$type.'/'.$user.'/';
//        if(!is_dir($path)){
//            throw new ExternalFileNotFoundException(sprintf('Destination directory "%s" not found', $path));
//        }

        if (null === $picture) {
            throw new ExternalFileNotFoundException(sprintf('Picture is empty'));
        }
//        $destinyPath = __DIR__.$path;
        $namePicture = uniqid($type.'-').'.jpg';
        $picture->move($destinyPath, $namePicture);
        return $namePicture;
    }
    /**
     * @param            $value
     * @param int        $length
     * @param bool|false $preserve
     * @param string     $separator
     *
     * @return string
     */
    function truncate($value, $length = 30, $preserve = false, $separator = '...')
    {
        if (strlen($value) > $length) {
            if ($preserve) {
                if (false !== ( $breakpoint = strpos($value, ' ', $length) )) {
                    $length = $breakpoint;
                }
            }

            return rtrim(substr($value, 0, $length)).$separator;
        }

        return $value;
    }

    /**
     * @param        $cadena
     * @param string $separador
     *
     * @return mixed|string
     */
    function get_slug($cadena, $separador = '-')
    {
        // Código copiado de http://cubiq.org/the-perfect-php-clean-url-generator
        $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $cadena);
        $slug = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $slug);
        $slug = strtolower(trim($slug, $separador));
        $slug = preg_replace("/[\/_|+ -]+/", $separador, $slug);

        return $slug;
    }

    /**
     * @param $haystack
     * @param $needle
     *
     * @return bool
     */
    public function in_str($haystack, $needle)
    {
        return strpos($haystack, $needle) !== false;
    }

    /**
     * @param        $text
     * @param int    $length
     * @param string $separator
     *
     * @return mixed
     */
    public function truncate_and_replace($text, $length = 20, $separator = "...")
    {
        if (strlen($text) < $length) {
            return $text;
        }
        $separatorlength = strlen($separator);
        $maxlength       = $length - $separatorlength;
        $start           = $maxlength / 2;
        $trunc           = strlen($text) - $maxlength;

        return substr_replace($text, $separator, $start, $trunc);
    }

    /**
     * @param array  $collection
     * @param string $field
     * @param string $prefix
     *
     * @return array
     */
    public function extractField($collection, $field, $prefix = '')
    {
        $result = array();
        if ( ! empty( $collection )) {
            foreach ($collection as $element) {
                if (is_array($element) && array_key_exists($field, $element)) {
                    $result[] = (int) $prefix.$element[ $field ];
                    continue;
                }
                if (is_object($element)) {
                    $method = 'get'.ucfirst($field);
                    if (method_exists($element, $method)) {
                        $result[] = (int) $prefix.$element->$method;
                        continue;
                    }
                }
            }
        }

        return $result;
    }

    public function getTimestamp($format = "Y-m-d H:i:s e")
    {
        $date = new \DateTime();

        return $date->format($format);
    }

    public function validUrl($value)
    {
        $protocols = array('http', 'https');
        $patterns = '~^
            (%s)://                                 # protocol
            (([\pL\pN-]+:)?([\pL\pN-]+)@)?          # basic auth
            (
                ([\pL\pN\pS-\.])+(\.?([\pL]|xn\-\-[\pL\pN-]+)+\.?) # a domain name
                    |                                              # or
                \d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}                 # a IP address
                    |                                              # or
                \[
                    (?:(?:(?:(?:(?:(?:(?:[0-9a-f]{1,4})):){6})(?:(?:(?:(?:(?:[0-9a-f]{1,4})):(?:(?:[0-9a-f]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:::(?:(?:(?:[0-9a-f]{1,4})):){5})(?:(?:(?:(?:(?:[0-9a-f]{1,4})):(?:(?:[0-9a-f]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:(?:(?:(?:[0-9a-f]{1,4})))?::(?:(?:(?:[0-9a-f]{1,4})):){4})(?:(?:(?:(?:(?:[0-9a-f]{1,4})):(?:(?:[0-9a-f]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:(?:(?:(?:(?:[0-9a-f]{1,4})):){0,1}(?:(?:[0-9a-f]{1,4})))?::(?:(?:(?:[0-9a-f]{1,4})):){3})(?:(?:(?:(?:(?:[0-9a-f]{1,4})):(?:(?:[0-9a-f]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:(?:(?:(?:(?:[0-9a-f]{1,4})):){0,2}(?:(?:[0-9a-f]{1,4})))?::(?:(?:(?:[0-9a-f]{1,4})):){2})(?:(?:(?:(?:(?:[0-9a-f]{1,4})):(?:(?:[0-9a-f]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:(?:(?:(?:(?:[0-9a-f]{1,4})):){0,3}(?:(?:[0-9a-f]{1,4})))?::(?:(?:[0-9a-f]{1,4})):)(?:(?:(?:(?:(?:[0-9a-f]{1,4})):(?:(?:[0-9a-f]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:(?:(?:(?:(?:[0-9a-f]{1,4})):){0,4}(?:(?:[0-9a-f]{1,4})))?::)(?:(?:(?:(?:(?:[0-9a-f]{1,4})):(?:(?:[0-9a-f]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:(?:(?:(?:(?:[0-9a-f]{1,4})):){0,5}(?:(?:[0-9a-f]{1,4})))?::)(?:(?:[0-9a-f]{1,4})))|(?:(?:(?:(?:(?:(?:[0-9a-f]{1,4})):){0,6}(?:(?:[0-9a-f]{1,4})))?::))))
                \]  # a IPv6 address
            )
            (:[0-9]+)?                              # a port (optional)
            (/?|/\S+)                               # a /, nothing or a / with something
        $~ixu';

        if (empty($value)) {
            return false;
        }

        $pattern = sprintf($patterns, implode('|', $protocols));
        if ( !preg_match($pattern, $value)) {
            return false;
        }

        $host = parse_url($value, PHP_URL_HOST);
        if (!checkdnsrr($host, 'ANY')) {
            return false;
        }

        return true;
    }
}