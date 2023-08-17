<?php
// CORE
include('../../../_core/_includes/config.php');
// RESTRICT
restrict('1');
// SEO
$seo_subtitle = "Adicionar Planos! - PayLojas! Sitema multilojas de lojas online.";
$seo_description = "PayLojas! Sitema multilojas de lojas online.";
$seo_keywords = "PayLojas, Script multilojas, sistema de lojas virtuais, loja virtual gratis, ecommerce, loja delivery, pedido no whatsapp, franquia de delivery, franquia de sistemas multilojas, script delivery multilojas";
// HEADER
$system_header .= "";
include('../../_layout/head.php');
include('../../_layout/top.php');
include('../../_layout/sidebars.php');
include('../../_layout/modal.php');
?>

<?php

  // Globals

  global $numeric_data;

  // Checar se formulário foi executado

  $formdata = $_POST['formdata'];

  if( $formdata ) {

    // Setar campos

    $nome = mysqli_real_escape_string( $db_con, $_POST['nome'] );
    $descricao = mysqli_real_escape_string( $db_con, $_POST['descricao'] );
    $duracao_dias = mysqli_real_escape_string( $db_con, $_POST['duracao_dias'] );
    $duracao_meses = mysqli_real_escape_string( $db_con, $_POST['duracao_meses'] );
    $valor_total = dinheiro( mysqli_real_escape_string( $db_con, $_POST['valor_total'] ) );
    $valor_mensal = dinheiro( mysqli_real_escape_string( $db_con, $_POST['valor_mensal'] ) );
    $link = mysqli_real_escape_string( $db_con, $_POST['link'] );
    $termos = mysqli_real_escape_string( $db_con, $_POST['termos'] );

    $funcionalidade_marketplace = mysqli_real_escape_string( $db_con, $_POST['funcionalidade_marketplace'] );
    $funcionalidade_variacao = mysqli_real_escape_string( $db_con, $_POST['funcionalidade_variacao'] );
    $funcionalidade_banners = mysqli_real_escape_string( $db_con, $_POST['funcionalidade_banners'] );
    
    $visible = mysqli_real_escape_string( $db_con, $_POST['visible'] );
    $status = mysqli_real_escape_string( $db_con, $_POST['status'] );
    $ordem = mysqli_real_escape_string( $db_con, $_POST['ordem'] );

    $limite_produtos = mysqli_real_escape_string( $db_con, $_POST['limite_produtos'] );

    // Checar Erros

    $checkerrors = 0;
    $errormessage = array();

      // if( $_FILES['destaque']['name'] ) {

      //   $upload = upload_image( "administracao", $_FILES['destaque'] );
        
      //   if ( $upload['status'] == "1" ) {
      //     $destaque = $upload['url'];
      //   } else {
      //     $checkerrors++;
      //     for( $x=0; $x < count( $upload['errors'] ); $x++ ) {
      //       $errormessage[] = $upload['errors'][$x];
      //     }
      //   }

      // }

      $destaque = "";

      // -- Destaque

      // if( !$destaque ) {
      //   $checkerrors++;
      //   $errormessage[] = "A imagem destaque não pode ser nula";
      // }

      // -- Nome

      if( !$nome ) {
        $checkerrors++;
        $errormessage[] = "O nome não pode ser nulo";
      }

    // Executar registro

      if( !$checkerrors ) {

        if( new_plano( $destaque,$nome,$descricao,$duracao_meses,$duracao_dias,$valor_total,$valor_mensal,$link,$termos,$funcionalidade_marketplace,$funcionalidade_variacao,$funcionalidade_banners,$visible,$status,$ordem,$limite_produtos ) ) {

          header("Location: index.php?msg=sucesso");

        } else {

          header("Location: index.php?msg=erro");

        }

      }

    }

?>

<div class="middle minfit bg-gray">

	<div class="container">

		<div class="row">

			<div class="col-md-12">

        <div class="title-icon pull-left">
          <i class="lni lni-list"></i>
          <span>Adicionar Plano</span>
        </div>

        <div class="bread-box pull-right">
          <div class="bread">
            <a href="<?php admin_url(); ?>"><i class="lni lni-home"></i></a>
            <span>/</span>
            <a href="<?php admin_url(); ?>/planos">Planos</a>
            <span>/</span>
            <a href="<?php admin_url(); ?>/planos/adicionar">Adicionar</a>
          </div>
        </div>
        
			</div>

		</div>

		<!-- Content -->

		<div class="data box-white mt-16">

      <form id="the_form" class="form-default" method="POST" enctype="multipart/form-data">

          <div class="row">

            <div class="col-md-12">

              <?php if( $checkerrors ) { list_errors(); } ?>

              <?php if( $_GET['msg'] == "erro" ) { ?>

                <?php modal_alerta("Erro, tente novamente!","erro"); ?>

              <?php } ?>

              <?php if( $_GET['msg'] == "sucesso" ) { ?>

                <?php modal_alerta("Cadastro efetuado com sucesso!","sucesso"); ?>

              <?php } ?>

            </div>

          </div>

