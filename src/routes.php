<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

include 'persons.php';

$app->get('/', function (Request $request, Response $response, $args) {
    // Render index view
    return $this->view->render($response, 'index.latte');
})->setName('index');

$app->post('/test', function (Request $request, Response $response, $args) {
    //read POST data
    $input = $request->getParsedBody();

    //log
    $this->logger->info('Your name: ' . $input['person']);

    return $response->withHeader('Location', $this->router->pathFor('index'));
})->setName('redir');


// Vypis osob

$app->get('/persons', function (Request $request, Response $response, $args){
     $page = $request->getQueryParam('page');
     #if (!page){ $page=0; };
     $pocet = $this->db->query('SELECT count(*) FROM person');
     $stmt = $this->db->prepare('SELECT * FROM person ORDER BY first_name LIMIT 10 OFFSET :page');                
     $stmt->bindParam(':page',$page); 
     $stmt->execute();
     $tplVars['persons'] = $stmt->fetchAll();    
     $tplVars['pocet'] = $pocet->fetch()['count'];
     return $this->view->render($response, 'persons.latte', $tplVars);
        })->setName('persons');
        
 
 //Vyhledavani osob
 
 $app->post('/search', function (Request $request, Response $response, $args){
    $input = $request->getParsedBody();
    if (!empty($input)) {
        $stmt = $this->db->prepare('SELECT * FROM person WHERE LOWER(first_name) = LOWER(:fname)');
        $stmt ->bindParam("fname", $input['person_name']);
        $stmt->execute();
        $tplVars['persons'] = $stmt->fetchAll();
        return $this->view->render($response, 'persons.latte', $tplVars);
        
    }
 })->setName('search');     
 
 
 
 //Formular pro pridani nove osoby
 
 $app->get('/persons/new', function (Request $request, Response $response, $args){
            $tplVars['formData'] = [
                'first_name' => '',
                'last_name' => '',
                'nickname' => '',
                'id_location' => null,
                'gender' => '',
                'height' => '',
                'birth_day' => '',  
                'city' =>'',
                'street_number' => '',
                'street_name' =>'',
                'zip' => ''                            
            ];
            
           return $this->view->render($response, 'newPerson.latte', $tplVars);   
           })->setName('newPerson'); 
           
           
           
//Obsluha formulare pro novou osobu 
 
  $app->post('/persons/new', function (Request $request, Response $response, $args){
           $formData = $request->getParsedBody();
           if (empty($formData['first_name']) || empty($formData['last_name']) || empty($formData['nickname'])){
            $tplVars['message'] = "Please fill required fields";             
           } else {
            try  {    
            insert_person($this->db, $formData);              
           $tplVars['message'] = "Person succefully added";        
        } catch (PDOException $e) {
            $tplVars['message'] = "Error occured " . $e->getMessage();
        }
     }
     $tplVars['formData']=$formData;
     return $this->view->render($response, 'newPerson.latte', $tplVars);
 
 });
 
 
      //nastroj pro upravu osoby
 
 $app->get('/persons/update',   function (Request $request, Response $response, $args){
    $params = $request->getQueryParams(); //zISKA VSEchny parametry z url 
    if (empty($params['id_person'])){
        exit('id person is missing');
    } else {
        $stmt = $this->db->prepare("SELECT * FROM person FULL OUTER JOIN location USING (id_location) WHERE id_person = :id_person");
        $stmt->bindValue(':id_person',$params['id_person']);   //Smaze vsechny znaky, ktere by mohly byt nejaky kod 
        $stmt->execute();
        $tplVars['formData'] = $stmt->fetch();
        if (empty($tplVars['formData'])){
            exit('person not found');
        } else {
            return $this->view->render($response, 'updatePerson.latte', $tplVars);
       }           
    }                
 })->setName('person_update');
 
 
          
   //Obsluha edit tlacitka
