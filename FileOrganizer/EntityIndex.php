
<html>
<body>


<?php

require_once('alchemyapi.php');
	$alchemyapi = new AlchemyAPI();
	$myfile = fopen("newfile.txt", "r") or die("Unable to open file");
	
	$test_text = fread($myfile,filesize("newfile.txt"));
	//$test_text = 'Bob broke my heart, and then made up this silly sentence to test the PHP SDK';  
	$test_html = '<html><head><title>The best SDK Test | AlchemyAPI</title></head><body><h1>Hello World!</h1><p>My favorite language is PHP</p></body></html>';
	$test_url = 'http://www.nytimes.com/2013/07/13/us/politics/a-day-of-friction-notable-even-for-a-fractious-congress.html?_r=0';
	$var = '\n';
	
echo ("Checking entities . . . ");
echo '<br>';

	$response = $alchemyapi->entities('text', $test_text, array('sentiment'=>1));
	
	if ($response['status'] == 'OK') {
		//echo ("## Response Object ##". PHP_EOL);
		//echo print_r($response);

		echo PHP_EOL;
		echo " <b>Insights with in the document</b> ";
		echo '<br>';
		foreach ($response['entities'] as $entity) 
		{
			$dbcon=mysqli_connect("localhost","root","code");  
			mysqli_select_db($dbcon,'db1');  
			
			
			echo ' <br><b>Entity: </b>', $entity['text'];
			
			$EntityText = mysqli_real_escape_string($dbcon, $entity['text']);
			//echo print_r($var);
			echo ' <b>Type: </b> ', $entity['type'];
			$EntityType = mysqli_real_escape_string($dbcon, $entity['type']);
			
			echo '<b> Relevance:</b> ', $entity['relevance'];
			$ERelevance = mysqli_real_escape_string($dbcon, $entity['relevance']);
			
			echo '<b> Sentiment: </b> ', $entity['sentiment']['type']; 
			$ESentiment = mysqli_real_escape_string($dbcon, $entity['sentiment']['type']);
						
			if (array_key_exists('score', $entity['sentiment'])) {
				echo ' (' . $entity['sentiment']['score'] . ')';
			} else {
				echo PHP_EOL;
			}
			
			$sql= "INSERT INTO entityextraction". "(entity,type,relevance,sentiment) "."VALUES ('$EntityText','$EntityType','$ERelevance','$ESentiment')";
			
		   
			   
			if (mysqli_query($dbcon, $sql)) {
				echo "New record created successfully";
			}
			else {
				echo "Error: " . $sql . "<br>" . mysqli_error($dbcon);
			}		

			
						
            //$retval = mysqli_query($dbcon, $sql );
			
			//$retval = mysql_db_query($sql, $dbcon );
			
               
            //echo "Entered data successfully\n";
            
            mysqli_close($dbcon);

				
			echo PHP_EOL;
		}
	} else {
		echo 'Error in the entity extraction call: ', $response['statusInfo'];
	}
fclose($myfile);
include ("SearchIndex.php");
	
	?>
	
</body>
</html>
