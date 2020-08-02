<?php
defined('BASEPATH') or exit('No direct script access allowed');

require(APPPATH . 'third_party/fpdf/fpdf.php');

class PDF_Remision extends FPDF
{
    public $widths;
    public $aligns;
    public $title;
    public $cCosto;
    public $cCosto2;
    public $userPrint;
    public $ONIUser;
    public $numDocumento;
    public $tipoDocumento;
    public $oni_entrega;
    public $nombreAsignado;
    public $data = [];
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
        $this->SetFont('Arial', 'B', 225);
        $this->SetTextColor(212, 212, 212);
        if(strlen($this->data["ONIUSER"])<= 5){
            $this->SetFont('Arial', 'B', 290);
            $this->RotatedText(45, 270, $this->data["ONIUSER"], 50);
        } else {
            $this->RotatedText(45, 270, $this->data["ONIUSER"], 53);
        }

    }

    public function Header()
    {
        $this->WaterMark();
        $logo =  base_url()."theme/dist/img/logo_pnc_alter.png";
        $this->Image($logo, 14, 10, 30);
        $margenTabla = 100;
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', '', 9);
        if(isset($this->data['FECHA'])){
            $fecha = $this->data['FECHA'];
        }else{
            $fecha = $this->actual_date();
        }
        
        $this->Text(15, 44, 'POLICIA NACIONAL CIVIL');
       // $this->Text(15, 49, 'DEPARTAMENTO DE SUMINISTROS');
        $this->Text(150, 48, $fecha);
        $this->Text(15, 49, $this->data['UNIDAD']);
        $this->Text(15, 54, 'USUARIO: '. $this->data['USUARIO']);
        $this->Text(15, 59, utf8_decode('OFICIO N°: '). $this->data['NUM_OFICIO']);
        $this->Text(15, 64,  utf8_decode($this->data['NOM_SER']));
        $this->Text(15, 69,  $this->data['CARGO']);
        $this->Text(15, 74,  'Presente:');
        $this->SetFont('Arial', '', 11);
        
        
        

        $this->Text(45, 98, 'Para su conocimiento y para efectos consiguientes de ley, atentamente y por este medio');
        $this->Text(24, 105, 'remito a usted, la cantidad de '.$this->data['NUM_ESQUELAS']. ' Esquelas de infraccion notificadas por '.$this->data['UNIDAD']);
        $this->Text(24, 112, 'a conductores por infringir la ley de Transporte Terrestre Transito y Seguridad Vial y el');
        $this->Text(24, 118, 'Reglamento General de Transito');
        $this->Text(40, 123, 'Asi mismo le remito los decomisos correspondientes segun detalle:');
        $this->SetFont('Arial', 'B', 11);
        
        
        if($this->data['TOT_D_TARJETA'] > 0) $this->Text(24, 130, $this->data['TOT_D_TARJETA'].' TARJETAS DE CIRCULACION');
        if($this->data['TOT_D_LICENCIA'] > 0) $this->Text(24, 137, $this->data['TOT_D_LICENCIA'].' LICENCIAS DE CONDUCIR');
        if($this->data['TOT_D_1_PLACA'] > 0) $this->Text(24, 144, $this->data['TOT_D_1_PLACA'].' PLACA IMPAR');
        if($this->data['TOT_D_2_PLACA'] > 0) $this->Text(24, 151, $this->data['TOT_D_2_PLACA'].' PLACA PAR');
        if($this->data['TOT_D_POLIZA'] > 0) $this->Text(24, 158, $this->data['TOT_D_POLIZA'].' POLIZA');
        //if($this->data['TOT_D_VEHICULO'] > 0) $this->Text(24, 165, $this->data['TOT_D_VEHICULO'].' VEHICULO');
        if($this->data['TOT_D_PERMISO'] > 0) $this->Text(24, 165, $this->data['TOT_D_PERMISO'].' PERMISO');

        $this->SetFont('Arial', '', 11);
        $this->Text(60, 230, 'DIOS');
        $this->Text(100, 230, 'UNION');
        $this->Text(130, 230, 'LIBERTAD');
        $this->SetFont('Arial', 'B', 11);
       
        $this->Text(95, 245, $this->data['REMITE']);
        $this->Text(95, 250, $this->data['CARGO_REMITE']);
        
        //$this->Text(13, 65, 'Especificaciones del Arma: ');
        /*
        $this->SetFont('Arial', '', 8);
        $this->SetY(53);
        $this->SetX($margenTabla);
        $this->Cell(35,7,'No: ',0,0,'C');
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(120,7,$this->data['NUM_DOC'],0,0,'L');
        $this->SetY(63);
        $this->SetFont('Arial', '', 8);
        $this->SetX($margenTabla);
        $this->Cell(35,7,'ONI: ',0,0,'C');
        $this->Cell(120,7,utf8_decode($this->data['ONI_ASIGNACION']),0,0,'L');
        $this->SetY(73);
        $this->SetX($margenTabla);
        $this->Cell(35,7,'NOMBRE: ',0,0,'C');
        $this->Cell(120,7,utf8_decode($this->data['NOMBRE_ASIGNADO']),0,0,'L');
        $this->SetY(83);
        $this->SetX($margenTabla);
        $this->Cell(35,7,'CARGO: ',0,0,'C');
        $this->Cell(120,7,utf8_decode($this->data['CARGO']),0,0,'L');
        $this->SetY(93);
        $this->SetX($margenTabla);
        $this->Cell(35,7,'UBICACION: ',0,0,'C');
        $this->MultiCell(100,7,utf8_decode($this->data['UBICACION']),0,'L');

        $this->SetY(103);
        $this->SetX($margenTabla);
        $this->Cell(35,7,'CARGO: ',0,0,'C');
        $this->Cell(120,7,utf8_decode($this->data['CARGO']),0,0,'L');
        $this->SetY(113);
        $this->SetX($margenTabla);
        $this->Cell(35,7,'UBICACION ARMA: ',0,0,'C');
        $this->MultiCell(100,7,utf8_decode($this->data['CCOSTO']),0,'L');

        $this->SetY(123);
        $this->SetX($margenTabla);
        $this->Cell(35,7,'TIPO/ARMA: ',0,0,'C');
        $this->Cell(120,7,$this->data['TIPO_ARMA'],0,0,'L');
        $this->SetY(133);
        $this->SetX($margenTabla);
        $this->Cell(35,7,'MODELO: ',0,0,'C');
        $this->Cell(120,7,$this->data['MODELO_ARMA'],0,0,'L');
        $this->SetY(143);
        $this->SetX($margenTabla);
        $this->Cell(35,7,'MARCA: ',0,0,'C');
        $this->Cell(120,7,$this->data['MARCA_ARMA'],0,0,'L');
        $this->SetY(153);
        $this->SetX($margenTabla);
        $this->Cell(35,7,'CALIBRE: ',0,0,'C');
        $this->Cell(120,7,$this->data['CALIBRE_ARMA'],0,0,'L');
        $this->SetY(163);
        $this->SetX($margenTabla);
        $this->Cell(35,7,'CARGADORES: ',0,0,'C');
        $this->Cell(120,7,$this->data['CARGADORES'],0,0,'L');
        $this->SetY(173);
        $this->SetX($margenTabla);
        $this->Cell(35,7,'MUNICIONES: ',0,0,'C');
        $this->Cell(120,7,$this->data['MUNICION'],0,0,'L');
        
        $this->SetFont('Arial', '', 8);
        $this->SetY(53);
        $this->SetX(28);
        $this->Cell(35,20,'OBSERVACIONES: ',0,0,'C');
        $this->SetY(70);
        $this->SetX(28);
       $this->MultiCell(70,10,utf8_decode($this->data['OBSERVA_ASIGNACION']),1,'L');
       if($this->data['TIPO_ASIGNACION'] == 1){
       $this->SetX(28);
        $this->MultiCell(70,10,'DATOS ARMA DEVUELTA SEGUN SISTEMA: ',0,'L');
        
        $this->SetX(28);
        $this->SetFont('Arial', 'B', 9);
        $this->MultiCell(60,7,'SERIE A DEVOLVER:   '.$this->data['SERIE_DEVUELTA'],'T,L,R','L');
        
        $this->SetX(28);
        $this->SetFont('Arial', '', 8);
        $this->MultiCell(60,7,'ESTADO:    '.$this->data['ESTADO'],'L,R','L');
        
        $this->SetX(28);
        $this->MultiCell(60,7,'ASIGNADA A:    '.$this->data['ONI_CARGO'].' - '.$this->data['NOMBRE_A_CARGO'],'L,R','L');
        $this->SetX(28);
        $this->MultiCell(60,7,'UBICACION ARMA:    '.$this->data['CCOSTOASIG'],'L,B,R','L');
       }
        $this->SetFont('Arial', '', 9);
        
        
        $this->Text(35, 190, utf8_decode("SEÑOR :"));
        $this->Text(35, 195, utf8_decode($this->data['NOMBRE_JEFE']));
        $this->Text(20, 208, utf8_decode("Por este medio se autoriza al portador de la presente para retirar de Almacén N° 6 el arma, cuyas caracteristicas"));
        $this->Text(20, 212, utf8_decode("se mencionan con anterioridad; para lo cual ya se realizó la respectiva verificación."));
        $this->Text(20, 220, utf8_decode("Atentamente,"));
        $this->Text(20, 235, utf8_decode("Autorizado:"));
        $this->Text(100, 250, utf8_decode("Inspector/ra: ".$this->data['NOMBRE_AUTORIZACION']));
        $this->Text(110, 254, utf8_decode("Jefe/a Departamento de Suministros"));
*/
    }
    public function data($datos)
    {
        //Set the title to the report
        $this->data = $datos;
    }
    public function SetOniEntrega($oni)
    {
        //Set the title to the report
        $this->oni_entrega=$oni;
    }

    public function nombreAsignado($nombreAsignado)
    {
        //Set the title to the report
        $this->nombreAsignado = $nombreAsignado;
    }

    
