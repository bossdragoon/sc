<div id="loginform">
<!--//    make by Shikaru--> 
    <form class="form-signin" id="loginform_form" role="form" action="login/run" method="post">
        <h2 class="form-signin-heading">Please sign in</h2>
        <p>กรอกชื่อผู้ใช้และรหัสผ่าน เพื่อเข้าใช้งานระบบ NMS</p>
    <hr>
    <div class="form-group">
        <label for="username" class="sr-only">Username</label>
        <input type="text" id="username" name="username" value="<?=$_COOKIE['CK_username']?>" class="form-control" placeholder="Username" required />        
    </div>
    <div class="form-group">
        <label for="password" class="sr-only">Password</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Password" required />
    </div>
    <div class="checkbox">
        <label><input type="checkbox" id="check_remember"> จำ username ผู้ใช้งานเมื่อเข้าใช้ครั้งถัดไป</label>
    </div>
    <div id="txtBoxWarning" class="alert alert-danger" role="alert">
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <span class="sr-only">Error:</span>
        <span id="txtWarning"></span>
    </div>    
    <hr>
    <button class="btn btn-lg btn-primary btn-block" type="submit" id="submit_login">เข้าสู่ระบบ (Login)</button>
    </form>
</div>