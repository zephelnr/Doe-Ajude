document.getElementById("email").textContent = email;
document.getElementById("idPublicacao").textContent = idPublicacao;
console.log(idPublicacao.value);
console.log(email.value);

// Selecionar os elementos do Modal
const modal = document.getElementById('sucessoEdicaoPublicacaoModal');
const fecharModalBtn = document.getElementById('fecharModal');

function carregarSessaoEdit() {
    let xhr = new XMLHttpRequest();
    xhr.open("GET","editarPublicacao_get.php?id_publicacao=" + idPublicacao.value + "&usuario_email=" + email.value);
    xhr.onreadystatechange = function() {
         const siglaEstado = document.getElementById("estadoSigla");
         const cidadeNome = document.getElementById("cidadeNome");

        if (xhr.status==200 && xhr.readyState==4) {
            console.log(xhr.responseText);

            const titulo = document.getElementById("titulo");
            const descricao = document.getElementById("descricao");
            //const cidade = document.getElementById("cidade");
            //const estado = document.getElementById("estado");
            const telefone = document.getElementById("telefone");
            const fotoAtual = document.getElementById("fotoAtual");
            const estadoSigla = document.getElementById("estadoSigla");
            const estadoId = document.getElementById("estadoId");
            const cidadeNome = document.getElementById("cidadeNome");
            const cidadeId = document.getElementById("cidadeId");
            const fotoLabel = document.getElementById("fotoLabel");
            const fotoHidden = document.getElementById("fotoAtualNome");
            const tituloHidden = document.getElementById("tituloHidden");
            const descricaoHidden = document.getElementById("descricaoHidden");
            const dataHidden = document.getElementById("dataHidden");

            var response = xhr.responseText;
            

            // Criando um elemento temporário para analisar o HTML
            var parser = new DOMParser();
            var doc = parser.parseFromString(response, "text/html");
            // Pegando o conteúdo de um elemento específico
            var tituloGet = doc.querySelector("h2").textContent;
            var descricaoGet = doc.querySelector("h3").textContent;
            var cidadeGet = doc.querySelector("h4").textContent;
            var estadoGet = doc.querySelector("h5").textContent;
            var telefoneGet = doc.querySelector("h6").textContent;
            var fotoGet = doc.querySelector("h7").textContent;
            var idEstadoGet = doc.querySelector("h8").textContent;
            var idCidadeGet = doc.querySelector("h9").textContent;
            var dataGet = doc.querySelector("h1").textContent;


            // Exibindo os dados
            titulo.value = tituloGet;
            descricao.value = descricaoGet;
            //cidade.value = cidadeGet;
            //estado.value = estadoGet;
            telefone.value = telefoneGet;
            //foto.value = fotoGet;
            estadoSigla.value = estadoGet;
            estadoId.value = idEstadoGet;
            cidadeNome.value = cidadeGet;
            cidadeId.value = idCidadeGet;
            fotoHidden.value = fotoGet;
            tituloHidden.value = tituloGet;
            descricaoHidden.value = descricaoGet;
            dataHidden.value = dataGet;
            if (fotoGet != "") {
               fotoAtual.innerHTML = `A publicação contém a foto: ` + fotoGet + `.</br>Para manter a foto atual deixe o campo "Alterar Foto" em branco!`;
               fotoLabel.innerHTML = `Alterar Foto`
            } else {
               fotoAtual.innerHTML = `A publicação não contém nenhuma foto!</br><p></p>`;
               fotoLabel.innerHTML = `Adicionar Foto`
            }
            
            //console.log("foto",fotoGet);
        
            if(siglaEstado.value != ""){
               //const siglaEstado = document.getElementById("estadoSigla");
               var estado = document.getElementById("estado");
                  let xhr = new XMLHttpRequest();
                  xhr.open("GET","estadoEditar.php?id_estado=" + idEstadoGet + "&sigla=" + estadoGet);
                  xhr.onreadystatechange = function() {
                     if (xhr.status==200 && xhr.readyState==4) {
                           //console.log(xhr.responseText);
                           //var publicacoes = this.response;
                           //console.log(publicacoes);
                           if(xhr.responseText != ""){
                              estado.innerHTML = xhr.responseText;
                           }
                     }
                  }
                  xhr.send();
               if(cidadeNome.value != ""){
                  let xhr = new XMLHttpRequest();
                  xhr.open("GET","cidadeEditar.php?id_municipio=" + cidadeId.value + "&nome=" + cidadeNome.value + "&id_estado=" + estadoId.value);
                  xhr.onreadystatechange = function() {
                     if (xhr.status==200 && xhr.readyState==4) {
                           //console.log(xhr.responseText);
                           if(xhr.responseText != ""){
                              cidade.innerHTML = xhr.responseText;
                           }
                     }
                  }
                  xhr.send();
               }               
            }
         }
    }
    xhr.send();
}

window.onload = carregarSessaoEdit;

