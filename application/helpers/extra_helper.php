<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

if (! function_exists('current_date'))
{
    /**
     * Get current datetime
     *
     * @see https://www.php.net/manual/en/datetime.format.php
     *
     * @param string|null $format
     * @param string|null $timezone
     * @return string
     */
    function current_date($format = null, $timezone = null)
    {
        $format ??= 'Y-m-d H:i:s';
        $timezone ??= config_item('time_reference');

        if ($timezone === 'local' || $timezone === date_default_timezone_get()) {
            return date($format);
        }

        $dateTime = new \DateTime('now');
        $dateTime->setTimezone(new \DateTimeZone($timezone));

        return $dateTime->format($format);
    }
}

if (! function_exists('locate_date'))
{
    /**
     * Change a specific datetime in a localized pattern
     *
     * @see https://unicode-org.github.io/icu/userguide/format_parse/datetime
     *
     * @param string $date
     * @param string|null $pattern
     * @param string|null $timezone
     * @return string
     */
    function locate_date($date, $pattern = null, $timezone = null)
    {
        $pattern ??= lang('datetime_pattern');
        $timezone ??= config_item('time_reference');

        if (empty($date) || $date === '0000-00-00' || $date === '0000-00-00 00:00:00') {
            return '';
        }

        $CI =& get_instance();
        $CI->load->library('multilanguage');

        $dateTime  = new \DateTime($date);
        $formatter = new \IntlDateFormatter($CI->multilanguage->current_language('locale'), \IntlDateFormatter::MEDIUM, \IntlDateFormatter::SHORT, $timezone, \IntlDateFormatter::GREGORIAN);

        $formatter->setPattern($pattern);

        return $formatter->format($dateTime);
    }
}

if (! function_exists('add_timespan'))
{
    /**
     * Add timespan to a date
     *
     * @see https://www.php.net/manual/en/dateinterval.construct.php
     * to know the format used in interval
     *
     * @param string $date
     * @param string $interval
     * @param string|null $format
     * @param string|null $timezone
     * @return string
     */
    function add_timespan($date, $interval, $format = null, $timezone = null)
    {
        $format ??= 'Y-m-d H:i:s';
        $timezone ??= config_item('time_reference');

        $dateTime = new \DateTime($date);

        if (! in_array($timezone, ['local', date_default_timezone_get()])) {
            $dateTime->setTimezone(new \DateTimeZone($timezone));
        }

        $add = $dateTime->add(new \DateInterval($interval));

        return $add->format($format);
    }
}

if (! function_exists('remaining_minutes'))
{
    /**
     * Get remaining minutes when comparing two dates
     *
     * @param string $date
     * @param string $dateTwo
     * @param string|null $timezone
     * @param string|null $timezoneTwo
     * @return int
     */
    function remaining_minutes($date, $dateTwo, $timezone = null, $timezoneTwo = null)
    {
        $timezone ??= config_item('time_reference');
        $timezoneTwo ??= config_item('time_reference');

        $dateTime    = new \DateTime($date);
        $dateTimeTwo = new \DateTime($dateTwo);

        if (! in_array($timezone, ['local', date_default_timezone_get()])) {
            $dateTime->setTimezone(new \DateTimeZone($timezone));
        }

        if (! in_array($timezoneTwo, ['local', date_default_timezone_get()])) {
            $dateTimeTwo->setTimezone(new \DateTimeZone($timezoneTwo));
        }

        $diff = $dateTime->diff($dateTimeTwo);

        $minutes = (int) $diff->format('%r%a') * 24 * 60;
        $minutes += (int) $diff->format('%r%h') * 60;
        $minutes += (int) $diff->format('%r%i');

        return $minutes;
    }
}

if (! function_exists('curl_request'))
{
    /**
     * Simple curl request
     *
     * @param string $url
     * @param array $options
     * @return string
     */
    function curl_request($url, $options = [])
    {
        $opts = [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false
        ];

        $ch = curl_init();

        curl_setopt_array($ch, $opts + $options);

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }
}

if (! function_exists('split_data'))
{
    /**
     * Get a certain string type from the data
     *
     * @param string $data
     * @param string $type
     * @param int|null $key
     * @return mixed
     */
    function split_data($data, $type = 'not_digits', $key = null)
    {
        switch ($type) {
            case 'digits':
                $result = preg_split('/\D+/', (string) $data, 0, PREG_SPLIT_NO_EMPTY);
                break;

            case 'not_digits':
                $result = preg_split('/\d+/', (string) $data, 0, PREG_SPLIT_NO_EMPTY);
                break;
        }

        if (! isset($result) || empty($result)) {
            return [];
        }

        return $key === null ? $result : $result[$key];
    }
}

