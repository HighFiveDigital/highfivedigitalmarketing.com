<?php

$this->set_default($data, 'buffer', 8);
$this->set_default($data['list'], 'num', 10);

$num_pages = ceil($data['list']['total']/$data['list']['num']);

$data['file'] = $data['list']['file']; //set the file reference to the php file that called this script

$start_buffer = floor($data['buffer']/3);
$start_page = $data['page']-$start_buffer;
if ($start_page <= 1) {
	$start_page = 1;
}
else {
	$data['page'] = $start_page-1;
	$start_block = pd('lists')->build_link($data, '...');
}

$end_page = $start_page+$data['buffer'];

if ($end_page >= $num_pages) {
	$end_page = $num_pages;
}
else {
	$data['page'] = $end_page+1;
	$end_block = pd('lists')->build_link($data, '...');
}

if ($end_page > 1) {

for ($i = $start_page; $i <= $end_page; $i++) {
	if ($i == $data['list']['page']) {
		$block .= " <span class=\"active\">$i</span> ";
	}
	else {
	  $data['page'] = $i;
		$block .= ' '.pd('lists')->build_link($data, $i).' ';
	}
}

echo $start_block.$block.$end_block;

}

	

?>