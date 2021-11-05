let camposModalAlterar = ["#nome-fornecedor-doador", "#descricao", "#inputEndereco", "#inputBairro", "#inputCidade", "#inputEstado", "#telefone01", "#telefone02"];

//formulario de alterar for submetido
let submit = document.querySelector(".form-fornecedor-doador-alterar");
submit.addEventListener("submit", function(event) {
    let camposInvalidosModal = camposInvalidosAlterar(camposModalAlterar);
    if(camposInvalidosModal.length === 0) {
        camposModalAlterar.forEach(element => {
            setaEstiloValidacaoCampo(element, ".is-valid");
        });
        if(makeRequestAlterarFornecedorDoador("../controller/ControllerFornecedoresDoadores.php", obterDadosModalAlterar())) {
            //deu certo faz nada.
            tabela.ajax.reload();
        }else{
            //deu erro
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Alguns campos não foram preenchidos, corretamente, por favor, preencha os novamente, da forma correta!',
                footer: '<a href="#">Clique aqui se precisa de ajuda!</a>'
            });
            //limpaCamposModalAlterar();
            event.preventDefault();
        }
    }else{
        camposInvalidosModal.forEach(element => {
            setaEstiloValidacaoCampo(element, ".is-invalid");  
        });
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Alguns campos não foram preenchidos, corretamente, por favor, preencha os novamente, da forma correta!',
            footer: '<a href="#">Clique aqui se precisa de ajuda!</a>'
        });
        event.preventDefault();
    }
});


/**
 * * Esta Função valida os campos de uma formulario.
 * @param {*} arraySelectorsCss 
 * @returns array - com os campos invalidos
*/
function camposInvalidosAlterar(arraySelectorsCss) {
    let camposInvalidos = [];
    let camposValidos = [];
    arraySelectorsCss.forEach(element => {
        if(element == "#telefone01") {
            //campo com mascara de telefone celular
            let telefoneCelular = document.querySelector("#telefone01").value;
            let telefoneCelularPuro = tiraMascaraTel(telefoneCelular, "celular");
            if(telefoneCelularPuro.length < 11) {
               camposInvalidos.push("#telefone01"); 
            }else{
                //camposArray.push("#telefone01");
            }
        }else if(element == "#telefone02") {
            //campo com mascara de telefone celular
            let telefoneFixo = document.querySelector("#telefone02").value;
            let telefoneFixoPuro = tiraMascaraTel(telefoneFixo, "fixo");
            if(telefoneFixoPuro.length < 10) {
               camposInvalidos.push("#telefone02"); 
            }else{
                //camposArray.push("#telefone02");
            }
        }else{
            let elementHtml = document.querySelector(element).value;
            if(elementHtml === "" || elementHtml === " " || elementHtml === "SELECIONE") {
                camposInvalidos.push(element); 
            }else{
                camposValidos.push(element);
            }    
        }
    });
    return camposInvalidos;  
}

/**
 * * Esta Função Mostra o modal
 */
 function mostraModalAlterarFornecedorDoador() {
    let elementoModal = document.querySelector("#modalFornecedorDoador");
    let objectBoostrap = new bootstrap.Modal(elementoModal);
    objectBoostrap.show();
}

/**
 * * Esta função vai carregar, e preenche os dados no modal.
 * @param {*} fornecedorDoador 
 */
