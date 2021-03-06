<?php
/**
 * Standardize queries and error reporting
 *
 * @param string $query The SQL query
 * @param string $error (optional) The failure message
 * @param string $results_error (optional) Throw an error if a records are found
 * @param string $no_results_error (optional) Throw an error if no records are found
 * @since 1.2.0
 */
function pod_query($sql, $error = 'SQL failed', $results_error = null, $no_results_error = null) {
    global $wpdb;

    $sql = trim($sql);
    // Using @wp_users is deprecated! use $wpdb->users instead!
    $sql = str_replace('@wp_users', $wpdb->users, $sql);
    $sql = str_replace('@wp_', $wpdb->prefix, $sql);
    $sql = str_replace('{prefix}', '@wp_', $sql);

    // Return cached resultset
    if ('SELECT' == substr($sql, 0, 6)) {
        $cache = PodCache::instance();
        if ($cache->cache_enabled && isset($cache->results[$sql])) {
            $result = $cache->results[$sql];
            if (0 < mysql_num_rows($result)) {
                mysql_data_seek($result, 0);
            }
            return $result;
        }
    }
    $result = mysql_query($sql, $wpdb->dbh) or die("<e>$error; SQL: $sql; Response: " . mysql_error($wpdb->dbh));

    if (0 < @mysql_num_rows($result)) {
        if (!empty($results_error)) {
            die("<e>$results_error");
        }
    }
    elseif (!empty($no_results_error)) {
        die("<e>$no_results_error");
    }

    if ('INSERT' == substr($sql, 0, 6)) {
        $result = mysql_insert_id($wpdb->dbh);
    }
    elseif ('SELECT' == substr($sql, 0, 6)) {
        if ('SELECT FOUND_ROWS()' != $sql) {
            $cache->results[$sql] = $result;
        }
    }
    return $result;
}

/**
 * Filter input. Escape output.
 *
 * @param mixed $input The string, array, or object to sanitize
 * @since 1.2.0
 */
function pods_sanitize($input) {
    global $wpdb;
    $output = array();

    if (empty($input)) {
        $output = $input;
    }
    elseif (is_object($input)) {
        foreach ((array) $input as $key => $val) {
            $output[$key] = pods_sanitize($val);
        }
        $output = (object) $output;
    }
    elseif (is_array($input)) {
        foreach ($input as $key => $val) {
            $output[$key] = pods_sanitize($val);
        }
    }
    else {
        $output = mysql_real_escape_string($input,$wpdb->dbh);
    }
    return $output;
}

/**
 * Return a GET, POST, COOKIE, SESSION, or URI string segment
 *
 * @param mixed $key The variable name or URI segment position
 * @param string $type (optional) "uri", "get", "post", "cookie", or "session"
 * @return string The requested value, or null
 * @since 1.6.2
 */
function pods_url_variable($key = 'last', $type = 'uri') {
    $output = null;
    $type = strtolower($type);
    if ('uri' == $type) {
        $uri = explode('?', $_SERVER['REQUEST_URI']);
        $uri = explode('#', $uri[0]);
        $uri = preg_replace("@^([/]?)(.*?)([/]?)$@", "$2", $uri[0]);
        $uri = explode('/', $uri);

        if ('first' == $key) {
            $key = 0;
        }
        elseif ('last' == $key) {
            $key = -1;
        }

        if (is_numeric($key)) {
            $output = (0 > $key) ? $uri[count($uri)+$key] : $uri[$key];
        }
    }
    elseif ('get' == $type) {
        $output = isset($_GET[$key]) ? $_GET[$key] : null;
    }
    elseif ('post' == $type) {
        $output = isset($_POST[$key]) ? $_POST[$key] : null;
    }
    elseif ('session' == $type) {
        $output = isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }
    return pods_sanitize($output);
}

/**
 * Create a slug from an input string
 *
 * @param string $str
 * @since 1.8.9
 */
function pods_create_slug($str) {
    $str = preg_replace("/([_ ])/", "-", trim($str));
    $str = preg_replace("/([^0-9a-z-.])/", "", strtolower($str));
    $str = preg_replace("/(-){2,}/", "-", $str);
    return $str;
}

