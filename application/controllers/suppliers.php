<?php

/**
 * Class Suppliers
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */

class Suppliers extends Controller
{
	function __construct()
	{
		$this->openDatabaseConnection();
		$this->loadModel();
	}

	public function loadModel()
	{
		require APP . '/model/supplier.php';
		require APP . '/model/task.php';
		require APP . '/model/po.php';
		// create new "model" (and pass the database connection)
        $this->supplier = new Supplier($this->db);
        $this->task = new Task($this->db);
        $this->po = new PO($this->db);
	}

	/**
	* Displays index page for Contractors.
	*/
	public function index()
	{
		$suppliers = $this->supplier->getAllSuppliers();
		$supplierPointer = $this->supplier;

		require APP . 'views/_templates/header.php';
		require APP . 'views/_templates/body.php';
        require APP . 'views/supplier/index.php';
        require APP . 'views/_templates/footer.php';
	}

	public function edit($sid)
	{
		$selected_supplier = $this->supplier->getSupplier($sid);

		require APP . 'views/_templates/header.php';
		require APP . 'views/_templates/body.php';
		require APP . 'views/supplier/edit.php';
		require APP . 'views/_templates/footer.php';
	}

	public function addSupplier()
	{
		$name = ($_POST['supplier_name']) ? $_POST['supplier_name'] : "N/A";
		$number = ($_POST['phone_number']) ? $_POST['phone_number'] : "N/A";
		$email = ($_POST['email']) ? $_POST['email'] : "N/A";

		// Check to see if we have any POST data.
		if(isset($_POST['submit_add_supplier']))
		{
			$new_sid = $this->supplier->addSupplier($name, $number, $email);
		}

		// Takes us back to suppliers/index.php
		header('location:' . URL_WITH_INDEX_FILE . 'suppliers/index');
	}

	/**
	* @todo: Check to see if user submissions are valid or 
	* not for updating the table.
	*/
	public function updateSupplier($sid)
	{
		$name = $_POST['name'];
		$num = $_POST['phone_number'];
		$email = $_POST['email'];

		if(isset($_POST['submit_update_task']))
		{
			$updated_supplier = $this->supplier->updateSupplier($sid, $name,$num,$email);
		}

		// Takes us back to suppliers/index.php
		header('location:' . URL_WITH_INDEX_FILE . 'suppliers/index');
	}

}