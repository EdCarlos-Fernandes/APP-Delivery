  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 <div class="jwc_return"></div>
<script>

        var lati = '';
        var long = '';
        var cidade = '';


  

		//GEO DO NAVEGADOR
			//SE O GEO ESTIVER ATIVO E RETORONAR UMA POSIÇÃO
        if('geolocation' in navigator)
			{
			navigator.geolocation.getCurrentPosition(function (posicao){
            var url = "https://nominatim.openstreetmap.org/reverse?lat=" + posicao.coords.latitude + "&lon=" + posicao.coords.longitude + "&format=json&json_callback=preencherDados";

            var script = document.createElement('script');
            script.src = url;
            document.body.appendChild(script);
            lati = posicao.coords.latitude;
            long = posicao.coords.longitude;

			},

			//SE NAO RETORNAR RESULTADO
			function(error){
				//AVISO DE ERRO
				alert("Erro ao localizar sua posição! \n Verifique se: \n O GPS encontra-se ativo.\n Não se esqueça: \n autorizar a consulta!");	alert('O GPS ainda encontra-se desativado.\n Ative sua geolocalizacao');
				//PEGA O NOME DA CIDADE QUE O CLIENTE DIGITA
				cd = prompt ("Sua localidade ainda e desconhecida.\n  Digite o nome da sua cidade.");
						var nomecd = cd.toUpperCase(); // Converte para Caixa alta o retorno da cidade
						//variavel responsavel por tratar as acentuações e characteres especiais no retorno
						 var map={"â":"a","Â":"A","à":"a","À":"A","á":"a","Á":"A","ã":"a","Ã":"A","ê":"e","Ê":"E","è":"e","È":"E","é":"e","É":"E","î":"i","Î":"I","ì":"i","Ì":"I","í":"i","Í":"I","õ":"o","Õ":"O","ô":"o","Ô":"O","ò":"o","Ò":"O","ó":"o","Ó":"O","ü":"u","Ü":"U","û":"u","Û":"U","ú":"u","Ú":"U","ù":"u","Ù":"U","ç":"c","Ç":"C"};
						//Função responsavel por remover os acentos(utiliza a varivavel acima)
						function removerAcentos(s){ return s.replace(/[\W\[\] ]/g,function(a){return map[a]||a}) };
						var ncdr = (removerAcentos(nomecd));
						// Trato os espaços com o split alterando para , e depois uso o join para trocar as , por -
						var upper = ncdr.split(" ").join('-');
						 dadosajax = {'cidade':upper};
						 
			//REALIZA O PROCESSO DE CONSULTA PELO NOME INFORMADO
			 $.ajax({
						url: "https://mpedidos.com/painel/configuracoes/procura_ip.php",
						data: dadosajax,
						type: 'POST',
						dataType: 'json',

						success: function (data) {
							if (data.trigger) {
								setTimeout(function () {
									$('.jwc_return').html(data.trigger).fadeIn();
								}, 500);
							}
							
						

							if (data.content) {
								$('.').before(data.content);
							}
								
						
						}
									
				});
			});
 
		//SE RETORNAR UMA LOCALOZAÇÃO
        function preencherDados(dados) {
			if(dados.address.village){
                         cidade = dados.address.village;
                     }else{
                        if(dados.address.city){
			 cidade = dados.address.city;
                        }
                   } 
                     
					 var uppp = cidade.toUpperCase(); // Converte para Caixa alta o retorno da cidade
					//variavel responsavel por tratar as acentuações e characteres especiais no retorno
					 var map={"â":"a","Â":"A","à":"a","À":"A","á":"a","Á":"A","ã":"a","Ã":"A","ê":"e","Ê":"E","è":"e","È":"E","é":"e","É":"E","î":"i","Î":"I","ì":"i","Ì":"I","í":"i","Í":"I","õ":"o","Õ":"O","ô":"o","Ô":"O","ò":"o","Ò":"O","ó":"o","Ó":"O","ü":"u","Ü":"U","û":"u","Û":"U","ú":"u","Ú":"U","ù":"u","Ù":"U","ç":"c","Ç":"C"};
					//Função responsavel por remover os acentos(utiliza a varivavel acima)
					function removerAcentos(s){ return s.replace(/[\W\[\] ]/g,function(a){return map[a]||a}) };
					var upp = (removerAcentos(uppp));
					// Trato os espaços com o split alterando para , e depois uso o join para trocar as , por -
					var upper = upp.split(" ").join('-');
					dadosajax = {'latitude':lati, 'longitude': long, 'cidade':upper};



		$.ajax({
            url: "https://mpedidos.com/painel/configuracoes/procura_ip.php",
            data: dadosajax,
            type: 'POST',
            dataType: 'json',

            success: function (data) {
                if (data.trigger) {
                    setTimeout(function () {
                        $('.jwc_return').html(data.trigger).fadeIn();
                    }, 500);
				alert('Olá, Verificamos que você encontra-se na cidade de '+ upper +'\n caso não esteja acessando dessa localidade');
                }
				
			

                if (data.content) {
                    $('.').before(data.content);
                }
					
			
			}
        
		});
    
		}
	}
</script>
