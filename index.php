<?php
require_once("./view/cabecalho.php"); 
require_once("./view/menu.php"); ?>

    <main class="principal">
        <?php $servicos = [
            "Hora"=>"time",
            "Diretorio"=>"dir",
            "Ping"=>"ping 127.0.0.1",
            "Memoria"=>"wmic OS get FreePhysicalMemory /Value",
            "Diretorio2"=>"dir"
        ]; 
        $hosts = ["Server1","Server2","Server3","Server4","Server5","Server6","Server7","Server8","Server9","Server10","Server11","Server2","Server13","Server14","Server15"]; ?>
        <div id="todosServicos">
        <?php
        /*foreach($servicos as $index=>$comando): ?>
            <div class="servicos">            
                <p><span id="servico"+<?=$index?>></span></p>   
            </div>*/
        /*endforeach */?>
        </div>
    </main>

    <script>   
    
    let servicos = <?= json_encode($servicos) ?>;

    let qntServicos = <?= sizeof($servicos) ?>;
    let hosts = <?= json_encode($hosts)?>;
    console.log(hosts);
    let qntHosts = <?= sizeof($hosts) ?>;

       $(document).ready(function(){
           iniciaServicos();
           $('#busca').keyup(function(){
               var txt = $(this).val();
               if(txt != ''){  
                   $.each(hosts,function(index,elemento){   
                        let pesquisa = txt.toLowerCase();
                        let host = elemento.toLowerCase();
                        var regex1 = RegExp(`^${pesquisa}`);                    
                        if(regex1.test(host)) $(`#ddraggable${index}`).parent().show();
                        else $(`#ddraggable${index}`).parent().hide();
                   });
               }else{
                $.each(hosts,function(index,elemento){                       
                        $(`#ddraggable${index}`).parent().show();
                   });
               }
           })
       })
        


        const iniciaServicos = function(){
            $( function() {
                for(let indexHosts = 0; indexHosts < qntHosts;indexHosts++){
                    $("#todosServicos").append(` 
                    <div id="conjuntoServicos${indexHosts}" class="conjuntoServicos ui-widget-content ">
                        <h3 id="ddraggable${indexHosts}">${hosts[indexHosts]}</h3>
                    </div>`);
                    $.each(servicos, function (index,servico){
                        $("#conjuntoServicos"+indexHosts).append(` 
                            
                            <div class="card bg-light mb-3 ui-widget-content servicos" id="draggable${index}">
                                <div class="card-header dark-color">${index}</div>
                                <a href="#" data-toggle="modal" data-target="#modal${indexHosts}${index}">
                                    <div class="card-body" id= "card-body${indexHosts}${index}">
                                        <img width="30px" height="30px" id="servico${indexHosts}${index}" src="./img/loading.gif" alt="loading">
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="modal fade" id="modal${indexHosts}${index}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="titulo">${servico}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p id="texto${indexHosts}${index}"></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-dark" data-dismiss="modal">Sair</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        `); 

                        

                    }); 
                    var positions = JSON.parse(localStorage.positions || "{}");
                       
                    $.each(positions, function (id, pos) {
                        $("#" + id).css(pos)
                    })
                    $( `#conjuntoServicos${indexHosts}` ).draggable({
                        stop: function (event, ui) {
                            positions[this.id] = ui.position
                            localStorage.positions = JSON.stringify(positions)
                        }
                    });
                }   
            });
            
        

            const atualizaServico = function (){

                for(let indexHosts = 0;indexHosts < qntHosts; indexHosts++){
                    
                    $.each(servicos, function (index,servico){
                        
                        $.ajaxSetup({
                                type: "POST",
                                global: true,
                                url: "./servicos.php",
                                data:{comando:servico},
                                success: function(data){      
                                    let card = $(`#card-body${indexHosts}${index}`);
                                    if(data.substr(23,7)>3000000){
                                        card.removeClass("btn-danger");
                                        card.addClass("btn-success");
                                        $(`#servico${indexHosts}${index}`).hide();
                                        console.log(`servico${indexHosts}${index}`)
                                    }else{
                                        card.removeClass("btn-success");
                                        card.addClass("btn-danger");
                                        $(`#servico${indexHosts}${index}`).hide();
                                        
                                    }
                                    $(`#texto${indexHosts}${index}`).text(data);
                                    
                                }
                            });
                        $.ajax();
                        
                    });
                    let qntServicosCritical = $(`#conjuntoServicos${indexHosts} .btn-danger`).length;
                    if(qntServicosCritical >= 5){
                        $(`#ddraggable${indexHosts}`).addClass("text-danger");
                    }else if(qntServicosCritical >=1)
                        $(`#ddraggable${indexHosts}`).addClass("text-warning");
                    else{
                        $(`#ddraggable${indexHosts}`).addClass("text-success");
                    }
                };
            }
            atualizaServico();

            setInterval(atualizaServico, 180000);  
        }       
    </script>
    <?php require_once("./view/rodape.php"); ?>