<!--           <div class="row">

            <div class="col-md-12">
              <label>Foto destaque:</label>
              <div class="file-preview">

                <div class="image-preview image-preview-product" id="image-preview" style='background: url("") no-repeat center center; background-size: auto 102%;'>
                  <label for="image-upload" id="image-label">Enviar imagem</label>
                  <input type="file" name="destaque" id="image-upload"/>
                </div>
                <span class="explain">Selecione a foto destaque clicando no campo ou arrastando o arquivo!</span>

              </div>

            </div>

          </div> -->

          <div class="row">

            <div class="col-md-12">

              <div class="form-field-default">

                  <label>Nome:</label>
                  <input type="text" id="input-nome" name="nome" placeholder="Nome" value="<?php echo htmlclean( $_POST['nome'] ); ?>">

              </div>

            </div>

          </div>

          <div class="row">

            <div class="col-md-12">

              <div class="form-field-default">

                  <label>Descrição:</label>
                  <textarea rows="6" name="descricao" placeholder="Descrição do seu estabelecimento"><?php echo htmlclean( $_POST['descricao'] ); ?></textarea>

              </div>

            </div>

          </div>

          <div class="row">

            <div class="col-md-6 col-sm-6 col-xs-6">

              <div class="form-field-default">

                  <label>Duração (em meses):</label>
                  <input type="text" name="duracao_meses" placeholder="Duração (em meses)" value="<?php echo htmlclean( $_POST['duracao_meses'] ); ?>">

              </div>

            </div>

            <div class="col-md-6 col-sm-6 col-xs-6">

              <div class="form-field-default">

                  <label>Duração (em dias):</label>
                  <input type="text" name="duracao_dias" placeholder="Duração (em dias)" value="<?php echo htmlclean( $_POST['duracao_dias'] ); ?>">

              </div>

            </div>

          </div>

          <div class="row">

            <div class="col-md-6 col-sm-6 col-xs-6">

              <div class="form-field-default">

                  <label>Valor total:</label>
                  <input class="maskmoney" type="text" name="valor_total" placeholder="Valor total" value="<?php echo htmlclean( dinheiro( $_POST['valor_total'], "BR") ); ?>">

              </div>

            </div>

            <div class="col-md-6 col-sm-6 col-xs-6">

              <div class="form-field-default">

                  <label>Valor mensal:</label>
                  <input class="maskmoney" type="text" name="valor_mensal" placeholder="Valor mensal" value="<?php echo htmlclean( dinheiro( $_POST['valor_mensal'], "BR") ); ?>">

              </div>

            </div>

          </div>

