$(function() {
//    make by bossrover
//    $("div#loginform form").on('submit',function(){
//        return false;
//    });
    
//    $("#check_remember").bootstrapSwitch();

    /*==============================================================*/
    /* Focusing */
    /* //now using after modal event in "menutop.php"
    if($("#username").val() !== "")
    {
        //when cookie is usable, always check this box until remove it
        $("#password").focus();
        $("#check_remember").prop("checked",true);
    }else
    {
        $("#username").focus();
        $("#check_remember").prop("checked",false);
    }
    */
    /*=============================================================*/
    
    $("#txtBoxWarning").hide();
    $("div#loginform form").validate({
        rules: {
            username: {
                required: true
            },
            password: {
                required: true
            }
        },
        messages: {
                username: {
                    required: "Username is required!"
                        //,minlength: "Field PostCode must contain at least 3 characters"
                },
                password: {
                    required: "Password is required!"
                        //,minlength: "Field PostCode must contain at least 3 characters"
                }
        },        
        highlight: function (element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function (element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function(form){
            $("#txtBoxWarning").hide();
            $("#submit_login").prop('disabled', true);
            $.post('login/run', {'username': $("#username").val(),'password': $("#password").val()}, function (o) {
                        if (o.chk) {
                            
                            /*store username into cookie when checked*/
                            if (check_remember.checked === true) {
                                var days = 10; // กำหนดจำนวนวันที่ต้องการให้จำค่า  
                                var date = new Date();
                                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                                var expires = "; expires=" + date.toGMTString();
                                document.cookie = "CK_username=" + $("#username").val() + "; expires=" + expires + "; path=/";
                                
                            } else {
                                var expires = "";
                                document.cookie = "CK_username=" + expires + ";-1;path=/";
                            }  
                            
                            window.location.href = o.url + 'index';
                            
                        } else {
                            $("#txtBoxWarning").show();
                            $("#txtWarning").html("ไม่พบชื่อผู้ใช้นี้ในระบบ กรุณากรอกข้อมูลใหม่อีกครั้ง หรือติดต่อศูนย์คอมพิวเตอร์");
                            $("#submit_login").prop('disabled', false);
                        }
                    }, 'json');          
                    return false;
        }
    });
    

});