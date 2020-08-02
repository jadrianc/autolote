<?php
defined('BASEPATH') or exit('No direct script access allowed');

require(APPPATH . 'third_party/fpdf/fpdf.php');

class PDF_Generador extends FPDF
{
    public $widths;
    public $aligns;
    public $title;
    public $cCosto;
    public $clase;
    public $subClase;
    public $estado;
    public $motivo;
    public $adscritas;
    

    public $userPrint;
    public $ONIUser;
    public $filtered = array();

    public $angle=0;

    public function Rotate($angle, $x=-1, $y=-1)
    {
        if ($x==-1) {
            $x=$this->x;
        }
        if ($y==-1) {
            $y=$this->y;
        }
        if ($this->angle!=0) {
            $this->_out('Q');
        }
        $this->angle=$angle;
        if ($angle!=0) {
            $angle*=M_PI/180;
            $c=cos($angle);
            $s=sin($angle);
            $cx=$x*$this->k;
            $cy=($this->h-$y)*$this->k;
            $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm', $c, $s, -$s, $c, $cx, $cy, -$cx, -$cy));
        }
    }

    public function _endpage()
    {
        if ($this->angle!=0) {
            $this->angle=0;
            $this->_out('Q');
        }
        parent::_endpage();
    }

    public function RotatedText($x, $y, $txt, $angle)
    {
        //Text rotated around its origin
        $this->Rotate($angle, $x, $y);
        $this->Text($x, $y, $txt);
        $this->Rotate(0);
    }

    public function WaterMark()
    {
        $this->SetFont('Arial', 'B', 195);
        $this->SetTextColor(212, 212, 212);
        if(strlen($this->ONIUser)<= 5){
            $this->SetFont('Arial', 'B', 275);
            $this->RotatedText(45, 220, $this->ONIUser, 35);
        } else {
            $this->RotatedText(45, 275, $this->ONIUser, 55);
        }

    }

    public function Header()
    {
        $this->WaterMark();
        $logo =  base_url()."theme/dist/img/logo_pnc_alter.png";
        $this->Image($logo, 7, 5, 16);

        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', '', 8);
        $this->Text(24, 10, 'POLICIA NACIONAL CIVIL');
        $this->Text(24, 14, 'DIVISION DE LOGISTICA');
        $this->Text(24, 18, 'DEPARTAMENTO DE ACTIVO FIJO');
        $this->Text(170, 8, 'Pag. '.$this->PageNo().' de {nb}');
        $this->Text(170, 12, 'FECHA : '.date('d/m/Y'));
        $this->Text(170, 15.5, 'HORA : '.date('H:i:s A'));
        $this->Text(170, 19, 'USUARIO : '.$this->userPrint);
        $this->SetFont('Arial', 'B', 14);
        $this->Text(24, 25, $this->title);
        $this->SetFont('Arial', 'BU', 9);
        $this->Text(24, 29, 'Filtrado por : ');
        $this->SetFont('Arial', '', 9);
        if($this->adscritas == 1){
            $this->Text(24, 35, 'C. DE COSTO Y UNID. ADSCRITAS DE : ');
            $this->SetFont('Arial', 'B', 9);
            $this->Text(84, 35, $this->cCosto);
        } else {
            $this->Text(24, 35, 'CENTRO DE COSTO : ');
            $this->SetFont('Arial', 'B', 9);
            $this->Text(57, 35, $this->cCosto);
        }
        $this->SetFont('Arial', '', 9);
        $this->Text(24, 40, 'CLASE : ');
        $this->SetFont('Arial', 'B', 9);
        $this->Text(37, 40, $this->clase);
        $this->SetFont('Arial', '', 9);
        $this->Text(115, 40, 'SUBCLASE : ');
        $this->SetFont('Arial', 'B', 9);
        $this->Text(134, 40, $this->subClase);
        $this->SetFont('Arial', '', 9);
        $this->Text(24, 45, 'ESTADO DEL BIEN : ');
        $this->SetFont('Arial', 'B', 9);
        $this->Text(55, 45, $this->estado);
        $this->SetFont('Arial', '', 9);
        $this->Text(24, 50, 'ACTAS DE DESCARGO : ');
        $this->SetFont('Arial', 'B', 9);
        $this->Text(61, 50, $this->motivo);
        $this->SetDrawColor(0, 0, 0);
        $this->Line(10, 52, 210, 52);
        $this->SetFont('Arial', 'B', 9);
        $this->Ln(43);
    }

