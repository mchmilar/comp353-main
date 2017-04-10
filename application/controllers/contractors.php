<?php

class Contractors extends Controller
{
	function __construct()
	{
		$this->openDatabaseConnection();
		$this->loadModel();
	}

	// TODO: Keep in mind address also.
	public function loadModel()
	{
		require APP . '/model/contractor.php';
		require APP . '/model/task.php';
		require APP . '/model/po.php';
		require APP . '/model/project.php';
		// create new "model" (and pass the database connection)
        $this->contractor = new Contractor($this->db);
        $this->task = new Task($this->db);
        $this->po = new PO($this->db);
        $this->project = new Project($this->db);
	}

	public function index()
	{
		$contractors = $this->contractor->getAllContractors();

		$contractorPointer = $this->contractor;

		require APP . 'views/_templates/header.php';
		require APP . 'views/_templates/body.php';
		require APP . 'views/contractors/index.php';
		require APP . 'views/_templates/footer.php';
	}

	public function addContractor()
	{
		// Retrieve organization name entered.
		// TODO: Form validation.
		$org_name = $_POST['org_name'];

		// Retrieve contractor first name.
		$firstName = $_POST['first_name'];

		// Retrieve contractor last name.
		$lastName = $_POST['last_name'];

		// Retrieve contractor phone number.
		$phone = $_POST['phone'];

		// Retrieve contractor profession.
		$profession = (empty($_POST['profession'])) ? $_POST['profession'] : "N/A";
	}

	public function edit($cid)
	{
		$selectedContractor = $this->contractor->getContractor($cid);

		require APP . 'views/_templates/header.php';
		require APP . 'views/_templates/body.php';
		require APP . 'views/contractors/edit.php';
		require APP . 'views/_templates/footer.php';
	}

	public function updateContractor($cid)
	{
		$org_name = $_POST['org_name'];
		$firstName = $_POST['first_name'];
		$lastName = $_POST['last_name'];
		$phone = $_POST['phone'];
		$prof = $_POST['profession'];

		// if we have POST data to create a new project
        if (isset($_POST["submit_update_contractor"])) {
            $new_cid = $this->contractor->updateContractor($org_name, $firstName, $lastName, $phone, $prof, $cid);
        }


        header('location: ' . URL_WITH_INDEX_FILE . 'contractors/index');
	}
}

?>