<?php

class InfoException extends Exception {};

class Info 
{
	private $_id;
	private $_membership_no;
	private $_fullname;
	private $_dob;
	private $_gender;
	private $_phone;
	private $_email;
	private $_company;
	private $_photo;
	private $_sync_time;

	public function __construct($data)
	{
		if(is_array($data))
		{
			if(array_key_exists('id', $data))
				$this->setID($data['id']);
			if(array_key_exists('membership_no', $data))
				$this->setMembershipno($data['membership_no']);
			if(array_key_exists('fullname', $data))
				$this->setFullname($data['fullname']);
			if(array_key_exists('dob', $data))
				$this->setDOB($data['dob']);
			if(array_key_exists('gender', $data))
				$this->setGender($data['gender']);
			if(array_key_exists('phone', $data))
				$this->setPhone($data['phone']);
			if(array_key_exists('email', $data))
				$this->setEmail($data['email']);
			if(array_key_exists('company', $data))
				$this->setCompany($data['company']);
			if(array_key_exists('photo', $data))
				$this->setPhoto($data['photo']);
			if(array_key_exists('sync', $data))
				$this->setSyncTime($data['sync_time']);
		}
	}

	public function setID($id)
	{
		if($id < 1 || $id > 9223372036854775807 || is_null($id) || $id == '' ||
			!is_numeric($id)
		)
		{
			throw new InfoException('Invalid Member id, must be numeric not less than 1 and not exceed 9223372036854775807 [$id]');
		}
		$this->_id = $id;
	}

	public function setMembershipno($membership_no)
	{
		if(strlen($membership_no) > 25 || is_null($membership_no) || strlen($membership_no) < 5 || 
			preg_match("/^[a-zA-z0-9-]+$/", $membership_no) != 1
		)
		{
			throw new InfoException("Invalid Membershp number, Membership number can only be alphanumeric and -");
		}
		$this->_membership_no = strtoupper($membership_no);
	}

	public function setFullname($fullname)
	{
		if(strlen($fullname) > 75 || is_null($fullname))
		{
			throw new InfoException("Member fullname must not be blan or exceed 75 characters");
		}
		$this->_fullname = strtoupper($fullname);
	}

	public function setDOB($dob)
	{
		if(is_null($dob) || !strtotime($dob) || strtotime($dob) > time())
		{
			throw new InfoException("Invalid member Date of birth. DOB cannot be blank or be in future");
		}
		$this->_dob = $dob;
	}

	public function setGender($gender)
	{
		$gender = strtoupper($gender);	
		if(strlen($gender) > 1 || !($gender == 'M' || $gender == 'F'))
		{
			throw new InfoException("Invalid Gender. Gender can only be M for maile or F for femail");
		}
		$this->_gender = $gender;
	}


	public function setPhone($phone)
	{
		if(is_null($phone) || strlen($phone) > 13 || $phone == '' ||
			preg_match("/^[+0-9]+/", $phone) != 1
		)
		{
			throw new InfoException("Invalid phone number. Phone number can only be + and numbers and not greater than  13 digits");
		}
		$this->_phone = $phone;
	}

	public function setEmail($email)
	{
		if(is_null($email) || strlen($email) > 255 || $email == '' ||
			!filter_var($email, FILTER_VALIDATE_EMAIL)
		)
		{
			throw new InfoException("Invalid Email address");
		}
		$this->_email = $email;
	}

	public function setCompany($company)
	{
		if(is_null($company) || strlen($company) > 255 || $company == '')
		{
			throw new InfoException("Invalid Company name");
		}
		$this->_company = strtoupper($company);
	}

	public function setPhoto($photo)
	{
		if(is_null($photo) || strlen($photo) > 75 || $photo == '' ||
			preg_match("/^[a-zA-z0-9-]+.(jpg)|(jpeg)|(png)$/", $photo) != 1
		)
		{
			throw new InfoException("Invalid Photo only jpg, jpeg or png photo is allowed");
		}
		$this->_photo = $photo;
	}

	public function setSyncTime($sync)
	{
		if(is_null($sync) || !strtotime($sync) || $sync == '')
		{
			throw new InfoException("Invalid Syncronise time");
		}
		$this->_sync_time = $sync;
	}

	public function getID()
	{
		return $this->_id;
	}

	public function getMembershipno()
	{
		return $this->_membership_no;
	}

	public function getFullname()
	{
		return $this->_fullname;
	}

	public function getDOB()
	{
		return $this->_dob;
	}

	public function getGender()
	{
		return $this->_gender;
	}

	public function getPhone()
	{
		return $this->_phone;
	}

	public function getEmail()
	{
		return $this->_email;
	}

	public function getCompany()
	{
		return $this->_company;
	}

	public function getPhoto()
	{
		return $this->_photo;
	}

	public function getSyncTime()
	{
		return $this->_sync_time;
	}

	public function getUploadFolder()
	{
		return "../../photo";
	}


	public function returnInfoArray()
	{
		$info = array();
		$info['id'] = $this->getID();
		$info['membership_no'] = $this->getMembershipno();
		$info['fullname'] = $this->getFullname();
		$info['dob'] = $this->getDOB();
		$info['gender'] = $this->getGender();
		$info['phone'] = $this->getPhone();
		$info['email'] = $this->getEmail();
		$info['company'] = $this->getCompany();
		$info['photo'] = $this->getPhoto();
		$info['sync'] = $this->getSyncTime();

		return $info;
	}
}


?>
