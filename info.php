<?php

defaults('USE_AUTHENTICATION',1);			// Use (internal) authentication - best choice if

defaults('ADMIN_USERNAME','apc-fox'); 			// Admin Username
defaults('ADMIN_PASSWORD','1234asdf');  	// Admin Password - CHANGE THIS TO ENABLE!!!


// check validity of input variables
$vardom=array(
    'LO'	=> '/^1$/',				// login requested
);
// handle POST and GET requests
if (empty($_REQUEST)) {
    if (!empty($_GET) && !empty($_POST)) {
        $_REQUEST = array_merge($_GET, $_POST);
    } else if (!empty($_GET)) {
        $_REQUEST = $_GET;
    } else if (!empty($_POST)) {
        $_REQUEST = $_POST;
    } else {
        $_REQUEST = array();
    }
}
// check parameter syntax
foreach($vardom as $var => $dom) {
    if (!isset($_REQUEST[$var])) {
        $MYREQUEST[$var]=null;
    } else if (!is_array($_REQUEST[$var]) && preg_match($dom.'D',$_REQUEST[$var])) {
        $MYREQUEST[$var]=$_REQUEST[$var];
    } else {
        $MYREQUEST[$var]=$_REQUEST[$var]=null;
    }
}

// authentication needed?
if (!USE_AUTHENTICATION) {
    $AUTHENTICATED=1;
} else {
    $AUTHENTICATED=0;
    if (ADMIN_PASSWORD!='password' && ($MYREQUEST['LO'] == 1 || isset($_SERVER['PHP_AUTH_USER']))) {

        if (!isset($_SERVER['PHP_AUTH_USER']) ||
            !isset($_SERVER['PHP_AUTH_PW']) ||
            $_SERVER['PHP_AUTH_USER'] != ADMIN_USERNAME ||
            $_SERVER['PHP_AUTH_PW'] != ADMIN_PASSWORD) {
            Header("WWW-Authenticate: Basic realm=\"APC Login\"");
            Header("HTTP/1.0 401 Unauthorized");

            echo <<<EOB
				<html><body>
				<h1>Rejected!</h1>
				<big>Wrong Username or Password!</big><br/>&nbsp;<br/>&nbsp;
				<big><a href='$PHP_SELF?OB={$MYREQUEST['OB']}'>Continue...</a></big>
				</body></html>
EOB;
            exit;

        } else {
            $AUTHENTICATED=1;
        }
    }
}


echo put_login_link();


if (!$AUTHENTICATED) {
    echo <<<EOB
		<h3>Please login first</h3>
EOB;
    exit;
}



echo info();
print "<br><br><br><br><br><br><br><br><br><br>";
echo phpinfo();

function info()
{
	$svn_table = create_table(info_revision());
	$php_server_table = create_table($_SERVER);

	$final_output = '<div class="center_z">';
	$final_output = $final_output.css_style().create_table_header();
	$final_output = $final_output."<br>".$svn_table;
	$final_output = $final_output."<br>".$php_server_table;
	$final_output = $final_output.'</div>';
	return $final_output;
}