function carregaDadosModalFornecedorDoador(fornecedorDoador) {
    //objeto vazio não possui valores
    if(Object.values(fornecedorDoador).length === 0) {
        console.log("Objetc fornecedor ou doador esta vazio!");
    }else{
        let optionsIdentificacao = ["SELECIONE", "DOADOR", "FORNECEDOR"];
        let optionsTipoPessoa = ["FISICA", "JURIDICA"];
        let optionsEstados = ["AC", "AL", "DF", "GO", "AP", "AM", "BA", "CE", "ES", "MA", "MT", "MS", "MG", "PB", "PR", "PE", "PI", "RJ", "RN", "RS", "RO", "RR", "SC", "SP", "SE", "TO"];
        document.querySelector("#id_forn_doado").value = fornecedorDoador.id;
        document.querySelector("#nome-fornecedor-doador").value = fornecedorDoador.nome;
        document.querySelector("#descricao").value = fornecedorDoador.descricao;
        for (let index = 0; index < optionsIdentificacao.length; index++) {
            if(fornecedorDoador.identificacao === optionsIdentificacao[index]) { 
                let optionNovoElemento = document.createElement("option");
                optionNovoElemento.value = optionsIdentificacao[index];
                optionNovoElemento.text = optionsIdentificacao[index];
                optionNovoElemento.selected = true;
                document.querySelector("#tipoIdentificacao").remove(index);
                document.querySelector("#tipoIdentificacao").add(optionNovoElemento);
                document.querySelector("#tipoIdentificacao").setAttribute("disabled", "true");
            }else{
                //faz nada
            }        
        }
        for (let index = 0; index < optionsTipoPessoa.length; index++) {
            if(fornecedorDoador.tipo_pessoa === optionsTipoPessoa[index]) {
                let optionNovoElemento = document.createElement("option");
                optionNovoElemento.value = optionsTipoPessoa[index];
                optionNovoElemento.text = optionsTipoPessoa[index];
                optionNovoElemento.selected = true;
                document.querySelector("#tipoPessoa").remove(index);
                document.querySelector("#tipoPessoa").add(optionNovoElemento);
                document.querySelector("#tipoPessoa").setAttribute("disabled", "true");
                let stsSelector = optionsTipoPessoa[index] === "JURIDICA" ? "cnpj" : "cpf";
                let tipo = document.querySelector(".container-" + stsSelector);
                tipo.style.display = "block";
                document.querySelector("#" + stsSelector).value = optionsTipoPessoa[index] === "JURIDICA" ? fornecedorDoador.cnpj : fornecedorDoador.cpf;
                document.querySelector("#" + stsSelector).setAttribute("readonly", "readonly");
            }else{
                //faz nada
            }
        }
        document.querySelector("#inputCep").value = fornecedorDoador.cep;
        document.querySelector("#inputEndereco").value = fornecedorDoador.endereco;
        document.querySelector("#inputComplemento").value = fornecedorDoador.complemento;
        document.querySelector("#inputBairro").value = fornecedorDoador.bairro;
        document.querySelector("#inputCidade").value = fornecedorDoador.cidade;
        for (let index = 0; index < optionsEstados.length; index++) {
            if(fornecedorDoador.uf === optionsEstados[index]) {
                let optionNovoElemento = document.createElement("option");
                optionNovoElemento.value = optionsEstados[index];
                optionNovoElemento.text = optionsEstados[index];
                optionNovoElemento.selected = true;
                document.querySelector("#inputEstado").remove(index);
                document.querySelector("#inputEstado").add(optionNovoElemento);
            }else{
                //faz nada
            }
        }
        document.querySelector("#telefone01").value = fornecedorDoador.telefone_celular;
        document.querySelector("#telefone02").value = fornecedorDoador.telefone_fixo;
        document.querySelector("#email").value = fornecedorDoador.email;
        document.querySelector("#email").setAttribute("readonly", "readonly");
    }
        //document.querySelector("#tipoIdentificacao");
}

/**
 * * Esta função limpa campos do modal alterar
 */
