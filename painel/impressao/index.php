<?php
// CORE
include('../../_core/_includes/config.php');
// RESTRICT
restrict(2);
atualiza_estabelecimento( $_SESSION['estabelecimento']['id'], "online" );
// SEO
$seo_subtitle = "Impressão";
$seo_description = "";
$seo_keywords = "";
// HEADER
$system_header .= "";
include('../_layout/head.php');
include('../_layout/top.php');
include('../_layout/sidebars.php');
include('../_layout/modal.php');

global $db_con;
$eid = $_SESSION['estabelecimento']['id'];
$meudominio = "https://".$simple_url."/api/?token=";

$sql = mysqli_query( $db_con, "SELECT * FROM impressao WHERE ide = '$eid'" );
$total_results = mysqli_num_rows( $sql );

if($total_results <=0 ){

for ($i = 0; $i < 20; $i++)
{ 
    
$token = uniqid(rand());
$token = sha1($token); 

}

$token = "MDT".$eid.$token;

$sql = mysqli_query( $db_con, "INSERT INTO impressao (ide,status,token) VALUES ('$eid','2','$token');" );

$data = array(
    "Url" => $meudominio,
    "Token" => $token
);

$arquivo = 'login.json';
$json = json_encode($data);
$file = fopen($arquivo,'w');
fwrite($file, $json);
fclose($file);

header("Location: index.php?msg=sucesso");

} else { 

$datatoken = mysqli_fetch_array( $sql );

}

?>

<div class="middle minfit bg-gray">

	<div class="container">

		<div class="row">

			<div class="col-md-12">

				<div class="title-icon pull-left">
					<i class="lni lni-database"></i>
					<span>Impressão Automática</span>
				</div>

				<div class="bread-box pull-right">
					<div class="bread">
						<a href="<?php panel_url(); ?>"><i class="lni lni-home"></i></a>
						<span>/</span>
						<a href="<?php panel_url(); ?>/impressao">Impressão Automática</a>
					</div>
				</div>

			</div>

		</div>

		<div class="integracao">

			<div class="data box-white mt-16">

	            <div class="row">

	              <div class="col-md-12">

	                <div class="title-line pd-0">
	                  <i class="lni lni-printer"></i>
	                  <span>Impressão Automática</span>
	                  <div class="clear"></div>
	                </div>

	              </div>

	            </div>

 	            <div class="row">

	              <div class="col-md-12">

		              <div class="form-field-default">

		                  <label>Tutorial (Passo a passo):</label>
		                  
						  1 - Solicite o arquivo de instalação do sistema com o administrador.<br/>
						  
						  2 - Após instalar o sistema clique no botão abaixo para baixar o arquivo de liberação e coloque dentro da pasta do sistema em:<br/>
						  <br/>
						  <b>C:\Program Files (x86)\mdimpressao</b> ou <b>C:\Program Files\mdimpressao</b><br/>
						  <br/>
						  3 - Após isso execute o sistema.
		                

		              </div>

	              </div>

	            </div> 

			
			<div class="row">
 
	            <div class="col-md-3">
	            	<label></label>
					<a href="login.json" download>
	              	 <button>
	              		<span>
	              			<i class="lni lni-clipboard"></i> Baixar Arquivo
	              		</span>
						</button>
	              	 </a>
	              </div>

	          </div>

			</div>

		 </div>

	</div>

</div>

<?php 
// FOOTER
$system_footer .= "";
include('../_layout/rdp.php');
include('../_layout/footer.php');
?>