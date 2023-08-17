<?php
// CORE
include('../../_core/_includes/config.php');
// RESTRICT
restrict_estabelecimento();
restrict_expirado();
// SEO
$seo_subtitle = "Imprimir pedido";
$seo_description = "";
$seo_keywords = "";
// HEADER
$system_header .= "";
include('../../_layout/head.php');
?>

<?php
global $app;
global $seo_subtitle;
global $seo_description;
global $seo_keywords;
global $seo_image;
global $db_con;
?>

<?php
$eid = mysqli_real_escape_string( $db_con, $_GET['estabelecimento_id'] );

$data_inicial = mysqli_real_escape_string( $db_con, $_GET['data_inicial'] );
if( !$data_inicial ) { $data_inicial = date("d/m/Y"); }
$data_inicial_sql = datausa_min( $data_inicial );
$data_inicial_sql = $data_inicial_sql." 00:00:00";

$data_final = mysqli_real_escape_string( $db_con, $_GET['data_final'] );
if( !$data_final ) { $data_final = date("d/m/Y"); }
$data_final_sql = datausa_min( $data_final );
$data_final_sql = $data_final_sql." 23:59:59";

// FINALIZADOS
$sql1 = mysqli_query( $db_con, "SELECT SUM(v_pedido) AS soma1 FROM pedidos WHERE 1=1 AND status = '2' AND (data_hora > '$data_inicial_sql' AND data_hora < '$data_final_sql') AND rel_estabelecimentos_id = '$eid'" );
$define_data1 = mysqli_fetch_array( $sql1 );
$sql1x = mysqli_query( $db_con, "SELECT id FROM pedidos WHERE 1=1 AND status = '2' AND (data_hora > '$data_inicial_sql' AND data_hora < '$data_final_sql') AND rel_estabelecimentos_id = '$eid'" );
$total_results1 = mysqli_num_rows( $sql1x );

// CANCELADOS
$sql2 = mysqli_query( $db_con, "SELECT SUM(v_pedido) AS soma2 FROM pedidos WHERE 1=1 AND status = '3' AND (data_hora > '$data_inicial_sql' AND data_hora < '$data_final_sql') AND rel_estabelecimentos_id = '$eid'" );
$define_data2 = mysqli_fetch_array( $sql2 );
$sql2x = mysqli_query( $db_con, "SELECT id FROM pedidos WHERE 1=1 AND status = '3' AND (data_hora > '$data_inicial_sql' AND data_hora < '$data_final_sql') AND rel_estabelecimentos_id = '$eid'" );
$total_results2 = mysqli_num_rows( $sql2x );

// NAO FINALIZADOS
$sql3 = mysqli_query( $db_con, "SELECT SUM(v_pedido) AS soma3 FROM pedidos WHERE 1=1 AND (status = '1' OR status = '4' OR status = '5' OR status = '6') AND (data_hora > '$data_inicial_sql' AND data_hora < '$data_final_sql') AND rel_estabelecimentos_id = '$eid'" );
$define_data3 = mysqli_fetch_array( $sql3 );
$sql3x = mysqli_query( $db_con, "SELECT id FROM pedidos WHERE 1=1 AND (status = '1' OR status = '4' OR status = '5' OR status = '6') AND (data_hora > '$data_inicial_sql' AND data_hora < '$data_final_sql') AND rel_estabelecimentos_id = '$eid'" );
$total_results3 = mysqli_num_rows( $sql3x );

// TOTAL GERAL
$sql4 = mysqli_query( $db_con, "SELECT SUM(v_pedido) AS soma4 FROM pedidos WHERE 1=1 AND (data_hora > '$data_inicial_sql' AND data_hora < '$data_final_sql') AND rel_estabelecimentos_id = '$eid'" );
$define_data4 = mysqli_fetch_array( $sql4 );
$sql4x = mysqli_query( $db_con, "SELECT id FROM pedidos WHERE 1=1 AND (data_hora > '$data_inicial_sql' AND data_hora < '$data_final_sql') AND rel_estabelecimentos_id = '$eid'" );
$total_results4 = mysqli_num_rows( $sql4x );

$estabelecimento = data_info("estabelecimentos",$eid,"nome");
?>

