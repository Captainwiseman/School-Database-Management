$(function () {
    console.log("jq admin running");
    // global variable, the power of the user logged
    var power = $("#SessionData").data("session");
    var logged = $("#SessionData").data("id");
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
            $(".addadmin").show();
            $(".addadmin").on("click", function () {
                newAdmin();
            });
        };
        $("#adminedit").on("click", function () {
            editAdmin();
        });
        notify(false);
        adminsRoll();
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
        $(".adminMainCtr>div").hide()
        sysCount();
        if (type == 'good') {
            $("#adminHomeCtr h1").css('color', 'white');
        }
        if (type == 'bad') {
            $("#adminHomeCtr h1").css('color', 'red');
        }
        $("#adminHomeCtr h1").text(msg);
        $('#adminHomeCtr').fadeIn();
    }

    function adminsRoll() {
        $.ajax({
            url: "/project/api/admins",
            method: "get",
            dataType: "json"
        }).done(function (r) {
            for (x in r) {
                if (power == "Owner") {
                    listAdmin('add', r[x]['id'], r[x]['name'], r[x]['role'], r[x]['phone'], r[x]['img']);
                }
                if (power == "Manager") {
                    if (r[x]['role'] == "Manager" || r[x]['role'] == "Sales")
                        listAdmin('add', r[x]['id'], r[x]['name'], r[x]['role'], r[x]['phone'], r[x]['img']);
                }
                listAdminClick();
            }
        });
    }

    function listAdmin(action, id, name, role, phone, img) {
        if (action == 'add') {
            $("<li class='adminitem' data-id='admins' data-postid='" + id + "'>" +
                "<div class='img' style='background-image: url(/project/upload/" + img + ")'></div>" +
                "<div class='listText'>" +
                "<span>" + id + "</span>" +
                "<span>" + name + "</span>" +
                "<span>" + role + "</span>" +
                "<span>" + phone + "</span>" +
                "</div>" +
                "</li>").appendTo(".adminslist");
        }
        if (action == 'edit') {
            console.log("im here and im changing - " + name);
            $(".adminitem[data-postid=" + id + "]").html(
                "<div class='img' style='background-image: url(/project/upload/" + img + ")'></div>" +
                "<div class='listText'>" +
                "<span>" + id + "</span>" +
                "<span>" + name + "</span>" +
                "<span>" + role + "</span>" +
                "<span>" + phone + "</span>" +
                "</div>" +
                "</li>");
        }
        if (action == 'delete') {
            $(".adminitem[data-postid=" + id + "]").remove();
        }
    }

    function listAdminClick() {
        $(".adminitem").off('click');
        $(".adminitem").on('click', function () {
            adminMultipass($(this));
        });
    }
    // database items counter
    function sysCount() {
        var adminscount = 0;
        $.ajax({
            url: "/project/api/admins",
            method: "get",
            dataType: "json"
        }).done(function (r) {
            for (x in r) {
                adminscount++
            }
            $("#adminHomeCtr h2:nth-child(2)").text(adminscount + " Admins in the system");
        });
    }

    function newAdmin() {
        $(".adminMainCtr>div").hide();
        $("#adminsCtr select").empty();
        notify(false);
        var fa = document.forms.adminEditForm.elements;
        fa.adminname.value = "";
        fa.adminphone.value = "";
        fa.adminrole.value = "";
        fa.adminemail.value = "";
        $("<option value='Sales'>Sales</option>").appendTo($("#adminsCtr select"));
        $("<option value='Manager'>Manager</option>").appendTo($("#adminsCtr select"));
        $("#adminsCtr>div>div>span").text("Add User");
        $(".upImg").css("background-image", "url(/project/upload/none.jpg");
        $("#adminsCtr .formdelete").hide();
        $("#adminsCtr .formsave").off("click");
        $("#adminsCtr .formsave").on("click", function () {
            postAdmin();
        });
        $("#adminsCtr").fadeIn()
    }

    function editAdmin() {
        $(".adminMainCtr>div").hide();
        $("#adminsCtr select").empty();
        $("<option value='Sales'>Sales</option>").appendTo($("#adminsCtr select"));
        $("<option value='Manager'>Manager</option>").appendTo($("#adminsCtr select"));
        admin = $("#adminedit").attr("data-id");
        uploadingImg = false;
        $(".adminMainCtr>div").hide()
        $("#spinner").fadeIn();
        notify(false);
        $("#adminsCtr>div>div>span").text("Edit User");
        $("#adminsCtr .formsave").off("click");
        $("#adminsCtr .formsave").on("click", function () {
            editpostAdmin(admin);
        });
        $("#adminsCtr .formdelete").off("click");
        $("#adminsCtr .formdelete").hide();
        $.ajax({
            url: "/project/api/admins/" + admin,
            method: "get",
            dataType: "json"
        }).done(function (r) {
            $(".roleselector").prop('disabled', false);
            // if user is the owner, and he edits sales or mangers, he can delete
            if (power == "Owner") {
                if (r.role == "Sales" || r.role == "Manager") {
                    $("#adminsCtr .formdelete").show();
                    $("#adminsCtr .formdelete").on("click", function () {
                        deleteAdmin(admin);
                    });
                }
                // if he edits himself, he cannot change his role
                if (r.role == "Owner") {
                    $("<option value='Owner'>Owner</option>").appendTo($("#adminsCtr select"));
                    $(".roleselector").prop('disabled', true);
                }
                // if user is manager and he edits sales, he can delete
            } else if (power == "Manager") {
                if (r.role == "Sales") {
                    $("#adminsCtr .formdelete").show();
                    $("#adminsCtr .formdelete").on("click", function () {
                        deleteAdmin(admin);
                    });
                }
                // if he edits himself, he cannot change his role
                if (r.role == "Manager") {
                    $(".roleselector").prop('disabled', true);
                }
            }
            var fa = document.forms.adminEditForm.elements;
            fa.adminname.value = r.name;
            fa.adminphone.value = r.phone;
            fa.adminpassword.value = "";
            fa.adminrole.value = r.role;
            fa.adminemail.value = r.email;
            $(".upImg").css("background-image", "url(/project/upload/" + r.img + ")");
        })
        $("#spinner").fadeOut();
        $("#adminsCtr").fadeIn();
    }

    function adminMultipass(li) {
        console.log($(this));
        $(".adminMainCtr>div").hide()
        $("#spinner").fadeIn();
        $("#adminedit").hide();
        $.ajax({
            url: "/project/api/admins/" + li.data("postid"),
            method: "get",
            dataType: "json"
        }).done(function (r) {
            $(".amImg").css("background-image", "url(/project/upload/" + r.img + ")");
            $(".amname").text(r.name);
            $(".amrole").text(r.role);
            $(".amphone").text(r.phone);
            $(".amemail").text(r.email);
            if (power == "Owner") {
                $("#adminedit").attr("data-id", r.id);
                $("#adminedit").show();
            }
            if (power == "Manager" && r.role == "Manager" && li.data("postid") == logged) {
                $("#adminedit").attr("data-id", r.id);
                $("#adminedit").show();
            }
            if (power == "Manager" && r.role == "Sales") {
                $("#adminedit").attr("data-id", r.id);
                $("#adminedit").show();
            }
            $("#spinner").fadeOut();
            $("#adminMultipass").fadeIn();
        })
    }

    function postAdmin() {
        var validation = adminValidation();
        if (validation != true) {
            notify(true, "bad", "<p><strong>Error! </strong>" + validation.join(', ') + "</p>");
        } else {
            var fa = document.forms.adminEditForm.elements;
            var fcimg = 'none.jpg';
            $("#adminsCtr").hide();
            $("#spinner").fadeIn();
            if (uploadingImg == true) {
                fcimg = fr.result;
            }
            $.ajax({
                url: "/project/api/admins/add",
                method: "post",
                dataType: "json",
                data: {
                    pid: newId(),
                    pname: fa.adminname.value,
                    ppassword: fa.adminpassword.value,
                    pphone: fa.adminphone.value,
                    pemail: fa.adminemail.value,
                    prole: fa.adminrole.value,
                    pimg: fcimg
                }
            }).done(function (r) {
                fa.adminpassword.value = "";
                $("#spinner").fadeOut();
                if (r.success) {
                    notify(true, "good", "<p><strong>Success! </strong><i>" + fa.adminname.value + "</i> has been successfully added to the school system</p>");
                    $("#adminsCtr").fadeIn();
                    listAdmin('add', r['data']['id'], r['data']['name'], r['data']['role'], r['data']['phone'], r['data']['img']);
                    listAdminClick();
                } else {
                    notify(true, "bad", "<p><strong>Error! </strong>" + r.error + "</p>");
                    $("#adminsCtr").fadeIn();
                }
            });
        }
    }

    function editpostAdmin(id) {
        var validation = adminValidation();
        if (validation != true) {
            notify(true, "bad", "<p><strong>Error! </strong>" + validation.join(', ') + "</p>");
        } else {
            var fa = document.forms.adminEditForm.elements;
            var fcimg = 'default';
            $("#adminsCtr").hide();
            $("#spinner").fadeIn();
            if (uploadingImg == true) {
                fcimg = fr.result;
            }
            $.ajax({
                url: "/project/api/admins/edit/" + id,
                method: "post",
                dataType: "json",
                data: {
                    pid: id,
                    pname: fa.adminname.value,
                    ppassword: fa.adminpassword.value,
                    pphone: fa.adminphone.value,
                    pemail: fa.adminemail.value,
                    prole: fa.adminrole.value,
                    pimg: fcimg
                }
            }).done(function (r) {
                $("#spinner").fadeOut();
                fa.adminpassword.value = "";
                if (r.success) {
                    notify(true, "good", "<p><strong>Success! </strong><i>" + fa.adminname.value + "</i> has been successfully added to the school system</p>");
                    $("#adminsCtr").fadeIn();
                    listAdmin('edit', r['data']['id'], r['data']['name'], r['data']['role'], r['data']['phone'], r['data']['img']);
                    listAdminClick();
                    if (logged == r['data']['id']) {
                        $(".name").text(r['data']['name'] + ", " + r['data']['role']);
                        $(".credimg").css("background-image", "url(/project/upload/" + r['data']['img'] + ")");
                    }
                } else {
                    notify(true, "bad", "<p><strong>Error! </strong>" + r.error + "</p>");
                    $("#adminsCtr").fadeIn();
                }
            });
        }
    }

    function deletepostAdmin(id) {
        $("#adminsCtr").hide();
        $("#spinner").fadeIn();
        $.ajax({
            url: "/project/api/admins/delete/" + id,
            method: "post",
            dataType: "json",
            data: {
                pid: id
            }
        }).done(function (r) {
            if (r.success) {
                $("#spinner").fadeOut();
                listAdmin('delete', r['data']['id']);
                Home(name + " Has been successfully removed from the system", "bad");
            } else {
                Home(r.error, "bad");
            }
        })
    }

    function deleteAdmin(id) {
        $(".adminMainCtr>div").hide()
        notify(false);
        $("#deleteCtr .formback").off("click");
        $("#deleteCtr .formback").on("click", function () {
            editAdmin();
        });
        $.ajax({
            url: "/project/api/admins/" + id,
            method: "get",
            dataType: "json"
        }).done(function (r) {
            $("#deleteCtr .formdelete").off("click");
            $("#deleteCtr .formdelete").on("click", function () {
                deletepostAdmin(id, r.name);
            });
            $("#deleteCtr h2").text(r.name);
            $("#deleteCtr .upImg").css("background-image", "url(/project/upload/" + r.img + ")");
        });
        $("#deleteCtr").fadeIn();
    }

    function adminValidation() {
        var fa = document.forms.adminEditForm.elements;
        var err = [];
        if (fa.adminname.value == "") {
            err.push('Missing User Name');
        }
        if (fa.adminpassword.value == "") {
            err.push('Missing Password');
        }
        if (fa.adminphone.value == "") {
            err.push('Missing Phone Number');
        }
        if (fa.adminemail.value == "") {
            err.push('Missing Email');
        }
        if (isNaN(fa.adminphone.value)) {
            err.push('Phone can only contain numbers')
        }
        if (fa.adminphone.value.length < 10) {
            err.push('Not a valid Phone Number (10 digits)');
        }
        if (!validemail(fa.adminemail.value)) {
            err.push('Not a valid Email');
        }
        if (err.length > 0) {
            return err;
        } else {
            return true;
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
        var id = "9369" + n.toString() + rnd.toString();
        id = id.slice(3, 14)
        return Number(id);
    }
    init();
});