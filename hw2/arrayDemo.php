<!Doctype html>
<html>
	<head>
		<title> Generate Array </title>
		<link rel="icon" type="image/x-icon" href="rainbow-cat.gif"/>
		<link rel="stylesheet" type="text/css" href = "arrayDemo.css"/>
	</head>
	<body>
		<h1><img src= "rolling-cat-3.gif" alt="rolling cat" style="float:left;width:42px;height:42px;padding-right:25px">Generate Array</h1>
		<hr/>
		<?php
				// get the data from the user
				$numRow = $_POST['rows'];
				$numCol = $_POST['cols'];
				$minRan = $_POST['minRan'];
				$maxRan = $_POST['maxRan'];
				//give the user somefeedback about that data
				echo 'Your array size is: ' .$numRow;
				echo 'x'.$numCol, "<br/>";
				echo 'Your min value is: ' .$minRan,"<br/>";
				echo 'Your max value is: ' .$maxRan,"<br/>";
				echo "<hr/>";
				//create an empty array
				$array = array();
				//fill the array with random numbers based on user specifications. This makes a 2d array.
				for($x = 0; $x < ($numRow);$x++){
					for($xx = 0; $xx < ($numCol); $xx++){
						$array[$x][$xx] = rand($minRan,$maxRan);
						//this is test code ---delete---
						echo $array[$x][$xx].", ";
					}
				}
				echo "<hr/>";
				/* 	
					This function uses the ForEach construct to build 
					a table in html. The function takes an array as input.
					It does not rely on any variables to build the table.
				*/
				function tableForE($arr = array()){
					echo "<table style='border-collapse:collapse; border:1px solid black'><tr>";
					foreach ($arr as $row){
						foreach($row as $element){
							echo "<td>".$element."</td>";
						}
						echo "</tr>";
					}
					echo "</table>";
				}
				/*	
					This function is not fully implemented. 
					It builds an html table from an array using for loops and is mostly irrelevent.
					It directly builds the table using set variables which may cause issues with some arrays.
				*/
				function table($arr = array()){
					echo "<table style='border-collapse:collapse; border:1px solid black'>";
					for($row = 0;$row < $numRow; $row++){
						echo "<tr>";
						for($col = 0; $col < $numCol; $col++){
							echo "<td>".$arr[$row][$col]."</td>";
						}
						echo "</tr>";
					}
				}
				// call the table function to build a table.
				echo tableForE($array);
				echo "<hr/>";
				
				//process data --> row|sum of row|average of row|std dev of row
				function processData($arr = array()){
					$i = 0;
					$c = 0;
					foreach ($arr as $row){
						$rowSum = 0;
						$count = 0;
						
						foreach($row as $element){
							$count += 1;
							$rowSum += $element;
							
						}
						$rowAvg[$i] = $rowSum / $count;
						//std dev
						
						foreach ($row as $element2){
							
							$meanData[$c] = pow($element2 - $rowAvg[$i],2);
							echo $meanData[$c];
							$c++;
						}
						
						
						//tester code ---delete---
						echo "Row #: ".$i." Row sum: ".$rowSum." Row Avg: ".number_format($rowAvg[$i],3). "<br/>";
						$i++;
					}
					
				}
				processData($array);
		?>
		<hr/>
		<!--This is a simple back button to return to the user input page.-->
		<a href="arrayDemo.html"><p>Return to inputs.</p></a>
	</body>
</html>




















