/**
 * Return a lowercase alphanumeric name (with underscores)
 *
 * @param string $name Input string to clean
 * @since 1.2.0
 */
function pods_clean_name($str) {
    $str = preg_replace("/([- ])/", "_", trim($str));
    $str = preg_replace("/([^0-9a-z_])/", "", strtolower($str));
    $str = preg_replace("/(_){2,}/", "_", $str);
    return $str;
}

/**
 * Build a unique slug
 *
 * @todo Simplify this function - get rid of the pod_id crap
 * @param string $value The slug value
 * @param string $column_name The column name
 * @param string $datatype The datatype name
 * @param int $datatype_id The datatype ID
 * @param int $pod_id The item's ID in the wp_pod table
 * @return string The unique slug name
 * @since 1.7.2
 */
function pods_unique_slug($value, $column_name, $datatype, $datatype_id, $pod_id = 0) {
    $value = sanitize_title($value);
    $sql = "
    SELECT DISTINCT
        t.`$column_name` AS slug
    FROM
        @wp_pod p
    INNER JOIN
        `@wp_pod_tbl_{$datatype}` t ON t.id = p.tbl_row_id
    WHERE
        p.datatype = '$datatype_id' AND p.id != '$pod_id'
    ";
    $result = pod_query($sql);
    if (0 < mysql_num_rows($result)) {
        $unique_num = 0;
        $unique_found = false;
        while ($row = mysql_fetch_assoc($result)) {
            $taken_slugs[] = $row['slug'];
        }
        if (in_array($value, $taken_slugs)) {
            while (!$unique_found) {
                $unique_num++;
                $test_slug = $value . '-' . $unique_num;
                if (!in_array($test_slug, $taken_slugs)) {
                    $value = $test_slug;
                    $unique_found = true;
                }
            }
        }
    }
    return $value;
}

/**
 * Find out if the current page is a Pod Page
 *
 * @param string $uri The Pod Page URI to check if currently on
 * @return bool
 * @since 1.7.5
 */
function is_pod_page($uri = null) {
    global $pod_page_exists;

    if (false !== $pod_page_exists) {
        if (null == $uri || $uri == $pod_page_exists['uri']) {
            return true;
        }
    }
    return false;
}

/**
 * Check to see if Pod Page exists and return data
 *
 * $uri not required, if NULL then returns REQUEST_URI matching Pod Page
 *
 * @param string $uri The Pod Page URI to check if exists
 * @return array
 */
function pod_page_exists($uri = null) {
    global $wpdb;
    if (null == $uri) {
        $home = parse_url(get_bloginfo('url'));
        $uri = explode('?', $_SERVER['REQUEST_URI']);
        $uri = explode('#', $uri[0]);
        $uri = $uri[0];
        if($home['path']!='/') {
            $uri = substr($uri, strlen($home['path']));
        }
    }
    $uri = trim($uri,'/');
    $uri = mysql_real_escape_string($uri,$wpdb->dbh);
    $uri_depth = count(explode('/',$uri))-1;

    if (false !== strpos($uri, 'wp-admin')) {
        return false;
    }

    // See if the custom template exists
    $result = pod_query("SELECT * FROM @wp_pod_pages WHERE uri = '$uri' LIMIT 1");
    if (1 > mysql_num_rows($result)) {
        // Find any wildcards
        $sql = "SELECT * FROM @wp_pod_pages
                WHERE
                    (LENGTH(uri)-LENGTH(REPLACE(uri,'/','')))=$uri_depth
                    AND '$uri' LIKE REPLACE(uri, '*', '%')
                ORDER BY LENGTH(uri) DESC, uri DESC
                LIMIT 1";
        $result = pod_query($sql);
    }

    if (0 < mysql_num_rows($result)) {
        $pod_page_data = mysql_fetch_assoc($result);
        $validate_pod_page = explode('/',$pod_page_data['uri']);
        $validate_uri = explode('/',$uri);
        if (count($validate_pod_page)==count($validate_uri)) {
            return $pod_page_data;
        }
    }
    return false;
}