function limpaCamposModalAlterar() {
    let nome = document.querySelector(".nome-fornecedor-doador");
    let descricao = document.querySelector("#descricao");
    let identificacao = document.querySelector("#tipoIdentificacao");
    let tipoPessoa = document.querySelector("#tipoPessoa");
    let cep = document.querySelector("#inputCep");
    let endereco = document.querySelector("#inputEndereco");
    let complemento = document.querySelector("#inputComplemento");
    let bairro =  document.querySelector("#inputBairro");
    let cidade  = document.querySelector("#inputCidade");
    let estado = document.querySelector("#inputEstado");
    let telefoneCelular = document.querySelector("#telefone01");
    let telefoneFixo = document.querySelector("#telefone02");
    let email = document.querySelector("#email");
    let cpf = '';
    let cnpj = '';
    let arraySelectorFeedbacks = [".feedback-nome", ".feedback-descricao", ".feedback-endereco", ".feedback-complemento", ".feedback-bairro", ".feedback-cidade", ".feedback-email"];
    arraySelectorFeedbacks.forEach(element => {
        let ele = document.querySelector(element);
        ele.textContent = '';
    });
    let arraySelector = [".nome-fornecedor-doador", "#descricao", "#tipoIdentificacao", "#tipoPessoa", "#inputCep", "#inputEndereco", "#inputComplemento", "#inputBairro", "#inputCidade", "#inputEstado" ,"#telefone01", "#telefone02", "#email"];
    if(tipoPessoa.value === "FISICA") {
       cpf = document.querySelector("#cpf");
       let tipo = document.querySelector(".container-cpf");
       tipo.style.display = "none";
       arraySelector.push("#cpf");
       cpf.value = '';         
    }else{
       cnpj = document.querySelector("#cnpj");
       arraySelector.push("#cnpj");
       let tipo = document.querySelector(".container-cnpj");
       tipo.style.display = "none";
       cnpj.value = '';
    }
    nome.value = '';
    descricao.value = '';
    identificacao.options.item(0).selected = true;
    tipoPessoa.options.item(0).selected = true;
    cep.value = '';
    endereco.value = '';
    complemento.value = '';
    bairro.value = '';
    cidade.value = '';
    estado.options.item(0).selected = true;
    telefoneCelular.value = '';
    telefoneFixo.value = '';
    email.value = '';
    //faz os atributos de endereço serem editaveis
    endereco.removeAttribute("readonly");
    complemento.removeAttribute("readonly");
    bairro.removeAttribute("readonly");
    cidade.removeAttribute("readonly");
    estado.removeAttribute("disabled");
    //tira class css dos elementos
    arraySelector.forEach(element => {
        setaEstiloValidacaoCampo(element, "remover");
    });
}

/**
 * * Esta função faz uma solicitação por ajax para alterar os dados de um fornecedor ou doador.
 * @param {*} url 
 * @param {*} fornecedorDoador 
 */