    public function SetAdscritas($a)
    {
        //Set the Adscritas data to the report
        $this->adscritas=$a;
    }

    public function SetCCosto($cc)
    {
        //Set the CCOSTO data to the report
        $this->cCosto=$cc;
    }

    
    public function SetClase($c)
    {
        //Set the CLASE data to the report
        $this->clase=$c;
    }

    public function SetSubClase($sc)
    {
        //Set the SUBCLASE data to the report
        $this->subClase=$sc;
    }

    public function SetEstado($e)
    {
        //Set the ESTADO data to the report
        $this->estado=$e;
    }

    public function SetMotivoDescargo($m)
    {
        //Set the ESTADO data to the report
        $this->motivo=$m;
    }

    public function SetTitle($t)
    {
        //Set the title to the report
        $this->title=$t;
    }


    public function SetUser($u, $o)
    {
        //Set the user to the report
        $this->userPrint=$u;
        $this->ONIUser=$o;
    }

    public function SetWidths($w)
    {
        //Set the array of column widths
        $this->widths=$w;
    }

    public function SetAligns($a)
    {
        //Set the array of column alignments
        $this->aligns=$a;
    }


    public function Row($data)
    {
        //Calculate the height of the row
        $nb=0;
        for ($i=0;$i<count($data);$i++) {
            $nb=max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        }
        $h=6*$nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);

        //Draw the cells of the row
        for ($i=0;$i<count($data);$i++) {
            $w=$this->widths[$i];
            $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x=$this->GetX();
            $y=$this->GetY();
            //Draw the border
            //$this->Rect($x, $y, $w, $h);
            //Print the text
            $this->MultiCell($w, 5, $data[$i], 0, $a);
            //Put the position to the right of the cell
            $this->SetXY($x+$w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    public function RowTotal($data)
    {
        //Calculate the height of the row
        $nb=0;
        for ($i=0;$i<count($data);$i++) {
            $nb=max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        }
        $h=6*$nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);

        //Draw the cells of the row
        for ($i=0;$i<count($data);$i++) {
            $w=$this->widths[$i];
            $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x=$this->GetX();
            $y=$this->GetY();
            //Draw the border
            $this->Rect($x, $y, $w, $h);
            //Print the text
            $this->MultiCell($w, 5, $data[$i], 0, $a);
            //Put the position to the right of the cell
            $this->SetXY($x+$w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }


    public function CheckPageBreak($h)
    {
        //If the height h would cause an overflow, add a new page immediately
        if ($this->GetY()+$h>$this->PageBreakTrigger) {
            $this->AddPage('P', 'Letter');
        }
    }

    public function NbLines($w, $txt)
    {
        //Computes the number of lines a MultiCell of width w will take
        $cw=&$this->CurrentFont['cw'];
        if ($w==0) {
            $w=$this->w-$this->rMargin-$this->x;
        }
        $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
        $s=str_replace("\r", '', $txt);
        $nb=strlen($s);
        if ($nb>0 and $s[$nb-1]=="\n") {
            $nb--;
        }
        $sep=-1;
        $i=0;
        $j=0;
        $l=0;
        $nl=1;
        while ($i<$nb) {
            $c=$s[$i];
            if ($c=="\n") {
                $i++;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
                continue;
            }
            if ($c==' ') {
                $sep=$i;
            }
            $l+=$cw[$c];
            if ($l>$wmax) {
                if ($sep==-1) {
                    if ($i==$j) {
                        $i++;
                    }
                } else {
                    $i=$sep+1;
                }
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
            } else {
                $i++;
            }
        }
        return $nl;
    }



    public function getInstance()
    {
        return new PDF_Generador();
    }
}
