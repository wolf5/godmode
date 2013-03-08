<?php
include("../../inc/config.inc.php");
include("../../inc/func.inc.php");

$id = isset($_GET["id"]) ? $_GET["id"] : NULL;
$besrnr = isset($_GET["besrnr"]) ? $_GET["besrnr"] : NULL;
$type = isset($_GET["type"]) ? $_GET["type"] : NULL;
             
//SQL Selects, Titel setzen
if($type=="mahnung") {
        $query = mysql_query("SELECT rech.id,rech.kontakt,rech.waehrung,DATE_FORMAT(mahn.datum,'$_config_date'),rech.bezahlt,mahn.adresse,mahn.betreff,mahn.text,mahn.footer,mahn.zahlungsfrist,mahn.besrnr FROM Rechnungen rech, Rechnungen_mahnungen mahn WHERE mahn.rechnung = rech.id AND mahn.id='$id'");
} else {
        $query = mysql_query("SELECT id,kontakt,waehrung,DATE_FORMAT(datum,'$_config_date'),bezahlt,adresse,betreff,text,footer,zahlungsfrist,besrnr FROM Rechnungen WHERE id='$id'");
}
if(mysql_num_rows($query)==0) {
        print "Die Rechnung Nr. '$id' existiert nicht.";
        die();
}
list($rech_id,$kontakt,$waehrung,$datum,$bezahlt,$adresse,$betreff,$text,$footer,$zahlungsfrist,$besrnr)=mysql_fetch_row($query);
$query = mysql_query("SELECT firma FROM Kontakte WHERE id='$kontakt'");
list($firma)=mysql_fetch_row($query);
$query=mysql_query("SELECT kp.vorname,kp.name FROM Kontakte_kontaktpersonen kp,Kontakte ko WHERE ko.id='$kontakt' AND ko.pl = kp.id");
if($type=="mahnung") {
        $title="Mahnung $firma";
} else {
        $title="Rechnung $firma";
}

if($besrnr) $besrnr="-$besrnr";
if(mysql_num_rows($query)==1)
$sachbearbeiter=substr(mysql_result($query,0,0),0,1).substr(mysql_result($query,0,1),0,1);
if($sachbearbeiter) $sachbearbeiter="Sachbearbeiter: $sachbearbeiter";

//Rechnungspositionen holen
if($type=="mahnung") {
        $rechnung_pos= mysql_query("SELECT text,text1,anzahl,betrag,waehrung,mwst,`key`,`value` FROM Rechnungen_positionen WHERE (rechnung='$rech_id' OR (`key`='mahnung' AND `value`='$id')) ORDER BY id");
} else {
        $rechnung_pos= mysql_query("SELECT text,text1,anzahl,betrag,waehrung,mwst,`key`,`value` FROM Rechnungen_positionen WHERE rechnung='$id' ORDER BY id");
}
$gutschriften= mysql_query("SELECT text, betrag,waehrung,mwst FROM Rechnungen_gutschriften WHERE bezahlt='$id'");


//PDF erstellen, generelle Optionen
define('FPDF_FONTPATH',"$_config_root_path/fpdf/font/");
require("$_config_root_path/fpdf/fpdf.php");

$pdf = new FPDF();
$pdf->Open();
$pdf->SetTitle($title);
$pdf->SetCreator("Sylon godmode");
$pdf->SetAuthor($_config_rechnung_pdf_author);
$pdf->SetPDFfileName(str_replace(" ","_",$title).".pdf");
$pdf->SetDisplayMode("fullwidth","single");
$pdf->SetAutoPageBreak("margin",27);
$pdf->SetFillColor(230);
$pdf->SetLeftMargin(15);
$pdf->AddPage();

