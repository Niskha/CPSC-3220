<!Doctype html>
<html>
  <head>
    <link rel = "stylesheet" type ="text/css" href = "create_data.css">
    <title>Create Data</title>
  </head>
  <body>
    <h1>Data Generation</h1>
    <hr/>
    <?php
		/*File IO and data extraction
		5 different files and formats
		*/
		// $filetype = 0 for .txt and 1 for .csv
		function parseFile(string $filename, int $filetype, string $delimiter = "\r\n", string $homogenizer = Null){
			$parsedfile = array();
			// .txt file
			if($filetype == 0){
				$contents = file_get_contents($filename);
				$contents = trim($contents);
				if ($homogenizer != Null){
					$contents = str_replace($homogenizer,$delimiter,$contents);
				}
				$parsedfile = explode($delimiter,$contents);
				return $parsedfile;
			}
			// .csv file
			else if($filetype == 1){
				$file = fopen($filename,'r');
				$parsedfile = fgetcsv($file);
				fclose($file);
				return $parsedfile;
			}
			else return $parsedfile;
		}
		//domains.txt | "." is the deliminator
		$domains = parseFile("domains.txt", 0 , ".");
		
		//first_names.csv | excel spreadsheet
		$first_names = parseFile("first_names.csv", 1);

		//last_names.txt | newline is the delimiter
		$last_names = parseFile("last_names.txt",0,"\n");
		//get rid of that pesky \n
		foreach($last_names as $name){
			$last_names[] = trim($name);
		}
		
		
		//street_names.txt | ":" and newline is the delimiter
		$street_names = parseFile("street_names.txt",0,":","\r\n");
		
		//street_types.txt | "..;" is the delimiter\
		$street_types = parseFile("street_types.txt",0,"..;");
		
		//Make an array fixing the domain names in domains
		
		$domain = array();
		for($i = 0; $i < (count($domains)-1);$i+=2){
			$domain[] = "@".$domains[$i].".".$domains[$i+1];
		}
		
		//Make an array uniqueIdentity() that is all of the combinations of first_names and last_names.
		//this is no longer used 
		// $unique_identity = array();
		// foreach($first_names as $first){
			// foreach($last_names as $last){
				// $last = trim($last);
				// $unique_identity[] = $first." ".$last;	
			// }
		// }

		//Make an array uniqueAddress() that is all of the combinations of street_name and street_type.
		//this is no longer used
		// $unique_address = array();
		// foreach($street_names as $name){
			// foreach($street_types as $type){
				// $unique_address[] = $name." ".$type;
			// }
		// }
		
		/*Generate Random Array of People*/
		function generateCustomers(array $first_names, array $last_names, array $street_names, array $street_types, array $domain, int $amount){
			//this should make sure that there is never more requested unique customer generation than possible to generate.
			if(count($first_names) * count($last_names) < $amount){
				throw new Exception('Out of bounds. You requested more than can be generated.');
			}
			$customer = array();
			$index_pairs = array();
			$street_pairs = array();
			$count = 0;
			while ($count < $amount){
				//add first name and last name 
				$first_index = rand(0,count($first_names)-1);
				$last_index = rand(0,count($last_names)-1);
				$pair = [$first_index,$last_index];
				//add the elements without checking for uniqueness if there are no elements in the array
				if(($index_pairs == Null)){
					$index_pairs[] = $pair;
					$customer[0][] = $first_names[$first_index];
					$customer[1][] = $last_names[$last_index];
				}
				//this might not do anything, hard to check, but im not sure how its comparing the two arrays, it might just be taking the first elements. I wanted this to check the current index pair with the stored index pairs
				foreach($index_pairs as $pairs){
					if ($pair == $pairs){
						break;
					}
					else{
						$index_pairs[] = $pair;
						$customer[0][] = $first_names[$first_index];
						$customer[1][] = $last_names[$last_index];
					}
				}
				$street_index = rand(0,count($street_names)-1);
				$type_index = rand(0,count($street_types)-1);
				$street_pair = [$street_index,$type_index];
				//add the elements without checking for uniqueness if there are no elements in the array
				if(($street_pairs == Null)){
					$street_pairs[] = $street_pair;
					$customer[2][] = rand(0,9999)." ".$street_names[$street_index];
					$customer[3][] = $street_types[$type_index];
				}
				//this might not do anything, hard to check, but im not sure how its comparing the two arrays, it might just be taking the first elements. I wanted this to check the current index pair with the stored index pairs. 
				foreach($street_pairs as $pairs){
					if ($street_pair == $pairs){
						break;
					}
					else{
						$street_pairs[] = $pair;
						$customer[2][] = rand(0,9999)." ".$street_names[$street_index];
						$customer[3][] = $street_types[$type_index];
					}
				}
				
				$domain_index = rand(0,count($domain)-1);
				$customer[4][] = $first_names[$first_index].trim($last_names[$last_index]).$domain[$domain_index];
				
				$count = count($customer[0]);
			}
			return $customer;
		}
		$customer = array();
		try{
			$customer = generateCustomers($first_names,$last_names,$street_names,$street_types,$domain,2);
		} catch(Exception $e){
			echo "Exception: ".$e->getMessage();
		}
		echo var_dump($customer);
		
		
		/*Table Generation | generate randomized data for 25 people, people must be unique 
		and address must be unique*/
		// Print a heading above each array | use the pre tag and utilize print_r() for element generation
		
		//heading table
		 echo "<table class = 'header_table'><tr><th>First Name</th><th>Last Name</th><th>Address</th><th>Email</th></tr></table><hr/>";
		
			
		
		/*Export Data to customers.txt | 
		Format: first_name:last_name:street_name + street_type:email(domains + '.com') | deliminator is ':'
		*/
		$customers_txt = fopen("customers.txt","w");
		for($i = 0; $i < count($customer[0]);$i++){
			$txt = $customer[0][$i].":".$customer[1][$i].":".$customer[2][$i]." ".$customer[3][$i].":".$customer[4][$i];
			fwrite($customers_txt,$txt);
			fwrite($customers_txt,"\n");
		}
		fclose($customers_txt);
    ?>
  </body>
</html>
