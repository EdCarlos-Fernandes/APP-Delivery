<?php
// CORE
include('../../_core/_includes/config.php');
// RESTRICT
restrict_estabelecimento();
restrict_expirado();
// SEO
$seo_subtitle = "Relatório";
$seo_description = "";
$seo_keywords = "";
// HEADER
$system_header .= "";
include('../_layout/head.php');
include('../_layout/top.php');
include('../_layout/sidebars.php');
include('../_layout/modal.php');
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

?>



<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawVisualization);
      
    function drawVisualization() {
        

        
        var data = google.visualization.arrayToDataTable([
            
            ['MÊS', 'Finalizados', 'Cancelados'],
        
        <?php
        $buscar = mysqli_query($db_con, "SELECT SUM(v_pedido AND status = '2') AS sumas, SUM(v_pedido AND status = '3') AS soomas, date(data_hora) AS datas FROM pedidos WHERE (data_hora > '$data_inicial_sql' AND data_hora < '$data_final_sql') AND rel_estabelecimentos_id = '$eid' GROUP BY date(data_hora)" );
        
          while ($dados = mysqli_fetch_array($buscar)) {
            $pedidostotais = $dados['sumas'];
            $pedidostotaisss = $dados['soomas'];
            $mes = $dados['datas'];
        
        ?>
        
        ['<?php echo $mes ?>', <?php echo $pedidostotais ?>, <?php echo $pedidostotaisss ?>], 
        
        <?php } ?>
        
        ]);
        
        var options = {
          title: 'GRÁFICO PEDIDOS POR DIA',
          vAxis: {minValue: 0}
        };
        
        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }
</script>