function makeRequestAlterarFornecedorDoador(url, fornecedorDoador = {}) { 
    let httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = alertsContents;
    httpRequest.open("POST", url, true);
    httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    if(fornecedorDoador.tipoPessoa === "FISICA") {
        //puxa cpf
        httpRequest.send('id=' + encodeURIComponent(fornecedorDoador.id) + '&nome=' + encodeURIComponent(fornecedorDoador.nome) + '&descricao=' + encodeURIComponent(fornecedorDoador.descricao) + '&tipoPessoa=' + encodeURIComponent(fornecedorDoador.tipoPessoa) + '&identificacao=' + encodeURIComponent(fornecedorDoador.identificacao) + '&cpf=' + encodeURIComponent(fornecedorDoador.cpf) + '&cep=' + encodeURIComponent(fornecedorDoador.cep) + '&endereco=' + encodeURIComponent(fornecedorDoador.endereco) + '&complemento=' + encodeURIComponent(fornecedorDoador.complemento) + '&bairro=' + encodeURIComponent(fornecedorDoador.bairro) + '&cidade=' + encodeURIComponent(fornecedorDoador.cidade) + '&estado=' + encodeURIComponent(fornecedorDoador.estado) + '&telefoneCelular=' + encodeURIComponent(fornecedorDoador.telefoneCelular) + '&telefoneFixo=' + encodeURIComponent(fornecedorDoador.telefoneFixo) + '&email=' + encodeURIComponent(fornecedorDoador.email) + '&operacao=' + encodeURIComponent("alterar"));
    }else{
        //puxa cnpj
        httpRequest.send('id=' + encodeURIComponent(fornecedorDoador.id) + '&nome=' + encodeURIComponent(fornecedorDoador.nome) + '&descricao=' + encodeURIComponent(fornecedorDoador.descricao) + '&tipoPessoa=' + encodeURIComponent(fornecedorDoador.tipoPessoa) + '&identificacao=' + encodeURIComponent(fornecedorDoador.identificacao) + '&cnpj=' + encodeURIComponent(fornecedorDoador.cnpj) + '&cep=' + encodeURIComponent(fornecedorDoador.cep) + '&endereco=' + encodeURIComponent(fornecedorDoador.endereco) + '&complemento=' + encodeURIComponent(fornecedorDoador.complemento) + '&bairro=' + encodeURIComponent(fornecedorDoador.bairro) + '&cidade=' + encodeURIComponent(fornecedorDoador.cidade) + '&estado=' + encodeURIComponent(fornecedorDoador.estado) + '&telefoneCelular=' + encodeURIComponent(fornecedorDoador.telefoneCelular) + '&telefoneFixo=' + encodeURIComponent(fornecedorDoador.telefoneFixo) + '&email=' + encodeURIComponent(fornecedorDoador.email) + '&operacao=' + encodeURIComponent("alterar"));
    }
    function alertsContents() {
        if(httpRequest.readyState === 4) {
            if(httpRequest.status === 200) {
                try {
                    let httpResponse = JSON.parse(httpRequest.responseText);  
                    Swal.fire(
                        'Obaa...',
                        httpResponse.response,
                        'success'
                    );
                    tabela.ajax.reload();
                    return 1;
                } catch (error) {
                    console.error(error.message);
                    console.error(error.name);
                    console.error("HTTP RESPONSE: " + httpRequest.responseText);
                    return 0;
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

/**
 * * Esta função obtem dados do modal e retorna um objeto
 */
function obterDadosModalAlterar() {
    let p = document.querySelector("#tipoPessoa").value;
    if(p === "FISICA") {
        let dados = {
            "id" : document.querySelector("#id_forn_doado").value,
            "nome" : document.querySelector(".nome-fornecedor-doador").value,
            "descricao" : document.querySelector("#descricao").value,
            "tipoPessoa" : document.querySelector("#tipoPessoa").value,
            "identificacao" :  document.querySelector("#tipoIdentificacao").value,
            "cpf" : tiraMascaraCPF(document.querySelector("#cpf").value),
            "cep" : document.querySelector("#inputCep").value,
            "endereco" : document.querySelector("#inputEndereco").value,
            "complemento" : document.querySelector("#inputComplemento").value,
            "bairro" : document.querySelector("#inputBairro").value,
            "cidade" : document.querySelector("#inputCidade").value,
            "estado" : document.querySelector("#inputEstado").value,
            "telefoneCelular" : tiraMascaraTel(document.querySelector("#telefone01").value, "celular"),
            "telefoneFixo" : tiraMascaraTel(document.querySelector("#telefone02").value, "fixo"),
            "email" : document.querySelector("#email").value,
            "operacao" : document.querySelector("#operacao").value
       };
       return dados;
    }else{
        let dados = {
            "id" : document.querySelector("#id_forn_doado").value,
            "nome" : document.querySelector(".nome-fornecedor-doador").value,
            "descricao" : document.querySelector("#descricao").value,
            "tipoPessoa" : document.querySelector("#tipoPessoa").value,
            "identificacao" :  document.querySelector("#tipoIdentificacao").value,
            "cnpj" : tiraMascaraCNPJ(document.querySelector("#cnpj").value),
            "cep" : document.querySelector("#inputCep").value,
            "endereco" : document.querySelector("#inputEndereco").value,
            "complemento" : document.querySelector("#inputComplemento").value,
            "bairro" : document.querySelector("#inputBairro").value,
            "cidade" : document.querySelector("#inputCidade").value,
            "estado" : document.querySelector("#inputEstado").value,
            "telefoneCelular" : tiraMascaraTel(document.querySelector("#telefone01").value, "celular"),
            "telefoneFixo" : tiraMascaraTel(document.querySelector("#telefone02").value, "fixo"),
            "email" : document.querySelector("#email").value,
            "operacao" : document.querySelector("#operacao").value
       };
       return dados;
    }
}