function info_revision()
{
        $svn_info = shell_exec(escapeshellcmd('svn info ../') );
        $svn_info_withOut_lines = preg_split( '/\r\n|\r|\n/', $svn_info);

        $svn_Path = explode (":", $svn_info_withOut_lines[0]);
        $svn_url = explode (":", $svn_info_withOut_lines[1]);
        $svn_url_path = "$svn_url[1]".":"."$svn_url[2]";
        $svn_repoRoot = explode (":", $svn_info_withOut_lines[2]);
        $svn_repoRoot_path = "$svn_repoRoot[1]"."$svn_repoRoot[2]";
        $svn_repoUuid = explode (":", $svn_info_withOut_lines[3]);
        $svn_revision = explode (":", $svn_info_withOut_lines[4]);
        $svn_nodeKind = explode (":", $svn_info_withOut_lines[5]);
        $svn_schedule = explode (":", $svn_info_withOut_lines[6]);
        $svn_LastAuthor = explode (":", $svn_info_withOut_lines[7]);
        $svn_LastRev = explode (":", $svn_info_withOut_lines[8]);
        $svn_LastUpdate = explode (":", $svn_info_withOut_lines[9]);
        $svn_LastUpdate_all = $svn_LastUpdate[1].":".$svn_LastUpdate[2].":".$svn_LastUpdate[3];

        $svn_url_path_array = explode ("/", $svn_url_path);
        $svn_url_path_array_count = count($svn_url_path_array);
        $svn_Branch_name = "<b>".$svn_url_path_array[$svn_url_path_array_count-1]."</b>";

        $hash_basic = array (
                                $svn_revision[0] => "<b>".$svn_LastRev[1]."</b>",
                                "Branch"  => $svn_Branch_name,
                                $svn_LastAuthor[0] => $svn_LastAuthor[1],
                                $svn_LastUpdate[0] => $svn_LastUpdate_all,
                                $svn_url[0] => $svn_url_path);
        return $hash_basic;
}

/*
* This function creates table for the given hash
*/
function create_table($hash)
{
	$output = '<table width="600" cellpadding="3" border="0"> <tbody>';
	foreach ($hash as $key => $value)
	{
		if( $key == "HTTP_COOKIE")
		{}
		else
		{
			$output = $output.'<tr> <td class="e_z" WIDTH="100">'.$key.'</td>';
			$output = $output.'<td class="v_z" WIDTH="500">'.$value.'</td> </tr>';
		}
	}

	$output = $output."</tbody> </table>";

	return $output;
}


/*
* This function creates table for the given hash
*/
function create_table_header()
{
	$output = '<table width="600" cellpadding="3" border="0"> <tbody>';
	$output = $output.'<tr class="h_z"> <td>';
	$output = $output.'<h1 class="p_z">'.$_SERVER['HTTP_HOST'].'</h1> </td>';
	$output = $output."</tbody> </table>";

	return $output;
}

/*
*
*/
function css_style()
{
	$output = '<style type="text/css">'.
			'pre {margin: 0px; font-family: monospace;}'.
			'.center_z {text-align: center;}'.
			'.center_z table { margin-left: auto; margin-right: auto; text-align: left;}'.
			'.center_z th { text-align: center !important; }'.
			'td, th { border: 1px solid #000000; font-size: 75%; vertical-align: baseline;}'.
			'h1 {font-size: 150%;}'.
			'h2 {font-size: 125%;}'.
			'.p {text-align: left;}'.
			'.e_z {background-color: #58BED8; font-weight: bold; color: #000000;}'.
			'.h_z {background-color: #E5F1F4; font-weight: bold; color: #000000;}'.
			'.v_z {background-color: #cccccc; color: #000000;}'.
			'.vr_z {background-color: #cccccc; text-align: right; color: #000000;}'.
			'img {float: right; border: 0px;}'.
			'hr {width: 600px; background-color: #cccccc; border: 0px; height: 1px; color: #000000;}'.
			'</style>';
	return $output;
}

// "define if not defined"
function defaults($d,$v) {
    if (!defined($d)) define($d,$v); // or just @define(...)
}

function put_login_link($s="Login")
{
    global $AUTHENTICATED;

    $PHP_SELF= isset($_SERVER['PHP_SELF']) ? htmlentities(strip_tags($_SERVER['PHP_SELF'],''), ENT_QUOTES, 'UTF-8') : '';

    if (!USE_AUTHENTICATION) {
        return;
    }
    else if ($AUTHENTICATED) {
        print <<<EOB
			'{$_SERVER['PHP_AUTH_USER']}'&nbsp;logged&nbsp;in!
EOB;
    } else{
        print <<<EOB
			<a href="$PHP_SELF?LO=1">$s</a>
EOB;
    }
}