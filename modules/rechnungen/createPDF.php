<?php
include("../../inc/config.inc.php");

include("../../inc/func.inc.php");

//SQL Selects, Titel setzen
$query = mysql_query("SELECT kontakt,waehrung,DATE_FORMAT(datum,'$_config_date'),bezahlt,adresse,betreff,text,footer,zahlungsfrist,besrnr FROM Rechnungen WHERE id='$id'");
if(@mysql_num_rows($query)==0) {
        print "Die Rechnung Nr. '$id' existiert nicht.";
        die();
}
list($kontakt,$waehrung,$datum,$bezahlt,$adresse,$betreff,$text,$footer,$zahlungsfrist,$besrnr)=mysql_fetch_row($query);
$query = mysql_query("SELECT firma FROM Kontakte WHERE id='$kontakt'");
list($firma)=mysql_fetch_row($query);
$query=mysql_query("SELECT kp.vorname,kp.name FROM Kontakte_kontaktpersonen kp,Kontakte ko WHERE ko.id='$kontakt' AND ko.pl = kp.id");
$title="Rechnung $firma";
if($besrnr) $besrnr="-$besrnr";
if(mysql_num_rows($query)==1)
$sachbearbeiter=substr(mysql_result($query,0,0),0,1).substr(mysql_result($query,0,1),0,1);
if($sachbearbeiter) $sachbearbeiter="Sachbearbeiter: $sachbearbeiter";
//Rechnungspositionen holen
$rechnung_pos= mysql_query("SELECT text,text1,anzahl,betrag,waehrung,mwst,`key`,`value` FROM Rechnungen_positionen WHERE rechnung='$id'");
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
$pdf->SetAutoPageBreak("margin",20);
$pdf->SetFillColor(230);
$pdf->SetLeftMargin(15);
$pdf->AddPage();

//Header

$pdf->SetFont("Times","",24);
//$pdf->Cell(20,5,"",0,0,"L");
$pdf->Text(40,15,"Sylon");
$pdf->SetFont("Arial","",10);
$pdf->SetFont("Arial","B",10);
$txt=split("\n","Sylon\nPostfach 43\n4004 Basel\nTel. 061 383 85 77\nFax 061 383 85 76\nhttp://www.sylon.net\ninfo@sylon.net");
for($i=0,$height=19;$txt[$i];$i++,$height+=4){
        if($i==1){
                $pdf->SetFont("Arial","",10);
        }
        $pdf->Text(150,$height,$txt[$i]);
}
$pdf->Write(15,"");
$pdf->Line($pdf->getX(),15,$pdf->getX()+190,15);

$pdf->Ln();
$pdf->SetFont("Arial","",10);
$pdf->Write(5,"\n\n\n\n\n\n\n$adresse");
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

//Header: Rechnungsinfo's, Betreff, Text, etc.
$pdf->SetFont("Arial","B",10);
$pdf->Cell(61,5,"Rechnungsnummer: ".$kontakt.str_pad($id,4,"0",STR_PAD_LEFT).$besrnr,0,0,"L");
$pdf->Cell(61,5,$sachbearbeiter,0,0,"C");
$pdf->Cell(61,5,"$_config_rechnung_ort, $datum",0,1,"R");

$pdf->Write(5,"\n\n$betreff\n\n");
$pdf->SetFont("Arial","",10);
if($text)
        $pdf->Write(5,"$text\n");

$pdf->Ln();

//Positionstitel
$pdf->SetFont("Arial","B",10);
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
$pdf->SetFont("Arial","",9);