<!-- Dinheiro -->
<?php
$buscar1 = mysqli_query( $db_con, "SELECT * FROM pedidos WHERE 1=1 AND forma_pagamento = '1' AND status = '2' AND (data_hora > '$data_inicial_sql' AND data_hora < '$data_final_sql')  AND rel_estabelecimentos_id = '$eid'");
$con1 = 0;
while ($dado1 = mysqli_fetch_array($buscar1)) {
$tot_din += $dado1['v_pedido'];
$con1++
?>
<?php } ?>

<!-- Débito -->
<?php
$buscar2 = mysqli_query( $db_con, "SELECT * FROM pedidos WHERE 1=1 AND forma_pagamento = '2' AND status = '2' AND (data_hora > '$data_inicial_sql' AND data_hora < '$data_final_sql')  AND rel_estabelecimentos_id = '$eid'");
$con2 = 0;
while ($dado2 = mysqli_fetch_array($buscar2)) {
$tot_debito += $dado2['v_pedido'];
$con2++
?>
<?php } ?>

<!-- Crèdito -->
<?php
$buscar3 = mysqli_query( $db_con, "SELECT * FROM pedidos WHERE 1=1 AND forma_pagamento = '3' AND status = '2' AND (data_hora > '$data_inicial_sql' AND data_hora < '$data_final_sql')  AND rel_estabelecimentos_id = '$eid'");
$con3 = 0;
while ($dado3 = mysqli_fetch_array($buscar3)) {
$tot_credito += $dado3['v_pedido'];
$con3++
?>
<?php } ?>

<!-- Ticket alimentação -->
<?php
$buscar4 = mysqli_query( $db_con, "SELECT * FROM pedidos WHERE 1=1 AND forma_pagamento = '4' AND status = '2' AND (data_hora > '$data_inicial_sql' AND data_hora < '$data_final_sql')  AND rel_estabelecimentos_id = '$eid'");
$con4 = 0;
while ($dado4 = mysqli_fetch_array($buscar4)) {
$tot_tktalimentacao += $dado4['v_pedido'];
$con4++
?>
<?php } ?>

<!-- Outros -->
<?php
$buscar5 = mysqli_query( $db_con, "SELECT * FROM pedidos WHERE 1=1 AND forma_pagamento = '5' AND status = '2' AND (data_hora > '$data_inicial_sql' AND data_hora < '$data_final_sql')  AND rel_estabelecimentos_id = '$eid'");
$con5 = 0;
while ($dado5 = mysqli_fetch_array($buscar5)) {
$tot_outros += $dado5['v_pedido'];
$con5++
?>
<?php } ?>

<!-- PIX -->
<?php
$buscar6 = mysqli_query( $db_con, "SELECT * FROM pedidos WHERE 1=1 AND forma_pagamento = '6' AND status = '2' AND (data_hora > '$data_inicial_sql' AND data_hora < '$data_final_sql')  AND rel_estabelecimentos_id = '$eid'");
$con6 = 0;
while ($dado6 = mysqli_fetch_array($buscar6)) {
$tot_pix += $dado6['v_pedido'];
$con6++
?>
<?php } ?>


