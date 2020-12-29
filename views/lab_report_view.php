<?php

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
//$pdf->SetAuthor('Nicola Asuni');
//$pdf->SetTitle('TCPDF Example 005');
//$pdf->SetSubject('TCPDF Tutorial');
//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, 190, ''.'','');
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.'', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('times', '', 10);

// add a page
$pdf->AddPage();

// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
$pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 127);


   $this->load->helper('date');
		$dateTimeformat = "%Y-%m-%d %h:%i %A";

		$filname='';
		  $barcodeNumber='';
		$output = '<table width="100%" align="left" cellpadding = "2" style="border-collapse: collapse;  border-color: #D5D5D5;
		 font-family:Arial; font-size:13px " >';

		foreach($data->result() as $row)
		{
		$filname=$row->first_name;
		$barcodeNumber=$row->barcode_number;
			$output .= '
			 <tr >
			   <td  colspan="2" style="background-color:#4385F4;color: white;font-weight: bold;">
			   Client Identification
			   </td>
			   </tr>
			   <tr>				  		   
				<td width="50%" align=left>
					<p><b>Full Name : </b>'.$row->first_name.' '. $row->father_name.' '. $row->grand_father_name.' </p>
					<p><b>Gender : </b>'.$row->gender.'</p>
					<p><b>Passport Number : </b>'.$row->passport_number.'</p>
					<p><b>ResidenceCity/Town : </b> '.$row->city.' </p>	
				</td>
				<td width="50%" align=left>	
				<p><b>Age in year : </b>'.(date('Y') - date('Y',strtotime($row->birth_date))).'</p>
				<p><b>Nationality : </b>'.$row->nationality.'</p>
				<p><b>phone Number : </b> '.$row->phone_number.' </p>
				<p><b>Region : </b>'.$row->region.'</p>
					
				</td>
			</tr>			
			 <tr>
			 <td  colspan="2" style="background-color:#4385F4;color: white; font-weight: bold;">
			   Specimen Information
			   </td>
			   </tr>
			   <tr>				  		   
				<td width="50%" align=left>
				<p><b>Sample Id : </b>'.$row->sample_id.' </p>
					
					<p><b>Date of Specimen Collection : </b>'.date('d/m/y', strtotime($row->date)).'</p>
					<p><b>Site of specimen collection : </b>'.$row->collection_site.'</p>					
					<p><b>Reason for Test : </b>'.$row->reason_for_testing.'</p>
				</td>
				<td width="50%" align=left>	
								
					<p ><b>Specimen Type : </b>'.$row->specimen_type.'</p>
					<p><b>Time of Specimen Collection : </b>'.date('g:i A', strtotime($row->date)).'</p>
					<p><b>Sample Collected by : </b>'.$row->cbyfname.' '. $row->cbylname.' </p>					
				    <p><b>Requested by : </b>Self </p>
				</td>
			</tr>			
			 <tr>
			 <td  colspan="2" style="background-color:#4385F4;color: white;font-weight: bold;">
			   Test Result
			   </td>
			   </tr>
			   <tr>				  		   
				<td width="50%" align=left>
				<p><b>Requested Test :  : </b>'.$row->test.' </p>
				
					<p><b>Test Result : </b>'.$row->result.'</p>
					<p><b>Time Result Issued :  </b>'.date('g:i A', strtotime($row->result_date)).'</p>
					<p><b>Result Reviewed by:</b>'.$row->rapbyfname.' '. $row->rapbylname.' </p>
					
				</td>
				<td width="50%">
				<p><b>Test Method : </b>'.$row->test_method.'</p>					
				<p><b>Date Result Issued :  </b>'.date('d/m/y', strtotime($row->result_date)).'</p>
				<p><b>Test Done by :  </b>'.$row->tdbyfname.' '. $row->tdbylname.' </p>	
				<p><b>Testing Laboratory : </b>ICMC COVID Lab</p>					
					
					</td>
			</tr>
	  <tr>
	     <td colspan="2">
       <p><b>Report Authorized and Issued by : </b>'.$this->session->userdata('username').'</p>
					<p><b>Signature : </b>_______________________________</p>
					<p><b>Date : </b> '.mdate($dateTimeformat).'</p>
					</td>
		</tr>
		 <tr>
			 <td  colspan="2" style="background-color:#4385F4;color: white;font-weight: bold;">
			   
			   </td>
			   </tr>
			<tr>
			<td colspan="2" align="left" ><img src="'.base_url().'assets/images/info.png" /></td>
		</tr>
		';
		}
	
		$output .= '</table>';
		
		$pdf->writeHTMLCell(0,0,'','',$output,0,1,0,true,'C',true);
  
	//$pdf->Ln();	
// define barcode style
$style = array(
    'position' => '',
    'align' => 'C',
    'stretch' => false,
    'fitwidth' => true,
    'cellfitalign' => '',
    'border' => true,
    'hpadding' => 'auto',
    'vpadding' => 'auto',
    'fgcolor' => array(0,0,0),
    'bgcolor' => false, //array(255,255,255),
    'text' => true,
    'font' => 'helvetica',
    'fontsize' => 8,
    'stretchtext' => 4
);

// PRINT VARIOUS 1D BARCODES
$pdf->setBarcode($barcodeNumber, 'C39', '', '', '', 18, 0.4, $style, 'N');
// Standard 2 of 5

$pdf->write1DBarcode($barcodeNumber, 'S25', '', '', '', 18, 0.4, $style, 'N');
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
ob_clean();
$pdf->Output($filname.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+