//Header
/*
$pdf->SetFont("Times","",24);
//$pdf->Cell(20,5,"",0,0,"L");
$pdf->Text(40,15,$_config_rechnung_head_titel_logo);
$pdf->SetFont("Arial","",10);
$pdf->SetFont("Arial","B",10);
$txt=explode("\n",$_config_rechnung_head_titel_adresse);
for($i=0,$height=19;$txt[$i];$i++,$height+=4){
        if($i==1){
                $pdf->SetFont("Arial","",10);
        }
        $pdf->Text(150,$height,$txt[$i]);
}
$pdf->Write(15,"");
$pdf->Line($pdf->getX(),15,$pdf->getX()+190,15);
*/

$pdf->SetFont("Helvetica","",10);
$pdf->Write(5,"\n\n\n\n\n\n\n$adresse");
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

//Header: Rechnungsinfo's, Betreff, Text, etc.
$pdf->SetFont("Helvetica","B",10);
$pdf->Cell(61,5,"Rechnungsnummer: ".$kontakt.str_pad($rech_id,4,"0",STR_PAD_LEFT).$besrnr,0,0,"L");
$pdf->Cell(61,5,$sachbearbeiter,0,0,"C");
$pdf->Cell(61,5,"$_config_rechnung_ort, $datum",0,1,"R");

$pdf->Write(5,"\n\n$betreff\n\n");
$pdf->SetFont("Helvetica","",10);
if(isset($text))
        $pdf->Write(5,"$text\n");

//Positionstitel
$pdf->SetFont("Helvetica","B",10);
$pdf->Cell(59,5,"Produkt",0,0,"L");
$pdf->Cell(18,5,"Anz.",0,0,"R");
$pdf->Cell(35,5,"EP exkl.",0,0,"R");
$pdf->Cell(35,5,"EP Inkl.",0,0,"R");
$pdf->Cell(35,5,"Total",0,1,"R");

$pdf->Cell(59,5,"",0,0,"L");
$pdf->Cell(18,5,"Prod. Nr.",0,0,"R");
$pdf->Cell(35,5,"MWSt in %",0,0,"R");
$pdf->Cell(35,5,"MWSt Betrag",0,0,"R");


$pdf->Ln();
$pdf->SetFont("Helvetica","",9);

//Positionen
while(list($text,$text1,$anzahl,$betrag,$waehrung_pos,$mwst,$key,$value)=mysql_fetch_row($rechnung_pos))
{
        if($key!="produkt") $value="";
        if(isset($bgcolor)){
                $bgcolor=0;
        } else {
                $bgcolor=1;
        }
        $total+=($betrag*$anzahl);
        $total_mwst+=((($betrag/100)*$mwst)*$anzahl);
        if(!$waehrung)$waehrung=1;
        $text.=" \n ".$text1;
        if($pdf->GetY()>=259) {
                $pdf->AddPage();
        }
        $pdf->MultiCell(59,5,$text,0,"L",$bgcolor);
        $pdf->SetY($pdf->GetY()-10);
        $pdf->SetX(72);
        $pdf->Cell(18,5,$anzahl,0,0,"R",$bgcolor);
        $pdf->Cell(35,5,formatBetrag($betrag),0,0,"R",$bgcolor);
        $pdf->Cell(35,5,formatBetrag($betrag+(($betrag/100)*$mwst)),0,0,"R",$bgcolor);
        $pdf->Cell(35,5,"",0,1,"R",$bgcolor);
        $pdf->SetX(72);
        $pdf->Cell(18,5,$value,0,0,"R",$bgcolor);
        $pdf->Cell(35,5,sprintf("%0.1f",$mwst)."%",0,0,"R",$bgcolor);
        $pdf->Cell(35,5,formatBetrag((($betrag/100)*$mwst)),0,0,"R",$bgcolor);
        $pdf->Cell(35,5,getWaehrung($waehrung_pos)." ".formatBetrag(waehrungRound(($betrag+(($betrag/100)*$mwst))*$anzahl,$waehrung_pos)),0,1,"R",$bgcolor);
}