<style>
  .comprovant-print {
    margin: 0;
    max-width: 300px;
    box-shadow: none !important;
    border: 1px solid #C7C7C7;
    padding: 20px 10px 20px 10px;
    font-size: 14px;
    text-align: left;
  }
  .comprovant {
    padding: 40px 20px 40px 20px;
    background: #fef9da;
    /* background: rgba(0,0,0,.05); */
    /* background: rgba(0,0,0,.01); */
    border: 1px solid rgba(0,0,0,.1);
    text-align: center;
    font-size: 16px;
    transition: 0.3s;
    box-shadow: 3px 3px 3px rgb(0 0 0 / 10%);
  }

  .canto {
      display: flex;
      justify-content: space-between;
  }

  #invoice-POS {
  box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
  padding: 2mm;
  margin: 0 auto;
  width: 44mm;
  background: #FFF;
  }
  #invoice-POS ::selection {
    background: #f31544;
    color: #FFF;
  }
  #invoice-POS ::moz-selection {
    background: #f31544;
    color: #FFF;
  }
  #invoice-POS h1 {
    font-size: 1.5em;
    color: #222;
  }
  #invoice-POS h2 {
    font-size: 0.9em;
  }
  #invoice-POS h3 {
    font-size: 1.2em;
    font-weight: 300;
    line-height: 2em;
  }
  #invoice-POS p {
    font-size: 0.7em;
    color: #666;
    line-height: 1.2em;
  }
  #invoice-POS #top, #invoice-POS #mid, #invoice-POS #bot {
    /* Targets all id with 'col-' */
    border-bottom: 1px solid #EEE;
  }
  #invoice-POS #top {
    min-height: 100px;
  }
  #invoice-POS #mid {
    min-height: 80px;
  }
  #invoice-POS #bot {
    min-height: 50px;
  }
  #invoice-POS #top .logo {
    height: 60px;
    width: 60px;
    background: url(http://michaeltruong.ca/images/logo1.png) no-repeat;
    background-size: 60px 60px;
  }
  #invoice-POS .clientlogo {
    float: left;
    height: 60px;
    width: 60px;
    background: url(http://michaeltruong.ca/images/client.jpg) no-repeat;
    background-size: 60px 60px;
    border-radius: 50px;
  }
  #invoice-POS .info {
    display: block;
    margin-left: 0;
  }
  #invoice-POS .title {
    float: right;
  }
  #invoice-POS .title p {
    text-align: right;
  }
  #invoice-POS table {
    width: 100%;
    border-collapse: collapse;
  }
  #invoice-POS .tabletitle {
    font-size: 0.5em;
    background: #EEE;
  }
  #invoice-POS .service {
    border-bottom: 1px solid #EEE;
  }
  #invoice-POS .item {
    width: 24mm;
  }
  #invoice-POS .itemtext {
    font-size: 0.5em;
  }
  #invoice-POS #legalcopy {
    margin-top: 5mm;
  }


  
  .canto1 {
      display: flex;
      justify-content: flex-end;
  }

  .canto2 {
    display: flex;
    justify-content: center;
    transform: translate(5px, 0px);
  }
  
  
  .linha_baixa {
    border-bottom: 1px solid black;
    border-right: 1px solid black;
  }
</style>


