<?php
// the class Festival defines the structure of what every festival object will look like. ie. each festival will have an id, title, description etc...
// NOTE : For handiness I have the very same spelling as the database attributes
class Course {
  public $id;
  public $name;
  public $course_code;
  public $cao_points;
  public $start_date;
  public $image_id;



  public function __construct() {
    $this->id = null;
  }

  public function save() {
    try {
      //Create the usual database connection - $conn
      $db = new DB();
      $db->open();
      $conn = $db->get_connection();

      $params = [
        ":name" => $this->name,
        ":course_code" => $this->course_code,
        ":cao_points" => $this->cao_points,
        ":start_date" => $this->start_date,
        ":image_id" => $this->image_id
      ];

      // We will uncomment this code when we get to do the Create 
      // If there is no ID yet, then it's a new festival being created for the first time
      // if ($this->id === null) {
      //   $sql = "INSERT INTO festivals (" .
      //     "title, description, location, start_date, end_date, contact_name, contact_email, contact_phone, image_id" .
      //     ") VALUES (" .
      //     ":title, :description, :location, :start_date, :end_date, :contact_name, :contact_email, :contact_phone, :image_id" .
      //     ")";
      // } else {
        // if there is an ID then it's an update for an existing festival in the database. 
        $sql = "UPDATE courses SET " .
          "name = :name, " .
          "course_code = :course_code, " .
          "cao_points = :cao_points, " .
          "start_date = :start_date, " .
          "image_id = :image_id " .
          "WHERE id = :id";
        $params[":id"] = $this->id;
    //  }


      $stmt = $conn->prepare($sql);
      $status = $stmt->execute($params);

      if (!$status) {
        $error_info = $stmt->errorInfo();
        $message = "SQLSTATE error code = " . $error_info[0] . "; error message = " . $error_info[2];
        throw new Exception("Database error executing database query: " . $message);
      }

      if ($stmt->rowCount() !== 1) {
        throw new Exception("Failed to save course.");
      }

      //If the save() was a new festival created it won't have an ID
      // so retrieve the ID assigned by the DB. - remember auto_increment in the Database for assigning primary keys
      // if ($this->id === null) {
      //   $this->id = $conn->lastInsertId();
      // }
    } finally {
      if ($db !== null && $db->is_open()) {
        $db->close();
      }
    }
  }

  public function delete() {
    try {
      /*Create connection.*/
      $db = new DB();
      $db->open();
      $conn = $db->get_connection();

      $sql = "DELETE FROM courses WHERE id = :id";
      $params = [
        ":id" => $this->id
      ];

      $stmt = $conn->prepare($sql);
      $status = $stmt->execute($params);

      if (!$status) {
        $error_info = $stmt->errorInfo();
        $message = "SQLSTATE error code = " . $error_info[0] . "; error message = " . $error_info[2];
        throw new Exception("Database error executing database query: " . $message);
      }

      if ($stmt->rowCount() !== 1) {
        throw new Exception("Failed to delete course.");
      }
    } finally {
      if ($db !== null && $db->is_open()) {
        $db->close();
      }
    }
  }

  public static function findAll() {
    $festivals = array();

    try {
      // call DB() in DB.php to create a new database object - $db
      $db = new DB();
      $db->open();
      // $conn has a connection to the database
      $conn = $db->get_connection();
      

      // $select_sql is a variable containing the correct SQL that we want to pass to the database
      $select_sql = "SELECT * FROM courses";
      $select_stmt = $conn->prepare($select_sql);
      // $the SQL is sent to the database to be executed, and true or false is returned 
      $select_status = $select_stmt->execute();

      // if there's an error display something sensible to the screen. 
      if (!$select_status) {
        $error_info = $select_stmt->errorInfo();
        $message = "SQLSTATE error code = ".$error_info[0]."; error message = ".$error_info[2];
        throw new Exception("Database error executing database query: " . $message);
      }
      // if we get here the select worked correctly, so now time to process the festivals that were retrieved
      

      if ($select_stmt->rowCount() !== 0) {
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
        while ($row !== FALSE) {
          // Create $festival object, then put the id, title, description, location etc into $festival
          $course = new Course();
          $course->id = $row['id'];
          $course->name = $row['name'];
          $course->course_code = $row['course_code'];
          $course->cao_points = $row['cao_points'];
          $course->start_date = $row['start_date'];
          $course->image_id = $row['image_id'];

          // $festival now has all it's attributes assigned, so put it into the array $festivals[] 
          $courses[] = $course;
          
          // get the next festival from the list and return to the top of the loop
          $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
        }
      }
    }
    finally {
      if ($db !== null && $db->is_open()) {
        $db->close();
      }
    }

    // return the array of $festivals to the calling code - index.php (about line 6)
    return $courses;
  }

  public static function findById($id) {
    $course = null;

    try {
      $db = new DB();
      $db->open();
      $conn = $db->get_connection();

      $select_sql = "SELECT * FROM courses WHERE id = :id";
      $select_params = [
          ":id" => $id
      ];
      $select_stmt = $conn->prepare($select_sql);
      $select_status = $select_stmt->execute($select_params);

      if (!$select_status) {
        $error_info = $select_stmt->errorInfo();
        $message = "SQLSTATE error code = ".$error_info[0]."; error message = ".$error_info[2];
        throw new Exception("Database error executing database query: " . $message);
      }

      if ($select_stmt->rowCount() !== 0) {
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
          
        $course = new Course();
        $course->id = $row['id'];
        $course->name = $row['name'];
        $course->course_code = $row['course_code'];
        $course->cao_points = $row['cao_points'];
        $course->start_date = $row['start_date'];
        $course->image_id = $row['image_id'];
      }
    }
    finally {
      if ($db !== null && $db->is_open()) {
        $db->close();
      }
    }

    return $course;
  }

  
}
?>
