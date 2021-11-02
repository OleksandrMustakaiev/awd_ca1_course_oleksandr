<?php
require_once 'config.php';

try {
    

    // Array of locations, this is used for the location validation rule - see line 18
    $rules = [
        "name" => "present|minlength:2|maxlength:64",
        "course_code" => "present|minlength:3|maxlength:2000",
        "cao_points" => "present|minlength:3|maxlength:2000",
        "start_date" => "present|match:/\A[0-9]{4}[-][0-9]{2}[-][0-9]{2}/",
    ];

    $request->validate($rules);
    if ($request->is_valid()) {
        //Pass the name of the file upload button as a parameter
        $file = new FileUpload("profile");
        //Get our new FileUpload object, which is stored in a temporary folder on our web server
        $filename = $file->get();
        //Create an image object and store the file path in that object.
        $image = new Image();
        /*Save the pathname for where the image is stored in the database*/
        $image->filename = $filename;
        $image->save();

        // !!Check .... If your Image is saved to the Database, but your 'Course' has not, you know code is correct to at least this point ...

        // Create an empty $course object
        $course = new Course();

        // course-create.php passed name, course_code, cao_points etc... in it's request object
        // not get name, course_code, cao_points etc from the request object and assign these values to the appropriate attributes in the $course object. 
        $course->name = $request->input("name");
        $course->course_code = $request->input("course_code");
        $course->cao_points = $request->input("cao_points");
        $course->start_date = $request->input("start_date");

        // When the Image was saved to the database ($image->save() above) and ID was created for that image. 
        // Now get that id from the $image, and assign it to $course->image_id so it can be saved as in the course table as a foreign key. 
        $course->image_id = $image->id;
        
        // save() is a function in the Course class, you will have written part of it - to update an existing course
        // now you will add more code to the save() function so it can create a new course or update an existing course.  
        $course->save();


        $request->session()->set("flash_message", "The course was successfully added to the database");
        //Class that changes the appearance of the Bootstrap message.
        $request->session()->set("flash_message_class", "alert-info");
        $request->session()->forget("flash_data");
        $request->session()->forget("flash_errors");
        // redirect back to the home page - course-index.php
        $request->redirect("/course-index.php");
    } else {
        //Get all session data from the form and store under the key 'flash_data'.
        $request->session()->set("flash_data", $request->all());
        $request->session()->set("flash_errors", $request->errors());

        //Redirect the user to the create page.
        $request->redirect("/course-create.php");
    }
} catch (Exception $ex) {
    /*Get all data and errors again and redirect.*/
    $request->session()->set("flash_message", $ex->getMessage());
    $request->session()->set("flash_message_class", "alert-warning");
    $request->session()->set("flash_data", $request->all());
    $request->session()->set("flash_errors", $request->errors());
    $request->redirect("/course-create.php");
}