<div class="comprovant comprovant-print">
  <div class="conten" style="font-size: 16px;">
    <div style="border: 3px solid black;margin-top: -29px;padding-top: 10px;">   
      <img style="width: 200px;height: 115px;margin-top: -5px;" src="<?php echo thumber( $_SESSION['estabelecimento']['perfil'], 150 ); ?>" alt="<?php echo $_SESSION['estabelecimento']['nome']; ?>" />
      <h1 style="font-size: 30px;margin-top: 0px;"><?php echo $estabelecimento ?></h1>
      <h4>
        <center><code>RELATÓRIO FINANCEIRO<br />SINTÉTICO POR DATA</code></center>
      </h4>

      <code>De:<?php print $data_inicial; ?></code>&nbsp;&nbsp;-&nbsp;&nbsp;<code>Até:<?php print $data_final; ?></code>
        
      <h3 style="margin: 0px;padding-bottom: 11px;border-bottom: 1px solid black;border-top: 1px solid black;padding-top: 10px;font-size: 18px;">Tipos de pagamento</h3>

      <div id="bot">

        <div id="table">
          <table style="width: 100%;font-size: 15px;">
            <tr class="tabletitle">
              <td class="Hours"><h3><center>UND</center></h3></td>
              <td class="item"><h3><center style="display: flex;justify-content: center;transform: translate(5px, 0px);">Pagamento</center></h3></td>
              <td class="Rate"><h3><center class="canto1">Sub-total</center></h3></td>
            </tr>

            <tr class="service">
              <td class="tableitem linha_baixa"  style="border-top: 1px solid black;"><center><?php echo $con1 ?></center></td>
              <td class="tableitem linha_baixa"  style="border-top: 1px solid black;"><center class="canto2">Dinheiro</center></td>
              <td class="tableitem linha_baixa"  style="border-top: 1px solid black;border-right: 0px solid black;"><center class="canto1">R$<?php echo number_format($tot_din, 2, ',', '.');?></center></td>
            </tr>

            <tr class="service">
              <td class="tableitem linha_baixa"><center><?php echo $con2 ?></center></td>
              <td class="tableitem linha_baixa"><center class="canto2">Débito</center></td>
              <td class="tableitem linha_baixa" style="border-right: 0px solid black;"><center class="canto1">R$<?php echo number_format($tot_debito, 2, ',', '.');?></center></td>
            </tr>

            <tr class="service">
              <td class="tableitem linha_baixa"><center><?php echo $con3 ?></center></td>
              <td class="tableitem linha_baixa"><center class="canto2">Crèdito</center></td>
              <td class="tableitem linha_baixa" style="border-right: 0px solid black;"><center class="canto1">R$<?php echo number_format($tot_credito, 2, ',', '.');?></center></td>
            </tr>

            <tr class="service">
              <td class="tableitem linha_baixa"><center><?php echo $con4 ?></center></td>
              <td class="tableitem linha_baixa"><center class="canto2">Ticket alimentação</center></td>
              <td class="tableitem linha_baixa" style="border-right: 0px solid black;"><center class="canto1">R$<?php echo number_format($tot_tktalimentacao, 2, ',', '.');?></center></td>
            </tr>

            <tr class="service">
              <td class="tableitem linha_baixa"><center><?php echo $con5 ?></center></td>
              <td class="tableitem linha_baixa"><center class="canto2">Outros</center></td>
              <td class="tableitem linha_baixa" style="border-right: 0px solid black;"><center class="canto1">R$<?php echo number_format($tot_outros, 2, ',', '.');?></center></td>
            </tr>

            <tr class="service">
              <td class="tableitem linha_baixa"><center><?php echo $con6 ?></center></td>
              <td class="tableitem linha_baixa"><center class="canto2">PIX</center></td>
              <td class="tableitem linha_baixa" style="border-right: 0px solid black;"><center class="canto1">R$<?php echo number_format($tot_pix, 2, ',', '.');?></center></td>
            </tr>
          </table>
          
          <h3 style="margin: 0px;padding-bottom: 11px;border-bottom: 1px solid black;font-size: 18px;padding-top: 60px;">Balancete do periodo pesquisado</h3>

          <table style="width: 100%;font-size: 14px;">
            <tr class="tabletitle">
              <td class="Hours"><h3><center>UND</center></h3></td>
              <td class="item"><h3><center style="display: flex;justify-content: center;transform: translate(-10px, 0px);">Tipo</center></h3></td>
              <td class="Rate"><h3><center class="canto1">Sub-total</center></h3></td>
            </tr>

            <tr class="service">
              <td class="tableitem linha_baixa"  style="border-top: 1px solid black;"><center><?php print $total_results4; ?></center></td>
              <td class="tableitem linha_baixa"  style="border-top: 1px solid black;"><center class="canto2" style="transform: translate(-5px, 0px);">Pedidos aceitos</center></td>
              <td class="tableitem linha_baixa"  style="border-top: 1px solid black;border-right: 0px solid black;"><center class="canto1" style="transform: translate(0px, 0px);">R$<?php echo number_format($define_data4['soma4'], 2, ',', '.');?></center></td>
            </tr>

            <tr class="service">
              <td class="tableitem linha_baixa"><center><?php print $total_results2; ?></center></td>
              <td class="tableitem linha_baixa"><center class="canto2" style="transform: translate(-5px, 0px);">Pedidos Cancelados</center></td>
              <td class="tableitem linha_baixa" style="border-right: 0px solid black;"><center class="canto1" style="transform: translate(0px, 0px);">R$<b>-</b><?php echo number_format($define_data2['soma2'], 2, ',', '.');?></center></td>
            </tr>

            <tr class="service">
              <td class="tableitem linha_baixa"><center><?php print $total_results1; ?></center></td>
              <td class="tableitem linha_baixa"><center class="canto2" style="transform: translate(0px, 0px);">Pedidos FINALIZADOS</center></td>
              <td class="tableitem linha_baixa" style="border-right: 0px solid black;"><center class="canto1" style="transform: translate(0px, 0px);">R$<?php echo number_format($define_data1['soma1'], 2, ',', '.');?></center></td>
            </tr>

          </table>

          <h3 style="margin: 0px;padding-bottom: 11px;border-bottom: 1px solid black;font-size: 18px;padding-top: 60px;">Total final em CAIXA</h3>

          <table style="width: 100%;">

            <tr class="service">
              <td class="tableitem"></td>
              <td class="tableitem linha_baixa"><center class="canto2" style="transform: translate(-5px, 0px);">Pedidos totais em caixa</center></td>
              <td class="tableitem" style="border-bottom: 1px solid black;"><center style="transform: translate(-15px, 0px);"><?php print $total_results1; ?></center></td>
            </tr>

            <tr class="service">
              <td class="tableitem"></td>
              <td class="tableitem" style="border-right: 1px solid black;"><center class="canto2" style="transform: translate(-15px, 0px);">Valor Total em caixa</center></td>
              <td class="tableitem"><center class="canto1" style="transform: translate(0px, 0px);">R$<?php echo number_format($define_data1['soma1'], 2, ',', '.');?></center></td>
            </tr>

          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  window.print();
</script>