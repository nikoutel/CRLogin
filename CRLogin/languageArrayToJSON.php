<?PHP

namespace CRLogin;

use CRLogin\core\DIC;

require '../CRLoginAutoloader.php';
require 'Debugr/DebugrLoad.php';

$dic = new DIC;
$l = $dic->getLanguageFile();
header('Content-Type: application/json');
echo json_encode($l);
?>
