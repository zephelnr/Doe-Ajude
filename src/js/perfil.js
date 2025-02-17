document.getElementById("email").textContent = email;
//console.log(email.value);
function carregarSessao() {
    let xhr = new XMLHttpRequest();
    xhr.open("GET","perfil_get.php?email=" + email.value);
    xhr.onreadystatechange = function() {
        if (xhr.status==200 && xhr.readyState==4) {
            console.log(xhr.responseText);

            const cpf = document.getElementById("cpf");
            const nomeCompleto = document.getElementById("nomeCompleto");
            const senha = document.getElementById("senha");
            const nomeCompletoModal = document.getElementById("nomeCompletoModal");
            const senhaModal = document.getElementById("senhaModal");

            var response = xhr.responseText;
            

            // Criando um elemento temporário para analisar o HTML
            var parser = new DOMParser();
            var doc = parser.parseFromString(response, "text/html");
            // Pegando o conteúdo de um elemento específico
            var cpfGet = doc.querySelector("h2").textContent;
            var nomeCompletoGet = doc.querySelector("h3").textContent;
            var senhaGet = doc.querySelector("h4").textContent;

            //funcao mascara cpf
            var i = 0;
            var cpfMascara = cpfGet;
            while(i < cpfGet.length){
               cpfMascara = cpfMascara.replace(/\D/g,'');
               cpfMascara = cpfMascara.replace(/(\d{3})(\d)/, '$1.$2');
               cpfMascara = cpfMascara.replace(/(\d{3})(\d)/, '$1.$2');
               cpfMascara = cpfMascara.replace(/(\d{3})(\d{2})$/, '$1-$2');
               i = i + 1;
            }


            // Exibindo os dados
            cpf.value = cpfMascara;
            nomeCompleto.value = nomeCompletoGet;
            senha.value = senhaGet;
            nomeCompletoModal.value = nomeCompletoGet;
            senhaModal.value = senhaGet;
        }
        else {
            console.log("XMLHttpRequest Error");
        }
    }
    xhr.send();

}

window.onload = carregarSessao;