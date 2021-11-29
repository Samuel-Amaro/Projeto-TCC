function mostraModalInformation() {
    let elementoModal = document.querySelector("#modalInfoBeneficios");
    let objectBoostrap = new bootstrap.Modal(elementoModal);
    objectBoostrap.show();
}

function mostraModalAlterarBeneficio() {
    let elementoModal = document.querySelector("#modalAlterarBeneficio");
    let objectBoostrap = new bootstrap.Modal(elementoModal);
    objectBoostrap.show();
}

function carregaDadosModalInfo(data) {
    let nomeBeneficio = document.querySelector(".nome-beneficio");
    let formaAquisicaoBenef = document.querySelector(".forma-aqu-beneficio");
    let qtdMinimaBenef = document.querySelector(".qtd-minima-beneficio");
    let qtdMaximaBenef = document.querySelector(".qtd-maxima-beneficio");
    let dataHoraBeneficio = document.querySelector(".data-hora-beneficio");
    let descricaoBeneficio = document.querySelector(".descricao-beneficio");
    let categoriaBeneficio = document.querySelector(".categoria-beneficio");
    let nomeFornecedorDoador = document.querySelector(".nome-fornecedor-doador-beneficio");
    let cpfCpnjFornecedorDoador = document.querySelector(".cpf-cnpj-fornecedor-doador-beneficio");
    let identificacaoFornecedorDoador = document.querySelector(".identificacao-fornecedor-doador");
    let tipoPessoaFornecedorDoador = document.querySelector(".tipo-pessoa-fornecedor-doador");
    let emailFornecedorDoador = document.querySelector(".email-fornecedor-doador");
    let saldo = document.querySelector(".saldo-beneficio");
    nomeBeneficio.textContent = data.nome_beneficio;
    formaAquisicaoBenef.textContent = data.forma_aquisicao_beneficio;
    qtdMinimaBenef.textContent = data.quantidade_minima_beneficio;
    qtdMaximaBenef.textContent = data.quantidade_maxima_beneficio;
    dataHoraBeneficio.textContent = formataDataHora(data.data_hora_beneficio);
    descricaoBeneficio.textContent = data.descricao_beneficio;
    categoriaBeneficio.textContent = data.nome_categoria_beneficio;
    nomeFornecedorDoador.textContent = data.nome_fornecedor_doador;
    if(data.cpf_fornecedor_doador === null || data.cpf_fornecedor_doador === '') {
       cpfCpnjFornecedorDoador.textContent = data.cnpj_fornecedor_doador; 
    }else{
        cpfCpnjFornecedorDoador.textContent = data.cpf_fornecedor_doador; 
    }
    identificacaoFornecedorDoador.textContent = data.identificacao_fornecedor_doador;
    tipoPessoaFornecedorDoador.textContent = data.tipo_pessoa_fornecedor_doador;
    emailFornecedorDoador.textContent = data.email_fornecedor_doador;
    saldo.textContent = data.saldo;
}

function carregaDadosModalAlterar(data) {
    let qtdMinima = document.querySelector("#qtdMinima");
    let qtdMaxima = document.querySelector("#qtdMaxima");
    let qtd = document.querySelector("#quantidade");
    let idBeneficio = document.querySelector("#id_beneficio");
    let operacao = document.querySelector("#operacao");
    qtdMinima.value = data.quantidade_minima_beneficio;
    qtdMaxima.value = data.quantidade_maxima_beneficio;
    idBeneficio.value = data.id_beneficio;
    operacao.value = "ALTERAR";
    qtdMinima.setAttribute("min", "0");
    qtdMaxima.setAttribute("min", "0");
    qtd.setAttribute("min", qtdMinima.value);
    qtd.setAttribute("max", qtdMaxima.value);
}

function obterDadosModalAlterar() {
    let qtdMinima = document.querySelector("#qtdMinima").value; //number
    let qtdMaxima = document.querySelector("#qtdMaxima").value; //number
    let qtd = document.querySelector("#quantidade").value; //number
    let idBeneficio = document.querySelector("#id_beneficio").value; //number
    let operacao = document.querySelector("#operacao").value; //text
    let unidadeMedida = document.querySelector("#um").value; //number
    let qtdMedida = document.querySelector("#qtdMedida").value; //number
    let descricao = document.querySelector("#descricao").value; //text
}

function validaDadosQuantidadeMinMax(qtdMinima, qtdMaxima) {
    //se o dado for numero
    if(Number.isInteger(qtdMinima) && Number.isInteger(qtdMaxima)) {
       if((qtdMinima > 0 && qtdMinima < qtdMaxima) && (qtdMaxima > 0 && qtdMaxima > qtdMinima)) {
          return true;
       }else{
          return false;  
       } 
    }//se for texto
    else{
        return false;
    }
}