$app->post('/persons/update',   function (Request $request, Response $response, $args){
    $formData = $request->getParsedBody();
    $id_person = $request->getQueryParam('id_person'); //Ziska jeden parametr 
    if (empty($formData['first_name']) || empty($formData['last_name']) || empty($formData['nickname']) || empty($id_person)){
    $tplVars['message'] = 'Please fill required fields';
    } else { 
    try {
        $stmt = $this->db->prepare("UPDATE person SET 
                            first_name = :fn,
                            last_name = :ln,
                            nickname = :nn,
                            birth_day= :bd,
                            gender = :gn,
                            height = :hg
                         WHERE id_person = :idp");
        $stmt->bindValue(":fn", $formData['first_name']);  
        $stmt->bindValue(":ln", $formData['last_name']);  
        $stmt->bindValue(":nn", $formData['nickname']);  
        $stmt->bindValue(":bd", $formData['birth_day']);  
        $stmt->bindValue(":gn", $formData['gender']);  
        $stmt->bindValue(":hg", $formData['height']);
        $stmt->bindValue(":idp", $id_person);    
        $stmt->execute();                  
    
    } catch (PDOexception $e) {
        $tplVars['message'] = 'Error occured ' . $e->getMessage();
    }           
    
    
    }
    $tplVars['message']="Person updated";
    $tplVars['formData'] = $formData;  
     return $this->view->render($response, 'updatePerson.latte', $tplVars);
    
    
    


});


//Vypsani osob s adresou
$app->get('/percon', function (Request $request, Response $response, $args){
     
     $stmt = $this->db->query("SELECT first_name, last_name, TO_CHAR(birth_day :: DATE, 'dd/mm/yyyy') as birth_day, concat(city,' ',street_name,' ',street_number) as place FROM person
                               FULL OUTER JOIN location USING (id_location) 
                               ORDER BY first_name");   
     $tplVars['percon'] = $stmt->fetchAll();    
     return $this->view->render($response, 'percon.latte', $tplVars);
        })->setName('person_address');
        
        
        
        
//Vypsani lokaci a meetingu

$app->get('/meetings', function (Request $request, Response $response, $args){

    $stmt = $this->db->query("SELECT TO_CHAR(start :: DATE, 'dd/mm/yyyy') as date,concat(city,' ',street_name,' ',street_number) as place,
                              description, duration 
                              FROM meeting FULL OUTER JOIN location USING(id_location)");
    $tplVars['meetings'] = $stmt->fetchAll();
    return $this->view->render($response,'meetings.latte',$tplVars);                          

})->setName('meeting');

$app->post('/persons/delete', function (Request $request, Response $response, $args){
     $id_person = $request->getQueryParam('id_person');
     if (!empty($id_person)){
        try {
             delete_person($this->db,$id_person);
        } catch(PDOexception $e){
        $tplVars['message']='Error : '  . $e->getMessage();
        }
     
     } else {
        exit('Id_person missing');
     }
     
     return $response->withHeader('location', $this->router->pathFor('persons'));

})->setName('person_delete');


$app->get('/add-contact', function (Request $request, Response $response, $args) {
	    $tplVars["id"]=$request->getQueryParam('id');
		    $id=$request->getQueryParam("id");


    try {
$stmt = $this->db->prepare('SELECT * FROM contact_type');
        $stmt->execute();
        $tplVars['type'] = $stmt->fetchAll();
		    } catch (Exception $e) {
        $this->logger->error($e->getMessage());
        die($e->getMessage());
    }    
	
	try {
        $stmt = $this->db->prepare('SELECT * FROM contact
JOIN contact_type 
on (contact_type.id_contact_type=contact.id_contact_type)
WHERE id_person = :id');
        $stmt->bindValue(':id', $tplVars['id']);
        $stmt->execute();
        $tplVars['contact'] = $stmt->fetchAll();
		    } catch (Exception $e) {
        $this->logger->error($e->getMessage());
        die($e->getMessage());
    }
	
    return $this->view->render($response, 'add-contact.latte', $tplVars);
})->setName('addContact');

$app->post('/add-contact', function (Request $request, Response $response, $args) {
		
		    $tplVars['id_person']=$request->getQueryParam('id_person');	
			    $data=$request->getParsedBody();
				
				if($data["id_contact"]!=""){
				try{	
				$stmt = $this->db->prepare('DELETE FROM contact WHERE id_contact = :id');
				$stmt->bindValue(':id', $data["id_contact"]);
				$stmt->execute();
				    } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            die($e->getMessage());
    }	
				}else{
					
					  try {
        $stmt = $this->db->prepare('INSERT INTO contact 
        ( id_person, id_contact_type, contact)
              VALUES ( :i, :c, :co);');
			  
		$stmt->bindValue(':co', $data["c"]);
        $stmt->bindValue(':i', $tplVars['id_person']);
        $stmt->bindValue(':c', $data["type"]);
    

        $stmt->execute();

    } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            die($e->getMessage());
    }
					
				}

	
    return $response->withHeader('Location',
        $this->router->pathFor("persons"));
});

$app->get('/add-meeting', function (Request $request, Response $response, $args) {
 try {
        $stmt = $this->db->prepare('SELECT * FROM location');
        $stmt->execute();
        $tplVars['m'] = $stmt->fetchAll();
	    } catch (Exception $e) {
        $this->logger->error($e->getMessage());
        die($e->getMessage());
    }	
	 try {
        $stmt = $this->db->prepare('SELECT * FROM meeting');
        $stmt->execute();
        $tplVars['meetings'] = $stmt->fetchAll();
	    } catch (Exception $e) {
        $this->logger->error($e->getMessage());
        die($e->getMessage());
    }

    return $this->view->render($response, 'add-meeting.latte', $tplVars);
})->setName('addMeeting');

$app->post('/del-meeting', function (Request $request, Response $response, $args) {
		    $data=$request->getParsedBody();
		try{		
				$stmt = $this->db->prepare('DELETE FROM person_meeting WHERE id_meeting = :id');
				$stmt->bindValue(':id', $data["id_meeting"]);
				$stmt->execute();
		    } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            die($e->getMessage());
    }		
				try{
				$stmt = $this->db->prepare('DELETE FROM meeting WHERE id_meeting = :id');
				$stmt->bindValue(':id', $data["id_meeting"]);
				$stmt->execute();
	    } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            die($e->getMessage());
    }
    return $response->withHeader('Location',
        $this->router->pathFor("addMeeting"));
})->setName('deleteMeeting');

$app->post('/new-meeting', function (Request $request, Response $response, $args) {
		    $data=$request->getParsedBody();
				
    try {
        $stmt = $this->db->prepare('INSERT INTO meeting(start, description, duration, id_location)
              VALUES (:z, :d, :de, :idl);');   


        $stmt->bindValue(':z', $data["z"]);  
        $stmt->bindValue(':d', $data["d"]);    
        $stmt->bindValue(':de', $data["de"]);  
        $stmt->bindValue(':idl', empty($data['m']) ? null : intval($data['m']));   
        $stmt->execute();

    } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            die($e->getMessage());
    }
	
    return $response->withHeader('Location',
        $this->router->pathFor("addMeeting"));
})->setName('newMeeting');

//Prida meeeting k person
$app->get('/add-meeting-to-person', function (Request $request, Response $response, $args) {
	    $id=$request->getQueryParam("id");
	    $tplVars['id']=$request->getQueryParam("id");



    try {

   $stmt = $this->db->prepare('select id_meeting, description, start from meeting except SELECT id_meeting, description, start FROM person_meeting natural join meeting where id_person = :id');
   		$stmt->bindValue(':id', $id);
    $stmt->execute();
    $tplVars['m'] = $stmt->fetchAll();  

$stmt = $this->db->prepare('SELECT * FROM person
JOIN person_meeting USING (id_person)
JOIN meeting USING (id_meeting)
WHERE id_person = :id');
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $tplVars['meetings'] = $stmt->fetchAll();

    } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            die($e->getMessage());
    }

    return $this->view->render($response, 'add-meeting-to-person.latte', $tplVars);
})->setName('addMeetingToPerson');

//Smaze meetiing od osoby
$app->post('/delete-meeting-to-person', function (Request $request, Response $response, $args) {
	    $id=$request->getQueryParam("id");

		$data=$request->getParsedBody();

   try {

        $stmt = $this->db->prepare('DELETE FROM person_meeting WHERE id_meeting = :id and id_person = :id2');
        $stmt->bindValue(':id', $data['id_meeting']);
        $stmt->bindValue(':id2', $data['id_person']);
        $stmt->execute();

    } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            die($e->getMessage());
    }
    return $response->withHeader('Location',
        $this->router->pathFor("persons"));
})->setName('deleteMeetingToPerson');


