<?php


function insert_location($db, $formData) {
    try {
        $stmt = $db->prepare("INSERT INTO location
            (city, street_name, street_number, zip)
            VALUES (:city, :street_name, :street_number, :zip)");
        $stmt->bindValue(":city", empty($formData['city']) ? null : $formData['city']);
        $stmt->bindValue(":street_name", empty($formData['street_name']) ? null : $formData['street_name']);
        $stmt->bindValue(":street_number", empty($formData['street_number']) ? null : $formData['street_number']);
        $stmt->bindValue(":zip", empty($formData['zip']) ? null : $formData['zip']);
        $stmt->execute();
        return $db->lastInsertId('location_id_location_seq');                              
    } catch (PDOException $e) {
        echo $e->getMessage();
        return False;
    }               
}



