//O evento DOMContentLoaded é acionado quando todo o HTML foi completamente carregado e analisado, sem aguardar pelo CSS, imagens, e subframes para encerrar o carregamento. Um evento muito diferente - load - deve ser usado apenas para detectar uma página completamente carregada.
//window
//REFERENCIA AO PLUGIN
//https://github.com/fiduswriter/Simple-DataTables/wiki
//var dataTable;
window.addEventListener('DOMContentLoaded', function() {
    let tabelaDom = document.querySelector('#datatablesSimple');
    dataTable = new simpleDatatables.DataTable(tabelaDom);
});


//quando pagina estiver com o DOM TOTALMENTE CARREGADO
window.onload = function() {
    makeRequest('../controller/ControllerUsuario.php');
}


function makeRequest(url) { 

    let httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = alertsContents;
    httpRequest.open('POST', url, true);
    httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    httpRequest.send('&operacao=listar');

    function alertsContents() {
        if(httpRequest.readyState === 4) {
            if(httpRequest.status === 200) {
                try {
                    //let httpResponse = JSON.parse(httpRequest.responseText);  
                    //console.log(httpResponse);
                    //importa dados do banco de dados para tabela, na view, em formato json
                    dataTable.import({
                        type: "json", 
                        data: httpRequest.responseText
                    });
                    //dataTable.insert(httpResponse);
                    //carregaDadosTabela(httpResponse);
                    //return 1;
                } catch (error) {
                    console.error(error.message);
                    console.error(error.name);
                    console.error("HTTP RESPONSE: " + httpRequest.responseText);
                    //return 0;
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


function carregaDadosTabela(arrayData) {
    let tbody = document.querySelector('tbody');
    arrayData.forEach(element => {
            let tr = document.createElement('tr');
            let tdId = document.createElement('td');
            tdId.textContent = element.id_usuario;
            let tdCpf = document.createElement('td');
            tdCpf.textContent = element.cpf_usuario;
            let tdCelular = document.createElement('td');
            tdCelular.textContent = element.celular_usuario;
            let tdEmail = document.createElement('td');
            tdEmail.textContent = element.email_usuario;
            let tdCargo = document.createElement('td');
            tdCargo.textContent = element.cargo_usuario;
            let tdTipo = document.createElement('td');
            tdTipo.textContent = element.tipo_usuario;
            //let tdDataCadastro = document.createElement('td');
            //tdDataCadastro = element.data_cadastro_usuario;
            let tdNome = document.createElement('td');
            tdNome.textContent = element.nome_usuario;
            tr.append(tdId);
            tr.append(tdCpf);
            tr.append(tdCelular);
            tr.append(tdEmail);
            tr.append(tdCargo);
            tr.append(tdTipo);
            //tr.append(tdDataCadastro);
            tr.append(tdNome);
            tbody.appendChild(tr);
    });
}


//Baixar tabela do usuario
let button = document.querySelector('.baixa-tabela');
let selectValue = document.querySelector('#tipo-file').value;
let alertDanger  = document.querySelector('.alert-danger');

button.addEventListener('click', function(event) {
    switch (selectValue) {
        case "sql":
            dataTable.export({
                type: "sql",
                tableName: "table_usuario"
            });
            console.log(selectValue);
            break;
        case "json":
            dataTable.export({
                type: "json"
            });
            console.log(selectValue);
            break;    
        case "csv":
            dataTable.export({
                type: "csv",
                filename: "usuarios"
            });
            console.log(selectValue);
            break;            
        case "txt":
            dataTable.export({
                type: "csv",
                filename: "usuarios"
            });
            console.log(selectValue);
            break;
        default:
            alertDanger.style.display = "block";
            alertDanger.textContent = "Selecione um tipo de arquivo especificado!";
    }
    
});
