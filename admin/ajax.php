<?php
require_once('include/main.php');

$data = array();
$data['post'] = $_POST;
$result = false;

if(isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'update':

            $dataUpdate = $_POST['data'];

            if(!empty($_POST['where']))
            foreach($_POST['where'] as $key => $val) {
                $db->where($key, $val);
            }

            if($db->update('`'.$_POST['table'].'`', $dataUpdate)) {
                $result = true;
            }

            break;
        case 'insert':

            $dataInsert = $_POST['data'];

            $id = $db->insert('`'.$_POST['table'].'`', $dataInsert);
			if($id) {
            	$result = true;
				$data['newid'] = $id;
			}

            break;
        case 'delete':

            if($_POST['table'] == 'team') {

                $db->where($_POST['key'], $_POST['id']);

                if($db->update('`'.$_POST['table'].'`', array("hidden"=>"1"))) {
                    $result = true;
                }
            } else {

                $db->where($_POST['key'], $_POST['id']);

                if($db->delete('`'.$_POST['table'].'`')) {
                    $result = true;
                }
            }

            break;
        case 'tablesort':

            foreach($_POST['sort'] as $nr => $id) {

                $data = Array ('sort' => $nr);
                $db->where('id', $id);
                if($db->update('`'.$_POST['table'].'`', $data)) {

                } else {
                     $update = false;
                }
            }
            if($update !== false) {
                $result = true;
            }

            break;

        default:
            break;
    }
}

if($result !== true) {
    $result = false;
	$data['error'] = $db->getLastError();
}
$data['success'] = $result;

print json_encode($data);

?>
