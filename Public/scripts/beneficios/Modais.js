function mostraModalInformation() {
    let elementoModal = document.querySelector("#modalInfoBeneficios");
    let objectBoostrap = new bootstrap.Modal(elementoModal);
    objectBoostrap.show();
}

function carregaDadosModalInfo(data) {
    document.querySelector(".descricao-beneficio").textContent = data.descricao_beneficio;
    document.querySelector(".qtd-inicial-beneficio").textContent = data.quantidade_inicial_beneficio;
    document.querySelector(".data-hora-beneficio").textContent = formataDataHora(data.data_hora_insercao_beneficio);
    document.querySelector(".nome-fornecedor-doador-beneficio").textContent = data.nome_fornecedor_doador;
    document.querySelector(".identificacao-forn-doad-beneficio").textContent = data.identificacao_fornecedor_doador;
    document.querySelector(".tipo-pessoa-forn-doador").textContent = data.tipo_pessoa_fornecedor_doador;
    document.querySelector(".cpf-forn-doador").textContent = data.cpf_fornecedor_doador;
    document.querySelector(".cnpj-forn-doador").textContent = data.cnpj_fornecedor_doador;
    document.querySelector(".tipo-aquisica-beneficio").textContent = data.tipo_aquisicao;
    document.querySelector(".tipo-beneficio").textContent = data.nome_tipo_beneficio;
    document.querySelector(".um-beneficio").textContent = data.unidade_medida_beneficio;
    document.querySelector(".categoria-beneficio").textContent = data.nome_categoria;
    document.querySelector(".email-fornecedor-doador").textContent = data.email_fornecedor_doador;
}

function obterDadosModalAddMovimentacao() {
    let idBeneficio = document.querySelector("#id_beneficio").value; //number
    let operacao = document.querySelector("#operacao").value; //text
    let qtd = document.querySelector("#quantidade").value; //number
    let unidadeMedida = document.querySelector("#um").value; //select
    let qtdMedida = document.querySelector("#qtdMedida").value; //number
    let descricao = document.querySelector(".descricao").value; //text
    let movimentacao = document.querySelector("#tipoMovimentacao").value; //select
    let objMovimentacao = {};
    try {
        objMovimentacao = {
            "idBeneficio" : idBeneficio,
            "operacao" : operacao,
            "qtd" : new Number(qtd).valueOf(),
            "unidadeMedida" : unidadeMedida,
            "qtdMedida" : new Number(qtdMedida).valueOf(),
            "descricao" : descricao,
            "movimentacao" : movimentacao
        };
    } catch (error) {
        console.error(error.name);
        console.error(error.message);    
    }
    let arraySelector = ["#quantidade", "#unidadeMedida", "#qtdMedida", ".descricao", "#tipoMovimentacao"];
    let resultadoValidacao = validaValoresModal(arraySelector, objMovimentacao);
    if(resultadoValidacao.length === 0) {
        console.log(objMovimentacao);    
    }else{
        console.log("CAMPOS INVALIDOS = " + resultadoValidacao);
    }
}

function limpaModalAddMov() {
    document.querySelector("#quantidade").value = 0; //number
    document.querySelector("#id_beneficio").value = 0;//hidden
    document.querySelector("#operacao").value = ''; //text
    document.querySelector("#um").options.item(0).selected = true;//select    
    document.querySelector("#qtdMedida").value = 0; //number
    document.querySelector(".descricao").value = ''; //text
    document.querySelector("#tipoMovimentacao").options.item(0).selected = true; //select
}

function validaValoresModal(arraySelectorCSS, object) {
    let camposValidos = [];
    let camposInvalidos = [];
    arraySelectorCSS.forEach(element => {
        if(element === "#qtdMinima") {
            if((Number.isInteger(object.qtdMinima)) && (object.qtdMinima > 0 && object.qtdMinima < object.qtdMaxima)) {
                camposValidos.push("#qtdMinima");
            }else{
                camposInvalidos.push("#qtdMinima")
            }
        }else if(element === "#qtdMaxima") {
            if((Number.isInteger(object.qtdMaxima)) && (object.qtdMaxima > 0 && object.qtdMaxima > object.qtdMinima)) {
                camposValidos.push("#qtdMaxima");
            }else{
                camposInvalidos.push("#qtdMaxima")
            }
        }else if(element === "#qtd") {
            if((Number.isInteger(object.qtd)) && (object.qtd > 0 && object.qtd >= object.qtdMinima) && (object.qtd <= object.qtdMaxima)) {
                camposValidos.push("#qtd");
            }else{
                camposInvalidos.push("#qtd")
            }
        }else if(element === "#qtdMedida") {
            if(Number.isInteger(object.qtdMedida)) {
                camposValidos.push("#qtdMedida");
            }else{
                camposInvalidos.push("#qtdMedida")
            }
        }else if(element === ".descricao") {
            if(object.descricao.length === 0) {
               camposInvalidos.push(".descricao"); 
            }else{
                if(!object.descricao.trim() || object.descricao === '') {
                   camposInvalidos.push("#descricao"); 
                }else{
                   camposValidos.push("#descricao"); 
                }
            }
        }else if(element === "#tipoMovimentacao") {
            if(object.movimentacao === "SELECIONE") {
                camposInvalidos.push("#tipoMovimentacao");
            }else{
                camposValidos.push("#tipoMovimentacao");
            }
        }else if(element === "#unidadeMedida") {
            if(object.unidadeMedida === "SELECIONE") {
               camposInvalidos.push("#unidadeMedida"); 
            }else{
                camposValidos.push("#unidadeMedida");
            }
        }  
    }); 
    return camposInvalidos;
}

function formataDataHora(dataHoraString) {
    let d = new Date(dataHoraString);
    let dia = d.getDate();
    let mes = d.getMonth() + 1; //porque come??a em 0 janeiro
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
                        //limpa movimenta????es antigas se o modal tiver aparecido antes
                        let ul = document.querySelector(".timeline");
                        //para n??o acumular movimenta????es de beneficios diferentes em um mesmo modal
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
    //para n??o acumular movimenta????es de beneficios diferentes em um mesmo modal
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
        a.textContent = formataDataHora(object.data_hora_mov);
        a.href = "#";
        a.setAttribute("class", "float-right");
        let divPai = document.createElement("div");
        //itera sobre as propriedades do objeto
        for(const propriedade in object) {
            if((propriedade >= 0 && propriedade <= 6) || propriedade === "data_hora_mov") {
                //faz nada propriedade de numero n??o interessa 
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
                }else if(propriedade === "tipo_movimentacao") {
                    b.textContent = "Tipo movimenta????o: ";
                    if(object[propriedade] === 0) {
                        span.textContent = "Saida"; 
                    }else{
                        span.textContent = "Entrada";
                    }
                }else if(propriedade === "nome") {
                    b.textContent = "Nome categoria: ";
                    span.textContent = object[propriedade];
                }else if(propriedade === "descricao") {
                    b.textContent = "Descri????o Movimenta????o: ";
                    span.textContent = object[propriedade];
                }else if(propriedade === "nome_tipo") {
                    b.textContent = "Tipo benef??cio: ";
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