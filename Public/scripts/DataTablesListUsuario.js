//O evento DOMContentLoaded é acionado quando todo o HTML foi completamente carregado e analisado, sem aguardar pelo CSS, imagens, e subframes para encerrar o carregamento. Um evento muito diferente - load - deve ser usado apenas para detectar uma página completamente carregada.
//window
//REFERENCIA AO PLUGIN
//https://datatables.net/manual/installation

//dados da tabela formato manual
let dados = [
             ["000.056.091-00", "(61) 9 9628-4269", "email@user.com", "Usuario", "Adm", "Samuel Amaro"],
             ["000.056.091-00", "(61) 9 9628-4269", "email@user.com", "Usuario", "Adm", "Samuel Amaro"]
            ];

window.addEventListener('DOMContentLoaded', function() {
    let tabela = new DataTable('#dataTablesBeneficiarios', {
        "scrollX": true,
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "../controller/ControllerBeneficiario.php",
            "data": {operacao: "listar"},
            "type": "POST",
            "dataSrc": "data",
            /*function(data) {
                return JSON.parse(data.data);
            }*///,
            columns: [
                {"data": "ultimo_nome"},
                {"data": "cpf"}
            ],
            "contentType": 'application/x-www-form-urlencoded; charset=UTF-8'
        }
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