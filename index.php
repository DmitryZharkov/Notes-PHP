  <!DOCTYPE html>
<head>
  <link rel="stylesheet" href="index.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>

<?php
session_start();

$SearchString = "";
$table = "Notes";

if( isset($_POST['SearchString']) )
{
     $SearchString = $_POST['SearchString'];
}

require_once('connection.php');

if ($conn->select_db('Notes') === false) {

    // Create db

$sql = "CREATE DATABASE Notes";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully";
} else {
    echo "Error creating database: " . $conn->error;
}

}
else
{
//echo "database exist";
}

$conn->select_db('Notes');

//----------- Check if Notes table exist and create

$result = $conn->query("SHOW TABLES LIKE '".$table."'");

    if($result->num_rows == 1) {
        //echo "Table exists";
    }

else {
    echo "office Table does not exist";
$sql = "CREATE TABLE Notes (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
text BLOB NOT NULL,
icon BLOB NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Table Notes created successfully";
} else {
    echo "Error creating table Notes: " . $conn->error;
}


}

?>

<body onload="showNotes()">

<div id="home" style="right:50%; margin: 1% auto;">
<a href="index.php" class="btn-primary btn-sm">Home</a>
</div>

<div style="margin-left:40%;">
<h1>Notes</h1>

 <button class="btn btn-primary btn-md" onclick=window.location.replace("newnote.htm")>New note</button>


<form style="margin: 1% auto;" action="index.php" method="post">
            <p>
                Search: <input type="text" name="SearchString" />
                <input class="btn btn-primary btn-sm" type="submit" value="Go" />
            </p>
</form>
</div>

<div id="notetable">
</div>


<div style="margin: 1% auto; text-align: center;" id="notepage" style="display:none">
</div>

<div style="right:50%; margin: 1% auto;">
<span style="margin-left:40%;" id="sorttitle" >Sort by </span>
 <select id="sortsel" class="btn-primary btn-sm" onchange="SortChanged();">
  <option value="id">Id</option>
  <option value="text">Text</option>
</select>
</div>

<script>

 function showNotes()
{
sort=$("#sortsel").val();
SearchString = "<?php echo $SearchString ?>";$("#notepage").empty();$("#notepage").empty();
$("#sortsel").hide();$("#sorttitle").hide();

$.get("getnotes.php",{off:0, sort:sort, SearchString:SearchString }, function(data, status){
      var res= JSON.parse(data);
	  //if (data== "0 results"){alert(res.length);}

     $("#notetable").empty();$("#notetable").show();
	//$("#notetable").append("<h3>Notes</h3>");
     var tab="<table class=\"table table-striped table-hover\" style=\"text-align: center\"><tr><th style=\"text-align: center\">Id</th><th style=\"text-align: center\">Icon</th><th style=\"text-align: center\">Text</th></tr>";
     
       if( res.length!=0){
       for(i=0;i<res.length-1;i++)
       {
       tab +="<tr><td style=\"width:1%; height:1%;\">"+res[i].data.id+"</td>"+"<td style=\"width:1%; height:1%;\">"+res[i].data.icon+"</td>"+"<td>"+res[i].data.text.slice(0, 50)+"</td>"+"<td> <a href=\"Viewnote.php?id="+res[i].data.id+"\">View</a> / <a href=\"deletenote.php?id="+res[i].data.id+"\">Delete</a> / <a href=\"editnote.php?id="+res[i].data.id+"\">Edit</a></td>"+"<tr>";
        }
        tab+= "</table>";
        $("#notetable").append(tab);
		if ( res.length!=2){
         $("#sortsel").show();$("#sorttitle").show();}

         if(res[res.length-1].data.total>10){
         var page=res[res.length-1].data.total/10;
         $("#notepage").empty();
         $("#notepage").show();
         var notepage="<ul class=\"pagination pagination-lg\">";
         for(i=0;i<page;i++)
         {
            notepage+="<li class=\"page-item\"><a class=\"page-link\" onclick=RefreshTable("+i+")>"+(i+1)+"</a></li>";
         }
         notepage+="</ul>";
         $("#notepage").append(notepage);
         }
        }
		else
		{//alert(SearchString);
		if(SearchString){
		$("#notetable").append("<p style=\"text-align:center;\">No results.</p>");$("#notetable").show();
		}	
		}
		
    });
}

function RefreshTable(page,id){
    sort=$("#sortsel").val();
   $("#notetable").empty(); $("#sortsel").hide();$("#sorttitle").show();
   $.get("getnotes.php",{ off:page*10, sort:sort, SearchString:SearchString }, function(data, status){
      var res= JSON.parse(data);

     $("#notetable").empty();//$("#notetable").append("<h3>Notes</h3>");
     var tab="<table class=\"table table-striped table-hover\" style=\"text-align: center\"><tr><th style=\"text-align: center\">Id</th><th style=\"text-align: center\">Icon</th><th style=\"text-align: center\">Text</th></tr>";

       if( res.length!=0){
       for(i=0;i<res.length-1;i++)
       {
       tab +="<tr><td style=\"width:1%; height:1%;\">"+res[i].data.id+"</td>"+"<td style=\"width:1%; height:1%;\">"+res[i].data.icon+"</td>"+"<td>"+res[i].data.text.slice(0, 50)+"</td>"+"<td> <a href=\"Viewnote.php?id="+res[i].data.id+"\">View</a> / <a href=\"deletenote.php?id="+res[i].data.id+"\">Delete</a> / <a href=\"editnote.php?id="+res[i].data.id+"\">Edit</a></td>"+"<tr>";
        }
        tab+= "</table>";
        $("#notetable").append(tab);
         $("#sortsel").show();$("#sorttitle").show();

        }
    });
   }

function SortChanged(){

showNotes();
   }

</script>

</body>
</html>