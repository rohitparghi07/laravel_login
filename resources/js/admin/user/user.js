$(document).ready(function() {

    if (isUserValidationError ) {
        $('#modal-default').modal('show'); 
    }

    page_load();  

    //get data in pageload from storage and initialize table
    function page_load() {
        var table = $("#userTable").DataTable({
            responsive: true,
            paging: true,
            processing: true,
            serverSide: true,
            lengthMenu: [15],
            saveState: true,
            defaultContent: "-",
            bDestroy: true,
            ajax: {
                url: AdminUrl+"user/getUserDataTable",
                type: "get",
                dataType: "json",
                dataSrc: function(res) {
                    return res["data"];
                }
            },
            lengthChange: false,
            searching: true,
            info: true,
            autoWidth: false,
            language: {
                emptyTable: "No data available"
            },
            columns: [
                {
                    width: "5%",
                    data: "id",
                    orderable: true
                },
                {
                    width: "20%",
                    data: "fullname",
                    orderable: true
                },
                {
                    width: "8%",
                    data: "dob",
                    orderable: false
                },
                {
                    width: "10%",
                    data: "user_name",
                    orderable: true
                },
                {
                    width: "13%",
                    data: "email",
                    orderable: true
                },                   
                {
                    width: "6%",
                    orderable: false
                },
                {
                    width: "6%",
                    orderable: false
                }
            ],
            columnDefs: [
                {
                    // edit
                    targets: [5],
                    render: function(a, b, data, d) {
                        return '<a href="#" data-id="'+data.id+'" class="editUser"><i class="fa fa-edit"></i> Edit</a>';
                    }
                },
                {
                    // delete
                    targets: [6],
                    render: function(a, b, data, d) {
                        return '<a href="#" data-id="'+data.id+'" class="deleteUser"><i class="fas fa-trash-alt"></i> Delete</a>';
                    }
                }
            ],
            order: [[0, "desc"]],
        });
    }

    // date oicker initialized 
    function setDatePicker(){
        $("#dob").datepicker({
            autoclose: true,
            format: 'dd/mm/yyyy' 
        }).datepicker("setDate", new Date());
    }

    // add new users
    $("#adduser").on("click", function() {
        $(".error").text('');
        $("#userId").remove();
        $(".is-invalid").removeClass('is-invalid');
        $('#user-form')[0].reset();
        setDatePicker();
    });

    // delete user record with ajax call
    $("#user-delete").on("click",function(e){
        e.preventDefault();
        var id=  $("#delete-user-model #userId").val();
        $.ajax({
            url: AdminUrl+"user/deleteUserDetail",
            type: "post",
            dataType: "json",
            data: {
                id:id, 
                _token:postToken
            },
            success: function (response) {
                page_load();  
                $('#headerMsg').html("<div class='alert alert-success'><h4><i class='icon fa fa-check'></i> Success </h4> " + response.message + "</div>");
                setTimeout(() => {
                    $("#headerMsg").empty();
                }, 5000);
            },
            error: function (response) {
                var message = response.responseJSON.message;
                setErrorPropmt(message)
                // $('#headerMsg').html("<div class='alert alert-danger'><h4><i class='fas fa-exclamation-circle'></i> Warning </h4> " + response.responseJSON.message + "</div>");
                // setTimeout(() => {
                //     $("#headerMsg").empty();
                // }, 5000);
            }
        });
    });


    // delete user confirm message show 
    $(document).on("click",".deleteUser",function(e){
        e.preventDefault();
        var id=$(this).data('id');
        $("#delete-user-model #userId").remove();
        $("<input>").attr({
            name: "id",
            id: "userId",
            type: "hidden",
            value: id
        }).appendTo("#delete-user-model");

        $("#delete-user-model").modal('show'); 

    });

    // update users
    $(document).on("click", ".editUser",function(e) {
        e.preventDefault();
        var id=$(this).data('id');
        $(".error").text('');
        $(".is-invalid").removeClass('is-invalid');
        $("#userId").remove();
        $('#user-form')[0].reset();
        $.ajax({
            url: AdminUrl+"user/getUserDetail",
            type: "post",
            dataType: "json",
            data: {
                id:id, 
                _token:postToken
            },
            success: function (response) {
                $('#modal-default').modal('show'); 

                $("<input>").attr({
                    name: "id",
                    id: "userId",
                    type: "hidden",
                    value: response.user.id
                }).appendTo("#user-form");

                $("#fname").val(response.user.fname);
                $("#lname").val(response.user.lname);
                $("#dob").val(response.user.dob);
                $("#username").val(response.user.user_name);
                $("#email").val(response.user.email);

                $("#dob").datepicker({
                    autoclose: true,
                    format: 'dd/mm/yyyy' 
                }).datepicker("setDate", response.user.dob);
            },
            error: function (response) {
                $('#headerMsg').html("<div class='alert alert-danger'><h4><i class='fas fa-exclamation-circle'></i> Warning </h4> " + response.responseJSON.message + "</div>");
                setTimeout(() => {
                    $("#headerMsg").empty();
                }, 5000);
            }
        });
    });

    // user form jquery validation
    $('#user-form').validate({
        rules: {
            fname: {
                required: true,
                normalizer: function (value) {
                    return $.trim(value);
                }
            },
            lname: {
                required: true,
                normalizer: function (value) {
                    return $.trim(value);
                }
            },
            email: {
                required: true,
                email: true,
                normalizer: function (value) {
                    return $.trim(value);
                },
                remote: {
                    url: AdminUrl + "user/checkEmailExists",
                    type: "post",
                    data: {
                        id: function () {
                            return  $('#userId').val();
                        },
                        email:function(){
                            return $('#email').val();
                        },
                        _token:postToken
                    }
                },
            },
            dob: {
                required: true,
                normalizer: function (value) {
                    return $.trim(value);
                }
            },
            username: {
                required: true,
                normalizer: function (value) {
                    return $.trim(value);
                },
                remote: {
                    url: AdminUrl + "user/checkUserNameExists",
                    type: "post",
                    data: {
                        id: function () {
                            return  $('#userId').val();
                        },
                        username:function(){
                            return $('#username').val();
                        },
                        _token:postToken
                    }
                },

            },
            password : {
                minlength : 5
            },
            confirmPassword : {
                minlength : 5,
                equalTo : "#password"
            }
        },
        messages: {
            fname: {
                required: "Please enter a first name"
            },
            lname: {
                required: "Please enter a last name"
            },
            email: {
                required: "Please enter a email address",
                email: "Please enter a vaild email address",
                remote: "Email Address Already Taken"
            },
            username:{
                required: "Please enter a user name",
                remote: "UserName Already Taken."
            }
        
        },
        errorElement: 'label',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback offset-sm-3');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function(form) {
            $('#fname-error').text('');
            $('#lname-error').text('');
            $('#dob-error').text('');
            $('#email-error').text('');
            $('#username-error').text('');
            $('#password-error').text('');
            $('#confirmPassword-error').text('');

            $.ajax({
                url: AdminUrl + "user/save-user-data", 
                type: "POST",             
                data: {
                    id: function () {
                        return  $('#userId').val();
                    },
                    fname:function(){
                        return $('#fname').val();
                    },
                    lname:function(){
                        return $('#lname').val();
                    },
                    dob:function(){
                        return $('#dob').val();
                    },
                    username:function(){
                        return $('#username').val();
                    },
                    email:function(){
                        return $('#email').val();
                    },
                    password:function(){
                        return $('#password').val();
                    },
                    confirmPassword:function(){
                        return $('#confirmPassword').val();
                    },
                    _token:postToken    
                },
                cache: false,             
                processData: true,      
                success: function(response) {
                   $('#modal-default').modal('hide'); 
                   page_load();  
                   $('#headerMsg').html("<div class='alert alert-success'><h4><i class='icon fa fa-check'></i> Success </h4> " + response.message + "</div>");
                  
                   setTimeout(() => {
                       $("#headerMsg").empty();
                   }, 5000);
                },
                error: function(response) {
                   var message = response.responseJSON.message;
                   setErrorPropmt(message);

                   $('#fname-error').text(response.responseJSON.errors.fname);
                   $('#lname-error').text(response.responseJSON.errors.lname);
                   $('#dob-error').text(response.responseJSON.errors.dob);
                   $('#email-error').text(response.responseJSON.errors.email);
                   $('#username-error').text(response.responseJSON.errors.username);
                   $('#password-error').text(response.responseJSON.errors.password);
                   $('#confirmPassword-error').text(response.responseJSON.errors.confirmPassword);

                }
            });
            return false;
        },
    });

    // message remove after 3 second
    setTimeout(() => {
        $("#headerMsg").empty();
    }, 5000);


    function setErrorPropmt(message){
        $('#headerMsg').html("<div class='alert alert-danger'><h4><i class='fas fa-exclamation-circle'></i> Warning </h4> " + message + "</div>");
        setTimeout(() => {
            $("#headerMsg").empty();
        }, 5000);
    }
});