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
        "responsive": true,
        //'Bfrtip'
        "buttons" : ['copy', 'excel', 'pdf', 'print'],
        "scrollX": true,
        "paging": true,
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
            "defaultContent": "<button type=\"button\" class=\"btn btn-primary btn-alterar-benef\" data-toggle=\"modal\" data-target=\"#exampleModal\" data-whatever=\"@mdo\"><i class=\"fas fa-user-edit\"></i></button> <button type=\"button\" class=\"btn btn-primary btn-excluir-beneficiario\"><i class=\"fas fa-user-times\"></i></button>"
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
    //ao clicar no btn de excluir, vai mostrar modal de exlcuir
    $('#dataTablesBeneficiarios tbody').on('click', '.btn-excluir-beneficiario', function(){
        let data = tabela.row($(this).parents('tr')).data();
        modalExcluir(data.id);
        //console.log(data); //return um object 
        //alert(data.cpf +" seu nome e: "+ data.primeiro_nome + data.ultimo_nome);
    });
});

/**
 * esta função carrega o modal de excluir um beneficiario
 */
function modalExcluir(idBeneficiario) {
    Swal.fire({
        title: 'Realmente deseja deletar este beneficiário?',
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: 'Sim',
        denyButtonText: 'Não',
        customClass: {
          actions: 'my-actions',
          cancelButton: 'order-1 right-gap',
          confirmButton: 'order-2',
          denyButton: 'order-3',
        }
    }).then((result) => {
        //sim deseja deletar
        if (result.isConfirmed) {
            makeRequestDeletarBeneficiario("../controller/ControllerBeneficiario.php", idBeneficiario);
        } else if (result.isDenied) {
            //não deseja deletar  
            Swal.fire('Beneficiário não sera deletado', '', 'info');
        }
    });
}


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
        inputFoneRequired.value = aplicaMascaraTelefone(object.celular_required);
        inputFoneOpcional.value = aplicaMascaraTelefone(object.celular_opcional);
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
        inputNis.value = aplicaMascaraNumeroNis(object.nis);
        inputQtdPessoasHome.value = object.qtd_pessoas_home;
        inputRenda.value = tiraCifraoRenda(object.renda);
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


/**
 * esta funçaõ tira o cifrao da renda
 * @param {*} rendaComCifrao 
 */
 function tiraCifraoRenda(rendaComCifrao) {
    let rendaFormatada = rendaComCifrao;
    let cifrao = rendaFormatada.substr(0, 3); //R$ 
    let rendaPura = rendaFormatada.substr(3); //renda total
    console.log(rendaPura);
    return rendaPura;
}

/**
 * esta função aplica uma mascara de formatação no telefone
 * @param {} telefoneSemFormatacao 
 */
function aplicaMascaraTelefone(telefoneSemFormatacao) { 
    if(telefoneSemFormatacao == "") {
        return "";     
    }else{
        let telefonePuro = telefoneSemFormatacao;
        let parte1 = "(" + telefonePuro.substr(0, 2) + ") "; //(##) 
        let parte2 = telefonePuro.substr(2, 5); //#####
        let parte3 = "-" + telefonePuro.substr(7, 4); //-####
        //console.log(parte1 + parte2 + parte3);
        return parte1 + parte2 + parte3;
    }
}

/**
 * esta função aplica uma mascara de formatação no campo numero do nis
 * @param {*} nisSemFormatacao 
 */
function aplicaMascaraNumeroNis(nisSemFormatacao) {
    return nisSemFormatacao.substr(0, 3) + "." + nisSemFormatacao.substr(3, 3) + "." + nisSemFormatacao.substr(6, 3) + "-" + nisSemFormatacao.substr(9, 2);
}

/**
 * esta função faz uma solicitação por ajax para o back ende excluir um beneficiario
 * @param {*} url 
 * @param {*} idBeneficiario 
 */
function makeRequestDeletarBeneficiario(url, idBeneficiario) { 
    let httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = alertsContents;
    httpRequest.open("POST", url, true);
    httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    httpRequest.send('idBeneficiario=' + encodeURIComponent(idBeneficiario) + '&operacao=' + encodeURIComponent('deletar'));
    function alertsContents() {
        if(httpRequest.readyState === 4) {
            if(httpRequest.status === 200) {
                try {
                    let httpResponse = JSON.parse(httpRequest.responseText);
                    Swal.fire(
                        'Exclusão de beneficiário',
                        httpResponse.computedString,
                        'success'
                    );
                } catch (error) {
                    Swal.fire(
                        'Exclusão de beneficiário',
                        'Beneficiário não foi excluido, tivemos um erro interno, tente essa ação novamente, mais tarde!',
                        'error'
                    );
                    console.error(error.message);
                    console.error(error.name);
                    console.error("HTTP RESPONSE: " + httpRequest.responseText);
                }
            }else{
                //return 0;
            }
        }else{
                //alert("Ajax operação assincrona não concluida! onreadystatechange: " + httpRequest.readyState);
                //operação assincrona ajax não chegou no estagio de concluida
                //return 0;
        }
    }
}
