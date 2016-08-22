<?php

class ActiveForms {

    public function __construct() {
        
    }

    public function generateTopMenu($page_menu,$current_page_select,$autoHomeButton=1) {

        $form_html = "";
        $active = ' class="active"';
        
        if($autoHomeButton == 1){
            array_unshift($page_menu, array("url" => "index","label" => "หน้าแรก","icon" => "home"));
        }

        foreach ($page_menu as $index => $options) {

            $pagename = $options["url"];

            $active_page = "";
            $label = (isset($options["label"]) ? $options["label"] : $pagename);
            $url_route = ($pagename <> "#" ? (URL . $pagename) : "#");
            $icon = $options["icon"];

            if (isset($options["lists"])) {
                if (array_key_exists($current_page_select, $options["lists"])) {
                    $active_page = "active";
                } else {
                    $active_page = "";
                }

                $form_html .= "<li class=\"dropdown {$active_page}\" >"
                        . "<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-expanded=\"false\">"
                        . "<span class=\"" . (isset($icon) ? "glyphicon glyphicon-" . $icon : "") . "\"></span> {$label}<span class=\"caret\"></span>"
                        . "</a>"
                        . "<ul class=\"dropdown-menu\">";

                foreach ($options["lists"] as $listindex => $list_option) {
                    
                    $listname = $list_option["url"];
                    
                    $active_list = "";
                    $label_list = (isset($list_option["label"]) ? $list_option["label"] : $listname);
                    $url_route_list = ($listname <> "#" ? (URL . $listname) : "#");
                    $class = (isset($list_option["class"]) ? $list_option["class"] : "");
                    $custom_properties = (isset($list_option["custom_properties"]) ? $list_option["custom_properties"] : "");

                    if ($current_page_select == $listname) {
                        $active_list = $active;
                    } else {
                        $active_list = "";
                    }

                    $form_html .= "<li {$class} {$active_list} >"
                            . ($class <> "divider" ? "<a href=\"{$url_route_list}\" {$custom_properties} >{$label_list}</a>" : "")
                            . "</li>";
                }
                $form_html .= "</ul></a></li>";
            } else {
                if ($current_page_select == $pagename) {
                    $active_page = $active;
                }
//                            else if($current_page_select == "" && $viewname == "index"){ $active_page = $active; }

                $form_html .= "<li {$active_page} >"
                        . "<a href=\"{$url_route}\"><span class=\"" . (isset($icon) ? "glyphicon glyphicon-" . $icon : "") . "\"></span> {$label}</a>"
                        . "</li>";
            }
        }

        return $form_html;
    }
    
    /*
     * How to use
     * 1.create an array like this,
     * $page_menu = array(
     *                  array("url" => "ชื่อ view","label" => "ข้อความที่จะแสดงบน menutop","icon" => "ชื่อไอคอน"),...
     *              );
     * 
     * //กรณีสร้าง Dropdownlist *สามารถสร้างได้แค่ชั้นเดียว
     * 
     *   array(
     *       "url" => "#",
     *       "label" => "ข้อความที่จะแสดงบน menutop",
     *       "icon" => "ชื่อไอคอน",
     *       "lists" => array(
     *               array("url" => "ชื่อ view","label" => "ข้อความที่จะแสดงบน menutop","icon" => "ชื่อไอคอน"),
     *               ...
     *           )
     *       ),
     *       ...
     *
     * 
     * Properties เพิ่มเติม
     *  "class" => "ใส่ชื่อคลาส"
     *  "custom_properties" => "ใส่ property อื่นๆ ที่ต้องการ โดนใส่ต่อกันเลย เช่น "custom_properties" => "target=\"_blank\" ... "
     * 
     * 
     * 
     * 2.call this class/method
     *      $atf = new ActiveForms();
     *      echo $atf->generateTopMenu($page_menu,$this->pageMenu);
     * 
     */
    
    
    
    
    
    
    
    
    

}