if (! function_exists('money_pieces'))
{
    /**
     * Determine the amount of copper/silver/gold pieces
     * there is from the total amount of money
     *
     * @param int|string $money
     * @param string $type
     * @return int
     */
    function money_pieces($money, $type = 'g')
    {
        $money  = (string) $money;
        $length = strlen($money);

        switch ($type) {
            case 'c':
            case 'copper':
                return $length >= 1 ? (int) substr($money, -2) : 0;

            case 's':
            case 'silver':
                return $length >= 3 ? (int) substr($money, -4, -2) : 0;

            case 'g':
            case 'gold':
                return $length >= 5 ? (int) substr($money, 0, -4) : 0;

            default:
                return 0;
        }
    }
}

if (! function_exists('ordinal'))
{
    /**
     * Set ordinal suffix
     *
     * @param int $value
     * @return string
     */
    function ordinal($value)
    {
        $CI =& get_instance();

        $CI->load->library('multilanguage');

        $locale = $CI->multilanguage->current_language('locale');

        $nf = new \NumberFormatter($locale, \NumberFormatter::ORDINAL);

        return $nf->format($value);
    }
}

if (! function_exists('encrypt'))
{
    /**
     * Encrypt data
     *
     * @param mixed $data
     * @return string
     */
    function encrypt($data)
    {
        if ($data === '' || $data === null) {
            return '';
        }

        $CI =& get_instance();

        $CI->load->library('encryption', [
            'driver' => 'openssl',
            'cipher' => 'aes-192',
            'mode'   => 'cbc',
            'key'    => hex2bin(config_item('encryption_key'))
        ]);

        return $CI->encryption->encrypt($data);
    }
}

if (! function_exists('decrypt'))
{
    /**
     * Decrypt data
     *
     * @param mixed $data
     * @return string
     */
    function decrypt($data)
    {
        if ($data === '' || $data === null) {
            return '';
        }

        $CI =& get_instance();

        $CI->load->library('encryption', [
            'driver' => 'openssl',
            'cipher' => 'aes-192',
            'mode'   => 'cbc',
            'key'    => hex2bin(config_item('encryption_key'))
        ]);

        return $CI->encryption->decrypt($data);
    }
}