function validaDadosModalQtd(qtd, qtdMinima, qtdMaxima) {
    //se o dado for numero
    if(Number.isInteger(qtd)) {
        if(qtd >= qtdMinima && qtd <= qtdMaxima) {
           return true;
        }else{
           return false;  
        } 
    }//se for texto
    else{
         return false;
    }
}


function formataDataHora(dataHoraString) {
    let d = new Date(dataHoraString);
    let dia = d.getDate();
    let mes = d.getMonth() + 1; //porque começa em 0 janeiro
    let ano = d.getFullYear();
    let hora = d.getHours();
    let minuto = d.getMinutes();
    let segundos = d.getSeconds();
    return `${dia}/${mes}/${ano} ${hora}:${minuto}:${segundos}`;
}

function mostraModalTimelineMovimentacoes() {
    let elementoModal = document.querySelector("#modalTimelineMovimentacoes");
    let objectBoostrap = new bootstrap.Modal(elementoModal);
    objectBoostrap.show();
}

function makeRequestDadosTimeline(url, idBeneficio, operacao, nomeBeneficio) {
    let httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = alertsContents;
    httpRequest.open("POST", url, true);
    try {
        httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
        httpRequest.send("id_beneficio=" + encodeURIComponent(idBeneficio) + "&operacao=" + encodeURIComponent(operacao));   
    } catch (error) {
        console.error(error.name);
        console.error(error.message);
    }
    function alertsContents() {
        if(httpRequest.readyState === 4) {
            if(httpRequest.status === 200) {
                try {
                    let httpResponse = JSON.parse(httpRequest.responseText);  
                    //console.log(httpResponse.dados);
                    if(Array.isArray(httpResponse.dados)) {
                        carregaDadosTimeline(httpResponse.dados, nomeBeneficio); 
                    }else{
                        //limpa movimentações antigas se o modal tiver aparecido antes
                        let ul = document.querySelector(".timeline");
                        //para não acumular movimentações de beneficios diferentes em um mesmo modal
                        let liExistentes = document.querySelectorAll(".item-timeline");
                        //console.log(liExistentes);
                        if(liExistentes.length > 0) {
                            liExistentes.forEach(element => {
                                ul.removeChild(element);  
                            }); 
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: httpResponse.response
                        });
                    }
                } catch (error) {
                    console.error(error.message);
                    console.error(error.name);
                    console.error("HTTP RESPONSE: " + httpRequest.responseText);
                }
            }
        }
    }
}

function carregaDadosTimeline(array, nomeBeneficio) {
    let ul = document.querySelector(".timeline");
    //para não acumular movimentações de beneficios diferentes em um mesmo modal
    let liExistentes = document.querySelectorAll(".item-timeline");
    //console.log(liExistentes);
    if(liExistentes.length > 0) {
        liExistentes.forEach(element => {
            ul.removeChild(element);  
        }); 
    }
    let h5 = document.querySelector(".titulo-beneficio");
    //let textH5 = document.createTextNode(nomeBeneficio);
    h5.textContent = nomeBeneficio;
    //itera sobre cada item do array que e um objeto
    array.forEach(object => {
        //console.log(object);
        let li = document.createElement("li");
        li.setAttribute("class", "item-timeline");
        let a = document.querySelector("a");
        a.textContent = formataDataHora(object.data_hora_ultima_mov);
        a.href = "#";
        a.setAttribute("class", "float-right");
        let divPai = document.createElement("div");
        //itera sobre as propriedades do objeto
        for(const propriedade in object) {
            if((propriedade >= 0 && propriedade <= 4) || propriedade === "data_hora_ultima_mov") {
                //faz nada propriedade de numero não interessa 
            }else{
                //propriedade de texto  
                let divFilha = document.createElement("div");
                let b = document.createElement("b");
                let span = document.createElement("span");
                let hr = document.createElement("hr");
                hr.style.margin = "4px";
                if(propriedade === "quantidade_mov") {
                b.textContent = "Quantidade movimentada: "; 
                span.textContent =  object["quantidade_mov"];
                }else if(propriedade === "sigla") {
                    b.textContent = "Unidade de medida: "; 
                    span.textContent =  object["sigla"];
                }else if(propriedade === "tipo_mov") {
                    b.textContent = "Tipo movimentação: ";
                    if(object[propriedade] === 0) {
                    span.textContent = "Saida"; 
                    }else{
                    span.textContent = "Entrada";
                    }
                }else if(propriedade === "quantidade_por_medida") {
                    b.textContent = "Quantidade por medida: ";
                    span.textContent = object[propriedade];
                }
                divFilha.appendChild(b);
                divFilha.appendChild(span);
                divFilha.appendChild(hr);
                divPai.appendChild(divFilha);  
            }
        }
        li.appendChild(a);
        li.appendChild(divPai);
        ul.appendChild(li);
    });   
}