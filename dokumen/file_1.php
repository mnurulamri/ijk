<?php
include('../views/form_lembur_data_pemohon.php');

//ambil data unit kerja
$sql = "SELECT unit_kerja_ijk, unit_kerja_real FROM cek_unit_kerja";
$query = mysql_query($sql) or die(mysql_error());
while ($row = mysql_fetch_assoc($query)){
	$array_unit_kerja[$row['unit_kerja_ijk']] = $row['unit_kerja_real'];
	$array_pejabat[$row['unit_kerja_ijk']] = $row['pejabat'];
}

#ambil data lembur
$sql ="SELECT id, tgl_lembur, presensi, uraian, waktu_lembur, status, keterangan, flag_libur, honor_lembur
		FROM lembur_detail
		WHERE nip = '$nip' AND flag_transaksi = 0
		ORDER BY tgl_lembur";
$result = mysql_query($sql) or die(mysql_error());
while($row = mysql_fetch_assoc($result)){
	$data_lembur[] = $row;
}

//echo pelaksanaan_lembur($data_lembur); exit();

if (empty($array_unit_kerja[$row['unit_kerja']])) {
	$unit_kerja = $row['unit_kerja'];
} else {
	$unit_Kerja = $array_unit_kerja[$row['unit_kerja']];
}

if (empty($array_pejabat[$row['unit_kerja']])) {
	$pejabat = '...';
} else {
	$pejabat = $array_pejabat[$row['unit_kerja']];
}

$nip = $data['nip'];
$nama = $data['nama'];
$golongan = $data['golongan'];
$unit_kerja = $unit_Kerja;
$deskripsi = $data['deskripsi'];

