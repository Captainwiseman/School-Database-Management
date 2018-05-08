$(function () {
    console.log("jq running");
    // global variable, the power of the user logged
    var power = $("#SessionData").data("session")
    //Img Upload
    var uploadingImg = false;
    var fr = new FileReader();
    fr.onload = function () {
        var img = new Image();
        img.onload = function () {
            if (img.width > 400 || img.height > 400) {
                selectImageResult(false, 'Image dimentions ' + img.width + ' X ' + img.height + ' is too big');
                console.log("HERE MOI EYE");
            } else {
                console.log("HERE I AM");
                selectImageResult(true);
            }
        }
        img.src = fr.result;
    }
    var $inpFile = $('.Upload');

    function selectImageResult(success, str = "") {
        if (success) {
            notify(false);
            uploadingImg = true;
            $('.upImg').css('background-image', 'url(' + fr.result + ')');
            console.log(fr.result);
        } else {
            notify(true, "bad", "<p><strong>Image Violation! </strong>" + str + "<br>Will upload default</p>");
            uploadingImg = false
            $('.upImg').css('background-image', 'url(upload/vio.png)');
        }
    }

    function changed(e) {
        var validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        if (validTypes.indexOf(e.target.files[0].type) == -1) {
            selectImageResult(false, 'Selected file ' + e.target.files[0].type + ' is not an image');
        } else if (e.target.files[0].size > 1000000) {
            selectImageResult(false, 'Image size ' + parseInt(e.target.files[0].size / 1000) + 'KB is too big');
        } else {
            fr.readAsDataURL(e.target.files[0]);
        }
    }
    $inpFile.on('change', function (e) {
        changed(e);
    });
    // Student and courses list init
    function init() {
        $("#spinner").fadeIn();
        if (power == "Owner" || power == "Manager") {
            $(".addcourse").show();
            $(".addcourse").on("click", function () {
                newCourse($(this));
            });
        };
        $(".addstudent").show();
        $(".addstudent").on("click", function () {
            newStudent($(this));
        });
        $("#studentedit").on("click", function () {
            editStudent();
        });
        $("#courseedit").on("click", function () {
            editCourse();
        });
        notify(false);
        studentsRoll();
        coursesRoll();
        $("#spinner").fadeOut()
        Home("Welcome", "good");
    }

    function notify(show = false, alert = "bad", html = "") {
        if (show) {
            $(".notify").removeClass("alert-success");
            $(".notify").removeClass("alert-danger");
            if (alert == "bad") {
                $(".notify").addClass("alert-danger");
            }
            if (alert == "good") {
                $(".notify").addClass("alert-success");
            }
            $(".notify").html(html);
            $(".notify").show();
        }
        if (!show) {
            $(".notify").hide();
        }
    }
    // Home page
    function Home(msg, type) {
        $(".mainCtr>div").hide();
        sysCount();
        if (type == 'good') {
            $("#homeCtr h1").css('color', 'white');
        }
        if (type == 'bad') {
            $("#homeCtr h1").css('color', 'red');
        }
        $("#homeCtr h1").text(msg);
        $('#homeCtr').fadeIn();
    }
    // database items counter
    function sysCount() {
        var studentscount = 0;
        $.ajax({
            url: "/project/api/students",
            method: "get",
            dataType: "json"
        }).done(function (r) {
            for (x in r) {
                studentscount++
            }
            $("#homeCtr h2:nth-child(2)").text(studentscount + " Students in the system");
        });
        var coursescount = 0;
        $.ajax({
            url: "/project/api/courses",
            method: "get",
            dataType: "json"
        }).done(function (r) {
            for (x in r) {
                coursescount++
            }
            $("#homeCtr h2:nth-child(3)").text(coursescount + " Courses in the system");
        });
    }
    // new student form reveal
    function newStudent() {
        $(".mainCtr>div").hide()
        $("#spinner").fadeIn();
        notify(false);
        var fs = document.forms.studentEditForm.elements;
        fs.studentname.value = "";
        fs.studentphone.value = "";
        fs.studentemail.value = "";
        $(".studentcourses").empty();
        $("#studentsCtr>div>div>span").text("Add Student");
        $(".upImg").css("background-image", "url(/project/upload/none.jpg");
        $("#studentsCtr .formdelete").hide();
        $("#studentsCtr .formsave").off("click");
        $("#studentsCtr .formsave").on("click", function () {
            postStudent();
        });
        $.ajax({
            url: "/project/api/courses",
            method: "get",
            dataType: "json"
        }).done(function (r) {
            console.log(r);
            for (x in r) {
                $("<label><input class='smcourses' type='checkbox' name='smcourses[]' data-id=" + r[x]['id'] + " value=" + r[x]['id'] + ">" + r[x]['name'] + "</label>")
                    .appendTo($(".studentcourses"));
            }
        });
        $("#spinner").fadeOut();
        $("#studentsCtr").fadeIn()
    }
    // new course form reveal
    function newCourse() {
        $(".mainCtr>div").hide()
        notify(false);
        uploadingImg = false;
        $(".studentcount").text("");
        $("#coursesCtr>div>div>span").text("Add Course");
        var fc = document.forms.courseEditForm.elements;
        fc.coursename.value = "";
        fc.coursedesc.value = "";
        $("#coursesCtr .formdelete").hide();
        $("#coursesCtr .formsave").off("click");
        $("#coursesCtr .formsave").on("click", function () {
            postCourse();
        });
        $(".upImg").css("background-image", "url(/project/upload/none.jpg");
        $("#coursesCtr").fadeIn()
    }
    // edit student form reveal and detalis fill
    function editStudent() {
        var student = $("#studentedit").attr("data-id");
        uploadingImg = false;
        $(".mainCtr>div").hide()
        $("#spinner").fadeIn();
        notify(false);
        $("#studentsCtr>div>div>span").text("Edit Student");
        $(".studentcourses").empty();
        $("#studentsCtr .formsave").off("click");
        $("#studentsCtr .formsave").on("click", function () {
            editpostStudent(student);
        });
        $("#studentsCtr .formdelete").off("click");
        $("#studentsCtr .formdelete").on("click", function () {
            deleteStudent(student);
        });
        $("#studentsCtr .formdelete").show();
        $.ajax({
            url: "/project/api/courses",
            method: "get",
            dataType: "json"
        }).done(function (r) {
            console.log(r);
            for (x in r) {
                $("<label><input class='smcourses' type='checkbox' name='smcourses[]' data-id=" + r[x]['id'] + " value=" + r[x]['id'] + ">" + r[x]['name'] + "</label>")
                    .appendTo($(".studentcourses"));
            }
        })
        $.ajax({
            url: "/project/api/students/" + student,
            method: "get",
            dataType: "json"
        }).done(function (r) {
            console.log(r.name);
            var fs = document.forms.studentEditForm.elements;
            fs.studentname.value = r.name;
            fs.studentphone.value = r.phone;
            fs.studentemail.value = r.email;
            fs.upload.value = "";
            $(".upImg").css("background-image", "url(/project/upload/" + r.img + ")");
            for (x in r.courses) {
                $(".smcourses[data-id=" + r['courses'][x]['courseid'] + "]").prop('checked', true)
            }
        })
        $("#spinner").fadeOut();
        $("#studentsCtr").fadeIn();
    }

    function editpostStudent(id) {
        var validation = formValidation("addStudent");
        if (validation != true) {
            notify(true, "bad", "<p><strong>Error! </strong>" + validation.join(', ') + "</p>");
        } else {
            var fs = document.forms.studentEditForm.elements;
            var fcimg = "default";
            $("#studentsCtr").hide();
            $("#spinner").fadeIn();
            if (uploadingImg == true) {
                fcimg = fr.result;
            }
            var postcourses = [];
            $(".smcourses:checked").each(function () {
                postcourses.push($(this).val());
            });
            $.ajax({
                url: "/project/api/students/edit/" + id,
                method: "post",
                dataType: "json",
                data: {
                    pid: id,
                    pname: fs.studentname.value,
                    pphone: fs.studentphone.value,
                    pemail: fs.studentemail.value,
                    pcourses: postcourses,
                    pimg: fcimg
                }
            }).done(function (r) {
                $("#spinner").fadeOut();
                if (r.success) {
                    notify(true, "good", "<p><strong>Success! </strong><i>" + fs.studentname.value + "</i> has been successfully edited in the school system</p>");
                    $("#studentsCtr").fadeIn();
                    listStudent('edit', r['data']['id'], r['data']['name'], r['data']['phone'], r['data']['img']);
                } else {
                    notify(true, "bad", "<p><strong>Error! </strong>" + r.error + "</p>");
                    $("#studentsCtr").fadeIn();
                }
            });
        }
    }
    // edit student form reveal and detalis fill
    function editCourse() {
        course = $("#courseedit").attr("data-id");
        uploadingImg = false;
        console.log(course);
        $(".mainCtr>div").hide()
        $("#spinner").fadeIn();
        notify(false);
        $("#coursesCtr>div>div>span").text("Edit Course");
        $(".coursestudents").empty();
        $("#coursesCtr .formsave").off("click");
        $("#coursesCtr .formsave").on("click", function () {
            editpostCourse(course);
        });
        $("#coursesCtr .formdelete").hide();
        $("#coursesCtr .formdelete").off("click");
        $("#coursesCtr .formdelete").on("click", function () {
            deleteCourse(course);
        });
        $.ajax({
            url: "/project/api/courses/" + course,
            method: "get",
            dataType: "json"
        }).done(function (r) {
            var fc = document.forms.courseEditForm.elements;
            fc.coursename.value = r.name;
            fc.coursedesc.value = r.description;
            $(".upImg").css("background-image", "url(/project/upload/" + r.img + ")");
            var si = 0;
            $(".studentcountwar").hide();
            for (x in r.students) {
                si++;
            }
            if (si == 0) {
                $("#coursesCtr .formdelete").show();
            }
            $(".studentcount").text("There are " + si + " students in this course");
            if (si > 0) {
                $(".studentcountwar").show();
            }
        })
        $("#spinner").fadeOut();
        $("#coursesCtr").fadeIn();
    }
    // delete Course Prompt
    function deleteCourse(id) {
        $(".mainCtr>div").hide()
        notify(false);
        $("#deleteCtr .formback").off("click");
        $("#deleteCtr .formback").on("click", function () {
            editCourse();
        });
        $.ajax({
            url: "/project/api/courses/" + id,
            method: "get",
            dataType: "json"
        }).done(function (r) {
            $("#deleteCtr .formdelete").off("click");
            $("#deleteCtr .formdelete").on("click", function () {
                deletepostCourse(id, r.name);
            });
            $("#deleteCtr h2").text(r.name);
            $("#deleteCtr .upImg").css("background-image", "url(/project/upload/" + r.img + ")");
        });
        $("#deleteCtr").fadeIn();
    }
    // delete Student Prompt
    function deleteStudent(id) {
        $(".mainCtr>div").hide()
        notify(false);
        $("#deleteCtr .formback").off("click");
        $("#deleteCtr .formback").on("click", function () {
            editStudent();
        });
        $.ajax({
            url: "/project/api/students/" + id,
            method: "get",
            dataType: "json"
        }).done(function (r) {
            $("#deleteCtr .formdelete").off("click");
            $("#deleteCtr .formdelete").on("click", function () {
                deletepostStudent(id, r.name);
            });
            $("#deleteCtr h2").text(r.name);
            $("#deleteCtr .upImg").css("background-image", "url(/project/upload/" + r.img + ")");
        });
        $("#deleteCtr").fadeIn();
    }
    // courses list grabbing and dumping
    function coursesRoll() {
        $.ajax({
            url: "/project/api/courses",
            method: "get",
            dataType: "json"
        }).done(function (r) {
            for (x in r) {
                listCourse('add', r[x]['id'], r[x]['name'], r[x]['img']);
                listCourseClick();
            }
        });
    }
    // adding course items to list
    function listCourse(action, id, name, img) {
        if (action == 'add') {
            $("<li class='courseitem' data-id='courses' data-postid='" + id + "'>" +
                "<div class='img' style='background-image: url(/project/upload/" + img + ")'></div>" +
                "<div class='listText'>" +
                "<span>" + id + "</span>" +
                "<span>" + name + "</span>" +
                "</div>" +
                "</li>").appendTo(".courselist");
        }
        if (action == 'edit') {
            console.log("im here and im changing - " + name);
            $(".courseitem[data-postid=" + id + "]").html(
                "<div class='img' style='background-image: url(/project/upload/" + img + ")'></div>" +
                "<div class='listText'>" +
                "<span>" + id + "</span>" +
                "<span>" + name + "</span>" +
                "</div>" +
                "</li>");
        }
        if (action == 'delete') {
            $(".courseitem[data-postid=" + id + "]").remove();
        }
    }

    function listStudent(action, id, name, phone, img) {
        if (action == 'add') {
            $("<li class='studentitem' data-id='students' data-postid='" + id + "'>" +
                "<div class='img' style='background-image: url(/project/upload/" + img + ")'></div>" +
                "<div class='listText'>" +
                "<span>" + id + "</span>" +
                "<span>" + name + "</span>" +
                "<span>" + phone + "</span>" +
                "</div>" +
                "</li>").appendTo(".studentlist");
        }
        if (action == 'edit') {
            console.log("im here and im changing - " + name);
            $(".studentitem[data-postid=" + id + "]").html(
                "<div class='img' style='background-image: url(/project/upload/" + img + ")'></div>" +
                "<div class='listText'>" +
                "<span>" + id + "</span>" +
                "<span>" + name + "</span>" +
                "<span>" + phone + "</span>" +
                "</div>" +
                "</li>");
        }
        if (action == 'delete') {
            $(".studentitem[data-postid=" + id + "]").remove();
        }
    }
    // add clicker events to the courses and students list
    function listCourseClick() {
        $(".courseitem").off('click');
        $(".courseitem").on('click', function () {
            courseMultipass($(this));
        });
    }

    function listStudentClick() {
        $(".studentitem").off('click');
        $(".studentitem").on('click', function () {
            studentMultipass($(this));
        });
    }
    // student list grabbing and dumping
    function studentsRoll() {
        $.ajax({
            url: "/project/api/students",
            method: "get",
            dataType: "json"
        }).done(function (r) {
            for (x in r) {
                listStudent('add', r[x]['id'], r[x]['name'], r[x]['phone'], r[x]['img']);
                listStudentClick();
            }
        });
    }
    // Student information
    function studentMultipass(li) {
        console.log($(this));
        $(".mainCtr>div").hide()
        $("#spinner").fadeIn();
        $(".studentcourselist").empty();
        $.ajax({
            url: "/project/api/students/" + li.data("postid"),
            method: "get",
            dataType: "json"
        }).done(function (r) {
            $(".smImg").css("background-image", "url(/project/upload/" + r.img + ")");
            $(".smname").text(r.name);
            $(".smphone").text(r.phone);
            $(".smemail").text(r.email);
            $("#studentedit").attr("data-id", r.id);
            for (x in r.courses) {
                $("<li>" +
                    "<div class='img' style='background-image: url(/project/upload/" + r['courses'][x]['img'] + "'></div>" +
                    "<div class='listText'>" +
                    "<span>" + r['courses'][x]['courseid'] + "</span>" +
                    "<span>" + r['courses'][x]['name'] + "</span>" +
                    "</div>" +
                    "</li>").appendTo(".studentcourselist");
            }
            $("#spinner").fadeOut();
            $("#studentMultipass").fadeIn();
        })
    }
    // Course information
    function courseMultipass(li) {
        $(".mainCtr>div").hide()
        $("#spinner").fadeIn();
        $(".coursestudentlist").empty();
        $.ajax({
            url: "/project/api/courses/" + li.data("postid"),
            method: "get",
            dataType: "json"
        }).done(function (r) {
            $(".coImg").css("background-image", "url(/project/upload/" + r.img + ")");
            $(".coname").text(r.name);
            $(".codesc").text(r.description);
            if (power == "Sales") {
                $("#courseedit").hide();
            } else {
                $("#courseedit").attr("data-id", r.id);
            }
            var si = 0;
            for (x in r.students) {
                si++;
                $("<li>" +
                    "<div class='img' style='background-image: url(/project/upload/" + r['students'][x]['img'] + "'></div>" +
                    "<div class='listText'>" +
                    "<span>" + r['students'][x]['studentid'] + "</span>" +
                    "<span>" + r['students'][x]['name'] + "</span>" +
                    "</div>" +
                    "</li>").appendTo(".coursestudentlist");
            }
            $(".costudents").text("Number of Students: " + si);
            $("#spinner").fadeOut();
            $("#courseMultipass").fadeIn();
        })
    }

    function postStudent() {
        var validation = formValidation("addStudent");
        if (validation != true) {
            notify(true, "bad", "<p><strong>Error! </strong>" + validation.join(', ') + "</p>");
        } else {
            var fs = document.forms.studentEditForm.elements;
            var fcimg = 'none.jpg';
            $("#studentsCtr").hide();
            $("#spinner").fadeIn();
            if (uploadingImg == true) {
                fcimg = fr.result;
            }
            var postcourses = [];
            $(".smcourses:checked").each(function () {
                postcourses.push($(this).val());
            });
            $.ajax({
                url: "/project/api/students/add",
                method: "post",
                dataType: "json",
                data: {
                    pid: newId(),
                    pname: fs.studentname.value,
                    pphone: fs.studentphone.value,
                    pemail: fs.studentemail.value,
                    pcourses: postcourses,
                    pimg: fcimg
                }
            }).done(function (r) {
                $("#spinner").fadeOut();
                if (r.success) {
                    notify(true, "good", "<p><strong>Success! </strong><i>" + fs.studentname.value + "</i> has been successfully added to the school system</p>");
                    $("#studentsCtr").fadeIn();
                    listStudent('add', r['data']['id'], r['data']['name'], r['data']['phone'], r['data']['img']);
                    listStudentClick();
                } else {
                    notify(true, "bad", "<p><strong>Error! </strong>" + r.error + "</p>");
                    $("#studentsCtr").fadeIn();
                }
            });
        }
    }
    // adding a course and sending it to the server via POST
    function postCourse() {
        var validation = formValidation("addCourse");
        if (validation != true) {
            notify(true, "bad", "<p><strong>Error! </strong>" + validation.join(', ') + "</p>");
        } else {
            var fc = document.forms.courseEditForm.elements;
            var fcimg = 'none.jpg';
            $("#coursesCtr").hide();
            $("#spinner").fadeIn();
            if (uploadingImg == true) {
                fcimg = fr.result;
            }
            $.ajax({
                url: "/project/api/courses/add",
                method: "post",
                dataType: "json",
                data: {
                    pname: fc.coursename.value,
                    pdesc: fc.coursedesc.value,
                    pimg: fcimg
                }
            }).done(function (r) {
                $("#spinner").fadeOut();
                if (r.success) {
                    notify(true, "good", "<p><strong>Success! </strong><i>" + fc.coursename.value + "</i> has been successfully added to the school system</p>");
                    $("#coursesCtr").fadeIn();
                    listCourse('add', r['data']['id'], r['data']['name'], r['data']['img']);
                    listCourseClick();
                } else {
                    notify(true, "bad", "<p><strong>Error! </strong>" + r.error + "</p>");
                    $("#coursesCtr").fadeIn();
                }
            });
        }
    }

    function editpostCourse(id) {
        console.log(id);
        var validation = formValidation("addCourse");
        if (validation != true) {
            notify(true, "bad", "<p><strong>Error! </strong>" + validation.join(', ') + "</p>");
        } else {
            var fc = document.forms.courseEditForm.elements;
            var fcimg = "default";
            console.log("IMG is: " + fcimg);
            $("#coursesCtr").hide();
            $("#spinner").fadeIn();
            if (uploadingImg == true) {
                fcimg = fr.result;
            }
            $.ajax({
                url: "/project/api/courses/edit/" + id,
                method: "post",
                dataType: "json",
                data: {
                    pname: fc.coursename.value,
                    pdesc: fc.coursedesc.value,
                    pimg: fcimg
                }
            }).done(function (r) {
                $("#spinner").fadeOut();
                if (r.success) {
                    notify(true, "good", "<p><strong>Success! </strong><i>" + fc.coursename.value + "</i> has been successfully edited in the school system</p>");
                    $("#coursesCtr").fadeIn();
                    listCourse('edit', r['data']['id'], r['data']['name'], r['data']['img']);
                } else {
                    notify(true, "bad", "<p><strong>Error! </strong>" + r.error + "</p>");
                    $("#coursesCtr").fadeIn();
                }
            });
        }
    }

    function deletepostCourse(id, name) {
        $("#coursesCtr").hide();
        $("#spinner").fadeIn();
        $.ajax({
            url: "/project/api/courses/delete/" + id,
            method: "post",
            dataType: "json",
            data: {
                pid: id
            }
        }).done(function (r) {
            $("#spinner").fadeOut();
            if (r.success) {
                listCourse('delete', r['data']['id']);
                Home(name + " Has been successfully removed from the system", "bad");
            } else {
                Home(r.error, "bad");
            }
        })
    }

    function deletepostStudent(id, name) {
        $("#studentsCtr").hide();
        $("#spinner").fadeIn();
        $.ajax({
            url: "/project/api/students/delete/" + id,
            method: "post",
            dataType: "json",
            data: {
                pid: id
            }
        }).done(function (r) {
            $("#spinner").fadeOut();
            if (r.success) {
                listStudent('delete', r['data']['id']);
                Home(name + " Has been successfully removed from the system", "bad");
            } else {
                Home(r.error, "bad");
            }
        })
    }

    function formValidation(form) {
        if (form == 'addCourse') {
            var fc = document.forms.courseEditForm.elements;
            var err = [];
            if (fc.coursename.value == "") {
                err.push('Missing Course Name');
            }
            if (fc.coursedesc.value == "") {
                err.push('Missing Course Description');
            }
            if (err.length > 0) {
                return err;
            } else {
                return true;
            }
        }
        if (form == 'addStudent') {
            var fs = document.forms.studentEditForm.elements;
            var err = [];
            if (fs.studentname.value == "") {
                err.push('Missing Student Name');
            }
            if (fs.studentphone.value == "") {
                err.push('Missing Student Phone');
            }
            if (fs.studentemail.value == "") {
                err.push('Missing Student Email');
            }
            if (isNaN(fs.studentphone.value)) {
                err.push('Phone can only contain numbers');
            }
            if (fs.studentphone.value.length < 10) {
                err.push('Not a valid Phone Number (10 digits)');
            }
            if (!validemail(fs.studentemail.value)) {
                err.push('Not a valid Email');
            }
            if (err.length > 0) {
                return err;
            } else {
                return true;
            }
        }
    }

    function validemail(email) {
        // check for @
        var atSymbol = email.indexOf("@");
        if (atSymbol < 1) return false;

        var dot = email.indexOf(".");
        if (dot <= atSymbol + 2) return false;

        // check that the dot is not at the end
        if (dot === email.length - 1) return false;
        return true;
    }

    function newId() {
        var d = new Date();
        var n = d.getTime();
        var rnd = Math.floor(Math.random() * 100);
        var id = "369" + n.toString() + rnd.toString();
        id = id.slice(3, 14)
        return Number(id);
    }
    init();
});