//Prida novou schuzku person
$app->post('/new-meeting-to-person', function (Request $request, Response $response, $args) {
	    $id=$request->getQueryParam("id");

		$data=$request->getParsedBody();
    try {

        $stmt = $this->db->prepare("INSERT INTO  person_meeting (id_person, id_meeting) VALUES (:i, :i2)");
        $stmt->bindValue(':i', $data['id_person']);
        $stmt->bindValue(':i2', $data['m']);
        $stmt->execute();

    } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            die($e->getMessage());
    }
    return $response->withHeader('Location',
        $this->router->pathFor("persons"));
})->setName('newMeetingToPerson');

//Vypise relace
$app->get('/relation', function (Request $request, Response $response, $args) {

 $id=$request->getQueryParam("id");
 $tplVars['id']=$request->getQueryParam("id");
try{
        $stmt = $this->db->prepare("SELECT * FROM person join relation on relation.id_person2 = person.id_person natural join relation_type where id_person1 = :i");
        $stmt->bindValue(':i', $id);
        $stmt->execute();
		$tplVars['r'] = $stmt->fetchAll();
	    } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            die($e->getMessage());
    }
	try{
	    $stmt = $this->db->prepare("SELECT * FROM relation_type");
        $stmt->execute();
		$tplVars['m'] = $stmt->fetchAll();	  
    } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            die($e->getMessage());
    }
	try{
		
		$stmt = $this->db->prepare("select id_person, nickname from person except SELECT id_person, nickname FROM relation join person on id_person2=id_person where id_person1=:i");
		$stmt->bindValue(':i', $id);
        $stmt->execute();
		$tplVars['pe'] = $stmt->fetchAll();
	    } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            die($e->getMessage());
    }
    return $this->view->render($response, 'relation.latte', $tplVars);
})->setName('relation');