//Positionen
while(list($text,$text1,$anzahl,$betrag,$waehrung_pos,$mwst,$key,$value)=mysql_fetch_row($rechnung_pos))
{
        if($key!="produkt") $value="";
        if($bgcolor){
                $bgcolor=0;
        } else {
                $bgcolor=1;
        }
        $total+=($betrag*$anzahl);
        $total_mwst+=((($betrag/100)*$mwst)*$anzahl);
        if(!$waehrung)$waehrung=1;
        if($text1) $text1="\n".$text1;
        $y=$pdf->getY();
        $pdf->Cell(77,5,$anzahl,0,0,"R",$bgcolor);
        $pdf->Cell(35,5,formatBetrag($betrag),0,0,"R",$bgcolor);
        $pdf->Cell(35,5,formatBetrag($betrag+(($betrag/100)*$mwst)),0,0,"R",$bgcolor);
        $pdf->Cell(35,5,"",0,1,"R",$bgcolor);

        $pdf->Cell(77,5,$value,0,0,"R",$bgcolor);
        $pdf->Cell(35,5,sprintf("%0.1f",$mwst)."%",0,0,"R",$bgcolor);
        $pdf->Cell(35,5,formatBetrag((($betrag/100)*$mwst)),0,0,"R",$bgcolor);
        $pdf->Cell(35,5,getWaehrung($waehrung_pos)." ".formatBetrag(waehrungRound(($betrag+(($betrag/100)*$mwst))*$anzahl,$waehrung_pos)),0,1,"R",$bgcolor);
        $y2=$pdf->getY();
        $pdf->setY($y);
        $pdf->MultiCell(59,5,$text.$text1,0,"L",$bgcolor);
        $y3 = $pdf->getY();
        if($y3>$y2) {
                if($bgcolor) {
                        $pdf->Rect(74,$y2,123,($y3-$y2),"F");
                }
                $pdf->setY($y2+($y3-$y2));
        } else {
                $pdf->setY($y2);
        }
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
  $pdf->Cell(35,5,"-".formatBetrag($betrag),0,0,"R",$bgcolor);
  $pdf->Cell(35,5,"-".formatBetrag($betrag+(($betrag/100)*$mwst)),0,0,"R",$bgcolor);
  $pdf->Cell(35,5,"",0,1,"R",$bgcolor);

  $pdf->Cell(59,5,"",0,0,"L",$bgcolor);
  $pdf->Cell(18,5,"",0,0,"R",$bgcolor);
  $pdf->Cell(35,5,sprintf("%0.1f",$mwst)."%",0,0,"R",$bgcolor);
  $pdf->Cell(35,5,formatBetrag((($betrag/100)*$mwst)),0,0,"R",$bgcolor);
  $pdf->Cell(35,5,getWaehrung($waehrung_pos)." -".formatBetrag(waehrungRound(($betrag+(($betrag/100)*$mwst)),$waehrung_pos)),0,1,"R",$bgcolor);
}

//Total
$query=mysql_query("SELECT sum(anzahl*(betrag*fx)),sum((((anzahl*betrag)/100)*mwst)*fx) FROM Rechnungen_positionen WHERE rechnung='$id'");
list($total,$total_mwst)=mysql_fetch_row($query);

$query=mysql_query("SELECT sum(betrag*fx),sum(((betrag/100)*mwst)*fx) FROM Rechnungen_gutschriften WHERE bezahlt='$id'");
list($total_gut,$total_mwst_gut)=mysql_fetch_row($query);

$total-=$total_gut;
$total_mwst-=$total_mwst;
$pdf->Ln();
$pdf->SetFont("Arial","B",10);
$pdf->Cell(59,5,"Nettobetrag",0,0,"L");
$pdf->Cell(53,5,"Totalbetrag MWSt",0,0,"R");
$pdf->Cell(70,5,"Zu überweisender Betrag",0,1,"R");
$pdf->Cell(59,5,getWaehrung($waehrung)." ".formatBetrag(waehrungRound($total,$waehrung)),0,0,"L");
$pdf->Cell(53,5,getWaehrung($waehrung)." ".formatBetrag(waehrungRound($total_mwst,$waehrung)),0,0,"R");
$pdf->Cell(70,5,getWaehrung($waehrung)." ".formatBetrag(waehrungRound($total+$total_mwst,$waehrung)),0,1,"R");

$pdf->Ln();
$pdf->Ln();

$pdf->Line(15,276,197,276);
$pdf->SetFont("Arial","",7);

//footer
$pdf->Text(15,280,"Das Sylon Team verfolgt keine aktiven Marketing Projekte.");
$pdf->Text(15,284,"Unser Marketing ist eine zufriedene Kundschaft. Sind Sie mit den Hosting Dienstleistungen des Sylon Teams zufrieden, empfehlen Sie uns bitte weiter.");
$pdf->Text(15,288,"Für jeden vermittelten Auftrag schreiben wir Ihnen die ersten zwei Monatsgebühren des Neukunden gut. Besten Dank für Ihre Unterstützung.");
//$_config_rechnung_text_footer


//Abschlusstext
$lines=0;
for($i=0;$i<strlen($footer);$i++) {
        if(substr($footer,$i,1)=="\n") $lines++;
}
if(($pdf->getY() + ($lines + 103.33))>250) {
        $pdf->addpage();
}
$pdf->SetFont("Arial","",10);
$pdf->Write(5,"$footer");
$pdf->Output();
?>