$html = head();
$html.= data_pemohon($nip, $nama, $golongan, $unit_kerja);
$html.= pelaksanaan_lembur($data_lembur, $deskripsi);
$html.= tanda_tangan_persetujuan($nama, $pejabat);
$html.= foot();
//echo $html;
function head()
{
$html = '
	<html xmlns:v="urn:schemas-microsoft-com:vml"
	xmlns:o="urn:schemas-microsoft-com:office:office"
	xmlns:w="urn:schemas-microsoft-com:office:word"
	xmlns:m="http://schemas.microsoft.com/office/2004/12/omml"
	xmlns="http://www.w3.org/TR/REC-html40">

	<head>
	<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
	<meta name=ProgId content=Word.Document>
	<meta name=Generator content="Microsoft Word 15">
	<meta name=Originator content="Microsoft Word 15">
	<link rel=File-List href="form_pengajuan_lembur_files/filelist.xml">
	<link rel=Edit-Time-Data href="form_pengajuan_lembur_files/editdata.mso">
	<!--[if !mso]>
	<style>
	v\:* {behavior:url(#default#VML);}
	o\:* {behavior:url(#default#VML);}
	w\:* {behavior:url(#default#VML);}
	.shape {behavior:url(#default#VML);}
	</style>
	<![endif]--><!--[if gte mso 9]><xml>
	 <o:DocumentProperties>
	  <o:Author>user</o:Author>
	  <o:Template>Normal</o:Template>
	  <o:LastAuthor>work</o:LastAuthor>
	  <o:Revision>2</o:Revision>
	  <o:TotalTime>0</o:TotalTime>
	  <o:LastPrinted>2018-11-06T02:59:00Z</o:LastPrinted>
	  <o:Created>2019-02-28T22:52:00Z</o:Created>
	  <o:LastSaved>2019-02-28T22:52:00Z</o:LastSaved>
	  <o:Pages>1</o:Pages>
	  <o:Words>169</o:Words>
	  <o:Characters>966</o:Characters>
	  <o:Lines>8</o:Lines>
	  <o:Paragraphs>2</o:Paragraphs>
	  <o:CharactersWithSpaces>1133</o:CharactersWithSpaces>
	  <o:Version>16.00</o:Version>
	 </o:DocumentProperties>
	</xml><![endif]-->
	<link rel=dataStoreItem href="form_pengajuan_lembur_files/item0001.xml"
	target="form_pengajuan_lembur_files/props002.xml">
	<link rel=themeData href="form_pengajuan_lembur_files/themedata.thmx">
	<link rel=colorSchemeMapping
	href="form_pengajuan_lembur_files/colorschememapping.xml">
	<!--[if gte mso 9]><xml>
	 <w:WordDocument>
	  <w:SpellingState>Clean</w:SpellingState>
	  <w:GrammarState>Clean</w:GrammarState>
	  <w:TrackMoves>false</w:TrackMoves>
	  <w:TrackFormatting/>
	  <w:PunctuationKerning/>
	  <w:DrawingGridHorizontalSpacing>5,5 pt</w:DrawingGridHorizontalSpacing>
	  <w:DisplayHorizontalDrawingGridEvery>2</w:DisplayHorizontalDrawingGridEvery>
	  <w:ValidateAgainstSchemas/>
	  <w:SaveIfXMLInvalid>false</w:SaveIfXMLInvalid>
	  <w:IgnoreMixedContent>false</w:IgnoreMixedContent>
	  <w:AlwaysShowPlaceholderText>false</w:AlwaysShowPlaceholderText>
	  <w:DoNotPromoteQF/>
	  <w:LidThemeOther>IN</w:LidThemeOther>
	  <w:LidThemeAsian>X-NONE</w:LidThemeAsian>
	  <w:LidThemeComplexScript>X-NONE</w:LidThemeComplexScript>
	  <w:Compatibility>
	   <w:BreakWrappedTables/>
	   <w:SnapToGridInCell/>
	   <w:WrapTextWithPunct/>
	   <w:UseAsianBreakRules/>
	   <w:DontGrowAutofit/>
	   <w:SplitPgBreakAndParaMark/>
	   <w:EnableOpenTypeKerning/>
	   <w:DontFlipMirrorIndents/>
	   <w:OverrideTableStyleHps/>
	  </w:Compatibility>
	  <m:mathPr>
	   <m:mathFont m:val="Cambria Math"/>
	   <m:brkBin m:val="before"/>
	   <m:brkBinSub m:val="&#45;-"/>
	   <m:smallFrac m:val="off"/>
	   <m:dispDef/>
	   <m:lMargin m:val="0"/>
	   <m:rMargin m:val="0"/>
	   <m:defJc m:val="centerGroup"/>
	   <m:wrapIndent m:val="1440"/>
	   <m:intLim m:val="subSup"/>
	   <m:naryLim m:val="undOvr"/>
	  </m:mathPr></w:WordDocument>
	</xml><![endif]--><!--[if gte mso 9]><xml>
	 <w:LatentStyles DefLockedState="false" DefUnhideWhenUsed="false"
	  DefSemiHidden="false" DefQFormat="false" DefPriority="99"
	  LatentStyleCount="371">
	  <w:LsdException Locked="false" Priority="0" QFormat="true" Name="Normal"/>
	  <w:LsdException Locked="false" Priority="9" QFormat="true" Name="heading 1"/>
	  <w:LsdException Locked="false" Priority="9" SemiHidden="true"
	   UnhideWhenUsed="true" QFormat="true" Name="heading 2"/>
	  <w:LsdException Locked="false" Priority="9" SemiHidden="true"
	   UnhideWhenUsed="true" QFormat="true" Name="heading 3"/>
	  <w:LsdException Locked="false" Priority="9" SemiHidden="true"
	   UnhideWhenUsed="true" QFormat="true" Name="heading 4"/>
	  <w:LsdException Locked="false" Priority="9" SemiHidden="true"
	   UnhideWhenUsed="true" QFormat="true" Name="heading 5"/>
	  <w:LsdException Locked="false" Priority="9" SemiHidden="true"
	   UnhideWhenUsed="true" QFormat="true" Name="heading 6"/>
	  <w:LsdException Locked="false" Priority="9" SemiHidden="true"
	   UnhideWhenUsed="true" QFormat="true" Name="heading 7"/>
	  <w:LsdException Locked="false" Priority="9" SemiHidden="true"
	   UnhideWhenUsed="true" QFormat="true" Name="heading 8"/>
	  <w:LsdException Locked="false" Priority="9" SemiHidden="true"
	   UnhideWhenUsed="true" QFormat="true" Name="heading 9"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="index 1"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="index 2"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="index 3"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="index 4"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="index 5"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="index 6"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="index 7"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="index 8"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="index 9"/>
	  <w:LsdException Locked="false" Priority="39" SemiHidden="true"
	   UnhideWhenUsed="true" Name="toc 1"/>
	  <w:LsdException Locked="false" Priority="39" SemiHidden="true"
	   UnhideWhenUsed="true" Name="toc 2"/>
	  <w:LsdException Locked="false" Priority="39" SemiHidden="true"
	   UnhideWhenUsed="true" Name="toc 3"/>
	  <w:LsdException Locked="false" Priority="39" SemiHidden="true"
	   UnhideWhenUsed="true" Name="toc 4"/>
	  <w:LsdException Locked="false" Priority="39" SemiHidden="true"
	   UnhideWhenUsed="true" Name="toc 5"/>
	  <w:LsdException Locked="false" Priority="39" SemiHidden="true"
	   UnhideWhenUsed="true" Name="toc 6"/>
	  <w:LsdException Locked="false" Priority="39" SemiHidden="true"
	   UnhideWhenUsed="true" Name="toc 7"/>
	  <w:LsdException Locked="false" Priority="39" SemiHidden="true"
	   UnhideWhenUsed="true" Name="toc 8"/>
	  <w:LsdException Locked="false" Priority="39" SemiHidden="true"
	   UnhideWhenUsed="true" Name="toc 9"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Normal Indent"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="footnote text"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="annotation text"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="header"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="footer"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="index heading"/>
	  <w:LsdException Locked="false" Priority="35" SemiHidden="true"
	   UnhideWhenUsed="true" QFormat="true" Name="caption"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="table of figures"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="envelope address"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="envelope return"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="footnote reference"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="annotation reference"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="line number"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="page number"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="endnote reference"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="endnote text"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="table of authorities"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="macro"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="toa heading"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="List"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="List Bullet"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="List Number"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="List 2"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="List 3"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="List 4"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="List 5"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="List Bullet 2"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="List Bullet 3"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="List Bullet 4"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="List Bullet 5"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="List Number 2"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="List Number 3"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="List Number 4"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="List Number 5"/>
	  <w:LsdException Locked="false" Priority="10" QFormat="true" Name="Title"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Closing"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Signature"/>
	  <w:LsdException Locked="false" Priority="1" SemiHidden="true"
	   UnhideWhenUsed="true" Name="Default Paragraph Font"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Body Text"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Body Text Indent"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="List Continue"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="List Continue 2"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="List Continue 3"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="List Continue 4"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="List Continue 5"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Message Header"/>
	  <w:LsdException Locked="false" Priority="11" QFormat="true" Name="Subtitle"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Salutation"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Date"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Body Text First Indent"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Body Text First Indent 2"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Note Heading"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Body Text 2"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Body Text 3"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Body Text Indent 2"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Body Text Indent 3"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Block Text"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Hyperlink"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="FollowedHyperlink"/>
	  <w:LsdException Locked="false" Priority="22" QFormat="true" Name="Strong"/>
	  <w:LsdException Locked="false" Priority="20" QFormat="true" Name="Emphasis"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Document Map"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Plain Text"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="E-mail Signature"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="HTML Top of Form"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="HTML Bottom of Form"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Normal (Web)"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="HTML Acronym"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="HTML Address"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="HTML Cite"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="HTML Code"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="HTML Definition"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="HTML Keyboard"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="HTML Preformatted"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="HTML Sample"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="HTML Typewriter"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="HTML Variable"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Normal Table"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="annotation subject"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="No List"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Outline List 1"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Outline List 2"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Outline List 3"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Table Simple 1"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Table Simple 2"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Table Simple 3"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Table Classic 1"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Table Classic 2"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Table Classic 3"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Table Classic 4"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Table Colorful 1"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Table Colorful 2"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Table Colorful 3"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Table Columns 1"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Table Columns 2"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Table Columns 3"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Table Columns 4"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Table Columns 5"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Table Grid 1"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Table Grid 2"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Table Grid 3"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Table Grid 4"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Table Grid 5"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Table Grid 6"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Table Grid 7"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Table Grid 8"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Table List 1"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Table List 2"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Table List 3"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Table List 4"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Table List 5"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Table List 6"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Table List 7"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Table List 8"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Table 3D effects 1"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Table 3D effects 2"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Table 3D effects 3"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Table Contemporary"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Table Elegant"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Table Professional"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Table Subtle 1"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Table Subtle 2"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Table Web 1"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Table Web 2"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Table Web 3"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Balloon Text"/>
	  <w:LsdException Locked="false" Priority="59" Name="Table Grid"/>
	  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
	   Name="Table Theme"/>
	  <w:LsdException Locked="false" SemiHidden="true" Name="Placeholder Text"/>
	  <w:LsdException Locked="false" Priority="1" QFormat="true" Name="No Spacing"/>
	  <w:LsdException Locked="false" Priority="60" Name="Light Shading"/>
	  <w:LsdException Locked="false" Priority="61" Name="Light List"/>
	  <w:LsdException Locked="false" Priority="62" Name="Light Grid"/>
	  <w:LsdException Locked="false" Priority="63" Name="Medium Shading 1"/>
	  <w:LsdException Locked="false" Priority="64" Name="Medium Shading 2"/>
	  <w:LsdException Locked="false" Priority="65" Name="Medium List 1"/>
	  <w:LsdException Locked="false" Priority="66" Name="Medium List 2"/>
	  <w:LsdException Locked="false" Priority="67" Name="Medium Grid 1"/>
	  <w:LsdException Locked="false" Priority="68" Name="Medium Grid 2"/>
	  <w:LsdException Locked="false" Priority="69" Name="Medium Grid 3"/>
	  <w:LsdException Locked="false" Priority="70" Name="Dark List"/>
	  <w:LsdException Locked="false" Priority="71" Name="Colorful Shading"/>
	  <w:LsdException Locked="false" Priority="72" Name="Colorful List"/>
	  <w:LsdException Locked="false" Priority="73" Name="Colorful Grid"/>
	  <w:LsdException Locked="false" Priority="60" Name="Light Shading Accent 1"/>
	  <w:LsdException Locked="false" Priority="61" Name="Light List Accent 1"/>
	  <w:LsdException Locked="false" Priority="62" Name="Light Grid Accent 1"/>
	  <w:LsdException Locked="false" Priority="63" Name="Medium Shading 1 Accent 1"/>
	  <w:LsdException Locked="false" Priority="64" Name="Medium Shading 2 Accent 1"/>
	  <w:LsdException Locked="false" Priority="65" Name="Medium List 1 Accent 1"/>
	  <w:LsdException Locked="false" SemiHidden="true" Name="Revision"/>
	  <w:LsdException Locked="false" Priority="34" QFormat="true"
	   Name="List Paragraph"/>
	  <w:LsdException Locked="false" Priority="29" QFormat="true" Name="Quote"/>
	  <w:LsdException Locked="false" Priority="30" QFormat="true"
	   Name="Intense Quote"/>
	  <w:LsdException Locked="false" Priority="66" Name="Medium List 2 Accent 1"/>
	  <w:LsdException Locked="false" Priority="67" Name="Medium Grid 1 Accent 1"/>
	  <w:LsdException Locked="false" Priority="68" Name="Medium Grid 2 Accent 1"/>
	  <w:LsdException Locked="false" Priority="69" Name="Medium Grid 3 Accent 1"/>
	  <w:LsdException Locked="false" Priority="70" Name="Dark List Accent 1"/>
	  <w:LsdException Locked="false" Priority="71" Name="Colorful Shading Accent 1"/>
	  <w:LsdException Locked="false" Priority="72" Name="Colorful List Accent 1"/>
	  <w:LsdException Locked="false" Priority="73" Name="Colorful Grid Accent 1"/>
	  <w:LsdException Locked="false" Priority="60" Name="Light Shading Accent 2"/>
	  <w:LsdException Locked="false" Priority="61" Name="Light List Accent 2"/>
	  <w:LsdException Locked="false" Priority="62" Name="Light Grid Accent 2"/>
	  <w:LsdException Locked="false" Priority="63" Name="Medium Shading 1 Accent 2"/>
	  <w:LsdException Locked="false" Priority="64" Name="Medium Shading 2 Accent 2"/>
	  <w:LsdException Locked="false" Priority="65" Name="Medium List 1 Accent 2"/>
	  <w:LsdException Locked="false" Priority="66" Name="Medium List 2 Accent 2"/>
	  <w:LsdException Locked="false" Priority="67" Name="Medium Grid 1 Accent 2"/>
	  <w:LsdException Locked="false" Priority="68" Name="Medium Grid 2 Accent 2"/>
	  <w:LsdException Locked="false" Priority="69" Name="Medium Grid 3 Accent 2"/>
	  <w:LsdException Locked="false" Priority="70" Name="Dark List Accent 2"/>
	  <w:LsdException Locked="false" Priority="71" Name="Colorful Shading Accent 2"/>
	  <w:LsdException Locked="false" Priority="72" Name="Colorful List Accent 2"/>
	  <w:LsdException Locked="false" Priority="73" Name="Colorful Grid Accent 2"/>
	  <w:LsdException Locked="false" Priority="60" Name="Light Shading Accent 3"/>
	  <w:LsdException Locked="false" Priority="61" Name="Light List Accent 3"/>
	  <w:LsdException Locked="false" Priority="62" Name="Light Grid Accent 3"/>
	  <w:LsdException Locked="false" Priority="63" Name="Medium Shading 1 Accent 3"/>
	  <w:LsdException Locked="false" Priority="64" Name="Medium Shading 2 Accent 3"/>
	  <w:LsdException Locked="false" Priority="65" Name="Medium List 1 Accent 3"/>
	  <w:LsdException Locked="false" Priority="66" Name="Medium List 2 Accent 3"/>
	  <w:LsdException Locked="false" Priority="67" Name="Medium Grid 1 Accent 3"/>
	  <w:LsdException Locked="false" Priority="68" Name="Medium Grid 2 Accent 3"/>
	  <w:LsdException Locked="false" Priority="69" Name="Medium Grid 3 Accent 3"/>
	  <w:LsdException Locked="false" Priority="70" Name="Dark List Accent 3"/>
	  <w:LsdException Locked="false" Priority="71" Name="Colorful Shading Accent 3"/>
	  <w:LsdException Locked="false" Priority="72" Name="Colorful List Accent 3"/>
	  <w:LsdException Locked="false" Priority="73" Name="Colorful Grid Accent 3"/>
	  <w:LsdException Locked="false" Priority="60" Name="Light Shading Accent 4"/>
	  <w:LsdException Locked="false" Priority="61" Name="Light List Accent 4"/>
	  <w:LsdException Locked="false" Priority="62" Name="Light Grid Accent 4"/>
	  <w:LsdException Locked="false" Priority="63" Name="Medium Shading 1 Accent 4"/>
	  <w:LsdException Locked="false" Priority="64" Name="Medium Shading 2 Accent 4"/>
	  <w:LsdException Locked="false" Priority="65" Name="Medium List 1 Accent 4"/>
	  <w:LsdException Locked="false" Priority="66" Name="Medium List 2 Accent 4"/>
	  <w:LsdException Locked="false" Priority="67" Name="Medium Grid 1 Accent 4"/>
	  <w:LsdException Locked="false" Priority="68" Name="Medium Grid 2 Accent 4"/>
	  <w:LsdException Locked="false" Priority="69" Name="Medium Grid 3 Accent 4"/>
	  <w:LsdException Locked="false" Priority="70" Name="Dark List Accent 4"/>
	  <w:LsdException Locked="false" Priority="71" Name="Colorful Shading Accent 4"/>
	  <w:LsdException Locked="false" Priority="72" Name="Colorful List Accent 4"/>
	  <w:LsdException Locked="false" Priority="73" Name="Colorful Grid Accent 4"/>
	  <w:LsdException Locked="false" Priority="60" Name="Light Shading Accent 5"/>
	  <w:LsdException Locked="false" Priority="61" Name="Light List Accent 5"/>
	  <w:LsdException Locked="false" Priority="62" Name="Light Grid Accent 5"/>
	  <w:LsdException Locked="false" Priority="63" Name="Medium Shading 1 Accent 5"/>
	  <w:LsdException Locked="false" Priority="64" Name="Medium Shading 2 Accent 5"/>
	  <w:LsdException Locked="false" Priority="65" Name="Medium List 1 Accent 5"/>
	  <w:LsdException Locked="false" Priority="66" Name="Medium List 2 Accent 5"/>
	  <w:LsdException Locked="false" Priority="67" Name="Medium Grid 1 Accent 5"/>
	  <w:LsdException Locked="false" Priority="68" Name="Medium Grid 2 Accent 5"/>
	  <w:LsdException Locked="false" Priority="69" Name="Medium Grid 3 Accent 5"/>
	  <w:LsdException Locked="false" Priority="70" Name="Dark List Accent 5"/>
	  <w:LsdException Locked="false" Priority="71" Name="Colorful Shading Accent 5"/>
	  <w:LsdException Locked="false" Priority="72" Name="Colorful List Accent 5"/>
	  <w:LsdException Locked="false" Priority="73" Name="Colorful Grid Accent 5"/>
	  <w:LsdException Locked="false" Priority="60" Name="Light Shading Accent 6"/>
	  <w:LsdException Locked="false" Priority="61" Name="Light List Accent 6"/>
	  <w:LsdException Locked="false" Priority="62" Name="Light Grid Accent 6"/>
	  <w:LsdException Locked="false" Priority="63" Name="Medium Shading 1 Accent 6"/>
	  <w:LsdException Locked="false" Priority="64" Name="Medium Shading 2 Accent 6"/>
	  <w:LsdException Locked="false" Priority="65" Name="Medium List 1 Accent 6"/>
	  <w:LsdException Locked="false" Priority="66" Name="Medium List 2 Accent 6"/>
	  <w:LsdException Locked="false" Priority="67" Name="Medium Grid 1 Accent 6"/>
	  <w:LsdException Locked="false" Priority="68" Name="Medium Grid 2 Accent 6"/>
	  <w:LsdException Locked="false" Priority="69" Name="Medium Grid 3 Accent 6"/>
	  <w:LsdException Locked="false" Priority="70" Name="Dark List Accent 6"/>
	  <w:LsdException Locked="false" Priority="71" Name="Colorful Shading Accent 6"/>
	  <w:LsdException Locked="false" Priority="72" Name="Colorful List Accent 6"/>
	  <w:LsdException Locked="false" Priority="73" Name="Colorful Grid Accent 6"/>
	  <w:LsdException Locked="false" Priority="19" QFormat="true"
	   Name="Subtle Emphasis"/>
	  <w:LsdException Locked="false" Priority="21" QFormat="true"
	   Name="Intense Emphasis"/>
	  <w:LsdException Locked="false" Priority="31" QFormat="true"
	   Name="Subtle Reference"/>
	  <w:LsdException Locked="false" Priority="32" QFormat="true"
	   Name="Intense Reference"/>
	  <w:LsdException Locked="false" Priority="33" QFormat="true" Name="Book Title"/>
	  <w:LsdException Locked="false" Priority="37" SemiHidden="true"
	   UnhideWhenUsed="true" Name="Bibliography"/>
	  <w:LsdException Locked="false" Priority="39" SemiHidden="true"
	   UnhideWhenUsed="true" QFormat="true" Name="TOC Heading"/>
	  <w:LsdException Locked="false" Priority="41" Name="Plain Table 1"/>
	  <w:LsdException Locked="false" Priority="42" Name="Plain Table 2"/>
	  <w:LsdException Locked="false" Priority="43" Name="Plain Table 3"/>
	  <w:LsdException Locked="false" Priority="44" Name="Plain Table 4"/>
	  <w:LsdException Locked="false" Priority="45" Name="Plain Table 5"/>
	  <w:LsdException Locked="false" Priority="40" Name="Grid Table Light"/>
	  <w:LsdException Locked="false" Priority="46" Name="Grid Table 1 Light"/>
	  <w:LsdException Locked="false" Priority="47" Name="Grid Table 2"/>
	  <w:LsdException Locked="false" Priority="48" Name="Grid Table 3"/>
	  <w:LsdException Locked="false" Priority="49" Name="Grid Table 4"/>
	  <w:LsdException Locked="false" Priority="50" Name="Grid Table 5 Dark"/>
	  <w:LsdException Locked="false" Priority="51" Name="Grid Table 6 Colorful"/>
	  <w:LsdException Locked="false" Priority="52" Name="Grid Table 7 Colorful"/>
	  <w:LsdException Locked="false" Priority="46"
	   Name="Grid Table 1 Light Accent 1"/>
	  <w:LsdException Locked="false" Priority="47" Name="Grid Table 2 Accent 1"/>
	  <w:LsdException Locked="false" Priority="48" Name="Grid Table 3 Accent 1"/>
	  <w:LsdException Locked="false" Priority="49" Name="Grid Table 4 Accent 1"/>
	  <w:LsdException Locked="false" Priority="50" Name="Grid Table 5 Dark Accent 1"/>
	  <w:LsdException Locked="false" Priority="51"
	   Name="Grid Table 6 Colorful Accent 1"/>
	  <w:LsdException Locked="false" Priority="52"
	   Name="Grid Table 7 Colorful Accent 1"/>
	  <w:LsdException Locked="false" Priority="46"
	   Name="Grid Table 1 Light Accent 2"/>
	  <w:LsdException Locked="false" Priority="47" Name="Grid Table 2 Accent 2"/>
	  <w:LsdException Locked="false" Priority="48" Name="Grid Table 3 Accent 2"/>
	  <w:LsdException Locked="false" Priority="49" Name="Grid Table 4 Accent 2"/>
	  <w:LsdException Locked="false" Priority="50" Name="Grid Table 5 Dark Accent 2"/>
	  <w:LsdException Locked="false" Priority="51"
	   Name="Grid Table 6 Colorful Accent 2"/>
	  <w:LsdException Locked="false" Priority="52"
	   Name="Grid Table 7 Colorful Accent 2"/>
	  <w:LsdException Locked="false" Priority="46"
	   Name="Grid Table 1 Light Accent 3"/>
	  <w:LsdException Locked="false" Priority="47" Name="Grid Table 2 Accent 3"/>
	  <w:LsdException Locked="false" Priority="48" Name="Grid Table 3 Accent 3"/>
	  <w:LsdException Locked="false" Priority="49" Name="Grid Table 4 Accent 3"/>
	  <w:LsdException Locked="false" Priority="50" Name="Grid Table 5 Dark Accent 3"/>
	  <w:LsdException Locked="false" Priority="51"
	   Name="Grid Table 6 Colorful Accent 3"/>
	  <w:LsdException Locked="false" Priority="52"
	   Name="Grid Table 7 Colorful Accent 3"/>
	  <w:LsdException Locked="false" Priority="46"
	   Name="Grid Table 1 Light Accent 4"/>
	  <w:LsdException Locked="false" Priority="47" Name="Grid Table 2 Accent 4"/>
	  <w:LsdException Locked="false" Priority="48" Name="Grid Table 3 Accent 4"/>
	  <w:LsdException Locked="false" Priority="49" Name="Grid Table 4 Accent 4"/>
	  <w:LsdException Locked="false" Priority="50" Name="Grid Table 5 Dark Accent 4"/>
	  <w:LsdException Locked="false" Priority="51"
	   Name="Grid Table 6 Colorful Accent 4"/>
	  <w:LsdException Locked="false" Priority="52"
	   Name="Grid Table 7 Colorful Accent 4"/>
	  <w:LsdException Locked="false" Priority="46"
	   Name="Grid Table 1 Light Accent 5"/>
	  <w:LsdException Locked="false" Priority="47" Name="Grid Table 2 Accent 5"/>
	  <w:LsdException Locked="false" Priority="48" Name="Grid Table 3 Accent 5"/>
	  <w:LsdException Locked="false" Priority="49" Name="Grid Table 4 Accent 5"/>
	  <w:LsdException Locked="false" Priority="50" Name="Grid Table 5 Dark Accent 5"/>
	  <w:LsdException Locked="false" Priority="51"
	   Name="Grid Table 6 Colorful Accent 5"/>
	  <w:LsdException Locked="false" Priority="52"
	   Name="Grid Table 7 Colorful Accent 5"/>
	  <w:LsdException Locked="false" Priority="46"
	   Name="Grid Table 1 Light Accent 6"/>
	  <w:LsdException Locked="false" Priority="47" Name="Grid Table 2 Accent 6"/>
	  <w:LsdException Locked="false" Priority="48" Name="Grid Table 3 Accent 6"/>
	  <w:LsdException Locked="false" Priority="49" Name="Grid Table 4 Accent 6"/>
	  <w:LsdException Locked="false" Priority="50" Name="Grid Table 5 Dark Accent 6"/>
	  <w:LsdException Locked="false" Priority="51"
	   Name="Grid Table 6 Colorful Accent 6"/>
	  <w:LsdException Locked="false" Priority="52"
	   Name="Grid Table 7 Colorful Accent 6"/>
	  <w:LsdException Locked="false" Priority="46" Name="List Table 1 Light"/>
	  <w:LsdException Locked="false" Priority="47" Name="List Table 2"/>
	  <w:LsdException Locked="false" Priority="48" Name="List Table 3"/>
	  <w:LsdException Locked="false" Priority="49" Name="List Table 4"/>
	  <w:LsdException Locked="false" Priority="50" Name="List Table 5 Dark"/>
	  <w:LsdException Locked="false" Priority="51" Name="List Table 6 Colorful"/>
	  <w:LsdException Locked="false" Priority="52" Name="List Table 7 Colorful"/>
	  <w:LsdException Locked="false" Priority="46"
	   Name="List Table 1 Light Accent 1"/>
	  <w:LsdException Locked="false" Priority="47" Name="List Table 2 Accent 1"/>
	  <w:LsdException Locked="false" Priority="48" Name="List Table 3 Accent 1"/>
	  <w:LsdException Locked="false" Priority="49" Name="List Table 4 Accent 1"/>
	  <w:LsdException Locked="false" Priority="50" Name="List Table 5 Dark Accent 1"/>
	  <w:LsdException Locked="false" Priority="51"
	   Name="List Table 6 Colorful Accent 1"/>
	  <w:LsdException Locked="false" Priority="52"
	   Name="List Table 7 Colorful Accent 1"/>
	  <w:LsdException Locked="false" Priority="46"
	   Name="List Table 1 Light Accent 2"/>
	  <w:LsdException Locked="false" Priority="47" Name="List Table 2 Accent 2"/>
	  <w:LsdException Locked="false" Priority="48" Name="List Table 3 Accent 2"/>
	  <w:LsdException Locked="false" Priority="49" Name="List Table 4 Accent 2"/>
	  <w:LsdException Locked="false" Priority="50" Name="List Table 5 Dark Accent 2"/>
	  <w:LsdException Locked="false" Priority="51"
	   Name="List Table 6 Colorful Accent 2"/>
	  <w:LsdException Locked="false" Priority="52"
	   Name="List Table 7 Colorful Accent 2"/>
	  <w:LsdException Locked="false" Priority="46"
	   Name="List Table 1 Light Accent 3"/>
	  <w:LsdException Locked="false" Priority="47" Name="List Table 2 Accent 3"/>
	  <w:LsdException Locked="false" Priority="48" Name="List Table 3 Accent 3"/>
	  <w:LsdException Locked="false" Priority="49" Name="List Table 4 Accent 3"/>
	  <w:LsdException Locked="false" Priority="50" Name="List Table 5 Dark Accent 3"/>
	  <w:LsdException Locked="false" Priority="51"
	   Name="List Table 6 Colorful Accent 3"/>
	  <w:LsdException Locked="false" Priority="52"
	   Name="List Table 7 Colorful Accent 3"/>
	  <w:LsdException Locked="false" Priority="46"
	   Name="List Table 1 Light Accent 4"/>
	  <w:LsdException Locked="false" Priority="47" Name="List Table 2 Accent 4"/>
	  <w:LsdException Locked="false" Priority="48" Name="List Table 3 Accent 4"/>
	  <w:LsdException Locked="false" Priority="49" Name="List Table 4 Accent 4"/>
	  <w:LsdException Locked="false" Priority="50" Name="List Table 5 Dark Accent 4"/>
	  <w:LsdException Locked="false" Priority="51"
	   Name="List Table 6 Colorful Accent 4"/>
	  <w:LsdException Locked="false" Priority="52"
	   Name="List Table 7 Colorful Accent 4"/>
	  <w:LsdException Locked="false" Priority="46"
	   Name="List Table 1 Light Accent 5"/>
	  <w:LsdException Locked="false" Priority="47" Name="List Table 2 Accent 5"/>
	  <w:LsdException Locked="false" Priority="48" Name="List Table 3 Accent 5"/>
	  <w:LsdException Locked="false" Priority="49" Name="List Table 4 Accent 5"/>
	  <w:LsdException Locked="false" Priority="50" Name="List Table 5 Dark Accent 5"/>
	  <w:LsdException Locked="false" Priority="51"
	   Name="List Table 6 Colorful Accent 5"/>
	  <w:LsdException Locked="false" Priority="52"
	   Name="List Table 7 Colorful Accent 5"/>
	  <w:LsdException Locked="false" Priority="46"
	   Name="List Table 1 Light Accent 6"/>
	  <w:LsdException Locked="false" Priority="47" Name="List Table 2 Accent 6"/>
	  <w:LsdException Locked="false" Priority="48" Name="List Table 3 Accent 6"/>
	  <w:LsdException Locked="false" Priority="49" Name="List Table 4 Accent 6"/>
	  <w:LsdException Locked="false" Priority="50" Name="List Table 5 Dark Accent 6"/>
	  <w:LsdException Locked="false" Priority="51"
	   Name="List Table 6 Colorful Accent 6"/>
	  <w:LsdException Locked="false" Priority="52"
	   Name="List Table 7 Colorful Accent 6"/>
	 </w:LatentStyles>
	</xml><![endif]-->
	<style>
	<!--
	 /* Font Definitions */
	 @font-face
		{font-family:Wingdings;
		panose-1:5 0 0 0 0 0 0 0 0 0;
		mso-font-charset:2;
		mso-generic-font-family:auto;
		mso-font-pitch:variable;
		mso-font-signature:0 268435456 0 0 -2147483648 0;}
	@font-face
		{font-family:"Cambria Math";
		panose-1:2 4 5 3 5 4 6 3 2 4;
		mso-font-charset:1;
		mso-generic-font-family:roman;
		mso-font-pitch:variable;
		mso-font-signature:0 0 0 0 0 0;}
	@font-face
		{font-family:Calibri;
		panose-1:2 15 5 2 2 2 4 3 2 4;
		mso-font-charset:0;
		mso-generic-font-family:swiss;
		mso-font-pitch:variable;
		mso-font-signature:-536859905 -1073732485 9 0 511 0;}
	@font-face
		{font-family:"Segoe UI";
		panose-1:2 11 5 2 4 2 4 2 2 3;
		mso-font-charset:0;
		mso-generic-font-family:swiss;
		mso-font-pitch:variable;
		mso-font-signature:-469750017 -1073683329 9 0 511 0;}
	 /* Style Definitions */
	 p.MsoNormal, li.MsoNormal, div.MsoNormal
		{mso-style-unhide:no;
		mso-style-qformat:yes;
		mso-style-parent:"";
		margin-top:0cm;
		margin-right:0cm;
		margin-bottom:10.0pt;
		margin-left:0cm;
		line-height:115%;
		mso-pagination:widow-orphan;
		font-size:11.0pt;
		font-family:"Calibri",sans-serif;
		mso-fareast-font-family:Calibri;
		mso-bidi-font-family:"Times New Roman";
		mso-ansi-language:EN-US;
		mso-fareast-language:EN-US;}
	p.MsoHeader, li.MsoHeader, div.MsoHeader
		{mso-style-priority:99;
		mso-style-link:"Header Char";
		margin:0cm;
		margin-bottom:.0001pt;
		mso-pagination:widow-orphan;
		tab-stops:center 234.0pt right 468.0pt;
		font-size:11.0pt;
		font-family:"Calibri",sans-serif;
		mso-fareast-font-family:Calibri;
		mso-bidi-font-family:"Times New Roman";
		mso-ansi-language:EN-US;
		mso-fareast-language:EN-US;}
	p.MsoFooter, li.MsoFooter, div.MsoFooter
		{mso-style-priority:99;
		mso-style-link:"Footer Char";
		margin:0cm;
		margin-bottom:.0001pt;
		mso-pagination:widow-orphan;
		tab-stops:center 234.0pt right 468.0pt;
		font-size:11.0pt;
		font-family:"Calibri",sans-serif;
		mso-fareast-font-family:Calibri;
		mso-bidi-font-family:"Times New Roman";
		mso-ansi-language:EN-US;
		mso-fareast-language:EN-US;}
	a:link, span.MsoHyperlink
		{mso-style-priority:99;
		mso-style-parent:"";
		color:blue;
		text-decoration:underline;
		text-underline:single;}
	a:visited, span.MsoHyperlinkFollowed
		{mso-style-noshow:yes;
		mso-style-priority:99;
		color:#954F72;
		mso-themecolor:followedhyperlink;
		text-decoration:underline;
		text-underline:single;}
	p.MsoAcetate, li.MsoAcetate, div.MsoAcetate
		{mso-style-noshow:yes;
		mso-style-priority:99;
		mso-style-link:"Balloon Text Char";
		margin:0cm;
		margin-bottom:.0001pt;
		mso-pagination:widow-orphan;
		font-size:9.0pt;
		font-family:"Segoe UI",sans-serif;
		mso-fareast-font-family:Calibri;
		mso-ansi-language:EN-US;
		mso-fareast-language:EN-US;}
	p.MsoListParagraph, li.MsoListParagraph, div.MsoListParagraph
		{mso-style-priority:34;
		mso-style-unhide:no;
		mso-style-qformat:yes;
		margin-top:0cm;
		margin-right:0cm;
		margin-bottom:10.0pt;
		margin-left:36.0pt;
		mso-add-space:auto;
		line-height:115%;
		mso-pagination:widow-orphan;
		font-size:11.0pt;
		font-family:"Calibri",sans-serif;
		mso-fareast-font-family:Calibri;
		mso-bidi-font-family:"Times New Roman";
		mso-ansi-language:EN-US;
		mso-fareast-language:EN-US;}
	p.MsoListParagraphCxSpFirst, li.MsoListParagraphCxSpFirst, div.MsoListParagraphCxSpFirst
		{mso-style-priority:34;
		mso-style-unhide:no;
		mso-style-qformat:yes;
		mso-style-type:export-only;
		margin-top:0cm;
		margin-right:0cm;
		margin-bottom:0cm;
		margin-left:36.0pt;
		margin-bottom:.0001pt;
		mso-add-space:auto;
		line-height:115%;
		mso-pagination:widow-orphan;
		font-size:11.0pt;
		font-family:"Calibri",sans-serif;
		mso-fareast-font-family:Calibri;
		mso-bidi-font-family:"Times New Roman";
		mso-ansi-language:EN-US;
		mso-fareast-language:EN-US;}
	p.MsoListParagraphCxSpMiddle, li.MsoListParagraphCxSpMiddle, div.MsoListParagraphCxSpMiddle
		{mso-style-priority:34;
		mso-style-unhide:no;
		mso-style-qformat:yes;
		mso-style-type:export-only;
		margin-top:0cm;
		margin-right:0cm;
		margin-bottom:0cm;
		margin-left:36.0pt;
		margin-bottom:.0001pt;
		mso-add-space:auto;
		line-height:115%;
		mso-pagination:widow-orphan;
		font-size:11.0pt;
		font-family:"Calibri",sans-serif;
		mso-fareast-font-family:Calibri;
		mso-bidi-font-family:"Times New Roman";
		mso-ansi-language:EN-US;
		mso-fareast-language:EN-US;}
	p.MsoListParagraphCxSpLast, li.MsoListParagraphCxSpLast, div.MsoListParagraphCxSpLast
		{mso-style-priority:34;
		mso-style-unhide:no;
		mso-style-qformat:yes;
		mso-style-type:export-only;
		margin-top:0cm;
		margin-right:0cm;
		margin-bottom:10.0pt;
		margin-left:36.0pt;
		mso-add-space:auto;
		line-height:115%;
		mso-pagination:widow-orphan;
		font-size:11.0pt;
		font-family:"Calibri",sans-serif;
		mso-fareast-font-family:Calibri;
		mso-bidi-font-family:"Times New Roman";
		mso-ansi-language:EN-US;
		mso-fareast-language:EN-US;}
	span.HeaderChar
		{mso-style-name:"Header Char";
		mso-style-priority:99;
		mso-style-unhide:no;
		mso-style-locked:yes;
		mso-style-link:Header;}
	span.FooterChar
		{mso-style-name:"Footer Char";
		mso-style-priority:99;
		mso-style-unhide:no;
		mso-style-locked:yes;
		mso-style-link:Footer;}
	span.BalloonTextChar
		{mso-style-name:"Balloon Text Char";
		mso-style-noshow:yes;
		mso-style-priority:99;
		mso-style-unhide:no;
		mso-style-locked:yes;
		mso-style-parent:"";
		mso-style-link:"Balloon Text";
		mso-ansi-font-size:9.0pt;
		mso-bidi-font-size:9.0pt;
		font-family:"Segoe UI",sans-serif;
		mso-ascii-font-family:"Segoe UI";
		mso-hansi-font-family:"Segoe UI";
		mso-bidi-font-family:"Segoe UI";}
	span.SpellE
		{mso-style-name:"";
		mso-spl-e:yes;}
	span.GramE
		{mso-style-name:"";
		mso-gram-e:yes;}
	.MsoChpDefault
		{mso-style-type:export-only;
		mso-default-props:yes;
		font-size:10.0pt;
		mso-ansi-font-size:10.0pt;
		mso-bidi-font-size:10.0pt;
		font-family:"Calibri",sans-serif;
		mso-ascii-font-family:Calibri;
		mso-fareast-font-family:Calibri;
		mso-hansi-font-family:Calibri;}
	 /* Page Definitions */
	 @page
		{mso-footnote-separator:url("form_pengajuan_lembur_files/header.htm") fs;
		mso-footnote-continuation-separator:url("form_pengajuan_lembur_files/header.htm") fcs;
		mso-endnote-separator:url("form_pengajuan_lembur_files/header.htm") es;
		mso-endnote-continuation-separator:url("form_pengajuan_lembur_files/header.htm") ecs;}
	@page WordSection1
		{size:21.0cm 841.95pt;
		margin:1.0cm 72.0pt 12.45pt 72.0pt;
		mso-header-margin:1.0cm;
		mso-footer-margin:30.9pt;
		mso-header:url("form_pengajuan_lembur_files/header.htm") h1;
		mso-footer:url("form_pengajuan_lembur_files/header.htm") f1;
		mso-paper-source:0;}
	div.WordSection1
		{page:WordSection1;}
	 /* List Definitions */
	 @list l0
		{mso-list-id:106199096;
		mso-list-type:hybrid;
		mso-list-template-ids:321176148 67698703 67698713 67698715 67698703 67698713 67698715 67698703 67698713 67698715;}
	@list l0:level1
		{mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;}
	@list l0:level2
		{mso-level-number-format:alpha-lower;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;}
	@list l0:level3
		{mso-level-number-format:roman-lower;
		mso-level-tab-stop:none;
		mso-level-number-position:right;
		text-indent:-9.0pt;}
	@list l0:level4
		{mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;}
	@list l0:level5
		{mso-level-number-format:alpha-lower;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;}
	@list l0:level6
		{mso-level-number-format:roman-lower;
		mso-level-tab-stop:none;
		mso-level-number-position:right;
		text-indent:-9.0pt;}
	@list l0:level7
		{mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;}
	@list l0:level8
		{mso-level-number-format:alpha-lower;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;}
	@list l0:level9
		{mso-level-number-format:roman-lower;
		mso-level-tab-stop:none;
		mso-level-number-position:right;
		text-indent:-9.0pt;}
	@list l1
		{mso-list-id:159197434;
		mso-list-type:hybrid;
		mso-list-template-ids:-2095302280 67698689 67698691 67698693 67698689 67698691 67698693 67698689 67698691 67698693;}
	@list l1:level1
		{mso-level-number-format:bullet;
		mso-level-text:\F0B7;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;
		font-family:Symbol;}
	@list l1:level2
		{mso-level-number-format:bullet;
		mso-level-text:o;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;
		font-family:"Courier New";}
	@list l1:level3
		{mso-level-number-format:bullet;
		mso-level-text:\F0A7;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;
		font-family:Wingdings;}
	@list l1:level4
		{mso-level-number-format:bullet;
		mso-level-text:\F0B7;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;
		font-family:Symbol;}
	@list l1:level5
		{mso-level-number-format:bullet;
		mso-level-text:o;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;
		font-family:"Courier New";}
	@list l1:level6
		{mso-level-number-format:bullet;
		mso-level-text:\F0A7;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;
		font-family:Wingdings;}
	@list l1:level7
		{mso-level-number-format:bullet;
		mso-level-text:\F0B7;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;
		font-family:Symbol;}
	@list l1:level8
		{mso-level-number-format:bullet;
		mso-level-text:o;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;
		font-family:"Courier New";}
	@list l1:level9
		{mso-level-number-format:bullet;
		mso-level-text:\F0A7;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;
		font-family:Wingdings;}
	@list l2
		{mso-list-id:200897977;
		mso-list-type:hybrid;
		mso-list-template-ids:835108832 226898956 67698691 67698693 67698689 67698691 67698693 67698689 67698691 67698693;}
	@list l2:level1
		{mso-level-start-at:0;
		mso-level-number-format:bullet;
		mso-level-text:\F0B7;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;
		font-family:Symbol;
		mso-fareast-font-family:Calibri;
		mso-bidi-font-family:"Times New Roman";}
	@list l2:level2
		{mso-level-number-format:bullet;
		mso-level-text:o;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;
		font-family:"Courier New";}
	@list l2:level3
		{mso-level-number-format:bullet;
		mso-level-text:\F0A7;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;
		font-family:Wingdings;}
	@list l2:level4
		{mso-level-number-format:bullet;
		mso-level-text:\F0B7;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;
		font-family:Symbol;}
	@list l2:level5
		{mso-level-number-format:bullet;
		mso-level-text:o;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;
		font-family:"Courier New";}
	@list l2:level6
		{mso-level-number-format:bullet;
		mso-level-text:\F0A7;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;
		font-family:Wingdings;}
	@list l2:level7
		{mso-level-number-format:bullet;
		mso-level-text:\F0B7;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;
		font-family:Symbol;}
	@list l2:level8
		{mso-level-number-format:bullet;
		mso-level-text:o;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;
		font-family:"Courier New";}
	@list l2:level9
		{mso-level-number-format:bullet;
		mso-level-text:\F0A7;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;
		font-family:Wingdings;}
	@list l3
		{mso-list-id:634677313;
		mso-list-type:hybrid;
		mso-list-template-ids:-1077256594 840745176 67698713 67698715 67698703 67698713 67698715 67698703 67698713 67698715;}
	@list l3:level1
		{mso-level-tab-stop:none;
		mso-level-number-position:left;
		margin-left:54.0pt;
		text-indent:-18.0pt;}
	@list l3:level2
		{mso-level-number-format:alpha-lower;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		margin-left:90.0pt;
		text-indent:-18.0pt;}
	@list l3:level3
		{mso-level-number-format:roman-lower;
		mso-level-tab-stop:none;
		mso-level-number-position:right;
		margin-left:126.0pt;
		text-indent:-9.0pt;}
	@list l3:level4
		{mso-level-tab-stop:none;
		mso-level-number-position:left;
		margin-left:162.0pt;
		text-indent:-18.0pt;}
	@list l3:level5
		{mso-level-number-format:alpha-lower;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		margin-left:198.0pt;
		text-indent:-18.0pt;}
	@list l3:level6
		{mso-level-number-format:roman-lower;
		mso-level-tab-stop:none;
		mso-level-number-position:right;
		margin-left:234.0pt;
		text-indent:-9.0pt;}
	@list l3:level7
		{mso-level-tab-stop:none;
		mso-level-number-position:left;
		margin-left:270.0pt;
		text-indent:-18.0pt;}
	@list l3:level8
		{mso-level-number-format:alpha-lower;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		margin-left:306.0pt;
		text-indent:-18.0pt;}
	@list l3:level9
		{mso-level-number-format:roman-lower;
		mso-level-tab-stop:none;
		mso-level-number-position:right;
		margin-left:342.0pt;
		text-indent:-9.0pt;}
	@list l4
		{mso-list-id:732509354;
		mso-list-type:hybrid;
		mso-list-template-ids:358490684 851765348 67698713 67698715 67698703 67698713 67698715 67698703 67698713 67698715;}
	@list l4:level1
		{mso-level-number-format:alpha-lower;
		mso-level-text:%1;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		margin-left:18.0pt;
		text-indent:-18.0pt;}
	@list l4:level2
		{mso-level-number-format:alpha-lower;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		margin-left:54.0pt;
		text-indent:-18.0pt;}
	@list l4:level3
		{mso-level-number-format:roman-lower;
		mso-level-tab-stop:none;
		mso-level-number-position:right;
		margin-left:90.0pt;
		text-indent:-9.0pt;}
	@list l4:level4
		{mso-level-tab-stop:none;
		mso-level-number-position:left;
		margin-left:126.0pt;
		text-indent:-18.0pt;}
	@list l4:level5
		{mso-level-number-format:alpha-lower;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		margin-left:162.0pt;
		text-indent:-18.0pt;}
	@list l4:level6
		{mso-level-number-format:roman-lower;
		mso-level-tab-stop:none;
		mso-level-number-position:right;
		margin-left:198.0pt;
		text-indent:-9.0pt;}
	@list l4:level7
		{mso-level-tab-stop:none;
		mso-level-number-position:left;
		margin-left:234.0pt;
		text-indent:-18.0pt;}
	@list l4:level8
		{mso-level-number-format:alpha-lower;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		margin-left:270.0pt;
		text-indent:-18.0pt;}
	@list l4:level9
		{mso-level-number-format:roman-lower;
		mso-level-tab-stop:none;
		mso-level-number-position:right;
		margin-left:306.0pt;
		text-indent:-9.0pt;}
	@list l5
		{mso-list-id:847989594;
		mso-list-type:hybrid;
		mso-list-template-ids:1707914038 -2067090490 67698691 67698693 67698689 67698691 67698693 67698689 67698691 67698693;}
	@list l5:level1
		{mso-level-start-at:0;
		mso-level-number-format:bullet;
		mso-level-text:\F0B7;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;
		font-family:Symbol;
		mso-fareast-font-family:Calibri;
		mso-bidi-font-family:"Times New Roman";}
	@list l5:level2
		{mso-level-number-format:bullet;
		mso-level-text:o;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;
		font-family:"Courier New";}
	@list l5:level3
		{mso-level-number-format:bullet;
		mso-level-text:\F0A7;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;
		font-family:Wingdings;}
	@list l5:level4
		{mso-level-number-format:bullet;
		mso-level-text:\F0B7;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;
		font-family:Symbol;}
	@list l5:level5
		{mso-level-number-format:bullet;
		mso-level-text:o;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;
		font-family:"Courier New";}
	@list l5:level6
		{mso-level-number-format:bullet;
		mso-level-text:\F0A7;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;
		font-family:Wingdings;}
	@list l5:level7
		{mso-level-number-format:bullet;
		mso-level-text:\F0B7;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;
		font-family:Symbol;}
	@list l5:level8
		{mso-level-number-format:bullet;
		mso-level-text:o;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;
		font-family:"Courier New";}
	@list l5:level9
		{mso-level-number-format:bullet;
		mso-level-text:\F0A7;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;
		font-family:Wingdings;}
	@list l6
		{mso-list-id:1003895565;
		mso-list-type:hybrid;
		mso-list-template-ids:801820652 67698689 67698691 67698693 67698689 67698691 67698693 67698689 67698691 67698693;}
	@list l6:level1
		{mso-level-number-format:bullet;
		mso-level-text:\F0B7;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;
		font-family:Symbol;}
	@list l6:level2
		{mso-level-number-format:bullet;
		mso-level-text:o;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;
		font-family:"Courier New";}
	@list l6:level3
		{mso-level-number-format:bullet;
		mso-level-text:\F0A7;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;
		font-family:Wingdings;}
	@list l6:level4
		{mso-level-number-format:bullet;
		mso-level-text:\F0B7;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;
		font-family:Symbol;}
	@list l6:level5
		{mso-level-number-format:bullet;
		mso-level-text:o;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;
		font-family:"Courier New";}
	@list l6:level6
		{mso-level-number-format:bullet;
		mso-level-text:\F0A7;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;
		font-family:Wingdings;}
	@list l6:level7
		{mso-level-number-format:bullet;
		mso-level-text:\F0B7;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;
		font-family:Symbol;}
	@list l6:level8
		{mso-level-number-format:bullet;
		mso-level-text:o;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;
		font-family:"Courier New";}
	@list l6:level9
		{mso-level-number-format:bullet;
		mso-level-text:\F0A7;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;
		font-family:Wingdings;}
	@list l7
		{mso-list-id:1353536554;
		mso-list-type:hybrid;
		mso-list-template-ids:-796215472 378153666 67698713 67698715 67698703 67698713 67698715 67698703 67698713 67698715;}
	@list l7:level1
		{mso-level-number-format:alpha-lower;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		margin-left:39.3pt;
		text-indent:-18.0pt;}
	@list l7:level2
		{mso-level-number-format:alpha-lower;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		margin-left:75.3pt;
		text-indent:-18.0pt;}
	@list l7:level3
		{mso-level-number-format:roman-lower;
		mso-level-tab-stop:none;
		mso-level-number-position:right;
		margin-left:111.3pt;
		text-indent:-9.0pt;}
	@list l7:level4
		{mso-level-tab-stop:none;
		mso-level-number-position:left;
		margin-left:147.3pt;
		text-indent:-18.0pt;}
	@list l7:level5
		{mso-level-number-format:alpha-lower;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		margin-left:183.3pt;
		text-indent:-18.0pt;}
	@list l7:level6
		{mso-level-number-format:roman-lower;
		mso-level-tab-stop:none;
		mso-level-number-position:right;
		margin-left:219.3pt;
		text-indent:-9.0pt;}
	@list l7:level7
		{mso-level-tab-stop:none;
		mso-level-number-position:left;
		margin-left:255.3pt;
		text-indent:-18.0pt;}
	@list l7:level8
		{mso-level-number-format:alpha-lower;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		margin-left:291.3pt;
		text-indent:-18.0pt;}
	@list l7:level9
		{mso-level-number-format:roman-lower;
		mso-level-tab-stop:none;
		mso-level-number-position:right;
		margin-left:327.3pt;
		text-indent:-9.0pt;}
	@list l8
		{mso-list-id:1458990521;
		mso-list-type:hybrid;
		mso-list-template-ids:-1011589644 -1432955776 67698691 67698693 67698689 67698691 67698693 67698689 67698691 67698693;}
	@list l8:level1
		{mso-level-start-at:0;
		mso-level-number-format:bullet;
		mso-level-text:\F0B7;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		margin-left:54.0pt;
		text-indent:-18.0pt;
		font-family:Symbol;
		mso-fareast-font-family:Calibri;
		mso-bidi-font-family:"Times New Roman";}
	@list l8:level2
		{mso-level-number-format:bullet;
		mso-level-text:o;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		margin-left:90.0pt;
		text-indent:-18.0pt;
		font-family:"Courier New";}
	@list l8:level3
		{mso-level-number-format:bullet;
		mso-level-text:\F0A7;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		margin-left:126.0pt;
		text-indent:-18.0pt;
		font-family:Wingdings;}
	@list l8:level4
		{mso-level-number-format:bullet;
		mso-level-text:\F0B7;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		margin-left:162.0pt;
		text-indent:-18.0pt;
		font-family:Symbol;}
	@list l8:level5
		{mso-level-number-format:bullet;
		mso-level-text:o;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		margin-left:198.0pt;
		text-indent:-18.0pt;
		font-family:"Courier New";}
	@list l8:level6
		{mso-level-number-format:bullet;
		mso-level-text:\F0A7;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		margin-left:234.0pt;
		text-indent:-18.0pt;
		font-family:Wingdings;}
	@list l8:level7
		{mso-level-number-format:bullet;
		mso-level-text:\F0B7;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		margin-left:270.0pt;
		text-indent:-18.0pt;
		font-family:Symbol;}
	@list l8:level8
		{mso-level-number-format:bullet;
		mso-level-text:o;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		margin-left:306.0pt;
		text-indent:-18.0pt;
		font-family:"Courier New";}
	@list l8:level9
		{mso-level-number-format:bullet;
		mso-level-text:\F0A7;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		margin-left:342.0pt;
		text-indent:-18.0pt;
		font-family:Wingdings;}
	@list l9
		{mso-list-id:1595047177;
		mso-list-type:hybrid;
		mso-list-template-ids:-280333422 67698703 67698713 67698715 67698703 67698713 67698715 67698703 67698713 67698715;}
	@list l9:level1
		{mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;}
	@list l9:level2
		{mso-level-number-format:alpha-lower;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;}
	@list l9:level3
		{mso-level-number-format:roman-lower;
		mso-level-tab-stop:none;
		mso-level-number-position:right;
		text-indent:-9.0pt;}
	@list l9:level4
		{mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;}
	@list l9:level5
		{mso-level-number-format:alpha-lower;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;}
	@list l9:level6
		{mso-level-number-format:roman-lower;
		mso-level-tab-stop:none;
		mso-level-number-position:right;
		text-indent:-9.0pt;}
	@list l9:level7
		{mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;}
	@list l9:level8
		{mso-level-number-format:alpha-lower;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;}
	@list l9:level9
		{mso-level-number-format:roman-lower;
		mso-level-tab-stop:none;
		mso-level-number-position:right;
		text-indent:-9.0pt;}
	@list l10
		{mso-list-id:1686787773;
		mso-list-type:hybrid;
		mso-list-template-ids:1241150878 -558856370 67698691 67698693 67698689 67698691 67698693 67698689 67698691 67698693;}
	@list l10:level1
		{mso-level-start-at:0;
		mso-level-number-format:bullet;
		mso-level-text:\F0B7;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;
		font-family:Symbol;
		mso-fareast-font-family:Calibri;
		mso-bidi-font-family:"Times New Roman";}
	@list l10:level2
		{mso-level-number-format:bullet;
		mso-level-text:o;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;
		font-family:"Courier New";}
	@list l10:level3
		{mso-level-number-format:bullet;
		mso-level-text:\F0A7;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;
		font-family:Wingdings;}
	@list l10:level4
		{mso-level-number-format:bullet;
		mso-level-text:\F0B7;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;
		font-family:Symbol;}
	@list l10:level5
		{mso-level-number-format:bullet;
		mso-level-text:o;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;
		font-family:"Courier New";}
	@list l10:level6
		{mso-level-number-format:bullet;
		mso-level-text:\F0A7;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;
		font-family:Wingdings;}
	@list l10:level7
		{mso-level-number-format:bullet;
		mso-level-text:\F0B7;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;
		font-family:Symbol;}
	@list l10:level8
		{mso-level-number-format:bullet;
		mso-level-text:o;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;
		font-family:"Courier New";}
	@list l10:level9
		{mso-level-number-format:bullet;
		mso-level-text:\F0A7;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;
		font-family:Wingdings;}
	@list l11
		{mso-list-id:2070378851;
		mso-list-type:hybrid;
		mso-list-template-ids:-726755736 -594615920 67698713 67698715 67698703 67698713 67698715 67698703 67698713 67698715;}
	@list l11:level1
		{mso-level-text:"\(%1\)";
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;}
	@list l11:level2
		{mso-level-number-format:alpha-lower;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;}
	@list l11:level3
		{mso-level-number-format:roman-lower;
		mso-level-tab-stop:none;
		mso-level-number-position:right;
		text-indent:-9.0pt;}
	@list l11:level4
		{mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;}
	@list l11:level5
		{mso-level-number-format:alpha-lower;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;}
	@list l11:level6
		{mso-level-number-format:roman-lower;
		mso-level-tab-stop:none;
		mso-level-number-position:right;
		text-indent:-9.0pt;}
	@list l11:level7
		{mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;}
	@list l11:level8
		{mso-level-number-format:alpha-lower;
		mso-level-tab-stop:none;
		mso-level-number-position:left;
		text-indent:-18.0pt;}
	@list l11:level9
		{mso-level-number-format:roman-lower;
		mso-level-tab-stop:none;
		mso-level-number-position:right;
		text-indent:-9.0pt;}
	ol
		{margin-bottom:0cm;}
	ul
		{margin-bottom:0cm;}
	-->
	</style>
	<!--[if gte mso 10]>
	<style>
	 /* Style Definitions */
	 table.MsoNormalTable
		{mso-style-name:"Table Normal";
		mso-tstyle-rowband-size:0;
		mso-tstyle-colband-size:0;
		mso-style-noshow:yes;
		mso-style-priority:99;
		mso-style-parent:"";
		mso-padding-alt:0cm 5.4pt 0cm 5.4pt;
		mso-para-margin:0cm;
		mso-para-margin-bottom:.0001pt;
		mso-pagination:widow-orphan;
		font-size:10.0pt;
		font-family:"Calibri",sans-serif;
		mso-bidi-font-family:"Times New Roman";}
	table.MsoTableGrid
		{mso-style-name:"Table Grid";
		mso-tstyle-rowband-size:0;
		mso-tstyle-colband-size:0;
		mso-style-priority:59;
		mso-style-unhide:no;
		border:solid black 1.0pt;
		mso-border-alt:solid black .5pt;
		mso-padding-alt:0cm 5.4pt 0cm 5.4pt;
		mso-border-insideh:.5pt solid black;
		mso-border-insidev:.5pt solid black;
		mso-para-margin:0cm;
		mso-para-margin-bottom:.0001pt;
		mso-pagination:widow-orphan;
		font-size:10.0pt;
		font-family:"Calibri",sans-serif;
		mso-bidi-font-family:"Times New Roman";}
	</style>
	<![endif]--><!--[if gte mso 9]><xml>
	 <o:shapedefaults v:ext="edit" spidmax="2049"/>
	</xml><![endif]--><!--[if gte mso 9]><xml>
	 <o:shapelayout v:ext="edit">
	  <o:idmap v:ext="edit" data="1"/>
	 </o:shapelayout></xml><![endif]-->
	</head>
	<body lang=IN link=blue vlink="#954F72" style="tab-interval:36.0pt">

	<div class=WordSection1>

	<p class=MsoNormal align=center style="margin-bottom:0cm;margin-bottom:.0001pt;
	text-align:center"><b style="mso-bidi-font-weight:normal"><span lang=EN-US
	style="font-size:16.0pt;line-height:115%">FORMULIR PENGAJUAN LEMBUR<o:p></o:p></span></b></p>

	<table class=MsoNormalTable border=1 cellspacing=0 cellpadding=0 width=696
	 style="width:522.0pt;margin-left:-30.6pt;border-collapse:collapse;border:none;
	 mso-border-alt:solid black .5pt;mso-yfti-tbllook:1184;mso-padding-alt:0cm 5.4pt 0cm 5.4pt;
	 mso-border-insideh:.5pt solid black;mso-border-insidev:.5pt solid black">
	 <tr>
	  <td style="width:280px;border:solid black 1.0pt;
	  mso-border-alt:solid black .5pt;padding-top: 3px; padding-bottom:3px;">
	  	<b><i>Bagian untuk diisi SDM :</i></b>
	  </td>
	  <td width=337 valign=top style="width:252.65pt;border:solid black 1.0pt;
	  border-left:none;mso-border-left-alt:solid black .5pt;mso-border-alt:solid black .5pt;t"><b><i>Tanggal :
	  </td>
	 </tr>
	 <tr>
	  <td style="padding-top: 3px; padding-bottom:3px;">No :</td>
	 </tr>
	</table>

	<p class=MsoNormal align=center style="margin-bottom:0cm;margin-bottom:.0001pt;
	text-align:center"><b style="mso-bidi-font-weight:normal"><span lang=EN-US
	style="font-size:6.0pt;line-height:115%"><o:p>&nbsp;</o:p></span></b></p>	
	';
	return $html;
}

function data_pemohon($nip, $nama, $golongan, $unit_kerja){
	//echo 'nip='.$nip.$nama.$golongan.$unit_kerja; exit();
	$html = '
	<table class=MsoNormalTable border=1 cellspacing=0 cellpadding=0 width=696
	 style="width:522.0pt;margin-left:-30.6pt;border-collapse:collapse;border:none;
	 mso-border-alt:solid black .5pt;mso-yfti-tbllook:1184;mso-padding-alt:0cm 5.4pt 0cm 5.4pt;
	 mso-border-insideh:.5pt solid black;mso-border-insidev:.5pt solid black">
		<tr style="mso-yfti-irow:0;mso-yfti-firstrow:yes;height:17.95pt">
			<td width=696 colspan=6 style="width:522.0pt;border:solid windowtext 1.0pt;
			mso-border-alt:solid windowtext .5pt;background:#A6A6A6;padding:0cm 5.4pt 0cm 5.4pt;
			height:17.95pt">
			<p class=MsoNormal align=center style="margin-bottom:0cm;margin-bottom:.0001pt;
			text-align:center;line-height:normal"><b style="mso-bidi-font-weight:normal"><span
			lang=EN-US>DATA PEMOHON<o:p></o:p></span></b></p>
			</td>
		</tr>
		<tr>
			<td style="width:100px;padding-top:3px; padding-bottom:3px; border-right:1px solid #fff;">Nama</td>
			<td style="border-left:1px solid #fff; border-right:1px solid #fff;">:</td>
			<td style="width:10px; border-left:1px solid #fff;">'.$nama.'</td>
			<td style="padding-top:3px; padding-bottom:3px; border-right:1px solid #fff;">Golongan</td>
			<td style="border-left:1px solid #fff; border-right:1px solid #fff;">:</td>
			<td style="border-left:1px solid #fff;">'.$golongan.'</td>
		</tr>
		<tr>
			<td style="padding-top:3px; padding-bottom:3px; border-right:1px solid #fff;">NPM/NIP/NUP</td>
			<td style="border-left:1px solid #fff; border-right:1px solid #fff;">:</td>
			<td style="width:200px; border-left:1px solid #fff;">'.$nip.'</td>
			<td style="padding-top:3px; padding-bottom:3px; border-right:1px solid #fff;">PAF/Dept/Prodi</td>
			<td style="border-left:1px solid #fff; border-right:1px solid #fff;">:</td>
			<td style="border-left:1px solid #fff;">'.$unit_kerja.'</td>
		</tr>
	</table>
	<p class=MsoNormal style="margin-bottom:0cm;margin-bottom:.0001pt;line-height:
	normal"><b style="mso-bidi-font-weight:normal"><span lang=EN-US
	style="font-size:6.0pt"><o:p>&nbsp;</o:p></span></b></p>
	';
	return $html;
}

function pelaksanaan_lembur($data_lembur, $deskripsi){

	$html = '
	<table class=MsoNormalTable border=1 cellspacing=0 cellpadding=0 width=696
	 style="width:522.0pt;margin-left:-30.6pt;border-collapse:collapse;border:none;
	 mso-border-alt:solid black .5pt;mso-yfti-tbllook:1184;mso-padding-alt:0cm 5.4pt 0cm 5.4pt;
	 mso-border-insideh:.5pt solid black;mso-border-insidev:.5pt solid black">
		<tr style="mso-yfti-irow:0;mso-yfti-firstrow:yes;height:32.35pt">
			<td width=696 colspan=4 style="width:522.0pt;border:solid black 1.0pt;
			mso-border-alt:solid black .5pt;background:#A6A6A6;padding:0cm 5.4pt 0cm 5.4pt;
			height:32.35pt">
			<p class=MsoNormal align=center style="margin-bottom:0cm;margin-bottom:.0001pt;
			text-align:center;line-height:normal"><b style="mso-bidi-font-weight:normal"><span
			lang=EN-US>PELAKSANAAN LEMBUR<o:p></o:p></span></b></p>
			<p class=MsoNormal align=center style="margin-bottom:0cm;margin-bottom:.0001pt;
			text-align:center;line-height:normal"><b style="mso-bidi-font-weight:normal"><span
			lang=EN-US>(<span class=SpellE><i style="mso-bidi-font-style:normal">diisi</i></span><i
				style="mso-bidi-font-style:normal"> <span class=SpellE>oleh</span> <span
				class=SpellE>Pemohon</span> <span class=SpellE>sebelum</span> <span
				class=SpellE>pelaksanaan</span> <span class=SpellE>Lembur</span></i>)<o:p></o:p></span></b></p>
			</td>
		</tr>
		<tr style="font-size:13px">
			<th style="padding-top:8px;padding-bottom:8px; text-align:center; font-weight:bold;">No</th>
			<th style="text-align:center; font-weight:bold;">Hari / Tanggal</th>
			<th style="text-align:center; font-weight:bold;">Uraian Pekerjaan yang dilakukan</th>
			<th style="text-align:center; font-weight:bold;">Waktu Lembur</th>
		</tr>';

		$no = 1;
		$total_menit_hari_kerja = 0;
		$total_menit_hari_libur = 0;
		$total_menit_hari_kerja_disetujui = 0;
		$total_menit_hari_libur_disetujui = 0;

		foreach ($data_lembur as $k => $v)
		{
			$presensi = $v['presensi'];
			$array_waktu = explode(' - ', $presensi);
			$selesai_lembur = $array_waktu[1];
			$waktu_lembur = new DateTime( $v['waktu_lembur'] );
			$array_selesai_lembur = explode(':', $array_waktu[1]);
			$menit_selesai = $array_selesai_lembur[0] * 60 + $array_selesai_lembur[1];
			$array_lembur = explode(':', $v['waktu_lembur']);
			$menit_lembur = $array_lembur[0] * 60 + $array_lembur[1];
			$mulai_lembur = date('H:i', mktime(0, $menit_selesai - $menit_lembur ));

			$html.= '
			<tr>
				<td style="text-align:center">'.$no.'</td>
				<td style="text-align:center; line-height:2px;padding-top:2px;padding-bottom:2px;">'.tanggal($v['tgl_lembur']).'</td>
				<td style="padding-top:2px;padding-bottom:2px;">'.$v['uraian'].'</td>
				<td style="text-align:center">'.$mulai_lembur.' - '.$selesai_lembur.'</td>
			</tr>';
			$no++;

			# Hitung Total Jam Lembur
			if($v['flag_libur'] == 1){
				$total_menit_hari_libur += $menit_lembur;
			} else {
				$total_menit_hari_kerja += $menit_lembur;
			}
			
			# Hitung Total Jam Lembur disetujui
			if($v['status'] == 1 and $v['flag_libur'] == 1){
				$total_menit_hari_libur_disetujui += $menit_lembur;
			} else if($v['status'] == 1 and $v['flag_libur'] == 0){
				$total_menit_hari_kerja_disetujui += $menit_lembur;
			}
		}

	
		$total_jam_hari_kerja = convertToHoursMins($total_menit_hari_kerja, '%02d jam %02d menit');
		$total_jam_hari_libur = convertToHoursMins($total_menit_hari_libur, '%02d jam %02d menit');
		
		$total_jam_hari_kerja_disetujui = convertToHoursMins($total_menit_hari_kerja_disetujui, '%02d jam %02d menit');
		$total_jam_hari_libur_disetujui = convertToHoursMins($total_menit_hari_libur_disetujui, '%02d jam %02d menit');

		$html.= '
		<tr>
			<td colspan="4" style="padding:5px; text-align:center">
				<table class=MsoNormalTable width=670 style="width:500.0pt;border-collapse:collapse; border:1px solid #ccc; mso-border-alt:solid black .5pt;mso-yfti-tbllook:1184;mso-padding-alt:0cm 5.4pt 0cm 5.4pt; mso-border-insideh:.5pt solid black;mso-border-insidev:.5pt solid black; margin:auto;">
					<tr>
						<th colspan="2" style="padding-top:1px; padding-bottom:1px; background:#ccc; border-left:1px solid #ccc;border-top:1px solid #ccc;border-bottom:1px solid #fff;">Total Jam Lembur</th>
						<th colspan="2" style="background:#ccc; border-left:1px solid #fff;border-right:1px solid #ccc;border-top:1px solid #ccc;border-bottom:1px solid #fff;">Total Jam Lembur Disetujui</th>
					</tr>
					<tr>
						<th style="padding-top:1px; padding-bottom:1px; background:#ccc; border-left:1px solid #ccc;border-right:1px solid #fff;border-bottom:1px solid #fff;">Hari Kerja</th>
						<th style="background:#ccc; border:1px solid #fff;">Hari Libur</th>
						<th style="background:#ccc; border:1px solid #fff;">Hari Kerja</th>
						<th style="background:#ccc; border:1px solid #fff;border-right:1px solid #ccc;">Hari Libur</th>
					</tr>
					<tr>
						<td style="text-align:center; padding-top:3px; padding-bottom:3px; border:1px solid #ccc;">'.$total_jam_hari_kerja.'</td>
						<td style="text-align:center; border:1px solid #ccc;">'.$total_jam_hari_libur.'</td>
						<td style="text-align:center; border:1px solid #ccc;">'.$total_jam_hari_kerja_disetujui.'</td>
						<td style="text-align:center; border:1px solid #ccc;">'.$total_jam_hari_libur_disetujui.'</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="4" style="padding-top:3px;padding-bottom:3px;vertical-align:top; line-height:normal; border-bottom:1px solid #fff">
				<p class=MsoNormal style="margin-bottom:0cm;margin-bottom:.0001pt;line-height:normal">
					<b style="mso-bidi-font-weight:normal">
						<span lang=EN-US style="font-size:10.0pt">
							<o:p>Deskripsi Pelaksanan Kerja Lembur :</o:p>
						</span>
					</b>
				</p>				
			</td>
		</tr>
		<tr>
			<td colspan="4" style="padding-bottom:3px; border-top:1px solid #fff">'.trim($deskripsi).'</td>
		</tr>
	</table>
	';
	$html.= '
	<p class=MsoNormal style="margin-bottom:0cm;margin-bottom:.0001pt;line-height:
	normal"><b style="mso-bidi-font-weight:normal"><span lang=EN-US
	style="font-size:6.0pt"><o:p>&nbsp;</o:p></span></b></p>
	';
	return $html;
}

function tanda_tangan_persetujuan($nama, $pejabat){
	$html = '
	<table class=MsoNormalTable border=1 cellspacing=0 cellpadding=0 width=696
	 style="width:522.0pt;margin-left:-30.6pt;border-collapse:collapse;border:none;
	 mso-border-alt:solid black .5pt;mso-yfti-tbllook:1184;mso-padding-alt:0cm 5.4pt 0cm 5.4pt;
	 mso-border-insideh:.5pt solid black;mso-border-insidev:.5pt solid black">
	 <tr style="mso-yfti-irow:0;mso-yfti-firstrow:yes;height:18.5pt">
	  <td width=696 colspan=3 style="width:522.0pt;border-top:solid black 1.0pt;border-left:
	  solid black 1.0pt;border-bottom:solid windowtext 1.0pt;border-right:solid black 1.0pt;
	  mso-border-left-alt:solid black .5pt;mso-border-bottom-alt:solid windowtext .5pt;
	  mso-border-right-alt:solid black .5pt;background:#A6A6A6;padding:0cm 5.4pt 0cm 5.4pt;
	  height:18.5pt">
	  <p class=MsoNormal align=center style="margin-bottom:0cm;margin-bottom:.0001pt;
	  text-align:center"><b style="mso-bidi-font-weight:normal"><span lang=EN-US>KOLOM
	  TANDA TANGAN PERSETUJUAN<o:p></o:p></span></b></p>
	  </td>
	 </tr>
	 <tr style="mso-yfti-irow:1">
	  <td width=227 valign=top style="width:170.15pt;border-top:none;border-left:
	  solid windowtext 1.0pt;border-bottom:none;border-right:solid windowtext 1.0pt;
	  mso-border-top-alt:solid windowtext .5pt;mso-border-top-alt:solid windowtext .5pt;
	  mso-border-left-alt:solid windowtext .5pt;mso-border-right-alt:solid windowtext .5pt;
	  padding:0cm 5.4pt 0cm 5.4pt">
	  <p class=MsoNormal align=center style="margin-bottom:0cm;margin-bottom:.0001pt;
	  text-align:center"><span class=SpellE><b style="mso-bidi-font-weight:normal"><span
	  lang=EN-US style="font-size:10.0pt;line-height:115%">Pemohon</span></b></span><b
	  style="mso-bidi-font-weight:normal"><span lang=EN-US style="font-size:10.0pt;
	  line-height:115%"><o:p></o:p></span></b></p>
	  </td>
	  <td width=246 valign=top style="width:184.25pt;border:none;border-right:solid windowtext 1.0pt;
	  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
	  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
	  mso-border-right-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt">
	  <p class=MsoNormal align=center style="margin-bottom:0cm;margin-bottom:.0001pt;
	  text-align:center"><span class=SpellE><b style="mso-bidi-font-weight:normal"><span
	  lang=EN-US style="font-size:10.0pt;line-height:115%">Atasan</span></b></span><b
	  style="mso-bidi-font-weight:normal"><span lang=EN-US style="font-size:10.0pt;
	  line-height:115%"><span class=SpellE>Langsung</span><sup>(*</sup><o:p></o:p></span></b></p>
	  </td>
	  <td width=223 valign=top style="width:167.6pt;border:none;border-right:solid windowtext 1.0pt;
	  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
	  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
	  mso-border-right-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt">
	  <p class=MsoNormal align=center style="margin-bottom:0cm;margin-bottom:.0001pt;
	  text-align:center"><b style="mso-bidi-font-weight:normal"><span lang=EN-US
	  style="font-size:10.0pt;line-height:115%">Wakil <span class=SpellE>Manajer</span>
	  <span class=SpellE>Khusus</span> <span class=SpellE>Bidang</span> SDM<o:p></o:p></span></b></p>
	  </td>
	 </tr>
	 <tr style="mso-yfti-irow:2">
	  <td width=227 valign=top style="width:170.15pt;border-top:none;border-left:
	  solid windowtext 1.0pt;border-bottom:none;border-right:solid windowtext 1.0pt;
	  mso-border-left-alt:solid windowtext .5pt;mso-border-right-alt:solid windowtext .5pt;
	  padding:0cm 5.4pt 0cm 5.4pt">
	  <p class=MsoNormal align=center style="margin-bottom:0cm;margin-bottom:.0001pt;
	  text-align:center"><b style="mso-bidi-font-weight:normal"><span lang=EN-US
	  style="font-size:10.0pt;line-height:115%"><o:p>&nbsp;</o:p></span></b></p>
	  <p class=MsoNormal align=center style="margin-bottom:0cm;margin-bottom:.0001pt;
	  text-align:center"><b style="mso-bidi-font-weight:normal"><span lang=EN-US
	  style="font-size:10.0pt;line-height:115%"><o:p>&nbsp;</o:p></span></b></p>
	  <p class=MsoNormal align=center style="margin-bottom:0cm;margin-bottom:.0001pt;
	  text-align:center"><b style="mso-bidi-font-weight:normal"><span lang=EN-US
	  style="font-size:10.0pt;line-height:115%"><o:p>&nbsp;</o:p></span></b></p>
	  <p class=MsoNormal align=center style="margin-bottom:0cm;margin-bottom:.0001pt;
	  text-align:center"><b style="mso-bidi-font-weight:normal"><span lang=EN-US
	  style="font-size:10.0pt;line-height:115%"><o:p>&nbsp;</o:p></span></b></p>
	  </td>
	  <td width=246 valign=top style="width:184.25pt;border:none;border-right:solid windowtext 1.0pt;
	  mso-border-left-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
	  mso-border-right-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt">
	  <p class=MsoNormal align=center style="margin-bottom:0cm;margin-bottom:.0001pt;
	  text-align:center"><b style="mso-bidi-font-weight:normal"><span lang=EN-US
	  style="font-size:10.0pt;line-height:115%"><o:p></o:p></span></b></p>
	  </td>
	  <td width=223 valign=top style="width:167.6pt;border:none;border-right:solid windowtext 1.0pt;
	  mso-border-left-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
	  mso-border-right-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt">
	  <p class=MsoNormal align=center style="margin-bottom:0cm;margin-bottom:.0001pt;
	  text-align:center"><b style="mso-bidi-font-weight:normal"><span lang=EN-US
	  style="font-size:10.0pt;line-height:115%"><o:p>&nbsp;</o:p></span></b></p>
	  </td>
	 </tr>
	 <tr style="mso-yfti-irow:3">
	  <td width=227 valign=top style="width:170.15pt;border:solid windowtext 1.0pt;
	  border-top:none;mso-border-left-alt:solid windowtext .5pt;mso-border-bottom-alt:
	  solid windowtext .5pt;mso-border-right-alt:solid windowtext .5pt;padding:
	  0cm 5.4pt 0cm 5.4pt">
	  <p class=MsoNormal style="margin-bottom:0cm;margin-bottom:.0001pt;text-align:
	  center"><span lang=EN-US style="font-size:10.0pt;line-height:115%">'.$nama.'<span
	  style="mso-spacerun:yes"></span><o:p></o:p></span></p>
	  </td>
	  <td width=246 valign=top style="width:184.25pt;border-top:none;border-left:
	  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
	  mso-border-left-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
	  mso-border-bottom-alt:solid windowtext .5pt;mso-border-right-alt:solid windowtext .5pt;
	  padding:0cm 5.4pt 0cm 5.4pt">
	  <p class=MsoNormal style="margin-bottom:0cm;margin-bottom:.0001pt;text-align:
	  center"><span lang=EN-US style="font-size:10.0pt;line-height:115%">'.$pejabat.'</span><o:p></o:p></span></p>
	  </td>
	  <td width=223 valign=top style="width:167.6pt;border-top:none;border-left:
	  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
	  mso-border-left-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
	  mso-border-bottom-alt:solid windowtext .5pt;mso-border-right-alt:solid windowtext .5pt;
	  padding:0cm 5.4pt 0cm 5.4pt">
	  <p class=MsoNormal style="margin-bottom:0cm;margin-bottom:.0001pt;text-align:
	  center"><span lang=EN-US style="font-size:10.0pt;line-height:115%">Dra. Riaty Raffiudin, M.A., Ph.D.<span
	  style="mso-spacerun:yes"></span><o:p></o:p></span></p>
	  </td>
	 </tr>
	 <tr style="mso-yfti-irow:4;mso-yfti-lastrow:yes">
	  <td width=227 valign=top style="width:170.15pt;border:solid black 1.0pt;
	  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid black .5pt;
	  mso-border-top-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt">
	  <p class=MsoNormal style="margin-bottom:0cm;margin-bottom:.0001pt;text-align:
	  center"><span class=SpellE><span lang=EN-US style="font-size:10.0pt;
	  line-height:115%; text-align:center">'.dateToIndo().'</span></span><span lang=EN-US style="font-size:
	  10.0pt;line-height:115%"><span style="mso-spacerun:yes"></span><o:p></o:p></span></p>
	  </td>
	  <td width=246 valign=top style="width:184.25pt;border-top:none;border-left:
	  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
	  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid black .5pt;
	  mso-border-alt:solid black .5pt;mso-border-top-alt:solid windowtext .5pt;
	  padding:0cm 5.4pt 0cm 5.4pt; text-align:center">
	  <p class=MsoNormal style="margin-bottom:0cm;margin-bottom:.0001pt;text-align:
	  center"><span class=SpellE><span lang=EN-US style="font-size:10.0pt;
	  line-height:115%">'.dateToIndo().'</span></span><o:p></o:p></span></p>
	  </td>
	  <td width=223 valign=top style="width:167.6pt;border-top:none;border-left:
	  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
	  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid black .5pt;
	  mso-border-alt:solid black .5pt;mso-border-top-alt:solid windowtext .5pt;
	  padding:0cm 5.4pt 0cm 5.4pt; text-align:center">
	  <p class=MsoNormal style="margin-bottom:0cm;margin-bottom:.0001pt;text-align:
	  center"><span class=SpellE><span lang=EN-US style="font-size:10.0pt;
	  line-height:115%">'.dateToIndo().'</span></span><span lang=EN-US style="font-size:
	  10.0pt;line-height:115%"><o:p></o:p></span></p>
	  </td>
	 </tr>
	</table>

	<p class=MsoNormal align=center style="margin-bottom:0cm;margin-bottom:.0001pt;
	text-align:center"><b style="mso-bidi-font-weight:normal"><span lang=EN-US
	style="font-size:6.0pt;line-height:115%"><o:p>&nbsp;</o:p></span></b></p>
	';
	return $html;
}

function foot(){
	$html = '';
	/*
	$html = '
	<table class=MsoNormalTable border=1 cellspacing=0 cellpadding=0 width=696
	 style="width:522.0pt;margin-left:-30.6pt;border-collapse:collapse;border:none;
	 mso-border-alt:solid black .5pt;mso-yfti-tbllook:1184;mso-padding-alt:0cm 5.4pt 0cm 5.4pt;
	 mso-border-insideh:.5pt solid black;mso-border-insidev:.5pt solid black">
	 <tr style="mso-yfti-irow:0;mso-yfti-firstrow:yes;mso-yfti-lastrow:yes">
	  <td width=696 valign=top style="width:522.0pt;border:solid black 1.0pt;
	  mso-border-alt:solid black .5pt;padding:0cm 5.4pt 0cm 5.4pt">
	  <p class=MsoListParagraphCxSpFirst style="margin:0cm;margin-bottom:.0001pt;
	  mso-add-space:auto;line-height:normal"><b style="mso-bidi-font-weight:normal"><i
	  style="mso-bidi-font-style:normal"><span lang=DE style="font-size:10.0pt;
	  mso-ansi-language:DE">Catatan :<o:p></o:p></span></i></b></p>
	  <p class=MsoListParagraphCxSpMiddle style="margin-top:0cm;margin-right:0cm;
	  margin-bottom:0cm;margin-left:18.0pt;margin-bottom:.0001pt;mso-add-space:
	  auto;text-align:justify;text-indent:-18.0pt;line-height:normal;mso-list:l4 level1 lfo8"><![if !supportLists]><i
	  style="mso-bidi-font-style:normal"><span lang=EN-US style="font-size:9.0pt;
	  mso-bidi-font-family:Calibri"><span style="mso-list:Ignore">a<span
	  style="font:7.0pt "Times New Roman"">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	  </span></span></span></i><![endif]><span class=SpellE><i style="mso-bidi-font-style:
	  normal"><span lang=EN-US style="font-size:9.0pt">Pemohon</span></i></span><i
	  style="mso-bidi-font-style:normal"><span lang=EN-US style="font-size:9.0pt"> <span
	  class=SpellE>lembur</span> <span class=SpellE>adalah</span> <span
	  class=SpellE>tenaga</span> <span class=SpellE>kependidikan</span> yang <span
	  class=SpellE>akan</span> <span class=SpellE>melakukan</span> <span
	  class=SpellE>kerja</span> <span class=SpellE>lembur</span>;<o:p></o:p></span></i></p>
	  <p class=MsoListParagraphCxSpMiddle style="margin-top:0cm;margin-right:0cm;
	  margin-bottom:0cm;margin-left:18.0pt;margin-bottom:.0001pt;mso-add-space:
	  auto;text-align:justify;text-indent:-18.0pt;line-height:normal;mso-list:l4 level1 lfo8"><![if !supportLists]><i
	  style="mso-bidi-font-style:normal"><span lang=EN-US style="font-size:9.0pt;
	  mso-bidi-font-family:Calibri"><span style="mso-list:Ignore">b<span
	  style="font:7.0pt "Times New Roman"">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	  </span></span></span></i><![endif]><span class=SpellE><i style="mso-bidi-font-style:
	  normal"><span lang=EN-US style="font-size:9.0pt">Kerja</span></i></span><i
	  style="mso-bidi-font-style:normal"><span lang=EN-US style="font-size:9.0pt"> <span
	  class=SpellE>lembur</span> <span class=SpellE>hanya</span> <span
	  class=SpellE>bisa</span> <span class=SpellE>dilakukan</span> di <span
	  class=SpellE>luar</span> jam <span class=SpellE>kerja</span> <span
	  class=SpellE>operasional</span>;<o:p></o:p></span></i></p>
	  <p class=MsoListParagraphCxSpMiddle style="margin-top:0cm;margin-right:0cm;
	  margin-bottom:0cm;margin-left:18.0pt;margin-bottom:.0001pt;mso-add-space:
	  auto;text-align:justify;text-indent:-18.0pt;line-height:normal;mso-list:l4 level1 lfo8"><![if !supportLists]><i
	  style="mso-bidi-font-style:normal"><span lang=EN-US style="font-size:9.0pt;
	  mso-bidi-font-family:Calibri"><span style="mso-list:Ignore">c<span
	  style="font:7.0pt "Times New Roman"">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	  </span></span></span></i><![endif]><span class=SpellE><i style="mso-bidi-font-style:
	  normal"><span lang=EN-US style="font-size:9.0pt">Formulir</span></i></span><i
	  style="mso-bidi-font-style:normal"><span lang=EN-US style="font-size:9.0pt"> <span
	  class=SpellE>pengajuan</span> <span class=SpellE>lembur</span> <span
	  class=SpellE>wajib</span> <span class=SpellE>disetujui</span> <span
	  class=SpellE>dan</span> <span class=SpellE>ditandatangai</span> <span
	  class=SpellE>oleh</span> <span class=SpellE>atasan</span> <span class=SpellE>langsung</span>;<o:p></o:p></span></i></p>
	  <p class=MsoListParagraphCxSpMiddle style="margin-top:0cm;margin-right:0cm;
	  margin-bottom:0cm;margin-left:18.0pt;margin-bottom:.0001pt;mso-add-space:
	  auto;text-align:justify;text-indent:-18.0pt;line-height:normal;mso-list:l4 level1 lfo8"><![if !supportLists]><i
	  style="mso-bidi-font-style:normal"><span lang=EN-US style="font-size:9.0pt;
	  mso-bidi-font-family:Calibri"><span style="mso-list:Ignore">d<span
	  style="font:7.0pt "Times New Roman"">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	  </span></span></span></i><![endif]><span class=SpellE><i style="mso-bidi-font-style:
	  normal"><span lang=EN-US style="font-size:9.0pt">Formulir</span></i></span><i
	  style="mso-bidi-font-style:normal"><span lang=EN-US style="font-size:9.0pt"> <span
	  class=SpellE>pengajuan</span> <span class=SpellE>lembur</span> <span
	  class=SpellE>harus</span> <span class=SpellE>disampaikan</span> <span
	  class=SpellE>ke</span> Unit SDM <span class=SpellE>melalui</span> email </span></i><span
	  lang=EN-US><a href="mailto:sdm@fisip.ui.ac.id"><i style="mso-bidi-font-style:
	  normal"><span style="font-size:9.0pt">sdm@fisip.ui.ac.id</span></i></a></span><i
	  style="mso-bidi-font-style:normal"><span lang=EN-US style="font-size:9.0pt">.
	  <span class=SpellE>sebelum</span> <span class=SpellE>tugas</span> <span
	  class=SpellE>lembur</span> (<span class=SpellE>maksimal</span> di <span
	  class=SpellE>hari</span> <span class=SpellE>saat</span> <span class=SpellE>lembur</span>
	  <span class=SpellE>dilaksanakan</span>);<o:p></o:p></span></i></p>
	  <p class=MsoListParagraphCxSpMiddle style="margin-top:0cm;margin-right:0cm;
	  margin-bottom:0cm;margin-left:18.0pt;margin-bottom:.0001pt;mso-add-space:
	  auto;text-align:justify;text-indent:-18.0pt;line-height:normal;mso-list:l4 level1 lfo8"><![if !supportLists]><i
	  style="mso-bidi-font-style:normal"><span lang=EN-US style="font-size:9.0pt;
	  mso-bidi-font-family:Calibri"><span style="mso-list:Ignore">e<span
	  style="font:7.0pt "Times New Roman"">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	  </span></span></span></i><![endif]><span class=SpellE><i style="mso-bidi-font-style:
	  normal"><span lang=EN-US style="font-size:9.0pt">Pembayaran</span></i></span><i
	  style="mso-bidi-font-style:normal"><span lang=EN-US style="font-size:9.0pt"> <span
	  class=SpellE>lembur</span> <span class=SpellE>mengikuti</span> <span
	  class=SpellE>pembayaran</span> <span class=SpellE>gaji</span>;<o:p></o:p></span></i></p>
	  <p class=MsoListParagraphCxSpMiddle style="margin-top:0cm;margin-right:0cm;
	  margin-bottom:0cm;margin-left:18.0pt;margin-bottom:.0001pt;mso-add-space:
	  auto;text-align:justify;text-indent:-18.0pt;line-height:normal;mso-list:l4 level1 lfo8"><![if !supportLists]><i
	  style="mso-bidi-font-style:normal"><span lang=EN-US style="font-size:9.0pt;
	  mso-bidi-font-family:Calibri"><span style="mso-list:Ignore">f<span
	  style="font:7.0pt "Times New Roman"">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	  </span></span></span></i><![endif]><span class=SpellE><i style="mso-bidi-font-style:
	  normal"><span lang=EN-US style="font-size:9.0pt">Perhitungan</span></i></span><i
	  style="mso-bidi-font-style:normal"><span lang=EN-US style="font-size:9.0pt"> <span
	  class=SpellE>lembur</span> <span class=SpellE>mengikuti</span> <span
	  class=SpellE>ketentuan</span> yang <span class=SpellE>berlaku</span> <span
	  class=SpellE>menurut</span> SDM <span class=SpellE>Universitas</span>
	  Indonesia.<o:p></o:p></span></i></p>
	  <p class=MsoListParagraphCxSpLast style="margin:0cm;margin-bottom:.0001pt;
	  mso-add-space:auto;text-align:justify;line-height:normal"><i
	  style="mso-bidi-font-style:normal"><sup><span lang=EN-US style="font-size:
	  9.0pt">*)</span></sup></i><i style="mso-bidi-font-style:normal"><span
	  lang=EN-US style="font-size:9.0pt"><span style="mso-spacerun:yes">   </span><span
	  style="mso-spacerun:yes">  </span><span style="mso-spacerun:yes"> </span><span
	  class=SpellE>Pimpinan</span> unit / <span class=SpellE>Ketua</span> <span
	  class=SpellE>departemen</span><o:p></o:p></span></i></p>
	  </td>
	 </tr>
	</table>

	<p class=MsoNormal align=center style="margin-bottom:0cm;margin-bottom:.0001pt;
	text-align:center"><b style="mso-bidi-font-weight:normal"><span lang=EN-US
	style="font-size:14.0pt;line-height:115%"><o:p>&nbsp;</o:p></span></b></p>

	<p class=MsoNormal align=center style="margin-bottom:0cm;margin-bottom:.0001pt;
	text-align:center"><b style="mso-bidi-font-weight:normal"><span lang=EN-US
	style="font-size:14.0pt;line-height:115%"><o:p>&nbsp;</o:p></span></b></p>

	<p class=MsoNormal style="line-height:150%"><span lang=EN-US style="color:black"><o:p>&nbsp;</o:p></span></p>

	<p class=MsoNormal style="line-height:150%"><span lang=EN-US style="color:black"><o:p>&nbsp;</o:p></span></p>

	</div>

	</body>

	</html>
	';
	*/
	return $html;
}

function tanggal($tgl) { // fungsi atau method untuk mengubah tanggal ke format indonesia
	// variabel BulanIndo merupakan variabel array yang menyimpan nama-nama bulan
	$array_hari = array('Sun'=>'Minggu', 'Mon'=>'Senin', 'Tue'=>'Selasa', 'Wed'=>'Rabu', 'Thu'=>'Kamis', 'Fri'=>'Jumat', 'Sat'=>'Sabtu');
	$BulanIndo = array("01"=>"Januari", "02"=>"Februari", "03"=>"Maret",
					   "04"=>"April", "05"=>"Mei", "06"=>"Juni",
					   "07"=>"Juli", "08"=>"Agustus", "09"=>"September",
					   "10"=>"Oktober", "11"=>"November", "12"=>"Desember");
	$tgl_arr = explode('-',$tgl);
	$tahun = $tgl_arr[0]; 
	$bulan = $tgl_arr[1]; 
	$hari   = $tgl_arr[2]; 
	$kd_hari  = date('D', strtotime($tgl));
	$nama_hari = $array_hari[$kd_hari];
	$result = '<i>- '.$nama_hari.' -</i><br>'.$hari . " " . $BulanIndo[$bulan] . " ". $tahun;
	return($result);
}

function convertToHoursMins($time, $format = '%02d:%02d') {
    if ($time < 1) {
        return;
    }
    $hours = floor($time / 60);
    $minutes = ($time % 60);
    return sprintf($format, $hours, $minutes);
}

function dateToIndo(){
	$array_bulan = array("01"=>"Januari", "02"=>"Februari", "03"=>"Maret",
				   "04"=>"April", "05"=>"Mei", "06"=>"Juni",
				   "07"=>"Juli", "08"=>"Agustus", "09"=>"September",
				   "10"=>"Oktober", "11"=>"November", "12"=>"Desember");
	$m = date('m');
	$y = date('Y');
	$d = date('d');
	return $d.' '.$array_bulan[$m].' '.$y;
}
?>
