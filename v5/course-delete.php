<?php require_once 'config.php';

try {
  // course_id is valid of it is present, is an integer with a minimum value of 1
  $rules = [
    'course_id' => 'present|integer|min:1'
  ];

  // you can have a look at the validate() function in HttpRequest.php (line 415)
  $request->validate($rules);
  if (!$request->is_valid()) {
    throw new Exception("Illegal request");
  }
  //the course_id was passed in from course-index.php
  // now you extract it from the request object and assign the value to the variable $course_id  
  $course_id = $request->input('course_id');


  /*Retrieving the correct course object ($course) from the Database*/
  //Call findById(id) function to check if this course exists in the Database
  $course = course::findById($course_id);
  // if course does not exist display error message 
  if ($course === null) {
    throw new Exception("No course exists or Illegal request parameter");
  }

  // $course is an object - created from the course class
  // calling $course->delete() calls the delete function in the course class
  $course->delete();

  // Display redirect to the list of courses and display the correct message - Deleted or Not Deleted
  $request->session()->set("flash_message", "The course was successfully deleted from the database");
  $request->session()->set("flash_message_class", "alert-info");
  $request->redirect("/course-index.php");
} catch (Exception $ex) {
  /*If something goes wrong, catch the message and store it as a flash message.*/
  $request->session()->set("flash_message", $ex->getMessage());
  $request->session()->set("flash_message_class", "alert-warning");

  $request->redirect("/course-index.php");
}