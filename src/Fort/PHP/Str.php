<?php


namespace Fort\PHP;
use JsonException;

class Str
{

    /**
     * Determine if the provided needle exist in the haystack in case insensitive manner
     * @param array $haystack [required] <p>
     * @return bool returns true if the needle exit, false otherwise

     */
    public static function valueExist(array $haystack, mixed $needle): bool
    {
        $trans = $haystack;
        $realString = strtr($needle,$trans);
        foreach($haystack as $val){
            $realVal = strtr($val,$trans);
            if(strcasecmp( $realVal, $realString ) == 0){
                return true;
            }

        }
        return false;
    }

    /**
     * Return the remainder of a string after the first occurrence of a given value.
     *
     * @param  string  $subject
     * @param  string  $search
     * @return string
     */
    public static function after( string $subject, string $search):string
    {
        return $search === '' ? $subject : array_reverse(explode($search, $subject, 2))[0];
    }

    /**
     * Return the remainder of a string after the last occurrence of a given value.
     *
     * @param  string  $subject
     * @param  string  $search
     * @return string
     */
    public static function afterLast( string $subject,  string $search):string
    {
        if ($search === '') {
            return $subject;
        }

        $position = strrpos($subject, (string) $search);

        if ($position === false) {
            return $subject;
        }

        return substr($subject, $position + strlen($search));
    }




    /**
     * Get the portion of a string before the first occurrence of a given value.
     *
     * @param  string  $subject
     * @param  string  $search
     * @return string
     */
    public static function before( string $subject, string $search):string
    {
        if ($search === '') {
            return $subject;
        }

        $result = strstr($subject, (string) $search, true);

        return $result === false ? $subject : $result;
    }

    /**
     * Get the portion of a string before the last occurrence of a given value.
     *
     * @param  string  $subject
     * @param  string  $search
     * @return string
     */
    public static function beforeLast(string $subject, string $search):string
    {
        if ($search === '') {
            return $subject;
        }

        $pos = mb_strrpos($subject, $search);

        if ($pos === false) {
            return $subject;
        }

        return static::substr($subject, 0, $pos);
    }

    /**
     * Get the portion of a string between two given values.
     *
     * @param  string  $subject
     * @param  string  $from
     * @param  string  $to
     * @return string
     */
    public static function between( string$subject, string $from,  string $to):string
    {
        if ($from === '' || $to === '') {
            return $subject;
        }

        return static::beforeLast(static::after($subject, $from), $to);
    }

    /**
     * Get the smallest possible portion of a string between two given values.
     *
     * @param  string  $subject
     * @param  string  $from
     * @param  string  $to
     * @return string
     */
    public static function betweenFirst(string $subject, string $from, string $to):string
    {
        if ($from === '' || $to === '') {
            return $subject;
        }

        return static::before(static::after($subject, $from), $to);
    }



    /**
     * Get the character at the specified index.
     *
     * @param  string  $subject
     * @param  int  $index
     * @return string|false
     */
    public static function charAt(string $subject, int $index):string|false
    {
        $length = mb_strlen($subject);

        if ($index < 0 ? $index < -$length : $index > $length - 1) {
            return false;
        }

        return mb_substr($subject, $index, 1);
    }

