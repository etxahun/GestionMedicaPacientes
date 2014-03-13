<?

/** Disable error reporting by default */
error_reporting( 0 );

/** Check for 'action' GET variable */
if( isset($_GET["action"]) ) {
    $action = $_GET["action"];
}
else {
    $action = "get";
}

/** Check for 'username' GET variable */
if( isset($_GET["username"]) ) {
    $username = $_GET["username"];
}
else {
    $username="";
}

/** Checck for 'target' GET variable */
if( isset($_GET["target"]) ) {
    $target = $_GET["target"];
}
else {
    $target = 0;
}

/** Checck for 'user_id' GET variable */
if( isset($_GET["user_id"]) ) {
    $user_id = $_GET["user_id"];
}
else {
    $user_id = 0;
}

/** Check for 'debug' GET variable */
if( isset($_GET["debug"]) ) {
    $debug = $_GET["debug"];
}
else {
    $debug = "0";
}

/**************************/

/* Add this for debugging */
if( $debug=="1" ) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}
/**************************/

/** Autocheck */
if( $action=="" ) {
    $action="get";
}

/** Connect to database */
$mysqli = new mysqli("localhost", "halls", "kakongordo", "halls_fn" );

/** Check which action has to be performed */
switch( $action ) {
    /** Case when we need to get the current users */
    case "get":
        $res_users = $mysqli->query("SELECT * FROM users" );
        
        $str_arr = "[";
        $count = 0;
        while( $row = $res_users->fetch_row() ) {
            if( $count!=0 ) {
                $str_arr .= ", ";
            }
            $str_arr .= "{\"id\": ".$row[0].", \"user\": \"".$row[1]."\", \"target\": ".$row[2]."}";
            $count++;
        }
        $str_arr .= "]";
        
        echo $str_arr;
        break;
        
    /** Case when we need to add a user */
    case "add":
        if( $username=="" ) {
            echo "ERROR_WRONG_USER";
        }
        else if ($target==0) {
            echo "ERROR_WRONG_TARGET";
        }
        else {
            $q = "INSERT INTO users (name,target) VALUES ('".$username."',".$target.")";
            if( $debug=="1" ) {
                echo "[DEBUG] Query: $q <br />";
            }
            
            $res_add = $mysqli->query( $q );
            if( !$res_add ) {
                echo "ERROR_FAILED_ADD_OPERATION";
            }
            else {
                $q = "ALTER TABLE weight_measures_avg ADD $username FLOAT NOT NULL DEFAULT 0";
                $res_insert = $mysqli->query( $q );
                
                echo "NO_ERROR";
            }
        }
        break;
        
    /** Case when we need to delete a user */
    case "del":
        if( $user_id==0 ) {
            echo "ERROR_WRONG_USER";
        }
        else {
            $q = "SELECT name FROM users WHERE id=".$user_id;
            $res_name = $mysqli->query( $q );
            
            if( !$res_name ) {
                echo "ERROR_WRONG_USER";
            }
            else {
                $row = $res_name->fetch_row();
                $username = $row[0];
                
                $q = "DELETE FROM users WHERE id=".$user_id;
                if( $debug=="1" ) {
                    echo "[DEBUG] Query: $q <br />";
                }
                
                $res_del = $mysqli->query( $q );
                if( !$res_del ) {
                    echo "ERROR_WRONG_USER";
                }
                else {
                    $q = "ALTER TABLE weight_measures_avg DROP $username";
                    $mysqli->query( $q );
                    
                    echo "NO_ERROR";
                }
            }
        }
        break;
        
    default:
        echo "ERROR_NO_ACTION";
        break;
}

$mysqli->close();

?>