//Gutschriften
while(list($text,$betrag,$waehrung_pos,$mwst)=mysql_fetch_row($gutschriften)){
  if($bgcolor){
    $bgcolor=0;
  } else {
    $bgcolor=1;
  }
  $total-=($betrag);
        $mwst_total-=(($betrag/100)*$mwst);
  if(!$waehrung)$waehrung=1;
  $pdf->Cell(59,5,$text,0,0,"L",$bgcolor);
  $pdf->Cell(18,5,$anzahl,0,0,"R",$bgcolor);
  $pdf->Cell(35,5,formatBetrag($betrag),0,0,"R",$bgcolor);
  $pdf->Cell(35,5,formatBetrag($betrag+(($betrag/100)*$mwst)),0,0,"R",$bgcolor);
  $pdf->Cell(35,5,"",0,1,"R",$bgcolor);

  $pdf->Cell(59,5,"",0,0,"L",$bgcolor);
  $pdf->Cell(18,5,"",0,0,"R",$bgcolor);
  $pdf->Cell(35,5,sprintf("%0.1f",$mwst)."%",0,0,"R",$bgcolor);
  $pdf->Cell(35,5,formatBetrag((($betrag/100)*$mwst)),0,0,"R",$bgcolor);
  $pdf->Cell(35,5,getWaehrung($waehrung_pos)." ".formatBetrag(waehrungRound(($betrag+(($betrag/100)*$mwst)),$waehrung_pos)),0,1,"R",$bgcolor);
}


$pdf->Ln();
/*
$pdf->Line(15,275,197,275);
$pdf->SetFont("Helvetica","",6);

$pdf->Text(15,278,"UBS AG, Basel (CHF)");
$pdf->Text(15,281,"Konto Nr. 292-12250031.0");
$pdf->Text(15,284,"Clearing Nr. 292");
$pdf->Text(15,287,"BIC  UBSWCHZH80A");
$pdf->Text(15,290,"IBAN  CH5400292292122500310");

$pdf->Text(60,278,"UBS AG, Basel (EUR)");
$pdf->Text(60,281,"Konto Nr. 292-IQ124851.0");
$pdf->Text(60,284,"BIC  UBSWCHZH80A");
$pdf->Text(60,287,"IBAN  CH4400292292IQ1248510");


$pdf->Text(106,278,"Deutsche Bank, L�rrach (EUR)");
$pdf->Text(106,281,"Konto Nr. 0157040 00");
$pdf->Text(106,284,"BLZ 68370024");
$pdf->Text(106,287,"BIC  DEUTDEDB683");
$pdf->Text(106,290,"IBAN  DE16683700240015704000");

$pdf->Text(151,278,"MWSt. Nr. (CH):  361 275");
$pdf->Text(151,281,"MWSt. Nr. (D):  09422 / 05507");
$pdf->Text(151,284,"Umsatzsteuer-ID Nr.: DE 167 702 322");

/*
$pdf->Text(60.5,280,"UBS AG, Basel:");
$pdf->Text(106,280,"Konto Nr. 292-12250031.0");
$pdf->Text(151.5,280,"BLZ 3101");

$pdf->Text(60.5,284,"Deutsche Bank, L�rrach:");
$pdf->Text(106,284,"Konto Nr. 0 15 70 40 00");
$pdf->Text(151.5,284,"BLZ 683 700 24 Umsatzsteuer-ID Nr.: DE 167702322");

$pdf->Text(60.5,288,"MwSt.-Nr. (CH): 361 275");
$pdf->Text(106,288,"MwSt.-Nr. (D): 09422/05507");
$pdf->Text(151.5,288,"Umsatzsteuer-ID Nr.: DE 167702322");

//$_config_rechnung_text_footer
*/

//Abschlusstext
$lines=0;
for($i=0;$i<strlen($footer);$i++) {
        if(substr($footer,$i,1)=="\n") $lines++;
}
if(($pdf->getY() + ($lines + 3.33))>250) {
        $pdf->addpage();
}
$pdf->SetFont("Helvetica","",10);
$pdf->Write(5,"$footer");
$pdf->Output();
?>