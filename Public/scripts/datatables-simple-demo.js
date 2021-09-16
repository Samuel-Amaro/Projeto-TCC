//O evento DOMContentLoaded é acionado quando todo o HTML foi completamente carregado e analisado, sem aguardar pelo CSS, imagens, e subframes para encerrar o carregamento. Um evento muito diferente - load - deve ser usado apenas para detectar uma página completamente carregada.
//window
//REFERENCIA AO PLUGIN
//https://github.com/fiduswriter/Simple-DataTables/wiki

window.addEventListener('DOMContentLoaded', function() {

    let tabelaDom = document.querySelector('#datatablesSimple');
    let dataTable = new simpleDatatables.DataTable(tabelaDom);
});