const btnEditar = document.getElementById("btnEditar");
const respTituloCadEdit = document.querySelector("#respTituloCadEdit");
const respDescricaoCadEdit = document.querySelector("#respDescricaoCadEdit");
const respCidadeCadEdit = document.querySelector("#respCidadeCadEdit");
const respEstadoCadEdit = document.querySelector("#respEstadoCadEdit");
const respTelefoneCadEdit = document.querySelector("#respTelefoneCadEdit");
//const respFotoCadEdit = document.querySelector("#respFotoCadEdit");

btnEditar.addEventListener("click", (e) => {
   const frmEditar = document.getElementById("frmEditar");

   const tituloInput = frmEditar.querySelector("#titulo");
   const descricaoInput = frmEditar.querySelector("#descricao");
   const cidadeInput = frmEditar.querySelector("#cidade");
   const estadoInput = frmEditar.querySelector("#estado");
   const telefoneInput = frmEditar.querySelector("#telefone");
   const fotoInput = document.getElementById("foto");


   console.log("cidade", cidadeInput.value);
   console.log("estado",estadoInput.value);

   let formData = new FormData(frmEditar);

   //inclui no formdata o campo e o nome do campo
   formData.append("email", email.value);
   formData.append("cidade",cidadeInput.value);
   formData.append("estado", estadoInput.value);
   formData.append("campoTitulo", "titulo");
   formData.append("campoDescricao", "descricao");
   formData.append("campoCidade", "cidade");
   formData.append("campoEstado", "estado");
   formData.append("campoTelefone", "telefone");
   formData.append("campoFoto", "foto");
   formData.append("status", "Editado");

   //verifica o tamanho do telefone
   let tamTelefone = telefone.value.length
   if (tamTelefone < 10 || tamTelefone > 11){
      formData.append("telefone", "");
   }

   //console.log("fotoInput", fotoInput.files[0].name);

   const imagem = fotoInput.files[0];
   const emailCaminho = document.getElementById("email");
   const tituloCaminho = document.getElementById("tituloHidden");
   const descricaoCaminho = document.getElementById("descricaoHidden");
   const fotoAntigaCaminho = document.getElementById("fotoAtualNome") ;
   const dataCaminho = document.getElementById("dataHidden");

   //inpede o campo foto adicionar lixo na tabela
   //if(fotoInput != ""){
   //   formData.append("foto", fotoInput);
   //} else {
   //   formData.append("foto", "");
   //}
   
   if (imagem) {
      const reader = new FileReader();
      //converte a imagem para Base64
      reader.readAsDataURL(imagem); 

      reader.onload = function () {
         //armazena o nome da foto
         formData.append("campoFotoNome", "fotoNome");
         formData.append("fotoNome", fotoInput.files[0].name);

         //adiciona imagem convertida
         formData.append("foto", reader.result);
         
         //adiciona o caminho da imagem antiga
         formData.append("campoFotoAntiga", "fotoAntiga");
         formData.append("fotoAntiga", emailCaminho.value + "-" + tituloCaminho.value + "_" + descricaoCaminho.value + "_" + dataCaminho.value + "_" + fotoAntigaCaminho.value);

         //converte para JSON sem interferir nos outros campos
         let jsonData = JSON.stringify(Object.fromEntries(formData));
         console.log("passou",jsonData);

         let xhr = new XMLHttpRequest();
         xhr.onload = function () {
               if (xhr.status == 200 && xhr.readyState == 4) {
                  console.log(xhr.responseText);
                  const response = xhr.responseText;

                  if (response.includes("response")) {
                     modal.style.display = 'flex';

                     fecharModalBtn.addEventListener('click', () => {
                           modal.style.display = 'none';
                           window.location.href = "publicacoes.php";
                     });

                     window.addEventListener('click', (e) => {
                           if (e.target === modal) {
                              modal.style.display = 'none';
                              window.location.href = "publicacoes.php";
                           }
                     });
                  }

                  //verifica se o campo título esta vazio
                  if (tituloInput.value != "") {
                     respTituloCadEdit.innerHTML = ``;
                  } else {
                     respTituloCadEdit.innerHTML = `O campo Título está vazio!`;
                  }

                  //verifica se o campo descrição esta vazio
                  if (descricaoInput.value != "") {
                     respDescricaoCadEdit.innerHTML = ``;
                  } else {
                     respDescricaoCadEdit.innerHTML = `O campo Descrição está vazio!`;
                  }

                  //verifica se o campo cidade esta vazio
                  if (cidadeInput.value != "") {
                     respCidadeCadEdit.innerHTML = ``;
                  } else {
                     respCidadeCadEdit.innerHTML = `O campo Cidade está vazio!`;
                  }

                  //verifica se o campo estado esta vazio
                  if (estadoInput.value != "") {
                     respEstadoCadEdit.innerHTML = ``;
                  } else {
                     respEstadoCadEdit.innerHTML = `O campo Estado está vazio!`;
                  }

                  //verifica se o campo telefone esta vazio
                  if (telefoneInput.value != "") {
                     //verifica o número de dígitos do telefone
                     if (tamTelefone < 10 || tamTelefone > 11) {
                        respTelefoneCadEdit.innerHTML = `O campo telefone está com formato incorreto`;
                     } else {
                        respTelefoneCadEdit.innerHTML = ``;
                     }
                  } else {
                     respTelefoneCadEdit.innerHTML = `O campo Telefone está vazio!`;
                  }
               } else {
                  console.log("XMLHttpRequest Error");
               }
         };
         xhr.open("PUT", "editarPublicacao_put.php");
         xhr.send(jsonData);
      };
   } else {

      let jsonData = JSON.stringify(Object.fromEntries(formData));
      console.log(jsonData);

      let xhr = new XMLHttpRequest();
      xhr.onload = function() {
         if (xhr.status==200 && xhr.readyState==4) {
            console.log(xhr.responseText);

            // Verifica o conteúdo da resposta ou outras condições
            const response = xhr.responseText;

            // Verifica a resposta para decidir o redirecionamento
            if (response.includes("response")) {
               // Abrir o modal
               modal.style.display = 'flex';

               // Fechar o modal
               fecharModalBtn.addEventListener('click', () => {
                  modal.style.display = 'none';
                  window.location.href = "publicacoes.php";
               });
               
               // Fechar o modal ao clicar fora dele
               window.addEventListener('click', (e) => {
                  if (e.target === modal) {
                  modal.style.display = 'none';
                  window.location.href = "publicacoes.php";
                  }
               });
            }

            //verifica se o campo título esta vazio
            if (tituloInput.value != "") {
               respTituloCadEdit.innerHTML = ``;
            } else {
               respTituloCadEdit.innerHTML = `O campo Título está vazio!`;
            }

            //verifica se o campo descrição esta vazio
            if (descricaoInput.value != "") {
               respDescricaoCadEdit.innerHTML = ``;
            } else {
               respDescricaoCadEdit.innerHTML = `O campo Descrição está vazio!`;
            }

            //verifica se o campo cidade esta vazio
            if (cidadeInput.value != "") {
               respCidadeCadEdit.innerHTML = ``;
            } else {
               respCidadeCadEdit.innerHTML = `O campo Cidade está vazio!`;
            }

            //verifica se o campo estado esta vazio
            if (estadoInput.value != "") {
               respEstadoCadEdit.innerHTML = ``;
            } else {
               respEstadoCadEdit.innerHTML = `O campo Estado está vazio!`;
            }

            //verifica se o campo telefone esta vazio
            if (telefoneInput.value != "") {
               //verifica o número de dígitos do telefone
               if (tamTelefone < 10 || tamTelefone > 11) {
                  respTelefoneCadEdit.innerHTML = `O campo telefone está com formato incorreto`;
               } else {
                  respTelefoneCadEdit.innerHTML = ``;
               }
            } else {
               respTelefoneCadEdit.innerHTML = `O campo Telefone está vazio!`;
            }
         }
         else {
            console.log("XMLHttpRequest Error");
         }
      }
      xhr.open("PUT","editarPublicacao_put.php");
      xhr.send(jsonData);  

   }
   
   
})

