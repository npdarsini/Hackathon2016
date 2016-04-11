<!DOCTYPE html>
<html>
<body>

<?php
 
$button = $_GET ['submit'];
$search = $_GET ['search']; 
$x =0;
$count =0;
if(!$button)
echo "you didn't submit a keyword";
else
{
if(strlen($search)<=1)
echo "Search term too short";
else{
echo "You searched for <b>$search</b> <hr size='1'></br>";

$dbcon=mysqli_connect("localhost","root","code");  
mysqli_select_db($dbcon,"db1"); 


$search_exploded = explode (" ", $search);
 
foreach($search_exploded as $search_each)
{
$x++;
if($x==1)
$construct =mysqli_real_escape_string($dbcon, $search_each);
else
$construct =mysqli_real_escape_string($dbcon, $search_each);
 
}

 //echo "$construct";
$construct1 ="SELECT * FROM entityextraction WHERE entity LIKE '%$construct%'";


$result = mysqli_query($dbcon, $construct1);

/*if ($result)
{
	echo "Success";
}

else {
	echo "Fail";
}
*/
$construct2 ="SELECT count(*) FROM entityextraction WHERE entity ='$construct'";


$result1 = mysqli_query($dbcon, $construct2);


//echo "Affected rows: " . mysqli_affected_rows($dbcon);
$output = mysqli_affected_rows($dbcon);
//echo "$output";
//$output = mysqli_result($result,0);
			
//$foundnum = mysqli_num_rows($output);

$foundnum = $output;

//echo "$foundnum";
 
if ($foundnum > 0)
{
	//echo "$foundnum results found !<p>";

while($runrows = mysqli_fetch_assoc($result))
{
$type = $runrows ['type'];
$relevance = $runrows ['relevance'];
$sentiment = $runrows ['sentiment'];

$count++;
}
}
else
{
	
	echo "Sorry, there are no matching result for <b>$search</b>.</br></br>1. 
Try more general words. for example: If you want to search 'how to create a website'
then use general keyword like 'create' 'website'</br>2. Try different words with similar
 meaning</br>3. Please check your spelling";
 
 

}
 
}


echo "<br><b>$search</b>";
echo " is found ". $count. " times";

echo "<br><b>$search</b>";
echo " is of type "."<b>".$type."</b>";
echo " with the <b>relevance</b> of " ."<b>".$relevance. "</b>";
echo " which hold the <b>sentiment</b> of ". "<b>".$sentiment."</b>" ;

}

?>

</body>
</html>