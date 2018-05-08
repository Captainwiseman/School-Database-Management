<div class="backgroundadmin"></div>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-2">
            <div class="ctrlist">
                <div class="ctrlisttop">
                    <span class="ctrlistheader">Administrators</span>
                    <span class="glyphicon glyphicon-plus addadmin"></span>
                </div>
                <ul class="adminslist">
                </ul>
            </div>
        </div>
        <div class="col-sm-offset-2 col-sm-8">
            <div class="adminMainCtr">
                <div id="adminHomeCtr" class="container-fluid">
                    <div class="homebox">
                        <h1></h1>
                        <h2></h2>
                        <h2></h2>
                    </div>
                </div>
                <div id="adminsCtr" class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12 hr">
                            <span>Add Admin/Edit Admin</span>
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
                                <form class="form-horizontal" enctype="multipart/form-data" name="adminEditForm" action="/action_page.php">
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="name">Name:</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="adminname" placeholder="Add Name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="phone">Password:</label>
                                        <div class="col-sm-6">
                                            <input type="password" class="form-control" name="adminpassword" placeholder="Add Password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="phone">Phone:</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="adminphone" placeholder="Add Phone">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="email">Email:</label>
                                        <div class="col-sm-6">
                                            <input type="email" class="form-control" name="adminemail" placeholder="Add Email">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="role">Role:</label>
                                        <div class="col-sm-6">
                                            <select class="form-control roleselector" name="adminrole">
                                            </select>
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
                <div id="adminMultipass">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="descheader hr">
                                <span>User</span>
                                <button type="button" name="adminedit" id="adminedit" data-id="0" class="btn btn-default">Edit</button>
                            </div>
                        </div>
                        <div class="col-sm-12">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="amCtr">
                                <div class="amImg"></div>
                                <div class="amtxtCtr">
                                    <span class="amname">YOU SHOULDNT SEE THIS</span>
                                    <span class="amrole"></span>
                                    <span class="amphone"></span>
                                    <span class="amemail"></span>
                                </div>
                            </div>
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