const btnDeletar = document.getElementById("btnDeletar");
btnDeletar.addEventListener("click", (e) => {
   const frmDeletar = document.getElementById("frmDeletar");
   let formData = new FormData(frmDeletar);
   
   // as 2 linhas abaixo são no caso de uma alterção ou exclusão
   let jsonData = JSON.stringify(Object.fromEntries(formData));
   console.log(jsonData);

   let xhr = new XMLHttpRequest();
   xhr.onload = function() {
      if (xhr.status==200 && xhr.readyState==4) {
         console.log(xhr.responseText);

         // Verifica o conteúdo da resposta ou outras condições
         const response = xhr.responseText;

         // Verifica a resposta para decidir o redirecionamento
         if (response.includes("response")) {
            window.location.href = "publicacoes.php";
         }
      }
      else {
         console.log("XMLHttpRequest Error");
      }
   }
   xhr.open("DELETE","editarPublicacao_delete.php");
   xhr.send(jsonData);
})

const btnArquivar = document.getElementById("btnArquivar");
btnArquivar.addEventListener("click", (e) => {
   const frmArquivar = document.getElementById("frmArquivar");
   let formData = new FormData(frmArquivar);
   formData.append("status", "Arquivado");
   
   // as 2 linhas abaixo são no caso de uma alterção ou exclusão
   let jsonData = JSON.stringify(Object.fromEntries(formData));
   console.log(jsonData);

   let xhr = new XMLHttpRequest();
   xhr.onload = function() {
      if (xhr.status==200 && xhr.readyState==4) {
         console.log(xhr.responseText);

         // Verifica o conteúdo da resposta ou outras condições
         const response = xhr.responseText;

         // Verifica a resposta para decidir o redirecionamento
         if (response.includes("response")) {
            window.location.href = "arquivados.php";
         }
      }
      else {
         console.log("XMLHttpRequest Error");
      }
   }
   xhr.open("PUT","editarPublicacao_arquivar.php");
   xhr.send(jsonData);
})