<?php

$html = "<table width='100%' cellspacing='0' cellpadding='0' style='border-collapse:collapse;'>";

$html .= "<tr><td colspan='" . count($info[0]) . "'><strong>" .$altData['title'] . "</strong></td></tr>";

if (isset($altData['data_ora'])) {
	$html .= "<tr><td colspan='5'>". $altData['data_ora'] . "</td></tr>";
}

$html .= "<thead>";

$html .= "<tr>";

foreach ($headerTabel as $cell) {
	$html.= "<th style='border: 1px solid black;'>" . $cell . "</th>";	
}
$html.= "</tr>";
$html.= "</thead>";

foreach ($info as $row) {
	$html.= "<tr>";
    foreach ($row as $cellData)	{
    	$html.= "<td style='border: 1px solid black;'>" . $cellData . "</td>";
	}
    $html.= "</tr>";
}

$html .= "</table>";

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream', false);
header('Content-Transfer-Encoding: binary');
header('Cache-Control: public, must-revalidate, max-age=0');
header('Pragma: public');
header('Content-Length: '.strlen($html));
header("Content-Type: application/excel");
header('Content-Disposition: attachment; filename='. $altData['file_name'] . '.xls');
echo $html;

