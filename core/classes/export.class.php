<?php
/**
 * Ofera metode pentru crearea de pdf-uri, respectiv xls
 */
class Export {
    
     /**
     * Transforma html intr-un document excel 
     * @param array Datele din tabel
     * @param array Header-ul tabelului
     * @param array Date care sunt afisate inainte de capul tabelului
     * @param string Numele template-ului
     * @return void
     */
	public function servesteTabelExcel($info, $headerTabel, $altData, $template="tabel_excel")
	{
		require_once(BROKER_REAL_DIR . "core/templates/" . $template . ".html.php");
	}
	

	public function htmlToExcel($html)
	{
		require_once(BROKER_REAL_DIR . "core/templates/excel_file.html.php");
	}

}