<style type="text/css">
  .card-counter {
    margin: 5px;
    padding: 10px 10px;
    background-color: #fff;
    height: 100px;
    border-radius: 5px;
    transition: .3s linear all;
  }

  .card-counter:hover {
    box-shadow: 4px 4px 20px #DADADA;
    transition: .3s linear all;
  }

  .card-counter.primary {
    background-color: #007bff;
    color: #FFF;
  }

  .card-counter.danger {
    background-color: #ef5350;
    color: #FFF;
  }

  .card-counter.success {
    background-color: #66bb6a;
    color: #FFF;
  }

  .card-counter.info {
    background-color: #f0ad4e;
    color: #FFF;
  }

  .card-counter i {
    font-size: 35px;
    opacity: 0.6;
    display: flex;
    transform: translate(15px, 20px);
  }

  .card-counter .count-numbers {
    position: absolute;
    right: 35px;
    top: 20px;
    font-size: 25px;
    display: block;
  }

  .card-counter .count-name {
    position: absolute;
    right: 35px;
    top: 65px;
    font-style: italic;
    text-transform: capitalize;
    opacity: 0.6;
    display: block;
    font-size: 16px;
  }


  .cardviews {
    display: flex;
    flex-direction: column;
    background-color: #252b43;
    flex: 1;
    align-items: center;
    justify-content: space-between;
    padding: 15px 0;
    border-radius: 3px;
    position: relative;
    margin-bottom: 30px;
  }

  .card::after {
    content: "";
    border-top: 5px solid #1ba2f4;
    border-radius: 3px;
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
  }

  .card__ig {
    display: flex;
    flex-direction: column;
    background-color: #252b43;
    flex: 1;
    align-items: center;
    justify-content: space-between;
    padding: 15px 0;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
    border-bottom-left-radius: 3px;
    border-bottom-right-radius: 3px;
    position: relative;
    margin-bottom: 30px;
    margin-top: 5px;
  }

  .card__ig::after {
    content: "";
    border-top: none;
    border-top-left-radius: 3px;
    border-top-right-radius: 3px;
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
    position: absolute;
    width: 100%;
    height: 5px;
    top: 0;
    left: 0;
    background: linear-gradient(90deg, #fac06c, #db4e93);
  }

  .card__yt::after {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    border-top: 5px solid #c2042a;
  }

  .fa-facebook-official,
  .fa-twitter {
    color: #1ba2f4;
  }

  .fa-youtube-play {
    color: #c2042a;
  }

  .icon {
    font-size: 22px !important;
  }

  .fa-instagram {
    color: red;
    display: block;
    background: linear-gradient(0deg, #fac06c, #db4e93);
    -webkit-text-fill-color: transparent;
  }

  .card__name {
    padding: 15px 0;
    color: #8a91bd;
    display: flex;
  }

  .card__number {
    font-size: 56px;
    font-weight: 700;
    color: #ffffff;
  }

  .card__followers {
    font-size: 12px;
    text-transform: uppercase;
    color: #8a91bd;
    letter-spacing: 5px;
  }

  .card__change {
    padding: 15px 0;
    color: #079076;
    display: flex;
  }

  span {
    margin-left: 5px;
  }

  .card__triangle-up {
    width: 0;
    height: 0;
    position: relative;
    top: 3px;
    border-right: 5px solid transparent;
    border-top: 5px solid transparent;
    border-left: 5px solid transparent;
    border-bottom: 5px solid #079076;
  }

  .card__change-down {
    padding: 15px 0;
    color: #da4e5b;
    display: flex;
  }

  .card__triangle-down {
    width: 0;
    height: 0;
    position: relative;
    top: 9px;
    border-right: 5px solid transparent;
    border-top: 5px solid #da4e5b;
    border-left: 5px solid transparent;
    border-bottom: 5px solid transparent;
  }

  .card-small {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    background-color: #252b43;
    flex: 1;
    align-items: stretch;
    justify-content: space-between;
    padding: 30px 30px;
    border-radius: 3px;
    position: relative;
    margin-bottom: 30px;
  }

  .card-small .card__name {
    flex: 0 50%;
  }

  .card-small .fa {
    flex: 0 50%;
    display: flex;
    align-items: center;
    justify-content: flex-end;
  }

  .card-small .card__number {
    flex: 0 50%;
    font-size: 36px;
  }

  .card-small .card__change {
    flex: 0 50%;
    position: relative;
    right: 0;
    display: flex;
    align-items: center;
    justify-content: flex-end;
  }

  .card-small .card__triangle-up {
    width: 0;
    height: 0;
    position: relative;
    top: -3px;
  }
</style>



<div class="row" style="width: 100%;display: contents;">
  <div class="col-md-12" style="margin-top: 50px;margin-bottom: 25px;">
    <div class="title-icon pull-left">
      <i class="lni lni-ticket-alt"></i>
      <span>Relatório</span>
    </div>

    <div class="bread-box pull-right">
      <div class="bread">
        <a href="<?php panel_url(); ?>"><i class="lni lni-home"></i></a>
        <span>/</span>
        <a href="<?php panel_url(); ?>/relatorio">Relatório</a>
      </div>
    </div>
  </div>
</div>


<!-- relatório -->
<div class="row" style="width: 100%;display: contents;">
  <div class="col-md-12">
    <div class="panel-group panel-filters">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title">
            <a>
              <span class="desc" style="width: 90%;display: flex;justify-content: space-around;flex-direction: row;"><b><?php print $data_inicial; ?></b> - <b><?php print $data_final; ?></b></span>
              <i class="lni lni-funnel"></i>
              <div class="clear"></div>
            </a>
          </h4>
        </div>

        <div class="panel-collapse <?php if( $_GET['filtered'] ) { echo 'in'; }; ?>">
          <div class="panel-body" style="padding: 0px;padding-top: 20px;">
            <div style="display: flex;flex-direction: column;">
              <div style="display: flex;justify-content: center;flex-direction: row;flex-wrap: wrap;">
                <div class="col-md-3" style="width: 310px;">
                  <div class="card-counter primary">
                    <i class="fa fa-money" aria-hidden="true"><?php print $total_results3; ?></i>
                    <span class="count-numbers">R$ <?php echo number_format($define_data3['soma3'], 2, ',', '.');?></span>
                    <span class="count-name">Não Finalizados</span>
                  </div>
                </div>
                <div class="col-md-3" style="width: 310px;">
                  <div class="card-counter danger">
                    <i class="fa fa-money" aria-hidden="true"><?php print $total_results2; ?></i>
                    <span class="count-numbers">R$ <?php echo number_format($define_data2['soma2'], 2, ',', '.');?></span>
                    <span class="count-name">Pedidos Cancelados</span>
                  </div>
                </div>
                <div class="col-md-3" style="width: 310px;">
                  <div class="card-counter success">
                    <i class="fa fa-money" aria-hidden="true"><?php print $total_results1; ?></i>
                    <span class="count-numbers">R$ <?php echo number_format($define_data1['soma1'], 2, ',', '.');?></span>
                    <span class="count-name">Pedidos Finalizados</span>
                  </div>
                </div>
              </div>

              <hr />

              <div style="display: flex;flex-wrap: wrap;flex-direction: row;justify-content: center;">
                <div class="col-md-3" style="width: 310px;">
                  <div class="card-counter success" style="height: 70px;background-color: #3e3e3e;">
                    <i class="fa fa-money" aria-hidden="true" style="transform: translate(15px, 0px);"><?php print $total_results4; ?></i>
                    <span class="count-name" style="top: 30px;">Total de Pedidos</span>
                  </div>
                </div>
                <div class="col-md-3" style="width: 310px;">
                  <div class="card-counter success" style="height: 70px;background-color: #3e3e3e;">
                    <span class="count-numbers" style="top: 15px;right: 75px;">R$ <?php echo number_format($define_data4['soma4'], 2, ',', '.');?></span>
                    <span class="count-name" style="top: 50px;right: 55px;">Total Geral do Período</span>
                  </div>
                </div>
              </div>
            </div>
            <!-- Gráfico -->
            <div id="chart_div" style="width: 100%; height: 300px;"></div>
            <!-- Fim Gráfico -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /relatório -->



<!-- Filters -->

<div class="row" style="width: 100%;display: contents;">
  <div class="col-md-12">
    <div class="panel-group panel-filters">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title">
            <a>
              <span class="desc">Filtrar novamente</span>
              <i class="lni lni-funnel"></i>
              <div class="clear"></div>
            </a>
          </h4>
        </div>
        <div class="panel-collapse <?php if( $_GET['filtered'] ) { echo 'in'; }; ?>">
          <div class="panel-body">
            <form class="form-filters form-100" method="GET" action="<?php panel_url(); ?>/relatorio/relatorio.php" target="_self">
              <input type="hidden" name="estabelecimento_id" value="<?php echo $eid; ?>" />
              <input type="hidden" name="numero" value="" />
              <input type="hidden" name="status" value="" />
              <input type="hidden" name="nome" value="" />
              <input type="hidden" name="cupom" value="" />

              <div class="row">

                <div class="clear visible-xs visible-sm"></div>
                <div class="col-md-4 half-left col-sm-6 col-xs-6">
                  <div class="form-field-default">
                    <label>Data inicial:</label>
                    <input class="maskdate datepicker" type="text" name="data_inicial" placeholder="Data inicial"
                      value="<?php echo htmlclean( $data_inicial ); ?>" />
                  </div>
                </div>
                <div class="col-md-4 half-right col-sm-6 col-xs-6">
                  <div class="form-field-default">
                    <label>Data final:</label>
                    <input class="maskdate datepicker" type="text" name="data_final" placeholder="Data inicial"
                      value="<?php echo htmlclean( $data_final ); ?>" />
                  </div>
                </div>
                <div class="clear visible-xs visible-sm"></div>
                <div class="col-md-4">
                  <div class="form-field-default">
                    <label class="hidden-xs hidden-sm"></label>
                    <input type="hidden" name="filtered" value="1" />
                    <button>
                      <span>Buscar</span>
                      <i class="lni lni-search-alt"></i>
                    </button>
                  </div>
                </div>

              </div>
              <?php if( $_GET['filtered'] ) { ?>
              <div class="row">
                <div class="col-md-12">
                  <a href="<?php panel_url(); ?>/relatorio" class="limpafiltros"><i class="lni lni-close"></i> Limpar filtros</a>
                </div>
              </div>
              <?php } ?>
            </form>

            <br />

            <form class="form-filters form-100" method="GET"
              action="<?php panel_url(); ?>/relatorio/relatorioImprimir.php" target="_blanc" style="margin-top: 20px;">
              <input type="hidden" name="estabelecimento_id" value="<?php echo $eid; ?>" />
              <input type="hidden" name="numero" value="" />
              <input type="hidden" name="status" value="" />
              <input type="hidden" name="nome" value="" />
              <input type="hidden" name="cupom" value="" />

              <div class="row">

                <input type="text" name="data_inicial" value="<?php echo htmlclean( $data_inicial ); ?>"
                  style="display: none;" />
                <input type="text" name="data_final" value="<?php echo htmlclean( $data_final ); ?>"
                  style="display: none;" />


                <button>
                  <span class="desc" style="color:white;">Imprimir</span>
                  <i class="lni lni-printer"></i>
                </button>

              </div>
            </form>





          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- / Filters -->

<?php 
// FOOTER
$system_footer .= "";
include('../_layout/rdp.php');
include('../_layout/footer.php');
?>