/*
    public function SetTitle($t)
    {
        //Set the title to the report
        $this->title=$t;
    }
*/
    public function SetDocumento($doc){
        $this->numDocumento=$doc;
    }

    public function SetTipoDocumento($tipo){
        $this->tipoDocumento=$tipo;
    }

    public function SetCCosto($cc)
    {
        //Establecer la matriz de anchos de columna
        $this->cCosto=$cc;       
    }

    public function SetCCosto2($cc2)
    {
        //Establecer la matriz de anchos de columna   
        $this->cCosto2=$cc2;      
    }

    public function SetWidths($w)
    {
        //Establecer la matriz de anchos de columna
        $this->widths=$w;
    }

    public function SetAligns($a)
    {
        //Set the array of column alignments
        $this->aligns=$a;
    }

    public function actual_date ()  
{  
    $week_days = array ("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado");  
    $months = array ("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");  
    $year_now = date ("Y");  
    $month_now = date ("n");  
    $day_now = date ("j");  
    $week_day_now = date ("w");  
    $date = $week_days[$week_day_now] . ", " . $day_now . " de " . $months[$month_now] . " de " . $year_now;   
    return $date;    
} 

    public function RowHeader($data)
    {
        //Calculate the height of the row
        $nb=0;
        for ($i=0;$i<count($data);$i++) {
            $nb=max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        }
        $h=2*$nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //$this->SetFont('Arial', 'B', 8);
        //$this->Text($this->GetX(), $this->GetY() - 2, trim($this->title));
        $this->SetFont('Arial', 'B', 7);
        //Draw the cells of the row
        for ($i=0;$i<count($data);$i++) {
            $w=$this->widths[$i];
            $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x=$this->GetX();
            $y=$this->GetY();
            //Draw the border
           // $this->Rect($x, $y, $w, $h);
            //Print the text
            $this->MultiCell($w, 3, $data[$i], 0, $a);
            //Put the position to the right of the cell
            $this->SetXY($x+$w, $y);
        }
        $this->SetFont('Arial', '', 7);
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
        $h=(3*$nb);
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //$this->SetFont('Arial', 'B', 8);
        //$this->Text($this->GetX(), $this->GetY() - 2, trim($this->title));
        $this->SetFont('Arial', 'B', 7);
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
        #$this->SetFont('Arial', '', 3);
        //Go to the next line
        $this->Ln($h);
    }


    public function Row($data,$colorear)
    {
        //Calculate the height of the row
        $nb=0;
        for ($i=0;$i<count($data);$i++) {
            $nb=max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        }
        $h=(3*$nb)+1;
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
            $this->Rect($x, $y, $w, $h+1);
            //Print the text
            $this->MultiCell($w, 4, $data[$i], 0, $a, $colorear);
            //Put the position to the right of the cell
            $this->SetXY($x+$w, $y);
        }
        //Go to the next line
        $this->Ln($h+1);
    }

    public function CheckPageBreak($h)
    {
        //If the height h would cause an overflow, add a new page immediately
        if ($this->GetY()+$h+1>$this->PageBreakTrigger) {
            $this->AddPage('L', 'Letter');
            $this->Header();
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
        return new PDF_Remision();
    }
}
