var tmp_results = null;

/** Set container for hidden temporal AJAX results */
var setHiddenResultsContainer = function(tmp)
{
    tmp_results = $(tmp);
}

/** 
 * Function to retrieve a weights array and process it with a callback function
 *
 * @param callback : callback function to be executed after the array has been retrieved
 * @param cb_data : data object to be passed to the callback function
 */
var getWeightsArray = function(callback,cb_data)
{
    var url = "weights.php?action=get_avg";
    if( tmp_results==null ) {
        alert("No hidden results container has been defined" );
    }
    else {
        tmp_results.load(url,function(data) {
            var wg = JSON.parse(tmp_results.html());

            callback( wg, cb_data );
        });
    }
}

/** 
 * Function to retrieve a weights array from a specific user, and process it 
 * with a callback function
 *
 * @param callback : callback function to be executed after the array has been retrieved
 * @param cb_data : data object to be passed to the callback function
 */
var getUserWeightsArray = function(id,callback,cb_data)
{
    var url = "weights.php?action=get_individual&user_id="+id;
    if( tmp_results==null ) {
        alert("No hidden results container has been defined" );
    }
    else {
        tmp_results.load(url,function(data) {
            var wg = JSON.parse(tmp_results.html());

            callback( wg, cb_data );
        });
    }
}

/** 
 * Function to retrieve a users array and process it with a callback function
 *
 * @param callback : callback function to be executed after the array has been retrieved
 * @param cb_data : data object to be passed to the callback function
 */
var getUsersArray = function(callback,cb_data)
{
    var url = "users.php?action=get";
    if( tmp_results==null ) {
        alert("No hidden results container has been defined" );
    }
    else {
        tmp_results.load(url,function(data) {
            var us = JSON.parse(tmp_results.html());
            
            callback( us, cb_data );
        });
    }
}

/** Display weights array into a graph */
var graphAvgWeights = function(arr,keys,container)
{
    var line = new RGraph.Line(container, arr.splice(1))
        .Set( 'ymin', 55 )
        .Set( 'ymax', 115 )
        .Set( 'tickmarks', 'filledcircle' )
        .Set( 'ticksize', 1 )
        .Draw();
        
    RGraph.HTML.Key('lecturas', {
                                'colors': line.Get('colors'),
                                'labels': keys.slice(1),
                                });
}

/** Display a table containing the data from the 'weights' array */
var displayAvgWeights = function(arr,container)
{
    var fields = arr.fields;
    var flen = fields.length;
    
    var weights = arr.data_arr;
    var len = weights.length;
    
    var usr_wg = new Array( fields.length );
    var last_wg = new Array( fields.length );
    
    var str = "";
    
    
    
    /** Initialize user arrays */
    for( i=0; i<flen; i++ ) {
        usr_wg[i] = new Array();
        last_wg[i] = 0;
    }
    
    str += "<table class=\"weights\">"; 

    /** Display headers */
    str += "<tr>";
    for( i=0; i<5; i++ ) {
        str += "<th"+(fields[i]=="date"?" class=\"date\"":"")+">"+fields[i]+"</th>";
    }
    str += "</tr>";

    /* Now display data */    
    for( i=0; i<len; i++ ) {
        str += "<tr>";
        for( j=0; j<fields.length; j++ ) {
            if( weights[i][j]==0 ) {
                str += "<td>--</td>";
                usr_wg[j].push(last_wg[j]); 
            }
            else {
                usr_wg[j].push(weights[i][j]);
                str += "<td"+((j==0)?" class=\"date\"":"")+">" + weights[i][j] + "</td>";
                last_wg[j] = weights[i][j];
            }
        }
        str += "</tr>";
    }
    str += "</table>";
    
    $(container).html(str);
    graphAvgWeights( usr_wg, arr.fields, "w_graph" );
}

/** Display a table containing the data from the 'weights' array */
var displayUserWeights = function(arr,container)
{
    var weights = arr.data;
    var target = arr.target;
    var len = weights.length;
    var str = "";
    
    str += "<span><b>Target:</b> "+target+" kg</span><br /><br />";
    str += "<table class=\"weights\" style=\"border: 1px solid #000;\">";
    str += "<tr><th>ID</th><th>Fecha</th><th>Hora</th><th>Peso</th><th style=\"text-align:center\">Eliminar?</th>";
    for( i=0; i<len; i++ ) {
        str += "<tr>";
        str += "<td>"+weights[i].id+"</td>";
        str += "<td>"+weights[i].date+"</td>";
        str += "<td>"+weights[i].time+"</td>";
        str += "<td>"+weights[i].value+"</td>";
        str += "<td style=\"text-align:center\">";
        str += "<a href=\"javascript: if( confirm('Eliminar peso con ID="+weights[i].id+" ?') ) {delWeight("+weights[i].id+");}\" class=\"deleter\">X</a>";
        str += "</td>";
        str += "</tr>";
    }
    str += "</table>";
    
    $(container).html(str);
}

