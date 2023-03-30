<?php

/*
 * Class to operate folder table
 * @author: Elevenfox
 */

Class User {

    protected static $table_users;


    private static function setTables() {
        self::$table_users = Config::get('db_table_base_prefix') . 'users';
    }

    public static function getMaxUserId() {
        self::setTables();

        $res = DB::$dbInstance->getRows('select max(uid) as maxId from ' . self::$table_users);
        return $res[0]['maxId'];
    }

    public static function getUserByID($id) {
        self::setTables();

        $where = "WHERE id = $id";

        $query = 'SELECT * FROM ' . self::$table_users . ' ' . $where;
        $res = DB::$dbInstance->getRows($query);
        if(count($res)) {
            return $res[0];
        }
        else {
            error_log('Failed to get user by id: ' . $id);
            return false;
        }
    }

    public static function getUserByName($name) {
        self::setTables();

        $name = DB::sanitizeInput($name);

        $where = "WHERE name = '$name'";

        $query = 'SELECT * FROM ' . self::$table_users . ' ' . $where;
        $res = DB::$dbInstance->getRows($query);
        if(count($res)) {
            return $res[0];
        }
        else {
            error_log('Failed to get user by name: ' . $name);
            return false;
        }
    }

    public static function getRandomUserName() {
        self::setTables();

        $query = 'SELECT name FROM ' . self::$table_users . ' ORDER BY RAND() LIMIT 1';
        $res = DB::$dbInstance->getRows($query);
        if(count($res)) {
            return $res[0]['name'];
        }
        else {
            error_log('Failed to get random user!');
            return false;
        }
    }

    public static function authencate($username, $password) {
        $username = DB::sanitizeInput($username);

        $user = FALSE;
        if (!empty($username) && strlen(trim($password)) > 0) {
            $account = self::getUserByName($username);
            if ($account) {
                // Allow alternate password hashing schemes.
                if (self::user_check_password($password, $account)) {
                    // Successful authentication.
                    $user = $account;
                }
            }
        }
        return $user;
    }

    public static function getCurrentUser() {
        if(!empty($_SESSION['user'])) {
            return $_SESSION['user'];
        }

        return null;
    }

    public static function saveUser($uid, $name, $email, $pass=null) {
        self::setTables();

        $name = DB::sanitizeInput($name);
        $email = DB::sanitizeInput($email);
        if(empty($uid)) {
            // Create a new user
            $newUid = self::getMaxUserId() + 1;
            $encPass = self::_password_crypt('sha512', $pass, self::_password_generate_salt(15));
            $sql = "insert into " . self::$table_users . " set name='".$name."', mail='".$email."', status=1, pass='".$encPass."', uid=" . $newUid . ", created=" . time();
            $res = DB::$dbInstance->query($sql);

            if($res) {
                return self::getUserByName($name);
            }
            return false;
        }
        else {
            // Update a user
            $updatePassString = '';
            if(!empty($pass)) {
                $encPass = self::_password_crypt('sha512', $pass, self::_password_generate_salt(15));
                $updatePassString = ", pass='".$encPass."'";
            }
            $sql = "update " . self::$table_users . " set name='".$name."', mail='".$email."', status=1 ".$updatePassString." where uid=" . $uid . ' limit 1';
            $res = DB::$dbInstance->query($sql);
            if($res) {
                $updatedUser = self::getUserByName($name);
                $_SESSION['user'] = $updatedUser;
                return $updatedUser;
            }
            return false;
        }
    }


    /////////////////////////////////////////////////////////
    ///
    /// Below are functions copied from Drupal to generate
    /// and check password field
    ///
    /////////////////////////////////////////////////////////

    /**
     * Check whether a plain text password matches a stored hashed password.
     *
     * Alternative implementations of this function may use other data in the
     * $account object, for example the uid to look up the hash in a custom table
     * or remote database.
     *
     * @param $password
     *   A plain-text password
     * @param $account
     *   A user object with at least the fields from the {users} table.
     *
     * @return
     *   TRUE or FALSE.
     */
    private static function user_check_password($password, $account) {
        if (substr($account['pass'], 0, 2) == 'U$') {
            // This may be an updated password from user_update_7000(). Such hashes
            // have 'U' added as the first character and need an extra md5().
            $stored_hash = substr($account['pass'], 1);
            $password = md5($password);
        }
        else {
            $stored_hash = $account['pass'];
        }

        $type = substr($stored_hash, 0, 3);
        switch ($type) {
            case '$S$':
                // A normal Drupal 7 password using sha512.
                $hash = self::_password_crypt('sha512', $password, $stored_hash);
                break;
            case '$H$':
                // phpBB3 uses "$H$" for the same thing as "$P$".
            case '$P$':
                // A phpass password generated using md5.  This is an
                // imported password or from an earlier Drupal version.
                $hash = self::_password_crypt('md5', $password, $stored_hash);
                break;
            default:
                return FALSE;
        }
        return ($hash && $stored_hash == $hash);
    }

    /**
     * Hash a password using a secure stretched hash.
     *
     * By using a salt and repeated hashing the password is "stretched". Its
     * security is increased because it becomes much more computationally costly
     * for an attacker to try to break the hash by brute-force computation of the
     * hashes of a large number of plain-text words or strings to find a match.
     *
     * @param $algo
     *   The string name of a hashing algorithm usable by hash(), like 'sha256'.
     * @param $password
     *   Plain-text password up to 512 bytes (128 to 512 UTF-8 characters) to hash.
     * @param $setting
     *   An existing hash or the output of _password_generate_salt().  Must be
     *   at least 12 characters (the settings and salt).
     *
     * @return
     *   A string containing the hashed password (and salt) or FALSE on failure.
     *   The return string will be truncated at DRUPAL_HASH_LENGTH characters max.
     */
    private static function _password_crypt($algo, $password, $setting) {
        // Prevent DoS attacks by refusing to hash large passwords.
        if (strlen($password) > 512) {
            return FALSE;
        }
        // The first 12 characters of an existing hash are its setting string.
        $setting = substr($setting, 0, 12);

        if ($setting[0] != '$' || $setting[2] != '$') {
            return FALSE;
        }
        $count_log2 = self::_password_get_count_log2($setting);
        // Hashes may be imported from elsewhere, so we allow != DRUPAL_HASH_COUNT
        if ($count_log2 < 7 || $count_log2 > 30) {
            return FALSE;
        }
        $salt = substr($setting, 4, 8);
        // Hashes must have an 8 character salt.
        if (strlen($salt) != 8) {
            return FALSE;
        }

        // Convert the base 2 logarithm into an integer.
        $count = 1 << $count_log2;

        // We rely on the hash() function being available in PHP 5.2+.
        $hash = hash($algo, $salt . $password, TRUE);
        do {
            $hash = hash($algo, $hash . $password, TRUE);
        } while (--$count);

        $len = strlen($hash);
        $output =  $setting . self::_password_base64_encode($hash, $len);
        // _password_base64_encode() of a 16 byte MD5 will always be 22 characters.
        // _password_base64_encode() of a 64 byte sha512 will always be 86 characters.
        $expected = 12 + ceil((8 * $len) / 6);
        return (strlen($output) == $expected) ? substr($output, 0, 55) : FALSE;
    }

    /**
     * Parse the log2 iteration count from a stored hash or setting string.
     */
    private static function _password_get_count_log2($setting) {
        $itoa64 = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        return strpos($itoa64, $setting[3]);
    }

    /**
     * Encodes bytes into printable base 64 using the *nix standard from crypt().
     *
     * @param $input
     *   The string containing bytes to encode.
     * @param $count
     *   The number of characters (bytes) to encode.
     *
     * @return
     *   Encoded string
     */
    private static function _password_base64_encode($input, $count) {
        $output = '';
        $i = 0;
        $itoa64 = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        do {
            $value = ord($input[$i++]);
            $output .= $itoa64[$value & 0x3f];
            if ($i < $count) {
                $value |= ord($input[$i]) << 8;
            }
            $output .= $itoa64[($value >> 6) & 0x3f];
            if ($i++ >= $count) {
                break;
            }
            if ($i < $count) {
                $value |= ord($input[$i]) << 16;
            }
            $output .= $itoa64[($value >> 12) & 0x3f];
            if ($i++ >= $count) {
                break;
            }
            $output .= $itoa64[($value >> 18) & 0x3f];
        } while ($i < $count);

        return $output;
    }

    /**
     * Generates a random base 64-encoded salt prefixed with settings for the hash.
     *
     * Proper use of salts may defeat a number of attacks, including:
     *  - The ability to try candidate passwords against multiple hashes at once.
     *  - The ability to use pre-hashed lists of candidate passwords.
     *  - The ability to determine whether two users have the same (or different)
     *    password without actually having to guess one of the passwords.
     *
     * @param $count_log2
     *   Integer that determines the number of iterations used in the hashing
     *   process. A larger value is more secure, but takes more time to complete.
     *
     * @return
     *   A 12 character string containing the iteration count and a random salt.
     */
    private static function _password_generate_salt($count_log2) {
        $output = '$S$';
        // Ensure that $count_log2 is within set bounds.
        $count_log2 = self::_password_enforce_log2_boundaries($count_log2);
        // We encode the final log2 iteration count in base 64.
        $itoa64 = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $output .= $itoa64[$count_log2];
        // 6 bytes is the standard salt for a portable phpass hash.
        $output .= self::_password_base64_encode(self::drupal_random_bytes(6), 6);
        return $output;
    }

    /**
     * Ensures that $count_log2 is within set bounds.
     *
     * @param $count_log2
     *   Integer that determines the number of iterations used in the hashing
     *   process. A larger value is more secure, but takes more time to complete.
     *
     * @return
     *   Integer within set bounds that is closest to $count_log2.
     */
    private static function _password_enforce_log2_boundaries($count_log2) {
        if ($count_log2 < 7) {
            return 7;
        }
        elseif ($count_log2 > 30) {
            return 30;
        }

        return (int) $count_log2;
    }

    /**
     * Returns a string of highly randomized bytes (over the full 8-bit range).
     *
     * This function is better than simply calling mt_rand() or any other built-in
     * PHP function because it can return a long string of bytes (compared to < 4
     * bytes normally from mt_rand()) and uses the best available pseudo-random
     * source.
     *
     * @param $count
     *   The number of characters (bytes) to return in the string.
     */
    private static function drupal_random_bytes($count)  {
        // $random_state does not use drupal_static as it stores random bytes.
        static $random_state, $bytes, $has_openssl;

        $missing_bytes = $count - strlen($bytes);

        if ($missing_bytes > 0) {
            // PHP versions prior 5.3.4 experienced openssl_random_pseudo_bytes()
            // locking on Windows and rendered it unusable.
            if (!isset($has_openssl)) {
                $has_openssl = version_compare(PHP_VERSION, '5.3.4', '>=') && function_exists('openssl_random_pseudo_bytes');
            }

            // openssl_random_pseudo_bytes() will find entropy in a system-dependent
            // way.
            if ($has_openssl) {
                $bytes .= openssl_random_pseudo_bytes($missing_bytes);
            }

            // Else, read directly from /dev/urandom, which is available on many *nix
            // systems and is considered cryptographically secure.
            elseif ($fh = @fopen('/dev/urandom', 'rb')) {
                // PHP only performs buffered reads, so in reality it will always read
                // at least 4096 bytes. Thus, it costs nothing extra to read and store
                // that much so as to speed any additional invocations.
                $bytes .= fread($fh, max(4096, $missing_bytes));
                fclose($fh);
            }

            // If we couldn't get enough entropy, this simple hash-based PRNG will
            // generate a good set of pseudo-random bytes on any system.
            // Note that it may be important that our $random_state is passed
            // through hash() prior to being rolled into $output, that the two hash()
            // invocations are different, and that the extra input into the first one -
            // the microtime() - is prepended rather than appended. This is to avoid
            // directly leaking $random_state via the $output stream, which could
            // allow for trivial prediction of further "random" numbers.
            if (strlen($bytes) < $count) {
                // Initialize on the first call. The contents of $_SERVER includes a mix of
                // user-specific and system information that varies a little with each page.
                if (!isset($random_state)) {
                    $random_state = print_r($_SERVER, TRUE);
                    if (function_exists('getmypid')) {
                        // Further initialize with the somewhat random PHP process ID.
                        $random_state .= getmypid();
                    }
                    $bytes = '';
                }

                do {
                    $random_state = hash('sha256', microtime() . mt_rand() . $random_state);
                    $bytes .= hash('sha256', mt_rand() . $random_state, TRUE);
                }
                while (strlen($bytes) < $count);
            }
        }
        $output = substr($bytes, 0, $count);
        $bytes = substr($bytes, $count);
        return $output;
    }
}