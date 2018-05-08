<?php

class api {

    public function studentsApi() {
        $sm = new schoolmodel;
        $students = $sm->getAllStudents();
        echo json_encode($students);
    }
    public function coursesApi() {
        $sm = new schoolmodel;
        $courses = $sm->getAllCourses();
        echo json_encode($courses);
    }
    public function adminsApi() {
        $um = new usermodel;
        $admins = $um->getAllUsers();
        echo json_encode($admins);
    }
    // get one student, get his courses from the pivot table and json it
    public function oneStudentApi($id) {
        $sm = new schoolmodel;
        $student = $sm->getStudent($id);
        $courses = $sm->getStudentCourses($id);
        $student['courses'] = $courses;
        echo json_encode($student);
    }
    // get one course, get his students from the pivot table and json it
    public function oneCourseApi($id) {
        $sm = new schoolmodel;
        $course = $sm->getCourse($id);
        $students = $sm->getCourseStudents($id);
        $course['students'] = $students;
        echo json_encode($course);
    }
    public function oneAdminApi($id) {
        $um = new usermodel;
        $admin = $um->getUser($id);
        echo json_encode($admin);
    }
    public function addStudentApi() {
        $result = [
            'success'=>false,
            'error' => '909: Unkown error occured, consider yourself lucky'
        ];
        $pid = empty($_POST['pid']) ? NULL : $_POST['pid'];
        $pname = empty($_POST['pname']) ? NULL : $_POST['pname'];
        $pphone = empty($_POST['pphone']) ? NULL : $_POST['pphone'];
        $pemail = empty($_POST['pemail']) ? NULL : $_POST['pemail'];
        $pcourses = empty($_POST['pcourses']) ? NULL : $_POST['pcourses'];
        $filename = "none.jpg";
        if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['pimg']) && $_POST['pimg'] != "none.jpg" ) {
            try {
                $filename = $this->processBlob($_POST['pimg']);
                $result = [
                    'img-success'=>true
                ];
            }
            catch(RuntimeException $e) {
                $result = [
                    'img-success'=>true,
                    'error' => $e->getMessage()
                ];
            }
        }
        $err = [];
        if($pname==NULL) {
            $err[] = 'Name';
        }
        if($pphone==NULL) {
            $err[] = 'Phone';
        }
        if($pemail==NULL) {
            $err[] = 'Email';
        }
        if(count($err)>0) {
        $result['error'] = 'Missing '.implode(',',$err);
        }
        else {
            $sm = new schoolmodel;
            $emailtest = $sm->getStudentByMail($pemail);
            if ($emailtest) {
                $result['error'] = "Email already taken";
            }
            else {
            $sm->addStudent($pid,$pname,$pphone,$pemail,$pcourses,$filename);
            $result = [
                'success'=>true,
                'data'=> [
                'id' => $pid,
                'name'=> $pname,
                'phone' => $pphone,
                'pemail'=> $pemail,
                'pcourses'=> $pcourses,
                'img' => $filename
                ]
            ];
        ;}
        echo json_encode($result);
        }
    }
    public function addCourseApi() {
        $result = [
            'success'=>false,
            'error' => '909: Unkown error occured, consider yourself lucky'
        ];
        $pname = empty($_POST['pname']) ? NULL : $_POST['pname'];
        $pdesc = empty($_POST['pdesc']) ? NULL : $_POST['pdesc'];
        $filename = "none.jpg";
        if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['pimg']) && $_POST['pimg'] != "none.jpg" ) {
            try {
                $filename = $this->processBlob($_POST['pimg']);
                $result = [
                    'img-success'=>true
                ];
            }
            catch(RuntimeException $e) {
                $result = [
                    'img-success'=>true,
                    'error' => $e->getMessage()
                ];
            }
        }

        $err = [];
        if($pname==NULL) {
            $err[] = 'Name';
        }
        if($pdesc==NULL) {
            $err[] = 'Description';
        }
        if(count($err)>0) {
            $result['error'] = 'Missing '.implode(',',$err);
        }
        else {
            $sm = new schoolmodel;
            $sm->addCourse($pname,$pdesc,$filename);
            $result = [
                'success'=>true,
                'data'=> [
                    'id' => $sm->lastID(),
                    'name'=> $pname,
                    'description' => $pdesc,
                    'img' => $filename
                ]
            ];
            echo json_encode($result);
            }
    }
    public function addAdminApi() {
        $result = [
            'success'=>false,
            'error' => '909: Unkown error occured, consider yourself lucky'
        ];
        $pid = empty($_POST['pid']) ? NULL : $_POST['pid'];
        $pname = empty($_POST['pname']) ? NULL : $_POST['pname'];
        $ppassword = empty($_POST['ppassword']) ? NULL : $_POST['ppassword'];
        $pphone = empty($_POST['pphone']) ? NULL : $_POST['pphone'];
        $pemail = empty($_POST['pemail']) ? NULL : $_POST['pemail'];
        $prole = empty($_POST['prole']) ? NULL : $_POST['prole'];
        $filename = "none.jpg";
        if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['pimg']) && $_POST['pimg'] != "none.jpg" ) {
            try {
                $filename = $this->processBlob($_POST['pimg']);
                $result = [
                    'img-success'=>true
                ];
            }
            catch(RuntimeException $e) {
                $result = [
                    'img-success'=>true,
                    'error' => $e->getMessage()
                ];
            }
        }
        $err = [];
        if($pname==NULL) {
            $err[] = 'Name';
        }
        if($pphone==NULL) {
            $err[] = 'Phone';
        }
        if($pemail==NULL) {
            $err[] = 'Email';
        }
        if($prole==NULL) {
            $err[] = 'Role';
        }
        if($ppassword==NULL) {
            $err[] = 'Password';
        }
        if(count($err)>0) {
        $result['error'] = 'Missing '.implode(',',$err);
        }
        else {
            $um = new usermodel;
            $emailtest = $um->getUserByMail($pemail);
            if ($emailtest) {
                $result['error'] = "Email already taken";
            }
            else {
                $um->addUser($pid,$pname,$ppassword,$pphone,$pemail,$prole,$filename);
                $result = [
                    'success'=>true,
                    'data'=> [
                    'id' => $pid,
                    'name'=> $pname,
                    'password'=>$ppassword,
                    'phone' => $pphone,
                    'email'=> $pemail,
                    'role'=> $prole,
                    'img' => $filename
                    ]
                ];
            };
        echo json_encode($result);
        }
    }
    public function editAdminApi() {
        $result = [
            'success'=>false,
            'error' => '909: Unkown error occured, consider yourself lucky'
        ];
        $pid = empty($_POST['pid']) ? NULL : $_POST['pid'];
        $pname = empty($_POST['pname']) ? NULL : $_POST['pname'];
        $ppassword = empty($_POST['ppassword']) ? NULL : $_POST['ppassword'];
        $pphone = empty($_POST['pphone']) ? NULL : $_POST['pphone'];
        $pemail = empty($_POST['pemail']) ? NULL : $_POST['pemail'];
        $prole = empty($_POST['prole']) ? NULL : $_POST['prole'];
        $um = new usermodel;
        // defaulted, already uploaded img, if the user dosent want to change the img
        $filename = $um->getUser($pid)['img'];
        // upload and change the image only if the user requested it so
        if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['pimg']) && $_POST['pimg'] != "default" ) {
            try {
                $filename = $this->processBlob($_POST['pimg']);
                $result = [
                    'img-success'=>true
                ];
            }
            catch(RuntimeException $e) {
                $result = [
                    'img-success'=>true,
                    'error' => $e->getMessage()
                ];
            }
        }
        $err = [];
        if($pname==NULL) {
            $err[] = 'Name';
        }
        if($pphone==NULL) {
            $err[] = 'Phone';
        }
        if($pemail==NULL) {
            $err[] = 'Email';
        }
        if($prole==NULL) {
            $err[] = 'Role';
        }
        if($ppassword==NULL) {
            $err[] = 'Password';
        }
        if(count($err)>0) {
        $result['error'] = 'Missing '.implode(',',$err);
        }
        else {
            $um = new usermodel;
            $emailtest = $um->getUserByMail($pemail);
            if ($emailtest && $emailtest['adminid'] != $pid) {
                $result['error'] = "Email already taken";
            }
            else {
                $um->EditUser($pid,$pname,$ppassword,$pphone,$pemail,$prole,$filename);
                $result = [
                    'success'=>true,
                    'data'=> [
                    'id' => $pid,
                    'name'=> $pname,
                    'password'=>$ppassword,
                    'phone' => $pphone,
                    'email'=> $pemail,
                    'role'=> $prole,
                    'img' => $filename
                    ]
                ];
            };
        echo json_encode($result);
        }
    }
    public function deleteAdminApi($pid) {
        $result = [
            'success'=>false,
            'error' => '909: Unkown error occured, consider yourself lucky'
        ];
        $um = new usermodel;
            $um->deleteUser($pid);
            $result = [
                'success'=>true,
                'data'=> [
                    'id' => $pid,
                ]
            ];
            echo json_encode($result);
    }
    public function editStudentApi($pid) {
        $result = [
            'success'=>false,
            'error' => '909: Unkown error occured, consider yourself lucky'
        ];
        $pid = empty($_POST['pid']) ? NULL : $_POST['pid'];
        $pname = empty($_POST['pname']) ? NULL : $_POST['pname'];
        $pphone = empty($_POST['pphone']) ? NULL : $_POST['pphone'];
        $pemail = empty($_POST['pemail']) ? NULL : $_POST['pemail'];
        $pcourses = empty($_POST['pcourses']) ? NULL : $_POST['pcourses'];
        $sm = new schoolmodel;
        // defaulted, already uploaded img, if the user dosent want to change the img
        $filename = $sm->getStudent($pid)['img'];
        // upload and change the image only if the user requested it so
        if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['pimg']) && $_POST['pimg'] != "default" ) {
            try {
                $filename = $this->processBlob($_POST['pimg']);
                $result = [
                    'img-success'=>true
                ];
            }
            catch(RuntimeException $e) {
                $result = [
                    'img-success'=>true,
                    'error' => $e->getMessage()
                ];
            }
        }
        $err = [];
        if($pname==NULL) {
            $err[] = 'Name';
        }
        if($pphone==NULL) {
            $err[] = 'Phone';
        }
        if($pemail==NULL) {
            $err[] = 'Email';
        }
        if(count($err)>0) {
        $result['error'] = 'Missing '.implode(',',$err);
        }
        else {
            $sm = new schoolmodel;
            $emailtest = $sm->getStudentByMail($pemail);
            if ($emailtest && $emailtest['studentid'] != $pid) {
                $result['error'] = "Email already taken";
            }
            else {
                $sm->editStudent($pid,$pname,$pphone,$pemail,$pcourses,$filename);
                $result = [
                    'success'=>true,
                    'data'=> [
                    'id' => $pid,
                    'name'=> $pname,
                    'phone' => $pphone,
                    'pemail'=> $pemail,
                    'pcourses'=> $pcourses,
                    'img' => $filename
                    ]
                ];
            }
        echo json_encode($result);
        }  
    }
    public function deleteStudentApi($pid) {
        $result = [
            'success'=>false,
            'error' => '909: Unkown error occured, consider yourself lucky'
        ];
        $sm = new schoolmodel;
            $sm->deleteStudent($pid);
            $result = [
                'success'=>true,
                'data'=> [
                    'id' => $pid,
                ]
            ];
            echo json_encode($result);
    }
    public function editCourseApi($pid) {
        $result = [
            'success'=>false,
            'error' => '909: Unkown error occured, consider yourself lucky'
        ];
        $pname = empty($_POST['pname']) ? NULL : $_POST['pname'];
        $pdesc = empty($_POST['pdesc']) ? NULL : $_POST['pdesc'];
        $sm = new schoolmodel;
        // defaulted, already uploaded img, if the user dosent want to change the img
        $filename = $sm->getCourse($pid)['img'];
        // upload and change the image only if the user requested it so
        if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['pimg']) && $_POST['pimg'] != "default" ) {
            try {
                $filename = $this->processBlob($_POST['pimg']);
                $result = [
                    'img-success'=>true
                ];
            }
            catch(RuntimeException $e) {
                $result = [
                    'img-success'=>true,
                    'error' => $e->getMessage()
                ];
            }
        }

        $err = [];
        if($pname==NULL) {
            $err[] = 'Name';
        }
        if($pdesc==NULL) {
            $err[] = 'Description';
        }
        if(count($err)>0) {
            $result['error'] = 'Missing '.implode(',',$err);
        }
        else {
            $sm = new schoolmodel;
            $sm->editCourse($pid,$pname,$pdesc,$filename);
            $result = [
                'success'=>true,
                'data'=> [
                    'id' => $pid,
                    'name'=> $pname,
                    'description' => $pdesc,
                    'img' => $filename
                ]
            ];
            echo json_encode($result);
            }
    }
    public function deleteCourseApi($pid) {
        $result = [
            'success'=>false,
            'error' => '909: Unkown error occured, consider yourself lucky'
        ];
        $sm = new schoolmodel;
            $sm->deleteCourse($pid);
            $result = [
                'success'=>true,
                'data'=> [
                    'id' => $pid,
                ]
            ];
            echo json_encode($result);
    }
    public function processBlob($blob) {
        // Decode base64 data
        list($type, $data) = explode(';', $blob);
        list(, $data) = explode(',', $data);
        $file_data = base64_decode($data);
    
        // Get file mime type
        $finfo = finfo_open();
        $file_mime_type = finfo_buffer($finfo, $file_data, FILEINFO_MIME_TYPE);
    
        // File extension from mime type, throw error if not valid
        if($file_mime_type == 'image/jpeg' || $file_mime_type == 'image/jpg')
            $file_type = 'jpeg';
        else if($file_mime_type == 'image/png')
            $file_type = 'png';
        else if($file_mime_type == 'image/gif')
            $file_type = 'gif';
        else
            throw new RuntimeException("Invalid file type {$file_mime_type}");
        // image size, throw error if invalid
        $size_in_bytes = (int) (strlen(rtrim($blob, '=')) * 3 / 4);
        if($size_in_bytes>1000000) {
            throw new RuntimeException('Image size ' . intVal($size_in_bytes/1000) . 'KB is too big');
        }
    
        // image dimentions, throw error if invalid
        $dim = getimagesizefromstring($file_data);
        if($dim[0] > 400 || $dim[1] > 400) {
            throw new RuntimeException('Image dimentions ' . $dim[0] . ' X ' . $dim[1] . ' too big');
        }
    
        $file_name = uniqid() . time() . '.' . $file_type;
        file_put_contents('upload/'.$file_name, $file_data);
        return $file_name;
    }
}

?>