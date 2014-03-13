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

/** Check for 'date' GET variable */
if( isset($_GET["date"]) ) {
    $date = $_GET["date"];
}
else {
    $date = "";
}

/** Check for 'time' GET variable */
if( isset($_GET["time"]) ) {
    $time = $_GET["time"];
}
else {
    $time = "";
}

/** Check for 'value' GET variable */
if( isset($_GET["value"]) ) {
    $value = $_GET["value"];
}
else {
    $value = 0;
}

/** Check for 'comment' GET variable */
if( isset($_GET["comment"]) ) {
    $comment = $_GET["comment"];
}
else {
    $comment = "";
}

/** Check for 'user_id' GET variable */
if( isset($_GET["user_id"]) ) {
    $user_id = $_GET["user_id"];
}
else {
    $user_id = 0;
}

/** Check for 'w_id' GET variable */
if( isset($_GET["w_id"]) ) {
    $w_id = $_GET["w_id"];
}
else {
    $w_id = 0;
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
    /** Case when we need to get the current weights listing */
    case "get":
        $q = "SELECT * FROM weight_measures";
        $res_get = $mysqli->query( $q );
        if( !$res_get ) {
            echo "ERROR_FAILED_GET_OPERATION";
        }
        else {
            $str_arr = "[";
            $count = 0;
            while( $row = $res_get->fetch_row() ) {
                if( $count!=0 ) {
                    $str_arr .= ", ";
                }
                $str_arr .= "{\"id\": ".$row[0].", \"user_id\": ".$row[1].", \"date\": \"".$row[2]."\", \"time\": \"".$row[3]."\", \"value\": ".$row[4].", \"comment\": ".$row[5]."}";
                $count++;
            }
            $str_arr .= "]";
            
            echo $str_arr;
        }
        break;
        
    /** Case when we need to get the current average weights listing */
    case "get_avg":
        $q = "SELECT name FROM users";
        $res_users = $mysqli->query( $q );
        if( !$res_users ) {
            echo "ERROR_NO_USERS";
        }
        else {
            $users_str = "";
            $users_names = array();
            $index = 0;
            while( $row = $res_users->fetch_row() ) {
                if( $index!=0 ) {
                    $users_str .= ",";
                }
                $users_str .= $row[0];
                $users_names[$index] = $row[0];
                $index++;
            }
            
            $q = "SELECT date,$users_str FROM weight_measures_avg";
            $res_get_avg = $mysqli->query( $q );
            if( !$res_get_avg ) {
                echo "ERROR_FAILED_GET_AVG_OPERATION";
            }
            else {
                $str_res = "";
                $campos = $res_get_avg->fetch_fields();
                $sz = sizeof($campos);
                
                $str_res .= "{ \"fields\": [";
                for( $i=0; $i<$sz; $i++ ) {
                    if( $i!=0 ) {
                        $str_res .= ", ";
                    }    
                    $str_res .= "\"".$campos[$i]->name."\"";                    
                }
                $str_res .= "], \"data_arr\": ";
                
                $str_arr = "[";
                $count = 0;
                while( $row = $res_get_avg->fetch_row() ) {
                    if( $count!=0 ) {
                        $str_arr .= ", ";
                    }
                    $str_arr .= "[";
                    for( $i=0; $i<$sz; $i++ ) {
                        if( $i==0 ) {
                            $str_arr .= "\"".$row[$i]."\"";
                        }
                        else {
                            $str_arr .= ", ".$row[$i];
                        }
                    }
                    $str_arr .= "]";
                    $count++;
                }
                $str_arr .= "]";
                
                $str_res .= $str_arr;
                
                $str_res .= " }"; //For main object closing
                echo $str_res;
            }
        }
        break;
      
    /** Case when we need to get the individual record of a user */
    case "get_individual":
        if( $user_id<1 ) {
            echo "ERROR_WRONG_USER_ID";
        }
        else {
            //$q = "SELECT * FROM weight_measures WHERE user_id=$user_id ORDER BY date ASC, time ASC";
            $q = "SELECT weight_measures .*,users.target FROM weight_measures LEFT JOIN users ON users.id=weight_measures.user_id WHERE user_id=$user_id ORDER BY date ASC, time ASC";
            $res_get = $mysqli->query( $q );
            if( !$res_get ) {
                echo "ERROR_FAILED_GET_OPERATION";
            }
            else {
                $str_arr = "";
                $count = 0;
                while( $row = $res_get->fetch_row() ) {
                    if( $count!=0 ) {
                        $str_arr .= ", ";
                    }
                    $str_arr .= "{\"id\": ".$row[0].", \"user_id\": ".$row[1].", \"date\": \"".$row[2]."\", \"time\": \"".$row[3]."\", \"value\": ".$row[4].", \"comment\": \"".$row[5]."\"}";
                    $last_row = $row;
                    $count++;
                }
                
                echo "{ \"target\": ".$last_row[6].", \"data\": [".$str_arr."] }";
            }
        }
        break;
        
    /** Case when we need to add a measure */
    case "add":
        if( $user_id<1 ) {
            echo "ERROR_WRONG_USER_ID";
        }
        else if( $date=="" ) {
            echo "ERROR_WRONG_DATE";
        }
        else if( $time=="" ) {
            echo "ERROR_WRONG_TIME";
        }
        else if( $value<50 ) {
            echo "ERROR_WRONG_WEIGHT_VALUE";
        }
        else {
            /** Insert user's weight into the weights table */
            $q = "INSERT INTO weight_measures (user_id,date,time,value,comment) VALUES ($user_id,'$date','$time',$value,'$comment')";
            $res_add = $mysqli->query( $q );
            if( !$res_add ) {
                echo "ERROR_FAILED_ADD_OPERATION";
            }
            else { /** Everything went OK */
                $res = update_averages_table($mysqli, $date);
                
                echo $res;
            }

        }
        break;
        
    /** Case when we need to delete a measure */
    case "del":
        if( $w_id<1 ) {
            echo "ERROR_WRONG_WEIGHT_ID";
        }
        else {
            /** First retrieve the date of the record being deleted */
            $q = "SELECT date FROM weight_measures WHERE id=".$w_id;
            $res_q = $mysqli->query( $q );
            
            if( !$res_q ) {
                echo "ERROR_WRONG_RECORD";
            }
            else {
                /** Get the row containing the date from the result */
                $row = $res_q->fetch_row();
                $date = $row[0];
                
                $q = "DELETE FROM weight_measures WHERE id=".$w_id;
                $res_del = $mysqli->query( $q );
                if( !$res_del ) {
                    echo "ERROR_FAILED_DEL_OPERATION";
                }
                else { /** Everything went OK */
                    $res = update_averages_table($mysqli, $date);
                    
                    echo $res;
                }
            }
            
        }
        break;
        
    default:
        echo "ERROR_UNKNOWN_ACTION";
        break;
}

