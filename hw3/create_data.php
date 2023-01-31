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
		
		//Make an array fixing the domain names in domains
		$domain = array();
		for($i = 0; $i < (count($domains)-1);$i+=2){
			$domain[] = "@".$domains[$i].".".$domains[$i+1];
		}
		
		//first_names.csv | excel spreadsheet
		$first_names = parseFile("first_names.csv", 1);
		//last_names.txt | newline is the delimiter
		$last_names = parseFile("last_names.txt",0,"\n");
		//street_names.txt | ":" and newline is the delimiter
		$street_names = parseFile("street_names.txt",0,":","\r\n");
		//street_types.txt | "..;" is the delimiter\
		$street_types = parseFile("street_types.txt",0,"..;");
		
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
			while ($count <= $amount){
				//add first name and last name 
				$first_index = rand(0,count($first_names)-1);
				$last_index = rand(0,count($last_names)-1);

				$customer[0][] = $first_names[$first_index];
				$customer[1][] = $last_names[$last_index];

				$street_index = rand(0,count($street_names)-1);
				$type_index = rand(0,count($street_types)-1);
				
				$customer[2][] = rand(0,9999)." ".$street_names[$street_index];
				$customer[3][] = $street_types[$type_index];
			
				$domain_index = rand(0,count($domain)-1);
				$customer[4][] = $first_names[$first_index].trim($last_names[$last_index]).$domain[$domain_index];
				
				$count = count($customer[0]);
			}
			return $customer;
		}
		
		$customer = array();
		try{
			$customer = generateCustomers($first_names,$last_names,$street_names,$street_types,$domain,25);
		} catch(Exception $e){
			echo "Exception: ".$e->getMessage();
		}
		
		/*Table Generation | generate randomized data for 25 people, people must be unique 
		and address must be unique*/
		//print each raw array. Print a heading above each array | use the pre tag and utilize print_r() for element generation
		
		//heading table
		echo "<table class = 'data-table'><tr><th>First Name</th><th>Last Name</th><th>Address</th><th>Email</th></tr>";
		for($i = 0; $i < count($customer[0])-1;$i++){
			echo "<tr><td>".$customer[0][$i]."</td><td>".$customer[1][$i]."</td><td>".$customer[2][$i]." ".$customer[3][$i]."</td><td>".$customer[4][$i]."</td></tr>";
		}
		echo "</table>";
		
		/*Export Data to customers.txt | 
		Format: first_name:last_name:street_name + street_type:email(domains + '.com') | deliminator is ':'
		*/
		$customers_txt = fopen("customers.txt","w");
		for($i = 0; $i < count($customer[0])-1;$i++){
			$txt = $customer[0][$i].":".trim($customer[1][$i]).":".$customer[2][$i]." ".$customer[3][$i].":".$customer[4][$i];
			fwrite($customers_txt,$txt);
			fwrite($customers_txt,"\n");
		}
		fclose($customers_txt);
		echo "<pre>First Names</pre>";
		echo print_r($first_names);
		echo "<pre>Last Names</pre>";
		echo print_r($last_names);
		echo "<pre>Street Names</pre>";
		echo print_r($street_names);
		echo "<pre>Street Types</pre>";
		echo print_r($street_types);
		echo "<pre>Domains</pre>";
		echo print_r($domain);
    ?>
  </body>
</html>