/**
 * See if the current user has a certain privilege
 *
 * @param mixed $priv The privilege name or names (array if multiple)
 * @param string $method The access method ("AND", "OR")
 * @return bool
 * @since 1.2.0
 */
function pods_access($privs, $method = 'OR') {
    global $pods_roles;

    if (current_user_can('administrator') || current_user_can('pods_administrator') || (function_exists('is_super_admin') && is_super_admin())) {
        return true;
    }

    // Convert $method to uppercase
    $method = strtoupper($method);

    // Convert $privs to an array
    $privs = (array) $privs;

    // Store approved privs when using "AND"
    $approved_privs = array();

    // Loop through the user's roles
    if (is_array($pods_roles)) {
        foreach ($pods_roles as $role => $pods_privs) {
            if (current_user_can($role)) {
                foreach ($privs as $priv) {
                    if (false !== array_search($priv, $pods_privs) || current_user_can('pods_'.ltrim($priv,'pod_'))) {
                        if ('OR' == $method) {
                            return true;
                        }
                        $approved_privs[$priv] = true;
                    }
                }
            }
        }
        if ('AND' == strtoupper($method)) {
            foreach ($privs as $priv) {
                if (isset($approved_privs[$priv])) {
                    return false;
                }
            }
            return true;
        }
    }
    return false;
}

/**
 * Shortcode support for WP Posts and Pages
 *
 * @param array $tags An associative array of shortcode properties
 * @since 1.6.7
 */
function pods_shortcode($tags) {
    $pairs = array('name' => null, 'id' => null, 'slug' => null, 'order' => 'id DESC', 'limit' => 15, 'where' => null, 'col' => null, 'template' => null, 'helper' => null);
    $tags = shortcode_atts($pairs, $tags);

    if (empty($tags['name'])) {
        return '<e>Please provide a Pod name';
    }
    if (empty($tags['template']) && empty($tags['col'])) {
        return '<e>Please provide either a template or column name';
    }

    // id > slug (if both exist)
    $id = empty($tags['slug']) ? null : $tags['slug'];
    $id = empty($tags['id']) ? $id : $tags['id'];

    $order = empty($tags['order']) ? 'id DESC' : $tags['order'];
    $limit = empty($tags['limit']) ? 15 : $tags['limit'];
    $where = empty($tags['where']) ? null : $tags['where'];

    $Record = new Pod($tags['name'], $id);

    if (empty($id)) {
        $Record->findRecords($order, $limit, $where);
    }
    if (!empty($tags['col']) && !empty($id)) {
        $val = $Record->get_field($tags['col']);
        return empty($tags['helper']) ? $val : $Record->pod_helper($tags['helper'], $val);
    }
    return $Record->showTemplate($tags['template']);
}

/**
 * Translation support
 *
 * @param string $string The string to translate
 * @return string The translated string, or the original string
 * @since 1.7.0
 */
function pods_i18n($string) {
    global $lang;

    if (isset($lang[$string])) {
        $string = $lang[$string];
    }
    return $string;
}

/**
 * Generate form key - INTERNAL USE
 *
 * @since 1.2.0
 */
function pods_generate_key($datatype, $uri_hash, $public_columns, $form_count = 1) {
    $token = md5(mt_rand());
    $_SESSION[$uri_hash][$form_count]['dt'] = $datatype;
    $_SESSION[$uri_hash][$form_count]['token'] = $token;
    $_SESSION[$uri_hash][$form_count]['columns'] = $public_columns;
    return $token;
}

/**
 * Validate form key - INTERNAL USE
 *
 * @since 1.2.0
 */
function pods_validate_key($key, $uri_hash, $datatype, $form_count = 1) {
    if (!empty($_SESSION[$uri_hash])) {
        $session_dt = $_SESSION[$uri_hash][$form_count]['dt'];
        $session_token = $_SESSION[$uri_hash][$form_count]['token'];
        if (!empty($session_token) && $key == $session_token && $datatype == $session_dt) {
            return true;
        }
    }
    return false;
}
