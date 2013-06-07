<?PHP
require 'CRLoginAutoloader.php';
require 'Debugr/DebugrLoad.php';
$dic = new DIC;
$l=$dic->getLanguage();
header('Content-Type: application/json');
echo json_encode($l);
?>
