<?php require_once 'config.php';

try {

  // The $rules array has 3 rules, festival_id must be present, must be an integer and have a minimum value of 1.  
  // note festival_id was passed in from festival_index.php when you chose a festival by clicking a radio button. 
  $rules = [
    'course_id' => 'present|integer|min:1'
  ];
  // $request->validate() is a function in HttpRequest(). You pass in the 3 rules above and it does it's magic. 
  $request->validate($rules);
  if (!$request->is_valid()) {
    throw new Exception("Illegal request");
  }

  // get the festival_id out of the request (remember it was passed in from festival_index.php)
  $course_id = $request->input('course_id');
 
  //Retrieve the festival object from the database by calling findById($festival_id) in the Festival.php class
  $course = Course::findById($course_id);
  if ($course === null) {
    throw new Exception("Illegal request parameter");
  }
} catch (Exception $ex) {
  $request->session()->set("flash_message", $ex->getMessage());
  $request->session()->set("flash_message_class", "alert-warning");

  // some exception/error occured so re-direct to the index page
  $request->redirect("/course-index.php");
}

?>



<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>View Course</title>

  <link href="<?= APP_URL ?>/assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="<?= APP_URL ?>/assets/css/template.css" rel="stylesheet">
  <link href="<?= APP_URL ?>/assets/css/style.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400&display=swap" rel="stylesheet">


</head>

<body>
  <div class="container-fluid p-0">
    <?php require 'include/navbar.php'; ?>
    <main role="main">
      <div>
        <div class="row d-flex justify-content-center">
          <h1 class="t-peta engie-head pt-5 pb-5">View Course</h1>
        </div>

        <div class="row justify-content-center pt-4">
          <div class="col-lg-10">
            <form method="get">
              <!--This is how we pass the ID-->
              <input type="hidden" name="course_id" value="<?= $course->id ?>" />

              <!--Disabled so the user can't intereact. This form is for viewing only.-->
              <div class="form-group">
                <label class="labelHidden" for="ticketPrice">Name</label>
                <input placeholder="Name" type="text" id="name" class="form-control" value="<?= $course->name ?>" disabled />
              </div>

              <div class="form-group">
                <label class="labelHidden" for="date">Course Code</label>
                <textarea name="course_code" rows="3" id="course_code" class="form-control" disabled><?= $course->course_code ?></textarea>
              </div>

              <div class="form-group">
                <label class="labelHidden" for="date">CAO Points</label>
                <textarea name="cao_points" rows="3" id="cao_points" class="form-control" disabled><?= $course->cao_points ?></textarea>
              </div>

              <div class="form-group">
                <label class="labelHidden" for="venueCapacity">Start Date</label>
                <input placeholder="Start Date" type="date" class="form-control" id="startDate" value="<?= $course->start_date ?>" disabled />
              </div>

              <div class="form-group">
                <label class="labelHidden" for="venueDescription">Image</label>
                <?php
                try {
                  $image = Image::findById($course->image_id);
                } catch (Exception $e) {
                }
                if ($image !== null) {
                ?>
                  <img src="<?= APP_URL . "/" . $image->filename ?>" width="205px" alt="image" class="mt-2 mb-2" />
                <?php
                }
                ?>
              </div>

              <div class="form-group">
                <a class="btn btn-default" href="<?= APP_URL ?>/course-index.php">Cancel</a>
                <button class="btn btn-warning" formaction="<?= APP_URL ?>/course-edit.php">Edit</button>
                <button class="btn btn-danger btn-course-delete" formaction="<?= APP_URL ?>/course-delete.php">Delete</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </main>
    <?php require 'include/footer.php'; ?>
  </div>
  <script src="<?= APP_URL ?>/assets/js/jquery-3.5.1.min.js"></script>
  <script src="<?= APP_URL ?>/assets/js/bootstrap.bundle.min.js"></script>
  <script src="<?= APP_URL ?>/assets/js/festival.js"></script>

  <script src="https://kit.fontawesome.com/fca6ae4c3f.js" crossorigin="anonymous"></script>

</body>

</html>