/** Display users taken from the array */
var displayUsers = function(users,container)
{
    var len = users.length;
    var str = "";
    
    str += "<span style=\"font-weight: bold;\">Participantes</h2></span>";
    str += "<ul style=\"list-style-type: none; padding-left: 10px\">";
    
    for( i=0; i<len; i++ ) {
        str += "<li>";
        str += "<a href=\"javascript: toggleUser("+users[i].id+");\">"+users[i].user+"</a>";
        str += "<div id=\"userdiv"+users[i].id+"\"style=\"display: none; padding-bottom: 10px\">";
        str += "(Cargando...)";
        str += "</div>";
        str += "</li>";
    }
    str += "</ul>";
    
    $(container).html(str);
}

/** Fill a combo box with the specified users array */
var fillComboBox = function(users,cb)
{
    var len = users.length;
    //var sel = document.getElementById(cb);
    var sel = $(cb)[0];
    
    var opt_inicial = document.createElement('option');
    opt_inicial.innerHTML = "(Selecciona)";
    opt_inicial.value = -1;
    sel.appendChild(opt_inicial);
    
    for( i=0; i<len; i++ ) {
        var opt = document.createElement('option');
        opt.innerHTML = users[i].user;
        opt.value = users[i].id;
        sel.appendChild(opt);
    }
}

/** Updates the current view of the users list with renewed data */
var updateUsersView = function()
{
    getUsersArray(displayUsers,"#users");
}

/** Updates the current view of the weights list with renewed data */
var updateWeightsView = function()
{
    getWeightsArray(displayAvgWeights,"#weights");
}

/** Toggle the visibility of the specified user div */
var toggleUser = function(id)
{
    var div = $("#userdiv"+id);
    //var halls_weights = [{id: 1,user_id: 4, date: "2014-01-07", time: "08:30:00", value: 106, comment: ""},{id: 2,user_id: 4, date: "2014-01-07", time: "23:30:00", value: 108.1, comment: ""},{id: 3,user_id: 4, date: "2014-01-08", time: "08:30:00", value: 105.9, comment: ""},];
    
    if( div.css('display') == 'none' ) {
        div.show();
        //displayUserWeights(halls_weights,"#userdiv"+id);
        getUserWeightsArray(id,displayUserWeights,"#userdiv"+id);
    }
    else {
        div.hide();
    }
}

/** Returns the current date in the correct format */
var getCurrentDate = function()
{
    var d = new Date();
    var dd = d.getDate();
    var mm = d.getMonth()+1;
    var yyyy = d.getFullYear();
    
    if( dd<10 ) {
        dd = '0' + dd;
    }
    
    if( mm<10 ) {
        mm = '0' + mm;
    }
    
    return yyyy+"-"+mm+"-"+dd;
}

/**
 * Add a weight record into the database
 * 
 * @param user_id : ID of the corresponding user
 */
var addWeight = function(user_id,date,time,value)
{
    var url = "weights.php?action=add";
    url += "&user_id=" + user_id;
    url += "&date=" + date;
    url += "&time=" + time;
    url += "&value=" + value;
    
    if( tmp_results==null ) {
        alert("No hidden results container has been defined" );
    }
    else {
        tmp_results.load(url,function(data) {
            var res = tmp_results.html();
            
            if( res=="ERROR_WRONG_USER_ID" ) {
                alert( "El usuario con ID '"+user_id+"' no existe." );
            }
            else if( res=="ERROR_WRONG_DATE" ) {
                alert( "El formato de fecha no es correcto." );
            }
            else if( res=="ERROR_WRONG_TIME" ) {
                alert( "El formato de hora no es correcto." );
            }
            else if( res=="ERROR_WRONG_WEIGHT_VALUE" ) {
                alert( "El peso debe ser un valor mayor de 50 kg." );
            }
            else if( res=="ERROR_FAILED_ADD_OPERATION" ) {
                alert( "Ha ocurrido un error en la base de datos al intentar añadir el registro." );
            }
            else if( res=="NO_ERROR" ) {
                /** Everything went OK */
                updateWeightsView();
            }
            else{
                alert("Ha ocurrido un error inesperado: \n" + res );
            }
        });
    }
}

/**
 * Delete a weight record from the database
 * 
 * @param w_id : ID of the corresponding weight
 */
var delWeight = function(w_id)
{
    var url = "weights.php?action=del";
    url += "&w_id=" + w_id;
    
    if( tmp_results==null ) {
        alert("No hidden results container has been defined" );
    }
    else {
        tmp_results.load(url,function(data) {
            var res = tmp_results.html();
            
            if( res=="ERROR_WRONG_MEASURE_ID" ) {
                alert( "La medida con ID '"+w_id+"' no existe." );
            }
            else if( res=="NO_ERROR" ) {
                /** Everything went OK */
                updateWeightsView();
            }
            else{
                alert("Ha ocurrido un error inesperado: \n" + res );
            }
        });
    }
}
