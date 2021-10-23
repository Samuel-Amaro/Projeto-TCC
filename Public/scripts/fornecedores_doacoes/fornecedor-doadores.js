//O load evento é disparado quando a página inteira é carregada, incluindo todos os recursos dependentes, como folhas de estilo e imagens. 
window.addEventListener('load', function(event) {
    let selectElement = document.querySelector('#tipoPessoa');
    selectElement.addEventListener("change", function(event) {
        mostraCampoTipoPessoa(event.target.value);
    });
});


function mostraCampoTipoPessoa(value) {
    let containerCpf = document.querySelector(".container-cpf");
    let containerCNPJ = document.querySelector(".container-cnpj");
    if(value === "FISICA") {
      containerCNPJ.style.display = "none"; 
      containerCpf.style.display = "block"; 
    }else{
      containerCNPJ.style.display = "block"; 
      containerCpf.style.display = "none";
    }
}