if (! function_exists('client_pwd_hash'))
{
    /**
     * Generate a client password hash
     *
     * @param string $username
     * @param string $password
     * @param string $type
     * @param mixed $salt
     * @return mixed
     */
    function client_pwd_hash($username, $password, $type = null, $salt = null)
    {
        switch ($type) {
            case 'bnet':
                return strtoupper(bin2hex(strrev(hex2bin(strtoupper(hash('sha256', strtoupper(hash('sha256', strtoupper($username)) . ':' . strtoupper($password))))))));

            case 'hex':
                $client = new \Laizerox\Wowemu\SRP\UserClient($username, $salt);
                return strtoupper($client->generateVerifier($password));

            case 'srp6':
                // Initialize the base value for the public key
                $baseValue = gmp_init(7);

                // Initialize the modulus value using a hexadecimal string
                $modulus = gmp_init('894B645E89E1535BBDAD5B8B290650530801B18EBFBF5E8FAB3C82872A3E9BB7', 16);

                // Create a hash from the salt and the password
                // - Concatenate the username and password with a colon
                // - Convert the concatenated string to uppercase and hash it using SHA-1
                // - Concatenate the salt with the SHA-1 hash and hash again using SHA-1
                // - Import the result as a GMP number (integer)
                $passwordHash = sha1($salt . sha1(strtoupper($username . ':' . $password), true), true);
                $hashedPassword = gmp_import($passwordHash, 1, GMP_LSW_FIRST);

                // Compute the password verifier
                // - Compute g^h mod N (baseValue^hashedPassword mod modulus)
                // - Export the result as a binary string
                // - Pad the result to ensure it is 32 bytes long
                $verifierBinary = gmp_powm($baseValue, $hashedPassword, $modulus);
                $verifierBinaryString = gmp_export($verifierBinary, 1, GMP_LSW_FIRST);
                $verifier = str_pad($verifierBinaryString, 32, chr(0), STR_PAD_RIGHT);

                // Return the padded password verifier
                return $verifier;
            case 'srpV1':
                // Initialize the base value (g) for the SRP public key calculation
                $baseValue = gmp_init(2);

                // Initialize the modulus (N) using a hexadecimal string
                $modulus = gmp_init('86A7F6DEEB306CE519770FE37D556F29944132554DED0BD68205E27F3231FEF5A10108238A3150C59CAF7B0B6478691C13A6ACF5E1B5ADAFD4A943D4A21A142B800E8A55F8BFBAC700EB77A7235EE5A609E350EA9FC19F10D921C2FA832E4461B7125D38D254A0BE873DFC27858ACB3F8B9F258461E4373BC3A6C2A9634324AB', 16);

                // Compute the intermediate hash value for the password key
                // - Hash the username using SHA-256, concatenate with ':' and the first 16 bytes of the password
                // - Hash the result again using SHA-256, concatenate with salt, and hash once more using SHA-256
                $intermediateHash = hash('sha256', strtoupper($username) . ':' . substr($password, 0, 16), true);
                $saltedHash = hash('sha256', $salt . $intermediateHash, true);
                $hashedPasswordKey = gmp_import($saltedHash, 1, GMP_LSW_FIRST);

                // Calculate the password verifier
                // - Compute baseValue^hashedPasswordKey mod modulus
                // - Export the result as a binary string
                // - Pad the result to ensure it is 128 bytes long (little-endian)
                $verifierBinary = gmp_powm($baseValue, $hashedPasswordKey, $modulus);
                $verifierBinaryString = gmp_export($verifierBinary, 1, GMP_LSW_FIRST);
                $verifier = str_pad($verifierBinaryString, 128, chr(0), STR_PAD_RIGHT);

                return $verifier;
            case 'srpV2':
                // Constants used in the SRP algorithm
                $generator = gmp_init(2); // Base value for SRP
                $primeModulus = gmp_init('AC6BDB41324A9A9BF166DE5E1389582FAF72B6651987EE07FC3192943DB56050A37329CBB4A099ED8193E0757767A13DD52312AB4B03310DCD7F48A9DA04FD50E8083969EDB767B0CF6095179A163AB3661A05FBD5FAAAE82918A9962F0B93B855F97993EC975EEAA80D740ADBF4FF747359D041D5C33EA71D281E446B14773BCA97B43A23FB801676BD207A436C6481F1D2B9078717461A5B9D32E688F87748544523B524B0D57D5EA77A2775D2ECFA032CFBDBF52FB3786160279004E57AE6AF874E7303CE53299CCC041C7BC308D82A5698F3A8D0C38271AE35F8E9DBFBB694B5C803D89F7AE435DE236D525F54759B65E372FCD68EF20FA7111F9E4AFF73', 16);

                // Create the string for hashing by combining username and password
                $usernameHash = strtoupper(hash('sha256', strtoupper($username), true));
                $combinedString = $usernameHash . ":" . $password;

                // Parameters for PBKDF2 key derivation
                $pbkdf2Iterations = 15000;
                $derivedKey = hash_pbkdf2("sha512", $combinedString, $salt, $pbkdf2Iterations, 64, true);

                // Convert the derived key to a GMP integer
                $derivedKeyInteger = gmp_import($derivedKey, 1, GMP_MSW_FIRST);

                // Check if the first byte of the derived key indicates a negative value
                $firstByte = $derivedKey[0];
                if (ord($firstByte) & 0x80) {
                    $adjustmentFactor = gmp_init('100000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000', 16);
                    $derivedKeyInteger = gmp_sub($derivedKeyInteger, $adjustmentFactor);
                }

                // Ensure the derived key is within the valid range
                $modulusAdjusted = gmp_sub($primeModulus, gmp_init(1));
                $derivedKeyInteger = gmp_mod($derivedKeyInteger, $modulusAdjusted);

                // Compute the SRP verifier
                $verifierRaw = gmp_powm($generator, $derivedKeyInteger, $primeModulus);
                $verifierBinary = gmp_export($verifierRaw, 1, GMP_LSW_FIRST);

                // Pad the verifier to a fixed length of 256 bytes, ensuring little-endian format
                $verifier = str_pad($verifierBinary, 256, chr(0), STR_PAD_RIGHT);

                return $verifier;
            default:
                return strtoupper(sha1(strtoupper($username) . ':' . strtoupper($password)));
        }
    }
}

