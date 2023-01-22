<!Doctype html>
<html>
	<head>
		<title> Generate Array </title>
		<link rel="icon" type="image/x-icon" href="rainbow-cat.gif"/>
		<link rel="stylesheet" type="text/css" href = "arrayDemo.css"/>
		
		<style>
		td.1{
			width: 100px;
			text-align: center;
		}
		
		</style>
	</head>
	<body>
		<h1><a href = "arrayDemo.html"><img src= "rolling-cat-3.gif" alt="rolling cat" style="float:left;width:42px;height:42px;padding-right:25px"></a>Generate Array</h1>
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
				//create an empty array
				$array = array();
				//fill the array with random numbers based on user specifications. This makes a 2d array.
				for($x = 0; $x < ($numRow);$x++){
					for($xx = 0; $xx < ($numCol); $xx++){
						$array[$x][$xx] = rand($minRan,$maxRan);
					}
				}
				echo "<hr/>";
				/* 	
					This function uses the ForEach construct to build 
					a table in html. The function takes an array as input.
					It does not rely on any variables to build the table.
				*/
				function tableForE($arr = array()){
					static $idCount = 0;
					echo "<table style='border-collapse:collapse; border:1px solid black'><tr>";
					foreach ($arr as $row){
						foreach($row as $element){
							echo "<td class = --".$idCount.">".$element."</td>";
						}
						echo "</tr>";
					}
					echo "</table>";
					$idCount++;
				}
				/*	
					This function should take two arrays, rowNum, colNum, and alternate the rows of the arrays
					and build a table.
				
				*/
				function tableAlt($arr = array(), $arr2 = array(), $numRow = int, $numCol = int){
					echo "<table>";
					for($row = 0;$row < $numRow; $row++){
						echo "<tr>";
						for($col = 0; $col < $numCol; $col++){
							echo "<td>".$arr[$row][$col]."</td>";
						}
						echo "</tr><tr>";
						for($col = 0; $col < $numCol; $col++){
							echo "<td>".$arr2[$row][$col]."</td>";
							
						}
						echo "</tr>";
					}
					echo "</table>";
				}
				// call the table function to build a table.
				echo tableForE($array);
				echo "<hr/>";
				
				//process data --> row|sum of row|average of row|std dev of row
				function processData($arr = array()){
					//final data
					$finalData = array();
					//counter for data arrays
					$i = 0;
					//counter for arrays in std dev
					$c = 0;
					foreach ($arr as $row){
						$rowSum = 0;
						$count = 0;
						$mean = 0;
						$meanData = array();
						//calculate the sum of the row elements
						foreach($row as $element){
							$count += 1;
							$rowSum += $element;
							
						}
						//calculate the average
						$rowAvg[$i] = $rowSum / $count;
						//variance calculation
						foreach ($row as $element2){
							
							$meanData[$c] = pow($element2 - $rowAvg[$i],2);
							$c++;
						}
						//calculate the mean of the variance values
						foreach ($meanData as $value){
							$mean += $value; 
						}
						//final std deviation value per row
						$stdDev[$i]= sqrt($mean/$count);
						
						//Add all data points into an array
						$finalData[$i] = (
						
							array($i, $rowSum, number_format($rowAvg[$i],3), number_format($stdDev[$i],3))
						);
						$i++;
					}
					return $finalData;
				}
				//table 2 headers
				echo "<table><tr><th style ='width:100px; text-align: center;'>Row</th><th style = 'width:100px; text-align: center;'>Sum</th><th style = 'width:100px; text-align: center;'>Average</th><th style = 'width:100px; text-align: center;'>Standard Dev.</th></tr></table>";
				echo tableForE(processData($array));
				echo "<hr/>";
				//table 3 data
				$arrayThree = array();
				for($i = 0; $i < $numRow; $i++){
					$j = 0;
					foreach ($array[$i] as $element){
						
						if ($element > 0){
							$arrayThree[$i][$j] = "Positive";
							
							$j++;
						}
						elseif($element < 0){
							$arrayThree[$i][$j] = "Negative";
							
							$j++;
						}
						else{
							$arrayThree[$i][$j] = "Zero";
							
							$j++;
						}
					}
				}
				//table 3 formatting
				tableAlt($array,$arrayThree,$numRow,$numCol);
		?>
		<hr/>
		<!--This is a simple back button to return to the user input page.-->
		<a href="arrayDemo.html"><button style = "border: none; background-color: grey;">Return to inputs.</button></a>
	</body>
</html>