//Editace relace
$app->post('/edit-relation', function (Request $request, Response $response, $args) {
$id=$request->getQueryParam("id");

try{


		$data=$request->getParsedBody();
        $stmt = $this->db->prepare("UPDATE relation SET id_relation_type = :t WHERE id_relation=:i;");
        $stmt->bindValue(':i', $data["id_relation"]);
        $stmt->bindValue(':t', $data["t"]);
        $stmt->execute();
    } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            die($e->getMessage());
    }
	
    return $response->withHeader('Location',
        $this->router->pathFor("persons"));
})->setName('editRelation');

//smaze relaci/vztah          
$app->post('/delete-relation', function (Request $request, Response $response, $args) {
$id=$request->getQueryParam("id");

try{
			    $data=$request->getParsedBody();
        $stmt = $this->db->prepare("delete from relation WHERE id_relation=:i;");
        $stmt->bindValue(':i', $data["id_relation"]);
        $stmt->execute();
    } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            die($e->getMessage());
    }
	
    return $response->withHeader('Location',
        $this->router->pathFor("index"));
})->setName('deleteRelation');

//Prida meeting k dane osobe dle id person
$app->post('/add-relation-to-person', function (Request $request, Response $response, $args) {
$id=$request->getQueryParam("id");
try{
		$data=$request->getParsedBody();
        $stmt = $this->db->prepare("INSERT INTO relation (id_person1, id_person2, description,id_relation_type) VALUES (:id, :id2, :d, :t);");
        $stmt->bindValue(':id', $data["id"]);
        $stmt->bindValue(':d', $data["d"]);
        $stmt->bindValue(':id2', $data["pe"]);
        $stmt->bindValue(':t', $data["t"]);
        $stmt->execute();

    } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            die($e->getMessage());
    }
	
    return $response->withHeader('Location',
        $this->router->pathFor("persons"));
})->setName('addRelationToPerson');









        
        
        
        
        
        
        
        
        


