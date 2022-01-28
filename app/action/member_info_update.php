<?php

ob_start();
session_start();
require_once("../controller/model/info.php");
require_once("../controller/db.php");

try
{
    list($day, $month, $year) = explode('/', $_POST['dob']);
    $_POST['dob'] = "$year-$month-$day";

    $WriteDB = DB::connectWriteDB();

    $info = new Info($_POST);
    list($filename, $extention) = explode('.', $_FILES['photo']['name']);
    $photo = $info->getMembershipno().".".$extention;
    $info->setPhoto($photo);

    $membershipno = $info->getMembershipno();
    $fullname = $info->getFullname();
    $dob = $info->getDOB();
    $gender = $info->getGender();
    $phone = $info->getPhone();
    $email = $info->getEmail();
    $company = $info->getCompany();
    $photo = $info->getPhoto();


    $sql = "SELECT id FROM info WHERE membership_no = :membershipno";
    $query = $WriteDB->prepare($sql);
    $query->bindParam(':membershipno', $membershipno, PDO::PARAM_STR);
    $query->execute();

    $rowCount = $query->rowCount();
    $row = $query->fetch(PDO::FETCH_ASSOC);

    $WriteDB->beginTransaction();
    if($rowCount > 0)
    {
        $sql = "UPDATE info SET membership_no = :membershipno, 
                fullname = :fullname, dob = :dob, gender = :gender, 
                phone = :phone, email = :email, company = :company, 
                photo = :photo, sync = NULL WHERE id = :id";
        $query = $WriteDB->prepare($sql);
        $query->bindParam(':id', $row['id'], PDO::PARAM_INT);
    }
    else
    {
        $sql = "INSERT INTO info(membership_no, fullname, dob, gender, phone, 
                email, company, photo) VALUES(:membershipno, :fullname, :dob, 
                :gender, :phone, :email, :company, :photo)";
        $query = $WriteDB->prepare($sql);
    }

    $query->bindParam(':membershipno', $membershipno, PDO::PARAM_STR);
    $query->bindParam(':fullname', $fullname, PDO::PARAM_STR);
    $query->bindParam(':dob', $dob, PDO::PARAM_STR);
    $query->bindParam(':gender', $gender, PDO::PARAM_STR);
    $query->bindParam(':phone', $phone, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':company', $company, PDO::PARAM_STR);
    $query->bindParam(':photo', $photo, PDO::PARAM_STR);

    $query->execute();
    if($_FILES['photo']['error'] !== 0)
    {
        if($WriteDB->inTransaction())
            $WriteDB->rollBack();
        echo "Error: photo upload failed. Photo size must not exceed 10MB";
        exit;
    }

    $filePath = $info->getUploadFolder()."/".$info->getPhoto();

    if(file_exists($filePath))
    {
        # Rename the old file
        $fileName = basename($filePath);
        $folderName = $info->getUploadFolder();
        $newFileName = $folderName."/".time()."_".$fileName;
        if(!rename($filePath, $newFileName))
        {
            if($WriteDB->inTransaction())
                $WriteDB->rollBack();
            throw new InfoException("Internal Error During file upload");
            exit;
        }
    }

    if(!move_uploaded_file($_FILES['photo']['tmp_name'], $filePath))
    {
        if($WriteDB->inTransaction())
            $WriteDB->rollBack();
        throw new InfoException("Error during file upload");
        exit;
    }

    $infoId = null;
    ($rowCount > 0 ? $infoId = $row['id'] : $infoId = $WriteDB->lastInsertId());
    $info->setID($infoId);
    $_SESSION['data'] = $info->returnInfoArray();
    $WriteDB->commit();
    header("Location: ../card.php");
    exit;
}
catch(InfoException $ex)
{
    if(is_array($_SESSION['data']))
    {
        $passedValue = null;
        foreach($_SESSION['data'] as $key => $value)
        {
            $passedValue .= "$key=".urlencode($value)."&";
        }
    }

    $msg = urlencode($ex->getMessage());
    header("Location: ../?error=$msg&$passedValue");
    exit;
}
catch(PDOException $ex)
{
    error_log("Error: ".$ex->getMessage(), 0);
    $_SESSION['data'] = $info->returnInfoArray();
    $msg = urlencode("Internal system error please try again");
    header("Location: ../?error=$msg");
    exit;
}


?>