if (! function_exists('purify'))
{
    /**
     * Purify a content using the HTMLPurifier
     *
     * @param string $content
     * @param string|null $type
     * @return string
     */
    function purify($content, $type = null)
    {
        switch ($type) {
            case 'article':
                $elements = [
                    'HTML.Allowed'          => 'a[href|title],b,br,em,h1[style],h2[style],h3[style],h4[style],h5[style],h6[style],i,iframe[width|height|src],img[width|height|alt|src],li,ol[style],p[style],s,span[style],strong,sub,sup,table[border|style],tbody,td[style],th[style],thead,tr,ul[style]',
                    'HTML.SafeIframe'       => true,
                    'URI.SafeIframeRegexp'  => '%^https://(www\.youtube\.com\/embed\/|www\.dailymotion\.com\/embed\/|player\.twitch\.tv\/)%',
                    'CSS.AllowedProperties' => 'color,border,border-color,border-collapse,border-spacing,border-width,font,font-family,font-size,font-style,height,list-style-type,margin,margin-left,margin-right,max-height,max-width,min-height,min-width,padding,text-align,text-decoration,width',
                ];
                break;

            case 'comment':
                $elements = [
                    'HTML.Allowed'          => 'a[href|title],b,br,em,i,li,ol[style],p[style],s,span[style],strong,sub,sup,ul[style]',
                    'CSS.AllowedProperties' => 'height,list-style-type,max-height,max-width,min-height,min-width,text-align,text-decoration,width',
                ];
                break;

            default:
                $elements = [];
                break;
        }

        $config = \HTMLPurifier_HTML5Config::create(array_merge([
            'Core.Encoding'            => 'utf-8',
            'AutoFormat.AutoParagraph' => false,
            'AutoFormat.RemoveEmpty'   => false
        ], $elements));

        $content = str_replace(['\r\n', '\n\r', '\n', '\r'], '<br>', (string) $content);

        return (new \HTMLPurifier())->purify($content, $config);
    }
}

if (! function_exists('is_json'))
{
    /**
     * Check if the string is in a valid JSON format
     *
     * @param string $str
     * @return bool
     */
    function is_json($str)
    {
        try {
            json_decode($str, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            return false;
        }

        return true;
    }
}

if (! function_exists('hide_email'))
{
    /**
     * Partially hide an email address
     *
     * @param string $email
     * @return string
     */
    function hide_email($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            return '';
        }

        [$name, $domain] = explode('@', $email);

        $lenght = floor(strlen($name) / 2);

        return substr($name, 0, $lenght) . str_repeat('*', $lenght) . '@' . $domain;
    }
}

if (! function_exists('is_route_active'))
{
    /**
     * Check if a URL/Route is the same route as the current page
     *
     * @param string $url
     * @param bool $strict
     * @return bool
     */
    function is_route_active($url, $strict = true)
    {
        $CI =& get_instance();

        if (filter_var($url, FILTER_VALIDATE_URL) !== false) {
            $baseHost = parse_url(site_url(), PHP_URL_HOST);
            $urlHost  = parse_url($url, PHP_URL_HOST);
            $urlPath  = ltrim(parse_url($url, PHP_URL_PATH), '/');

            if ($baseHost !== $urlHost) {
                return false;
            }

            if ($strict) {
                return $urlPath === $CI->uri->uri_string();
            }

            return stripos($urlPath, $CI->uri->uri_string()) !== false;
        }

        if ($strict) {
            return $url === $CI->uri->uri_string();
        }

        return stripos($url, $CI->uri->uri_string()) !== false;
    }
}

if (! function_exists('captcha_widget'))
{
    /**
     * Render captcha widget HTML
     *
     * @return string
     */
    function captcha_widget()
    {
        $sitekey = config_item('captcha_sitekey');
        $type    = config_item('captcha_type');

        switch ($type) {
            case 'recaptcha':
                $class = 'g-recaptcha';
                break;

            case 'turnstile':
                $class = 'cf-turnstile';
                break;

            default:
                $class = 'h-captcha';
                break;
        }

        $div = '<div class="' . $class . '" data-sitekey="'. $sitekey .'"';

        if (in_array($type, ['hcaptcha', 'recaptcha'], true) && config_item('captcha_size') === 'compact') {
            $div .= ' data-size="compact"';
        }

        if (config_item('captcha_theme') === 'dark') {
            $div .= ' data-theme="dark"';
        }

        $div .= '></div>';

        return $div;
    }
}
