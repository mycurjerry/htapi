<?php
if($_GET["png"]=="true"){
  header('Content-type:image/png');
}
echo file_get_contents("http://home.2ui.top/".$_GET["url"]);
