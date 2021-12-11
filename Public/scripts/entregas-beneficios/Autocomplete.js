/*AUTCOMPLETE PARA O BENEFICIARIO*/
$(".autocomplete-beneficiario").autocomplete({
    //Object request, function response(Object dados)
    source: function(request, response) {
        //busca dados por ajax, por nome do beneficiario
        //console.log(request.term);
        $.ajax({
            url : "../controller/ControllerEntregaBeneficios.php",
            data : {
                operacao : "busca-beneficiario",
                termo : request.term
            },
            type: "POST",
            dataType : "json",
        }).done(function(json) {
            try {    
                let beneficiarios = trataResponse(json);
                response(beneficiarios);
            } catch (error) {
                console.error(error.message);
                console.error(error.name);
            }
        }).fail(function(xhr, status, errorThrown) {
            console.log("Error: " + errorThrown);
            console.log("Status: " + status);
            console.dir(xhr); 
        });
    },//ao selecionar um item do autocomplete, preenche o form com os dados necessarios, passsando um array para função
    select : function(event, ui) {
        setaIdBeneficiario(ui.item.id);
    }
   //add o desc no item do autocomplete 
}).autocomplete("instance")._renderItem = function(ul, item) {
    return $("<li>").append("<div>" + item.label + "<br>" + item.desc + "</div>").appendTo(ul);
};

let listaBeneficiarios = [];

/**
 * * Esta função add os resultados trazidos da controller em um array para poder mandar para o autocomplete
 * @param {*} json 
 * @returns 
 */
function trataResponse(json) {
    let lista = [];
    //esvazia lista, apos ter realizado alguma pesquisa anterior
    for (let index = 0; index <= listaBeneficiarios.length; index++) {
        listaBeneficiarios.pop();
    }
    if(Array.isArray(json)) {
        json.forEach(element => { 
            listaBeneficiarios.push(element);  
        });
        return listaBeneficiarios; 
    }else{
        return json;
    }
}

function setaIdBeneficiario(id) {
    document.querySelector("#idBeneficiario").value = id;
}

/*AUTOCOMPLETE PARA O TIPO DE BENEFICIO*/
$(".autocomplete-tipo-beneficio").autocomplete({
    //Object request, function response(Object dados)
    source: function(request, response) {
        //busca dados por ajax, por nome do beneficiario
        //console.log(request.term);
        $.ajax({
            url : "../controller/ControllerTipoBeneficio.php",
            data : {
                operacao : "busca-tipo",
                termo : request.term
            },
            type: "POST",
            dataType : "json",
        }).done(function(json) {
            try {    
                let tipoBeneficios = trataResponse(json);
                response(tipoBeneficios);
            } catch (error) {
                console.error(error.message);
                console.error(error.name);
            }
        }).fail(function(xhr, status, errorThrown) {
            console.log("Error: " + errorThrown);
            console.log("Status: " + status);
            console.dir(xhr); 
        });
    },//ao selecionar um item do autocomplete, preenche o form com os dados necessarios, passsando um array para função
    select : function(event, ui) {
        setaIdTipoBeneficio(ui.item.id);
    }
   //add o desc no item do autocomplete 
}).autocomplete("instance")._renderItem = function(ul, item) {
    return $("<li>").append("<div>" + item.label + "<br>" + item.desc + "</div>").appendTo(ul);
};

let listaTipoBeneficios = [];

function trataResponseTipoBeneficio(json) {
    //esvazia lista, apos ter realizado alguma pesquisa anterior
    for (let index = 0; index <= listaTipoBeneficios.length; index++) {
        listaTipoBeneficios.pop();
    }
    if(Array.isArray(json)) {
        json.forEach(element => { 
            listaTipoBeneficios.push(element);  
        });
        return listaTipoBeneficios; 
    }else{
        return json;
    }
}

function setaIdTipoBeneficio(id) {
    document.querySelector("#idTipoBeneficio").value = id;
}
