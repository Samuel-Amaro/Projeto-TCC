//O evento DOMContentLoaded é acionado quando todo o HTML foi completamente carregado e analisado, sem aguardar pelo CSS, imagens, e subframes para encerrar o carregamento. Um evento muito diferente - load - deve ser usado apenas para detectar uma página completamente carregada.
//window
//REFERENCIA AO PLUGIN
//https://datatables.net/manual/installation

//dados da tabela formato manual
//let dados = [
//             ["000.056.091-00", "(61) 9 9628-4269", "email@user.com", "Usuario", "Adm", "Samuel Amaro"],
//             ["000.056.091-00", "(61) 9 9628-4269", "email@user.com", "Usuario", "Adm", "Samuel Amaro"]
//            ];

//let tabela;

window.addEventListener('load', function() {
    let tabela = new DataTable('#dataTablesBeneficiarios', {
        "dom": 'B<"clear">lfrtip', 
        //'Bfrtip'
        "buttons" : ['copy', 'excel', 'pdf', 'print'],
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
           // {"data" : "celular_opcional"},
           // {"data" : "endereco"},
           // {"data" : "bairro"},
            {"data" : "cidade"},
            {"data" : "uf"},
            {"data" : "qtd_pessoas_home"},
            {"data" : "renda"},
          //  {"data" : "obs"},
           // {"data" : "email"},
           // {"data" : "cep"},
           // {"data" : "complemento_ende"},
           // {"data" : "abrangencia_cras"}
        ],
        "columnDefs": [ {
            "targets": 9,
            "data": null,
            "defaultContent": "<button type=\"button\" class=\"btn btn-primary btn-alterar-benef\" data-toggle=\"modal\" data-target=\"#exampleModal\" data-whatever=\"@mdo\"><i class=\"fas fa-user-edit\"></i></button> <button type=\"button\" class=\"btn btn-primary\"><i class=\"fas fa-user-times\"></i></button>"
        }]
    });    
    //ao clicar no btn de alterar retorna os dados da linha clicada
    $('#dataTablesBeneficiarios tbody').on('click', '.btn-alterar-benef', function(){
        let data = tabela.row($(this).parents('tr')).data();
        carregaDadosModal(data);
        mostraModal();
        //console.log(data); //return um object 
        //alert(data.cpf +" seu nome e: "+ data.primeiro_nome + data.ultimo_nome);
    });
});

/**
 * esta função mostra um modal com o formulario de beneficiario.
 * mostra um modal do boostrap 5
 */
function mostraModal() {
    let elementoModal = document.querySelector("#exampleModal");
    let objectBoostrap = new bootstrap.Modal(elementoModal);
    objectBoostrap.show();
} 

/**
 * esta função carrega, os dados, numa modal boostrap, popula os campos de um modal
 * @param {object data} object 
 */
function carregaDadosModal(object) {
    let selectValuesEstado = ["ac", "al", "df", "go", "ap", "am", "ba", "ce", "es", "ma", "mt", "ms", "mg", "pb", "pr", "pe", "pi", "rj", "rn", "rs", "ro", "rr", "sc", "sp", "se", "to"];
    let selectValuesAbrangenciaCras = ["cras1", "cras2"];
    let inputPrimeiroNome = document.querySelector("#inputNomePrimeiro");
    let inputUltimoNome = document.querySelector("#inputNomeUltimo");
    let inputCpf = document.querySelector("#inputCpf");
    let inputFoneRequired = document.querySelector("#inputFone");
    let inputFoneOpcional = document.querySelector("#inputFoneOpcional");
    let inputCep = document.querySelector("#inputCep");
    let inputEmail = document.querySelector("#inputEmailOpcional");
    let inputEndereco = document.querySelector("#inputEndereco");
    let inputComplemento = document.querySelector("#inputComplemento");
    let inputCidade = document.querySelector("#inputCidade");
    let selectEstado = document.querySelector("#inputEstado");
    let inputBairro = document.querySelector("#inputBairro");
    let inputNis = document.querySelector("#inputNis");
    let inputQtdPessoasHome = document.querySelector("#inputQtdPessoasHome");
    let inputRenda = document.querySelector("#inputRenda");
    let textAreaObs = document.querySelector("#obs");
    let selectAbrangenciaCras = document.querySelector("#inputTipoCras");
    let hiddenOperacao = document.querySelector("#operacao");
    let hiddenIdBeneficiario = document.querySelector("#id_beneficiario");

    if(object === undefined || object === null) {
        console.error("Impossivel carregar dados no modal, dados indefinidos object = " + object);
    }else{
        hiddenIdBeneficiario.value = object.id;
        inputPrimeiroNome.value = object.primeiro_nome;
        inputUltimoNome.value = object.ultimo_nome;
        inputCpf.value = object.cpf;
        inputFoneRequired.value = object.celular_required;
        inputFoneOpcional.value = object.celular_opcional;
        inputCep.value = object.cep;
        inputEmail.value = object.email;
        inputEndereco.value = object.endereco;
        inputComplemento.value = object.complemento_ende;
        inputCidade.value = object.cidade;
        inputBairro.value = object.bairro;
        let optionIndex = -1;
        let strValueEstado = object.uf;
        for (let index = 0; index < selectValuesEstado.length; index++) {
            if(selectValuesEstado[index] === strValueEstado.toLowerCase()) {
                optionIndex = index;
            }
        }
        if(optionIndex != -1){
          let optionNovoElemento = document.createElement("option");
          optionNovoElemento.value = object.uf;
          optionNovoElemento.text = object.uf;
          optionNovoElemento.selected = true;
          selectEstado.remove(optionIndex);
          selectEstado.add(optionNovoElemento);
        }
        inputNis.value = object.nis;
        inputQtdPessoasHome.value = object.qtd_pessoas_home;
        inputRenda.value = object.renda;
        hiddenOperacao.value = "alteracao";
        //textAreaObs.textContent = object.obs;
        //selectAbrangenciaCras.value = object.abrangencia_cras;
        let optionIndexAbrangencia = -1;
        for (let index = 0; index < selectValuesAbrangenciaCras.length; index++) {
            if(selectValuesAbrangenciaCras[index] === object.abrangencia_cras) {
                optionIndexAbrangencia = index;
            }
        }
        if(optionIndexAbrangencia != -1) {
            let optionNovoElemento = document.createElement("option");
            optionNovoElemento.value = object.abrangencia_cras;
            optionNovoElemento.text = object.abrangencia_cras;
            optionNovoElemento.selected = true;
            selectAbrangenciaCras.remove(optionIndexAbrangencia);
            selectAbrangenciaCras.add(optionNovoElemento);
        }
    }
}






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