    /**
     * Determine if a given string contains a given substring.
     *
     * @param  string  $string
     * @param  string|iterable<string>  $needles
     * @param  bool  $ignoreCase
     * @return bool
     */
    public static function contains( string $string,  string|iterable $needles, $ignoreCase = false):bool
    {
        if ($ignoreCase) {
            $string = mb_strtolower($string);
        }

        if (! is_iterable($needles)) {
            $needles = (array) $needles;
        }

        foreach ($needles as $needle) {
            if ($ignoreCase) {
                $needle = mb_strtolower($needle);
            }

            if ($needle !== '' && str_contains($string, $needle)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine if a given string contains all array values.
     *
     * @param  string  $haystack
     * @param  iterable<string>  $needles
     * @param  bool  $ignoreCase
     * @return bool
     */
    public static function containsAll($haystack, string|iterable $needles, $ignoreCase = false):bool
    {
        foreach ($needles as $needle) {
            if (! static::contains($haystack, $needle, $ignoreCase)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Convert the case of a string.
     *
     * @param  string  $string
     * @param  int  $mode
     * @param  string  $encoding
     * @return string
     */
    public static function convertCase(string $string, int $mode = MB_CASE_FOLD, ?string $encoding = 'UTF-8')
    {
        return mb_convert_case($string, $mode, $encoding);
    }

    /**
     * Determine if a given string ends with a given substring.
     *
     * @param  string  $haystack
     * @param  string|iterable<string>  $needles
     * @return bool
     */
    public static function endsWith($haystack, $needles)
    {
        if (! is_iterable($needles)) {
            $needles = (array) $needles;
        }

        foreach ($needles as $needle) {
            if ((string) $needle !== '' && str_ends_with($haystack, $needle)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Extracts an excerpt from text that matches the first instance of a phrase.
     *
     * @param  string  $text
     * @param  string  $phrase
     * @param  array  $options
     * @return string|null
     */
    public static function excerpt($text, $phrase = '', $options = [])
    {
        $radius = $options['radius'] ?? 100;
        $omission = $options['omission'] ?? '...';

        preg_match('/^(.*?)('.preg_quote((string) $phrase).')(.*)$/iu', (string) $text, $matches);

        if (empty($matches)) {
            return null;
        }

        $start = ltrim($matches[1]);

        $start = str(mb_substr($start, max(mb_strlen($start, 'UTF-8') - $radius, 0), $radius, 'UTF-8'))->ltrim()->unless(
            fn ($startWithRadius) => $startWithRadius->exactly($start),
            fn ($startWithRadius) => $startWithRadius->prepend($omission),
        );

        $end = rtrim($matches[3]);

        $end = str(mb_substr($end, 0, $radius, 'UTF-8'))->rtrim()->unless(
            fn ($endWithRadius) => $endWithRadius->exactly($end),
            fn ($endWithRadius) => $endWithRadius->append($omission),
        );

        return $start->append($matches[2], $end)->toString();
    }

    /**
     * Cap a string with a single instance of a given value.
     *
     * @param  string  $value
     * @param  string  $cap
     * @return string
     */
    public static function finish($value, $cap)
    {
        $quoted = preg_quote($cap, '/');

        return preg_replace('/(?:'.$quoted.')+$/u', '', $value).$cap;
    }

    /**
     * Wrap the string with the given strings.
     *
     * @param  string  $value
     * @param  string  $before
     * @param  string|null  $after
     * @return string
     */
    public static function wrap($value, $before, $after = null)
    {
        return $before.$value.($after ??= $before);
    }

    /**
     * Determine if a given string matches a given pattern.
     *
     * @param  string|iterable<string>  $pattern
     * @param  string  $value
     * @return bool
     */
    public static function is($pattern, $value)
    {
        $value = (string) $value;

        if (! is_iterable($pattern)) {
            $pattern = [$pattern];
        }

        foreach ($pattern as $pattern) {
            $pattern = (string) $pattern;

            // If the given value is an exact match we can of course return true right
            // from the beginning. Otherwise, we will translate asterisks and do an
            // actual pattern match against the two strings to see if they match.
            if ($pattern === $value) {
                return true;
            }

            $pattern = preg_quote($pattern, '#');

            // Asterisks are translated into zero-or-more regular expression wildcards
            // to make it convenient to check if the strings starts with the given
            // pattern such as "library/*", making any string check convenient.
            $pattern = str_replace('\*', '.*', $pattern);

            if (preg_match('#^'.$pattern.'\z#u', $value) === 1) {
                return true;
            }
        }

        return false;
    }



    /**
     * Determine if a given value is valid JSON.
     *
     * @param  mixed  $value
     * @return bool
     */
    public static function isJson($value)
    {
        if (! is_string($value)) {
            return false;
        }

        if (function_exists('json_validate')) {
            return json_validate($value, 512);
        }

        try {
            json_decode($value, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException) {
            return false;
        }

        return true;
    }

    /**
     * Determine if a given value is a valid URL.
     *
     * @param  mixed  $value
     * @param  array  $protocols
     * @return bool
     */
    public static function isUrl($value, array $protocols = [])
    {
        if (! is_string($value)) {
            return false;
        }

        $protocolList = empty($protocols)
            ? 'aaa|aaas|about|acap|acct|acd|acr|adiumxtra|adt|afp|afs|aim|amss|android|appdata|apt|ark|attachment|aw|barion|beshare|bitcoin|bitcoincash|blob|bolo|browserext|calculator|callto|cap|cast|casts|chrome|chrome-extension|cid|coap|coap\+tcp|coap\+ws|coaps|coaps\+tcp|coaps\+ws|com-eventbrite-attendee|content|conti|crid|cvs|dab|data|dav|diaspora|dict|did|dis|dlna-playcontainer|dlna-playsingle|dns|dntp|dpp|drm|drop|dtn|dvb|ed2k|elsi|example|facetime|fax|feed|feedready|file|filesystem|finger|first-run-pen-experience|fish|fm|ftp|fuchsia-pkg|geo|gg|git|gizmoproject|go|gopher|graph|gtalk|h323|ham|hcap|hcp|http|https|hxxp|hxxps|hydrazone|iax|icap|icon|im|imap|info|iotdisco|ipn|ipp|ipps|irc|irc6|ircs|iris|iris\.beep|iris\.lwz|iris\.xpc|iris\.xpcs|isostore|itms|jabber|jar|jms|keyparc|lastfm|ldap|ldaps|leaptofrogans|lorawan|lvlt|magnet|mailserver|mailto|maps|market|message|mid|mms|modem|mongodb|moz|ms-access|ms-browser-extension|ms-calculator|ms-drive-to|ms-enrollment|ms-excel|ms-eyecontrolspeech|ms-gamebarservices|ms-gamingoverlay|ms-getoffice|ms-help|ms-infopath|ms-inputapp|ms-lockscreencomponent-config|ms-media-stream-id|ms-mixedrealitycapture|ms-mobileplans|ms-officeapp|ms-people|ms-project|ms-powerpoint|ms-publisher|ms-restoretabcompanion|ms-screenclip|ms-screensketch|ms-search|ms-search-repair|ms-secondary-screen-controller|ms-secondary-screen-setup|ms-settings|ms-settings-airplanemode|ms-settings-bluetooth|ms-settings-camera|ms-settings-cellular|ms-settings-cloudstorage|ms-settings-connectabledevices|ms-settings-displays-topology|ms-settings-emailandaccounts|ms-settings-language|ms-settings-location|ms-settings-lock|ms-settings-nfctransactions|ms-settings-notifications|ms-settings-power|ms-settings-privacy|ms-settings-proximity|ms-settings-screenrotation|ms-settings-wifi|ms-settings-workplace|ms-spd|ms-sttoverlay|ms-transit-to|ms-useractivityset|ms-virtualtouchpad|ms-visio|ms-walk-to|ms-whiteboard|ms-whiteboard-cmd|ms-word|msnim|msrp|msrps|mss|mtqp|mumble|mupdate|mvn|news|nfs|ni|nih|nntp|notes|ocf|oid|onenote|onenote-cmd|opaquelocktoken|openpgp4fpr|pack|palm|paparazzi|payto|pkcs11|platform|pop|pres|prospero|proxy|pwid|psyc|pttp|qb|query|redis|rediss|reload|res|resource|rmi|rsync|rtmfp|rtmp|rtsp|rtsps|rtspu|s3|secondlife|service|session|sftp|sgn|shttp|sieve|simpleledger|sip|sips|skype|smb|sms|smtp|snews|snmp|soap\.beep|soap\.beeps|soldat|spiffe|spotify|ssh|steam|stun|stuns|submit|svn|tag|teamspeak|tel|teliaeid|telnet|tftp|tg|things|thismessage|tip|tn3270|tool|ts3server|turn|turns|tv|udp|unreal|urn|ut2004|v-event|vemmi|ventrilo|videotex|vnc|view-source|wais|webcal|wpid|ws|wss|wtai|wyciwyg|xcon|xcon-userid|xfire|xmlrpc\.beep|xmlrpc\.beeps|xmpp|xri|ymsgr|z39\.50|z39\.50r|z39\.50s'
            : implode('|', $protocols);

        /*
         * This pattern is derived from Symfony\Component\Validator\Constraints\UrlValidator (5.0.7).
         *
         * (c) Fabien Potencier <fabien@symfony.com> http://symfony.com
         */
        $pattern = '~^
            (LARAVEL_PROTOCOLS)://                                 # protocol
            (((?:[\_\.\pL\pN-]|%[0-9A-Fa-f]{2})+:)?((?:[\_\.\pL\pN-]|%[0-9A-Fa-f]{2})+)@)?  # basic auth
            (
                ([\pL\pN\pS\-\_\.])+(\.?([\pL\pN]|xn\-\-[\pL\pN-]+)+\.?) # a domain name
                    |                                                 # or
                \d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}                    # an IP address
                    |                                                 # or
                \[
                    (?:(?:(?:(?:(?:(?:(?:[0-9a-f]{1,4})):){6})(?:(?:(?:(?:(?:[0-9a-f]{1,4})):(?:(?:[0-9a-f]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:::(?:(?:(?:[0-9a-f]{1,4})):){5})(?:(?:(?:(?:(?:[0-9a-f]{1,4})):(?:(?:[0-9a-f]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:(?:(?:(?:[0-9a-f]{1,4})))?::(?:(?:(?:[0-9a-f]{1,4})):){4})(?:(?:(?:(?:(?:[0-9a-f]{1,4})):(?:(?:[0-9a-f]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:(?:(?:(?:(?:[0-9a-f]{1,4})):){0,1}(?:(?:[0-9a-f]{1,4})))?::(?:(?:(?:[0-9a-f]{1,4})):){3})(?:(?:(?:(?:(?:[0-9a-f]{1,4})):(?:(?:[0-9a-f]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:(?:(?:(?:(?:[0-9a-f]{1,4})):){0,2}(?:(?:[0-9a-f]{1,4})))?::(?:(?:(?:[0-9a-f]{1,4})):){2})(?:(?:(?:(?:(?:[0-9a-f]{1,4})):(?:(?:[0-9a-f]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:(?:(?:(?:(?:[0-9a-f]{1,4})):){0,3}(?:(?:[0-9a-f]{1,4})))?::(?:(?:[0-9a-f]{1,4})):)(?:(?:(?:(?:(?:[0-9a-f]{1,4})):(?:(?:[0-9a-f]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:(?:(?:(?:(?:[0-9a-f]{1,4})):){0,4}(?:(?:[0-9a-f]{1,4})))?::)(?:(?:(?:(?:(?:[0-9a-f]{1,4})):(?:(?:[0-9a-f]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:(?:(?:(?:(?:[0-9a-f]{1,4})):){0,5}(?:(?:[0-9a-f]{1,4})))?::)(?:(?:[0-9a-f]{1,4})))|(?:(?:(?:(?:(?:(?:[0-9a-f]{1,4})):){0,6}(?:(?:[0-9a-f]{1,4})))?::))))
                \]  # an IPv6 address
            )
            (:[0-9]+)?                              # a port (optional)
            (?:/ (?:[\pL\pN\-._\~!$&\'()*+,;=:@]|%[0-9A-Fa-f]{2})* )*          # a path
            (?:\? (?:[\pL\pN\-._\~!$&\'\[\]()*+,;=:@/?]|%[0-9A-Fa-f]{2})* )?   # a query (optional)
            (?:\# (?:[\pL\pN\-._\~!$&\'()*+,;=:@/?]|%[0-9A-Fa-f]{2})* )?       # a fragment (optional)
        $~ixu';

        return preg_match(str_replace('LARAVEL_PROTOCOLS', $protocolList, $pattern), $value) > 0;
    }

    /**
     * Determine if a given value is a valid UUID.
     *
     * @param  mixed  $value
     * @return bool
     */
    public static function isUuid($value)
    {
        if (! is_string($value)) {
            return false;
        }

        return preg_match('/^[\da-f]{8}-[\da-f]{4}-[\da-f]{4}-[\da-f]{4}-[\da-f]{12}$/iD', $value) > 0;
    }





    /**
     * Return the length of the given string.
     *
     * @param  string  $value
     * @param  string|null  $encoding
     * @return int
     */
    public static function length($value, $encoding = null)
    {
        return mb_strlen($value, $encoding);
    }

    /**
     * Limit the number of characters in a string.
     *
     * @param  string  $value
     * @param  int  $limit
     * @param  string  $end
     * @return string
     */

    public static function limit($string, $limit = 100, $end = '...')
    {
        if (mb_strwidth($string, 'UTF-8') <= $limit) {
            return $string;
        }

        return rtrim(mb_strimwidth($string, 0, $limit, '', 'UTF-8')) . $end;
    }


    /**
     * Convert the given string to lower-case.
     *
     * @param  string  $value
     * @return string
     */
    public static function lower($value)
    {
        return mb_strtolower($value, 'UTF-8');
    }

    /**
     * Limit the number of words in a string.
     *
     * @param  string  $value
     * @param  int  $words
     * @param  string  $end
     * @return string
     */
    public static function words($value, $words = 100, $end = '...')
    {
        preg_match('/^\s*+(?:\S++\s*+){1,'.$words.'}/u', $value, $matches);

        if (! isset($matches[0]) || static::length($value) === static::length($matches[0])) {
            return $value;
        }

        return rtrim($matches[0]).$end;
    }




    /**
     * Masks a portion of a string with a repeated character.
     *
     * @param  string  $string
     * @param  string  $character
     * @param  int  $index
     * @param  int|null  $length
     * @param  string  $encoding
     * @return string
     */
    public static function mask($string, $character, $index, $length = null, $encoding = 'UTF-8')
    {
        if ($character === '') {
            return $string;
        }

        $segment = mb_substr($string, $index, $length, $encoding);

        if ($segment === '') {
            return $string;
        }

        $strlen = mb_strlen($string, $encoding);
        $startIndex = $index;

        if ($index < 0) {
            $startIndex = $index < -$strlen ? 0 : $strlen + $index;
        }

        $start = mb_substr($string, 0, $startIndex, $encoding);
        $segmentLen = mb_strlen($segment, $encoding);
        $end = mb_substr($string, $startIndex + $segmentLen);

        return $start.str_repeat(mb_substr($character, 0, 1, $encoding), $segmentLen).$end;
    }

    /**
     * Get the string matching the given pattern.
     *
     * @param  string  $pattern
     * @param  string  $subject
     * @return string
     */
    public static function match($pattern, $subject)
    {
        preg_match($pattern, $subject, $matches);

        if (! $matches) {
            return '';
        }

        return $matches[1] ?? $matches[0];
    }

    /**
     * Determine if a given string matches a given pattern.
     *
     * @param  string|iterable<string>  $pattern
     * @param  string  $value
     * @return bool
     */
    public static function isMatch($pattern, $value)
    {
        $value = (string) $value;

        if (! is_iterable($pattern)) {
            $pattern = [$pattern];
        }

        foreach ($pattern as $pattern) {
            $pattern = (string) $pattern;

            if (preg_match($pattern, $value) === 1) {
                return true;
            }
        }

        return false;
    }


    /**
     * Pad both sides of a string with another.
     *
     * @param  string  $value
     * @param  int  $length
     * @param  string  $pad
     * @return string
     */
    public static function padBoth($value, $length, $pad = ' ')
    {
        $short = max(0, $length - mb_strlen($value));
        $shortLeft = floor($short / 2);
        $shortRight = ceil($short / 2);

        return mb_substr(str_repeat($pad, $shortLeft), 0, $shortLeft).
            $value.
            mb_substr(str_repeat($pad, $shortRight), 0, $shortRight);
    }

    /**
     * Pad the left side of a string with another.
     *
     * @param  string  $value
     * @param  int  $length
     * @param  string  $pad
     * @return string
     */
    public static function padLeft($value, $length, $pad = ' ')
    {
        $short = max(0, $length - mb_strlen($value));

        return mb_substr(str_repeat($pad, $short), 0, $short).$value;
    }

    /**
     * Pad the right side of a string with another.
     *
     * @param  string  $value
     * @param  int  $length
     * @param  string  $pad
     * @return string
     */
    public static function padRight($value, $length, $pad = ' ')
    {
        $short = max(0, $length - mb_strlen($value));

        return $value.mb_substr(str_repeat($pad, $short), 0, $short);
    }

    /**
     * Parse a Class[@]method style callback into class and method.
     *
     * @param  string  $callback
     * @param  string|null  $default
     * @return array<int, string|null>
     */
    public static function parseCallback($callback, $default = null)
    {
        return static::contains($callback, '@') ? explode('@', $callback, 2) : [$callback, $default];
    }



    /**
     * Pluralize the last word of an English, studly caps case string.
     *
     * @param  string  $value
     * @param  int|array|\Countable  $count
     * @return string
     */
    public static function pluralStudly($value, $count = 2)
    {
        $parts = preg_split('/(.)(?=[A-Z])/u', $value, -1, PREG_SPLIT_DELIM_CAPTURE);

        $lastWord = array_pop($parts);

        return implode('', $parts).self::plural($lastWord, $count);
    }



    /**
     * Find the multi-byte safe position of the first occurrence of a given substring in a string.
     *
     * @param  string  $haystack
     * @param  string  $needle
     * @param  int  $offset
     * @param  string|null  $encoding
     * @return int|false
     */
    public static function position($haystack, $needle, $offset = 0, $encoding = null)
    {
        return mb_strpos($haystack, (string) $needle, $offset, $encoding);
    }

    /**
     * Generate a more truly "random" alpha-numeric string.
     *
     * @param  int  $length
     * @return string
     */



    /**
     * Repeat the given string.
     *
     * @param  string  $string
     * @param  int  $times
     * @return string
     */
    public static function repeat(string $string, int $times)
    {
        return str_repeat($string, $times);
    }




    /**
     * Replace the first occurrence of a given value in the string.
     *
     * @param  string  $search
     * @param  string  $replace
     * @param  string  $subject
     * @return string
     */
    public static function replaceFirst($search, $replace, $subject)
    {
        $search = (string) $search;

        if ($search === '') {
            return $subject;
        }

        $position = strpos($subject, $search);

        if ($position !== false) {
            return substr_replace($subject, $replace, $position, strlen($search));
        }

        return $subject;
    }

    /**
     * Replace the first occurrence of the given value if it appears at the start of the string.
     *
     * @param  string  $search
     * @param  string  $replace
     * @param  string  $subject
     * @return string
     */
    public static function replaceStart($search, $replace, $subject)
    {
        $search = (string) $search;

        if ($search === '') {
            return $subject;
        }

        if (static::startsWith($subject, $search)) {
            return static::replaceFirst($search, $replace, $subject);
        }

        return $subject;
    }

    /**
     * Replace the last occurrence of a given value in the string.
     *
     * @param  string  $search
     * @param  string  $replace
     * @param  string  $subject
     * @return string
     */
    public static function replaceLast($search, $replace, $subject)
    {
        $search = (string) $search;

        if ($search === '') {
            return $subject;
        }

        $position = strrpos($subject, $search);

        if ($position !== false) {
            return substr_replace($subject, $replace, $position, strlen($search));
        }

        return $subject;
    }

    /**
     * Replace the last occurrence of a given value if it appears at the end of the string.
     *
     * @param  string  $search
     * @param  string  $replace
     * @param  string  $subject
     * @return string
     */
    public static function replaceEnd($search, $replace, $subject)
    {
        $search = (string) $search;

        if ($search === '') {
            return $subject;
        }

        if (static::endsWith($subject, $search)) {
            return static::replaceLast($search, $replace, $subject);
        }

        return $subject;
    }

    /**
     * Remove any occurrence of the given string in the subject.
     *
     * @param  string|iterable<string>  $search
     * @param  string|iterable<string>  $subject
     * @param  bool  $caseSensitive
     * @return string
     */


    /**
     * Reverse the given string.
     *
     * @param  string  $value
     * @return string
     */
    public static function reverse(string $value)
    {
        return implode(array_reverse(mb_str_split($value)));
    }

    /**
     * Begin a string with a single instance of a given value.
     *
     * @param  string  $value
     * @param  string  $prefix
     * @return string
     */
    public static function start($value, $prefix)
    {
        $quoted = preg_quote($prefix, '/');

        return $prefix.preg_replace('/^(?:'.$quoted.')+/u', '', $value);
    }

    /**
     * Convert the given string to upper-case.
     *
     * @param  string  $value
     * @return string
     */
    public static function upper($value)
    {
        return mb_strtoupper($value, 'UTF-8');
    }

    /**
     * Convert the given string to title case.
     *
     * @param  string  $value
     * @return string
     */
    public static function title($value)
    {
        return mb_convert_case($value, MB_CASE_TITLE, 'UTF-8');
    }


    /**
     * Generate a URL friendly "slug" from a given string.
     *
     * @param  string  $title
     * @param  string  $separator
     * @param  string|null  $language
     * @param  array<string, string>  $dictionary
     * @return string
     */
    public static function slug($title, $separator = '-', $language = 'en', $dictionary = ['@' => 'at'])
    {
        $title = $language ? static::ascii($title, $language) : $title;

        // Convert all dashes/underscores into separator
        $flip = $separator === '-' ? '_' : '-';

        $title = preg_replace('!['.preg_quote($flip).']+!u', $separator, $title);

        // Replace dictionary words
        foreach ($dictionary as $key => $value) {
            $dictionary[$key] = $separator.$value.$separator;
        }

        $title = str_replace(array_keys($dictionary), array_values($dictionary), $title);

        // Remove all characters that are not the separator, letters, numbers, or whitespace
        $title = preg_replace('![^'.preg_quote($separator).'\pL\pN\s]+!u', '', static::lower($title));

        // Replace all separator characters and whitespace by a single separator
        $title = preg_replace('!['.preg_quote($separator).'\s]+!u', $separator, $title);

        return trim($title, $separator);
    }



    /**
     * Remove all "extra" blank space from the given string.
     *
     * @param  string  $value
     * @return string
     */
    public static function squish($value)
    {
        return preg_replace('~(\s|\x{3164}|\x{1160})+~u', ' ', preg_replace('~^[\s\x{FEFF}]+|[\s\x{FEFF}]+$~u', '', $value));
    }

    /**
     * Determine if a given string starts with a given substring.
     *
     * @param  string  $haystack
     * @param  string|iterable<string>  $needles
     * @return bool
     */
    public static function startsWith($haystack, $needles)
    {
        if (! is_iterable($needles)) {
            $needles = [$needles];
        }

        foreach ($needles as $needle) {
            if ((string) $needle !== '' && str_starts_with($haystack, $needle)) {
                return true;
            }
        }

        return false;
    }



    /**
     * Returns the portion of the string specified by the start and length parameters.
     *
     * @param  string  $string
     * @param  int  $start
     * @param  int|null  $length
     * @param  string  $encoding
     * @return string
     */
    public static function substr($string, $start, $length = null, $encoding = 'UTF-8')
    {
        return mb_substr($string, $start, $length, $encoding);
    }

    /**
     * Returns the number of substring occurrences.
     *
     * @param  string  $haystack
     * @param  string  $needle
     * @param  int  $offset
     * @param  int|null  $length
     * @return int
     */
    public static function substrCount($haystack, $needle, $offset = 0, $length = null)
    {
        if (! is_null($length)) {
            return substr_count($haystack, $needle, $offset, $length);
        }

        return substr_count($haystack, $needle, $offset);
    }

    /**
     * Replace text within a portion of a string.
     *
     * @param  string|string[]  $string
     * @param  string|string[]  $replace
     * @param  int|int[]  $offset
     * @param  int|int[]|null  $length
     * @return string|string[]
     */
    public static function substrReplace($string, $replace, $offset = 0, $length = null)
    {
        if ($length === null) {
            $length = strlen($string);
        }

        return substr_replace($string, $replace, $offset, $length);
    }

    /**
     * Swap multiple keywords in a string with other keywords.
     *
     * @param  array  $map
     * @param  string  $subject
     * @return string
     */
    public static function swap(array $map, $subject)
    {
        return strtr($subject, $map);
    }

    /**
     * Make a string's first character lowercase.
     *
     * @param  string  $string
     * @return string
     */
    public static function lcfirst($string)
    {
        return static::lower(static::substr($string, 0, 1)).static::substr($string, 1);
    }

    /**
     * Make a string's first character uppercase.
     *
     * @param  string  $string
     * @return string
     */
    public static function ucfirst($string)
    {
        return static::upper(static::substr($string, 0, 1)).static::substr($string, 1);
    }

    /**
     * Split a string into pieces by uppercase characters.
     *
     * @param  string  $string
     * @return string[]
     */
    public static function ucsplit($string)
    {
        return preg_split('/(?=\p{Lu})/u', $string, -1, PREG_SPLIT_NO_EMPTY);
    }

    /**
     * Get the number of words a string contains.
     *
     * @param  string  $string
     * @param  string|null  $characters
     * @return int
     */
    public static function wordCount($string, $characters = null)
    {
        return str_word_count($string, 0, $characters);
    }

    /**
     * Wrap a string to a given number of characters.
     *
     * @param  string  $string
     * @param  int  $characters
     * @param  string  $break
     * @param  bool  $cutLongWords
     * @return string
     */
    public static function wordWrap($string, $characters = 75, $break = "\n", $cutLongWords = false)
    {
        return wordwrap($string, $characters, $break, $cutLongWords);
    }


}