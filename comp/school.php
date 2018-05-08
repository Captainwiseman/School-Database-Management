<div class="background"></div>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-2">
            <div class="ctrlist">
                <div class="ctrlisttop">
                    <span class="ctrlistheader">Courses</span>
                    <span class="glyphicon glyphicon-plus addcourse"></span>
                </div>
                <ul class="courselist">
                </ul>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="ctrlist">
                <div class="ctrlisttop">
                    <span class="ctrlistheader">Students</span>
                    <span class="glyphicon glyphicon-plus addstudent"></span>
                </div>
                <ul class="studentlist">
                </ul>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="mainCtr">
                <div id="homeCtr" class="container-fluid">
                    <div class="homebox">
                        <h1></h1>
                        <h2></h2>
                        <h2></h2>
                    </div>
                </div>
                <div id="studentsCtr" class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12 hr">
                            <span>Add Student/Edit Student</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <button type="button" class="btn btn-default pull-left formsave">Save</button>
                        </div>
                        <div class="col-sm-6">
                            <button type="button" name="delete" class="btn btn-danger pull-right formdelete">Delete</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-offset-2 col-sm-8">
                            <div class="alert alert-success notify">
                                <p>
                                    <strong>This is a test</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="container-fluid">
                            <div class="col-sm-offset-2 col-sm-10">
                                <form class="form-horizontal" enctype="multipart/form-data" name="studentEditForm" action="/action_page.php">
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="name">Name:</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="studentname" placeholder="Add Name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="phone">Phone:</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="studentphone" placeholder="Add Phone">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="email">Email:</label>
                                        <div class="col-sm-6">
                                            <input type="email" class="form-control" name="studentemail" placeholder="Add Email">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2">Image:</label>
                                        <div class="col-sm-4">
                                            <div class="upImg" style="background-image:url(/project/upload/none.jpg)"></div>
                                        </div>
                                        <div class="col-sm-3">
                                            <p class="uploadrules">Upload image
                                                <br>Not bigger than 1mb
                                                <br>Not bigger than 400x400
                                                </p>
                                        </div>
                                        <div class="col-sm-6">
                                        <input type="file" name="upload" class="Upload">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="upCourses">Courses:</label>
                                        <div class="studentcourses">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="coursesCtr" class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12 hr">
                            <span>Add Course/Edit Course</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <button type="button" name="save" class="btn btn-default pull-left formsave">Save</button>
                        </div>
                        <div class="col-sm-6">
                            <button type="button" name="delete" class="btn btn-danger pull-right formdelete">Delete</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-offset-2 col-sm-8">
                            <div class="alert alert-success notify">
                                <p>
                                    <strong>This is a test</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="container-fluid">
                            <div class="col-sm-offset-2 col-sm-10">
                                <form class="form-horizontal" action="/action_page.php" name="courseEditForm" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="coursename">Name:</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="coursename" placeholder="Add Name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="coursedesc">Description:</label>
                                        <div class="col-sm-6">
                                            <textarea class="form-control" name="coursedesc" placeholder="Add Description"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2">Image:</label>
                                        <div class="col-sm-4">
                                            <div class="upImg" style="background-image:url(/project/upload/none.jpg)"></div>
                                        </div>
                                        <div class="col-sm-3">
                                        <p class="uploadrules">Upload image
                                                <br>Not bigger than 1mb
                                                <br>Not bigger than 400x400
                                                </p>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="file" name="upload" class="Upload">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-6">
                                            <span class="studentcount">There are 80X students in this course</span><br>
                                            <span class="studentcountwar">Cannot delete course if there are students enlisted</span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="deleteCtr">
                    <div class="deletebox">
                        <h1>Are you sure you wish to delete?</h1>
                        <h2>Name</h2>
                        <div class="upImg" style="background-image:url(/project/upload/none.jpg)"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-5">
                            <button type="button" name="back" class="btn btn-default pull-right formback">Back</button>
                        </div>
                        <div class="col-sm-3">
                            <button type="button" name="delete" class="btn btn-danger pull-right formdelete">Delete</button>
                        </div>
                    </div>
                </div>
                <div id="studentMultipass">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="descheader hr">
                                <span>Student</span>
                                <button type="button" name="studentedit" id="studentedit" data-id="0" class="btn btn-default">Edit</button>
                            </div>
                        </div>
                        <div class="col-sm-12">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="smCtr">
                                <div class="smImg"></div>
                                <div class="smtxtCtr">
                                    <span class="smname">YOU SHOULDNT SEE THIS</span>
                                    <span class="smphone"></span>
                                    <span class="smemail"></span>
                                </div>
                            </div>
                            <ul class="studentcourselist">
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="courseMultipass">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="descheader hr">
                                <span>Course</span>
                                <button type="button" name="coursetedit" id="courseedit" data-id="0" class="btn btn-default">Edit</button>
                            </div>
                        </div>
                        <div class="col-sm-12">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="coCtr">
                                <div class="coImg"></div>
                                <div class="cotxtCtr">
                                    <span class="coname">YOU SHOULDNT SEE THIS</span>
                                    <span class="costudents"></span>
                                    <p class="codesc"></p>
                                </div>
                            </div>
                            <ul class="coursestudentlist">
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="spinner">
                    <div>
                        <div class="sk-folding-cube">
                            <div class="sk-cube1 sk-cube"></div>
                            <div class="sk-cube2 sk-cube"></div>
                            <div class="sk-cube4 sk-cube"></div>
                            <div class="sk-cube3 sk-cube"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>