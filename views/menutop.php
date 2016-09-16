<?php
//$this->view->js = array('public/js/pagejscript.js');

$User = Session::get('User');
$active = ' class="active"';
?>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <span class="navbar-brand" href="<?= URL; ?>index"><?=SHORT_NAME_SYSTEM?></span>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navNMS">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>                      
                <span class="icon-bar"></span>                      
            </button>
        </div>
        <div class="collapse navbar-collapse" id="navNMS">
            <input type="hidden" id="user_session" name="user_session"  value="<?= sizeof($User); ?>" />
            <input type="hidden" id="depart_id" name="depart_id"  value="<?= $User['depart_id']; ?>" />
            <input type="hidden" id="user_type" name="user_type"  value="<?= $User['Supply_system']; ?>" />
            <ul class="nav navbar-nav">
                <li <?= ($this->pageMenu == 'index' || $this->pageMenu == '') ? $active : ''; ?>>
                    <a href="<?= URL; ?>index"><span class="glyphicon glyphicon-home"></span> หน้าแรก</a></li>
                    
               
                   
                   <li <?= ($this->pageMenu == 'supply') ? $active : ''; ?>>
                        <a href="<?= URL; ?>supply"><span class="glyphicon glyphicon-edit"></span> เบิก-จ่ายอุปกรณ์</a>
                    </li>
                   
                    <?php  if(like_match('%admin%',$User['Supply_system']) == TRUE){ ?>
                        
                        <li <?= ($this->pageMenu == 'hardware' || $this->pageMenu == 'hardware_type' || $this->pageMenu == 'symptom' || $this->pageMenu == 'depart' || $this->pageMenu == 'technician' || $this->pageMenu == 'service_status' || $this->pageMenu == 'store' || $this->pageMenu == 'store_type' || $this->pageMenu == 'items') ? $active : ''; ?> class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-cog"></span> ตั้งค่า<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li <?= ($this->pageMenu == 'items') ? $active : ''; ?>>
                                    <a href="<?= URL; ?>items">จัดการรายการอุปกรณ์</a></li>
                                <li <?= ($this->pageMenu == 'items_type') ? $active : ''; ?>>
                                    <a href="<?= URL; ?>itemsType">จัดการชนิดอุปกรณ์</a></li>

                                <li class="divider"></li>
                                <li <?= ($this->pageMenu == 'user') ? $active : ''; ?>>
                                    <a href="<?= URL; ?>user">กำหนดสิทธิ์ User</a></li>
                                <li class="divider"></li>
                                <li <?= ($this->pageMenu == 'structure') ? $active : ''; ?>>
                                    <a href="<?= URL; ?>structure">Check Structure Database</a></li>
                                
                            </ul>
                        </li>
                        <?php
                    }
               
                ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-info-sign"></span> ช่วยเหลือ<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#"><font color="#A4A4A4">คู่มือ</font></a></li>
                        <li <?= ($this->pageMenu == 'question') ? $active : ''; ?>>
                                    <a href="<?= URL; ?>question">ข้อซักถาม</a></li>
                        <li <?= ($this->pageMenu == 'developer') ? $active : ''; ?>>
                                    <a href="<?= URL; ?>developer">ผู้พัฒนา</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php if (sizeof($User) > 0) { ?>  
                    <li class="dropdown">
                        <!--<a href="#" class="dropdown-toggle profile-image" data-toggle="dropdown" role="button" aria-expanded="false">-->
                        <?php
                        $imgurl = "http://192.168.5.250/p4p/images/PhotoPersonal/" . $User['person_photo'];
                        if (!empty($User['person_photo'])) {
                            ?>
                            <a href="#" class="dropdown-toggle profile-image" data-toggle="dropdown" role="button" aria-expanded="false">
                                <span class="profile-navbar-image"><img class="img-circle" src="<?= $imgurl ?>" /></span>
                            <?php } else { ?>
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span> 
                                    <?php
                                }//end set photo
                                echo $User['firstname'] . ' ' . $User['lastname'];
                                ?><span class="caret" aria-hidden="true"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?= URL; ?>uprofile"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> แก้ไขข้อมูลส่วนตัว</a></li>
                                <li><a href="#">...</a></li>
                                <li class="divider"></li>
                                <li><a href="<?= URL; ?>login/logout"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> ออกจากระบบ</a></li>
                            </ul>
                    </li>
                <?php } else { ?>
                    <li><a href="#" onclick="
                            BootstrapDialog.show({
                                message: $('<div></div>').load('<?= URL ?>login'),
                                onshown: function(dialog) {
                                    if ($('#username').val() !== '')
                                    {
                                        //when cookie is usable, always check this box until remove it
                                        $('#password').focus();
                                        $('#check_remember').prop('checked', true);
                                    } else {
                                        $('#username').focus();
                                        $('#check_remember').prop('checked', false);
                                    }
                                }
                            });" >
                            <span class="glyphicon glyphicon-user" aria-hidden="true"></span> ลงชื่อเข้าใช้</a></li>
                <?php } ?>
                <li><a href="<?= URL; ?>about"><span class="glyphicon glyphicon-copyright-mark" aria-hidden="true"></span> เกี่ยวกับ</a></li>
            </ul>
        </div>
    </div>
</nav>
<?php

function like_match($pattern, $subject)
{
    $pattern = str_replace('%', '.*', preg_quote($pattern, '/'));
    return (bool) preg_match("/^{$pattern}$/i", $subject);

}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