$mysqli->close();

/**** FUNCTIONS ****/

/** Insert (or update) the corresponding entry for the averages table */
function update_averages_table($mysqlobj, $date)
{
    error_reporting( 0 );
    
    /* Select the avg weight of every user for that specific day */
    $q = "SELECT B.name,AVG(A.value) as avg FROM weight_measures A INNER JOIN users B ON A.user_id=B.id WHERE A.date='$date' GROUP BY A.date,A.user_id";
    $res_avg = $mysqlobj->query( $q );

    $values = "";
    $fields = "";
    $duplicates = "";

    /* Generate the query for inserting (or updating) the corresponding day's average */
    $count = 0;
    while( $row = $res_avg->fetch_row() ) {
        if( $count!=0 ) {
            $values .= ",";
            $fields .= ",";
            $duplicates .= ",";
        }

        $values .= number_format($row[1],2);
        $fields .= $row[0];
        $duplicates .= $row[0]."=".number_format($row[1],2);
        $count = 1;
    }

    /** Execute the query for the averages table */
    $q_avg = "INSERT INTO weight_measures_avg (date,$fields) VALUES ('$date',$values) ON DUPLICATE KEY UPDATE $duplicates";
    $res_q_avg = $mysqlobj->query( $q_avg );
    if( !$res_q_avg ) {
        return "ERROR_FAILED_AVG: $q_avg";
    }
    else {
        return "NO_ERROR";
    }
}

?>