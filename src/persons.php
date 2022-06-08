
<?php

include 'location.php';

function insert_person($db,$formData){
    try {
         //Napred vlozime adresu        
         if ((!empty($formData['city'])) || (!empty($formData['street_name'])) || (!empty($formData['street_number'])) || (!empty($formData['zip']))){  //Zavorka neco -> opravit  
         $id_location = insert_location($db,$formData);  
         } else {
          $id_location = null;
          }
         //Vlozime ososu           
         $stmt = $db->prepare("INSERT INTO person (nickname, first_name, last_name, id_location, birth_day, height, gender)
          VALUES (:nickname, :first_name, :last_name, :id_location, :birth_day, :height, :gender)");
          $stmt->bindValue(":nickname", $formData['nickname']); 
          $stmt->bindValue(":last_name", $formData['last_name']);
          $stmt->bindValue(":first_name", $formData['first_name']);
          $stmt->bindValue(":id_location", $id_location ? $id_location : null);
          $stmt->bindValue(":gender", empty($formData['gender']) ? null : $formData['gender']);
          $stmt->bindValue(":height", empty($formData['height']) ? null : $formData['height']);
          $stmt->bindValue(":birth_day", empty($formData['birth_day']) ? null : $formData['birth_day']);
          $stmt->execute();                                        
    } catch (PDOException $e){
        echo $e->getMessage();
    
    }
    
}

function delete_person($db, $id_person){
    $stmt = $db->prepare("DELETE FROM person WHERE id_person= :id_person");
    $stmt->bindValue(":id_person", $id_person);
    $stmt->execute();
    return True;

}