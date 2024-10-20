<?php
require_once "../config.php";

$templates_json = file_get_contents('../template_list.json');
$templates_decode = json_decode($templates_json, true);
$templates = $templates_decode['templates'];

if(isset($_GET["errorCode"])) {
  $errors_json = file_get_contents('../error_list.json');
  $errors_decode = json_decode($errors_json, true);
  $errors = $errors_decode['errors'];

  $error_code = $_GET["errorCode"];
  $error_reason = $errors[$error_code]['description'];

  include "../components/error.php";
}

// try to create data folder if not exists
if(!is_dir("data")) {
  mkdir("data", 0644, false);
}

if(isset($_GET["templateId"])) {
  $template_id = htmlspecialchars($_GET["templateId"]);
  $target_template = $templates[$template_id];

  if($target_template["templateFolder"] == null) {
    header("Location: /dwarf-engine/templates?errorCode=404");
  }

  $file_to_download = './data/'.$target_template["templateFolder"].'.7z';
  $file_name = $target_template["templateFolder"].'.7z';

  header("Content-type: application/zip");
  header("Content-Disposition: attachment; filename=$file_name");
  header("Content-length: " . filesize($file_to_download));
  header("Pragma: no-cache");
  header("Expires: 0");
  readfile("$file_to_download");
  exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dwarf Engine - Templates</title>

  <link rel="stylesheet" href="/<?php echo $HOST_DIRECTORY; ?>/styles/main.css">

  <script src="/<?php echo $HOST_DIRECTORY; ?>/scripts/hover-effect.js"></script>
</head>
<body onload="start()">
  <?php
    include "../components/navbar.php";
  ?>

  <div class="template-holder">

  <?php
    $template_name = '';
    $template_desc = '';
    $template_id = '';
    $i = 0;
    foreach($templates as $template) {
      $template_name = $template['templateName'];
      $template_desc = $template['templateDesc'];
      $template_id = $i;
      include "../components/template.php";
      $i++;
    }
  ?>

  </div>
</body>
</html>