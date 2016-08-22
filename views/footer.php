<?php $logged = Session::get('User'); 
   $people = array("5250499004786", "Joe", "Glenn", "Cleveland");
   if (!in_array($logged['person_id'],$people, TRUE)){
       //TRUE FALSE
?>
<div id="footer">
    <nav class="navbar navbar-default navbar-fixed-bottom hidden-xs"> 
        <div class="col-lg-12">
            <ul class="list-unstyled">
                <li style="margin-right: 0;" class="pull-right">
                    <b>เบราว์เซอร์ที่รองรับ&nbsp;:&nbsp;</b> 
                    &nbsp;<a href="http://www.google.co.th/intl/th/chrome/browser/desktop/index.html" target="_blank">
                        <img style=" width: 20px; height: 20px;" title="Chrome" alt="Chrome" src="<?= URL ?>public/images/chrome.png"> Chrome (แนะนำ) </a>

                    &nbsp;<a href="https://www.mozilla.org/th/firefox/new/" target="_blank">
                        <img style=" width: 20px; height: 20px;" title="Firefox" alt="Firefox" src="<?= URL ?>public/images/firefox.png"> Firefox </a>
                    
                </li>
                <li>&copy; 2016 <?=SYSTEM_NAME?></li>
            </ul>
        </div>
    </nav>
</div>
<?php } ?>
</body>
</html>