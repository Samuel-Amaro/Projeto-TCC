//O evento DOMContentLoaded é acionado quando todo o HTML foi completamente carregado e analisado, sem aguardar pelo CSS, imagens, e subframes para encerrar o carregamento. Um evento muito diferente - load - deve ser usado apenas para detectar uma página completamente carregada.
//window
//REFERENCIA AO PLUGIN
//https://datatables.net/manual/installation

//dados da tabela formato manual
//let dados = [
//             ["000.056.091-00", "(61) 9 9628-4269", "email@user.com", "Usuario", "Adm", "Samuel Amaro"],
//             ["000.056.091-00", "(61) 9 9628-4269", "email@user.com", "Usuario", "Adm", "Samuel Amaro"]
//            ];

window.addEventListener('DOMContentLoaded', function() {
    let tabela = new DataTable('#dataTablesBeneficiarios', {
        dom: 'B<"clear">lfrtip', 
        //'Bfrtip'
        buttons : ['copy', 'excel', 'pdf'],
        "scrollX": true,
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "../controller/ControllerBeneficiario.php",
            "data": {operacao: "listar"},
            "type": "POST",
            "dataSrc" : function(json) {
                        return json.data;
            },
            "contentType": 'application/x-www-form-urlencoded; charset=UTF-8'
        },
        "columns": [
            //{"data" : "id"},
            {"data" : "cpf"},
            {"data" : "primeiro_nome"},
            {"data" : "ultimo_nome"},
            {"data" : "nis"},
            {"data" : "celular_required"},
            //{"data" : "celular_opcional"},
            //{"data" : "endereco"},
            //{"data" : "bairro"},
            {"data" : "cidade"},
            {"data" : "uf"},
            {"data" : "qtd_pessoas_home"},
            {"data" : "renda"},
            //{"data" : "obs"},
            //{"data" : "email"},
            //{"data" : "cep"},
            //{"data" : "complemento_ende"},
            //{"data" : "abrangencia_cras"}
        ],
        "columnDefs": [ {
            "targets": 9,
            "data": null,
            "defaultContent": "<button class=\"btn btn-primary m-2\">Alterar</button> <button class=\"btn btn-primary m-2\">Excluir</button>"
        }]
    });    
});


/*
function(json) { //<font></font>
    for(var i=0, ien=json.length; i<ien ; i++) { //<font></font>
      json[i][0] = '<a href="/message/'+json[i][0]+'>View message</a>'; //<font></font>
    }//<font></font>
    return json;//<font></font>
},
*/

/*function(data) {
                        var dados = data['data'];
                        for (let index = 0; index < dados.length; index++) {
                            return dados[index];
                        }
            }*/

            //"dataSrc": "data",
            // "dataSrc": "data",

            /*"data" : function(json) {
            let dados = json["data"];
            return JSON.parse(dados);
        },*/