<!--           <div class="row">

            <div class="col-md-12">

              <div class="form-field-default">

                  <label>Link de compra:</label>
                  <input type="text" name="link" placeholder="Link" value="<?php echo htmlclean( $_POST['link'] ); ?>">

              </div>

            </div>

          </div> -->

          <div class="row">

            <div class="col-md-12">

              <div class="form-field-default">

                  <label>Termos de compra:</label>
                  <textarea rows="12" name="termos" placeholder="Termos de compra"><?php include('termos.txt'); ?></textarea>

              </div>

            </div>

          </div>

          <div class="row">

            <div class="col-md-12">

              <div class="form-field-default">

                  <label>Habilita marketplace?</label>
                  <div class="radios">
                    <div class="spacer"></div>
                    <div class="form-field-radio">
                      <input type="radio" name="funcionalidade_marketplace" value="1" <?php if( $_POST['funcionalidade_marketplace'] == 1 OR !$_POST['funcionalidade_marketplace'] ){ echo 'CHECKED'; }; ?>> Sim
                    </div>
                    <div class="form-field-radio">
                      <input type="radio" name="funcionalidade_marketplace" value="2" <?php if( $_POST['funcionalidade_marketplace'] == 2 ){ echo 'CHECKED'; }; ?>> Não
                    </div>
                    <div class="clear"></div>
                  </div>

              </div>

            </div>

          </div>

          <div class="row">

            <div class="col-md-12">

              <div class="form-field-default">

                  <label>Habilita variação de produto?</label>
                  <div class="radios">
                    <div class="spacer"></div>
                    <div class="form-field-radio">
                      <input type="radio" name="funcionalidade_variacao" value="1" <?php if( $_POST['funcionalidade_variacao'] == 1 OR !$_POST['funcionalidade_variacao'] ){ echo 'CHECKED'; }; ?>> Sim
                    </div>
                    <div class="form-field-radio">
                      <input type="radio" name="funcionalidade_variacao" value="2" <?php if( $_POST['funcionalidade_variacao'] == 2 ){ echo 'CHECKED'; }; ?>> Não
                    </div>
                    <div class="clear"></div>
                  </div>

              </div>

            </div>

          </div>

          <div class="row">

            <div class="col-md-12">

              <div class="form-field-default">

                  <label>Habilita banners?</label>
                  <div class="radios">
                    <div class="spacer"></div>
                    <div class="form-field-radio">
                      <input type="radio" name="funcionalidade_banners" value="1" <?php if( $_POST['funcionalidade_banners'] == 1 OR !$_POST['funcionalidade_banners'] ){ echo 'CHECKED'; }; ?>> Sim
                    </div>
                    <div class="form-field-radio">
                      <input type="radio" name="funcionalidade_banners" value="2" <?php if( $_POST['funcionalidade_banners'] == 2 ){ echo 'CHECKED'; }; ?>> Não
                    </div>
                    <div class="clear"></div>
                  </div>

              </div>

            </div>

          </div>

          <div class="row">

            <div class="col-md-12">

              <div class="form-field-default">

                  <label>Plano visível?</label>
                  <span class="form-tip">Se habilitado o produto irá aparecer em todo site para compra.</span>
                  <div class="radios">
                    <div class="spacer"></div>
                    <div class="form-field-radio">
                      <input type="radio" name="visible" value="1" <?php if( $_POST['visible'] == 1 OR !$_POST['visible'] ){ echo 'CHECKED'; }; ?>> Sim
                    </div>
                    <div class="form-field-radio">
                      <input type="radio" name="visible" value="2" <?php if( $_POST['visible'] == 2 ){ echo 'CHECKED'; }; ?>> Não
                    </div>
                    <div class="clear"></div>
                  </div>

              </div>

            </div>

          </div>

          <div class="row">

            <div class="col-md-12">

              <div class="form-field-default">

                  <label>Plano ativo?</label>
                  <div class="radios">
                    <div class="spacer"></div>
                    <div class="form-field-radio">
                      <input type="radio" name="status" value="1" <?php if( $_POST['status'] == 1 OR !$_POST['status'] ){ echo 'CHECKED'; }; ?>> Sim
                    </div>
                    <div class="form-field-radio">
                      <input type="radio" name="status" value="2" <?php if( $_POST['status'] == 2 ){ echo 'CHECKED'; }; ?>> Não
                    </div>
                    <div class="clear"></div>
                  </div>

              </div>

            </div>

          </div>

          <div class="row">

            <div class="col-md-12">

              <div class="form-field-default">

                  <label>Ordem:</label>
                  <input type="text" name="ordem" placeholder="Ordem" value="<?php echo htmlclean( $_POST['ordem'] ); ?>">

              </div>

            </div>

          </div>

          <div class="row">

            <div class="col-md-12">

              <div class="form-field-default">

                  <label>Limite de produtos:</label>
                  <input type="number" name="limite_produtos" placeholder="Limite de produtos" value="<?php if( $_POST['limite_produtos'] ) { echo htmlclean( $_POST['limite_produtos'] ); } else { echo '10'; } ?>">

              </div>

            </div>

          </div>

          <div class="row lowpadd">

          	<div class="col-md-6 col-sm-5 col-xs-5">
          		<div class="form-field form-field-submit">
  							<a href="javascript:history.back(1)" class="backbutton pull-left">
  								<span><i class="lni lni-chevron-left"></i> Voltar</span>
  							</a>
  						</div>
          	</div>

  					<div class="col-md-6 col-sm-7 col-xs-7">
  						<input type="hidden" name="formdata" value="true"/>
  						<div class="form-field form-field-submit">
  							<button class="pull-right">
  								<span>Cadastrar <i class="lni lni-chevron-right"></i></span>
  							</button>
  						</div>
  					</div>

          </div>

      </form>

		</div>

		<!-- / Content -->

	</div>

</div>

<?php 
// FOOTER
$system_footer .= "";
include('../../_layout/rdp.php');
include('../../_layout/footer.php');
?>

<script>

$(document).ready( function() {
          
  // Globais

  $("#the_form").validate({

      /* REGRAS DE VALIDAÇÃO DO FORMULÁRIO */

      rules:{

        destaque:{
        required: true
        },
        nome:{
        required: true
        },
        descricao:{
        required: true
        }

      },
          
      /* DEFINIÇÃO DAS MENSAGENS DE ERRO */
              
      messages:{

        destaque:{
          required: "Obrigatório"
        },
        nome:{
          required: "Esse campo é obrigatório"
        },
        descricao:{
          required: "Esse campo é obrigatório"
        }

      }

    });

  });

</script>

<script>

$(document).ready(function() {
    
  // Preview avatar
  $.uploadPreview({
    input_field: "#image-upload",
    preview_box: "#image-preview",
    label_field: "#image-label",
    label_default: "Envie ou arraste",
    label_selected: "Trocar imagem",
    no_label: false
  });

  // Preview capa
  $.uploadPreview({
    input_field: "#image-upload2",
    preview_box: "#image-preview2",
    label_field: "#image-label2",
    label_default: "Envie ou arraste",
    label_selected: "Trocar imagem",
    no_label: false
  });

});

</script>